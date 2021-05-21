<?php include('includes/header.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<!-- Start main-content -->
<?php $user_name=$_SESSION['user_name'];

?>
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
               
                  <h4 class="text-theme-colored text-uppercase m-0">Create New Password</h4>
                  
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
                  <form id="new_pass" class="mt-30" method="post" action="create-new-password_">
                      <div class="col-sm-12">
                        <div class="form-group mb-10">
                          <input name="password" class="form-control" title="Password should not be less than 6 characters"  required="required" type="password" placeholder="Enter New Password" aria-required="true">
                        </div>
                      </div>
                       <div class="col-sm-12">
                        <div class="form-group mb-10">
                        <input name="user_name" value="<?php echo $user_name?>" type="hidden">

                          <input name="cpassword" class="form-control" title="Password should not be less than 6 characters" required="required" type="password" placeholder="Comfirm Password" aria-required="true">
                        </div>
                      </div>
                      
                   <div class="form-group mb-0 mt-1">
                      <button type="submit" class="btn btn-dark btn-theme-colored" data-loading-text="Please wait...">Create Now</button>
                    </div>   
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