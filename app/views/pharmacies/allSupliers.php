<?php require APPROOT .'/views/inc_pharmacy/header.php'; ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Supplier</h3></div>
            <div class="panel-body">
            	<div class="table-responsive">
            		<table class="table">
            			<thead>
            				<tr>
            					<th style="text-align:left;">Suplier Name</th>
            					<th style="text-align:left;">Suplier Phone</th>
            					<th style="text-align:left;">Suplier Email</th>
            					<th style="text-align:left;">Suplier GSTIN</th>
            					<th style="text-align:left;">Suplier Address</th>
            				</tr>
            			</thead>
            			<tbody id="allSup">
            				
            			</tbody>
            		</table>
            	</div>
            </div>
        </div>
    </div>
</div>
<?php foreach ($data['sup'] as $key) {
?>
<div class="modal fade" id="<?php echo $key->s_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php require APPROOT .'/views/inc_pharmacy/footer.php'; ?>

<script type="text/javascript">
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/pharmacies/allSup',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#allSup').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/pharmacies/allSup',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#allSup').append(response);
                    }
                  });
                }
            });
          });
</script>