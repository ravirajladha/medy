<?php require APPROOT . '/views/inc/header.php'; ?>
<!-- Start Breadcrumbbar -->
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Sales Invoice</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <a href="<?php echo URLROOT; ?>/pages/add_sales_order"><button class="btn btn-primary">New</button>
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
                            <h5 class="card-title mb-0">All Sales Invoice</h5>
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
                                    <th>Sales Id</th>
                                    <th>Customer Name</th>
                                    <th>Expected Shipment Date</th>
                                    <th>Amount</th>
                                    <th>Invoice</th>
                                    <th style="width: 150px; display: none;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="allSales">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->



    <!-- Modal -->
    <div class="modal fade" id="exampleStandardModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleStandardModalLabel">Create</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Sales Order: </label>
                                    <label>#SO-000003</label>
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <label>: Not Packed</label>
                                    <label>: Not Shipped</label>
                                </div>
                                <div class="form-group">
                                    <label>Reference#</label>
                                    <input type="text" class="form-control" value="#SO-00003">
                                </div>

                                <div class="form-group">
                                    <label>Sales Order Date</label>
                                    <input type="date" class="form-control" value="2020-07-12">

                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <div class="modal-footer">
                    <a href="<?php echo URLROOT; ?>/pages/packed"><button type="button" class="btn btn-primary">Package</button></a>
                    <a href="<?php echo URLROOT; ?>/pages/packed"><button type="button" class="btn btn-primary">Shipment</button></a>
                    <a href="<?php echo URLROOT; ?>/pages/addinvoice"><button type="button" class="btn btn-primary">Convert to Invoice</button></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="processSaleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleLargeModalLabel">Sales Order - <span id="pid"></span></h5>
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
                            <a class="nav-link" id="pills-profile-tab-justified" data-toggle="pill" href="#pills-profile-justified" role="tab" aria-controls="pills-profile" aria-selected="false">Package</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab-justified" data-toggle="pill" href="#pills-contact-justified" role="tab" aria-controls="pills-contact" aria-selected="false">Invoice</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" id="pills-return-tab-justified" data-toggle="pill" href="#pills-return-justified" role="tab" aria-controls="pills-contact" aria-selected="false">Return & Cancellation</a>
                        </li> -->
                    </ul>
                    <div class="tab-pane fade show active" id="pills-home-justified" role="tabpanel" aria-labelledby="pills-home-tab-justified">
                        <p>No History</p>
                    </div>
                    <div class="tab-pane fade" id="pills-profile-justified" role="tabpanel" aria-labelledby="pills-profile-tab-justified">
                        <p>No package created yet! </p>
                    </div>
                    <div class="tab-pane fade" id="pills-contact-justified" role="tabpanel" aria-labelledby="pills-contact-tab-justified">
                        <p>No invoice generated yet!</p>
                    </div>
                    <div class="tab-pane fade" id="pills-return-justified" role="tabpanel" aria-labelledby="pills-return-tab-justified">
                        <p>No return received yet!</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="buttonArea">
                <!-- <a href="<?php //echo URLROOT ?>/pages/purchaseReceive"><button type="button" class="btn btn-info-rgba">Create Package</button></a>
                <a href="<?php //echo URLROOT ?>/pages/purchaseBill"><button type="button" class="btn btn-info-rgba">Create Invoice</button></a> -->
            </div>
        </div>
    </div>
</div>
<!-- End Contentbar -->
<?php require APPROOT . '/views/inc/footer.php'; ?>

<script type="text/javascript">
  $(document).ready(function()
    {
    var lim = 9;
    var off = 0;
    var inc = 0;
        $.ajax({
        type: "POST",
        url: '<?php echo URLROOT;?>/pages/getAllSales',
        data: {lim,off},
        cache: false,
        success:function(response)
        {
            $('#allSales').html(response);
        }
        });
        $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height())
        {
            lim = 10;
            $.ajax({
            type: "POST",
            url: '<?php echo URLROOT;?>/pages/getAllSales',
            data: {lim,inc},
            cache: false,
            success:function(response)
            { 
                inc++;
                $('#allSales').append(response);
            }
            });
        }
    });
    });
</script>

<script>
    function processModal(id)
    {
        $('#processSaleModal').modal('show');
        $('#pid').text(id);
          $('#buttonArea').html('<a href="<?php echo URLROOT ?>/pages/packageCreate/'+id+'"><button type="button" class="btn btn-info-rgba">Create Package</button></a><a href="<?php echo URLROOT ?>/pages/salesInvoice/'+id+'"><button type="button" class="btn btn-info-rgba">view Invoice</button></a>');
        // $('#buttonArea').html('<a href="<?php echo URLROOT ?>/pages/packageCreate/'+id+'"><button type="button" class="btn btn-info-rgba">Create Package</button></a><a href="<?php echo URLROOT ?>/pages/salesInvoice/'+id+'"><button type="button" class="btn btn-info-rgba">view Invoice</button></a><a href="<?php echo URLROOT ?>/pages/return_item/'+id+'"><button class="btn btn-info-rgba">Sales Return</button></a>');
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/processCreate",
            type: "POST",
            data: {
                id
            },
            success: function(response)
            {
                $('#pills-profile-justified').html(response);
            }
        });
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/createInvoice",
            type: "POST",
            data: {
                id
            },
            success: function(response1)
            {
                $('#pills-contact-justified').html(response1);
            }
        });
    }

    function updateShipment(sId)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/updateShipment",
            type: "POST",
            data: {
                sId
            },
            success: function(response)
            {
                processModal(sId);
            }
        });
    }
</script>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>