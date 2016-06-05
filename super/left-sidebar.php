<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="../dist/img/rasel.jpg" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>Abul Basar Rasel</p>
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

<!--
  <ul class="nav navbar-nav collapse navbar-collapse">
    <li><a href="index.php" class="active">Home</a></li>  -->

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
  

  $statement2 = $db->prepare("SELECT DISTINCT cat_id FROM table_products WHERE com_id = ?");
  $statement2->execute(array($company_id));

  $categories= $statement2->fetchAll(PDO::FETCH_ASSOC);

  if(count($categories) == 0)
  {
?>
    <li class="treeview">
        <a href="#">
          <i class="fa fa-gg"></i> <span><?php echo $company_name; ?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
    </li>
<?php
  }
  else
  {
?>
    <li class="treeview">
        <a href="#">
          <i class="fa fa-gg"></i> <span><?php echo $company_name; ?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
    <ul class="treeview-menu">
<?php

    foreach ($categories as $cat) {

      $category_id = $cat["cat_id"];

      $statement3 = $db->prepare("SELECT * FROM table_categories WHERE cat_id = ?");
      $statement3->execute(array($category_id));

      $category = $statement3->fetchAll(PDO::FETCH_ASSOC);
      $category_name = $category[0]["cat_name"];

      $statement3 = $db->prepare("SELECT DISTINCT size_id FROM table_products WHERE cat_id = ? AND com_id = ? ");
      $statement3->execute(array($category_id, $company_id));

        $sizes= $statement3->fetchAll(PDO::FETCH_ASSOC);

        if(count($sizes) == 0)
        {
?>
          <li>
            <a href="#"><i class="fa fa-circle-o"></i><?php echo $category_name; ?><i class="fa fa-angle-left pull-right"></i></a>
          </li>
<?php
        }
        else
        {
?>
          <li>
            <a href="#"><i class="fa fa-circle-o"></i><?php echo $category_name; ?><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
<?php
        foreach ($sizes as $s) {

          $size_id = $s["size_id"]; 

          $statement4 = $db->prepare("SELECT * FROM table_sizes where size_id = ?");
          $statement4->execute(array($size_id));

          $size = $statement4->fetchAll(PDO::FETCH_ASSOC);
          $size_name = $size[0]["size_name"]; 
?>    
          <li>
                <a href="product-details.php?com_id=<?php echo $company_id; ?>&amp;cat_id=<?php echo $category_id; ?>&amp;size_id=<?php echo $size_id; ?>" ><i class="fa fa-circle-o"></i><?php echo $size_name; ?></a>
          </li>
<?php
        }
?>
        </ul>
        </li>
<?php
      }
      }
?>
    </ul>
    </li>
<?php
  }
}
?>
</ul>

  
 </section>
  <!-- /.sidebar -->
</aside>