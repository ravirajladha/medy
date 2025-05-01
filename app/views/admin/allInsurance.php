<?php require APPROOT .'/views/inc_admin/header.php'; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Insurance</h3></div>
            <!-- <div class="row">
             <div class="col-sm-6" style="margin-top: 15px">
                <input type="text" id="service_id_value" name="example-input2-group2" class="form-control" placeholder="Search By Service ID" autocomplete="off">
             </div>
             <div class="col-sm-6" style="margin-top: 15px">
                <input type="text" id="search_by_name_value" name="example-input2-group2" class="form-control" placeholder="Search By Service Name" autocomplete="off">
             </div>
             </div> -->
             <br>
              <div class="row">
                    <div class="col-md-6">
                      <div class="table-responsive">
                          <table class="table">
                              <thead>
                                  <tr>
                                      <th style="text-align: left;">Agency ID</th>
                                      <th style="text-align: left;">Agency Name</th>
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

<?php require APPROOT .'/views/inc_admin/footer.php'; ?>
<script type="text/javascript">
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/admin/all_insu1',
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
                    url: '<?php echo URLROOT;?>/admin/all_insu1',
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
<?php
	if(isset($_SESSION['ins_err']))
	{
		?>
			<script>
			var d = <?php echo json_encode($_SESSION['ins_err']); ?>;
			swal(d);
			</script>
		<?php
	}
	unset($_SESSION['ins_err']);
?>