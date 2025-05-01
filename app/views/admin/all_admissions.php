<?php require APPROOT .'/views/inc_admin/header.php';?>
<?php $curdatetime=date('Y-m-d\TH:i');?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Admissions</h3></div>
            <div class="row">
             <div class="col-sm-3">
                  <input type="number" id="admit_id_search" name="example-input2-group2" class="form-control" placeholder="Search By Admit ID" style="margin-top: 10px;">
             </div>
             <div class="col-sm-3">
                  <input type="number" id="admit_pid_search" name="example-input2-group2" class="form-control" placeholder="Search By Patient ID" style="margin-top: 10px;">
             </div>
             <div class="col-sm-3">
                  <input type="text" id="admit_pname_search" name="example-input2-group2" class="form-control" placeholder="Search By Patient Name/Phone" style="margin-top: 10px;">
             </div>
             <div class="col-sm-3">
                  <input type="email" id="admit_dname_search" name="example-input2-group2" class="form-control" placeholder="Search By Doctor Name" style="margin-top: 10px;">
             </div>
             </div>
             <br>
              <div class="row">
                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Admit ID</th>
                                                        <th style="text-align: left;">Patient Name</th>
                                                        <th style="text-align: left;">Doctor</th>
                                                        <th>Bed ID</th>
                                                        <th>Insurance</th>
                                                        <th>Admission</th>
                                                        <th>Discharge</th>
														<th>Discharge Advice</th>
														<th>Created By</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="all_admissions_display">
                                                     
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                    <div id="datemodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
						<div class="modal-dialog"> 
							<div class="modal-content"> 
								<div class="modal-header"> 
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
									<h4 class="modal-title">Discharge Date And Time</h4> 
								</div> 
								<div class="modal-body">
								<div class="col-md-2">
								</div> 
									<div class="row"> 
										<div class="col-md-8"> 
											<div class="form-group"> 
												<input type='datetime-local' class="form-control" id="field_dis" value='<?php echo $curdatetime;?>'> 
											</div> 
										</div> 
									</div> 
								</div> 
								<div class="modal-footer"> 
									<button type="button" id="discharge" class="btn btn-info">Discharge</button> 
								</div> 
							</div> 
						</div>
					</div>
<?php if(isset($data['ipd'])) { 
        foreach ($data['ipd'] as $key) {
          $dte = date('Y-m-d', strtotime($key->admission_date_time));
          $tim = date('h:i', strtotime($key->admission_date_time));
          $dis_dte = date('Y-m-d', strtotime($key->discharge_date_time));
          $dis_tim = date('h:i', strtotime($key->discharge_date_time));
          $td_dt = date('Y-m-d');
          $day_before = date( 'Y-m-d', strtotime( $td_dt . ' -1 day' ) );

?>                                
  <div class="modal fade" id="adm_modal<?php echo $key->ipd_admit_id?>">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Admission Date & Time</h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <form action="<?php echo URLROOT; ?>/receptions/update_admission" method="POST">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Date</label> 
                    <input type="number" name="id" value="<?php echo $key->ipd_admit_id ?>" style="display: none;">
                    <input type='date' class="form-control" name="dte" value='<?php echo $dte ?>' max="<?php echo date('Y-m-d') ?>" min="<?php echo $day_before ?>"> 
                </div>
                </div>
                <div class="col-md-6">
                  <label>Time</label> 
                    <input type='time' class="form-control" name="tim" value='<?php echo $tim ?>'>
                </div>
            </div>
            </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>


  <div class="modal fade" id="dis_modal<?php echo $key->ipd_admit_id?>">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Discharge Date & Time</h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <form action="<?php echo URLROOT; ?>/receptions/update_discharge" method="POST">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Date</label> 
                    <input type="number" name="id" value="<?php echo $key->ipd_admit_id ?>" style="display: none;">
                    <input type='date' class="form-control" name="dte" value='<?php echo $dis_dte ?>' min="<?php echo $dte ?>"> 
                </div>
                </div>
                <div class="col-md-6">
                  <label>Time</label> 
                    <input type='time' class="form-control" name="tim" value='<?php echo $tim ?>'>
                </div>
            </div>
            </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<?php } } ?>

<div class="modal fade" id="insuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Insurance Detail</h5>
      </div>
      <form action="<?php echo URLROOT; ?>/receptions/updateTheInsurance" method="POST">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Inusrance Number</label>
              <input type="number" name="admitId" style="display: none;" id="admitId">
              <input type="text" name="agId" class="form-control" placeholder="Insurance Number" required="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Inusrance Name</label>
              <select class="form-control" required="" name="agName">
                <?php foreach ($data['getAllIns'] as $key) {
                ?>
                  <option><?php echo $key->insurance_name; ?></option>
                <?php
                } ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Expiry Date</label>
              <input type="date" name="agExpiry" class="form-control" required="">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
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
                url: '<?php echo URLROOT;?>/admin/all_admissions1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_admissions_display').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/admin/all_admissions1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_admissions_display').append(response);
                    }
                  });
                }
            });
          });
</script>



<script type="text/javascript">
  $(document).ready(function()
      {
        $(document).on('click', 'button[data-id]', function () {
            var ser_id = $(this).attr('data-id');
            $('#discharge').click(function(){
             var dis = $('#field_dis').val();
            $.ajax({
                url:'<?php echo URLROOT;?>/receptions/discharge',
                type:'POST',
                data:{ser_id,dis},
                success : function(data)
                {
                    $('#datemodal').modal('hide');
                    window.location.reload();
                }
            });
        });
        });
      });
</script>

<script type="text/javascript">
  $(document).ready(function(){
        $("#admit_id_search").keyup(function(){
          var admit_id = $('#admit_id_search').val();
          if(admit_id != 0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/admin/search_by_admit_id',
              data:{admit_id},
              success : function(data)
              {
                $('#all_admissions_display').html(data);
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
                url: '<?php echo URLROOT;?>/admin/all_admissions1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_admissions_display').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/admin/all_admissions1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_admissions_display').append(response);
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
        $("#admit_pid_search").keyup(function(){
          var admit_id = $('#admit_pid_search').val();
          if(admit_id != 0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/admin/search_by_p_id',
              data:{admit_id},
              success : function(data)
              {
                $('#all_admissions_display').html(data);
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
                url: '<?php echo URLROOT;?>/admin/all_admissions1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_admissions_display').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/admin/all_admissions1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_admissions_display').append(response);
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
        $("#admit_pname_search").keyup(function(){
          var admit_id = $('#admit_pname_search').val();
          if(admit_id != 0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/admin/search_by_p_name',
              data:{admit_id},
              success : function(data)
              {
                $('#all_admissions_display').html(data);
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
                url: '<?php echo URLROOT;?>/admin/all_admissions1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_admissions_display').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/admin/all_admissions1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_admissions_display').append(response);
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
        $("#admit_dname_search").keyup(function(){
          var admit_id = $('#admit_dname_search').val();
          if(admit_id != 0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/admin/search_by_d_name',
              data:{admit_id},
              success : function(data)
              {
                $('#all_admissions_display').html(data);
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
                url: '<?php echo URLROOT;?>/admin/all_admissions1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_admissions_display').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/admin/all_admissions1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_admissions_display').append(response);
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
  function gotoInsurance(id)
  {
    $('#admitId').val(id);
    $('#insuModal').modal('show');
  }
</script>

<?php require APPROOT .'/views/inc_admin/footer.php'; ?>
  