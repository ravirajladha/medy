<?php require APPROOT .'/views/inc_reception/header.php'; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Services </h3></div>
            <div class="row">
             <div class="col-sm-4">
                    <div class="input-group m-t-10">
                        <input type="email" id="example-input2-group2" name="example-input2-group2" class="form-control" placeholder="Search By Patient ID">
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-effect-ripple btn-primary"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
             </div>
             <div class="col-sm-4">
                    <div class="input-group m-t-10">
                        <input type="email" id="example-input2-group2" name="example-input2-group2" class="form-control" placeholder="Search By Patient Name">
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-effect-ripple btn-primary"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
             </div>
             <div class="col-sm-4">
                    <div class="input-group m-t-10">
                        <input type="email" id="example-input2-group2" name="example-input2-group2" class="form-control" placeholder="Search By Patient Phone Number">
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
                                                        <th>Patient ID</th>
                                                        <th>Patient Name</th>
                                                        <th>Age | Sex</th>
                                                        <th>Contact</th>
                                                        <th>Address</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="all_patients_display">
                                                     
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
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/receptions/all_patients1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_patients_display').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/receptions/all_patients1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_patients_display').append(response);
                    }
                  });
                }
            });
          });
</script>