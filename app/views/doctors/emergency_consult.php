<?php require APPROOT .'/views/inc_doctor/header.php'; ?>
<?php
    if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
    {
        redirect('users/login');
    }
    $em = $data['em'];
?>

<div class="wraper container-fluid">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Update Consultation</h3>
        </div>
            <div class="panel-body " >
				<div class="row">
					<input id="id" class="form-control" value="<?php echo $em->id; ?>" type="hidden" name="" autocomplete="off" readonly>
					<div class="col-md-3">
						<label for="">Patient Name</label>
						<input id="p_id" class="form-control" value="<?php echo $em->p_name; ?>" type="text" name="" autocomplete="off" readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<label for="">Consultation Deatils</label>
						<textarea class="form-control" id="details" rows="5" cols="8"><?php echo $em->details; ?></textarea>
					</div>

					<div class="col-md-3">
						    <button style="margin-top: 102px" id="op_visit" type="button" class="btn btn-info w-md m-b-5">Update</button>
					</div>
				</div>
			</div>

		</div>
	</div>
</div> 
<div class="row" id="timeSlots"> 
	
</div>
</div>
<?php  require APPROOT .'/views/inc_doctor/footer.php';?>

<script type="text/javascript">
	$('#op_visit').click(function(){
		var details = $('#details').val();
		var id = $('#id').val();
		$.ajax({
			url:'<?php echo URLROOT;?>/doctors/update_emergency',
			type:'POST',
			data:{id,details},
			success:function(data)
			{
				$('#details').val('');
				$('#p_id').val('');
				alert(data);
			}
		});
	});
</script>
