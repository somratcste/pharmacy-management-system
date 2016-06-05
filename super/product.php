<?php 
ob_start();
session_start();
if($_SESSION['name']!='www.somrat.info')
{
  header('location: index.php');
}
include("header.php"); 
include("../connection.php");
include ("left-sidebar-set.php") ; 
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
  
  $success_message2 = "Product has been deleted successfully.";
  
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
        $real_path = "dist/img/product-images/".$row['p_image'];
        unlink($real_path);
      }
      move_uploaded_file($_FILES["p_image"]["tmp_name"],"dist/img/product-images/" . $f1);
      
      
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
  <section class="content">

    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Add New Product </h3>
          </div><!-- /.box-header -->
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
          
          <!-- form start -->
          <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Product Code</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="inputEmail3" placeholder="Insert Product Name" name="p_name">
                </div>
              </div>

              <div class="form-group">
              <label for="inputEmail3" class="col-sm-3 control-label">Select Company</label>
              <div class="col-sm-6">
                <select class="form-control" name="com_id">
                <option value="">Select A Company</option>
                <?php

                $statement = $db->prepare("SELECT * FROM table_companies");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($result as $row) { ?>


                    <option value="<?php echo $row['com_id']; ?>"><?php echo $row['com_name'] ; ?></option>

                    <?php
                  
                    }

                ?>
              </select>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-3 control-label">Select Category</label>
              <div class="col-sm-6">
                <select class="form-control" name="cat_id">
                <option value="">Select A Category</option>
                 <?php

                  $statement = $db->prepare("SELECT * FROM table_categories");
                  $statement->execute();
                  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) { ?>


                      <option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_name'] ; ?></option>

                      <?php
                    
                      }

                  ?>
              </select>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-3 control-label">Select Size </label>
              <div class="col-sm-6">
                <select class="form-control" name="size_id">
                <option value="">Select A Size</option>
                <?php

                $statement = $db->prepare("SELECT * FROM table_sizes");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($result as $row) { ?>


                    <option value="<?php echo $row['size_id']; ?>"><?php echo $row['size_name'] ; ?></option>

                    <?php
                  
                    }

                ?>
              </select>
              </div>
            </div>

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Upload Image </label>
                <div class="col-sm-6">
                  <input type="file" class="form-control" id="inputEmail3" placeholder="Insert Price" name="p_image">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Price </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="inputEmail3" placeholder="Insert Piece" name="p_price">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Product Cartoon </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="inputEmail3" placeholder="Insert Piece" name="p_cartoon">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Product Piece </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="inputEmail3" placeholder="Insert Piece" name="p_peice">
                </div>
              </div>



            </div><!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-info pull-right" name="form1">SUBMIT</button>
            </div><!-- /.box-footer -->
          </form>

          

        </div><!-- /.box -->
    </div>

    <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">View Latest Products </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                 <div class="table-responsive">  
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Action</th>
                        <th>Cartoon</th>
                        <th>Piece</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>

          <?php
        $i=0;
        $statement = $db->prepare("SELECT * FROM table_products ORDER BY p_id DESC LIMIT 20 ");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row)
        {
          $i++;
          ?>

            <tr>
              <td><?php echo $i ; ?></td>
                  <td><?php echo $row['p_name']; ?></td>
                  <td><?php echo $row['p_price']; ?></td>
                  <td><a href="" data-toggle="modal" data-target="#price_increment"><img src="../dist/img/price_up.png" alt="" title="" border="0" /></a> || <a href="" data-toggle="modal" data-target="#price_decrement" ><img src="../dist/img/price_down.png" alt="" title="" border="0" /></a> </td>

                  <!--price increment modal -->
                  <div class="modal fade" id="price_increment" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                                  <h5 class="modal-title">Increment Price</h5>
                              </div>

                              <div class="modal-body">
                                  <!-- The form is placed inside the body of modal -->
                            <!-- form start -->
                            <form class="form-horizontal" action="product.php?pid=<?php echo $row['p_id']; ?>" method="post" enctype="multipart/form-data">
                              <div class="box-body">
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Product Price (Tk.) </label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="0" name="p_price">
                                  </div>
                                </div>

                              </div><!-- /.box-body -->
                              <div class="box-footer">
                                
                                <button type="submit" class="btn btn-info pull-right" name="form_price_increment">UPDATE</button>
                              </div><!-- /.box-footer -->
                            </form>

                              </div>
                          </div>
                      </div>
                  </div>
                  <!--price increment modal End-->

                   <!--price decrement modal -->
                  <div class="modal fade" id="price_decrement" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                                  <h5 class="modal-title">Decrement Price</h5>
                              </div>

                              <div class="modal-body">
                                  <!-- The form is placed inside the body of modal -->
                            <!-- form start -->
                            <form class="form-horizontal" action="product.php?pid=<?php echo $row['p_id']; ?>" method="post" enctype="multipart/form-data">
                              <div class="box-body">
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Product Price (Tk.) </label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="0" name="p_price">
                                  </div>
                                </div>

                              </div><!-- /.box-body -->
                              <div class="box-footer">
                                
                                <button type="submit" class="btn btn-info pull-right" name="form_price_decrement">UPDATE</button>
                              </div><!-- /.box-footer -->
                            </form>

                              </div>
                          </div>
                      </div>
                  </div>
                  <!--price decrement modal End-->

                  <td><?php echo $row['p_cartoon']; ?></td>
                  <td><?php echo $row['p_peice']; ?></td>
                  <td><img src="../dist/img/view.jpg" data-toggle="modal" data-target="#viewModal<?php echo $i ; ?>"></td>


                  
                  <!--product view Modal -->
                  <div class="modal fade" id="viewModal<?php echo $i ; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel">View Product Details</h4>
                        </div>
                        <div class="modal-body">
                        <p><b>Product Name <span style="margin-left:4em"></span> :</b> <?php echo $row['p_name'] ; ?> </p>

                        <p><b>Selected Company <span style="margin-left:2em"></span> : </b>
                        <?php
                        $statement1 = $db->prepare("SELECT * FROM table_companies WHERE com_id=?");
                        $statement1->execute(array($row['com_id']));
                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result1 as $row1)
                        {
                          echo $row1['com_name'];
                        }
                        ?>
                        </p> 

                        <p><b>Selected Category<span style="margin-left:2.2em"></span> : </b>
                        <?php
                        $statement1 = $db->prepare("SELECT * FROM table_categories WHERE cat_id=?");
                        $statement1->execute(array($row['cat_id']));
                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result1 as $row1)
                        {
                          echo $row1['cat_name'];
                        }
                        ?>
                        </p>

                        <p><b>Selected Size<span style="margin-left:4.4em"></span> : </b>
                        <?php
                        $statement1 = $db->prepare("SELECT * FROM table_sizes WHERE size_id=?");
                        $statement1->execute(array($row['size_id']));
                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result1 as $row1)
                        {
                          echo $row1['size_name'];
                        }
                        ?>
                        </p>

                        <p><b>Price<span style="margin-left:7.9em"></span> : </b><?php echo $row['p_price']; ?> Tk/-</p>
                        <p><b>Featured Image</b><img src="../dist/img/product-images/<?php echo $row['p_image']; ?>" alt="" class="img-responsive" width="304" height="236"></p>
                        <p><b>Cartoon <span style="margin-left:6.7em"></span> : </b><?php echo $row['p_cartoon']; ?></p>
                        <p><b>Piece <span style="margin-left:7.9em"></span> : </b><?php echo $row['p_peice']; ?></p>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--End product view Modal -->
                   

                  <!-- <td><a href="product-edit.php?id=<?php //echo $row['p_id']; ?>" ><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit"><span class="glyphicon glyphicon-pencil"></span></button></a></td> -->

                  <td><button class="btn btn-primary" data-toggle="modal" data-target="#editModal<?php echo $i ; ?>">Edit</button></td>
