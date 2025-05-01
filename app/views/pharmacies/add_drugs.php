<?php require APPROOT .'/views/inc_pharmacy/header.php'; ?>

<div class="row">
	<form>
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Add Drug</h3></div>
                <div class="panel-body">
                	<div class="row">
                		<div class="col-md-4">

		                <div class="form-group">
							<label for="exampleInputEmail1">Barcode</label>
		                        <input style="margin-top: 10px;" type="text" class="form-control" id="barcode" placeholder="Scan Barcode">
				    </div>
                		</div>
                	</div>

				<div class="row">
					<div class="col-md-4">
		                <div class="form-group">
							<label for="exampleInputEmail1">Drug Name</label>
		                        <input style="margin-top: 10px;" type="text" class="form-control" id="drug_name" placeholder="Enter Drug Name">
				    </div>
				</div>

				<div class="col-md-4">
		                <div class="form-group">
							<label for="exampleInputEmail1">Generic Name</label>
		                        <input style="margin-top: 10px;" type="text" class="form-control" id="drug_gen" placeholder="Enter Drug Generic Name">
				    </div>
				</div>
				<div class="col-md-4">
		            <div class="form-group">
					    <label for="exampleInputEmail1">Drug Manufacturer</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="drug_manf" placeholder="Enter Drug Manufacturer">
					</div>
				</div>
				<div class="col-md-4">
		            <div class="form-group">

					   <label for="exampleInputEmail1">Drug Formulation</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="drug_form" placeholder="Enter Drug Formulation">

					</div>
				</div>

				<div class="col-md-4">
		            <div class="form-group">

					   <label for="exampleInputEmail1">Drug Unit Dosage</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="drug_unit_dosage" placeholder="Enter Drug Unit Dosage">

					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					   <label for="exampleInputEmail1">Minimum Drug Package</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="min_drg_pack" placeholder="Enter Minimum Drug Package">
					</div>
				</div>

				<input type="number" name="" id="ch" value="1" style="display: none;">
				<?php if(isset($data['drug_detail'])) { ?>
				<div class="col-md-2">
		            <div class="form-group">
					   <button style="margin-top: 34px" type="button" class="btn btn-info w-md m-b-5 add_drug">Update Drug</button>
					</div>
				</div>
				<?php } 
				else
				{
				?>
				<div class="col-md-2">
		            <div class="form-group">
					   <button style="margin-top: 34px" type="button" class="btn btn-info w-md m-b-5 add_drug">Add Drug</button>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
</form>
</div>
<?php
    if(isset($data['drug_detail']))
    {
       foreach ($data['drug_detail'] as $key)
        {
            $drug_id = $key->drug_id;
            $drug_name = json_encode($key->drug_name);
            $gen_name = json_encode($key->gen_name);
            $drug_manufacturer = json_encode($key->drug_manufacturer);
            $drug_formulation = json_encode($key->drug_formulation);
            $drug_dossage = json_encode($key->drug_dossage);
            $drug_package = $key->drug_package;
        } 
        ?>
        <script type="text/javascript">
            document.getElementById('drug_name').value = <?php echo $drug_name;?>;
            document.getElementById('drug_gen').value = <?php echo $gen_name;?>;
            document.getElementById('drug_manf').value = <?php echo $drug_manufacturer;?>;
            document.getElementById('drug_form').value = <?php echo $drug_formulation;?>;
            document.getElementById('drug_unit_dosage').value = <?php echo $drug_dossage;?>;
            document.getElementById('min_drg_pack').value = <?php echo $drug_package;?>;
            document.getElementById('ch').value = <?php echo $drug_id;?>;
        </script>
        <?php
    }
    
?>
<?php require APPROOT .'/views/inc_pharmacy/footer.php';?>

<script type="text/javascript">
	$(document).ready(function(){
		$('.add_drug').click(function(){
			var ch = $('#ch').val();
			var drug_name = $('#drug_name').val();
			var drug_gen = $('#drug_gen').val();
			var drug_form = $('#drug_form').val();
			var drug_manf = $('#drug_manf').val();
			var drug_unit_dosage = $('#drug_unit_dosage').val();
			var min_drg_pack = $('#min_drg_pack').val();

			$.ajax({
				url : '<?php echo URLROOT;?>/pharmacies/new_drug',
				type : 'POST',
				data : {ch,drug_name,drug_gen,drug_manf,drug_form,drug_unit_dosage,min_drg_pack},
				success : function(response)
				{
					alert(response);
					if(ch == 1)
					{
						$('#drug_name').val("");
						$('#drug_gen').val("");
						$('#drug_form').val("");
						$('#drug_manf').val("");
						$('#drug_unit_dosage').val("");
						$('#min_drg_pack').val("");
					}
					else
					{
						window.location.href = "<?php echo URLROOT;?>/pharmacies/all_drugs";
					}
				}
			})
		});
	});
</script>
