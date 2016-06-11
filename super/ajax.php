<?php
/*
Site : http:www.smarttutorials.net
Author :muni
*/
include ("../connection.php");
if(!empty($_POST['type'])){
	$type = $_POST['type'];
	$name = $_POST['name_startsWith'];
	$query = "SELECT productCode, productName, buyPrice FROM table_products where quantityInStock !=0 and UPPER($type) LIKE '".strtoupper($name)."%'";
	$result = mysqli_query($con, $query);
	$data = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$name = $row['productCode'].'|'.$row['productName'].'|'.$row['buyPrice'];
		array_push($data, $name);
	}	
	echo json_encode($data);exit;
}


