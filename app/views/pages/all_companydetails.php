<?php require APPROOT . '/views/inc/header.php'; ?>
   <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">All CompanyDetails</h4>
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
                                        <h5 class="card-title mb-0">All company details</h5>
                                    </div>
                             
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                              
                                                <th>Company name</th>
                                                <th>Company Email</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                              
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                               <?php foreach ($data['company'] as $k){ ?>
                                            <tr>
                                                <td><?php echo $k->id;?></td>
                                                
                                                <td><?php echo $k->name;?></td>
                                                <td><?php echo $k->email;?></td>
                                                  <td><?php echo $k->street1;?></td>
                                                <td> <a  href="<?php echo URLROOT; ?>/pages/editcompanydetails/<?php echo $k->id ?>"><button class="btn btn-info">Edit</button></a>
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
