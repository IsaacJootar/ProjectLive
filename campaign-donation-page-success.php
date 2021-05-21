<?php ob_start(); ?>
<?php session_start();?>
<?php error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); 
 // show header according to sessions
  if(isset($_SESSION['SESS_USER'])){include('includes/header-login.php');}else {
    include('includes/header.php');} ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/smsAPI.php'); ?>
<?php require_once('campaigns/classes/functions.php'); ?>
<style type="text/css">
body,td,th {
  
  color: #000000;
}
</style>


<br><br><br><br>
  <!-- Start main-content -->
  <div class="main-content">
    <!-- Section: inner-header -->
    <section class="inner-header divider layer-overlay overlay-dark" data-bg-img="images/bg/bg2.jpg">
      <div class="container pt-30 pb-30">
        <!-- Section Content -->
        <div class="section-content text-center">
          <div class="row"> 
            <div class="col-md-12  text-center">
              <?php
              $reference=$_GET['reference'];
              $payment_id=$_GET['payment_id'];
              $campaign_id=$_GET['campaign_id'];
              $name=$_GET['name'];
              $amount=$_GET['amount']/ 100; // remove the paystack conversion
       
$result = array();
//The parameter after verify/ is the transaction reference to be verified
$url = 'https://api.paystack.co/transaction/verify/'.$reference;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt(
  $ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer sk_live_9393c970d9ff34af8e9274e5b63248b2555f7024']
);
$request = curl_exec($ch);
if(curl_error($ch)){
 echo 'error:' . curl_error($ch);
 }
curl_close($ch);

if ($request) {
  $result = json_decode($request, true);
}

if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) { ?>
 <h2 class="text-white font-24" align="center"> <?php
 echo  "Your donation is received. Thank you"; ?>  
 <?php
    // update projectlive database and comfirm payment. Flag for Payment channel on debit/credit cards=1, others =0 //
  global $database;
  $query="UPDATE `pl_campaign_donations`

          SET `payment_status`=1,
           `payment_channel`=1,
              `reference_code`='{$reference}'
          WHERE `payment_id`='{$payment_id}'";

  if($database->query($query)){
   echo '.';
   $get_user=$database->query("SELECT `user_id` FROM `pl_campaigns` WHERE `id`='{$campaign_id}'");
    $get_user=$database->fetch_array($get_user);
    $get_user=$get_user['user_id'];
    $get_user_info=$database->query("SELECT * FROM `pl_users` WHERE `id`='{$get_user}'");
    $get_user_info=$database->fetch_array($get_user_info);  
    $get_user_name=$get_user_info['first_name'];

    //send SMS Notification//
    $msg="Hello $get_user_name, $name has just made a donation of $amount to your campaign on ProjectLive. Tell more people about your project.";
    $number=$get_user_info['phone'];
    $username = 'projectlive'; //your login username
    $password = '001100110011..,,..,,'; //your login password
    $sender='ProjectLive';
   $baseurl='https://api.loftysms.com/simple/sendsms';
    $url=$baseurl.'?username='.$username.'&password='.$password.'&sender='.$sender.'&recipient='.$number.'&message='.$msg;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $exe = curl_exec($ch);
    curl_close($ch);
    
    // send message to creator's account//
    $get_tittle=$database->query("SELECT `campaign_tittle` FROM `pl_campaign_basics` WHERE `campaign_id`='{$campaign_id}'");
    $get_tittle=$database->fetch_array($get_tittle);
    $get_tittle=$get_tittle['campaign_tittle'];
    $date=date('M j, Y h:i:s A');
    $message="Hello $get_user_name, your campaign  $get_tittle has just received a donation of $amount from $name.";
    
    $query2="INSERT INTO `pl_donation_notifications` (`user_id`, `message`, `date`) VALUES ('{$get_user}', '{$message}', '{$date}')";
    if(!$query2=$database->query($query2)){
      echo 'ERROR_SENDING_CREATOR_NOTIFICATION';
      exit();
    }


  }else{
   echo 'ERROR_CONFIRMING_PAYMENT'; 
   exit();
  }

   ?>
<h2/>
 <?php
}else{ ?>
  <h2 class="text-white font-24" align="center"> <?php  
  echo  "TRANSACTION_WAS_NOT_COMFIRMED". ' reference code is ' . $reference=$_GET['reference'];
   ?><h2/>
    <?php
}
   ?>                 
            </div>
          </div>
        </div>
      </div>      
    </section>

      <!-- divider: Call To Donate  Services -->
    <section class="divider parallax layer-overlay overlay-deep" data-stellar-background-ratio="0.2"  data-bg-img="images/bg/bg2.jpg">
      <div class="container">
        <div class="section-content text-center">
          <div class="row">
            <div class="col-md-12">
              <h3 class="mt-0"> You can even fund a campaign offline, its very easy.</h3>
              <h2>   
Just call <span class="text-theme-colored">+234 (0) 806 916 8444 </span> for answers now!</h2>
            </div>
          </div>
        </div>
      </div>      
    </section>

    <!-- divider: Gallery -->
    <!-- divider: Gallery -->
    <section class="divider bg-lighter">
      
        <div class="section-content">
          <div class="row">
            <?php include('includes/gallery.php');// similar campaigns shud follow down later?>
          </div>
        </div>
      </div>
    </section>

  <!-- end main-content -->
   <!-- Footer -->
  <?php include('includes/footer.php'); ?>
</body>
</html>