<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="<?php echo URLROOT;?>/img/favicon.png">
        <!-- Google-Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,600,700,900,400italic' rel='stylesheet'>


        <!-- Bootstrap core CSS -->
        <link href="<?php echo URLROOT;?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo URLROOT;?>/css/bootstrap-reset.css" rel="stylesheet">

        <!--Animation css-->
        <link href="<?php echo URLROOT;?>/css/animate.css" rel="stylesheet">

        <!--Icon-fonts css-->
        <link href="<?php echo URLROOT;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo URLROOT;?>/assets/ionicon/css/ionicons.min.css" rel="stylesheet" />


        <!-- Custom styles for this template -->
        <link href="<?php echo URLROOT;?>/css/style.css" rel="stylesheet">
        <link href="<?php echo URLROOT;?>/css/helper.css" rel="stylesheet">
        <link href="<?php echo URLROOT;?>/css/style-responsive.css" rel="stylesheet" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->

    </head>
<?php
    foreach ($data['posts'] as $key)
    {
        $invoice_id = $key->invoice_id;
        $comany_name = $key->comany_name;
        $company_address = $key->company_address;
        $items = explode('|', $key->product_name);
        $it0 = $items[0];
        $qty = explode('|', $key->qunatity);
        $due = explode('|', $key->due_dates);
        $item_price = explode('|', $key->item_price);
        $buying_price = explode('|', $key->buying_price);
        $total = explode('|', $key->total);
        $quantity =$key->qunatity;
        $dis = $key->discount;
?>
<div class="wraper container-fluid">
                <div class="page-title"> 
                    <center><h3 class="title"><b>BILL</b></h3> </center>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <h4>Invoice</h4>
                            </div> -->
                            <div class="panel-body">
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <h4 class="text-right"><img src="<?php echo URLROOT;?>/img/logo.png" alt="velonic"></h4>
                                 
                                    </div>
                                    <div class="pull-right">
                                        <h4>Bill #<br>
                                            <strong><?php echo $invoice_id; ?></strong>
                                        </h4>
                                    </div>
                                    <div class="pull-left" style="padding-left: 10px;">
                                        <h3 class="">Admin<!-- <?php echo $client_name; ?> --></h3>
                                        <h5><!-- <?php echo $client_add;?> --></h5>
                                        <h5><!-- <?php echo $client_email;?> | <?php echo $client_phone;?> --></h5>
                                    </div>
                                    <div class="pull-right">
                                        <h4> <br>
                                            <strong></strong>
                                        </h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div class="pull-left m-t-30">
                                            <address>
                                              <strong>Company Name:</strong> <?php echo ucwords($comany_name);?><br>
                                              <strong>Company Address:</strong><?php echo ucwords($company_address);?><br>
                                              <!-- 795 Folsom Ave, Suite 600<br>
                                              San Francisco, CA 94107<br>
                                              <abbr title="Phone">P:</abbr> (123) 456-7890 -->
                                              </address>
                                        </div>
                                        <div class="pull-right m-t-30">
                                            <p><strong>Invoice Date:</strong> <?php echo date('d-m-Y', strtotime($key->created_at))?></p>
                                           <!--  <p class="m-t-10"><strong>Order Status: </strong> <span class="label label-warning">Pending</span></p>
                                            <p class="m-t-10"><strong>Order ID: </strong> #123456</p> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="m-h-50"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-30">
                                                <thead>
                                                    <tr><th>ITEM</th>
                                                    <th>QTY</th>
                                                    <th>Due Dates</th>
                                                    <th>ITEM PRICE</th>
                                                    <th>BUYING PRICE</th>
                                                    <th>TOTAL</th>
                                                    
                                                   
                                                </tr></thead>
                                                <tbody>
                                                    <?php
                                                for ($i=0; $i < count($items) ; $i++) 
                                                { 
                                                ?> 

                                                    <tr>
                                                        <td> <?php echo $items[$i]?> </td>
                                                        <td> <?php echo 
                                                    $qty[$i];?> </td>
                                                    <td> <?php echo 
                                                    $due[$i];?> </td>
                                                        <td> <?php echo $item_price[$i];?></td>
                                                        <td> <?php echo $buying_price[$i];?> </td>
                                                        <td> <?php echo $total[$i];?> </td>
                                                                                                            </tr>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="border-radius: 0px;">
                                    <div class="col-md-3 col-md-offset-9">
                                        <p class="text-right"><b>Sub-total:</b> &nbsp;&nbsp;₹ <?php echo $key->sub_total;?> </p>
                                       
                                        <p class="text-right"><b>Discount:</b> &nbsp;&nbsp;₹<?php echo $dis ?> 
                                            
                                        </p>
                                        <hr>
                                        <h3 class="text-right"><b>Grand Total:</b> &nbsp;&nbsp;₹ <?php echo $key->grand_total;?></h3>
                                    </div>
                                </div>
                               
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-30">
                                                <thead>
                                                    <tr>
                                                    <th>GST</th>
                                                    <th>DISCOUNT</th>
                                                    <th>TRANSPORT MODE</th>
                                                    <th>PAYMENT TERMS</th>
                                                    <th>ITEM EXPECTED DATE</th>
                                                    <th>ITEM DELIVERY ADDTRESS</th>
                                                    
                                                   
                                                   
                                                </tr></thead>
                                                <tbody>
                                                   
                                                    <tr>
                                                        <td> <?php echo $key->gst;?> </td>
                                                        <td> <?php echo $key->discount;?> </td>

                                                        <td> <?php echo $key->delivery_mode;?> </td>
                                                        <td> <?php echo $key->payment_tems;?></td>
                                                        <td> <?php echo $key->item_expected_date;?> </td>
                                                        <td> <?php echo $key->item_delivery_address;?> </td>
                                                    </tr>

                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row" style="border-radius: 0px;">
                                    <div class="col-md-3 col-md-offset-9">
                                        <hr>
                                        <h3 class="text-right"><b style="color: red">*</b></h3>
                                        <hr>
                                    </div>
                                </div>
                                <div class="hidden-print">
                                    <div class="pull-right">
                                        <a href="<?php echo URLROOT;?>/pharmacies/print_invoice/<?php echo $invoice_id;?>" class="btn btn-success">Print &nbsp;&nbsp;<i class="fa fa-print"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       
    <script type="text/javascript">
        window.print();
    </script>