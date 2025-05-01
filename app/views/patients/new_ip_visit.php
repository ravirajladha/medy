<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<div class="row">
	<form>
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">New In Patient Admit</h3></div>
                <div class="panel-body">
				<div class="row">
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Patient Name / ID</label>
		                        <input style="margin-top: 10px;" type="text" class="form-control" id="pat_name1" placeholder="Enter Patient Name / ID">
				    </div>
					</div>
			
				<div class="col-md-3">
		             <div class="form-group">
						<label for="exampleInputEmail1">Doctor Name</label>
	                        <select style="margin-top: 10px;" class="form-control" id="doc_name1">
	                        	<option>Select Doctor</option>
	                        	<?php foreach($data['doc_list'] as $key) { ?> 
                                <option><?php echo $key->doctor_name.' | '.$key->doctor_speciality;?></option>
                          		<?php } ?>
                            </select>
			        </div>
			    </div>	
				<div class="col-md-3">
		            <div class="form-group">
					    <label for="exampleInputEmail1">Bed ID</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="visit_pur1" placeholder="Enter Bed ID">
					</div>
				</div>
				<div class="col-md-3">
		            <div class="form-group">

					   <button style="margin-top: 34px" id="ip_admit" type="button" class="btn btn-info w-md m-b-5">Create Admission</button>

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
	$('#ip_admit').click(function(){
		var p_name = $('#pat_name1').val();
		var d_name = $('#doc_name1').children('option:selected').val();
		var visit_pur = $('#visit_pur1').val();
		$.ajax({
			url:'<?php echo URLROOT;?>/receptions/create_admission',
			type:'POST',
			data:{p_name,d_name,visit_pur},
			success:function(data)
			{
				$('#pat_name1').val(null); 
				$('#doc_name1').val('Select Doctor');
				$('#visit_pur1').val(null);
				alert(data);
			}
		});
	});
</script>