<?php require_once('includes/header-login.php'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/campaign-goal.php'); ?>


<?php	//initialize error array and flag//
	 		$error_array=array();
			$error_flag=false;

// post variables-assign them to the attributes of the class/
			$campaign_goal=campaignGoalManager::find_by_id($_POST['campaign_id']);
			$campaign_goal ->amount=$_POST['campaign_goal'];
			$campaign_goal ->id=$campaign_goal->id;
//donot check for empty form fields, do not hinder hapharzard submission, allow creators build their campaign as they wish and at their pace-validate all input filelds only when about to go live finally//


		
			if (isset($campaign_goal->campaign_goal) && ($campaign_goal->campaign_goal< 2000)){
				$error_array[]='Campaign goal minimum amount is ₦2,000';
				$error_flag=true;
			}
			

			// check campaign status to determine if to allow further 
			//update//
			$check_status=$database->query("SELECT `campaign_id` FROM `pl_campaign_review`
						 		   WHERE `campaign_id`='{$_POST['campaign_id']}'");

	
			if($check_status){
				if($database->num_rows($check_status) >=1){
					$error_array[]='This campaign is already under review, you cannot make anymore changes! The review should take a maximum of 72 hours, please monitor your mail or phone for review notifications.  ';
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

		// if errors are found store the error in a seesion//
			if ($error_flag){	
				$_SESSION['sess_errors']=$error_array;
				$_SESSION['campaign_id']=$campaign_goal ->campaign_id;
				$_SESSION['active_tab']=4;// 2  for default tab now for campaign basics
				session_write_close();
				redirect_to('create');
				
				exit();
			}
			
			if($campaign_goal->update()){
			$session->message("Your campaign goal has been updated  successfully");
			$_SESSION['campaign_id']=$_POST['campaign_id'];
			$_SESSION['active_tab']=4;// comment later pls, am busy
			redirect_to('create');
			exit();

			}
			else{
			$session->message("Your campaign goal hasn't change and is saved successfully");
			$_SESSION['campaign_id']=$_POST['campaign_id'];
			$_SESSION['active_tab']=4;//
			redirect_to('create');
			exit();
			}
 ?>