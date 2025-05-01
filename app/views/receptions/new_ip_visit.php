<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<?php
    if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
    {
        redirect('users/login');
    }  
?>
<style type="text/css">
	.ee{
		padding: 5px;
	}
	.ee:hover{
		background-color: lightgray;
	}
	.ee1{
		padding: 5px;
	}
	.ee1:hover{
		background-color: lightgray;
	}
	.ee32{
		padding: 5px;
	}
	.ee32:hover{
		background-color: lightgray;
	}

	#list, #list1, #list32
	{
	max-height: 400px;
	max-width: 237px;
	min-width: 237px;
	position: absolute;
	background-color: white;
	border: solid;
	border-width: 1px;
	border-color: lightgray;
	font-size: 13px;
	cursor: pointer;
	z-index: 50;
	text-align: left;
	display: none;
	}
</style>

<div class="wraper container-fluid">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">New In Patient Admit</h3>
           	<label style="float: right;margin-top: -15px; cursor: pointer; color: #7FB3D5;font-size: 14px;" for="exampleInputEmail1" id="addIns" class="c_button">Add Insurance</label>
           	<label style="float: right;margin-top: -15px; cursor: pointer; color: #7FB3D5;font-size: 14px; display: none;" for="exampleInputEmail1" id="closeIns" class="c_button">Close Insurance</label>
            </div>
                <div class="panel-body first_div">
				<div class="row">
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Patient Name / ID</label>
								<input id="id_id" type="" name="" style="display: none;"  autocomplete="off"
								<?php  
									if(isset($data['cTV']->patient_name))
									{
										?>
											value="<?php echo $data['cTV']->patient_id; ?>";
										<?php
									}
								?>
								>
								<input style="margin-top: 10px;" autocomplete="off" type="text" class="form-control patient_search" id="pat_name_q" placeholder="Enter Patient Name / ID / Phone"
								<?php  
									if(isset($data['cTV']->patient_name))
									{
										?>
											value="<?php echo $data['cTV']->patient_name;?>(<?php echo $data['cTV']->patient_id; ?>)";
										<?php
									}
								?>
								>
		                        <div id="list"></div>
				    	</div>
					</div>
					<div class="col-md-3">
			            <div class="form-group">
							<label for="exampleInputEmail1">Doctor Name</label>
								
		                        <select class="select2" style="margin-top: 6px; border: none;" id="doc_name1">
								<?php foreach($data['doc_list'] as $key) { ?> 
								<option
								value="<?php echo $key->mem_id; ?>"
									<?php
									if(isset($data['cTV']->doctor_name))
									{
										if($key->doctor_name == $data['cTV']->doctor_name)
										{
											?>
												selected="true"
											<?php
										}
									}
										?>
									><?php echo ucwords($key->doctor_name).' | '.$key->doctor_speciality;?>
								</option>
								<?php } ?>
	                            </select>
				        </div>
				    </div>	
					<div class="col-md-3">
			            <div class="form-group">
						    <label for="exampleInputEmail1">Bed ID</label>
			                    <input style="margin-top: 10px;" type="text" class="form-control" id="visit_pur" placeholder="Enter Bed ID">
			                    <div id="list32"></div>
						</div>
					</div>
					<div class="col-md-3 insuHide" style="display: none;">
			            <div class="form-group">
						    <label for="exampleInputEmail1">Insurance Number</label>
			                    <input style="margin-top: 10px;" type="text" class="form-control" id="agencyNumber" placeholder="Enter Insurance Number">
						</div>
					</div>
				</div>
				<div class="row insuHide" style="display: none;">
					<div class="col-md-3">
			            <div class="form-group">
						    <label for="exampleInputEmail1">Insurance Agency Name</label>
								<select class="form-control" style="margin-top: 10px;" id="agencyName">
									<option value="NULL">--SELECT--</option>
			                    	<?php foreach ($data['ins'] as $value) {
			                    	?>
			                    	<option><?php echo $value->insurance_name; ?></option>
			                    	<?php } ?>
			                    </select>
						</div>
					</div>
					<div class="col-md-3">
			            <div class="form-group">
						    <label for="exampleInputEmail1">Insurance Agency Expiry</label>
			                    <input style="margin-top: 10px;" type="date" class="form-control" id="insExpiry" placeholder="Enter Bed ID">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
			            <div class="form-group">
						   <button style="margin-top: 34px;" id="ip_admit" type="button" class="btn btn-info w-md m-b-5">Create Admission</button>
						</div>
					</div>  
				</div>
		</div>

