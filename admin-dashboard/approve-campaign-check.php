<?php include ('includes/header.php');?>
<?php require_once('../campaigns/classes/database.php'); ?>
<?php require_once('../campaigns/classes/database-object.php'); ?>
<?php require_once('../classes/functions.php'); ?>
<?php require_once('classes/smsAPI.php'); ?>
<?php require_once('classes/sendmail.php'); ?>
<?php //initialize error array and flag//
            $error_array=array();
            $error_flag=false;

if(isset($_SESSION['campaign_id'])){
         $campaign_id=$_SESSION['campaign_id'];
 }

//global $database;
 if(isset($_GET['flag'])){
      $flag=$_GET['flag'];
         // if flag is 1 means campaigns is approved for going live//
    if($flag==1){
        // check first to see if a declined campaign is trying to be approved// 
        $check_verify_status=$database->query("SELECT * FROM `pl_declined_campaigns` WHERE `campaign_id`='{$campaign_id}'");
            $check_verify_status=$database->num_rows($check_verify_status); 

            if($check_verify_status >=1){
                $error_array[]='This campaign has already been declined, and cant be approved at this moment!';
                $error_flag=true;
            }
                $check_live_status=$database->query("SELECT * FROM `pl_live_campaigns` WHERE `campaign_id`='{$campaign_id}'");
                $check_live_status=$database->num_rows($check_live_status); 

                    if($check_live_status >=1){
                       $error_array[]='This campaign has already been approved!';
                       $error_flag=true;
                    }
                        if ($error_flag){   
                            $_SESSION['sess_errors']=$error_array;
                            session_write_close();
                            redirect_to('approve-campaigns_');
                            exit();
                        }
        // remove campaign from review tables and insert in live able//

        $remove_campaign="DELETE  FROM  `pl_campaign_review` 
                                   WHERE `campaign_id`='{$campaign_id}'";
        if(!$remove_campaign=$database->query($remove_campaign)){
            echo 'Campaign could not be removed from review';
            exit();
        }
        $approved_date=date('M j, Y h:i:s A');
        $update_live_campaign="INSERT INTO `pl_live_campaigns`(`campaign_id`, `approved_date`) VALUES ('{$campaign_id}', '{$approved_date}')";

//update the campaign status if no errors occur//
   

        

        if($update_live_campaign=$database->query($update_live_campaign)){
                // update the due date for this campaign now, we shud start counting when approved and not when the campaign was submited for review-so first get the duration of this campaign convert to due date and update back the table //
                $get_campaign_duration=$database->query("SELECT `campaign_duration`, `campaign_id` FROM `pl_campaign_basics` WHERE `campaign_id`= '{$campaign_id}'");
                $get_campaign_duration=$database->fetch_array($get_campaign_duration);
                $duedate=(60*60*24 * $get_campaign_duration['campaign_duration'] );
                $campaign_duration=$duedate+time(); // add to current time, all in seconds, i need it that way//
                $update_campaign_due_date="UPDATE `pl_campaign_basics` 
                                           SET  `campaign_due_date`='{$campaign_duration}'
                                           WHERE `campaign_id`='{$campaign_id}'";

                

                if($update_campaign_due_date=$database->query($update_campaign_due_date)){
                    // update campaign state//
                $campaign_state='live'; // i hate doing this//

                // get infor for sending mail and notifications-i will put al notifications handling in a fuction later this month, am feeling lazy right now//
                $query=$database->query("UPDATE `pl_campaign_basics` SET `campaign_state`= '{$campaign_state}' WHERE `campaign_id`='{$campaign_id}'");

                $get_user=$database->query("SELECT `user_id` FROM `pl_campaigns` WHERE `id`='{$campaign_id}'");
                $get_user=$database->fetch_array($get_user);
                $get_user=$get_user['user_id'];
                $get_user_info=$database->query("SELECT * FROM `pl_users` WHERE `id`='{$get_user}'");
                $get_user_info=$database->fetch_array($get_user_info);  
                $get_user_name=$get_user_info['first_name'];

                //send SMS Notification//
                $msg="Hello $get_user_name, your campaign on ProjectLive has been approved. An Email has also been sent to you. Goodluck on your campaign";
                $number=$get_user_info['phone'];
                $username = 'projectlive'; //your login username
                $password = '001100110011..,,..,,'; //your login password
                $sender='Projectlive';
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
                $subject = "Projectlive Campaign Update";
                // Get HTML contents from file
                $htmlContent = file_get_contents("template.html");

                // Set content-type for sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // Additional headers
                $headers .= 'From: Projectlive Africa<support@projectlive.ng>' . "\r\n";
                $headers .= 'Cc: noreply@projectlive.ng ' . "\r\n";

                // Send email
                mail($to,$subject,$htmlContent,$headers);
                

                $session->message("This campaign is now approved, and live on ProjectLive");
                    redirect_to('approve-campaigns_');
                    exit();
        
                }
                
                else{
                $session->message("an error occured, campaign  could not be approved, please try again");
                redirect_to('approve-campaigns_');
                exit();
                }
        }
      
    } // endif of flag being 1

    // 0 flag being campaign is declined//
    if($flag==0){
    $date_declined=time();
    // check to see if an approved campaign is been declined//
    $check_verify_status=$database->query("SELECT * FROM `pl_live_campaigns` WHERE `campaign_id`='{$campaign_id}'");
            if($check_verify_status=$database->num_rows($check_verify_status) >=1){
                $error_array[]='This campaign has already been approved, and cannot be declined at this moment';
                $error_flag=true;
            } 
    $check_decline_status=$database->query("SELECT * FROM `pl_declined_campaigns` WHERE `campaign_id`='{$campaign_id}'");
            if($check_decline_status=$database->num_rows($check_decline_status) >=1){
                $error_array[]='This campaign has already been declined';
                $error_flag=true;
            }
                if ($error_flag){   
                    $_SESSION['sess_errors']=$error_array;
                    session_write_close();
                    redirect_to('approve-campaigns_');
                    exit();
                }




                 // remove campaign from review tables and insert in live able//

        $remove_campaign="DELETE  FROM  `pl_campaign_review` 
                                   WHERE `campaign_id`='{$campaign_id}'";
        if(!$remove_campaign=$database->query($remove_campaign)){
            echo 'campaign could not be removed from review';
            exit();
        }
    $update_declined_campaigns="INSERT INTO `pl_declined_campaigns`(`campaign_id`, `date_declined`) VALUES ('{$campaign_id}', '{$date_declined}')";


//update the campaign status if no errors occur//
    if($update_declined_campaigns=$database->query($update_declined_campaigns)){
        // update campaign state//
                $campaign_state='declined'; // i hate doing this//
                $query=$database->query("UPDATE `pl_campaign_basics` SET `campaign_state`= '{$campaign_state}' WHERE `campaign_id`='{$campaign_id}'");

    // send a decline mail to the creator here, both mail and phone notification//
                $get_user=$database->query("SELECT `user_id` FROM `pl_campaigns` WHERE `id`='{$campaign_id}'");
                $get_user=$database->fetch_array($get_user);
                $get_user=$get_user['user_id'];
                $get_user_info=$database->query("SELECT * FROM `pl_users` WHERE `id`='{$get_user}'");
                $get_user_info=$database->fetch_array($get_user_info);  
                $get_user_name=$get_user_info['first_name'];
                 //send SMS Notification//
                $msg="Hello $get_user_name, your campaign on ProjectLive has been declined. An Email has also been sent to you. You can make changes and submit again.";
                $number=$get_user_info['phone'];
                $username = 'projectlive'; //your login username
                $password = '001100110011..,,..,,'; //your login password
                $sender='Projectlive';
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
                $subject = "Projectlive Campaign Update";
                // Get HTML contents from file
                $htmlContent = file_get_contents("template_.html");

                // Set content-type for sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // Additional headers
                $headers .= 'From: Projectlive Africa<support@projectlive.ng>' . "\r\n";
                $headers .= 'Cc: noreply@projectlive.ng ' . "\r\n";

                // Send email
                mail($to,$subject,$htmlContent,$headers);

       $session->message("This campaign has been declined, and will not be going live on ProjectLive");
            redirect_to('approve-campaigns_');
            exit();
    }

 }
}// end isset
 else{
    print 'An error occured, please try the vetting process again';
 }
 
?>