 <?php ob_start(); ?>
<?php session_start(); ?>
<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); 
// put these guys in a function later. //
if(!isset($_SESSION['SESS_USER'])){
  include ('includes/header.php');
  } else {
   include ('includes/header-login.php');  
}
    ?>


  
  <!-- Start main-content -->
    <br><br><br>
  <div class="main-content">
    <!-- Section: inner-header -->
    <section class="inner-header divider layer-overlay overlay-dark">
      <div>
        <!-- Section Content -->
        <div class="section-content text-center">
          <div class="row"> 
            <div class="col-md-12  text-center">
              <h2 class="text-white font-34" align="center">Trust And Safety</h2>
              
            </div>
          </div>
        </div>
      </div>      
    </section>

 <p><div class= "text-center">            
            <div><p>
             Trust is essential in every type of relationship, and because Projectlive understands this, we believe in building trusting relationships with everyone who interacts on our platform – those who look to raise funds and others who choose to make pledges; because we care about you, trust and safety are our watchwords. 
We are committed to making sure that our website is safe for all customers to use. Your trust is especially important to us, therefore we provide the safety you need to have a positive experience with us at Projectlive. <p>
Our Trust and Safety Team bears the responsibility of doing all they can to prevent fraud on the platform so that we can keep you safe. Some of the safety measures we employ include manual and automated reviews of campaigns, and working closely with payment processors to guarantee that your funds are processed securely, thoroughly and effectively. We also monitor the information we collect online and protect them from unauthorized access.<p>
The Team also scrutinizes real time feedback from our community and partners. Our campaign owners are held accountable for the identity information they provide, and are expected to communicate regularly with their backers. At Projectlive, we do not allow any abuse of our system; we take necessary action at all times to maintain the integrity of our platform. <p>
Campaign creators are equipped with the tools to create and deliver a successful project, and to also keep their community of supporters abreast with the progress of the project including when things are not going exactly as planned. On the other hand, campaign supporters – donors are provided with the basic information and tools needed to decide whether or not to back a campaign. And because trust is a two-way street, we expect that everyone complies with our Terms of Use and keep the communication open and honest. This way we can build and maintain trust between Projectlive and every member of our community. 

              <P>
            
            </div>
  <!-- end main-content -->
   <!-- Footer -->
  <?php include('includes/footer.php'); ?>
</body>
</html>