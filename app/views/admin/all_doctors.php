<?php require APPROOT .'/views/inc_admin/header.php'; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Doctors</h3></div>
            <br>
              <div class="row">
                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: left;">Member ID</th>
                                                        <th style="text-align:left;">Doctor Name</th>
                                                        <th style="text-align:left; padding-left:150px;">Speciality</th>
                                                        <th style="text-align:left;">Email</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="all_doc_display">
                                                   
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
                url: '<?php echo URLROOT;?>/admin/all_doctors1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_doc_display').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/admin/all_doctors1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_doc_display').append(response);
                    }
                  });
                }
            });
          });
</script>