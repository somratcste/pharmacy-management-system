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
      throw new Exception("Product Name can not be empty.");
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

    if(empty($_POST['size_id'])) {
      throw new Exception("size Cat not be selected");
      
    }

    

    if(empty($_POST['p_price'])) {
      throw new Exception("Price Cat not be empty");
      
    }
  

    $p_date = date('Y-m-d');
    $p_year = substr($p_date,0,4);
    $p_month = substr($p_date,5,2);
    $p_day = substr($p_date,8,2);




    if(empty($_FILES["p_image"]["name"])) { 

    $statement = $db->prepare("INSERT INTO table_products (p_name,com_id,cat_id,size_id,p_cartoon,p_peice,p_date,p_price) VALUES (?,?,?,?,?,?,?,?)");
    $statement->execute(array($_POST['p_name'],$_POST['com_id'],$_POST['cat_id'],$_POST['size_id'],$_POST['p_cartoon'],$_POST['p_peice'],$p_date,$_POST['p_price']));

    }


    else {

    $statement = $db->prepare("SHOW TABLE STATUS LIKE 'table_products'");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
      $new_id = $row[10];
      
    
    $up_filename=$_FILES["p_image"]["name"];
    $file_basename = substr($up_filename, 0, strripos($up_filename, '.')); // strip extention
    $file_ext = substr($up_filename, strripos($up_filename, '.')); // strip name
    $f1 = $new_id . $file_ext;
    
    if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
      throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
    
    move_uploaded_file($_FILES["p_image"]["tmp_name"],"dist/img/product-images/" . $f1);


    
    $statement = $db->prepare("INSERT INTO table_products (p_name,p_image,com_id,cat_id,size_id,p_cartoon,p_peice,p_date,p_price) VALUES (?,?,?,?,?,?,?,?,?)");
    $statement->execute(array($_POST['p_name'],$f1,$_POST['com_id'],$_POST['cat_id'],$_POST['size_id'],$_POST['p_cartoon'],$_POST['p_peice'],$p_date,$_POST['p_price']));


    }






    
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
  
  $success_message = "Product has been deleted successfully.";
  
}

?>


<?php
if(isset($_POST['form_price_increment'])) {


  try {
  
    $id = $_REQUEST['pid'];

    if(empty($_POST['p_price'])) {
      throw new Exception("Price Cat not be empty");
      
    }
    else {
      $p_price = $_POST['p_price'];
    }

    $p_price_inc = 0 ;

    $statement = $db->prepare("SELECT p_price FROM table_products WHERE p_id=?");
    $statement->execute(array($id));
    $product_price = $statement->fetch()["p_price"];
    $p_price_inc = $product_price + $p_price ;
  



    $statement = $db->prepare("UPDATE table_products SET p_price = ? WHERE p_id =? ");
    $statement->execute(array($p_price_inc,$id));
    $success_message = "Price Increment has been successfully added.";
    
  
  }
  
  catch(Exception $e) {
    $error_message = $e->getMessage();
  }


}

?>

<?php

if(isset($_POST['form_price_decrement'])) {


  try {
  
      $id = $_REQUEST['pid'];

    if(empty($_POST['p_price'])) {
      throw new Exception("Price Cat not be empty");
      
    }
    else {
      $p_price = $_POST['p_price'];
    }

    $p_price_dec = 0 ;

    $statement = $db->prepare("SELECT p_price FROM table_products WHERE p_id=?");
    $statement->execute(array($id));
    $product_price = $statement->fetch()["p_price"];
    $p_price_dec = $product_price - $p_price ;

    if($p_price_dec <= 0 ) 
      throw new Exception("Price can not be less than ZERO (0). ");
      
  



    $statement = $db->prepare("UPDATE table_products SET p_price = ? WHERE p_id =? ");
    $statement->execute(array($p_price_dec,$id));
    $success_message = "Price Decrement has been successfully Removed.";
    
  
  }
  
  catch(Exception $e) {
    $error_message = $e->getMessage();
  }


}

?>

