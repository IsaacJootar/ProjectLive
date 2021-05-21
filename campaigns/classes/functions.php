<?php error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_WARNING & ~E_DEPRECATED); ?>
<?php function redirect_to( $location = NULL ){if ($location != NULL) {
	 header("Location: {$location}");
    exit;
  }
}
function output_message($message="") {
  if (!empty($message)) { 
    return "{$message}</p>";
	
  } else {
    return "";
  }
}

function crypt_decrpt_url( $string, $type = 'e' ) {
    $secret_key = 'Jesus is Lord!'; // foreva and eva//
    $secret_iv = 'my_simple_secret_iv';
 
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $pass = substr( hash( 'sha256', $secret_iv ), 0, 16 );
 
    if( $type == 'e' ) {
        $url = base64_encode(openssl_encrypt( $string, $encrypt_method, $key, 0, $pass ) );
    }
    else if( $type == 'd' ){
        $url = openssl_decrypt(base64_decode( $string ), $encrypt_method, $key, 0, $pass );
    }
 
    return $url;
}

   function format_currency($val,$symbol='₦',$r=0){


    $n = $val; 
    $c = is_float($n) ? 1 : number_format($n,$r);
    $d = '.';
    $t = ',';
    $sign = ($n < 0) ? '-' : '';
    $i = $n=number_format(abs($n),$r); 
    $j = (($j = strlen($i)) > 3) ? $j % 2 : 0; 

   return  $symbol.$sign .($j ? substr($i,0, $j) + $t : '').preg_replace('/(\d{3})(?=\d)/',"$1" + $t,substr($i,$j)) ;

}


function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

  function get_date_time($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}// end time ago

// get campaign due date//     
    function get_campaign_due_date_by_campaign_id($campaign_id){
global $database;
      $query=$database->query("SELECT `campaign_due_date` FROM `pl_campaign_basics` WHERE `campaign_id`='{$campaign_id}'");
            $campaign_due_date=$database->fetch_array(($query));
            $campaign_due_date=$campaign_due_date['campaign_due_date'];
    //$now = time(); // get present time//
   return  $campaign_due_date-time(); // subtract the due date from the present time//
}



