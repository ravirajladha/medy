<?php require APPROOT . '/views/inc/header.php'; ?>
<style>
    @media print
    {    
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
</style>
  <!-- Start Breadcrumbbar -->                    
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Non Purchase Order Details</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
            </div>                        
        </div>
    </div>          
</div>               
<!-- End Breadcrumbbar -->
<?php $b = $data['p_details'];?>
<?php $Page = new Page(); ?>
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
                           <!--  <h5 class="card-title mb-0"></h5> -->
                           <img width="150" height="auto" src="<?php echo URLROOT;?>/assets/images/art3.png" alt="logo">
                        </div>
                        <div class="col-6" >
                            <ul class="list-inline-group text-right mb-0 pl-0" >
                                <li class="list-inline-item">
                                        <div class="form-group mb-0 amount-spent-select" style="text-align: left;">
                                            <h4 class="mb-0">Non Purchase Order</h4>
                                        <label>Order NO: <?php echo $b->id;?></label>
                                        <?php $Page = new Page(); ?>
                                        
                                    </div>
                                </li>
                            </ul>                                        
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="col-md-4">
                            <label>Vendor Name: <?php echo ucwords($b->vendor);?></label>
                            </div>
                            <div class="col-md-4">
                            <label>Address: <?php $v = $Page->get_vendor_by_id($b->vendor_id);?><?php echo $v->attension. " " . $v->street1 . " " . $v->street2 . " " . $v->city . " " . $v->state . " " . $v->country . " " . $v->zipcode . " " . $v->phoneAdd . " " . $v->fax;?></label>
                            </div>
                                                        
                        </div>
                        <div class="col-md-4 pl-0">
                            <label>Order number:<?php echo $b->id;?></label>
                            <br>
                            <label>Date:<?php echo $b->receive_date;?></label>
                            <br>
                            <label style="color: black">Batch: <?php echo ucwords($b->batch);?></label>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>Item id</th>
                                        <th>Item Name</th>
                                        <th>Receivable</th>
                                        <th>Quantity Ordered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php $batch_wise = $Page->get_all_nonpurchase_order_details_find_batch($b->batch); ?>
                                    <?php foreach ($batch_wise as $k) { ?>
                                        <tr>
                                            <td><?php echo $k->item_id;?></td>
                                            <?php $item_name = $Page->getTheItemDetails($k->item_id); 
                                            ?>
                                            <?php $mm = $Page->get_model_name_by_id($item_name->model_id); ?>
                                            <td><?php echo "(".$mm->model_name.")".$item_name->name;?></td>
                                            <td><?php if($k->receivable==1){ echo "Box"; }elseif($k->receivable==3){ echo "Pieces"; } ?></td>
                                            <td><?php echo $k->qty_receive;?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <hr>
                   
                    <br>
                    <br>
                    <a class="btn btn-secondary pull-right no-print" href="<?php echo URLROOT;?>/pages/prfornonpurchase/<?php echo $data['id'];?>">PRINT</a>
                    <button class="btn btn-primary pull-right no-print" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i> Print A4</button>
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
        $('#buttonArea').html('<a href="<?php echo URLROOT ?>/pages/purchaseReceive/'+pId+'"><button type="button" class="btn btn-info-rgba">Purchase Receive</button></a>');

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
            url: "<?php echo URLROOT; ?>/pages/getTheBillsForModal",
            type: "POST",
            data: {pId},
            success: function(response1)
            {
                $('#pills-profile-justified').html(response1);
            }
        });
    }
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
