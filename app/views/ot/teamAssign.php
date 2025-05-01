<?php require APPROOT .'/views/inc_ot/header.php'; ?>
<div class="wraper container-fluid">
    <div class="page-title"> 
        <h3 class="title">Assign Team</h3> 
    </div>

    <div class="row">
        <!-- Basic example -->
        <form action="<?php echo URLROOT; ?>/ot/assignTeamToId/<?php echo $data['id']; ?>" method="POST" enctype="multipart/form-data">
        <div class="col-md-12">
            <div class="panel panel-default">   
                <div class="panel-heading">
                	 <a class="btn btn-info btn-xs m-b-5" style="float: right;" id="doctorAdd"> + Add</a> 
                	<h3 class="panel-title">Assign Doctor/Surgeon</h3>
                </div>
                <div class="panel-body">
                    <div class="row" id="doctorDiv">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label for="exampleInputEmail1">Doctor</label>
		                        <select class="form-control" name="doc[]">
                                    <?php foreach ($data['doc'] as $key) {
                                    ?>
		                        	<option><?php echo $key->doctor_name.'('.$key->mem_id.')'; ?></option>
                                    <?php  
                                    }
                                    ?>
		                        </select>
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label for="exampleInputPassword1">Responisability</label>
		                        <input type="text" class="form-control" name="docRes[]" id="exampleInputPassword1" placeholder="">
		                    </div>
                    	</div>
                    </div>
                </div><!-- panel-body -->
            </div> <!-- panel -->
        </div>
    
        <!-- Basic example -->
        <div class="col-md-12">
            <div class="panel panel-default" style="border: white;">
                <div class="panel-heading">
                	 <a class="btn btn-info btn-xs m-b-5" style="float: right;" id="addNur"> + Add</a> 
                	<h3 class="panel-title">Assign Nurse</h3>
                </div>
                <div class="panel-body">
                    <div class="row" id="nurseDiv">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label for="exampleInputEmail1">Nurse</label>
		                        <select class="form-control" name="nur[]">
                                    <?php foreach ($data['nur'] as $nur) {
                                    ?>
		                        	<option><?php echo $nur->mem_name.'('.$nur->mem_id.')'; ?></option>
                                    <?php 
                                    }
                                    ?>
		                        </select>
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label for="exampleInputPassword1">Responisability</label>
		                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" name="nurRes[]">
		                    </div>
                    	</div>
                    </div>
                </div><!-- panel-body -->
            </div> <!-- panel -->
        </div>
   	
            <div class="panel panel-default">
                <div class="panel-heading">
                	 <a class="btn btn-info btn-xs m-b-5" style="float: right;" id="addOth"> + Add</a> 
                	<h3 class="panel-title">Others</h3>
                </div>
                <div class="panel-body">
                    <div class="row" id="othDiv">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label for="exampleInputEmail1">Name</label>
		                        	<input type="text" class="form-control" id="exampleInputPassword1" placeholder="" name="oth[]">
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label for="exampleInputPassword1">Responisability</label>
		                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" name="othRes[]">
		                    </div>
                    	</div>
                    </div>
                </div><!-- panel-body -->
            </div> <!-- panel -->
        </div>
    <div class="row">
    	<div class="">
    		<button class="btn btn-primary" type="submit">Submit</button>
    	</div>
    </div>
    </form>
</div>
<?php require APPROOT .'/views/inc_ot/footer.php'; ?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#doctorAdd').click(function(){
			$('#doctorDiv').append('<div class="col-md-6">\
                    		<div class="form-group">\
                                <select class="form-control" name="doc[]">\
		                        <?php foreach ($data['doc'] as $key) {
                                    ?>
                                    <option><?php echo $key->doctor_name.'('.$key->mem_id.')'; ?></option>\
                                    <?php  
                                    }
                                    ?>
                                    </select>\
		                    </div>\
                    	</div>\
                    	<div class="col-md-6">\
                    		<div class="form-group">\
		                        <input type="text" class="form-control" name="docRes[]" id="exampleInputPassword1" placeholder="">\
		                    </div>\
                    	</div>');
			});
		$('#addNur').click(function(){
			$('#nurseDiv').append('<div class="col-md-6">\
                    		<div class="form-group">\
		                        <select class="form-control" name="nur[]">\
                                    <?php foreach ($data['nur'] as $nur) {
                                    ?>
                                    <option><?php echo $nur->mem_name.'('.$nur->mem_id.')'; ?></option>\
                                    <?php 
                                    }
                                    ?>
                                </select>\
		                    </div>\
                    	</div>\
                    	<div class="col-md-6">\
                    		<div class="form-group">\
		                        <input type="text" class="form-control" name="nurRes[]" id="exampleInputPassword1" placeholder="">\
		                    </div>\
                    	</div>');
		});
		$('#addOth').click(function(){
			$('#othDiv').append('<div class="col-md-6">\
                    		<div class="form-group">\
		                        <input type="text" class="form-control" name="oth[]" id="exampleInputPassword1" placeholder="">\
		                    </div>\
                    	</div>\
                    	<div class="col-md-6">\
                    		<div class="form-group">\
		                        <input type="text" class="form-control" name="othRes[]" id="exampleInputPassword1" placeholder="">\
		                    </div>\
                    	</div>');
		});
	});
</script>