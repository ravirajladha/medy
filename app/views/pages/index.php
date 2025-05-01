<?php require APPROOT . '/views/inc/header.php'; ?>

            <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">Dashboard</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT;?>/assets2/pages/index">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT;?>/assets2/pages/index">Dashboard</a></li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                            <!-- <button class="btn btn-primary"><i class="ri-refresh-line mr-2"></i>Refresh</button> -->
                        </div>                        
                    </div>
                </div>          
            </div>
            <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->    
            <div class="contentbar">   
                <!-- Start row -->
                <div class="row"> 
                    <!-- Start col -->
                    <div class="col-lg-12 col-xl-4">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col-8">
                                        <p class="font-15">TOTAL PACKED</p>
                                        <h4 class="card-title mb-0"><?php echo $data['pack']; ?></h4><br>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="iconbar iconbar-md bg-primary text-white rounded"><i class="ri-arrow-right-up-line align-unset"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col-8">
                                        <p class="font-15">TOTAL SHIPPED</p>
                                        <h4 class="card-title mb-0"><?php echo $data['ship']; ?></h4><br>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="iconbar iconbar-md bg-primary text-white rounded"><i class="ri-money-dollar-circle-line align-unset"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- End col --> 
                     <div class="col-lg-12 col-xl-4"> 
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col-8">
                                        <p class="font-15">TOTAL ITEM DELIVERED</p>
                                        <h4 class="card-title mb-0"><?php echo $data['deliver']; ?></h4><br>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="iconbar iconbar-md bg-primary text-white rounded"><i class="ri-user-3-line align-unset"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col-8">
                                        <p class="font-15">TOTAL INVOICED</p>
                                        <h4 class="card-title mb-0"><?php echo $data['invoice']; ?></h4><br>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="iconbar iconbar-md bg-primary text-white rounded"><i class="ri-user-3-line align-unset"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12 col-xl-4"> 
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col-8">
                                        <small><small>Inventory Summary</small></small>
                                        <p class="font-15">QUANTITY IN HAND</p>
                                        <h4 class="card-title mb-0"><?php echo $data['on_hand'];?></h4>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="iconbar iconbar-md bg-primary text-white rounded"><i class="ri-user-3-line align-unset"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col-8">
                                         <small><small>Inventory Summary</small></small>
                                        <p class="font-13">QUANTITY TO BE RECEIVED</p>
                                        <h4 class="card-title mb-0"><?php echo $data['rec'];?></h4>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="iconbar iconbar-md bg-primary text-white rounded"><i class="ri-user-3-line align-unset"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
                  <div class="row"> 
                    <!-- Start col -->
                    <div class="col-lg-12 col-xl-6" style="display: none;">
                            <!-- Start col -->
                           
                                <div class="card m-b-30">
                                    <div class="card-header">
                                        <h5 class="card-title">PRODUCT DETAILS</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="apex-radial-chart"></div>
                                    </div>
                                </div> 
                        <!-- End col --> 
                    </div>
                    <!-- End col -->
                       <!-- Start col -->
                    <div class="col-md-12 col-lg-12 col-xl-6" style="display: none;">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <h5 class="card-title">TOP SELLING ITEMS</h5>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab-line" data-toggle="tab" href="#home-line" role="tab" aria-controls="home-line" aria-selected="true">This Week</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab-line" data-toggle="tab" href="#profile-line" role="tab" aria-controls="profile-line" aria-selected="false">This Month</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab-line" data-toggle="tab" href="#contact-line" role="tab" aria-controls="contact-line" aria-selected="false">This Year</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="defaultTabContentLine">
                                    <div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">
                                      <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="tab-pane fade" id="profile-line" role="tabpanel" aria-labelledby="profile-tab-line">
                                      <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="tab-pane fade" id="contact-line" role="tabpanel" aria-labelledby="contact-tab-line">
                                      <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->                  
                </div>
                <!-- End row -->
                <?php if($_SESSION['user_type']==0){?>
                <!-- Start row -->
                <div class="row"> 
                    <!-- Start col -->
                    <div class="col-lg-12 col-xl-4">
                        <div class="card m-b-30">
                            <div class="card-header">

                            <div class="row align-items-center">
                                    <div class="col-8">
                                        <h5 class="card-title mb-0">PURCHASE ORDER</h5>
                                    </div>
                                    <!-- <div class="col-4">
                                         <select class="form-control font-12" >
                                            <option value="class1" selected> Week</option>
                                            <option value="class2"> Month</option>
                                            <option value="class3"> Year</option>
                                        </select>
                                    </div> -->
                                </div> 
                               </div>
                               <br>
                            <div class="card-body">
                                <div class="text-center">
                                    <h4>Quantity Ordered</h4>
                                    <p><br><?php echo $data['p_total_qty'];?></p>
                                </div> 
                                <hr><br>
                                  <div class="text-center">
                                    <h4>Total Cost</h4>
                                    <p><br>Rs.<?php echo $data['p_total_price'];?></p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- End col -->  
                 
                    <!-- Start col -->
                      <!-- Start col -->
                    <div class="col-8">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <h5 class="card-title">SALES ORDER</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table foo-filtering-table" data-filtering="true">
                                        <thead>
                                        <tr >
                                            <th>ID</th>
                                            <th>Customer Name</th>
                                            <th>Expected Delivery Date</th>
                                            <th>Payment Terms</th>
                                            <th>Total Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $a =0; foreach ($data['sales'] as $k) { ?>
                                            <?php if($a <5){ ?>
                                            <tr>
                                                <td><?php echo $k->id;?></td>
                                                <td><?php echo $k->customer_name;?></td>
                                                <td><?php echo $k->expected_delivery_date;?></td>
                                                <td><?php echo $k->payment_terms;?></td>
                                                <td><?php echo $k->total_amount;?></td>
                                            </tr>
                                       <?php } $a++; }?>
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col --> 
                    <!-- End col -->                    
                </div>
                <?php }?>
                <!-- End row -->
            </div>
            <!-- End Contentbar -->

<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