<!-- 

		 <div class="panel-body sec_div" style="display: none;">
				<div class="row">
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Patient Name / ID</label>
								<input id="id_id1" type="" name="" style="display: none;"  autocomplete="off">
								<input style="margin-top: 10px;" autocomplete="off" type="text" class="form-control patient_search1" id="pat_name_q1" placeholder="Enter Patient Name / ID / Phone"
								
								>
		                        <div id="list1"></div>
				    	</div>
					</div>
			
				<div class="col-md-3">
		             <div class="form-group">
						<label for="exampleInputEmail1">Doctor Name</label>
	                        <select class="select2" style="margin-top: 6px; border: none;" id="doc_name2">
	                        	<option>Select Doctor</option>
	                        	
                            </select>
			        </div>
			    </div>	
				<div class="col-md-3">
		            <div class="form-group">
					    <label for="exampleInputEmail1">Bed ID</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="visit_pur" placeholder="Enter Bed ID">
		                    
					</div>
				</div>
				<div class="col-md-3">
		            <div class="form-group">
					    <label for="exampleInputEmail1">Admission Date</label>
		                    <input style="margin-top: 10px;" type="datetime-local" class="form-control" id="adm_date1" placeholder="Enter Bed ID">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-3"></div>
				<div class="col-md-3"></div>
				<div class="col-md-3"> 
		            <div class="form-group">
					   <button style="margin-top: 10px;float: right;" id="ip_admit1" type="button" class="btn btn-info w-md m-b-5">Create Admission</button>
					</div>
				</div>
			</div>
		</div> -->
	</div>
</div>
</div>
</div> 		
<?php require APPROOT .'/views/inc_reception/footer.php';?>
  <script type="text/javascript">
    $(document).ready(function(){
      $('.patient_search').keyup(function(){
        var query3 = $(this).val();
        if(query3!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/receptions/get_auto_patient_name2',
            type:'POST',
            data:{query3:query3},
            success:function(data)
            {
              $('#list').fadeIn();
              $('#list').html(data);
            }
          });
        }
        else
        {
           $('#list').fadeOut();
        }
      });
       $(document).on('click', '.ee', function(){
       	   var id = $(this).text();
       	   var res = id.split("(",2);
       	   var res1 = res[0].trim();
           var res2 = res[1].split(")",2);
       	   var res2 = res2[0].trim();
           $('.patient_search').val(res1);
           $('#id_id').val(res2);
           $('#list').fadeOut();
      });
       
      $(document).click(function (event){
        $('#list').fadeOut(); 
      }); 
    });
  </script>

    <script type="text/javascript">
    $(document).ready(function(){
      $('.patient_search1').keyup(function(){
        var query3 = $(this).val();
        if(query3!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/receptions/get_auto_patient_name3',
            type:'POST',
            data:{query3:query3},
            success:function(data)
            {

              $('#list1').fadeIn();
              $('#list1').html(data);
            }
          });
        }
        else
        { 
           $('#list1').fadeOut();
        }
      });
       $(document).on('click', '.ee1', function(){
       	   var id = $(this).text();
       	   var res = id.split("(",2);
       	   var res1 = res[0].trim();
       	   var res2 = res[1].split(")",2);
       	   var res2 = res2[0].trim();
           $('.patient_search1').val(res1);
           $('#id_id1').val(res2);
           $('#list1').fadeOut();
      });
       
      $(document).click(function (event){
        $('#list1').fadeOut(); 
      }); 
    });
  </script>	

<script type="text/javascript">
	$('#ip_admit').click(function(){
		var p_name = $('#id_id').val();
		var d_name = $('#doc_name1').children('option:selected').val();
		var visit_pur = $('#visit_pur').val();
		var insNumber = $('#agencyNumber').val();
		var insName = $('#agencyName').children('option:selected').val();
		var insExpiry = $('#insExpiry').val();
		$.ajax({
			url:'<?php echo URLROOT;?>/receptions/create_admission',
			type:'POST',
			data:{p_name,d_name,visit_pur,insNumber,insName,insExpiry},
			success:function(data)
			{
				swal({
					title: data,
				}, function() {
					location.reload();
				});
			}
		});
	});
</script>

<script type="text/javascript">
	$('#ip_admit1').click(function(){
		var p_name = $('#id_id1').val();
		var d_name = $('#doc_name2').children('option:selected').val();
		var adm_date1 = $('#adm_date1').val();
		var ins_id = $('#in')
		$.ajax({
			url:'<?php echo URLROOT;?>/receptions/create_admission1',
			type:'POST',
			data:{p_name,d_name,visit_pur,adm_date1},
			success:function(data)
			{
				swal({
					title: data,
				}, function() {
					location.reload();
				});
			}
		});

	});
</script>

<script type="text/javascript">
	$('#tggle_div').click(function(){
		$('.first_div').css({'display':'none'});
		$('.sec_div').css({'display':'block'});
		$('.c_button').css({'display':'none'});
	});
</script>

<script type="text/javascript">
	$('#addIns').click(function(){
		$('.insuHide').css({'display':'block'});
		$('#addIns').css({'display':'none'});
		$('#closeIns').css({'display':'block'});
	});
	$('#closeIns').click(function(){
		$('.insuHide').css({'display':'none'});
		$('#addIns').css({'display':'block'});
		$('#closeIns').css({'display':'none'});
	});
</script>

<script type="text/javascript">
    $(document).ready(function(){
      $('#visit_pur').keyup(function(){
        var query3 = $(this).val();
        if(query3!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/receptions/getBeds',
            type:'POST',
            data:{query3:query3},
            success:function(data)
            {
              $('#list32').fadeIn();
              $('#list32').html(data);
            }
          });
        }
        else
        { 
           $('#list32').fadeOut();
        }
      });
       $(document).on('click', '.ee32', function(){

           var id = $(this).text();
           $('#visit_pur').val(id);
           $('#list32').fadeOut();
      });
       
      $(document).click(function (event){
        $('#list32').fadeOut(); 
      }); 
    });
  </script>