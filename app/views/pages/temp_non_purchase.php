<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Non Purchase Receive</h4>
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
                    <h5 class="card-title text-primary">Non Purchase Receive</h5>
                </div>
                <div class="card-body">

                    <form action="<?php echo URLROOT; ?>/pages/saveTheReceive1" method="POST">
                        <div class="table-responsive m-b-30">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Vendor Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Vendor Name" name="vendor" id="vname" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off" style="display: none">
                                            <div class="dropdown-menu" id="dropDownAjaxvname" style="width: 470px;padding-bottom: 0px;padding-top: 0px;">
                                            </div> 
                                            <!-- <input type="text" name="vendor_id" id="vname_id" style="display: block;" /> -->

                                            <select class="select2-single form-control" name="vendor_id" id="vname_id" onchange="getvendoradd(this.value)">
                                                <option>--Select--</option>
                                                <?php foreach ($data['vendor'] as $ve) { ?>
                                                <option value="<?php echo $ve->vendor_id;?>"><?php echo $ve->dispName;?></option>
                                                <?php }?>
                                            </select> 

                                        </div>

                                        <div class="col-md-4">
                                            <label for="">Receive Date</label>
                                            <input type="date" name="rec_date" class="form-control" required="true" min='1960-01-01' max="<?php echo date('Y-m-d');?>" value="<?php echo date('Y-m-d'); ?>">
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
                                    <br>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sl.No.</th>
                                                <th scope="col">Item</th>
                                                <th scope="col">Receivable</th>
                                                <th scope="col">Quantity To Receive</th>
                                                <th scope="col">Positions</th>
                                                <th scope="col">Barcode</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <input type="number" name="itemId" class="form-control" placeholder="Enter Item Id" id="itemId" style="display: none;">
                                                    
                                                    <input type="text" name='itemName' placeholder='Enter Item Name' class="form-control" id="tags" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off"/>
                                                    
                                                    <div class="dropdown-menu" id="dropDownAjax" style="width: 500px;padding-bottom: 0px;padding-top: 0px;">
                                                    </div>
                                                    
                                                </td>
                                                <td>
                                                    <select name="receivable">
                                                        <option value="1">Box</option>
                                                        <option value="3">Pieces</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" placeholder="Quantity Receive" name="rQty" id="rqty">
                                                </td>
                                                <td>
                                                    <select name="pos" id="">
                                                        <?php foreach ($data['positions'] as $value) {
                                                        ?>
                                                            <option><?php echo $value->position_code ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control mt-1" placeholder="Barcode" name="barcode" id="pastbarcode" style="width: 180px;">
                                                </td>
                                            </tr>
                                            

                                            
                                        </tbody>
                                    </table>
                        </div>
                        <a class="btn btn-primary" style="color: white" onclick="addRowForBill()">Add Another Line</a>
                        <br>
                        <br>
                        <label for="">Notes</label>
                        <textarea class="form-control" name="notes"></textarea><br>
                        <button class="btn btn-primary" type="submit" name="npreceive">Receive</button>
                        <a class="btn btn-warning text-white">Cancel</a>
                        </from>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
<div class="modal fade" id="barcodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <p id="myIframe1"></p>

        </div>
    </div>
</div>
<div class="modal fade" id="qrcodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <p id="myIframe2"></p>
        </div>
    </div>
</div>
<script>
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
    function getvendoradd(vid) 
    {
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
    // $('#rqty').keyup(function(){
    function copybarcode(){
        var itemid = $('#itemId').val();
        var rqty = $('#rqty').val();
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/calculate_barcode",
            type: "POST",
            data: {itemid,rqty},
            success: function(response)
            {
                 $('#pastbarcode').val(response);
            }
        });
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/calculate_barcode1",
            type: "POST",
            data: {itemid,rqty},
            success: function(response)
            {
                 $('#myIframe1').html(response);
            }
        });
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/calculate_barcode2",
            type: "POST",
            data: {itemid,rqty},
            success: function(response)
            {
                 $('#myIframe2').html(response);
            }
        });
    }
     // });

    function existingBatch() {
        $('#newBatch').css('display', 'none');
        $('#newBatch').attr('disabled', true);
        $('#newBatchA').css('display', 'block');
        $('#existingBatch').css('display', 'block');
        $('#existingBatchA').css('display', 'none');
        $('#existingBatch').attr('disabled', false);
    }

    function newBatch() {
        $('#newBatch').css('display', 'block');
        $('#newBatchA').css('display', 'none');
        $('#existingBatch').css('display', 'none');
        $('#existingBatchA').css('display', 'block');
        $('#newBatch').attr('disabled', false);
        $('#existingBatch').attr('disabled', true);
    }
</script>

<script>
    function selectProduct(val)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/getItemDetailsById1",
            type: "POST",
            data: {val},
            success: function(response)
            {
                var itemName = response.trim();
                $('#tags').val(itemName);
                getReceivable(val);
            }
        });
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/getItemDetailsById2",
            type: "POST",
            data: {val},
            success: function(response)
            {
                // var itemid = response.trim();
                $('#itemId').val(val);
                //getReceivable(val);
            }
        });
    }
    $('#tags').keyup(function(){
        var tags = $('#tags').val();
        $.ajax({
            url: '<?php echo URLROOT; ?>/pages/getTheItems1',
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
    function selectProductvname(val)
    {
        document.getElementById("vname_id").value = val.id;
        document.getElementById("vname").value = val.name;
        // document.getElementById("bill_address").value = val.address;
           
    }
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