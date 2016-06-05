<?php
    include("../connection.php");
    $key=$_GET['key'];
    $array = array();



$statement = $db->prepare("SELECT * FROM table_products WHERE p_name LIKE '%{$key}%'");
$statement->execute(array());
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
    $array[] = $row['p_name'];
        }

    echo json_encode($array);
?>
