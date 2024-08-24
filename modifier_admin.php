<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $postnom = $_POST['postnom'];
    $prenom = $_POST['prenom'];
    $lieuNaissance = $_POST['lieuNaissance'];
    $dateNaissance = $_POST['dateNaissance'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $etatCivil = $_POST['etatCivil'];
    $psw = $_POST['psw'] ? password_hash($_POST['psw'], PASSWORD_DEFAULT) : null;

    // Gestion de la photo
    if ($_FILES['photo']['name']) {
        $photo = basename($_FILES['photo']['name']);
        $target_dir = "img/";
        $target_file = $target_dir . $photo;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $_SESSION['photo'] = $photo;
        } else {
            echo "Erreur lors du téléchargement de la photo.";
            exit();
        }
    } else {
        $photo = $_SESSION['photo'];
    }

    try {
        // Mise à jour des informations
        $stmt = $conn->prepare("
            UPDATE apprenant 
            SET nom = ?, postnom = ?, prenom = ?, lieuNaissance = ?, dateNaissance = ?, email = ?, tel = ?, etatCivil = ?, photo = ?
            WHERE id = ?
        ");
        $stmt->execute([$nom, $postnom, $prenom, $lieuNaissance, $dateNaissance, $email, $tel, $etatCivil, $photo, $_SESSION['user_id']]);

        if ($psw) {
            $stmt = $conn->prepare("
                UPDATE users 
                SET psw = ? 
                WHERE idApprenant = ?
            ");
            $stmt->execute([$psw, $_SESSION['user_id']]);
        }

        // Mettre à jour la session
        $_SESSION['nom'] = $nom;
        $_SESSION['postnom'] = $postnom;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['lieuNaissance'] = $lieuNaissance;
        $_SESSION['dateNaissance'] = $dateNaissance;
        $_SESSION['email'] = $email;
        $_SESSION['tel'] = $tel;
        $_SESSION['etatCivil'] = $etatCivil;
        $_SESSION['photo'] = $photo;

        if ($_SESSION['category'] === 'Apprenant') {
            header("Location: index_2.php");
        } else {
            header("Location: Admin.php");
        }
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
