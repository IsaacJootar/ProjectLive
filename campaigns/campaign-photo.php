<?php require_once('includes/header-login.php'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/campaign-photos.php'); ?>
<?php
// Access the $_FILES global variable for this specific file being uploaded
// and create local PHP variables from the $_FILES array of information
$error_array=array();
$error_flag=false;
$campaign_id=$_POST['campaign_id'];

// check campaign status to determine if to allow further 
            //update//
            $check_status=$database->query("SELECT `campaign_id` FROM `pl_campaign_review`
                                   WHERE `campaign_id`='{$_POST['campaign_id']}'");

    
            if($check_status){
                if($database->num_rows($check_status) >=1){
                    $error_array[]='This campaign is already under review, you cannot make anymore changes! The review should take a maximum of 72 hours at most, please monitor your mail or phone for review notifications.  ';
                $error_flag=true;
                }
            }

            $check_status2=$database->query("SELECT `campaign_id` FROM `pl_ended_campaigns`
                                   WHERE `campaign_id`='{$_POST['campaign_id']}'");

    
            if($check_status2){
                if($database->num_rows($check_status2) >=1){
                    $error_array[]='This campaign due date has already expired, you cannot make anymore changes! You can only create a new project if you wish.  ';
                $error_flag=true;
                }
            }



            // check, if campaign is in live tables, refuse edition//

            $check_status3=$database->query("SELECT `campaign_id` FROM `pl_live_campaigns`
                                   WHERE `campaign_id`='{$_POST['campaign_id']}'");

    
            if($check_status3){
                if($database->num_rows($check_status3) >=1){
                    $error_array[]='This campaign is ongoing and you cannot make anymore changes!.  ';
                $error_flag=true;
                }
            }



$location="campaign-photos";
$campaign_tittle=$_POST['campaign_tittle'];
$fileName = $_FILES["uploaded_file"]["name"]; // The file name
$fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["uploaded_file"]["type"]; // The type of file it is
$fileSize = $_FILES["uploaded_file"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["uploaded_file"]["error"]; // 0 for false... and 1 for true
$kaboom = explode(".", $fileName); // Split file name into an array using the dot
$fileExt = end($kaboom); // Now target the last array element to get the file extension
// START PHP Image Upload Error Handling --------------------------------------------------
if (!$fileTmpLoc) { // if file not chosen
    $error_array[]='ERROR: Please browse for a campaign photo before clicking the upload button.';
        $error_flag=true;
} else if($fileSize > 15728640) { // if file size is larger than 15 Megabytes
        $error_array[]='ERROR: Your campaign photo was larger than 15 Megabytes in size.';
        $error_flag=true;
    unlink($fileTmpLoc);
} else if (!preg_match("/.(gif|jpg|png)$/i", $fileName) ) { 
        $error_array[]='ERROR: Your campaign photo was not .gif, .jpg, or .png.';
        $error_flag=true; 
     unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
} else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1\
        $error_array[]='ERROR: An error occured while processing your campaign photo. Please Try again.';
        $error_flag=true; 
       
}

// errors are found store the errors in a seesion//
            if ($error_flag){   
            $_SESSION['sess_errors']=$error_array;
             $_SESSION['campaign_id']=$_POST['campaign_id'];
            $_SESSION['active_tab']=2;
            session_write_close();
            redirect_to('create');
            exit();
            }
// END PHP Image Upload Error Handling ---------------------------------
$moveResult = move_uploaded_file($fileTmpLoc, "$location/$fileName");
// Check to make sure the move result is true before continuing
if ($moveResult != true) {
    echo "ERROR: File not uploaded. Try again.";
    unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
    exit();
}
unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
$target_file = "$location/$fileName";
$resized_file = "$location/resized_$fileName";
$wmax = 600;
$hmax = 460;
//resize_campaign_photo($target_file, $resized_file, $wmax, $hmax, $fileExt);
$target_file = "$location/resized_$fileName";
$thumbnail = "$location/thumb_$fileName";
$wthumb = 170;
$hthumb = 170;
//resize_campaign_photo_thumb($target_file, $thumbnail, $wthumb, $hthumb, $fileExt);

// for now ProjectLive will allow just a single campaign image, so first check and remove others before uploading the latest for usage//

$get_previous_image=$database->query("SELECT  `photo_name` FROM `pl_campaign_photos`
                        WHERE `campaign_id`='{$campaign_id}' AND `user_id` = '{$user_id}'");
$get_previous_image=$database->fetch_array($get_previous_image);

//if (array_key_exists('delete_file', $_POST)) {
 // if (file_exists($previous_image)) {
    unlink("campaign-photos/".$get_previous_image['photo_name']);
    //echo 'File '.$filename.' has been removed as campaign phoho';
  //} else {
   // echo 'Could not delete '.$filename.', file does not exist';
  //}
//}
 
 
$moveResult = move_uploaded_file($fileTmpLoc, "$location/$fileName");

    //query//

$update_photo=$database->query("UPDATE `pl_campaign_photos`
                         SET `campaign_id`= '{$campaign_id}',
                        `photo_name`='{$fileName}',
                        `photo_ext`='{$fileExt}',
                        `photo_size`='{$fileSize}'
                        WHERE `campaign_id`='{$campaign_id}' AND `user_id` = '{$user_id}'");



    if ($update_photo){
                //$_SESSION['foto_name']= $fileName;
                $session->message("Campaign Photo Has been successfully uploaded");
                $_SESSION['campaign_id']=$campaign_id;
                $_SESSION['active_tab']=2;//
                redirect_to('create');
                exit();
    }
    else{
            $session->message("Campaign Photo Uplaod failed, Please try again later");
            $_SESSION['campaign_id']=$campaign_id;
                $_SESSION['active_tab']=2;//
            redirect_to('create');
            exit();
            }
        
        ?>


        

?>


