<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu d'Inscription</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header-img {
            width: 150px;
        }

        .card {
            max-width: 800px;
            margin: auto;
            background-color: #f8f9fa;
        }
    </style>
</head>

<?php
// Connexion à la base de données et récupération des données
include('config.php');

$inscription_id = null;

if (isset($_GET['id'])) {
    $inscription_id = $_GET['id'];

    // Requête pour récupérer les informations spécifiques
    $query = "SELECT 
                a.nom AS apprenant_nom,
                a.postnom AS apprenant_postnom,
                a.prenom AS apprenant_prenom,
                a.photo AS apprenant_photo,
                d.intituleDomaine AS domaine_intitule,
                d.typeDomaine AS domaine_type,
                sd.description AS sousdomaine_description,
                p.montant AS payement_montant,
                p.numTrans AS payement_numTrans,
                p.photo AS payement_photo,
                i.id AS inscription_id,
                i.matricule AS inscription_matricule,
                i.dateInscription AS inscription_dateInscription
            FROM 
                inscription i
            JOIN 
                apprenant a ON i.idApp = a.id
            JOIN 
                sousdomaine sd ON i.idSousDomaine = sd.id
            JOIN 
                domaine d ON sd.idDomaine = d.id
            JOIN 
                payement p ON i.idPayement = p.id
            WHERE 
                i.id = :id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $inscription_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<body>
    <div class="container mt-5">
        <!-- Corps du reçu -->
        <div class="card border-primary">
            <div class="card-body">
                <!-- En-tête du reçu -->
                <div class="text-center mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <img src="./asset/img/l.png" alt="Photo de Gauche" class="header-img">
                        <div>
                            <h5 class="mb-1">REPUBLIQUE DEMOCRATIQUE DU CONGO</h5>
                            <h6 class="mb-1">PROVINCE DU NORD KIVU</h6>
                            <h6 class="mb-1">INSTITUT NATIONAL DE PREPARATION PROFESSIONNEL</h6>
                            <h6 class="mb-1">BP : 208 Goma/RDC</h6>
                            <h4 class="mt-3">
                                <strong>REÇU D’INSCRIPTION N°
                                    <?php
                                    if (isset($result['inscription_id'])) {
                                        $formatted_id = str_pad($result['inscription_id'], 4, '0', STR_PAD_LEFT);
                                        echo htmlspecialchars($formatted_id);
                                    }
                                    ?>
                                </strong>
                            </h4>
                            <hr>
                        </div>
                        <img src="./asset/img/l.png" alt="Photo de Droite" class="header-img">
                    </div>
                </div>

                <div class="row position-relative">
                    <!-- Filigrane -->
                    <div class="position-absolute top-40 start-50 translate-middle text-uppercase text-secondary" style="font-size: 80px; opacity: 0.1; transform: rotate(-45deg); z-index: 0; font-weight: bold">
                        Reçu Inscription
                    </div>
                    <div class="col-md-12 text-xl position-relative" style="z-index: 1;">
                        <?php
                        if ($result) {
                            echo "<div class='p-4'>";
                            echo "<p class='h5 text-justify'>";
                            echo "Reçu de <strong class='text-uppercase'>" . htmlspecialchars($result['apprenant_nom']) . " " . htmlspecialchars($result['apprenant_postnom']) . " " . htmlspecialchars($result['apprenant_prenom']) . "</strong>, ";
                            echo "la somme de <strong class='text-success'>" . htmlspecialchars($result['payement_montant']) . " </strong> dollars Américains ";
                            echo "pour inscription dans le domaine <strong class='text-primary'>" . htmlspecialchars($result['domaine_intitule']) . "</strong>, filière " . htmlspecialchars($result['sousdomaine_description']) . ". ";
                            echo "<strong>Fait à Goma le</strong> " . htmlspecialchars($result['inscription_dateInscription']) . ".";
                            echo "</p>";
                            echo "</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Aucun reçu trouvé pour cet ID.</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lien vers Bootstrap JS et ses dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>



</html>