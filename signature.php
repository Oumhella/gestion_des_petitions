<?php
// Connexion à la base de données
include 'connexion.php';

// Récupération de l'ID de la pétition depuis l'URL
if (isset($_GET['idp'])) {
    $idp = $_GET['idp'];

    // Récupérer les informations de la pétition sélectionnée
    $stmt = $conn->prepare("SELECT * FROM petition WHERE IDP = ?");
    $stmt->execute([$idp]);
    $petition = $stmt->fetch();
} else {
    die("Aucune pétition sélectionnée !");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Signer la pétition</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            margin-top: 20px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .petition-info {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<form action="ajouterSignature.php" method="POST">
    <h2>Signer la pétition</h2>

    <div class="petition-info">
        <p><strong>Titre :</strong> <?= htmlspecialchars($petition['TitreP']); ?></p>
        <p><strong>Description :</strong> <?= htmlspecialchars($petition['DescriptionP']); ?></p>
    </div>

    <input type="hidden" name="idp" value="<?= $petition['IDP']; ?>">

    <label>Nom :</label>
    <input type="text" name="nomS" required>

    <label>Prénom :</label>
    <input type="text" name="prenomS" required>

    <label>Pays :</label>
    <input type="text" name="paysS" required>

    <label>Email :</label>
    <input type="email" name="emailS" required>

    <input type="submit" value="Signer la pétition">
</form>

</body>
</html>
