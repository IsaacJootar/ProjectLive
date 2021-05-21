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
			$user->first_name = $database->escape_value($_POST['first_name']);
			$user->last_name =$database->escape_value($_POST['last_name']);
			$user->user_name=$database->escape_value($_POST['email']);
			$user->password =sha1($_POST['password']);// harse the password;
			$user->phone=$database->escape_value($_POST['phone']);	

			if (isset($user->first_name) && ($user->first_name=='')){
				$error_array[]='first name is missing';
				$error_flag=true;
			}
			if (isset($user->last_name) && ($user->last_name=='')){
				$error_array[]='Last name is missing';
				$error_flag=true;
			}
			if (isset($user->user_name) && ($user->user_name=='')){
				$error_array[]='Email Adress is missing';
				$error_flag=true;
			}
			if (isset($user->phone) && ($user->phone=='')){
				$error_array[]='Your Phone Number is missing';
				$error_flag=true;
			}

			
	
//Check for duplicate username
			$check_user=$database->query("SELECT `user_name` FROM `pl_users` WHERE `user_name`= '{$user->user_name}'");
			if($check_user){
				if($database->num_rows($check_user)== 1){
					$error_array[]='This username has already been taken';
					$error_flag=true;
				}
			}
		
		// if errors are found store the errors in a seesion//
			if ($error_flag){	
			$_SESSION['sess_errors']=$error_array;
			session_write_close();
			redirect_to('sign-up-form');
			exit();
			}

			if($user->create()){
			$session->message("Your account has been successfully created");
			redirect_to('sign-in-form');
			exit();

			}
			else{
			$session->message("an error occured, sign-up was not completed, please try again later");
			redirect_to('sign-up-form');
			exit();
			}
 ?>