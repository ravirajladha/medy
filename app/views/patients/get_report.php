<?php require APPROOT .'/views/inc_reception/header.php'; ?>


<div class="panel panel-default">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-4">
			<div class="col-md-9 col-sm-6">
                <div class="widget-panel widget-style-1 bg-info">
                    <i class="fa fa-shopping-cart"></i> 
                    <h2 class="m-0 counter">22056</h2>
                    <div>Orders</div>
                </div>
            </div>
            </div>
            
			<div class="col-md-4">
            <div class="col-md-9 col-sm-10">
                <div class="widget-panel widget-style-1 bg-info">
                    <i class="fa fa-rupee"></i> 
                    <h2 class="m-0 counter">1268</h2>
                    <div>Revenue</div>
                </div>
            </div>
        </div>
			<div class="col-md-4">
            <div class="col-md-9 col-sm-6">
                <div class="widget-panel widget-style-1 bg-info">
                    <i class="ion-stats-bars"></i> 
                    <h2 class="m-0 counter">1268</h2>
                    <div>Revenue</div>
                </div>
            </div>
        </div>
            </div>
            <div>
                <br>
                <br>
            </div>
            <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="email" id="example-email" name="example-email" class="form-control" placeholder="Email">
                    </div>
                </div>      
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-effect-ripple btn-primary">Print Report</button>
            </div>
            </div>
            <br>
            <br>

            <div class="row">
                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Patient ID</th>
                                                        <th>Patient Name</th>
                                                        <th>Doctor Name</th>
                                                        <th>Bill Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Mark</td>
                                                        <td>Otto</td>
                                                        <td>Otto</td>
                                                        <td>
                                                            <button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">Edit</button>
                                                            <button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Remove</button>
                                                        
                                                        </td>
                                                    </tr>  
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
		</div>
	</div>
</div>	


<?php require APPROOT .'/views/inc_reception/footer.php'; ?>