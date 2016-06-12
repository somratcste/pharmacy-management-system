<?php 
ob_start();
session_start();
if($_SESSION['name']!='www.somrat.info')
{
  header('location: index.php');
}
include("header.php"); 
include("../connection.php");


if(isset($_POST['invoice']))
{
  try {


    $statement = $db->prepare("INSERT INTO memo_info (memo_no, m_date, customar_name, sex, age, doc_id) VALUES (?,?,?,?,?,?)");
    $statement->execute(array($_POST['memo_no'],$_POST['m_date'],$_POST['customar_name'],$_POST['sex'],$_POST['age'],$_POST['doc_id']));


    $statement = $db->prepare("INSERT INTO memo_price (memo_no, subtotal, percent, percent_amount, without_percent, discount_amount, total_paid) VALUES (?,?,?,?,?,?,?)");
    $statement->execute(array($_POST['memo_no'],$_POST['subtotal'],$_POST['percent'],$_POST['percent_amount'],$_POST['without_percent'],$_POST['discount_amount'],$_POST['total_paid']));




    for($i=0;$i<count($_POST['itemNo']);$i++)
    {

        $memo_no['memo_no']      = $_POST['memo_no'];
        $itemNo['itemNo']      = $_POST['itemNo'][$i];
        $itemName['itemName']     = $_POST['itemName'][$i];
        $price['price']        = $_POST['price'][$i];
        $quantity['quantity']     = $_POST['quantity'][$i];
        $total['total']        = $_POST['total'][$i];
        // echo $data['itemNo'] . " " .$data['itemName'] . " " . $data['price'] . " " . $data['quantity']. " " . $data['total'] ;
       //your insert query here
       $statement = $db->prepare("INSERT INTO memo_item (memo_no, item_id, item_name, item_price, item_quantity, item_total) VALUES (?,?,?,?,?,?)");
       $statement->execute(array($memo_no['memo_no'], $itemNo['itemNo'], $itemName['itemName'], $price['price'], $quantity['quantity'], $total['total']));
     }




    $success_message = "Memo Created successfully.";
    
  
  }
  
  catch(Exception $e) { 
    $error_message = $e->getMessage();
  }
}

?>

 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <?php
              if(isset($error_message))
              { ?>
                <div class="alert alert-danger">
                    <p class=""><?php echo $error_message ; ?></p>
                </div>
            <?php 
               } 
             else if(isset($success_message))
              { ?>
                <div class="alert alert-success">
                    <p class=""><?php echo $success_message ; ?></p>
                </div>
            <?php } ?>


          </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ("footer.php"); ?>