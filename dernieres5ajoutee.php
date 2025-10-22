<?php
include 'connexion.php';
header('Content-Type: application/json; charset=utf-8');

$cinq = $conn->prepare("SELECT * FROM signature
                                ORDER BY DateS DESC, Heures DESC LIMIT 5;");
$cinq->execute();
$cinq=$cinq->fetchAll();
if (!$cinq){
    echo json_encode([]);
}else {
    echo json_encode($cinq);
}
?>
