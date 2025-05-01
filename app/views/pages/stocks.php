<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Start Breadcrumbbar -->
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Stocks</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>

                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">

                <button class="btn btn-primary"><i class="ri-refresh-line mr-2"></i>Refresh</button>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbbar -->
<!-- Start Contentbar -->
<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="card-title mb-0">All Stocks</h5>
                        </div>
                        <div class="col-6">
                            <ul class="list-inline-group text-right mb-0 pl-0">
                                <li class="list-inline-item">
                                    <div class="form-group mb-0 amount-spent-select">
                                        <select class="form-control" id="formControlSelect">
                                            <option>All</option>
                                            <option>Last Week</option>
                                            <option>Last Month</option>
                                            <option>Low Stocks</option>
                                            <option>New Stocks</option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>QR</th>
                                    <th>Order Type</th>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Purchase Order no</th>
                                    <th>Sales Order no</th>
                                    <th>Batch</th>
                                    <th>Vendor Name</th>
                                    <th>Customer Name</th>
                                    <th>Distributor</th>
                                    <th>Stock in Hand</th>
                                    <th>Total stock Received</th>
                                    <th>Remaining Stock</th>
                                    <th>Position</th>
                                    <th>Received IN</th>
                                    <th>Expected Date</th>
                                    <th>received date</th>
                                    <th>Item Age</th>
                                   <!--  <th>barcode</th> -->
                                    
                                    <!--  <th>Actions</th> -->
                                </tr>
                            </thead>
                            <tbody >
                                <?php $Page = new Page();?>
                                <?php foreach ($data['stock'] as $s) { ?>
                                    <?php
                                    $item_id = explode("|||", $s->item_id);
                                    $stock_on_hand = explode("|||", $s->stock_on_hand);
                                    $stock_total_receive = explode("|||", $s->stock_total_receive);
                                    $remaining_stock = explode("|||", $s->remaining_stock);
                                    $position = explode("|||", $s->position);
                                    ?>


                                    <?php for ($m = 0; $m < sizeof($item_id); $m++) { ?>

                                        <tr>

                                            <td scope="row"><?php echo $s->id; ?></td>
                                            <td>
                                                <input type="text" id="item_id<?php echo $s->id; ?>" name="item_id" value="<?php echo $s->item_id; ?>" style="display: none;">
                                                <input type="text" id="temp_qr_id<?php echo $s->id; ?>" name="temp_qr_id" value="<?php echo $s->id; ?>" style="display: none;">
                                                
                                                <button id="qrprint<?php echo $s->id; ?>" type="submit" class="btn btn-info text-white"><i class="fa fa-qrcode" aria-hidden="true"></i></button>
                                                <script>
                                                     $('#qrprint<?php echo $s->id; ?>').click(function(){
                                                        var item_id = $('#item_id<?php echo $s->id; ?>').val();
                                                        var temp_qr_id = $('#temp_qr_id<?php echo $s->id; ?>').val();
                                                        $.ajax({ url: "<?php echo URLROOT; ?>/pages/print_item_qr2",
                                                            type: "POST",
                                                            data: {item_id,temp_qr_id},
                                                            success: function(response)
                                                            {window.open(response);}
                                                        });
                                                     });
                                                </script>
                                            </td>
                                            <td><?php if($s->purchase_sales==0){ echo "Purchase Order";}else{ echo "Sales Order";} ?></td>
                                            <td><?php echo $item_id[$m]; ?></td>
                                            <td><?php echo $Page->getTheItemName($item_id[$m]); ?></td>
                                            <td><?php if(empty($s->order_number)){ echo "#";}else{ echo $s->order_number;} ?></td>
                                            <td><?php if(empty($s->sales_order_no)){ echo "#";}else{ echo $s->sales_order_no;}?></td>
                                            <td><?php if(empty($s->batch)){ echo "#";}else{ echo $s->batch;} ?></td>
                                            <td><?php if(empty($s->name)){ echo "null";}else{ echo $s->name;} ?> </td>
                                            <td><?php if(empty($s->customer_name)){ echo "null";}else{ echo $s->customer_name;} ?></td>
                                             <td><?php if(empty($s->distributor_name)){ echo "null";}else{ echo $s->distributor_name;} ?></td>
                                            <td><?php echo $stock_on_hand[$m]; ?></td>
                                            <td><?php echo $stock_total_receive[$m]; ?></td>
                                            <td><?php echo $remaining_stock[$m]; ?></td>
                                            <td><?php if(empty($position[$m])){ echo "null";}else{ echo $position[$m];} ?></td>
                                            <td>
                                                <?php if($s->receivable == 1){?>
                                                &nbsp;Box 
                                                <br>
                                                <a href="#" class="badge badge-primary" data-toggle="modal" data-target="#exampleStandardModal<?php echo $s->id;?>">Unbox</a> 
                                                <div class="modal fade" id="exampleStandardModal<?php echo $s->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <form method="post" action="<?php echo URLROOT;?>/pages/convert_box_item/<?php echo $s->id; ?>">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleStandardModalLabel">Update Stock </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table>
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>Stock on hand</th>
                                                                            <th>Item Box QTY</th>
                                                                            <th>Unbox QTY</th>
                                                                            
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><input type="text" name="stock_id" class="form-control" value="<?php echo $s->id; ?>" readonly="true" autocomplete="off" /></td>
                                                                            <td><input type="text" name="stock_on_hand" class="form-control" value="<?php echo $stock_on_hand[$m];?>" readonly="true"></td>
                                                                            <td>
                                                                            <?php $all_it = $Page->get_single_item($item_id[$m]); ?>
                                                                            <input type="text" name="item_qty" class="form-control" value="<?php echo $all_it->qty;?>" readonly="true">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" name="pieces" class="form-control" required="true" autocomplete="off" value="sd">
                                                                            </td>
                                                                            <?php $a = 0;
                                                                            $a = $all_it->qty * $stock_on_hand[$m];?>
                                                                            <td><input type="text" name="item_id" value="<?php echo $item_id[$m];?>" style="display: none;">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Unbox</button>
                                                            </div>
                                                        </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php 
                                                }
                                                elseif($s->receivable == 2)
                                                { 
                                                    echo "Unbox"; 
                                                }
                                                elseif($s->receivable == 3)
                                                { 
                                                    echo "Pieces"; 
                                                } ?>
                                            </td>
                                            <td><?php echo $s->Expected_date; ?></td>
                                            <td><?php echo $s->created_at; ?></td>
                                            <td><?php   
                                            $d = date('Y-m-d H:i:s');
                                            $date1 = strtotime($s->created_at);  
                                            $date2 = strtotime(date($d));  
                                            $diff = abs($date2 - $date1); 
                                            $years = floor($diff / (365*60*60*24));  
                                            $months = floor(($diff - $years * 365*60*60*24) 
                                                                        / (30*60*60*24));
                                            $days = floor(($diff - $years * 365*60*60*24 -  
                                            $months*30*60*60*24)/ (60*60*24));
                                            echo "Day:".$days."<br>Month:".$months."<br>Year:".$years;
                                            ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
</div>
<!-- End Contentbar -->
<?php require APPROOT . '/views/inc/footer.php'; ?>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php if (isset($_SESSION['success'])) { ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php }
unset($_SESSION['success']); ?>
<script type="text/javascript">
  $(document).ready(function()
    {
    var lim = 9;
    var off = 0;
    var inc = 0;
        $.ajax({
        type: "POST",
        url: '<?php echo URLROOT;?>/pages/all_stock_tbody',
        data: {lim,off},
        cache: false,
        success:function(response)
        {
            $('#all_stock').html(response);
        }
        });
        $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height())
        {
            lim = 10;
            $.ajax({
            type: "POST",
            url: '<?php echo URLROOT;?>/pages/all_stock_tbody',
            data: {lim,inc},
            cache: false,
            success:function(response)
            { 
                inc++;
                $('#all_stock').append(response);
            }
            });
        }
    });
    });
</script>