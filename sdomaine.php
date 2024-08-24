<?php
require_once('config.php');
// Lien vers la NavBar
require_once('blade/DashHeader.php');
// Lien vers l'ASIDE
require_once('blade/AsideUser.php');
include 'config.php';
// Récupérer les domaines pour le select
$domainesSQL = "SELECT * FROM domaine";
$domainesStmt = $conn->prepare($domainesSQL);
$domainesStmt->execute();
$domaines = $domainesStmt->fetchAll(PDO::FETCH_ASSOC);
// Récupérer les sous-domaines pour l'affichage dans le tableau
$sousdomainesSQL = "SELECT sousdomaine.id, domaine.intituleDomaine, sousdomaine.description, sousdomaine.image 
                    FROM sousdomaine 
                    JOIN domaine ON sousdomaine.idDomaine = domaine.id";
$sousdomainesStmt = $conn->prepare($sousdomainesSQL);
$sousdomainesStmt->execute();
$sousdomaines = $sousdomainesStmt->fetchAll(PDO::FETCH_ASSOC);
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
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Gerer les domaines</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Compte Utilisateur</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- naissance Card -->
                    <div class="col-xxl-4 col-md-6">
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
                    </div><!-- End naissance Card -->

                    <!-- personne Card -->
                    <div class="col-xxl-4 col-md-6">
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

                    <!-- décès Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <h5 class="card-title">Nouveau <span>| Créer</span></h5>

                                <div class="d-flex align-items-center">

                                    <div class="ps-3">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                            Nouvel Enregistrement Domaine
                                        </button>
                                        <div class="modal fade" id="basicModal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Formulaire d'enregistrement</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="ajouter_sousdomaine.php" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                                                            <div class="col-12">
                                                                <label for="idDomaine" class="form-label">Domaine</label>
                                                                <select name="idDomaine" class="form-select" id="idDomaine" required>
                                                                    <option value="" disabled selected>Choisir un domaine</option>
                                                                    <?php foreach ($domaines as $domaine): ?>
                                                                        <option value="<?php echo htmlspecialchars($domaine['id']); ?>">
                                                                            <?php echo htmlspecialchars($domaine['intituleDomaine']); ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <div class="invalid-feedback">Veuillez sélectionner un domaine !</div>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="description" class="form-label">Description</label>
                                                                <textarea name="description" class="form-control" id="description" required></textarea>
                                                                <div class="invalid-feedback">Veuillez entrer une description !</div>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="image" class="form-label">Image</label>
                                                                <input type="file" name="image" class="form-control" id="image" required>
                                                                <div class="invalid-feedback">Veuillez choisir une image !</div>
                                                            </div>
                                                            <div class="col-12">
                                                                <button class="btn btn-primary w-100" type="submit">Enregistrer</button>
                                                            </div>
                                                        </form>

                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- End Basic Modal-->
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End dece Card -->
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
                                    <th>ID</th>
                                    <th>Domaine</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sousdomaines as $sousdomaine): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($sousdomaine['id']); ?></td>
                                        <td><?php echo htmlspecialchars($sousdomaine['intituleDomaine']); ?></td>
                                        <td><?php echo htmlspecialchars($sousdomaine['description']); ?></td>
                                        <td><img src="img/<?php echo htmlspecialchars($sousdomaine['image']); ?>" alt="" width="50"></td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#voirModal"
                                                data-image="img/<?php echo htmlspecialchars($sousdomaine['image']); ?>">Voir</button>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modifierModal"
                                                data-id="<?php echo htmlspecialchars($sousdomaine['id']); ?>"
                                                data-domaine="<?php echo htmlspecialchars($sousdomaine['intituleDomaine']); ?>"
                                                data-description="<?php echo htmlspecialchars($sousdomaine['description']); ?>"
                                                data-image="img/<?php echo htmlspecialchars($sousdomaine['image']); ?>">Modifier</button>
                                            <a href="supprimer_sousdomaine.php?id=<?php echo htmlspecialchars($sousdomaine['id']); ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce sous-domaine ?');">Supprimer</a>
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
                <!-- Modal Modifier Sous-domaine -->
                <div class="modal fade" id="modifierModal" tabindex="-1" aria-labelledby="modifierModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modifierModalLabel">Modifier Sous-domaine</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="modifier_sousdomaine.php" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                                    <input type="hidden" name="id" id="modifierId">
                                    <div class="col-12">
                                        <label for="modifierDomaine" class="form-label">Domaine</label>
                                        <select name="idDomaine" class="form-select" id="modifierDomaine" required>
                                            <option value="" disabled>Choisir un domaine</option>
                                            <?php foreach ($domaines as $domaine): ?>
                                                <option value="<?php echo htmlspecialchars($domaine['id']); ?>">
                                                    <?php echo htmlspecialchars($domaine['intituleDomaine']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Veuillez sélectionner un domaine !</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="modifierDescription" class="form-label">Description</label>
                                        <textarea name="description" class="form-control" id="modifierDescription" required></textarea>
                                        <div class="invalid-feedback">Veuillez entrer une description !</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="modifierImage" class="form-label">Image</label>
                                        <input type="file" name="image" class="form-control" id="modifierImage">
                                        <div class="invalid-feedback">Veuillez choisir une image !</div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Modifier</button>
                                    </div>
                                </form>
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

                    var modifierModal = document.getElementById('modifierModal');
                    modifierModal.addEventListener('show.bs.modal', function(event) {
                        var button = event.relatedTarget;
                        var id = button.getAttribute('data-id');
                        var domaine = button.getAttribute('data-domaine');
                        var description = button.getAttribute('data-description');
                        var image = button.getAttribute('data-image');

                        var modalId = modifierModal.querySelector('#modifierId');
                        var modalDomaine = modifierModal.querySelector('#modifierDomaine');
                        var modalDescription = modifierModal.querySelector('#modifierDescription');
                        var modalImage = modifierModal.querySelector('#modifierImage');

                        modalId.value = id;
                        modalDomaine.value = domaine;
                        modalDescription.value = description;
                        modalImage.value = image;
                    });
                </script>

            </div>
        </div>
    </section>
</main>
<?php
// Lien vers le footer
require_once('blade/DashFooter.php');
?>