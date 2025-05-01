<?php require APPROOT .'/views/inc_acc/header.php'; ?>
<?php
    if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
    {
        redirect('users/login');
    }
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Reports</h3></div>
                <div class="panel-body">
				<div class="row">
					<div class="col-md-12">
            				<div class="panel-heading" style="border: none;"><h3 class="panel-title">Custom Report</h3></div>
                				<div class="panel-body" style="border: none;" >
                					<form method="POST" action="<?php echo URLROOT;?>/receptions/custom_date">
	                					<div class="col-md-4">
							                <div class="form-group">
												<label for="exampleInputEmail1">From</label>
							                        <input style="margin-top: 10px;" type="date" class="form-control" name="to">
									    	</div>
										</div>
										<div class="col-md-4">
							                <div class="form-group">
												<label for="exampleInputEmail1">To</label>
							                        <input style="margin-top: 10px;" type="date" class="form-control" name="from">
									    	</div>
										</div>
										<div class="col-md-2">
								            <div class="form-group">
											   <button style="margin-top: 34px" type="submit" class="btn btn-info m-b-5">Go</button>
											</div>
										</div>
									</form>

									<div class="col-md-12">
										 <br>
										 <br>
									</div>
									<div class="col-md-2">
							            <div class="form-group">
										<a href="<?php echo URLROOT;?>/acc/today_report">
										   <button type="button" class="btn btn-primary  w-lg m-b-5">Today's Report</button></a>
										</div>
									</div>

									<div class="col-md-2">
							            <div class="form-group">
										   <a href="<?php echo URLROOT;?>/acc/monthly_report">
										   <button type="button" class="btn btn-primary  w-lg m-b-5">Monthly Report</button></a>
										</div>
									</div>

									<div class="col-md-2">
							            <div class="form-group">
										   <a href="<?php echo URLROOT;?>/acc/yearly_report">
										   <button type="button" class="btn btn-primary  w-lg m-b-5">Yearly Report</button></a>
										</div>
									</div>
				            </div>
					</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php require APPROOT .'/views/inc_acc/footer.php';?>