function due_date_in_days($seconds, $campaign_id)
{
    $ret = "";

    /*** factor out the day(s) ***/
    $days = intval(intval($seconds) / (3600*24));
    if($days > 1 ){
        $ret .= "$days days left";
    }
    if($days == 1){
        $ret .= "$days day left";
    }
  /*** factor out the hour(s) ***/
    if($days < 1){
      $days = intval(intval($seconds) / (3600));
      if($days > 1 ){
        $ret .= "$days hours left";
      }
      if($days == 1 ){
          $ret .= "$days hour left";
        }
      
    } // endif for hour(s)

    /*** factor out the min(s) ***/
    if($days < 1){
      $days = intval(intval($seconds) / (60));
      if($days > 1 ){
        $ret .= "$days minutes left";
      }
        if($days == 1 ){
          $ret .= "$days minute left";
        }
    }//endif for min(s)
   
    /*** factor out the seconds(s) ***/
    if($days < 1){
      $days = intval(intval($seconds));
      if($days > 1 ){
        $ret .= "$days seconds left";
      }
        if($days == 1 ){
          $ret .= "$days second left";
        }
        // this is when campaigns ends//
         if($days <=0 ){
          // immediately the campaign set time ends, update the end of campaign status, an dhalt every othet opertions about such campaign//
          global $database;
          $date_ended=date('M j, Y, g:i a'); // i may change this date format later-feeling lazy now//

          // check to be sure campaigns are ended just once//
          $check_status=$database->query("SELECT `campaign_id` 
            FROM `pl_ended_campaigns` 
            WHERE `campaign_id`= '{$campaign_id}' ");
          // end only if campaign is not already ended, only then will u waste processing power doing the rest of the operation//
          if($check_status=$database->num_rows($check_status) < 1){
            // Get all the details u need to store in the campaign eneded table-got started, ended, target goal,amount raised, success status etc// 
           
            // get ended date and goal//
            $query=$database->query("SELECT `amount` FROM `pl_campaign_goal` WHERE `campaign_id`='{$campaign_id}'");
            $target_goal=$database->fetch_array(($query));
            $target_goal=$target_goal['amount'];
            $date_ended=$date_ended;
            // get amount raised//
            if($query=$database->query("SELECT SUM(donation_amount) AS `donation_amount`
             FROM `pl_campaign_donations` WHERE `campaign_id`='{$campaign_id}' AND `payment_status`=1"))
            $donations=$database->fetch_array(($query));
            $amount_raised=$donations['donation_amount'];

            // get success status-sucessful is wen a campaign raises atlease 35% of the tartget goal-calculate//
            //(35/100)= 0.35
            $thirtyfive_percent=$target_goal*0.35;
            if($amount_raised >=$thirtyfive_percent){
              $campaign_success_status=1;
            }
            if($amount_raised < $thirtyfive_percent){
              $campaign_success_status=0;
            }
              $query=$database->query("INSERT INTO `pl_ended_campaigns`(`campaign_id`, `date_ended`, `amount_raised`, `target_goal`, `success_status`) VALUES ('{$campaign_id}','{$date_ended}', 
              '{$amount_raised}', '{$target_goal}', '{$campaign_success_status}')");

              // then remove project from live table//
              $remove_campaign="DELETE  FROM  `pl_live_campaigns` 
                     WHERE `campaign_id`='{$campaign_id}'";
              if(!$remove_campaign=$database->query($remove_campaign)){
              echo 'campaign could not be removed from live table';
              }
             $campaign_state='ended'; // i hate doing this like this-better way, mayb later//
             $query=$database->query("UPDATE `pl_campaign_basics` SET `campaign_state`= '{$campaign_state}' WHERE `campaign_id`='{$campaign_id}'");
//update the campaign status if no errors occur//
            if(!$query){
                 
          $ret .= "Campaign ended: updating campaign status failed";
            }

        }//  wen campaign ends//
            
          

          $ret .= "Ended";
        }
              
    }//endif for seconds//
   
    
    return $ret;
}

// -------------- RESIZE FUNCTION -------------
// Function for resizing any jpg, gif, or png image files


function resize_campaign_photo($target, $newcopy, $w, $h, $ext) {
    list($w_orig, $h_orig) = getimagesize($target);
    $scale_ratio = $w_orig / $h_orig;
    if (($w / $h) > $scale_ratio) {
           $w = $h * $scale_ratio;
    } else {
           $h = $w / $scale_ratio;
    }
    $img = "";
    $ext = strtolower($ext);
    if ($ext == "gif"){ 
    $img = imagecreatefromgif($target);
    } else if($ext =="png"){ 
    $img = imagecreatefrompng($target);
    } else { 
    $img = imagecreatefromjpeg($target);
    }
    $tci = imagecreatetruecolor($w, $h);
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
    if ($ext == "gif"){ 
        imagegif($tci, $newcopy);
    } else if($ext =="png"){ 
        imagepng($tci, $newcopy);
    } else { 
        imagejpeg($tci, $newcopy, 84);
    }
}
// ------------- THUMBNAIL (CROP) FUNCTION -------------
// Function for creating a true thumbnail cropping from any jpg, gif, or png image files
function resize_campaign_photo_thumb($target, $newcopy, $w, $h, $ext) {
    list($w_orig, $h_orig) = getimagesize($target);
    $src_x = ($w_orig / 2) - ($w / 2);
    $src_y = ($h_orig / 2) - ($h / 2);
    $ext = strtolower($ext);
    $img = "";
    if ($ext == "gif"){ 
    $img = imagecreatefromgif($target);
    } else if($ext =="png"){ 
    $img = imagecreatefrompng($target);
    } else { 
    $img = imagecreatefromjpeg($target);
    }
    $tci = imagecreatetruecolor($w, $h);
    imagecopyresampled($tci, $img, 0, 0, $src_x, $src_y, $w, $h, $w, $h);
    if ($ext == "gif"){ 
        imagegif($tci, $newcopy);
    } else if($ext =="png"){ 
        imagepng($tci, $newcopy);
    } else { 
        imagejpeg($tci, $newcopy, 84);
    }
}

// get the category icon by campaign category//
function get_campaign_category_icon($campaign_category){
         switch ($campaign_category) {
             case 'Photography':
                    return  'fa fa-file-photo-o (alias)';    
                 break;
             case   'Craft':
                    return  'fa fa-bullseye';   
                 break;
             case   'Education':
                    return  'fa fa-graduation-cap';
                 break;
             case   'Community':
                    return 'fa fa-group (alias)';
                 break;
             case 'Publishing':
                    return 'fa fa-file-photo-o (alias)';    
                 break;
             case   'Medical':
                    return 'fa fa-heartbeat';   
                 break;
             case   'Music':
                    return 'fa fa-music';
                 break;
             case   'Business':
                    return 'fa fa-briefcase';
                 break;
             case   'Volunteer':
                    return  'fa fa-hand-paper-o';
                  break;
             case   'Film & Video':
                    return 'fa fa-file-video-o';
                 break;
             case   'Politics':
                    return 'fa fa-bookmark';
                  break;
             case   'Events':
                    return 'fa fa-calendar';
                 break;
             default:
                 return 'No associated icon for this campaign category';
                 break;
         } // end





}

?>