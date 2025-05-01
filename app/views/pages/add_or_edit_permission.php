<?php require APPROOT . '/views/inc/header.php'; ?>
  <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-lg-11">
                        <h4 class="page-title">All Permission Details</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                               
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <!-- <a class="btn btn-primary" style="color: white" onclick="print_page()"><i class="fa fa-print" aria-hidden="true"></i></a> -->
                    </div>
                </div>          
            </div>
            <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->    
            <div class="contentbar">                
                <!-- Start row -->
                <form method="POST" action="<?php echo URLROOT;?>/pages/update_permission/<?php echo $data['s_emp']->emp_id; ?>">
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-header">                                
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <center>
                                        <h5 class="card-title mb-0" style="font-size: 28px;">Permission Details</h5>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-border">
                                        <thead>
                                            <tr>
                                                <th>Permission Id</th>
                                                <th>Permission Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $page = new Page(); ?>
                                            <?php foreach ($data['p_all'] as $k) { ?>
                                            <tr>
                                                <td><?php echo $k->id;?></td>
                                                <td><?php echo $k->permission;?></td>
                                                <td>
                                                    <a href="<?php echo URLROOT;?>/pages/assign_permission/<?php echo $k->id;?>">
                                                    <input type="checkbox" name="check<?php echo $k->id;?>" class="form-control"> </a>
                                                </td>
                                            </tr> 
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                 <button class="btn btn-primary" style="float: right;">Update</button>
                            </div>

                        </div>

                    </div>
                    <!-- End col -->
                </div>
                </form>
                <!-- End row -->
            </div>
            <!-- End Contentbar -->

<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
<script type="text/javascript">
   $(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script>