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
        <h3>ProjectLive Africa: Comfirm Payouts.</h3>

        <div class="box-icon">
           
            <a href="#" class="btn btn-minimize btn-round btn-default"><i
                    class="glyphicon glyphicon-chevron-up"></i></a>
            
        </div>
    </div> <?php
    $get_payouts=$database->query("SELECT * FROM  `pl_campaign_payouts`");
    
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
     <thead> <tr> 
    <?php $no=1;?>
    <th>#</th> <th> Title</th><th>Category</th> <th>State</th><th>Date of<br/> creation</th><th>Date ended</th><th>Target<br/> goal</th><th>Amount<br/> raised</th><th>Amount due </th><th>Fees(Platform & cards processing)</th> <th>Payout Status</th><th>Payout confirmation  status</th><th>Confirm payment</th> </tr> </thead> <tbody>
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
     <td><?php echo format_currency($payouts['amount_due']);?></td>
     <td><?php echo format_currency($payouts['platform_fees']);?></td>
     <td><?php echo $payouts['payout_status'];?></td>
  <td><?php echo $payouts['payout_comfirm_status'];?></td>
 <td><p></p><a class="btn btn-dark btn-theme-colored btn-xs btn-flat pull-left mt-0" href="comfirm-payouts_?ref=<?php echo $payouts['campaign_id']; ?>">Comfirm payment</a>

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