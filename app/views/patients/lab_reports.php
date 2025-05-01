<?php require APPROOT .'/views/inc_reception/header.php'; ?>


 <div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Prescriptions</h3></div>
            <div class="row">
             <div class="col-sm-3">
                    <div class="input-group m-t-10">
                        <input type="email" id="example-input2-group2" name="example-input2-group2" class="form-control" placeholder="Search By Visit ID">
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-effect-ripple btn-primary"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
             </div>

             <div class="col-sm-6">
             <div class="input-group m-t-10"> 
                    
                          <input type="date" class="form-control" placeholder="Enter start date" autocomplete="off" name="order_start_date" style="width: 50%;">

                          <input type="date" class="form-control" placeholder="Enter end date" autocomplete="off" name="order_end_date" style="width: 50%;">
                          
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-effect-ripple btn-primary"><i class="fa fa-search"></i></button>
                          </span>
                      </div>
             </div>
             <div class="col-sm-3">
                    <div class="input-group m-t-10">
                        <input type="email" id="example-input2-group2" name="example-input2-group2" class="form-control" placeholder="Search By Patient Name">
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-effect-ripple btn-primary"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
             </div>
             </div>
             <br>
              <div class="row">
                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Order Id</th>
                                                        <th>Patient Name</th>
                                                        <th>Doctor</th>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="lab_reports">
                                                    <tr>
                                                        
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

<script type="text/javascript">
  $(document).ready(function(){
    $.ajax({
      url:'<?php echo URLROOT;?>/receptions/lab_reports_reception',
      type:'POST',
      success : function(data)
      {
        $('#lab_reports').html(data);
      }
    });
  });
</script>