<?php require_once('includes/header-login.php'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/campaign-review.php'); ?>
<?php require_once('classes/smsAPI.php'); ?>


<?php	//initialize error array and flag//
	 		$error_array=array();
			$error_flag=false;


			 $otp_code=$_POST['otp_code'];
			 $user_id=$_POST['user_id'];
			 $campaign_id=$_POST['campaign_id']; // campaign id
			 //Verify account//
  // check if the OTP is correct//
			$sql_sent_time=$database->query("SELECT  `otp_code`, `sent_time` FROM `pl_otp_codes` WHERE `user_id`='{$user_id}' AND `campaign_id`= '{$campaign_id}' AND `otp_code`= '{$otp_code}'");// check query for exceptions always-but I feel lazy now, come back later//
			
			if($database->num_rows($sql_sent_time) < 1){
				$error_array[]='OTP code is wrong. Please ensure you are typing in the correct code. Try submitting campaign again.';
				$error_flag=true;
			}
			
			  // check if the OTP is correct but expired//
            //if otp has not been sent for this campaign ID yet//
          $sql_sent_time=$database->query("SELECT  `sent_time` FROM `pl_otp_codes` WHERE `user_id`='{$user_id}' AND `campaign_id`= '{$campaign_id}'");// check query for errors always-but am lazy now, come back later//
     if($database->num_rows($sql_sent_time) >=1){ 
          // get the time when otp code was sent to creator and stored//
          $get_sent_time=$database->fetch_array($sql_sent_time); 
          $then = $get_sent_time['sent_time']; //that is then, to be compared with now//
          // This is now, time when a creator is trying to validate ProjectLive account with an OTP code, compare the times and make sure its not more than 5 mins//
          $datetime1 =$then;
          $time_diff=time()-$then;
          $time_diff=floor($time_diff/60);// divide the time by 60 mins, to covert to mins for verification//

          if ($time_diff > 5) { // if its less than 5 mins, ask creator to use the current otp again till it expires
            
            $error_array[]='OTP code is expired. Please re-submit your campaign to generate a new OTP code.';
				$error_flag=true;
          }
     }		
// post variables-assign them to the attributes of the class
			$campaign_review=new campaignReviewManager();
			$campaign_review->campaign_id=$_POST['campaign_id'];
			$campaign_review->date=date('M j, Y h:i:s A'); //date the campaign was submitted for review, this date makes the vetting team know its still within the 72 hours period //

			//check to refuse alowance for editing campaign, if a campaign is already in review process.//
			$check_status=$database->query("SELECT `campaign_id` FROM `pl_campaign_review`
						 		   WHERE `campaign_id`='{$campaign_review->campaign_id}'");


	
			if($check_status){
				if($database->num_rows($check_status) >=1){
					$error_array[]='This campaign is already under review, you cannot make anymore changes! The review should take a maximum of 72 hours at most, please monitor your mail or phone for review notifications.  ';
				$error_flag=true;
				}
			}

			$check_status2=$database->query("SELECT `campaign_id` FROM `pl_ended_campaigns`
						 		   WHERE `campaign_id`='{$_POST['campaign_id']}'");

	
			if($check_status2){
				if($database->num_rows($check_status2) >=1){
					$error_array[]='This campaign due date has already expired, you cannot make anymore changes! You can only create a new project if you wish.  ';
				$error_flag=true;
				}
			}


			// check, if campaign is in live tables, refuse edition//

			$check_status3=$database->query("SELECT `campaign_id` FROM `pl_live_campaigns`
						 		   WHERE `campaign_id`='{$_POST['campaign_id']}'");

	
			if($check_status3){
				if($database->num_rows($check_status3) >=1){
					$error_array[]='This campaign is ongoing and you cannot make anymore changes!.  ';
				$error_flag=true;
				}
			}



			// if errors are found store the errors in a seesion//
			if ($error_flag){	
			$_SESSION['sess_errors']=$error_array;
			$_SESSION['campaign_id']=$campaign_review ->campaign_id;
			$_SESSION['active_tab']=5;// 2  for default tab now
			session_write_close();
			redirect_to('create');
			exit();
			}

			
			if($campaign_review->create()){
				// update the basics table, to reflect campaign state. its now under review//
				$campaign_state='review'; // i hate doing this//
				$query=$database->query("UPDATE `pl_campaign_basics` SET `campaign_state`= '{$campaign_state}' WHERE `campaign_id`='{$_POST['campaign_id']}'");
				
				//check if this campaign was rejected, if yes, remove it from that state and let it only be under review//

				if(!$check_status4=$database->query("SELECT `campaign_id` FROM `pl_declined_campaigns`
						 		   WHERE `campaign_id`='{$_POST['campaign_id']}'")){
					echo 'ERROR_VERIFYING_CAMPAIGN_STATE';
				}

	
			if($check_status4){
				if($database->num_rows($check_status4) >=1){
				$remove_campaign="DELETE  FROM  `pl_declined_campaigns` 
                                   WHERE `campaign_id`='{$_POST['campaign_id']}'";
			        if(!$remove_campaign=$database->query($remove_campaign)){
			            echo 'ERROR_REMOVING_CAMPAIGN_FROM_DECLINED_STATE';
			            exit();
			        }
				}
			}

				
				$session->message("Your campaign has been submitted for review, this process takes a maximum of 72 hours and can be less. Please note that you cannot make anymore changes to your campaign build up. An e-Mail will be sent to you concerning your campaign status and also a notification will be sent to your mobile phone. Make sure your account profile uses your real email and mobile number to receive notifications.  ");
				$_SESSION['campaign_id']=$_POST['campaign_id'];
				$_SESSION['active_tab']=5;// 2  for default tab now
				
			//send projectlive an SMS notification for pending campaigns//
			
				$get_user=$database->query("SELECT `user_id` FROM `pl_campaigns` WHERE `id`='{$_SESSION['campaign_id']}'");
                $get_user=$database->fetch_array($get_user);
                $get_user=$get_user['user_id'];
                $get_user_info=$database->query("SELECT * FROM `pl_users` WHERE `id`='{$get_user}'");
                $get_user_info=$database->fetch_array($get_user_info);  
                $get_user_name=$get_user_info['first_name'];

                //send SMS Notification//
                $msg="Hello izzic,  $get_user_name has just submitted a campaign for review";
                $number='08069168444';
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
 
			redirect_to('create');
			exit();

			}
			else{
			$session->message("an error occured, campaign submission was not successful, please try again later");
			$_SESSION['campaign_id']=$campaign_id;
			$_SESSION['active_tab']=5;// 2  for default tab now
			redirect_to('create');
			exit();
			}
 ?>