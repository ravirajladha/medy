<?php require APPROOT .'/views/inc_ot/header.php'; ?>
<div class="wraper container-fluid">
    <div class="page-title"> 
        <h3 class="title">Current Operation Details</h3> 
    </div>
    <div class="col-md-12">
    	<div class="row">
    
    		<?php
    	
    		foreach ($data['ot'] as $key) {
    			

    		?>
    		<div class="col-md-4">
                <div class="panel">
                    <div class="panel-body p-t-10">
                        <div class="media-main">
                            <a class="pull-left" href="#">
                                <img class="thumb-lg img-circle bx-s" src="<?php echo URLROOT; ?>/img/pat.jpg" alt="">
                            </a>
                            <div class="info">
                                <h4><?php echo ucwords($key->patient_name); ?></h4>
                                <p class="text-muted">Patient ID: <?php echo $key->patient_id; ?> <br>
                                Gender: <?php echo $key->patient_gender; ?>
                                <br>	
                                Age: <?php if(empty($key->patient_age))
									{ echo date('Y') - date('Y',strtotime($key->patient_dob));
									} else echo $key->patient_age; ?>
									<br> 
                                Admit Date & time: <?php echo date('d-m-Y h:i A',strtotime($key->admission_date_time)); ?></p>
                                
                            </div>
                        </div>
                       <div class="clearfix"></div>
                   		<hr/>
                            <ul class="social-links list-inline p-b-10">
                                <li>
                                   <span>Status: <span style="color:black;"><?php if($key->status == 0 or $key->status == 1 or $key->status == 2) {
                                   	echo "Pending";
                                   }
                                   elseif ($key->status == 4) {
                                   	echo "canceled";
                                   }
                                   else {
                                   	echo "Completed";
                                   } ?></span></span>
                                </li>
                               
                                <br>
                                	
                            </ul>
                            <pre class="text-muted" style="height: 100px;">Description: <?php echo ucwords($key->ot_description); ?></pre>
                            <button style="float: right;" class="btn btn-success btn-xs m-b-5" data-toggle="modal" data-target="#myModal<?php echo $key->ot_id; ?>">Attend</button>
                    </div> <!-- panel-body -->
                </div> <!-- panel -->
    		</div>
    		<div id="myModal<?php echo $key->ot_id; ?>" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">OT Details</h4>
			      </div>
			      <div class="modal-body">
			      	<h4>Patient Name: <?php echo ucwords($key->patient_name); ?></h4>
			        <p><?php echo ucwords($key->ot_description); ?></p>
			        <div class="row">
			        	<div class="col-md-12">
			        		<h4>Medicine</h4>
			        		<div class="col-md-8">
			        			<label>Medicine Name</label>
			        			<input type="text" class="form-control" name="">
			        		</div>
			        		<div class="col-md-4">
			        			<label>Quantity</label>
			        			<input type="text" class="form-control" name="">
			        		</div>
			        	</div>
			        	<div class="col-md-12">
			        		<h4>Nurse Service</h4>
			        		<div class="col-md-8">
			        			<label>Service Name</label>
			        			<input type="text" class="form-control" name="">
			        		</div>
			        		<div class="col-md-4">
			        			<label>Cost</label>
			        			<input type="text" class="form-control" name="">
			        		</div>
			        	</div>
			        	<div class="col-md-12">
			        		<h4>Feedback</h4>
			        		<div class="col-md-12">
			        			<textarea class="form-control"></textarea>
			        		</div>
			        	</div>
			        </div>
			      </div>
			      <br>
			      <div class="modal-footer">
			      	<button type="button" class="btn btn-success">Finish OT</button>
			        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
			      </div>
			    </div>

			  </div>
			</div>
    		<?php } ?>
    	</div>
    </div>
</div>

<?php require APPROOT .'/views/inc_ot/footer.php'; ?>