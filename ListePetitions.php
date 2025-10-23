<?php
include 'connexion.php';

$petitions = $conn->prepare("SELECT * FROM petition ORDER BY DateAjoutP DESC");
$petitions->execute();
$petitions = $petitions->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des pétitions</title>
    <style>
        /* === Reset & Base === */
        body {
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
            background-color: #f4f6f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .top{background:#f7f7f7;padding:10px;margin-bottom:12px;border-radius:6px;}
        button{padding:8px 12px;margin:4px;}

        h1 {
            text-align: center;
            color: #1e88e5;
            margin-top: 40px;
            font-size: 2em;
        }

        /* === Table Styling === */
        .tab {
            width: 90%;
            margin: 40px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .tab thead {
            background-color: #1e88e5;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .tab th, .tab td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tab tr:hover {
            background-color: #f1f7ff;
        }

        .tab tbody tr:last-child td {
            border-bottom: none;
        }

        /* === Bouton === */
        .btn {
            display: inline-block;
            background-color: #1e88e5;
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn:hover {
            background-color: #1565c0;
        }

        /* === Responsive === */
        @media (max-width: 768px) {
            .tab {
                width: 100%;
                font-size: 0.9em;
            }

            .tab th, .tab td {
                padding: 10px;
            }

            h1 {
                font-size: 1.5em;
            }
        }
    </style>
</head>

<body>
<div class="top">
    <strong>Pétition la plus signée :</strong>
    <span id="topPetition">Chargement...</span>
    <button onclick="location.href='AjouterPetition.php'">Ajouter une pétition</button>
</div>
<h1>Liste des pétitions</h1>
<table class="tab">
    <thead>
    <tr>
        <th>Titre de la pétition</th>
        <th>Description</th>
        <th>Date d'ajout</th>
        <th>Date de fin</th>
        <th>Porteur</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($petitions as $petition): ?>
        <tr>
            <td><?= htmlspecialchars($petition['TitreP']) ?></td>
            <td><?= htmlspecialchars($petition['DescriptionP']) ?></td>
            <td><?= htmlspecialchars($petition['DateAjoutP']) ?></td>
            <td><?= htmlspecialchars($petition['DateFinP']) ?></td>
            <td><?= htmlspecialchars($petition['NomPorteurP']) ?></td>
            <td><?= htmlspecialchars($petition['Email']) ?></td>
            <td>
                <a href="signature.php?idp=<?= $petition['IDP'] ?>" class="btn">Signer</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
<script>
    function updateTop() {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "plusSignee.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    let data = JSON.parse(xhr.responseText);
                    if (data.TitreP !== undefined) {
                    document.getElementById('topPetition').textContent = data.TitreP + ' : ' + data.nbr+ ' signatures';
                } else {
                    document.getElementById('topPetition').textContent = 'Aucune pétition';
                }

                } catch(e) {
                    console.error("Erreur JSON", e);
                }
            }
        }
        xhr.send();
    }
    updateTop();
    setInterval(updateTop, 5000);



    let lastId = 0;
    let initialised = false;

    if (Notification.permission !== "granted") {
        Notification.requestPermission();
    }

    function showNotification(message){
        if(Notification.permission === "granted"){
            new Notification(message);
        }
    }

    function verifierNouveauRecord() {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "notifNouvellepetition.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    let data = JSON.parse(xhr.responseText);

                    if (data.lastId !== undefined) {
                        if (initialised && data.lastId > lastId) {

                            showNotification("Nouvelle petition ajoutee !");
                        } else {
                            console.log("No new petition or first load");
                        }
                        lastId = data.lastId;
                        initialised = true;
                    }
                } catch(e) {
                    console.error("Erreur JSON", e);
                }
            }
        };
        xhr.send();
    }

    verifierNouveauRecord();
    setInterval(verifierNouveauRecord, 5000);
</script>