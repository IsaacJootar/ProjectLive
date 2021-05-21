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
<?php require_once('classes/campaign-donations.php'); ?>


<?php	//initialize error array and flag//
$error_array=array();
$error_flag=false;
if(isset($_SESSION['SESS_USER_ID'])){$user_id=$_SESSION['SESS_USER_ID'];}
	else{
   $user_id='';
}
			//if user is logged in during donating, capture the ID/

// putting a (-) in a campaign tittle is giving me issues wen i want to encode my urls, so I will remove it for now. Wil solve it later//
// post variables-assign them to the attributes of the class//
$campaign_donations=new campaignDonationManager();
$campaign_donations->campaign_id=$_POST['campaign_id'];
$campaign_donations ->user_id=$user_id;
$campaign_donations ->identity_of_donor=$_POST['donor_identity'];
$campaign_donations ->donation_amount =$_POST['donor_amount'];
$campaign_donations ->name_of_donor =$_POST['donor_name'];	
$campaign_donations ->phone_of_donor =$_POST['donor_phone'];
$campaign_donations ->email_of_donor =$_POST['donor_email'];
$campaign_donations ->comment_of_donor =$_POST['donor_comment'];
$campaign_donations ->comment_of_donor =$_POST['donor_comment'];
$campaign_donations ->donation_date =$_POST['donation_date']=date('M j, Y h:i:s A');

// get the category of this campaign-i need it
global $database;
$get_campaign_category=$database->query("SELECT `campaign_category` from `pl_campaign_basics` WHERE `campaign_id`='{$campaign_donations->campaign_id}'");
$get_campaign_category=$database->fetch_array($get_campaign_category);
$campaign_donations->campaign_category=$get_campaign_category['campaign_category'];

			//Check for empty fields//

if (isset($campaign_donations->donation_amount) && ($campaign_donations->donation_amount=='')){
				$error_array[]='Pease Enter Donation amount';
				$error_flag=true;
}
if (isset($campaign_donations->name_of_donor) && ($campaign_donations->name_of_donor=='')){
				$error_array[]='Please Enter Name of donor';
				$error_flag=true;
}
if (isset($campaign_donations->phone_of_donor) && ($campaign_donations->phone_of_donor=='')){
				$error_array[]='Please Enter Phone Number of donor';
				$error_flag=true;
}
if (isset($campaign_donations->email_of_donor) && ($campaign_donations->email_of_donor=='')){
				$error_array[]='Please Enter email of donor';
				$error_flag=true;
}
			
// if errors are found store the error in a seesion//
if ($error_flag){	
	$_SESSION['sess_errors']=$error_array;
	$_SESSION['campaign_id']=$campaign_donations->campaign_id;
	session_write_close();
	redirect_to('campaign-donation-page');
	exit();
}
// query he database//
if($campaign_donations->create()){
	$_SESSION['name_of_donor']=$campaign_donations->name_of_donor;
	$_SESSION['campaign_tittle']=$_POST['campaign_tittle'];
//s$session-> message("Your donation is successfully processed");
redirect_to('campaign-donation-page-success'); 
exit();
}
?>