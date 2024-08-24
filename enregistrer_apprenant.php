<?php
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
    $category = $_POST['category'];
    $psw = password_hash($_POST['psw'], PASSWORD_DEFAULT);

    // Gestion de la photo
    $photo = $_FILES['photo']['name'];
    $target_dir = "img/";
    $target_file = $target_dir . basename($photo);
    move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);

    try {
        // Insérer les données dans la table apprenant
        $stmt = $conn->prepare("INSERT INTO apprenant (nom, postnom, prenom, lieuNaissance, dateNaissance, email, tel, etatCivil, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $postnom, $prenom, $lieuNaissance, $dateNaissance, $email, $tel, $etatCivil, $photo]);

        // Obtenir l'ID de l'apprenant inséré
        $idApprenant = $conn->lastInsertId();

        // Insérer les données dans la table users
        $stmt = $conn->prepare("INSERT INTO users (idApprenant, category, psw) VALUES (?, ?, ?)");
        $stmt->execute([$idApprenant, $category, $psw]);

        // Redirection avec un message d'alerte
        header("Location: login.php?message=Veuillez vous connecter avec votre email et mot de passe.");
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
