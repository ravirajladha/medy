<?php require APPROOT . '/views/inc/header.php'; ?>

            <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">New Distributor</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                             
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                             
                        </div>                        
                    </div>
                </div>          
            </div>
            <?php $cust = $data['distributor']; ?>
            <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->
            <form action="<?php echo URLROOT; ?>/pages/update_distributor" method="POST" >   
            <input type="text" name="id" value="<?php echo $cust->id;?>" style="display: none;">  
            <div class="contentbar">
                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6">
                        <div class="card m-b-30">
                            
                            <div class="card-body">
                                    

                                    <div class="form-group">
                                        <label >Primary Contact</label>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <select class="form-control" id="formControlSelect" name="salutation">
                                                    <option selected=""><?php echo $cust->distributor_sa;?></option>
                                                    <option>Salutation</option>
                                                    <option>Mr.</option>
                                                     <option>Mrs.</option>
                                                     <option>Ms.</option>
                                                     <option>Miss.</option>
                                                     <option>Dr.</option> 
                                                 </select>
                                            </div>
                                             <div class="col-md-4">
                                                <input type="text" class="form-control" placeholder="First Name" name="f_name" value="<?php echo $cust->distributor_first_name;?>">
                                             </div>
                                             <div class="col-md-4 form-group">
                                                 <input type="text" class="form-control" placeholder="Last Name" name="l_name" value="<?php echo $cust->distributor_last_name;?>">
                                             </div>
                                         </div>
                                   
                                    </div>

                                     <div class="form-group">
                                        <label >Distributor Name</label>
                                         <input type="text" class="form-control" placeholder="" name="distributor_name" value="<?php echo $cust->distributor_name;?>">
                                       
                                    </div>
                               
                                    
                                     <div class="form-group">
                                        <label >Distributor Display Name</label>
                                        <input type="text" class="form-control" placeholder="" name="c_display_name" value="<?php echo $cust->distributor_display_name;?>">
                                    </div>
                                   
                                   
                                   
                            </div>
                        </div>
                    </div> 
                    <!-- End col -->
                    <!-- Start col -->
                    <div class="col-lg-6">
                        <div class="card m-b-30">
                            
                            <div class="card-body">
                                   
                                      <div class="form-group">
                                        <label >Distributor Email</label>
                                        <input type="email" class="form-control" placeholder="" name="c_email" value="<?php echo $cust->distributor_email;?>">
                                    </div>


                                     <div class="form-group">
                                        <label >Distributor Phone Number</label>
                                        <div class="row">
                                            
                                             <div class="col-md-6">
                                                <input type="number" class="form-control" placeholder="Home" name="Distributor_home_phone" value="<?php echo $cust->distributor_phno_home;?>">
                                             </div>
                                             <div class="col-md-6 form-group">
                                                 <input type="number" class="form-control" placeholder="Work" name="Distributor_work_phone" value="<?php echo $cust->distributor_phno_work;?>">
                                             </div>
                                         </div>
                                    </div>

                                    <div class="form-group">
                                        <label >Website</label>
                                        <input type="text" class="form-control" name="website" value="<?php echo $cust->distributor_website;?>">
                                    </div>
                                   
                                   
                            </div>
                        </div>
                    </div> 
                    <!-- End col -->
                    
              
                    <!-- Start col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="card m-b-30">
                            
                            <div class="card-body">
                               
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Other Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Address</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact Persons</a>
                                    </li>


                                 <!--  <li class="nav-item">
                                        <a class="nav-link " id="pills-home-tab1" data-toggle="pill" href="#pills-home1" role="tab" aria-controls="pills-home1" aria-selected="true">Receivable</a>
                                    </li> -->
                                    <!--   <li class="nav-item">
                                        <a class="nav-link" id="pills-profile-tab1" data-toggle="pill" href="#pills-profile1" role="tab" aria-controls="pills-profile1" aria-selected="false">Reporting Tags</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-contact-tab1" data-toggle="pill" href="#pills-contact1" role="tab" aria-controls="pills-contact1" aria-selected="false">Remarks</a>
                                    </li> -->
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6">
                        <div class="card m-b-30">
                            <div class="card-body">
                                    <div class="form-group">
                                        <label >Currency*</label>
                                        <input type="text" class="form-control" placeholder="Currency" name="currency" value="<?php echo $cust->currency;?>">
                                       
                                    </div>
                                      <div class="form-group">
                                        <label >Payment Terms</label>
                                        <input type="text" class="form-control" placeholder="Payment Terms" name="payment_terms" value="<?php echo $cust->payment_terms;?>">
                                       
                                    </div>
                                   
                                    
                            </div>
                        </div>
                    </div> 
                    <!-- End col -->
                     <!-- Start col -->
                    <div class="col-lg-6">
                        <div class="card m-b-30">
                            <div class="card-body">
                                   
                                      <div class="form-group">
                                        <label >Facebook</label>
                                        <input type="text" class="form-control" placeholder="Facebook" name="facebook" value="<?php echo $cust->facebook;?>">
                                  
                                    </div>
                                    <div class="form-group">
                                        <label >Twitter</label>
                                        <input type="text" class="form-control" placeholder="Twitter" name="twitter" value="<?php echo $cust->twitter;?>">
                                      
                                    </div>
                                    
                            </div>
                        </div>
                    </div> 
                    <!-- End col -->
                </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

            <div class="row">
               
                    <!-- Start col -->
                    <div class="col-lg-6">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <label> Billing Address</label>
                                    <div class="form-group">
                                        <label >Attention</label>
                                        <input type="text" class="form-control" placeholder="" name="attention" value="<?php echo $cust->b_attention;?>">
                                       
                                    </div>
                                      <div class="form-group">
                                        <label >Country</label>
                                        <select class="form-control" id="formControlSelect" name="country">
                                                <option selected=""><?php echo $cust->b_country;?></option>
                                                <option>India</option>
                                                <option>Australia</option>
                                                <option>Belgium</option>
                                                <option>Canada</option>
                                                <option>Germany</option>
                                                <option>U.S.A</option> 
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label >Address</label>
                                        <textarea class="form-control" placeholder="street1" name="street1"><?php echo $cust->b_street1;?></textarea>
                                        <br>
                                        <textarea class="form-control"  placeholder="street2" name="street2"><?php echo $cust->b_street2;?></textarea>
                                       
                                    </div>
                                    <div class="form-group">
                                        <label >City</label>
                                        <input type="text" class="form-control" placeholder="" name="city" value="<?php echo $cust->b_city;?>">
                                       
                                    </div>
                                   <div class="form-group">
                                        <label >State</label>
                                        <input type="text" class="form-control" placeholder="" name="state" value="<?php echo $cust->b_state;?>">
                                       
                                    </div>
                                   <div class="form-group">
                                        <label >Zip Code</label>
                                        <input type="text" class="form-control" placeholder=" " name="zip_code" value="<?php echo $cust->b_zip_code;?>">
                                       
                                    </div>
                                   <div class="form-group">
                                        <label >Phone</label>
                                        <input type="text" class="form-control" placeholder="" name="phone" value="<?php echo $cust->b_phone;?>">
                                       
                                    </div>
                                   <div class="form-group">
                                        <label >Fax</label>
                                        <input type="text" class="form-control" placeholder="" name="fax" value="<?php echo $cust->b_fax;?>">
                                       
                                    </div>
                                   
                                    
                            </div>
                        </div>
                    </div> 
                    <!-- End col -->
                     <!-- Start col -->
                    <div class="col-lg-6">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <label> Shipping Address &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;  <a href="">Copy</a></label>
                                    <div class="form-group">
                                        <label >Attention</label>
                                        <input type="text" class="form-control" placeholder="" name="cp_attention" value="<?php echo $cust->s_attention;?>">
                                       
                                    </div>
                                      <div class="form-group">
                                        <label >Country</label>
                                        <select class="form-control" id="formControlSelect" name="cp_country">
                                                    <option><?php echo $cust->s_country;?></option>
                                                    <option>India</option>
                                                    <option>Australia</option>
                                                     <option>Belgium</option>
                                                     <option>Canada</option>
                                                     <option>Germany</option>
                                                     <option>U.S.A</option> 
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label >Address</label>
                                        <textarea class="form-control" placeholder="street1" name="cp_street1"><?php echo $cust->s_street1;?></textarea>
                                        <br>
                                        <textarea class="form-control"  placeholder="street2" name="cp_street2"><?php echo $cust->s_street2;?></textarea>
                                       
                                    </div>
                                    <div class="form-group">
                                        <label >City</label>
                                        <input type="text" class="form-control" placeholder="" name="cp_city" value="<?php echo $cust->s_city;?>">
                                       
                                    </div>
                                   <div class="form-group">
                                        <label >State</label>
                                        <input type="text" class="form-control" placeholder="" name="cp_state" value="<?php echo $cust->s_state;?>">
                                       
                                    </div>
                                   <div class="form-group">
                                        <label >Zip Code</label>
                                        <input type="text" class="form-control" placeholder=" " name="cp_zip_code" value="<?php echo $cust->s_zip_code;?>">
                                       
                                    </div>
                                   <div class="form-group">
                                        <label >Phone</label>
                                        <input type="text" class="form-control" placeholder="" name="cp_phone" value="<?php echo $cust->s_phone;?>">
                                       
                                    </div>
                                   <div class="form-group">
                                        <label >Fax</label>
                                        <input type="text" class="form-control" placeholder="" name="cp_fax" value="<?php echo $cust->s_fax;?>">
                                       
                                    </div>
                                   
                                    
                            </div>
                        </div>
                    </div> 
                    <!-- End col -->
                   
                    
                </div>   
                                    </div>

                                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                        <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="edit-click">
                                        <thead>
                                            <tr>
                                                <th>Salutaion</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email Address</th>
                                                <th>Work Phone</th>
                                                <th>Mobile</th>                                    
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                              <td><select class="form-control" id="formControlSelect" name="cp_salutation">
                                                <option selected=""><?php echo $cust->cp_salut;?></option>
                                                    <option>Salutation</option>
                                                    <option>Mr.</option>
                                                     <option>Mrs.</option>
                                                     <option>Ms.</option>
                                                     <option>Miss.</option>
                                                     <option>Dr.</option> 
                                                 </select></td>
                                                <td><input type="text" class="form-control" name="cp_f_name" value="<?php echo $cust->cp_first_name;?>"></td>
                                                <td><input type="text" class="form-control" name="cp_l_name" value="<?php echo $cust->cp_last_name;?>"></td>
                                                <td><input type="text" class="form-control" name="cp_email" value="<?php echo $cust->cp_email;?>"></td>
                                                <td><input type="text" class="form-control" name="cp_working_phone" value="<?php echo $cust->cp_work_phone;?>"></td>
                                                <td><input type="text" class="form-control" name="cp_mobile" value="<?php echo $cust->cp_mobile;?>"></td>
                                          </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->

                                    </div>

                                     <!-- <div class="tab-pane fade show " id="pills-home1" role="tabpanel" aria-labelledby="pills-home-tab1">
                                       <label >Receivables Amount</label>
                                       <input type="number" class="form-control" name="receivables">
                                    </div> -->
                                    <div class="tab-pane fade" id="pills-profile1" role="tabpanel" aria-labelledby="pills-profile-tab1">
                                        <p>NO Record Found</p>
                                    </div>
                                    <div class="tab-pane fade" id="pills-contact1" role="tabpanel" aria-labelledby="pills-contact-tab1">
                                        <label >Remarks (For Internal Use)</label>
                                        <textarea class="form-control" ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->

                      </div>  

                      <div class="row">
                    <div class="col-lg-12">

                        <a href="<?php echo URLROOT;?>/pages/index"><button class="btn btn-primary" style="float: right; margin-left: 10px;">Cancle</button></a>
                        <a href="<?php echo URLROOT;?>/pages/all_customer"><button class="btn btn-primary" style="float: right;">Save</button></a>
                    </div><!-- End row -->
                </div><br>
            </div>
        </form>
            <!-- End Contentbar -->
 <script type="text/javascript">
    $(".chb").change(function() {
    $(".chb").prop('checked', false);
    $(this).prop('checked', true);
});
 </script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>