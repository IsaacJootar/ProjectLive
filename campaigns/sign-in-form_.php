<?php ob_start();?>
<?php session_start();?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/user.php'); ?>


<?php	
	$error_array=array();
	$error_flag=false;
 // post variables-assign them to the attributes of the class/
	$user = new userManager();
	$user->user_name=$_POST['email'];
	$user->password =$_POST['password'];// harsh the password;
	
//Check for duplicate username
	$check_user=$database->query("SELECT  `user_name`,`password` FROM `pl_users` 
	WHERE `user_name`= '{$user->user_name}'
	 AND `password`='".sha1($user->password)."'");
	if($check_user){
		if($database->num_rows($check_user) < 1){
			$error_array[]='This username or password is wrong';
			$error_flag=true;
		}
	}
		
		// if errors are found store the error in a seesion//
	if ($error_flag)
	{	
		$_SESSION['sess_errors']=$error_array;
		session_write_close();
		redirect_to('sign-in-form');
		exit();
	}
  
?>
<?php

	$check_user2=$database->query("SELECT `id`, `first_name`, `user_name` FROM `pl_users`
		 WHERE `user_name`= '{$user->user_name}'
		 AND `password`='".sha1($user->password)."'");
	if($check_user2){
		if($database->num_rows($check_user2) == 1){
			session_regenerate_id();
			$check_user2 = $database->fetch_array($check_user2);
			$_SESSION['SESS_USER'] = $check_user2['user_name'];
			$_SESSION['FIRST_NAME'] = $check_user2['first_name'];
			$_SESSION['SESS_USER_ID'] = $check_user2['id'];
			$_SESSION['LAST_NAME'] = $check_user2['last_name'];
				//$session->message("Welcome  {$check_user2['user_name']}, you have successfully logged in")// hold on first;
			redirect_to('profile');
		exit();
		}
	}


	else{ echo 'an error occured'; }
 ?>