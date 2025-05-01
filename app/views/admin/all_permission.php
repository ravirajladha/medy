<?php require APPROOT . '/views/inc_admin/header.php'; ?>
            <!-- Start Contentbar -->    
            <div class="contentbar">                
                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="panel m-b-30">
                            <div class="panel-header">                                
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <center>
                                        <h5 class="card-title mb-0" style="font-size: 28px;">Permission Details</h5>
                                        </center>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-border">
                                        <thead>
                                            <tr>
                                                <th>Employee Id</th>
                                                <th>Employee Name</th>
                                                <th>Type</th>
                                                <th>Permissions</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $page = new Reception(); ?>
                                            <?php foreach ($data['all_emp'] as $k) { ?>
                                            <?php if($k->type==0){}else{ ?>
                                            <tr>
                                                <td><?php echo $k->mem_id;?></td>
                                                <td><?php echo $k->mem_name;?></td>
                                                <td><?php echo $k->mem_type;?></td>
                                                <td>
                                                    <?php 
                                                        $permissions ="";
                                                        $permissions = $k->permissions;
                                                        if(!empty($permissions))
                                                        {
                                                            $permissions = explode("|", $permissions);
                                                            for ($i=0; $i <sizeof($permissions) ; $i++) 
                                                            { 
                                                               $p1[$i] = $page->get_permissions_name($permissions[$i]);
                                                               echo ($i+1).".".$p1[$i]."<br>";
                                                            }
                                                        }?>
                                                    </td>
                                                        
                                                <td><a class="btn btn-primary" href="<?php echo URLROOT;?>/admin/give_permission/<?php echo $k->mem_id;?>">Assign Permission</a></td>
                                            </tr> 
                                            <?php } }?>
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