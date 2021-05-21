<?php ob_start(); ?>
<?php session_start();?>
<?php error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); 
 // show header according to sessionsinclude('includes/header-login.php');}else {
    include('includes/header.php'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('../campaigns/classes/database.php'); ?>
<?php require_once('../campaigns/classes/database-object.php'); ?>
<?php require_once('../campaigns/classes/functions.php'); ?>
<?php require_once('../campaigns/classes/campaign-basics.php'); ?>
<?php require_once('../campaigns/classes/campaigns.php'); ?>
<?php require_once('../campaigns/classes/campaign-photos.php'); ?>
<?php require_once('../campaigns/classes/campaign-goal.php'); ?>
<?php require_once('../campaigns/classes/campaign-story.php'); ?>
<?php require_once('../campaigns/classes/user.php'); ?>
<?php require_once('../classes/campaign-donations.php'); ?>

  <!-- Start main-content -->
  <?php // coming from the approve page ?>
<?php if(isset($_GET['ref'])){
         $campaign_tittle=str_replace('-', ' ', $_GET['ref']); // remove the dashes from the titile//
         $campaign_id=$database->query("SELECT `campaign_id` FROM `pl_campaign_basics` WHERE `campaign_tittle`= '{$campaign_tittle}'");
        $campaign_id=$database->fetch_array($campaign_id);
        $set_campaign_id=$campaign_id['campaign_id'];
        $_SESSION['campaign_id']=$set_campaign_id; // for the next page//
      }
?>
<?php // coming from approved page-not a must though ?>
<?php if(!isset($_GET['ref'])){
         
       $set_campaign_id= $_SESSION['campaign_id']; // for the next page//
      }
?>
<?php
 $get_user=campaignsManager::find_user_by_campaign_id($set_campaign_id);
      $get_user_name=userManager::find_user_by_id($get_user->user_id);
      $query=$database->query("SELECT `photo_name` FROM `pl_campaign_photos` WHERE `campaign_id`='{$set_campaign_id}' AND `user_id`= '{$get_user->user_id}'");
    $file_name=$database->fetch_array(($query));
    $file_name=$file_name['photo_name'];


?>
 <!-- Start main-content -->
<div class="main-content">
   <!-- Divider: Campaign Page details -->
    <section>
      <?php
  
    $campaign_basics=campaignBasicsManager::find_by_id($set_campaign_id);
    $get_user=campaignsManager::find_user_by_campaign_id($set_campaign_id);
    $get_user_name=userManager::find_user_by_id($get_user->user_id);
    $get_campaign_story=campaignStoryManager::find_campaign_story_by_campaign_id($set_campaign_id);
    $campaign_donations=new campaignDonationManager;
  ?>
  <div class="container">
    <?php
                    if ((output_message($message))){
                        echo   '<div class="alert alert-success">';
                        echo ' <button type="button" class="close" data-dismiss="alert">&times;</button>';
                   
                        echo  '<strong style="font-size:14px">' .  output_message($message). '</strong>'; 
                        echo ' </div>';
                        unset ($message);
                    }
      
                         echo  '<strong style="font-size:30px">'.$session->display_error().'</strong>';
            
        ?>        
       <h4 align="left" class="text-theme-colored"> Campaign Tittle: </h4>
       
       <h4> <?php echo   $campaign_basics->campaign_tittle; ?>  </h4>
        <h4 align="left"class="text-theme-colored">Campaign Tagline:</h4><h4> <?php echo   $campaign_basics->campaign_tagline; ?>  </h4>
     
        <div class="row">
          <div class="col-sm-11 col-md-8">
            <div class="upcoming-events media bg-white p-15 pb-60 mb-50 mb-sm-30">
              <div class="thumb" align="left">
              <div align="left">
               
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
                      
              </div></br><?php
            echo $get_campaign_photo=campaignPhotoManager::find_campaign_photo_by_campaign_id_for_admin($set_campaign_id); ?>
              <p>&nbsp;</p>
              <div class="col-md-12">
              <ul id="myTab" class="nav nav-tabs boot-tabs">
                <li class="active"><a href="#campaign_story" data-toggle="tab">Campaign Story</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in active" id="campaign_story">
                <?php echo $get_campaign_story->story; ?>
                </div>
               
                <div class="tab-pane fade" id="camp-comments">
                  <p>
                   
                </div>
            
              </div>
            </div>
            </div>
          

       </div>
          <div class="col-sm-16 col-md-4">
            <div class="sidebar sidebar-right mt-sm-35">
      
              <div class="widget">
               <div class="event-count causes clearfix p-15 mt-15 border-left">
              <div class="widget">
                <h5 class="widget-title line-bottom">Campaign Creator</h5>
                <div class="latest-posts">
                  <article class="post media-post clearfix pb-0 mb-10">
                   <a class="post-thumb" href="#">
                      <img alt="" width="76" height="76" src="../images/flat-color-icons-svg/settings.svg" title="Project Creator"/>
                  </a>

                    <div class="post-right">
                      <strong  class="text-black">Created By:</strong> <a class="text-theme-colored" href="#">
                          <u><?php  echo ucfirst(strtolower($get_user_name->first_name));?> 
                          <?php echo  ucfirst(strtolower($get_user_name->last_name)); ?></u></a>
              
                    </div>
                  </article>
                  <h5 class="widget-title line-bottom"> Beneficiary</h5>
                <div class="latest-posts">
                  <article class="post media-post clearfix pb-0 mb-10">
                    <a class="post-thumb" href="#"><img alt="" width="76" height="76" src="../images/flat-color-icons-svg/multiple_inputs.svg" title="Campaign Beneficiary"/></a>
                    <div class="post-right">
                      <strong  class="text-black">Beneficiary:</strong> <a class="text-theme-colored">
                         
                          <?php echo   $campaign_basics->campaign_beneficiary; ?></u></a><p>
                         <strong  class="text-black">Beneficiary Type:</strong> <a class="text-theme-colored">  <?php echo   $campaign_basics->beneficiary_type; ?></a>
                  
                    </div>
                  </article>
                  <a title="This will make this campaign live on the plaform and anyone can see it." href=approve-campaign-check.php?flag=1 class="btn btn-dark btn-flat btn-sm pull-left mt-15">Approve this camapign</a></div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                </div>
                <a title="This will reject the application for going live on the platform" style="color:#F00" href=approve-campaign-check?flag=0 class="btn btn-dark btn-flat btn-sm pull-left mt-15">Decline this campaign</a>. </div>
              <ul>
                         
                        
                           </li></ul>
              </div>
               </div>
        </div>
      </div>
    </section>
  </div>
  <!-- end main-content -->

  <!-- Footer -->
  <?php include('includes/footer.php'); ?>
</body>
</html>