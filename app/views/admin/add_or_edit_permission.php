<?php require APPROOT . '/views/inc_admin/header.php'; ?>

            <!-- Start Contentbar -->    
            <div class="contentbar">                
                <!-- Start row -->
                <form method="POST" action="<?php echo URLROOT;?>/admin/update_permission/<?php echo $data['s_emp']->mem_id; ?>">
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="panel m-b-30">
                            <div class="panel-header">                                
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <center>
                                        <h5 class="panel-title mb-0" style="font-size: 28px;">Permission Details</h5>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
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
                                            <?php $s_emp =  $data['emp_per'];
                                                $per = explode("|",$s_emp->permissions);   
                                             ?>
                                            <?php foreach ($data['p_all'] as $k) { ?>
                                            <tr>
                                                <td><?php echo $k->id;?></td>
                                                <td><?php echo $k->permission;?></td>
                                                <td>
                                                    <?php
                                                        if(in_array($k->id, $per))
                                                        {
                                                            ?>
                                                            <a href="<?php echo URLROOT;?>/pages/assign_permission/<?php echo $k->id;?>">
                                                            <input type="checkbox" checked name="check<?php echo $k->id;?>" class="form-control"> </a>
                                                        <?php
                                                            }
                                                            else
                                                            {
                                                        ?>
                                                            <a href="<?php echo URLROOT;?>/pages/assign_permission/<?php echo $k->id;?>">
                                                            <input type="checkbox" name="check<?php echo $k->id;?>" class="form-control"> </a>
                                                        <?php
                                                        }
                                                    ?>
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

<?php require APPROOT . '/views/inc_admin/footer.php'; ?>
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