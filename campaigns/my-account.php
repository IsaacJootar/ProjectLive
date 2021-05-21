<?php include ('includes/header-login.php');?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php include ('classes/database-object.php');?>
<?php include ('classes/user.php');?>

 <section align="left">                   
      <div class="container pt-10 pb-10" align="left">
        <h2 class="heading-border">Manage Account</h2>
        <div class="section-content"a align="left">
          <div class="row" align="left">
            <div class="col-md-16" align="left">
              <div class="horizontal-tab-centered text-center ">
                <ul class="nav nav-pills mb-10">
                  <li class="active"> <a href="#tab-1" class="" data-toggle="tab" aria-expanded="false"> <i class="fa fa-edit"></i>Update Account</a> </li>
                  <li class=""> <a href="#tab-7" data-toggle="tab" aria-expanded="false"> <i class="fa fa-envelope"></i> My messages</a> </li>
                   <li class=""> <a href="#tab-2" data-toggle="tab" aria-expanded="false"> <i class="fa fa-comment"></i> My notifications</a> </li>
                   <li class=""> <a href="#tab-4" data-toggle="tab" aria-expanded="false"> <i class="fa fa-lock"> </i> Change Password </a> </li>
                 <li class=""> <a href="#tab-6" data-toggle="tab" aria-expanded="false"> <i class="fa fa-gear"> </i>Account Settings</a> </li>
                  <li class=""> <a href="#tab-5" data-toggle="tab" aria-expanded="false"> <i class="fa fa-trash"> </i>Delete Account</a> </li>
                </ul>
                <div class="panel-body" align="left">
                  <div class="tab-content no-border" align="left">
                    <div class="tab-pane fade active in" id="tab-1"  align="left">
                      <div class="row">
                        <div class="col-sm-5">
                          <h4 class="mt-0 mb-30 line-bottom">User Account Update</h4>
                         <div class="col-md-16">
                          <?php
                    if ((output_message($message))){
                        echo   '<div class="alert alert-success">';
                        echo ' <button type="button" class="close" data-dismiss="alert">&times;</button>';
                   
                        echo  '<strong style="font-size:14px">' .  output_message($message). '</strong>'; 
                        echo ' </div>';
                        unset ($message);
                    }
      
                         echo  '<strong style="font-size:20px">'.$session->display_error().'</strong>';
            
        ?>        
             <form action="my-account-update" method="post">
