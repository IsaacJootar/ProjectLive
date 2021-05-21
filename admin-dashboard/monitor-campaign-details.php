<?php ob_start(); ?>
<?php session_start(); ?>
<?php date_default_timezone_set('Africa/Lagos'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('../campaigns/classes/database.php'); ?>
<?php require_once('../campaigns/classes/database-object.php'); ?>
<?php require_once('../campaigns/classes/functions.php'); ?>
<?php require_once('../campaigns/classes/campaign-basics.php'); ?>
<?php require_once('../campaigns/classes/campaigns.php'); ?>
<?php require_once('../campaigns/classes/campaign-goal.php'); ?>
<?php require_once('../campaigns/classes/campaign-story.php'); ?>
<?php require_once('../campaigns/classes/user.php'); ?>
<?php require_once('../classes/campaign-donations.php'); ?>
<?php
          $campaign_state=ucfirst($_GET['cs']); // from Ajax
          $set_campaign_id=$_GET['cid']; // From Ajax 

 ?>
        <div class="modal-header">
 
  <button type="button"  class="close" data-dismiss="modal">X</button>
                                  
 <!-- Start main-content -->
<div class="main-content">
   <!-- Divider: Campaign Page details -->
                   <h5 class="modal-title" id="myModalLabel2">Campaign State:   <a class="btn btn-dark btn-theme-colored btn-xs btn-flat "><?php echo $campaign_state;?></a></h5>
                </div>

                <div class="modal-body">
                   <form class="form-horizontal" action="campaign-review" method="post">
                <fieldset>

    <section>
      <?php
  
    $campaign_basics=campaignBasicsManager::find_by_id($set_campaign_id);
    $get_user=campaignsManager::find_user_by_campaign_id($set_campaign_id);
    $get_user_name=userManager::find_user_by_id($get_user->user_id);
    $get_campaign_story=campaignStoryManager::find_campaign_story_by_campaign_id($set_campaign_id);
    $campaign_donations=new campaignDonationManager;
  ?>
  <div class="container">
   
       <h6 align="left" class="media-heading text-uppercase font-weight-200"> Campaign Tittle: <?php echo   $campaign_basics->campaign_tittle; ?>  </h6>
        <h6 align="left" font-weight-200>Campaign Tagline: <?php echo   $campaign_basics->campaign_tagline; ?>  </h6>
     
        <div class="row">
          <div class="col-sm-11 col-md-8">
            <div class="upcoming-events media bg-white p-15 pb-60 mb-50 mb-sm-30">
              <div class="thumb" align="left">
              <div align="left">
                <?php  $query=$database->query("SELECT `photo_name` FROM `pl_campaign_photos` WHERE `campaign_id`='{set_campaign_id}'");
    $file_name=$database->fetch_array(($query));
    $file_name=$file_name['photo_name']; ?>
              </div><br/>
                      <div align="left">
                        <ul class="list-inline mt-5">
                         
                          <li class="m-0 pl-10 pr-10"> <i class="<?php echo get_campaign_category_icon($campaign_basics->campaign_category); ?> text-theme-colored mr-5"></i> 
                          <?php  echo ucfirst(strtolower($campaign_basics->campaign_category)); ?>
                           </li>
                          <li class="m-0 pl-10 pr-10"> <i class="fa fa-globe text-theme-colored mr-5"></i> 
                          <?php  echo ucfirst(strtolower($campaign_basics->campaign_location)); ?>, Nigeria. </li>
                         
                         <li class="m-0 pl-10 pr-10"> <i class="fa fa-clock-o text-theme-colored mr-5"></i>
                          <?php  echo ucfirst(strtolower($campaign_basics->campaign_duration)); ?> Days </li>
                           <li class="m-0 pl-10 pr-10"> <i class="fa fa-money text-theme-colored mr-5"></i>
                         <?php echo format_currency($campaign_goal=campaignGoalManager::find_all_campaign_goal_by_campaign_id($set_campaign_id));?> </li>
                         
                         
                         <li class="m-0 pl-10 pr-10"> <i class="fa fa-user text-theme-colored mr-5"></i>
                          <?php echo $get_user_name->user_name; ?>  </li>
                         <li class="m-0 pl-10 pr-10"> <i class="fa fa-phone text-theme-colored mr-5"></i>
                          <?php echo $get_user_name->phone; ?>  </li>
                         
                         
                           </li>
                          
                          </ul>
                      </div>
                      
              </div>
             
              <p>&nbsp;</p>
              <div class="col-md-12">
              <ul id="myTab" class="nav nav-tabs boot-tabs">
                <li class="active"><a href="#campaign_story" data-toggle="tab">Campaign Story</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in active" id="campaign_story">
                <?php echo $get_campaign_story->story; ?>
                </div>
               
               

       </div>
          
</body>
</html>
                </fieldset>
            </form>
              
                
            </div>