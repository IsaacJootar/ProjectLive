 <?php ob_start(); ?>
<?php session_start(); ?>
<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); 
// put these guys in a function later. //
if(!isset($_SESSION['SESS_USER'])){include ('includes/header.php');} else {
   include ('includes/header-login.php');} ?>
<?php require_once('classes/session.php'); ?>
<?php require_once('classes/functions.php'); ?>
<br><br><br>
  <div class="main-content">
    <!-- Section: inner-header -->
    <section class="inner-header divider layer-overlay overlay-dark" data-bg-img="images/bg/bg2.jpg">
      <div class="container pt-30 pb-30">
        <!-- Section Content -->
        <div class="section-content text-center">
          <div class="row"> 
            <div class="col-md-6 col-md-offset-3 text-center">
              <h2 class="text-theme-colored font-36">Become a Volunteer</h2>
              <ol class="breadcrumb text-center mt-10 white">
              
                <li class="active">join hundreds of other volunteers verifying and screening campaigns in their communities.
                
                   <p> Already have a volunteer's account?  <a href="volunteer/volunteer-sign-in"><strong class="text-theme-colored" style="color:#000">Log in</strong></a></p>
                   <p> Haven't created a volunteer's account? <a href="#sign_up"><strong class="text-theme-colored" style="color:#000">Create Now</strong></a></p></li>
            
              </ol>
            </div>
          </div>
        </div>
      </div>      
    </section>
<div align="center"; style="font-weight: bold;">

   <?php
                    if ((output_message($message))){
               echo   '<div class="alert alert-success">';
                   echo ' <button type="button" class="close" data-dismiss="alert">&times;</button>';
                   
                   echo output_message($message); 
               echo ' </div>';
                 unset ($message);
                 }
              ?>
                  <?php echo $session->display_error(); ?>  
