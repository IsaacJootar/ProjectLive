<?php ob_start(); ?>
<?php session_start();?>
<?php error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); 
 // show header according to sessions
  if(isset($_SESSION['SESS_USER'])){include('includes/header-login.php');}else {
    include('includes/header.php');} ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('campaigns/classes/database.php'); ?>
<?php require_once('campaigns/classes/database-object.php'); ?>
<?php require_once('campaigns/classes/functions.php'); ?>
<?php require_once('campaigns/classes/campaign-basics.php'); ?>
<?php require_once('campaigns/classes/campaigns.php'); ?>
<?php require_once('campaigns/classes/campaign-photos.php'); ?>
<?php require_once('campaigns/classes/campaign-goal.php'); ?>
<?php require_once('campaigns/classes/campaign-story.php'); ?>
<?php require_once('campaigns/classes/user.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/campaign-donations.php'); ?>
<?php 
// i dont like the idea of querying the database again for this campaign_id, i will get it from the session variable from the previous page later/ am feeling lazy for now//


//get campaign id and supply to the method for campaign details//
  if(isset($_SESSION['campaign_id'])){
    $set_campaign_id=  $_SESSION['campaign_id'];
  }
elseif(isset($_GET['ref'])){
         $campaign_tittle=str_replace('-', ' ', $_GET['ref']); // remove the dashes from the tittle//
         $campaign_id=$database->query("SELECT `campaign_id` FROM `pl_campaign_basics` WHERE `campaign_tittle`= '{$campaign_tittle}'");
        $campaign_id=$database->fetch_array($campaign_id);
        $set_campaign_id=$campaign_id['campaign_id'];
      }

      else {$session->message("Campaign id reset, please fill the informations and submit again");
      header('location:../sign-in-form');
      exit();
    }
?>

 <!-- Start main-content -->

 <p>&nbsp;</p> <p>&nbsp;</p> <p>&nbsp;</p>  
<div class="container">
   <!-- Divider: Campaign Page details -->

    <section>
     <h5 align="left" font-weight-"500">You are donating to   </h5>
      <?php
  
    $campaign_basics=campaignBasicsManager::find_by_id($set_campaign_id);
    $get_user=campaignsManager::find_user_by_campaign_id($set_campaign_id);
    $get_user_name=userManager::find_user_by_id($get_user->user_id);
    $get_campaign_story=campaignStoryManager::find_campaign_story_by_campaign_id($set_campaign_id);
  ?>

  <?php 
    $payment_id=time();
    $payment_id= $payment_id.uniqid();
    $payment_id=substr($payment_id, -7); // for this purpose this is unique enuf//
  ?>
      <h3 align="left" class="media-heading text-uppercase font-weight-500"><?php echo   $campaign_basics->campaign_tittle; ?>  </h3>
      <strong  class="">This campaign was created By:</strong> <b class="text-theme-colored">
                          <?php  echo ucfirst(strtolower($get_user_name->first_name));?> 
                          <?php echo  ucfirst(strtolower($get_user_name->last_name)); ?></b>
        <div class="row">
          <div class="col-sm-11 col-md-8">
            <div class="upcoming-events media bg-white p-15 pb-60 mb-50 mb-sm-30">
              <div class="thumb" align="left">
              <br/>
                      <div class="bg-lightest border-1px p-30 mb-0">
  <h4 class="text-theme-colored mt-0 pt-"> Secure Donation Page <i class="fa fa-check-circle text-theme-colored"></i></h3>
