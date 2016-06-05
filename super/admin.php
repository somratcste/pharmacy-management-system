<?php include ("header.php") ; ?>
<?php include ("../connection.php"); ?>
<?php include ("left-sidebar.php") ; ?>

<?php

$statement = $db->prepare("SELECT * FROM table_companies");
$statement->execute(array());
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$compnay_number = 0 ;
  foreach ($result as $row) {
    $compnay_number++;
    }


$statement = $db->prepare("SELECT * FROM table_categories");
$statement->execute(array());
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$category_number = 0 ;
  foreach ($result as $row) {
    $category_number++;
    }

$statement = $db->prepare("SELECT * FROM table_sizes");
$statement->execute(array());
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$size_number = 0 ;
  foreach ($result as $row) {
    $size_number++;
    }

$statement = $db->prepare("SELECT * FROM table_products");
$statement->execute(array());
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$product_number = 0 ;
  foreach ($result as $row) {
    $product_number++;
    }
?>


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Haque Agencies</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->


           <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Company</span>
                  <span class="info-box-number"><?php echo $compnay_number ; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Category</span>
                  <span class="info-box-number"><?php echo $category_number ; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Size</span>
                  <span class="info-box-number"><?php echo $size_number ; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Products</span>
                  <span class="info-box-number"><?php echo $product_number ; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- =========================================================== -->

          

        




        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
    
<?php include ("footer.php"); ?>