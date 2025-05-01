<?php require APPROOT .'/views/inc_admin/header.php'; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
        <div class="panel-heading">
                <a href="<?php echo URLROOT; ?>/admin/addAmbulance"><button class="btn btn-inverse btn-xs pull-right">Add Ambulances</button></a>
                <h3 class="panel-title">All Ambulance</h3>
            </div><br><br>
              <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table" style="margin-bottom: 0px;">
                                <thead>
                                    <tr>
                                        <th>Vehicle Id</th>
                                        <th style="text-align: left;">Vehicle Name</th>
                                        <th>Vehicle Number</th>
                                        <th>Seating Capacity</th>
                                        <th width="250">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="allAmbulance" >
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php require APPROOT .'/views/inc_admin/footer.php';?>
<script type="text/javascript">
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/admin/allAmbulanceList',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#allAmbulance').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/admin/allAmbulanceList',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#allAmbulance').append(response);
                    }
                  });
                }
            });
          });
</script>