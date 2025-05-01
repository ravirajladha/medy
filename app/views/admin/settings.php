<?php require APPROOT .'/views/inc_admin/header.php'; ?>
<div class="row">
<form action="<?php echo URLROOT;?>/admin/service_provider_details" method="POST" enctype="multipart/form-data">
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Service Provider Details</h3></div>
                <div class="panel-body">
				<div class="row">
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Hospital Name</label>
		                        <input style="margin-top: 10px;" type="text" class="form-control" name="c_name" placeholder="Enter Hospital Name" value="<?php if(isset($data['service']->client_name)) { echo $data['service']->client_name; } ?>">
				    	</div>
					</div>
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Hospital Title</label>
		                        <input style="margin-top: 10px;" type="text" class="form-control" name="c_title" placeholder="Enter Hospital Title" value="<?php if(isset($data['service']->client_title)) { echo $data['service']->client_title; } ?>">
				    	</div>
			    	</div>
					<div class="col-md-3">
			            <div class="form-group">
							<label for="exampleInputEmail1">Hospital Type</label>
		                        <input style="margin-top: 10px;" type="text" class="form-control" name="c_type"  placeholder="Enter Hospital Type" value="<?php if(isset($data['service']->client_type)) { echo $data['service']->client_type; } ?>">
				    	</div>
					</div>
					<div class="col-md-3">
			            <div class="form-group">
							<label for="exampleInputEmail1">Hospital Logo</label>
		                        <input style="margin-top: 10px;" type="file" name="files" class="form-control">
				    	</div>
					</div>
					
					<div class="col-md-3">
			            <div class="form-group">
						   <label for="exampleInputEmail1">Email</label>
			                    <input style="margin-top: 10px;" type="email" class="form-control" name="email" placeholder="Enter Email" value="<?php if(isset($data['service']->client_email)) { echo $data['service']->client_email; } ?>">
						</div>
					</div>
					<div class="col-md-3">
			            <div class="form-group">
						   <label for="exampleInputEmail1">Phone</label>
			                    <input style="margin-top: 10px;" type="text" class="form-control" name="phone" placeholder="Enter Phone Number" value="<?php if(isset($data['service']->client_phone)) { echo $data['service']->client_phone; } ?>">
						</div>
					</div>
					<div class="col-md-3">
			            <div class="form-group">
						   <label for="exampleInputEmail1">Drug Licence No:</label>
			                    <input style="margin-top: 10px;" type="text" class="form-control" name="d_licence" placeholder="Enter Drug Licence No" value="<?php if(isset($data['service']->d_licence)) { echo $data['service']->d_licence; } ?>">
						</div>
					</div>
					<div class="col-md-3">
			            <div class="form-group">
						   <label for="exampleInputEmail1">GST No.</label>
			                    <input style="margin-top: 10px;" type="text" class="form-control" name="gst_no" placeholder="Enter Gst No:" value="<?php if(isset($data['service']->gst_no)) { echo $data['service']->gst_no; } ?>">
						</div>
					</div>
					<div class="col-md-3">
			            <div class="form-group">
						   <label for="exampleInputEmail1">Login Page Image</label>
			                    <input style="margin-top: 10px;" type="file" class="form-control" name="login_image" placeholder="" >
						</div>
					</div>
					<div class="col-md-9">
			            <div class="form-group">
						   <label for="exampleInputEmail1">Hospital Address</label>
			                    <input style="margin-top: 10px;" type="text" class="form-control" name="add" placeholder="Enter Hospital Address" value="<?php if(isset($data['service']->client_address)) { echo $data['service']->client_address; } ?>">
						</div>
					</div>
					<div class="col-md-2">
			            <div class="form-group">
						   <button style="margin-top: 34px" type="submit" class="btn btn-info w-md m-b-5" name="" >Submit</button>
						</div>
					</div>
				</div>
		</div>
	</div>
</div>
</form>
</div>
<div class="row">
	<form action="<?php echo URLROOT;?>/admin/service_provider_details1" method="POST" enctype="multipart/form-data">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading"><h3 class="panel-title">Logo Upload</h3></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="exampleInputEmail1">Hospital Logo</label>
									<input style="margin-top: 10px;" type="file" name="files" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
							<button style="margin-top: 34px" type="submit" class="btn btn-info w-md m-b-5" name="" >Submit</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="row">
	<form action="<?php echo URLROOT;?>/admin/billPattern" method="POST" enctype="multipart/form-data">
		<div class="col-md-12">
			<div class="panel panel-default">
	            <div class="panel-heading"><h3 class="panel-title">Bill Pattern</h3></div>
	            <div class="panel-body">
	            	<div class="row">
	            		<div class="col-md-3">
			                <div class="form-group">
								<label for="exampleInputEmail1">Hospital Name</label>
			                    <select class="form-control" name="pattern">
			                    	<option value="0" <?php if(isset($data['service']->page_pattern)) { if($data['service']->page_pattern == 0) { ?> selected="" <?php } } ?>>Half Page</option>
			                    	<option value="1" <?php if(isset($data['service']->page_pattern)) { if($data['service']->page_pattern == 1) { ?> selected="" <?php } } ?>>Full Page</option>
			                    </select>
					    	</div>
						</div>
	            	</div>
					<div class="row col-md-12">
						<button class="btn btn-info  w-md m-b-5">Submit</button>
					</div>
            	</div>
        	</div>
        </div>
    </form>
</div>
<?php require APPROOT .'/views/inc_admin/footer.php'; ?>