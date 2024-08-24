<?php
// Inclure le fichier de configuration
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idDomaine = $_POST['idDomaine'];
    $description = $_POST['description'];

    // Vérifier si une image a été téléchargée
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imagePath = 'img/' . $image;

        // Déplacer le fichier téléchargé vers le dossier 'img'
        move_uploaded_file($imageTmp, $imagePath);

        // Préparer la requête d'insertion
        $sql = "INSERT INTO sousdomaine (idDomaine, description, image) VALUES (:idDomaine, :description, :image)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idDomaine', $idDomaine);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
    } else {
        // Pas de fichier image, insérer seulement les autres champs
        $sql = "INSERT INTO sousdomaine (idDomaine, description) VALUES (:idDomaine, :description)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idDomaine', $idDomaine);
        $stmt->bindParam(':description', $description);
    }

    $stmt->execute();
    header('Location: sdomaine.php');
    exit;
}
