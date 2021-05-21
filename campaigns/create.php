<?php include ('includes/header-login.php');?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/database-object.php'); ?>
<?php require_once('classes/functions.php'); ?>
<?php require_once('classes/campaign-basics.php'); ?>
<?php require_once('classes/campaign-photos.php'); ?>
<?php require_once('classes/campaign-goal.php'); ?>
<?php require_once('classes/campaign-story.php'); ?>
<?php require_once('classes/campaign-bank-details.php'); ?>
 <?php 


 //get campaign id and supply to the method for campaign details//
  if(isset($_SESSION['campaign_id'])){
    $set_campaign_id=  $_SESSION['campaign_id'];
   $active_tab=$_SESSION['active_tab'];
  }
  elseif(isset($_GET['ref'])){
         $campaign_tittle=str_replace('-', ' ', $_GET['ref']); // remove the dashes from the titile//
         $campaign_id=$database->query("SELECT `campaign_id` FROM `pl_campaign_basics` WHERE `campaign_tittle`= '{$campaign_tittle}'");
        $campaign_id=$database->fetch_array($campaign_id);
        $set_campaign_id=$campaign_id['campaign_id'];
        $active_tab=2; // when visiting this page focuse on the 2 tab which is default//

  }
 
   else {$session->message("Campaign id reset, please fill the informations and submit again");
      header('location:../sign-in-form');
      exit();
    }

?>


  <!-- Start main-content -->
 
  
    <!-- Section: inner-header -->
    <section class="inner-header divider layer-overlay overlay-dark">
      <div class="container pt-10 pb-10">
        <!-- Section Content -->
        <div class="section-content text-center">
          <div class="row"> 
            <div class="col-md-6 col-md-offset-3 text-center">
              <h2 style="color:#FFF"> Let’s get started.</h2>
            

              <ol>
                <li class="active"; style="color: #FFF"><div class="text-justify">Fifty-five percent of unsuccessful  campaigns result from poor planning! Do not rush, take time and build your campaign before you go live! You can even save your data to continue at a later time.</div></li>
              </ol>
            </div>
          </div>
        </div>
      </div>      
    </section>
    
    <section>
      <div>
        <div class="row" align="left">
          <div class="col-md-9" align="left">
            <!-- Section: About -->
            
 <section align="center">
        <h4 class="heading-border"><div class="text-justify">Creating a successful campaign requires some dedication and hardwork. Make a great first impression with your campaign basics, that is your project title and photo, campaign title, campaign duration etc. Set your funding goal, setup your bank account details. Tell your story. Go live.</div>
        </h4>
          <?php
                    if ((output_message($message))){
                        echo   '<div class="alert alert-success">';
                        echo ' <button type="button" class="close" data-dismiss="alert">&times;</button>';
                   
                        echo  '<strong style="font-size:14px">' .  output_message($message). '</strong>'; 
                        echo ' </div>';
                        unset ($message);
                    }
      
                         echo  '<strong  style="font-size:20px">'.$session->display_error().'</strong>';;
            
        ?> 
        <div class="section-content"a align="left">
          <div class="row" align="left">
            <div class="col-md-16" align="left">
              <div class="horizontal-tab-centered text-center ">
                <ul class="nav nav-pills mb-8">
                 <li class="<?php if($active_tab==1){echo 'active';} else {echo '';}?>"> <a href="#tab-1" class="" data-toggle="tab" aria-expanded="false"> <i class="fa fa-edit"></i>Campaign Story </a> </li>
                  <li class="<?php if($active_tab==2){echo 'active';} else {echo '';}?>"> <a href="#tab-2" data-toggle="tab" aria-expanded="false"> <i class="fa fa-book"></i> My Bacis Information</a> </li>
                   <li class="<?php if($active_tab==3){echo 'active';} else {echo '';}?>"> <a href="#tab-3" data-toggle="tab" aria-expanded="false"> <i class="fa fa-bank"> </i> Set Up Bank Details</a> </li>
                 
                  <li class="<?php if($active_tab==4){echo 'active';} else {echo '';}?>"> <a href="#tab-4" data-toggle="tab" aria-expanded="false"> <i class="fa fa-money"> </i>Campaign Funding Goal</a> </li>
                   <li class="<?php if($active_tab==5){echo 'active';} else {echo '';}?>"> <a href="#tab-5" data-toggle="tab" aria-expanded="false"> <i class="fa fa-globe"> </i> Submit For Review</a> </li>
                </ul>
                <div class="panel-body" align="left">
                  <div class="tab-content no-border" align="left">
                  <div class="<?php if($active_tab==1){echo 'tab-pane fade active in';} else {echo 'tab-pane fade';}?>" id="tab-1"  align="left">
                      <div class="row">
                        <div class="col-sm-9">
                          <h4 class="mt-0 mb-16 line-bottom">Campaign Story</h4>
                         <div class="col-md-16">
                               <div class="text-justify">
                              <p>Hello campaign creator! This is where you can write your story. Donors are more likely to fund projects that touch or inspire them. Use all the tools in the text editor to present a good and detailed story. Use the tabs as you wish, to include links, photos, videos, colors, tables, and any other thing that will make your story inspiring. You can download Creators Handbook if you need more help. Or read other amazing resources on the platform that will help you run a successful campaign. Goodluck. <a class="text-theme-colored" style style="bxslider bx-nav-top" href="resources/CREATORS_HANDBOOK.pdf" download>
  Creators Handbook
