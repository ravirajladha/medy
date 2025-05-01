<?php require APPROOT . '/views/inc/header.php';?>
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Sales Package Shipment</h4>
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
        <form action="<?php echo URLROOT; ?>/pages/shipmentCreate/<?php echo $data['sp_id'];?>" method="POST">
        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header bg-primary-rgba">
                    <h5 class="card-title text-primary">Sales ID - <?php echo $data['id'] ?></h5>
                </div>
                <br>
                <div class="row container">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Shipment Date</label>
                            <input type="date" class="form-control" name="shippingDate">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Shipment Carrier</label>
                            <input type="text" class="form-control" name="shipCarrier">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Tracking</label>
                            <input type="text" class="form-control" name="tracking">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Shipping Charges</label>
                            <input type="number" class="form-control" name="shippingCharges">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Notes</label>
                            <textarea class="form-control" name="shippingNotes"></textarea>
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