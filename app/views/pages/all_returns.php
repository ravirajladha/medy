<?php require APPROOT . '/views/inc/header.php'; ?>
  <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">All Returns</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                               
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                             
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
                                        <h5 class="card-title mb-0">All Returns</h5>
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
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>SKU</th>
                                                <th>Stock on Hand</th>
                                                <th>Reorder Level</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td><img src="<?php echo URLROOT; ?>/assets/images/ecommerce/ganesha.jpg" class="img-fluid" width="35" alt="product"></td>
                                                <td>Ganesha Rahashya</td>
                                                <td class="text-success">GR1</td>
                                                <td>5200</td>
                                                <td>0</td>
                                                <td>01/07/2020</td>
                                                <td>
                                                    <div class="button-list">
                                                        <a  class="btn btn-primary-rgba" data-toggle="modal" data-target="#exampleStandardModal" ><i class="ri-pencil-line"></i></a>

                                                        <a href="" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <th scope="row">2</th>
                                                <td><img src="<?php echo URLROOT; ?>/assets/images/ecommerce/namaskara.jpg" class="img-fluid" width="35" alt="product"></td>
                                                <td>Surya Namaskar - Dvd English</td>
                                                <td class="text-success">SN1</td>
                                                <td>550</td>
                                                <td>0</td>
                                                <td>01/07/2020</td>
                                                <td>
                                                    <div class="button-list">
                                                       <a href="<?php echo URLROOT;?>/pages/" class="btn btn-primary-rgba"><i class="ri-pencil-line"></i></a>
                                                        <a href="" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a>
                                                    </div>
                                                </td>
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
            
                   
                               
                                <!-- Modal -->
                                <div class="modal fade" id="exampleStandardModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleStandardModalLabel">Create</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                
                <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            
                            <div class="card-body">
                                     <div class="form-group">
                                        <label >Sales Order:  </label>
                                        <label >#SO-000003</label>
                                    </div>
                               
                                    <div class="form-group">
                                        <label >Status</label>
                                        <label >: Packed</label>
                                         <label >: Shipped</label>
                                         <label >: Delivered </label>
                                    </div>
                                     <div class="form-group">
                                        <label >Reference#</label>
                                        <input type="text" class="form-control" value="#SO-00003">
                                    </div>

                                    <div class="form-group">
                                        <label >Sales Order Date</label>
                                         <input type="date" class="form-control" value="2020-07-12">
                                       
                                    </div>
                                   
                                   
                            </div>
                        </div>
                    </div> 
                    <!-- End col -->






                                            </div>
                                            <div class="modal-footer">
                                                
                                                <a href="<?php echo URLROOT;?>/pages/add_returns"><button type="button" class="btn btn-primary">Sales Return</button></a>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           
            </div>
            <!-- End Contentbar -->
<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
