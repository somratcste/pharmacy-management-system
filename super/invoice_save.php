<?php

// foreach ($_POST["itemNo"] as $selectedOption)
// {    
//     echo $selectedOption."\n";  
// }



 for($i=0;$i<count($_POST['itemNo']);$i++)
    {
        $data['itemNo']       = $_POST['itemNo'][$i];
        $data['itemName']     = $_POST['itemName'][$i];
        $data['price']        = $_POST['price'][$i];
        $data['quantity']     = $_POST['quantity'][$i];
        $data['total']        = $_POST['total'][$i];
        echo $data['itemNo'] . " " .$data['itemName'] . " " . $data['price'] . " " . $data['quantity']. " " . $data['total'] ;
       //your insert query here
     }

     echo $_POST['total_paid'];
?>