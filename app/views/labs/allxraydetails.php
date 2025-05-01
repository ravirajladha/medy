<?php require APPROOT .'/views/inc_labs/header.php'; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All X-ray reports</h3></div>
            <div class="row">
             <div class="col-sm-6" style="margin-top: 15px">
                <input type="number" id="service_id_value" name="example-input2-group2" class="form-control" placeholder="Search By Patient ID" autocomplete="off">
             </div>
             <div class="col-sm-6" style="margin-top: 15px;display: none;">
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
                                      <th class="col-md-2">Patient ID</th>
                                      <th class="col-md-3" style="text-align: left; padding-left: 50px;">Report Title</th>
                                      <th class="col-md-3" style="text-align: left; padding-left: 50px;">File_attached</th>
                                      <th class="col-md-2" style="text-align: left;">Uploaded Date</th>
                                      <th class="col-md-2" style="text-align: left; padding-left: 45px;">Action</th>
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

<?php require APPROOT .'/views/inc_labs/footer.php'; ?>
<script type="text/javascript">
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/labs/all_xray1',
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
                    url: '<?php echo URLROOT;?>/labs/all_xray1',
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
              url:'<?php echo URLROOT;?>/labs/search_by_xray_id',
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
                url: '<?php echo URLROOT;?>/labs/all_xray1',
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
                    url: '<?php echo URLROOT;?>/labs/all_xray1',
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
              url:'<?php echo URLROOT;?>/labs/search_by_xray_id',
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
                url: '<?php echo URLROOT;?>/labs/all_xray1',
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
                    url: '<?php echo URLROOT;?>/labs/all_xray1',
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
  function after_delete()
  {
    $(document).ready(function()
            {
              var lim = 9;
              var off = 0;
              var inc = 0;
                $.ajax({
                  type: "POST",
                  url: '<?php echo URLROOT;?>/labs/all_xray1',
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
                      url: '<?php echo URLROOT;?>/labs/all_xray1',
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

<script type="text/javascript">
    function confirm_sec(ser_id)
    {
        if (confirm('Are you sure?'))
        {
            $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/labs/delete_xray',
                data: {ser_id,ser_id},
                cache: false,
                success:function(response)
                {
                  after_delete();
                }
              });
        }
        else
        {
            
        }
    }
</script>


