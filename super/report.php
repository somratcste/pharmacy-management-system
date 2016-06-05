<?php
ob_start();
session_start();
if($_SESSION['name']!='www.somrat.info')
{
  header('location: index.php');
} 
include("header.php"); 
include("../connection.php");
include("left-sidebar-set.php");


?>


<div class="content-wrapper">
  <section class="content">

    <!-- SELECT2 EXAMPLE -->

 <div class="box box-default">
  <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Product Report </h3>
      </div><!-- /.box-header -->
      <div class="box-body">
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
      </div>
  </div><!-- /.box -->
</div>
   

   <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12"  data-toggle="modal" data-target="#editModalDailyEntry">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-wrench"></i></span>
        <div class="info-box-content">
          <span class="info-box-text"></span>
          <span class="info-box-number">Daily Entry</span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->

    <div class="modal fade" id="editModalDailyEntry" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  <h5 class="modal-title">Entry Product</h5>
              </div>

              <div class="modal-body">
                  <!-- The form is placed inside the body of modal -->      
            <div class="box-header with-border">
              <h3 class="box-title">Daily Entry Product</h3>
            </div><!-- /.box-header -->
            
            <form class="form-horizontal" action="entry-day.php" method="post" enctype="multipart/formdata">
                <div class="box-body">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Year </label>
                    <div class="col-sm-6">
                      <select name="p_year" class="form-control" required>
                            <option value="">Select A Year</option>
                            
                          <?php

                        $statement = $db->prepare("SELECT DISTINCT(p_year) FROM product_increment ");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          foreach ($result as $row) { ?>


                            <option value="<?php echo $row['p_year']; ?>"><?php echo $row['p_year'] ; ?></option>

                            <?php
                          
                            }

                        ?>

                     </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Month </label>
                    <div class="col-sm-6">
                      <select  name="p_month" class="form-control" required> 
                          <option value="">Select A Month</option>
                            
                        <?php

                        $statement = $db->prepare("SELECT DISTINCT(p_month) FROM product_increment ");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          foreach ($result as $row) { 

                            $month = $row['p_month'];
                            if($month=='01') {$month_full="January";}
                              if($month=='02') {$month_full="February";}
                              if($month=='03') {$month_full="March";}
                              if($month=='04') {$month_full="April";}
                              if($month=='05') {$month_full="May";}
                              if($month=='06') {$month_full="June";}
                              if($month=='07') {$month_full="July";}
                              if($month=='08') {$month_full="August";}
                              if($month=='09') {$month_full="September";}
                              if($month=='10') {$month_full="October";}
                              if($month=='11') {$month_full="November";}
                              if($month=='12') {$month_full="December";}
                            ?>


                            <option value="<?php echo $row['p_month']; ?>"><?php echo $month_full ; ?></option>

                            <?php
                          
                            }

                        ?>

                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Day </label>
                    <div class="col-sm-6">
                      <select class="form-control" name="p_day" required>
                          <option value="">Select A Day</option>
                            

                        <?php

                        $statement = $db->prepare("SELECT DISTINCT(p_day) FROM product_increment ");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          foreach ($result as $row) { ?>


                            <option value="<?php echo $row['p_day']; ?>"><?php echo $row['p_day'] ; ?></option>

                            <?php
                          
                            }

                        ?>

                      </select>
                    </div>
                  </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-info pull-right" name="form_daily_entry">SUBMIT</button>
                </div><!-- /.box-footer -->
              </form>

            </div>
          </div>
      </div>
    </div>
  


    <div class="col-md-6 col-sm-6 col-xs-12"  data-toggle="modal" data-target="#editModalDailyDelivary">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-wrench"></i></span>
        <div class="info-box-content">
          <span class="info-box-text"></span>
          <span class="info-box-number">Daily Delivary</span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->

    <div class="modal fade" id="editModalDailyDelivary" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  <h5 class="modal-title">Product Delivary</h5>
              </div>

              <div class="modal-body">
                  <!-- The form is placed inside the body of modal -->      
            <div class="box-header with-border">
              <h3 class="box-title">Daily Delivary Product</h3>
            </div><!-- /.box-header -->
            
           <form class="form-horizontal" action="delivary-day.php" method="post" enctype="multipart/formdata" enctype="multipart/formdata">
                <div class="box-body">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Year </label>
                    <div class="col-sm-6">
                      <select name="p_year" class="form-control" required>
                            <option value="">Select A Year</option>
                            
                          <?php

                        $statement = $db->prepare("SELECT DISTINCT(p_year) FROM product_decrement ");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          foreach ($result as $row) { ?>


                            <option value="<?php echo $row['p_year']; ?>"><?php echo $row['p_year'] ; ?></option>

                            <?php
                          
                            }

                        ?>

                     </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Month </label>
                    <div class="col-sm-6">
                      <select  name="p_month" class="form-control" required>
                          <option value="">Select A Month</option>
                            
                        <?php

                        $statement = $db->prepare("SELECT DISTINCT(p_month) FROM product_decrement ");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          foreach ($result as $row) { 

                            $month = $row['p_month'];
                            if($month=='01') {$month_full="January";}
                              if($month=='02') {$month_full="February";}
                              if($month=='03') {$month_full="March";}
                              if($month=='04') {$month_full="April";}
                              if($month=='05') {$month_full="May";}
                              if($month=='06') {$month_full="June";}
                              if($month=='07') {$month_full="July";}
                              if($month=='08') {$month_full="August";}
                              if($month=='09') {$month_full="September";}
                              if($month=='10') {$month_full="October";}
                              if($month=='11') {$month_full="November";}
                              if($month=='12') {$month_full="December";}
                            ?>


                            <option value="<?php echo $row['p_month']; ?>"><?php echo $month_full ; ?></option>

                            <?php
                          
                            }

                        ?>

                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Day </label>
                    <div class="col-sm-6">
                      <select class="form-control" name="p_day" required>
                          <option value="">Select A Day</option>
                            

                        <?php

                        $statement = $db->prepare("SELECT DISTINCT(p_day) FROM product_decrement ");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          foreach ($result as $row) { ?>


                            <option value="<?php echo $row['p_day']; ?>"><?php echo $row['p_day'] ; ?></option>

                            <?php
                          
                            }

                        ?>

                      </select>
                    </div>
                  </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-info pull-right" name="form_daily_delivary">SUBMIT</button>
                </div><!-- /.box-footer -->
              </form>

              </div>
          </div>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12"  data-toggle="modal" data-target="#editModalMonthlyEntry">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-wrench"></i></span>
        <div class="info-box-content">
          <span class="info-box-text"></span>
          <span class="info-box-number">Monthly Entry</span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->

    <div class="modal fade" id="editModalMonthlyEntry" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  <h5 class="modal-title">Entry Product</h5>
              </div>

              <div class="modal-body">
                  <!-- The form is placed inside the body of modal -->      
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Entry Product</h3>
            </div><!-- /.box-header -->
            
            <form class="form-horizontal" action="monthly-entry.php" method="post" enctype="multipart/formdata" enctype="multipart/formdata">
                <div class="box-body">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Year </label>
                    <div class="col-sm-6">
                      <select name="p_year" class="form-control" required>
                            <option value="">Select A Year</option>
                            
                          <?php

                        $statement = $db->prepare("SELECT DISTINCT(p_year) FROM product_increment ");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          foreach ($result as $row) { ?>


                            <option value="<?php echo $row['p_year']; ?>"><?php echo $row['p_year'] ; ?></option>

                            <?php
                          
                            }

                        ?>

                     </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Month </label>
                    <div class="col-sm-6">
                      <select  name="p_month" class="form-control" required>
                          <option value="">Select A Month</option>
                            
                        <?php

                        $statement = $db->prepare("SELECT DISTINCT(p_month) FROM product_increment ");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          foreach ($result as $row) { 

                            $month = $row['p_month'];
                            if($month=='01') {$month_full="January";}
                              if($month=='02') {$month_full="February";}
                              if($month=='03') {$month_full="March";}
                              if($month=='04') {$month_full="April";}
                              if($month=='05') {$month_full="May";}
                              if($month=='06') {$month_full="June";}
                              if($month=='07') {$month_full="July";}
                              if($month=='08') {$month_full="August";}
                              if($month=='09') {$month_full="September";}
                              if($month=='10') {$month_full="October";}
                              if($month=='11') {$month_full="November";}
                              if($month=='12') {$month_full="December";}
                            ?>


                            <option value="<?php echo $row['p_month']; ?>"><?php echo $month_full ; ?></option>

                            <?php
                          
                            }

                        ?>

                      </select>
                    </div>
                  </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-info pull-right" name="form_monthly_entry">SUBMIT</button>
                </div><!-- /.box-footer -->
              </form>

            </div>
          </div>
      </div>
    </div>
  


    <div class="col-md-6 col-sm-6 col-xs-12"  data-toggle="modal" data-target="#editModalMonthlyDelivary">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="glyphicon glyphicon-wrench"></i></span>
        <div class="info-box-content">
          <span class="info-box-text"></span>
          <span class="info-box-number">Monthly Delivary</span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->

    <div class="modal fade" id="editModalMonthlyDelivary" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  <h5 class="modal-title">Product Delivary</h5>
              </div>

              <div class="modal-body">
                  <!-- The form is placed inside the body of modal -->      
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Delivary Product</h3>
            </div><!-- /.box-header -->
            
           <form class="form-horizontal" action="monthly-delivary.php" method="post" enctype="multipart/formdata">
                <div class="box-body">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Year </label>
                    <div class="col-sm-6">
                      <select name="p_year" class="form-control" required>
                            <option value="">Select A Year</option>
                            
                          <?php

                        $statement = $db->prepare("SELECT DISTINCT(p_year) FROM product_decrement ");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          foreach ($result as $row) { ?>


                            <option value="<?php echo $row['p_year']; ?>"><?php echo $row['p_year'] ; ?></option>

                            <?php
                          
                            }

                        ?>

                     </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Month </label>
                    <div class="col-sm-6">
                      <select  name="p_month" class="form-control" required>
                          <option value="">Select A Month</option>
                            
                        <?php

                        $statement = $db->prepare("SELECT DISTINCT(p_month) FROM product_decrement ");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                          foreach ($result as $row) { 

                            $month = $row['p_month'];
                            if($month=='01') {$month_full="January";}
                              if($month=='02') {$month_full="February";}
                              if($month=='03') {$month_full="March";}
                              if($month=='04') {$month_full="April";}
                              if($month=='05') {$month_full="May";}
                              if($month=='06') {$month_full="June";}
                              if($month=='07') {$month_full="July";}
                              if($month=='08') {$month_full="August";}
                              if($month=='09') {$month_full="September";}
                              if($month=='10') {$month_full="October";}
                              if($month=='11') {$month_full="November";}
                              if($month=='12') {$month_full="December";}
                            ?>


                            <option value="<?php echo $row['p_month']; ?>"><?php echo $month_full ; ?></option>

                            <?php
                          
                            }

                        ?>

                      </select>
                    </div>
                  </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-info pull-right" name="form_delivary_monthly">SUBMIT</button>
                </div><!-- /.box-footer -->
              </form>

              </div>
          </div>
      </div>
    </div>
  </div>



</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ("footer.php"); ?>