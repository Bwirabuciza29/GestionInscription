<?php
// Inclure le fichier de configuration
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $intituleDomaine = $_POST['intituleDomaine'];
    $typeDomaine = $_POST['typeDomaine'];

    // Préparer la requête de mise à jour
    $sql = "UPDATE domaine SET intituleDomaine = :intituleDomaine, typeDomaine = :typeDomaine WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':intituleDomaine', $intituleDomaine);
    $stmt->bindParam(':typeDomaine', $typeDomaine);

    try {
        $stmt->execute();
        // Rediriger vers la page domaines.php après la mise à jour
        header("Location: domaines.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
