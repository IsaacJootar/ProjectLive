<?php ob_start(); ?>
<?php session_start();?>
<?php error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); 
 // show header according to sessions
  if(isset($_SESSION['SESS_USER'])){include('includes/header-login.php');}else {
    include('includes/header.php');} ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('campaigns/classes/database.php'); ?>
<?php require_once('campaigns/classes/database-object.php'); ?>
<?php require_once('campaigns/classes/functions.php'); ?>
<?php require_once('campaigns/classes/campaign-basics.php'); ?>
<?php require_once('campaigns/classes/campaigns.php'); ?>
<?php require_once('campaigns/classes/campaign-photos.php'); ?>
<?php require_once('campaigns/classes/campaign-goal.php'); ?>
<?php require_once('campaigns/classes/campaign-story.php'); ?>
<?php require_once('campaigns/classes/user.php'); ?>
<?php require_once('classes/session.php'); ?>


<?php	//initialize error array and flag//
	 		$error_array=array();
			$error_flag=false;

		// if errors are found store the error in a seesion//
			$campaign_id=$_POST['campaign_id'];
			$report=$database->escape_value($_POST['report']);
			$phone=$_POST['phone'];
			$name=$database->escape_value($_POST['name']);
			$query=$database->query("INSERT INTO `pl_report_campaigns` (`name`, `report`, `phone`, `campaign_id`) VALUES ('{$name}', '{$report}', '{$phone}', '{$campaign_id}')");
			
			if($query){
			$_SESSION['campaign_id']=$campaign_id;
			$session->message("Your Report has been  successfully submitted"); //this message is messing up
			redirect_to('report-campaign');
			exit();

			}
			else{
			$session->message("There was an error processing your report, please try again later");
			$_SESSION['campaign_id']=$campaign_id; // for the modal//
			redirect_to('report-campaign');
			exit();
			}
 ?>