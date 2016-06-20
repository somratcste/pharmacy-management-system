<?php
    include("../connection.php");
    $key=$_GET['key'];
    $array = array();
   
$statement = $db->prepare("SELECT * FROM table_products WHERE productName LIKE '%{$key}%'");
$statement->execute(array());
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
    $array[] = $row['productName'];

        }

    echo json_encode($array);

?>
