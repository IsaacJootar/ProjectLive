<?php include ('includes/header-login.php');?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/campaigns.php'); ?>
<?php require_once('classes/campaign-basics.php'); ?>
<?php require_once('classes/campaign-photos.php'); ?>
<?php require_once('classes/user.php'); ?>
<?php require_once('../classes/campaign-donations.php'); ?>
<?php // unset the session first so that it doesnt conflict with the Get request ?>
<?php if(isset($_SESSION['campaign_id'])){ 
      unset($_SESSION['campaign_id']);

      } ?>

 <section align="left">                   
      <div class="container pt-10 pb-10" align="left">
        <h2 class="heading-border">Manage Projects</h2>
        <div class="section-content"a align="left">
          <div class="row" align="left">
            <div class="col-md-16" align="left">
              <div class="horizontal-tab-centered text-center ">
                <ul class="nav nav-pills mb-10">
                  <li class="active"> <a href="#tab-1" class="" data-toggle="tab" aria-expanded="false"> <i class="fa fa-edit"></i>My campaigns</a> </li>
                  <li class=""> <a href="#tab-2" data-toggle="tab" aria-expanded="false"> <i class="fa fa-money"></i> My Payouts</a> </li>
                   <li class=""> <a href="#tab-3" data-toggle="tab" aria-expanded="false"> <i class="fa fa-globe"> </i> My success Story</a> </li>
                 
                </ul>
                <div class="panel-body" align="left">
                  <div class="tab-content no-border" align="left">
                  
                     <div class="tab-pane fade active in" id="tab-1"  align="left">
                      <div class="row" align="left">
                        <div class="col-sm-5" align="left">
                          <h4 class="mt-0 mb-30 line-bottom">My Projects</h4>
                          <p><h6>Don't worry, only you can see your campaigns.</h6><p>
        <?php
    $get_campaigns=campaignsManager:: find_by_sql("SELECT `id` FROM `pl_campaigns` WHERE `user_id`='{$user_id}'");
   ?>
<div class="container">
<div class="table-responsive">
<table class="table table-bordered"> 
  <thead> <tr> 
    <?php $no=1;?>
    <th>#</th> <th>Campaign Tittle</th> <th>Date of<br/> Creation</th> <th>Campaign<br/> Status</th><th>Amount<br/> Raised</th> <th>Action</th> </tr> </thead> <tbody>
 <?php foreach ($get_campaigns as $campaigns):
      $campaign_basics=campaignBasicsManager::find_by_id($campaigns->id);
       $campaign_donations=new campaignDonationManager;

      ?>
  
  <tr class="info"> <th scope="row"><?php echo $no;?></th> 
    <td> <a  class="openModal" data-toggle="modal" data-target="#myModal" data-cs="<?php echo $campaign_basics->campaign_state;?>" 
          data-cid="<?php echo $campaigns->id;?>">
          <button type="button" class="btn btn-dark btn btn-xs btn-flat pull-left mt-0"><?php echo  $campaign_basics->campaign_tittle ?></button>
                       
                    </a>  </td>
  <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
       
                  
          </div>
                
      </div>
  </div>
     
     <td><?php echo  $campaign_basics->campaign_creation_date; ?></td> 

     <td><?php echo  ucfirst($campaign_basics->campaign_state); ?></td>
     <td>
      <?php echo format_currency($campaign_donations->find_all_campaign_donations_by_campaign_id($campaigns->id));?> from <i class="fa fa-heart-o text-theme-colored"></i> <?php echo $campaign_donations->find_numbers_of_donations_by_campaign_id($campaigns->id);?> Donor(s)</td>
   
    <td>
     
