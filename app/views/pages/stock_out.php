<?php require APPROOT . '/views/inc/header.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style>
	.brde
	{
		border: 1px solid red;
	}
</style>
<?php $l=0; ?>
<?php $Page = new Page(); ?>
<div class="breadcrumbbar">
	<div class="row align-items-center">
		<div class="col-md-8 col-lg-8">
			<h4 class="page-title">Sales Order</h4>
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
							<label>Sales Order Date</label>
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
											
											<th class="text-center" width="500"> Item </th>
											<th></th>
											<th class="text-center">Type</th>
											<th class="text-center"> Qty </th>
											<th class="text-center" style="display: none;"> Price </th>
											<th class="text-center" style="display: none;"> Total </th>
										</tr>
									</thead>
									<tbody id='addr1'>
										<tr id='addr0'>
											<td width="500">
												<input type="text" name='itemName' placeholder='Enter Item Name' class="form-control" id="tags1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off" style="display: none;" />
                                                    
                                                <div class="dropdown-menu" id="dropDownAjax" style="width: 500px;padding-bottom: 0px;padding-top: 0px;">
                                                </div>
                                                <input type="text" name="item_id" id="item_id" style="display: none;">
												<select class="select2-single form-control" name='' id="tags" onchange="getitem_name(this.value)">
                                                    <option>--Select--</option>
                                                    <?php foreach ($data['all_items'] as $it) {
                                                    $m = $Page->get_model_name_by_id($it->model_id);
                                                    if(empty($m->model_name)){ $m=""; }else{ $m=$m->model_name; }
                                                    ?>
                                                    <option value="<?php echo $it->id;?>"><?php echo "(".$m.")";?><?php echo $it->name;?></option>
                                                    <?php }?>
                                                </select> 
												<input type="text" id="item_id_for_qty" style="display: none;">
											</td>
											<td>
												<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleStandardModal"><i class="fa fa-search"></i></a>
											</td>
											<input type="hidden" id="tTax" value="0">
											<td>
												<select name="rec" id="rec" class="form-control">
			                                        <option value="" selected disabled>--select--</option>
			                                        <option value="1">Box</option>
			                                        <option value="3">Pieces</option>
			                                    </select>
											</td>
											<td><input type="number" name='qty' placeholder='Enter Qty' class="form-control qty" step="0" min="0" onclick="calculateTheGst(this.value)" id="qty" value="" /></td>
											
											<td style="display: none;"><input type="number" name='price' placeholder='Enter Unit Price' class="form-control price" id="price" step="0.00" min="0" /></td>

											<td style="display: none;"><input type="number" name='total' placeholder='0.00' class="form-control total" id="totalRow" readonly /></td>
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
						<div class="row clearfix" style="margin-top:20px;float: right; display: none;">
							
							<div class="pull-right col-md-12" style="margin-top: 30px;">
								<table class="table table-bordered table-hover" id="tab_logic_total">
									<tbody>
										<tr>
											<th class="text-center">Sub Total</th>
											<td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly /></td>
										</tr>
										<tr style="display: none;">
											<th class="text-center">Tax</th>
											<td class="text-center">
												<div class="input-group mb-2 mb-sm-0">
													<input type="number" class="form-control" id="tax" placeholder="0" name="tax">
													<div class="input-group-addon">%</div>
												</div>
											</td>
										</tr>
										<tr>
											<th class="text-center">Grand Total</th>
											<td class="text-center"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" value="" /></td>
										</tr>
									</tbody>
								</table>
								
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
			$('#addr' + i).html($('#addr' + b).html());
			$('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
			i++;
		});
		$("#delete_row").click(function() {
			if (i > 1) {
				$("#addr" + (i - 1)).html('');
				i--;
			}
			calc();

		});

		$('#tab_logic tbody').on('keyup change', function() {
			calc();
		});
		$('#tax').on('keyup change', function() {
			calc_total();
		});
		$('#discount').on('keyup change',function(){
    		calc_total1();
  		});
	});

	function calc() {
		$('#tab_logic tbody tr').each(function(i, element) {
			var html = $(this).html();
			if (html != '') {
				var qty = $(this).find('.qty').val();
				var price = $(this).find('.price').val();
				$(this).find('.total').val(qty * price);
				calc_total();
			}
		});
	}
	function ind_tax()
	{
		var t = qty * price ;
		sum = t / 100 * $('#xgst').val();
		$(this).find('.total').val(t+sum);
	}

	function calc_total() {
		total = 0;
		$('.total').each(function() {
			total += parseInt($(this).val());
		});
		sub_total = $('#sub_total').val(total.toFixed(2));
		tax_sum = total / 100 * $('#tax').val();
		$('#tax_amount').val(tax_sum.toFixed(2));
		$('#total_amount').val((tax_sum + total).toFixed(2));
		calc_tax_total();
	}

	function calc_tax_total()
	{
		var tTotal = parseInt($('#tTax').val());
		var total = parseInt($('#total_amount').val());
		$('#total_amount').val((tTotal + total).toFixed(2));
	}

	function calc_total1()
	{
		total=0;
		$('.total').each(function() {
				total += parseInt($(this).val());
			});
		$('#sub_total').val(total.toFixed(2));
		tax_sum=total/100*$('#tax').val();
		discount=$('#discount').val();
		var distype = discount[discount.length -1];
			if(distype=="%"){
			discount=total/100*parseInt(discount);
			}
			
			$('#tax_amount').val(tax_sum.toFixed(2));
			$('#discount_amount').val(discount);
		$('#total_amount').val((tax_sum+total-discount).toFixed(2));
	}
	 function getitem_name(vid) 
    {
        var val = vid;
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/getTheItemName_for_jquery_name",
            type: "POST",
            data: {val},
            success: function(response)
            {
               $('#tags1').val(response);
               selectProduct(val);
            }
        });
        $('#item_id').val(vid);

    }

