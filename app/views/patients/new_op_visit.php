<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<style type="text/css">
	.ee{
		padding: 5px;
	}
	.ee:hover{
		background-color: lightgray;
	}
</style>
<div class="row">
	<form>
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">New Out Patient Visit</h3></div>
                <div class="panel-body">
				<div class="row">
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Patient Name / ID / Phone</label>
								<input id="id_id" type="" name="" style="display: none;">
		                        <input style="margin-top: 10px;" type="text" class="form-control patient_search" id="pat_name" placeholder="Enter Patient Name / ID / Phone">
		                        <div id="list" style="display: none; width: 254px; border:1px solid lightgray;z-index: 50; max-height: 200px; background-color: white"></div>
				    </div>
				</div>
				<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Doctor Name</label>
		                        <select style="margin-top: 10px;" class="form-control" id="doc_name">
		                        	<option>Select Doctor</option>
		                        	<?php foreach($data['doc_list'] as $key) { ?> 
                                    <option><?php echo $key->doctor_name.' | '.$key->doctor_speciality;?></option>
                              		<?php } ?>
                                </select>
				        </div>
			    </div>
				<div class="col-md-3">
		            <div class="form-group">
					    <label for="exampleInputEmail1">Visit Purpose</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="visit_pur" placeholder="Enter Visit Purpose">
					</div>
				</div>
				<div class="col-md-3">
		            <div class="form-group">
					   <button style="margin-top: 34px" id="op_visit" type="button" class="btn btn-info w-md m-b-5">Create Visit</button>
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
				$('#pat_name').val(null); 
				$('#doc_name').val('Select Doctor');
				$('#visit_pur').val(null);
				alert(data);
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
       	   var res = id.split("|",2);
       	   var res1 = res[0].trim();
       	   var res2 = res[1].trim();
           $('.patient_search').val(res1);
           $('#id_id').val(res2);
           $('#list').fadeOut();
      });
       
      $(document).click(function (event){
        $('#list').fadeOut(); 
      }); 
    });
  </script>