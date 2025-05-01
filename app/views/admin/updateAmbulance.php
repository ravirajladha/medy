<?php require APPROOT .'/views/inc_admin/header.php';?>
<?php
$objRec = new Reception;
$vehicleName = $objRec->getTheVehicle($data['service']->vehicle_id);
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Update Ambulance Service</h3>
            </div>
            <br>
            <div class="row">
                <center>
                    <div class="form-group">
                        <?php
                            if($data['service']->service_type == 1) {
                        ?>
                        <label class="cr-styled">
                            <input type="checkbox" checked="" id="int" onchange="changeInt()" name="int" value="1" readonly>
                            <i class="fa"></i> 
                            Internal
                        </label>
                            <?php } if($data['service']->service_type == 2) { ?>
                        <label class="cr-styled">
                            <input type="checkbox" id="ext" onchange="changeExt()" name="ext" value="1">
                            <i class="fa"></i> 
                            External
                        </label>
                            <?php } ?>
                    </div>
                </center>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <label for="">Vehicle</label>
                    <input type="text" class="form-control" value="<?php echo $vehicleName->vehicle_name;?>(<?php echo ucwords($vehicleName->vehicle_number) ?>)" disabled="">
                </div>
                <div class="col-sm-3">
                    <label for="">Patient</label>
                    <input class="form-control" type="text" placeholder="Enter Patient Name" name="patient" value="<?php echo $data['service']->patient_name; ?>" disabled>
                </div>
                <div class="col-sm-3">
                    <label for="">Driver Name</label>
                    <input class="form-control" type="text" placeholder="Enter Driver Name" name="driver" value="<?php echo $data['service']->driver_name; ?>" disabled>
                </div>
                <div class="col-sm-3">
                    <label for="">Initial Reading Kilometer</label>
                    <input class="form-control" type="text" placeholder="Enter KM" name="irk" value="<?php echo $data['service']->initial_reading ?>" disabled>
                </div>
                <div class="col-sm-3" style="margin-top: 20px;">
                    <label for="">Patient Condition</label>
                    <input class="form-control" type="text" placeholder="Patient Condition" name="condition" value="<?php echo $data['service']->patient_condition; ?>" disabled>
                </div>
                <div class="col-sm-3" style="margin-top: 20px;">
                    <label for="">From Time</label>
                    <input class="form-control" type="time" placeholder="Patient Condition" name="fromTime" value="<?php echo $data['service']->from_time; ?>" disabled>
                </div>
                <div class="col-sm-6" style="margin-top: 20px;">
                    <label for="">Remarks</label>
                    <input class="form-control" type="text" placeholder="Enter Remarks" name="remarks" value="<?php echo $data['service']->remarks; ?>" disabled>
                </div>
                <div class="col-sm-8" style="margin-top: 20px;">
                    <label for="">Address</label>
                    <input class="form-control" type="text" placeholder="Enter Address" name="address" value="<?php echo $data['service']->address;?>" disabled>
                </div>
            </div>
            <form action="<?php echo URLROOT; ?>/admin/finishAmbulanceService/<?php echo $data['service']->as_id;?>" method="POST">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group" style="margin-top: 20px;">
                        <label for="">Resource Name</label>
                        <input class="form-control" type="text" placeholder="Enter Address" name="resource">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group" style="margin-top: 20px;">
                        <label for="">Final Reading Kilometer</label>
                        <input class="form-control" type="number" placeholder="in Kilometer" name="finalReading">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group" style="margin-top: 20px;">
                        <label for="">To Time</label>
                        <input class="form-control" type="time" placeholder="Enter Address" name="toTime">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <button class="btn btn-info btn-md" type="submit">Finish</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT .'/views/inc_admin/footer.php';?>
<script>
    function changeInt()
    {
        $('#int').prop('checked', true);
    }
</script>