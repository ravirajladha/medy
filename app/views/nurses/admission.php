<?php require APPROOT .'/views/inc_nurse/header.php'; ?>
<script type="text/javascript">
window.onload = function() {
    //considering there aren't any hashes in the urls already
    if(!window.location.hash) {
        //setting window location
        window.location = window.location + '#loaded';
        //using reload() method to reload web page
        window.location.reload();
    }
}
</script>
<style type="text/css">
		hr.new1 {
		border-top: 1px solid gray;
		}
	    #list4{
        max-height: 100px;
        max-width: 410px;                         
        min-width: 410px;
        position: absolute;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        font-size: 16px;
        cursor: pointer;
        z-index: 50;
        text-align: left;
      }

      .nursingServiceList
      {
      	max-height: 100px;
        max-width: 340px;                         
        min-width: 340px;
        position: absolute;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        font-size: 13px;
        cursor: pointer;
        z-index: 50;
        text-align: left;
      }
      .cc:hover{
      	background-color: lightgray;
      }

      .forCursor:hover
      {
      	background-color: lightgray;
      }

      .bnm{
        max-height: 100px;
        max-width: 410px;                         
        min-width: 410px;
        position: absolute;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        font-size: 16px;
        cursor: pointer;
        z-index: 50;
        text-align: left;      	
      }

      .ccx:hover{
      	background-color: lightgray;
      }



</style>
<?php foreach ($data['p_data'] as $key)
{
	$patient_name = $key->patient_name;
	$patient_id = $key->patient_id;
	$admit_id = $key->ipd_admit_id;
	$bed = $key->ipd_bed_id;
	$admission_date = $key->admission_date_time;
	$patient_address = $key->patient_address;
	$patient_gender = $key->patient_gender;
	$patient_phone = $key->patient_phone;
	$patient_email = $key->patient_email;
	$patient_dob = $key->patient_dob;	
	$hypertention = $key->hypertension;
	$diabetes = $key->diabetes;
	$coronary = $key->coronary;
	$cerebro = $key->cerebro;
	$dyslipidaemia = $key->dyslipidaemia;
	$hypothyroidism = $key->hypothyroidism;
	$other = $key->other;
	$past_his = $key->patient_history;
	$fam = $key->family_history;
	$mon = $key->patient_history_mon;
    $year = $key->patient_history_year;
}

foreach ($data['main_ipd'] as $test)
{
	$ipd_initial_condition = $test->ipd_initial_condition;
	$ipd_first_diagnosis = $test->ipd_first_diagnosis;
	$dis = $test->discharge_date_time;
	$doc_id = $test->ipd_doctor_id;
	$advice = $test->advice;
}

