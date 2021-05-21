<?php ob_start();?>
<?php session_start();?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/user.php'); ?>
<?php require_once('classes/smsAPI.php'); ?>


<?php	
	 		$error_array=array();
			$error_flag=false;
// post variables-assign them to the attributes of the class/
			$password=$_POST['password'];
			$cpassword=$_POST['cpassword'];	
			$user_name=$_POST['user_name'];	

			if (isset($password) && ($password=='')){
				$error_array[]='Please enter password.';
				$error_flag=true;
			}
			if (isset($password) && ($password=='')){
				$error_array[]='Please enter confirm password.';
				$error_flag=true;
			}
			
			if (isset($password) && (strlen($password)) < 6){
				$error_array[]='Your password should be atleast 6 characters long.';
				$error_flag=true;
			}
			if (strcmp($password, $cpassword) !==0){
				$error_array[]='Password and comfirm password are not the same.';
				$error_flag=true;
			}
			
		
		// if errors are found store the errors in a seesion//
			if ($error_flag){	
			$_SESSION['sess_errors']=$error_array;
			session_write_close();
			redirect_to('create-new-password');
			exit();
			}

			// hash the password, update and send user a notification//
			$password=sha1($password);
			
			if($database->query("UPDATE `pl_users` SET `password`='{$password}' WHERE `user_name`= '{$user_name}'")){
				if(!$phone=$database->query("SELECT `phone` FROM `pl_users` WHERE `user_name`= '{$user_name}'")){
				echo "ERROR_GETTING_PHONE_FOR_PASSWORD_CHANGE";
				exit();
				}
				$phone=$database->fetch_array($phone); // if query passes fine//
				$phone=$phone['phone'];

				$msg="Your account password has been changed successfully, please notify us immediately if you didn't initiate this change.  ";
                $number=$phone;
                $username = 'projectlive'; //your login username
                $password = 'passwordizicc0011,.,.'; //your login password
                $sender='Projectlive';
                $result = file_get_contents("https://api.loftysms.com/simple/sendsms?username=$username&password=$password&sender=$sender&recipient=$number&message=$msg");
                //echo $result = file_get_contents("https://api.loftysms.com/simple/sendsms?username=$username&password=$password&sender=$sender&recipient=$number&message=$msg");
                if(!$phone=$database->query("DELETE FROM `pl_password_codes` WHERE `user_name`= '{$user_name}'")){
				echo "ERROR_DELETING_USER_FROM_PASSWORD_CHANGE";
				exit();
				}
			$session->message("Your password has been successfully changed");

			redirect_to('sign-in-form');
			exit();

			}elseif (!$database->query("UPDATE `pl_users` SET `password`=$password WHERE `user_name`= $user_name")) {
				echo "ERROR_UPDATING PASSWORD";
			}
			else{
			$session->message("an error occured, password change was not completed, please try again later");
			redirect_to('create-new-password');
			exit();
			}

			
 ?>