<?php 
ob_start();
session_start();
if($_SESSION['name']!='www.somrat.info')
{
  header('location: index.php');
}
include("header.php"); 

include ("left-sidebar-set.php") ;
?>

<div class="content-wrapper">
  <section class="content">
	<div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div align="center" class="box-header with-border">
                  <h3 class="box-title">Smart Sell</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                 <div class="table-responsive">  
                 <form class="" method="post" action="invoice_save.php">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
							<th width="2%"><input id="check_all" class="formcontrol" type="checkbox"/></th>
							<th width="15%">Item No</th>
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
			<div class="form-group">
				<label>Subtotal: &nbsp;</label>
				<div class="input-group">
					<div class="input-group-addon">Tk.</div>
					<input type="number" class="form-control" id="subTotal" placeholder="Subtotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
				</div>
			</div>
			<div class="form-group">
				<label>Percent: &nbsp;</label>
				<div class="input-group">
					<div class="input-group-addon">Tk.</div>
					<input type="number" class="form-control" id="tax" placeholder="Percent" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
       				<div class="input-group-addon">%</div>
				</div>
			</div>
			<div class="form-group">
				<label>Percent Amount: &nbsp;</label>
				<div class="input-group">
					<div class="input-group-addon">Tk.</div>
					<input type="number" class="form-control" id="taxAmount" placeholder="Percent" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">					
				</div>
			</div>

			<div class="form-group">
				<label>Without Percent: &nbsp;</label>
				<div class="input-group">
					<div class="input-group-addon">Tk.</div>
					<input type="number" class="form-control" id="totalAftertax" placeholder="Without Percen" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
				</div>
			</div>
			<div class="form-group">
				<label>Discount Amount: &nbsp;</label>
				<div class="input-group">
					<div class="input-group-addon">Tk.</div>
					<input type="number" class="form-control" id="amountPaid" placeholder="Discount Amount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
				</div>
			</div>
			<div class="form-group">
				<label>Total : &nbsp;</label>
				<div class="input-group">
					<div class="input-group-addon">Tk.</div>
					<input type="number" class="form-control amountDue" id="amountDue" placeholder="Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
				</div>
			</div>

          <div class="form-group">
              <input type=submit name="" value="Save" class="btn btn-primary">
 
          </div>

		</form>
		</div>


      	</div> <!--box body -->
        </div>
     </div>
    </div>




  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ("footer.php"); ?>