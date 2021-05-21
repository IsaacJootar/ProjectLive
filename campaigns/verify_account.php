<?php ob_start(); ?>
<?php session_start(); ?>
<?php date_default_timezone_set('Africa/Lagos'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/smsAPI.php');

 
         $user_id=$_GET['user_id']; // from Ajax
         $campaign_id=$_GET['cid']; // From Ajax 
          // clicking the submit entails creator is discarding the previous OPT, so remove it from database and resend a new one.//

        $remove_campaign="DELETE  FROM  `pl_otp_codes` 
                                   WHERE `campaign_id`='{$campaign_id}'";
        if(!$remove_campaign=$database->query($remove_campaign)){
            echo 'Could not discard OTP';
            exit();
        }

 //if otp has not been sent for this campaign ID yet//
          $sql_sent_time=$database->query("SELECT  `sent_time` FROM `pl_otp_codes` WHERE `user_id`='{$user_id}' AND `campaign_id`= '{$campaign_id}'");// check query for errors always-but am lazy now, come back later//
      
      
        if($database->num_rows($sql_sent_time) == 0){
          //initiualize message//
          $otp_message="A one time password (OTP) has been sent to your phone. Input the code below to confirm your ProjectLive account. If your phone number has changed, make sure you go to 'My Account' and update the new phone number.";
          //$_SESSION['otp_message']=$otp_message;
         //send OTP code to database//
          $otp=substr(mt_rand(), -5); // for this purpose this is random enuf//
          $sent_time=time();
          $sql="INSERT INTO `pl_otp_codes`(`user_id`, `campaign_id`, `otp_code`, `sent_time`) VALUES ('{$user_id}', '{$campaign_id}', '{$otp}', '{$sent_time}')";
          if(!$database->query($sql)){
                    echo 'ERROR_SENDING_OTP_CODE'; // make all ur systems errors display in this format//
                    exit();
          }

         $get_user_info=$database->query("SELECT * FROM `pl_users` WHERE `id`='{$user_id}'");
                $get_user_info=$database->fetch_array($get_user_info); 

                //send SMS Notification//
                $msg="Your OTP is $otp";
                $number=$get_user_info['phone'];
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
 
         } // end if




     
      /* /when a campaign OTP is matched, check then if the OTP is still valid, that is, it has not stayed for more than 5 mins//
        if($database->num_rows($sql_sent_time) >=1){ 
          // get the time when otp code was sent to creator and stored//
          $get_sent_time=$database->fetch_array($sql_sent_time); 
          $then = $get_sent_time['sent_time']; //that is then, to be compared with now//
          // This is now, time when a creator is trying to validate ProjectLive account with an OTP code, compare the times and make sure its not more than 5 mins//
          $datetime1 =$then;
          $time_diff=time()-$then;
          $time_diff=floor($time_diff/60);// divide the time by 60 mins, to covert to mins for verification//

          if ($time_diff < 5) { // if its less than 5 mins, ask creator to use the current otp again till it expires
            
            $otp_message="The previous OTP code sent to your phone is still valid and can be used untill after 5 minutes. Input the code below to 
            confirm your ProjectLive account. If your phone number has changed, make sure you 
            go to 'My Account' and update the new phone number & try again.";
            //$_SESSION['otp_message']=$otp_message;
          }


          // if OTP expires, that is,  sent for up to 5 mins, then send creator a new otp code again, and update the expired otp in the database on the same camapaign.//
          if ($time_diff >= 5) {
          $otp_message="A one time password (OTP) has been sent to your phone. Input the code below to confirm your ProjectLive account. If your phone number has changed, make sure you go to 'My Account' and update the new phone number.";
         //send OTP code to database//
          $otp=substr(mt_rand(), -5); // for this purpose this is random enuf//
          $sent_time=time();

          $sql="UPDATE `pl_otp_codes` 
          SET `otp_code`= '{$otp}',
              `sent_time`='{$sent_time}'
           WHERE `user_id`= '{$user_id}' AND `campaign_id`= '{$campaign_id}'";
          if(!$database->query($sql)){
                    echo 'ERROR_SENDING_OTP_CODE'; // make all ur systems errors display in this form//
                    exit();
          }
          $get_user_info=$database->query("SELECT * FROM `pl_users` WHERE `id`='{$user_id}'");
                $get_user_info=$database->fetch_array($get_user_info); 

                //send SMS Notification//
                $msg="Your OTP is $otp";
                $number=$get_user_info['phone'];
                $username = 'projectlive'; //your login username
                $password = 'passwordizicc0011,.,.'; //your login password
                $sender='Projectlive';
                $baseurl='https://api.loftysms.com/simple/sendsms';
                $url=$baseurl.'?username='.$username.'&password='.$password.'&sender='.$sender.'&recipient='.$number.'&message='.$msg;
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $exe = curl_exec($ch);
                curl_close($ch);

          }



        */

    


 ?>
        <div class="modal-header">
 
  <button type="button"  class="close" data-dismiss="modal">X</button>
                   
                   <h5 class="modal-title" id="myModalLabel2">Verify your ProjectLive account.  <i class="fa fa-check-circle text-theme-colored"></i> </h5>
                </div>

                <div class="modal-body">
                   <form class="form-horizontal" action="campaign-review" method="post">
                <fieldset>
               
                    <div class="input-group col-md-12"> 
                       <h6 class="alert alert-success"><?php echo $otp_message; // this variable shud also be set?> </h6> 
                       <label style="float:center">Enter one time password sent to you.<strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="A one time password (OTP) is a number code sent to you phone to verify your ProjectLive account before you can go live. Each code is valid for 10 minutes. "> </i></label>
    <input type="text" name="otp_code" required class="form-control" id="otp" placeholder="enter OTP code here">
                    </div></br>
                  
                    <input name="campaign_id" type="hidden" value="<?php echo $campaign_id ?>">
                    <input name="user_id" type="hidden" value="<?php echo $user_id ?>">
                    <div class="clearfix"></div>
                    <p class="center col-md-5">
                      <button type="submit" class="btn btn-dark btn-theme-colored">Verify & submit campaign</button>
                    </p>
                </fieldset>
            </form>
              
                
            </div>