<?php require APPROOT .'/views/inc_admin/header.php'; ?>
<div class="row">
	<form>
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">New Doctor</h3></div>
                <div class="panel-body">
				<div class="row">
					<div class="col-md-4">
		                <div class="form-group">
							<label for="exampleInputEmail1">Doctor Name</label>
							<input style="margin-top: 10px;" type="text" class="form-control" id="doc_name" placeholder="Enter Doctor Name"
							<?php
								if(isset($data['d_list']))
								{
									?>
										value="<?php echo $data['d_user']->mem_name; ?>"
									<?php
								}
							?>
							>
				    </div>
				</div>
			
				<div class="col-md-4">
	                <div class="form-group">
						<label for="exampleInputEmail1">Doctor Speciality</label>
                        <select style="margin-top: 10px;" class="form-control" id="doc_spl">
                            <option>Select Doctor Speciality</option>
							<option value='Neurology' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Neurology") { ?> selected <?php } } ?> >Neurology</option>
							<option value='Dental' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Dental") { ?> selected <?php } } ?>>Dental</option>
							<option value='Neurosurgery' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Neurosurgery") { ?> selected <?php } } ?>>Neurosurgery</option>
							<option value='Pediatrics' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Pediatrics") { ?> selected <?php } } ?>>Pediatrics</option>
							<option value='Psychiatry' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Psychiatry") { ?> selected <?php } } ?>>Psychiatry</option>
							<option value='Gynecology & Infertility' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Gynecology & Infertility") { ?> selected <?php } } ?>>Gynecology & Infertility</option>
							<option value='Orthopedics' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Orthopedics") { ?> selected <?php } } ?>>Orthopedics</option>
							<option value='Dermatology' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Dermatology") { ?> selected <?php } } ?>>Dermatology</option>
							<option value='Nephrology' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Nephrology") { ?> selected <?php } } ?>>Nephrology</option>
							<option value='Diabetology & Endocrinology' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Diabetology & Endocrinology") { ?> selected <?php } } ?>>Diabetology & Endocrinology</option>
							<option value='Urology' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Urology") { ?> selected <?php } } ?>>Urology</option> 
							<option value='General Medicine & Diabetology' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "General Medicine & Diabetology") { ?> selected <?php } } ?>>General Medicine & Diabetology</option>
							<option value='Surgical Gastroenterology' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Surgical Gastroenterology") { ?> selected <?php } } ?>>Surgical Gastroenterology</option>
							<option value='Oncology' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Oncology") { ?> selected <?php } } ?>>Oncology</option>
							<option value='Cardiology' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Cardiology") { ?> selected <?php } } ?>>Cardiology</option>
							<option value='Surgical Oncology' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Surgical Oncology") { ?> selected <?php } } ?>>Surgical Oncology</option>
							<option value='Orthopedics' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "Orthopedics") { ?> selected <?php } } ?>>Orthopedics</option>
							<option value='ENT' <?php if(isset($data['d_list'])) { if($data['d_list']->doctor_speciality == "ENT") { ?> selected <?php } } ?>>ENT</option>
                        </select>
			        </div>
			    </div>
			    <div class="col-md-3">
			    	<div class="form-group">
			    		<label for="">Doctor Fee</label>
							<input type="number" class="form-control" name="" id="doc_fee" placeholder="Enter Fee" style="margin-top: 10px;" <?php if(isset($data['d_list'])) { ?> value="<?php echo $data['d_list']->doctor_fees ?>" <?php } ?>>
			    	</div>
			    </div>
			    <div class="col-md-4">
			    	<div class="form-group">
			    		<label for="">Doctor Phone</label>
			    		<input type="number" class="form-control" name="" id="doc_phn" placeholder="Enter Phone Number" style="margin-top: 10px;" <?php if(isset($data['d_user'])) { ?> value="<?php echo $data['d_user']->mem_phone ?>" <?php } ?>>
			    	</div>
			    </div>
			    <div class="col-md-4">
			    	<div class="form-group">
			    		<label for="">Doctor Email</label>
			    		<input type="email" class="form-control" name="" id="doc_eml" placeholder="Enter Email" style="margin-top: 10px;" <?php if(isset($data['d_user'])) { ?> readonly value="<?php echo $data['d_user']->mem_email ?>" <?php } ?>>
			    	</div>
			    </div>
				<div class="col-md-3">
		            <div class="form-group">
		            	<?php
						if(isset($data['d_list']))
						{ ?>
							<input type="number" id="doc_id" name="" style="display: none;">
					   		<button style="margin-top: 34px" type="button" id="update_doc" class="btn btn-info w-md m-b-5">Update Details</button>
					   	<?php } else { ?>
					   		<button style="margin-top: 34px" type="button" id="add_doc" class="btn btn-info w-md m-b-5">Add Doctor</button>	
					   	<?php } ?>
					</div>
				</div>
				</div>
		</div>
	</div>
</div>
</form>
</div> 		
<?php require APPROOT .'/views/inc_admin/footer.php';?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#add_doc').click(function(){
			var doc_name = $('#doc_name').val();
			var doc_spl = $('#doc_spl').val();
			var doc_fee = $('#doc_fee').val();
			var doc_phone = $('#doc_phn').val();
			var doc_email = $('#doc_eml').val();
			$.ajax({
				url : '<?php echo URLROOT;?>/admin/add_doctor',
				type : 'POST',
				data : {doc_name,doc_spl,doc_fee,doc_phone,doc_email},
				success : function(data)
				{
					swal({
						title: data,
					}, function() {
						window.location = "<?php echo URLROOT;?>/admin/new_doctor";
					});	
				}
			});
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#update_doc').click(function(){
			var doc_name = $('#doc_name').val();
			var doc_spl = $('#doc_spl').val();
			var doc_fee = $('#doc_fee').val();
			var doc_email = $('#doc_eml').val();
			var doc_phone = $('#doc_phn').val();
			var mem_id = <?php echo $data['d_user']->mem_id; ?>;
			$.ajax({
				url : '<?php echo URLROOT;?>/admin/update_doctor',
				type : 'POST',
				data : {doc_name,doc_spl,doc_fee,doc_email,doc_phone,mem_id},
				success : function(data)
				{
					swal({
						title: data,
					}, function() {
						window.location = "<?php echo URLROOT;?>/admin/all_doctors";
					});
				}
			});
		});
	});
</script>

