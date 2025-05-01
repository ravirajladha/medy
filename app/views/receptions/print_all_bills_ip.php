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
        
        <style>
             @media print {
            .pagebreak { page-break-before: always; } /* page-break-after works, as well */
        </style>
    </head>
    <body>
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

<div class="container">
            <!-- <center>
                <?php
                        
                echo "<b>FINAL ALL BILLS</b>";
                       
                ?>
            </center>  -->      

                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                            <div class="">
                                <div class="">
                                    <br>
                                    <table>
                                        <thead>
                                            <th class="col-md-4">
                                                <?php
                                                    if($logo)
                                                    {
                                                        ?>
                                                        <img width="100" height="100" src="<?php echo URLROOT;?>/service_detail/<?php echo $logo;?>" alt="velonic">
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                        <img src="<?php echo URLROOT;?>/img/logo.png" alt="velonic">
                                                <?php } ?>
                                            </th>
                                            <th width="50">
                                                
                                            </th>
                                            <th>
                                                <h3 class=""><?php echo $client_name; ?></h3>
                                                <h5><?php echo $client_add;?></h5>
                                                <h5><?php echo $client_email;?> | <?php echo $client_phone;?></h5>
                                            </th>
                                        </thead>
                                    </table>
                                    
                                    <center>
                                        <h3 class="title">
                                        FINAL ALL BILLS
                                        </h3>
                                    </center>
                                    
                                    <div class="pull-right">
                                        <h4>IP Admission #<br>
                                            <strong> IP<?php echo $data['admission_id'];?></strong>
                                        </h4>
                                    </div>

                                </div>
                                
                                <br>
                                <br>
                                <hr>
                                <?php 
                                $bill_count = 1;
                                foreach ($data['last_inv'] as $key)
                                {
                                    
                                    $inv_item = $key->invoice_item;
                                    $inv_item = explode(',', $inv_item);
                                    $inv_item_len = (sizeof($inv_item)-1)/4;
                                    $invoice_bill = $key->invoice_bill;
                                    $invoice_total = $key->invoice_total;
                                    $amount_paid = $key->amount_paid;
                                    $advance_pay = $key->advance_pay;
                                    $payment = $key->invoice_pay;
                                    $patient = explode('|', $key->invoice_name);
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
                                
                                <?php
                                if($bill_count != 1)
                                {
                                ?>
                                <br>
                                <?php
                                }
                                ?>
                                
                                <div class="row">
                                    
                                    <div class="container">
                                        <table>
                                            <tbody>
                                                <td>
                                                    <h5><strong>Transaction No: <?php echo $bill_count;?></strong></h5>
                                                    <h4><strong>Bill No: </strong># <?php echo $key->invoice_id;?></h4><br>
                                                    <strong>Bill Date: </strong><?php echo date('d-m-Y', strtotime($invoice_date));?><br>

                                                    <?php
                                                        if($onlyID == "ip" || $onlyID == "IP") 
                                                          {

                                                    ?>
                                                    <strong>Admission Date: </strong>
                                                            <?php echo date('d-m-Y h:i A', strtotime($admissionDischarge->admission_date_time));?>
                                                            <?php if($admissionDischarge->discharge_date_time != NULL) {?><br>
                                                    <strong>Discharged Date: </strong>
                                                            <?php echo date('d-m-Y h:i A', strtotime($admissionDischarge->discharge_date_time));?>
                                                    <?php } } ?>
                                                    
                                                    <br>
                                                    
                                                    <strong>Patient Name: </strong><?php echo ucwords($patient[0]);?><br>
                                                    <strong>Patient Id: </strong><?php echo ucwords($patient[1]);?><br>
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
                                                    <strong>Doctor Name: </strong>Dr <?php echo ucwords($doctor_name[0]);?>
                                                </td>

                                                
                                                
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive table-bordered">
                                            <table class="table ">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th style="text-align: left;padding-left: 50px;">Service</th>
                                                        <th style="text-align: left;padding-left: 50px;">Quantity</th>
                                                        <th>Unit Cost</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($t=0; $t < $inv_item_len; $t++) {  ?>
                                                    <tr>
                                                        <td><?php echo $t+1;?></td>
                                                        <td style="text-align: left; padding-left: 50px;"><?php echo $inv_item[($t*4)+2]?></td>
                                                        <td style="text-align: left; padding-left: 50px;"><?php echo $inv_item[($t*4)+1];?></td>
                                                        <td>&nbsp;<?php echo $inv_item[($t*4)+3];?></td>
                                                        <td><?php echo ($inv_item[($t*4)+1]) * ($inv_item[($t*4)+3]);?></td>
                                                    </tr>
                                                <?php } ?> 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row container" style="border-radius: 0px;">
                                    
                                    <div class="col-md-3 col-md-offset-9">
                                        <p class="text-right"><b>Sub-total:</b> &nbsp;&nbsp;₹ <?php echo $key->invoice_bill;?></p>
                                        <?php if($invoice_bill - $invoice_total != 0) { ?>
                                        <p class="text-right" style="padding-right: 7px;"><b>
                                            <?php if($dis != NULL) { ?>
                                            Discount:</b> &nbsp;&nbsp;₹ <?php echo $invoice_bill - $invoice_total; } ?>
                                        </p>
                                        <?php } ?>
                                        
                                        <?php if($amount_paid - $advance_pay != 0) { ?>
                                        
                                        <p class="text-right"><b>Advance Paid:</b> &nbsp;&nbsp;₹ <?php echo $advance_pay;?></p>
                                        
                                        <?php }else{  ?>
                                        
                                        <p class="text-right"><b>Paid:</b> &nbsp;&nbsp;₹ <?php echo $advance_pay;?></p>
                                        
                                        <?php } ?>
                                        
                                       
                                        
                                         <p class="text-right" style="padding-right: 7px;"><b>Total amount paid:</b> &nbsp;&nbsp;₹ <?php echo $amount_paid - $advance_pay;?>
                                        </p>
                                        
                                        <p class="text-right"><b>Balance:</b> &nbsp;&nbsp;₹ <?php echo $invoice_total - $amount_paid;?></p>
                                        
                                        
                                        <?php if($invoice_total - $amount_paid != 0) { ?>
                                        <p class="text-right" style="padding-right: 7px;"><b>Balance:</b> &nbsp;&nbsp;₹ <?php echo $invoice_total - $amount_paid ; ?>
                                        <?php } ?>
                                        </p>
                                        <h3 class="text-right">₹ <?php echo $amount_paid - $advance_pay;?></h3>
                                    </div>
                                    
                                    <div class="">
                                        <div class="pull-left">
                                            <a  class="text">&nbsp;<strong>Payment Mode: <?php if(!empty($payment)){ echo $payment; }?></strong></a><br>
                                            &nbsp;<small>Powered By <b>MedHike</b></small>
                                        </div>
                                    </div>
                                
                                </div>
                                
                                
                                
                                
                                    
                                    <div style="border-bottom:1px solid black;padding-bottom:15px;">
                                    
                                </div>
                                
                                
                                
                                <div class="pagebreak"></div>  
                                
                                <?php 
                                  $bill_count++; 
                                }
                                ?>
                                
                                
                            </div>
                        </div>
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
                window.location.replace('<?php echo URLROOT; ?>/receptions/all_admissions');
            }
        });
</script>