<?php
require_once('config.php');
// Lien vers la NavBar
require_once('blade/DashHeader.php');
// Lien vers l'ASIDE
require_once('blade/AsideUser.php');
// Compter le nombre d'utilisateurs
// Inclure le fichier de configuration
include 'config.php';
// Récupérer les domaines depuis la base de données
$sql = "SELECT * FROM domaine";
$stmt = $conn->prepare($sql);
$stmt->execute();
$domaines = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                                                        <h5 class="modal-title">Créer un Compte Partenaire</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="row g-3 needs-validation" action="enregistrer_domaine.php" method="POST" novalidate>
                                                            <div class="col-12">
                                                                <label for="intituleDomaine" class="form-label">Intitulé du Domaine</label>
                                                                <input type="text" name="intituleDomaine" class="form-control" id="intituleDomaine" required>
                                                                <div class="invalid-feedback">Veuillez entrer l'intitulé du domaine !</div>
                                                            </div>

                                                            <div class="col-12">
                                                                <label for="typeDomaine" class="form-label">Type de Domaine</label>
                                                                <input type="text" name="typeDomaine" class="form-control" id="typeDomaine" required>
                                                                <div class="invalid-feedback">Veuillez entrer le type de domaine !</div>
                                                            </div>

                                                            <div class="col-12">
                                                                <button class="btn btn-primary w-100" type="submit">Créer un Domaine</button>
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
                                    <th>#</th>
                                    <th>Intitulé</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($domaines as $domaine): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($domaine['id']); ?></td>
                                        <td><?php echo htmlspecialchars($domaine['intituleDomaine']); ?></td>
                                        <td><?php echo htmlspecialchars($domaine['typeDomaine']); ?></td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"
                                                data-id="<?php echo htmlspecialchars($domaine['id']); ?>"
                                                data-intitule="<?php echo htmlspecialchars($domaine['intituleDomaine']); ?>"
                                                data-type="<?php echo htmlspecialchars($domaine['typeDomaine']); ?>">
                                                Modifier
                                            </button>
                                            <a href="supprimer_domaine.php?id=<?php echo htmlspecialchars($domaine['id']); ?>" class="btn btn-danger btn-sm">Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Modale pour modification -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Modifier le Domaine</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="editForm" action="modifier_domaine.php" method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="id" id="domaineId">
                                    <div class="mb-3">
                                        <label for="intituleDomaine" class="form-label">Intitulé du Domaine</label>
                                        <input type="text" name="intituleDomaine" class="form-control" id="intituleDomaine" required>
                                        <div class="invalid-feedback">Veuillez entrer l'intitulé du domaine !</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="typeDomaine" class="form-label">Type de Domaine</label>
                                        <input type="text" name="typeDomaine" class="form-control" id="typeDomaine" required>
                                        <div class="invalid-feedback">Veuillez entrer le type de domaine !</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-primary">Sauvegarder les modifications</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var editModal = document.getElementById('editModal');
                        editModal.addEventListener('show.bs.modal', function(event) {
                            var button = event.relatedTarget;
                            var id = button.getAttribute('data-id');
                            var intitule = button.getAttribute('data-intitule');
                            var type = button.getAttribute('data-type');

                            var modal = editModal.querySelector('#editForm');
                            modal.querySelector('#domaineId').value = id;
                            modal.querySelector('#intituleDomaine').value = intitule;
                            modal.querySelector('#typeDomaine').value = type;
                        });
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