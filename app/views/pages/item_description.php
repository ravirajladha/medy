<?php require APPROOT . '/views/inc/header.php'; ?>
<?php $t = $data['all_items']; ?>
<!-- Start Breadcrumbbar -->
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Item Overview</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>

                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <!--<div class="widgetbar">-->
            <!--    <a href="<?php echo URLROOT; ?>/pages/adjuststock"><button class="btn btn-primary">Adjust Stock</button></a>-->
            <!--</div>-->
        </div>
    </div>
</div>
<!-- End Breadcrumbbar -->

<!-- Start Contentbar -->
<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-6">
            <div class="card m-b-30">

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4 form-group">
                            <label>SKU:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->SKU; ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Unit:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->unit; ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Dimensions:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->dimension; ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Weight:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->weight; ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>UPC:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->UPC; ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>EAN:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->EAN; ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>MPN:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->MPN; ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>ISBN:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->ISBN; ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Manufacturer:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->Manufacturer_name; ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Brand:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->brand; ?>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Inventory Account:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->inventory_account_type; ?>
                        </div>

                        <label class="col-md-12" style="color: black">Purchase Information</label>
                        <br>
                        <br>
                        <div class="col-md-4 form-group">
                            <label>Cost Price:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->purchase_price; ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Purchase Account:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->p_account; ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Description:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->p_description; ?>
                        </div>

                        <label class="col-md-12" style="color: black">Sales Information</label>
                        <br>
                        <br>
                        <div class="col-md-4 form-group">
                            <label>Selling Price:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->selling_price; ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Sales Account:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->s_account; ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Description:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->s_description; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
        <!-- Start col -->


        <!-- Start col -->
        <div class="col-lg-6">
            <div class="card m-b-30">
                <img class="card-img-top" src="<?php echo URLROOT; ?>/uploads/<?php echo $t->img; ?>" alt="Card image cap" />

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Opening Stock</label>
                            <hr>
                        </div>
                        <div class="col-md-8">
                            <?php if(empty($t->opening_stock)){ echo ":0"; }else{ echo ":".$t->opening_stock;} ; ?>
                        </div>
                        <label class="col-md-12" style="color: black">Accounting Stock</label>
                        <br><br>
                        <div class="col-md-4 form-group">
                            <label>Stock on Hand:</label>
                        </div>
                        <div class="col-md-8">
                             <?php
                                    $post = new Page();
                                    $a =0;
                                    $b=0;
                                    $c = 0;
                                     $d = 0;
                                    $s_stock = $post->get_single_stock($t->id);
                                    foreach ($s_stock as $k) 
                                    {
                                        $a = $a + $k->stock_total_receive;
                                        if($k->receivable == 1)
                                        {
                                            $b = $b + $k->stock_total_receive;    
                                            $d = (int)$t->qty * (int)$b;
                                        }
                                        if($k->receivable == 3)
                                        {
                                            $c = $c + $k->stock_total_receive;     
                                        }
                                    }
                                    $d = $d+$c; echo $d; ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Committed Stock:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $t->committed_stock; ?>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Available for Sale:</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $d; ?>
                        </div>

                        <label class="col-md-12" style="color: black">
                            <hr> Box Quantity</label>
                        <br><br>
                        <div class="col-md-12">
                            <?php echo $b; ?>
                        </div>
                        <label class="col-md-12" style="color: black">
                            <hr> Pieces Quantity</label>
                        <br><br>
                        <div class="col-md-12">
                            <?php echo $c; ?>
                        </div>
                        <label class="col-md-12" style="color: black">
                            <hr> Min Stock</label>
                        <br><br>
                        <div class="col-md-12">
                            <?php echo $t->minstock; ?>
                        </div>
                        <label class="col-md-12" style="color: black">
                            <hr> Max Stock</label>
                        <br><br>
                        <div class="col-md-12">
                            <?php echo $t->maxstock; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->

        <?php require APPROOT . '/views/inc/footer.php'; ?>
        <?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>