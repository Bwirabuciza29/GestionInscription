<?php
// Lien vers la NavBar
require_once('blade/DashHeader.php');
// Lien vers l'ASIDE
require_once('blade/AsideUser.php');

require_once('config.php');
try {
    // Requête pour compter le nombre d'inscriptions avec le statut "en attente"
    $query_en_attente = "SELECT COUNT(*) AS total_en_attente FROM inscription WHERE status = 'en attente'";
    $stmt_en_attente = $conn->prepare($query_en_attente);
    $stmt_en_attente->execute();
    $result_en_attente = $stmt_en_attente->fetch(PDO::FETCH_ASSOC);
    $totalEnAttente = $result_en_attente['total_en_attente'];

    // Requête pour compter le nombre d'utilisateurs avec la catégorie "Apprenant"
    $query = "SELECT COUNT(*) AS total_apprenants FROM users WHERE category = 'Apprenant'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupérer le nombre d'apprenants
    $totalApprenants = $result['total_apprenants'];
    // Requête pour compter le nombre d'inscriptions avec le statut "payé"
    $query_paye = "SELECT COUNT(*) AS total_paye FROM inscription WHERE status = 'payé'";
    $stmt_paye = $conn->prepare($query_paye);
    $stmt_paye->execute();
    $result_paye = $stmt_paye->fetch(PDO::FETCH_ASSOC);
    $totalPaye = $result_paye['total_paye'];
    // Récupérer les données de la vue
    $query = "SELECT 
    a.id AS apprenant_id,
    a.nom AS apprenant_nom,
    a.postnom AS apprenant_postnom,
    a.prenom AS apprenant_prenom,
    a.photo AS apprenant_photo,
    d.id AS domaine_id,
    d.intituleDomaine AS domaine_intitule,
    d.typeDomaine AS domaine_type,
    sd.id AS sousdomaine_id,
    sd.description AS sousdomaine_description,
    sd.image AS sousdomaine_image,
    p.id AS payement_id,
    p.montant AS payement_montant,
    p.datePayement AS payement_date,
    p.numTrans AS payement_numTrans,
    p.photo AS payement_photo,
    i.id AS inscription_id,
    i.matricule AS inscription_matricule,
    i.dateInscription AS inscription_dateInscription,
    i.status AS inscription_status
FROM 
    inscription i
JOIN 
    apprenant a ON i.idApp = a.id
JOIN 
    sousdomaine sd ON i.idSousDomaine = sd.id
JOIN 
    domaine d ON sd.idDomaine = d.id
JOIN 
    payement p ON i.idPayement = p.id
WHERE
    i.status = 'en attente';
";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // LE CLIQUE DU BOUTTON
    // Generer le nouveau matricule
    function genererMatricule($conn)
    {
        $stmt = $conn->prepare("SELECT matricule FROM inscription ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        $dernierMatricule = $stmt->fetchColumn();

        if ($dernierMatricule) {
            $num = (int)substr($dernierMatricule, 6);
            $num++;
            return 'APINPP' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            return 'APINPP001';
        }
    }
    // Récupérer les inscriptions en attente
    $query = "SELECT i.id, i.matricule, i.status, a.nom, a.postnom, a.id AS idApprenant, u.category, d.intituleDomaine, sd.description, p.montant, p.datePayement 
          FROM inscription i 
          JOIN apprenant a ON i.idApp = a.id 
          JOIN users u ON u.idApprenant = a.id 
          JOIN sousdomaine sd ON i.idSousDomaine = sd.id 
          JOIN domaine d ON sd.idDomaine = d.id 
          JOIN payement p ON i.idPayement = p.id 
          WHERE i.status = 'en attente'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $inscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $idInscription = $_POST['idInscription'];

        // Changer le statut à "payé"
        $stmt = $conn->prepare("UPDATE inscription SET status = 'payé', matricule = :matricule WHERE id = :id");
        $stmt->bindParam(':id', $idInscription);

        // Générer un nouveau matricule
        $nouveauMatricule = genererMatricule($conn);
        $stmt->bindParam(':matricule', $nouveauMatricule);

        $stmt->execute();

        // Envoyer une notification à l'apprenant
        $stmt = $conn->prepare("INSERT INTO notifications (idApprenant, message) VALUES (:idApprenant, :message)");
        $stmt->bindParam(':idApprenant', $_POST['idApprenant']);
        $message = "Votre paiement a été validé. Votre nouveau matricule est $nouveauMatricule.";
        $stmt->bindParam(':message', $message);
        $stmt->execute();

        // Rediriger pour éviter le double POST
        header("Location: valide.php");
        exit();
    }
} catch (PDOException $e) {
    // Afficher les erreurs de base de données
    echo "Erreur : " . $e->getMessage();
} catch (Exception $e) {
    // Afficher toute autre erreur
    echo "Erreur : " . $e->getMessage();
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Tableau de bord</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
                <li class="breadcrumb-item active">Tableau de bord</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="welcome-message" id="welcomeMessage">
            <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['nom'] . ' ' . $_SESSION['postnom']); ?>!</h1>
            <p>Vous êtes connecté en tant qu'Administrateur.</p>
        </div>
    </section>
    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Utilisateurs <span>| All</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo htmlspecialchars($totalApprenants); ?></h6>
                                        <span
                                            class="text-muted small pt-2 ps-1">comptes</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Inscriptions Validés <span>| Payement</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo htmlspecialchars($totalPaye); ?></h6>
                                        <span class="text-muted small pt-2 ps-1">validées</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <h5 class="card-title">Inscriptions en Attente <span>|</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo htmlspecialchars($totalEnAttente); ?></h6>
                                        <span class="text-danger small pt-1 fw-bold">En attent</span> <span
                                            class="text-muted small pt-2 ps-1">d'être validées</span>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->

                </div>
            </div><!-- End Left side columns -->


        </div>
    </section>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Liste</h5>
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Postnom</th>
                                    <th>Category</th>
                                    <th>Domaine</th>
                                    <th>Sous-domaine</th>
                                    <th>Montant</th>
                                    <th>Date de paiement</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($inscriptions as $inscription): ?>
                                    <tr>
                                        <td><?= $inscription['nom'] ?></td>
                                        <td><?= $inscription['postnom'] ?></td>
                                        <td><?= $inscription['category'] ?></td>
                                        <td><?= $inscription['intituleDomaine'] ?></td>
                                        <td><?= $inscription['description'] ?></td>
                                        <td><?= $inscription['montant'] ?></td>
                                        <td><?= $inscription['datePayement'] ?></td>
                                        <td><?= $inscription['status'] ?></td>
                                        <td>
                                            <form method="post" action="enreg.php">
                                                <input type="hidden" name="idInscription" value="<?= $inscription['id'] ?>">
                                                <input type="hidden" name="idApprenant" value="<?= $inscription['idApprenant'] ?>">
                                                <button class="btn btn-outline-primary" type="submit">Valider</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var welcomeMessage = document.getElementById('welcomeMessage');
        welcomeMessage.style.display = 'block';
        setTimeout(function() {
            welcomeMessage.style.opacity = 0;
            setTimeout(function() {
                welcomeMessage.style.display = 'none';
            }, 1000);
        }, 10000);
    });
</script>
<?php
// Lien vers le footer
require_once('blade/DashFooter.php');
?>