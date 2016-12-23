<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="../dist/img/avatar.png" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>Central Hospital</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    

  <ul class="sidebar-menu">

  <li class="header">MAIN NAVIGATION</li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li class=""><a href="admin.php"><i class="fa fa-circle-o"></i>Dashboard</a></li>
        <li class=""><a href="settings.php"><i class="fa fa-circle-o"></i>Setting</a></li>
      </ul>
    </li>


<?php

$statement = $db->prepare("SELECT DISTINCT com_id FROM table_products");
$statement->execute(array());

$companies = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($companies as $com) {

  $company_id = $com['com_id'];

  $statement1 = $db->prepare("SELECT * FROM table_companies WHERE com_id = ?");
  $statement1->execute(array($company_id));

  $company = $statement1->fetchAll(PDO::FETCH_ASSOC);
  $company_name=$company[0]["com_name"];

?>
    <li class="treeview">
        <a href="product-details.php?com_id=<?php echo $company_id; ?>">
          <i class="fa fa-gg"></i> <span><?php echo $company_name; ?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
    </li>
<?php 
}
?>
</ul>

  
 </section>
  <!-- /.sidebar -->
</aside>