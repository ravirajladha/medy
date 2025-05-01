<?php require APPROOT . '/views/inc_patient/header1.php'; ?>
<section class="bg_gradiant_custom software_home_extra_p" id="home" style="padding-top: 75px;">    </section>

  
  
   <section class="section_all " id="contact">
            <div class="container">
               


                <!-- <div class="container"> -->
                    <div class="row">
                        <div class="col-md-3">
                            
                        </div>
                         <div class="col-md-6">
                             <div class="buss_form_custom mx-auto bg-white mt-3">
                                 <div class="row" style="padding-bottom: 25px;">
                    <div class="col-lg-12">
                        <div class="section_title_all text-center">
                            <h3 class="font-weight-bold"><img style="width: 150px;" src="<?php echo URLROOT ?>/p/images/medhike_logo.png" alt="" class="img-fluid logo-dark"><br><br><span class="text-custom">Sign In</span></h3>
                            <p class="section_subtitle mx-auto text-muted"><!-- It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. --> </p>
                            <div class="section_subtitle_border mx-auto"></div>
                        </div>
                    </div>
                </div>

                            <form action="<?php echo URLROOT;?>/patients/login" method="post">
                                <!-- <div class="row"> -->
                                    
                                    <div class="col-lg-12">
                                        <div class="form-group mt-2">
                                            <input name="username" id="email" type="text" class="form-control" placeholder="Username" required="">
                                        </div>
                                    </div>
                                <!-- </div> -->
                                <!-- <div class="row"> -->
                                    <div class="col-lg-12">
                                        <div class="form-group mt-2">
                                            <input type="password" class="form-control" name="password" id="subject" placeholder="Password" required="">
                                        </div>
                                    </div>
                                <!-- </div> -->
                               
                             <center>
                                    <div class="col-lg-4 text-center">
                                        <input type="submit" id="submit" name="send" class="btn btn_custom w-100" value="Login">
                                    </div></center>
                                
                            </form>
                        </div>
                            
                        </div>
                         <div class="col-md-3">
                            
                        </div>
                        
                    </div>
                    
                <!-- </div> -->

            </div>
        </section>

<?php require APPROOT . '/views/inc_patient/footer1.php'; ?>