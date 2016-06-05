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

if(!isset($_REQUEST['id'])) {
	header("location:product-details.php");
}
else {
	$id = $_REQUEST['id'];
}
?>

<div class="content-wrapper">
  <section class="content">
  	<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div align="center" class="box-header with-border">

            <?php
				$statement = $db->prepare("SELECT * FROM table_products WHERE p_id = $id");
				$statement->execute(array($id));
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach ($result as $row) {
					$com_id = $row['com_id'];
					$cat_id = $row['cat_id'];
					$size_id = $row['size_id'];
					$p_name = $row['p_name'];
				}
			?>

			<?php 
				$statement = $db->prepare("SELECT com_name FROM table_companies WHERE com_id = ?");
				$statement->execute(array($com_id));
				$com_name = $statement->fetch()["com_name"]; 
			?>
			<?php 
				$statement = $db->prepare("SELECT cat_name FROM table_categories WHERE cat_id = ?");
				$statement->execute(array($cat_id));
				$cat_name = $statement->fetch()["cat_name"]; 
			?>
			<?php 
				$statement = $db->prepare("SELECT size_name FROM table_sizes WHERE size_id = ?");
				$statement->execute(array($size_id));
				$size_name = $statement->fetch()["size_name"]; 
			?>
				 <h2 class="box-title">Product Entry Reports </h2> <hr />
                 <h3 class="box-title"><?php echo $com_name ;?> / <?php echo $cat_name ;?> / <?php echo $size_name ; ?> / <?php echo $p_name ; ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                 <div class="table-responsive">  
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Date</th>                     
                        <th>Cartoon</th>
                        <th>Piece</th>
                        <th>Entry Address</th>
                      </tr>
                    </thead>

                   <tbody>

                <?php
                $i=0;
                $statement = $db->prepare("SELECT * FROM product_increment WHERE p_id = ? ORDER BY inc_id ASC");
                $statement->execute(array($id));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $row)
                {
                    $i++;
                    ?>

                    <tr>
                        <td><?php echo $i ; ?></td>
                        <td><?php echo $row['p_date']; ?></td>
                        <td><?php echo $row['p_cartoon']; ?></td>
                        <td><?php echo $row['p_peice']; ?></td>
                        <td><?php echo $row['inc_address']; ?></td>
                    </tr>
                <?php 
                }
                ?>
                </tbody>




         <tfoot>
           <tr>
            <th>No.</th>
            <th>Date</th>                     
            <th>Cartoon</th>
            <th>Piece</th>
            <th>Entry Address</th>
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