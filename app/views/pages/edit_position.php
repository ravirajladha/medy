<?php require APPROOT . '/views/inc/header.php'; ?>                   
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Edit Position</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                </ol>
            </div>
        </div>
    </div>          
</div>  
<?php $p = $data['position'];?>
<div class="contentbar">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="<?php echo URLROOT; ?>/pages/all_positions"><button class="btn btn-link pull-right">All Positions</button></a>
                    <h5>Edit Position</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/update_positions" method="POST">
                        <input type="text" name="id" value="<?php echo $p->position_id;?>" style="display: none;">
                    <div class="row">
                        
                        <div class="col-md-3 form-group">
                            <label for="">Position Code</label>
                            <input type="text" class="form-control" placeholder="Enter Position" name="posCode" required="true" autocomplete="off" value="<?php echo $p->position_code;?>">
                        </div>
                        <div class=" col-md-3form-group">
                            <label for="">Position Details</label>
                            <textarea class="form-control" placeholder="Enter Position Details" name="posDetails" required="true" autocomplete="off" cols="50"><?php echo $p->position_details;?></textarea>
                            
                        </div>
                        
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
