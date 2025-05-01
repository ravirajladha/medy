<?php require APPROOT .'/views/inc_reception/header.php'; 
if(isset($data['p_details']))
{
	foreach ($data['p_details'] as $key)
	{
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#p_name').val(<?php echo $key->patient_name;?>);
				$('#gen').val(<?php echo $key->patinet_gender?>);
				$('#dob').val(<?php echo $key->patient_dob;?>);
				$('#phn').val(<?php echo $key->patient_phone;?>);
				$('#email').val(<?php echo $key->patient_email;?>);
				$('#address').val(<?php echo $key->patient_address;?>);
			});
		</script>
		<?php
	}
}
?>
<div class="row">
	<form>
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">New Patient</h3></div>
                <div class="panel-body">
				<div class="row">
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Patient Name</label>
		                        <input style="margin-top: 10px;" type="text" class="form-control" id="p_name" placeholder="Enter Patient Name">
				    	</div>
					</div>
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Gender</label>
		                        <select style="margin-top: 10px;" class="form-control" id="gen">
                                    <option>Select Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
				        </div>
			    	</div>
				<div class="col-md-3">
		            <div class="form-group">
					    <label for="exampleInputEmail1">Date Of Birth</label>
		                    <input style="margin-top: 10px;" type="date" class="form-control" id="dob" placeholder="Enter Service Cost">
					</div>
				</div>
				<div class="col-md-2">
		            <div class="form-group">
					   <label for="exampleInputEmail1">Age(year)</label>
		                    <input style="margin-top: 10px;" type="number" class="form-control" id="age" placeholder="Enter Age">
					</div>
				</div>
				<div class="col-md-3">
		            <div class="form-group">
					   <label for="exampleInputEmail1">Phone</label>
		                    <input style="margin-top: 10px;" type="number" class="form-control" id="phn" placeholder="Enter Phone Number">
					</div>
				</div>
				<div class="col-md-3">
		            <div class="form-group">
					   <label for="exampleInputEmail1">Email</label>
		                    <input style="margin-top: 10px;" type="email" class="form-control" id="email" placeholder="Enter Email">
					</div>
				</div>
				<div class="col-md-3">
		            <div class="form-group">
					   <label for="exampleInputEmail1">Address</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="address" placeholder="Enter Address">
					</div>
				</div>
				<div class="col-md-2">
		            <div class="form-group">
					   <button style="margin-top: 34px" type="button" class="btn btn-info w-md m-b-5" id="add_pat">Add Patient</button>
					</div>
				</div>
				</div>
		</div>
	</div>
</div>
</form>
</div>
<?php require APPROOT .'/views/inc_reception/footer.php';?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#add_pat').click(function(){
			var p_name = $('#p_name').val();
			var gen = $('#gen').children('option:selected').val();
			var dob = $('#dob').val();
			var age = $('#age').val();
			var phone = $('#phn').val();
			var email = $('#email').val();
			var address = $('#address').val();
			$.ajax({
				url:'<?php echo URLROOT;?>/receptions/add_patient',
				type:'POST',
				data:{p_name,gen,dob,age,phone,email,address},
				success : function(data)
				{
					$('#p_name').val(null);
					$('#gen').val('Select Gender');
					$('#dob').val(null);
					$('#age').val(null);
					$('#phn').val(null);
					$('#email').val(null);
					$('#address').val(null);
				}
			});
		});
	});
</script>