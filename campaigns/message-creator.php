
<?php date_default_timezone_set('Africa/Lagos'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/smsAPI.php');

           $user_id=$_GET['user_id']; // from Ajax
           $campaign_id=$_GET['cid']; // From Ajax 
 ?>
        <div class="modal-header">
 
  <button type="button"  class="close" data-dismiss="modal">X</button>
                   
                   <h5 class="modal-title" id="myModalLabel2"><i class="fa fa-envelope-o text-theme-colored"></i> Send creator a message.   </h5>
                </div>

                <div class="modal-body">
                   <form class="form-horizontal" id="form" method="post">
                <fieldset>
               
                    <div class="input-group col-md-12"> 
                       <h6 class="alert alert-info">This message will be sent to the creator of this campaign. Creator's reply is entirely by them and their discretion. </h6> 
                       <label style="float:center"> Enter your fullname in the box below <strong style="color:#F00">*</strong> </label>
      <input id="campaign_id" type="hidden" value="<?php echo $campaign_id ?>">
       <input id="user_id" type="hidden" value="<?php echo $user_id ?>">
    <input type="text" id="name" required class="form-control">
    <label style="float:center">Okay, enter your e-Mail address below.<strong style="color:#F00">*</strong> </label>
    <input type="email" id="email" required class="form-control">
    <label style="float:center">Enter your message for the creator.<strong style="color:#F00">*</strong></label>
   <textarea type="text" id="message" placeholder="Your message.." required class="form-control"></textarea>
                    </div></br>
                  
                  
                    <div class="clearfix"></div>
                    <p class="center col-md-5">
                      <button type="button" id="submit" class="btn btn-dark btn-theme-colored">Send Now</button>
                    </p>
                </fieldset>
            </form>
              
                
            </div>
<script type="text/javascript">

$(document).ready(function() {
$("#submit").click(function() {
var name = $("#name").val();
var email = $("#email").val();
var message = $("#message").val();
var user_id = $("#user_id").val();
var campaign_id = $("#campaign_id").val();
if (name == '' || email == '' || message == '') {
alert("Field(s) are Blank....!!");
} else {
// Returns successful data submission message when the entered information is stored in database.
$.post("message-creator_.php", {
name1: name,
email1: email,
message1: message,
user_id1: user_id,
campaign_id1: campaign_id,
}, function(data) {
alert(data);
$('#form')[0].reset(); // To reset form fields
});
}
});
});
            </script>