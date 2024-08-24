<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['category'] !== 'Apprenant') {
    header("Location: login.php");
    exit();
}
include 'config.php';
// Récupérer les notifications pour l'utilisateur connecté
$userId = $_SESSION['user_id']; // Assurez-vous que l'ID de l'utilisateur est stocké dans la session
$stmt = $conn->prepare("SELECT * FROM notification WHERE user_id = :user_id AND seen = FALSE ORDER BY date DESC");
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Message Notif
// Marquer les notifications comme lues une fois qu'elles sont affichées
$stmt = $conn->prepare("UPDATE notification SET seen = TRUE WHERE user_id = :user_id AND seen = FALSE");
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
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
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">INPP</span>
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

                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number"><?php echo count($notifications); ?></span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            Vous avez <?php echo count($notifications); ?> nouvelle(s) notification(s)
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Voir tout</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <?php foreach ($notifications as $notification): ?>
                            <li class="notification-item">
                                <i class="bi bi-info-circle text-primary"></i>
                                <div>
                                    <h4>Notification</h4>
                                    <p><?php echo htmlspecialchars($notification['message']); ?></p>
                                    <p><?php echo date('d M Y H:i', strtotime($notification['date'])); ?></p>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        <?php endforeach; ?>

                        <li class="dropdown-footer">
                            <a href="#">Afficher toutes les notifications</a>
                        </li>
                    </ul><!-- End Notification Dropdown Items -->
                </li>

                <!-- <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-chat-left-text"></i>
                        <span class="badge bg-success badge-number"><?= $notificationCount ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                        <li class="dropdown-header">
                            Vous avez <?= $notificationCount ?> nouveau message
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <?php foreach ($notificationss as $notification) : ?>
                            <li class="message-item">
                                <a href="#">
                                    <img src="assets/img/default-user.png" alt="" class="rounded-circle">
                                    <div>
                                        <h4>Administration UMOJA NI NGUVU</h4>
                                        <p><?= htmlspecialchars($notification['message']) ?></p>
                                        <p><?= $notification['dateNotification'] ?></p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        <?php endforeach; ?>
                        <li class="dropdown-footer">
                            <a href="#">Show all messages</a>
                        </li>
                    </ul>
                </li> -->

                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="img/<?php echo htmlspecialchars($_SESSION['photo']); ?>" alt="Photo de profil" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo htmlspecialchars($_SESSION['nom'] . ' ' . $_SESSION['postnom']); ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo htmlspecialchars($_SESSION['nom']); ?></h6>
                            <span>INPP</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="logout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Se Déconnecter</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header>