Please note that this donation will go directly to the beneficiary (<i class="text-theme-colored"><?php echo $campaign_basics->campaign_beneficiary; ?> </i>). All online donations are securely handled by <a class="text-theme-colored" target="_blank" href="https://paystack.com/"> Paystack</a></br>
   
   <?php
      
                         echo  '<strong style="font-size:30px">'.$session->display_error().'</strong>';;
            
        ?> 
  <label for="form_name"><strong>Donation Amount</strong> <strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="This is the amount of money you want to donate for this project. Foreign currencies will be reconciled authomatically"> </i></label>
                  <form id="donation_form" name="donation_form" method="post" action="">
                    
                    <div class="input-group">
      <div class="input-group-addon">₦</div>
      <input id="chatinput" required name="donor_amount" value="<?php echo @$_POST['donor_amount']?>"  type="number" min="5"  class="form-control" id="inputAmount" placeholder="Enter Amount Here">
 
      <div class="input-group-addon">.00</div>
    </div>
        
                    <div class="row">
                     <div class="col-sm-6">
                     
                        <div class="form-group">
                          <label for="form_name"><br />
                          Donors Name <strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Donors name is compulsory, it is a requirement to process the transaction. However, if you select 'Hide donors name', the donors name will remain anonymous, and will be hidden from the public"> </i></label>
                          <input id="form_name" name="donor_name" value="<?php echo @$_POST['donor_name']?>" type="text" placeholder="Enter Name Here" required="required"  class="form-control">
                          <input name="payment_id" type="hidden" value="<?php echo $payment_id; ?>">
                    
                  <div class="col-md-12">
                    <div class="form-group mb-20">
                      <?php  // 0 is hide flag, 1 is reveal ?>
                      <label><strong>Identity Option</strong></label> <br>
                      <label class="radio-inline">
                        <input type="radio" checked="" value="1" name="donor_identity"> 
                        display donors name
                      </label>
                      <label class="radio-inline">
                        <input type="radio" value="0" name="donor_identity"> 
                       Hide donors name
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-12" id="donation_type_choice">
                   
                      <div class="radio mt-5">
                        <label class="text-theme-colored">
                        This option will hide donors name and contribute anonymously
                        </label>
                     
                    </div>
                  </div>

                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                           <label for="form_name"><br />
                          Donor' Phone No.[optional] <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Donors phone number is also important for reaching you when neccessary, "> </i></label>
                          <input id="form_name" name="donor_phone"  value="<?php echo @$_POST['donor_phone']?>"type="text" placeholder="Enter Phone Number Here" class="form-control">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="form_name"><br />
                          Donors Email [if any] <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Donors email is important for processing cards for payments and sending you payment receipt . "> </i></label>
                          <input id="form_email" name="donor_email" value="<?php echo @$_POST['donor_email']?>" class="form-control required email" type="email" placeholder="Enter Email Here">
                        </div>
                      </div>
                    </div>
                    <div class="row">               
                     
                      <div class="col-sm-6">
                        
                      </div>
                    </div>
                    <div class="form-group">
                       <label for="form_comment"><br />
                          Comment [optional] <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Beneficiaries read these comments, they mean alot to them, say something soothing."> </i></label>
                      <textarea id="form_message" name="donor_comment" class="form-control" rows="5" placeholder="Please, leave a comment for the creator"></textarea>
                    </div>
                    <input type="hidden" name="campaign_id" value="<?php echo $set_campaign_id; ?>">
                    <input type="hidden" name="campaign_tittle" value=" <?php echo   $campaign_basics->campaign_tittle; ?>">
                   
                    <div class="form-group">
                      <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="" />
                      <button type="submit" name="comfirmPayment" class="btn btn-block btn-dark btn-theme-colored btn-sm mt-20 pt-10 pb-10" data-loading-text="Please wait...">Proceed to secured payment</button>
                    </div>
                     <p>
               By proceeding you agree to our <a target="_blank"href="terms-of-use"><strong class="text-theme-colored">Terms of Use</strong></a>.
                      </p>
              
              </div>
                 <ul class="styled-icons icon-dark mt-20">
              <li class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".1s" data-wow-offset="10"><img src="images/visa.jpg" width="61" height="41" alt=""/></li>
           
              <li class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".2s" data-wow-offset="10"><img src="images/verve.jpg" width="61" height="41" alt=""/>
           </li>
              <li class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".4s" data-wow-offset="10"><img src="images/master.jpg" width="61" height="41" alt=""/></a></li>
              
<li class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".4s" data-wow-offset="10"><img src="images/secure.jpg" width="61" height="41" alt=""/></a> All online donations are securely handled by paystack.
           
            </ul>
              <a href=campaigns/campaign-page-details?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?> style="float: left" class="btn btn-dark btn-flat btn-sm pull-left mt-15">Return back to campaign </a> 
            </div>
           </div>
               
             
         
            <?php // featured projects goes here later, mayb after 2 years of running this platform// ?>
          </div>
          <div class="col-sm-13 col-md-4">
            <div class="sidebar sidebar-right mt-sm-30">
             
              <div class="widget">
                <div class="event-count causes clearfix p-15 mt-15 border-left">

                <h5 class="widget-title line-bottom">Help make this campaign a success.</h5>
              
     
 
      <div id="printchatbox" class="input-group-addon"></div>
