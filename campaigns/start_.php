<?php ob_start();?>
<?php session_start();?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/campaigns.php'); ?>
<?php require_once('classes/campaign-basics.php'); ?>
<?php require_once('classes/campaign-goal.php'); ?>
<?php require_once('classes/campaign-photos.php'); ?>


<?php		//initialize error array and flag//
	 		$error_array=array();
			$error_flag=false;
// post variables
			$campaigns=new campaignsManager();
		    $campaigns->user_id=$_SESSION['SESS_USER_ID'];
			$campaign_code=md5(uniqid($_SESSION['SESS_USER_ID'])) ;
			$campaigns->campaign_code='PL-'. strtoupper(substr($campaign_code, -7));
			$campaigns->campaign_category=$_POST['campaign_category'];
			
			
			

			$campaign_basics=new campaignBasicsManager();
			// putting a - in a campaign titte is giving me issues wen i want t0 enc0de my urls, so I will rem0ve it f0r n0w. Wil solve it letter//
			$campaign_tittle=str_replace('-', '. ', $_POST['campaign_tittle']);


			//  remove extra spaces, as well as leading and trailing spaces.
			$campaign_basics ->campaign_tittle=ucwords(strtolower(trim(preg_replace('/\s+/',' ',  $database->escape_value($campaign_tittle)))));
			$campaign_basics->campaign_category=$_POST['campaign_category'];
			$campaign_basics->campaign_creation_date=date('M j, Y');

			$campaign_goals=new campaignGoalManager();
			$campaign_goals->amount =$_POST['campaign_goal']; // amount
			$campaign_code=md5(uniqid($_SESSION['SESS_USER_ID'])) ;
			$campaign_goals->campaign_code='PL-'. strtoupper(substr($campaign_code, -7)); // campaign code

			$campaign_photos=new campaignPhotoManager();
			$campaign_code=md5(uniqid($_SESSION['SESS_USER_ID'])) ;
			$campaign_photos->campaign_code='PL-'. strtoupper(substr($campaign_code, -7)); // campaign code
			$campaign_photos->user_id=$_SESSION['SESS_USER_ID'];

			
			if (isset($_POST['campaign_tittle']) && ($_POST['campaign_tittle']=='')){
				$error_array[]=' Please enter your campaign_tittle';
				$error_flag=true;
			}
			if (isset($_POST['campaign_cat']) && ($_POST['campaign_cat']=='')){
				$error_array[]='Please enter your campaign  category';
				$error_flag=true;
			}
			
			if (isset($_POST['campaign_goal']) && ($_POST['campaign_goal'] < 2000)){
				$error_array[]='Campaign goal cannot be less than ₦2,000';
				$error_flag=true;
			}
			
	
//Check for duplicate username
			$get_tittle=$database->query("SELECT `campaign_tittle` FROM `pl_campaign_basics`
						 		   WHERE `campaign_tittle`='{$campaign_basics->campaign_tittle}'");

	
			if($get_tittle){
				if($database->num_rows($get_tittle) >=1){
					$error_array[]='This campaign tittle has already been used by another campaign creator';
				$error_flag=true;
				}
			}
		
		// if errors are found store the errors in a seesion//
			if ($error_flag){	
			$_SESSION['sess_errors']=$error_array;
			session_write_close();
			redirect_to('start');
			exit();
			}
		// create the campaign, then get the campaign ID and up create its instance in the other tables//
			if($campaigns->create()){
				global $database; // include the database//
				//update the campaign state//
				
		         $campaign_id=$database->insert_id();
				//update campaign state// 
				$campaign_basics->campaign_id=$campaign_id;
				$campaign_basics->campaign_state='build up';
				$campaign_goals->campaign_id=$campaign_id;
				$campaign_photos->campaign_id=$campaign_id;
				$campaign_basics->create();
				$campaign_goals->create();
				$campaign_photos->create();
				$_SESSION['campaign_id']=$campaign_id;
				$_SESSION['active_tab']=2;// 2  for default tab now
				
			$session->message("You can continue building '{$campaign_basics->campaign_tittle }' campaign here");
			redirect_to('create');
			exit();

			}
			else{
			$session->message("an error occured, campaign page could not be set up, please try again later");
			redirect_to('start');
			exit();
			}
 ?>