<?php require APPROOT .'/views/inc_doctor/header.php'; ?>
<?php
	$docObj = new Doctor;
?>
<div class="wraper container-fluid">       
    <div class="page-title"> 
        <h3 class="title">Operations</h3> 
    </div>
	<div class="row">
	    <?php foreach ($data['ot'] as $key) {
	    	$pName = $docObj->getPatientName($key->patient_id);
	    ?>
	    <div class="col-sm-4">
	        <div class="panel">
	            <div class="panel-body p-t-10">
	                <div class="media-main">
	                    <a class="pull-left" href="#">
	                        <img class="thumb-lg img-circle bx-s" src="<?php echo URLROOT; ?>/img/pat.jpg" alt="">
	                    </a>
		                    <div class="info">
	                        <h4><?php echo $pName->patient_name; ?>[<?php echo $key->patient_id?>]</h4>
	                        <p class="text-muted"><b>Status:</b>
	                        	<?php
	                        		if($key->status == 0)
	                        		{
	                        			echo "Assigned";
	                        		}
	                        		else if($key->status == 1 || $key->status == 2)
	                        		{
	                        			echo "Active";
	                        		}
	                        		else if($key->status == 3)
	                        		{
	                        			echo "Completed";
	                        		}
	                        		else if($key->status == 4)
	                        		{
	                        			echo 'Cancelled';
	                        		}
	                        	?>
	                        </p>
	                    </div>
	                </div>
	                <div class="clearfix"></div>
	                <hr/>
	                <ul class="social-links list-inline p-b-10">
	                	<div class="row">
	                		<div class="col-sm-8"><span><b>Operation:</b> <?php echo ucwords($key->ot_name); ?></span></div>
	                		<a href="<?php echo URLROOT; ?>/doctors/operationDetails/<?php echo $key->ot_id; ?>"><div class="col-sm-4"><button class="btn btn-purple btn-xs m-b-5" style="float: right;"> View Details</button></a></div>
	                	</div>
	                </ul>
	            </div> <!-- panel-body -->
	        </div> <!-- panel -->
	    </div>
		<?php } ?>
	</div>
</div>
<?php require APPROOT .'/views/inc_doctor/footer.php'; ?>
