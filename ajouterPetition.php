<?php
include 'connexion.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $dateFin = $_POST['datefin'];
    $nomPorteur = $_POST['nomporteur'];
    $email = $_POST['email'];
    $dateAjout = date('Y-m-d'); // date du jour automatiquement

    // Insertion dans la base de données
    $stmt = $conn->prepare("INSERT INTO petition (TitreP, DescriptionP, DateAjoutP, DateFinP, NomPorteurP, Email)
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$titre, $description, $dateAjout, $dateFin, $nomPorteur, $email]);

    // Rediriger vers la liste après ajout
    header("Location: ListePetitions.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une pétition</title>
    <style>
        body {
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
            background-color: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            width: 420px;
        }

        h2 {
            text-align: center;
            color: #1e88e5;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        textarea {
            resize: vertical;
            height: 80px;
        }

        input[type="submit"] {
            background-color: #1e88e5;
            color: white;
            border: none;
            padding: 10px;
            margin-top: 25px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #1565c0;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #1e88e5;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<form method="POST" action="">
    <h2>Ajouter une nouvelle pétition</h2>

    <label for="titre">Titre de la pétition :</label>
    <input type="text" id="titre" name="titre" required>

    <label for="description">Description :</label>
    <textarea id="description" name="description" required></textarea>

    <label for="datefin">Date de fin :</label>
    <input type="date" id="datefin" name="datefin" required>

    <label for="nomporteur">Nom du porteur :</label>
    <input type="text" id="nomporteur" name="nomporteur" required>

    <label for="email">Email du porteur :</label>
    <input type="email" id="email" name="email" required>

    <input type="submit" value="Créer la pétition">

    <a href="ListePetitions.php">← Retour à la liste des pétitions</a>
</form>

</body>
</html>
<script>
    function notifier(){
        const xhttp = new XMLHttpRequest();
    }
</script>