<?php require APPROOT .'/views/inc_pharmacy/header.php'; ?>
<?php
    foreach ($data['logo'] as $key2)
    {
        $logo = $key2->client_logo;
        $client_name = $key2->client_name;
        $client_add = $key2->client_address;
        $client_email = $key2->client_email;
        $client_phone = $key2->client_phone;
    }
    foreach ($data['invoice'] as $key)
    {
        $invoice_id = $key->invoice_id;
        $invoice_name = $key->invoice_name;
        $invoice_doctor = $key->invoice_doctor;
        $items = $key->invoice_items;
        $batch = $key->items_batch;
        $dis = $key->discount;
        $inv_total = $key->invoice_total;
        $total = "";
        $tot = 0;
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
                                        <?php
                                        if($logo)
                                        {
                                            ?>
                                            <h4 class="text-right"><img width="100" height="100" src="<?php echo URLROOT;?>/service_detail/<?php echo $logo;?>" alt="velonic"></h4>
                                            <?php
                                        }
                                        else
                                        {
                                        ?>
                                        <h4 class="text-right"><img src="<?php echo URLROOT;?>/img/logo.png" alt="velonic"></h4>
                                    <?php } ?>
                                    </div>
                                    <div class="pull-right">
                                        <h4>Bill #<br>
                                            <strong><?php echo $invoice_id; ?></strong>
                                        </h4>
                                    </div>
                                    <div class="pull-left" style="padding-left: 10px;">
                                        <h3 class=""><?php echo $client_name; ?></h3>
                                        <h5><?php echo $client_add;?></h5>
                                        <h5><?php echo $client_email;?> | <?php echo $client_phone;?></h5>
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
                                              <strong>Patient Name:</strong> <?php echo ucwords($invoice_name);?><br>
                                              <strong>Doctor Name:</strong> Dr. <?php echo ucwords($invoice_doctor);?><br>
                                              <!-- 795 Folsom Ave, Suite 600<br>
                                              San Francisco, CA 94107<br>
                                              <abbr title="Phone">P:</abbr> (123) 456-7890 -->
                                              </address>
                                        </div>
                                        <div class="pull-right m-t-30">
                                            <p><strong>Invoice Date:</strong> <?php echo date('d-m-Y', strtotime($key->invoice_date_time))?></p>
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
                                                    <th>MFR</th>
                                                    <th>BATCH</th>
                                                    <th>EXP</th>
                                                    <th>COST</th>
                                                    <th>CGST</th>
                                                    <th>SGST</th>
                                                    <th>TOTAL</th>
                                                </tr></thead>
                                                <tbody>
                                                    <?php
                                                        $item1 = explode(',', $items);
                                                        $batch1 = explode(',', $batch);
                                                        for ($i=0,$j=0,$k=1; $i < sizeof($batch1) ; $i++,$j = $j+2,$k = $k+2)
                                                        { 
                                                            $manf = new Pharmacies;
                                                            $manf_name = $manf->get_manf_name($item1[$j]);

                                                            $stock_details = $manf->get_stock_detail($batch1[$i]);
                                                            foreach ($stock_details as $value)
                                                            {
                                                                $drug_name = $manf->get_dname_name($value->drug_id);
                                                                
                                                                $exp = $value->stock_expiry;
                                                                $txb_amt = $value->drug_taxable_amount;
                                                                $sell = $value->drug_sell_cost;
                                                                $gst = ($sell - $txb_amt)/2;
                                                                $cgst = $value->drug_cgst;
                                                                $sgst = $value->drug_sgst;
                                                            }
                                                    ?>
                                                    <tr>
                                                        <!-- <td> <?php //echo $item1[$j].$drug_name->drug_name;?> </td> -->
                                                        <td> <?php echo $drug_name->drug_name;?> </td>
                                                        <td> <?php echo $item1[$k];?> </td>
                                                        <td> <?php echo ucwords(substr($manf_name->drug_manufacturer, 0,4));?></td>
                                                        <td> <?php echo ucwords($batch1[$i]);?> </td>
                                                        <td> <?php echo $exp;?> </td>
                                                        <td> <?php echo $txb_amt;?> </td>
                                                        <td> <?php echo $gst;?> </td>
                                                        <td> <?php echo $gst;?> </td>
                                                        <td> <?php echo ($txb_amt + $gst + $gst) * $item1[$k];?> </td>
                                                    </tr>

                                                    <?php
                                                    $total = ($txb_amt + $gst + $gst) * $item1[$k];
                                                    $tot = $tot + $total;
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="border-radius: 0px;">
                                    <div class="col-md-3 col-md-offset-9">
                                        <p class="text-right"><b>Sub-total:</b> &nbsp;&nbsp;₹<?php echo $tot;?> </p>
                                        <?php if($dis != NUll) { ?>
                                        <p class="text-right"><b>Discount:</b> &nbsp;&nbsp;₹<?php echo $dis ?> 
                                            
                                        </p><?php } ?>
                                        <hr>
                                        <h3 class="text-right">₹ <?php echo $inv_total;?></h3>
                                    </div>
                                </div>
                               
                                <hr>
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
        <?php } ?>
<?php require APPROOT .'/views/inc_pharmacy/footer.php'; ?>