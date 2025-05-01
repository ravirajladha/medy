<?php require APPROOT .'/views/inc_admin/header.php'; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Members</h3></div>
            <br>
              <div class="row">
                    <div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Member ID</th>
										<th style="text-align:left">Member Name</th>
										<th style="text-align:left">Member Type</th>
										<th style="text-align:left">Phone</th>
										<th style="text-align:left">Email</th>
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
<div class="modal fade" id="cth" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Cost To Hospital Details</h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="">Member Id</label>
              <input type="text" id="mem_id" class="form-control" readonly="">
            </div>
            <div class="form-group">
              <label for="">Consultation</label><br>
              <label class="cr-styled">
                  <input type="checkbox" id="hour" class="per" value="1" checked>
                  <i class="fa"></i> 
                  per hour
              </label>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <label class="cr-styled">
                  <input type="checkbox" id="day" class="per" value="2">
                  <i class="fa"></i> 
                  per day
              </label>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <label class="cr-styled">
                  <input type="checkbox" id="week" class="per" value="3">
                  <i class="fa"></i> 
                  per week
              </label>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <label class="cr-styled">
                  <input type="checkbox" id="month" class="per" value="4">
                  <i class="fa"></i> 
                  per month
              </label>
              <input type="number" class="form-control" placeholder="enter cost" id="cost" style="margin-top: 10px;;">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" onclick="updateCth()">Update</button>
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
                url: '<?php echo URLROOT;?>/admin/all_members1',
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
                    url: '<?php echo URLROOT;?>/admin/all_members1',
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

<script>
  function cth(id) 
  {
    $('#mem_id').val(id);
    $('#cth').modal('show');
  }

  $('.per').change(function(){
    $('#hour').prop('checked', false);
    $('#day').prop('checked', false);
    $('#week').prop('checked', false);
    $('#month').prop('checked', false);
    $(this).prop('checked', true);
  });

  function updateCth()
  {
    var per = $('.per:checked').val();
    var memId = $('#mem_id').val();
    var cost = $('#cost').val();

    $.ajax({
      url: "<?php echo URLROOT; ?>/admin/updateCth",
      type: "POST",
      data: {per, memId, cost},
      success: function(resp)
      {
        $('#cth').modal('hide');
        swal('Cost to Hospital updated.');
      }
    })
  }
</script>