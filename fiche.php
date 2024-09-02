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
                            <h4 class="mt-3"><strong>FICHE D’INSCRIPTION</strong></h4>
                            <hr>
                        </div>
                        <img src="./asset/img/l.png" alt="Photo de Droite" class="header-img">
                    </div>
                </div>

                <div class="row position-relative">
                    <!-- Filigrane -->
                    <div class="position-absolute top-50 start-50 translate-middle text-uppercase text-secondary" style="font-size: 100px; opacity: 0.1; transform: rotate(-45deg); z-index: 0; font-weight: bold">
                        Reçu Inscri
                    </div>
                    <div class="col-md-8 position-relative" style="z-index: 1;">
                        <?php
                        // Connexion à la base de données et récupération des données
                        include('config.php');

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

                            if ($result) {
                                // Afficher les informations
                                echo "<p><strong>Matricule:</strong> " . htmlspecialchars($result['inscription_matricule']) . "</p>";
                                echo "<p><strong>Nom:</strong> " . htmlspecialchars($result['apprenant_nom']) . "</p>";
                                echo "<p><strong>Postnom:</strong> " . htmlspecialchars($result['apprenant_postnom']) . "</p>";
                                echo "<p><strong>Prénom:</strong> " . htmlspecialchars($result['apprenant_prenom']) . "</p>";
                                echo "<p><strong>Domaine:</strong> " . htmlspecialchars($result['domaine_intitule']) . "</p>";
                                echo "<p><strong>Type de Domaine:</strong> " . htmlspecialchars($result['domaine_type']) . "</p>";
                                echo "<p><strong>Sous-Domaine:</strong> " . htmlspecialchars($result['sousdomaine_description']) . "</p>";
                                echo "<p><strong>Montant:</strong> $" . htmlspecialchars($result['payement_montant']) . "</p>";
                                echo "<p><strong>Numéro de Transaction:</strong> " . htmlspecialchars($result['payement_numTrans']) . "</p>";
                                echo "<p><strong>Date d'Inscription:</strong> " . htmlspecialchars($result['inscription_dateInscription']) . "</p>";
                                echo "<p><strong>En date du:</strong> " . date("d/m/Y") . "</p>";
                            } else {
                                echo "<div class='alert alert-danger'>Aucun reçu trouvé pour cet ID.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Aucun ID fourni.</div>";
                        }
                        ?>
                    </div>
                    <div class="col-md-4 text-center position-relative" style="z-index: 1;">
                        <?php
                        if ($result) {
                            echo "<img src='img/" . htmlspecialchars($result['apprenant_photo']) . "' alt='Photo de l’Apprenant' class='img-thumbnail'>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bouton d'impression -->
        <!-- <div class="text-center mt-4">
            <button class="btn btn-primary" onclick="window.print()">Imprimer le Reçu</button>
        </div> -->
    </div>

    <!-- Lien vers Bootstrap JS et ses dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>