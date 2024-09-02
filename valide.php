<?php
// Lien vers la NavBar
require_once('blade/DashHeader.php');
// Lien vers l'ASIDE
require_once('blade/AsideUser.php');
require_once('config.php');

// Requête pour compter le nombre d'inscriptions avec le statut "en attente"
$query = "SELECT COUNT(*) AS total_en_attente FROM inscription WHERE status = 'en attente'";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
// Requête pour compter le nombre d'inscriptions avec le statut "payé"
$query_paye = "SELECT COUNT(*) AS total_paye FROM inscription WHERE status = 'payé'";
$stmt_paye = $conn->prepare($query_paye);
$stmt_paye->execute();
$result_paye = $stmt_paye->fetch(PDO::FETCH_ASSOC);
$totalPaye = $result_paye['total_paye'];

// Récupérer le nombre d'inscriptions en attente
$totalEnAttente = $result['total_en_attente'];
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
    i.status = 'payé';
";
$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Les Inscriptions Validée</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
                <li class="breadcrumb-item active">Tableau de bord</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Inscriptions en attente <span>| Today</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo htmlspecialchars($totalEnAttente); ?></h6>
                                        <span
                                            class="text-muted small pt-2 ps-1">Enregistrés</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Inscriptions Validés <span>|Avec Payement</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo htmlspecialchars($totalPaye); ?></h6>
                                        <span
                                            class="text-muted small pt-2 ps-1">avec payement</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div><!-- End Left side columns -->


        </div>
    </section>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body table-responsive">
                        <h5 class="card-title">Inscriptions en Validées</h5>
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Matricule</th>
                                    <th>Nom</th>
                                    <th>Postnom</th>
                                    <th>Prénom</th>
                                    <th>Domaine</th>
                                    <th>Type</th>
                                    <th>Sous-Domaine</th>
                                    <th>Image</th>
                                    <th>Montant en $</th>
                                    <th>Numéro de Transaction</th>
                                    <th>Photo du Paiement</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $row): ?>
                                    <tr>
                                        <td><img src="img/<?php echo htmlspecialchars($row['apprenant_photo']); ?>" alt="Photo de l'Apprenant" class="avatar" data-bs-toggle="modal" data-bs-target="#apprenantPhotoModal<?php echo $row['apprenant_id']; ?>"></td>
                                        <td><?php echo htmlspecialchars($row['inscription_matricule']); ?></td>
                                        <td><?php echo htmlspecialchars($row['apprenant_nom']); ?></td>
                                        <td><?php echo htmlspecialchars($row['apprenant_postnom']); ?></td>
                                        <td><?php echo htmlspecialchars($row['apprenant_prenom']); ?></td>
                                        <td><?php echo htmlspecialchars($row['domaine_intitule']); ?></td>
                                        <td><?php echo htmlspecialchars($row['domaine_type']); ?></td>
                                        <td><?php echo htmlspecialchars($row['sousdomaine_description']); ?></td>
                                        <td><img src="img/<?php echo htmlspecialchars($row['sousdomaine_image']); ?>" alt="Image du Sous-Domaine" class="avatar" data-bs-toggle="modal" data-bs-target="#sousdomaineImageModal<?php echo $row['sousdomaine_id']; ?>"></td>
                                        <td><?php echo htmlspecialchars($row['payement_montant']); ?></td>
                                        <td><?php echo htmlspecialchars($row['payement_numTrans']); ?></td>
                                        <td><img src="<?php echo htmlspecialchars($row['payement_photo']); ?>" alt="Photo du Paiement" class="avatar" data-bs-toggle="modal" data-bs-target="#payementPhotoModal<?php echo $row['payement_id']; ?>"></td>
                                        <td><?php echo htmlspecialchars($row['inscription_dateInscription']); ?></td>
                                        <td>
                                            <a href="recu.php?id=<?php echo $row['inscription_id']; ?>" class="btn btn-outline-success" target="_blank">Reçu</a>
                                        </td>
                                        <td>
                                            <a href="fiche.php?id=<?php echo $row['inscription_id']; ?>" class="btn btn-outline-primary" target="_blank">Fiche</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Modale pour la photo de l'apprenant -->
                <div class="modal fade" id="apprenantPhotoModal<?php echo $row['apprenant_id']; ?>" tabindex="-1" aria-labelledby="apprenantPhotoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="apprenantPhotoModalLabel">Photo de l'Apprenant</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="img/<?php echo htmlspecialchars($row['apprenant_photo']); ?>" alt="Photo de l'Apprenant" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modale pour l'image du sous-domaine -->
                <div class="modal fade" id="sousdomaineImageModal<?php echo $row['sousdomaine_id']; ?>" tabindex="-1" aria-labelledby="sousdomaineImageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="sousdomaineImageModalLabel">Image du Sous-Domaine</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="img/<?php echo htmlspecialchars($row['sousdomaine_image']); ?>" alt="Image du Sous-Domaine" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modale pour la photo du paiement -->
                <div class="modal fade" id="payementPhotoModal<?php echo $row['payement_id']; ?>" tabindex="-1" aria-labelledby="payementPhotoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="payementPhotoModalLabel">Photo du Paiement</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="<?php echo htmlspecialchars($row['payement_photo']); ?>" alt="Photo du Paiement" class="img-fluid">
                            </div>
                        </div>
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