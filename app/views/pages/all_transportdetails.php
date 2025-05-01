<?php require APPROOT . '/views/inc/header.php'; ?>
   <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">All Transport Details</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                               
                            </ol>
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
                                        <h5 class="card-title mb-0">All transport details</h5>
                                    </div>
                             
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                              
                                                <th>LR Number</th>
                                                <th>Name</th>
                                                <th>Details</th>
                                                <th>Created By</th>
                                              
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                               <?php foreach ($data['transport'] as $k){ ?>
                                            <tr>
                                                <td><?php echo $k->id;?></td>
                                                <td><?php echo $k->lr_number;?></td>
                                                <td><?php echo $k->name;?></td>
                                                <td><?php echo $k->details;?></td>
                                                <td><?php echo $k->created_by;?></td>
                                                <td> 
                                                <a href="<?php echo URLROOT; ?>/pages/editTransportDetails/<?php echo $k->id ?>"><button class="btn btn-info">Edit</button></a>
                                                <a href="<?php echo URLROOT; ?>/pages/deleteTransportDetails/<?php echo $k->id ?>"><button class="btn btn-warning">Delete</button></a>
                                                </td>
                                                
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

<?php require APPROOT . '/views/inc/footer.php'; ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
