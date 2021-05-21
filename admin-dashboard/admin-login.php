<?php ob_start();?>
<?php session_start();?>
<?php require_once('../campaigns/classes/database.php'); ?>
<?php require_once('../campaigns/classes/database-object.php'); ?>
<?php require_once('../classes/functions.php'); ?>
<?php require_once('../classes/session.php'); ?>
<?php require_once('classes/user.php'); ?>


<?php	
	$error_array=array();
	$error_flag=false;
 // post variables-assign them to the attributes of the class/
	$user = new adminManager();
	 $user->username=$_POST['username'];
	 $user->password =$_POST['password'];// harsh the password;
	
//Check for duplicate username
	$check_user=$database->query("SELECT  `username`,`password` FROM `pl_admin` 
	WHERE `username`= '{$user->username}'
	 AND `password`='".sha1($user->password)."'");
	if($check_user){
		if($database->num_rows($check_user) !=1){
			$error_array[]='This username/password is wrong';
			$error_flag=true;
		}
	}
		
		// if errors are found store the error in a seesion//
	if ($error_flag)
	{	
		$_SESSION['sess_errors']=$error_array;
		session_write_close();
		header("Location: zoe-life");
		exit();
	}
  
?>
<?php

	$check_user2=$database->query("SELECT `id`, `username`, `password` FROM `pl_admin`
		 WHERE `username`= '{$user->username}'
		 AND `password`='".sha1($user->password)."'");
	if($check_user2){
		if($database->num_rows($check_user2) == 1){
			session_regenerate_id();
			$check_user2 = $database->fetch_array($check_user2);
			$_SESSION['SESS_USERNAME'] = $check_user2['username']; //same session names and id with match wit other sessions-bad stuff.
			$_SESSION['SESS_ID'] = $check_user2['id'];
			$session->message("Welcome  {$check_user2['username']}, you are successfully logged in");
		 header("Location:home");
		exit();
		}
	}


	else{ echo 'UNSUCCESSFUL_LOGIN_AN_ERROR_OCCURED_'; }
 ?>