$doc_obj = new Nurses;
$doc_name = $doc_obj->call_for_doc_name($doc_id);
?>
<div class="wraper container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body" style="padding-top: 0px;">
                <div class="col-md-10">
                	<div class="col-lg-12">
                		<b>Name:</b> <?php echo ucwords($patient_name); ?>
                	</div>
                	<div class="col-lg-12">
                		<b>Patient ID:</b> <?php echo $patient_id;?>
                	</div>
                	<div class="col-lg-12">
                		<b>Doctor:</b> Dr. <?php echo ucwords($doc_name);?>
                	</div>
                	<div class="col-lg-12">
                		<b>Admission ID:</b> <?php echo $admit_id;?>
                	</div>
                	<div class="col-lg-12">
                		<b>Bed:</b> <?php echo $bed; ?>
                	</div>
                </div>
                <div class="col-md-2">
                	<!-- <button style="float: right; width: 115px;" class="btn btn-purple btn-xs m-b-5">Upload Report</button> -->
                	<button style="float: right;  width: 115px;" class="btn btn-info btn-xs m-b-5">Assign Team</button>
                	<?php
                	if($dis != NULL)
                	{ ?>
                		<button style="float: right;  width: 115px;" class="btn btn-primary btn-xs m-b-5">Discharge Summary</button> 
                	
                		<button style="float: right;  width: 115px;" class="btn btn-danger btn-xs m-b-5">Cancel Discharge</button> <?php
                	}
                	?>
                </div>
            	</div>
            </div>
		</div>
	</div>
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default p-0  m-t-20">
                <div class="panel-body p-0">
                    <div class="list-group no-border mail-list">
                      <a href="#home" data-toggle="tab" aria-expanded="true" class="list-group-item">Present Admission</a>
                      <a href="#homenew1" data-toggle="tab" aria-expanded="true" class="list-group-item">Medication / Advice</a>
                      <a href="#homenewnurse" data-toggle="tab" aria-expanded="true" class="list-group-item">Nursing</a>
                      <a href="#homenew2" data-toggle="tab" aria-expanded="true" class="list-group-item">Test Reports</a>
                      <a href="#home2" data-toggle="tab" aria-expanded="false" class="list-group-item">Co-Morbidities</a>
                      <a href="#home3" data-toggle="tab" aria-expanded="false" class="list-group-item">Patient History</a>
                      <a href="#home4" data-toggle="tab" aria-expanded="false" class="list-group-item">Basic Information</a>
                      <a href="#home5" data-toggle="tab" aria-expanded="false" class="list-group-item">Visits to Clinic<br>Prescription  & Reports</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                  	<div class="panel panel-default m-t-20">
                		<div class="panel-body p-t-10">
                            <div class="col-lg-12"> 
                            	<div class="tab-content"> 
                					<div class="tab-pane active" id="home">
                					 	<ul class="nav nav-tabs nav-justified" style="max-width:800px; overflow-x:scroll;" ><li class="" style="min-width: 200px;">
					                                <a href="#home-2" data-toggle="tab" aria-expanded="true"> 
					                                    <span class="visible-xs">Initial Diagnosis</span> 
					                                    <span class="hidden-xs">Initial Diagnosis<br>&nbsp;</span> 
					                                </a>
					                            </li>
					                            <?php
					                            $t = 1;
					                            foreach ($data['ipd'] as $test)
					                            {
					                            	$day = $test->ipd_day_val;
					                            	$day1 = date('d-m-Y', strtotime($day));
					                            	$day_name = date('D', strtotime($day1));
					                            	$today = date('d-m-Y');
												?> 
												<?php if($today == $day1) { ?>
					                            <li class="active" style="min-width: 200px;"> 
					                            <?php } 
					                            else { ?>
					                            <li class="" style="min-width: 200px;"> 
					                            <?php } ?>	
					                                <a href="#pro<?php echo $t;?>" data-toggle="tab" aria-expanded="false"> 
					                                    <span class="visible-xs"><?php echo "Day ".$t." | ".$day_name;?>
					                                    	<br>
					                                    	<?php echo $day1;
					                                    	?></span> 
					                                    <span class="hidden-xs">
					                                    	<?php echo "Day ".$t." | ".$day_name;?>
					                                    	<br>
					                                    	<?php echo $day1;
					                                    	?>
					                                    </span> 
					                                </a> 
					                            </li>
					                            <?php
					                            	$t = $t+1;
					                            	} 
					                            ?> 
					                        </ul> 
					                        <div class="tab-content"> 
					                        	
					                            <div class="tab-pane" id="home-2"> 
					                            	<form action="<?php echo URLROOT;?>/nurses/save_initial_diag" method="POST">
					                            	<input type="number" name="admit_id" value="<?php echo $admit_id;?>" style="display: none;">
					                            	<input type="number" name="pat_id" value="<?php echo $patient_id;?>" style="display: none;">
					                                <div class="form-group">
					                                        <label for="exampleInputEmail1">Initial Condition</label>
					                                        <input type="text" class="form-control" name="init_cond" placeholder="Enter Present Condition Here" value="<?php echo $ipd_initial_condition;?>" readonly="">
					                                </div>
					                                <!-- <div class="form-group">
					                                        <label for="exampleInputEmail1">First Diagnosis</label>
					                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Diagnosis Details">
					                                </div> -->
					                               <!--  <div class="form-group">
					                                        <label for="exampleInputEmail1">First Investigation</label>
					                                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter Investigation Details">
					                                </div> -->
					                                <div class="form-group">
					                                        <label for="exampleInputEmail1">First Diagnosis</label>
					                                        <input type="text" class="form-control" name="first_diag" placeholder="Enter Investigation Details" value="<?php echo $ipd_first_diagnosis?>" readonly="">
					                                </div>
					                                <!-- <div class="form-group">
					                                        <label for="exampleInputEmail1">Initial Test Advised</label>
					                                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter Investigation Details">
					                                </div> -->
					                                <!-- <div class="form-group">
					                                        <label for="exampleInputEmail1">Initial Notes</label>
					                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Any Other Information">
					                                </div> -->
				                            			<!-- <div class="form-group">
				                            				 <label for="exampleInputEmail1">Instructions</label>
				                            				 <button class="btn btn-danger btn-xs m-b-5" style="float: right;" data-toggle="modal" data-target="#intructionmodal">Select Instruction</button>
				                            				<textarea type="text" class="form-control" id="exampleInputEmail1"></textarea>
				                            			</div> -->
				                            			<!-- <div class="form-group">
				                            				<button class="btn btn-primary w-md m-b-5" type="submit" style="float: right;">Update</button>
				                            			</div> -->
				                            		</form>
					                            </div>
					                    <?php
					                    $m = 1;
					                    foreach($data['ipd'] as $test2)
					                    { 
					                    	$dayin = $test2->ipd_day_val;
					                    	$dayx = date('d-m-Y', strtotime($dayin));
					                    	$pres = $test2->ipd_day_prescription;
					                    	$proc = $test2->ipd_day_procedure;
					                    	$nS = $test2->nursing_service;
					                    ?>
					                    <!-- dynamic tab content -->
					                    <?php if($today == $dayx) { ?>
					                            <div class="tab-pane active" id="pro<?php echo $m;?>"> 
					                            <?php } 
					                            else { ?>
					                            <div class="tab-pane" id="pro<?php echo $m;?>">
					                    <?php } 
					                        if($pres != null) { ?>
					                       	<!-- <h4>Day's Medicine</h4>
					                        <button class="btn btn-info btn-xs m-b-5" onclick="myFunctionx()">Add Medicine</button> -->

<!-- ############### on click open add medicine ################ -->
<!-- <div style="display: none;" class="myDIVx">
<form action="<?php echo URLROOT;?>/nurses/save_medication_perticular/<?php echo $admit_id;?>" method="POST">
	<div class="row">
		<hr style=" border-top: 1px solid lightgray;">
		<input type="number" name="pat" style="display: none;" value="<?php echo $patient_id;?>">
		<div class="col-lg-12">
			<b>Prescription &nbsp;&nbsp;</b>
			<a id="" class="btn btn-purple btn-xs m-b-5 add_the_data_x">Add Prescription</a>
		</div>
		<div class="col-lg-12">
			<br>
		</div>
		<div class="appnd_the_add_on_x">	
		<div class="col-lg-7">
			<div class="form-group">
                <label for="exampleInputEmail1">Medicine</label>
                <input type="text" class="form-control" id="medx" name="medi[]" autocomplete="none">
                <div id="list4x"></div>
            </div>
		</div>
		<div class="col-lg-2">
			<div class="form-group">
                <label for="exampleInputEmail1">Unit</label>
                <input type="number" class="form-control"
                name="uni[]">
            </div>
		</div>
		<div class="col-lg-3">
			<div class="form-group">
				 <label for="exampleInputEmail1">Procedure</label>
				 <br>
				<a class="btn btn-primary w-md m-b-4" data-toggle="modal" data-target="#intructionmodal22" >Add Procedure</a>
			</div>
		</div>
	</div>
	<button type="submit" class="btn btn-primary" style="margin-left: 10px;">Update</button>
	<hr style=" border-top: 1px solid lightgray;">
	</div> 
</form>

</div> -->
<script>
function myFunctionx() {
	 $(".myDIVx").toggle();
}
</script>
<!-- ############### end of add medicine ####################### -->
            <div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th  style="text-align: left;">Sl.</th>
							<th  style="text-align: left;">Medicine Name</th>
							<th  style="text-align: left;">Dossage</th>
							<th  style="text-align: left;">Duration</th>
							<th  style="text-align: right;"></th>
						</tr>
					</thead>

					<tbody>
						<?php
						$pres = explode('$$', $pres);
						$proc = explode('$&$x', $proc);
						$medi = explode(',', $pres[0]);
						$units = explode(',', $pres[1]);
						for ($r=0; $r < sizeof($medi); $r++)
						{ 
							$proc2 = explode(',', $proc[$r]);
						?>
						<tr>
							<form action="<?php echo URLROOT;?>/nurses/delete_med" method="POST">
							<td style="text-align: left;"><?php echo $r+1;?> </td>
							<td style="text-align: left;"><?php echo $medi[$r];?></td>
							<td style="text-align: left;">
								<?php
									for ($l=0; $l < sizeof($proc2)/4 ; $l++)
									{ 
										for ($k=$l, $j=0; $k < sizeof($proc2); $k = $k + sizeof($proc2)/4, $j++)
										{ 
											if($j == 0)
										 	{
										 		if($l != 0)
										 		{
										 			echo "<hr>";
										 		}
										 		echo "<b>Days - </b>".$proc2[$k];
										 		echo " | ";
										 	}
										 	if($j == 1)
										 	{
										 		echo "<b>Qty - </b>".$proc2[$k];
										 		echo "<br>";
										 	}
										 	if($j == 2)
										 	{
										 		echo "<b>Food Manner - </b>";
										 		echo $proc2[$k];
										 		echo " | ";
										 	}
										 	if($j == 3)
										 	{
										 		echo "<b>Timings - </b>";
										 		echo $proc2[$k];
										 	}
										}
									}
								?>
							</td>
							<td style="text-align: left;"><?php echo $units[$r];?> Units</td>
							<input type="text" name="position" value="<?php echo $r;?>" style="display: none;">
							<input type="text" name="curr_date" value="<?php echo $dayin;?>" style="display: none;">
        					<input type="text" name="ad_id" value="<?php echo $admit_id;?>" style="display: none;">
        					<input type="text" name="pat_id" value="<?php echo $patient_id;?>" style="display: none;">
							<td ></td>
							</form>
						</tr>
						<?php } ?>
					</tbody>
				</table>

			</div>
		<?php } ?>

		<?php
			if($nS != null)
			{
		?>
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th width="80" style="text-align: left;">Sl. No.</th>
							<th style="text-align: left;">Service Name</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$nS = explode(',', $nS);
							for ($g=0; $g < sizeof($nS); $g++)
							{ 
								$serviceName = $doc_obj->getServiceName($nS[$g]);
						?>
						<tr>
							<td style="text-align: left;"><?php echo $g+1; ?></td>
							<td style="text-align: left;"><?php echo $serviceName; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		<?php
			}
		?>

                	<!-- <form action="<?php echo URLROOT;?>/nurses/update_days_details" method = "POST"> -->
                		
                		
                    <!-- <div class="form-group">
                            <label for="exampleInputEmail1">Initial Condition</label>
                            <input type="text" class="form-control" placeholder="Enter Present Condition Here"
                            name="init_cond" value="<?php echo $test2->ipd_day_condition;?>">
                    </div>
                    <div class="form-group">
                            <label for="exampleInputEmail1">First Examination</label>
                            <input type="text" class="form-control"placeholder="Enter Examination Details" name="fir_exm" value="<?php echo $test2->ipd_day_examination;?>">
                    </div>
                    <div class="form-group">
                            <label for="exampleInputEmail1">First Investigation</label>
                            <input type="text" class="form-control" placeholder="Enter Investigation Details"
                            name="fir_inv"
                            value="<?php echo $test2->ipd_day_investigation;?>">
                    </div>
                    <div class="form-group">
                            <label for="exampleInputEmail1">First Diagnosis</label>
                            <input type="text" class="form-control" placeholder="Enter Investigation Details" name="fir_diag" value="<?php echo $test2->ipd_day_diagnosis;?>">
                    </div>
                    <div class="form-group">
                            <label for="exampleInputEmail1">Initial Test Advised</label>
                            <input type="text" class="form-control"placeholder="Enter Investigation Details" name="init_test" value="<?php echo $test2->ipd_day_test_advised;?>">
                    </div>
                    <div class="form-group">
                            <label for="exampleInputEmail1">Initial Notes</label>
                            <input type="text" class="form-control"  placeholder="Enter Any Other Information" name="init_notes" value="<?php echo $test2->ipd_day_notes;?>">
                    </div> -->
            			<!-- <div class="form-group">
            				 <label for="exampleInputEmail1">Instructions</label>
            				 <a class="btn btn-danger btn-xs m-b-5" style="float: right;" data-toggle="modal" data-target="#intructionmodal<?php echo $m;?>">Select Instruction</a>
            				<textarea type="text" class="form-control" name="inst"><?php echo $test2->ipd_day_instruction;?></textarea>
            			</div> -->
            			<!-- <div class="form-group">
            				<button class="btn btn-primary w-md m-b-5" style="float: right;" type="submit">Update</button>
            			</div>
            		</form> -->
                </div> 
			<!-- <div id="intructionmodal<?php echo $m;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog"> 
                    <div class="modal-content"> 
                        <div class="modal-header"> 
                            <h4 class="modal-title">Select Instructions</h4> 
                        </div> 
                        <div class="modal-body"> 
                            <div class="row"> 
                                <div class="col-md-12"> 
                                    <div class="form-group"> 
                                        <div class="form-group">
					                        <select style="margin-top: 10px;" class="form-control">
			                                    <option>Please Select Category</option>
			                                </select>
								        </div> 
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                        <div class="modal-footer"> 
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button> 
                        </div> 
                    </div> 
                </div>
            </div> -->
				                <?php
				                $m++;
				                } 
				                ?>
				                            <div class="tab-pane" id="profile-2">
				                            	                            
				                            </div> 
				                        <br> 
				                    </div>
				                    
				                    <!-- dynamic tab content -->
            					</div>
            					<div class="tab-pane" id="homenew2">
            						<h3>Reports</h3>
            						<div class="table-responsive">
        								<table class="table">
        									<thead>
        										<tr>
        											<th style="text-align: left;">Report Title</th>
        											<th>Report Date</th>
        											<th>Action</th>
        										</tr>
        									</thead>
        									<tbody>
        									<?php foreach ($data['reports'] as $rep) {
        									?>
        										<tr>
        											<td style="text-align: left;"><?php echo ucwords($rep->report_title) ?></td>
        											<td><?php echo date('d-m-Y', strtotime($rep->report_date)) ?></td>
        											<td>
        												<a href="<?php echo URLROOT; ?>/reports/<?php echo $rep->report_file_name; ?>" target="_blank"><button class="btn btn-info btn-xs m-b-5" style="width: 74px;">View</button></a>
        												<a href="<?php echo URLROOT ?>/doctors/download_rep/<?php echo $rep->report_file_name; ?>"><button class="btn btn-purple btn-xs m-b-5" style="width: 74px;">Download</button></a>
        											</td>
        										</tr>
        									<?php } ?>	
        									</tbody>
        								</table>
        							</div>
            					</div>

            					<div class="tab-pane" id="homenewnurse">
            						<h3>Current Nursing Service</h3>
            						<br>
            						<?php 
            						foreach ($data['ipd'] as $test)
									{
										$current_dat = $test->ipd_day_val;
										$current_date = date('d-m-Y', strtotime($current_dat));

									?>
										<div class="col-md-12">
	            							<?php
	            							if(isset($test->nursing_service) AND $test->nursing_service != NULL) { ?>
	            							<h4>Date : <?php echo $current_date;?></h4>
												<div class="table-responsive">
													<table class="table">
														<thead>
															<tr>
																<th width="80" style="text-align: left;">Sl. No.</th>
																<th style="text-align: left;">Service Name</th>
															</tr>
														</thead>
														<tbody>
															<?php 
																$nS = explode(',', $test->nursing_service);
																for ($g=0; $g < sizeof($nS); $g++)
																{ 
																	$serviceName = $doc_obj->getServiceName($nS[$g]);
															?>
															<tr>
																<td style="text-align: left;"><?php echo $g+1; ?></td>
																<td style="text-align: left;"><?php echo $serviceName; ?></td>
															</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
		            						<?php } ?>
	            						</div>
									<?php
									}
									?>
									<form action="<?php echo URLROOT;?>/nurses/saveNursingService" method="POST">
										<div class="col-md-6">
											<div class="form-group forNurseService">
												<input type="text" name="curr_date" value="<?php echo $current_dat;?>" style="display: none;">
        										<input type="text" name="ad_id" value="<?php echo $admit_id;?>" style="display: none;">
        										<input type="number" name="pat_id" value="<?php echo $patient_id;?>" style="display: none;">
												<label>Service Name</label><span><a href="#" class="btn btn-purple btn-xs m-b-5" style="float: right;" onclick="addNurseService()">Add Row</a></span>
												<input type="text" id="nursingKeyup0" name="services[]" class="form-control" placeholder="Enter Nurse Service" onkeyup="getAutoCompleteNurseService(0, this.value)">
												<div class="nursingServiceList" id="nursingServiceList0"></div>
											</div>
											<div class="form-group">
												<button class="btn btn-success">Submit</button>
											</div>
										</div>
									</form>
            					</div>

            					<div class="tab-pane" id="homenew1">
									<div class="row">
										<form action="<?php echo URLROOT; ?>/nurses/save_advice_for_discharge/<?php echo $patient_id; ?>/<?php echo $admit_id ?>" method="post">
											<label for="">Advice for Discharge</label>
											<textarea name="advice_discharge" class="form-control" rows="2"><?php echo $advice; ?></textarea><br>
											<button class="btn btn-info" type="submit">Submit</button>
										</form>
									</div>
									<hr>
            						<h3>Current Medication</h3><br>
            						<?php 
            						foreach ($data['ipd'] as $test)
									{
										$current_dat = $test->ipd_day_val;
										$prescription = $test->ipd_day_prescription;
										$procedure = $test->ipd_day_procedure;
										$current_date = date('d-m-Y', strtotime($current_dat));
            						if(isset($prescription) AND isset($procedure) AND ($prescription != "$$")) { ?>
            						<div class="col-md-12">
            							<h4>Date : <?php echo $current_date;?></h4>
            							<div class="table-responsive">
            								<table class="table">
            									<thead>
            										<tr>
            											<th  style="text-align: left;">Sl.</th>
            											<th  style="text-align: left;">Medicine Name</th>
            											<th  style="text-align: left;">Dossage</th>
            											<th  style="text-align: left;">Duration</th>
            											<th  style="text-align: left;"></th>
            										</tr>
            									</thead>

            									<tbody>
            									<?php
                    								$prescription = explode('$$', $prescription);
                    								$medicines = explode(',', $prescription[0]);
                    								$dossage = explode('$&$x', $procedure);
                    								$units = explode(',', $prescription[1]);
                    								for ($p=0; $p < sizeof($medicines); $p++)
                    								{ 
                    							?>
            										<tr>
            											<td style="text-align: left;"><?php echo $p+1;?></td>
            											<td style="text-align: left;"><?php echo $medicines[$p];?></td>
            											<form action="<?php echo URLROOT;?>/nurses/delete_med" method="POST">
            											<td style="text-align: left;">
            											<?php
            												$sub_doss = $dossage[$p];
            												$sub_doss = explode(',', $sub_doss);
            												for ($v=0; $v < sizeof($sub_doss)/4;$v++)
            												{
            													for ($n=$v,$m=0; $n <  sizeof($sub_doss); $n = $n + (sizeof($sub_doss)/4),$m++)
            													{ 
            													 	if($m == 0)
            													 	{
            													 		if($v != 0)
            													 		{
            													 			echo "<hr>";
            													 		}
            													 		echo "<b>Days - </b>".$sub_doss[$n];
            													 		echo " | ";
            													 	}
            													 	if($m == 1)
            													 	{
            													 		echo "<b>Qty - </b>".$sub_doss[$n];
            													 		echo "<br>";
            													 	}
            													 	if($m == 2)
            													 	{
            													 		echo "<b>Food Manner - </b>";
            													 		echo $sub_doss[$n];
            													 		echo " | ";
            													 	}
            													 	if($m == 3)
            													 	{
            													 		echo "<b>Timings - </b>";
            													 		echo $sub_doss[$n];
            													 	}
            													} 
            													?>
            													<input type="text" name="position" value="<?php echo $p;?>" style="display: none;">
            													<?php
            												}
            											?>
            											</td>
            											<td style="text-align: left;"><?php echo $units[$p]." Units";?></td>
            											<td >
        													<input type="text" name="curr_date" value="<?php echo $current_dat;?>" style="display: none;">
        													
        													<input type="text" name="ad_id" value="<?php echo $admit_id;?>" style="display: none;">
        													<input type="text" name="pat_id" value="<?php echo $patient_id;?>" style="display: none;">
        													
            												</form>
            											</td>
            										</tr>
            										<?php } ?>
            									</tbody>
            								</table>
            							</div>
            						</div>	
            					<?php } 
            						}
            					?>
            						<!-- form -->
            						<!-- <form action="<?php echo URLROOT;?>/nurses/save_medication/<?php echo $admit_id;?>" method="POST">
            									<div class="row">
            										<input type="number" name="pat" style="display: none;" value="<?php echo $patient_id;?>">
				                            		<div class="col-lg-12">
				                            			<b>Prescription&nbsp;&nbsp;</b>
				                            			<a id="add_the_data" class="btn btn-purple btn-xs m-b-5">Add Prescription</a>
				                            		</div>
				                            		<div class="col-lg-12">
				                            			<br>
				                            		</div>
				                            		<div class="row">
				                            		<div id="appnd_the_add_on">	
				                            		<div class="col-lg-7">
				                            			<div class="form-group">
					                                        <label for="exampleInputEmail1">Medicine</label>
					                                        <input type="text" class="form-control" id="med" name="medicine[]" autocomplete="off" required="true">
					                                        <div id="list4"></div>
						                                </div>
				                            		</div>
				                            		<div class="col-lg-2">
				                            			<div class="form-group">
					                                        <label for="exampleInputEmail1">Unit</label>
					                                        <input type="number" class="form-control"
					                                        name="unit[]" required="true">
						                                </div>
				                            		</div>
				                            		<div class="col-lg-3">
				                            			<div class="form-group">
				                            				 <label for="exampleInputEmail1">Procedure</label>
				                            				 <br>
				                            				<a class="btn btn-primary w-md m-b-4" data-toggle="modal" data-target="#intructionmodal22" >Add Procedure</a>
				                            			</div>
				                            		</div>
				                            	</div>
				                            	</div>
				                            	<button type="submit" class="btn btn-primary" style="margin-left: 10px;">Update</button>
				                            	</div> 
				                            </form> -->
				                            	<!-- /form -->
            							</div>
            					<!-- medication end -->

            					<div class="tab-pane" id="home2">
            						<form action="<?php echo URLROOT;?>/nurses/comorb" method="POST">
            						<div class="col-lg-12">
                            			<div class="form-group">
                            				<input type="number" name="pat" value="<?php echo $patient_id;?>" style="display: none;">
                            				<input type="number" name="admit_id" value="<?php echo $admit_id;?>" style="display: none;">
	                                        <label for="exampleInputEmail1">Hypertension</label>
	                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Hypertension Details Here" name="hyp" value="<?php echo $hypertention;?>">
		                                </div>
		                                <div class="form-group">
	                                        <label for="exampleInputEmail1">Diabetes Mellitus</label>
	                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Diabetes Mellitus Details Here" name="dia" value="<?php echo $diabetes;?>">
		                                </div>
		                                <div class="form-group">
	                                        <label for="exampleInputEmail1">Coronary Artery Disease</label>
	                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Coronary Artery Disease Details Here" name="cad" value="<?php echo $coronary;?>">
		                                </div>
		                                <div class="form-group">
	                                        <label for="exampleInputEmail1">Cerebrovascular disease / Peripheral Vascular Disease</label>
	                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Cerebrovascular disease / Peripheral Vascular Disease Details Here" name="cd" value="<?php echo $cerebro;?>">
		                                </div>
		                                <div class="form-group">
	                                        <label for="exampleInputEmail1">Dyslipidaemia</label>
	                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Dyslipidaemia Details Here" name="dys" value="<?php echo $dyslipidaemia;?>">
		                                </div>
		                                <div class="form-group">
	                                        <label for="exampleInputEmail1">Hypothyroidism</label>
	                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Hypothyroidism Details Here" name="hypth" value="<?php echo $hypothyroidism;?>">
		                                </div>
		                                <div class="form-group">
	                                        <label for="exampleInputEmail1">Other allergic/ chronic disorders</label>
	                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Other Details Here" name="allrg" value="<?php echo $other;?>">
		                                </div>
		                                <div class="form-group">
	                                        <button type="submit" class="btn btn-primary w-md m-b-5">Update</button>
		                                </div>
                            		</div>
                            		</form>
            					</div>
            					<div class="tab-pane" id="home3">
            						<div class="col-lg-12">
            							<form action="<?php echo URLROOT;?>/nurses/patient_history" method="POST">
            							<div class="form-group">
            								<input type="number" name="pat" value="<?php echo $patient_id;?>" style="display: none;">
	                                        <label for="exampleInputEmail1">Patient Past History</label>
	                                        <!-- <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Past History Details Here" name="past" value="<?php echo $past_his;?>"> -->
										</div>
										<br>
											<?php if(!empty($past_his)) { 
												$patHis = explode(',', $past_his);
												$patMon = explode(',', $mon);
												$patYear = explode(',', $year);
												
												?>
											<div class="timeline-2">
												<?php for ($e=0; $e < sizeof($patHis); $e++) { ?>
												<div class="time-item">
													<div class="item-info">
														<div class="text-muted">Date: <?php echo $patMon[$e].'-'.$patYear[$e]; ?></div>
														<p><strong>Incident: <?php echo $patHis[$e]; ?></strong></p>
													</div>
												</div>
													<?php } ?>
											</div>
											<?php } ?>
		                                <div class="form-group">
	                                        <label for="exampleInputEmail1">Family History</label>
	                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Investigation Family History Details Here" name="fam" value="<?php echo $fam;?>">
		                                </div>
		                                <!-- <div class="form-group">
	                                        <button type="submit" class="btn btn-primary w-md m-b-5">Update</button>
		                                </div> -->
		                            	</form>
            						</div>
            					</div>
            					<div class="tab-pane" id="home4">
            						<div class="col-lg-12">
            							<div class="row">
            							<div class="col-lg-6">
                							<div class="form-group">
		                                        <label for="exampleInputEmail1">Name</label>
		                                        <input type="text" class="form-control" id="exampleInputEmail1" readonly="" value="<?php echo $patient_name;?>">
			                                </div>
			                            </div>
			                            <div class="col-lg-6">
                							<div class="form-group">
		                                        <label for="exampleInputEmail1">Gender</label>
		                                        <input type="text" class="form-control" id="exampleInputEmail1" readonly="" value="<?php echo $patient_gender;?>">
			                                </div>
			                            </div>
			                            <div class="col-lg-6">
                							<div class="form-group">
		                                        <label for="exampleInputEmail1">Date Of Birth</label>
		                                        <input type="text" class="form-control" id="exampleInputEmail1" readonly="" value="<?php echo $patient_dob;?>">
			                                </div>
			                            </div>
			                            <div class="col-lg-6">
                							<div class="form-group">
		                                        <label for="exampleInputEmail1">Email</label>
		                                        <input type="text" class="form-control" id="exampleInputEmail1" readonly="" value="<?php echo $patient_email;?>">
			                                </div>
			                            </div>
			                            <div class="col-lg-6">
                							<div class="form-group">
		                                        <label for="exampleInputEmail1">Phone</label>
		                                        <input type="text" class="form-control" id="exampleInputEmail1" readonly="" value="<?php echo $patient_phone;?>">
			                                </div>
			                            </div>
			                            <div class="col-lg-6">
                							<div class="form-group">
		                                        <label for="exampleInputEmail1">Address</label>
		                                        <textarea type="text" class="form-control" id="exampleInputEmail1" readonly="" rows="1"><?php echo $patient_address;?></textarea>
			                                </div>
			                            </div>
		                            	</div>
		                                <!-- <div class="form-group">
	                                        <button type="button" class="btn btn-primary w-md m-b-5">Update</button>
		                                </div> -->
            						</div>
            					</div>
            					<div class="tab-pane" id="home5">
            						<div class="col-lg-12">
            							<div class="row">
            							<?php
            							$vb = 0;
            							foreach ($data['all_ipd'] as $key)
            							{
            								$vb++;
            								$last_admit = $key->admission_date_time;
            							}
            							?>
            							<div class="col-lg-6">
                							<div class="form-group">
		                                        <label for="exampleInputEmail1">Total Visits</label>
		                                        <input type="text" class="form-control" id="exampleInputEmail1" readonly="" value="<?php echo $vb;?>">
			                                </div>
			                            </div>
			                            <div class="col-lg-6">
                							<div class="form-group">
		                                        <label for="exampleInputEmail1">Last Visit</label>
		                                        <input type="text" class="form-control" id="exampleInputEmail1" readonly="" value="<?php echo $last_admit; ?>">
			                                </div>
			                            </div>
			                            <div class="col-lg-12">
			                            <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th  style="text-align: left;" class="col-lg-3" >Date</th>
                                                    <th  style="text-align: left;" class="col-lg-7">Admitted Doctor</th>
                                                    <th  style="text-align: left;" class="col-lg-2">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            	<?php foreach ($data['all_ipd'] as $keys)
                                            	{
                                            		$new_call = new Nurses;
                                            		$doctor_name = $new_call->call_for_doc_name($keys->ipd_doctor_id);
                                            	?>
                                                <tr>
                                                    <td  style="text-align: left;"><?php echo $keys->admission_date_time;?></td>
                                                    <td  style="text-align: left;"><?php echo $doctor_name?></td>
                                                    <td  style="text-align: left;">
                                                    	<a href="<?php echo URLROOT;?>/nurses/print_prescription_ipd/<?php echo $keys->ipd_admit_id;?>">
                                                        <button style="width: 54px" type="button" class="btn btn-success btn-xs m-b-5">Print</button>
                                                    </a>
                                                    </td>
                                                </tr>
                                                <?php } ?> 
                                            </tbody>
                                        </table>
                        				</div>
                        			</div>
		                            	</div>
            						</div>
            					</div>
            				</div>
                        </div>
                	</div>
                </div>
            </div>
        </div>
    </div>
        
         <!-- End Rightsidebar -->
</div><!-- End row -->
            </div>
            <div id="intructionmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog"> 
                    <div class="modal-content"> 
                        <div class="modal-header"> 
                            <h4 class="modal-title">Select Instructions</h4> 
                        </div> 
                        <div class="modal-body"> 
                            <div class="row"> 
                                <div class="col-md-12"> 
                                    <div class="form-group"> 
                                        <div class="form-group">
					                        <select style="margin-top: 10px;" class="form-control">
			                                    <option>Please Select Category</option>
			                                </select>
								        </div> 
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                        <div class="modal-footer"> 
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button> 
                        </div> 
                    </div> 
                </div>
            </div>


<!-- Drug Autocomplete -->

<script type="text/javascript">
 $(document).ready(function(){
  $('#med').keyup(function(){
    var query = $(this).val();
    if(query!=0)
    {
      $.ajax({
        url:'<?php echo URLROOT;?>/pharmacies/get_drug_autocomplete',
        type:'POST',
        data:{query:query}, 
        success:function(data)
        {
          $('#list4').fadeIn();
          $('#list4').html(data);
        }
      });
    }
    else
    {
      $('#list4').fadeOut();
    }
  });
   $(document).on('click', '.cc', function(){  
       $('#med').val($(this).text());  
       $('#list4').fadeOut();  
  });
  $(document).click(function (event){
    $('#list4').fadeOut(); 
  });  
});
</script>

<script type="text/javascript">
 $(document).ready(function(){
  $('#medx').keyup(function(){
    var query = $(this).val();
    if(query!=0)
    {
      $.ajax({
        url:'<?php echo URLROOT;?>/pharmacies/get_drug_autocomplete',
        type:'POST',
        data:{query:query}, 
        success:function(data)
        {
          $('#list4x').fadeIn();
          $('#list4x').html(data);
        }
      });
    }
    else
    {
      $('#list4x').fadeOut();
    }
  });
   $(document).on('click', '.cc', function(){  
       $('#medx').val($(this).text());  
       $('#list4x').fadeOut();  
  });
  $(document).click(function (event){
    $('#list4x').fadeOut(); 
  });  
});
</script>

<!-- add procedure -->
         	<div id="intructionmodal22" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	            <div class="modal-dialog"> 
	                <div class="modal-content"> 
	                    <div class="modal-header"> 
	                        <h4 class="modal-title">Add Procedure</h4> 
	                    </div> 
	                    <div class="modal-body"> 
	                    	<div class="col-md-12">
	                    		<div class="row">
	                    			<button class="btn btn-purple btn-xs m-b-5" id="add_procedure">Add</button>
	                    		</div>
	                    	</div>
	                        <div class="row" id="appnd_the_procedure">
	                            <div class="col-md-2"> 
	                                <div class="form-group"> 
	                                    <div class="form-group">
	                                    	<label>Days</label>
					                        <input type="number" name="day_num[]" class="form-control" style="border: 1px solid lightgray;" value="1">
								        </div> 
	                                </div> 
	                            </div>
	                            <div class="col-md-3"> 
	                                <div class="form-group"> 
	                                    <div class="form-group">
	                                    	<label>Quantity</label>
					                        <select class="form-control" name="tab_quant[]" style="border: 1px solid lightgray;">
			                                    <option>1/2 Tab</option>
			                                    <option>1 Tab</option>
			                                    <option>2 Tab</option>
			                                    <option>1/2 Tbsp</option>
			                                    <option>1 Tbsp</option>
			                                    <option>2 Tbsp</option>
			                                    <option>2.5 ml</option>
			                                    <option>5 ml</option>
			                                    <option>10 ml</option>
			                                </select>
								        </div> 
	                                </div> 
	                            </div> 
	                            <div class="col-md-3"> 
	                                <div class="form-group"> 
	                                    <div class="form-group">
	                                    	<label>Food Manner</label>
					                        <select class="form-control" name="food_manner[]" style="border: 1px solid lightgray;">
			                                    <option>After Food</option>
			                                    <option>Before Food</option>
			                                    <option>Not Specified</option>
			                                </select>
								        </div> 
	                                </div> 
	                            </div>
	                            <div class="col-md-4"> 
	                                <div class="form-group"> 
	                                    <div class="form-group">
	                                    	<label>Timings</label>
					                        <select class="form-control" name="times[]" style="border: 1px solid lightgray;">
			                                    <option>Morning</option>
			                                    <option>Afternoon</option>
			                                    <option>Night</option>
			                                    <option>Bed Time</option>
			                                    <option>Morning Afternoon Night</option>
			                                    <option>Morning Night</option>
			                                    <option>Morning Afternoon</option>
			                                    <option>Afternoon Night</option>
			                                    <option>4 times a Day</option>
			                                    <option>5 times a Day</option>
			                                </select>
								        </div> 
	                                </div> 
	                            </div>
	                        </div> 
	                    </div> 
	                    <div class="modal-footer">
	                    	<button id="addpros" type="button" class="btn btn-primary">Add</button> 
	                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
	                    </div> 
	                </div> 
	            </div>
	        </div>



<?php require APPROOT .'/views/inc_nurse/footer.php'; ?>
<script>
$(document).ready(function(){
	var i = 0;
  $("#add_the_data").click(function(){
  	  i++;
    $('#appnd_the_add_on').append('<div class="col-lg-7">\
    			<div class="form-group">\
                <input type="text" class="form-control" id="med'+i+'" name="medicine[]" onclick="xyz('+i+')">\
                <div id="list4'+i+'" class="bnm" style="display:none;"></div>\
                </div>\
    		</div>\
    		<div class="col-lg-2">\
    			<div class="form-group">\
                    <input type="text" class="form-control" id="exampleInputEmail1" name="unit[]">\
                </div>\
    		</div>\
    		<div class="col-lg-3">\
    			<div class="form-group">\
    				<a id="instructionmodal'+i+'" class="btn btn-primary w-md m-b-4" data-toggle="modal" data-target="#intructionmodal22">Add Procedure</a>\
    			</div>\
    		</div>');
  });
});	

</script>
<script>
$(document).ready(function(){
	var i = 0;
  $(".add_the_data_x").click(function(){
  	  i++;
    $('.appnd_the_add_on_x').append('<div class="col-lg-7">\
    			<div class="form-group">\
                <input type="text" class="form-control" id="med'+i+'" name="medicine[]" onclick="xyz('+i+')">\
                <div id="list4'+i+'" class="bnm" style="display:none;"></div>\
                </div>\
    		</div>\
    		<div class="col-lg-2">\
    			<div class="form-group">\
                    <input type="text" class="form-control" id="exampleInputEmail1" name="unit[]">\
                </div>\
    		</div>\
    		<div class="col-lg-3">\
    			<div class="form-group">\
    				<a class="btn btn-primary w-md m-b-4" data-toggle="modal" data-target="#intructionmodal22">Add Procedure</a>\
    			</div>\
    		</div>');
  });
});	

</script>
<script type="text/javascript">
	function xyz(e)
	{
	  $('#med'+e+'').keyup(function(){
	    var query = $(this).val();
	    if(query!=0)
	    {
	      $.ajax({
	        url:'<?php echo URLROOT;?>/pharmacies/get_drug_autocomplete_x',
	        type:'POST',
	        data:{query:query}, 
	        success:function(data)
	        {
	          $('#list4'+e+'').fadeIn();
	          $('#list4'+e+'').html(data);
	        }
	      });
	    }
	    else
	    {
	      $('#list4'+e+'').fadeOut();
	    }
	  });
	   $(document).on('click', '.ccx', function(){
	   	   var h = $('#med'+e+'').val();
	   	   if(h != '')
	   	   {
	   	   		$('#med'+e+'').val($(this).text());
	   	   }
	        
	       $('#list4'+e+'').fadeOut();  
	  });
	  $(document).click(function (event){
	    $('#list4'+e+'').fadeOut(); 
	  });  
	}
</script>

<script>
$(document).ready(function(){
  $("#add_procedure").click(function(){
    $('#appnd_the_procedure').append('<div class="col-md-2">\
     	                                <div class="form-group"> \
	                                    <div class="form-group">\
					                        <input type="number" name="day_num[]" class="form-control" style="border: 1px solid lightgray;">\
								        </div> \
	                                </div> \
	                            </div>\
	                            <div class="col-md-3"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
					                        <select class="form-control" name="tab_quant[]" style="border: 1px solid lightgray;">\
			                                    <option>1/2 Tab</option>\
			                                    <option>1 Tab</option>\
			                                    <option>2 Tab</option>\
			                                    <option>1/2 Tbsp</option>\
			                                    <option>1 Tbsp</option>\
			                                    <option>2 Tbsp</option>\
			                                    <option>2.5 ml</option>\
			                                    <option>5 ml</option>\
			                                    <option>10 ml</option>\
			                                </select>\
								        </div> \
	                                </div> \
	                            </div> \
	                            <div class="col-md-3"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
					                        <select class="form-control" name="food_manner[]" style="border: 1px solid lightgray;">\
			                                    <option>After Food</option>\
			                                    <option>Before Food</option>\
			                                    <option>Not Specified</option>\
			                                </select>\
								        </div> \
	                                </div> \
	                            </div>\
	                            <div class="col-md-4"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
					                        <select class="form-control" name="times[]" style="border: 1px solid lightgray;">\
			                                    <option>Morning</option>\
			                                    <option>Afternoon</option>\
			                                    <option>Night</option>\
			                                    <option>Bed Time</option>\
			                                    <option>Morning Afternoon Night</option>\
			                                    <option>Morning Night</option>\
			                                    <option>Morning Afternoon</option>\
			                                    <option>Afternoon Night</option>\
			                                    <option>4 times a Day</option>\
			                                    <option>5 times a Day</option>\
			                                </select>\
								        </div> \
	                                </div> \
	                            </div>');
  });
});	
</script>
<script>
$(document).ready(function(){
  $("#add_procedure_x").click(function(){
    $('#appnd_the_procedure_x').append('<div class="col-md-2">\
     	                                <div class="form-group"> \
	                                    <div class="form-group">\
					                        <input type="number" name="day_num[]" class="form-control" style="border: 1px solid lightgray;">\
								        </div> \
	                                </div> \
	                            </div>\
	                            <div class="col-md-3"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
					                        <select class="form-control" name="tab_quant[]" style="border: 1px solid lightgray;">\
			                                    <option>1/2 Tab</option>\
			                                    <option>1 Tab</option>\
			                                    <option>2 Tab</option>\
			                                    <option>1/2 Tbsp</option>\
			                                    <option>1 Tbsp</option>\
			                                    <option>2 Tbsp</option>\
			                                    <option>2.5 ml</option>\
			                                    <option>5 ml</option>\
			                                    <option>10 ml</option>\
			                                </select>\
								        </div> \
	                                </div> \
	                            </div> \
	                            <div class="col-md-3"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
					                        <select class="form-control" name="food_manner[]" style="border: 1px solid lightgray;">\
			                                    <option>After Food</option>\
			                                    <option>Before Food</option>\
			                                    <option>Not Specified</option>\
			                                </select>\
								        </div> \
	                                </div> \
	                            </div>\
	                            <div class="col-md-4"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
					                        <select class="form-control" name="times[]" style="border: 1px solid lightgray;">\
			                                    <option>Morning</option>\
			                                    <option>Afternoon</option>\
			                                    <option>Night</option>\
			                                    <option>Bed Time</option>\
			                                    <option>Morning Afternoon Night</option>\
			                                    <option>Morning Night</option>\
			                                    <option>Morning Afternoon</option>\
			                                    <option>Afternoon Night</option>\
			                                    <option>4 times a Day</option>\
			                                    <option>5 times a Day</option>\
			                                </select>\
								        </div> \
	                                </div> \
	                            </div>');
  });
});	
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#addpros').click(function(){
			var day = $("input[name='day_num[]']")
              .map(function(){return $(this).val();}).get();
            var tab = $("select[name='tab_quant[]']")
              .map(function(){return $(this).val();}).get();
            var food = $("select[name='food_manner[]']")
              .map(function(){return $(this).val();}).get(); 
            var times = $("select[name='times[]']")
              .map(function(){return $(this).val();}).get();

            var all_procedure = day;
            all_procedure += ',';
            all_procedure += tab;
            all_procedure += ',';
            all_procedure += food;
            all_procedure += ',';
            all_procedure += times;
            all_procedure += '$&$x';
            $.ajax({
            	url:'<?php echo URLROOT;?>/nurses/procedure_session_x',
            	type:'POST',
            	data:{all_procedure},

            	success : function(data)
            	{
            		
            		$("#appnd_the_procedure").html('<div class="col-md-2">\
     	                                <div class="form-group"> \
	                                    <div class="form-group">\
	                                    <label>Days</label>\
					                        <input type="number" name="day_num[]" class="form-control" style="border: 1px solid lightgray;">\
								        </div> \
	                                </div> \
	                            </div>\
	                            <div class="col-md-3"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
	                                    <label>Quantity</label>\
					                        <select class="form-control" name="tab_quant[]" style="border: 1px solid lightgray;">\
			                                    <option>1/2 Tab</option>\
			                                    <option>1 Tab</option>\
			                                    <option>2 Tab</option>\
			                                    <option>1/2 Tbsp</option>\
			                                    <option>1 Tbsp</option>\
			                                    <option>2 Tbsp</option>\
			                                    <option>2.5 ml</option>\
			                                    <option>5 ml</option>\
			                                    <option>10 ml</option>\
			                                </select>\
								        </div> \
	                                </div> \
	                            </div> \
	                            <div class="col-md-3"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
	                                    <label>Food Manner</label>\
					                        <select class="form-control" name="food_manner[]" style="border: 1px solid lightgray;">\
			                                    <option>After Food</option>\
			                                    <option>Before Food</option>\
			                                    <option>Not Specified</option>\
			                                </select>\
								        </div> \
	                                </div> \
	                            </div>\
	                            <div class="col-md-4"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
	                                    <label>Timings</label>\
					                        <select class="form-control" name="times[]" style="border: 1px solid lightgray;">\
			                                    <option>Morning</option>\
			                                    <option>Afternoon</option>\
			                                    <option>Night</option>\
			                                    <option>Bed Time</option>\
			                                    <option>Morning Afternoon Night</option>\
			                                    <option>Morning Night</option>\
			                                    <option>Morning Afternoon</option>\
			                                    <option>Afternoon Night</option>\
			                                    <option>4 times a Day</option>\
			                                    <option>5 times a Day</option>\
			                                </select>\
								        </div> \
	                                </div> \
	                            </div>');
            		 $('#intructionmodal22').modal('toggle');
            	}
            });
		});
	});
</script>

<script type="text/javascript">
	var y = 1;
	function addNurseService()
	{
		$('.forNurseService').append('<br><input type="text" name="services[]" class="form-control" id="nursingKeyup'+y+'" placeholder="Enter Nurse Service" onkeyup="getAutoCompleteNurseService('+y+', this.value)"><div class="nursingServiceList" id="nursingServiceList'+y+'" ></div>');
		y++;
	}

	function getAutoCompleteNurseService(keyVal, val)
	{
		$.ajax({
			url: '<?php echo URLROOT; ?>/nurses/getNurseService',
			type: 'POST',
			data: {val, keyVal},

			success : function(data)
			{
				$('#nursingServiceList'+keyVal+'').html(data);
			}
		});
	}

	function putValueAndFadeOut(serId, actVal)
	{
		var inp = $('#inpVal'+serId+'').text();
		$('#nursingKeyup'+actVal+'').val(inp);
		$('#nursingServiceList'+actVal+'').fadeOut();
	}
</script>
