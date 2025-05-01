<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Distributor Package Create</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="contentbar">
    <div class="row">   
        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header bg-primary-rgba">
                    <h5 class="card-title text-primary">Distributor Order ID - <?php echo $data['distributor']->id; ?></h5>
                </div>
                <div class="card-body">
                    <?php if(empty($data['rem_d_ord'])){ ?>
                    <form action="<?php echo URLROOT; ?>/pages/saveThePackageDetails_for_dist/<?php echo $data['distributor']->id ?>" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Date</label>
                                    <input type="date" class="form-control" name="distDate">
                                </div>
                            </div>
                            <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sl.No.</th>
                                                    <th>Item</th>
                                                    <th>Ordered</th>
                                                    <th>Packed</th>
                                                    <th>Quantity to Pack</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $itemId = explode('|||', $data['do']->item_id);
                                                $itemName = explode('|||', $data['do']->item_name);
                                                $itemQty = explode('|||', $data['do']->item_qty);
                                                $itemPrice = explode('|||', $data['do']->item_price);
                                                $itemTax = explode('|||', $data['do']->item_tax);
                                                $itemTotal = explode('|||', $data['do']->item_state);
                                                for ($i=0; $i < sizeof($itemId); $i++) { 
                                            ?> 
                                                <tr>
                                                    <td><?php echo $i+1; ?></td>
                                                    <td>
                                                        <input type="text" class="form-control" value="<?php echo $itemName[$i]; ?>" name="itemName[]">
                                                        <input type="hidden" class="form-control" value="<?php echo $itemId[$i] ?>" name="itemId[]">
                                                    </td>
                                                    <td><input type="text" class="form-control" value="<?php echo $itemQty[$i]; ?>" name="itemQty[]" ></td>
                                                    <td><input type="text" class="form-control" name="qtyPack[]"></td>

                                                    <td width="200"><input type="text" class="form-control" value="<?php echo $itemQty[$i]; ?>" name=""></td>
                                                </tr>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <button class="btn btn-info pull-right" style="width: 150px;">Save</button>
                                        <button class="btn btn-warning pull-right mr-2" style="width: 150px;">Cancel</button>
                                    </div>
                                
                            </div>
                        </div>
                    </form>
                    <?php }else{ ?>
                    <form action="<?php echo URLROOT; ?>/pages/saveThePackageDetails_rem_pack_for_dist/<?php echo $data['distributor']->id ?>" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Date</label>
                                    <input type="date" class="form-control" name="saleDate">
                                </div>
                            </div>
                            <div class="col-md-12">
                                
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sl.No.</th>
                                                    <th>Item</th>
                                                    <th>Ordered</th>
                                                    <th>Quantity to Pack</th>
                                                    <th>Packed</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                         <?php 
                                                    $flag =0;
                                                    $rem = $data['all_rem_d_ord'];
                                                    $itemId = explode('|||', $data['do']->item_id);
                                                    $itemName = explode('|||', $data['do']->item_name);
                                                    $itemQty = explode('|||', $data['do']->item_qty);
                                                    $itemPrice = explode('|||', $data['do']->item_price);
                                                    $total_item_received = explode('|||', $data['rem_d_ord']->total_item_received);
                                                    $item_to_pack = explode('|||', $data['rem_d_ord']->item_to_pack);
                                                    for ($i=0; $i < sizeof($itemId); $i++) { 
                                                ?>
                                                <?php if($item_to_pack[$i] == 0){ $flag = 0; }else{$flag = 1;}?>
                                                <tr>
                                                    <td><?php echo $i+1; ?></td>
                                                    <td>
                                                        <input type="text" class="form-control" value="<?php echo $itemName[$i]; ?>" name="itemName[]">
                                                        <input type="hidden" class="form-control" value="<?php echo $itemId[$i] ?>" name="itemId[]">
                                                    </td>
                                                    <td><input type="text" class="form-control" value="<?php echo $itemQty[$i]; ?>" name="itemQty[]" ></td>
                                                    
                                                     <td width="200"><input type="text" class="form-control" value="<?php echo $item_to_pack[$i]; ?>" name="qtyPack[]"></td>

                                                    <td><input type="text" class="form-control"  value="<?php echo $total_item_received[$i]; ?>" name="already_packed[]" readonly></td>
                                                   
                                                </tr>
                                            <?php }?> 
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php if($flag==1){?>
                                    <div class="col-md-12">
                                        <button class="btn btn-info pull-right" style="width: 150px;">Save</button>
                                        <button class="btn btn-warning pull-right mr-2" style="width: 150px;">Cancel</button>
                                    </div>
                                    <?php }else{ ?> <div><?php echo "All Items Packed";?></div> <?php }?>
                               
                            </div>
                        </div>
                    </form>
                    <?php }?>
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