<?php require APPROOT . '/views/inc/header.php'; ?>

            <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">Transport Details</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                             
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                             
                        </div>                        
                    </div>
                </div>          
            </div>

            
                <br><br>
            <div class="contentbar">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5>Edit Transport Details</h5>
                        <hr>
                          <?php $com = $data['transport']; ?>
                        <form action="<?php echo URLROOT; ?>/pages/updatetransportdetails" method="POST">
                             <input type="number" name="id" value="<?php echo $com->id;?>" style="display: none;"> 
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>LR Number</label>
                                    <input type="text" class="form-control" placeholder="LR Number" name="lr_number" autocomplete="off" value="<?php echo $com->lr_number; ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" autocomplete="off" required value="<?php echo $com->name; ?>">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>Details</label>
                                    <textarea class="form-control" placeholder="Details" name="details" autocomplete="off"><?php echo $com->details; ?></textarea>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Created By</label>
                                    <input type="number" class="form-control" placeholder="Created By" name="created_by" value="<?php echo $com->created_by; ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="id" value="<?php echo $com->id; ?>" style="display:none" />
                                <a href="<?php echo URLROOT;?>/pages/all_companydetails"><button name="update_company" class="btn btn-primary" type="submit">update</button></a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
<script type="text/javascript">
    $(".chb").change(function() {
    $(".chb").prop('checked', false);
    $(this).prop('checked', true);
});
 </script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
