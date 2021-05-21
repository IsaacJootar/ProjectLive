<?php include ('includes/header-login.php');?>
<?php require_once('includes/config.php'); ?>
<?php require_once('classes/database.php'); ?>
<?php require_once('classes/functions.php'); ?>

<style type="text/css">
body,td,th {
	color: #000000;
}
</style>

  
  <!-- Start main-content -->
  <div class="main-content">
    <!-- Section: inner-header -->
    <section class="inner-header divider layer-overlay overlay-dark" data-bg-img="images/bg/bg2.jpg">
      <div class="container pt-10 pb-10">
        <!-- Section Content -->
        <div class="section-content text-center">
          <div class="row"> 
            <div class="col-md-12  text-center">
              <h2 class="text-white font-26" align="center">Raise funds for creative, charity, entrepreneurial, or any other cause that means alot to you. It is completely free.  </h2>
              
            </div>
          </div>
        </div>
      </div>      
    </section>

     <!-- Section: home -->
    <section id="home">
      <div class="display-table">
        <div class="display-table-cell">
          <div class="container pb-50">
            <div class="row">
              <div class="col-md-7 col-md-push-2">
                <div class="text-center mb-60"></div>
                <div class="bg-lightest border-1px p-25">
               
                  <h4 class="text-theme-colored text-uppercase m-0">Start a Campaign</h4>
                  <div align="center">
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
                    
                    <form id="appointment_form" name="reg_form" class="mt-30" method="post" action="start_">
                    <div class="row">
                    <label>
                     How much money do you want to raise from this campaign?<strong style="color:#F00"></strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Your campaign should have a certain amount of money it wants to raise, this is your target goal. This amount should be realistic and should reflect the project at hand so as not to discourage potential donors"> </i>
                    </label>
                    <div class="col-sm-12">
    <div class="input-group mb-10">
      <div class="input-group-addon">₦</div>
      <input  name="campaign_goal" title="enter goal amount"  type="number" class="form-control" id="InputAmount" placeholder="Amount">
      <div class="input-group-addon">.00</div>
    
    </div> 
    Mininum campaign amount is ₦2000. Don't worry you can change the amount later if you wish</br></br>
    </div>
                      
    <div class="col-sm-12">
                      <div class="form-group mb-10">
                        <label> 
                          <div align="left">Enter Campaign Title<strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Your campaign title should be clear and precise, not too long or too complicated for donors. People often donate to projects they understand. "> </i></div>

                        </label>
                        <div align="left">
                          <input name="campaign_tittle" title="enter campaign tittle" class="form-control" type="text"  placeholder="E.g 'Dairy of a young Lawyer'" required="required">
                        </div>
                      </div>
                      </div>
    <div align="left"></br></br>
      </br>
   
    </div>
     <div class="col-sm-12">
                        <div class="form-group mb-10">
                        <label> Select Campaign Category:</label><strong style="color:#F00">*</strong> <i class="fa fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Every campaign should fall under a category, example a campaign for hospital bills or related issues may fall under medical category."> </i>
                          <select  name="campaign_category" class="form-control" id="cat">
                            <?php 
                            global $database; 
                            $query=$database->query("SELECT `category` 
                              FROM `pl_campaign_categories`");
                        while($category=$database->fetch_array($query)) {
                          
                          
                       
                                 echo '<option>';
                            
                              
                               echo $category['category'];
                             } ?></option>
                           
                            
                            </select>
                        </div>
                      </div>
                    
                    </div>
                   
                    <div class="form-group mb-0 mt-1">
                      <button type="submit" class="btn btn-dark btn-theme-colored" data-loading-text="Please wait...">Save and continue</button>
                    </div>
                  </form>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- end main-content -->


<!-- end wrapper -->

<!-- Footer Scripts -->
<!-- JS | Custom script for all pages -->
<script src="js/custom.js"></script>

</body>

<!-- Mirrored from kodesolution.com/demo/nonprofit/charity/charityfund-html/v3.1/demo/form-appointment-style3.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 13 Sep 2016 13:00:18 GMT -->
</html>