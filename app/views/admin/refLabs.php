<?php require APPROOT .'/views/inc_admin/header.php'; ?>
<div class="row">
	<form action="<?php echo URLROOT; ?>/admin/addRefLab" method="POST">
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">New Reference Lab</h3></div>
               <div class="panel-body">
				<div class="row">
					<div class="col-md-3">
		                <div class="form-group">
                            <label for="service_name">Lab Name</label>
                            <input type="text" class="form-control" style="margin-top: 10px;" placeholder="Enter Lab Name" name="labName" required>
                        </div>
					</div>
				</div>
                <div class="row">
                    <div class="col-md-4">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
			</div>
		</div>
    </div>
	</form>
</div>
<?php require APPROOT .'/views/inc_admin/footer.php'; ?>
