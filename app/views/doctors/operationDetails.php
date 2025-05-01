<?php require APPROOT .'/views/inc_doctor/header.php'; ?>
<?php
	$docObj = new Doctor;
?>
<div class="wraper container-fluid">       
    <div class="page-title"> 
        <h3 class="title">Operation Details</h3> 
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Operation</h3></div>
                <div class="panel-body">
                	<div class=" form">
                        <form class="cmxform form-horizontal tasi-form" id="signupForm" method="get" action="#" novalidate="novalidate">
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Patient Name:</label>
                                <div class="col-lg-10">
                                    <h4><?php $pName = $docObj->getPatientName($data['ot']->patient_id);
                                    	echo ucwords($pName->patient_name).'('.$data['ot']->patient_id.')';
                                    ?></h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">IP/OP Id:</label>
                                <div class="col-lg-10">
                                    <h4><?php echo $data['ot']->ip_op_ref; ?></h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Referred Doctor:</label>
                                <div class="col-lg-10">
                                    <h4><?php
                                    	$docName = $docObj->getDocName($data['ot']->ip_op_doc_ref_id);
                                    	echo ucwords($docName->doctor_name).'('.$data['ot']->ip_op_doc_ref_id.')';
                                    ?></h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Operation Name:</label>
                                <div class="col-lg-10">
                                    <h4><?php echo ucwords($data['ot']->ot_name); ?></h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Operation Description:</label>
                                <div class="col-lg-10">
                                    <h4><?php echo ucwords($data['ot']->ot_description); ?></h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Status:</label>
                                <div class="col-lg-10">
                                    <h4>
                                    	<?php
			                        		if($data['ot']->status == 0)
			                        		{
			                        			echo "Assigned";
			                        		}
			                        		else if($data['ot']->status == 1 || $data['ot']->status == 2)
			                        		{
			                        			echo "Active";
			                        		}
			                        		else if($data['ot']->status == 3)
			                        		{
			                        			echo "Completed";
			                        		}
			                        		else if($data['ot']->status == 4)
			                        		{
			                        			echo 'Cancelled';
			                        		}
			                        	?>
                                    </h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Operation Date & Time:</label>
                                <div class="col-lg-10">
                                    <h4><?php echo date('d-m-Y H:i A', strtotime($data['ot']->created_at)); ?></h4>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-title"> 
    	<?php if(isset($data['ot']->ot_team_doc) || isset($data['ot']->ot_team_nur) || isset($data['ot']->ot_team_oth)) { ?>
         <h3 class="title">Operation Team</h3> 
     	<?php } ?>
    </div>
    <?php
    	$docTeam = explode(',', $data['ot']->ot_team_doc);
    	$nurTeam = explode(',', $data['ot']->ot_team_nur);
    	$othTeam = explode(',', $data['ot']->ot_team_oth);
    ?>
    <div class="row">
    	<?php if(isset($data['ot']->ot_team_doc)) { ?>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><center><h3 class="panel-title">Doctors / Surgeon</h3></center></div>
                <div class="panel-body" style="padding-top: 0px!important">
                    <table class="table"> 
                        <thead> 
                            <tr> 
                                <th style="text-align: left;">Name</th> 
                                <th style="text-align: left;">Responsibility</th> 
                            </tr> 
                        </thead> 
                        <tbody> 
                            <?php 
                            $docSize = sizeof($docTeam)/2;
                            for ($i=0; $i < $docSize; $i++) { 
                        	?>
                            <tr> 
                                <td style="text-align: left;"><?php echo $docTeam[$i]; ?></td> 
                                <td style="text-align: left;"><?php echo $docTeam[$i+$docSize]; ?></td> 
                            </tr> 
                        	<?php } ?>
                        </tbody>
                    </table>
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div>
    	<?php } ?>
    	<?php if(isset($data['ot']->ot_team_doc)) { ?>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><center><h3 class="panel-title">Nurses</h3></center></div>
                <div class="panel-body" style="padding-top: 0px!important">
                    <table class="table"> 
                        <thead> 
                            <tr> 
                                <th style="text-align: left;">Name</th> 
                                <th style="text-align: left;">Responsibility</th> 
                            </tr> 
                        </thead> 
                        <tbody> 
                            <?php 
                            $nurSize = sizeof($nurTeam)/2;
                            for ($i=0; $i < $nurSize; $i++) { 
                        	?>
                            <tr> 
                                <td style="text-align: left;"><?php echo $nurTeam[$i]; ?></td> 
                                <td style="text-align: left;"><?php echo $nurTeam[$i+$nurSize]; ?></td> 
                            </tr> 
                        	<?php } ?>
                        </tbody>
                    </table>
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div>
    	<?php } ?>
        <?php if(isset($data['ot']->ot_team_doc)) { ?>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><center><h3 class="panel-title">Others</h3></center></div>
                <div class="panel-body" style="padding-top: 0px!important">
                    <table class="table"> 
                        <thead> 
                            <tr> 
                                <th style="text-align: left;">Name</th> 
                                <th style="text-align: left;">Responsibility</th> 
                            </tr> 
                        </thead> 
                        <tbody> 
                            <?php 
                            $othSize = sizeof($othTeam)/2;
                            for ($i=0; $i < $othSize; $i++) { 
                        	?>
                            <tr> 
                                <td style="text-align: left;"><?php echo $othTeam[$i]; ?></td> 
                                <td style="text-align: left;"><?php echo $othTeam[$i+$othSize]; ?></td> 
                            </tr> 
                        	<?php } ?>
                        </tbody>
                    </table>
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    	<?php } ?>
</div>
<?php require APPROOT .'/views/inc_doctor/footer.php'; ?>