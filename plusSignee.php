<?php

include 'connexion.php';


    $top = $conn->query("SELECT TitreP, count(*) as nbr,s.IDP
                        FROM petition p natural join signature s GROUP BY s.IDP
                        HAVING nbr >= ALL (SELECT count(*) as nbr
                        FROM petition p natural join signature s GROUP BY s.IDP);");
    $top->execute();
    $top = $top->fetch();

    if (!$top) {
        echo json_encode([]);
    } else {
        echo json_encode($top);
}

?>