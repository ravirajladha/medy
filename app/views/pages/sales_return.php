<?php require APPROOT . '/views/inc/header.php'; ?>
<!-- Start Breadcrumbbar -->
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Sales Orders</h4>
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
                            <h5 class="card-title mb-0">All Sales Order</h5>
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
                                    <th style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="">
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
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
