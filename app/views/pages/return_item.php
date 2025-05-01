<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Sales Return</h4>
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
                    <h5 class="card-title text-primary">Sales ID - <?php echo $data['sales']->id; ?></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Date</label>
                                <input type="date" class="form-control" name="saleDate" max="<?php echo date('Y-m-d');?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <!-- first time package creation -->
                        
                        <form action="<?php echo URLROOT; ?>/pages/saveThePackageDetails/<?php echo $data['sales']->id ?>" method="POST">
                            <div class="table-responsive">
                               
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Item</th>
                                            <th>Ordered</th>
                                            <th>Returned</th>
                                            <th>Quantity to Return</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $itemId = explode('|||', $data['so']->item_id);
                                        $itemName = explode('|||', $data['so']->item_name);
                                        $itemQty = explode('|||', $data['so']->item_qty);
                                        $itemPrice = explode('|||', $data['so']->item_price);
                                        $itemTax = explode('|||', $data['so']->item_tax);
                                        $itemTotal = explode('|||', $data['so']->item_state);
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
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-info pull-right" style="width: 150px;">Save</button>
                            <button class="btn btn-warning pull-right mr-2" style="width: 150px;">Cancel</button>
                        </div>
                        </form>
                        
                  
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