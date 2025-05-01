<?php require APPROOT . '/views/inc/header.php';?>
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Sales Order - Shipment</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
 <?php $tl = $data['ship_details']; ?>
<div class="contentbar">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <label>Transaction details</label>
                    <select class="form-control" onclick="categoryChange4(this.value)">
                        <?php foreach($data['all_transport_details'] as $k) { ?>
                            <option value="<?php echo $k->id; ?>" <?php if(($k->id)==($tl->id)){?> selected <?php }?> ><?php echo $k->name; ?></option>
                        <?php } ?>
                    </select>  
                </div>
            </div>
        </div>
    </div>
<br>
    <div class="row">
        <form action="<?php echo URLROOT; ?>/pages/shipmentCreate_for_stock_out/<?php echo $data['st_id'];?>" method="POST">
        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header bg-primary-rgba">
                    <h5 class="card-title text-primary">Sales Order ID - <?php echo $data['id'] ?></h5>
                    <?php $tid =  $data['p_all']; ?>
                </div>
                <br>
                <div class="row container">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Shipment Date</label>
                            <input type="date" class="form-control" name="shippingDate" value="<?php echo date('Y-m-d', strtotime($tid->ship_date)); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Shipment Carrier</label>
                            <input type="text" class="form-control" name="shipCarrier" id="tname" value="<?php echo $tid->ship_carrier; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">  
                        <div class="form-group">
                            <label for="">Tracking</label>
                            <input type="text" class="form-control" name="tracking" id="lrnumber" value="<?php echo $tid->tracking; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Shipping Charges</label>
                            <input type="number" class="form-control" name="shippingCharges" value="<?php echo $tid->shipping_charges; ?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Notes</label>
                            <textarea class="form-control" name="shippingNotes"  id="details"><?php echo $tid->notes; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-info" type="submit">Save</button>
                        <button class="btn btn-warning" >Cancel</button>
                    </div>
                </div>
                <br>
            </div>
        </div>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>
<script type="text/javascript">
    function categoryChange4(tranid)
    {
        var transaction_id = tranid;
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/transaction_details",
            type: "POST",
            data: {transaction_id},

            success: function(response)
            {   
                var s = JSON.parse(response);
                $('#tname').val(s.tname);
                $('#lrnumber').val(s.lrnumber);
                $('#details').val(s.details);
            }
        });
    }
</script>
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