<div align="center"; style="font-weight: bold;">
Goal: <?php echo format_currency($campaign_goal=campaignGoalManager::find_all_campaign_goal_by_campaign_id($set_campaign_id));?></div>
               
                <div align="left"; style="font-size:11px">Please note that this donation will go directy to the beneficiary <i class="text-theme-colored"> (<?php echo $campaign_basics->campaign_beneficiary; ?>) </i>.     </div></br>
                

              <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fprojectlive.ng%2Fcampaigns%2Fcampaign-page-details?ref=<?php echo urlencode(str_replace(' ', '-', $campaign_basics->campaign_tittle)); ?>&amp;src=sdkpreparse" class="btn btn-dark btn-lg btn-block no-border mt-11 mb-11" data-bg-color="#3b5998">Share their story on facebook</a>
                 <div id="accordion1" class="panel-group accordion transparent"></br>
             <div><strong>FREQUENTLY ASKED QUESTIONS</strong></div>   
  <div class="panel">
    <div class="panel-title"> <a data-parent="#accordion1" data-toggle="collapse" href="#accordion11" class="" aria-expanded="true"> <span class="open-sub"></span> How to I donate? </a> </div>
    <div id="accordion11" class="panel-collapse collapse" role="tablist" aria-expanded="true">
      <div class="panel-content">
        <p>Enter your pledge amount and the informations needed in the form. Then, click on proceed to secure payment, there you will enter your payment informations for<a class="text-theme-colored" target="_blank" href="https://paystack.com/"> Paystack</a> to complete the checkout process.</p>
      </div>
    </div>
  </div>
  <div class="panel">
    <div class="panel-title"> <a class="collapsed" data-parent="#accordion1" data-toggle="collapse" href="#accordion12" aria-expanded="false"> <span class="open-sub"></span>What can others see about my donation?</a> </div>
    <div id="accordion12" class="panel-collapse collapse" role="tablist" aria-expanded="false" style="height: 0px;">
      <div class="panel-content">
        <p>Generally your donations are visible to users of this platform, however, during donation, you may choose to hide your identity and contribute anonymously, in this case, your name will be hidden from the public.</p>
      </div>
    </div>
  </div>
   <div class="panel">
    <div class="panel-title"> <a data-parent="#accordion1" data-toggle="collapse" href="#accordion13" class="" aria-expanded="true"> <span class="open-sub"></span> How safe are my payment details? </a> </div>
    <div id="accordion13" class="panel-collapse collapse" role="tablist" aria-expanded="true">
      <div class="panel-content">
        <p>At ProjectLive Africa we take the security of our users very seriously. Our platform utilizes the Secure Sockets Layer (SSL) Protocol. Payment cards are also securely processed and managed by <a class="text-theme-colored" target="_blank" href="https://paystack.com/"> paystack</a> our payment partners. We do not collect, store or keep any of your card details during donation.</p>
      </div>
    </div>

<div class="panel">
    <div class="panel-title"> <a data-parent="#accordion1" data-toggle="collapse" href="#accordion14" class="" aria-expanded="true"> <span class="open-sub"></span> Which other means of payment can I use? </a> </div>
    <div id="accordion14" class="panel-collapse collapse" role="tablist" aria-expanded="true">
      <div class="panel-content">
        <p>ProjectLive makes donations to campaigns very easy, during payment, you can choose from four options-(1) secure online payment using your ATM cards, (2) bank transfer,  (3) USSD (GTB 737) and 
Visa QR code. mCash and
POS options are coming soon. You can also give us a call to help you on how best you can contribute to a campaign.</p>
      </div>
    </div>

<div class="panel">
    <div class="panel-title"> <a data-parent="#accordion1" data-toggle="collapse" href="#accordion15" class="" aria-expanded="true"> <span class="open-sub"></span> What if I want a refund of my donations? </a> </div>
    <div id="accordion15" class="panel-collapse collapse" role="tablist" aria-expanded="true">
      <div class="panel-content">
        <p>ProjectLive is a donation based crowdfunding platform, we do not refund pledges, however when ProjectLive terminates an ongoing campaign for voilating the platform rules & regulations, all donations associated to that campaign are returned back to donors within 7 working days.   </p>
      </div>
    </div>
  </div>
