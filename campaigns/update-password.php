<?php ob_start(); ?>
<?php session_start(); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/user.php'); ?>
<?php	//initialize error array and flag//
	 		$error_array=array();
			$error_flag=false;
			$user_id= $_POST['user_id'];
	
			$former_pass =sha1($_POST['former_pass']); // harse the pasword bfor comparing, but shudnt it be even better un harsing and then comparing, well..//;
			$new_pass = sha1($_POST['new_pass']);
			// get the global database//
			global $database;

			$sql=$database->query("SELECT `password` FROM `pl_users` WHERE `password` = '{$former_pass}' AND `id` ='{$user_id}'");

		   if($values=$database->num_rows($sql)< 1){
			$error_array[]=' Old password supplied is incorrect!';
			$error_flag=true;
		  	}
					
			// if errors are found store the errors in a seesion//
			if ($error_flag){	
			$_SESSION['sess_errors']=$error_array;
			session_write_close();
			redirect_to('my-account');
			exit();
			}
			if ($database->num_rows($sql) == 1){ // password may be same for multiply users but the user id is additional check-I may come back later, am tired now. 
			$query=$database->query("UPDATE `pl_users` 
						SET password='{$new_pass}'
					WHERE `id`= '{$user_id}'");
					
			
					
			} // end else


		$session->message("Password has been changed successfully ");
						redirect_to("my-account.php");
						exit();
								

 ?>