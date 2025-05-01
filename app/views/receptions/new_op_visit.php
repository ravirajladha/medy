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

	#list
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
        <div class="panel-heading"><h3 class="panel-title">New Out Patient Visit</h3>
                      <!--  <label style="float: right;margin-top: -15px; cursor: pointer; color: #7FB3D5;font-size: 14px;" class="c_button" id="tggle_div"> Custom DateTime</label> -->
        </div>
            <div class="panel-body " >
				<div class="row">
					<div class="col-md-3">
		          <div class="form-group">
  							<label for="">Patient Name / ID / Phone</label>
							  <input id="id_id" type="text" name="" style="display: none;"  autocomplete="off"
							  <?php  
								if(isset($data['cTV']->patient_name))
								{
									?>
										value="<?php echo $data['cTV']->patient_id; ?>";
									<?php
								}
							?>>
                			<input style="margin-top: 10px;" autocomplete="off" type="text" class="form-control patient_search" id="pat_name_q" placeholder="Enter Patient Name / ID / Phone" required="true"
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
		             	<select style="margin-top: 6px;" class="select2" id="doc_name" required="true" onchange="showTimeslots(this.value)">
                    	<option value="Select Doctor">Select Doctor</option>
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
						<label for="exampleInputEmail1">Visit Purpose</label>
			          	<input style="margin-top: 10px;" type="text" class="form-control" id="visit_pur" placeholder="Enter Visit Purpose" autocomplete="off" required="true">
						</div>
					</div>
					<div class="col-md-3">
              <div class="first_div">
                  <div class="form-group">
                    <button style="margin-top: 34px" id="op_visit" type="button" class="btn btn-info w-md m-b-5">Create Visit</button>
                  </div>
              </div>
              <div class="sec_div" style="display: none;">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Select Date and Time</label>

                          <input style="margin-top: 10px;" type="datetime-local" class="form-control" id="dt" placeholder="Enter Visit Purpose" autocomplete="off">

                      </div>
                      <div class="form-group">
                       <button style="margin-top: 34px; float:right;" id="op_visit1" type="button" class="btn btn-info w-md m-b-5">Create Visit</button>
                      </div>
              </div>
					</div>

				</div>
			</div>

		</div>
	</div>
</div> 
<div class="row" id="timeSlots"> 
	
</div>
</div>
<?php  require APPROOT .'/views/inc_reception/footer.php';?>

<script type="text/javascript">
	$('#op_visit').click(function(){
		var d_name = $('#doc_name').children('option:selected').val();
		var visit_pur = $('#visit_pur').val();
		var p_name = $('#id_id').val();
		$.ajax({
			url:'<?php echo URLROOT;?>/receptions/create_visit',
			type:'POST',
			data:{p_name,d_name,visit_pur},
			success:function(data)
			{
				$('#doc_name').val('');
				$('#visit_pur').val('');
				$('#pat_name_q').val(''); 
				swal(data);
			}
		});
	});
</script>

<script type="text/javascript">
  $('#op_visit1').click(function(){
    var d_name = $('#doc_name').children('option:selected').val();
    var visit_pur = $('#visit_pur').val();
    var p_name = $('#id_id').val();
    var dt = $('#dt').val();
    $.ajax({
      url:'<?php echo URLROOT;?>/receptions/create_visit1',
      type:'POST',
      data:{p_name,d_name,visit_pur,dt},
      success:function(data)
      {
        $('#doc_name').val('');
        $('#visit_pur').val('');
        $('#pat_name_q').val(''); 
        $('#dt').val('');
        alert(data); 
        // if(data == 'updated')
        // {
        //     swal({
        //         title: "Patient Visit Created",   
        //         timer: 2000,   
        //         showConfirmButton: false 
        //     });
        //     setTimeout(function() {
        //         location.reload();
        //     }, 2200);
          
        // }
        // else if(data == 'cannot')
        // {
        //     swal({
        //         title: "Cannot Create Visit...!Because Patient Is Admitted",   
        //         timer: 2000,   
        //         showConfirmButton: false 
        //     });
        //     setTimeout(function() {
        //         location.reload();
        //     }, 2200);
        // }
        // else
        // {
        //     swal({
        //           title: "Patient visit already exists for same doctor",   
        //           timer: 2000,   
        //           showConfirmButton: false 
        //       });
        //       setTimeout(function() {
        //           location.reload();
        //       }, 2200);
        // }     
      
      }
    });
  });
</script>

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
  $('#tggle_div').click(function(){
    $('.first_div').css({'display':'none'});
    $('.sec_div').css({'display':'block'});
    $('.c_button').css({'display':'none'});
  });

function showTimeslots(dId)
{
	$.ajax({
		url: '<?php echo URLROOT; ?>/doctors/showTimeSlotsByDoctorId',
		type: 'POST',
		data: {dId},
		success: function(timeSlot)
		{
			$('#timeSlots').html(timeSlot);
		}
	});
}
</script>