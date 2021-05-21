<?php ob_start(); ?>
<?php session_start();?>
<?php error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); 
 // show header according to sessions
include('includes/header-login.php'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/smsAPI.php'); ?>
<?php require_once('classes/user.php'); ?>>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>






<?php	
	$error_array=array();
	$error_flag=false;
 // post variables-assign them to the attributes of the class/
	$user = new userManager();
	$user->user_name=$database->escape_value($_POST['email']);
	
//Check for duplicate username
	$check_user=$database->query("SELECT  `user_name`, `phone`, `first_name` FROM `pl_users` 
	WHERE `user_name`= '{$user->user_name}'");
	$phone=$database->fetch_array($check_user);
	$phone=$phone['phone'];
	if($check_user){
		if($database->num_rows($check_user) !=1){
			$error_array[]='This e-Mail is not associated with any account on ProjectLive.';
			$error_flag=true;
		}
	}
		
		// if errors are found store the error in a seesion//
	if ($error_flag)
	{	
		$_SESSION['sess_errors']=$error_array;
		session_write_close();
		redirect_to('recover-password');
		exit();
	}
  
?>
<?php

		if($database->num_rows($check_user) == 1){
			session_regenerate_id();
			$check_user = $database->fetch_array($check_user);
			//$number= $check_user['phone'];
			$code=substr(mt_rand(), -5); // for this purpose this is random enuf//
          	$sent_time=time();

          $sql="INSERT INTO `pl_password_codes`(`user_name`,`code`, `sent_time`) VALUES ('{$user->user_name}', '{$code}', '{$sent_time}')";
          if(!$database->query($sql)){
                    echo 'ERROR_SENDING_OTP_TO_DATABASE'; // make all ur systems errors display in this format//
                    exit();
          }
          $_SESSION['number']=$phone;
          	$_SESSION['code']=$code;
          $session->message("Hello {$check_user['first_name']}, to create a new password, enter the code sent to your phone to verify your account.");
			redirect_to('verify-contact');
		exit();
		}


	else{ echo 'AN_ERROR_OCCURED_COULD_NOT_RECOVER_USER'; }
 ?>