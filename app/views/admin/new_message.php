<?php require APPROOT .'/views/inc_admin/header.php'; ?>

<?php
    if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
    {
        redirect('users/login');
    }
?>

<?php
	if(isset($data['p_details']))
 	{
 		foreach ($data['p_details'] as $key4)
 		{
 			$p_id = $key4->patient_id;
 		}
 	}
?>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<div class="row">
	<form >
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><?php if (isset($data['p_details'])) { ?><h3 class="panel-title">Update Patient</h3><?php } else { ?><h3 class="panel-title">New Message</h3><?php } ?></div>
                <div class="panel-body">
				<div class="row" >
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Message Content</label>
		                        <input style="margin-top: 10px;" type="text" class="form-control" id="p_name" placeholder="Enter Message Content" required="true" onkeypress="" >

		                        <input type="number" id="patient_update_id" value="<?php echo $p_id;?>" style="display: none;">
				    	</div>
					</div>
					
				

				
			
			

			
			
			

				
				<div class="col-md-2">
		            <div class="form-group">
		            	<?php if (isset($data['p_details'])) { ?>
		            		<button style="margin-top: 34px" type="button" class="btn btn-info w-md m-b-5" onclick="patient_details(0)">Update Details</button>
		            	<?php } else { ?>
					   <button style="margin-top: 34px" type="button" class="btn btn-info w-md m-b-5" onclick="patient_details()">Add Message</button>
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

	function patient_details()
	{

		
		var p_name = $('#p_name').val();
		
			$.ajax({
			url:'<?php echo URLROOT;?>/admin/add_message_admin',
			type:'POST',
			data:{p_name},
			success : function(data)
			{
				swal({
		            title: "Message Added Successfully",   
		            timer: 2000,   
		            showConfirmButton: false, 
		        });
		  
          		$(location).attr('href', '<?php echo URLROOT;?>/admin/all_message');
			}
		});
	}

	function upload_photo()
	{
        var fd = new FormData(); 
        var files = $('#file')[0].files[0]; 
        fd.append('file', files); 
        $.ajax({ 
            url: '<?php echo URLROOT; ?>/receptions/patient_photo_upload', 
            type: 'POST', 
            data: fd,
            contentType: false, 
            processData: false, 
            success: function(response){ 
            	$('#file').val(null);
            }, 
        });
	}
	function upload_photo1(patid)
	{
		var p = patid;
        var fd = new FormData(); 
		var files = $('#file')[0].files[0]; 
		if(files)
		{
        fd.append('file', files); 
        $.ajax({ 
            url: '<?php echo URLROOT; ?>/receptions/patient_photo_upload1', 
            type: 'POST', 
            data: fd,
            contentType: false, 
            processData: false, 
            success: function(response){ 
            	$('#file').val(null);
            }, 
		});
		}
	}
	
</script>

<script type="text/javascript">
	$('#sel_date').click(function(){
		$('#age').hide();
		$('#dob').show();
	});
</script>

<script type="text/javascript">
	$('#sel_age').click(function(){
		$('#age').show();
		$('#dob').hide();
	});
</script>

<?php
 if(isset($data['p_details']))
 {
 	foreach ($data['p_details'] as $key)
 	{
 		$name = json_encode($key->patient_name);
 		$gen = json_encode($key->patient_gender);
 		$dob = json_encode($key->patient_dob);
 		$age = json_encode($key->patient_age);
 		$phone = json_encode($key->patient_phone);
 		$eml = json_encode($key->patient_email);
 		$adrs = json_encode($key->patient_address);
 		$wght = json_encode($key->patient_weight);
 		$hght = json_encode($key->patient_height);
 	}
 	?>
 		<script type="text/javascript">
 			var name = <?php echo $name;?>;
 			var gen = <?php echo $gen;?>;
 			var dob = <?php echo $dob;?>;
 			var age = <?php echo $age;?>;
 			var phone = <?php echo $phone;?>;
 			var eml = <?php echo $eml;?>;
 			var adrs = <?php echo $adrs;?>;
 			var ht = <?php echo $hght; ?>;
 			var wt = <?php echo $wght; ?>;
 			$('#p_name').val(name);
 			$('#gen').val(gen);
 			$('#dob').val(dob);
 			if(age != null)
 			{
 				$('#age').val(age);
 			}
 			$('#phn').val(phone);
 			$('#email').val(eml);
 			$('#address').val(adrs);
 			$('#wht').val(wt);
 			$('#hgt').val(ht);
 		</script>
 	<?php
 }
?>

<script type="text/javascript">
	$(".innn").intlTelInput({
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
});
</script>