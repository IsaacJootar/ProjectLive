<?php include ('includes/header.php');?>
<?php require_once('includes/config.php'); ?>
<?php require_once('../campaigns/classes/database.php'); ?>
<?php require_once('../campaigns/classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php  require_once('classes/functions.php'); ?>
<?php include ('classes/user.php');?>                  
      <div class="" align="left">
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
        <h2 class="text-theme heading-border">ProjectLive Administrator Dashboard</h2>
      </div>
    
  <div style="height: 390px">
  </div>
<div class="main-content">
    <!-- Section: home -->

<!-- Footer -->
  <?php include('includes/footer.php'); ?>

</body>
</html>