<?php 
if(isset($_POST['form_product_increment'])) {

  $id = $_REQUEST['pinid'];
  try {
  
    $p_cartoon_entry = $_POST['p_cartoon_entry'];
    $p_peice_entry = $_POST['p_peice_entry'];

    if(empty($_POST['inc_address'])) {
      throw new Exception("Address can not be empty");
      
    }
    else {
      $inc_address = $_POST['inc_address'];
    }

    if(empty($_POST['carton_number'])) {
      throw new Exception("Peice Number can not be empty");
      
    }
    else {
      $peice_number = $_POST['carton_number'];
    }




    $p_date = date('Y-m-d');
    $p_year = substr($p_date,0,4);
    $p_month = substr($p_date,5,2);
    $p_day = substr($p_date,8,2);


    $statement = $db->prepare("INSERT INTO product_increment (p_cartoon,p_peice,p_id,p_date,inc_address,p_day,p_month,p_year) VALUES (?,?,?,?,?,?,?,?)");
    
    $statement->execute(array($_POST['p_cartoon_entry'],$_POST['p_peice_entry'],$id,$p_date,$inc_address,$p_day,$p_month,$p_year));
    $success_message = "Product Increment has been successfully added.";

    
    $statement = $db->prepare("SELECT * FROM table_products WHERE p_id=?");
    $statement->execute(array($id));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row)
    {
      $p_cartoon = $row['p_cartoon'];
      $p_peice = $row['p_peice'];
    }

    
    if($peice_number == 1 ) {
      $p_peice = $p_peice + $p_peice_entry ;
    } else  {

      $p_cartoon = $p_cartoon + $p_cartoon_entry;
      $p_peice = $p_peice + $p_peice_entry;

      if ($p_peice >= $peice_number){
        $p_cartoon = $p_cartoon + 1 ;
        $p_peice = $p_peice - $peice_number ;
      }

    }
  


    $statement = $db->prepare("UPDATE table_products SET  p_cartoon = ? , p_peice = ? WHERE p_id =? ");
    $statement->execute(array($p_cartoon,$p_peice,$id));
    
  
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
  
    $p_cartoon_entry = $_POST['p_cartoon_entry'];
    $p_peice_entry = $_POST['p_peice_entry'];

    if(empty($_POST['dec_address'])) {
      throw new Exception("Address value can not be empty");
      
    }
    else {
      $dec_address = $_POST['dec_address'];
    }

    if(empty($_POST['carton_number'])) {
      throw new Exception("Peice Number can not be empty");
      
    }
    else {
      $peice_number = $_POST['carton_number'];
    }


    $p_date = date('Y-m-d');
    $p_year = substr($p_date,0,4);
    $p_month = substr($p_date,5,2);
    $p_day = substr($p_date,8,2);


    $statement = $db->prepare("INSERT INTO product_decrement (p_cartoon,p_peice,p_id,p_date,dec_address,p_day,p_month,p_year) VALUES (?,?,?,?,?,?,?,?)");
    
    $statement->execute(array($_POST['p_cartoon_entry'],$_POST['p_peice_entry'],$id,$p_date,$dec_address,$p_day,$p_month,$p_year));
    $success_message = "Product Decrement has been successfully Removed.";



    $statement = $db->prepare("SELECT * FROM table_products WHERE p_id=?");
    $statement->execute(array($id));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row)
    {
      $p_cartoon = $row['p_cartoon'];
      $p_peice = $row['p_peice'];
    }

    if($peice_number == 1 ) {
      $p_peice = $p_peice - $p_peice_entry ; 
    } else { 
      $p_cartoon = $p_cartoon - $p_cartoon_entry ; 

      if($p_peice_entry > $p_peice) {
        $p_cartoon = $p_cartoon - 1 ;
        $p_peice = $p_peice + $peice_number;
        $p_peice = $p_peice - $p_peice_entry ; 
      } else {
        $p_peice = $p_peice - $p_peice_entry ;
      }

    }

    $statement = $db->prepare("UPDATE table_products SET  p_cartoon = ? , p_peice = ?  WHERE p_id =? ");
    $statement->execute(array($p_cartoon,$p_peice,$id));
    
  
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
      throw new Exception("Title can not be empty.");
    }
    
    if(empty($_POST['com_id'])) {
      throw new Exception("Company Name can not be Selected.");
    }   
    
    if(empty($_POST['cat_id'])) {
      throw new Exception("Category Name can not be Selected.");
    }
    
    if(empty($_POST['size_id'])) {
      throw new Exception("Size can not be Selected.");
    }

    
    if(empty($_FILES["p_image"]["name"])) {
            
      $statement = $db->prepare("UPDATE table_products SET p_name=?, com_id=?, cat_id=?, size_id=? , p_cartoon = ? , p_peice = ?  WHERE p_id =? ");
      $statement->execute(array($_POST['p_name'],$_POST['com_id'],$_POST['cat_id'],$_POST['size_id'],$_POST['p_cartoon'],$_POST['p_peice'],$id));
      
    }
    else {
      
      $up_filename=$_FILES["p_image"]["name"];
      $file_basename = substr($up_filename, 0, strripos($up_filename, '.')); 
      $file_ext = substr($up_filename, strripos($up_filename, '.'));
      $f1 = $id . $file_ext;
    
      if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
        throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
      
      
      $statement = $db->prepare("SELECT * FROM table_products WHERE p_id=?");
      $statement->execute(array($id));
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      foreach($result as $row)
      {
        $real_path = "../dist/img/product-images/".$row['p_image'];
        unlink($real_path);
      }
      move_uploaded_file($_FILES["p_image"]["tmp_name"],"../dist/img/product-images/" . $f1);
      
      
      $statement = $db->prepare("UPDATE table_products SET p_name=?, com_id=?, cat_id=?, size_id=? , p_cartoon = ? , p_peice = ? , p_image = ? WHERE p_id = ? ");
      $statement->execute(array($_POST['p_name'],$_POST['com_id'],$_POST['cat_id'],$_POST['size_id'],$_POST['p_cartoon'],$_POST['p_peice'],$f1,$id));
      
    }
    
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