<?php require APPROOT .'/views/inc_labs/header.php'; ?>

<style type="text/css">
hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid #615ca8
    margin: 1em 0;
    padding: 0; 
}
</style>
<form action="<?php echo URLROOT;?>/labs/create_test" method="POST">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Create Test</h3></div>
                <div class="panel-body">               
				<div class="row">
					<div class="col-md-4">
		                <div class="form-group">
		                    <input style="margin-top: 10px;" type="text" name="test_name" class="form-control" id="exampleInputEmail1" placeholder="Enter Test Name">
				    </div>
				</div>
			
				<div class="col-md-4">
		                <div class="form-group">
		                    <select style="margin-top: 10px;" name='test_type' class="form-control">
		                    	<option>Select Test Type</option>
		                    	<?php foreach($data['test_types'] as $test) { ?>
                                <option value="<?php echo $test->lab_test_type_id; ?>" ><?php echo $test->lab_test_type_name?></option>
                            <?php } ?>
                            </select>
				        </div>
				</div>
				<div class="col-md-4">
		            <div class="form-group">
		                <input style="margin-top: 10px;" type="text" name='test_cost' class="form-control" id="exampleInputEmail1" placeholder="Enter Test Cost">
					</div>
				</div>
				<div class="col-md-4">
		            <div class="form-group">
		                <input style="margin-top: 10px;" type="text" name='test_instruction' class="form-control" id="exampleInputEmail1" placeholder="Enter Test Instructions">
					</div>
				</div>

				<div class="col-md-4">
		            <div class="form-group">

					   
		                    <input style="margin-top: 10px;" type="text" name='test_procedure' class="form-control" id="exampleInputEmail1" placeholder="Enter Test Procedures">

					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					   
		                    <input style="margin-top: 10px;" type="text" name='test_equipments' class="form-control" id="exampleInputEmail1" placeholder="Enter Test Equipments">
					</div>
				</div>
				<div class="col-md-12">
					<br>
				</div>
			</div>
		</div>
	</div>
	
	<div class="panel panel-default">
                <div class="panel-body"> 
				<div class="row"  id="add1">
				<div class="col-md-12">
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12">	
								<div class="form-group">
									<label for="exampleInputEmail1">Value Information</label>
				                        <input style="margin-top: 10px;" name="testval_name[]" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Value Heading">
						    	</div>
					    	</div>
					    	<div class="col-md-6">	
								<div class="form-group">							
			                        <select style="margin-top: 10px;" name="testval_specimen[]" class="form-control">
	                                    <option value="">Select Test Specimen</option>
                        				<option value="EDTA">EDTA</option>
                        				<option value="SERUM">SERUM</option>
                        				<option value="URINE">URINE</option>
                        				<option value="BLOOD">BLOOD</option>
                        				<option value="SPUTUM">SPUTUM</option>
                        				<option value="PUS">PUS</option>
                        				<option value="SWAB">SWAB</option>
                        				<option value="STOOL">STOOL</option>
                        				<option value="ET">ET</option>
                        				<option value="AFB">AFB</option>
	                                </select>
					        	</div>
					    	</div>
					    	<div class="col-md-6">	
								<div class="form-group">									
				                    <input style="margin-top: 10px;" name="testval_unit[]" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Unit">
						    	</div>
					    	</div>
				    	</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12">	
								<div class="form-group">
									<label for="exampleInputEmail1">Value Information</label>	
									<a id="add_div" class="btn btn-purple btn-xs m-b-5" style="float: right;">Add More</a>
				                        <textarea style="margin-top: 10px;" type="text" name="testval_ref[]" rows="3" class="form-control" id="exampleInputEmail1" placeholder="Biol. Ref. Int."></textarea>
						    	</div>
					    	</div>
					    						    	
				    	</div>
					</div>
					
				</div>
				</div>
				<div class="col-md-12">	
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-md m-b-5">Create Test</button>
			    	</div>
		    	</div>
			</div>
		</div>
	</div>
</div>
</div>
</form>
<?php require APPROOT .'/views/inc_labs/footer.php';?>
<script>
$(document).ready(function(){
	var i=1;
	$('#add_div').click(function(){
		i++;

		$('#add1').append('<div id="row'+i+'" class="col-md-12"><hr><div class="col-md-6"><div class="row"><div class="col-md-12"><div class="form-group">\
									<label for="exampleInputEmail1">Value Information</label>\
				                        <input style="margin-top: 10px;" name="testval_name[]" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Value Heading">\
						    	</div>\
					    	</div>\
					    	<div class="col-md-6">\
								<div class="form-group">\
			                        <select style="margin-top: 10px;" name="testval_specimen[]" class="form-control">\
	                                    <option value="">Select Test Specimen</option>\
                        				<option value="EDTA">EDTA</option>\
                        				<option value="SERUM">SERUM</option>\
                        				<option value="URINE">URINE</option>\
                        				<option value="BLOOD">BLOOD</option>\
                        				<option value="SPUTUM">SPUTUM</option>\
                        				<option value="PUS">PUS</option>\
                        				<option value="SWAB">SWAB</option>\
                        				<option value="STOOL">STOOL</option>\
                        				<option value="ET">ET</option>\
                        				<option value="AFB">AFB</option>\
	                                </select>\
					        	</div>\
					    	</div>\
					    	<div class="col-md-6">\
								<div class="form-group">\
				                    <input style="margin-top: 10px;" name="testval_unit[]" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Unit">\
						    	</div>\
					    	</div>\
				    	</div>\
					</div>\
					<div class="col-md-6">\
						<div class="row">\
							<div class="col-md-12">\
								<div class="form-group">\
									<label for="exampleInputEmail1">Value Information</label><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn-xs m-b-5 btn_remove" style="float: right;">X</button><textarea name="testval_ref[]" rows="3" style="margin-top: 10px;" type="text" class="form-control" id="exampleInputEmail1" placeholder="Biol. Ref. Int."></textarea>\
						    	</div>\
					    	</div>\
				    	</div>\
					</div>\
				</div>');

	});
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
});

</script>