<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HAQUE AGENCIES | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="../plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="../https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="../https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
.bs-example{
  font-family: sans-serif;
  position: relative;
  margin: 50px;
}
.typeahead, .tt-query, .tt-hint {
  border: 2px solid #CCCCCC;
  border-radius: 8px;
  font-size: 24px;
  height: 30px;
  line-height: 30px;
  outline: medium none;
  padding: 8px 12px;
  width: 396px;
}
.typeahead {
  background-color: #FFFFFF;
}
.typeahead:focus {
  border: 2px solid #0097CF;
}
.tt-query {
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
}
.tt-hint {
  color: #999999;
}
.tt-dropdown-menu {
  background-color: #FFFFFF;
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 8px;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  margin-top: 12px;
  padding: 8px 0;
  width: 422px;
}
.tt-suggestion {
  font-size: 24px;
  line-height: 24px;
  padding: 3px 20px;
}
.tt-suggestion.tt-is-under-cursor {
  background-color: #FFFFFF;
  color: black;
}
.tt-suggestion p {
  margin: 0;
}
</style>
    
  </head>
  <body class="hold-transition skin-blue layout-boxed sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="admin.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>H </b>A</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>HAQUE </b>AGENCIES</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="../#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav"> 

            <li class="dropdown user user-menu">
                <a href="search.php" class="dropdown-toggle" > Search
                  <!-- <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
                  <!-- <span class="user-image">Logout</span> -->
                </a>
              </li>  

              <li class="dropdown user user-menu">
                <a href="logout.php" class="dropdown-toggle" > Logout
                  <!-- <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
                  <!-- <span class="user-image">Logout</span> -->
                </a>
              </li>             
          
              <li class="dropdown user user-menu">
                <a href="../#" class="dropdown-toggle" data-toggle="dropdown"> Developer
                  <!-- <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                  <span class="hidden-xs">About Developer</span> -->
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    <p>
                      Nazmul Hossain || Software Eng.
                      <small>Hello : 01823387518</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="../#">Software</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="../#">Application</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="../#">Website</a>
                    </div>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="http://somrat.info/" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="http://facebook.com/somratcste" class="btn btn-default btn-flat">Facebook</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <!-- <li>
                <a href="../#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li> -->
            </ul>
          </div>
        </nav>
      </header>