<!--product edit modal -->
<div class="modal fade" id="editModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Update Infromation</h5>
            </div>

            <div class="modal-body">
                <!-- The form is placed inside the body of modal -->
 

         
       
          <div class="box-header with-border">
            <h3 class="box-title">Edit Product </h3>
          </div><!-- /.box-header -->
          
          <!-- form start -->
          <form class="form-horizontal" action="product.php?peditid=<?php echo $row['p_id']; ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Product Code</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="inputEmail3" value="<?php echo $row['p_name']; ?>" name="p_name">
                </div>
              </div>

              <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Select Company</label>
              <div class="col-sm-6">
                <select class="form-control" name="com_id">
                <option value="">Select A Company</option>
                <?php

                $statement1 = $db->prepare("SELECT * FROM table_companies");
                $statement1->execute();
                $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                foreach($result1 as $row1)
                  {

                    if($row1['com_id'] == $row['com_id'])
                    {
                      ?><option value="<?php echo $row1['com_id']; ?>" selected><?php echo $row1['com_name']; ?></option><?php
                    }
                    else
                    {
                      ?><option value="<?php echo $row1['com_id']; ?>"><?php echo $row1['com_name']; ?></option><?php
                    }
                      
                    
                    
                  }
                ?>
              </select>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Select Category</label>
              <div class="col-sm-6">
                <select class="form-control" name="cat_id">
                <option value="">Select A Category</option>
                 <?php

                  $statement1 = $db->prepare("SELECT * FROM table_categories");
                  $statement1->execute();
                  $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                  foreach($result1 as $row1)
                    {

                      if($row1['cat_id'] == $row['cat_id'])
                      {
                        ?><option value="<?php echo $row1['cat_id']; ?>" selected><?php echo $row1['cat_name']; ?></option><?php
                      }
                      else
                      {
                        ?><option value="<?php echo $row1['cat_id']; ?>"><?php echo $row1['cat_name']; ?></option><?php
                      }
                        
                      
                      
                    }
                  ?>
              </select>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Select Size </label>
              <div class="col-sm-6">
                <select class="form-control" name="size_id">
                <option value="">Select A Size</option>
                <?php

                  $statement1 = $db->prepare("SELECT * FROM table_sizes");
                  $statement1->execute();
                  $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                  foreach($result1 as $row1)
                    {

                      if($row1['size_id'] == $row['size_id'])
                      {
                        ?><option value="<?php echo $row1['size_id']; ?>" selected><?php echo $row1['size_name']; ?></option><?php
                      }
                      else
                      {
                        ?><option value="<?php echo $row1['size_id']; ?>"><?php echo $row1['size_name']; ?></option><?php
                      }
                        
                      
                      
                    }
                  ?>
              </select>
              </div>
            </div>

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Previous Image Preview </label>
                <div class="col-sm-6">
                  <img src="../dist/img/product-images/<?php echo $row['p_image']; ?>" alt="" class="img-responsive" width="304" height="236">
                </div>
              </div>

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Upload New Image</label>
                <div class="col-sm-6">
                  <input type="file" class="form-control" id="inputEmail3" placeholder="Insert Price" name="p_image">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Price </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="inputEmail3" value="<?php echo $row['p_price']; ?>" name="p_price">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Product Cartoon </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="inputEmail3" value="<?php echo $row['p_cartoon']; ?>" name="p_cartoon">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Product Piece </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="inputEmail3" value="<?php echo $row['p_peice']; ?>" name="p_peice">
                </div>
              </div>



            </div><!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-info pull-right" name="form_edit">UPDATE</button>
            </div><!-- /.box-footer -->
          </form>

        
       



            </div>
        </div>
    </div>
