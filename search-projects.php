 <?php ob_start(); ?>
<?php session_start(); ?>
<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); 
// put these guys in a function later. //
if(!isset($_SESSION['SESS_USER'])){
  include ('includes/header.php');
  } else {
   include ('includes/header-login.php');  
}
    ?> <body onLoad="window.scroll(0, 200)"> <?php  // this snippet scroll the page to a certian page. enuf to view the campaigns as they display?>
<style type="text/css">
body,td,th {
  
  color: #000000;
}
</style>

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
<?php require_once('classes/campaign-donations.php'); ?>
<br /><br />
  <!-- Start main-content -->
  <div class="main-content">
      <div class="container" align="center">
    
          
        <p>&nbsp;</p><p>&nbsp;</p>
        
<div class="row">
                <div class="form-group col-md-12">
                  <label for="form_choose_username">Search Projects</label>
                  <form  method="post" action="search-projects">
                  <input id="form_choose_username" required placeholder="Search Projects, Locations & names" name="search_projects" class="form-control" type="text">
                  <span class="icon"><a class="text-theme-colored" href="search-projects" onclick="$(this).closest('form').submit();return false;"><i  class="fa fa-search fa-2x"></i></a></span>
                </form>
                </div>
              </div>
              <?php 

                
              if(isset($_POST['search_projects'])){
                session_regenerate_id();
                $_SESSION['search_projects']=trim(strip_tags($_POST['search_projects']));
                $q=$_SESSION['search_projects'];


              }
              
             

              ?>
