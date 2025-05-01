<?php require APPROOT .'/views/inc_doctor/header.php'; ?>
<style type="text/css">
	    #list4, .bnm{
        max-height: 100px;
        max-width: 375px;                         
        min-width: 375px;
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

      .cc:hover, .ccx:hover{
        background-color: lightgray;
      }
      .cc, .ccx{
        padding: 3px;
        border-bottom: 1px #F8F9F9 solid;
      }
</style>
<?php
	foreach ($data['gen'] as $key)
	{
		$pname = $key->patient_name;
		$p_id = $key->patient_id;
		// if($key->patient_gender == 1)
		// 	$pgen = "Male";
		// else
		// 	$pgen = "Female";
		$pgen = $key->patient_gender;
		$pdob = $key->patient_dob;
		$pphone = $key->patient_phone;
		$pemail = $key->patient_email;
		$padd = $key->patient_address;
		$au_year = $key->age_update_time;
		$reg_date = $key->registered_time;
		$age = $key->patient_age;
	}
	foreach ($data['opd'] as $key2)
	{
		$pur = $key2->opd_purpose;
		$opdid = $key2->opd_visit_id;
		$opd_doc_id = $key2->opd_doctor_id;
	}

	$doc_obj = new Doctors;
	$doc_n = $doc_obj->call_for_doc_name($opd_doc_id);


	$i = 0;
	foreach ($data['opd2'] as $key3)
	{
		$i++;
		$date_visit = $key3->visit_date_time;
	}