</div>
<!--Product edit modal end -->


                  <td><form method="POST" action="product.php?id=<?php echo $row['p_id']; ?>" accept-charset="UTF-8" style="display:inline"><button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete Product" data-message="Are you sure you want to delete ?"> <i class="glyphicon glyphicon-trash"></i> Delete</button></form></td>

                  <td><a href="" data-toggle="modal" data-target="#product_increment"><img src="../dist/img/plus.jpg" alt="" title="" border="0" /></a> || <a href="" data-toggle="modal" data-target="#product_decrement"><img src="../dist/img/minus.jpg" alt="" title="" border="0" /></a> </td>



                  <!--product increment modal -->
                  <div class="modal fade" id="product_increment" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                                  <h5 class="modal-title">Update Product </h5>
                              </div>

                              <div class="modal-body">
                          
                            <div class="box-header with-border">
                              <h3 class="box-title">Increment Product </h3>
                            </div><!-- /.box-header -->
                          
                            <!-- form start -->
                            <form class="form-horizontal" action="product.php?pinid=<?php echo $row['p_id']; ?>" method="post" enctype="multipart/formdata">

                              <div class="box-body">
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Product Cartoon </label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="0" name="p_cartoon_entry">
                                  </div>
                                </div> 

                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Product Piece </label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="0" name="p_peice_entry">
                                  </div>
                                </div> 

                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Entry Address </label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Memo No." name="inc_address">
                                  </div>
                                </div> 

                                <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Select Piece Number</label>
                                <div class="col-sm-6">
                                  <select  name="carton_number" class="form-control">
                                        <option value="">Select Piece Number</option>
                                        <option value="1">Door</option>
                                        

                                        <?php

                              $statement3 = $db->prepare("SELECT * FROM table_cartons");
                              $statement3->execute();
                              $result3 = $statement3->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result3 as $row3) { ?>


                                  <option value="<?php echo $row3['c_number']; ?>"><?php echo $row3['c_number'] ; ?></option>

                                  <?php
                                
                                  }

                              ?>

                                   </select>
                                </div>
                              </div>

                              </div><!-- /.box-body -->
                              <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right" name="form_product_increment">UPDATE</button>
                              </div><!-- /.box-footer -->
                            </form>
                            

                              </div>
                          </div>
                      </div>

                  </div>
                  <!--product increment modal End-->


                  <!--product decrement modal -->
                  <div class="modal fade" id="product_decrement" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                                  <h5 class="modal-title">Update Product </h5>
                              </div>

                              <div class="modal-body">
                          
                            <div class="box-header with-border">
                              <h3 class="box-title">Decrement Product </h3>
                            </div><!-- /.box-header -->
                          
                            <!-- form start -->
                            <form class="form-horizontal" action="product.php?pdecid=<?php echo $row['p_id']; ?>"  method="post" enctype="multipart/formdata">
                              <div class="box-body">
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Product Cartoon </label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="0" name="p_cartoon_entry">
                                  </div>
                                </div> 

                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Product Piece </label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="0" name="p_peice_entry">
                                  </div>
                                </div> 

                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Entry Address </label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Memo No." name="dec_address">
                                  </div>
                                </div> 

                                <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Select Piece Number</label>
                                <div class="col-sm-6">
                                  <select  name="carton_number" class="form-control">
                                        <option value="">Select Piece Number</option>
                                        <option value="1">Door</option>
                                        

                                        <?php

                              $statement = $db->prepare("SELECT * FROM table_cartons");
                              $statement->execute();
                              $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) { ?>


                                  <option value="<?php echo $row['c_number']; ?>"><?php echo $row['c_number'] ; ?></option>

                                  <?php
                                
                                  }

                              ?>

                                   </select>
                                </div>
                              </div>

                              </div><!-- /.box-body -->
                              <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right" name="form_product_decrement">UPDATE</button>
                              </div><!-- /.box-footer -->
                            </form>
                            

                              </div>
                          </div>
                      </div>
                  </div>
                  <!--product decrement modal End-->

              </tr>
              
          <?php

            }

          ?>
        
              
          </tbody>
                    
        <tfoot>
           <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Price</th>
            <th>Action</th>
            <th>Cartoon</th>
            <th>Piece</th>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Action</th>
          </tr>
        </tfoot>
      </table>
    </div><!-- /.box-body -->
    </div>
  </div><!-- /.box -->
</div>
</div>



  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ("footer.php"); ?>