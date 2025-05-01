<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<div class="row" style="margin: 20px;">
    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading">
              	<h3 class="panel-title">Advance Receipt</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
				<h5><b><u>Patient Details</u></b></h5>
				<p><b>Name</b>: <?php echo $data['patient']->patient_name; ?> - <?php echo $data['patient']->patient_id ?></p>
				<p><b>Admit ID</b>: <?php echo $data['admit_id'] ?></p>
				</div>
				<br>
				<form action="<?php echo URLROOT; ?>/receptions/save_advanced_receipt" method="POST">
					<div class="col-md-5">
						<label for="">Date time</label>
						<input type="hidden" name="patient_id" value="<?php echo $data['patient']->patient_id ?>">
						<input type="hidden" name="admit_id" value="<?php echo $data['admit_id'] ?>">
						<input type="datetime-local" name="datetime" id="" class="form-control" value="<?php echo date('Y-m-d\TH:i:s'); ?>">
					</div>
					<div class="col-md-4">
						<label for="">Amount</label>
						<input type="number" name="amount" id="" class="form-control" placeholder="enter amount">
					</div>
					<div class="col-md-3">
						<label for="">Payment mode</label>
						<input type="text" class="form-control" name="payment_type">
					</div>
					<div class="col-md-12">
						<button class="btn btn-info" style="margin-top: 25px;" type="submit">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">All Receipts</h3>
			</div>
			<div class="row">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th>Sl.No</th>
								<th>Date Time</th>
								<th>Amount</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i = 1;
								foreach ($data['bills'] as $key) 
								{
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo date('d-M-Y H:i a', strtotime($key->created_date_time)) ?></td>
								<td><?php echo $key->amount; ?></td>
								<td>
									<a href="<?php echo URLROOT; ?>/receptions/print_receipt/<?php echo $key->id ?>/<?php echo $data['patient']->patient_id; ?>/<?php echo $data['admit_id'] ?>" class="btn btn-info btn-xs">Print</a>
								</td>
							</tr>
							<?php
								$i++;
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require APPROOT .'/views/inc_reception/footer.php'; ?>