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

if(isset($_POST['p_year']) & isset($_POST['p_month'])) {
    $p_year = $_POST['p_year'];
    $p_month = $_POST['p_month'];
}


?>

<div class="content-wrapper">
  <section class="content">

  	<div class="box box-default">
	  <div class="box box-info">
	      <div class="box-header with-border">
	        <center><h3 class="box-title">Monthly Entry Product</h3></center>
	      </div><!-- /.box-header -->	      
	  </div><!-- /.box -->
	</div>


	<div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
        	<?php
			    if($p_month=='01') {$month_full="January";}
			    if($p_month=='02') {$month_full="February";}
			    if($p_month=='03') {$month_full="March";}
			    if($p_month=='04') {$month_full="April";}
			    if($p_month=='05') {$month_full="May";}
			    if($p_month=='06') {$month_full="June";}
			    if($p_month=='07') {$month_full="July";}
			    if($p_month=='08') {$month_full="August";}
			    if($p_month=='09') {$month_full="September";}
			    if($p_month=='10') {$month_full="October";}
			    if($p_month=='11') {$month_full="November";}
			    if($p_month=='12') {$month_full="December";}
			?>
        <center><h3 class="box-title"><?php echo $month_full ;?>-<?php echo $p_year ; ?></h3></center>
        </div><!-- /.box-header -->
        <div class="box-body">
         <div class="table-responsive">  
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
        <th>No.</th>
        <th>P. Name</th>
        <th>Company</th>
        <th>Piece</th>
        <th>Purchase Price</th>
        <th>Total Price</th>
        <th>Date(Y-M-D)</th>
      </tr>
            </thead>

            <tbody>

                <?php
                $i=0;
                $totalPurchasePrice = 0 ;
                $statement = $db->prepare("SELECT * from table_products INNER JOIN product_increment ON product_increment.p_id = table_products.productCode WHERE product_increment.p_month = ? AND product_increment.p_year = ? ");
                $statement->execute(array($p_month,$p_year));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row)
                {                    
                 $i++;
                ?>
                <tr>
                    <td><?php echo $i ; ?></td>
                    <td><?php echo $row['productName']; ?></td>
                    <?php
                    $statement2 = $db->prepare("SELECT com_name FROM table_companies WHERE com_id = ?");
                    $statement2->execute(array($row['com_id']));
                    $company_name = $statement2->fetch()["com_name"];
                    ?>
                    <td><?php echo $company_name; ?></td>
                    <td><?php echo $row['p_peice']; ?></td>
                    <td><?php echo $row['buyPrice']; ?></td>                                   
                    <td><?php echo $row['buyPrice'] * $row['p_peice']; ?></td>     
                    <?php $totalPurchasePrice += $row['buyPrice'] * $row['p_peice']; ?>    
                    <td><?php echo $row['p_date']; ?></td>            
                </tr>
                <?php 
                }
                ?>
            </tbody>
	            
	<tfoot>
	   <tr>
        <th>No.</th>
        <th>P. Name</th>
        <th>Company</th>
        <th>Piece</th>
        <th>Purchase Price</th>
        <th>Total Price</th>
        <th>Date(Y-M-D)</th>
      </tr>
	</tfoot>
	</table>
	</div><!-- /.box-body -->
	</div>
	</div><!-- /.box -->
	</div>
	</div>


  <div class="box box-default">
    <div class="box box-info">
        <div class="box-header with-border">
          <center><h3 class="box-title">Monthly Delivary Product</h3></center>
        </div><!-- /.box-header -->       
    </div><!-- /.box -->
  </div>


  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <?php
          if($p_month=='01') {$month_full="January";}
          if($p_month=='02') {$month_full="February";}
          if($p_month=='03') {$month_full="March";}
          if($p_month=='04') {$month_full="April";}
          if($p_month=='05') {$month_full="May";}
          if($p_month=='06') {$month_full="June";}
          if($p_month=='07') {$month_full="July";}
          if($p_month=='08') {$month_full="August";}
          if($p_month=='09') {$month_full="September";}
          if($p_month=='10') {$month_full="October";}
          if($p_month=='11') {$month_full="November";}
          if($p_month=='12') {$month_full="December";}
      ?>
        <center><h3 class="box-title"><?php echo $month_full ;?>-<?php echo $p_year ; ?></h3></center>
        </div><!-- /.box-header -->
        <div class="box-body">
         <div class="table-responsive">  
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
        <th>No.</th>
        <th>P. Name</th>
        <th>Company</th>
        <th>Piece</th>
        <th>Selling Price</th>
        <th>Total Price</th>
        <th>Date(Y-M-D)</th>
      </tr>
            </thead>

            <tbody>

                <?php
                $i=0;
                $totalSellingPrice = 0 ;
                $statement = $db->prepare("SELECT * from table_products INNER JOIN product_decrement ON product_decrement.p_id = table_products.productCode WHERE product_decrement.p_month = ? AND product_decrement.p_year = ? ");
                $statement->execute(array($p_month,$p_year));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row)
                {                    
                 $i++;
                ?>
                <tr>
                    <td><?php echo $i ; ?></td>
                    <td><?php echo $row['productName']; ?></td>
                    <?php
                    $statement2 = $db->prepare("SELECT com_name FROM table_companies WHERE com_id = ?");
                    $statement2->execute(array($row['com_id']));
                    $company_name = $statement2->fetch()["com_name"];
                    ?>
                    <td><?php echo $company_name; ?></td>
                    <td><?php echo $row['p_peice']; ?></td>
                    <td><?php echo $row['sellPrice']; ?></td>                                   
                    <td><?php echo $row['sellPrice'] * $row['p_peice']; ?></td>     
                    <?php $totalSellingPrice += $row['sellPrice'] * $row['p_peice']; ?>    
                    <td><?php echo $row['p_date']; ?></td>            
                </tr>
                <?php 
                }
                ?>
            </tbody>
              
  <tfoot>
     <tr>
        <th>No.</th>
        <th>P. Name</th>
        <th>Company</th>
        <th>Piece</th>
        <th>Purchase Price</th>
        <th>Total Price</th>
        <th>Date(Y-M-D)</th>
      </tr>
  </tfoot>
  </table>
  </div><!-- /.box-body -->
      <div class="col-md-6 pull-right">
        <table id="example2" class="table table-bordered table-hover">
            <tbody>
                <tr>
                    <th>Total Purchase Price</th>
                    <td><?php echo $totalPurchasePrice ; ?> /-</td>
                </tr>
                <tr>
                    <th>Total Selling Price</th>
                    <td><?php echo $totalSellingPrice; ?> /-</td>
                </tr>
                <tr>
                <?php if($totalPurchasePrice > $totalSellingPrice) {?>
                    <th>Total Loss</th>
                    <td><?php echo $total = $totalPurchasePrice - $totalSellingPrice ; ?> Tk.</td>
                <?php } else { ?>
                    <th>Total Profit</th>
                    <td><?php echo $total = $totalSellingPrice - $totalPurchasePrice ; ?> Tk.</td>
                <?php } ?>
                </tr>
            </tbody>
        </table>
        </div>
  </div>
  </div><!-- /.box -->
  </div>
  </div>


  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ("footer.php"); ?>