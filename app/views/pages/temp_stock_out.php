<?php require APPROOT . '/views/inc/header.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style>
	.brde
	{
		border: 1px solid red;
	}
</style>
<?php $l=0; ?>
<div class="breadcrumbbar">
	<div class="row align-items-center">
		<div class="col-md-8 col-lg-8">
			<h4 class="page-title">Stock_Out</h4>
			<div class="breadcrumb-list">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>

				</ol>
			</div>
		</div>
		
	</div>
</div>
<form method="post" action="<?php echo URLROOT;?>/pages/create_sales_order_for_stock_out">
	<div class="contentbar">
		<!-- Start row -->
		<div class="row">
			<!-- Start col -->
			<div class="col-lg-6">
				<div class="card m-b-30">

					<div class="card-body">
						<div class="form-group">
							<label>Customer Name</label>
							<!-- <input type="text" class="form-control" placeholder="Enter Customer Name" name="customer" id="cname" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off">
							<div class="dropdown-menu" id="dropDownAjaxcname" style="width: 300px;padding-bottom: 0px;padding-top: 0px;">
							</div> 
							<input type="text" name="customer_id" id="cname_id" style="display: none;" /> -->
							<select class="select2-single form-control" name="customer_id" id="cname" onchange="getbilladd(this.value)">
	                        	<option>--Select--</option>
	                        	<?php foreach ($data['customer'] as $cu) { ?>
	                            <option value="<?php echo $cu->id;?>"><?php echo $cu->customer_display_name;?></option>
	                        	<?php }?>
                        	</select>
						</div>
						
						
					</div>
				</div>
			</div>
			<!-- End col -->
			<!-- Start col -->
			<div class="col-lg-6">
				<div class="card m-b-30">
					<div class="card-body">
						<div class="form-group">
							<label>Stock Out Date & Time</label>
							<input type="date" id="stock_dt" class="form-control" placeholder="" name="stock_dt" min='1960-01-01' max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>">
						</div>
					</div>
				</div>
			</div>
			<!-- End col -->
			<!-- Start col -->
			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<h5 class="card-title">Item Details</h5>
					</div>
					<div class="card-body">

						<div class="row clearfix">
							<div class="col-md-12">
								<table class="table table-bordered table-hover" id="tab_logic">
									<thead>
										<tr>
											<th class="text-center"> # </th>
											<th class="text-center"> Item </th>
											<th class="text-center"> Qty </th>
											<th class="text-center">Type</th>
										</tr>
									</thead>
									<tbody id='addr1'>
										<tr id='addr0'>
											<td>1</td>
											<td>
												<input type="text" name='product' placeholder='Enter Item Name' class="form-control" id="tags" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off" />
												<div class="dropdown-menu" id="dropDownAjax" style="width: 480px;padding-bottom: 0px;padding-top: 0px;">
												</div>
												<input type="text" id="item_id_for_qty" style="display: none;">
											</td>
											<td><input type="number" name='qty' placeholder='Enter Qty' class="form-control qty" step="0" min="0" onclick="calculateTheGst(this.value)" id="qty" value="" /></td>
											<td>
												<select name="rec" id="rec" class="form-control"required="true">
			                                        <option value="" selected disabled>--select--</option>
			                                        <option value="1">Box</option>
			                                        <option value="3">Pieces</option>
			                                    </select>
			                                </td>
										</tr>
									</tbody>
									
								</table>
							</div>
						</div>
						<div class="row clearfix">
							<div class="col-md-12">
								<a style="color: white;" class="btn btn-default pull-left" onclick="addRowForBill()">Add Another Line</a>
								<!-- <a style="color: white;" id='delete_row' class="pull-right btn btn-default">X</a> -->
							</div>
						</div>

					</div>
				</div>
			</div>

			<!-- Start col -->
			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-body">
						<div class="form-group" style="float: right;">
							<button type="submit" class="btn btn-info text-white" >Submit</button>
							<a class="btn btn-warning" href="<?php echo URLROOT; ?>/pages/sales_order" style="color: white;">Cancel</a> &nbsp;
						</div>
					</div>
				</div>
			</div>
			<!-- End col -->
		</div>
	</div>
</form>
<!-- End Contentbar -->



<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php if (isset($_SESSION['success'])) { ?>
	<script type="text/javascript">
		swal("<?php echo $_SESSION['success']; ?>");
	</script>
<?php }
unset($_SESSION['success']); ?>

<script type="text/javascript">
	$(document).ready(function() {
		var i = 1;
		$("#add_row").click(function() {
			b = i - 1;
			$('#addr' + i).html($('#addr' + b).html()).find('td:first-child').html(i + 1);
			$('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
			i++;
		});
		$("#delete_row").click(function() {
			if (i > 1) {
				$("#addr" + (i - 1)).html('');
				i--;
			}

		});

	});
</script>
<script type="text/javascript">
	$('#tags').keyup(function() {
		var tags = $('#tags').val();
		$.ajax({
			url: '<?php echo URLROOT; ?>/pages/getTheItems',
			type: "POST",
			data: {
				tags
			},
			success: function(res) {
				$('#dropDownAjax').html(res);
			}
		});
	});
	
</script>

<script>
	function selectProduct(val)
	{
		$.ajax({
			url: "<?php echo URLROOT; ?>/pages/getItemDetailsById",
			type: "POST",
			data: {val},
			success: function(response)
			{
				var itemName = response.trim();
				$('#tags').val(itemName);
			}
		});
	}

	function addRowForBill()
	{
		if(($('#tags').val())=="")
		{
			alert("Enter Item First");
		}
		else
		{
			var sItem = $('#tags').val();
			var sQty = $('#qty').val();
			var rec = $('#rec').val();
			$.ajax({
				url: "<?php echo URLROOT; ?>/pages/tempSaleData_stock_out",
				type: "POST",
				data: {
					sItem, sQty, rec
				},

				success: function(response4)
				{
					$('#addr1').append(response4);
					$('#tags').val("");
					$('#qty').val("");
					$('#rec').val("");
				}
			});
		}
	}

	function addRowForBillSubmit()
	{
		var sItem = $('#tags').val();
		var sQty = $('#qty').val();
		var rec = $('#rec').val();
		$.ajax({
			url: "<?php echo URLROOT; ?>/pages/tempSaleData_stock_out",
			type: "POST",
			data: {
				sItem, sQty, rec
			},

			success: function(response4)
			{
				$('#addr1').append(response4);
				$('#tags').val("");
				$('#qty').val("");
				$('#rec').val("");
			}
		});	
	}
</script>
<script>
  // $('#cname').keyup(function(){
  //       var cname = $('#cname').val();
  //       $.ajax({
  //           url: '<?php echo URLROOT; ?>/pages/get_all_customer_for_auto_complete_cname',
  //           type: "POST",
  //           data: {cname},
  //           success : function(res)
  //           {
  //               $('#dropDownAjaxcname').html(res);
  //           }
  //       });
  // });
  function getbilladd(cid) 
  	{
        // var cid = $('#cname').val();
        $.ajax({
            url: '<?php echo URLROOT; ?>/pages/get_cu_bill',
            type: "POST",
            data: {cid},
            success : function(res)
            {
                // $('#bill_address').html(res);
                // document.getElementById("bill_address").value = res;

            }
        });
    }
</script>
<script>
    function selectProductcname(val)
    {
        document.getElementById("cname_id").value = val.id;
        document.getElementById("cname").value = val.name;
           
    }
</script>
<script type="text/javascript">
   $(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script> 
<?php require APPROOT . '/views/inc/footer.php'; ?>