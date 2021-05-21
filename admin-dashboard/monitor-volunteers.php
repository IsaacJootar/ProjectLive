<?php  include('includes/header.php'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('../campaigns/classes/database.php'); ?>
<?php require_once('../campaigns/classes/database-object.php'); ?>
<?php require_once('../campaigns/classes/functions.php'); ?>
<?php require_once('../campaigns/classes/campaign-basics.php'); ?>
<?php require_once('../campaigns/classes/campaigns.php'); ?>
<?php require_once('../campaigns/classes/campaign-goal.php'); ?>
<?php require_once('../campaigns/classes/campaign-story.php'); ?>
<?php require_once('../classes/volunteer.php'); ?>

<?php require_once('../classes/campaign-donations.php'); ?>
<?php // unset the session first so that it doesnt conflict with the Get request ?>
<?php if(isset($_SESSION['campaign_id'])){ 
      unset($_SESSION['campaign_id']);

      } ?>
      <div class="main-content">
      <section align="left">                   
      <div class="container pt-10 pb-10">
        <h2 class="heading-border">ProjectLive Volunteers</h2>
        
                    
                   
             <?php
    $get_volunteers=volunteerManager:: find_by_sql("SELECT * FROM `pl_volunteers`");
   ?>
<div class="container">
<div class="table-responsive">
<table  class="table table-striped table-bordered bootstrap-datatable datatable responsive"> 
  <thead> <tr> 
    <?php $no=1;?>
    <th>#</th> <th>Names</th> <th>e-Mail</th> <th>Gender</th><th>Volunteering State</th><th>Phone</th> <th>Date of Joining</th> </tr> </thead> <tbody>
 <?php foreach ($get_volunteers as $users):

      ?>
  
  <tr class="info"> <th scope="row"><?php echo $no; $n++;?></th> 
    <td> <?php echo  ucfirst($users->name); ?></td>
  <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
       
                  
          </div>
                
      </div>
  </div>
     
     <td><?php echo  ucfirst($users->email); ?></td> 

     <td><?php echo  ucfirst($users->gender); ?></td>
     <td>
      <?php echo  ucfirst($users->state); ?></td>
      <td>
      <?php echo  ucfirst($users->phone); ?></td>
      <td>
      <?php echo  ucfirst($users->date); ?></td>
   
    <?php $no++; ?>

          


       
     </tr>
<?php  endforeach;?> </tbody> </table>

        </div>
                    </div>   
           
    <th><strong>Tips:</strong></th>These are volunteers, seperate accounts  from creators and general users
                
    </section>
  
  <?php include('includes/footer.php'); ?>

</body>
</html>