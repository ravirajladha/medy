<?php require APPROOT .'/views/inc_admin/header.php'; ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">New Insurance Agency</h3></div>
                <div class="panel-body">
                <form action="<?php echo URLROOT; ?>/admin/saveInsurance" method="POST">	
				<div class="row">
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Agency ID</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" name="agId" placeholder="Enter Agency ID">
				    	</div>
					</div>
					<div class="col-md-3">
		                <div class="form-group">
							<label for="exampleInputEmail1">Agency Name</label>
		                    <input style="margin-top: 10px;" type="text" class="form-control" name="agName" placeholder="Enter Agency Name">
				    	</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<button class="btn btn-primary" >Submit</button>
					</div>
				</div>
				</form>	
			</div>
		</div>
	</div>
</div>

<?php require APPROOT .'/views/inc_admin/footer.php'; ?>
<?php
	if(isset($_SESSION['ins_err']))
	{
		?>
			<script>
			var d = <?php echo json_encode($_SESSION['ins_err']); ?>;
			swal(d);
			</script>
		<?php
	}
	unset($_SESSION['ins_err']);
?>