</div>
    <!-- Section: Features -->
    <section class="bg-lighter"> 
      <div class="container">
        <div class="section-content">
          <div class="row mtli-row-clearfix">
            <div class="col-xs-12 col-sm-6 col-md-3 pb-sm-20">
              <div class="icon-box text-center p-10">
                 <a href="#sign_up"  class="icon icon-gray icon-bordered icon-rounded icon-border-effect effect-rounded mb-10">
                  <i class="fa fa-user-plus font-30 text-theme-colored"></i>
                </a>
                <h4 class="icon-box-title">Sign up</h4>
               
                <p class="text-gray">Sign up on ProjectLive to become a volunteer. It takes just 2 munites.</p>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 pb-sm-20">
              <div class="icon-box text-center p-10">
                <a href="#" class="icon icon-gray icon-bordered icon-rounded icon-border-effect effect-rounded mb-10">
                  <i class="fa fa-clone font-30 text-theme-colored"></i>
                </a>
                <h4 class="icon-box-title"><a>Join to a new campaign</a></h4>
                <p class="text-gray">Join a campaign in your community or create one yourself</p>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 pb-sm-20">
              <div class="icon-box text-center p-10">
                <a href="#" class="icon icon-gray icon-bordered icon-rounded icon-border-effect effect-rounded mb-10">
                  <i class="fa fa-globe font-30 text-theme-colored"></i>
                </a>
                <h4 class="icon-box-title">Discover</h4>
                <p class="text-gray">Discover amazing adeas and projects in your community, vet and be a part of their creation. </p>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 pb-sm-20">
              <div class="icon-box text-center p-10">
                <a href="#" class="icon icon-gray icon-bordered icon-rounded icon-border-effect effect-rounded mb-10">
                  <i class="fa fa-life-ring font-30 text-theme-colored"></i>
                </a>
                <h4 class="icon-box-title"><a href="#">Support</a></h4>
                <p class="text-gray">Support amazing stories of people raising funds for different projects in your community</p>
              </div>
            </div>
          </div>
        </div> 
      </div>
    </section>

    <section>
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            
            <div class="icon-box mb-0 p-0">
              <a href="#" class="icon icon-gray pull-left mb-0 mr-10">
                <i class="pe-7s-volume"></i>
              </a>
              <h3 class="icon-box-title pt-15 mt-0 mb-40">Help Annouce.</h3>
              <hr>
              <p class="text-gray"><div class="text-justify">For the first time, Africa will have a plaform entirely dedicated to promoting and supporting ideas on social, charity, creative and entrepreneurial projects. ProjectLive creates a golden opportunity for people such as you, to be a part something good, and of benefit to you and your community. By joining other hundreds of volunteers on ProjectLive, you will annouce to others in your community of a plaform they can leverage on. Join today!</p>
             </div>
             </div>
            <div class="icon-box mt-80 mb-0 p-0">
              <a href="#" class="icon icon-gray pull-left mb-0 mr-10">
                <i class="pe-7s-scissors"></i>
              </a>
              <h3 class="icon-box-title pt-15 mt-0 mb-40">Be a Part of Creation.</h3>
              <hr>
              <p class="text-gray">Creating a successful crowdfunding camapign can be demanding. Become a part of their creation by helping to vet projects in your community, been a guide and a physical help to creators birthing ideas that means alot to them. </p>
            </div>
          </div>
            <a id="sign_up"></a>
          <div class="col-md-4">
       
            <div class="heading-line-bottom mt-0 mb-30">

             <h3 class="line-bottom"> Sign Up Here</h3>
            </div>

            <form id="volunteer_apply_form" name="job_apply_form" action="become-a-volunteer_" method="post">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="form_name">Fullname <small class="text-theme-colored">*</small></label>
                    <input id="form_name" name="name" type="text" placeholder="Enter Name" required="" class="form-control">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                   
                    <label for="form_email">Email <small>*</small></label>
                    <input id="email" required="required" name="email" class="form-control required email" type="email" placeholder="Enter Email">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="form_name">Phone Number <small class="text-theme-colored">*</small></label>
                    <input id="form_name" name="phone" type="text" placeholder="Enter Phone Number" required="" class="form-control">
                  </div>
                </div>
               
 <div class="col-sm-6">
                  <div class="form-group">
                   
                    <label for="form_location">Create Password<small class="text-theme-colored">*</small></label>
                    <input id="" required="required" name="password" class="form-control required " type="password" placeholder=" Choose a password">
                  </div>
                </div>
              </div>

              <div class="row">               
                <div class="col-sm-6">
                  <div class="form-group">
                   
                  
                    <label for="form_sex">Gender <small class="text-theme-colored" >*</small></label>
                    <select id="gender" name="gender" class="form-control required">
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                 <?php // include database// ?>   
             <?php require_once('classes/database.php'); ?>
        
                    
                
                    <label for="form_branch">Volunteering  State <small class="text-theme-colored" > *</small></label>
                    <select id="location" name="state" class="form-control required">
                      <?php 
                            global $database; 
                            $query=$database->query("SELECT `states` FROM `pl_states`");
                        while($states=$database->fetch_array($query)) { ?>
                                <option>
                            
                             <?php 
                               echo $states['states'];
                             ?></option>
                           <?php } ?>
                            
                            </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                   
               
                <label for="form_message">Message <small class="text-theme-colored">*</small></label>
                <textarea id="form_message" name="message" class="form-control" rows="4" placeholder="Reason for joining-this is optional, you can choose to leave it blank"></textarea>
              </div>
         
              <div class="form-group">
                
                <button type="submit" class="btn btn-block btn-dark btn-theme-colored btn-sm mt-20 pt-10 pb-10" data-loading-text="Please wait...">Join Now</button><p>
                  <p style="font-size: 11px">Your phone number & email may be used to sent you SMS & email notifications</p>
                 <p>Already have a volunteer's account? <a href="volunteer/volunteer-sign-in"><strong class="text-theme-colored" style="color:#000">Log in</strong></a></p>
              </div>
            </form>
          </div>

        </div>
      </div>
    </section>
  </div>
  <!-- end main-content -->
  
  <!-- Footer -->
  <?php include('includes/footer.php'); ?>
</body>
</html>