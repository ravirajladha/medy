<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Manage Details</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="contentbar">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <a href="<?php echo URLROOT; ?>/pages/all_types"><button class="btn btn-link pull-right">All Types</button></a>
                    <h5>Type</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_type" method="POST">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Type</label>
                                <input type="text" class="form-control" placeholder="Enter Type" name="type">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <h5>Add Model </h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_model" method="POST">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Type </label>
                                    <select name="tid" id="" class="form-control">
                                        <?php
                                        foreach ($data['type'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->type_id; ?>"><?php echo $key->type_name; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Model Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Name" name="mname">
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-12 row">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                   <!--  <a href="<?php echo URLROOT; ?>/pages/all_subcategories2"><button class="btn btn-link pull-right">All categories</button></a> -->
                    <h5>Add category</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_category_new" method="POST">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Type</label>
                                    <select name="tid" id="" class="form-control" onchange="categoryChange8(this.value)">
                                        <option selected="" disabled="">--select--</option>
                                        <?php foreach ($data['type'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->type_id; ?>"><?php echo $key->type_name ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Model</label>
                                    
                                    <select name="mid" id="model81" class="form-control" onclick="categoryChange5(this.value)">
                                        <option selected="" disabled="">--select--</option>
                                       <!--  <?php foreach ($data['cat1'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->sc_id; ?>"><?php echo $key->sc_name ?></option>
                                        <?php
                                        } ?> -->
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Category Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Category Name" name="ccname">
                                </div>
                            </div>
                            

                        </div>
                        <div class="col-md-12 row">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <!-- <a href="<?php echo URLROOT; ?>/pages/all_subcategories2"><button class="btn btn-link pull-right">All Subcategories</button></a> -->
                    <h5>Add Subcategory</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_subcategory_new" method="POST">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Type</label>
                                    <select name="tid" id="" class="form-control" onchange="categoryChange4(this.value)">
                                        <option selected="" disabled="">--select--</option>
                                        <?php foreach ($data['type'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->type_id; ?>"><?php echo $key->type_name ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Model</label>
                                    
                                    <select name="mid" id="model1" class="form-control" onclick="categoryChange5(this.value)">
                                        <option selected="" disabled="">--select--</option>
                                       <!--  <?php //foreach ($data['cat1'] as $key) {
                                        ?>
                                            <option value="<?php //echo $key->sc_id; ?>"><?php //echo $key->sc_name ?></option>
                                        <?php
                                        //} ?> -->
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="ccid" id="category_new" class="form-control" onclick="categoryChange6(this.value)">
                                        
                                       <!--  <?php //foreach ($data['cat2'] as $key) {
                                        ?>
                                            <option value="<?php //echo $key->sc2_id; ?>"><?php //echo $key->sc2_name ?></option>
                                        <?php
                                        //} ?> -->
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">SubCategory Name</label>
                                    <input type="text" class="form-control" placeholder="Enter SubCategory Name" name="scname1">
                                </div>
                            </div>
                           
                        </div>
                        <div class="col-md-12 row">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <a href="<?php echo URLROOT; ?>/pages/all_size"><button class="btn btn-link pull-right">All Size</button></a>
                    <h5>Size</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_size" method="POST">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Size</label>
                                <input type="text" class="form-control" placeholder="Enter Size" name="size">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <a href="<?php echo URLROOT; ?>/pages/all_color"><button class="btn btn-link pull-right">All Color</button></a>
                    <h5>Color</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_color" method="POST">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Color</label>
                                <input type="text" class="form-control" placeholder="Enter Color" name="color">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <a href="<?php echo URLROOT; ?>/pages/all_manufacturer"><button class="btn btn-link pull-right">All Manufacturer</button></a>
                    <h5>Manufacturer</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_manufacturer" method="POST">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Manufacturer</label>
                                <input type="text" class="form-control" placeholder="Enter Manufacturer Name" name="manufacturer">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- old -->
<div class="contentbar">
    <!-- <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <a href="<?php echo URLROOT; ?>/pages/all_categories"><button class="btn btn-link pull-right">All Main Categories</button></a>
                    <h5>Main Category</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_category" method="POST">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Main Category Name</label>
                                <input type="text" class="form-control" placeholder="Enter Name" name="cName">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->
<!-- </div>
<div class="contentbar"> -->
    <!-- <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <a href="<?php echo URLROOT; ?>/pages/all_subcategories"><button class="btn btn-link pull-right">All Primary categories</button></a>
                    <h5>Add Primary category</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_subcategory" method="POST">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Primary category Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Name" name="sCName">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Main Category Name</label>
                                    <select name="cId" id="" class="form-control">
                                        <?php
                                        foreach ($data['cat'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->category_id; ?>"><?php echo $key->category_name; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->
    <!-- </div>
<div class="contentbar"> -->
    <!-- <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <a href="<?php echo URLROOT; ?>/pages/all_subcategories2"><button class="btn btn-link pull-right">All Secondary categories</button></a>
                    <h5>Add Secondary category</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_subcategory2" method="POST">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Secondary category Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Name" name="sCName2">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Primary Category Name</label>
                                    <select name="cId2" id="" class="form-control">
                                        <?php
                                        foreach ($data['cat2'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->sc_id; ?>"><?php echo $key->sc_name; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->
    <!-- </div>
<div class="contentbar"> -->
    <!-- <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <a href="<?php echo URLROOT; ?>/pages/all_subcategories3"><button class="btn btn-link pull-right">All Tertiary categories</button></a>
                    <h5>Add Tertiary category</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_subcategory3" method="POST">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">tertiary category Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Name" name="sCName3">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Secondary Category Name</label>
                                    <select name="cId3" id="" class="form-control">
                                        <?php
                                        foreach ($data['cat3'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->sc2_id; ?>"><?php echo $key->sc2_name; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->
    <!-- </div>
<div class="contentbar"> -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <a href="<?php echo URLROOT; ?>/pages/all_positions"><button class="btn btn-link pull-right">All Positions</button></a>
                    <h5>Add Positions</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_positions" method="POST">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Position Code</label>
                                    <input type="text" class="form-control" placeholder="Enter Code" name="posCode">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Complete Position Detail</label>
                                    <textarea name="posDetails" id="" class="form-control" placeholder="Enter Position"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- </div>
<div class="contentbar"> -->


   <!--  <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <a href="<?php echo URLROOT; ?>/pages/all_tax"><button class="btn btn-link pull-right">All Tax</button></a>
                    <h5>Add Tax</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_tax" method="POST">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Enter Tax</label>
                                <input type="number" class="form-control" placeholder="Enter tax" name="tax" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->

    
    <!-- </div>
<div class="contentbar"> -->
   <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <!-- <div class="card-body">
                    <h5>Add Company Details</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_company_details" method="POST">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Enter Tax</label>
                            <input type="number" class="form-control" placeholder="Enter tax" name="tax" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                    </form>
                </div> -->
                <?php $comp = $data['comp_details']; ?>
                <div class="card-body">
                    <a href="<?php echo URLROOT; ?>/pages/all_companydetails"><button class="btn btn-link pull-right">All Company details</button></a>
                    <h5>Manage Company Details</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_company_details" method="POST">
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label>Company Name</label>
                                <input type="text" class="form-control" placeholder="Company Name" name="name" autocomplete="off" required value="">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Company Email</label>
                                <input type="email" class="form-control" placeholder="Company Email" name="email" autocomplete="off" required value="">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Address</label>
                                <textarea class="form-control" placeholder="street1" name="street1" autocomplete="off" required></textarea>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Address</label>
                                <textarea class="form-control" placeholder="street2" name="street2"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label>City</label>
                                <input type="text" class="form-control" placeholder="" name="city" autocomplete="off" required value="">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>State</label>
                                <select id="state" class="form-control" name="state" autocomplete="off" required>
                                    <option value=""></option>
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
                                    <option value=""></option>
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
                                <input type="text" class="form-control" placeholder=" " name="zip_code" autocomplete="off" value="">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" placeholder="" name="phone" value="">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Fax</label>
                                <input type="text" class="form-control" placeholder="" name="fax" value="">
                            </div>
                        </div>
                        <div class="col-md-12">
                                <button name="add_company" class="btn btn-primary" type="submit">Submit</button>
                                <input type="text" name="id" value="<?php echo $comp->id; ?>" style="display:none" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <a href="<?php echo URLROOT; ?>/pages/all_transportdetails"><button class="btn btn-link pull-right">All Transport details</button></a>
                    <h5>Manage Transport Details</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/add_transport_details" method="POST">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>LR Number</label>
                                <input type="text" class="form-control" placeholder="LR Number" name="lr_number" autocomplete="off" value="">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" name="name" autocomplete="off" required value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Details</label>
                                <textarea class="form-control" placeholder="Details" name="details" autocomplete="off" value=""></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button name="add_company" class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php if (isset($_SESSION['success'])) { ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php }
unset($_SESSION['success']); ?>
<?php
if (isset($_SESSION['checkForCategory'])) {
    unset($_SESSION['checkForCategory']);
?>
    <script>
        swal('Category name already exists.');
    </script>
<?php
}
?>
<?php
if (isset($_SESSION['successForCategory'])) {
    unset($_SESSION['successForCategory']);
?>
    <script>
        swal('Category added Successfully.');
    </script>
<?php
}
?>

<?php
if (isset($_SESSION['checkForTheSubCategory'])) {
    unset($_SESSION['checkForTheSubCategory']);
?>
    <script>
        swal('Sub Category name already exists.');
    </script>
<?php
}
?>
<?php
if (isset($_SESSION['sessionForTheSubCategory'])) {
    unset($_SESSION['sessionForTheSubCategory']);
?>
    <script>
        swal('Sub Category added Successfully.');
    </script>
<?php
}
?>
                    <!--<select>
                                <option value="AF">Afghanistan</option>
                                <option value="AX">Åland Islands</option>
                                <option value="AL">Albania</option>
                                <option value="DZ">Algeria</option>
                                <option value="AS">American Samoa</option>
                                <option value="AD">Andorra</option>
                                <option value="AO">Angola</option>
                                <option value="AI">Anguilla</option>
                                <option value="AQ">Antarctica</option>
                                <option value="AG">Antigua and Barbuda</option>
                                <option value="AR">Argentina</option>
                                <option value="AM">Armenia</option>
                                <option value="AW">Aruba</option>
                                <option value="AU">Australia</option>
                                <option value="AT">Austria</option>
                                <option value="AZ">Azerbaijan</option>
                                <option value="BS">Bahamas</option>
                                <option value="BH">Bahrain</option>
                                <option value="BD">Bangladesh</option>
                                <option value="BB">Barbados</option>
                                <option value="BY">Belarus</option>
                                <option value="BE">Belgium</option>
                                <option value="BZ">Belize</option>
                                <option value="BJ">Benin</option>
                                <option value="BM">Bermuda</option>
                                <option value="BT">Bhutan</option>
                                <option value="BO">Bolivia, Plurinational State of</option>
                                <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                <option value="BA">Bosnia and Herzegovina</option>
                                <option value="BW">Botswana</option>
                                <option value="BV">Bouvet Island</option>
                                <option value="BR">Brazil</option>
                                <option value="IO">British Indian Ocean Territory</option>
                                <option value="BN">Brunei Darussalam</option>
                                <option value="BG">Bulgaria</option>
                                <option value="BF">Burkina Faso</option>
                                <option value="BI">Burundi</option>
                                <option value="KH">Cambodia</option>
                                <option value="CM">Cameroon</option>
                                <option value="CA">Canada</option>
                                <option value="CV">Cape Verde</option>
                                <option value="KY">Cayman Islands</option>
                                <option value="CF">Central African Republic</option>
                                <option value="TD">Chad</option>
                                <option value="CL">Chile</option>
                                <option value="CN">China</option>
                                <option value="CX">Christmas Island</option>
                                <option value="CC">Cocos (Keeling) Islands</option>
                                <option value="CO">Colombia</option>
                                <option value="KM">Comoros</option>
                                <option value="CG">Congo</option>
                                <option value="CD">Congo, the Democratic Republic of the</option>
                                <option value="CK">Cook Islands</option>
                                <option value="CR">Costa Rica</option>
                                <option value="CI">Côte d'Ivoire</option>
                                <option value="HR">Croatia</option>
                                <option value="CU">Cuba</option>
                                <option value="CW">Curaçao</option>
                                <option value="CY">Cyprus</option>
                                <option value="CZ">Czech Republic</option>
                                <option value="DK">Denmark</option>
                                <option value="DJ">Djibouti</option>
                                <option value="DM">Dominica</option>
                                <option value="DO">Dominican Republic</option>
                                <option value="EC">Ecuador</option>
                                <option value="EG">Egypt</option>
                                <option value="SV">El Salvador</option>
                                <option value="GQ">Equatorial Guinea</option>
                                <option value="ER">Eritrea</option>
                                <option value="EE">Estonia</option>
                                <option value="ET">Ethiopia</option>
                                <option value="FK">Falkland Islands (Malvinas)</option>
                                <option value="FO">Faroe Islands</option>
                                <option value="FJ">Fiji</option>
                                <option value="FI">Finland</option>
                                <option value="FR">France</option>
                                <option value="GF">French Guiana</option>
                                <option value="PF">French Polynesia</option>
                                <option value="TF">French Southern Territories</option>
                                <option value="GA">Gabon</option>
                                <option value="GM">Gambia</option>
                                <option value="GE">Georgia</option>
                                <option value="DE">Germany</option>
                                <option value="GH">Ghana</option>
                                <option value="GI">Gibraltar</option>
                                <option value="GR">Greece</option>
                                <option value="GL">Greenland</option>
                                <option value="GD">Grenada</option>
                                <option value="GP">Guadeloupe</option>
                                <option value="GU">Guam</option>
                                <option value="GT">Guatemala</option>
                                <option value="GG">Guernsey</option>
                                <option value="GN">Guinea</option>
                                <option value="GW">Guinea-Bissau</option>
                                <option value="GY">Guyana</option>
                                <option value="HT">Haiti</option>
                                <option value="HM">Heard Island and McDonald Islands</option>
                                <option value="VA">Holy See (Vatican City State)</option>
                                <option value="HN">Honduras</option>
                                <option value="HK">Hong Kong</option>
                                <option value="HU">Hungary</option>
                                <option value="IS">Iceland</option>
                                <option value="IN">India</option>
                                <option value="ID">Indonesia</option>
                                <option value="IR">Iran, Islamic Republic of</option>
                                <option value="IQ">Iraq</option>
                                <option value="IE">Ireland</option>
                                <option value="IM">Isle of Man</option>
                                <option value="IL">Israel</option>
                                <option value="IT">Italy</option>
                                <option value="JM">Jamaica</option>
                                <option value="JP">Japan</option>
                                <option value="JE">Jersey</option>
                                <option value="JO">Jordan</option>
                                <option value="KZ">Kazakhstan</option>
                                <option value="KE">Kenya</option>
                                <option value="KI">Kiribati</option>
                                <option value="KP">Korea, Democratic People's Republic of</option>
                                <option value="KR">Korea, Republic of</option>
                                <option value="KW">Kuwait</option>
                                <option value="KG">Kyrgyzstan</option>
                                <option value="LA">Lao People's Democratic Republic</option>
                                <option value="LV">Latvia</option>
                                <option value="LB">Lebanon</option>
                                <option value="LS">Lesotho</option>
                                <option value="LR">Liberia</option>
                                <option value="LY">Libya</option>
                                <option value="LI">Liechtenstein</option>
                                <option value="LT">Lithuania</option>
                                <option value="LU">Luxembourg</option>
                                <option value="MO">Macao</option>
                                <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                                <option value="MG">Madagascar</option>
                                <option value="MW">Malawi</option>
                                <option value="MY">Malaysia</option>
                                <option value="MV">Maldives</option>
                                <option value="ML">Mali</option>
                                <option value="MT">Malta</option>
                                <option value="MH">Marshall Islands</option>
                                <option value="MQ">Martinique</option>
                                <option value="MR">Mauritania</option>
                                <option value="MU">Mauritius</option>
                                <option value="YT">Mayotte</option>
                                <option value="MX">Mexico</option>
                                <option value="FM">Micronesia, Federated States of</option>
                                <option value="MD">Moldova, Republic of</option>
                                <option value="MC">Monaco</option>
                                <option value="MN">Mongolia</option>
                                <option value="ME">Montenegro</option>
                                <option value="MS">Montserrat</option>
                                <option value="MA">Morocco</option>
                                <option value="MZ">Mozambique</option>
                                <option value="MM">Myanmar</option>
                                <option value="NA">Namibia</option>
                                <option value="NR">Nauru</option>
                                <option value="NP">Nepal</option>
                                <option value="NL">Netherlands</option>
                                <option value="NC">New Caledonia</option>
                                <option value="NZ">New Zealand</option>
                                <option value="NI">Nicaragua</option>
                                <option value="NE">Niger</option>
                                <option value="NG">Nigeria</option>
                                <option value="NU">Niue</option>
                                <option value="NF">Norfolk Island</option>
                                <option value="MP">Northern Mariana Islands</option>
                                <option value="NO">Norway</option>
                                <option value="OM">Oman</option>
                                <option value="PK">Pakistan</option>
                                <option value="PW">Palau</option>
                                <option value="PS">Palestinian Territory, Occupied</option>
                                <option value="PA">Panama</option>
                                <option value="PG">Papua New Guinea</option>
                                <option value="PY">Paraguay</option>
                                <option value="PE">Peru</option>
                                <option value="PH">Philippines</option>
                                <option value="PN">Pitcairn</option>
                                <option value="PL">Poland</option>
                                <option value="PT">Portugal</option>
                                <option value="PR">Puerto Rico</option>
                                <option value="QA">Qatar</option>
                                <option value="RE">Réunion</option>
                                <option value="RO">Romania</option>
                                <option value="RU">Russian Federation</option>
                                <option value="RW">Rwanda</option>
                                <option value="BL">Saint Barthélemy</option>
                                <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                <option value="KN">Saint Kitts and Nevis</option>
                                <option value="LC">Saint Lucia</option>
                                <option value="MF">Saint Martin (French part)</option>
                                <option value="PM">Saint Pierre and Miquelon</option>
                                <option value="VC">Saint Vincent and the Grenadines</option>
                                <option value="WS">Samoa</option>
                                <option value="SM">San Marino</option>
                                <option value="ST">Sao Tome and Principe</option>
                                <option value="SA">Saudi Arabia</option>
                                <option value="SN">Senegal</option>
                                <option value="RS">Serbia</option>
                                <option value="SC">Seychelles</option>
                                <option value="SL">Sierra Leone</option>
                                <option value="SG">Singapore</option>
                                <option value="SX">Sint Maarten (Dutch part)</option>
                                <option value="SK">Slovakia</option>
                                <option value="SI">Slovenia</option>
                                <option value="SB">Solomon Islands</option>
                                <option value="SO">Somalia</option>
                                <option value="ZA">South Africa</option>
                                <option value="GS">South Georgia and the South Sandwich Islands</option>
                                <option value="SS">South Sudan</option>
                                <option value="ES">Spain</option>
                                <option value="LK">Sri Lanka</option>
                                <option value="SD">Sudan</option>
                                <option value="SR">Suriname</option>
                                <option value="SJ">Svalbard and Jan Mayen</option>
                                <option value="SZ">Swaziland</option>
                                <option value="SE">Sweden</option>
                                <option value="CH">Switzerland</option>
                                <option value="SY">Syrian Arab Republic</option>
                                <option value="TW">Taiwan, Province of China</option>
                                <option value="TJ">Tajikistan</option>
                                <option value="TZ">Tanzania, United Republic of</option>
                                <option value="TH">Thailand</option>
                                <option value="TL">Timor-Leste</option>
                                <option value="TG">Togo</option>
                                <option value="TK">Tokelau</option>
                                <option value="TO">Tonga</option>
                                <option value="TT">Trinidad and Tobago</option>
                                <option value="TN">Tunisia</option>
                                <option value="TR">Turkey</option>
                                <option value="TM">Turkmenistan</option>
                                <option value="TC">Turks and Caicos Islands</option>
                                <option value="TV">Tuvalu</option>
                                <option value="UG">Uganda</option>
                                <option value="UA">Ukraine</option>
                                <option value="AE">United Arab Emirates</option>
                                <option value="GB">United Kingdom</option>
                                <option value="US">United States</option>
                                <option value="UM">United States Minor Outlying Islands</option>
                                <option value="UY">Uruguay</option>
                                <option value="UZ">Uzbekistan</option>
                                <option value="VU">Vanuatu</option>
                                <option value="VE">Venezuela, Bolivarian Republic of</option>
                                <option value="VN">Viet Nam</option>
                                <option value="VG">Virgin Islands, British</option>
                                <option value="VI">Virgin Islands, U.S.</option>
                                <option value="WF">Wallis and Futuna</option>
                                <option value="EH">Western Sahara</option>
                                <option value="YE">Yemen</option>
                                <option value="ZM">Zambia</option>
                                <option value="ZW">Zimbabwe</option>
                        </select> -->

<script>
   
    function categoryChange8(typeid)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/types",
            type: "POST",
            data: {typeid},

            success: function(response)
            {   
                $('#model81').html(response);
            }
        });
    }
    function categoryChange4(typeid)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/types",
            type: "POST",
            data: {typeid},

            success: function(response)
            {   
                $('#model1').html(response);
            }
        });
    }
     function categoryChange5(model)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/models",
            type: "POST",
            data: {model},

            success: function(response)
            {   
                $('#category_new').html(response);
            }
        });

    }
    function categoryChange6(cat_new)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/category_new",
            type: "POST",
            data: {cat_new},

            success: function(response)
            {   
                $('#subcat_new').html(response);
            }
        });
       
    }

    function changeReceivable(recValue)
    {
        if(recValue == 2)
        {
            $('#qty').prop('readonly', true);
            $('#qty').val(1);
        }
        else
        {
            $('#qty').prop('readonly', false);
            $('#qty').val(1);
        }
    }
</script>