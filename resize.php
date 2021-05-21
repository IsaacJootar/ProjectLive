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
$location="campaign-photos";
$campaign_id=$_POST['campaign_id'];
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
    $error_array[]='ERROR: Please browse for a camapign photo before clicking the upload button.';
        $error_flag=true;
} else if($fileSize > 5242880) { // if file size is larger than 5 Megabytes
        $error_array[]='ERROR: Your campaign photo was larger than 5 Megabytes in size.';
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
            session_write_close();
            redirect_to('create');
            exit();
            }
// END PHP Image Upload Error Handling ---------------------------------
// Place it into your "uploads" folder mow using the move_uploaded_file() function
$moveResult = move_uploaded_file($fileTmpLoc, "uploads/$fileName");
// Check to make sure the move result is true before continuing
if ($moveResult != true) {
    echo "ERROR: File not uploaded. Try again.";
    unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
    exit();
}
unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
// ---------- Include Adams Universal Image Resizing Function --------
$target_file = "uploads/$fileName";
$resized_file = "uploads/resized_$fileName";
$wmax = 250;
$hmax = 250;
resize_campaign_photo($target_file, $resized_file, $wmax, $hmax, $fileExt);
// ----------- End Adams Universal Image Resizing Function ----------
// ------ Start Adams Universal Image Thumbnail(Crop) Function ------
$target_file = "uploads/resized_$fileName";
$thumbnail = "uploads/thumb_$fileName";
$wthumb = 120;
$hthumb = 120;
resize_campaign_photo_thumb($target_file, $thumbnail, $wthumb, $hthumb, $fileExt);

//End campaign photo Upload Error Handling, but please come back later and resize these photos as thumbnail images. 
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


