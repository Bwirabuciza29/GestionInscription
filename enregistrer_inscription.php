<?php
session_start();
include 'config.php';

function genererMatricule($conn)
{
    $stmt = $conn->prepare("SELECT matricule FROM inscription ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $dernierMatricule = $stmt->fetchColumn();

    if ($dernierMatricule) {
        $num = (int)substr($dernierMatricule, 6);
        $num++;
        $nouveauMatricule = 'APINPP' . str_pad($num, 3, '0', STR_PAD_LEFT);
    } else {
        $nouveauMatricule = 'APINPP001';
    }

    return $nouveauMatricule;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idApp = $_POST['idApp'];
    $idSousDomaine = $_POST['idSousDomaine'];
    $dateInscription = $_POST['dateInscription'];
    $status = $_POST['status'] ?? 'en attente'; // Défini par défaut à "en attente"
    $matricule = 'Apprenant'; // Matricule par défaut pour "en attente"

    // Gestion du paiement
    $montant = $_POST['montant'];
    $datePayement = $_POST['datePayement'];
    $numTrans = $_POST['numTrans'];
    $photo = $_FILES['photo'];

    $photoPath = 'img/' . basename($photo['name']);
    move_uploaded_file($photo['tmp_name'], $photoPath);

    // Insérer les données dans la table `payement`
    $stmt = $conn->prepare("INSERT INTO payement (Montant, datePayement, numTrans, photo) 
                            VALUES (:montant, :datePayement, :numTrans, :photo)");
    $stmt->bindParam(':montant', $montant);
    $stmt->bindParam(':datePayement', $datePayement);
    $stmt->bindParam(':numTrans', $numTrans);
    $stmt->bindParam(':photo', $photoPath);
    $stmt->execute();
    $idPayement = $conn->lastInsertId(); // Obtenir l'ID du paiement inséré

    // Si le statut est payé, générer un matricule unique
    if ($status == 'payé') {
        $matricule = genererMatricule($conn);
    }

    // Insérer les données dans la table `inscription`
    $stmt = $conn->prepare("INSERT INTO inscription (matricule, idApp, idSousDomaine, idPayement, dateInscription, status) 
                            VALUES (:matricule, :idApp, :idSousDomaine, :idPayement, :dateInscription, :status)");
    $stmt->bindParam(':matricule', $matricule);
    $stmt->bindParam(':idApp', $idApp);
    $stmt->bindParam(':idSousDomaine', $idSousDomaine);
    $stmt->bindParam(':idPayement', $idPayement);
    $stmt->bindParam(':dateInscription', $dateInscription);
    $stmt->bindParam(':status', $status);

    try {
        $stmt->execute();

        // Récupérer les données de l'utilisateur connecté
        $stmt = $conn->prepare("SELECT u.*, a.* 
                                FROM users u 
                                JOIN apprenant a ON u.idApprenant = a.id 
                                WHERE a.id = :idApprenant");
        $stmt->bindParam(':idApprenant', $idApp);
        $stmt->execute();
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        // Ajouter une notification pour l'apprenant
        $messageUtilisateur = "Votre inscription a été enregistrée. Votre cas sera traité dans quelques instants et une notification vous sera renvoyée. Votre matricule est $matricule pour l'instant.";
        $stmt = $conn->prepare("INSERT INTO notification (user_id, message) VALUES (:user_id, :message)");
        $stmt->bindParam(':user_id', $utilisateur['id']);
        $stmt->bindParam(':message', $messageUtilisateur);
        $stmt->execute();

        // Ajouter une notification pour l'administrateur
        // Remplacer $adminId par l'ID de l'administrateur
        $adminId = 2; // Exemple, modifiez en fonction de la façon dont vous gérez les admins
        $messageAdmin = "Un nouvel apprenant vient de vous envoyer une demande d'inscription. Veuillez vérifier et valider cette inscription.";
        $stmt = $conn->prepare("INSERT INTO notification (user_id, message) VALUES (:user_id, :message)");
        $stmt->bindParam(':user_id', $adminId);
        $stmt->bindParam(':message', $messageAdmin);
        $stmt->execute();

        echo "Enregistrement réussi!";
        header("Location: user.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de l'enregistrement : " . $e->getMessage();
    }
}
