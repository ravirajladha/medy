<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Referal Doctor</h3></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Patient Name</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="">Doctor Name</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="">Visit Purpose</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="">Doctor Fee</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <br>
                        <button class="btn btn-info">Submit</button>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT .'/views/inc_reception/footer.php'; ?>