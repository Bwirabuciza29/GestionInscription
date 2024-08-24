<?php
// Lien vers la NavBar
require_once('blade/DashPart.php');
// Lien vers l'ASIDE
require_once('blade/AsidePart.php');
require_once('config.php');

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Compte Utilisateur</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
                <li class="breadcrumb-item active">Gestion Compte Utilisateur</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Paramètres du compte</h5>
                        <!-- Button to trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                            Formulaire de Modification Compte
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="basicModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modifier Mon Compte</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form for credit registration -->
                                        <form action="modifier_apprenant.php" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                                            <div class="col-md-6">
                                                <label for="nom" class="form-label">Nom:</label>
                                                <input type="text" class="form-control" name="nom" id="nom" value="<?php echo htmlspecialchars($_SESSION['nom']); ?>" required>
                                                <div class="invalid-feedback">
                                                    Veuillez entrer votre nom.
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="postnom" class="form-label">Postnom:</label>
                                                <input type="text" class="form-control" name="postnom" id="postnom" value="<?php echo htmlspecialchars($_SESSION['postnom']); ?>" required>
                                                <div class="invalid-feedback">
                                                    Veuillez entrer votre postnom.
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="prenom" class="form-label">Prénom:</label>
                                                <input type="text" class="form-control" name="prenom" id="prenom" value="<?php echo htmlspecialchars($_SESSION['prenom']); ?>" required>
                                                <div class="invalid-feedback">
                                                    Veuillez entrer votre prénom.
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="lieuNaissance" class="form-label">Lieu de naissance:</label>
                                                <input type="text" class="form-control" name="lieuNaissance" id="lieuNaissance" value="<?php echo htmlspecialchars($_SESSION['lieuNaissance']); ?>" required>
                                                <div class="invalid-feedback">
                                                    Veuillez entrer votre lieu de naissance.
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="dateNaissance" class="form-label">Date de naissance:</label>
                                                <input type="date" class="form-control" name="dateNaissance" id="dateNaissance" value="<?php echo htmlspecialchars($_SESSION['dateNaissance']); ?>" required>
                                                <div class="invalid-feedback">
                                                    Veuillez entrer votre date de naissance.
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="email" class="form-label">Email:</label>
                                                <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required disabled>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="tel" class="form-label">Téléphone:</label>
                                                <input type="text" class="form-control" name="tel" id="tel" value="<?php echo htmlspecialchars($_SESSION['tel']); ?>" required>
                                                <div class="invalid-feedback">
                                                    Veuillez entrer votre numéro de téléphone.
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="etatCivil" class="form-label">État civil:</label>
                                                <input type="text" class="form-control" name="etatCivil" id="etatCivil" value="<?php echo htmlspecialchars($_SESSION['etatCivil']); ?>" required>
                                                <div class="invalid-feedback">
                                                    Veuillez entrer votre état civil.
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label for="photo" class="form-label">Changer la photo de profil:</label>
                                                <input type="file" class="form-control" name="photo" id="photo">
                                            </div>

                                            <div class="col-md-12">
                                                <label for="psw" class="form-label">Nouveau mot de passe:</label>
                                                <input type="password" class="form-control" name="psw" id="psw">
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
                                            </div>
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
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="img/<?php echo htmlspecialchars($_SESSION['photo']); ?>" alt="Photo de profil" class="rounded-circle">
                        <h2> <?php echo htmlspecialchars($_SESSION['nom'] . ' ' . $_SESSION['postnom']); ?></h2>
                        <h3>Utilisateur</h3>

                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">A propos de Mon Compte</button>
                            </li>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">A propos</h5>
                                <p class="small fst-italic">Certaines de ces informations peuvent être modifiées dans la section ci-haute.</p>

                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Noms</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($_SESSION['nom'] . ' ' . $_SESSION['postnom']); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Etat-Civil</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($_SESSION['etatCivil']); ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Lieu</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($_SESSION['lieuNaissance']); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Date</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($_SESSION['dateNaissance']); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($_SESSION['email']); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Telephone</div>
                                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($_SESSION['tel']); ?></div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Mot de passe</div>
                                    <div class="col-lg-9 col-md-8">********</div>
                                </div>

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<?php
// Lien vers le footer
require_once('blade/DashFooter.php');
?>