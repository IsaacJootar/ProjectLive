 <?php ob_start(); ?>
<?php session_start(); ?>
<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); 
// put these guys in a function later. //
if(!isset($_SESSION['SESS_USER'])){
  include ('includes/header.php');
  } else {
   include ('includes/header-login.php');  
}
    ?>

<style type="text/css">
body,td,th {
  
  color: #000000;
}
</style>
    
  <!-- Start main-content -->
  <div class="main-content">
    <div id="fullpage-container">

      <div class="section bg-img-cover layer-overlay overlay-dark-4" id="home" data-bg-img="">
        <div class="display-table">
          <div class="display-table-cell text-center">
            <div class="container pt-0 pb-0">
              <div class="row">
                <div class="col-md-12">
                  <h1 class="text-white font-titillium font-64 font-weight-600">Hi, Welcome To<span class="text-theme-colored"> Project<span class="text-white">Live</span></span><span class="text-white">   Africa</span></h1>
                  <h4 class="text-white">We are a crowdfunding platform tailored at creating a community where individuals, groups and entrepreneurs can raise funds for charitable causes, social and creative projects in Nigeria and throughout Africa .</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="section bg-img-cover layer-overlay" id="skills" data-bg-img="">
        <div class="display-table">
          <div class="display-table-cell">
            <div class="container pt-0 pb-0">
              <div class="row">
                <div class="col-md-offset-6 col-md-6">
                  <h2 class="font-32 mt-0 text-white">Our <span class="text-theme-colored">Vision</span></h2>
                  <p class="text-white font-16">To create the largest crowdfunding community in Africa.</p> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

 


 <div class="section bg-img-cover layer-overlay" id="skills" data-bg-img="">
        <div class="display-table">
          <div class="display-table-cell">
            <div class="container pt-0 pb-0">
              <div class="row">
                <div class="col-md-offset-6 col-md-6">
                  <h2 class="font-32 mt-0 text-white">Our <span class="text-theme-colored">Mission</span></h2>
                  <p class="text-white font-16">Creating a community by building platforms and tools, where willing donors can provide funds for individuals, groups and entrepreneurs for charitable, social and creative projects in Nigeria and throughout Africa.</p> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="section bg-img-cover layer-overlay" id="skills" data-bg-img="">
        <div class="display-table">
          <div class="display-table-cell">
            <div class="container pt-0 pb-0">
              <div class="row">
                <div class="col-md-offset-6 col-md-6">
                  <h2 class="font-32 mt-0 text-white">Who are <span class="text-theme-colored">We?</span></h2>
                  <p class="text-white font-16">We are a small team of software developers, designers, photographers, content creators and writers, who wake up everyday to creating the largest crowdfunding community in Africa.</p>
                  
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      
    </div>  
  </div>
  <!-- end main-content -->
</div>
<!-- end wrapper --> 

<!-- Footer Scripts -->
<!-- JS | fullpage  -->
<script src="js/fullpage-slider/jquery.fullpage.min.js"></script> 
<script type="text/javascript">
 $(document).ready(function() {
  $('#fullpage-container').fullpage({
      navigation: true,
      navigationPosition: 'right',
      verticalCentered: false
    });
  });
</script>
<!-- JS | Custom script for all pages -->
<script src="js/custom.js"></script>

</body>
</html>