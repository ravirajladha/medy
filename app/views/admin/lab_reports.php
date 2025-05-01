<?php require APPROOT .'/views/inc_admin/header.php'; ?>
 <div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Lab Reports</h3></div>
            <div class="row">
             <div class="col-sm-3">
                  <input type="text" id="vis_id" name="example-input2-group2" class="form-control" placeholder="Search By Order ID" style="margin-top: 10px;">
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
                  <input type="email" id="pat_name name="example-input2-group2" class="form-control" placeholder="Search By Patient Name" style="margin-top: 10px;">
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
<?php foreach ($data['lab'] as $key) {
?>                    
<div class="modal fade" id="exampleModal<?php echo $key->lab_test_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Lab Test Documents</h5>
      </div>
      <div class="modal-body">
        <ul class="list-group">
        <?php
          $docs = $key->lab_test_document;
          $docs = explode(',', $docs);
          for ($i=0; $i < sizeof($docs); $i++) { 
        ?>
          <li class="list-group-item"><a href="<?php echo URLROOT; ?>/reports/<?php echo $docs[$i] ?>" target="_blank"><?php echo $docs[$i]; ?></a></li>
        <?php } ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php } ?>                
<?php require APPROOT .'/views/inc_admin/footer.php'; ?>



<script type="text/javascript">
    $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/admin/lab_reports_reception',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#lab_reports').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/admin/lab_reports_reception',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#lab_reports').append(response);
                    }
                  });
                }
            });
          });
</script> 

<script type="text/javascript">
    $(document).ready(function()
          {
            $('#vis_id').keyup(function(){
              var visit_id = $('#vis_id').val();
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/admin/lab_reports_reception1',
                data: {visit_id},
                cache: false,
                success:function(response)
                {
                  $('#lab_reports').html(response);
                }
              });
            });
          });
</script>

<script type="text/javascript">
    $(document).ready(function()
          {
            $('#pat_name').keyup(function(){
              var patName = $(this).val();
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/admin/lab_reports_reception2',
                data: {patName},
                cache: false,
                success:function(response)
                {
                  $('#lab_reports').html(response);
                }
              });
            });
          });
</script>