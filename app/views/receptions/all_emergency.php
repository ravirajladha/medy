<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<?php
    if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
    {
        redirect('users/login');
    }
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Emergency</h3></div>
             
             <br>
              <div class="row">
                  <div class="col-md-12">
                      <div class="table-responsive">
                          <table class="table">
                              <thead>
                                  <tr>
                                   
                                      <th style="text-align: left;">Emergency ID</th>
                                      <th style="text-align: left;">Patient ID</th>
                                      <th style="text-align: left;">Patient Name</th>
                                      <th style="text-align: left;">Doctor Name</th>
                                      <th style="text-align: left;">Date</th>
                                      <th style="text-align: center;">Action
                                       </th>
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
<div class="modal fade" id="upDoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Upload Documents</h5>
      </div>
      <form action="<?php echo URLROOT; ?>/receptions/upload_file_from_visit" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
		<div class="form-group">
			<label for="">Document Title</label>
			<input type="text" class="form-control" name="rep_tit" required>
		</div>
        <div class="form-group">
			<label for="">Visit Id</label>
			<input type="number" id="visitId" class="form-control" name="visit_id" readonly>
		</div>
		<div class="form-group">
			<label for="">Select a file to upload</label>
			<input type="file" class="form-control" name="files">
		</div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php require APPROOT .'/views/inc_reception/footer.php'; ?>
<script type="text/javascript">
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/receptions/all_emergency1',
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
                    url: '<?php echo URLROOT;?>/receptions/all_emergency1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_visit_display').append(response);
                      $('#mod_div').html('');
                    }
                  });
                }
            });
          });
</script>
