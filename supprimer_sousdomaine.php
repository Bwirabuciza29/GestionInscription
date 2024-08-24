<?php
// Inclure le fichier de configuration
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Supprimer l'enregistrement de la base de données
    $sql = "DELETE FROM sousdomaine WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Optionnel : Supprimer l'image associée du serveur
    $imagePath = 'img/' . $image;

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    header('Location: sdomaine.php');
    exit;
}
