<?php 
ob_start();
session_start();
if($_SESSION['name']!='www.somrat.info')
{
  header('location: index.php');
}
include("head.php"); 
include("../connection.php");
?>

<div class="content-wrapper">
  <section class="content">
	<div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div align="center" class="box-header with-border">
          <h3 class="box-title">View All Memos</h3>
        </div><!-- /.box-header -->
      	<div class='box-body'>  
			<div class="table-responsive">          
			  <table class="table">
			    <thead>
			      <tr>
			        <th>S. No.</th>
			        <th>Memo No.</th>
			        <th>New</th>
			        <th>Return</th>
			        <th>Update Price</th>
			        <th>Print</th>
			        <th>Delete</th>
			      </tr>
			    </thead>
			    <tbody>
			     <?php
			        $i=0;
			        $statement = $db->prepare("SELECT * FROM memo_info ORDER BY info_id DESC");
			        $statement->execute(array());
			        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
			        foreach($result as $row)
			        {
			          $i++;
			          ?>

            	  <tr>
                    <td><?php echo $i ; ?></td>
			        <td><?php echo $row['memo_no'] ; ?></td>
			        <td><a href="invoice_new.php?memo_no=<?php echo $row['memo_no']; ?>"><img src="../dist/img/plus.jpg"></a></td>
			        <td><a href="invoice_return.php?memo_no=<?php echo $row['memo_no']; ?>"><img src="../dist/img/minus.jpg"></a></td>
			        <td><a href="memo_edit.php?memo_no=<?php echo $row['memo_no']; ?>"><button class="btn btn-primary">Update</button></a></td>
			        <td><a href="view_memo.php?memo_no=<?php echo $row['memo_no']; ?>"><img src="../dist/img/view.jpg"></a></td>
			        <td><a href="delete_memo.php?memo_no=<?php echo $row['memo_no']; ?>"><button class="btn btn-xs btn-danger" type="button"><i class="glyphicon glyphicon-trash"></i> Delete</button></a></td>
			      </tr>
			      <?php 
			      	}
			      ?>
			    </tbody>
			  </table>
			</div>  
  		</div> <!--box body -->
      </div>
    </div>
    </div>




  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ("footer_invoice.php"); ?>