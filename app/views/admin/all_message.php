<?php require APPROOT .'/views/inc_admin/header.php'; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Messages </h3></div>
            
             <br>
              <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Message ID</th>
                                        <th style="text-align: left;width: 200px">Message</th>
                                        <th>Created At</th>
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
<?php require APPROOT .'/views/inc_admin/footer.php'; ?>
<script type="text/javascript">
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/admin/all_message1',
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
                    url: '<?php echo URLROOT;?>/admin/all_message1',
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

<script type="text/javascript">
  $(document).ready(function()
    {
        $("#pat_id").keyup(function(){
        var sear = $('#pat_id').val();
        if(sear != '')
        {
          $.ajax({
            type: "POST",
            url: '<?php echo URLROOT;?>/admin/all_patients2',
            data: {sear},
            cache: false,
            success:function(response)
            {
              $('#all_patients_display').html(response);
            }
          });
        }
        else
        {
          after_remove();
        }
          
      });
    });
</script>

<script type="text/javascript">
  $(document).ready(function()
    {
        $("#pat_name").keyup(function(){
        var sear = $('#pat_name').val();
        if(sear != '')
        {
          $.ajax({
            type: "POST",
            url: '<?php echo URLROOT;?>/admin/all_patients3',
            data: {sear},
            cache: false,
            success:function(response)
            {
              $('#all_patients_display').html(response);
            }
          });
        }
        else
        {
          after_remove();
        }
      });
    });
</script>

<script type="text/javascript">
  $(document).ready(function()
    {
        $("#pat_phone").keyup(function(){
        var sear = $('#pat_phone').val();
          $.ajax({
            type: "POST",
            url: '<?php echo URLROOT;?>/admin/all_patients4',
            data: {sear},
            cache: false,
            success:function(response)
            {
              $('#all_patients_display').html(response);
            }
          });
      });
    });
</script>

<script type="text/javascript">
  function remove_pat(ser_id)
  {
        swal({   
            title: "Are you sure?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#2ECC71",   
            confirmButtonText: "Yes, Remove it!",
            cancelButtonColor: "#FFA726",   
            cancelButtonText: "No, Cancel",   
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm){   
            if (isConfirm)
            { 
                $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/admin/remove_patient',
                    data: {ser_id},
                    cache: false,
                    success:function(response)
                    {
                      swal("Removed!", "Please check in Removed Patients.", "success");
                      after_remove();
                    }
                  });    
            } 
            else
            {     
                swal("Cancelled", "", "error");   
            } 
        });
  }
</script>


<script type="text/javascript">
 function after_remove()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/admin/all_message1',
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
                    url: '<?php echo URLROOT;?>/admin/all_message1',
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
          }
</script>
