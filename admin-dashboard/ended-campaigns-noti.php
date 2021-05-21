<?php include ('includes/header.php');?>
<?php require_once('../campaigns/classes/database.php'); ?>
<?php require_once('../campaigns/classes/database-object.php'); ?>
<?php require_once('../classes/functions.php'); ?>
<?php require_once('../campaigns/classes/campaign-basics.php'); ?>
<?php require_once('../campaigns/classes/campaigns.php'); ?>
<?php require_once('classes/smsAPI.php'); ?>
<?php require_once('classes/sendmail.php'); ?>
<?php //initialize error array and flag//
            $error_array=array();
            $error_flag=false;

    // update projectlive database and comfirm payment//
 
    global $database;
     $campaign_id=$_GET['ref'];// from get request//
    $get_data=$database->query("SELECT * FROM `pl_campaign_basics` WHERE `campaign_id`='{$campaign_id}'");
    if(!$get_data){
        echo 'ERROR_COULD_ NOT_VERIFY_CAMPAIGN_ID';
        exit();
    }
    $get_user=$database->query("SELECT `user_id` FROM `pl_campaigns` WHERE `id`='{$campaign_id}'");
    if(!$get_user){

        echo "ERROR_COULD_NOT_FIND_CREATORS_ID";
    }
    
    $get_user=$database->fetch_array($get_user);
    $get_user=$get_user['user_id'];
    $get_user_info=$database->query("SELECT * FROM `pl_users` WHERE `id`='{$get_user}'");
    if(!$get_user_info){
        echo 'ERROR_COULD_NOT_FIND_CAMPAIGN_CREATORS';
    }
    //start getting data for sending creator email//
    $get_tittle=$database->query("SELECT `campaign_tittle` FROM `pl_campaign_basics` WHERE `campaign_id`='{$campaign_id}'");
    $get_tittle=$database->fetch_array($get_tittle);
    $get_tittle=$get_tittle['campaign_tittle'];
    $get_user_info=$database->fetch_array($get_user_info);  
    $get_user_name=$get_user_info['first_name'];
    
     $subject = ''.$get_tittle.' campaign update ';
     $message='Hello '.$get_user_name.', your '.$get_tittle.' campaign on ProjectLive is now ended. Your payout process for any generated funds will be initiated immediately. A mail will be sent to you on the details of your campaign and the payout process. Cheers. ';
     $title='Hello '.$get_user_name.', your '.$get_tittle.'  campaign has ended.';
     $date=date('Y');

    //send SMS Notification//
    $msg="Hello $get_user_name, your current campaign on ProjectLive has ended. A mail has been sent to you for more details. Please Check your inbox and also your spam folder to be sure you received it. Cheers";
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
  // send email//
    /// generate Email and send to user
    $campaign_tittle=$database->query("SELECT `campaign_tittle` FROM `pl_campaign_basics` WHERE `campaign_id`= '{$campaign_id}'");
    $campaign_tittle=$database->fetch_array($campaign_tittle);
    $campaign_tittle=$campaign_tittle['campaign_tittle'];
    $get_user=$database->query("SELECT `user_id` FROM `pl_campaigns` WHERE `id`='{$campaign_id}'");
    // get creator email//
    $get_user=$database->fetch_array($get_user);
    $get_user=$get_user['user_id'];
    $get_user_email=$database->query("SELECT * FROM `pl_users` WHERE `id`='{$get_user}'");
    $get_user_email=$database->fetch_array($get_user_email);  
    $email=$get_user_email['user_name'];// username is email//
    $to = $email;
    // send email//
     
    // Get HTML contents from file
    $htmlContent= '<html xmlns="http://www.w3.org/1999/xhtml">
                            
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,600" rel="stylesheet" type="text/css">
    <head>
    <!--[if gte mso 12]>
    > <style type="text/css">
    > [a.btn {
            padding:15px 22px !important;
            display:inline-block !important;
    }]
    > </style>
    > <![endif]-->
    <title>kreative</title>
    <style type="text/css">
    div, p, a, li, td {
            -webkit-text-size-adjust:none;
    }
    .ReadMsgBody {
            width: 100%;
            background-color: #d1d1d1;
    }
    .ExternalClass {
            width: 100%;
            background-color: #d1d1d1;
            line-height:100%;
    }
    body {
            width: 100%;
            height: 100%;
            background-color: #d1d1d1;
            margin:0;
            padding:0;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust:100%;
    }
    html {
            width: 100%;
    }
    img {
            -ms-interpolation-mode:bicubic;
    }
    table[class=full] {
            padding:0 !important;
            border:none !important;
    }
    table td img[class=imgresponsive] {
            width:100% !important;
            height:auto !important;
            display:block !important;
    }
    @media only screen and (max-width: 800px) {
    body {
     width:auto!important;
    }
    table[class=full] {
     width:100%!important;
    }
    table[class=devicewidth] {
     width:100% !important;
     padding-left:20px !important;
     padding-right: 20px!important;
    }
    table td img.responsiveimg {
     width:100% !important;
     height:auto !important;
     display:block !important;
    }
    }
    @media only screen and (max-width: 640px) {
    table[class=devicewidth] {
     width:100% !important;
    }
    table[class=inner] {
     width:100%!important;
     text-align: center!important;
     clear: both;
    }
    table td a[class=top-button] {
     width:160px !important;
      font-size:14px !important;
     line-height:37px !important;
    }
    table td[class=readmore-button] {
     text-align:center !important;
    }
    table td[class=readmore-button] a {
     float:none !important;
     display:inline-block !important;
    }
    .hide {
     display:none !important;
    }
    table td[class=smallfont] {
     border:none !important;
     font-size:26px !important;
    }
    table td[class=sidespace] {
     width:10px !important;
    }
    }
     @media only screen and (max-width: 520px) {
    }
    @media only screen and (max-width: 480px) {

     table {
     border-collapse: collapse;
    }
    table td[class=template-img] img {
     width:100% !important;
     display:block !important;
    }
    }
    @media only screen and (max-width: 320px) {
    }
    </style>
    </head>

    <body>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="full">

      <tr>
            <td align="center"><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="devicewidth">
                    <tr>
                      <td><table width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" align="center" class="full" style="border-radius:5px 5px 0 0; background-color:#ffffff;">
                              <tr>
                                    <td height="29">&nbsp;</td>
                              </tr>
                             
                              <tr>
                                    <td style="border-bottom:1px solid #dbdbdb;">&nbsp;</td>
                              </tr>
                            </table></td>
                    </tr>
              </table></td>
      </tr>
    </table>


    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="full">
      <tr>
            <td align="center"><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="devicewidth">
                    <tr>
                      <td><table width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" align="center" class="full" style="background-color:#ffffff;">
                              <tr>
                                    <td height="23">&nbsp;</td>
                              </tr>
                              <tr>
                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                            <tr>
                                              <td width="23" class="sidespace">&nbsp;</td>
                                              <td><table width="76%" border="0" cellspacing="0" cellpadding="0" align="left" class="inner" id="banner" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                                                      <tr>
                                                            <td style="font:bold 18px Arial, Helvetica, sans-serif; border-right:1px solid #dbdbdb;" class="smallfont">'.$title.'</td>
                                                      </tr>
                                                      <tr>
                                                            <td height="20">&nbsp;</td>
                                                      </tr>
                                                    </table>
                                                    </td>
                                              <td width="23" class="sidespace">&nbsp;</td>
                                            </tr>
                                      </table>
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                            <tr>
                                              <td width="3.33%" class="sidespace">&nbsp;</td>
                                              <td width="93.33%"><img class="imgresponsive" src="https://projectlive.ng/images/projectlive_africaa.png" width="554" height="atuo" alt="Banner" /></td>
                                              <td width="3.33%" class="sidespace">&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td height="20">&nbsp;</td>
                                              <td height="20">&nbsp;</td>
                                              <td height="20">&nbsp;</td>
                                            </tr>
                                      </table>
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                            <tr>
                                              <td width="23" class="sidespace">&nbsp;</td>
                                              <td>
                                             
                                                    
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="right" class="inner">
                                                      <tr>
                                                            <td style="font:14px/19px Arial, Helvetica, sans-serif; color:#333332;">'.$message.'</td>
                                                      </tr>
                                                      <tr>
                                                            <td height="20">&nbsp;</td>
                                                      </tr>
                                                     
                                                    
                                                    </table></td>
                                              <td width="23" class="sidespace">&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td height="16">&nbsp;</td>
                                              <td height="16">&nbsp;</td>
                                              <td height="16">&nbsp;</td>
                                            </tr>
                                      </table></td>
                              </tr>
                              <tr>
                                    <td style="border-bottom:1px solid #dbdbdb;">&nbsp;</td>
                              </tr>
                            </table></td>
                    </tr>
              </table></td>
      </tr>
    </table>

     
     
     
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full">
      <tr>
            <td align="center"><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="devicewidth">
                    <tr>
                      <td><table width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" align="center" class="full" style="border-radius:0 0 7px 7px;">
                              <tr>
                                    <td height="18">&nbsp;</td>
                              </tr>
                              <tr>
                                    <td><table class="inner" align="right" width="340" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; text-align:center;">
                                            
                                      </table>
                                      
                                      <table class="inner" align="center" width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; text-align:center;">
                                            <tr>
                                              <td width="21">&nbsp;</td>
                                              <td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                                      <tr>
                                                            <td align="center" style="font:11px Helvetica,  Arial, sans-serif; color:#000000;">&copy; '.$date.'<br/> ProjectLive Africa. </td>
                                                      </tr>
                                                      <tr>
                                                            <td height="18">&nbsp;</td>
                                                      </tr>
                                                    </table></td>
                                                    
                                              <td width="21">&nbsp;</td>
                                            </tr>
                                      </table></td>
                              </tr>
                            </table></td>
                    </tr>
              </table></td>
      </tr>
    </table>
    </body>
    </html>';

                // Set content-type for sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // Additional headers
                $headers .= 'From: Projectlive Africa<support@projectlive.ng>' . "\r\n";
                $headers .= 'Cc: noreply@projectlive.ng ' . "\r\n";


                 // update payout tables//

                $get_data2=$database->query("SELECT * FROM `pl_campaign_basics` WHERE `campaign_id`='{$campaign_id}'");
                if(!$get_data2){
                  echo 'ERROR_COULD_NOT_GET_PAYOUT_INFORMATIONS';
                  exit();
                }
                $get_data2=$database->fetch_array($get_data2);
                $campaign_tittle=$get_data2['campaign_tittle'];
                $creation_date=$get_data2['campaign_creation_date'];
                $campaign_category=$get_data2['campaign_category'];
                $campaign_state='Ended';
                // get amount raise//
                if(!$query=$database->query("SELECT * FROM `pl_ended_campaigns` WHERE `campaign_id`='{$campaign_id}'")){
                echo 'ERROR_GETTING_PAYOUT_DATA';
                  exit();
                }
                $donations=$database->fetch_array(($query));
                 $amount_raised=$donations['amount_raised'];
                 $target_goal=$donations['target_goal'];
                 $campaign_end_date=$donations['date_ended'];
                 $payout_status='initiated';
                $payout_comfirm_status='in process';
                
                /*calculate pltaforom fees, processing fees and amount due for creators//
                messy calculations for now, but its correct thou. Improve later//
                ~algorithms ~
                (1)get all donations from debit/credit card that are bellow 2500-paystack waiver limit, then apply the fees for projectlive & paystack, then put store it.
                (2)get all donations from debit/credit card that are above 2500-paystack waiver is ignore here and an additional  N100 is added as paystack fees, then apply the fees for projectlive, then put store it also//
                (3)get all other donations from other payment channels and apply only projectlive platform fees and store also.
                (4)Finally, add the fees and substract from total donations-this shud work, will work.

                */
                 $below=$database->query("SELECT SUM(donation_amount) 
                  AS `donation_amount` 
                  FROM `pl_campaign_donations` 
                  WHERE `campaign_id`='{$campaign_id}'
                  AND `payment_status`=1 
                  AND `reference_code` !='' 
                  AND `payment_id` !='' 
                  AND `payment_channel`= 1 
                  AND `donation_amount` < 2500");
                if(!$below){
                  echo 'ERROR_COULD_NOT_GET_PAYOUT_DONATIONS';
                  exit();
                }
                $below=$database->fetch_array($below); 
                $below=$below['donation_amount'];
             
                $below1=$below* 1.5/100; // for_paystack 1.5% + 100//
                
                $below2=$below* 5/100; //for_projectlive 5 %//
               
                 $below_sum=$below1+$below2;
                // for above cap of 2500//
               $above=$database->query("SELECT SUM(donation_amount) 
                AS `donation_amount` 
                FROM `pl_campaign_donations` 
                WHERE `campaign_id`='{$campaign_id}' 
                AND `payment_status`=1 
                AND `reference_code` !='' 
                AND `payment_id` !='' 
                AND `payment_channel`= 1 
                AND `donation_amount` >= 2500");
                if(!$above){
                echo 'ERROR_COULD_NOT_GET_PAYOUT_DONATIONS_2';
                exit();
                }
                   
                $above=$database->fetch_array($above);

                $above=$above['donation_amount'];
                if($above==0){
                  $above1=$above* 1.5/100; // dont add the 100 again bcus the payment channel for online wasnt used//
                }else{
                  $above1=$above* 1.5/100+100; // for_paystack 1.5% + 100//}
                  } 
                
                $above2=$above* 5/100; //for_projectlive 5 %//
                $above_sum=$above1+$above2;

                // for donation channels other than cards-thats bank traansfer, mobile banking, bank deposit, etc//

                $other=$database->query("SELECT SUM(donation_amount) 
                AS `donation_amount` 
                FROM `pl_campaign_donations` 
                WHERE `campaign_id`='{$campaign_id}' 
                AND `payment_status`=1 
                AND `reference_code` !='' 
                AND `payment_id` !='' 
                AND `payment_channel`= 0");
                if(!$other){
                echo 'ERROR_COULD_NOT_GET_PAYOUT_DONATIONS_3';
                exit();
                }
                $other=$database->fetch_array($other); 
                $other=$other['donation_amount'];
                $other= $other*5/100; //for_projectlive 5 %//
                // add all the fees for the 3 possible categories and deduct from creators total funds raised//
                $platform_fees=$above_sum+$below_sum+$other;

                $amount_due=$amount_raised-$platform_fees;
                // get number of donation channels//

                $count_cards=$database->query("SELECT `id`
                 FROM  `pl_campaign_donations` 
                 WHERE `campaign_id`='{$campaign_id}' 
                 AND `payment_status`=1 
                 AND `reference_code` !='' 
                 AND `payment_id` !=''  
                 AND `payment_channel`= 1");
                $count_cards=$database->num_rows(($count_cards));// paymets carried out with cards online//
  

                $count_others=$database->query("SELECT `id`
                 FROM  `pl_campaign_donations` 
                 WHERE `campaign_id`='{$campaign_id}' 
                 AND `payment_status`=1 
                 AND `reference_code` !='' 
                 AND `payment_id` !=''  
                 AND `payment_channel`= 0");
                $count_others=$database->num_rows(($count_others));// paymets carried out with other channels//
  
  
                // flag for making sure notifications are sent only once
                $flag=1;
                $check_query="INSERT INTO `pl_campaign_payouts` (`campaign_id`, `user_id`, `category`, `campaign_title`, `campaign_state`, `campaign_creation_date`, `campaign_end_date`, `amount_raised`, `target_goal`, `payout_status`, `payout_comfirm_status`, `platform_fees`, `amount_due`, `cards`, `others`, `flag` ) VALUES ('{$campaign_id}', '{$get_user}', '{$campaign_category}', '{$campaign_tittle}', '{$campaign_state}', '{$creation_date}', '{$campaign_end_date}', '{$amount_raised}', '{$target_goal}', '{$payout_status}', '{$payout_comfirm_status}', '{$platform_fees}', '{$amount_due}','{$count_cards}', '{$count_others}', '{$flag}')";
                if(!$check_query=$database->query($check_query)){
                  echo 'ERROR_UPDATING_PAYOUTS';
                  exit();
                }

                // Send email
                if(!mail($to,$subject,$htmlContent,$headers)){
                  $session->message("An e-Mail and SMS noitfications could not be sent");
                  redirect_to('ended-campaigns');
                  exit();
                }else{


                $session->message("An e-Mail and SMS noitfications for campaign ended have been sent to the creator of $get_tittle campaign");
                redirect_to('ended-campaigns');
                exit();
                }
   ?>