<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['category'] !== 'Apprenant') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Font awesome cdn CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <!-- Bootstrap core CSS -->
    <link href="asset/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="asset/css/styles.css" />
    <!-- Favicons -->
    <link href="asset/img/favicon.png" rel="icon">
    <link href="asset/img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- Vendor CSS Files -->
    <link href="asset/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="asset/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">

    <title>gestion_inscription</title>
</head>

<body>
    <nav class="cc-navbar navbar navbar-expand-lg navbar-dark position-fixed w-100">
        <div class="container-fluid">
            <a class="navbar-brand text-uppercase mx-4 py-3 fw-bolder m-0 font-weight-bold text-white" href="#">INPP</a> <br>
            <p class="m-0 font-weight-bold text-white">La formation professionnelle c'est nous! </p>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item pe-4">
                        <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item pe-4">
                        <a class="nav-link" href="user.php">Formation</a>
                    </li>
                    <li class="nav-item pe-4">
                        <a class="nav-link" href="maquette-catalogue-2022-kb.pdf">A propos</a>
                    </li>
                    <li class="nav-item pe-4">
                        <a class="btn btn-order rounded-0" href="user.php">Mon Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br><br><br><br>
    <section class="banner d-flex justify-content-center align-items-center pt-5">
        <div class="container my-5 py-5">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6 banner-desc lh-lg">
                    <h1 class="text-capitalize py-3 redressed">
                        Institut National <br />
                        de Préparation Professionnelle
                    </h1>
                    <p>
                        <a href="doc/FICHE-D-RENSEIGNEMENTS-2020-....docx.pdf" align="center">
                            <button class="btn btn-order btn-lg me-5 rounded-0 merriweather">
                                <i> fiche de renseignement</i>
                            </button>
                        </a>
                        <a href="doc/maquette-catalogue-2022-kb.pdf">
                            <button class="btn btn-outline-info btn-lg rounded-0 merriweather">
                                <i> Catalogue de formations continue 2022</i>
                            </button>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="available merriweather py-5">
        <div class="container">
            <div class="row">
                <div class="card mb-3 border-0 rounded-0 py-4">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="asset/img/INPP.JPG" class="img-fluid" alt="..." />
                        </div>
                        <div class="col-md-6" data-aos="fade-left">
                            <div class="card-body px-0">
                                <h3 class="m-0 font-weight-bold text-primary">A propos</h3>
                                <p class="card-text" align="justify">
                                    L'INPP, Institut National de Préparation Professionnelle. La formation continue, une priorité pour l'INPP, organisée en modules courts: S'adresse aux personnes dans l'emploi (Chefs d'entreprises, salariés du secteur public et privé, Auto entrepreneur, etc.) pour completer ou moderniser leurs compétences. Elle constitue la solution durable aux besoins réels du monde économique.
                                </p>
                                <p class="card-text"><a href="doc/maquette-catalogue-2022-kb.pdf" class="btn btn-outline-info btn-lg rounded-0 merriweather">Catalogue de formations continue 2022</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card my-5 border-0 rounded-0 py-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-body px-0">
                                <h3 class="m-0 font-weight-bold text-primary" data-aos="fade-right">Nos Formations</h3>
                                <p class="card-text" align="justify">
                                    En vue de contribuer au progrès de la nation congolaise, l’INPP s’est fixé pour objectif social la qualification de la population active de la République Démocratique du Congo par une formation professionnelle de haute performance.A part son objectif social, l’INPP/Nord–Kivu se fixe certaines missions qui sont :
                                </p>
                                <p>
                                <ul align="justify">
                                    <li data-aos="fade-right">Collaborer à la promotion, à la création et à la mise en application des moyens existants ou nouveaux, nécessaires pour la qualification de la population active de la RDC;</li>
                                    <li data-aos="fade-left">D’assurer les ministères ayant l’enseignement dans leurs attributions et de coopérer avec eux pour assurer l’harmonisation entre l’enseignement dispensé et les exigences quantitatives et qualitatives de l’emploi, en tenant compte des tendances ;</li>
                                </ul>
                                </p>
                                <a href="doc/FICHE-D-RENSEIGNEMENTS-2020-....docx.pdf" align="center">
                                    <button class="btn btn-outline-info btn-lg rounded-0 merriweather">
                                        fiche de renseignement
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="asset/img/AdobeStock_463754704_Preview.jpeg" class="d-block w-100" alt="..." />
                                    </div>
                                    <div class="carousel-item">
                                        <img src="asset/img/AdobeStock_442696515_Preview.jpeg" class="d-block w-100" alt="..." />
                                    </div>
                                    <div class="carousel-item">
                                        <img src="asset/img/bbb.jpg" class="d-block w-100" alt="..." />
                                    </div>
                                </div>
                                <button
                                    class="carousel-control-prev"
                                    type="button"
                                    data-bs-target="#carouselExampleControls"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button
                                    class="carousel-control-next"
                                    type="button"
                                    data-bs-target="#carouselExampleControls"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card mb-3 border-0 rounded-0 py-4">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="asset/img/INPP1.PNG" class="img-fluid" alt="..." />
                        </div>
                        <div class="col-md-6">
                            <div class="card-body px-0">
                                <h3 class="m-0 font-weight-bold text-primary">L'INPP assure:</h3>
                                <p class="card-text" align="justify">
                                    Le perfectionnement, l’employabilité, l’amélioration des compétences et la promotion professionnelle des bénéficiaires d’une culture générale de base, d’adaptation professionnelle de ceux ayant reçu une formation technique ou professionnelle de type scolaire.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cc-footer py-5">
        <div class="container">
            <div class="row">
            </div>
            <div class="col-12 text-center py-4 text-muted">
                <script>
                    document.write(new Date().getFullYear());
                </script>
                Copyright
            </div>
        </div>
        </div>
    </section>
    <script src="asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="asset/js/bootstrap.bundle.min.js"></script>
    <script src="asset/vendor/purecounter/purecounter.js"></script>
    <script src="asset/vendor/aos/aos.js"></script>
    <script src="asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="asset/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="asset/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="asset/vendor/swiper/swiper-bundle.min.js"></script>
</body>

</html>