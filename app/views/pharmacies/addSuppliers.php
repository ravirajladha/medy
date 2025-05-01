<?php require APPROOT .'/views/inc_pharmacy/header.php'; ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Add Supplier</h3></div>
            <div class="panel-body">
            	<form action="<?php echo URLROOT; ?>/pharmacies/addSupplier" method="POST">
            	<div class="row">
            		<div class="col-md-4">
		                <div class="form-group">
							<label for="exampleInputEmail1">Name</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="barcode" placeholder="Enter Name" name="name">
				    	</div>
            		</div>
            		<div class="col-md-4">
		                <div class="form-group">
							<label for="exampleInputEmail1">Phone</label>
		                    <input style="margin-top: 10px;" type="number" class="form-control" id="barcode" placeholder="Enter Name" name="phone">
				    	</div>
            		</div>
            		<div class="col-md-4">
		                <div class="form-group">
							<label for="exampleInputEmail1">Email</label>
		                    <input style="margin-top: 10px;" type="email" class="form-control" id="barcode" placeholder="Enter Name" name="email">
				    	</div>
            		</div><div class="col-md-4">
		                <div class="form-group">
							<label for="exampleInputEmail1">GSTIN</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="barcode" placeholder="Enter Name" name="gstin">
				    	</div>
            		</div>
            		<div class="col-md-8">
		                <div class="form-group">
							<label for="exampleInputEmail1">Address</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" id="barcode" placeholder="Enter Name" name="address">
				    	</div>
            		</div>
            		<div class="col-md-8">
		                <div class="form-group">
							<button class="btn btn-primary">Submit</button>
				    	</div>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT .'/views/inc_pharmacy/footer.php'; ?>