<?php
// Lien vers la NavBar
require_once('blade/DashPart.php');
// Lien vers l'ASIDE
require_once('blade/AsidePart.php');
require_once('config.php');
// Compter le nombre total de domaines
$countSQL = "SELECT COUNT(*) as total FROM domaine";
$countStmt = $conn->prepare($countSQL);
$countStmt->execute();
$totalDomaines = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
// Compter le nombre total de sous-domaines
$countSQL = "SELECT COUNT(*) as total FROM sousdomaine";
$countStmt = $conn->prepare($countSQL);
$countStmt->execute();
$totalSousDomaines = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
// Récupérer les données de la vue 'domaines'
$sql = "SELECT * FROM domaines";
$stmt = $conn->prepare($sql);
$stmt->execute();
$domaines = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <p>Vous êtes connecté en tant que Utilisateur.</p>
        </div>
    </section>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Inscription</h5>
                        <!-- Button to trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                            Formulaire d'inscription en ligne
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="basicModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Demander une Inscription</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form for credit registration -->
                                        <form class="row g-3 needs-validation" action="enregistrer_inscription.php" method="POST" enctype="multipart/form-data" novalidate>
                                            <div class="col-12">
                                                <label for="nomUtilisateur" class="form-label">Nom de l'utilisateur</label>
                                                <input type="text" name="nomUtilisateur" class="form-control" id="nomUtilisateur" value="<?php echo htmlspecialchars($_SESSION['nom'] . ' ' . $_SESSION['postnom']); ?>" readonly>
                                            </div>
                                            <input type="hidden" name="idApp" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">

                                            <!-- Autres champs du formulaire -->
                                            <div class="col-12">
                                                <label for="idSousDomaine" class="form-label">Sous-Domaine</label>
                                                <select name="idSousDomaine" id="idSousDomaine" class="form-control" required>
                                                    <?php
                                                    $stmt = $conn->prepare("SELECT id, description FROM sousdomaine");
                                                    $stmt->execute();
                                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                        echo '<option value="' . $row['id'] . '">' . $row['description'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <div class="invalid-feedback">Veuillez sélectionner un sous-domaine.</div>
                                            </div>

                                            <div class="col-12">
                                                <label for="intituleDomaine" class="form-label">Domaine</label>
                                                <input type="text" name="intituleDomaine" id="intituleDomaine" class="form-control" readonly>
                                            </div>
                                            <input type="hidden" name="status" value="en attente">
                                            <div class="col-12">
                                                <label for="montant" class="form-label">Montant</label>
                                                <input type="text" name="montant" class="form-control" id="montant" required>
                                            </div>

                                            <div class="col-12">
                                                <label for="numTrans" class="form-label">Numéro de Transaction</label>
                                                <input type="text" name="numTrans" id="numTrans" class="form-control" required>
                                                <div class="invalid-feedback">Veuillez saisir le numéro de transaction.</div>
                                            </div>

                                            <div class="col-12">
                                                <label for="photo" class="form-label">Photo</label>
                                                <input type="file" name="photo" id="photo" class="form-control" required>
                                                <div class="invalid-feedback">Veuillez télécharger une photo.</div>
                                            </div>
                                            <div class="col-12">
                                                <label for="datePayement" class="form-label">Date de Payement</label>
                                                <input type="date" name="datePayement" class="form-control" id="datePayement" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="dateInscription" class="form-label">Date d'Inscription et de Payement</label>
                                                <input type="datetime-local" name="dateInscription" id="dateInscription" class="form-control" required>
                                                <div class="invalid-feedback">Veuillez saisir la date d'inscription et de payement.</div>
                                            </div>

                                            <button class="btn btn-primary w-100" type="submit">Enregistrer</button>
                                        </form>
                                        <!-- End form -->
                                    </div>
                                </div>
                            </div>
                        </div><!-- End modal -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- naissance Card -->
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Domaines <span>| SYSTEME</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo $totalDomaines; ?></h6>
                                        <span class="text-success small pt-1 fw-bold">Enregistrés</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- personne Card -->
                    <div class="col-xxl-6 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Sous-domaines<span>|SYSTEME</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo $totalSousDomaines; ?></h6>
                                        <span class="text-success small pt-1 fw-bold">Enregistré</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End personnes Card -->
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
                                    <th>Intitulé</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($domaines as $domaine): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($domaine['intituleDomaine']); ?></td>
                                        <td><?php echo htmlspecialchars($domaine['typeDomaine']); ?></td>
                                        <td><?php echo htmlspecialchars($domaine['description']); ?></td>
                                        <td>
                                            <?php if ($domaine['image']): ?>
                                                <img src="img/<?php echo htmlspecialchars($domaine['image']); ?>" alt="Image" width="50">
                                            <?php else: ?>
                                                Pas d'image
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($domaine['image']): ?>
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#voirModal"
                                                    data-image="img/<?php echo htmlspecialchars($domaine['image']); ?>">Voir</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Modal Voir Image -->
                <div class="modal fade" id="voirModal" tabindex="-1" aria-labelledby="voirModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="voirModalLabel">Voir l'image</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img id="voirImage" src="" alt="Image" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    var voirModal = document.getElementById('voirModal');
                    voirModal.addEventListener('show.bs.modal', function(event) {
                        var button = event.relatedTarget;
                        var image = button.getAttribute('data-image');

                        var modalImage = voirModal.querySelector('#voirImage');
                        modalImage.src = image;
                    });
                </script>
            </div>
        </div>
    </section>
</main>
<script>
    document.getElementById('idSousDomaine').addEventListener('change', function() {
        var idSousDomaine = this.value;

        // Envoyer une requête AJAX pour récupérer l'intitulé du domaine
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_domaine.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status === 200) {
                document.getElementById('intituleDomaine').value = this.responseText;
            }
        };
        xhr.send('idSousDomaine=' + idSousDomaine);
    });
</script>
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