<?php 
   $user=userManager::find_user_by_id($user_id);
 ?>
              <div class="row">
                <div class="form-group col-md-6">
                  <label>First Name</label>
                  <input type="text" name="first_name" value="<?php echo $user->first_name;?>" class="form-control">
                </div>
                <div class="form-group col-md-6">
                  <label>Last Name</label>
                  <input type="text" name="last_name" value="<?php echo  $user->last_name;?>" class="form-control">
                </div>
              </div>
              
               <div class="row">
                <div class="form-group col-md-6">
                  <label>Gender</label>
                 <select name="gender" value="<?php echo  $user->gender;?>" class="form-control" id="">
                            <option>MALE</option>
                            <option>FEMALE</option>
                            </select>
                </div>
                <div class="form-group col-md-6">
                  <label>Phone Number</label>
                  <input type="text" name="phone" value="<?php echo $user->phone;?>" class="form-control">
                </div>
              </div>
              
              <div class="row">
               <div class="form-group col-md-12">
                  <label>Email/Username</label>
                  <input type="text" name="user_name" value="<?php echo  $user->user_name;?>" class="form-control">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <label>State</label>
             <select name="state" class="form-control" id="location">
                        <?php 
                            global $database; 
                            $query=$database->query("SELECT `states` FROM `pl_states`");
                        while($states=$database->fetch_array($query)) { ?>
                           <?php 
                          if($states['states']==$user->state){ 
                            echo  '<option selected>'; 
                          } else{
                                 echo '<option>';
                             }
                         ?>
                            
                             <?php 
                               echo $states['states'];
                             } //end while loop ?></option>
                           
                            </select>
                </div>
                <div class="form-group col-md-6">
                  <label>Country</label>
                <select name="country" class="form-control" id="location">
                            <option>NIGERIA</option>
                            <option>GHANA</option>
                            </select>
                </div>
              </div>
             
              <input type="hidden" style="visibility: hidden;" name="user_id" value="<?php echo $user_id;?>">
              <div class="form-group">
                <button type="submit" class="btn btn-dark btn-theme-colored">Update Account</button>
              </div>
            </form>
          </div>
                        </div>
                       
                      </div>
                    </div>
                    <div class="tab-pane fade" id="tab-2" align="left">
                      <div class="row" align="left">
                        <div class="col-sm-5" align="left">
                          <h4 class="mt-0 mb-30 line-bottom">My Notification</h4>
                          
        <div class="container">
                  <div class="table-responsive">
              <table class="table table-bordered"> 
              <thead> <tr> 
                <?php $no=1;?>
                <th>#</th> <th>Message</th> <th>Payment confirmation time</th> </tr> </thead> <tbody>
             <?php $query2=$database->query("SELECT *  FROM `pl_donation_notifications` WHERE `user_id`='{$user_id}' ORDER BY `id` DESC");
                                    while($messages=$database->fetch_array($query2)) { ?> 
              <tr class="info"> <th scope="row"><?php echo $no; $no++;?></th> 
                <td> <?php echo $messages['message'];?> </td>
                <td><?php echo get_date_time($messages['date']);?></td>
              </tr><?php } ?> 
              </tbody> 
            </table>
          </div>
       </br>
     </div>
                       
                        </div>
                      </div>
                    </div>

 <div class="tab-pane fade" id="tab-7" align="left">
                      <div class="row" align="left">
                        <div class="col-sm-5" align="left">
                          <h4 class="mt-0 mb-30 line-bottom">My Messages</h4>
                          
        <div class="container">
                  <div class="table-responsive">
              <table class="table table-bordered"> 
              <thead> <tr> 
                <?php $no=1;?>
                <th>#</th> <th>Name</th><th>e-Mail </th><th>Message</th> <th>Time</th> </tr> </thead> <tbody>
             <?php $query3=$database->query("SELECT * FROM `pl_creators_messages` WHERE `user_id`='{$user_id}'");
             
                                    while($messages=$database->fetch_array($query3)) { ?> 
              <tr class="info"> <th scope="row"><?php echo $no; $no++;?></th> 
               <td> <?php echo $messages['name'];?> </td>
                    <td> <?php echo $messages['email'];?> </td>
                <td> <?php echo $messages['message'];?> </td>
                <td><?php echo get_date_time($messages['date']);?></td>
              </tr><?php } ?> 
              </tbody> 
            </table>
          </div>
       </br>
     </div>
                         
                        </div>
                      </div>
                    </div>


                    <div class="tab-pane fade" id="tab-4" align="left">
                      <div class="row" align="left">
                        <div class="col-sm-5" align="left">
                          <h4 class="mt-0 mb-30 line-bottom">Change Password</h4>
                          <form action="update-password.php" method="post" name="change pass">
                           <div class="row">
                <div class="form-group col-md-6">
                  <label>Enter Previous Password</label>
                  <input type="password" required="required" name="former_pass"  class="password">
                </div>
                <div class="form-group col-md-6">
                  <label>Enter New Password</label>
                  <input type="password" required="required" name="new_pass" class="password">
                </div>
                  <input type="checkbox"  id="showHide"> <i>Reveal password</i>
              </div>
              
                          <input type="hidden" style="visibility: hidden;" name="user_id" value="<?php echo $user_id;?>">
                      <button type="submit" class="btn btn-dark btn-theme-colored" data-loading-text="Please wait...">Change  Now</button>
                      </br>
                       <div class="text-justify">
                      <p>It is good practice to choose a password you can remember and yet not simple enough to be guessed.  Do not share your password with others. Keep your password safe .</p>
                        </div>
                      </div>
                    </div>
                    </div>

                  </form>
                  
             <div class="tab-pane fade" id="tab-6" align="left">
                      <div class="row" align="left">
                        <div class="col-sm-5" align="left">
                          <h4 class="mt-0 mb-30 line-bottom">Account Settings.</h4>
                           <div class="text-justify">
                        <h6>Check and uncheck to turn options on and off respectively. Disabled boxes are turned on by default.</h6>
   
 <input type="checkbox" checked disabled value="">
  Send me an e-Mail any time my campaign receives a donation. </br>
<input type="checkbox" value="">
  Send me an SMS notification any time my campaign receives a donation.</br>
