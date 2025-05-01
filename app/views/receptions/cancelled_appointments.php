<?php require APPROOT .'/views/inc_reception/header.php';?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              
              <h3 class="panel-title">Cancelled Appointments</h3>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <input type="number" id="admit_id_search" name="example-input2-group2" class="form-control" placeholder="Search By Admit ID" style="margin-top: 10px;">
                </div>
                <div class="col-sm-3">
                    <input type="number" id="admit_pid_search" name="example-input2-group2" class="form-control" placeholder="Search By Patient ID" style="margin-top: 10px;">
                </div>
                <div class="col-sm-3">
                    <input type="text" id="admit_pname_search" name="example-input2-group2" class="form-control" placeholder="Search By Patient Name/Phone" style="margin-top: 10px;">
                </div>
                <div class="col-sm-3">
                    <input type="email" id="admit_dname_search" name="example-input2-group2" class="form-control" placeholder="Search By Doctor Name" style="margin-top: 10px;">
                </div>
             </div>
             <br>
             <div class="row">
                <div class="col-sm-12">
                    <div class="input-group"> 
                        <input type="date" class="form-control" placeholder="Enter start date" autocomplete="off" id="order_start_date" style="width: 50%;">
                        <input type="date" class="form-control" placeholder="Enter end date" autocomplete="off" id="order_end_date" style="width: 50%;">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-effect-ripple btn-primary" id="get_wrt_date">
                                <i class="fa fa-search"></i>
                            </button>
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
                                    <th style="text-align:left;">Appointment ID</th>
                                    <th style="text-align:left;">Patient Name</th>
                                    <th style="text-align:left;">Patient Phone</th>
                                    <th style="text-align:left;">Doctor Name</th>
                                    <th style="text-align:left;">Doctor Specialty</th>
                                    <th style="text-align:left;">Appointment Date & Time</th>
                                    <th style="text-align:center">Status</th>
                                </tr>
                            </thead>
                            <tbody id="allAppointmentsDisplay">
                                 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/receptions/allCancelledAppointments',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#allAppointmentsDisplay').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/receptions/allCancelledAppointments',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#allAppointmentsDisplay').append(response);
                    }
                  });
                }
            });
          });
</script>
<?php require APPROOT .'/views/inc_reception/footer.php';?>