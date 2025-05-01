<?php require APPROOT .'/views/inc_doctor/header.php'; ?>
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
	    #list4, #list4x{
        max-height: 100px;
        max-width: 422px;                         
        min-width: 422px;
        position: absolute;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        font-size: 14px;
        cursor: pointer;
        z-index: 50;
        text-align: left;
      }
      .cc:hover{
      	background-color: lightgray;
      }

      .bnm{
        max-height: 100px;
        max-width: 422px;                         
        min-width: 422px;
        position: absolute;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        font-size: 14px;
        cursor: pointer;
        z-index: 50;
        text-align: left;      	
      }

      .ccx:hover{
      	background-color: lightgray;
      }

      ul.ui-autocomplete
      {
        z-index: 1100;
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
}

foreach ($data['main_ipd'] as $test)
{
	$ipd_initial_condition = $test->ipd_initial_condition;
	$ipd_first_diagnosis = $test->ipd_first_diagnosis;
	$dis = $test->discharge_date_time;
	$doc_id = $test->ipd_doctor_id;
}

if ($dis != NULL) {
?>
	<style type="text/css">
	input {
		pointer-events: none; 
	}
	textarea{
		pointer-events: none; 
	}
	</style>
<?php
}

$doc_obj = new Doctors;
$doc_name = $doc_obj->call_for_doc_name($doc_id);
?>
<div class="wraper container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body" style="padding-top: 0px;">
                <div class="col-md-4">
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
                <!-- <div class="col-md-1">
                	<button style="float: right;" class="btn btn-pink btn-xs m-b-5" data-toggle="modal" data-target="#ot_modal">OR</button>
                </div> -->
                <div class="col-md-8" style="margin-left: 0px;">
                	<br><br><button style="float: right;width: ;" class="btn btn-pink btn-xs m-b-5" data-toggle="modal" data-target="#ot_modal"><i class="fa fa-heartbeat" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;OR</button><br><br>
                	<?php
                	if($dis != NULL)
                	{ ?>
                		<button id="un_dis" style="float: right;  width: 115px; margin-left: 5px;" class="btn btn-danger btn-xs m-b-5">Cancel Discharge</button>
                		<button style="float: right;  width: 115px;  margin-left: 5px;" class="btn btn-primary btn-xs m-b-5">Discharge Summary</button> <?php
                	}
                	?>
                	<a data-target="#reportupload" data-toggle="modal" >
                	<button style="float: right; width: 115px;  margin-left: 5px;" class="btn btn-purple btn-xs m-b-5">Upload Report</button>
                	</a>
                	<button style="float: right;  width: 115px;  margin-left: px;" class="btn btn-info btn-xs m-b-5">Assign Team</button>
                	
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
                      <a href="#home" data-toggle="tab" aria-expanded="true" class="list-group-item act yes_act">Present Admission</a>
                      <a href="#homenew1" data-toggle="tab" aria-expanded="true" class="list-group-item no_act">Medication</a>
                      <a href="#homenew2" data-toggle="tab" aria-expanded="true" class="list-group-item no_act">Test Reports</a>
                      <a href="#home2" data-toggle="tab" aria-expanded="false" class="list-group-item no_act">Co-Morbidities</a>
                      <a href="#home3" data-toggle="tab" aria-expanded="false" class="list-group-item no_act">Patient History</a>
                      <a href="#home4" data-toggle="tab" aria-expanded="false" class="list-group-item no_act">Basic Information</a>
                      <a href="#home5" data-toggle="tab" aria-expanded="false" class="list-group-item no_act">Previous Visits</a>
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
					                            	<form action="<?php echo URLROOT;?>/doctors/save_initial_diag" method="POST">
					                            	<input type="number" name="admit_id" value="<?php echo $admit_id;?>" style="display: none;">
					                            	<input type="number" name="pat_id" value="<?php echo $patient_id;?>" style="display: none;">
					                                <div class="form-group">
					                                        <label for="exampleInputEmail1">Initial Condition</label>
					                                        <input type="text" class="form-control" name="init_cond" placeholder="Enter Present Condition Here" value="<?php echo $ipd_initial_condition;?>">
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
					                                        <input type="text" class="form-control" name="first_diag" placeholder="Enter Investigation Details" value="<?php echo $ipd_first_diagnosis?>">
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
				                            			<div class="form-group">
				                            				<button class="btn btn-primary w-md m-b-5" type="submit" style="float: right;">Update</button>
				                            			</div>
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
					                    ?>
					                    <!-- dynamic tab content -->
					                    <?php if($today == $dayx) { ?>
					                            <div class="tab-pane active" id="pro<?php echo $m;?>"> 
					                            <?php } 
					                            else { ?>
					                            <div class="tab-pane" id="pro<?php echo $m;?>">
					                    <?php } 
					                        if($pres != NULL) { 
					                        	if($pres != "$$") { ?>
					                       	<h4>Day's Medicine</h4>
					                        <button class="btn btn-info btn-xs m-b-5" onclick="myFunctionx()">Add Medicine</button>

<!-- ############### on click open add medicine ################ -->
<div style="display: none;" class="myDIVx">
<form action="<?php echo URLROOT;?>/doctors/save_medication_particular/<?php echo $admit_id;?>" method="POST">
	<div class="row">
		<hr style=" border-top: 1px solid lightgray;">
		<input type="number" name="pat" style="display: none;" value="<?php echo $patient_id;?>">
		<input type="text" name="day_par" style="display: none;" value="<?php echo $dayin;?>">
		<div class="col-lg-12">
			<b>Prescription &nbsp;&nbsp;</b>
			<a id="" class="btn btn-purple btn-xs m-b-5 add_the_data_x">Add Prescription</a>
		</div>
		<div class="col-lg-12">
			<br>
		</div>
		<div class="appnd_the_add_on_x">	
		<div class="col-lg-8">
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
		<div class="col-lg-2">
			<div class="form-group">
				 <label for="exampleInputEmail1">Procedure</label>
				 <br>
				<a class="btn btn-primary w-md m-b-4" data-toggle="modal" data-target="#intructionmodal222" >Add Procedure</a>
			</div>
		</div>
	</div>
	<button type="submit" class="btn btn-primary" style="margin-left: 10px;">Update</button>
	<hr style=" border-top: 1px solid lightgray;">
	</div> 
</form>

</div>
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
							<form action="<?php echo URLROOT;?>/doctors/delete_med" method="POST">
							<td style="text-align: left;"><?php echo $r+1;?> </td>
							<td style="text-align: left;"><?php
							$x_m_name = explode('(', $medi[$r]);
							?>
							<p><?php echo ucwords($x_m_name[0]); ?></p>
							<?php if($units[$r] > 1) { ?>
							<small>(Units: <?php echo $units[$r] ?>)</small>
							<?php } else { ?>
							<small>(Unit: <?php echo $units[$r] ?>)</small>
							<?php } ?>	
							</td>
							<td style="text-align: left;">
								<?php
									$prx = $proc2;
                                    $lenx = sizeof($prx); 
									$prinx = '';
                                    $dayx = '';
									for($k=0;$k<$lenx/4;$k++)
                                    {
                                    for ($j=$k; $j < $lenx;$j=$j+$lenx/4) 
                                    { 
                                        $prinx .= $prx[$j];
                                        $prinx .= ',';
                                    }
                                    $prinx = explode(',', $prinx);
                                    if($prinx[2] == "Not Specified") {
                                      echo $prinx[1],' &bull; ',$prinx[3];
                                    }
                                    else{
                                      echo $prinx[1],' &bull; ',$prinx[2],' &bull; ',$prinx[3];
                                    }
                                    
                                    $dayx .= $prinx[0];
                                    $dayx .= ','; 
                                    $prinx = '';
                                    ?><br><?php
                                    }
								?>
							</td>
							<td style="text-align: left;"><?php echo $units[$r];?> Units</td>
							<input type="text" name="position" value="<?php echo $r;?>" style="display: none;">
							<input type="text" name="curr_date" value="<?php echo $dayin;?>" style="display: none;">
        					<input type="text" name="ad_id" value="<?php echo $admit_id;?>" style="display: none;">
        					<input type="text" name="pat_id" value="<?php echo $patient_id;?>" style="display: none;">
							<td ><button type="submit" style="background-color: orange; border: none; color: white; border-radius: 3px;">X</button></td>
							</form>
						</tr>
						<?php } ?>
					</tbody>
				</table>

			</div>
		<?php } } ?>

                	<form action="<?php echo URLROOT;?>/doctors/update_days_details" method = "POST">
                		<input type="text" name="day" value="<?php echo $dayin;?>" style="display: none;" >
                		<input type="number" name="admit_id" value="<?php echo $admit_id?>" style="display: none;">
                		<input type="number" name="pat_id" value="<?php echo $patient_id;?>" style="display: none;">
                    <div class="form-group">
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
                    </div>
            			<div class="form-group">
            				 <label for="exampleInputEmail1">Instructions</label>
            				 <a class="btn btn-success btn-xs m-b-5" style="float: right;" data-toggle="modal" data-target="#intructionmodal">Select Instruction</a>
            				<textarea type="text" class="form-control" name="inst" id="ins_field">
            					<?php if(!empty($test2->ipd_day_instruction)){
            						echo $test2->ipd_day_instruction;
            					}
            					else
            					{
            					}		?>
            						</textarea>

            			</div>
            			<div class="form-group">
            				<button class="btn btn-primary w-md m-b-5" style="float: right;" type="submit">Update</button>
            			</div>
            		</form>
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
					                        <select id="ins_sel" style="margin-top: 10px;" class="form-control">
			                                    <option>Please Select Category</option>
			                                    <?php foreach ($data['ins'] as $key) {
												?>
												<option value="<?php echo $key->category; ?>"><?php echo ucwords($key->category); ?></option>
												<?php } ?>
			                                </select>
								        </div> 
                                    </div> 
                                     <div id="ins_appnd">
	                                	
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

            					<div class="tab-pane" id="homenew1">
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
            											<td style="text-align: left;">
            												<?php 
            													$m_name = explode('(', $medicines[$p]);
            													$m_uni = explode(')', $m_name[1]);
            												?>
            												<p><?php echo ucwords($m_name[0]) ?></p>
            												<?php if($units > 1) { ?>
            												<small>(Units: <?php echo $units[$p] ?>)</small>
            												<?php } else { ?>
            												<small>(Unit: <?php echo $units[$p] ?>)</small>
            												<?php } ?>
            											</td>
            											<form action="<?php echo URLROOT;?>/doctors/delete_med" method="POST">
            											<td style="text-align: left;">
            											<?php
            												// $sub_doss = $dossage[$p];
            												// $sub_doss = explode(',', $sub_doss);
            												$pr = explode(',', $dossage[$p]);
                                                            $len = sizeof($pr);
                                                            $prin = '';
                                                            $day = '';
                                                            for($k=0;$k<$len/4;$k++)
                                                            {
                                                            for ($j=$k; $j < $len;$j=$j+$len/4) 
                                                            { 
                                                                $prin .= $pr[$j];
                                                                $prin .= ',';
                                                            }
                                                            $prin = explode(',', $prin);
                                                            if($prin[2] == "Not Specified") {
                                                              echo $prin[1],' &bull; ',$prin[3];
                                                            }
                                                            else{
                                                              echo $prin[1],' &bull; ',$prin[2],' &bull; ',$prin[3];
                                                            }
                                                            
                                                            $day .= $prin[0];
                                                            $day .= ','; 
                                                            $prin = '';
                                                            ?><br>
                                                            <input type="text" name="position" value="<?php echo $p;?>" style="display: none;"><?php
                                                            }

            											?>
            											</td>
            											<td style="text-align: left;"><?php 
                                                                            $day = explode(',', $day);
                                                                            $leng = sizeof($day);
                                                                            unset($day[$leng-1]);
                                                                            for ($n=0; $n < sizeof($day); $n++)
                                                                            { 
                                                                                if($day[$n] == 1)
                                                                                {
                                                                                    echo $day[$n];
                                                                                    echo " day";
                                                                                }
                                                                                else
                                                                                {
                                                                                    echo $day[$n];
                                                                                    echo " days";
                                                                                }
                                                                                echo "<br>";
                                                                            }
                                                                        ?></td>
            											<td >
        													<input type="text" name="curr_date" value="<?php echo $current_dat;?>" style="display: none;">
        													
        													<input type="text" name="ad_id" value="<?php echo $admit_id;?>" style="display: none;">
        													<input type="text" name="pat_id" value="<?php echo $patient_id;?>" style="display: none;">
        													<button type="submit" style="background-color: orange; border: none; color: white; border-radius: 3px;">X</button>
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
            						<form action="<?php echo URLROOT;?>/doctors/save_medication/<?php echo $admit_id;?>" method="POST">

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
					                                        <label for="exampleInputEmail1">Mediciney</label>
					                                        <input type="text" class="form-control" id="med" name="medicine[]" autocomplete="off">
					                                        <div id="list4"></div>
						                                </div>
				                            		</div>
				                            		<div class="col-lg-3">
				                            			<div class="form-group">
					                                        <label for="exampleInputEmail1">Unit</label>
					                                        <input type="number" class="form-control"
					                                        name="unit[]">
						                                </div>
				                            		</div>
				                            		<div class="col-lg-2">
				                            			<div class="form-group">
				                            				 <label for="exampleInputEmail1"style="margin-left: 10px;" >Procedure</label>
				                            				 <br>
				                            				<a class="btn btn-primary w-md m-b-4" data-toggle="modal" data-target="#intructionmodal22" style="float: right;" >Add Procedure</a>
				                            			</div>
				                            		</div>
				                            	</div>
				                            	</div>
				                            	<br>
				                            	<button type="submit" class="btn btn-success" style="float: right;">Update</button>
				                            	</div> 
				                            </form>
				                            	<!-- /form -->
            							</div>
            					<!-- medication end -->

            					<div class="tab-pane" id="home2">
            						<form action="<?php echo URLROOT;?>/doctors/comorb" method="POST">
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
            							<form action="<?php echo URLROOT;?>/doctors/patient_history" method="POST">
            							<div class="form-group">
            								<input type="number" name="pat" value="<?php echo $patient_id;?>" style="display: none;">
	                                        <label for="exampleInputEmail1">Patient Past History</label>
	                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Past History Details Here" name="past" value="<?php echo $past_his;?>">
		                                </div>
		                                <div class="form-group">
	                                        <label for="exampleInputEmail1">Family History</label>
	                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Investigation Family History Details Here" name="fam" value="<?php echo $fam;?>">
		                                </div>
		                                <div class="form-group">
	                                        <button type="submit" class="btn btn-primary w-md m-b-5">Update</button>
		                                </div>
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
                                            		$new_call = new Doctors;
                                            		$doctor_name = $new_call->call_for_doc_name($keys->ipd_doctor_id);
                                            	?>
                                                <tr>
                                                    <td  style="text-align: left;"><?php echo $keys->admission_date_time;?></td>
                                                    <td  style="text-align: left;"><?php echo $doctor_name?></td>
                                                    <td  style="text-align: left;">
                                                    	<a href="<?php echo URLROOT;?>/doctors/print_prescription_ipd/<?php echo $keys->ipd_admit_id;?>">
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
					                        <select id="ins_sel" style="margin-top: 10px;" class="form-control">
			                                    <option>Please Select Category</option>
			                                     <?php foreach ($data['ins'] as $key) {
												?>
												<option value="<?php echo $key->category; ?>"><?php echo ucwords($key->category); ?></option>
												<?php } ?>
			                                </select>
								        </div> 
                                    </div> 
                                      <div id="ins_appnd">
	                                	
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
	                    			<button class="btn btn-info btn-xs m-b-5" id="add_procedure" style="float: right;">Add More</button>
	                    		</div>
	                    	</div>
	                        <div class="row" id="appnd_the_procedure">
	                            <div class="col-md-2"> 
	                                <div class="form-group"> 
	                                    <div class="form-group">
	                                    	<label>Days</label>
					                        <input type="number" name="day_num0[]" class="form-control" style="border: 1px solid lightgray;">
								        </div> 
	                                </div> 
	                            </div>
	                            <div class="col-md-3"> 
	                                <div class="form-group"> 
	                                    <div class="form-group">
	                                    	<label>Quantity</label>
					                        <select class="form-control" name="tab_quant0[]" style="border: 1px solid lightgray;">
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
					                        <select class="form-control" name="food_manner0[]" style="border: 1px solid lightgray;">
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
					                        <select class="form-control" name="times0[]" style="border: 1px solid lightgray;">
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
	                    	<button onclick="create_session_for_procedure(0)" id="" type="button" class="btn btn-primary">Add</button> 
	                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
	                    </div> 
	                </div> 
	            </div>
	        </div>


	        <div id="intructionmodal222" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	            <div class="modal-dialog"> 
	                <div class="modal-content"> 
	                    <div class="modal-header"> 
	                        <h4 class="modal-title">Add Procedure</h4> 
	                    </div> 
	                    <div class="modal-body"> 
	                    	<div class="col-md-12">
	                    		<div class="row">
	                    			<button class="btn btn-info btn-xs m-b-5" id="add_procedure_x" style="float: right;">Add More</button>
	                    		</div>
	                    	</div>
	                        <div class="row" id="appnd_the_procedure_x">
	                            <div class="col-md-2"> 
	                                <div class="form-group"> 
	                                    <div class="form-group">
	                                    	<label>Days</label>
					                        <input type="number" name="day_numx0[]" class="form-control" style="border: 1px solid lightgray;">
								        </div> 
	                                </div> 
	                            </div>
	                            <div class="col-md-3"> 
	                                <div class="form-group"> 
	                                    <div class="form-group">
	                                    	<label>Quantity</label>
					                        <select class="form-control" name="tab_quantx0[]" style="border: 1px solid lightgray;">
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
					                        <select class="form-control" name="food_mannerx0[]" style="border: 1px solid lightgray;">
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
					                        <select class="form-control" name="timesx0[]" style="border: 1px solid lightgray;">
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
	                    	<button onclick="create_session_for_procedurex(0)" id="" type="button" class="btn btn-primary">Add</button> 
	                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> 
	                    </div> 
	                </div> 
	            </div>
	        </div>