<input type="checkbox" checked disabled value="">
 Send notifications to my ProjectLive account when my campaign receives a donation.</br>
<input type="checkbox" checked disabled value="">
  Send me an e-Mail notification any time my campaign is approved.</br>

<input type="checkbox"  value="">
  Send me an SMS notification any time my campaign is approved.</br>

<input type="checkbox" value="">
    Send me an e-Mail any time my campaign is declined.</br>

<input type="checkbox" value="">
   Send me an SMS notification any time my campaign is declined.</br></br>

</div>

                      <button  type="submit" class="btn btn-dark btn-theme-colored" data-loading-text="Please wait...">Update Settings</button>
                        </div>
                      </div>
                    </div>       
                   
                     <div class="tab-pane fade" id="tab-5" align="left">
                      <div class="row" align="left">
                        <div class="col-sm-5" align="left">
                          <h4 class="mt-0 mb-30 line-bottom">Delete Account</h4>
                          <p>This deletion will remove all your content from this platform.</p>
                      <button  disabled type="submit" class="btn btn-dark btn-theme-colored" data-loading-text="Please wait...">Delete Account Now</button>
                        </div>
                      </div>
                    </div>
                    
                   

    </section>
    
   <div class="row"> 
            <div class="col-md-12  text-center">
              <h2>Achieve your campaign goal in four simple steps</h2>
              
            </div>
          </div>
       
<div class="main-content">
    <!-- Section: home -->    
      <!-- divider: acheive in 4 easy step -->
   <section>
    <div class="row mt-30">
          <div class="col-sm-3">
            <div class="icon-box iconbox-theme-colored">
              <a class="icon icon-dark icon-circled icon-border-effect effect-circled icon-sm pull-left mb-0 mr-10" href="#">
                <i class="pe-7s-switch"></i>
              </a>
              <h5 class="icon-box-title mt-15 mb-20">Start a Campaign</h5>
              <p class="text-gray"> <div class="text-justify">Create a campaign by telling a compelling story of your idea, project or anything that means so much to you. Choose your area of interest from our various categories.</p>
            </div>
          </div>
          </div>
          <div class="col-sm-3">
            <div class="icon-box iconbox-theme-colored">
              <a class="icon icon-dark icon-circled icon-border-effect effect-circled icon-sm pull-left mb-0 mr-10" href="#">
                <i class="pe-7s-global"></i>
              </a>
              <h5 class="icon-box-title mt-15 mb-20">Go Live</h5>
              <p class="text-gray"><div class="text-justify">Your campaign goes live after a vetting process and approval by the ProjectLive team. Use the platform tools provided to promote your campaign on social media, with friends and family.</p>
            </div>
          </div>
          </div>
          <div class="col-sm-3">
            <div class="icon-box iconbox-theme-colored">
              <a class="icon icon-dark icon-circled icon-border-effect effect-circled icon-sm pull-left mb-0 mr-10" href="#">
                <i class="pe-7s-cash"></i>
              </a>
              <h5 class="icon-box-title mt-15 mb-20">Receive Funds</h5>
              <p class="text-gray"> <div class="text-justify">Start receiving funds from willing donors all over Africa. Monitor your funds in realtime as they come in.</p>
            </div>
          </div>
          </div>
          <div class="col-sm-3">
            <div class="icon-box iconbox-theme-colored">
              <a class="icon icon-dark icon-circled icon-border-effect effect-circled icon-sm pull-left mb-0 mr-10" href="#">
                <i class="pe-7s-like2"></i>
              </a>
              <h5 class="icon-box-title mt-15 mb-20">Execute your Project.</h5>
              <p class="text-gray"><div class="text-justify">Use the funds you have received to execute the project. Appreciate your donors and share your success story to our community.That's it. Simple!</p>
            </div>
          </div>
          </div>
        </div>
    </section>

<script type="text/javascript">
// toggle to reveal passowrd or not when updating//
 $(document).ready(function () {
 $("#showHide").click(function () {
 if ($(".password").attr("type")=="password") {
 $(".password").attr("type", "text");
 }
 else{
 $(".password").attr("type", "password");
 }
 
 });
 });
</script>

    
  <?php include('../includes/campaign-heads-up.php');?>
  <!-- Footer -->

  <?php include('includes/footer.php'); ?>

</body>
</html>