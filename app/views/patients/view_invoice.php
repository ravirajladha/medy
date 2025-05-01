<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<?php
        foreach ($data['last_inv'] as $key)
        {
            $i = 1;
            $invoice_id = $key->invoice_id;
            $invoice_item = $key->invoice_item;
            $invoice_name = explode(',', $invoice_item);
            $service_name = trim($invoice_name[2]);
            $service_qty = trim($invoice_name[1]);
            $service_id = trim($invoice_name[0]);
            $service_cost = trim($invoice_name[3]);
            $patient_name = $key->invoice_name;
            $invoice_date = $key->invoice_date;
            $doctor_name = $key->invoice_doctor;
            $ipop_id = $key->opip_id;
            $invoice_bill = $key->invoice_bill;
?>
<div class="wraper container-fluid">
                <div class="page-title"> 
                    <h3 class="title">Invoice</h3> 
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
                                        <h4>Invoice # <br>
                                            <strong><?php echo $invoice_id;?></strong>
                                        </h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div class="pull-left m-t-30">
                                            <address>
                                              <strong>Patient Name &nbsp;:&nbsp; </strong><?php echo strtoupper($patient_name);?><br>
                                              <strong>Visit ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; </strong><?php echo $ipop_id;?><br>
                                              <strong>Doctor Name &nbsp;&nbsp;:&nbsp; </strong><?php echo strtoupper($doctor_name);?><br>
                                              <!-- 795 Folsom Ave, Suite 600<br>
                                              San Francisco, CA 94107<br>
                                              <abbr title="Phone">P:</abbr> (123) 456-7890 -->
                                              </address>
                                        </div>
                                        <div class="pull-right m-t-30">
                                            <p><strong>Invoice Date: </strong><?php echo $invoice_date;?></p>
                                            <p class="m-t-10"><strong>Order Status: </strong> <span class="label label-warning">Pending</span></p>
                                            <p class="m-t-10"><strong>Order ID: </strong> #123456</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-h-50"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-30">
                                                <thead>
                                                    <tr><th>#</th>
                                                    <th>Service</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Cost</th>
                                                    <th>Total</th>
                                                </tr></thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $i?></td>
                                                        <td><?php echo $service_name.' | '.$service_id;?></td>
                                                        <td><?php echo $service_qty;?></td>
                                                        <td><i class="fa fa-rupee"></i>&nbsp;<?php echo $service_cost;?></td>
                                                        <td><i class="fa fa-rupee"></i>&nbsp;<?php echo $invoice_bill;?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="border-radius: 0px;">
                                    <div class="col-md-3 col-md-offset-9">
                                        <p class="text-right"><b>Sub-total:</b> <?php echo $key->invoice_total;?></p>
                                        <p class="text-right">Discount: 
                                            <?php if(isset($key->invoice_discount))
                                                    echo $key->invoice_discount;
                                                  else
                                                    echo " 0"?>%
                                        </p>
                                        <p class="text-right">VAT:
                                        </p>
                                        <hr>
                                        <h3 class="text-right">INR <?php echo $key->invoice_total;?>.00</h3>
                                    </div>
                                </div>
                                <?php 
                                    $i++;
                                        }
                                ?>
                                <hr>
                                <div class="hidden-print">
                                    <div class="pull-right">
                                        <a href="<?php echo URLROOT;?>/receptions/print_invoice" class="btn btn-inverse"><i class="fa fa-print"></i></a>
                                        <a href="#" class="btn btn-primary">Submit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php require APPROOT .'/views/inc_reception/footer.php'; ?>