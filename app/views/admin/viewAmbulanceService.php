<?php require APPROOT .'/views/inc_admin/header.php'; ?>
<div class="wraper container-fluid">       
    <div class="page-title"> 
        <h3 class="title">Ambulance Service Details</h3> 
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Service</h3></div>
                <div class="panel-body">
                	<div class=" form">
                        <form class="cmxform form-horizontal tasi-form" id="signupForm" method="get" action="#" novalidate="novalidate">
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Patient Name:</label>
                                <div class="col-lg-10">
                                    <h4><?php echo ucwords($data['service']->patient_name);?> (<?php echo $data['service']->patient_id; ?>)</h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Service Type:</label>
                                <div class="col-lg-10">
                                    <h4>
                                        <?php
                                            if($data['service']->service_type == 1)
                                            {
                                                echo "Internal";
                                            }
                                            if($data['service']->service_type == 2)
                                            {
                                                echo "External";
                                            }
                                        ?>
                                    </h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Driver Name:</label>
                                <div class="col-lg-10">
                                    <h4><?php echo ucwords($data['service']->driver_name);?></h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Initial Reading:</label>
                                <div class="col-lg-10">
                                    <h4><?php echo ucwords($data['service']->initial_reading);?></h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Final Reading:</label>
                                <div class="col-lg-10">
                                    <h4><?php echo ucwords($data['service']->final_reading);?></h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Patient Condition:</label>
                                <div class="col-lg-10">
                                    <h4><?php echo ucwords($data['service']->patient_condition);?></h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">From Time:</label>
                                <div class="col-lg-10">
                                    <h4><?php echo date('h:i A', strtotime($data['service']->from_time));?></h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">To Time:</label>
                                <div class="col-lg-10">
                                    <h4><?php echo date('h:i A', strtotime($data['service']->to_time));?></h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Resource Name:</label>
                                <div class="col-lg-10">
                                    <h4><?php echo ucwords($data['service']->resource_name);?></h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Address:</label>
                                <div class="col-lg-10">
                                    <h4><?php echo ucwords($data['service']->address);?></h4>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="firstname" class="control-label col-lg-2">Status:</label>
                                <div class="col-lg-10">
                                    <h4>
                                        <?php
                                            if($data['service']->status == 1)
                                            {
                                                echo "Pending";
                                            }
                                            if($data['service']->status == 2)
                                            {
                                                echo "Completed";
                                            }
                                        ?>
                                    </h4>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT .'/views/inc_admin/footer.php'; ?>