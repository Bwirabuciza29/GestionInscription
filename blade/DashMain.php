<?php
session_start();
require_once('config.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

try {
    // Préparer la requête pour récupérer les informations de l'utilisateur connecté
    $stmt = $conn->prepare("
        SELECT noms, fonction, category 
        FROM users 
        WHERE id = :user_id
    ");
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();

    // Récupérer les informations de l'utilisateur
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $userName = htmlspecialchars($user['noms']);
        $userFunction = htmlspecialchars($user['fonction']);
        $userCategory = htmlspecialchars($user['category']);
    } else {
        // Si l'utilisateur n'existe pas, détruire la session et rediriger vers la page de connexion
        session_destroy();
        header('Location: index.php');
        exit();
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>GestionCredit</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        * {
            a {
                text-decoration: none;
            }
        }

        @media print {
            .no-print {
                display: none;
            }

            .invoice {
                display: block;
            }
        }

        .invoice {
            margin: 20px 0;
        }

        .invoice .container {
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #fff;
        }

        .invoice table {
            width: 100%;
        }

        .invoice th,
        .invoice td {
            padding: 8px;
            text-align: left;
        }

        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .modal-body img {
            width: 100%;
            height: auto;
        }

        .profile-img {
            width: 120px;
            height: 100px;
            object-fit: cover;
        }

        .suggestion-list {
            border: 1px solid #ced4da;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            z-index: 1000;
            background-color: #fff;
        }

        .suggestion-item {
            padding: 8px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <span class="d-none d-lg-block">UMOJA NI NGUVU</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $userName ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= $userName ?></h6>
                            <span><?= $userCategory ?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a href="logout.php" class="dropdown-item d-flex align-items-center" href="logout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Se Deconnecter</span>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </nav>
    </header>