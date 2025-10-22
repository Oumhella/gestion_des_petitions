<?php
include 'connexion.php';

$cinq = $conn->prepare("SELECT * FROM signature
                                ORDER BY DateS DESC, Heures DESC LIMIT 5;");
$cinq->execute();
$cinq=$cinq->fetchAll();