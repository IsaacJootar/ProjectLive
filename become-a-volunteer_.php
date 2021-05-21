<?php ob_start(); ?>
<?php session_start();?>
<?php error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); 
 // show header according to sessions
  if(isset($_SESSION['SESS_USER'])){include('includes/header-login.php');}else {
    include('includes/header.php');} ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/volunteer.php'); ?>
<?php require_once('classes/smsAPI.php'); ?>


<?php	
	 		$error_array=array();
			$error_flag=false;
// post variables-assign them to the attributes of the class/
			$volunteer = new volunteerManager();
			$volunteer->name = $database->escape_value($_POST['name']);
			$volunteer->email =$database->escape_value($_POST['email']);
			$volunteer->phone=$_POST['phone'];
			$volunteer->password=sha1($_POST['password']);
			$volunteer->state=$_POST['state'];	// volunteering state//
			$volunteer->gender=$_POST['gender'];
			$volunteer->message=$database->escape_value($_POST['message']);
			$volunteer->date=date('M j, Y');	

			
			if (isset($volunteer->name) && ($volunteer->name=='')){
				$error_array[]='name is missing';
				$error_flag=true;
			}
			if (isset($volunteer->email) && ($volunteer->email=='')){
				$error_array[]='Email is missing';
				$error_flag=true;
			}
			if (isset($volunteer->phone) && ($volunteer->phone=='')){
				$error_array[]='Phone Number is missing';
				$error_flag=true;
			}
			
	
//Check for duplicate username
			$check_volunteer=$database->query("SELECT `name` FROM `pl_volunteers` WHERE `name`= '{$volunteer->name}'");
			if($check_volunteer){
				if($database->num_rows($check_volunteer) > 1){
					$error_array[]='This exact name has already been used by another volunteer. ';
					$error_flag=true;
				}
			}
		
		// if errors are found store the errors in a seesion//
			if ($error_flag){	
			$_SESSION['sess_errors']=$error_array;
			session_write_close();
			redirect_to('become-a-volunteer');
			exit();
			}

			if($volunteer->create()){
			$session->message("Your Application has been submitted, we will get back to you as soon as possible. You can login and upload your photo that will appear on our volunteer page. Thank you");
			
                //send SMS Notification//
                $name=$_POST['name'];
                $state =$_POST['state'];
                $msg="Hello Izicc,  $name has just signed up as a volunteer for $state";
                $number='09059599226';
                $username = 'projectlive'; //your login username
                $password = '001100110011..,,..,,'; //your login password
                $sender='Projectlive';
                $baseurl='https://api.loftysms.com/simple/sendsms';
                $url=$baseurl.'?username='.$username.'&password='.$password.'&sender='.$sender.'&recipient='.$number.'&message='.$msg;
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $exe = curl_exec($ch);
                curl_close($ch);
			redirect_to('become-a-volunteer');
			exit();

			}
			else{
			$session->message("an error occured, volunteer sign-up was not completed, please try again later");
			redirect_to('become-a-volunteer');
			exit();
			}
 ?>