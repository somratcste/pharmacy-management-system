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
  $m_date     = $row['m_date'];
  $customar_name  = $row['customar_name'];
  $sex      = $row['sex'];
  $age      = $row['age'];
  $doc_id     = $row['doc_id'];
  if($sex==1)
    $sex = "Male";
  else
    $sex = "Female";
}

$statement = $db->prepare("SELECT * FROM memo_price WHERE memo_no = ?");
$statement->execute(array($memo_no));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row)
{
  $percent     = $row['percent'];
}

$doc_name = "";
$statement = $db->prepare("SELECT * FROM doctors WHERE doc_id = ?");
$statement->execute(array($doc_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row)
{
  $doc_name = $row['doc_name'];
}

if(isset($_POST['invoice']))
{
  try {

    $statement = $db->prepare("DELETE FROM memo_item WHERE memo_no=?");
    $statement->execute(array($memo_no));

    $statement = $db->prepare("DELETE FROM memo_price WHERE memo_no=?");
    $statement->execute(array($memo_no));

    $statement = $db->prepare("INSERT INTO memo_price (memo_no, subtotal, percent, percent_amount, without_percent, discount_amount, total_paid) VALUES (?,?,?,?,?,?,?)");
    $statement->execute(array($_POST['memo_no'],$_POST['subtotal'],$_POST['percent'],$_POST['percent_amount'],$_POST['without_percent'],$_POST['discount_amount'],$_POST['total_paid']));


    for($i=0;$i<count($_POST['itemNo']);$i++)
    {
        $itemNo['itemNo']      = $_POST['itemNo'][$i];
        $itemName['itemName']     = $_POST['itemName'][$i];
        $price['price']        = $_POST['price'][$i];
        $quantity['quantity']     = $_POST['quantity'][$i];
        $total['total']        = $_POST['total'][$i];

       $statement = $db->prepare("INSERT INTO memo_item (memo_no, item_id, item_name, item_price, item_quantity, item_total ) VALUES (?,?,?,?,?,?)");
       $statement->execute(array($memo_no, $itemNo['itemNo'], $itemName['itemName'], $price['price'], $quantity['quantity'], $total['total']));
     }




    $success_message = "Memo Updated successfully.";

    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Memo Updated successfully')
    window.location.href='memo.php';
    </SCRIPT>");
    
  
  }
  
  catch(Exception $e) { 
    $error_message = $e->getMessage();
  }
}
?>

<div class="content-wrapper">
  <section class="content">
  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div align="center" class="box-header with-border">
                  <h3 class="box-title">Smart Sell</h3>
                </div><!-- /.box-header -->
                <form class="" method="post" action="" enctype="multipart/form-data">
            <div class='box-body'>  
          <div class="row col-md-6 pull-left">
          
          <div class="form-group form-inline">
            <label class="col-sm-4" >Memo No : &nbsp;</label>
            <div class="input-group col-sm-6">
              <input name="memo_no" type="number" class="form-control" value="<?php echo $memo_no ; ?>" readonly>
            </div>
          </div>  
          </div>  

          <div class="row col-md-6 pull-right">
          <div class="form-group form-inline">
            <label class="col-sm-4" >Date : &nbsp;</label>
            <div class="input-group col-sm-6">
              <input name="m_date" type="date" class="form-control" value="<?php echo $m_date; ?>" readonly>
            </div>
          </div>  
          </div>  

          <div class="row col-md-6 pull-left">
          <div class="form-group form-inline">
            <label class="col-sm-4" >Customar Name : &nbsp;</label>
            <div class="input-group col-sm-6">
              <input name="customar_name" type="text" class="form-control" value="<?php echo $customar_name ; ?>" readonly>
            </div>
          </div>  
          </div>  

          <div class="row col-md-6 pull-right">
          <div class="form-group form-inline">
            <label class="col-sm-4" >Sex : &nbsp;</label>
            <div class="input-group col-sm-6">
              <input name="customar_name" type="text" class="form-control" value="<?php echo $sex ; ?>" readonly>
            </div>
          </div>  
          </div>

          <div class="row col-md-6 pull-left">
          <div class="form-group form-inline">
            <label class="col-sm-4" >Age : &nbsp;</label>
            <div class="input-group col-sm-6">
              <input name="age" type="number" class="form-control" value="<?php echo $age; ?>" readonly>
            </div>
          </div>  
          </div>

          <div class="row col-md-6 pull-right">
          <div class="form-group form-inline">
            <label class="col-sm-4" >Ref. Doctor : &nbsp;</label>
            <div class="input-group col-sm-6">
            <input name="customar_name" type="text" class="form-control" value="<?php echo $doc_name ; ?>" readonly>
              </div>
          </div>  
          </div>
                  
         </div>

        
        <div class="box-body">
         <div class="table-responsive">  
         
          <table id="invoice_bill" class="table table-bordered table-hover">
            <thead>
                <tr>
                  <th width="2%"><input id="check_all" class="formcontrol" type="checkbox"/></th>
                  <th width="13%">Item ID</th>
                  <th width="33%">Item Name</th>
                  <th width="13%">Available</th>
                  <th width="13%">Price</th>
                  <th width="13%">Quantity</th>
                  <th width="13%">Total</th>
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
              <td><input class="case" type="checkbox"/></td>
              <td><input type="text" data-type="productCode" name="itemNo[]" id="itemNo_1" class="form-control autocomplete_txt" autocomplete="off" value="<?php echo $row['item_id'] ; ?>"></td>
              <td><input type="text" data-type="productName" name="itemName[]" id="itemName_1" class="form-control autocomplete_txt" autocomplete="off" value="<?php echo $row['item_name'] ; ?>"></td>

              <td><input type="text" data-type="productAvailable" name="itemAvailable[]" id="itemAvailable_1" class="form-control autocomplete_txt" autocomplete="off" readonly></td>


              <td><input type="number" name="price[]" id="price_1" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="<?php echo $row['item_price']; ?>" readonly></td>
              <td><input type="number" name="quantity[]" id="quantity_1" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="<?php echo $row['item_quantity']; ?>"></td>
              <td><input type="number" name="total[]" id="total_1" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="<?php echo $row['item_total']; ?>" readonly></td>
            </tr>
            <?php 
                }
              ?>
                    </tbody>
                  </table>
                </div>
             <!-- <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
            <button class="btn btn-danger delete" type="button">- Delete</button>
            <button class="btn btn-success addmore" type="button">+ Add More</button>
          </div> -->

        
      <div class="row col-md-6 pull-right">
      <div class="form-group form-inline">
        <label class="col-sm-4" >Subtotal: &nbsp;</label>
        <div class="input-group col-sm-6">
          <div class="input-group-addon">Tk.</div>
          <input name="subtotal" type="number" class="form-control" id="subTotal" placeholder="Subtotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" readonly>
        </div>
      </div>
      <div class="form-group form-inline">
        <label class="col-sm-4">Percent: &nbsp;</label>
        <div class="input-group col-sm-6">
          <div class="input-group-addon">Tk.</div>
          <input name="percent" type="number" class="form-control" id="tax" value="<?php echo $percent; ?>" placeholder="Percent" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" >
              <div class="input-group-addon">%</div>
        </div>
      </div>
      <div class="form-group form-inline">
        <label class="col-sm-4">Percent Amount: &nbsp;</label>
        <div class="input-group col-sm-6">
          <div class="input-group-addon">Tk.</div>
          <input name="percent_amount" type="text" class="form-control" id="taxAmount" placeholder="Percent" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">          
        </div>
      </div>

      <div class="form-group form-inline">
        <label class="col-sm-4">Without Percent: &nbsp;</label>
        <div class="input-group col-sm-6">
          <div class="input-group-addon">Tk.</div>
          <input name="without_percent" type="text" class="form-control" id="totalAftertax" placeholder="Without Percen" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" >
        </div>
      </div>
      <div class="form-group form-inline">
        <label class="col-sm-4">Discount Amount: &nbsp;</label>
        <div class="input-group col-sm-6">
          <div class="input-group-addon">Tk.</div>
          <input name="discount_amount" type="number" class="form-control" id="amountPaid" placeholder="Discount Amount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
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
      <input type=submit name="invoice" value="Save" class="btn btn-primary btn-lg btn-block">
      </div>
     
          </div>

    
    </div>


        </div> <!--box body -->
        </form>
        </div>
     </div>
    </div>




  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ("footer_invoice.php"); ?>