<?php require APPROOT .'/views/inc_patient/header.php'; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Prescriptions</h3></div>
            
            <div class="row">
             <!-- <div class="col-sm-6">
                  <input type="number" id="vis_id" name="example-input2-group2" class="form-control" placeholder="Search By Visit ID" style="margin-top: 10px;">
             </div> -->

             <!-- <div class="col-sm-6">
                  <div class="input-group m-t-10"> 
                    <input type="date" class="form-control" placeholder="Enter start date" autocomplete="off" name="order_start_date" style="width: 50%;">

                    <input type="date" class="form-control" placeholder="Enter end date" autocomplete="off" name="order_end_date" style="width: 50%;">
                    
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-effect-ripple btn-primary"><i class="fa fa-search"></i></button>
                    </span>
                  </div>
             </div> -->
             <!-- <div class="col-sm-6">
                  <input type="email" id="pat_name" name="example-input2-group2" class="form-control" placeholder="Search By Patient Name" style="margin-top: 10px;">
             </div> -->
             </div>
             <br>
              <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table">
                              <thead>
                                  <tr>
                                      <th>Visit ID</th>
                                      <th>Doctor Name</th>                              
                                      <th>Patient Name</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody id="prec_display">
                                    
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
                url: '<?php echo URLROOT;?>/doctors/all_prescription_pat',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#prec_display').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/doctors/all_prescription_pat',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#prec_display').append(response);
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
                url: '<?php echo URLROOT;?>/doctors/prescription_search_by_id',
                data: {visit_id},
                cache: false,
                success:function(response)
                {
                  $('#prec_display').html(response);
                }
              });
            });
          });
</script>

<script type="text/javascript">
    $(document).ready(function()
          {
            $('#pat_name').keyup(function(){
              var pat_name = $('#pat_name').val();
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/doctors/prescription_search_by_name',
                data: {pat_name},
                cache: false, 
                success:function(response)
                {
                  $('#prec_display').html(response);
                }
              });
            });
          });
</script>  
<?php require APPROOT .'/views/inc_patient/footer.php'; ?>