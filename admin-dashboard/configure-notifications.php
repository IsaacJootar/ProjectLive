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
        <h2 class="heading-border">Configure System Notifications.</h2>
      
<div class="container">
<div class="table-responsive">
<table class="table table-bordered"> 
  <thead> <tr> 
    <?php $no=1;?>
    <th>#</th> <th>Notification</th> <th>System Status</th></tr> </thead> <tbody>
  
  <tr class="info"> <th scope="row">1</th>
 
    <td>Send creators an email any time creator's campaign receives a donation.</td>
  
     <td><input type="checkbox" checked> ON</td> 
      <tr class="info"> <th scope="row">2</th>
<td> Send creators an SMS notification any time creator's campaign receives a donation.</td>
  
   <td><input type="checkbox" checked> ON</td>
   <tr class="info"> <th scope="row">3</th>
 
    <td>Send notifications to a creator's ProjectLive account when their campaign receives a donation.</td>
  
     <td><input type="checkbox" checked> ON</td> 
      <tr class="info"> <th scope="row">4</th>
<td> Send creators an email notification any time creator's campaign is approved.</td>
  
   <td><input type="checkbox" checked> ON</td>
 
    
      <tr class="info"> <th scope="row">5</th>
<td> Send creators an SMS notification any time creator's campaign is declined.</td>
 <td><input type="checkbox" checked> ON</td> 
  
   
 </tr> 
 </tbody> </table>

        </div>
                    </div>   
           
    <th><strong>Tips:</strong></th>These notifications are creator specific. 
                
    </section>
  
  <?php include('includes/footer.php'); ?>

</body>
</html>