<?php require APPROOT .'/views/inc_ot_room/header.php'; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Hospital Available Room Details</h3></div>
              <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table" >
                            <thead>
                                <tr>
									<th style="text-align: left;">Sl. No.</th>
									<th style="text-align: left;">Room Number</th>
									<th style="text-align: left;">Bed ID</th>
									<th style="text-align: left;">From Date</th>
									<th style="text-align: left;">To Date</th>
									<th style="text-align: left;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            		$i = 1;
                            		foreach ($data['booking'] as $key) {
                            	?>
                            	<tr>
                            		<td style="text-align: left;"><?php echo $i; ?></td>
                            		<td style="text-align: left;"><?php echo $key->room_number; ?></td>
                            		<td style="text-align: left;"><?php echo $key->bed_id; ?></td>
                            		<td style="text-align: left;"><?php echo $key->from_date; ?></td>
                            		<td style="text-align: left;"><?php echo $key->to_date; ?></td>
                            		<td style="text-align: left;"><a href="<?php echo URLROOT?>/ot_room/cancelBooking/<?php echo $key->booking_id; ?>"><button class="btn btn-warning btn-xs m-b-5">Cancel</button></a></td>
                            	</tr>
                            	<?php $i ++;
                            	} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT .'/views/inc_ot_room/footer.php'; ?>
