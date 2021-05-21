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
  <br><br><br>
  <div class="main-content">
    <!-- Section: inner-header -->
    <section class="inner-header divider layer-overlay overlay-dark" data-bg-img="images/bg/bg2.jpg">
      <div class="container pt-30 pb-30">
        <!-- Section Content -->
        <div class="section-content text-center">
          <div class="row"> 
            <div class="col-md-12  text-center">
              <h2 class="text-white font-25" align="center"> <div class="text-justify">We’re dedicated to creating a community where ordinary people with pressing needs, dreams and amazing ideas can connect with donors. That could range from helping you raise money for critical medical expenses, launch an exciting new business or make a dream come true. You can create a campaign in four simple steps.</h2>
              </div>
            </div>
          </div>
        </div>
      </div>      
    </section>
    
     
          <div class="row"> 
            <div class="col-md-12  text-center">
              <h2>ProjectLive works in four simple steps!</h2>
                <h6>Raising money can be difficult, but we have created a community to make it simple!</h6>
              
            </div>
          </div>
       
    
    
       
    
    <section>
    <div class="row mt-30">
          <div class="col-sm-3">
            <div class="icon-box iconbox-theme-colored">
              <a class="icon icon-dark icon-circled icon-border-effect effect-circled icon-sm pull-left mb-0 mr-10" href="#">
                <i class="pe-7s-switch"></i>
              </a>
              <h5 class="icon-box-title mt-15 mb-20">Start a Campaign</h5>
              <p class="text-gray">Create a campaign by telling a compelling story of your idea, project or anything that means so much to you. Choose your area of interest from our various categories</p>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="icon-box iconbox-theme-colored">
              <a class="icon icon-dark icon-circled icon-border-effect effect-circled icon-sm pull-left mb-0 mr-10" href="#">
                <i class="pe-7s-global"></i>
              </a>
              <h5 class="icon-box-title mt-15 mb-20">Go Live</h5>
              <p class="text-gray">Your campaign goes live after a vetting process and approval by the ProjectLive team. Use the platform tools provided to promote your campaign on social media, with friends and family</p>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="icon-box iconbox-theme-colored">
              <a class="icon icon-dark icon-circled icon-border-effect effect-circled icon-sm pull-left mb-0 mr-10" href="#">
                <i class="pe-7s-cash"></i>
              </a>
              <h5 class="icon-box-title mt-15 mb-20">Receive Funds</h5>
              <p class="text-gray">Start receiving funds from willing donors all over Africa. Monitor your funds in realtime as they come in.</p>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="icon-box iconbox-theme-colored">
              <a class="icon icon-dark icon-circled icon-border-effect effect-circled icon-sm pull-left mb-0 mr-10" href="#">
                <i class="pe-7s-like2"></i>
              </a>
              <h5 class="icon-box-title mt-15 mb-20">Execute your Project.</h5>
              <p class="text-gray">Use the funds you have received to execute the project. Appreciate your donors and share your success story to our community. That's it.  Simple!</p>
            </div>
          </div>
        </div>
    </section>

    <div class="divider layer-overlay overlay-dark call-to-action pt-40 pb-40 mb-20">
  <div class="col-xs-12 col-sm-8 col-md-8">
    <div class="icon-box icon-rounded-bordered left media mb-0"> 
      <a class="media-left pull-left" href="#"> <i class="pe-7s-culture text-whtie p-20"></i></a>
     <div class="media-body">
        <h3 class="media-heading heading text-white">Need Assistance?</h3>
        <p class="text-white">Did you know that most crowdfunding campaigns fail because of lack of planning? Read the following campaign heads up below and learn how to create successfull campaigns on ProjectLive. Or call our campaign help team for advice. </p>
      </div>
    </div>
  </div>
 
</div>
<?php include('includes/campaign-heads-up.php');?>
  <!-- end main-content -->
   <!-- Footer -->
  <?php include('includes/footer.php'); ?>
</body>
</html>