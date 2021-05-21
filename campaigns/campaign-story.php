<?php require_once('includes/header-login.php'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/campaign-story.php'); ?>
<?php

			 global $database;
			 $check_id=$database->query("SELECT `id` 
			 							 FROM `pl_campaign_stories`
			 							 WHERE `campaign_id`= '{$_POST['campaign_id']}'");
	if($database->num_rows($check_id) > 0){

			 	$campaign_story=campaignStoryManager::find_by_id($_POST['campaign_id']);
			    $campaign_story ->story=$_POST['campaign_story'];
		        $campaign_story ->campaign_id=$_POST['campaign_id'];	
		        $campaign_story ->id=$campaign_story->id;
		        // check campaign status to determine if to allow further 
            //update//
            $check_status=$database->query("SELECT `campaign_id` FROM `pl_campaign_review`
                                   WHERE `campaign_id`='{$_POST['campaign_id']}'");

    
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



// errors are found store the errors in a seesion//
            if ($error_flag){   
            $_SESSION['sess_errors']=$error_array;
            $_SESSION['campaign_id']=$campaign_story ->campaign_id;
			$_SESSION['active_tab']=1;// 2  for default tab now
            session_write_close();
            redirect_to('create');
            exit();
            }


		        if($campaign_story->update()){
			$session->message("Your campaign story has been updated  successfully");
			$_SESSION['campaign_id']=$_POST['campaign_id'];
			$_SESSION['active_tab']=1;//
			redirect_to('create');
			exit();

			}
			else{
			$session->message("Your campaign story hasn't change and is saved successfully");
			$_SESSION['campaign_id']=$_POST['campaign_id'];
			$_SESSION['active_tab']=1;//
			redirect_to('create');
			exit();
			}
	
	}

// post variables-assign them to the attributes of the class/
			 
//donot check for empty form fields, do not hinder hapharzard submission, allow creators build their campaign as they wish and at their pace-validate all input filelds only when about to go live finally//
if($database->num_rows($check_id) < 1){
		$campaign_story=new campaignStoryManager();
		$campaign_story ->story=$_POST['campaign_story'];
		$campaign_story ->campaign_id=$_POST['campaign_id'];	
		$campaign_story ->id=$campaign_story->id;


		        if($campaign_story->create()){
			$session->message("Your campaign story has been updated  successfully");
			$_SESSION['campaign_id']=$_POST['campaign_id'];
			$_SESSION['active_tab']=1;//
			redirect_to('create');
			exit();

			}
			else{
			$session->message("Your campaign story hasn't change and is saved successfully");
			$_SESSION['campaign_id']=$_POST['campaign_id'];
			$_SESSION['active_tab']=1;//
			redirect_to('create');
			exit();
			}
	
	}

 ?>