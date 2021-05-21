<?php ob_start(); ?>
<?php session_start(); ?>
<?php require_once('../classes/session.php'); ?>
<?php  require_once('../classes/functions.php'); ?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>

<script type="text/javascript" src="../tinymce/tinymce.min.js"></script>

<!-- Meta Tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="description" content="Charity & Crowdfunding Plaform for charity and creative projects in Nigeria" />
<meta name="keywords" content="Crowdfunding Plaform for charity and creative projects in Africa, ProjectLive- Charity & Crowdfunding Plaform for charity and creative projects in Nigeria " />
<meta name="author" content="ProjectLive-Crowdfunding Plaform for charity and creative projects in Nigeria, ProjectLive- Charity & Crowdfunding Plaform for charity and creative projects in Nigeria, Crowdfunding Plaform for charity and creative projects in Nigeria. ProjectLive is Nigeria's N0. 1 Crowdfunding Plaform."  />

<!-- Page Title -->
<title>ProjectLive-Secure Login </title>

<!-- Favicon and Touch Icons -->
<link href="../images/favicon.ico" rel="shortcut icon" type="image/png">
<link href="../images/apple-touch-icon.png" rel="apple-touch-icon">
<link href="../images/apple-touch-icon-72x72.png" rel="apple-touch-icon" sizes="72x72">
<link href="../images/apple-touch-icon-114x114.png" rel="apple-touch-icon" sizes="114x114">
<link href="../images/apple-touch-icon-144x144.png" rel="apple-touch-icon" sizes="144x144">


<!-- Stylesheet -->
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui.min.css" rel="stylesheet" type="text/css">
<link href="../css/animate.css" rel="stylesheet" type="text/css">
<link href="../css/css-plugin-collections.css" rel="stylesheet"/>
<!-- CSS | menuzord megamenu skins -->
<link id="menuzord-menu-skins" href="../css/menuzord-skins/menuzord-boxed.css" rel="stylesheet"/>
<!-- CSS | Main style file -->
<link href="../css/style-main.css" rel="stylesheet" type="text/css">
<!-- CSS | Preloader Styles -->
<link href="../css/preloader.css" rel="stylesheet" type="text/css">
<!-- CSS | Custom Margin Padding Collection -->
<link href="../css/custom-bootstrap-margin-padding.css" rel="stylesheet" type="text/css">
<!-- CSS | Responsive media queries -->
<link href="../css/responsive.css" rel="stylesheet" type="text/css">
<!-- Revolution Slider 5.x CSS settings -->
<link  href="../js/revolution-slider/css/settings.css" rel="stylesheet" type="text/css"/>
<link  href="../js/revolution-slider/css/layers.css" rel="stylesheet" type="text/css"/>
<link  href="../js/revolution-slider/css/navigation.css" rel="stylesheet" type="text/css"/>

<!-- CSS | Theme Color -->
<link href="../css/colors/theme-skin-orange.css" rel="stylesheet" type="text/css">
<style type="text/css">
body,td,th {
  font-family: "Open Sans", sans-serif;
  color: #000000;
}
</style>
<!-- external javascripts -->
<script src="../js/jquery-2.2.0.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<!-- JS | jquery plugin collection for this theme -->
<script src="../js/jquery-plugin-collection.js"></script>

<!-- Revolution Slider 5.x SCRIPTS -->
<script src="../js/revolution-slider/js/jquery.themepunch.tools.min.js"></script>
<script src="../js/revolution-slider/js/jquery.themepunch.revolution.min.js"></script>
 <!-- Include external CSS. -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
</head>
<body class="has-side-panel side-panel-right fullwidth-page side-push-panel">
<div class="body-overlay"></div>
<div class="header-nav" style="height:1">
      <div class="header-nav-wrapper navbar-scrolltofixed bg-white">
       
      </div>
    </div>
  </header>
<body class="">
<div id="wrapper">
  <!-- preloader -->
  
  
  <!-- start main-content -->
  <div class="main-content">
    <!-- Section: home -->
    <section id="home" class="divider parallax layer-overlay" data-bg-img="../images/gallery/gallery-sm3.jpg">
      <div class="display-table">
        <div class="display-table-cell">
          <div class="container">
            <div class="row">
              <div class="col-md-6 col-md-push-3">
                <div class="text-center mb-40"><a href="#" class=""><img src="../images/logo3.png" alt="" width="300"></a></div>
                <div class="widget bg-lightest border-1px p-8">
                  <div class="widget border-1px p-30">
                    <h5 class="widget-title line-bottom">ProjectLive Secure Admin Login</h5>
                    <div align="center">
                     <?php
                    if ((output_message($message))){
                        echo   '<div class="alert alert-success">';
                        echo ' <button type="button" class="close" data-dismiss="alert">&times;</button>';
                   
                        echo  '<strong style="font-size:14px">' .  output_message($message). '</strong>'; 
                        echo ' </div>';
                        unset ($message);
                    }
      
                         echo  '<strong style="font-size:30px">'.$session->display_error().'</strong>';
            
        ?> </div>  
            
                    <form id="admin"  action="admin-login" method="post">
                      <div class="form-group">
                        <input name="username" class="form-control" type="text" required="required" placeholder="Enter your username">
                      </div>
                       <div class="form-group">
                        <input name="password" class="form-control" type="password" required="required" placeholder="Enter your password">
                      </div>
                      <div class="form-group">
                        
                        <button type="submit" class="btn btn-dark btn-theme-colored btn-sm mt-0" data-loading-text="Please wait...">Login Now</button>
                      </div>
                    </form>

                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- end main-content -->

<!-- Footer -->
  <footer id="footer" class="footer text-center">
   
     
        <div class="col-md-12">
          <p class="text-black font-11 m-0">Copyright &copy; <?php echo date('Y'); ?> ProjectLive Africa. All Rights Reserved</p>
        </div>
      
   
  </footer>
</div>
<!-- end wrapper -->

<!-- Footer Scripts -->
<!-- JS | Custom script for all pages -->
<script src="js/custom.js"></script>

</body>
</html>