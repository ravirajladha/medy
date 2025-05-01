<?php require APPROOT . '/views/inc/header.php'; ?>  x              
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Purchase Receive</h4>
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
                    <h5 class="card-title text-primary">Purchase ID - <?php echo $data['purchase']->id; ?></h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo URLROOT; ?>/pages/saveTheReceive/<?php echo $data['pId'] ?>" method="POST">
                    <p>Receive Date: <?php echo date('d-M-Y'); ?></p>
                    <p>Batch:</p>
                    <input type="text" placeholder="enter batch name" id="newBatch" name="batch" required>
                    <select name="batch" id="existingBatch" style="display: none;" disabled required>
                        <option>a</option>
                    </select>
                    <a href="#" onclick="existingBatch()" id="existingBatchA">add existing batch</a>
                    <a href="#" onclick="newBatch()" id="newBatchA" style="display: none;">add new batch</a>
                    <br>
                    <br>
                    <div class="table-responsive m-b-30">
                        <table class="table table-hover">
                            <?php if($actQty != $rQtyValue) {
                            ?>
                            <thead>
                                <tr>
                                    <th scope="col">Sl.No.</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Receivable</th>
                                    <th scope="col">Ordered Qty</th>
                                    <th scope="col">Ordered Unit Qty</th>
                                    <th scope="col">Received Qty</th>
                                    <th scope="col">Received Total Qty</th>
                                    <th scope="col">Quantity To Receive</th>
                                    <th>Positions</th>
                                </tr>
                            </thead>
                            <?php } ?>
                            <tbody>
                                <?php
                                    for ($i = 0; $i < sizeof($itemId); $i++)
                                    { 
                                            ?>
                                            <tr <?php if($actQty[$i] == $rQtyValue[$i]) { ?> style="display: none;" <?php } ?>>
                                                <td>
                                                    <?php echo $i+1; ?>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="itemId[]" value="<?php echo $itemId[$i];?>">
                                                    <input type="hidden" name="itemName[]" value="<?php echo $itemName[$i];?>">
                                                    <?php echo $itemName[$i] ?>
                                                </td>
                                                <td>
                                                    <?php if($receivable[$i] == 1) { ?>
                                                    <select name="receivable[]">
                                                        <option value="1">Box</option>
                                                        <option value="2">Unbox</option>
                                                    </select>
                                                    <?php } ?>
                                                    <?php if($receivable[$i] == 2) { ?>
                                                    <select name="receivable[]">
                                                        <option value="3">Pieces</option>
                                                    </select>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php echo $actQty[$i] ?>
                                                </td>
                                                <td>
                                                    <?php echo $perUnit[$i] ?>
                                                </td>
                                                <td>
                                                    <?php echo $rQtyValue[$i]; ?>
                                                </td>
                                                <td>
                                                    <?php echo ($rQtyPerValue[$i] * $rQtyValue[$i]); ?>
                                                </td>
                                                <td>
                                                    <label for="">Qty&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                    <input type="number" style="width: 70px;" name="rQty[]" value="<?php echo ($actQty[$i] - $rQtyValue[$i]) ?>"><br>
                                                    <label for="">Per Qty</label>
                                                    <input type="number" style="width: 70px;" name="rPerQty[]" <?php if($receivable[$i] == 2) { ?> value="1" readonly <?php } ?> <?php if($receivable[$i] == 1) { ?> value="<?php echo $perUnit[$i] ?>" <?php } ?>>
                                                </td>
                                                <td>
                                                    <select name="pos[]" id="">
                                                        <?php foreach ($data['positions'] as $value)
                                                        {
                                                        ?>
                                                            <option><?php echo $value->position_code ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                    <?php }  ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($actQty != $rQtyValue) { ?>
                    <label for="">Notes</label>
                    <textarea class="form-control" name="notes"></textarea><br>
                    <button class="btn btn-primary">Receive</button>
                    <a class="btn btn-warning text-white">Cancel</a>
                    <?php } ?>
                    </from>
                </div>
            </div> 
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>

<script>
    function existingBatch()
    {
        $('#newBatch').css('display','none');
        $('#newBatch').attr('disabled',true);
        $('#newBatchA').css('display','block');
        $('#existingBatch').css('display','block');
        $('#existingBatchA').css('display','none');
        $('#existingBatch').attr('disabled',false);
    }

    function newBatch()
    {
        $('#newBatch').css('display','block');
        $('#newBatchA').css('display','none');
        $('#existingBatch').css('display','none');
        $('#existingBatchA').css('display','block');
        $('#newBatch').attr('disabled',false);
        $('#existingBatch').attr('disabled',true);
    }
</script>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>