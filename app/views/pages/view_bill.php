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
            <h4 class="page-title">Bill</h4>
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
<?php $b = $data['single_bill'];?>
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
                                            <h2 class="mb-0">BILL</h2>
                                        <label>Bill NO: <?php echo $b->bill_id;?></label>
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
                                                        
                        </div>
                        <div class="col-md-4 pl-0">
                            <label>Order number:<?php echo $b->purchase_id;?></label>
                            <br>
                            <label>Bill Date:<?php echo $b->created_at;?></label>
                            <br>
                            <label>Receive ID:<?php echo $b->receive_id;?></label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>Item id</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Item Price</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $item_id = explode("|||", $b->item_id);
                                    $item_name = explode("|||", $b->item_name);
                                    $qty = explode("|||", $b->qty);
                                    $item_price = explode("|||", $b->item_price);
                                    ?>

                                    <?php for ($i=0; $i < sizeof($item_id) ; $i++) { ?>
                                        <tr>
                                            <td><?php echo $item_id[$i];?></td>
                                            <td><?php echo $item_name[$i];?></td>
                                            <td><?php echo $qty[$i];?></td>
                                            <td><?php echo $item_price[$i];?></td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                <div class="row clearfix" style="margin-top:20px">
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                      <table class="table table-bordered table-hover" id="tab_logic_total">
                        <tbody>
                          <tr>
                            <th class="text-center">Sub Total</th>
                            <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" value="<?php echo $b->item_total;?>" readonly/></td>
                          </tr>
                          
                          <tr>
                            <th class="text-center">Tax</th>
                            <td class="text-center"><div class="input-group mb-2 mb-sm-0">
                                <input type="number" name="tax" class="form-control" value="<?php echo $b->tax;?>" readonly placeholder="0" >
                                <div class="input-group-addon" ></div>
                              </div></td>
                          </tr>
                          <tr>
                            <th class="text-center">Tax Amount</th>
                            <td class="text-center"><input type="number" name='tax_amount'  placeholder='0.00' class="form-control" value="<?php echo $b->tax_amount;?>" readonly/></td>
                          </tr>
                          <tr >
                            <th class="text-center">Discount</th>
                            <td class="text-center"><div class="input-group mb-2 mb-sm-0">
                                <input type="text" name="discount" class="form-control" value="<?php echo $b->discount;?>" readonly placeholder="0" >

                              </div></td>
                          </tr>
                          <tr >
                            <th class="text-center">Discount Amount</th>
                            <td class="text-center"><input type="number" name='discount_amount'  placeholder='0.00' class="form-control" value="<?php echo $b->discount_amount;?>" readonly/></td>
                          </tr>
                          <tr>
                            <th class="text-center">Grand Total</th>
                            <td class="text-center"><input type="number" name='total_amount' value="<?php echo $b->grand_total;?>" readonly placeholder='0.00' class="form-control" /></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    </div>
                    <button class="btn btn-primary pull-right no-print" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
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