</script>

<!-- <script type="text/javascript">
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
</script> -->
<script type="text/javascript">
	$('#tags').onchange(function() {
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
				getTheCostPriceForAnItem(val);
				getTheqtyForAnItem(val);
				$('#item_id_for_qty').val(val);
			}
		});
	}
	function getTheqtyForAnItem(val)
	{
		$.ajax({
			url: "<?php echo URLROOT; ?>/pages/getTheItem_for_qty",
			type: "POST",
			data: { val },
			success: function(response1)
			{
				// $('#qty').val(parseInt(response1));
				// check_qty();
			}
		});
	}
	function getTheCostPriceForAnItem(val)
	{
		$.ajax({
			url: "<?php echo URLROOT; ?>/pages/getTheItemCostPrice",
			type: "POST",
			data: {
				val
			},
			success: function(response1)
			{
				$('#price').val(parseInt(response1));
				// check_qty();
			}
		});
	}

	function addRowForBill()
	{
		if(($('#tags1').val())=="")
		{
			alert("Enter Item First");
		}
		else if(($('#qty').val())=="")
		{
			alert("Enter Qty");
		}
		else
		{
			var item_id = $('#item_id').val();
			var sItem = $('#tags1').val();
			var sQty = $('#qty').val();
			var rec = $('#rec').val();
			var price = $('#price').val();
			var total = $('#totalRow').val();

			$.ajax({
				url: "<?php echo URLROOT; ?>/pages/tempSaleData_stock_out",
				type: "POST",
				data: {
					item_id,sItem, sQty, rec, price, total
				},

				success: function(response4)
				{
					$('#addr1').append(response4);
					$('#tags').val("");
					$('#qty').val("");
					$('#price').val("");
					$('#rec').val("");
					$('#totalRow').val("");
					refresh_tag();
				}
			});
		}
	}
	function refresh_tag() {
        $.ajax({
                url: "<?php echo URLROOT; ?>/pages/refresh_tag_for_next",
                type: "POST",
                data: { },
                success: function(response4)
                {
                    $('#tags').html(response4);
                }
            });
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
<div class="modal fade" id="exampleStandardModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
      
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">Search Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >Type</label>
                            <select name="type_id" id="type_id" class="form-control" onchange="categoryChange4(this.value)">
                                <option selected="" disabled="">--select--</option>
                                <?php foreach ($data['type'] as $key) {
                                ?>
                                    <option value="<?php echo $key->type_id; ?>"><?php echo $key->type_name ?></option>
                                <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Model</label>
                            <select name="model_id" id="model1" class="form-control" onclick="categoryChange5(this.value)">
                                <option selected="" disabled="">--select--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                             <label>Category</label>
                            <select name="category_new_id" id="category_new" class="form-control" onclick="categoryChange6(this.value)">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                             <label>Sub category</label>
                            <select name="subcategory_new_id" id="subcat_new" class="form-control" onclick="categoryChange7(this.value)">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-border">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="allItems">
                          
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
               
            </div>
        
        </div>
    </div>
</div>
<script type="text/javascript">
  function get_all_category_search()
    {
        var category_id = $('#type_id').val();
        var subCategory = $('#model1').val();
        var subCategory1 = $('#category_new').val();
        var subCategory2 = $('#subcat_new').val();
        if(category_id!=0)
        {
          $.ajax({
            type:'POST',
            url:'<?php echo URLROOT;?>/pages/by_allcategory_item_catfornameonly',
            data:{category_id,subCategory,subCategory1,subCategory2},
            success : function(data)
            {
               $('#allItems').html(data);
            
            }
          });
        }
   }
   function select_items(vl) 
   {
        document.getElementById("item_id").value = vl.id;
        document.getElementById("tags1").value = vl.name;
        var val = vl.id;
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/getTheItemName_for_jquery",
            type: "POST",
            data: {val},
            success: function(response)
            {
               
               $('#tags').html(response);
               getTheCostPriceForAnItem(val);
				getTheqtyForAnItem(val);
            }
        });
        $('#exampleStandardModal').modal('hide');

   }
</script>
<script type="text/javascript">
    
    function categoryChange4(typeid)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/types",
            type: "POST",
            data: {typeid},

            success: function(response)
            {   
                $('#model1').html(response);
                $('#c').val(typeid);
                categoryChange5();
            }
        });
    }
     function categoryChange5(model)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/models",
            type: "POST",
            data: {model},

            success: function(response)
            {   
                $('#category_new').html(response);
                 $('#s1').val(model);
                categoryChange6();
            }
        });

    }
    function categoryChange6(cat_new)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/category_new",
            type: "POST",
            data: {cat_new},

            success: function(response)
            {   
                $('#subcat_new').html(response);
                $('#s2').val(cat_new);
                categoryChange7();
            }
        });
       
    }
    function categoryChange7(subcat_new)
    {
        $('#s3').val(subcat_new);
        get_all_category_search();
       
    }
</script>