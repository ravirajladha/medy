<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<?php
    if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
    {
        redirect('users/login');
    }
?>
<?php if(isset($data['mem_list'])) {
		foreach ($data['mem_list'] as $key)
		{
			$mem_name_update = json_encode($key->mem_name);
			$mem_type_update = json_encode($key->mem_type);
			$mem_ph_update = json_encode($key->mem_phone);
			$mem_em_update = json_encode($key->mem_email);
		}
?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#mem_name').val(<?php echo $mem_name_update;?>);
			$('#mem_type').val(<?php echo $mem_type_update?>);
			$('#mem_ph').val(<?php echo $mem_ph_update?>);
			$('#mem_em').val(<?php echo $mem_em_update?>);
		});
	</script>
<?php } ?>
<div class="row">
	<form>
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">New Member</h3></div>
                <div class="panel-body">
				<div class="row">
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Member Name</label>
		                        <input style="margin-top: 10px;" type="text" class="form-control" id="mem_name" required="" placeholder="Enter Doctor Name / ID">
				    	</div>
					</div>
			
				<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Member Type</label>
		                        <select style="margin-top: 10px;" required="" class="form-control" id="mem_type">
                                    <option>Select type</option>
									<option value='doc'>Doctor</option>
									<option value='lab'>Lab</option>
									<option value='rec'>Reception</option>
									<option value='pharm'>Pharmacy</option>
                                </select>
				        </div>
			    </div>

			    <div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Phone</label>
		                        <input style="margin-top: 10px;" type="number" required="" class="form-control" id="mem_ph" placeholder="Enter Phone">
				    	</div>
					</div>

					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Email</label>
		                        <input style="margin-top: 10px;" type="email" required="" class="form-control" id="mem_em" placeholder="Enter Email">
				    	</div>
					</div>

				<div class="col-md-3">
		            <div class="form-group">
						<?php if(!isset($data['mem_list'])) { ?>
							<button style="margin-top: 34px" type="button" id="add_mem" class="btn btn-info w-md m-b-5">Add Member</button>
						<?php } 
						else
						{	
						?>
					   		<button style="margin-top: 34px" type="button" id="add_mem" class="btn btn-info w-md m-b-5">Update Member Details</button>
						<?php } ?>

					</div>
				</div>
				</div>
		</div>
	</div>
</div>
</form>
</div> 	
<script type="text/javascript">
	$(document).ready(function(){
		$('#add_mem').click(function(){
		   var mem_name = $('#mem_name').val();
		   var mem_type = $('#mem_type').val();
		   var mem_ph = $('#mem_ph').val();
		   var mem_em = $('#mem_em').val();

		   $.ajax({
		   		url:'<?php echo URLROOT;?>/receptions/add_mem',
		   		type:'POST',
		   		data:{mem_name,mem_type,mem_ph,mem_em},
		   		success : function(data)
		   		{
		   			alert(data);
		   			$('#mem_name').val('');
		   			$('#mem_type').val('Select type');
		   			$('#mem_ph').val('');
		   			$('#mem_em').val('');
		   		}
		   });
		});
	});
</script>	
<?php require APPROOT .'/views/inc_reception/footer.php';?>