<?php require APPROOT .'/views/inc_doctor/footer.php'; ?>
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
    		<div class="col-lg-3">\
    			<div class="form-group">\
                    <input type="text" class="form-control" id="exampleInputEmail1" name="unit[]">\
                </div>\
    		</div>\
    		<div class="col-lg-2">\
    			<div class="form-group">\
    				<a id="instructionmodal'+i+'" class="btn btn-primary w-md m-b-4" data-toggle="modal" data-target="#intructionmodal22'+i+'" style="float:right">Add Procedure</a>\
    			</div>\
    		</div>\
    		<div id="intructionmodal22'+i+'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">\
	            <div class="modal-dialog"> \
	                <div class="modal-content">\
	                    <div class="modal-header">\
	                        <h4 class="modal-title">Add Procedure</h4>\
	                    </div>\
	                    <div class="modal-body">\
	                    	<div class="col-md-12">\
	                    		<div class="row">\
	                    			<a class="btn btn-info btn-xs m-b-5" onclick="for_appnd('+i+')" style="float:right">Add More</a>\
	                    		</div>\
	                    	</div>\
	                        <div class="row" id="appnd_the_procedure'+i+'">\
	                            <div class="col-md-2"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
	                                    	<label>Days</label>\
					                        <input type="number" name="day_num'+i+'[]" class="form-control" style="border: 1px solid lightgray;">\
								        </div> \
	                                </div> \
	                            </div>\
	                            <div class="col-md-3"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
	                                    	<label>Quantity</label>\
	                                    	<select class="form-control" name="tab_quant'+i+'[]" style="border: 1px solid lightgray;">\
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
					                        <select class="form-control" name="food_manner'+i+'[]" style="border: 1px solid lightgray;">\
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
					                        <select class="form-control" name="times'+i+'[]" style="border: 1px solid lightgray;">\
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
	                            </div>\
	                        </div> \
	                    </div> \
	                    <div class="modal-footer">\
	                    	<button onclick="create_session_for_procedure('+i+')" type="button" class="btn btn-primary">Add</button> \
	                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button> \
	                    </div> \
	                </div> \
	            </div>\
	        </div>');
  });
});	

