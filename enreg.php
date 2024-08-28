<?php
// Assurez-vous de démarrer la session si ce n'est pas déjà fait
session_start();
// Inclure le fichier de connexion à la base de données
include('config.php');

// Vérifier si la requête est un POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idInscription = $_POST['idInscription'];

    try {
        // Démarrer une transaction
        $conn->beginTransaction();

        // Changer le statut à "payé"
        $stmt = $conn->prepare("UPDATE inscription SET status = 'payé', matricule = :matricule WHERE id = :id");
        $stmt->bindParam(':id', $idInscription);

        // Générer un nouveau matricule
        $nouveauMatricule = genererMatricule($conn);
        $stmt->bindParam(':matricule', $nouveauMatricule);

        $stmt->execute();

        // Envoyer une notification à l'apprenant
        $stmt = $conn->prepare("INSERT INTO notifications (idApprenant, message) VALUES (:idApprenant, :message)");
        $stmt->bindParam(':idApprenant', $_POST['idApprenant']);
        $message = "Votre paiement a été validé. Votre nouveau matricule est $nouveauMatricule.";
        $stmt->bindParam(':message', $message);
        $stmt->execute();

        // Confirmer la transaction
        $conn->commit();

        // Rediriger vers admin.php après le succès de l'opération
        header("Location: admin.php");
        exit();
    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction
        $conn->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}

// Fonction pour générer un nouveau matricule
function genererMatricule($conn)
{
    // Logique pour générer un matricule unique
    $prefix = "INPP";
    $suffix = rand(1000, 9999); // Vous pouvez adapter cette logique selon vos besoins
    return $prefix . $suffix;
}
