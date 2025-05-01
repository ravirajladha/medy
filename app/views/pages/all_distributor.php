<?php require APPROOT . '/views/inc/header.php'; ?>
   <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">All Distributor</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                               
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                            <a href="<?php echo URLROOT;?>/pages/add_distributor"><button class="btn btn-primary">Add Distributor</button>
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
                                        <h5 class="card-title mb-0">All Distributor</h5>
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
                                                <th>Distributor Name</th>
                                                <th>Email</th>
                                                <th>Work Phone</th>
                                                <th>Website</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <?php foreach ($data['all_distributor'] as $k){ ?>
                                            <tr>
                                                <td><?php echo $k->id;?></td>
                                                <td><?php echo $k->distributor_display_name;?></td>
                                                <td><?php echo $k->distributor_email;?></td>
                                                <td><?php echo $k->distributor_phno_work;?></td>
                                                <td><?php echo $k->distributor_website;?></td>
                                               
                                                <td> <a href="<?php echo URLROOT; ?>/pages/edit_distributor/<?php echo $k->id;?>" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="<?php echo URLROOT; ?>/pages/del_distributor/<?php echo $k->id;?>" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
                                            </tr>
                                            <?php }?>
                                            
                                            
                                           
                                            
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