</a>if you need more help on writing a captivating story. Or read other amazing resources on the platform that will help you.     </p></div>
             <form id="campaign_story"  class="mt-30" method="POST" action="campaign-story">
                    <div class="row">
                      
                      <div class="col-sm-12">
                        <div class="form-group mb-20">
                          <div id="sample">
<?php
$campaign_story=campaignStoryManager::find_by_id($set_campaign_id);
?>

<textarea placeholder="Hello campaign creator! This is where you can write your story. Donors are more likely to fund projects that touch or inspire them. Use all the tools in the text editor to present a good and detailed story. Use the tabs as you wish, to include links, photos, videos, colors, designs, and any other thing that will make your story inspiring. You can download Creators Handbook if you need more help. Or read other amazing resources on the platform that will help you run a successful campaign. Goodluck." name="campaign_story" id="mystory">
      <?php if(!isset($campaign_story->story)){
        echo '';
        }else{ echo $campaign_story->story;
        } ?>
</textarea>
 <input type="hidden" name="campaign_id" style="visibility: hidden;" value="<?php echo $set_campaign_id?>" />
</div>

 
    
 
   
                        </div>
                      </div>
                     
                     
                     
                    </div>
                   
                   
                    <div class="form-group mb-0 mt-1">
                <p>
            <div class="alert-info" align="justify"> Its advisable to be saving your campaign informations before moving to the next tab or while shuffling between tabs.</div>
                      </p>
                     
                      <button type="submit" class="btn btn-dark btn-theme-colored" data-loading-text="Please wait...">Save campaign story</button>
                    </div>
                  </form>
          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="<?php if($active_tab==2){echo 'tab-pane fade active in';} else {echo 'tab-pane fade';}?>" id="tab-2" align="left">
                      <div class="row" align="left">
                       <div class="col-sm-9">
                          <h4 class="mt-0 mb-16 line-bottom">Campaign Basic Information</h4>
                         <div class="col-md-16">
                                  <div class="col-sm-12">
      
       
                        <div class="form-group mb-10">
<?php 
$campaign_basics=campaignBasicsManager::find_by_id($set_campaign_id);
$campaign_photos=campaignPhotoManager::find_by_id($set_campaign_id);
?>
                      
                          <form style="float:center" enctype="multipart/form-data" method="post" action="campaign-photo">
  
  <label>Select Campaign Photo:<strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Your campaign photo should be clear and should not contain text. Your campaign photo is the first thing that people see when they come across your project. So choose an image that is not too small, clear and text-free."> </i><b style="color:#06F"><p>   Image type must be .gif, .jpg, or .png and not more than 15MB in size. We recommend an image with a good resolution.</p></b> 

  </label>
  <p align="left">
  Your project photo is the first thing that people will see when they come across your project.Get your best photo for your campaign. Choose an image that will best communicate your message.Your image should be clear and text-free.
  <p>
   <?php echo $campaign_photos::find_thumb_campaign_photo_by_user_id($set_campaign_id, $user_id);?>
 
<input title="select campaign photo" required align="center" style="float:center" type="file" name="uploaded_file" /></br>
  <input align="left" style="float:left" type="submit" value="upload photo" /></br>
  <input type="hidden" name="campaign_id" style="visibility: hidden;" value="<?php echo $set_campaign_id?>" />
 
 <input type="hidden" name="campaign_tittle" style="visibility: hidden;" value="<?php echo $set_campaign_id?>" />
 
