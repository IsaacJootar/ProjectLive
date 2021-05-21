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
<?php 
// i dont like the idea of querying the database again for this campaign_id, i will get it from the session variable from the previous page later/ am feeling lazy for now//


//get campaign id and supply to the method for campaign details//
  if(isset($_SESSION['campaign_id'])){
    $set_campaign_id=  $_SESSION['campaign_id'];
  }
elseif(isset($_GET['ref'])){
         $campaign_tittle=str_replace('-', ' ', $_GET['ref']); // remove the dashes from the tittle//
         $campaign_id=$database->query("SELECT `campaign_id` FROM `pl_campaign_basics` WHERE `campaign_tittle`= '{$campaign_tittle}'");
        $campaign_id=$database->fetch_array($campaign_id);
        $set_campaign_id=$campaign_id['campaign_id'];
      }

      else {$session->message("Campaign id reset, please fill the informations and submit again");
      header('location:../sign-in-form');
      exit();
    }
?>

 <!-- Start main-content -->
<br /> <br /> <br /><br /> 
<div class="main-content">
   <!-- Divider: Campaign Page details -->
<?php
                    if ((output_message($message))){
               echo   '<div class="alert alert-success">';
                   echo ' <button type="button" class="close" data-dismiss="alert">&times;</button>';
                   
                   echo output_message($message); 
               echo ' </div>';
                 unset ($message);
                 }
              ?>
    <section>
         <div class="container">
     <h5 align="left" font-weight-500>You are reporting this campaign</h5>
      <?php
  
    $campaign_basics=campaignBasicsManager::find_by_id($set_campaign_id);
    $get_user=campaignsManager::find_user_by_campaign_id($set_campaign_id);
    $get_user_name=userManager::find_user_by_id($get_user->user_id);
    $get_campaign_story=campaignStoryManager::find_campaign_story_by_campaign_id($set_campaign_id);
  ?>
      <h3 align="left" class="media-heading text-uppercase font-weight-500"><?php echo   $campaign_basics->campaign_tittle; ?>  </h3>
      <strong  class="text-black">Created By:</strong> <u class="text-theme-colored">
                          <?php  echo ucfirst(strtolower($get_user_name->first_name));?> 
                          <?php echo  ucfirst(strtolower($get_user_name->last_name)); ?></u>
        <div class="row">
          <div class="col-sm-11 col-md-8">
            <div class="upcoming-events media bg-white p-15 pb-60 mb-50 mb-sm-30">
              <div class="thumb" align="left">
              <br/>
                      <div class="bg-lightest border-1px p-30 mb-0">
  <h3 class="text-theme-colored mt-0 pt-5"> Report This Campaign</h3>
  <p>Be assured ProjectLive takes seriously the integrity of campaigns created on its platform. Should this report prove this campaign violated our rules and regulations, guidelines or term of use, we will immediately terminate the campaign and remove all its contents on our platform.
  </p>
  <form id="donation_form" method="post" action="report-campaign_">
    <div class="row">
      <div class="col-sm-6">
                        <div class="form-group">
                           <label for="form_name"><br />
                          Name <strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Your name is very important."> </i></label>
                          <input id="form_name" name="name" type="text" placeholder="Enter Your Name" required="required" class="form-control">
        </div>
      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="form_name"><br />
                        Phone <strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Your number is very important. We may have to reach you "> </i></label>
                          <input id="" required="required" name="phone" class="form-control required" type="text" placeholder="EnteYour Number">
                        </div>
                      </div>
    </div>
                    <div class="row">               
                     
                      <div class="col-sm-6">
                        
                      </div>
                    </div>
                    <div class="form-group">
                       <label for="form_comment"><br />
                          Report <strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Make your case here"> </i></label>
                      <textarea id="form_message" name="report" class="form-control required" required="required" rows="5" placeholder="Type in your report"></textarea>
                    </div>
                    <input type="hidden" name="campaign_id" value="<?php echo $set_campaign_id; ?>">
                    <input type="hidden" name="campaign_tittle" value=" <?php echo   $campaign_basics->campaign_tittle; ?>">
                   
    <div class="form-group">
                      <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="" />
                      <button type="submit" class="btn btn-block btn-dark btn-theme-colored btn-sm mt-20 pt-10 pb-10" data-loading-text="Please wait...">Submit Report</button>
    </div>
             
    </div>
     <a href=campaigns/campaign-page-details?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?> sstyle="float: left" class="btn btn-dark btn-flat btn-sm pull-left mt-15">Return back to campaign </a> 
    </div>
    </div>
               
   
    </div>
    </section>
  </div>
  </form>
  
                 

                
 </div>
          

  <!-- Footer -->
  <?php include('includes/footer.php'); ?>
</body>
</html>