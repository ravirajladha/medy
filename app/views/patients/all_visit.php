<?php require APPROOT .'/views/inc_patient/header.php'; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Visits</h3></div>
            <div class="row">
             <!-- <div class="col-sm-3" style="margin-top: 10px;">
                <input type="email" id="visit_id_search" name="example-input2-group2" class="form-control" placeholder="Search By Visit ID">
             </div>
             <div class="col-sm-3" style="margin-top: 10px;">
                <input type="email" id="example-input2-group2" name="example-input2-group2" class="form-control" placeholder="Search By Patient ID">
             </div>
             <div class="col-sm-3" style="margin-top: 10px;">
                <input type="email" id="example-input2-group2" name="example-input2-group2" class="form-control" placeholder="Search By Patient Name">
             </div>
             <div class="col-sm-3" style="margin-top: 10px;">
                <input type="email" id="example-input2-group2" name="example-input2-group2" class="form-control" placeholder="Search By Doctor Name">
             </div> -->
             </div>
             <br>
              <div class="row">
                  <div class="col-md-12">
                      <div class="table-responsive">
                          <table class="table">
                              <thead>
                                  <tr>
                                      <th style="text-align: left;">Visit ID</th>
                                      <th style="text-align: left;">Patient ID</th>
                                      <th style="text-align: left;">Patient Name</th>
                                      <th style="text-align: left;">Doctor</th>
                                      <th style="text-align: left;">Visite Purpose</th>
                                      <th style="text-align: left;">Visite Date</th>
                                      <th style="text-align: left;">Fees</th>
                                  </tr>
                              </thead>
                              <tbody id="all_visit_display">
                                    
                              </tbody>
                          </table>
                      </div>
                  </div>
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
                url: '<?php echo URLROOT;?>/patients/all_visit1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_visit_display').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/patients/all_visit1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_visit_display').append(response);
                    }
                  });
                }
            });
          });
</script>

<script type="text/javascript">
    
</script>