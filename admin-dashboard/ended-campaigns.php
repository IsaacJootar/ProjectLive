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
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- The styles -->
    <!-- The styles -->
    <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">

    <link href="css/charisma-app.css" rel="stylesheet">
    <link href='bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <link href='bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='css/jquery.noty.css' rel='stylesheet'>
    <link href='css/noty_theme_default.css' rel='stylesheet'>
    <link href='css/elfinder.min.css' rel='stylesheet'>
    <link href='css/elfinder.theme.css' rel='stylesheet'>
    <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='css/uploadify.css' rel='stylesheet'>
    <link href='css/animate.min.css' rel='stylesheet'>

    <!-- jQuery -->
    <script src="bower_components/jquery/jquery.min.js"></script>


    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="img/favicon.ico">

</head>

<body>
<div class="ch-container">
    <div class="row">
        
       
        

        
    <div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div>
        <h3>ProjectLive Africa: Ended Campaigns</h3>

        <div class="box-icon">
           
            <a href="#" class="btn btn-minimize btn-round btn-default"><i
                    class="glyphicon glyphicon-chevron-up"></i></a>
            
        </div>
    </div> <?php
    $get_campaigns=campaignsManager:: find_by_sql("SELECT `pl_ended_campaigns`. `campaign_id`,  `pl_campaigns`. `id` FROM `pl_ended_campaigns` JOIN `pl_campaigns` ON `pl_ended_campaigns`. `campaign_id`=`pl_campaigns`. `id`");
   ?>
    <div class="box-content">
    

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
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
     <thead> 
 <tr> 
        <?php $no=1;?>
        <th>#</th> 
        <th>Tittle</th>
        <th>Category</th>
        <th>Location</th> 
        
       
        <th>Amount Raised</th>
        <th>Send campaign ended e-Mail</th> 
        <th>Send campaign payout e-Mail</th> 
</tr> 
</thead> 
<tbody>
 <?php foreach ($get_campaigns as $campaigns):
      $campaign_basics=campaignBasicsManager::find_by_id($campaigns->id);
       $campaign_donations=new campaignDonationManager;

      ?>
  
  <tr class="info"> <th scope="row"><?php echo $no; $n++;?></th> 
    <td> 
        <button type="button" class="btn btn-dark btn btn-xs btn-flat pull-left mt-0"><?php echo  $campaign_basics->campaign_tittle ?></button>
    </td>
     <td><?php echo  $campaign_basics->campaign_category; ?></td> 
     <td><?php echo  $campaign_basics->campaign_location; ?></td> 

     <td>
      <?php echo format_currency($campaign_donations->find_all_campaign_donations_by_campaign_id($campaigns->id));?> from <i class="fa fa-heart-o text-theme-colored"></i> <?php echo $campaign_donations->find_numbers_of_donations_by_campaign_id($campaigns->id);?> Donor(s)</td>
   
    <td> <?php $no++; ?>
      notification status:
<?php
// get SMS and e-Mail notification status//
 if(!$status=$database->query("SELECT * FROM `pl_campaign_payouts` WHERE `campaign_id`='{$campaigns->id}'")){
  echo 'ERROR_GETTING_PAYOUT_DATA';
    exit();
  }
  $status=$database->fetch_array(($status));
   if($status['flag']==0){echo "<span class='label-alert label label-default'>not yet sent</span>";}else{ echo "<span class='label-success label label-default'>sent</span>";}

?>    

<p></p><a class="btn btn-dark btn-theme-colored btn-xs btn-flat pull-left mt-0" href="ended-campaigns-noti?ref=<?php echo $campaigns->id; ?>">Send campaign end e-Mail& SMS</a>

    </td>
    <?php 
if($campaign_donations->find_all_campaign_donations_by_campaign_id($campaigns->id) < 1){echo "<td><span class='label-alert label label-default'>no funds was raised</span></td>";}else{ ?>
 <td> <a class="btn btn-dark btn-theme-colored btn-xs btn-flat pull-left mt-0"
  href="payout-campaigns-noti?ref=<?php echo $campaigns->id; ?>">Send campaign payout e-Mail& SMS</a>
      <?php } ?>
    </td>

       
     </tr> 
<?php  endforeach;?> </tbody> </table>
    </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->


</body>
</html>
<?php include('includes/footer.php'); ?>