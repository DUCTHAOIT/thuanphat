<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="theme/default/dist/css/style.min.css" rel="stylesheet" />

<link href="theme/default/style.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="../skins/frontend/js/jquery-2.2.3.min.js"></script>
<script src="//cdn.ckeditor.com/4.19.1/full/ckeditor.js"></script>
<script language="javascript" src="js/ajaxRequest.js"></script>
<script language="javascript" src="js/lib.js"></script>

<link rel="stylesheet" type="text/css" href="../js/jscalendar_v1.4.4/source/jsCalendar.css">
<link rel="stylesheet" type="text/css" href="../js/jscalendar_v1.4.4/themes/jsCalendar.micro.css">
<script type="text/javascript" src="../js/jscalendar_v1.4.4/source/jsCalendar.js"></script>
<script type="text/javascript" src="../js/jscalendar_v1.4.4/extensions/jsCalendar.datepicker.js"></script>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

<!--  <script src="theme/default/assets/libs/jquery/dist/jquery.min.js"></script>  -->
<!-- Bootstrap tether Core JavaScript -->
<script src="theme/default/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="theme/default/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="theme/default/assets/extra-libs/sparkline/sparkline.js"></script>

<!--Menu sidebar -->
<script src="theme/default/dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="theme/default/dist/js/custom.min.js"></script>

<title>Quản trị hệ thống</title>
</head>
<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
      <!-- ============================================================== -->
      <!-- Topbar header - style you can find in pages.scss -->
      <!-- ============================================================== -->
      <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
          <div class="navbar-header" data-logobg="skin5">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <a class="navbar-brand" href="../">
              <!-- Logo icon -->
              <b class="logo-icon ps-2">
                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                <!-- Dark Logo icon -->
                <img
                  src="theme/default/assets/images/logo-icon.png"
                  alt="homepage"
                  class="light-logo"
                  height="35px"                />
              </b>
              <!--End Logo icon -->
              

              <!-- </b> -->
              <!--End Logo icon -->
            </a>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a
              class="nav-toggler waves-effect waves-light d-block d-md-none"
              href="javascript:void(0)"
              ><i class="ti-menu ti-close"></i
            ></a>
          </div>
          <!-- ============================================================== -->
          <!-- End Logo -->
          <!-- ============================================================== -->
          <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
          <div
            class="navbar-collapse collapse"
            id="navbarSupportedContent"
            data-navbarbg="skin5"
          >
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-start me-auto">
              <li class="nav-item d-none d-lg-block">
                <a
                  class="nav-link sidebartoggler waves-effect waves-light"
                  href="javascript:void(0)"
                  data-sidebartype="mini-sidebar"
                  ><i class="mdi mdi-menu font-24"></i
                ></a>
              </li>
              
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-end">
             

              <!-- ============================================================== -->
              <!-- User profile and search -->
              <!-- ============================================================== -->
              <li class="nav-item dropdown" style="color:#FFFFFF">
                {$Hello} <em>(<strong>{$fistName}</strong>)</em> <em><a href="?m=control&f=my_account&id={$uid}" style="color:#FFFFFF">[ My account ]</a> &nbsp; <a href="action.php?op=logout" style="color:#FFFFFF">[ Logout ]</a></em>
                <ul
                  class="dropdown-menu dropdown-menu-end user-dd animated"
                  aria-labelledby="navbarDropdown"
                >
                  <a class="dropdown-item" href="?m=control&f=my_account&id={$uid}"
                    ><i class="mdi mdi-account me-1 ms-1"></i> My Profile</a
                  >
                 
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="action.php?op=logout"
                    ><i class="fa fa-power-off me-1 ms-1"></i> Logout</a
                  >
                 
                </ul>
              </li>
              <!-- ============================================================== -->
              <!-- User profile and search -->
              <!-- ============================================================== -->
            </ul>
          </div>
        </nav>
      </header>
      {menuLeft}
      <div class="page-wrapper">
      <div class="container-fluid">
          <div class="row" style="overflow-x:auto;">
		  <!--footer-->
	  