</script>
<script type="text/javascript">
	function for_appnd(o)
	{
		$('#appnd_the_procedure'+o+'').append('<div class="col-md-2">\
    <div class="form-group">\
	                                    <div class="form-group">\
					                        <input type="number" name="day_num'+o+'[]" class="form-control" style="border: 1px solid lightgray;">\
								        </div> \
	                                </div> \
	                            </div>\
	                            <div class="col-md-3"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
					                        <select class="form-control" name="tab_quant'+o+'[]" style="border: 1px solid lightgray;">\
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
					                        <select class="form-control" name="food_manner'+o+'[]" style="border: 1px solid lightgray;">\
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
					                        <select class="form-control" name="times'+o+'[]" style="border: 1px solid lightgray;">\
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
	}
</script>

<script type="text/javascript">
	function for_appndx(o)
	{
		$('#appnd_the_procedure'+o+'').append('<div class="col-md-2">\
    <div class="form-group">\
	                                    <div class="form-group">\
					                        <input type="number" name="day_numx'+o+'[]" class="form-control" style="border: 1px solid lightgray;">\
								        </div> \
	                                </div> \
	                            </div>\
	                            <div class="col-md-3"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
					                        <select class="form-control" name="tab_quantx'+o+'[]" style="border: 1px solid lightgray;">\
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
					                        <select class="form-control" name="food_mannerx'+o+'[]" style="border: 1px solid lightgray;">\
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
					                        <select class="form-control" name="timesx'+o+'[]" style="border: 1px solid lightgray;">\
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
	}
</script>
<script>
$(document).ready(function(){
	var i = 0;
  $(".add_the_data_x").click(function(){
  	  i++;
    $('.appnd_the_add_on_x').append('<div class="col-lg-8">\
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
    		<div class="col-lg-2">\
    			<div class="form-group">\
    				<a class="btn btn-primary w-md m-b-4" data-toggle="modal" data-target="#intructionmodal222'+i+'">Add Procedure</a>\
    			</div>\
    		</div>\
    		<div id="intructionmodal222'+i+'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">\
	            <div class="modal-dialog">\
	                <div class="modal-content">\
	                    <div class="modal-header">\
	                        <h4 class="modal-title">Add Procedure</h4>\
	                    </div>\
	                    <div class="modal-body">\
	                    	<div class="col-md-12">\
	                    		<div class="row">\
	                    			<a class="btn btn-info btn-xs m-b-5" onclick="for_appndx('+i+')" style="float: right;">Add More</a>\
	                    		</div>\
	                    	</div>\
	                        <div class="row" id="appnd_the_procedure'+i+'">\
	                            <div class="col-md-2"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
	                                    	<label>Days</label>\
					                        <input type="number" name="day_numx0[]" class="form-control" style="border: 1px solid lightgray;">\
								        </div> \
	                                </div> \
	                            </div>\
	                            <div class="col-md-3"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
	                                    	<label>Quantity</label>\
					                        <select class="form-control" name="tab_quantx0[]" style="border: 1px solid lightgray;">\
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
					                        <select class="form-control" name="food_mannerx0[]" style="border: 1px solid lightgray;">\
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
					                        <select class="form-control" name="timesx0[]" style="border: 1px solid lightgray;">\
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
								        </div>\
	                                </div> \
	                            </div>\
	                        </div> \
	                    </div> \
	                    <div class="modal-footer">\
	                    	<button onclick="create_session_for_procedurex(0)" id="" type="button" class="btn btn-primary">Add</button> \
	                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> \
	                    </div> \
	                </div> \
	            </div>\
	        </div>\
');
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
					                        <input type="number" name="day_num0[]" class="form-control" style="border: 1px solid lightgray;">\
								        </div> \
	                                </div> \
	                            </div>\
	                            <div class="col-md-3"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
					                        <select class="form-control" name="tab_quant0[]" style="border: 1px solid lightgray;">\
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
					                        <select class="form-control" name="food_manner0[]" style="border: 1px solid lightgray;">\
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
					                        <select class="form-control" name="times0[]" style="border: 1px solid lightgray;">\
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
					                        <input type="number" name="day_numx0[]" class="form-control" style="border: 1px solid lightgray;">\
								        </div> \
	                                </div> \
	                            </div>\
	                            <div class="col-md-3"> \
	                                <div class="form-group"> \
	                                    <div class="form-group">\
					                        <select class="form-control" name="tab_quantx0[]" style="border: 1px solid lightgray;">\
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
					                        <select class="form-control" name="food_mannerx0[]" style="border: 1px solid lightgray;">\
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
					                        <select class="form-control" name="timesx0[]" style="border: 1px solid lightgray;">\
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
	function create_session_for_procedure(u) {
			var day = $("input[name='day_num"+u+"[]']")
              .map(function(){return $(this).val();}).get();
            var tab = $("select[name='tab_quant"+u+"[]']")
              .map(function(){return $(this).val();}).get();
            var food = $("select[name='food_manner"+u+"[]']")
              .map(function(){return $(this).val();}).get(); 
            var times = $("select[name='times"+u+"[]']")
              .map(function(){return $(this).val();}).get();
            var position = u;
            var all_procedure = day;
            all_procedure += ',';
            all_procedure += tab;
            all_procedure += ',';
            all_procedure += food;
            all_procedure += ',';
            all_procedure += times;
            all_procedure += '$&$x';
            //alert(all_procedure);
            $.ajax({
            	url:'<?php echo URLROOT;?>/doctors/procedure_session',
            	type:'POST',
            	data:{all_procedure, position},

            	success : function(data)
            	{
            		swal({
			                title: "Procedure added..!",   
			                timer: 700,   
			                showConfirmButton: false 
         			    });
            		$('#intructionmodal22').modal('toggle');
            	}
            });
	}
</script>

<script type="text/javascript">
	function create_session_for_procedurex(u) {
			var day = $("input[name='day_numx"+u+"[]']")
              .map(function(){return $(this).val();}).get();
            var tab = $("select[name='tab_quantx"+u+"[]']")
              .map(function(){return $(this).val();}).get();
            var food = $("select[name='food_mannerx"+u+"[]']")
              .map(function(){return $(this).val();}).get(); 
            var times = $("select[name='timesx"+u+"[]']")
              .map(function(){return $(this).val();}).get();
            var position = u;
            var all_procedure = day;
            all_procedure += ',';
            all_procedure += tab;
            all_procedure += ',';
            all_procedure += food;
            all_procedure += ',';
            all_procedure += times;
            all_procedure += '$&$x';
            alert(all_procedure);
            $.ajax({
            	url:'<?php echo URLROOT;?>/doctors/procedure_session',
            	type:'POST',
            	data:{all_procedure, position},

            	success : function(data)
            	{
            		alert(data);
            		$('#intructionmodal222').modal('toggle');
            	}
            });
	}
</script>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="ot_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Suggest Operation</h4>
      </div>
      <form action="<?php echo URLROOT; ?>/doctors/ot_details" method="POST">
      <div class="modal-body">
      	<input type="number" name="pid" value="<?php echo $admit_id; ?>" style="display: none;">
      	<input type="number" name="pat_id" value="<?php echo $patient_id; ?>" style="display: none;">
        <div class="form-group">
        	<label>Enter Operation Date</label>
        	<input type="datetime-local" name="ot_date" class="form-control">
        </div>
        <div class="form-group">
        	<label>Enter Operation Name</label>
        	<input type="text" name="ot_name" class="form-control">
        </div>
        <div class="form-group">
        	<label>Enter Description</label>
        	<textarea class="form-control" name="ot_des"></textarea>
        </div>
      </div>
  	 
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
        <a class="btn btn-warning" data-dismiss="modal">Close</a>
      </div>
       </form>
    </div>
  </div>
</div>

<div id="reportupload" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <!-- <form method="post" action="" enctype="multipart/form-data">  -->
                    <div class="modal-dialog"> 
                        <div class="modal-content"> 
                            <div class="modal-header"> 
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                <h4 class="modal-title">Upload Reports</h4> 
                            </div> 
                            <div class="modal-body">
                            <div class="row"> 
                                <div class="col-md-12">
                                    <div class="col-md-12">
						                <div class="form-group">
											<label for="exampleInputEmail1">Enter Admit ID</label>
						                        <input style="margin-top: 10px;" name="report_up" type="text" class="form-control autocomplete" placeholder="" id="a" value="<?php echo $admit_id ?>">
									    </div>
									</div>
									<div class="col-md-12">
						                <div class="form-group">
											<label for="exampleInputEmail1">Enter Report Title</label>
						                        <input style="margin-top: 10px;" type="text" id="rep_tit" class="form-control" placeholder="" name="report_title">
									    </div>
                      <!-- <input type='text' id='a' class="autocomplete"> -->
									</div>
									<div class="col-md-12">
						                <div class="form-group">
                                            <label for="exampleInputEmail1">Please Select a Report</label>
                                            <input style="margin-top: 10px;" name="file" type="file" id="file" class="form-control" placeholder="">
                                        </div>
									</div>
                                    <div class="col-md-12">
                                        <div class="progress aft_upd1" style="display: none;">
                                            <div class="progress-bar progress-bar-success progress-bar-striped progress-animated wow animated" role="progressbar" aria-valuenow="48" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                            </div>
                                        </div> 
                                        <div class="aft_upd2" style="display: none;">
                                            <span style="color: #81C784">File Uploaded Successfully.</span>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" id="upl_doc" class="btn btn-info w-md m-b-5">Upload</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="pgbar"></div>
                                </div> 
                            </div>  
                        </div>
                    </div>
                </div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.yes_act').css('background-color','#F2F3F4');
		$('.no_act').click(function(){
			$('.yes_act').css('background-color','white');
		});
		$('.yes_act').click(function(){
			$('.yes_act').css('background-color','#F2F3F4');
		});
	});
</script>

<script type="text/javascript"> 
$(document).ready(function() { 
    $("#upl_doc").click(function() { 
        var ip_rep = $('#a').val();
        var rep_tit = $('#rep_tit').val();
        var fd = new FormData(); 
        var files = $('#file')[0].files[0]; 
        fd.append('file', files); 
        $.ajax({ 
            url: '<?php echo URLROOT; ?>/doctors/doc_upload_jq', 
            type: 'POST', 
            data: fd,
            contentType: false, 
            processData: false, 
            success: function(response){ 
                if(response != 0){ 
                   $('.aft_upd1').css("display", "block");
                   setTimeout( function(){ 
                    $('.aft_upd2').css("display", "block"); 
                  }  , 5000 );
                    save_other_upload_details(ip_rep, rep_tit);
                } 
                else{ 
                    alert('file not uploaded'); 
                } 
            }, 
        }); 
    }); 
}); 

function save_other_upload_details(ip_rep, rep_tit)
{
    $.ajax({
        url:'<?php echo URLROOT; ?>/doctors/save_other_upload_details_ip',
        type:'POST',
        data:{ip_rep, rep_tit},
        success : function(data)
        {
            return true;
        }
    });
}
</script>

<!-- Script -->
<script src='<?php echo URLROOT; ?>/autocomp/jquery-3.1.1.min.js' type='text/javascript'></script>

<!-- jQuery UI -->
<link href='<?php echo URLROOT; ?>/autocomp/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo URLROOT; ?>/autocomp/jquery-ui.min.js' type='text/javascript'></script>

</head>
<body>


<script type="text/javascript">
	$("#un_dis").click(function(){
		var ad_id = <?php echo $admit_id; ?>;
		$.ajax({
			url:'<?php echo URLROOT ?>/doctors/un_dis',
			type:'POST',
			data:{ad_id},
			success: function(data)
			{
				alert(data);
				location.reload(true);
			}
		});
	});
</script>
<script type="text/javascript">
	$('#ins_sel').on('change', function (e) {
	    var optionSelected = $("option:selected", this);
	    var cat = this.value;
		$.ajax({
			url: "<?php echo URLROOT; ?>/doctors/get_ins_of_cat",
			type: "POST",
			data: {cat},
			success: function(data)
			{
				$('#ins_appnd').html(data);
			}
		});
		});

	function display_ins_in_textarea(id)
	{
		$('#ins_field').text(id);
	}
</script>