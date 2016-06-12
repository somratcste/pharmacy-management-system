<?php 
ob_start();
session_start();
if($_SESSION['name']!='www.somrat.info')
{
  header('location: index.php');
}
include("head.php"); 
?>

<div class="content-wrapper">
  <section class="content">
	<div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div align="center" class="box-header with-border">
                  <h3 class="box-title">Smart Sell</h3>
                </div><!-- /.box-header -->
                <?php 
		        $a =0 ;
		        $a = $a+1; 
		        ?>
		      	<div class='box-body'>  
				  <div class="col-md-6 form-inline pull-left"><div class="form-group">
				    <label for="exampleInputName2">Memo No. :&nbsp; </label>
				    <input type="text" class="form-control" id="exampleInputName2" value="<?php echo $a; ?>">
				  </div></div>	      	
				  
				  <div class="col-md-6 form-inline pull-right"><div class="form-group">
				    <label for="exampleInputName2">Date :&nbsp;</label>
				    <input type="date" class="form-control" id="exampleInputName2" placeholder="Date">
				  </div></div>
 		
		      	</div>
                <div class="box-body">
                 <div class="table-responsive">  
                 <form class="" method="post" action="invoice_save.php">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
							<th width="2%"><input id="check_all" class="formcontrol" type="checkbox"/></th>
							<th width="15%">Item ID</th>
							<th width="38%">Item Name</th>
							<th width="15%">Price</th>
							<th width="15%">Quantity</th>
							<th width="15%">Total</th>
						</tr>
                    </thead>

                    <tbody>
                    	<tr>
							<td><input class="case" type="checkbox"/></td>
							<td><input type="text" data-type="productCode" name="itemNo[]" id="itemNo_1" class="form-control autocomplete_txt" autocomplete="off"></td>
							<td><input type="text" data-type="productName" name="itemName[]" id="itemName_1" class="form-control autocomplete_txt" autocomplete="off"></td>
							<td><input type="number" name="price[]" id="price_1" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
							<td><input type="number" name="quantity[]" id="quantity_1" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
							<td><input type="number" name="total[]" id="total_1" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
						</tr>
                    </tbody>
                  </table>
                </div>
             <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
      			<button class="btn btn-danger delete" type="button">- Delete</button>
      			<button class="btn btn-success addmore" type="button">+ Add More</button>
      		</div>

				
			<div class="row col-md-6 pull-right">
			<div class="form-group form-inline">
				<label class="col-sm-4" >Subtotal: &nbsp;</label>
				<div class="input-group col-sm-6">
					<div class="input-group-addon">Tk.</div>
					<input type="number" class="form-control" id="subTotal" placeholder="Subtotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
				</div>
			</div>
			<div class="form-group form-inline">
				<label class="col-sm-4">Percent: &nbsp;</label>
				<div class="input-group col-sm-6">
					<div class="input-group-addon">Tk.</div>
					<input type="number" class="form-control" id="tax" placeholder="Percent" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
       				<div class="input-group-addon">%</div>
				</div>
			</div>
			<div class="form-group form-inline">
				<label class="col-sm-4">Percent Amount: &nbsp;</label>
				<div class="input-group col-sm-6">
					<div class="input-group-addon">Tk.</div>
					<input type="text" class="form-control" id="taxAmount" placeholder="Percent" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">					
				</div>
			</div>

			<div class="form-group form-inline">
				<label class="col-sm-4">Without Percent: &nbsp;</label>
				<div class="input-group col-sm-6">
					<div class="input-group-addon">Tk.</div>
					<input type="text" class="form-control" id="totalAftertax" placeholder="Without Percen" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
				</div>
			</div>
			<div class="form-group form-inline">
				<label class="col-sm-4">Discount Amount: &nbsp;</label>
				<div class="input-group col-sm-6">
					<div class="input-group-addon">Tk.</div>
					<input type="number" class="form-control" id="amountPaid" placeholder="Discount Amount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
				</div>
			</div>
			<div class="form-group form-inline">
				<label class="col-sm-4">Total : &nbsp;</label>
				<div class="input-group col-sm-6">
					<div class="input-group-addon">Tk.</div>
					<input name="total_paid" type="number" class="form-control amountDue" id="amountDue" placeholder="Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
				</div>
			</div>

          <div class="form-group">       	
			<label class="col-sm-4"></label>	
			<div class="input-group col-sm-6">
			<input type=submit name="" value="Save" class="btn btn-primary btn-lg btn-block">
			</div>
     
          </div>

		</form>
		</div>


      	</div> <!--box body -->
        </div>
     </div>
    </div>




  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ("footer_invoice.php"); ?>