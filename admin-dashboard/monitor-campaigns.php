<?php  include('includes/header.php'); ?>
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
<?php // unset the session first so that it doesnt conflict with the Get request ?>
<?php if(isset($_SESSION['campaign_id'])){ 
      unset($_SESSION['campaign_id']);

      } ?>
      <div class="main-content">
      <section align="left">                   
      <div class="container pt-10 pb-10">
        <h2 class="heading-border">Projects</h2>
        
                    
                   
             <?php
    $get_campaigns=campaignsManager:: find_by_sql("SELECT `id` FROM `pl_campaigns`");
   ?>
<div class="container">
<div class="table-responsive">
<table  class="table table-striped table-bordered bootstrap-datatable datatable responsive"> 
  <thead> <tr> 
    <?php $no=1;?>
    <th>#</th> <th>Tittle</th><th>Category</th><th>Location</th> <th>Date of Creation</th> <th>Status</th><th>Amount Raised</th> <th>Action</th> </tr> </thead> <tbody>
 <?php foreach ($get_campaigns as $campaigns):
      $campaign_basics=campaignBasicsManager::find_by_id($campaigns->id);
       $campaign_donations=new campaignDonationManager;

      ?>
  
  <tr class="info"> <th scope="row"><?php echo $no; $n++;?></th> 
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
     <td><?php echo  $campaign_basics->campaign_category; ?></td>
     <td><?php echo  $campaign_basics->campaign_location; ?></td> 
     <td><?php echo  $campaign_basics->campaign_creation_date; ?></td> 

     <td><?php echo  ucfirst($campaign_basics->campaign_state); ?></td>
     <td>
      <?php echo format_currency($campaign_donations->find_all_campaign_donations_by_campaign_id($campaigns->id));?> from <i class="fa fa-heart-o text-theme-colored"></i> <?php echo $campaign_donations->find_numbers_of_donations_by_campaign_id($campaigns->id);?> Donor(s)</td>
   
    <td> <?php $no++; ?>

           <a disabled class="btn btn-dark btn-theme-colored btn-xs btn-flat pull-left mt-0" href="create?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?>">Terminate Campaign</a>
      


       
     </tr> 
<?php  endforeach;?> </tbody> </table>

        </div>
                    </div>   
           
    <th><strong>Note:</strong></th> A project should never be termitted except it grossly violates ProjectLive rules or terms of use. 
                
    </section>
  <script type="text/javascript">
    // modal for for displaying campaigns for admin  
  $('.openModal').click(function(){
      var cs = $(this).attr('data-cs');0
      var cid = $(this).attr('data-cid');0
      $.ajax({url:"monitor-campaign-details?cs="+cs+"&cid="+cid,cache:false,success:function(result){
          $(".modal-content").html(result);
      }});
  });
          </script>
  <?php include('includes/footer.php'); ?>

</body>
</html>