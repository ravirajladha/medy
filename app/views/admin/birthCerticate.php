<?php require APPROOT .'/views/inc_admin/header.php'; ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Birth Certificate</h3></div>
            <div class="panel-body">
                <form action="<?php echo URLROOT; ?>/admin/generateBirthCertificate" method="POST">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name of Registered child</label>
                            <input style="margin-top: 10px;" type="text" class="form-control" name="name" placeholder="Enter Doctor Name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Date & Time Of Birth</label>
                            <input style="margin-top: 10px;" type="datetime-local" class="form-control" name="dateTime" placeholder="Enter Doctor Name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Gender</label>
                            <select name="gender" id="" class="form-control" style="margin-top: 10px;">
                                <option value="MALE">Male</option>
                                <option value="FEMALE">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Date of Registration</label>
                            <input style="margin-top: 10px;" type="date" class="form-control" name="regDate" placeholder="Enter Doctor Name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Mother's Name</label>
                            <input style="margin-top: 10px;" type="text" class="form-control" name="motherName" placeholder="Enter Doctor Name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Father's Name</label>
                            <input style="margin-top: 10px;" type="text" class="form-control" name="fatherName" placeholder="Enter Doctor Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Address</label>
                            <input style="margin-top: 10px;" type="text" class="form-control" name="address" placeholder="Enter Doctor Name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-2">
                        <button class="btn btn-primary" type="submit">
                            Submit
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT .'/views/inc_admin/footer.php'; ?>