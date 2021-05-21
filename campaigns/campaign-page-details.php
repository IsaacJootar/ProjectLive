<?php ob_start();
 session_start();
 error_reporting(E_ALL); 
 // show header according to sessions
  if(isset($_SESSION['SESS_USER'])){include('includes/header-login-social.php');}else {
    include('includes/header.php');} ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/campaign-basics.php'); ?>
<?php require_once('classes/campaigns.php'); ?>
<?php require_once('classes/campaign-photos.php'); ?>
<?php require_once('classes/campaign-goal.php'); ?>
<?php require_once('classes/campaign-story.php'); ?>
<?php require_once('classes/user.php'); ?>
<?php require_once('../classes/campaign-donations.php'); ?>
 <script>// creator verify popup badge//
                $(document).ready(function(){
                    $('[data-toggle="popover"]').popover();
                });
              </script>
 <!-- Start main-content -->
<div class="main-content">
  
   <!-- Divider: Campaign Page details -->
    <section>
      <?php
  
    $campaign_basics=campaignBasicsManager::find_by_id($set_campaign_id);
    $_SESSION['tittle']= $campaign_basics->campaign_tittle;
    $get_user=campaignsManager::find_user_by_campaign_id($set_campaign_id);
    $get_user_name=userManager::find_user_by_id($get_user->user_id);
     $get_campaign_story=new campaignStoryManager;
    $get_campaign_story=campaignStoryManager::find_campaign_story_by_campaign_id($set_campaign_id);
    $campaign_donations=new campaignDonationManager;
  ?>
  <div class="container">
       <h3 align="left" class="media-heading text-uppercase font-weight-500"><?php echo   $campaign_basics->campaign_tittle; ?>  </h3>
        <h5 align="left" font-weight-500><?php echo   $campaign_basics->campaign_tagline; ?>  </h5>
      <strong  class="text-black">This campaign was created By:</strong> <a class="text-theme-colored">
          
       
                          <?php  echo ucfirst(strtolower($get_user_name->first_name));?> 
                          <?php echo  ucfirst(strtolower($get_user_name->last_name)); ?></a>
                           <div class="row">
          <div class="col-sm-11 col-md-8">
            <div class="upcoming-events media bg-white p-15 pb-60 mb-50 mb-sm-30">
              <div class="thumb" align="left">
              <div align="left">
                  
                  <?php // getting them in a session to use for facebook shearer plugin-messy for now ?>
 <?php  $_SESSION['image_name']=campaignPhotoManager::find_campaign_photo_name_by_campaign_id($set_campaign_id); ?>
    
 <?php // check which to display, photo or video// ?> 
              
              <?php
               $check_video=$database->query("SELECT * FROM `pl_campaign_basics` WHERE `campaign_id`= '{$set_campaign_id}'");
               $check_video=$database->fetch_array($check_video);
                 $check_video=trim($check_video['campaign_video_link']);
               if(!empty($check_video)){ ?>
               <iframe width="560" height="416" src="https://www.youtube.com/embed/<?php echo $check_video;?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                   
             <?php  } 
                    if(empty($check_video)){
                     echo $get_campaign_photo=campaignPhotoManager::find_campaign_photo_by_campaign_id($set_campaign_id);
                    }
             
                  ?>
              </div><br/>
                      <div align="left">
                        <ul class="list-inline mt-5">
                          <li class="m-0 pl-10 pr-10"> <i class="fa fa-user text-theme-colored mr-5"></i> <a class="text-black">
                          <?php  echo ucfirst(strtolower($get_user_name->first_name));?> 
                          <?php echo  ucfirst(strtolower($get_user_name->last_name)); ?></a> </li>
                          <li class="m-0 pl-10 pr-10"> <i class="<?php echo get_campaign_category_icon($campaign_basics->campaign_category); ?> text-theme-colored mr-5"></i> <a class="text-black">
                          <?php  echo ucfirst(strtolower($campaign_basics->campaign_category)); ?>
                          </a> </li>
                          <li class="m-0 pl-10 pr-10"> <i class="fa fa-globe text-theme-colored mr-5"></i> <a class="text-black">
                          <?php  echo ucfirst(strtolower($campaign_basics->campaign_location)); ?>, Nigeria.</a> </li>
                         
                          </ul></br>
                          <h5 class="pull-left mt-10 mr-20 text-theme-colored"> Share their story:</h5>
                       
                        <div class="sharethis-inline-share-buttons"></div>
                      </div>
                           
              </div>
          
              <p>&nbsp;</p>
        
              <div class="col-md-13">
              <ul id="myTab" class="nav nav-tabs boot-tabs">
                <li class="active"><a href="#campaign_story" data-toggle="tab">Campaign Story</a></li>
                <li><a href="#camp-updates" data-toggle="tab">Campaign Updates<sup> <strong class="text-theme-colored">0</strong></sup></a></li>
                <li><a href="#camp-comments" data-toggle="tab">Donors Comments</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in active" id="campaign_story">
                <?php echo $get_campaign_story->story; ?>
                </div>
                <div class="tab-pane fade" id="camp-updates">
              <b> This project does not have any updates yet.</b>
                </div>
                
                <div class="tab-pane fade" id="camp-comments">
                  <p>
                    <?php $get_campaign_donors=campaignDonationManager::find_by_sql("SELECT * FROM `pl_campaign_donations` WHERE `campaign_id`='{$set_campaign_id}' AND `payment_status`=1 AND `reference_code` !='' AND `payment_id` !='' ORDER BY `id` DESC");

                foreach ($get_campaign_donors as $Comments) {
            
                 ?>
                  </p>
                    <div class="entry-content border-1px p-20">  
                  <div class="timeline-block">
                      
                      <article class="post clearfix">
                        <div class="entry-header">
                          <h5 class="entry-title"> <i class="fa fa-user text-theme-colored"></i> <?php echo $Comments->name_of_donor;?></h5>
                          <ul class="list-inline font-12 mb-20 mt-10">
                           
                            
                          </ul>
                         
                        </div>
                        <div class="entry-content">
                          <p class="mb-30"> <i class="fa fa-comment text-theme-colored"></i> <?php echo $Comments->comment_of_donor;?></p>
                           <p class="mb-30"> <i class="fa fa-money text-theme-colored"></i>  <?php echo format_currency($Comments->donation_amount);?></p>
                          
                          <?php // come back for creators reply later echo '<a class="replay-icon pull-right text-theme-colored" href="#"> <i class="fa fa-commenting-o text-theme-colored"></i> Reply</a> '?>
                        </div>
                          <i class="fa fa-clock-o text-theme-colored"></i><span class="text-theme-colored"> <?php echo get_date_time($Comments->donation_date);?></span>
                      </article>
                    </div>
                    </div>
         <?php  } ?>
               
                </div>
           
              </div>
              <div class="fb-comments" data-href="https://projectlive.ng/campaigns/campaign-page-details<?php echo $encode?><?php echo $url ?>" data-numposts="5"></div>


                <div class="fb-share-button" data-href="https://projectlive.ng/campaigns/campaign-page-details<?php echo $encode?><?php echo $url ?>" data-layout="button_count" data-size="large" data-mobile-iframe="false"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fprojectlive.ng%2Fcampaigns%2Fcampaign-page-details<?php echo $encode?><?php echo $url ?>&amp;src=sdkpreparse" class="btn btn-dark btn-lg btn-block no-border mt-11 mb-11" data-bg-color="#3b5998">Share this campaign on facebook</a></div></br>

 <?php // check which button to remder//


                      $check_campaign=$database->query("SELECT `campaign_id` FROM `pl_ended_campaigns` WHERE `campaign_id`='{$set_campaign_id}'");
                      $check_campaign=$database->num_rows($check_campaign);
                       if($check_campaign ==1){?>
                    <a title="This campaign has ended and will not accept anymore donations"  style="float: left" class="btn btn-dark btn-flat btn-sm pull-left mt-15">This campaign has ended </a></br></br></br>
                 
                <?php }else{?>
                        <a href=../campaign-donation-page?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?> style="float: left" class="btn btn-dark btn-lg btn-block no-border mt-11 mb-11">Donate to this campaign Now </a></br></br></br>
                 
                    <?php  }?>
                <a href=../report-campaign?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?> style="float: left" class="btn btn-danger btn-flat btn-sm pull-left mt-15">Report this campaign </a>
            </div>
            </div>

       </div>
          <div class="col-sm-13 col-md-4">
            <div class="sidebar sidebar-right mt-sm-30">
             
              <div class="widget"><hr>
                  <div class="event-count causes clearfix p-5 mt-5 border-left">
                      <div class="event-count causes clearfix p-5 mt-5 border-right">
                <h5 class="widget-title line-bottom">

                  <a href=../campaign-donation-page?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?>>Be a part of this Campaign</a></h5>
               <h5 class="pull-left mt-10 mr-20 text-theme-colored"> Share their story:</h5>
                       
                        <ul class="list-inline mt-5">
                          <li class="styled-icons icon-circled m-0">
                            <div align="left"><data-href="https://projectlive.ng/campaigns/campaign-page-details" data-layout="button_count" data-size="large" data-mobile-iframe="false"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fprojectlive.ng%2Fcampaigns%2Fcampaign-page-details?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?>&amp;src=sdkpreparse" data-bg-color="#3A5795"><i class="fa fa-facebook text-white"></i></a></div>
                          </li>
                          <li class="styled-icons icon-circled m-0">
                            <div align="left"><a target="_blank" href="https://twitter.com/intent/tweet?text=https://projectlive.ng/campaigns/campaign-page-details<?php echo $encode?><?php echo $url ?>" data-bg-color="#55ACEE"><i class="fa fa-twitter text-white"></i></a></div>
                          </li>
                        
                
                        </ul>

               
                  <div align="left" style="font-size:12px">Every single social media share is capable of attracting 2 new donors. Do well by sharing their story.  </div></br>
            
             
                    <div class="progress-item mt-20 mb-30">
                      <div class="progress mb-10">
                      
                        <?php $percent=$campaign_donations->find_percentage_on_donations_by_campaign_id($set_campaign_id);
                  // if the donation percentage is zero, do not display  the progress atall//
                  if($percent < 1){ ?>

                    <div data-percent="<?php echo $percent?>"></div>
                    <?php
                  }

                    elseif ($percent >=100) { ?>
                     <div class="progress-bar" data-percent="100"></div> 
              <?php 
                    }
                  
                  else{ ?>
                    <div class="progress-bar" data-percent="<?php echo $percent;?>"%></div> 
                    <?php
                  }?>
                  <div class="pull-right mt-15"><li  style="font-size: 16px" class="text-theme-colored pr-0"> Goal: <?php echo format_currency($campaign_goal=campaignGoalManager::find_all_campaign_goal_by_campaign_id($set_campaign_id));?></li></div>
                      </div>
                      <?php echo $campaign_donations->find_percentage_on_donations_by_campaign_id($set_campaign_id);?>%
                    </div>
                    <ul class="list-inline clearfix">
                      <li style="font-size: 16px" class="pull-left pr-0">Raised:<?php echo format_currency($campaign_donations->find_all_campaign_donations_by_campaign_id($set_campaign_id));?></li>
                      <li class="pull-right pr-0"><i class="fa fa-heart-o text-theme-colored"></i> <?php echo  $count_donations=$campaign_donations->find_numbers_of_donations_by_campaign_id($set_campaign_id);?> Donor(s)</li></li>
                    </ul>
                    <div class="mt-10">
                      <ul class="pull-left list-inline mt-20">
                       <i class="fa fa-clock-o text-theme-colored"></i> <?php  $seconds= get_campaign_due_date_by_campaign_id($set_campaign_id, $campaign_basics->campaign_due_date); echo due_date_in_days($seconds, $set_campaign_id);

                 ?>
                      </ul>

                      <?php // check which button to remder//


                      $check_campaign=$database->query("SELECT `campaign_id` FROM `pl_ended_campaigns` WHERE `campaign_id`='{$set_campaign_id}'");
                      $check_campaign=$database->num_rows($check_campaign);
                       if($check_campaign ==1){?>
                      <a title="This campaign has ended and will not accept anymore donations" class="btn btn-dark btn-flat btn-sm pull-right mt-15">This campaign has ended</a>
                <?php }else{?>
                        <a href=../campaign-donation-page?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?> class="btn btn-dark btn-flat btn-sm pull-right mt-15">Donate Now</a>
                    <?php  }?></br></br></br></div><br/><hr>

            <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
           <div class="modal-dialog modal-sm">
  <div class="modal-content">
       
                  
      </div>
                
  </div>
