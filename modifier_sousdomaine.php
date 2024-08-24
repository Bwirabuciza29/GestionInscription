<?php
// Inclure le fichier de configuration
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $idDomaine = $_POST['idDomaine'];
    $description = $_POST['description'];

    // Vérifier si une nouvelle image a été téléchargée
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imagePath = 'img/' . $image;

        // Déplacer le fichier téléchargé vers le dossier 'img'
        move_uploaded_file($imageTmp, $imagePath);

        // Préparer la requête de mise à jour
        $sql = "UPDATE sousdomaine SET idDomaine = :idDomaine, description = :description, image = :image WHERE id = :id";
    } else {
        // Pas de nouvelle image, ne mettre à jour que les champs non image
        $sql = "UPDATE sousdomaine SET idDomaine = :idDomaine, description = :
description WHERE id =
";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idDomaine', $idDomaine);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id', $id);

    if (isset($image)) {
        $stmt->bindParam(':image', $image);
    }

    $stmt->execute();
    header('Location: sdomaine.php');
    exit;
}
