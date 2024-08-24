<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idSousDomaine = $_POST['idSousDomaine'];

    $stmt = $conn->prepare("SELECT d.intituleDomaine 
                            FROM domaine d 
                            JOIN sousdomaine sd ON d.id = sd.idDomaine 
                            WHERE sd.id = ?");
    $stmt->execute([$idSousDomaine]);
    echo $stmt->fetchColumn();
}
