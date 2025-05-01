<?php require APPROOT .'/views/inc_ot/header.php'; ?>
<form method="POST" action="<?php echo URLROOT; ?>/ot/create_asset">
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Add Asset</h3></div>
            <div class="row">
                <br>
                <div class="col-md-4">
                    <label for="">Asset Name</label>
                    <input type="text" class="form-control" name="asset_name" autocomplete="off">
                </div>
                <div class="col-md-4">
                    <label for="">Asset Type</label>
                    <input type="text" class="form-control" name="asset_type" autocomplete="off">
                </div>
                <div class="col-md-4">
                    <label for="">Asset Amount</label>
                    <input type="number" class="form-control" name="asset_amount" autocomplete="off">
                </div>
                <div class="col-md-4">
                    <label for="">Need</label>
                    <input type="text" class="form-control" name="asset_need" autocomplete="off">
                </div>
                <div class="col-md-4">
                    <label for="">Date</label>
                    <input type="date" class="form-control" name="asset_date" 
                    value="<?php echo date('Y-m-d'); ?>" autocomplete="off">
                </div>
                <div class="col-md-4">
                    <label for="">Asset Description</label>
                    <textarea name="asset_desc" class="form-control"></textarea>
                    <!-- <input type="text" class="form-control" name="asset_desc"> -->
                </div>

                <div class="col-md-12">
                    <br>
                    <button   style="float: right;" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<?php require APPROOT .'/views/inc_ot/footer.php'; ?>