</form>
     </br></br>
                        </div>
                      </div>
                  
            <form id="creation_form" name="campaign_basic" class="mt-30" method="post" action="campaign-basics">
                <label> Campaign Video [optional]:<strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Your campaign Video is optional. However campaign video is a huge compelling tool. Your video should be maximum two minutes or less. The video should describe who you are, what your project is about and how much you need to make your idea a reality, and the reward you have for donors, if any."> </i></label>
                <div class="col-md-12">
                    <div class="form-group mb-20">
                      <?php  // 0 is i dont have , 1 is i do have a video // ?> 
                      <label class="radio-inline">
                        <input type="radio" checked="" value="1" name="campaign_video_flag"> 
                        I do not have a campaign video
                      </label>
                      <label class="radio-inline">
                        <input type="radio" value="0" name="campaign_video_flag"> 
                       I have a campaign video
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-12" id="video_option">
                   
                      <div class="radio mt-5">
                        <b style="color:#06F">
                         Great! Projects with a video have a much higher chance of success. Upload your video on youtube, then copy and paste the video url link code in the input box below. Projectlive does not store video contents on its servers. 
                        </b>
                     <div class="col-sm-12">
                        <div class="form-group mb-10">
                    <label>Copy & paste your campaign video url link here</label>
                          <input name="campaign_video_link" class="form-control" type="text" value="<?php echo $campaign_basics->campaign_video_link;?>" aria-required="false">
                        </div>
                      </div>
                    </div>
                  </div>
                
                    <div class="row">
                         <div class="col-sm-12">
                        <div class="form-group mb-10">
                        <label> Select Campaign Duration: This is the number of days your campaign willl be live on projectlive</label><strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="All campaigns have a duration, this is the period (in days) that your campaign will remain live on this plaform and also open for donations. After you campaign duration expires, no further donations will be accepted or received."> </i>
                         <select required="required"  name="campaign_duration" class="form-control" id="duration">
                            <?php 
                            
                         for($i=0; $i<=70; $i+=2){
                            if($i==$campaign_basics->campaign_duration){ 
                            echo  '<option selected>'; 
                            } else{
                                 echo '<option>';
                             }
                         ?>
                            
                             <?php 
                               echo $i;
                          }// end for loop  ?></option>
                           
                            
                            </select>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group mb-10">
                        <label> Your Campaign Title</label><strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Your campaign title should be clear and precise, not too long or too complicated for donors. People often donate to projects they understand. "> </i>
                          <input name="campaign_tittle" class="form-control" type="text" value="<?php echo $campaign_basics->campaign_tittle; ?>"  placeholder="Enter  The Title of Your Campaign" aria-required="false">
                        </div>
                      </div>
                      
                            <div class="col-sm-12">
                        <div class="form-group mb-10">
                        <label> Your Campaign Category:This will represent a category that best represents your project.</label><strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Every campaign should fall under a category, example a campaign for hospital bills or related issues may fall under medical category."> </i>

                         <select  name="campaign_category" class="form-control" id="cat">
                            <?php 
                            global $database; 
                            $query=$database->query("SELECT `category` 
                              FROM `pl_campaign_categories`");
                        while($category=$database->fetch_array($query)) { ?>
                           <?php 
                          if($category['category']==$campaign_basics->campaign_category){ 
                            echo  '<option selected>'; 
                          } else{
                                 echo '<option>';
                             }
                         ?>
                            
                             <?php 
                               echo $category['category'];
                             } ?></option>
                           
                            
                            </select>
                        </div>
                      </div>

                       <div class="col-sm-12">
                        <div class="form-group mb-10">
                          <label title="Select beneficiary type"> Type of Beneficiary</label><strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Every campaign should have a beneficiary type, a campaign creator is either an individual, a group or an NGO"> </i>
                        
                            <select  name="beneficiary_type" class="form-control" id="">
                            <?php 
                            global $database; 
                            $query=$database->query("SELECT `beneficiary_type` FROM `pl_campaign_beneficiary_type`");
                        while($beneficiary=$database->fetch_array($query)) { ?>
                           <?php 
                          if($beneficiary['beneficiary_type']==$campaign_basics->beneficiary_type){ 
                            echo  '<option selected>'; 
                          } else{
                                 echo '<option>';
                             }
                         ?>
                            
                             <?php 
                               echo $beneficiary['beneficiary_type'];
                             } //end while loop ?></option>
                           
                            
                            </select>
                        </div>
                      </div>
                     
                      <div class="col-sm-12">
                        <div class="form-group mb-10">
                        <label>Name of Beneficiary </label><strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Your campaign should have a beneficiary, this is an indivdual, a group or organization that campaign funds will be disbursed to. A campaign creator can equally be the beneficiary"> </i>
                          <input name="campaign_beneficiary" class="form-control" type="text" value="<?php echo $campaign_basics->campaign_beneficiary;?>"  placeholder="Enter  The Name of Campaign beneficiary" aria-required="false">
                        </div>
                      </div>

                      <div class="col-sm-12">
                        <div class="form-group mb-10">
                          <label title="Select location where this project is happening"> Select Campaign Location:Where are you carrying out this project?</label><strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Your campaign Location is the place or state where you intend to carry out your project after raising funds"> </i>
                        
                            <select  name="campaign_location" class="form-control" id="location">
                            <?php 
                            global $database; 
                            $query=$database->query("SELECT `states` FROM `pl_states`");
                        while($states=$database->fetch_array($query)) { ?>
                           <?php 
                          if($states['states']==$campaign_basics->campaign_location){ 
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
                      </div>

                     <div class="col-sm-12">
                        <div class="form-group mb-10">
                           <label style="color:#000">Campaign Tagline<strong>:</strong>This is a short description that best summarizes your campaign<strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Your campaign tagline should be a short summary description of what your campaign is all about. Campaign description should not be long but should give a clear idea to the audience what it is all about. This is not where to tell your story "> </i></label>
                <input type="text" class="form-control" placeholder=" Should not be more than 80 characters" id="field" onkeyup="countChar(this)" name="area1" rows="3" style="width:80%;" value="<?php echo trim($campaign_basics->campaign_tagline); ?>">
              

              
                 <div id="charNum"></div>
                        </div>
                      </div>
            
                    
                       
                    </div>

            
                    <div class="form-group mb-0 mt-1">
                      <p>
            <div class="alert-info" align="justify"> Its advisable to be saving your campaign informations before moving to the next tab or while shuffling between tabs.</div>
                      </p>
                      </p>
                      <input type="hidden" style="visibility: hidden;" 
                      value="<?php echo $set_campaign_id?>" name="campaign_id">
                      <button type="submit" class="btn btn-dark btn-theme-colored" data-loading-text="Please wait...">Save basic information</button>
                    </div>
                  </form>
          </div>
                        </div>
                       
                      </div>
                    </div>
                       <div class="<?php if($active_tab==3){echo 'tab-pane fade active in';} else {echo 'tab-pane fade';}?>" id="tab-3" align="left">
                      <div class="row" align="left">
                        <div class="col-sm-9" align="left">
                          <h4 class="mt-0 mb-30 line-bottom">Bank Details</h4>
                         <form id="" name="reg_form" class="mt-30" method="post" action="campaign-bank-details">
                         <?php
$campaign_goal=campaignGoalManager::find_by_id($set_campaign_id);
$campaign_bank=campaignBankManager::find_by_id($set_campaign_id);
?>
    <div class="form-group col-md-6">
                  <label>SELECT YOUR BANK</label>
                 <select name="bank_name" type="text" class="form-control " id="bank">

<?php 
global $database; 
$query=$database->query("SELECT `bank` FROM `pl_banks`");
while($banks=$database->fetch_array($query)) { ?>
<?php 
if(!isset($campaign_bank->bank_name)){
  $bank_name='';
}
  else{
    $bank_name=$campaign_bank->bank_name;
  }
if($banks['bank']==$bank_name){ echo  '<option selected>'; 
  } else{
    echo '<option>';
      }
?>
                            
<?php 
echo $banks['bank'];
                             } ?></option>
                           
                            

                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>ENTER YOUR ACCOUNT NUMBER</label>
                  <input name="account_number" type="number" value="<?php echo $campaign_bank->account_number; ?>"  class="form-control">
                  <input type="hidden" name="campaign_id" style="visibility: hidden;" value="<?php echo $set_campaign_id?>" />
 
                </div><p>
 This is your bank account details where you will receive funds after your campaign ends.
 
                     
                      
                     
                  
                    <div class="form-group mb-0 mt-1">
             <div class="alert-info" align="justify"> Its advisable to be saving your campaign informations before moving to the next tab or while shuffling between tabs.</div>
                      </p>
                      <button type="submit" class="btn btn-dark btn-theme-colored" data-loading-text="Please wait...">Save bank  details</button>
                    </div>
                  </form>
                     
                        
                        </div>
                      </div>
                    </div>
                        <div class="<?php if($active_tab==4){echo 'tab-pane fade active in';} else {echo 'tab-pane fade';}?>" id="tab-4" align="left">
                      <div class="row" align="left">
                        <div class="col-sm-9" align="left">
                          <h4 class="mt-0 mb-30 line-bottom">Campaign Goal</h4>
                         <form id="" name="reg_form" class="mt-30" method="post" action="campaign-goal">
                         <?php
$campaign_goal=campaignGoalManager::find_by_id($set_campaign_id);
?>
    <label>Campaign Funding Goal:This is the amount of money you wish to raise from this campaign</label>
    <div class="input-group">
      <div class="input-group-addon">₦</div>
      <input name="campaign_goal" autofocus type="number" value="<?php echo $campaign_goal->amount; ?>" min="2000"  class="form-control" id="inputAmount" placeholder="Goal Amount">
       <input type="hidden" name="campaign_id" style="visibility: hidden;" value="<?php echo $set_campaign_id?>" />
 
      <div class="input-group-addon">.00</div>
    </div>
     <div class="text-justify">
 <br> Your funding goal is the exact amount of money you wish to get from your campaign. However your campaign donations can be exceeded, that is, your campaign may receive more funds depending on how successful your campaign runs. Funds will be disbursed through the channel you have provided during your bank details setup. The following fees will be allpied from each donation: ProjectLive platform fee 5%, and payment processing fees for transactions carried out online (1.5% + ₦100, The ₦100 fee is waived for all transactions less than ₦2500 ). Be aware that we do not charge donors.  <p >
 <a class="text-theme-colored" target="_blank" href="../fees">View  our fees breakdown here</a></div>
        <div class="form-group mb-0 mt-1">
             <div class="alert-info" align="justify"> Its advisable to be saving your campaign informations before moving to the next tab or while shuffling between tabs.</div>
                      </p>
                      <button type="submit" class="btn btn-dark btn-theme-colored" data-loading-text="Please wait...">Save funding setup</button>
                    </div>
                  </form>
                     
                         
                        </div>
                      </div>
                    </div>
                    
                            <div class="<?php if($active_tab==5){echo 'tab-pane fade active in';} else {echo 'tab-pane fade';}?>" id="tab-5" align="left">
                      <div class="row" align="left">
                        <div class="col-sm-9" align="left">
                          <h4 class="mt-0 mb-30 line-bottom">Go Live Now</h4>
                           <form id="campaign_review"  class="mt-30" method="post" action="campaign-review">
                            <div class="text-justify">
                          <p>Hello, creator! It is assumed you have taken your time to plan and build your campaign before attempting  to go live! Make sure you have saved all your data in all the tabs.  Fifty-five percent of unsuccessful crowdfunding campaigns result from poor planning. Make sure you have written a compelling campaign story, upload your campaign photo,  choosen your deadline wisely, written your campaign tagline,  set you bank account details, and be realistic with you campaign funding goal, etc. There is a 85-90 percent chance that during review your campaign will not be approved if you omitted filling some of these  informations in the tabs above. You can read the  <a class="text-theme-colored" href="resources/CREATORS_HANDBOOK.pdf" download>
  Creators Handbook
</a> if you need further resources on how to create a successful campaign on projectlive. Be aware that you will no longer be able to edit your campaign again after submitting for review or going live. Goodluck on your campaign.   </p></div>
  <input type="hidden" style="visibility: hidden;" name="campaign_id" value="<?php echo $set_campaign_id ?>">
                     
                         <!-- Small modal for verifying creators account using their mobile phones -->
        <a  class="openModal" data-toggle="modal" data-target="#myModal" data-id="<?php echo $user_id;?>" 
          data-cid="<?php echo $set_campaign_id;?>">
          <button type="button" class="btn btn-dark btn-theme-colored">Submit campaign</button>
                       
                    </a>
                  
                        </form>
                </form> 
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
           <div class="modal-dialog modal-sm">
  <div class="modal-content">
       
                  
      </div>
                
  </div>
</div>
             
                        </div>
                      </div>
                    </div>
    </section>
    
            <section>
             <?php include('../includes/campaign-heads-up.php');?>
          <div class="col-sm-12 col-md-3">
            <div class="sidebar sidebar-right mt-sm-30">
              <div class="widget">
                
              </div>
                    <div class="event-count causes clearfix p-15 mt-15 border-left">
              <div class="widget">
              
                <div class="widget">
                <h5 class="widget-title line-bottom"> Campaign Resources</h5>
                <div class="categories">
                  <ul class="list list-border angle-double-right">
                     <li>Creators Handbook  <i> <a class="text-theme-colored" href=""></a> | <a class="text-theme-colored" href="resources/CREATORS_HANDBOOK.pdf" download>
  download
</a></i>
                    
                     </li>
                    <li>6 steps to a successful campaign  <i class="text-theme-colored"> <a target="_blank" class="text-theme-colored" href="../contents/steps-to-a-successful-campaign "> | read</a> 
</a></i>
                    <li>Tips on writing a captivating  story <i><a target="_blank" class="text-theme-colored" href="../contents/writing-a-captivating-story"> | read</a> </i>
                    <li>How to create a catchy campaign title <i> <a target="_blank"class="text-theme-colored" href="../contents/create-a-catchy-campaign-tittle"> | read</a> 
</a></i>
                    <li> Making the most of social media <i><a target="_blank"class="text-theme-colored" href="../contents/how-to-make-the-most-of-social-media"> | read</a> </i>
                  </ul>
                </div>
              </div>
              </div>

              <div class="widget">
              <h5 class="widget-title line-bottom">Campaign Build up preview</h5>
                <p>
             
   <?php // check which to display, photo or video// ?> 
              
              <?php
               $check_video=$database->query("SELECT * FROM `pl_campaign_basics` WHERE `campaign_id`= '{$set_campaign_id}'");
               $check_video=$database->fetch_array($check_video);
              
               if(!empty($check_video['campaign_video_link'])){ 
                $check_video=trim($check_video['campaign_video_link']);?>
               <iframe width="560" height="316" src="https://www.youtube.com/embed/<?php echo $check_video;?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                
                   
         <?php  } 
                    else{
                     echo $campaign_photos::find_thumb_campaign_photo_by_user_id($set_campaign_id, $user_id);
                    }
             
                  ?>
              
  
    <p align="center"><?php echo $campaign_basics->campaign_tittle; ?>
              </p>
                <div class="latest-posts">
                     <div class="widget">
               
            
                    <div class="progress-item mt-20 mb-30">
                      <div class="progress mb-30">
                        
                      </div>
                    </div>
                    <ul class="list-inline clearfix">
                      <li class="pull-left pr-0">Raised: ₦0.00</li>
                      <li class="pull-right pr-0"><i class="fa fa-heart-o text-theme-colored"></i> By 0 Donor(s)</li>
                    </ul>
                    <div class="mt-10">
                      <ul class="pull-left list-inline mt-20">
                        <li class="text-theme-colored pr-0">Goal: <?php echo format_currency($campaign_goal=campaignGoalManager::find_all_campaign_goal_by_campaign_id($set_campaign_id));?></li>
                      </ul>
                      <a class="btn btn-dark btn-flat btn-sm pull-right mt-15">Donate</a>
                    </div>
                  </div>
              </div>
            
                  
                </div>
              
             <br/> <br/>
              <div class="widget">
                <h5 aligh="left" class="widget-title line-bottom">together we can build our communities.</h5>
                <div class="fluid-video-wrapper">
               <iframe width="560" height="316" src="https://www.youtube.com/embed/2hcVfja46Ac" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
              </div>
              </div>
</div>
             
              <div class="widget">
                <h5 class="widget-title line-bottom">DOWNLOAD THE CREATORS HANDBOOK</h5>
                <div id="flickr-feed" class="clearfix">
                  
                
            
 <a class="btn btn-theme-colored btn-flat btn-bordered btn-lg" href="resources/CREATORS_HANDBOOK.pdf" download>CLICK TO DOWNLOAD NOW <i class="fa fa-download ml-10"></i></a>
                 </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
   <script type="text/javascript">
    // modal for verifying ProjectLive Accounts using phone numberss    
  $('.openModal').click(function(){
      var id = $(this).attr('data-id');0
      var cid = $(this).attr('data-cid');0
      $.ajax({url:"verify_account.php?user_id="+id+"&cid="+cid,cache:false,success:function(result){
          $(".modal-content").html(result);
      }});
  });
          </script>
  <script type="text/javascript">
                $(document).ready(function(e) {
                  var $donation_form = $("#creation_form");

                  //toggle campaign video_option
                  var $video_option = $donation_form.find("#video_option");
                  $video_option.hide();
                  $("input[name='campaign_video_flag']").change(function() {
                      if (this.value == '0') {
                          $video_option.show();
                      }
                      else {
                          $video_option.hide();
                      }
                  });


                

                });
              </script>
  <!-- end main-content -->
  <!-- Footer -->
  <?php include ('includes/footer.php') ?>
</body>
</html>
