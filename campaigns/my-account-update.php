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

// post variables-assign them to the attributes of the class/
			$user=userManager::find_user_by_id($user_id);
			// post variables-assign them to the attributes of userclass/
	
			$user->first_name = $database->escape_value($_POST['first_name']);
			$user->last_name =$database->escape_value($_POST['last_name']);
			$user->user_name=$database->escape_value($_POST['user_name']); // username
			$user->phone=$database->escape_value($_POST['phone']);
			$user->state=$_POST['state'];
			$user->country=$_POST['country'];	
			$user->gender=$_POST['gender'];	

			if (isset($user->first_name) && ($user->first_name=='')){
				$error_array[]='first name is missing';
				$error_flag=true;
			}
			if (isset($user->phone) && ($user->phone=='')){
				$error_array[]='phone number is missing';
				$error_flag=true;
			}
			if (isset($user->last_name) && ($user->last_name=='')){
				$error_array[]='Last name is missing';
				$error_flag=true;
			}
			if (isset($user->user_name) && ($user->user_name=='')){
				$error_array[]='Email Adress/user name is missing';
				$error_flag=true;
			}
			if (isset($user->state) && ($user->state=='')){
				$error_array[]='State is missing';
				$error_flag=true;
			}
			if (isset($user->country) && ($user->country=='')){
				$error_array[]='Country is missing';
				$error_flag=true;
			}

			
	
//Check for duplicate username
			$check_user=$database->query("SELECT `id`, `user_name` FROM `pl_users` WHERE `user_name`= '{$user->user_name}' AND `id` != '{$user->id}'");
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
			redirect_to('my-account');
			exit();
			}

			if($user->update()){
			$session->message("Your account has been successfully updated");
			redirect_to('my-account');
			exit();

			}
			else{
			$session->message("No changes were made to your account details");
			redirect_to('my-account');
			exit();
			}
 ?>