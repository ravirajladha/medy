<?php require APPROOT . '/views/inc/header.php'; ?>
  <!-- Start Breadcrumbbar -->                    
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Purchase Order</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                    
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                    <a href="<?php echo URLROOT;?>/pages/add_purchase_order"><button class="btn btn-primary">New</button>
                    </a>
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
                            <h5 class="card-title mb-0">All Purchase Orders</h5>
                        </div>
                        <div class="col-6">
                            <ul class="list-inline-group text-right mb-0 pl-0">
                                <li class="list-inline-item">
                                        <div class="form-group mb-0 amount-spent-select">
                                        <select class="form-control" id="formControlSelect">
                                            <option>All</option>
                                            <option>Last Week</option>
                                            <option>Last Month</option>
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
                                    <th>PO ID</th>
                                    <th>Vendor Name</th>
                                    <th>Date</th>
                                    <!-- <th>Status</th>
                                    <th>Received</th>
                                    <th>Billed</th>
                                    <th>Amount</th> -->
                                    <th style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="allPo">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="processModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleLargeModalLabel">Purchase Order - <span id="pid"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="pills-tab-justifiedContent">
                    <ul class="nav nav-tabs nav-justified mb-3" id="pills-tab-justified" role="tablist">
                        <!-- <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab-justified" data-toggle="pill" href="#pills-home-justified" role="tab" aria-controls="pills-home" aria-selected="true">Process History</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab-justified" data-toggle="pill" href="#pills-profile-justified" role="tab" aria-controls="pills-profile" aria-selected="false">Billed</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab-justified" data-toggle="pill" href="#pills-contact-justified" role="tab" aria-controls="pills-contact" aria-selected="false">Received</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-unbox-tab-justified" data-toggle="pill" href="#pills-unbox-justified" role="tab" aria-controls="pills-qr" aria-selected="false">Unbox</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-qr-tab-justified" data-toggle="pill" href="#pills-qr-justified" role="tab" aria-controls="pills-qr" aria-selected="false">QR Print</a>
                        </li>
                    </ul>
                    <div class="tab-pane fade show active" id="pills-home-justified" role="tabpanel" aria-labelledby="pills-home-tab-justified">
                        <p>No History</p>
                    </div>
                    <div class="tab-pane fade" id="pills-profile-justified" role="tabpanel" aria-labelledby="pills-profile-tab-justified">
                        <p>No bills generated! </p>
                    </div>
                    <div class="tab-pane fade" id="pills-contact-justified" role="tabpanel" aria-labelledby="pills-contact-tab-justified">
                        <p>No item received yet!</p>
                    </div>

                    <div class="tab-pane fade" id="pills-unbox-justified" role="tabpanel" aria-labelledby="pills-unbox-tab-justified">

                    </div>
                    <div class="tab-pane fade" id="pills-qr-justified" role="tabpanel" aria-labelledby="pills-qr-tab-justified">
                        <p>No item received yet!</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="buttonArea">
                <a href="<?php echo URLROOT ?>/pages/purchaseReceive"><button type="button" class="btn btn-info-rgba">Purchase Receive</button></a>
                <!-- <a href="<?php echo URLROOT ?>/pages/purchaseBill"><button type="button" class="btn btn-primary-rgba">Purchase Bill</button></a> -->
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">

                swal("<?php echo $_SESSION['success']; ?>");
    </script>
  <?php } unset($_SESSION['success']); ?>  

<script type="text/javascript">
function idpassforpaid(arg1, arg2, arg3, arg4) 
{
    var x1 = arg1;
    var y1 = arg2;
    var z1 = arg3;
    var x2 = arg4;
    document.getElementById('get_id1').value = x1;
    document.getElementById('get_price1').value = y1;
    document.getElementById('get_price2').value = z1;
    document.getElementById('get_price3').value = x2;
}
</script>  

</div>
</div>
<script type="text/javascript">
  $(document).ready(function()
    {
    var lim = 9;
    var off = 0;
    var inc = 0;
        $.ajax({
        type: "POST",
        url: '<?php echo URLROOT;?>/pages/getAllPo',
        data: {lim,off},
        cache: false,
        success:function(response)
        {
            $('#allPo').html(response);
        }
        });
        $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height())
        {
            lim = 10;
            $.ajax({
            type: "POST",
            url: '<?php echo URLROOT;?>/pages/getAllPo',
            data: {lim,inc},
            cache: false,
            success:function(response)
            { 
                inc++;
                $('#allPo').append(response);
            }
            });
        }
    });
    });
</script>

<script>
    function processPurchaseOrderModal(pId)
    {
        $('#pid').text(pId);
        $('#processModal').modal('show');
        $('#buttonArea').html('<a href="<?php echo URLROOT ?>/pages/purchaseReceive/'+pId+'"><button type="button" class="btn btn-info-rgba">Purchase Receive</button></a> <a href="<?php echo URLROOT ?>/pages/purchase_order_details1/'+pId+'"><button type="button" class="btn btn-info-rgba">Order Details</button></a>');
// <a href="<?php //echo URLROOT ?>/pages/purchaseBill/'+pId+'"><button type="button" class="btn btn-info-rgba">Purchase Bill</button></a>
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/getReceivedDetails",
            type: "POST",
            data: {pId},
            success: function(response)
            {
                $('#pills-contact-justified').html(response);
            }
        });
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/getReceivedDetails_for_qr",
            type: "POST",
            data: {pId},
            success: function(response)
            {
                $('#pills-qr-justified').html(response);
            }
        });
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/getReceivedDetails_for_unbox",
            type: "POST",
            data: {pId},
            success: function(response)
            {
                $('#pills-unbox-justified').html(response);
            }
        });


        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/getTheBillsForModal",
            type: "POST",
            data: {pId},
            success: function(response1)
            {
                $('#pills-profile-justified').html(response1);
            }
        });
    }
    function get_data_tomodal(temp_qr) 
    {
        $('#processModal').modal('hide');
        $('#exampleStandardModal').modal('show');
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/getunbox_data_tomodal",
            type: "POST",
            data: {temp_qr},
            success: function (response) 
            {
                $('#modal_body_data').html(response);   
            }
        });
        
    }
    function convert_box_item_purchase(rid,$temp_for_qr) 
    {
        var stock_id = $('#stock_id').val();
        var stock_on_hand = $('#stock_on_hand').val();
        var item_qty = $('#item_qty').val();
        var pieces = $('#pieces').val();
        var item_id = $('#item_id').val();
        var id = rid;
        
         $.ajax({
            url: "<?php echo URLROOT; ?>/pages/convert_box_item_purchase",
            type: "POST",
            data: {stock_id,stock_on_hand,item_qty,pieces,item_id,id},
            success: function (response) 
            {
                swal(response); 
                // location.reload("<?php echo URLROOT;?>/pages/purchase_order");
                get_data_tomodal($temp_for_qr);  
            }
        });
    }
</script>


<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>

<div class="modal fade" id="exampleStandardModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
      
            <div class="modal-header">
                <h5 class="modal-title" id="exampleStandardModalLabel">Update Stock </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_body_data">
                
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
               
            </div>
        
        </div>
    </div>
</div>
