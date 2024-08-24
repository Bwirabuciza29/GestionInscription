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
                                    <h5 class="card-title text-center pb-0 fs-4">Authentification</h5>
                                    <p class="text-center small">Entrez votre email et votre mot de passe pour vous connecter</p>
                                </div>
                                <?php
                                if (isset($_GET['message'])) {
                                    echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($_GET['message']) . '</div>';
                                }
                                ?>
                                <?php
                                if (isset($_GET['error'])) {
                                    echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['error']) . '</div>';
                                }
                                ?>
                                <form class="row g-3 needs-validation" action="authentification.php" method="POST" novalidate>
                                    <div class="col-12">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" required>
                                        <div class="invalid-feedback">Veuillez entrer votre email!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="psw" class="form-label">Mot de passe</label>
                                        <input type="password" name="psw" class="form-control" id="psw" required>
                                        <div class="invalid-feedback">Veuillez entrer votre mot de passe!</div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Se Connecter</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">Vous n'avez pas de compte? <a href="register.php">Créer un compte</a></p>
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