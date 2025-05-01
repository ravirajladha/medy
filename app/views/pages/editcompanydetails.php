<?php require APPROOT . '/views/inc/header.php'; ?>

            <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">Company Details</h4>
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


                <br><br>
            <div class="contentbar">
                <div class="card">
                    <div class="card-body">
                        <h5>Edit Company Details</h5>
                        <hr>
                          <?php $com = $data['company']; ?>
                        <form action="<?php echo URLROOT; ?>/pages/updatecompanydetails" method="POST">
                             <input type="text" name="id" value="<?php echo $com->id;?>" style="display: none;"> 
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" placeholder="Company Name" name="name" autocomplete="off" required value="<?php echo $com->name  ?>">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Company Email</label>
                                    <input type="email" class="form-control" placeholder="Company Email" name="email" autocomplete="off" required value="<?php echo $com->email  ?>">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" placeholder="street1" name="street1" autocomplete="off" required><?php echo $com->street1 ?></textarea>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" placeholder="street2" name="street2"><?php echo $com->street2 ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" placeholder="" name="city" autocomplete="off" required value="<?php echo $com->city ?>">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>State</label>
                                    <select id="state" class="form-control" name="state" autocomplete="off" required>
                                        <option selected value="<?php echo $com->state; ?>"><?php echo $com->state; ?></option>
                                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                        <option value="Assam">Assam</option>
                                        <option value="Bihar">Bihar</option>
                                        <option value="Chandigarh">Chandigarh</option>
                                        <option value="Chhattisgarh">Chhattisgarh</option>
                                        <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                                        <option value="Daman and Diu">Daman and Diu</option>
                                        <option value="Delhi">Delhi</option>
                                        <option value="Lakshadweep">Lakshadweep</option>
                                        <option value="Puducherry">Puducherry</option>
                                        <option value="Goa">Goa</option>
                                        <option value="Gujarat">Gujarat</option>
                                        <option value="Haryana">Haryana</option>
                                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                        <option value="Jharkhand">Jharkhand</option>
                                        <option value="Karnataka">Karnataka</option>
                                        <option value="Kerala">Kerala</option>
                                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                                        <option value="Maharashtra">Maharashtra</option>
                                        <option value="Manipur">Manipur</option>
                                        <option value="Meghalaya">Meghalaya</option>
                                        <option value="Mizoram">Mizoram</option>
                                        <option value="Nagaland">Nagaland</option>
                                        <option value="Odisha">Odisha</option>
                                        <option value="Punjab">Punjab</option>
                                        <option value="Rajasthan">Rajasthan</option>
                                        <option value="Sikkim">Sikkim</option>
                                        <option value="Tamil Nadu">Tamil Nadu</option>
                                        <option value="Telangana">Telangana</option>
                                        <option value="Tripura">Tripura</option>
                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                        <option value="Uttarakhand">Uttarakhand</option>
                                        <option value="West Bengal">West Bengal</option>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Country</label>
                                    <select class="form-control" id="formControlSelect" name="country" autocomplete="off" required>
                                        <option value="<?php echo $com->country ?>"><?php echo $com->country ?></option>
                                        <option>India</option>
                                        <option>Australia</option>
                                        <option>Belgium</option>
                                        <option>Canada</option>
                                        <option>Germany</option>
                                        <option>U.S.A</option>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Zip Code</label>
                                    <input type="text" class="form-control" placeholder=" " name="zip_code" autocomplete="off" value="<?php echo $com->zip_code ?>">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" placeholder="" name="phone" value="<?php echo $com->phone ?>">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Fax</label>
                                    <input type="text" class="form-control" placeholder="" name="fax" value="<?php echo $com->fax ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                
                                    
                                
                                    <input type="text" name="id" value="<?php echo $com->id; ?>" style="display:none" />
                                    <a href="<?php echo URLROOT;?>/pages/all_companydetails"><button name="update_company" class="btn btn-primary" type="submit">update</button></a>
                              
                            </div>

                        </form>

                    </div>
                </div>
            </div>
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
