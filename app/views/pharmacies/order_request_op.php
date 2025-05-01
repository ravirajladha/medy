<?php require APPROOT .'/views/inc_pharmacy/header.php'; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Prescriptions</h3></div>
              <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table">
                              <thead>
                                  <tr>
                                      <th style="text-align:left;">Visit ID</th>
                                      <th style="text-align:left;">Doctor Name</th>                              
                                      <th style="text-align:left;">Patient Name</th>
                                      <th style="text-align:left;">Date & Time</th>
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
                url: '<?php echo URLROOT;?>/doctors/all_prescription_ph',
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
                    url: '<?php echo URLROOT;?>/doctors/all_prescription_ph',
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
<script type="text/javascript">
    $(document).ready(function()
          {
            $('#pat_phone').keyup(function(){
              var pat_name = $('#pat_phone').val();
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/doctors/prescription_search_by_phone',
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
<?php require APPROOT .'/views/inc_pharmacy/footer.php'; ?>