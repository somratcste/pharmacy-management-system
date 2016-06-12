<?php

// foreach ($_POST["itemNo"] as $selectedOption)
// {    
//     echo $selectedOption."\n";  
// }

 // for($i=0;$i<count($_POST['itemNo']);$i++)
 //    {
 //        $data['itemNo']       = $_POST['itemNo'][$i];
 //        $data['itemName']     = $_POST['itemName'][$i];
 //        $data['price']        = $_POST['price'][$i];
 //        $data['quantity']     = $_POST['quantity'][$i];
 //        $data['total']        = $_POST['total'][$i];
 //        echo $data['itemNo'] . " " .$data['itemName'] . " " . $data['price'] . " " . $data['quantity']. " " . $data['total'] ;
 //       //your insert query here
 //     }

if(isset($_POST['invoice']))
{
  try {


    $statement = $db->prepare("INSERT INTO memo_info (memo_no, m_date, customar_name, sex, age, doc_id) VALUES (?,?,?,?,?,?)");
    $statement->execute(array($_POST['memo_no'],$_POST['m_date'],$_POST['customar_name'],$_POST['sex'],$_POST['age'],$_POST['doc_id']));


    $statement = $db->prepare("INSERT INTO memo_price (memo_no, subtotal, percent, percent_amount, without_percent, discount_amount, total_paid) VALUES (?,?,?,?,?,?,?)");
    $statement->execute(array($_POST['memo_no'],$_POST['subtotal'],$_POST['percent'],$_POST['percent_amount'],$_POST['without_percent'],$_POST['discount_amount'],$_POST['total_paid']));


    for($i=0;$i<count($_POST['itemNo']);$i++)
    {
        $data['memo_no']      = $_POST['memo_no'];
        $data['itemNo']       = $_POST['itemNo'][$i];
        $data['itemName']     = $_POST['itemName'][$i];
        $data['price']        = $_POST['price'][$i];
        $data['quantity']     = $_POST['quantity'][$i];
        $data['total']        = $_POST['total'][$i];
        // echo $data['itemNo'] . " " .$data['itemName'] . " " . $data['price'] . " " . $data['quantity']. " " . $data['total'] ;
       //your insert query here
       $statement = $db->prepare("INSERT INTO memo_item (memo_no, item_id, item_name, item_price, item_quantity, item_total) VALUES (?,?,?,?,?,?)");
       $statement->execute(array($_POST['memo_no'],$_POST['itemNo'],$_POST['itemName'],$_POST['price'],$_POST['quantity'],$_POST['total']));
     }




    $success_message = "Memo Created successfully.";
    
  
  }
  
  catch(Exception $e) { 
    $error_message = $e->getMessage();
  }
}

?>