<?php $no++;
   if($campaign_basics->campaign_state=='declined'){ 
// wen status is declined, check to be sure this state has remained for atleast 2 hours bfor allowing edition//
    
    $campaigns=$database->query("SELECT  `date_declined` FROM `pl_declined_campaigns` 
        WHERE `campaign_id`= '{$campaigns->id}'");// check query for exceptions always-but I feel lazy now, come back later//
      if($database->num_rows($campaigns) >=1){ 
          // get the time when this capiagn was declined//
          $declined_time=$database->fetch_array($campaigns); 
          $then = $declined_time['date_declined']; //that is then, to be compared with now//
          // This is now, time when a creator is trying to edit campaign, making sure its not less than 2 hours//
          $datetime1 =$then;
          $time_diff=time()-$then;
          $time_diff=floor($time_diff/60);// divide the time by 60 mins, to covert to mins//
            if($time_diff < 1){// 120 minutes will equal 2 hours- for now i had to change it back to 1 min. Let creators edit as soon as declined//
            echo '';

            }else{ // show edit button?>
           <a class="btn btn-dark btn-theme-colored btn-xs btn-flat pull-left mt-0" href="create?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?>">Edit campaign</a>
        <?php  }

      }
  }


        if($campaign_basics->campaign_state=='build up'){ ?>
          <a class="btn btn-dark btn-theme-colored btn-xs btn-flat pull-left mt-0" href="create?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?>">Edit campaign</a>
  <?php }

       if($campaign_basics->campaign_state=='live'){
         echo ''; // no editing button is shown//
       }
        if($campaign_basics->campaign_state=='ended'){
         echo ''; // no editing button is shown//
       }

             ?>
     </tr> <tr> 

  </tr>
<?php  endforeach;?> </tbody> </table>

        </div></br>
        <div class="entry-content border-1px p-20">  
                  <div class="timeline-block">
                      
        <div class="text-justify"> <th><strong>Tips:</strong></th> If a campaign is declined, creators are allowed to make changes to their campaigns and resubmit again for review.</div>
                <div class="tab-pane fade" id="tab-5" align="left">
                      <div class="row" align="left">
                        <div class="col-sm-5" align="left">
                          <h4 class="mt-0 mb-30 line-bottom">Delete Account</h4>
                          <p>This deletion will remove all your content from this platform. Are you sure you want to precced?</p>
                     
                        </div>
                      </div>
                    </div>
                    </div>   
           
   
                </div>
                      </div>           
                        </div>
                      </div>
                    </div>



                    <div class="tab-pane fade" id="tab-2" align="left">
                        <div class="row" align="left">
                        <div class="col-sm-5" align="left">
                          <h4 class="mt-0 mb-30 line-bottom">My Payouts</h4>
                          <p><h6>Don't worry, only you can see your payouts.</h6><p>
                              
         <?php
    $get_payouts=$database->query("SELECT * FROM  `pl_campaign_payouts` WHERE `pl_campaign_payouts`. `user_id`='{$user_id}'");
    
   ?>
         
             <?php
    //$get_campaigns=campaignsManager:: find_by_sql("SELECT `id` FROM `pl_campaigns` WHERE `user_id`='{$user_id}'");
   ?>
<div class="container">
<div class="table-responsive">
<table class="table table-bordered"> 
  <thead> <tr> 
    <?php $no=1;?>
    <th>#</th> <th> Title</th><th>Category</th> <th>State</th><th>Date of<br/> creation</th><th>Date ended</th><th>Target<br/> goal</th><th>Amount<br/> raised</th><th>Donation channels</th><th>Fees (Platform & cards processing)</th> <th>Amount due </th><th>Payout Status</th><th>Payout confirmation  status</th> </tr> </thead> <tbody>
 <?php foreach ($get_payouts as $payouts):

      ?>
  
  <tr class="info"> <th scope="row"><?php echo $no;?></th> 
    <td> 
          <button type="button" class="btn btn-dark btn btn-xs btn-flat pull-left mt-0"><?php echo  $payouts['campaign_title'];?></button>
                       
                     </td>
  
     
     <td><?php echo  $payouts['category']; ?></td> 

     <td><?php echo  $payouts['campaign_state']; ?></td>
     <td><?php echo $payouts['campaign_creation_date'];?></td>
     <td><?php echo $payouts['campaign_end_date'];?></td>
     <td><?php echo format_currency($payouts['target_goal']);?></td>
      <td><?php echo format_currency($payouts['amount_raised']);?></td>
      <td><strong class="text-theme-colored">Online:</strong> <?php echo $payouts['cards']. '</br>';?> <strong class="text-theme-colored">other channels:</strong> <?php echo $payouts['others'];?></td>
    
     <td><?php echo format_currency($payouts['platform_fees']);?></td>
      <td><?php echo format_currency($payouts['amount_due']);?></td>
     <td><?php echo $payouts['payout_status'];?></td>
  <td><?php echo $payouts['payout_comfirm_status'];?></td>
 
            
     </tr> <tr> 

  </tr>
<?php  endforeach;?> </tbody> </table>

          </div>
       </br>
       <div class="entry-content border-1px p-20">  
                  <div class="timeline-block">
       <div class="text-justify">        
    <th><strong>For Local Transactions:</strong></th> charges are 1.5% + NGN 100. The ₦100 fee is waived for transactions under ₦2500.
<br>
<th><strong>For International Transactions:</strong></th>
3.9% + NGN 100.
The ₦100 fee is waived for transactions under ₦2500.
International cards are charged and settled in Naira by default, but you can also choose to get settled in USD.
<br>
Please note that card processing fees apply only on online donation channels.
<br>
ProjectLive fee remains 5% on each transaction.
</div>     
     </div>
                      </div>
                      </div>    
                        </div>
                      </div>
                    </div>
     
             <div class="tab-pane fade" id="tab-3" align="left">
                      <div class="row" align="left">
                        <div class="col-sm-5" align="left">
                          <h4 class="mt-0 mb-30 line-bottom">Success Story.</h4>
                          
  <div class="entry-content border-1px p-20">  
                  <div class="timeline-block">
                      
                      <article class="post clearfix">
                        <div class="entry-header">
                        <h6>Success Story feeds are updated when campaigns reach 100% of their target goals</h6></span>
                        </div>
                       
                      </article>
                    </div>
                    </div>
                        </div>
                      </div>
                    </div>       
                   
                     
                    
                   

    </section>
    
   <div class="row"> 
            <div class="col-md-12  text-center">
              <h2>Achieve your campaign goal in four simple steps</h2>
              
            </div>
          </div>
       
<div class="main-content">
    <!-- Section: home -->    
      <!-- divider: acheive in 4 easy step -->
    <section>
    <div class="row mt-30">
          <div class="col-sm-3">
            <div class="icon-box iconbox-theme-colored">
              <a  href="../learn" class="icon icon-dark icon-circled icon-border-effect effect-circled icon-sm pull-left mb-0 mr-10" href="#">
                <i class="pe-7s-switch"></i>
              </a>
              <h5 class="icon-box-title mt-15 mb-20"><a href="../learn">Start a Campaign</a></h5>
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
              <p class="text-gray">Use the funds you have received to execute the project. Appreciate your donors and share your success story to our community. That's it. Simple!</p>
            </div>
          </div>
        </div>
    </section>


    
  <?php include('../includes/campaign-heads-up.php');?>
  <!-- Footer -->

  <?php include('includes/footer.php'); ?>

</body>
<script type="text/javascript">
    // modal for for displaying campaigns   
  $('.openModal').click(function(){
      var cs = $(this).attr('data-cs');0
      var cid = $(this).attr('data-cid');0
      $.ajax({url:"view-campaign.php?cs="+cs+"&cid="+cid,cache:false,success:function(result){
          $(".modal-content").html(result);
      }});
  });
          </script>