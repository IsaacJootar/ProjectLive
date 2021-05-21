<?php include ('includes/header.php');?>
    <div class="" align="left">
        <h2 class="heading-border">ProjectLive Administrator Dashboard</h2>
      </div>
<div class="main-content">

<?php require_once('includes/config.php'); ?>
<?php require_once('../campaigns/classes/database.php'); ?>
<?php require_once('../campaigns/classes/database-object.php'); ?>
<?php require_once('../campaigns/classes/functions.php'); ?>
<?php require_once('../campaigns/classes/campaign-basics.php'); ?>
<?php require_once('../campaigns/classes/campaigns.php'); ?>
<?php require_once('../campaigns/classes/campaign-goal.php'); ?>
<?php require_once('../campaigns/classes/campaign-story.php'); ?>
<?php require_once('../campaigns/classes/user.php'); ?>
  <!-- Start main-content -->
  <div class="main-content">
    <!-- Section: inner-header -->
    
     
   

              <!-- Portfolio Gallery Grid -->
              <div id="gallery-isotope-grid" class="gallery-isotope grid-4 gutter clearfix">
                 <?php


     // get the camapigns waiting for approval based on which was submitted first //
                 $get_campaigns=campaignsManager:: find_by_sql("SELECT `pl_campaign_review`. `campaign_id`,  `pl_campaign_review`. `date`, `pl_campaigns`. `id` FROM `pl_campaign_review` LEFT JOIN `pl_campaigns` ON `pl_campaign_review`. `campaign_id`=`pl_campaigns`. `id` ORDER BY  `pl_campaign_review`. `campaign_id` DESC"); 
    foreach ($get_campaigns as $campaigns):
      $campaign_basics=campaignBasicsManager::find_by_id($campaigns->id);
      $campaign_goal=new campaignGoalManager; 
      $get_user=campaignsManager::find_user_by_campaign_id($campaigns->id);
      $get_user_name=userManager::find_user_by_id($get_user->user_id);
      $query=$database->query("SELECT `photo_name` FROM `pl_campaign_photos` WHERE `campaign_id`='{$campaigns->id}' AND `user_id`= '{$get_user->user_id}'");
    $file_name=$database->fetch_array(($query));
    $file_name=$file_name['photo_name'];
     
    $query2=$database->query("SELECT `date` FROM `pl_campaign_review` WHERE `campaign_id`='{$campaigns->id}'");
    $query2=$database->fetch_array(($query2));
    $submission_date=$query2['date'];
      
?>
              

                <!-- Campaign Start -->
               <div  class="col-sm-6 col-md-3 col-lg-2";>
            
            <div  class="causes bg-white">
              <div  class="thumb"> 
               <a href="approve-campaigns_?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?>"><img src="../campaigns/campaign-photos/<?php echo $file_name; ?>" width="400" height="220"></a>
       
              </div>
              <div class="causes-details border-1px p-20">
               <i class="<?php echo get_campaign_category_icon($campaign_basics->campaign_category); ?> text-theme-colored mr-5"> <?php echo $campaign_basics->campaign_category;?></i>
              <div style="height:115px";>
                <h6><a href="approve-campaigns_?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?>"><?php echo  $campaign_basics->campaign_tittle ?></a></h6>
          <i class="fa fa-user text-theme-colored mr-5"> <?php  echo ucfirst(strtolower($get_user_name->first_name));?> 
                          <?php echo  ucfirst(strtolower($get_user_name->last_name)); ?> </i> 
             
                <p><?php echo $campaign_basics->campaign_tagline;?></p>
                 </div>
                 <p>&nbsp;</p>
                 <p>&nbsp;</p>
                  <ul class="list-inline entry-date pull-left font-12 mt-5">
                  <li class="pr-0"><a class="text black" href="#">Submitted </a></li>
                  <li class="pl-0"><span class="text-theme-colored"><?php
                  echo get_date_time($submission_date);
                  ?> 
                  
                      



                    </span></li>
                </ul>
                 <p>&nbsp;</p>
                  <p>&nbsp;</p>
                 
                
                 <p><a class="btn btn-dark btn-theme-colored btn-flat btn-sm pull-left mt-10" href="approve-campaigns_?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?>">Vet this camapign</a></p>
                 <p>&nbsp;</p>
                 
           
              </div>
            </div>
          </div>
          <?php endforeach; ?>
         
              </div><div class="clearfix"></div> <div class="clearfix"></div><?php //these clearfix keeps the pagination static wen data remains one in a current result?>
              <!-- End Portfolio Gallery Grid -->

              <div class="pagination-filter-container">
                <nav>
                  <ul class="pagination">
                  </ul>
                </nav>
              </div>

              <script type="text/javascript">
                $(document).ready(function(e){
                  $( '#portfolio-container' ).pajinate({
                    items_per_page : 3,
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
    </section>
   </div>
  <?php include('includes/footer.php'); ?>

</body>
</html>