<?php require APPROOT . '/views/inc/header.php'; ?>


<!-- Start Breadcrumbbar -->                    
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Add Item</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                    
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <a href="<?php echo URLROOT;?>/pages/products"><button class="btn btn-primary">cancel</button></a>
            </div>                        
        </div>
    </div>          
</div>
<!-- End Breadcrumbbar -->
<!-- Start Contentbar -->  

<form method="post" action="<?php echo URLROOT; ?>/pages/create_item" enctype="multipart/form-data">  
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3" style="display: none">
                                <div class="form-group" >
                                    <label >Bar Code</label>
                                    <input type="text" class="form-control" placeholder="Barcode" name="barcode" autocomplete="off">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Name" name="name" required="true" autocomplete="off" id="itemNameForCheck">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Add Image</label>
                                    <input type="file" name="files">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >SKU</label>
                                    <input type="text" class="form-control" placeholder="Enter SKU" name="sku" autocomplete="off"   >
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Unit</label>
                                    <select class="form-control" id="formControlSelect" name="unit" required="true" required="true">
                                        <option>rolls</option>
                                        <option>coils</option>
                                        <option>box</option>
                                        <option>cm</option>
                                        <option>dz</option>
                                        <option>ft</option>
                                        <option>g</option>
                                        <option>in</option>
                                        <option>kg</option>
                                        <option>km</option>
                                        <option>lb</option>
                                        <option>mg</option>
                                        <option>m</option>
                                        <option>pc</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Type</label>
                                    <select name="type_id" id="" class="form-control" onchange="categoryChange4(this.value)">
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
                                    
                                    <select name="model_id" id="model1" class="form-control" onclick="categoryChange5(this.value)">
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
                                    <label>Category</label>
                                    <select name="category_new_id" id="category_new" class="form-control" onclick="categoryChange6(this.value)">
                                        
                                       <!--  <?php foreach ($data['cat2'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->sc2_id; ?>"><?php echo $key->sc2_name ?></option>
                                        <?php
                                        } ?> -->
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sub category</label>
                                    <select name="subcategory_new_id" id="subcat_new" class="form-control">
                                        
                                       <!--  <?php foreach ($data['cat3'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->sc3_id; ?>"><?php echo $key->sc3_name ?></option>
                                        <?php
                                        } ?> -->
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3" style="display: none;">
                                <div class="form-group">
                                    <label >Main Category</label>
                                    <select name="category_id" id="" class="form-control" onchange="categoryChange(this.value)">
                                        <option selected="" disabled="">--select--</option>
                                        <?php foreach ($data['cat'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->category_id; ?>"><?php echo $key->category_name ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div> 
                            </div> 
                            <div class="col-md-3" style="display: none;">
                                <div class="form-group">
                                    <label>Primary category</label>
                                    
                                    <select name="sc_id" id="subCategory" class="form-control" onclick="categoryChange1(this.value)">
                                        <option selected="" disabled="">--select--</option>
                                       <!--  <?php foreach ($data['cat1'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->sc_id; ?>"><?php echo $key->sc_name ?></option>
                                        <?php
                                        } ?> -->
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3" style="display: none;">
                                <div class="form-group">
                                    <label>Secondary category</label>
                                    <select name="sc_id2" id="subCategory1" class="form-control" onclick="categoryChange2(this.value)">
                                        
                                       <!--  <?php foreach ($data['cat2'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->sc2_id; ?>"><?php echo $key->sc2_name ?></option>
                                        <?php
                                        } ?> -->
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3" style="display: none;">
                                <div class="form-group">
                                    <label>Tertiary category</label>
                                    <select name="sc_id3" id="subCategory2" class="form-control">
                                        
                                       <!--  <?php foreach ($data['cat3'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->sc3_id; ?>"><?php echo $key->sc3_name ?></option>
                                        <?php
                                        } ?> -->
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Receivable</label>
                                    <select name="rec" id="" class="form-control" onchange="changeReceivable(this.value)" required="true">
                                        <option value="" selected disabled>--select--</option>
                                        <option value="1">Box</option>
                                        <option value="2">Pieces</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" class="form-control" id="qty" name="recNumber" autocomplete="off" required="true">
                                </div> 
                            </div>


                           
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input type="text" class="form-control" id="discount" name="discount" autocomplete="off" >
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>HSN</label>
                                    <input type="text" class="form-control" id="hsn" name="hsn" autocomplete="off" required="true">
                                </div> 
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tax Preference</label>
                                    <select class="form-control" id="tax_pre" name="tax_pre" required>
                                        <option selected disabled>----Select-----</option>
                                        <option value="taxable">Taxable</option>
                                        <option value="non_taxable">Non-Taxable</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Min Stock</label>
                                    <input type="text" class="form-control" id="" name="minstock" autocomplete="off" required="true">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Max Stock</label>
                                    <input type="text" class="form-control" id="" name="maxstock" autocomplete="off" required="true">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>PART NO</label>
                                    <input type="text" class="form-control" id="" name="part_no" autocomplete="off" required="true">
                                </div> 
                            </div>
                             <div class="col-md-12">
                                <hr>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Intra State Tax Rate</label>
                                    <select class="form-control" id="intra_gst" name="gst" required>
                                        <option selected disabled>----Select-----</option>
                                        <option value="0">GST0 [%0]</option>
                                        <option value="5">GST5 [%5]</option>
                                        <option value="12">GST12 [%12]</option>
                                        <option value="18">GST18 [%18]</option>
                                        <option value="28">GST28 [%28]</option>
                                    </select>
                                </div> 
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Inter State Tax Rate</label>
                                    <select class="form-control" id="inter_igst" name="igst" required>
                                        <option selected disabled>----Select-----</option>
                                        <option value="0">IGST0 [%0]</option>
                                        <option value="5">IGST5 [%5]</option>
                                        <option value="12">IGST12 [%12]</option>
                                        <option value="18">IGST18 [%18]</option>
                                        <option value="28">IGST28 [%28]</option>
                                    </select>
                                </div> 
                            </div>

                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Length</label>
                                    <input type="text" class="form-control" placeholder="Enter Length" name="Length" autocomplete="off" required="true">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Width</label>
                                    <input type="text" class="form-control" placeholder="Enter Width" name="width" autocomplete="off" >
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Height</label>
                                    <input type="text" class="form-control" placeholder="Enter Height" name="height" autocomplete="off" >
                                </div> 
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label >Size</label>
                                    <select name="size_id" id="" class="form-control" >
                                        <option selected="" disabled="">--select--</option>
                                        <?php foreach ($data['size'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->size_id; ?>"><?php echo $key->size_name ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Color</label>
                                    <select name="color_id" id="" class="form-control">
                                        <option selected="" disabled="">--select--</option>
                                        <?php foreach ($data['color'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->color_id; ?>"><?php echo $key->color_name ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div> 
                            </div>
                           
                            <div class="col-md-12">
                                <hr>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label >Manufacturer</label>
                                    <select name="man_name" id="" class="form-control" required="true">
                                        <option selected="" disabled="">--select--</option>
                                        <?php foreach ($data['all_mfg'] as $key) {
                                        ?>
                                            <option value="<?php echo $key->mfg_id;?>"><?php echo $key->mfg_name ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >UPC</label>
                                    <input type="text" class="form-control" placeholder="Enter UPC" name="upc" autocomplete="off">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >EAN</label>
                                    <input type="text" class="form-control" placeholder="Enter EAN" name="ean" autocomplete="off">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Weight(kg)</label>
                                    <input type="text" class="form-control" placeholder="Enter Weight" name="weight" autocomplete="off">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Brand</label>
                                    <input type="text" class="form-control" placeholder="Enter Brand" name="brand" autocomplete="off" required="true">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >MPN</label>
                                    <input type="text" class="form-control" placeholder="Enter MPN" name="mpn" autocomplete="off">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >ISBN</label>
                                    <input type="text" class="form-control" placeholder="Enter ISBM" name="isbn" autocomplete="off">
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Selling Price</label>
                                    <input type="number" class="form-control" placeholder="Enter Selling Price" name="selling_price" required="true" autocomplete="off">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Account</label>
                                    <input type="text" class="form-control" placeholder="Account" name="s_account" autocomplete="off" required="true"> 
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Description</label>
                                    <textarea class="form-control" name="s_description" autocomplete="off"></textarea>
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Purchase price</label>
                                    <input type="number" class="form-control" placeholder="Enter Purchase cost price" name="purchase_price" required="true" autocomplete="off">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Account</label>
                                    <input type="text" class="form-control" placeholder="Account" name="p_account" autocomplete="off" required="true">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Description</label>
                                    <textarea class="form-control" name="p_description" autocomplete="off"></textarea>
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                           <!--  <div class="col-md-3">
                                <div class="form-group">
                                    <label >Inventory Account*</label>
                                    <select class="select2-single form-control" name="inventory_type" required="true">
                                        <option selected="">Select</option>
                                        <option value="Finished Goods">Finished Goods</option>
                                        <option value="Inventory Asset">Inventory Asset</option>
                                        <option value="Work in Progress">Work in Progress</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Opening Stock</label>
                                    <input type="text" class="form-control" placeholder="Enter Opening Stock" name="opening_stock" autocomplete="off">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Reorder Point</label>
                                    <input type="text" class="form-control" placeholder="Enter Reorder Point" name="reorder_point" autocomplete="off">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Opening Stock Rate per Unit</label>
                                    <input type="text" class="form-control" placeholder="Enter Opening Stock Rate per Unit" name="opening_stock_rate" autocomplete="off">
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Preferred Vendor</label>
                                    <input type="text" class="form-control" placeholder="Enter Vendor" name="vendor" id="tags" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off">

                                    <div class="dropdown-menu" id="dropDownAjax" style="width: 300px;padding-bottom: 0px;padding-top: 0px;">

                                    </div> 
                                    <input type="text" name="vendor_id" id="tags_id" style="display: none;" />
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <a href="<?php echo URLROOT;?>/pages/products"><button class="btn btn-warning" style="float: right; margin-left: 10px;">Cancel</button></a>
                        <a href="<?php echo URLROOT;?>/pages/products"><button class="btn btn-primary" style="float: right;">Submit</button></a>
                    </div><!-- End row -->
                </div>
                <br>
            </div>
        </div>
    </div>
</form>



<script>
  $('#tags').keyup(function(){
        var tags = $('#tags').val();
        $.ajax({
            url: '<?php echo URLROOT; ?>/pages/get_all_vender_for_auto_complete',
            type: "POST",
            data: {tags},
            success : function(res)
            {
                $('#dropDownAjax').html(res);

            }
        });
  });
</script>
<script>
    function selectProduct(val)
    {
        document.getElementById("tags_id").value = val.id;
        document.getElementById("tags").value = val.name;
    }
</script>


<script>
    function categoryChange(categoryId)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/subCategory",
            type: "POST",
            data: {categoryId},

            success: function(response)
            {   
                $('#subCategory').html(response);
            }
        });
    }
     function categoryChange1(subCategory)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/subCategory1",
            type: "POST",
            data: {subCategory},

            success: function(response)
            {   
                $('#subCategory1').html(response);
            }
        });

    }
    function categoryChange2(subCategory1)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/subCategory_2",
            type: "POST",
            data: {subCategory1},

            success: function(response)
            {   
                $('#subCategory2').html(response);
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

<script>
    $('#itemNameForCheck').keyup(function(){
        var name = $('#itemNameForCheck').val();

        $.ajax({
            url: '<?php echo URLROOT; ?>/pages/checkName',
            type: 'POST',
            data: {
                name
            },
            success: function(response)
            {
                if(response == 1)
                {
                    alert('Name is used');
                }
            }
        });
    });
</script>
<script type="text/javascript">
   $(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script> 
<!-- End Contentbar -->
<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>