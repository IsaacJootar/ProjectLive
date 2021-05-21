<?php include('includes/header.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<!-- Start main-content -->
     <!-- Section: home -->
     <br><br><br><br><br>
    <section id="home">
   
      <div class="display-table">
        <div class="display-table-cell">
          <div class="container">
            <div class="row">
              <div class="col-md-5 col-md-push-3">
               
                <div class="bg-lightest border-1px p-25">
               
                  <h4 class="text-theme-colored text-uppercase m-0">Sign up to continue</h4>
                  <div class="line-bottom mb-15"></div>
                   
    <div align="center">
     <?php
                    if ((output_message($message))){
               echo   '<div class="alert alert-success">';
                   echo ' <button type="button" class="close" data-dismiss="alert">&times;</button>';
                   
                   echo output_message($message); 
               echo ' </div>';
                 unset ($message);
                 }
              ?>
                  <?php echo $session->display_error(); ?>         
      
                  <p>Already have an account? <a href="sign-in-form"><strong class="text-theme-colored" style="color:#000">Log in</strong></a></p>
                  <form id="appointment_form" name="reg_form" class="mt-30" method="post" action="sign-up-form_">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group mb-10">
                          <input name="first_name" class="form-control" required  type="text" placeholder="First  Name" aria-required="true">
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group mb-10">
                          <input name="last_name" class="form-control" required type="text" required placeholder="Last  Name" aria-required="true">
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group mb-10">
                          <input name="email" class="form-control" required type="email" placeholder="Enter Email" aria-required="true">
                        </div>
                      </div>
                       <div class="col-sm-12">
                        <div class="form-group mb-10">
                          <input name="password" class="form-control" required  type="password" placeholder="Create Password" aria-required="true">
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group mb-10">
                          <input name="phone" class="form-control" required  type="number" placeholder="Enter Your Valid Phone Number" aria-required="true">
                        </div>
                      </div>
                     
                    </div>
                   
                    <div class="form-group mb-0 mt-1">
                      <p>
               By signing up you agree to our <a href="terms-of-use"><strong class="text-theme-colored">Terms of Use</strong></a> and <a href="privacy-policy"> <strong class="text-theme-colored">Privacy Policy</strong></a>.<p style="font-size: 11px">Your phone number & e-Mail may be used to sent you SMS & e-Mail notifications</p>
                      </p>
                      <button type="submit" class="btn btn-dark btn-theme-colored" data-loading-text="Please wait...">Create Account</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- end main-content -->


<!-- end wrapper -->

<!-- Footer Scripts -->
<!-- JS | Custom script for all pages -->
<script src="js/custom.js"></script>

</body>


</html>