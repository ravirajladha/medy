<?php require APPROOT . '/views/inc/header.php'; ?>
  <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-7">
                        <h4 class="page-title">Purchase Orders by Vendor</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                               
                            </ol>
                        </div>
                    </div>
                    <div class="row col-md-4 col-lg-5">
                            <div class="col-md-4 col-lg-2">
                                <a href="<?php echo URLROOT;?>/pages/print"><button class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i></button></a>
                            </div>
                          <div class="col-md-4 col-lg-5">
                                    <div class="widgetbar" style="float: right;">

                                        <select class="form-control" id="formControlSelect">
                                            
                                            <option>Today</option>
                                            <option>This Week</option>
                                           
                                            <option selected>This Month</option>
                                            <option >This Quarter</option>
                                            <option>This Year</option>
                                            <option>Yesterday</option>
                                            <option>Previous Week</option>
                                            <option>Previous Month</option>
                                            <option>Previous Quarter</option>
                                            <option>Previous Year</option>
                                           
                                        </select>
                                    </div>   
                                </div>
                                  <div class="col-md-4 col-lg-5">
                                     <div class="widgetbar " style="float: right;">
                                       
                                        <select class="form-control" id="formControlSelect">
                                            
                                            <option selected>Export As</option>
                                            <option>PDF</option>
                                           
                                            <option >XLSX (Microsoft Excel)</option>
                                           
                                           
                                        </select>
                                    </div> 
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
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-header">                                
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <center>
                                         <h6>Sri Sri Publications Trust<h6>
                                        <h5 class="card-title mb-0" style="font-size: 28px;">Purchase Orders by Vendor</h5>
                                        <br>
                                        <h6>From 01/07/2020 To 31/07/2020<h6>
                                            </center>

                                    </div>
                                   <!--  <div class="col-6">
                                        <ul class="list-inline-group text-right mb-0 pl-0">
                                            <li class="list-inline-item">
                                                  <div class="form-group mb-0 amount-spent-select">
                                                    <select class="form-control" id="formControlSelect">
                                                      <option>All</option>
                                                      <option>Last Week</option>
                                                      <option>Last Month</option>
                                                    </select>
                                                </div>
                                            </li>
                                        </ul>                                        
                                    </div> -->
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-border">
                                        <thead>
                                            <tr>
                                                <th>Vendor Name</th>
                                                <th>Purchase Order Count</th>
                                                <th>Amount</th>
                                                
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                      
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
            <!-- End Contentbar -->

<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
