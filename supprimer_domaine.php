<?php
// Inclure le fichier de configuration
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Préparer la requête de suppression
    $sql = "DELETE FROM domaine WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    try {
        $stmt->execute();
        // Rediriger vers la page domaines.php après la suppression
        header("Location: domaines.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
