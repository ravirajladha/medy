<?php require APPROOT .'/views/inc_patient/header.php'; ?>
<?php $curdatetime=date('Y-m-d\TH:i');?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Admissions</h3></div>
            <div class="row">
             <!-- <div class="col-sm-3">
                    <div class="input-group m-t-10">
                        <input type="email" id="example-input2-group2" name="example-input2-group2" class="form-control" placeholder="Search By Admit ID">
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-effect-ripple btn-primary"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
             </div>
             <div class="col-sm-3">
                    <div class="input-group m-t-10">
                        <input type="email" id="example-input2-group2" name="example-input2-group2" class="form-control" placeholder="Search By Patient ID">
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
             <div class="col-sm-3">
                    <div class="input-group m-t-10">
                        <input type="email" id="example-input2-group2" name="example-input2-group2" class="form-control" placeholder="Search By Doctor Name">
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-effect-ripple btn-primary"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
             </div> -->
             </div>
             <br>
              <div class="row">
                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Admit ID</th>
                                                        <th style="text-align: left;">Patient Name</th>
                                                        <th style="text-align: left;">Doctor</th>
                                                        <th>Bed ID</th>
                                                        <th>Admission</th>
                                                        <th>Discharge</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="all_admissions_display">
                                                     
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                    <div id="datemodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog"> 
                                        <div class="modal-content"> 
                                            <div class="modal-header"> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                                <h4 class="modal-title">Discharge Date And Time</h4> 
                                            </div> 
                                            <div class="modal-body">
                                            <div class="col-md-2">
                                                
                                            </div> 
                                                <div class="row"> 
                                                    <div class="col-md-8"> 
                                                        <div class="form-group"> 
                                                            <input type='datetime-local' class="form-control" id="field_dis" value='<?php echo $curdatetime;?>'> 
                                                        </div> 
                                                    </div> 
                                                </div> 
                                            </div> 
                                            <div class="modal-footer"> 
                                                <button type="button" id="discharge" class="btn btn-info">Discharge</button> 
                                            </div> 
                                        </div> 
                                    </div>
                                </div>
<?php require APPROOT .'/views/inc_patient/footer.php'; ?>
<script type="text/javascript">
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/patients/all_admissions1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_admissions_display').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/patients/all_admissions1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_admissions_display').append(response);
                    }
                  });
                }
            });
          });
</script>

<script type="text/javascript">
  $(document).ready(function()
          {
            $(document).on('click', 'button[data-id]', function () {
                var ser_id = $(this).attr('data-id');
                $('#discharge').click(function(){
                 var dis = $('#field_dis').val();
                $.ajax({
                    url:'<?php echo URLROOT;?>/receptions/discharge',
                    type:'POST',
                    data:{ser_id,dis},
                    success : function(data)
                    {
                        $('#datemodal').modal('hide');
                    }
                });
            });
            });
          });
</script>
  