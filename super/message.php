<?php 
ob_start();
session_start();
if($_SESSION['name']!='www.somrat.info')
{
  header('location: index.php');
}
include ("header.php") ;
include ("../connection.php");
include ("left-sidebar.php") ; 
require_once('delete_confirm.php');

?>

<?php
if(isset($_POST['form1']))
{
  try {
    
    if(empty($_POST['p_name'])) {
      throw new Exception("Trade Name can not be empty.");
    }

    $statement = $db->prepare("SELECT * FROM table_products WHERE p_name=?");
    $statement->execute(array($_POST['p_name']));
    $total = $statement->rowCount();
    
    if($total>0) {
      throw new Exception("Product Name already exists.");
    }


    if(empty($_POST['com_id'])) {
      throw new Exception("Company Name Cat not be selected");
      
    }

    if(empty($_POST['cat_id'])) {
      throw new Exception("Category Name Cat not be selected");
      
    }

    if(empty($_POST['p_price'])) {
      throw new Exception("Purchase Price Cat not be empty");
      
    }

    if(empty($_POST['s_price'])) {
      throw new Exception("Selling Price Cat not be empty");
      
    }

    if(empty($_POST['e_date'])) {
      throw new Exception("Expire Date can not be empty");
      
    }
  

    $p_date = date('Y-m-d');
    $p_year = substr($p_date,0,4);
    $p_month = substr($p_date,5,2);
    $p_day = substr($p_date,8,2);


    $statement = $db->prepare("INSERT INTO table_products (p_name,com_id,cat_id,p_peice,p_price,s_price,e_date,p_date) VALUES (?,?,?,?,?,?,?,?)");
    $statement->execute(array($_POST['p_name'],$_POST['com_id'],$_POST['cat_id'],$_POST['p_peice'],$_POST['p_price'],$_POST['s_price'],$_POST['e_date'],$p_date));

    $success_message = "Product has been inserted successfully.";
    
  
  }
  
  catch(Exception $e) { 
    $error_message = $e->getMessage();
  }
} 



if(isset($_REQUEST['id'])) 
{
  $id = $_REQUEST['id'];
  
  $statement = $db->prepare("DELETE FROM table_products WHERE p_id=?");
  $statement->execute(array($id));
  
  $success_message2 = "Product has been deleted successfully.";
  
}

?>




<?php 
if(isset($_POST['form_product_increment'])) {

  $id = $_REQUEST['pinid'];
  try {
  
    $p_peice_entry = $_POST['p_peice_entry'];

    if(empty($_POST['inc_address'])) {
      throw new Exception("Memo No. can not be empty");
      
    }
    else {
      $inc_address = $_POST['inc_address'];
    }

    $p_date = date('Y-m-d');
    $p_year = substr($p_date,0,4);
    $p_month = substr($p_date,5,2);
    $p_day = substr($p_date,8,2);


    $statement = $db->prepare("INSERT INTO product_increment (p_peice,p_id,p_date,inc_address,p_day,p_month,p_year) VALUES (?,?,?,?,?,?,?)");
    
    $statement->execute(array($_POST['p_peice_entry'],$id,$p_date,$inc_address,$p_day,$p_month,$p_year));
    $success_message = "Product Increment has been successfully added.";

    
    $statement = $db->prepare("SELECT * FROM table_products WHERE p_id=?");
    $statement->execute(array($id));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row)
    {
      $p_peice = $row['p_peice'];
    }

    $p_peice = $p_peice + $p_peice_entry;

    $statement = $db->prepare("UPDATE table_products SET  p_peice = ? WHERE p_id =? ");
    $statement->execute(array($p_peice,$id));
    
  
  }
  
  catch(Exception $e) {
    $error_message = $e->getMessage();
  }


}

?>

<?php

if(isset($_POST['form_product_decrement'])) {

    $id = $_REQUEST['pdecid'];
  try {
  
    $p_peice_entry = $_POST['p_peice_entry'];

    if(empty($_POST['dec_address'])) {
      throw new Exception("Memo no. can not be empty");
      
    }
    else {
      $dec_address = $_POST['dec_address'];
    }

    $p_date = date('Y-m-d');
    $p_year = substr($p_date,0,4);
    $p_month = substr($p_date,5,2);
    $p_day = substr($p_date,8,2);


    $statement = $db->prepare("INSERT INTO product_decrement (p_peice,p_id,p_date,dec_address,p_day,p_month,p_year) VALUES (?,?,?,?,?,?,?)");
    
    $statement->execute(array($_POST['p_peice_entry'],$id,$p_date,$dec_address,$p_day,$p_month,$p_year));
    $success_message = "Product Decrement has been successfully Removed.";



    $statement = $db->prepare("SELECT * FROM table_products WHERE p_id=?");
    $statement->execute(array($id));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row)
    {
      $p_peice = $row['p_peice'];
    }
  
    $p_peice = $p_peice - $p_peice_entry ; 

    $statement = $db->prepare("UPDATE table_products SET p_peice = ?  WHERE p_id =? ");
    $statement->execute(array($p_peice,$id));
    
  
  }
  
  catch(Exception $e) {
    $error_message = $e->getMessage();
  }


}

?>


<?php 

if(isset($_POST['form_edit'])) {

  $id = $_REQUEST['peditid'];
  try {
  
    if(empty($_POST['p_name'])) {
      throw new Exception("Trade Name can not be empty.");
    }

    $statement = $db->prepare("SELECT * FROM table_products WHERE p_name=?");
    $statement->execute(array($_POST['p_name']));
    $total = $statement->rowCount();
    
    if($total>0) {
      throw new Exception("Product Name already exists.");
    }


    if(empty($_POST['com_id'])) {
      throw new Exception("Company Name Cat not be selected");
      
    }

    if(empty($_POST['cat_id'])) {
      throw new Exception("Category Name Cat not be selected");
      
    }

    if(empty($_POST['p_price'])) {
      throw new Exception("Purchase Price Cat not be empty");
      
    }

    if(empty($_POST['s_price'])) {
      throw new Exception("Selling Price Can not be empty");
      
    }

    if(empty($_POST['e_date'])) {
      throw new Exception("Expire Date can not be empty");
      
    }

            
      $statement = $db->prepare("UPDATE table_products SET p_name=?, com_id=?, cat_id=?,  p_peice = ? , p_price = ? , s_price = ? , e_date = ? WHERE p_id =? ");
      $statement->execute(array($_POST['p_name'],$_POST['com_id'],$_POST['cat_id'],$_POST['p_peice'],$_POST['p_price'],$_POST['s_price'],$_POST['e_date'],$id));

     
    $success_message = "Product has been updated successfully.";
    
    
  
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