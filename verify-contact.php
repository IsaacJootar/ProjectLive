<?php include('includes/header.php'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/smsAPI.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>

<!-- Start main-content -->

     <!-- Section: home -->
     <br><br><br>
    <section id="home">
    <?php 
    //send SMS Notification//
     
                //send SMS Notification//
$code=$_SESSION['code'];

$msg="Your OTP is $code";
$number=$_SESSION['number'];
$username = 'projectlive'; //your login username
$password = '001100110011..,,..,,'; //your login password
$sender='Projectlive';
$baseurl='https://api.loftysms.com/simple/sendsms';
$url=$baseurl.'?username='.$username.'&password='.$password.'&sender='.$sender.'&recipient='.$number.'&message='.$msg;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$exe = curl_exec($ch);
curl_close($ch);
                
    ?>

      <div class="display-table">
        <div class="display-table-cell">
          <div class="container pb-70">

            <div class="row">

              <div class="col-md-5 col-md-push-3">
                <div class="text-center mb-60"></div>
                <div class="bg-lightest border-1px p-25">
               
                  <h4 class="text-theme-colored text-uppercase m-0">Recover Password</h4>
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
                  <form id="verify_contact" class="mt-30" method="post" action="verify-contact_">
                      <div class="col-sm-12">
                        <div class="form-group mb-10">
                          <input name="code" class="form-control"  required="required" type="number" placeholder="Enter code to verify account" aria-required="true">
                        </div>
                      </div>
                       
                      
                   <div class="form-group mb-0 mt-1">
                      <button type="submit" class="btn btn-dark btn-theme-colored" data-loading-text="Please wait...">Verify</button>
                    </div>  
                    
                    </div>
                  <a href="recover-password">Send a new code</a>
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