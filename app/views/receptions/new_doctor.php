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
            <div class="panel-heading"><h3 class="panel-title">New Doctor</h3></div>
                <div class="panel-body">
				<div class="row">
					<div class="col-md-4">
		                <div class="form-group">
							<label for="exampleInputEmail1">Doctor Name</label>
		                        <input style="margin-top: 10px;" type="text" class="form-control" id="doc_name" placeholder="Enter Doctor Name / ID">
				    </div>
				</div>
			
				<div class="col-md-4">
		                <div class="form-group">
							<label for="exampleInputEmail1">Doctor Speciality</label>
		                        <select style="margin-top: 10px;" class="form-control" id="doc_spl">
                                    <option>Select Doctor Speciality</option>
									<option value='Neurology'>Neurology</option>
									<option value='Dental'>Dental</option>
									<option value='Neurosurgery'>Neurosurgery</option>
									<option value='Pediatrics'>Pediatrics</option>
									<option value='Psychiatry'>Psychiatry</option>
									<option value='Gynecology & Infertility'>Gynecology & Infertility</option>
									<option value='Orthopedics'>Orthopedics</option>
									<option value='Dermatology'>Dermatology</option>
									<option value='Nephrology'>Nephrology</option>
									<option value='Diabetology & Endocrinology'>Diabetology & Endocrinology</option>
									<option value='Urology'>Urology</option>
									<option value='General Medicine & Diabetology'>General Medicine & Diabetology</option>
									<option value='Surgical Gastroenterology'>Surgical Gastroenterology</option>
									<option value='Oncology'>Oncology</option>
									<option value='Cardiology'>Cardiology</option>
									<option value='Surgical Oncology'>Surgical Oncology</option>
									<option value='Orthopedics'>Orthopedics</option>
									<option value='ENT'>ENT</option>
                                </select>
				        </div>
			    </div>
				<div class="col-md-3">
		            <div class="form-group">

					   <button style="margin-top: 34px" type="button" id="add_doc" class="btn btn-info w-md m-b-5">Add Doctor</button>

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
		$('#add_doc').click(function(){
			var doc_name = $('#doc_name').val();
			var doc_spl = $('#doc_spl').val();

			$.ajax({
				url : '<?php echo URLROOT;?>/receptions/add_doctor',
				type : 'POST',
				data : {doc_name,doc_spl},
				success : function(data)
				{
					alert(data);
				}
			});
		});
	});
</script>
<?php
	if(isset($data['d_list']))
	{
		foreach ($data['d_list'] as $key)
		{
			$e_d_name = json_encode($key->doctor_name);
			$e_d_spl = json_encode($key->doctor_speciality);
		?>
			<script type="text/javascript">
    			document.getElementById('doc_name').value = <?php echo $e_d_name;?>;
    			document.getElementById('doc_spl').value = <?php echo $e_d_spl;?>;
    		</script>
		<?php
		}
	}
?>
