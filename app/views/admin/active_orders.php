<?php require APPROOT .'/views/inc_admin/header.php'; ?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Active Orders</h3></div>
			<div class="row">
			 <div class="col-sm-3" style="padding-top: 10px">
				  <input type="number" id="invoice_id_value" class="form-control" placeholder="Search By Invoice ID">
			 </div>
			 <div class="col-sm-6">
			<div class="input-group m-t-10"> 
				  <input type="date" class="form-control" placeholder="Enter start date" autocomplete="off" id="order_start_date" style="width: 50%;">

				  <input type="date" class="form-control" placeholder="Enter end date" autocomplete="off" id="order_end_date" style="width: 50%;">
				  
				  <span class="input-group-btn">
					<button type="button" class="btn btn-effect-ripple btn-primary" id="get_wrt_date"><i class="fa fa-search"></i></button>
				  </span>
			</div>
			</div>

			 <div class="col-sm-3" style="padding-top: 10px">
					<!-- <div class="input-group m-t-10"> -->
						<input type="text" id="search_by_name_value"class="form-control" placeholder="Search By Patient Name">
						<!-- <span class="input-group-btn">
						<button type="button" class="btn btn-effect-ripple btn-primary"><i class="fa fa-search"></i></button>
						</span> -->
					<!-- </div> -->
			 </div>
			 </div>
			 <br>
			  <div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table" style="margin-bottom: 0px;">
								<thead>
									<tr>
										<th>Invoice Id</th>
										<th style="text-align: left;">Customer Name</th>
										<th>Total Amount</th>
										<th>Net Amount</th>
										<th>Order Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="all_orders" >
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require APPROOT .'/views/inc_admin/footer.php';?>
<script type="text/javascript">
  $(document).ready(function()
		  {
			var lim = 9;
			var off = 0;
			var inc = 0;
			  $.ajax({
				type: "POST",
				url: '<?php echo URLROOT;?>/admin/all_orders_active',
				data: {lim,off},
				cache: false,
				success:function(response)
				{
				  $('#all_orders').html(response);
				}
			  });
			   $(window).scroll(function() {
				if($(window).scrollTop() + $(window).height() >= $(document).height())
				{
				  lim = 10;
					$.ajax({
					type: "POST",
					url: '<?php echo URLROOT;?>/admin/all_orders_active',
					data: {lim,inc},
					cache: false,
					success:function(response)
					{ 
					  inc++;
					  $('#all_orders').append(response);
					}
				  });
				}
			});
		  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
		$("#invoice_id_value").keyup(function(){
		  var inv = $('#invoice_id_value').val();
		  if(inv!=0)
		  {
			$.ajax({
			  type:'POST',
			  url:'<?php echo URLROOT;?>/admin/all_orders_active_by_id',
			  data:{inv},
			  success : function(data)
			  {
				$('#all_orders').html(data);
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
				url: '<?php echo URLROOT;?>/admin/all_orders_active',
				data: {lim,off},
				cache: false,
				success:function(response)
				{
				  $('#all_orders').html(response);
				}
			  });
			   $(window).scroll(function() {
				if($(window).scrollTop() + $(window).height() >= $(document).height())
				{
				  lim = 10;
					$.ajax({
					type: "POST",
					url: '<?php echo URLROOT;?>/admin/all_orders_active',
					data: {lim,inc},
					cache: false,
					success:function(response)
					{ 
					  inc++;
					  $('#all_orders').append(response);
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
			  url:'<?php echo URLROOT;?>/admin/search_by_name_value_active',
			  data:{patient_name},
			  success : function(data)
			  {
				$('#all_orders').html(data);
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
				url: '<?php echo URLROOT;?>/admin/all_orders_active',
				data: {lim,off},
				cache: false,
				success:function(response)
				{
				  $('#all_orders').html(response);
				}
			  });
			   $(window).scroll(function() {
				if($(window).scrollTop() + $(window).height() >= $(document).height())
				{
				  lim = 10;
					$.ajax({
					type: "POST",
					url: '<?php echo URLROOT;?>/admin/all_orders_active',
					data: {lim,inc},
					cache: false,
					success:function(response)
					{ 
					  inc++;
					  $('#all_orders').append(response);
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
		$("#get_wrt_date").click(function(){
		  var start = $('#order_start_date').val();
		  var end = $('#order_end_date').val();
		  if(start != '' && end != '')
		  {
			$.ajax({
			  type:'POST',
			  url:'<?php echo URLROOT;?>/admin/get_all_orders_wrt_dates_active',
			  data:{start, end},
			  success : function(data)
			  {
				$('#all_orders').html(data);
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
				url: '<?php echo URLROOT;?>/admin/all_orders_active',
				data: {lim,off},
				cache: false,
				success:function(response)
				{
				  $('#all_orders').html(response);
				}
			  });
			   $(window).scroll(function() {
				if($(window).scrollTop() + $(window).height() >= $(document).height())
				{
				  lim = 10;
					$.ajax({
					type: "POST",
					url: '<?php echo URLROOT;?>/admin/all_orders_active',
					data: {lim,inc},
					cache: false,
					success:function(response)
					{ 
					  inc++;
					  $('#all_orders').append(response);
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
  function cancel_order(id)
  {
	  swal({   
			title: "Are you sure?",   
			type: "warning",   
			showCancelButton: true,   
			confirmButtonColor: "#2ECC71",   
			confirmButtonText: "Yes",
			cancelButtonColor: "#FFA726",   
			cancelButtonText: "No",   
			closeOnConfirm: false,   
			closeOnCancel: false 
		}, function(isConfirm){   
			if (isConfirm)
			{ 
				$.ajax({
					type: "POST",
					url: '<?php echo URLROOT;?>/admin/cancel_invoice',
					data: {id},
					cache: false,
					success:function(response)
					{
					  if(response)
					  {
						swal("Order Cancelled!", "", "success");
						after_remove();
					  }
					  else
					  {
						swal("Error!", "", "error");
						after_remove();
					  }
					}
				});    
			} 
			else
			{     
				swal("Cancelled", "", "error");   
			} 
		});
  }
  function after_remove()
	{
		var lim = 9;
		var off = 0;
		var inc = 0;
			$.ajax({
				type: "POST",
				url: '<?php echo URLROOT;?>/admin/all_orders_active',
				data: {lim,off},
				cache: false,
				success:function(response)
				{
					$('#all_orders').html(response);
				}
			});
			 $(window).scroll(function() {
				if($(window).scrollTop() + $(window).height() >= $(document).height())
				{
					lim = 10;
						$.ajax({
						type: "POST",
						url: '<?php echo URLROOT;?>/admin/all_orders_active',
						data: {lim,inc},
						cache: false,
						success:function(response)
						{ 
							inc++;
							$('#all_orders').append(response);
						}
					});
				}
		});
	}
</script>