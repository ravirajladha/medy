<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<?php
    if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']))
    {
        redirect('users/login');
    }
?>
<?php
        foreach ($data['logo'] as $key2)
        {
            $logo = $key2->client_logo;
            $client_name = $key2->client_name;
            $client_add = $key2->client_address;
            $client_email = $key2->client_email;
            $client_phone = $key2->client_phone;
        } 



        $rec_obj = new Receptions;

?>
<div class="wraper container-fluid">
                <div class="page-title"> 
                    <center><h3 class="title">
                        <?php
                        
                                echo "<b>FINAL ALL BILLS</b>";
                       
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
                                        <h4>IP Admission #<br>
                                            <strong> IP<?php echo $data['admission_id'];?></strong>
                                        </h4>
                                    </div>
                                </div>
                                <hr>

                                
                                <?php 
                                $bill_count = 1;
                                foreach ($data['last_inv'] as $key)
                                {
                                    
                                    $inv_item_new = $key->invoice_item;
                                    $inv_item_new = explode(',', $inv_item_new);
                                    $inv_item_len_new = (sizeof($inv_item_new)-1)/4;
                                    $invoice_bill_new = $key->invoice_bill;
                                    $invoice_total_new = $key->invoice_total;
                                    $amount_paid_new = $key->amount_paid;
                                    $advance_pay_new = $key->advance_pay;
                                    $payment_new = $key->invoice_pay;
                                    $patient_name = explode('|', $key->invoice_name);
                                    $ipop_id = $key->opip_id;
                                    $onlyID = substr($ipop_id,0,2);
                                    $doctor_name = explode('|', $key->invoice_doctor);
                                    $invoice_date = $key->invoice_date;
                                    
                                    
                                    $ppid = explode('|', $key->invoice_name);
                                    $ppid = trim($ppid[1]);
                                    $ipop_id1 = $pp->opip_id;
                                    $onlyID1 = substr($ipop_id1,0,2);
                                    $onlyID2 = substr($ipop_id1,2);
                                    
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
                                ?>
                                
                                
                                <h5><strong>Transaction No: <?php echo $bill_count; ?></strong>
                                   
                                </h5>
                                
                                <h4>
                                    <strong>Bill No </strong> &nbsp;
                                    # <?php echo $key->invoice_id;?>
                                </h4>
                                    
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
                                            </strong> IP<?php echo $data['admission_id'];?><br>
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
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="m-h-50"></div>
                                
                                    
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive table-bordered">
                                                <table class="table m-t-30">
                                                    <thead>
                                                        <tr><th>#</th>
                                                        <th style="text-align: left;padding-left: 50px;">Service</th>
                                                        <th style="text-align: left;padding-left: 50px;">Quantity</th>
                                                        <th>Unit Cost</th>
                                                    </tr></thead>
                                                    <tbody>
                                                        <?php for ($t=0; $t < $inv_item_len_new; $t++) {  ?>
                                                        <tr>
                                                            <td><?php echo $t+1;?></td>
                                                            <td style="text-align: left; padding-left: 50px;"><?php echo $inv_item_new[($t*4)+2]?></td>
                                                            <td style="text-align: left; padding-left: 50px;"><?php echo $inv_item_new[($t*4)+1];?></td>
                                                            <td>&nbsp;<?php echo $inv_item_new[($t*4)+3];?></td>
                                                        </tr>
                                                    <?php } ?> 
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <br>
                                    <br>
                                    <div class="row" style="border-radius: 0px;">
                                    <div class="col-md-3 col-md-offset-9">
                                        <p class="text-right"><b>Sub-total:</b> &nbsp;&nbsp;₹ <?php echo $key->invoice_bill;?></p>
                                        <?php if($invoice_bill_new - $invoice_total_new != 0) { ?>
                                        <p class="text-right" style="padding-right: 7px;"><b>
                                            <?php if($dis != NULL) { ?>
                                            Discount:</b> &nbsp;&nbsp;₹ <?php echo $invoice_bill_new - $invoice_total_new; } ?>
                                        </p>
                                        <?php } ?>
                                        
                                        <?php if($amount_paid_new - $advance_pay_new != 0) { ?>
                                        
                                        <p class="text-right"><b>Advance Paid:</b> &nbsp;&nbsp;₹ <?php echo $advance_pay_new;?></p>
                                        
                                        <?php }else{  ?>
                                        
                                        <p class="text-right"><b>Paid:</b> &nbsp;&nbsp;₹ <?php echo $advance_pay_new;?></p>
                                        
                                        <?php } ?>
                                        
                                       
                                        
                                         <p class="text-right" style="padding-right: 7px;"><b>Total amount paid:</b> &nbsp;&nbsp;₹ <?php echo $amount_paid_new - $advance_pay_new;?>
                                        </p>
                                        
                                         <p class="text-right"><b>Balance:</b> &nbsp;&nbsp;₹ <?php echo $invoice_total_new - $amount_paid_new;?></p>
                                         
                                        <?php if($invoice_total_new - $amount_paid_new != 0) { ?>
                                        <p class="text-right" style="padding-right: 7px;"><b>Balance:</b> &nbsp;&nbsp;₹ <?php echo $invoice_total_new - $amount_paid_new ; ?>
                                        <?php } ?>
                                        </p>
                                        <hr>
                                        <h3 class="text-right">₹ <?php echo $amount_paid_new - $advance_pay_new;?></h3>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="hidden-print" >
                                     <div class="">
                                        <a  class="text" >&nbsp;<strong>Payment Mode: <?php if(!empty($payment_new)){ echo $payment_new; }?></strong></a>
                                    </div>
                                </div>
                                <div style="border-bottom:1px solid black;padding-bottom:15px;">
                                    
                                </div>
                                
                                
                                <br>
                                    
                                    <!--<hr>-->

                                        
                                <?php
                                $bill_count++;
                                }
                                ?> 
                                  
                                  
                                
 
                                

                                <div class="hidden-print">
                                     
                                    <div class="pull-right">
                                        <a href="<?php echo URLROOT;?>/receptions/print_all_bills_ip/<?php echo $data['admission_id'];?>" class="btn btn-success"><i class="fa fa-print"></i> &nbsp;Print</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php require APPROOT .'/views/inc_reception/footer.php'; ?>

