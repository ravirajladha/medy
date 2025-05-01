<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Stock Out Package</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"> var gl=0;</script>
<?php $ordered_q = 0; $qty_need_to_pack=0; $packed=0;?>
<div class="contentbar">
    <div class="row"> 
    	<div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header bg-primary-rgba">
                    <h5 class="card-title text-primary">Item to be Pack <x style="float: right;">Stockout ID - <?php echo $data['stockout']->id; ?> </x></h5>
                    <input type="hidden" name="" id="stockout" value="<?php echo $data['stockout']->id; ?>">
                </div>
                <div class="card-body">
                    <div class="row">
				    	<div class="col-md-12">
					            <!-- first time package creation -->
						        <?php if(empty($data['rem_s_ord'])){ ?>
						        <form action="<?php echo URLROOT; ?>/pages/saveThePackageDetails_stock_out/<?php echo $data['stockout']->id ?>" method="POST">
						            <div class="table-responsive">
						                <table class="table">
						                    <thead>
						                        <tr>
						                            <th>Sl.No.</th>
						                            <th>Item</th>
						                            <th>Type</th>
						                            <th>Ordered</th>
						                            <th>Packed</th>
						                            <th>Quantity to Pack</th>
						                        </tr>
						                    </thead>
						                    <tbody>
						                    <?php
						                    	
						                        $itemId = explode('|||', $data['so']->item_id);
						                        $itemName = explode('|||', $data['so']->item_name);
						                        $itemQty = explode('|||', $data['so']->item_qty);
						                        $item_rec = explode('|||', $data['so']->item_rec);
						                     
						                        for ($i=0; $i < sizeof($itemId); $i++) { 
						                    ?> 
						                        <tr>
						                            <td><?php echo $i+1; ?></td>
						                            <td><?php echo $itemName[$i]; ?>
						                            	
						                                <input type="hidden" class="form-control" value="<?php echo $itemName[$i]; ?>" name="itemName[]">

						                                <input type="hidden" class="form-control" value="<?php echo $itemId[$i] ?>" name="itemId[]">
						                            </td>
						                            <td>
						                            	<?php $s_s=''; if($item_rec[$i]==1){ $s_s = "Box"; }else { $s_s = "Pieces"; } echo $s_s; ?>
						                            	<input type="hidden" id="itype<?php echo $itemId[$i] ?>" value="<?php echo $s_s; ?>">
						                            </td>
						                            <td><input type="text" class="form-control" value="<?php echo $itemQty[$i]; ?>" name="itemQty[]" readonly="true"></td>

						                            <td><input type="text" class="form-control" name="qtyPack[]" readonly="true" id="qtyupdate<?php echo $itemId[$i] ?><?php echo $item_rec[$i]; ?>"></td>

						                            <td width="200"><input type="text" class="form-control" value="<?php echo $itemQty[$i]; ?>" name="" readonly="true" ></td>
						                           
						                        </tr>
						                    <?php }?>
						                    
						                    </tbody>
						                </table>
						            </div>
						            <div class="col-md-12">
						                <button class="btn btn-info pull-right" style="width: 150px;">Save</button>
						               <a href="<?php echo URLROOT;?>/pages/all_stock_out" class="btn btn-warning pull-right mr-2" style="width: 150px;">Cancel</a>
						            </div>
						        </form>
						        <?php }else{ ?>
						        <form action="<?php echo URLROOT; ?>/pages/saveThePackageDetails_rem_pack_for_stock/<?php echo $data['stockout']->id ?>" method="POST">
						            <div class="table-responsive">
						                <table class="table">
						                    <thead>
						                        <tr>
						                            <th>Sl.No.</th>
						                            <th>Item</th>
						                            <th>Type</th>
						                            <th>Ordered</th>
						                            <th>Quantity Need to Pack</th>
						                            <th>Qty Packed</th>
						                            <th>Already Packed</th>
						                        </tr>
						                    </thead>
						                    <tbody>
						                 <?php 
						                            $flag =0;
						                            $rem = $data['all_rem_s_ord'];
						                            $itemId = explode('|||', $data['so']->item_id);
						                            $item_rec = explode('|||', $data['so']->item_rec);
						                            $itemName = explode('|||', $data['so']->item_name);
						                            $itemQty = explode('|||', $data['so']->item_qty);
						                            $total_item_received = explode('|||', $data['rem_s_ord']->total_item_received);
						                            $item_to_pack = explode('|||', $data['rem_s_ord']->item_to_pack);
						                            for ($i=0; $i < sizeof($itemId); $i++) { 
						                        ?>
						                        <?php if($item_to_pack[$i] == 0){ $flag = 0; }else{$flag = 1;}?>
						                         <?php if($flag==1){?>
						                        <tr>
						                            <td><?php echo $i+1; ?></td>
						                            <td><?php echo $itemName[$i]; ?>
						                            	

						                                <input type="hidden" class="form-control" value="<?php echo $itemName[$i]; ?>" name="itemName[]" >
						                                <input type="hidden" class="form-control" value="<?php echo $itemId[$i] ?>" name="itemId[]" >
						                            </td>
						                            <td>
						                            	<?php $s_s=''; if($item_rec[$i]==1){ $s_s = "Box"; }else { $s_s = "Pieces"; } echo $s_s; ?>
						                            	<input type="hidden" id="itype<?php echo $itemId[$i] ?>" value="<?php echo $s_s; ?>">
						                            </td>
						                            <td><input type="text" class="form-control" value="<?php echo $itemQty[$i]; ?>" name="itemQty[]" readonly></td>
						                            <td><input type="text" class="form-control"  value="<?php echo $item_to_pack[$i]; ?>"readonly></td>
						                            
						                             <td width="200"><input type="text" class="form-control"  name="qtyPack[]" id="qtyupdate<?php echo $itemId[$i] ?><?php echo $item_rec[$i]; ?>" readonly></td>

						                            <td><input type="text" class="form-control"  value="<?php echo $total_item_received[$i]; ?>" name="already_packed[]"  readonly></td>
						                             <?php $ordered_q = $ordered_q + (int)$itemQty[$i]; ?>
						                             <?php $qty_need_to_pack = $qty_need_to_pack + (int)$item_to_pack[$i];?>
						                             <?php $packed = $packed + (int)$total_item_received[$i];  ?>
						                        </tr>
						                    <?php }?>
						                    <?php }?> 
						                     <input type="hidden" name="" id="ordered_q" value="<?php echo $ordered_q;?>">
						                     <input type="hidden" name="" id="qty_need_to_pack_q" value="<?php echo $qty_need_to_pack;?>">
						                     <input type="hidden" name="" id="packed_q" value="<?php echo $packed;?>">
						                    </tbody>
						                </table>
						            </div>
						            <?php //if($flag==1){?>
						            <div class="col-md-12">
						                <button class="btn btn-info pull-right" style="width: 150px;">Save</button>
						                <a href="<?php echo URLROOT;?>/pages/all_stock_out" class="btn btn-warning pull-right mr-2" style="width: 150px;">Cancel</a>
						            </div>
						        <?php //}else{ ?> <!-- <div><?php echo "All Items Packed";?></div> --> <?php// }?>
						        </form>
						    	<?php }?>
					    </div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header bg-primary-rgba">
                    <h5 class="card-title text-primary">Scan Packed Items </h5>
                </div>
                <div class="card-body">
                    <div class="row">
			    		<div class="col">
				        	<button class="btn btn-info pull-left" id="scstart" onclick="startscan()">Scan Packed Items</button>
				        	<button class="btn btn-warning pull-left" id="scend" onclick="endscan()" style="display: none;">End Scan Items</button>
				        </div>
				        <div class="col">
				        		<input type="text" name="barcode" id="scnitem" class="form-control" />
				        </div>
				        <div class="col-md-6">
				        	<p id="alert" style="color: red;display: none;" ></p>
				        </div>
				        <script type="text/javascript">
	      					function startscan()
	      					{
	      						gl=1;
	      						$("#scnitem").focus();
	      						selectProduct()
	      						document.getElementById("scstart").style.display = "none";
	      						document.getElementById("scend").style.display = "block";
	      					}
	      					function endscan()
	      					{
	      						gl=0;
	      						selectProduct()
	      						document.getElementById("scstart").style.display = "block";
	      						document.getElementById("scend").style.display = "none";
	      					}

	      					function selectProduct()
							{	
									var interval = setInterval(function()
									{
										if(gl==0)
										{
											clearInterval(interval);
											document.getElementById("alert").innerHTML="";
										}
										var y = document.getElementById("scnitem").value;
										if(y!="")
							 		 	{
									   //       	totalordered = parseInt(document.getElementById("ordered_q").value);
									   //       	qtydone = parseInt(document.getElementById("qty_need_to_pack_q").value);
									   //       	qtyneed = parseInt(document.getElementById("packed_q").value);
									   //       	alert(""+qtydone+""+qtyneed)
												// if(qtydone==qtyneed)
												// {
												// 	document.getElementById("alert").innerHTML="Qty Completed";
												// }
												// else
												// {
								 		 			var emp="";
								 		 			var item_id_for_qty = 0;
									 		 		var barcode = document.getElementById("scnitem").value;
									 		 		var stockoutid = document.getElementById("stockout").value;
										     		$.ajax({
												        type:"POST",
												        url: "<?php echo URLROOT; ?>/pages/addbarcodeto",
												        data:{barcode,stockoutid},
												        success:function(data)
												        {
												        	$("#scnitem").focus();
										        			$("#scnitem").val(emp);
										        			all_temp_scan_table();
										        			var str = data;
															var res = str.split("|");
															var item_id_for_qty = res[0];
															var item_rec = res[1];
															updateqtyforscanitems(item_id_for_qty,item_rec);
										        			document.getElementById("alert").innerHTML=res[2];

										        		}
													});
										     	// }
										}

								    }, 200);
							}
							function updateqtyforscanitems(itemid,item_rec) {
								if(itemid!=0)
								{
									x = "qtyupdate"+itemid+item_rec;
									x = x.split(" ");
									x = x[0]+x[4];
									s = 0;
									if((document.getElementById(x).value)=="")
									{
										document.getElementById(x).value=1;
									}
									else
									{
										s = parseInt(document.getElementById(x).value);
										s = s+1;
										document.getElementById(x).value=s;	
									}
								}
							}
	                    </script>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header bg-primary-rgba">
                    <h5 class="card-title text-primary">Scaned Items List</h5>
                </div>
                <div class="card-body">
                    <div class="row">
	                    <div class="col-md-12">
                        	<div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Item ID</th>
                                            <th>Stock ID</th>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th>Type</th>
                                            <th>QR Code</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_temp_scan">
                                    
                                    </tbody>
                                </table>
                            </div>
	                    </div>
                	</div>
            	</div>
        	</div>
    	</div>
	</div>
</div>
		
<?php require APPROOT . '/views/inc/footer.php'; ?>

<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>

<script type="text/javascript">
   $(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});

</script>
<script type="text/javascript">
 function all_temp_scan_table() {
        $.ajax({
        type: "POST",
        url: '<?php echo URLROOT;?>/pages/getscaneditemsAllStock_out',
        data: {},
        success:function(response)
        {
            $('#all_temp_scan').html(response);
        }
        });
}
</script>