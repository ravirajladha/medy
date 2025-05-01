<?php require APPROOT . '/views/inc/header.php'; ?>
   <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">Invoices</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                               
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                            <a href="<?php echo URLROOT;?>/pages/addinvoice"><button class="btn btn-primary">Add Invoice</button>
                            </a>
                              <button class="btn btn-primary"><i class="ri-refresh-line mr-2"></i>Refresh</button>
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
                                    <div class="col-6">
                                        <h5 class="card-title mb-0">All Invoice</h5>
                                    </div>
                                    <div class="col-6">
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
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th>Invoice</th>
                                                <th>Order Number</th>
                                                <th>Customer Name</th>
                                                <th>Status</th>
                                                <th>Due Date</th>
                                                <th>Amount</th>
                                                <th>Balance Due</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>1</th>
                                                 <td>01/05/2020</td>
                                                <td>INV-00002</td>
                                                <td>inv123456</td>
                                                <td>Mr.Praveen</td>
                                                <td>Due Today</td>
                                                 <td>22/05/2020</td>
                                                <td>Rs.850</td>
                                                <td>Rs.850</td>
                                               
                                            </tr>
                                            <tr>
                                                <th>2</th>
                                                 <td>01/05/2020</td>
                                                <td>INV-00002</td>
                                                <td>inv123456</td>
                                                <td>Mr.Praveen</td>
                                                <td>Due Today</td>
                                                 <td>22/05/2020</td>
                                                <td>Rs.850</td>
                                                <td>Rs.850</td>
                                               
                                            </tr>
                                            <tr>
                                                <th>3</th>
                                                 <td>01/05/2020</td>
                                                <td>INV-00002</td>
                                                <td>inv123456</td>
                                                <td>Mr.Praveen</td>
                                                <td>Due Today</td>
                                                 <td>22/05/2020</td>
                                                <td>Rs.850</td>
                                                <td>Rs.850</td>
                                               
                                            </tr>
                                            
                                           
                                            
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
