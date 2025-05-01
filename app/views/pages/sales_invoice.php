<?php require APPROOT . '/views/inc/header.php';?>
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Sales Invoice Details</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?php $Page = new Page(); ?>
<div class="contentbar">
    <!-- End row -->
    <div class="row justify-content-center">
        <!-- Start col -->
        <div class="col-md-12 col-lg-10 col-xl-10">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="invoice">
                        <div class="invoice-head">
                            <div class="row">
                                <div class="col-12 col-md-7 col-lg-7">
                                    <div class="invoice-logo">
                                        <!-- <img src="<?php echo URLROOT; ?>/assets/images/logo.svg" class="img-fluid" alt="invoice-logo"> -->
                                    </div>
                                    <h4>Bharathi Electricals</h4>
                                    <!-- <p>The Complete Web Solutions Partner</p>
                                    <p class="mb-0">21st Street, Titanium Tower, Times Square, Nevada Campus, New Jersey - 55986 USA.</p> -->
                                </div>
                                <div class="col-12 col-md-5 col-lg-5">
                                    <div class="invoice-name">
                                        <h5 class="text-uppercase mb-3">Invoice</h5>
                                        <p class="mb-1">No : <?php echo $data['sales']->sale_id; ?></p>
                                        <!-- <p class="mb-0">01 April, 2020</p>
                                        <h4 class="text-success mb-0 mt-3">$1180</h4> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="invoice-billing">
                            <div class="row">
                                <div class="col-sm-6 col-md-4 col-lg-4">
                                    <div class="invoice-address">
                                        <h6 class="mb-3">Bill to</h6>
                                        <h6 class="text-muted">Amy Adams</h6>
                                        <ul class="list-unstyled">
                                            <li>417 Redbud Drive, Manhattan Building, Whitestone, NY, New York-11357</li>
                                            <li>+1-9876543210</li>
                                            <li>amyadams@email.com</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-4">
                                    <div class="invoice-address">
                                        <h6 class="mb-3">Shipped to</h6>
                                        <h6 class="text-muted">Amy Adams</h6>
                                        <ul class="list-unstyled">
                                            <li>417 Redbud Drive, Manhattan Building, Whitestone, NY, New York-11357</li>
                                            <li>+1-9876543210</li>
                                            <li>amyadams@email.com</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="invoice-address">
                                        <div class="card">
                                            <div class="card-body bg-secondary-rgba text-center">
                                                <h6>Payment Method</h6>
                                                <p><i class="ri-paypal-line text-primary font-40"></i></p>
                                                <p>via PayPal</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <?php $b = $Page->getsalesonlyDetails($data['sales']->sale_id);?>
                        <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                            <label>Customer Name: <?php echo ucwords($b->customer_name);?></label>
                            </div>
                            <div class="col-md-6">
                            <label>Address: <?php $v = $Page->get_customer_by_id($b->customer_id);?>
                            <?php echo $v->b_attention. " " . $v->b_street1 . " " . $v->b_street2 . " " . $v->b_city . " " . $v->b_state . " " . $v->b_country . " " . $v->b_zip_code . " " . $v->b_phone . " " . $v->b_fax;?></label>
                            </div>
                                                        
                        </div>
                    </div>
                    <br>
                        <div class="invoice-summary">
                            <div class="table-responsive ">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Item Id</th>
                                            <th>Item Name</th>
                                            <th>Item Quantity</th>
                                            <th>Tax</th>
                                            <th>Unit Price</th>
                                            <th>Item Price</th>
                                        </tr>
                                    </thead>
                                    <?php
                                        $item_t_total=0;
                                        $t_tax = 0;
                                        $itemId = explode('|||', $data['sales']->item_id);
                                        $itemName = explode('|||', $data['sales']->item_name);
                                        $itemQty = explode('|||', $data['sales']->item_qty);
                                        $itemPrice = explode('|||', $data['sales']->item_price);
                                        $itemTax = explode('|||', $data['sales']->item_tax);
                                        $itemTotal = explode('|||', $data['sales']->item_total);
                                        $itemState = explode('|||', $data['sales']->item_state);
                                    ?>
                                    <tbody>
                                        <?php for ($i=0; $i < sizeof($itemId); $i++) { 
                                        ?>
                                        <tr>
                                            <td><?php echo $i+1; ?></td>
                                            <td><?php echo $itemId[$i]; ?></td>
                                             <?php $item_name1 = $Page->getTheItemDetails($itemId[$i]); 
                                            ?>
                                            <?php $mm = $Page->get_model_name_by_id($item_name1->model_id); ?>
                                            <td><?php echo "(".$mm->model_name.")".$itemName[$i]; ?></td>
                                            <td><?php echo $itemQty[$i]; ?></td>
                                            <td>
                                                <?php 
                                                    if($itemState[$i] == 1)
                                                    {
                                                        echo 'CGST-'.($itemTax[$i]/2).'%';
                                                        echo "<br>";
                                                        echo 'SGST-'.($itemTax[$i]/2).'%';
                                                    }
                                                    else
                                                    {
                                                        echo 'IGST-'.($itemTax[$i]).'%';
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $itemPrice[$i]; ?></td>
                                            <td><?php echo $itemTotal[$i]; 
                                            $item_t_total = $item_t_total + $itemTotal[$i];
                                            $t_tax = $t_tax + ($itemTotal[$i] /100 * $itemTax[$i]);
                                             ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-summary-total">
                            <div class="row">
                                <div class="col-md-12 order-2 order-lg-1 col-lg-5 col-xl-6">
                                    <div class="order-note">
                                        <!-- <p class="mb-3"><span class="badge badge-info-inverse font-14">This is Free Shipping Order</span></p>
                                        <h6>Special Note for this order:</h6>
                                        <p>Please, Pack with product air bag and handle with care.</p> -->
                                    </div>
                                </div>
                                <div class="col-md-12 order-1 order-lg-2 col-lg-7 col-xl-6">
                                    <div class="order-total table-responsive ">
                                        <table class="table table-borderless text-right">
                                            <tbody>
                                                <!-- <tr>
                                                    <td>Sub Total :</td>
                                                    <td>$1000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping Charges :</td>
                                                    <td>$0.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Tax (18%) :</td>
                                                    <td>$180.00</td>
                                                </tr> -->
                                                <tr>
                                                    <td class="f-w-5 font-12">
                                                        <h6>Sub Total:</h6>
                                                    </td>
                                                    <td class="f-w-5 font-12">
                                                        <h6>₹ <?php echo array_sum($itemTotal); ?></h6>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="f-w-5 font-12">
                                                        <h6>Tax:</h6>
                                                    </td>
                                                    <td class="f-w-5 font-12">
                                                        <h6>₹ <?php echo $t_tax; ?></h6>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="f-w-7 font-18">
                                                        <h5>Amount Payable :</h5>
                                                    </td>
                                                   
                                                    <td class="f-w-7 font-18">
                                                        <h5>₹ <?php echo $t_tax + $item_t_total; ?></h5>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="invoice-meta">
                            <div class="row">
                                <div class="col-sm-6 col-md-4 col-lg-4">
                                    <div class="invoice-meta-box">
                                        <h6 class="mb-3">Terms & Conditions</h6>
                                        <ul class="pl-3">
                                            <li>Goods once sold will not be taken back.</li>
                                            <li>We are responsible for Courier Damage.</li>
                                            <li>Subjects to NY Jurisdiction.</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-4">
                                    <div class="invoice-meta-box">
                                        <h6 class="mb-3">Contact Us</h6>
                                        <ul class="list-unstyled">
                                            <li><i class="ri-earth-line mr-2"></i>www.example.com</li>
                                            <li><i class="ri-mail-line mr-2"></i>demo@example.com</li>
                                            <li><i class="ri-phone-line mr-2"></i>+1-9876543210</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="invoice-meta-box text-right">
                                        <h6 class="mb-0">Authorized Signatory</h6>
                                        <img src="assets/images/general/signature.svg" class="img-fluid my-3" alt="signature">
                                        <p class="mb-0">Stacy C</p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="invoice-footer">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <p class="mb-0">Thank you for your Business.</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="invoice-footer-btn">
                                        <a class="btn btn-secondary " href="<?php echo URLROOT;?>/pages/salesinvoiceprint/<?php echo $data['id'];?>">Print</a>

                                        <a href="javascript:window.print()" class="btn btn-primary py-1 font-16"><i class="ri-printer-line mr-2"></i>PrintA4</a>
                                        <!-- <a href="#" class="btn btn-success py-1 font-16"><i class="ri-send-plane-line mr-2"></i>Submit</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
</div>
<?php require APPROOT . '/views/inc/footer.php';?>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>