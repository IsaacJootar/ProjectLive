<?php ob_start(); ?>
<?php session_start(); ?>
<?php date_default_timezone_set('Africa/Lagos'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/smsAPI.php');
         //$user_id=$_GET['user_id']; // from Ajax
         //$campaign_id=$_GET['cid']; // From Ajax 

   
      
       
          //initiualize message//
          $otp_message="A one time password (OTP) has been sent to your phone. Input the code below to confirm your ProjectLive account. If your phone number has changed, make sure you go to 'My Account' and update the new phone number.";
          //$_SESSION['otp_message']=$otp_message;
         //send OTP code to database//


     
     

 ?>
        <div class="modal-header">
 
  <button type="button"  class="close" data-dismiss="modal">X</button>
                   
                   <h5 class="modal-title" id="myModalLabel2">Verify your ProjectLive account.  <i class="fa fa-check-circle text-theme-colored"></i> </h5>
                </div>

                <div class="modal-body">
                   <form class="form-horizontal" action="campaign-review" method="post">
                <fieldset>
               
                    <div class="input-group col-md-12"> 
                       <h6 class="alert alert-success"><?php //echo $otp_message; // this variable shud also be set?> </h6> 
                       <label style="float:center">Enter one time password sent to you.<strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="A one time password (OTP) is a number code sent to you phone to verify your ProjectLive account before you can go live. Each code is valid for 10 minutes. "> </i></label>
    <input type="text" name="otp_code" required class="form-control" id="otp" placeholder="enter OTP code here">
                    </div></br>
                  
                    <input name="campaign_id" type="hidden" value="<?php //echo $campaign_id ?>">
                    <input name="user_id" type="hidden" value="<?php //echo $user_id ?>">
                    <div class="clearfix"></div>
                    <p class="center col-md-5">
                      <button type="submit" class="btn btn-dark btn-theme-colored">Verify & submit campaign</button>
                    </p>
                </fieldset>
            </form>
              
                
            </div>