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
     $message='Hello '.$get_user_name.', your payout process for '.$get_tittle.' campaign has been initiated. Below are the details. Please Notify us if your receiving bank or account details has changed';
     $title=''.$get_tittle.'  campaign performance and payout details.';
     $date=date('Y');

    //send SMS Notification//
    $msg="Hello $get_user_name, your payout is in process and will take a maximum of 3 working days. Check your mail for details. Notify us if your receiving bank or account details has changed..";
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

    $payouts=$database->query("SELECT * FROM  `pl_campaign_payouts` WHERE `pl_campaign_payouts`. `campaign_id`='{$campaign_id}'");
    $payouts=$database->fetch_array($payouts);
    
     $data='<title>ProjectLive Africa Payout Mail</title>
<style type="text/css">
body {
  font: 100%/1.4 Verdana, Arial, Helvetica, sans-serif;
  background-color: #42413C;
  margin: 0;
  padding: 0;
  color: #000;
}

ul, ol, dl { 
  padding: 0;
  margin: 0;
}
h1, h2, h3, h4, h5, h6, p {
  margin-top: 0;   /* removing the top margin gets around an issue where margins can escape from their containing div. The remaining bottom margin will hold it away from any elements that follow. */
  padding-right: 15px;
  padding-left: 15px; /* adding the padding to the sides of the elements within the divs, instead of the divs themselves, gets rid of any box model math. A nested div with side padding can also be used as an alternate method. */
}
a img { /* this selector removes the default blue border displayed in some browsers around an image when it is surrounded by a link */
  border: none;
}

  color: #42413C;
  text-decoration: underline; /
}
a:visited {
  color: #6E6C64;
  text-decoration: underline;
}
a:hover, a:active, a:focus { /* this group of selectors will give a keyboard navigator the same hover experience as the person using a mouse. */
  text-decoration: none;
}

/* ~~ this fixed width container surrounds all other elements ~~ */
.container {
  width: 960px;
  background-color: #FFF;
  margin: 0 auto; /* the auto value on the sides, coupled with the width, centers the layout */
}

/* ~~ This is the layout information. ~~ 

1) Padding is only placed on the top and/or bottom of the div. The elements within this div have padding on their sides. This saves you from any "box model math". Keep in mind, if you add any side padding or border to the div itself, it will be added to the width you define to create the *total* width. You may also choose to remove the padding on the element in the div and place a second div within it with no width and the padding necessary for your design.

*/
.content {

  padding: 10px 0;
}

/* ~~ miscellaneous float/clear classes ~~ */
.fltrt {  /* this class can be used to float an element right in your page. The floated element must precede the element it should be next to on the page. */
  float: right;
  margin-left: 8px;
}
.fltlft { /* this class can be used to float an element left in your page. The floated element must precede the element it should be next to on the page. */
  float: left;
  margin-right: 8px;
}
.clearfloat { /* this class can be placed on a <br /> or empty div as the final element following the last floated div (within the #container) if the overflow:hidden on the .container is removed */
  clear:both;
  height:0;
  font-size: 1px;
  line-height: 0px;
}
.container .content table tr td {
  font-family: Georgia, Times New Roman, Times, serif;
}
.container .content h1 {
  font-family: Georgia, Times New Roman, Times, serif;
}
.container .content h1 {
  font-family: Trebuchet MS, Arial, Helvetica, sans-serif;
}
.container .content p {
  font-family: Trebuchet MS, Arial, Helvetica, sans-serif;
}
-->
</style></head>

<body>

<div class="container">
  <div class="content">
    
    <table border="1" width="951">
      <tr style="font-size:12px">
        <td style="background-color:#CCC" width="98"><div align="center"><strong>Tittle </strong></div></td>
        <td style="background-color:#CCC" width="81"><div align="center"><strong>Category</strong></div></td>
        <td style="background-color:#CCC" width="83"><div align="center"><strong> State</strong></div></td>
        <td style="background-color:#CCC" width="148"><div align="center"><strong>Date of creator</strong></div></td>
        <td style="background-color:#CCC" width="102"><div align="center"><strong>Date ended</strong></div></td>
        <td style="background-color:#CCC" width="101"><div align="center"><strong>Target goal </strong></div></td>
        <td style="background-color:#CCC" width="67"><div align="center"><strong>Amount raised</strong></div></td>
        <td style="background-color:#CCC" width="33"><div align="center"><strong>Donation channels</strong></div></td>
        <td style="background-color:#CCC"   width="33"><div align="center"><strong>Fees (platform and/or cards)</strong></div></td>
        <td style="background-color:#CCC"  width="33"><div align="center"><strong>Amount due</strong></div></td>
        <td style="background-color:#CCC"  width="33"><div align="center"><strong>Payout status</strong></div></td>
        <td style="background-color:#CCC"  width="33"><div align="center"><strong>Payout confirm. status</strong></div></td>
        
      </tr>
      <tr style="font-size:12px">
        <td>'. $payouts['campaign_title'].'</td>
  
     
     <td> '.$payouts['category'].'</td> 

     <td> '.$payouts['campaign_state'].'</td>
     <td>'.$payouts['campaign_creation_date'].'</td>
     <td>'.$payouts['campaign_end_date'].'</td>
     <td>'.$payouts['target_goal'].'</td>
      <td>'.$payouts['amount_raised'].'</td>
      <td>Online:'.$payouts['cards']. '</br>'. 'other channels:'. $payouts['others'].'</td>
     
     <td>'.$payouts['platform_fees'].'</td>
     <td>'.$payouts['amount_due'].'</td>
     <td>'.$payouts['payout_status'].'</td>
  <td>'.$payouts['payout_comfirm_status'].'</td>
        
      </tr>
    </table>
   <p align="center">&nbsp;</p> <p align="center">&nbsp;</p> <p align="center">&nbsp;</p>
    <p align="center">Please contact us if your receiving bank or account has changed.</p>
    <p align="center">&nbsp;</p>
    <!-- end .content --></div>
</div>';
  
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
                                                      <tr>
                                                            <td style="font:14px/19px Arial, Helvetica, sans-serif; color:#333332;">'.$data.'</td>
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

                // Send email
                if(!mail($to,$subject,$htmlContent,$headers)){
                  $session->message("An e-Mail and SMS noitfications for payout  not be sent");
                  redirect_to('ended-campaigns');
                  exit();
                }else{
                 $session->message("An e-Mail and SMS noitfications for campaign payout have been sent to the creator of $get_tittle campaign");
                redirect_to('ended-campaigns');
                exit();
                }
   ?>