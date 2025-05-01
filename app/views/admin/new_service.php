<?php require APPROOT .'/views/inc_admin/header.php'; ?>
<div class="row">
	<form>
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">New Service</h3></div>
               <div class="panel-body">
				<div class="row">
					<div class="col-md-3">
		                <div class="form-group">
							<label for="service_name">Service Name</label>
		                        <input style="margin-top: 10px;" type="text" class="form-control" id="service_name" placeholder="Enter Service Name" onkeypress="return /[a-z 1-9 () | . ]/i.test(event.key)">
				    	</div>
				</div>
				<div class="col-md-3">
	                <div class="form-group">
						<label for="exampleInputEmail1">Service Type</label>
	                        <select style="margin-top: 10px;" class="form-control" id="service_type">
		                        <option>OPD Consultaion</option>
								<option>Dressing Charge</option>
								<option>Procedure</option>
								<option>Lab Test</option>
								<option>Nursing Service</option>
								<option>Observation Charge</option>
								<option>Suppository Charges</option>
                            </select>
			        </div>
			    </div>
				<div class="col-md-3">
		            <div class="form-group">
					    <label for="exampleInputEmail1">Service Cost</label>
		                    <input style="margin-top: 10px;" type="number" class="form-control" id="service_cost" placeholder="Enter Service Cost">
					</div>
				</div>
				<div class="col-md-3">
		            <div class="form-group">
					   <?php
						    if(isset($data['inv_edit_details']))
						    {
						    	?>
						        <button style="margin-top: 34px" id="update" type="button" class="btn btn-info w-md m-b-5">Update Services</button>
						        <?php
						    }
						    else
						    {
						    	?>
						    	<button style="margin-top: 34px" id="create_service" type="button" class="btn btn-info w-md m-b-5">Create Services</button>
						    	<?php
						    }
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
</div> 		
<?php require APPROOT .'/views/inc_admin/footer.php';?>
<?php
    if(isset($data['inv_edit_details']))
    {
       foreach ($data['inv_edit_details'] as $key):
       		$service_id = $key->service_id;
    		$service_name = json_encode($key->service_name);
    		$service_type = json_encode($key->service_type);
    		?>
    		<script type="text/javascript">
    			var e_name = <?php echo $service_name;?>;
    			document.getElementById('service_name').value = e_name;
    			document.getElementById('service_cost').value = <?php echo $key->service_cost;?>;
    			document.getElementById('service_type').value = <?php echo $service_type;?>; 
    		</script>
    		<?php
       endforeach;
    }
?>

<script type="text/javascript">
	$('#create_service').click(function(){
		var s_name = $('#service_name').val();
		var s_type = $('#service_type').children('option:selected').val();
		var s_cost = $('#service_cost').val();
		$.ajax({
			url:'<?php echo URLROOT;?>/admin/save_new_service',
			type:'POST',
			data:{s_name,s_type,s_cost},
			success:function(data)
			{
				swal({
					title: data,
					type: "success"
				}, function() {
					window.location = "<?php echo URLROOT;?>/admin/new_service";
                });
			}
		});
	});
</script>

<script type="text/javascript">
	$('#update').click(function(){
		var e_id = <?php echo $service_id;?>;
		var e_name = $('#service_name').val();
		var e_type = $('#service_type').children('option:selected').val();
		var e_cost = $('#service_cost').val();
		$.ajax({
			url:'<?php echo URLROOT;?>/admin/update_service',
			type:'POST',
			data:{e_id,e_name,e_type,e_cost},
			success:function(data)
			{
				swal({
					title: data,
					type: "success"
				}, function() {
					window.location = "<?php echo URLROOT;?>/admin/all_services";
                });
			}
		});
	});
</script>


