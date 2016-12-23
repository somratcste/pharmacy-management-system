<?php 
ob_start();
session_start();
if($_SESSION['name']!='www.somrat.info')
{
  header('location: index.php');
}
include("head.php"); 
include("../connection.php");

$memo_no = $_GET['memo_no'];



$statement = $db->prepare("SELECT * FROM memo_info WHERE memo_no = ?");
$statement->execute(array($memo_no));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row)
{
 	$m_date 		= $row['m_date'];
 	$customar_name 	= $row['customar_name'];
 	$sex 			= $row['sex'];
 	$age 			= $row['age'];
 	$doc_id 		= $row['doc_id'];
 	if($sex==1)
 		$sex = "Male";
 	else if ($sex==2)
 		$sex = "Female";
  else {
    $sex = "";
    $age = "";
  }
}
$doc_name = "";
$statement = $db->prepare("SELECT * FROM doctors WHERE doc_id = ?");
$statement->execute(array($doc_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row)
{
	$doc_name = $row['doc_name'];
}

	         
?>

<div class="content-wrapper">
  <section class="content">
	<div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div align="center" class="box-header with-border">
          <h3 class="box-title">TRUST ONE HOSPITAL</h3>
          <p>Maijdee-Court , Noakhali. Hello : 01823387518 </p>
      	<div class='box-body'>  
        
 			  <div class="table-responsive">  
                 
          <table id="invoice_bill" class="table table-bordered table-hover">
            <thead>
            <tr>
            	<th>Memo No.</th>
							<th width="">Customar Name</th>
							<th width="">Sex</th>
							<th>Age</th>
							<th width="">Ref. Dr.</th>
							<th width="">Date</th>
						</tr>
          </thead>

          <tbody>        	
          	  <tr>
          	  	<td><?php echo $memo_no ; ?></td>
				        <td><?php echo $customar_name ; ?></td>
				        <td><?php echo $sex ; ?></td>
				        <td><?php echo $age ; ?></td>
				        <td><?php echo $doc_name ; ?></td>
				        <td><?php echo $m_date; ?></td>
				      </tr>
            </tbody>
          </table>
        </div>
				  
				 				  
				 
     <div class="table-responsive">  
     
      <table id="invoice_bill" class="table table-bordered table-hover">
        <thead>
            <tr>
							<th width="15%">Item No.</th>
							<th width="38%">Item Name</th>
							<th width="15%">Price</th>
							<th width="15%">Quantity</th>
							<th width="8%">Total</th>
						</tr>
            </thead>

            <tbody>
                <?php
				        $i=0;
				        $statement = $db->prepare("SELECT * FROM memo_item WHERE memo_no = ? ");
				        $statement->execute(array($memo_no));
				        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
				        foreach($result as $row)
				        {
				          $i++;
				          ?>

	            	  <tr>
	                    <td><?php echo $i ; ?></td>
				        <td><?php echo $row['item_name'] ; ?></td>
				        <td><?php echo $row['item_price']; ?></td>
				        <td><?php echo $row['item_quantity']; ?></td>
				        <td><?php echo $row['item_total']; ?></td>
				      </tr>
				      <?php 
				      	}
				      ?>
            </tbody>
          </table>
        </div>
            	
			<div class="row col-md-4 pull-right">
				<table id="invoice_bill" class="table table-bordered table-hover">
                    <tbody>
                    <?php
                    $statement1 = $db->prepare("SELECT * FROM memo_price WHERE memo_no = ?");
                    $statement1->execute(array($memo_no));
                    $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                    foreach($result1 as $row1)
                    {
                    
                    ?>
                        <tr>
                        	<td>Subtotal</td>
                        	<td><?php echo $row1['subtotal']; ?></td>
                        </tr>
                        <tr>
                        	<td>Percent</td>
                        	<td><?php echo $row1['percent']; ?></td>
                        </tr>
                        <tr>
                        	<td>Percent Amount</td>
                        	<td><?php echo $row1['percent_amount']; ?></td>
                        </tr>
                        <tr>
                        	<td>Without Percent</td>
                        	<td><?php echo $row1['without_percent']; ?></td>
                        </tr>
                        <tr>
                        	<td>Discount Amount</td>
                        	<td><?php echo $row1['discount_amount']; ?></td>
                        </tr>
                        <tr>
                        	<td>Total</td>
                        	<td><?php echo $row1['total_paid']; ?></td>
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