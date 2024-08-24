<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $psw = $_POST['psw'];

    try {
        // Vérification dans la table utilisateur et apprenant
        $stmt = $conn->prepare("
            SELECT u.*, a.* 
            FROM users u 
            JOIN apprenant a ON u.idApprenant = a.id 
            WHERE a.email = ?
        ");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($psw, $user['psw'])) {
            // Stocker toutes les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['idApprenant'];
            $_SESSION['nom'] = $user['nom'] ?? '';
            $_SESSION['postnom'] = $user['postnom'] ?? '';
            $_SESSION['prenom'] = $user['prenom'] ?? '';
            $_SESSION['lieuNaissance'] = $user['lieuNaissance'] ?? '';
            $_SESSION['dateNaissance'] = $user['dateNaissance'] ?? '';
            $_SESSION['email'] = $user['email'] ?? '';
            $_SESSION['tel'] = $user['tel'] ?? '';
            $_SESSION['etatCivil'] = $user['etatCivil'] ?? '';
            $_SESSION['photo'] = $user['photo'] ?? '';
            $_SESSION['category'] = $user['category'] ?? '';

            if ($user['category'] == 'Apprenant') {
                header("Location: index_2.php");
            } elseif ($user['category'] == 'Admin') {
                header("Location: Admin.php");
            }
            exit();
        } else {
            header("Location: login.php?error=Email ou mot de passe incorrect.");
            exit();
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
