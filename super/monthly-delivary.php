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
	        <h3 class="box-title">Monthly Delivary Product</h3>
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
          <h3 class="box-title"><?php echo $month_full ;?>-<?php echo $p_year ; ?></h3>
        </div><!-- /.box-header -->
        <div class="box-body">
         <div class="table-responsive">  
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Date(Y-M-D)</th>
                <th>Company</th>
                <th>Size</th>
                <th>Carton</th>
                <th>Piece</th>
                <th>Delivary Address</th>
              </tr>
            </thead>

            <tbody>

                <?php
                $i=0;
                $statement = $db->prepare("SELECT * FROM product_decrement WHERE p_year = ? AND p_month = ? ORDER BY dec_id ASC");
                $statement->execute(array($p_year,$p_month));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row)
                {
                    $i++;
                    $p_date = $row['p_date'];
                    ?>

                    <tr>
                        <td><?php echo $i ; ?></td>
                        <?php 
                        $statement1 = $db->prepare("SELECT p_name , com_id , size_id FROM table_products WHERE p_id = ?");
                        $statement1->execute(array($row['p_id']));
                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result1 as $row1) {
                            $product_name = $row1['p_name'];
                            $com_id = $row1['com_id'];
                            $size_id = $row1['size_id'];
                            
                        ?>
                        
                        <td><?php echo $product_name; ?></td>
                        <td><?php echo $p_date; ?></td>
                        <?php
                        $statement2 = $db->prepare("SELECT com_name FROM table_companies WHERE com_id = ?");
						$statement2->execute(array($com_id));
						$company_name = $statement2->fetch()["com_name"];
						?>
						<td><?php echo $company_name; ?></td>
						<?php
                        $statement3 = $db->prepare("SELECT size_name FROM table_sizes WHERE size_id = ?");
						$statement3->execute(array($size_id));
						$size_name = $statement3->fetch()["size_name"];
						?>
						<td><?php echo $size_name; ?></td>
						<?php
                        }
                        ?>

                        <td><?php echo $row['p_cartoon']; ?></td>
                        <td><?php echo $row['p_peice']; ?></td>
                        <td><?php echo $row['dec_address']; ?></td>
                    </tr>
                <?php 
                }
                ?>
            </tbody>
	            
	<tfoot>
	   <tr>
        <th>No.</th>
        <th>Name</th>
        <th>Date(Y-M-D)</th>
        <th>Company</th>
        <th>Size</th>
        <th>Carton</th>
        <th>Piece</th>
        <th>Delivary Address</th>
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