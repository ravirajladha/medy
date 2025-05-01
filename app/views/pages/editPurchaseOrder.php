<?php require APPROOT . '/views/inc/header.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<?php $d = new Page;  ?>
<!-- Start Breadcrumbbar -->
<div class="breadcrumbbar">
	<div class="row align-items-center">
		<div class="col-md-8 col-lg-8">
			<h4 class="page-title">Edit Purchase Order</h4>
			<div class="breadcrumb-list">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
				</ol>
			</div>
		</div>
		<div class="col-md-4 col-lg-4">
			<div class="widgetbar">

			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbbar -->
<!-- Start Contentbar -->
<?php
$pData = $data['purchaseDetails'];
$pOData = $data['purchaseOrderDetails'];
?>

	<div class="contentbar">
		
		<!-- Start row -->
		<form method="POST" action="<?php echo URLROOT; ?>/pages/update_purchase_order/<?php echo $data['pid'];?>" enctype="multipart/form-data" id="formId">
		<div class="row">
			<!-- Start col -->
			
			<div class="col-lg-6">
				<div class="card m-b-30">
					<div class="card-body">
						<div class="form-group">
							<label>Vendor Name</label>
							<input type="text" class="form-control" value="<?php echo $pData->vendor; ?>" name="vendor" id="vname" readonly>
							<!-- <div class="dropdown-menu" id="dropDownAjaxvname" style="width: 470px;padding-bottom: 0px;padding-top: 0px;">
							</div>  -->
							<input type="text" name="vendor_id" id="vname_id" style="display: none;"  value="<?php echo $pData->vendor_id; ?>"/>
							<!-- <select class="select2-single form-control" name="vendor_id" id="" onchange="getvendoradd(this.value)" >
                                <option selected="" disabled="">--Select--</option>
                                <?php foreach ($data['vendor'] as $ve) { ?>
                                <option value="<?php echo $ve->vendor_id;?>"><?php echo $ve->dispName;?></option>
                                <?php }?>
                            </select>  -->
						</div>
						<div class="form-group">
							<label>Billing Address</label>
							<textarea class="form-control" id="bill_address" name="bill_address" ><?php echo $pData->bill_address; ?></textarea>
						</div>
						<div class="form-group">
							<label>Deliver To</label>
							<!-- <?php if(!empty($data['cdetails'])){$cd = $data['cdetails']; $caddress = $cd->name.", ".$cd->street1.",".$cd->street2.",".$cd->city.",".$cd->state.",".$cd->country.",".$cd->zip_code.", Phone:".$cd->phone.", Email:".$cd->email." ".$cd->fax; }else{ $caddress ="";} ?> -->
							<textarea class="form-control" name="deliver_to" ><?php echo $pData->deliver_to; ?></textarea>
						</div>

						<div class="form-group" style="display: none;">
							<label>Purchase Order#</label>
							<input type="text" class="form-control" placeholder="ex P0-00001" name="purchase_order" value="<?php echo $pData->purchase_order; ?>">
						</div>
						<div class="form-group">
							<label>Reference#</label>
							<input type="text" class="form-control" placeholder="" name="reference" value="<?php echo $pData->reference; ?>">
						</div>

						<div class="form-group">
							<label>Date</label>
							<input type="date" class="form-control" placeholder="" name="ndate" value="<?php echo date('Y-m-d'); ?>" >
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
							<label>Expected Delivery Date</label>
							<input type="date" class="form-control" placeholder="" name="expected_delivery_date" min='1960-01-01' value="<?php echo date('Y-m-d'); ?>">
						</div>
						<div class="form-group">
							<label>Shipment Preference</label>
							<input type="text" class="form-control" placeholder="Choose the Shipment Preference or type to add" name="shipment_preference">
						</div>
						<div class="form-group">
							<label>Payment Terms</label>
							<select class="form-control" id="formControlSelect" name="payment_terms">
								<option>Due on Receipt</option>
								<option>Net 15</option>
								<option>Net 30</option>
								<option>Net 45</option>
								<option>Net 60</option>
								<option>Due end of the month</option>
								<option>Due end of the next month</option>
								<option>Due on Recipt</option>
							</select>
						</div>
						<div class="form-group">
							<label>Delivery Method</label>
							<textarea class="form-control" name="delivery_method"></textarea>
						</div>
						<div class="form-group">
							<label>Salesperson</label>
							<textarea class="form-control" name="salesperson"></textarea>
						</div>
					</div>
				</div>
			</div>
			<!-- End col -->
			<!-- Start col -->
			<div class="col-lg-12" id="itemDetails">
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
											<th> # </th>
											<th width="300"> Item </th>
											<!-- <th></th> -->
											<th> Receivable </th>
											<th> Per Unit Qty </th>
											<th> Qty </th>
											<th style="display: none"> Total Qty </th>
											<th> Price </th>
											<th> Total </th>
										</tr>
									</thead>
									<tbody>
                                        <?php
                                            $poBasicDetails = $data['poDetails'];
                                            $poIds = explode('|||', $poBasicDetails->item_id);
                                            $poName = explode('|||', $poBasicDetails->item_name);
                                            $poReceivable = explode('|||', $poBasicDetails->receivable);
                                            $poUnitQuantity = explode('|||', $poBasicDetails->per_unit_quantity);
                                            $poActQty = explode('|||', $poBasicDetails->act_qty);
                                            $poTotal = explode('|||', $poBasicDetails->total_qty);
                                            $poRowPrice = explode('|||', $poBasicDetails->row_price);
											$poRowTotal = explode('|||', $poBasicDetails->row_total);
											$perUnitQty = explode('|||', $pOData->per_unit_quantity);
											$pRecievable = explode('|||', $pOData->receivable);
											$pActQty = explode ('|||', $pOData->act_qty);
											$rowPrice = explode ('|||', $pOData->row_price);
											$rowTotal = explode ('|||', $pOData->row_total);
                                            for ($ii=0; $ii < sizeof($poIds); $ii++) { 
                            
                                        ?>
										<tr id='addr<?php echo $ii;?>'>
											<td>1<input type="hidden" value="1" style="border: none; width:10px;" id="slno" readonly></td>
											<td>
												<input type="number" name="itemId[]" class="form-control" placeholder="Enter Item Id" id="itemId" style="display: none;" value="<?php echo $poIds[$ii]; ?>">
												<input type="text" name='product[]' placeholder='Enter Item Name' class="form-control" id="tags1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off"/ style="display: none;" value="<?php echo $poName[$ii]; ?>">
												<div class="dropdown-menu" id="dropDownAjax" style="width: 500px;padding-bottom: 0px;padding-top: 0px;">

												</div>
                                                    <input type="text" class="form-control" value="<?php echo $poName[$ii]; ?>" readonly>
											</td>
											<!-- <td><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleStandardModal"><i class="fa fa-search"></i></a></td> -->
											<td>
												<input type="text" class="form-control" name="receivable" id="receivable[]" value="<?php if($pRecievable[$ii] == 1) {echo "Box";} else {echo "Piece";} ?>" readonly>
												<!-- <input type="hidden" name="" id="forBox">
												<select name="receivable" id="receivable" onchange="change_qty(this.value)">
                                                    <option value="1" selected="">Box</option>
                                                    <option value="3">Pieces</option>
                                                </select> -->
											</td>
											<td><input type="number" name='perUnit[]' placeholder='Enter Per Unit Quantity' class="form-control" id="perUnit" value="<?php echo $perUnitQty[$ii]; ?>" readonly /></td>

											<td><input type="number" name='actQty[]' placeholder='Enter Quantity' class="form-control qty" id="actQty" value="<?php echo $pActQty[$ii]; ?>" onchange="changeTotalQty()" /></td>
											<td style="display: none;"><input type="number" name='qty' placeholder='Total Qty' class="form-control" step="0" min="0" id="ttlq" /></td>

											<td><input type="number" name='price[]' placeholder='Enter Unit Price' class="form-control price" step="0.00" min="0" id="rowPrice" value="<?php echo $rowPrice[$ii]; ?>" readonly/></td>
											<td><input type="number" name='total[]' placeholder='0.00' class="form-control total" id="rowTotal" value="<?php echo $rowTotal[$ii]; ?>" readonly /></td>
										</tr>
                                        <?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- <div class="row clearfix">
							<div class="col-md-12">
								<a style="color: white;" id="" class="btn btn-default pull-left" onclick="addRowAndChangeItems()">Add Another Line</a>
								
							</div>
						</div> -->


						<div class="row clearfix" style="margin-top:20px;float: right;">
							<div class="pull-right col-md-12" style="margin-top: 30px;">
								<table class="table table-bordered table-hover" id="tab_logic_total">
									<tbody>
										<tr>
											<th class="text-center">Sub Total</th>
											<td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" value="<?php echo $pOData->subtotal; ?>" readonly /></td>
										</tr>
										<tr>
											<th class="text-center">Tax</th>
											<td class="text-center">
												<div class="input-group mb-2 mb-sm-0">
													<input type="number" class="form-control" id="tax" placeholder="0" name="tax">
													<div class="input-group-addon">%</div>
												</div>
											</td>
										</tr>
										<tr >
											<th class="text-center">Discount</th>
											<td class="text-center"><div class="input-group mb-2 mb-sm-0">
												<input type="text" name="discount" class="form-control" id="discount" placeholder="0" >
											</div></td>
										</tr>
										<tr >
											<th class="text-center">Discount Amount</th>
											<td class="text-center"><input type="number" name='discount_amount' id="discount_amount" placeholder='0.00' value="<?php echo $pOData->discount_amount; ?>" class="form-control" readonly/></td>
										</tr>
										<tr>
										<tr>
											<th class="text-center">Tax Amount</th>
											<td class="text-center"><input type="number" name='tax_amount' id="tax_amount" placeholder='0.00' value="<?php echo $pOData->po_tax_amount; ?>" class="form-control" readonly /></td>
										</tr>
										<tr>
											<th class="text-center">Grand Total</th>
											<td class="text-center"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' value="<?php echo $pOData->grand_total; ?>" class="form-control" readonly /></td>
										</tr>
									</tbody>
								</table>
							</div>
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
							<label>Customer Notes</label>
							<textarea class="form-control" placeholder="Enter any notes to be displayed in your transaction" name="customer_notes"><?php echo $pData->customer_notes; ?></textarea>
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
							<label>Terms & Conditions</label>
							<textarea class="form-control" placeholder="Enter the terms and Conditions of your business to be displayed in your transaction " name="t_and_c"><?php echo $pData->t_and_c; ?></textarea>
						</div>
					</div>
				</div>
			</div>
			</form>
			<div class="col-lg-12">
				<a class="btn btn-warning" href="<?php echo URLROOT; ?>/pages/sales_order" style="color: white; float:right">Cancel</a>
				<button type="reset" class="btn btn-primary mr-1" style="float: right;" id="submitForm">Submit</button>
			</div>
			<br><br><br>
			<!-- End col -->
		</div>
	</div>

<!-- End Contentbar -->


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

	function calc_total() {
		total = 0;
		$('.total').each(function() {
			total += parseInt($(this).val());
		});
		$('#sub_total').val(total.toFixed(2));
		tax_sum = total / 100 * $('#tax').val();
		$('#tax_amount').val(tax_sum.toFixed(2));
		$('#total_amount').val((tax_sum + total).toFixed(2));
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

</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php if (isset($_SESSION['success'])) { ?>
	<script type="text/javascript">
		swal("<?php echo $_SESSION['success']; ?>");
	</script>
<?php }
unset($_SESSION['success']); ?>

<script>
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
               getReceivable(val);
            }
        });
        $('#itemId').val(val);
    }
  $('#tags').keyup(function(){
	  	var tags = $('#tags').val();
        $.ajax({
			url: '<?php echo URLROOT; ?>/pages/getTheItems',
			type: "POST",
			data: {tags},
			success : function(res)
			{
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
				getReceivable(val);
			}
		});
	} 

	function getReceivable(iId)
	{
		$.ajax({
			url : "<?php echo URLROOT; ?>/pages/getReceivableForTheItem",
			type: "POST",
			data: {iId},
			success: function(response1)
			{
				response = JSON.parse(response1);
				if(response.rec == 1)
				{
					$('#receivable').val("Box");
					$('#perUnit').val(response.qty);
					$('#perUnit').prop('readonly', true);
					$('#rowPrice').val(response.purchase);
					$('#forBox').val(response.qty);
					$('#receivable').val(1);
				}
				if(response.rec == 3)
				{
					$('#receivable').val("Piece");
					$('#perUnit').val(1);
					$('#perUnit').prop('readonly', true);
					$('#rowPrice').val(response.purchase);
					$('#forBox').val(response.qty);
					$('#receivable').val(3);
				}
			}
		});
	}
	function change_qty(val) {
		if(val == 1)
		{
			$('#perUnit').val($('#forBox').val());
		}else
		{
			$('#perUnit').val(1);
		}
	}
</script>
<script>
	function changePerUnit(itemSelected)
	{
		if(itemSelected === 1)
		{
			$('#perUnit').val(1);
			$('#perUnit').prop('readonly', true);
		}
		else
		{
			$('#perUnit').val(1);
			$('#perUnit').prop('readonly', false);
		}
	}

	function changeTotalQty()
	{
		var cq = $('#actQty').val();
		var perUnit = $('#perUnit').val();
		var ttl = cq ;
		// var ttl = cq * perUnit;
		$('#ttlq').val(ttl);
	}
</script>

<script>
	function addRowAndChangeItems()
	{
		var slno = $('#slno').val();
		var item_Id = $('#itemId').val();
		var item = $('#tags1').val();
		var receivable = $('#receivable').val();
		var perUnitQty = $('#perUnit').val();
		var actQty = $('#actQty').val();
		var totalQty = $('#ttlq').val();
		var rowPrice = $('#rowPrice').val();
		var rowTotal = $('#rowTotal').val();
		// if(receivable == 1)
		// {
		// 	receivable = 'Box';
		// }
		// else
		// {
		// 	receivable = 'Pieces';
		// }
		
		if(item!="")
		{
			$.ajax({
				url: "<?php echo URLROOT; ?>/pages/tempPoData",
				type: "POST",
				data: {item_Id,item, receivable, perUnitQty, actQty, totalQty, rowPrice, rowTotal, slno},
				success: function(response)
				{
					$('#addr1').append(response);
					$('#slno').val("");
					$('#tags').val("");
					$('#tags1').val("");
					$('#receivable').val("");
					$('#perUnit').val("");
					$('#actQty').val("");
					$('#ttlq').val("");
					$('#rowPrice').val("");
					$('#rowTotal').val("");
					calc();
					calc_total();
					refresh_tag()
				}
			});
			return true;
		}
		else
		{
			alert("Enter Item first");
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
</script>
<script>
	$('#submitForm').click(function(){
		if(document.getElementById('vname').value == "")
		{
			alert("enter vender name");
		}
		else
		{
			// addRowAndChangeItems();
			$('#formId').submit();
		}
	});
</script>

<script>
  $('#vname').keyup(function(){
        var vname = $('#vname').val();
        $.ajax({
            url: '<?php echo URLROOT; ?>/pages/get_all_vender_for_auto_complete_vname',
            type: "POST",
            data: {vname},
            success : function(res)
            {
                $('#dropDownAjaxvname').html(res);
                // alert(res);

            }
        });
  });
</script>
<script>
	function getvendoradd(vid) 
    {
        $.ajax({
            url: '<?php echo URLROOT; ?>/pages/get_ve_bill1',
            type: "POST",
            data: {vid},
            success : function(res)
            {
                $('#bill_address').val(res);
            }
        });
        $.ajax({
            url: '<?php echo URLROOT; ?>/pages/get_ve_bill',
            type: "POST",
            data: {vid},
            success : function(res)
            {
                $('#vname').val(res);
            }
        });
    }
    function selectProductvname(val)
    {
        document.getElementById("vname_id1").value = val.id;
        document.getElementById("vname").value = val.name;
     	document.getElementById("bill_address").value = val.address;
           
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
        document.getElementById("itemId").value = vl.id;
        document.getElementById("tags1").value = vl.name;
        var val = vl.id;
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/getTheItemName_for_jquery",
            type: "POST",
            data: {val},
            success: function(response)
            {
               $('#tags').html(response);
               getReceivable(val);
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