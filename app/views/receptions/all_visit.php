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
            <div class="panel-heading"><h3 class="panel-title">All Visits</h3></div>
            <div class="row">
             <div class="col-sm-3" style="margin-top: 10px;">
                <input type="number" id="visit_id_search" class="form-control" placeholder="Search By Visit ID">
             </div>
             <div class="col-sm-3" style="margin-top: 10px;">
                <input type="number" id="patient_id_search" class="form-control" placeholder="Search By Patient ID">
             </div>
             <div class="col-sm-3" style="margin-top: 10px;">
                <input type="text" id="pat_name" name="example-input2-group2" class="form-control" placeholder="Search By Patient Name/Phone">
             </div>
             <div class="col-sm-3" style="margin-top: 10px;">
                <input type="text" id="doc_name" name="example-input2-group2" class="form-control" placeholder="Search By Doctor Name">
             </div>
             </div>
             <br>
             <div class="row">
                <div class="col-sm-12">
                    <div class="input-group"> 
                        <input type="date" class="form-control" placeholder="Enter start date" autocomplete="off" id="order_start_date" style="width: 50%;">
                        <input type="date" class="form-control" placeholder="Enter end date" autocomplete="off" id="order_end_date" style="width: 50%;">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-effect-ripple btn-primary" id="get_wrt_date">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div> 
             </div>
             <br>
              <div class="row">
                  <div class="col-md-12">
                      <div class="table-responsive">
                          <table class="table">
                              <thead>
                                  <tr>
                                   
                                      <th style="text-align: left;">Visit ID</th>
                                     <!--  <th style="text-align: left;">Patient ID</th> -->
                                      <th style="text-align: left;">Patient Name</th>
                                      <th style="text-align: left;">Doctor</th>
                                      <th style="text-align: left;">Visite Purpose</th>
                                      <th style="text-align: left;">Visite Date</th>
                                      <th style="text-align: left;">Fees</th>
									  <th>Doctor's Advice</th>
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
                url: '<?php echo URLROOT;?>/receptions/all_visit1',
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
                    url: '<?php echo URLROOT;?>/receptions/all_visit1',
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

<script type="text/javascript">
  $(document).ready(function(){
        $("#visit_id_search").keyup(function(){
          var visit_id = $('#visit_id_search').val();
          if(visit_id != 0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/receptions/search_by_visit_id',
              data:{visit_id},
              success : function(data)
              {
                $('#all_visit_display').html(data);
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
                url: '<?php echo URLROOT;?>/receptions/all_visit1',
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
                    url: '<?php echo URLROOT;?>/receptions/all_visit1',
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
          }
        });
    })
</script>

<script type="text/javascript">
  $(document).ready(function(){
        $("#patient_id_search").keyup(function(){
          var pat_id = $('#patient_id_search').val();
          if(pat_id!= 0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/receptions/search_by_patient_id',
              data:{pat_id},
              success : function(data)
              {
                $('#all_visit_display').html(data);
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
                url: '<?php echo URLROOT;?>/receptions/all_visit1',
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
                    url: '<?php echo URLROOT;?>/receptions/all_visit1',
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
          }
        });
    })
</script>

<script type="text/javascript">
  $(document).ready(function(){
        $("#pat_name").keyup(function(){
          var pat_name = $('#pat_name').val();
          if(pat_name!= 0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/receptions/search_by_pat_name',
              data:{pat_name},
              success : function(data)
              {
                $('#all_visit_display').html(data);
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
                url: '<?php echo URLROOT;?>/receptions/all_visit1',
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
                    url: '<?php echo URLROOT;?>/receptions/all_visit1',
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
          }
        });
    })
</script>

<script type="text/javascript">
  $(document).ready(function(){
        $("#doc_name").keyup(function(){
          var pat_name = $('#doc_name').val();
          if(pat_name!= 0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/receptions/search_by_doc_name',
              data:{pat_name},
              success : function(data)
              {
                $('#all_visit_display').html(data);
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
                url: '<?php echo URLROOT;?>/receptions/all_visit1',
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
                    url: '<?php echo URLROOT;?>/receptions/all_visit1',
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
          }
        });
    })
</script>

<script type="text/javascript">
  function updateFinish(id)
  {
      swal({   
            title: "Are you sure?",   
            text: "Finish Visit.",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#2E86C1",   
            confirmButtonText: "Yes", 
            cancelButtonColor: "#EF5350",  
            cancelButtonText: "Cancel",   
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm){   
            if (isConfirm) {     
                window.location.replace('<?php echo URLROOT; ?>/receptions/finishVisit/'+id+'');  
            } else {     
                swal("Cancelled", "Finish has been cancelled.", "error");   
            } 
        });
  }
</script>

<script type="text/javascript">
  $(document).ready(function(){
        $("#get_wrt_date").click(function(){
          var start = $('#order_start_date').val();
          var end = $('#order_end_date').val();
          if(start != '' && end != '')
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/receptions/get_all_visit_wrt_dates',
              data:{start, end},
              success : function(data)
              {
                $('#all_visit_display').html(data);
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
                url: '<?php echo URLROOT;?>/receptions/all_visit1',
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
                    url: '<?php echo URLROOT;?>/receptions/all_visit1',
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
          }
        });
    })
</script>

<script>
	function uploadModelForVisit(id)
	{
		$('#visitId').val(id);
		$('#upDoc').modal('show');
	}
</script>