<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<?php
    if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
    {
        redirect('users/login');
    }
?>
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
		                        <input style="margin-top: 10px;" type="text" class="form-control" id="service_name" placeholder="Enter Service Name">
				    	</div>
				</div>
				<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Service Type</label>
		                        <select style="margin-top: 10px;" class="form-control" id="service_type" title="Select Service Type">
		                        	<option>IPD Ward</option>
		                        	<option>IPD Consultaion</option>
		                        	<option>Nursing Services</option>
		                        	<option>OPD Consultaion</option>
		                        	<option>Suture Charge</option>
		                        	<option>Dressing Charge</option>
		                        	<option>Observation Charge</option>
		                        	<option>Suture Charge</option>
			                        <!-- <?php foreach($data['service_types'] as $key) 
			                        	{
            							?>
                    						<option id='fr'><?php echo $key->service_type;?></option>
                						<?php
	                        			}
	                                ?> -->
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
<?php require APPROOT .'/views/inc_reception/footer.php';?>
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
			url:'<?php echo URLROOT;?>/receptions/save_new_service',
			type:'POST',
			data:{s_name,s_type,s_cost},
			success:function(data)
			{
				alert(data);
				$('#service_name').val('');
				$('#service_type').val('IPD Ward');
				$('#service_cost').val('');
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
			url:'<?php echo URLROOT;?>/receptions/update_service',
			type:'POST',
			data:{e_id,e_name,e_type,e_cost},
			success:function(data)
			{
				alert(data);
			}
		});
	});
</script>


