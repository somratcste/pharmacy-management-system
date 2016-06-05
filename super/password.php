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


if(isset($_POST['form_super_admin'])) {
    
    try {
    
        if(empty($_POST['old'])) {
            throw new Exception("Old Password field can not be empty");
        }
        
        if(empty($_POST['new1'])) {
            throw new Exception("New Password field can not be empty");
        }
        
        if(empty($_POST['new2'])) {
            throw new Exception("Confirm Password field can not be empty");
        }
        
        $statement = $db->prepare("SELECT * FROM table_admin_login WHERE adm_id=2");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row)
        {
            
            $old_password = md5($_POST['old']);
            if($old_password != $row['adm_password'])
            {
                throw new Exception("Old Password is wrong.");
            }
                    
        }
        
        if($_POST['new1'] != $_POST['new2'])
        {
            throw new Exception("New Password and Confirm Password does not match.");
        }
        
        
        $new_final_password = md5($_POST['new1']);
        
        $statement = $db->prepare("UPDATE table_admin_login SET adm_password=? WHERE adm_id=2");
        $statement->execute(array($new_final_password));
        
        $success_message = "Super Admin Password is changed successfully.";
        
    
    }
    
    catch(Exception $e) {
        $error_message = $e->getMessage();
    }
    
    
}

?>

<?php

if(isset($_POST['form_admin'])) {
    
    try {
    
        if(empty($_POST['old'])) {
            throw new Exception("Old Password field can not be empty");
        }
        
        if(empty($_POST['new1'])) {
            throw new Exception("New Password field can not be empty");
        }
        
        if(empty($_POST['new2'])) {
            throw new Exception("Confirm Password field can not be empty");
        }
        
        $statement = $db->prepare("SELECT * FROM table_admin_login WHERE adm_id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row)
        {
            
            $old_password = md5($_POST['old']);
            if($old_password != $row['adm_password'])
            {
                throw new Exception("Old Password is wrong.");
            }
                    
        }
        
        if($_POST['new1'] != $_POST['new2'])
        {
            throw new Exception("New Password and Confirm Password does not match.");
        }
        
        
        $new_final_password = md5($_POST['new1']);
        
        $statement = $db->prepare("UPDATE table_admin_login SET adm_password=? WHERE adm_id=1");
        $statement->execute(array($new_final_password));
        
        $success_message = "Password is changed successfully.";
        
    
    }
    
    catch(Exception $e) {
        $error_message = $e->getMessage();
    }
    
    
}

?>

<div class="content-wrapper">
  <section class="content">

    <!-- SELECT2 EXAMPLE -->

 <div class="box box-default">
  <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Change Your Password </h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <?php
              if(isset($error_message))
              { ?>
                <div class="alert alert-danger">
                    <p class=""><?php echo $error_message ; ?></p>
                </div>
            <?php 
               } 
             else if(isset($success_message))
              { ?>
                <div class="alert alert-success">
                    <p class=""><?php echo $success_message ; ?></p>
                </div>
            <?php } ?>
      </div>
  </div><!-- /.box -->
</div>
   

   <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12"  data-toggle="modal" data-target="#editModalSuper">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-wrench"></i></span>
        <div class="info-box-content">
          <span class="info-box-text"></span>
          <span class="info-box-number">SUPER ADMIN</span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->

    <div class="modal fade" id="editModalSuper" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  <h5 class="modal-title">Password Change</h5>
              </div>

              <div class="modal-body">
                  <!-- The form is placed inside the body of modal -->      
            <div class="box-header with-border">
              <h3 class="box-title">Change Super Admin Password</h3>
            </div><!-- /.box-header -->
            
            <!-- form start -->
            <form class="form-horizontal" action="" method="post" enctype="multipart/formdata">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Old Password </label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" id="inputEmail3" placeholder="Insert Old Password" name="old">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">New Password </label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" id="inputEmail3" placeholder="Insert New Password" name="new1">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Confirm Password </label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" id="inputEmail3" placeholder="Confirm New Password" name="new2">
                  </div>
                </div>

              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right" name="form_super_admin">UPDATE</button>
              </div><!-- /.box-footer -->
            </form>

              </div>
          </div>
      </div>
    </div>
  <!--Product edit modal end -->


    <div class="col-md-6 col-sm-6 col-xs-12"  data-toggle="modal" data-target="#editModaladmin">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-wrench"></i></span>
        <div class="info-box-content">
          <span class="info-box-text"></span>
          <span class="info-box-number">ADMIN</span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->

    <div class="modal fade" id="editModaladmin" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  <h5 class="modal-title">Password Change</h5>
              </div>

              <div class="modal-body">
                  <!-- The form is placed inside the body of modal -->      
            <div class="box-header with-border">
              <h3 class="box-title">Change Admin Password</h3>
            </div><!-- /.box-header -->
            
            <!-- form start -->
            <form class="form-horizontal" action="" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Old Password </label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" id="inputEmail3" placeholder="Insert Old Password" name="old">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">New Password </label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" id="inputEmail3" placeholder="Insert New Password" name="new1">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Confirm Password </label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" id="inputEmail3" placeholder="Confirm New Password" name="new2">
                  </div>
                </div>

              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right" name="form_admin">UPDATE</button>
              </div><!-- /.box-footer -->
            </form>

              </div>
          </div>
      </div>
    </div>
  <!--Product edit modal end -->

  </div>
</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ("footer.php"); ?>