?>
<div class="wraper container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body" style="padding-top: 0px;">
                <div class="col-md-8">
                	<div class="col-lg-6">
                		<b>Name:</b> <?php echo ucwords($pname);?><small>(<?php echo $p_id;  ?>)</small>
                	</div>
                	<div class="col-lg-6">
                		<b>Visit ID: </b><?php echo $opdid; ?>
                	</div>
                	<div class="col-lg-6">
                		<b>Age:</b> <?php
                                        $curr_yr = date('Y-m-d');
                                        if($pdob != "0000-00-00")
                                        {
                                            $diff = abs(strtotime($curr_yr) - strtotime($pdob));
                                            $years = floor($diff / (365*60*60*24));
                                            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
                                            if($years > 1)
                                            {
                                                echo $years;
                                                echo " years ";
                                            }
                                            else
                                            {
                                                if($years != 0)
                                                {
                                                    echo $years;
                                                    echo " year ";
                                                }
                                            }
                                            if($years < 1)
                                            {
                                                if($months > 1)
                                                {
                                                    echo $months;
                                                    echo " months";
                                                }
                                                else
                                                {
                                                    if($months != 0)
                                                    {
                                                        echo $months;
                                                        echo " month";
                                                    }
                                                    else
                                                    {
                                                        if($days > 0)
                                                        {
                                                            echo $days;
                                                            echo " days";
                                                        }
                                                        else
                                                        {
                                                            echo $days;
                                                            echo " day";
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $au_year = date('Y', strtotime($reg_date));
                                            $c_year = date('Y');
                                            $age = $age + ($c_year - $au_year);
                                            if($age > 1)
                                            {
                                                echo $age;
                                                echo " years";
                                            }
                                            else
                                            {
                                                echo $age;
                                                echo " year";
                                            }
                                        }
                                    ?>
                	</div>

                	<div class="col-lg-6">
                		<b>Doctor Name:</b> <?php echo ucwords($doc_n); ?>
                	</div>
                	<div class="col-lg-6">
                		<b>Visit Purpose:</b> <?php echo ucwords($pur);?> 
                	</div>
                	<div class="col-lg-6">
                		<b>Doctor ID: </b><?php echo $opd_doc_id; ?>
                	</div>
                </div>
                <div class="col-md-4">
                	<a data-target="#reportupload" data-toggle="modal" ><button style="float: right;" class="btn btn-info w-md m-b-5">Upload Report</button></a>
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
                                  <a href="#home" data-toggle="tab" id="smh" aria-expanded="true" class="list-group-item imone">Present Visit</a>
                                  <a href="#home4" data-toggle="tab" id="smh" aria-expanded="false" class="list-group-item imtwo">Basic Information</a>
                                  <a href="#home2" data-toggle="tab" id="smh" aria-expanded="false" class="list-group-item imtwo">Co-Morbidities</a>
                                  <a href="#home3" data-toggle="tab" id="smh" aria-expanded="false" class="list-group-item imtwo" >Patient History</a>
                                  <?php if($i>0){?>
                                   <a href="#home5" data-toggle="tab" aria-expanded="false" class="list-group-item imtwo">Previous Visits</a>

                                  <a href="#home6" data-toggle="tab" aria-expanded="false" class="list-group-item imtwo">Previous Admissions</a>
                                	<?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Left sidebar -->
                    <!-- Right Sidebar -->
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-lg-12">
                              	<div class="panel panel-default m-t-20">
                            		<div class="panel-body p-t-10">
		                                <div class="col-lg-12"> 
		                                	<div class="tab-content">
		            <!-- ####################present visit###################### -->
                            					<div class="tab-pane active" id="home">
                            						<form action="<?php echo URLROOT;?>/doctors/save_present_visit" method="POST">
                            					 	<ul class="nav nav-tabs nav-justified">
								                            <li class="active">
								                                <a href="#home-2" data-toggle="tab" aria-expanded="true"> 
								                                    <span class="visible-xs"><i class="fa fa-home"></i></span> 
								                                    <span class="hidden-xs">Examination & Investigation</span>
								                                </a> 
								                            </li> 
								                            <li class=""> 
								                                <a href="#profile-2" data-toggle="tab" aria-expanded="false"> 
								                                    <span class="visible-xs"><i class="fa fa-user"></i></span> 
								                                    <span class="hidden-xs">Consultation</span> 
								                                </a> 
								                            </li> 
								                            <li class=""> 
								                                <a href="#messages-2" data-toggle="tab" aria-expanded="false"> 
								                                    <span class="visible-xs"><i class="fa fa-envelope-o"></i></span> 
								                                    <span class="hidden-xs">Conclusion</span> 
								                                </a> 
								                            </li>  
								                        </ul> 
								                        <div class="tab-content"> 
								                            <div class="tab-pane active" id="home-2"> 
                                                                <div class="form-group">
                                                                        <label for="exampleInputEmail1">Drug Allergy</label>
                                                                        <input type="text" class="form-control" placeholder="Enter Drug Allergy Condition" name="allergy_cond">
                                                                </div>
								                                <div class="form-group">
								                                        <label for="exampleInputEmail1">Present Condition</label>
								                                        <input style="display: none" type="text" name="idc" autocomplete="off" value="<?php echo $data['idc'];?>">
								                                        <input type="text" class="form-control" placeholder="Enter Present Condition Here" name="pres_cond">
								                                </div>
								                                <div class="form-group">
								                                        <label for="exampleInputEmail1">Examination</label>
								                                        <input type="text" autocomplete="off" class="form-control" placeholder="Enter Examination Details" name="exam_det">
								                                </div>
								                                <div class="form-group">
								                                        <label for="exampleInputEmail1">Investigation</label>
								                                        <input type="text" autocomplete="off" class="form-control" placeholder="Enter Investigation Details" name="inv_det">
								                                </div>
								                                <div class="form-group">
								                                        <label for="exampleInputEmail1">Notes</label>
								                                        <input type="text" autocomplete="off" class="form-control"  placeholder="Enter Any Other Information" name="other_inf">
								                                </div> 
								                            </div> 
								                            <div class="tab-pane" id="profile-2">
								                            	<div class="row">
								                            		<div class="col-lg-12">
								                            			<div class="form-group">
									                                        <label for="exampleInputEmail1">Diagnosis</label>
									                                        <input type="text" autocomplete="off" class="form-control" placeholder="Enter Diagnosis" name="diag">
										                                </div>
								                            		</div>
								                            		<div class="col-lg-12">
								                            			<br>
								                            		</div>
								                            		<div class="col-lg-12">
								                            			<b>Prescription&nbsp;&nbsp;</b>
								                            			<a id="add_the_data" class="btn btn-purple btn-xs m-b-5">Add Prescription</a>
								                            		</div>
								                            		<div class="col-lg-12">
								                            			<br>
								                            		</div>
								                            		<div id="appnd_the_add_on">
								                            		<div class="col-lg-8">
								                            			<div class="form-group">
									                                        <label for="exampleInputEmail1">Medicine</label>
									                                        <input type="text" class="form-control" name="medicine[]" id="med" autocomplete="off">
									                                        <div id="list4"></div>
										                                </div>
										                                
								                            		</div>

								                            		<div class="col-lg-2">
								                            			<div class="form-group">
									                                        <label for="exampleInputEmail1">Unit</label>
									                                        <input type="text" class="form-control"  name="unit[]" autocomplete="off">
										                                </div>
								                            		</div>
								                            		<div class="col-lg-2">
								                            			<div class="form-group">
								                            				 <label for="exampleInputEmail1">Procedure</label>
								                            				<a class="btn btn-primary w-md m-b-4" data-toggle="modal" data-target="#intructionmodal22">Add Procedure</a>
								                            			</div>
								                            		</div>
								                            		</div>
								                            		<div class="col-lg-12">
								                            			<br>
								                            		</div>
								                            		<div class="col-lg-12">
								                            			<div class="form-group">
								                            				 <label for="exampleInputEmail1">Instructions</label>
								                            				 <a class="btn btn-success btn-xs m-b-5" style="float: right;" data-toggle="modal" data-target="#intructionmodal">Select Instruction</a>
								                            				<textarea type="text" class="form-control" name="inst" id="ins_field"></textarea> 
								                            			</div>
								                            		</div>
								                            	</div>                             
								                            </div> 
								                            <div class="tab-pane" id="messages-2">
								                                 <div class="row">
								                            		<div class="col-lg-12">
								                            			<div class="form-group">
									                                        <label for="exampleInputEmail1">Advice Test</label>
									                                        <input type="text" class="form-control autocomplete1" id="autoCompTest" name="txt_adv"  placeholder="Enter Any Other Information" >
										                                </div>
								                            		</div>
																	<div class="col-lg-12">
								                            			<div class="form-group">
									                                        <label for="exampleInputEmail1">Advice</label>
									                                        <textarea name="advice_for_patient" class="form-control"></textarea>
										                                </div>
								                            		</div>
								                            		<div class="col-lg-6">
								                            			<div class="form-group">
									                                        <label for="exampleInputEmail1">Follow Up Date</label>
									                                        <input type="date" class="form-control"  name="f_up_date">
										                                </div>
								                            		</div>
								                            		<div class="col-lg-6">
								                            			<div class="form-group">
									                                        <label for="exampleInputEmail1">Not a Regular Fee?</label>
									                                        <input type="number" class="form-control" id="exampleInputEmail1" placeholder="Enter your current visit fee" name="n_reg_fee" value="0" autocomplete="off">
										                                </div>
								                            		</div>
								                            		<div class="col-lg-12">
								                            			<div class="form-group">
								                            				 
								                            				<button type="submit" class="btn btn-primary w-md m-b-5" style="float: right;">Finish Visit</button>
								                            			</div>
								                            		</div>
								                            </div>  
								                        </div> 
								                        <br> 
								                    </div>
								                    </form>
                            					</div>
                            				
                            				
       <!-- ######################Present Visit############################ -->
                            				<div class="tab-pane" id="home2">
                            					<form action="<?php echo URLROOT;?>/doctors/save_co_morbidities/<?php echo $p_id;?>" method="POST">
                            						<div class="col-lg-12">
                            							<?php
					                                        foreach ($data['gen'] as $key) {
					                                        	$hypertension=$key->hypertension;
					                                        	$diabetes=$key->diabetes;
					                                        	$coronary=$key->coronary;
					                                        	$cerebro=$key->cerebro;
					                                        	$dyslipidaemia=$key->dyslipidaemia;
					                                        	$hypothyroidism=$key->hypothyroidism;
					                                        	$other=$key->other;
					                                        	$patient_history =$key->patient_history;
					                                        	$family_history =$key->family_history;
                                                                $mon = $key->patient_history_mon;
                                                                $year = $key->patient_history_year;
					                                        }?>
				                            			<div class="form-group">
					                                        <label for="exampleInputEmail1">Hypertension</label>
					                                        <input style="display: none" type="text" name="idc" value="<?php echo $data['idc'];?>" autocomplete="off">
					                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Hypertension Details Here" name="hyp" autocomplete="off"  value="<?php if(!empty($hypertension)){ echo $hypertension; } ?>">
						                                </div>
						                                <div class="form-group">
					                                        <label for="exampleInputEmail1">Diabetes Mellitus</label>
					                                        <input type="text" autocomplete="off" class="form-control" id="exampleInputEmail1" placeholder="Enter Diabetes Mellitus Details Here" name="dia_mel" value="<?php if(!empty($diabetes)){ echo $diabetes;} ?>">
						                                </div>
						                                <div class="form-group">
					                                        <label for="exampleInputEmail1">Coronary Artery Disease</label>
					                                        <input type="text" autocomplete="off" class="form-control" id="exampleInputEmail1" placeholder="Enter Coronary Artery Disease Details Here" name="cor_art_dis" value="<?php if(!empty($coronary)) { echo $coronary;} ?>">
						                                </div>
						                                <div class="form-group">
					                                        <label for="exampleInputEmail1">Cerebrovascular disease / Peripheral Vascular Disease</label>
					                                        <input type="text" autocomplete="off" class="form-control" id="exampleInputEmail1" placeholder="Enter Cerebrovascular disease / Peripheral Vascular Disease Details Here" name="cdpvd"  value="<?php if(!empty($cerebro)){ echo $cerebro;}?>">
						                                </div>
						                                <div class="form-group">
					                                        <label for="exampleInputEmail1">Dyslipidaemia</label>
					                                        <input type="text" autocomplete="off" class="form-control" id="exampleInputEmail1" placeholder="Enter Dyslipidaemia Details Here" name="dys" value="<?php if(!empty($dyslipidaemia)){ echo $dyslipidaemia;} ?>">
						                                </div>
						                                <div class="form-group">
					                                        <label for="exampleInputEmail1">Hypothyroidism</label>
					                                        <input type="text" autocomplete="off" class="form-control" id="exampleInputEmail1" placeholder="Enter Hypothyroidism Details Here" name="hypo" value="<?php if(!empty($hypothyroidism)){ echo $hypothyroidism;} ?>">
						                                </div>
						                                <div class="form-group">
					                                        <label for="exampleInputEmail1">Other allergic/ chronic disorders</label>
					                                        <input type="text" autocomplete="off" class="form-control" id="exampleInputEmail1" placeholder="Enter Other Details Here" name="oacd" value="<?php if(!empty($other)){ echo $other;} ?>">
						                                </div>
						                                <div class="form-group">
					                                        <button type="submit" class="btn btn-primary w-md m-b-5">Update</button>
						                                </div>
				                            		</div>
				                            	</form>	
                            					</div>
                            					<div class="tab-pane" id="home3">
                            					<form action="<?php echo URLROOT;?>/doctors/save_pat_his/<?php echo $p_id;?>" method="POST">	
                            						<div class="col-lg-12">
                            							<div class="form-group">
                                                            <a class="btn btn-purple btn-xs m-b-5" style="float: right;" id="patHisAdd"> + Add</a>
					                                        <label for="exampleInputEmail1">Patient Past History</label>
					                                        <input style="display: none" type="text" name="idc" value="<?php echo $data['idc'];?>" autocomplete="off">
                                                            <div class="row" id="patHisDiv">
                                                                <br>
                                                                <div class="col-md-8">
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Past History Details Here" name="past_his[]" autocomplete="off" value="">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <select class="form-control" name="mon[]">
                                                                        <option>Jan</option>
                                                                        <option>Feb</option>
                                                                        <option>Mar</option>
                                                                        <option>Apr</option>
                                                                        <option>May</option>
                                                                        <option>Jun</option>
                                                                        <option>Jul</option>
                                                                        <option>Aug</option>
                                                                        <option>Sep</option>
                                                                        <option>Oct</option>
                                                                        <option>Nov</option>
                                                                        <option>Dec</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input type="number" class="form-control" placeholder="year" name="year[]">
                                                                </div>
                                                                <br>
                                                            </div>
					                                        

                                                            <br>
                                                            <?php if(!empty($patient_history)) { 
                                                                $patHis = explode(',', $patient_history);
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
						                                </div>
						                                <div class="form-group">
					                                        <label for="exampleInputEmail1">Family History</label>
					                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Investigation Family History Details Here" name="fam_his" autocomplete="off" value="<?php if(!empty($family_history)){echo $family_history; } ?>">
						                                </div>
						                                <div class="form-group">
					                                        <button type="submit" class="btn btn-primary w-md m-b-5">Update</button>
						                                </div>
                            						</div>
                            					</form>
                            					</div>
                            					<div class="tab-pane" id="home4">
                            						
                            						<div class="col-lg-12">
                            							<div class="row">
                            							<div class="col-lg-6">
	                            							<div class="form-group">
						                                        <label for="exampleInputEmail1">Name</label>
						                                        <input type="text" autocomplete="off" class="form-control" id="exampleInputEmail1" disabled value="<?php echo $pname;?>">
							                                </div> 
							                            </div>
							                            <div class="col-lg-6">
	                            							<div class="form-group">
						                                        <label for="exampleInputEmail1">Gender</label>
						                                        <input type="text" autocomplete="off" class="form-control" id="exampleInputEmail1" disabled value="<?php echo $pgen;?>">
							                                </div>
							                            </div>
							                            <div class="col-lg-6">
	                            							<div class="form-group">
						                                        <label for="exampleInputEmail1">Date Of Birth</label>
						                                        <input type="text" autocomplete="off" class="form-control" id="exampleInputEmail1" disabled value="<?php echo $pdob;?>">
							                                </div>
							                            </div>
							                            <div class="col-lg-6">
	                            							<div class="form-group">
						                                        <label for="exampleInputEmail1">Email</label>
						                                        <input type="text" autocomplete="off" class="form-control" id="exampleInputEmail1" disabled value="<?php echo $pemail;?>">
							                                </div>
							                            </div>
							                            <div class="col-lg-6">
	                            							<div class="form-group">
						                                        <label for="exampleInputEmail1">Phone</label>
						                                        <input type="text" autocomplete="off" class="form-control" id="exampleInputEmail1" disabled value="<?php echo $pphone;?>">
							                                </div>
							                            </div>
							                            <div class="col-lg-6">
	                            							<div class="form-group">
						                                        <label for="exampleInputEmail1">Address</label>
						                                        <textarea type="text" class="form-control" id="exampleInputEmail1"  disabled rows="1" placeholder="<?php echo $padd;?>"></textarea>
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
                            							<div class="col-lg-6">
	                            							<div class="form-group">
						                                        <label for="exampleInputEmail1">Total Visits</label>
						                                        <input type="text" autocomplete="off" class="form-control" id="exampleInputEmail1" value="<?php echo $i;?>" readonly="">
							                                </div>
							                            </div>
							                            <div class="col-lg-6">
	                            							<div class="form-group">
						                                        <label for="exampleInputEmail1">Last Visit</label>
						                                        <input type="text" autocomplete="off" class="form-control" id="exampleInputEmail1" value="<?php echo $date_visit;?>" readonly="">
							                                </div>
							                            </div>
							                            <div class="col-lg-12">
							                            <div class="table-responsive">
			                                            <table class="table">
			                                                <thead>
			                                                    <tr>
			                                                        <th  style="text-align: left;" class="col-lg-3" >Date</th>
			                                                        <th  style="text-align: left;" class="col-lg-5">Visited Doctor</th>
			                                                        <th  style="text-align: left;" class="col-lg-4">Action</th>
			                                                    </tr>
			                                                </thead>
			                                                <tbody >
			                                                	<?php foreach($data['opd2'] as $test) { 
			                                                		$doc = new Doctors;
			                                                		$doc_data = $doc->get_doc($test->opd_doctor_id);
			                                                		foreach ($doc_data as $value)
			                                                		{
			                                                			$doc_name = $value->doctor_name;
			                                                		}
			                                                		?>
			                                                    <tr>
			                                                        <td  style="text-align: left;"><?php echo date('d-m-Y h:i A',strtotime($test->visit_date_time));?></td>
			                                                        <td  style="text-align: left;">Dr. <?php echo ucwords($doc_name);?></td>
			                                                        <td  style="text-align: left;">
			                                                            <a href="<?php echo URLROOT;?>/doctors/print_prescription/<?php echo $test->opd_visit_id;?>"><button style="width: 54px" type="button" class="btn btn-success btn-xs m-b-5">Print</button></a>
			                                                            <a href="<?php echo URLROOT;?>/doctors/print_prescription/<?php echo $test->opd_visit_id;?>"><button style="width: 54px" type="button" class="btn btn-purple btn-xs m-b-5">View</button></a>
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

                            					<div class="tab-pane" id="home6">
                            						<div class="col-lg-12">
                            							<div class="row">
                            							
							                            <div class="col-lg-12">
							                            <div class="table-responsive">
			                                            <table class="table">
			                                                <thead>
			                                                    <tr>
			                                                        <th style="text-align: left;" class="col-lg-4">Patients Admit Date</th>
			                                                        <th></th>
			                                                        <th  style="text-align: left;" class="col-lg-4">&nbsp;&nbsp;Consult Doctor</th>
			                                                        
			                                                    </tr>
			                                                </thead>
			                                                <tbody >
			                                                	<?php foreach($data['ipd_d'] as $test) {


			                                                		$doc = new Doctors;
			                                                		$doc_data = $doc->get_doc($test->ipd_doctor_id);
			                                                		foreach ($doc_data as $value)
			                                                		{
			                                                			$doc_name = $value->doctor_name;
			                                                		}
			                                                		?>
			                                                    <tr>

			                                                        <td  style="text-align: left;"><?php echo date('d-m-Y H:i A',strtotime($test->admission_date_time));


			                                                        ?></td>
			                                                        <td>
			                                                        	
			                                                        		
			                                                        	</td>
			                                                        <td  style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;Dr. <?php echo ucwords($doc_name);?></td>
			                                                        
			                                                    </tr> 

			                                                <?php break; } ?>

			                                                	<tr>
			                                                		<td style="text-align: left;"><?php echo $data['a']; ?></td>
			                                                		<td></td>
			                                                		<td style="text-align: left;"> <?php echo $data['a']; ?></td>
			                                                	</tr>

			                                               


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
			                                    <option selected="" disabled="">Please Select Category</option>
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


        <!-- <div id="reportupload" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <form method="post" action="<?php echo URLROOT;?>/doctors/report_up" enctype="multipart/form-data"> 
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
											<label for="exampleInputEmail1">Enter Visit ID</label>
						                        <input style="margin-top: 10px;" name="report_vid" type="text" class="form-control" placeholder="">
									    </div>
									</div>
									<div class="col-md-12">
						                <div class="form-group">
											<label for="exampleInputEmail1">Enter Report Title</label>
						                        <input style="margin-top: 10px;" type="text" class="form-control" placeholder="" name="report_title">
									    </div>
									</div>
									<div class="col-md-12">
						                <div class="form-group">
                                            <label for="exampleInputEmail1">Please Select a Report</label>
                                            <input style="margin-top: 10px;" name="files" type="file" class="form-control" placeholder="">
                                        </div>
									</div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info w-md m-b-5">Create Test</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="pgbar"></div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div> -->

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
			                                    <option>With Food</option>
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
	                    	<button onclick="create_session_for_procedure(0)" type="button" class="btn btn-primary">Add</button> 
	                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button> 
	                    </div> 
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
											<label for="exampleInputEmail1">Enter patient ID</label>
						                        <input style="margin-top: 10px;" name="report_up" type="text" class="form-control autocomplete" autocomplete="off" placeholder="" id="a" value="<?php echo ucwords($pname);?>(<?php echo $p_id; ?>)">
									    </div>
									</div>
									<div class="col-md-12">
						                <div class="form-group">
											<label for="exampleInputEmail1">Enter Report Title</label>
						                        <input style="margin-top: 10px;" type="text"  autocomplete="off" id="rep_tit" class="form-control" placeholder="" name="report_title">
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
            </div>


<?php require APPROOT .'/views/inc_doctor/footer.php'; ?>
<script>
$(document).ready(function(){
  var i = 0;
  $("#add_the_data").click(function(){
    i++;
    $('#appnd_the_add_on').append('<div class="col-lg-8">\
    			<div class="form-group">\
                <input type="text" class="form-control" id="med'+i+'" name="medicine[]" onclick="xyz('+i+')" autocomplete="off">\
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
    				<a class="btn btn-primary w-md m-b-4" data-toggle="modal" data-target="#intructionmodal'+i+'">Add Procedure</a>\
    			</div>\
    		</div>\
    		<div id="intructionmodal'+i+'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">\
	            <div class="modal-dialog"> \
	                <div class="modal-content">\
	                    <div class="modal-header">\
	                        <h4 class="modal-title">Add Procedure</h4>\
	                    </div>\
	                    <div class="modal-body">\
	                    	<div class="col-md-12">\
	                    		<div class="row">\
	                    			<a class="btn btn-info btn-xs m-b-5" onclick="for_appnd('+i+')">Add More</a>\
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
		$("#non1").click(function(){
    $('#appnd_the_procedure1').append('<div class="col-md-2">\
    <div class="form-group">\
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
</script>

<script>
$(document).ready(function(){
  $("#add_procedure").click(function(){
    $('#appnd_the_procedure').append('<div class="col-md-2">\ 	                                <div class="form-group"> \
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
            		//alert(data);
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
	var idType = 1;
    $.ajax({
        url:'<?php echo URLROOT; ?>/doctors/save_other_upload_details',
        type:'POST',
        data:{ip_rep, rep_tit, idType},
        success : function(data)
        {
            alert(data);
        }
    });
}
</script>

<script type="text/javascript">
	$('.imtwo').click(function(){
		$('.imone').css({"background-color": "white"});
	});

	$('.imone').click(function(){
		$('.imone').css({"background-color": "#F4F6F6"});
	});

	$(document).ready(function(){
		$('.imone').css({"background-color": "#F4F6F6"});
	});
</script>
<script src='<?php echo URLROOT; ?>/autocomp/jquery-3.1.1.min.js' type='text/javascript'></script>

    <!-- jQuery UI -->
    <link href='<?php echo URLROOT; ?>/autocomp/jquery-ui.min.css' rel='stylesheet' type='text/css'>
    <script src='<?php echo URLROOT; ?>/autocomp/jquery-ui.min.js' type='text/javascript'></script>
<script type="text/javascript">
	
	$( function() {
        $( "#autoCompTest" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "<?php echo URLROOT ?>/doctors/getTests",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {

                        response( data );
                    }
                });
            },
            select: function (event, ui) {

                $('#autoCompTest').val(ui.item.label); // display the selected text
                return false;
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

<script type="text/javascript">
    $(document).ready(function(){
        $('#patHisAdd').click(function(){
            $('#patHisDiv').append('<br><div class="col-md-8">\
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Past History Details Here" name="past_his[]" autocomplete="off" value="">\
                                    </div>\
                                    <div class="col-md-2">\
                                        <select class="form-control" name="mon[]">\
                                            <option>Jan</option>\
                                            <option>Feb</option>\
                                            <option>Mar</option>\
                                            <option>Apr</option>\
                                            <option>May</option>\
                                            <option>Jun</option>\
                                            <option>Jul</option>\
                                            <option>Aug</option>\
                                            <option>Sep</option>\
                                            <option>Oct</option>\
                                            <option>Nov</option>\
                                            <option>Dec</option>\
                                        </select>\
                                    </div>\
                                    <div class="col-md-2">\
                                        <input type="number" class="form-control" placeholder="year" name="year[]">\
                                    </div>');
        });
    });
</script>







