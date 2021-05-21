<?php ob_start(); ?>
<?php session_start(); ?>
<?php date_default_timezone_set('Africa/Lagos'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/smsAPI.php');
  $error_array=array();
  $error_flag=false;
         $code=$_POST['code']; // from  post

         $confirm_code=$database->query("SELECT * FROM `pl_password_codes` WHERE `code`='{$code}'");

         if($confirm_code){
          if($database->num_rows($confirm_code) !=1){
            $error_array[]='Recovery code is wrong';
            $error_flag=true;
          }
        }
      // when a campaign OTP is matched, check then if the OTP is still valid, that is, it has not stayed for more than 10 mins//
        if($database->num_rows($confirm_code)==1){ 
          // get the time when otp code was sent to creator and stored//
          $get_sent_time=$database->fetch_array($confirm_code); 
          $then = $get_sent_time['sent_time']; //that is then, to be compared with now//
          // This is now, time when a creator is trying to validate ProjectLive account with an OTP code, compare the times and make sure its not more than 10 mins//
          $datetime1 =$then;
          $time_diff=time()-$then;
          $time_diff=floor($time_diff/60);// divide the time by 60 mins, to covert to mins for verification//

          if ($time_diff > 10) {
          $error_array[]='This recovery code has expired, please try to resend another code.';
          $error_flag=true;
          }
        }
          // if errors are found store the error in a seesion//
        if ($error_flag){ 
          $_SESSION['sess_errors']=$error_array;
          session_write_close();
          redirect_to('verify-contact');
          exit();
        }


        if($database->num_rows($confirm_code)==1){ 
          $confirm_code=$database->query("SELECT * FROM `pl_password_codes` WHERE `code`='{$code}'");

          // get the time when otp code was sent to creator and stored//
          $get_sent_time=$database->fetch_array($confirm_code); 
          $then = $get_sent_time['sent_time']; //that is then, to be compared with now//
          $_SESSION['user_name'] = $get_sent_time['user_name']; // use this is determin which account password to change//
          // This is now, time when a user is trying to validate account contact with an OTP code, compare the times and make sure its not more than 10 mins//
          $datetime1 =$then;
          $time_diff=time()-$then;
          $time_diff=floor($time_diff/60);// divide the time by 60 mins, to covert to mins for verification//

          if ($time_diff < 10) {
          
          $session->message("Your account has been successfully verified. You can now create a new password.");// hold on first;
          redirect_to('create-new-password');
         
          }
        }
 ?>