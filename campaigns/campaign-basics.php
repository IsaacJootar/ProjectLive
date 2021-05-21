<?php require_once('includes/header-login.php'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/campaign-basics.php'); ?>


<?php	//initialize error array and flag//
	 		$error_array=array();
			$error_flag=false;
			// putting a - in a campaign tittl  e is giving me issues wen i want to encode my urls, so I will remove it for now. Wil solve it letter//
			$campaign_tittle=str_replace('-', '. ', $database->escape_value($_POST['campaign_tittle']));
// post variables-assign them to the attributes of the class/
			$campaign_basics=campaignBasicsManager::find_by_id($_POST['campaign_id']);
			$campaign_basics ->campaign_tittle=ucwords(strtolower(trim(preg_replace('/\s+/',' ',   $campaign_tittle))));
			$campaign_basics ->id=$campaign_basics->id;
			$campaign_basics ->campaign_location =$_POST['campaign_location'];
			$campaign_basics ->campaign_video_link=$database->escape_value($_POST['campaign_video_link']);
			
			$campaign_basics ->campaign_category =$_POST['campaign_category'];
			$campaign_basics ->campaign_duration =$_POST['campaign_duration'];
		 // convert the number of days to seconds and then  add current time to make up the duration in seconds//
			$duedate=(60*60*24 * $campaign_basics ->campaign_duration );
			$campaign_basics ->campaign_due_date =$duedate+time();
    	
			$campaign_basics ->campaign_tagline =ucwords(strtolower($database->escape_value($_POST['area1'])));
			$campaign_basics ->campaign_beneficiary =ucwords(strtolower($_POST['campaign_beneficiary']));
			$campaign_basics ->beneficiary_type =$_POST['beneficiary_type'];

			//do not check for empty form fields, do not hinder hapharzard submission, allow creators build their campaign as they wish and at their pace-validate all input filelds only when about to go live finally//
		//Check if campaign duration was not set//


				if($_POST['campaign_duration']==0){ // shudnt be 0//
				$error_array[]='Please choose the number of days your campaign will run, it cannot be 0';
				$error_flag=true;
				}
		

			//Check for duplicate campaign tittle
			$get_tittle=$database->query("SELECT `campaign_tittle` FROM `pl_campaign_basics`
						 		   WHERE `campaign_tittle`='{$campaign_basics ->campaign_tittle}' AND `campaign_id`!= '{$campaign_basics ->campaign_id }'");

	
			if($get_tittle){
				if($database->num_rows($get_tittle) >=1){ // shudnt be more than one shall//
				$error_array[]='This campaign tittle has already been used by another campaign creator';
				$error_flag=true;
				}
			}
			// check campaign status to determine if to allow further 
			//update//
			$check_status=$database->query("SELECT `campaign_id` FROM `pl_campaign_review`
						 		   WHERE `campaign_id`='{$_POST['campaign_id']}'");
				// check, if campaign is in reveiw table, refuse edition//
	
			if($check_status){
				if($database->num_rows($check_status) >=1){
					$error_array[]='This campaign is already under review, you cannot make anymore changes! The review should take a maximum of 72 hours, please monitor your mail or phone for review notifications.  ';
				$error_flag=true;
				}
			}
				// check, if campaign is in thr ended table, refuse edition//
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


		// if errors are found store the error in a seesion//
			if ($error_flag){	
				$_SESSION['sess_errors']=$error_array;
				$_SESSION['campaign_id']=$campaign_basics ->campaign_id;
				$_SESSION['active_tab']=2;// 2  for default tab now for campaign basics
				session_write_close();
				redirect_to('create');
				exit();
			}
			// update the database//
			if($campaign_basics->update()){
			$session->message("Your campaign basic infomations have been updated  successfully");
			$_SESSION['campaign_id']=$_POST['campaign_id'];
			$_SESSION['active_tab']=2;
			redirect_to('create');
			exit();

			}
			else{
			$session->message("an error occured, campaign basics infomation could not be updated , please try again later");
			$_SESSION['campaign_id']=$_POST['campaign_id'];
			$_SESSION['active_tab']=2;// // return to ther default tab //
			redirect_to('create');
			exit();
			}
 ?>