<?php require APPROOT .'/views/inc_pharmacy/header.php'; ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Reports</h3></div>
                <div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						
            				<div class="panel-heading" style="border: none;"><h3 class="panel-title">Custom Report</h3></div>
                				<div class="panel-body" style="border: none;" >
                					<form action="<?php echo URLROOT;?>/pharmacies/cus_rep" method="POST">
                					<div class="col-md-4">
						                <div class="form-group">
											<label for="exampleInputEmail1">From</label>
						                        <input style="margin-top: 10px;" type="date" class="form-control" name="to" id="exampleInputEmail1">
								    	</div>
									</div>
									<div class="col-md-4">
						                <div class="form-group">
											<label for="exampleInputEmail1">To</label>
						                        <input style="margin-top: 10px;" type="date" class="form-control" id="exampleInputEmail1" name="from">
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
										<a href="<?php echo URLROOT;?>/pharmacies/today_report">
										   <button type="button" class="btn btn-primary  w-lg m-b-5">Today's Report</button></a>

										</div>
									</div>

									<div class="col-md-2">
							            <div class="form-group">

										   <a href="<?php echo URLROOT;?>/pharmacies/monthly_report">
										   <button type="button" class="btn btn-primary  w-lg m-b-5">Monthly Report</button></a>

										</div>
									</div>

									<div class="col-md-2">
							            <div class="form-group">

										   <a href="<?php echo URLROOT;?>/pharmacies/yearly_report">
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
<?php require APPROOT .'/views/inc_pharmacy/footer.php';?>
