<?php require APPROOT .'/views/inc_doctor/header.php'; ?>
<?php
	if(isset($data['editing_ins']))
	{
		foreach ($data['editing_ins'] as $ins)
		{
			$ins_id = $ins->instruction_id;
			$ins_cat = $ins->category;
			$ins_title = $ins->instruction_title;
			$instruction  = $ins->instruction;
		}
	} 
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading">
            	<?php if(!isset($data['editing_ins'])){ ?>
            	<h3 class="panel-title">New Instruction</h3>
            	<?php } else { ?>
            	<a href="<?php echo URLROOT ?>/doctors/delete_instruction/<?php echo $ins_id; ?>"><button class="btn btn-warning btn-xs m-b-5" style="float: right;">Delete this Instruction</button></a>
            	<a href="<?php echo URLROOT; ?>/doctors/instructions"><button class="btn btn-info btn-xs m-b-5" style="float: right; margin-right: 5px;">Create New Instruction</button></a>
            	<h3 class="panel-title">Update Instruction</h3>
            	<?php } ?>
            </div>
                <div class="panel-body">               							
				<div class="row">
				<div class="col-md-12">
					<form action="<?php echo URLROOT; ?>/doctors/save_instruction" method="POST">
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12">	
								<div class="form-group">
									<label for="exampleInputEmail1">Instruction Category</label>
										<input type="number" name="ins_id" value="<?php echo $ins_id ?>" style="display: none;" >
										<input type="number" name="check" <?php if(isset($data['editing_ins'])) { ?> value="2" <?php } else { ?> value="1" <?php } ?> style="display: none;" >
				                        <input style="margin-top: 10px;" type="text" class="form-control" name="ins_category" placeholder="" <?php if(isset($data['editing_ins'])) { ?> value="<?php echo $ins_cat; ?>" <?php } ?>>
						    	</div>
					    	</div>
					    	<div class="col-md-12">	
								<div class="form-group">	
								<label for="exampleInputEmail1">Instruction Title</label>
				                    <input style="margin-top: 10px;" type="text" class="form-control" name="ins_title" placeholder="" <?php if(isset($data['editing_ins'])) { ?> value="<?php echo $ins_title; ?>" <?php } ?>>
						    	</div>
					    	</div>
				    	</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12">	
								<div class="form-group">
									<label for="exampleInputEmail1">Instruction Body</label>
				                        <textarea style="margin-top: 10px;" rows="5" type="text" class="form-control" name="ins_body" placeholder=""><?php if(isset($data['editing_ins'])) { echo $instruction; } ?></textarea>
						    	</div>
					    	</div>
					    	<div class="col-md-12">	
								<div class="form-group">
									<?php if(!isset($data['editing_ins'])){ ?>
					            	<button style="float: right;" class="btn btn-info w-md m-b-5">Create</button>
					            	<?php } else { ?>
					            	<button style="float: right;" class="btn btn-info w-md m-b-5">Update</button>	
					            	<?php } ?>
						    	</div>
					    	</div>					    	
				    	</div>
					</div>
					</form>
				</div>
				</div>

			</div>
		</div>
	</div>
</div>
</div>
<div class="row">
	<div class="col-md-12" style="margin-bottom: 40px;">
<?php
	if(isset($data['all_ins']))
	{
		?>
		<h3 style="margin-left: 10px;">Instructions</h3>
		<?php
		foreach ($data['all_ins'] as $key) {
	?>	
		
		<div class="col-md-3">
			
			<a href="<?php echo URLROOT; ?>/doctors/edit_instruction/<?php echo $key->instruction_id; ?>">
			<div class="panel panel-default" style="background-color: white; box-shadow: 2px 5px 7px #888888; margin-bottom: 10px;">
                <div class="panel-heading"> 
                    <h3 class="panel-title"><?php echo ucwords($key->instruction_title); ?></h3> 
                </div> 
                <div class="panel-body"> 
                    <p>ID: <?php echo ucwords($key->instruction_id); ?></p> 
                    <p>Category: <?php echo ucwords($key->category); ?></p>
                </div> 
            </div>
        	</a>
		</div>
<?php } } ?>
	</div>
</div>

<?php require APPROOT .'/views/inc_doctor/footer.php';?>