</div></div>    
              </div>

             
            </div>
      </div>
    </section>
  </div>
 </form>
  
                 

                
 </div>
              </form>
              <?php // if user submits form, display donation confirmation page/ ?>
<?php if (isset($_POST['comfirmPayment'])) { 


$_SESSION['donor_phone']=$_POST['donor_phone'];
  ?>


<script>
$(function() {
$("#myModal").modal();//if you want you can have a timeout to hide the window after x seconds
});
</script>
<form id="manualPayment" name="manualPayment">
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
       
        <div class="modal-header">
 
  <button type="button"  class="close" data-dismiss="modal">X</button>
   <?php
global $database;
// get the campaign code of this campaign-i need it for those paying manually on the bank//
$get_campaign_code=$database->query("SELECT `campaign_code` from `pl_campaigns` 
  WHERE `id`='{$set_campaign_id}'");
$get_campaign_code=$database->fetch_array($get_campaign_code);
$get_campaign_code=$get_campaign_code['campaign_code'];


    ?>                
  <h5 class="modal-title" id="myModalLabel2">Verify your Donation  <i class="fa fa-check-circle text-theme-colored"></i> </h5>
    
</div>
        <div class="modal-body">
          <p>Name of Donor: <strong><?php echo $_POST['donor_name']; ?></strong></p>
          <p>Name of Campaign: <strong><?php echo   $campaign_basics->campaign_tittle; ?></strong></p>
           <p>Amount: <strong><?php echo  format_currency($_POST['donor_amount']); ?></strong></p>
           <p>e-Mail of Donor: <strong><?php if(empty($_POST['donor_email'])){ echo 'projectliveafrica@gmail.com '. ' [default e-Mail]';}else{ echo $_POST['donor_email'];} ?></strong></p><hr>
 
                  </div>
<div class="col-md-12">
                    <div class="form-group mb-20">
                      <?php  // 0 is yes flag for online payment, 1 is yes for manual payment ?>
                     
                      <label class="radio-inline">
                        <input type="radio" checked="" value="o" name="donate_manually"> 
                        Donate now with Paystack.
                      </label>
                      <label class="radio-inline">
                        <input type="radio" value="1" name="donate_manually"> 
                       I want to donate manually in a bank.
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-12" id="manual_payment_choice">
                   
                      <div class="radio mt-5">
                        <label>
                        <h6 class="alert alert-success"><p>
    Account number: Projectlive Africa<p> 
     Account number: 0441163372<p> 
     Bank Name: Guaranty Trust Bank (GTB)<p>
     Transaction ID: <?php echo $get_campaign_code?><p> <p>
   Note: If you are using this option please make sure you include the Transaction ID, so that the money can go directly to the benefitting  campaign. (<b class="text-theme-colored"><?php echo   $campaign_basics->campaign_tittle; ?></b>)</h6>
                        </label>
                     
                    </div>
           <?php


if(isset($_SESSION['SESS_USER_ID'])){$user_id=$_SESSION['SESS_USER_ID'];}
  else{
   $user_id='';
}

      //if user is logged in during donating, capture the ID/
// post variables-assign them to the attributes of the class//
$campaign_donations=new campaignDonationManager();
$campaign_donations->campaign_id=$_POST['campaign_id'];
$campaign_donations ->user_id=$user_id;
$campaign_donations ->identity_of_donor=$_POST['donor_identity'];
$campaign_donations ->donation_amount =$_POST['donor_amount'];
$campaign_donations ->name_of_donor =$database->escape_value($_POST['donor_name']);  
$campaign_donations ->phone_of_donor =$database->escape_value($_POST['donor_phone']);
$campaign_donations ->email_of_donor =$database->escape_value($_POST['donor_email']);
$campaign_donations ->comment_of_donor =$database->escape_value($_POST['donor_comment']);
$campaign_donations ->donation_date =$_POST['donation_date']=date('M j, Y h:i:s A');

// get the category of this campaign-i need it
$get_campaign_category=$database->query("SELECT `campaign_category` from `pl_campaign_basics` 
  WHERE `campaign_id`='{$set_campaign_id}'");
$get_campaign_category=$database->fetch_array($get_campaign_category);
$campaign_donations->campaign_category=$get_campaign_category['campaign_category'];
      // generate a unique transaction ID for each atempt of donation, this is the ID i will use to confirm payment and give value along with the trans ID paystack will return as refrence when payment is successful//
$campaign_donations->payment_id=$_POST['payment_id']; // from hidden field//
$campaign_donations->payment_status=0; // always set comfirmation flag to zero till payment is given value//
$campaign_donations->create();

           ?>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">back</button>
          <button style="float:left" type="button" onclick="payWithPaystack()" class="btn btn-dark btn-theme-colored">Pay now with Paystack</button><ul class="styled-icons icon-dark mt-20">
              <li class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".1s" data-wow-offset="10"><img src="images/visa.jpg" width="61" height="41" alt=""/></li>
           
              <li class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".2s" data-wow-offset="10"><img src="images/verve.jpg" width="61" height="41" alt=""/>
           </li>
              <li class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".4s" data-wow-offset="10"><img src="images/master.jpg" width="61" height="41" alt=""/></a></li>
              
      <li class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".4s" data-wow-offset="10"><img src="images/secure.jpg" width="61" height="41" alt=""/></a></li>
           
            </ul>
        </div>
      </div>

    </div>
  </div>
</form>
<?php } ?>

 <?php 
     // Variables for paystack API
      $name=$_POST['donor_name'];

      if(empty($_POST['donor_email'])){
        $email='projectliveafrica@gmail.com';
      }else{ $email=$_POST['donor_email'];

      }
      $amount=$_POST['donor_amount'] * 100; // convert all amounts to kobo bfor passing to paystack API//
      $campaign_id=$_POST['campaign_id'];
      $payment_id=$_POST['payment_id'];
      ?>

      <script src="https://js.paystack.co/v1/inline.js"></script>  
<script>
// payWithPaystack API//
  function payWithPaystack(){
    var handler = PaystackPop.setup({
      key: 'pk_live_d0bbea7f24c60dcab78440fada77da8b770d07d3',
      email: '<?php echo $email;?>',
      amount: <?php echo $amount;?>,
      ref: 'PL'+Math.floor((Math.random() * 10000000) + 1), // generates a pseudo-unique reference for each transaction
      lastname: '<?php echo $name;?>',
      // label: "Optional string that replaces customer email"
      metadata: {
         custom_fields: [
            {
                display_name: "Campaign Id",
                variable_name: "campaign_id",
                value: <?php echo $campaign_id;?>
            }
         ]
      },
      callback: function(response){
       var payment_id = "<?php echo $payment_id ?>";
       var amount = "<?php echo $amount ?>";
       var name = "<?php echo $name ?>";
       var campaign_id = "<?php echo $campaign_id ?>";
      
window.location="http://projectlive.ng/campaign-donation-page-success.php?name="+name+"&campaign_id="+campaign_id+"&amount="+amount+"&payment_id="+payment_id+"&reference=" + response.reference;
      },
      onClose: function(){
          alert('window closed');
      }
    });
    handler.openIframe();
  }
</script>
 <script type="text/javascript">
  $(document).ready(function(e) {
    var $donation_form = $("#donation_form");

    //toggle donation_type_choice
    var $donation_type_choice = $donation_form.find("#donation_type_choice");
    $donation_type_choice.hide();
    $("input[name='donor_identity']").change(function() {
        if (this.value == '0') {
            $donation_type_choice.show();
        }
        else {
            $donation_type_choice.hide();
        }
    });


  

  });
</script>


 <script type="text/javascript">
  $(document).ready(function(e) {
    var $donation_form = $("#manualPayment");

    //toggle manual payment option
    var $manual_payment_choice = $donation_form.find("#manual_payment_choice");
    $manual_payment_choice.hide();
    $("input[name='donate_manually']").change(function() {
        if (this.value == '1') { // option for manual
            $manual_payment_choice.show();
        }
        else {
            $manual_payment_choice.hide();
        }
    });


  

  });
</script>
               
<script type="text/javascript">
 //display amount for donation in real time
var inputBox = document.getElementById('chatinput');

inputBox.onkeyup = function(){
    document.getElementById('printchatbox').innerHTML = inputBox.value;
}
</script>
          

  <!-- Footer -->
  <?php include('includes/footer.php'); ?>
</body>
</html>