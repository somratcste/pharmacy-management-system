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

if(isset($_POST['p_year']) & isset($_POST['p_month']) & isset($_POST['p_day'])) {
	$p_year = $_POST['p_year'];
	$p_month = $_POST['p_month'];
	$p_day = $_POST['p_day'];
}


?>

<div class="content-wrapper">
  <section class="content">

  	<div class="box box-default">
	  <div class="box box-info">
	      <div class="box-header with-border">
	        <center><h3 class="box-title">Daily Entry Product</h3></center>
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
          <center><h3 class="box-title"><?php echo $p_day;?>-<?php echo $month_full ;?>-<?php echo $p_year ; ?></h3></center>
        </div><!-- /.box-header -->
        <div class="box-body">
         <div class="table-responsive">  
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Company</th>
                <th>Piece</th>
                <th>Purchase Price</th>
                <th>Total Price</th>
                <th>Memo No.</th>
              </tr>
            </thead>

            <tbody>

                <?php
                $i=0;
                $totalPurchasePrice = 0 ;
                $totalSellingPrice = 0 ;
                $statement = $db->prepare("SELECT * FROM product_increment WHERE p_year = ? AND p_month = ? AND p_day = ? ORDER BY inc_id DESC");
                $statement->execute(array($p_year,$p_month,$p_day));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row)
                {
                    $i++;
                    ?>

                    <tr>
                        <td><?php echo $i ; ?></td>
                        <?php 
                        $statement1 = $db->prepare("SELECT *  FROM table_products WHERE productCode = ?");
						$statement1->execute(array($row['p_id']));
						$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
						foreach($result1 as $row1) {
							$product_name = $row1['productName'];
							$com_id = $row1['com_id'];
                            $purchase_price = $row1['buyPrice'];
						?>
						
                        <td><?php echo $product_name; ?></td>
                        <?php
                        $statement2 = $db->prepare("SELECT com_name FROM table_companies WHERE com_id = ?");
						$statement2->execute(array($com_id));
						$company_name = $statement2->fetch()["com_name"];
						?>
						<td><?php echo $company_name; ?></td>
						<?php
                        }
                        ?>
                        <td><?php echo $row['p_peice']; ?></td>
                        <td><?php echo $purchase_price; ?></td>
                        <?php $totalPurchasePrice += $purchase_price * $row['p_peice'] ; ?>
                        <td><?php echo $purchase_price * $row['p_peice'] ; ?></td>
                        <td><?php echo $row['memo_no']; ?></td>
                    </tr>
                <?php 
                }
                ?>
            </tbody>
	            
	<tfoot>
	   <tr>
        <th>No.</th>
        <th>Name</th>
        <th>Company</th>
        <th>Piece</th>
        <th>Purchase Price</th>
        <th>Total Price</th>
        <th>Memo No.</th>
      </tr>
	</tfoot>
	</table>
	</div><!-- /.box-body -->

	</div>
	</div><!-- /.box -->
	</div>
	</div> <!--row -->


    <div class="box box-default">
      <div class="box box-info">
          <div class="box-header with-border">
            <center><h3 class="box-title">Daily Delivary Product</h3></center>
          </div><!-- /.box-header -->
          
      </div><!-- /.box -->
    </div>


    <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <center><h3 class="box-title"><?php echo $p_day;?>-<?php echo $month_full ;?>-<?php echo $p_year ; ?></h3></center>
        </div><!-- /.box-header -->
        <div class="box-body">
         <div class="table-responsive">  
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Company</th>
                <th>Piece</th>
                <th>Selling Price</th>
                <th>Total Price</th>
                <th>Memo No.</th>
              </tr>
            </thead>

            <tbody>

                <?php
                $i=0;
                $statement = $db->prepare("SELECT * FROM product_decrement WHERE p_year = ? AND p_month = ? AND p_day = ? ORDER BY dec_id DESC");
                $statement->execute(array($p_year,$p_month,$p_day));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row)
                {
                    $i++;
                    ?>

                    <tr>
                        <td><?php echo $i ; ?></td>
                        <?php 
                        $statement1 = $db->prepare("SELECT *  FROM table_products WHERE productCode = ?");
                        $statement1->execute(array($row['p_id']));
                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result1 as $row1) {
                            $product_name = $row1['productName'];
                            $com_id = $row1['com_id'];
                            $selling_price = $row1['sellPrice'];
                        ?>
                        
                        <td><?php echo $product_name; ?></td>
                        <?php
                        $statement2 = $db->prepare("SELECT com_name FROM table_companies WHERE com_id = ?");
                        $statement2->execute(array($com_id));
                        $company_name = $statement2->fetch()["com_name"];
                        ?>
                        <td><?php echo $company_name; ?></td>
                        <?php
                        }
                        ?>
                        <td><?php echo $row['p_peice']; ?></td>
                        <td><?php echo $selling_price; ?></td>
                        <?php $totalSellingPrice += $selling_price * $row['p_peice'] ; ?>
                        <td><?php echo $selling_price * $row['p_peice'] ; ?></td>
                        <td><?php echo $row['memo_no']; ?></td>
                    </tr>
                <?php 
                }
                ?>
            </tbody>
                
    <tfoot>
       <tr>
        <th>No.</th>
        <th>Name</th>
        <th>Company</th>
        <th>Piece</th>
        <th>Selling Price</th>
        <th>Total Price</th>
        <th>Memo No.</th>
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
    </div> <!--row -->


  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ("footer.php"); ?>