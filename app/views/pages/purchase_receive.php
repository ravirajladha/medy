<?php require APPROOT . '/views/inc/header.php'; ?>                
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
                    
                    <?php 
                        $itemId = explode('|||', $data['purchaseItem']->item_id);
                        $itemName = explode('|||', $data['purchaseItem']->item_name);
                        $receivable = explode('|||', $data['purchaseItem']->receivable);
                        $perUnit = explode('|||', $data['purchaseItem']->per_unit_quantity);
                        $actQty = explode('|||', $data['purchaseItem']->act_qty);
                        $totalQty = explode('|||', $data['purchaseItem']->total_qty);
                     
                        /*
                            total receive quantity calculation part
                        */
                            $rQtyValue = array_fill(0, sizeof($itemId), 0);
                            $rQtyPerValue = array_fill(0, sizeof($itemId), 0);
                            $rQtyValueArray = array();
                            $rQtyPerValueArray = array();
                            $itemIdValueArray = array();
                            foreach ($data['receive'] as $value)
                            {
                                $rQtyValueArray[] = $value->received_qty;
                                $rQtyPerValueArray[] = $value->received_per_qty;
                                $itemIdValueArray[] = $value->item_id;
                            }

                            for ($p=0; $p < sizeof($rQtyPerValueArray); $p++)
                            { 
                                $tempReceiveQty = explode('|||', $rQtyValueArray[$p]);
                                $tempReceivePerQty = explode('|||', $rQtyPerValueArray[$p]);
                                // $tempItemId = explode('|||', $itemIdValueArray[$p]);

                                for ($qq=0; $qq < sizeof($tempReceiveQty); $qq++)
                                { 
                                    $rQtyValue[$qq] += $tempReceiveQty[$qq];
                                    $rQtyPerValue[$qq] = $tempReceivePerQty[$qq];
                                }
                            }
                        /*
                            end of total receive quantity calculation part
                        */
                        if($actQty == $rQtyValue)
                        {
                            echo "All items received";
                        }
                        if($actQty != $rQtyValue)
                        {
                         
                    ?>
                    <form action="<?php echo URLROOT; ?>/pages/saveTheReceive/<?php echo $data['pId'] ?>" method="POST">
                    <!-- <p>Receive Date: <?php echo date('d-M-Y'); ?></p>
                    <p>Batch:</p>
                    <input type="text" placeholder="enter batch name" id="newBatch" name="batch" required> -->
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Receive Date</label>
                            <input type="date" name="rec_date" class="form-control" required="true" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                         <?php $Page = new Page(); ?>
                            <?php $ab = $Page->get_auto_batch_count(); ?>
                            <?php if(empty($ab)){ ?> 
                                <div class="col-md-4">
                                    <label for="">Batch</label>
                                    <input type="text" name="batch" class="form-control" placeholder="Enter Batch" required="true" value="batch1">
                                </div>
                            <?php }else{ ?>
                            <?php $ab = explode("batch", $ab->batch );  ?>
                            <?php $ab = (int)$ab[1] + 1; ?>
                                <div class="col-md-4">
                                    <label for="">Batch</label>
                                    <input type="text" name="batch" class="form-control" placeholder="Enter Batch" required="true" value="<?php echo "batch".$ab; ?>">
                                </div>
                            <?php }?>

                    </div>
                    <hr>
                    <?php } ?>
                    <div class="table-responsive m-b-30">
                        <table class="table table-hover">
                            <?php if($actQty != $rQtyValue) {
                            ?>
                            <thead>
                                <tr>
                                    <th scope="col">Sl.No.</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Ordered Qty</th>
                                    <th scope="col">Ordered Unit Qty</th>
                                    <th scope="col">Received Qty</th>
                                    <th scope="col">Received Total Qty</th>
                                    <th scope="col">Quantity To Receive</th>
                                    <th>Position</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php } ?>
                            <tbody>
                                <?php $page = new Page(); ?>
                                <?php
                                    for ($i = 0; $i < sizeof($itemId); $i++)
                                    {  ?>
                                        <?php $check = $page->get_received_item_by_purchase_id($data['purchase']->id,$i); 

                                        $hide=0;
                                        if(empty($check))
                                        {}
                                        else
                                        {
                                            if($check->itemId == $itemId[$i])
                                            { 
                                                $hide=3; 
                                            }
                                            else
                                            { 
                                                $hide=0; 
                                            }
                                        }

                                        ?>  
                                            <?php if($hide==3){ ?>                      
                                            <tr <?php if($actQty[$i] == $rQtyValue[$i]) { ?> style="display: none;" <?php }?> >
                                                <td>
                                                    <?php echo $i+1; ?>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="itemId[]" value="<?php echo $itemId[$i];?>">
                                                    <input type="hidden" name="itemName[]" value="<?php echo $itemName[$i];?>">
                                                    <?php echo $itemName[$i] ?>
                                                </td>
                                                <input type="text" name="barcode[]" style="display: none;">
                                                <?php if($receivable[$i] == 1) { ?>
                                                    <select  style="display: none;">
                                                        <option>
                                                            <?php if($check->receivable==1){echo "Box";}?>
                                                        </option>
                                                    </select>
                                                    <?php } ?>
                                                    <?php if($receivable[$i] == 2) { ?>
                                                    <select   style="display: none;">
                                                        <option>
                                                            <?php if($check->receivable==3){echo "Pieces";}?>
                                                        </option>
                                                    </select>
                                                    <?php } ?>
                                                <!-- <td>
                                                    
                                                </td> -->
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

                                                    <input type="number" style="width: 70px;" name="rQty[]" value="<?php echo $check->rQty; ?>" disabled><br>

                                                    <label for="" style="display: none;">Per Qty</label>
                                                   
                                                    <input style="display: none;" type="number" style="width: 70px;" value="<?php echo $check->rPerQty; ?>" disabled>
                                                </td>
                                                <td>
                                                    <select disabled="">
                                                        <option><?php echo $check->position; ?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <?php
                                                        $qty = ($actQty[$i] - $rQtyValue[$i]);
                                                        $prId = sprintf('%06d', $itemId[$i]);
                                                        $pId = sprintf('%03d', $data['pId']);
                                                        $ccc = $prId.$i.$pId.'BE';
                                                    ?>
                                                   

                                                    <a class="btn btn-secondary text-white">Saved</a>
                                                    
                                                </td>
                                                
                                            </tr>

                                            <?php }else{ ?>
                                            <tr <?php if($actQty[$i] == $rQtyValue[$i]) { ?> style="display: none;" <?php }?> >
                                                <td>
                                                    <?php echo $i+1; ?>
                                                </td>
                                                <td>
                                                    <input type="text" name="barcode[]" style="display: none;">
                                                    <input type="hidden" name="itemId[]" value="<?php echo $itemId[$i];?>">
                                                    <input type="hidden" name="itemName[]" value="<?php echo $itemName[$i];?>">
                                                    <?php echo $itemName[$i]; ?>
                                                </td>
                                                    <?php if($receivable[$i] == 1) { ?>
                                                    <select name="receivable[]" style="display: none;">
                                                        <option value="1">Box</option>
                                                    </select>
                                                    <?php } ?>
                                                    <?php if($receivable[$i] == 3) { ?>
                                                    <select name="receivable[]" style="display: none;">
                                                        <option value="3">Pieces</option>
                                                    </select>
                                                    <?php } ?>

                                               <!--  <td>
                                                    
                                                </td> -->
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
                                                    <input type="number" style="width: 70px;" name="rQty[]" value="<?php echo ($actQty[$i] - $rQtyValue[$i]) ?>" ><br>
                                                    <label for="" style="display: none;">Per Qty</label>
                                                    <input style="display: none;" type="number" style="width: 70px;" name="rPerQty[]" <?php if($receivable[$i] == 2) { ?> value="1" readonly <?php } ?> <?php if($receivable[$i] == 1) { ?> value="<?php echo $perUnit[$i] ?>" <?php } ?> >
                                                </td>
                                                <td>
                                                    <select name="pos[]" id="" >
                                                        <?php foreach ($data['positions'] as $value)
                                                        {
                                                        ?>
                                                            <option><?php echo $value->position_code ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <?php
                                                        $qty = ($actQty[$i] - $rQtyValue[$i]);
                                                        $prId = sprintf('%06d', $itemId[$i]);
                                                        $pId = sprintf('%03d', $data['pId']);
                                                        $ccc = $prId.$i.$pId.'BE';
                                                    ?>
                                                    
                                                    <button name="temp_save" class="btn btn-secondary" onclick='save_serial_id(<?php echo $i;?>)' >Save</button>
                                                    
                                                </td>
                                                
                                            </tr>
                                            <?php }?>
                                           

                                           
                                    <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($actQty != $rQtyValue) { ?>
                    <label for="">Notes</label>
                    <textarea class="form-control" name="notes"></textarea><br>
                    <button class="btn btn-info pull-right" name="final_receive">Receive</button>
                    <a href="<?php echo URLROOT;?>/pages/purchase_order" class="btn btn-warning text-white pull-right mr-2" onclick="iFrame()">Cancel</a>
                    <?php } ?>
                    <input type="text" name="serial_id_draft" id="serial_id_draft" style="display: none;">
                    </from>
                </div>
            </div> 
        </div>
    </div>
</div>
<script type="text/javascript">
    //$("#pastbarcode").keypress(function(event){
    //if (event.which == '10' || event.which == '13') {
    //    event.preventDefault();
    //}
//});
</script>

<!-- Modal -->

<?php require APPROOT . '/views/inc/footer.php'; ?>
<script type="text/javascript">
    function copybarcode(arg1,arg2) {
        var x = 'pastbarcode'+arg2;
        document.getElementById(x).value = arg1;
    }
    function save_serial_id(arg1) {
        document.getElementById('serial_id_draft').value = arg1;
    }
</script>
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

    function generateBacode(rowId)
    {
        $.ajax({
            url: 'http://localhost/barcode/index.php',
            type: 'POST',
            data: {
                rowId
            },
            success: function(res)
            {
                // alert(res);
                // $('#barcode').html(res);
            }
        });
    }
</script>

<script type="text/javascript">
window.onload = function() {
    var oFrame = document.getElementById("myframe");
    oFrame.contentWindow.document.onclick = function() {
        alert("frame contents clicked");
    };
};
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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