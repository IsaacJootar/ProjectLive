<?php require_once('includes/header-login.php'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/campaign-bank-details.php'); ?>
<?php

			 global $database;
			$check_id=$database->query("SELECT `id`, `campaign_id`
			 							 FROM `pl_campaign_bank_details`
			 							 WHERE `campaign_id`= '{$_POST['campaign_id']}'");
	if($database->num_rows($check_id) > 0){

		 	$campaign_bank_deatils=campaignBankManager::find_by_id($_POST['campaign_id']);
		    $campaign_bank_deatils ->bank_name=$database->escape_value($_POST['bank_name']);
		    $campaign_bank_deatils ->account_number=$_POST['account_number'];
	        $campaign_bank_deatils ->campaign_id=$_POST['campaign_id'];	
	        $campaign_bank_deatils ->id=$campaign_bank_deatils->id;


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
					$error_array[]='This campaign due date has already sxpired, you cannot make anymore changes! You can only create a new project if you wish.  ';
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
				$_SESSION['campaign_id']=$campaign_bank_deatils ->campaign_id;
				$_SESSION['active_tab']=3;// 2  for default tab now for campaign basics
				session_write_close();
				redirect_to('create');
				exit();
			}


		if($campaign_bank_deatils->update()){
			$session->message("Your campaign bank details has been updated  successfully");
			$_SESSION['campaign_id']=$_POST['campaign_id'];
			$_SESSION['active_tab']=3;//
			redirect_to('create');
			exit();

			}
			else{
			$session->message("Your campaign  bank account details hasn't change and is saved successfully");
			$_SESSION['campaign_id']=$_POST['campaign_id'];
			$_SESSION['active_tab']=3;//
			redirect_to('create');
			exit();
		}
	
	}

// post variables-assign them to the attributes of the class/
			 
//do not check for empty form fields, do not hinder hapharzard submission, allow creators build their campaign as they wish and at their pace-validate for empty fields only when about to go live finally//
if($database->num_rows($check_id) < 1){
			$campaign_bank_deatils=new campaignBankManager();
			$campaign_bank_deatils ->bank_name=$_POST['bank_name'];
			$campaign_bank_deatils ->account_number=$_POST['account_number'];
			$campaign_bank_deatils ->campaign_id=$_POST['campaign_id'];	
			$campaign_bank_deatils ->id=$campaign_story->id;



		if($campaign_bank_deatils->create()){
			$session->message("Your campaign  bank account details hasn't change and is saved successfully");
			$_SESSION['campaign_id']=$_POST['campaign_id'];
			$_SESSION['active_tab']=3;//
			redirect_to('create');
			exit();

			}
			else{
			$session->message("Your campaign bank account details hasn't change and is saved successfully");
			$_SESSION['campaign_id']=$_POST['campaign_id'];
			$_SESSION['active_tab']=3;//
			redirect_to('create');
			exit();
		}
	
	}

 ?>