<?php require APPROOT .'/views/inc_patient/header.php'; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Services</h3></div>
            <div class="row">
             <div class="col-sm-6" style="margin-top: 15px">
                <input type="text" id="service_id_value" name="example-input2-group2" class="form-control" placeholder="Search By Service ID" autocomplete="off">
             </div>
             <div class="col-sm-6" style="margin-top: 15px">
                <input type="text" id="search_by_name_value" name="example-input2-group2" class="form-control" placeholder="Search By Service Name" autocomplete="off">
             </div>
             </div>
             <br>
              <div class="row">
                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="col-md-2">Service ID</th>
                                                        <th class="col-md-3">Services</th>
                                                        <th class="col-md-3">Type</th>
                                                        <th class="col-md-2">Cost</th>
                                                        <th class="col-md-2">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="all_services">
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
                url: '<?php echo URLROOT;?>/receptions/all_services1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_services').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/receptions/all_services1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_services').append(response);
                    }
                  });
                }
            });
          });
</script>

<script type="text/javascript">
  $(document).ready(function(){
        $("#service_id_value").keyup(function(){
          var inv = $('#service_id_value').val();
          if(inv!=0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/receptions/search_by_ser_id',
              data:{inv},
              success : function(data)
              {
                $('#all_services').html(data);
              }
            });
          }
          else
          {
            $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/receptions/all_services1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_services').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/receptions/all_services1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_services').append(response);
                    }
                  });
                }
            });
          });
          }
        });
    })
</script>

<script type="text/javascript">
  $(document).ready(function(){
        $("#search_by_name_value").keyup(function(){
          var patient_name = $('#search_by_name_value').val();
          if(patient_name!=0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/receptions/search_by_service_name',
              data:{patient_name},
              success : function(data)
              {
                $('#all_services').html(data);
              }
            });
          }
          else
          {
            $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/receptions/all_services1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_services').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/receptions/all_services1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_services').append(response);
                    }
                  });
                }
            });
          });
          }
        });
    })
</script>

<script type="text/javascript">
  $(document).ready(function()
          {
            $(document).on('click', 'button[data-id]', function () {
                var ser_id = $(this).attr('data-id');
                $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/receptions/delete_service',
                data: {ser_id,ser_id},
                cache: false,
                success:function(response)
                {
                  alert(response);
                  after_delete();
                }
              });
            });
          });
</script>

<script type="text/javascript">
  function after_delete()
  {
    $(document).ready(function()
            {
              var lim = 9;
              var off = 0;
              var inc = 0;
                $.ajax({
                  type: "POST",
                  url: '<?php echo URLROOT;?>/receptions/all_services1',
                  data: {lim,off},
                  cache: false,
                  success:function(response)
                  {
                    $('#all_services').html(response);
                  }
                });
                 $(window).scroll(function() {
                  if($(window).scrollTop() + $(window).height() >= $(document).height())
                  {
                    lim = 10;
                      $.ajax({
                      type: "POST",
                      url: '<?php echo URLROOT;?>/receptions/all_services1',
                      data: {lim,inc},
                      cache: false,
                      success:function(response)
                      { 
                        inc++;
                        $('#all_services').append(response);
                      }
                    });
                  }
              });
            });
  }
</script>



