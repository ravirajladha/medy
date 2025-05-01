<?php require APPROOT .'/views/inc_admin/header.php'; ?>
<?php
        foreach ($data['logo'] as $key2)
        {
            $logo = $key2->client_logo;
            $client_name = $key2->client_name;
            $client_add = $key2->client_address;
            $client_email = $key2->client_email;
            $client_phone = $key2->client_phone;
        } 

        foreach ($data['last_inv'] as $pp)
        {
            $ppid = explode('|', $pp->invoice_name);
            $ppid = trim($ppid[1]);
            $ipop_id1 = $pp->opip_id;
            $onlyID1 = substr($ipop_id1,0,2);
            $onlyID2 = substr($ipop_id1,2);
        }

        $rec_obj = new Admin;
        $pat_data = $rec_obj->get_patients_data_to_print($ppid);
        if($onlyID1 == 'ip' || $onlyID1 = 'IP')
        {
            $admissionDischarge = $rec_obj->getIpdDetails($onlyID2);
        }

        foreach ($pat_data as $pat) 
        {
            $reg_date = $pat->age_update_time;
            $dob = $pat->patient_dob;
            $age = $pat->patient_age;
        }

        foreach ($data['last_inv'] as $key)
        {
            $i = 1;
            $invoice_id = $key->invoice_id;
            $inv_item = $key->invoice_item;
            $inv_item = explode(',', $inv_item);
            $inv_item_len = (sizeof($inv_item)-1)/4;
            $patient_name = explode('|', $key->invoice_name);
            $invoice_date = $key->invoice_date;
            $doctor_name = explode('|', $key->invoice_doctor);
            $ipop_id = $key->opip_id;
            $onlyID = substr($ipop_id,0,2);
            $invoice_bill = $key->invoice_bill;
            $invoice_total = $key->invoice_total;
            $dis = $key->invoice_discount;
            $amount_paid = $key->amount_paid;
            $payment = $key->invoice_pay;
            $invoice_status = $key->invoice_status;
?>
<div class="wraper container-fluid">
                <div class="page-title"> 
                    <center><h3 class="title">
                        <?php
                        if($invoice_status == "saved")
                        {
                            echo "<b>ACKNOWLEDGEMENT</b>";
                        }
                        else
                        {
                            if($onlyID == "ip" || $onlyID == "IP") 
                            { 
                                echo "<b>FINAL BILL</b>";
                            }
                            else
                            {
                                echo "<b>BILL</b>";
                            }
                        }
                        ?>
                    </h3></center>
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
                                    <div class="pull-left" style="padding-left: 10px;">
                                        <h3 class=""><?php echo $client_name; ?></h3>
                                        <h5><?php echo $client_add;?></h5>
                                        <h5><?php echo $client_email;?> | <?php echo $client_phone;?></h5>
                                    </div>
                                    <div class="pull-right">
                                        <h4>Bill #<br>
                                            <strong><?php echo $invoice_id;?></strong>
                                        </h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div class="pull-left m-t-30">
                                            <address>
                                              <strong>Patient Name: </strong><?php echo ucwords($patient_name[0]);?><br>
                                              <strong>Patient ID : </strong><?php echo $patient_name[1];?><br>
                                              <strong>
                                              <?php 
                                                  if($onlyID == "op" || $onlyID == "OP")
                                                  {  
                                                        echo "VISIT ID:";
                                                  }  
                                                  elseif($onlyID == "ip" || $onlyID == "IP") 
                                                  {
                                                        echo "ADMIT ID:";
                                                  }
                                                  else
                                                  { 
                                                        echo "VISIT/ADMIT ID:";
                                                  } 
                                              ?>
                                          </strong><?php echo $ipop_id;?><br>
                                              <strong>Age : </strong>
                                              <?php
                                                $curr_yr = date('Y-m-d');
                                                if($dob != "0000-00-00")
                                                {
                                                    $diff = abs(strtotime($curr_yr) - strtotime($dob));
                                                    $years = floor($diff / (365*60*60*24));
                                                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
                                                    if($years > 1)
                                                    {
                                                        echo $years;
                                                        echo " years ";
                                                    }
                                                    else
                                                    {
                                                        if($years != 0)
                                                        {
                                                            echo $years;
                                                            echo " year ";
                                                        }
                                                    }
                                                    if($years < 1)
                                                    {
                                                        if($months > 1)
                                                        {
                                                            echo $months;
                                                            echo " months";
                                                        }
                                                        else
                                                        {
                                                            if($months != 0)
                                                            {
                                                                echo $months;
                                                                echo " month";
                                                            }
                                                            else
                                                            {
                                                                if($days > 0)
                                                                {
                                                                    echo $days;
                                                                    echo " days";
                                                                }
                                                                else
                                                                {
                                                                    echo $days;
                                                                    echo " day";
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    $au_year = date('Y', strtotime($reg_date));
                                                    $c_year = date('Y');
                                                    $age = $age + ($c_year - $au_year);
                                                    if($age > 1)
                                                    {
                                                        echo $age;
                                                        echo " years";
                                                    }
                                                    else
                                                    {
                                                        echo $age;
                                                        echo " year";
                                                    }
                                                }
                                            ?>
                                              <br>
                                              <strong>Doctor Name: </strong>Dr <?php echo ucwords($doctor_name[0]);?><br>
                                              <!-- 795 Folsom Ave, Suite 600<br>
                                              San Francisco, CA 94107<br>
                                              <abbr title="Phone">P:</abbr> (123) 456-7890 -->
                                              </address>
                                        </div>
                                        <div class="pull-right m-t-30">
                                            <p><strong>Bill Date: </strong><?php echo date('d-m-Y', strtotime($invoice_date));?></p>

                                            <?php
                                                if($onlyID == "ip" || $onlyID == "IP") 
                                                  {

                                            ?>
                                            <p>
                                                <strong>Admission Date: </strong>
                                                    <?php echo date('d-m-Y h:i A', strtotime($admissionDischarge->admission_date_time));?>
                                            </p>
                                                <?php if($admissionDischarge->discharge_date_time != NULL) {?>
                                            <p>
                                                <strong>Discharged Date: </strong>
                                                    <?php echo date('d-m-Y h:i A', strtotime($admissionDischarge->discharge_date_time));?>
                                            </p>
                                            <?php } } ?>
                                            <!-- <p class="m-t-10"><strong>Order Status: </strong> <span class="label label-warning">Pending</span></p>
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
                                                    <tr><th>#</th>
                                                    <th style="text-align: left;padding-left: 50px;">Service</th>
                                                    <th style="text-align: left;padding-left: 50px;">Quantity</th>
                                                    <th>Unit Cost</th>
                                                </tr></thead>
                                                <tbody>
                                                    <?php for ($t=0; $t < $inv_item_len; $t++) {  ?>
                                                    <tr>
                                                        <td><?php echo $t+1;?></td>
                                                        <td style="text-align: left; padding-left: 50px;"><?php echo $inv_item[($t*4)+2]?></td>
                                                        <td style="text-align: left; padding-left: 50px;"><?php echo $inv_item[($t*4)+1];?></td>
                                                        <td>&nbsp;<?php echo $inv_item[($t*4)+3];?></td>
                                                    </tr>
                                                <?php } ?> 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="border-radius: 0px;">
                                    <div class="col-md-3 col-md-offset-9">
                                        <p class="text-right"><b>Sub-total:</b> &nbsp;&nbsp;₹ <?php echo $key->invoice_bill;?></p>
                                        <?php if($invoice_bill - $invoice_total != 0) { ?>
                                        <p class="text-right" style="padding-right: 7px;"><b>
                                            <?php if($dis != NULL) { ?>
                                            Discount:</b> &nbsp;&nbsp;₹ <?php echo $invoice_bill - $invoice_total; } ?>
                                        </p>
                                        <?php } ?>
                                         <p class="text-right" style="padding-right: 7px;"><b>Total amount paid:</b> &nbsp;&nbsp;₹ <?php echo $amount_paid; ?>
                                        </p>
                                        <?php if($invoice_total - $amount_paid != 0) { ?>
                                        <p class="text-right" style="padding-right: 7px;"><b>Balance:</b> &nbsp;&nbsp;₹ <?php echo $invoice_total - $amount_paid ; ?>
                                        <?php } ?>
                                        </p>
                                        <hr>
                                        <h3 class="text-right">₹ <?php echo $key->amount_paid;?></h3>
                                    </div>
                                </div>
                                <?php 
                                    $i++;
                                        }
                                ?>
                                <hr>
                                <div class="hidden-print">
                                     <div class="pull-left">
                                        <a  class="text">&nbsp;<strong>Payment Mode: <?php if(!empty($payment)){ echo $payment; }?></strong></a>
                                    </div>
                                </div>

                                <div class="hidden-print">
                                     
                                    <div class="pull-right">
                                        <a href="<?php echo URLROOT;?>/admin/print_invoice/<?php echo $invoice_id;?>" class="btn btn-success"><i class="fa fa-print"></i> &nbsp;Print</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php require APPROOT .'/views/inc_admin/footer.php'; ?>