</div>
              
            
              <div class="widget">
                <h5 class="widget-title line-bottom">Campaign Creator</h5>
                <div class="latest-posts">
                  <article class="post media-post clearfix pb-0 mb-10">
                   <div class="post-right">
                      <strong  class="text-black">Created By:</strong> <a class="text-theme-colored">
                          <?php  echo ucfirst(strtolower($get_user_name->first_name));?> 
                          <?php echo  ucfirst(strtolower($get_user_name->last_name)); ?></a>  <a  class="openModal" data-toggle="modal" data-target="#myModal" data-id="<?php echo $get_user->user_id;?>" 
          data-cid="<?php echo $set_campaign_id;?>"><i class="text-theme-colored" style="float:right" > <i class="fa fa-envelope-o"> contact creator</i></i>
                       
                    </a><p>
                     <button type="button" class="btn btn-border btn-circled btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="This creator has passed through a background check and is verified
                        ">
                verified <i class="fa fa-check"></i>
              </button><p>
                    </div>
                  </article>
                 
                  <h5 class="widget-title line-bottom"> Beneficiary</h5>
                <div class="latest-posts">
                  <article class="post media-post clearfix pb-0 mb-10">
                  
                    <div class="post-right">
                      <strong  class="text-black">Beneficiary:</strong> <a class="text-theme-colored">
                         
                          <?php echo   $campaign_basics->campaign_beneficiary; ?></u></a><p> <button type="button" class="btn btn-border btn-circled btn-sm" data-container="body" data-toggle="popover" data-placement="top" data-content="This beneficiary has passed through a background check and is verified.">
                verified <i class="fa fa-check"></i>
              </button><p>
                         <strong  class="text-black">Beneficiary Type:</strong> <a class="text-theme-colored">  <?php echo   $campaign_basics->beneficiary_type; ?></a>
                  
                    </div>
                  </article>
                </div>
                </div>
              </div>
              <hr>
              <div class="widget">
                <h5 class="widget-title line-bottom">Donation Feeds</h5>
            <div class="bxslider bx-nav-top">
            <?php
          // from the donation query above
         foreach($get_campaign_donors as $donors){ ?>
              <div class="event media sm-maxwidth400 p-15 mt-0 mb-15">
                <div class="row">
                  <div class="col-xs-3 p-0">
                    <div class="thumb pl-15">
                     <img alt="" width="53" height="51" src="../images/flat-color-icons-svg/donate.svg"  title="donate.svg"/>
                    </div>
                  </div>
                  <div class="col-xs-6 p-0 pl-15">
                    <div class="event-content">
                      <h5 class="media-heading"><a href="#"><?php
                     
                      if($donors->identity_of_donor == 0) { echo 'Anonymous';} else {echo $donors->name_of_donor; } ?></a></h5>
                      <ul>
                        <li><i class="fa fa-clock-o text-theme-colored"></i> <?php
                  echo get_date_time($donors->donation_date);
                  ?> </li>
                      </ul>                    
                    </div>                
                  </div>
                  <div class="col-xs-3 pr-0">
                    <div class="event-date text-center">
                      <ul>
                        <li class="font-13 text-theme-colored font-weight-700"><?php echo format_currency($donors->donation_amount);?></li>
                       <?php // <li class="font-17 text-center text-uppercase"><img style="float:right" src="images/favicon.ico" /></li> //
                       ?>
                        <i class="fa fa-check-circle text-theme-colored"></i>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
             
                  <?php  } //endforeach;?>
              </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- end main-content -->
<script type="text/javascript">
    // modal for sending msg to creator    
  $('.openModal').click(function(){
      var id = $(this).attr('data-id');0
      var cid = $(this).attr('data-cid');0
      $.ajax({url:"message-creator.php?user_id="+id+"&cid="+cid,cache:false,success:function(result){
          $(".modal-content").html(result);
      }});
  });
          </script>
  <!-- Footer -->
  <?php include('includes/footer.php'); ?>
</body>
</html>