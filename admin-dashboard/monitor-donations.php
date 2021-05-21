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
    <!DOCTYPE html>
<html lang="en">
<head>

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
        <h3>ProjectLive Africa: Campaigns Donations</h3>

        <div class="box-icon">
           
            <a href="#" class="btn btn-minimize btn-round btn-default"><i
                    class="glyphicon glyphicon-chevron-up"></i></a>
            
        </div>
    </div> <?php
    $get_campaigns=campaignDonationManager::find_by_sql("SELECT * FROM `pl_campaign_donations` WHERE `payment_status`=1 AND `reference_code` !='' AND `payment_id` !='' ORDER BY `id` DESC");
   ?>
   <div class="box-content">
    

      <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
     <thead>  <tr> 
    <?php $no=1;?>
    <th>#</th> <th>Tittle</th><th>Category</th><th>Name of Donor</th> <th>Amount</th><th>Payment ID</th><th>Reference Code</th><th>Payment channel</th></th><th>Paystack(1.5% +)</th> <th>ProjectLive(5%)</th> </tr> </thead> <tbody>
 <?php foreach ($get_campaigns as $campaigns):
     
      $campaign_basics=$database->query("SELECT * FROM `pl_campaign_basics` WHERE `campaign_id`='{$campaigns->campaign_id}'");
       //$campaign_donations=new campaignDonationManager;
      $campaign_basics=$database->fetch_array($campaign_basics);
      ?>
  
  <tr class="info"> <th scope="row"><?php echo $no; $n++;?></th> 
   <td><?php echo   $campaign_basics['campaign_tittle']; ?></td>
     <td><?php echo  $campaigns->campaign_category; ?></td> 
     <td><?php echo  $campaigns->name_of_donor; ?></td> 
     <td><?php echo format_currency($campaigns->donation_amount); ?></td> 
       <td><?php echo  $campaigns->payment_id; ?></td> 
         <td><?php echo  $campaigns->reference_code; ?></td> 
                 <td><?php if($campaigns->payment_channel==1){echo 'Card';}else{echo 'Others';} ?></td>  
        

   
      <td><?php //payments not made by cards shud not be feesed bt paystack//
      if($campaigns->payment_channel==0) {echo'-';}
      elseif ($campaigns->donation_amount < 2500){echo  number_format("$campaigns->donation_amount"* 1.5/100, 2); 
      }else {echo  number_format("$campaigns->donation_amount"* 1.5/100+100, 2); } ?></td>
       <td><?php echo  format_currency($campaigns->donation_amount* 5/100); ?></td>
      

     <?php $no++; ?>

       
     </tr> 
<?php  endforeach;?> </tbody> </table>

        </div>
      </div> </br>  
    <div class="text-justify">        
    <th><strong>For Local Transactions:</strong></th> charges are 1.5% + NGN 100. The ₦100 fee is waived for transactions under ₦2500. Local transactions fees are capped at ₦2000, meaning that's the absolute maximum paystack will ever charge in fees per transaction.
<br>
<th><strong>For International Transactions:</strong></th>
3.9% + NGN 100.
The ₦100 fee is waived for transactions under ₦2500.
International cards are charged and settled in Naira by default, but you can also choose to get settled in USD.
<br>
ProjectLive fee remains 5% on each transaction.
</div>             
    </section>
  
  <?php include('includes/footer.php'); ?>

</body>
</html>