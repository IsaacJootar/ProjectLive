<?php date_default_timezone_set('Africa/Lagos'); ?>

<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/campaign-review.php'); ?>
<?php require_once('classes/smsAPI.php'); ?>

<?php
$user_id2=$_POST['user_id1'];
$campaign_id2=$_POST['campaign_id1']; // campaign id
$name2=$database->escape_value($_POST['name1']); // Fetching Values from URL
$email2=$database->escape_value($_POST['email1']);
$message2=$database->escape_value($_POST['message1']);
$date=date('M j, Y h:i:s A');
$query = $database->query("INSERT INTO pl_creators_messages(user_id, campaign_id, name, email, message, date) values ('$user_id2', '$campaign_id2','$name2','$email2','$message2', '$date')"); 
if($query){
echo "Your message is Send succesfully.";
}// Connection Closed.
?>