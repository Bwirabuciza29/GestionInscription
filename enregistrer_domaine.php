<?php
// Inclure le fichier de configuration
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire
    $intituleDomaine = $_POST['intituleDomaine'];
    $typeDomaine = $_POST['typeDomaine'];

    // Préparer la requête d'insertion
    $sql = "INSERT INTO domaine (intituleDomaine, typeDomaine) VALUES (:intituleDomaine, :typeDomaine)";

    // Exécuter la requête
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':intituleDomaine', $intituleDomaine);
        $stmt->bindParam(':typeDomaine', $typeDomaine);
        $stmt->execute();

        // Rediriger vers la page domaines.php après l'enregistrement
        header("Location: domaines.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
