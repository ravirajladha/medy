<?php require APPROOT .'/views/inc_admin/header.php';?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="<?php echo URLROOT; ?>/admin/allAmbulances"><button class="btn btn-inverse btn-xs pull-right">All Ambulances</button></a>
                <h3 class="panel-title">Add Ambulance</h3>
            </div>
            <br>
            <form action="<?php echo URLROOT;?>/admin/saveAmbulance" method="POST">
            <div class="row">
                <div class="col-sm-3">
                    <label for="">Vehicle Name</label>
                    <input type="text" name="name" class="form-control" style="margin-top: 10px;" placeholder="vehicle name">
                </div>
                <div class="col-sm-3">
                    <label for="">Vehicle Number</label>
                    <input type="text" name="vehNumber" class="form-control" style="margin-top: 10px;" placeholder="vehicle number">
                </div>
                <div class="col-sm-3">
                    <label for="">Seating Capacity</label>
                    <input type="number" name="seatsCapacity" class="form-control" style="margin-top: 10px;" placeholder="seating capacity">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <button class="btn btn-info btn-sm">Add Ambulance</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT .'/views/inc_admin/footer.php';?>