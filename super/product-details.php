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
if (isset($_GET['com_id'])) {
    $com_id =  $_GET['com_id'];
} 
?>

<?php 

$statement3 = $db->prepare("SELECT * FROM table_companies WHERE com_id = ?");
$statement3->execute(array($com_id));
$company_name = $statement3->fetch()["com_name"];


?>


<div class="content-wrapper">
  <section class="content">
  	<div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div align="center" class="box-header with-border">
                  <h3 class="box-title"><?php echo $company_name; ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                 <div class="table-responsive">  
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Store Box</th>
                        <th>Piece</th>
                        <th>Purchase P.</th>                        
                        <th>Selling P.</th>
                        <th>Expire Date</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>

          <?php
        $i=0;
        $statement = $db->prepare("SELECT * FROM table_products WHERE com_id = ? ORDER BY productCode DESC");
        $statement->execute(array($com_id));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row)
        {
          $i++;
          ?>

            <tr>
              <td><?php echo $i ; ?></td>
                  <td><?php echo $row['productName']; ?></td>
                  <td>
                    <?php
                        $statement1 = $db->prepare("SELECT * FROM table_categories WHERE cat_id=?");
                        $statement1->execute(array($row['cat_id']));
                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result1 as $row1)
                        {
                          echo $row1['cat_name'];
                        }
                      ?>
                  </td>
                  <td><?php echo $row['quantityInStock']; ?></td>
                  <td><?php echo $row['buyPrice']; ?></td>
                  <td><?php echo $row['sellPrice']; ?></td>
                  

                  

                  <td><?php echo $row['e_date']; ?></td>
                  
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
                        <p><b>Product Name<span style="margin-left:4em"></span> :</b> <?php echo $row['productName'] ; ?> </p>

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

                        <p><b>Selected Store Box<span style="margin-left:2.2em"></span> : </b>
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

                        <p><b>Piece <span style="margin-left:8em"></span> : </b><?php echo $row['quantityInStock']; ?></p>
                        <p><b>Purchase Price<span style="margin-left:3.8em"></span> : </b><?php echo $row['buyPrice']; ?> Tk/-</p>
                        <p><b>Selling Price<span style="margin-left:5em"></span> : </b><?php echo $row['sellPrice']; ?> Tk/-</p>
                        
                        <p><b>Expire Date <span style="margin-left:5.4em"></span> : </b><?php echo $row['e_date']; ?></p>
                      
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--End product view Modal -->
                   

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
          <form class="form-horizontal" action="message.php?peditid=<?php echo $row['productCode']; ?>" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Product Name</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="inputEmail3" value="<?php echo $row['productName']; ?>" name="productName">
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
              <label for="inputEmail3" class="col-sm-4 control-label">Select Store Box</label>
              <div class="col-sm-6">
                <select class="form-control" name="cat_id">
                <option value="">Select A Box</option>
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
                <label for="inputEmail3" class="col-sm-4 control-label">Product Piece </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="inputEmail3" value="<?php echo $row['quantityInStock']; ?>" name="quantityInStock">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Purchase Price </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="inputEmail3" value="<?php echo $row['buyPrice']; ?>" name="buyPrice">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Selling Price </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="inputEmail3" value="<?php echo $row['sellPrice']; ?>" name="sellPrice">
                </div>
              </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Expire Date </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="inputEmail3" value="<?php echo $row['e_date']; ?>" name="e_date">
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


                  <td><form method="POST" action="message.php?id=<?php echo $row['productCode']; ?>" accept-charset="UTF-8" style="display:inline"><button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete Product" data-message="Are you sure you want to delete ?"> <i class="glyphicon glyphicon-trash"></i> Delete</button></form></td>

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
                            <form class="form-horizontal" action="message.php?pinid=<?php echo $row['productCode']; ?>" method="post" enctype="multipart/formdata">

                              <div class="box-body">
                                

                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Product Piece </label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="0" name="quantityInStock_entry">
                                  </div>
                                </div> 

                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Memo No.</label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Memo No." name="inc_address">
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
                            <form class="form-horizontal" action="message.php?pdecid=<?php echo $row['productCode']; ?>"  method="post" enctype="multipart/formdata">
                              <div class="box-body">

                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Product Piece </label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="0" name="quantityInStock_entry">
                                  </div>
                                </div> 

                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Memo No.</label>
                                  <div class="col-sm-6">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Memo No." name="dec_address">
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
              <th>Store Box</th>
              <th>Piece</th>
              <th>Purchase P.</th>                        
              <th>Selling P.</th>
              <th>Expire Date</th>
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