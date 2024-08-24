<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('config.php');

?>

<?php require_once('blade/LoggerUp.php'); ?>
<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Création Compte</h5>
                                </div>
                                <form class="row g-3 needs-validation" action="enregistrer_apprenant.php" method="POST" enctype="multipart/form-data" novalidate>
                                    <div class="col-12">
                                        <label for="nom" class="form-label">Nom</label>
                                        <input type="text" name="nom" class="form-control" id="nom" required>
                                        <div class="invalid-feedback">Veuillez entrer votre nom!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="postnom" class="form-label">Postnom</label>
                                        <input type="text" name="postnom" class="form-control" id="postnom" required>
                                        <div class="invalid-feedback">Veuillez entrer votre postnom!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="prenom" class="form-label">Prénom</label>
                                        <input type="text" name="prenom" class="form-control" id="prenom" required>
                                        <div class="invalid-feedback">Veuillez entrer votre prénom!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="lieuNaissance" class="form-label">Lieu de Naissance</label>
                                        <input type="text" name="lieuNaissance" class="form-control" id="lieuNaissance" required>
                                        <div class="invalid-feedback">Veuillez entrer votre lieu de naissance!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="dateNaissance" class="form-label">Date de Naissance</label>
                                        <input type="date" name="dateNaissance" class="form-control" id="dateNaissance" required>
                                        <div class="invalid-feedback">Veuillez entrer votre date de naissance!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" required>
                                        <div class="invalid-feedback">Veuillez entrer votre email!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="tel" class="form-label">Téléphone</label>
                                        <input type="text" name="tel" class="form-control" id="tel" required>
                                        <div class="invalid-feedback">Veuillez entrer votre numéro de téléphone!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="etatCivil" class="form-label">État Civil</label>
                                        <select name="etatCivil" class="form-select" id="etatCivil" required>
                                            <option selected disabled value="">Choisir...</option>
                                            <option value="Célibataire">Célibataire</option>
                                            <option value="Marié(e)">Marié(e)</option>
                                        </select>
                                        <div class="invalid-feedback">Veuillez sélectionner votre état civil!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="photo" class="form-label">Photo</label>
                                        <input type="file" name="photo" class="form-control" id="photo" required>
                                        <div class="invalid-feedback">Veuillez télécharger votre photo!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="category" class="form-label">Catégorie</label>
                                        <input type="text" name="category" class="form-control" id="category" required>
                                        <div class="invalid-feedback">Veuillez entrer la catégorie!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="psw" class="form-label">Mot de passe</label>
                                        <input type="password" name="psw" class="form-control" id="psw" required>
                                        <div class="invalid-feedback">Veuillez entrer votre mot de passe!</div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Créer un Compte</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">avez-vous déjà un compte? <a href="login.php">Se Connecter</a></p>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
<?php require_once('blade/LoggerDown.php'); ?>