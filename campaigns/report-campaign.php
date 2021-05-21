<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>


<?php	//initialize error array and flag//
	 		$error_array=array();
			$error_flag=false;

		// if errors are found store the error in a seesion//
			$campaign_id=$_POST['campaign_id'];
			$report=trim($_POST['report']);
			$phone=$_POST['phone'];
			$query=$database->query("INSERT INTO `pl_report_campaigns` (`report`, `phone`) VALUES ('{$report}', '{$phone}')");
			
			if($query){
			//$session->message("Your Report has been  successfully submitted"); this message is messing up
			$_SESSION['modal_campaign_id']=$campaign_id; // for the modal//
			redirect_to('campaign-page-details');
			exit();

			}
			else{
			//$session->message("There was an error processing your report, please try again later");
			$_SESSION['modal_campaign_id']=$campaign_id; // for the modal//
			redirect_to('campaign-page-details');
			exit();
			}
 ?>