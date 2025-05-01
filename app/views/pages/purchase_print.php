<!DOCTYPE html>
<html lang="en">
    <head>
       <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Olian is a bootstrap minimal & clean admin template">
    <meta name="keywords" content="inventory, art of living inventory, art of living, art, living">
    <meta name="author" content="Themesbox17">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Art_of_living Inventory</title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="<?php echo URLROOT;?>/assets/images/favicon.ico">
    <!-- Start css -->
    <!-- Switchery css -->
    <link href="<?php echo URLROOT;?>/assets/plugins/switchery/switchery.min.css" rel="stylesheet">
    <!-- Apex css -->
    <link href="<?php echo URLROOT;?>/assets/plugins/apexcharts/apexcharts.css" rel="stylesheet">
    <!-- Slick css -->
    <link href="<?php echo URLROOT;?>/assets/plugins/slick/slick.css" rel="stylesheet">
    <link href="<?php echo URLROOT;?>/assets/plugins/slick/slick-theme.css" rel="stylesheet">
    <link href="<?php echo URLROOT;?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo URLROOT;?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo URLROOT;?>/assets/css/flag-icon.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo URLROOT;?>/assets/css/style.css" rel="stylesheet" type="text/css">
    <!-- End css -->
    <!-- Select2 css -->
    <link href="<?php echo URLROOT;?>/assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body style="background: white;margin-top: 50px;">
<?php $pur = $data['pur'];?>
<?php $d = new Page;  ?>

<div class="container">
<div class="col-12">
    <div class="row">
        <div class="col-md-6"> <img width="100" height="auto" src="<?php echo URLROOT;?>/assets/images/art3.png" alt="logo"></div>
        <div class="col-md-6" style="text-align: right;"><h4>PURCHASE ORDER</h4><h5><?php echo $pur->purchase_order;?></h5></div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <?php $ven = $d->get_vendor_by_id($pur->vendor_id) ?>
            <h6>Vendor Address</h6>
            <p><?php echo $ven->attension;?><br>
            <?php echo $ven->street1;?><br>
            <?php echo $ven->street2;?><br>
            <?php echo $ven->city;?><br>
            <?php echo $ven->state;?><br>
            <?php echo $ven->country;?><br>
            <?php echo $ven->zipcode;?><br>
            <?php echo "Phone: ".$ven->phoneAdd;?><br>
            </p>
        </div>
        <div class="col-md-6" ></div>
    </div>
    <div class="row">
        <div class="col-md-6" >
            <h6>Deliver To</h6>
            <p style="width: 100px;">
                <?php echo $pur->deliver_to;?>
            </p>
        </div>
        <div class="col-md-6" style="text-align: right;">    
            <div class="row">
                <div class="col">
                    <h6>
                    Shipment preference :
                    <br>Date :
                    <br>Delivery Date :
                    <br>Ref# :
                    </h6>    
                </div>
                <div class="col" >
                <?php echo $pur->shipment_preference;?>
                <br><?php echo date('d-m-Y h:i:s a',strtotime($pur->ndate));?>
                <br><?php echo date('d-m-Y h:i:s a',strtotime($pur->expected_delivery_date));?>
                <br><?php echo $pur->reference;?>
                </div>
            </div>
        </div>
    </div>
</div> 
<br>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="text-align: left;padding-left: 50px;">Product</th>
                                <th style="text-align: left;padding-left: 50px;">Quantity</th>
                                <th>Unit Cost</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $product = explode("|", $pur->product);
                            $qty = explode("|", $pur->qty);
                            $price = explode("|", $pur->price);
                            $total = explode("|", $pur->total);
                            ?>

                            <?php for ($i=0; $i < sizeof($product) ; $i++) { ?>
                                <tr>
                                    <td><?php echo $i+1;?></td>
                                    <td><?php echo $product[$i];?></td>
                                    <td><?php echo $qty[$i];?></td>
                                    <td><?php echo $price[$i];?></td>
                                    <td><?php echo $total[$i];?></td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br><br>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col">
                            <h6>Sub-total:</h6>
                            <h6>Total:</h6>
                        </div>
                        <div class="col">
                            <h6>&nbsp;&nbsp;₹<?php echo $pur->sub_total;?></h6>
                            <h6>&nbsp;&nbsp;₹<?php echo $pur->total_amount;?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
      <!--   <div class="hidden-print">
            <div class="pull-right">
                <a href="<?php echo URLROOT;?>/receptions/print_invoice/" class="btn btn-success"><i class="fa fa-print"></i> &nbsp;Print</a>
            </div>
        </div> -->
    </div>
</div>
</div>
</body>
</html>
<script type="text/javascript">
    window.print();
    var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) {
                console.log('before print dialog open');
            } else {
                window.location.replace('<?php echo URLROOT; ?>/pages/purchase_order');
            }
        });
</script>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>