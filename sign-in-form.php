<?php include('includes/header.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<!-- Start main-content -->

     <!-- Section: home -->
     <br><br><br>
    <section id="home">
   
      <div class="display-table">
        <div class="display-table-cell">
          <div class="container pb-70">

            <div class="row">

              <div class="col-md-5 col-md-push-3">
                <div class="text-center mb-60"></div>
                <div class="bg-lightest border-1px p-25">
               
                  <h4 class="text-theme-colored text-uppercase m-0">Log in to your Account</h4>
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
      
                  <p>Havent created an account? <a href="sign-up-form"><strong class="text-theme-colored" style="color:#000">Sign Up</strong></a></p>
                  <form id="appointment_form" name="reg_form" class="mt-30" method="post" action="sign-in-form_">
                      <div class="col-sm-12">
                        <div class="form-group mb-10">
                          <input name="email" class="form-control"  required="required" type="email" placeholder="Enter Email" aria-required="true">
                        </div>
                      </div>
                       <div class="col-sm-12">
                        <div class="form-group mb-10">
                          <input name="password" class="form-control" required="required" type="password" placeholder="Enter Password" aria-required="true">
                        </div>
                      </div>
                      
                   <div class="form-group mb-0 mt-1">
                      <button type="submit" class="btn btn-dark btn-theme-colored" data-loading-text="Please wait...">Log in Now</button>
                    </div>   
                    </div>
                  <a class="text-theme-colored" href="recover-password">Recover Password</a>
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