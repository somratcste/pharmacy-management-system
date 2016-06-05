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
    
    if(empty($_POST['cat_name'])) {
      throw new Exception("Category Name can not be empty.");
    }
    
    $statement = $db->prepare("SELECT * FROM table_categories WHERE cat_name=?");
    $statement->execute(array($_POST['cat_name']));
    $total = $statement->rowCount();
    
    if($total>0) {
      throw new Exception("Category Name already exists.");
    }

    
    $statement = $db->prepare("INSERT INTO table_categories (cat_name) VALUES (?)");
    $statement->execute(array($_POST['cat_name']));
    
    $success_message = "Category Name has been inserted successfully.";
    
  
  }
  
  catch(Exception $e) { 
    $error_message = $e->getMessage();
  }
} 


<?php 

$statement3 = $db->prepare("SELECT * FROM table_companies WHERE com_id = ?");
$statement3->execute(array($com_id));
$company_name = $statement3->fetch()["com_name"];

$statement3 = $db->prepare("SELECT * FROM table_categories WHERE cat_id = ?");
$statement3->execute(array($cat_id));
$category_name = $statement3->fetch()["cat_name"];

$statement3 = $db->prepare("SELECT * FROM table_sizes WHERE size_id = ?");
$statement3->execute(array($size_id));
$size_name = $statement3->fetch()["size_name"];

?>


<div class="content-wrapper">
  <section class="content">
  	<div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div align="center" class="box-header with-border">
                  <h3 class="box-title"><?php echo $company_name; ?> / <?php echo $category_name; ?> / <?php echo $size_name; ?></h3>
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
        $statement = $db->prepare("SELECT * FROM table_products WHERE com_id = ? AND cat_id = ? AND size_id = ? ORDER BY p_id DESC");
        $statement->execute(array($com_id,$cat_id,$size_id));
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
                            <form class="form-horizontal" action="message.php?pid=<?php echo $row['p_id']; ?>" method="post" enctype="multipart/form-data">
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
                            <form class="form-horizontal" action="message.php?pid=<?php echo $row['p_id']; ?>" method="post" enctype="multipart/form-data">
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
          <form class="form-horizontal" action="message.php?peditid=<?php echo $row['p_id']; ?>" method="post" enctype="multipart/form-data">
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


                  <td><form method="POST" action="message.php?id=<?php echo $row['p_id']; ?>" accept-charset="UTF-8" style="display:inline"><button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete Product" data-message="Are you sure you want to delete ?"> <i class="glyphicon glyphicon-trash"></i> Delete</button></form></td>

                  <td><a href="" data-toggle="modal" data-target="#product_increment<?php echo $i; ?>"><img src="../dist/img/plus.jpg" alt="" title="" border="0" /></a> || <a href="" data-toggle="modal" data-target="#product_decrement<?php echo $i; ?>"><img src="../dist/img/minus.jpg" alt="" title="" border="0" /></a> </td>



                  <!--product increment modal -->
                  <div class="modal fade" id="product_increment<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
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
                            <form class="form-horizontal" action="message.php?pinid=<?php echo $row['p_id']; ?>" method="post" enctype="multipart/formdata">

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
                  <div class="modal fade" id="product_decrement<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
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
                            <form class="form-horizontal" action="message.php?pdecid=<?php echo $row['p_id']; ?>"  method="post" enctype="multipart/formdata">
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