Search for Projects, Locations and Names. Use the tabs to filter search results.</div>
    <section>
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <div id="portfolio-container">
           <?php  //determine active tabs//
               
            if(isset($_GET['ref'])){

              switch ($_GET['ref']) {
                  case 'recent':
                  $active_tab=2;
                  //under this  case of tab 2, deploy this query//
                  $get_campaigns=campaignsManager:: find_by_sql("SELECT `pl_campaign_basics`. `campaign_id`,  `pl_campaigns`. `id` FROM `pl_campaign_basics` JOIN `pl_campaigns` ON `pl_campaign_basics`. `campaign_id`=`pl_campaigns`. `id` 
                    WHERE (`pl_campaign_basics`. `campaign_tittle` LIKE '%$q%' OR `pl_campaign_basics`. `campaign_location` LIKE '%$q%') AND `pl_campaign_basics`. `campaign_state`= 'live' ORDER BY `pl_campaigns`. `id` DESC");
                  break;
                  case 'most funded': //this most funded is not actually NOT taken note filter searcj bcus of the tables used in the query. I dont have tille or location in either of the joined tables. I wil figure out a way later. 
                  $active_tab=3;
                 $get_campaigns=campaignsManager:: find_by_sql("SELECT SUM(`pl_campaign_donations`.`donation_amount`) AS `donation_amount`,  `pl_campaign_donations`. `campaign_id`, `pl_campaign_donations`. `donation_amount`, `pl_campaigns`. `id` FROM `pl_campaign_donations` JOIN `pl_campaigns` ON `pl_campaign_donations`. `campaign_id`=`pl_campaigns`. `id`  GROUP BY `pl_campaigns`. `id`  ORDER BY `pl_campaign_donations`. `campaign_id` DESC"); 
                  break; 
                  // the next two senario shud have to do with the campaign duration-another table i suppose//
                  case 'ending soon':
                  $active_tab=4;
                  // for now let projectlive ending soon means a less than 4 days left- 345,600 seconds makes 4 days//
                  // $now=time(); // this is the time in seconds we added from dues date, and must now be subtracted again to get time in seconds//
                  $now=time(); 
                  $get_campaigns=campaignsManager:: find_by_sql("SELECT `pl_campaign_basics`. `campaign_id`,  `pl_campaigns`. `id` FROM `pl_campaign_basics` JOIN `pl_campaigns` ON `pl_campaign_basics`. `campaign_id`=`pl_campaigns`. `id`  WHERE (`pl_campaign_basics`. `campaign_tittle` LIKE '%$q%' OR `pl_campaign_basics`. `campaign_location` LIKE '%$q%') AND `pl_campaign_basics`. `campaign_due_date` - $now <= 345600  AND `pl_campaign_basics`. `campaign_state` = 'live'");
                  break;
                  case 'ended':
                  $active_tab=5;
                  
                  $get_campaigns=campaignsManager:: find_by_sql("SELECT `pl_campaign_basics`. `campaign_id`,  `pl_campaigns`. `id` FROM `pl_campaign_basics` JOIN `pl_campaigns` ON `pl_campaign_basics`. `campaign_id`=`pl_campaigns`. `id`  WHERE (`pl_campaign_basics`. `campaign_tittle` LIKE '%$q%' OR `pl_campaign_basics`. `campaign_location` LIKE '%$q%') AND `pl_campaign_basics`. `campaign_state` = 'ended'"); 
                  break;
                  default: // default should reference the all category tab//
                  $active_tab=1;
                  
                  $get_campaigns=campaignsManager:: find_by_sql("SELECT `pl_campaign_basics`. `campaign_id`,  `pl_campaigns`. `id` FROM `pl_campaign_basics` JOIN `pl_campaigns` ON `pl_campaign_basics`. `campaign_id`=`pl_campaigns`. `id`  WHERE (`pl_campaign_basics`. `campaign_tittle` LIKE '%$q%' OR `pl_campaign_basics`. `campaign_location` LIKE '%$q%') AND `pl_campaign_basics`. `campaign_state` != 'declined' AND `pl_campaign_basics`. `campaign_state` != 'build up' AND `pl_campaign_basics`. `campaign_state` != 'review' ");
                  break;
              } // end switch case

            } // endif
                  if(!isset($_GET['ref'])){
                    $get_campaigns=campaignsManager:: find_by_sql("SELECT `pl_campaign_basics`. `campaign_id`,  `pl_campaigns`. `id` FROM `pl_campaign_basics` JOIN `pl_campaigns` ON `pl_campaign_basics`. `campaign_id`=`pl_campaigns`. `id`  WHERE (`pl_campaign_basics`. `campaign_tittle` LIKE '%$q%' OR `pl_campaign_basics`. `campaign_location` LIKE '%$q%') AND `pl_campaign_basics`. `campaign_state` != 'declined' AND `pl_campaign_basics`. `campaign_state` != 'build up' AND `pl_campaign_basics`. `campaign_state` != 'review'");
                    $active_tab=1;
                  }

            ?>
               <!-- Campaign Filter tabs -->
            <div class="horizontal-tab-centered text-left ">
                <ul class="nav nav-pills mb-8">
                 <li class="<?php if($active_tab==1){echo 'active';} else {echo '';}?>"> <a href="search-projects?ref=all" data-toggle="tooltip" data-placement="right" title="This will display search projects but with no particular order." class="active">All</a> </li>

                  <li class="<?php if($active_tab==2){echo 'active';} else {echo '';}?>"> <a href="search-projects?ref=recent" data-toggle="tooltip" data-placement="right" title="This will display search projects that are recent."  class=""><strong>Recent Projects</strong></a></li>
                   <li class="<?php if($active_tab==3){echo 'active';} else {echo '';}?>"><a href="search-projects?ref=most funded" data-toggle="tooltip" data-placement="right" title="This will display search projects that are most funded."  class=""><strong>Most Funded</strong></a> </li>
                 
                  <li class="<?php if($active_tab==4){echo 'active';} else {echo '';}?>"> <a href="search-projects?ref=ending soon" data-toggle="tooltip" data-placement="right" title="This will display search projects that are ending soon."  class=""><strong>Ending Soon</strong></a> </li>
                   <li class="<?php if($active_tab==5){echo 'active';} else {echo '';}?>"> <a href="search-projects?ref=ended" data-toggle="tooltip" data-placement="right" title="This will display search projects already ended." class=""><strong>Ended</strong></a>
              </li>
                </ul>
            </div>
            <!-- End Campaign Filter Tags -->
    <section class="text-">
      <div>
        <!-- Section Content -->
        <div class="section-content text-center">
          <div class="row"> 
            <div class="">


<?php // if reference is not set, display the filter guide that carries ALL conditions,  just as the using in the switch case above. this issue is neccessary bcus on initial page visit $_GET is not yet set atall//

      if(!isset($_GET['ref'])){
        echo '<i style="float:left">Showing search results for: <strong class="text-theme-colored">';
        echo ' ';
        echo '"';
        echo  $_SESSION['search_projects'];
        echo '"';
        echo ' ';
        echo 'that are available';
        echo ' ';
      }?>

<?php  // if reference is set, and the  filter category selected is all then change the grammer//
     if(isset($_GET['ref'])){
        echo '<i style="float:left">Showing search results for: <strong class="text-theme-colored">';
        echo ' ';
        echo '"';
        echo  $_SESSION['search_projects'];
        echo '"';
        echo ' ';
        echo 'that are';
        echo ' ';


      if ($_GET['ref']=='all'){
        $_GET['ref']='available'; // just for grammer sake 
      } 
  echo $_GET['ref'];
}?></strong></i>
          
            </div>
          </div>
        </div>
      </div>      
    </section></br>
   
 <section> 
        <div id="gallery-isotope-grid" class="row mtli-row-clearfix">
                  
<?php

    foreach ($get_campaigns as $campaigns):
      $campaign_basics=campaignBasicsManager::find_by_id($campaigns->id);
      $campaign_photos=new campaignPhotoManager;
      $campaign_goal=new campaignGoalManager; 
      $get_user=campaignsManager::find_user_by_campaign_id($campaigns->id);
      $get_user_name=userManager::find_user_by_id($get_user->user_id);
      $campaign_donations=new campaignDonationManager;
     
?>
         <div  class="col-sm-6 col-md-3 col-lg-3";>
            
            <div  class="causes bg-white  box-hover-effect effect1 maxwidth500 mb-sm-30">
              <div  class="thumb"> 
               <a href="campaigns/campaign-page-details?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?>"><?php echo $campaign_photos->find_thumb_campaign_photo_by_campaign_id($campaigns->id);?></a>
        
              </div>
              <div class="causes-details border-1px p-20">
                <i class="<?php echo get_campaign_category_icon($campaign_basics->campaign_category); ?> text-theme-colored mr-5"> <?php echo $campaign_basics->campaign_category;?></i>
              <div style="height:118px";>
                <h6><a href="campaigns/campaign-page-details?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?>"><?php echo  $campaign_basics->campaign_tittle ?></a></h6>
          <i class="fa fa-user text-theme-colored mr-5"> <?php  echo ucfirst(strtolower($get_user_name->first_name));?> 
                          <?php echo  ucfirst(strtolower($get_user_name->last_name)); ?> </i> <br />
              
                 <?php echo $campaign_basics->campaign_tagline;?>
            </div>
                <ul class="list-inline clearfix mt-20">
                  <li class="pull-left pr-0"><strong> Raised: </strong> <?php echo format_currency($campaign_donations->find_all_campaign_donations_by_campaign_id($campaigns->id));?>
                  
                  </li>
                  <li class="text-theme-colored pull-right pr-<h1></h1>">Goal: <?php echo format_currency($campaign_goal->find_all_campaign_goal_by_campaign_id($campaigns->id));?></li>
                </ul><br/>
                <div class="progress-item mt-0">
                <div class="progress mb-0">
                  <?php $percent=$campaign_donations->find_percentage_on_donations_by_campaign_id($campaigns->id);
                  // if the donation percentage is zero, do not display the progree bar atall//
                  if($percent < 1){ ?>
                  <?php  // there is no progress bar class like progress-bar2, but i override the progress-bar class in the if statement bcus, not putting a progress bar atall in the if condition makes the boxes to miss-aligh, when amount raised it at zero.-find out why later. ?>
                   <div class="progress-bar2" data-percent="<?php echo $percent;?>"%></div> 
            <?php }
                    elseif ($percent >=100) { ?>
                     <div class="progress-bar" data-percent="100"></div> 
              <?php 
                    }else{ ?>
                  <div class="progress-bar" data-percent="<?php echo $percent;?>"%></div> 
                    <p>
                      <?php
                  }
                  ?>
                    </p>
                    <p>&nbsp; </p>
                  <div class="mt-10"><a class="btn btn-dark btn-theme-colored btn-flat btn-sm pull-left mt-10" href="campaigns/campaign-page-details?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?>">Details</a>
                    <div class="pull-right mt-15"><i class="fa fa-clock-o text-theme-colored"></i> <?php  $seconds= get_campaign_due_date_by_campaign_id($campaigns->id); echo due_date_in_days($seconds, $campaigns->id);

                 ?></div>
              </div>
                
                  </div>
                <p><?php echo  $campaign_donations->find_percentage_on_donations_by_campaign_id($campaigns->id);?>%
               </p>
                
                </p>
                <p>&nbsp;</p>
                </div>
                
              </div>
            </div>
          </div>
          <?php endforeach; ?>
           </br>
      </div>
    </section>

              <div class="pagination-filter-container">
                <nav>
                  <ul class="pagination">
                  </ul>
                </nav>
              </div>

              <script type="text/javascript">
                $(document).ready(function(e){
                  $( '#portfolio-container' ).pajinate({
                    items_per_page : 8,
                    item_container_id : '#gallery-isotope-grid',
                    nav_panel_id : '.pagination-filter-container ul',
                    show_first_last: false
                  });

                  setTimeout(function(){
                    THEMEMASCOT.widget.TM_isotopeGridRearrange();
                  }, 1000);

                  $( '.pagination li' ).click(function() {
                    THEMEMASCOT.widget.TM_isotopeGridRearrange();
                  });
                });
              </script>
            </div>
          </div>
        </div>
      </div>
  <br />
    <br />
   <?php include('includes/category-page-links.php'); ?>
    <section class="inner-header divider layer-overlay overlay-dark" data-bg-img="images/bg/bg2.jpg">
      <div class="container pt-30 pb-30">
        <!-- Section Content -->
        <div class="section-content text-center">
          <div class="row"> 
            <div class="col-md-12  text-center">
              <h2 class="text-white font-23" align="center">ProjectLive is creating a community where ordinary people with pressing needs or amazing ideas can connect with donors. This community  help you raise money for critical medical expenses, publish a book, launch an exciting new business idea or make a dream come true. Start a campaign today.
              
            </div>
          </div>
        </div>
      </div>      
    </section> <p>&nbsp; </p>
     
          <div class="row"> 
            <div class="col-md-12  text-center">
              <h2>Achieve your campaign goal in four simple steps</h2>
              
            </div>
          </div>
       
    
    <section>
    <div class="row mt-30">
          <div class="col-sm-3">
            <div class="icon-box iconbox-theme-colored">
              <a class="icon icon-dark icon-circled icon-border-effect effect-circled icon-sm pull-left mb-0 mr-10" href="#">
                <i class="pe-7s-switch"></i>
              </a>
              <h5 class="icon-box-title mt-15 mb-20">Start a Campaign</h5>
              <p class="text-gray">Create a campaign by telling a compelling story of your idea, project or anything that means so much to you. Choose your area of interest from our various categories</p>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="icon-box iconbox-theme-colored">
              <a class="icon icon-dark icon-circled icon-border-effect effect-circled icon-sm pull-left mb-0 mr-10" href="#">
                <i class="pe-7s-global"></i>
              </a>
              <h5 class="icon-box-title mt-15 mb-20">Go Live</h5>
              <p class="text-gray">Your campaign goes live after a vetting process and approval by the ProjectLive team. Use the platform tools provided to promote your campaign on social media, with friends and family</p>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="icon-box iconbox-theme-colored">
              <a class="icon icon-dark icon-circled icon-border-effect effect-circled icon-sm pull-left mb-0 mr-10" href="#">
                <i class="pe-7s-cash"></i>
              </a>
              <h5 class="icon-box-title mt-15 mb-20">Receive Funds</h5>
              <p class="text-gray">Start receiving funds from willing donors all over Africa. Monitor your funds in realtime as they come in.</p>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="icon-box iconbox-theme-colored">
              <a class="icon icon-dark icon-circled icon-border-effect effect-circled icon-sm pull-left mb-0 mr-10" href="#">
                <i class="pe-7s-like2"></i>
              </a>
              <h5 class="icon-box-title mt-15 mb-20">Execute your Project.</h5>
              <p class="text-gray">Use the funds you have received to execute the project. Appreciate your donors and share your success story to our community. Simply!</p>
            </div>
          </div>
        </div>
    </section>
    <div class="divider layer-overlay overlay-dark call-to-action pt-40 pb-40 mb-20">
  <div class="col-xs-12 col-sm-8 col-md-8">
    <div class="icon-box icon-rounded-bordered left media mb-0"> 
      <a class="media-left pull-left" href="#"> <i class="pe-7s-culture text-whtie p-20"></i></a>
     <div class="media-body">
        <h3 class="media-heading heading text-white">Need Assistance?</h3>
        <p class="text-white">Did you know that most crowdfunding campaigns fail because of lack of planning? Read the following campaign heads up below and learn how to create successfull campaigns on ProjectLive. Or call our campaign help team for advice. </p>
      </div>
    </div>
  </div>
 
</div>
<?php include('includes/campaign-heads-up.php');?>
  <!-- end main-content -->
   <!-- Footer -->
  <?php include('includes/footer.php'); ?>
</body>
</html>