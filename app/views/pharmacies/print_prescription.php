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
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->

    </head>
    <style type="text/css">
        @media print
        {
            .pagebreak { page-break-before: always; } /* page-break-after works, as well */
        }
    </style>
<?php
        foreach ($data['logo'] as $key2)
        {
            $logo = $key2->client_logo;
            $client_name = $key2->client_name;
            $client_add = $key2->client_address;
            $client_email = $key2->client_email;
            $client_phone = $key2->client_phone;
        }
        foreach ($data['opd'] as $key3)
        {   
        	$visit_id = $key3->opd_visit_id;
        	$p_id = $key3->opd_patient_id;
        	$visit_date = $key3->visit_date_time;
        	$opc = $key3->opd_present_condition;
            $d_id = $key3->opd_doctor_id;
            $oe = $key3->opd_examination;
            $oi = $key3->opd_investigation;
            $on = $key3->opd_notes;
            $od = $key3->opd_diagnosis;
            $op = $key3->opd_prescription;
            $pres = explode('$$', $op);
            $pres0 = $pres[0];
            $pres0 = explode(',', $pres0);
            $pres1 = $pres[1];
            $pres1 = explode(',', $pres1);//unit
            $oins = $key3->opd_instruction;
            $ota = $key3->opd_test_advised;
            $ofd = $key3->opd_followup_date;
            $proc = explode('$&$x', $key3->opd_prescription_procedure);
            $length = sizeof($proc);
            unset($proc[$length-1]);
        }
       

        $rec_obj = new Pharmacies;
        $pat_data = $rec_obj->get_patients_data_to_print($p_id);

        foreach ($pat_data as $pat) 
        {
            $reg_date = $pat->age_update_time;
            $dob = $pat->patient_dob;
            $age = $pat->patient_age;
        }

        foreach ($data['patient_name'] as $key2)
        {
            $p_name = explode('|', $key2->patient_name);
        }

        foreach ($data['doc_name'] as $key3)
        {
            $d_name = explode('|', $key3->doctor_name);
        }


?>
<div class="wraper container-fluid print">
                <div class="page-title"> 
                    <center><h3 class="title"><b>PRESCRIPTION</b></h3></center>
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
                                              <strong>Patient Name: </strong> <?php echo ucwords($p_name[0]);?><br>
                                              <strong>Patient ID: </strong> <?php echo $p_id;?><br>
                                              <strong>Age: </strong>
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
                                            ?><br>
                                              <strong>Visit ID: </strong> <?php echo $visit_id;?><br>
                                              <strong>Doctor Name: </strong> Dr. <?php echo ucwords($d_name[0]);?><br>
                                              <strong>Doctor ID: </strong> <?php echo ucwords($d_id);?><br>
                                              <!-- 795 Folsom Ave, Suite 600<br>
                                              San Francisco, CA 94107<br>
                                              <abbr title="Phone">P:</abbr> (123) 456-7890 -->
                                              </address>
                                        </div>
                                        <div class="pull-right m-t-30">
                                            <p><strong>Visit Date: </strong> <?php echo date('d-m-Y', strtotime($visit_date));?></p>
                                            <!-- <p class="m-t-10"><strong>Order ID: </strong> #123456</p> -->
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="m-h-50"></div>
                                <?php if(!empty($opc) OR !empty($oe) OR !empty($oi) OR !empty($on) OR !empty($od)) { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-30">
                                            	<h3>Observation</h3>
                                                <tbody>
                                                    <?php if(!empty($opc)) { ?>
                                                   	<tr>
                                                   		<td style="text-align: left;"><b>Present Condition:</b> <?php echo ucwords($opc);?> </td>
                                                   	</tr>
                                                    <?php } if(!empty($oe)) { ?>
                                                   	<tr>
                                                   		<td style="text-align: left;"><b>Examination:</b> <?php echo ucwords($oe);?> </td>
                                                   	</tr>
                                                    <?php } if(!empty($oi)) { ?>
                                                   	<tr>
                                                   		<td style="text-align: left;"><b>Investigation:</b> <?php echo ucwords($oi);?></td>
                                                   	</tr>
                                                    <?php } if(!empty($on)) { ?>
                                                   	<tr>
                                                   		<td style="text-align: left;"><b>Notes: </b><?php echo ucwords($on);?> </td>
                                                   	</tr>
                                                    <?php } if(!empty($od)) { ?>
                                                   	<tr>
                                                   		<td style="text-align: left;"><b>Diagnosis: </b><?php echo ucwords($od);?> </td>
                                                   	</tr>
                                                    <?php } ?>
                                                   	<tr><td></td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="pagebreak"> </div>
                                <br><br>
                                <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-30">
                                            	<h3>Prescription</h3>
                                                <thead>
                                                    <tr>
                                                    	<th style="text-align: left;">Medicine Name</th>
                                                    	<th style="text-align: left;">Dosage</th>
                                                    	<th style="text-align: left;">Duration</th>
	                                                </tr>
	                                            </thead>
                                                <tbody>
                                                                <?php
                                                                for ($i=0; $i < count($pres0 ) ; $i++) 
                                                                { 
                                                                ?>  
                                                                <tr>
                                                                    <td style="text-align: left;"><?php 
                                                                    $withoutId = explode('(', $pres0[$i]);
                                                                        echo ucwords($withoutId[0]);
                                                                    ?><br>
                                                                    <?php if($pres1[$i] > 1 ) { ?>    
                                                                        <small>(Units: <?php echo $pres1[$i];?>)</small>
                                                                    <?php } else { ?>
                                                                        <small>(Unit: <?php echo $pres1[$i];?>)</small>
                                                                    <?php } ?>
                                                                    </td>
                                                                    <td style="text-align: left;">
                                                                        <?php
                                                                            $pr = explode(',', $proc[$i]);
                                                                            $len = sizeof($pr);
                                                                            $prin = '';
                                                                            $day = '';
                                                                            for($k=0;$k<$len/4;$k++)
                                                                            {
                                                                            for ($j=$k; $j < $len;$j=$j+$len/4) 
                                                                            { 
                                                                                $prin .= $pr[$j];
                                                                                $prin .= ',';
                                                                            }
                                                                            $prin = explode(',', $prin);
                                                                            if($prin[2] == "Not Specified") {
                                                                              echo $prin[1],' &bull; ',$prin[3];
                                                                            }
                                                                            else{
                                                                              echo $prin[1],' &bull; ',$prin[2],' &bull; ',$prin[3];
                                                                            }
                                                                            
                                                                            $day .= $prin[0];
                                                                            $day .= ','; 
                                                                            $prin = '';
                                                                            ?><br><?php
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                    <td style="text-align: left">
                                                                        <?php 
                                                                            $day = explode(',', $day);
                                                                            $leng = sizeof($day);
                                                                            unset($day[$leng-1]);
                                                                            for ($n=0; $n < sizeof($day); $n++)
                                                                            { 
                                                                                if($day[$n] == 1)
                                                                                {
                                                                                    echo $day[$n];
                                                                                    echo " day";
                                                                                }
                                                                                else
                                                                                {
                                                                                    echo $day[$n];
                                                                                    echo " days";
                                                                                }
                                                                                echo "<br>";
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                               <?php } ?>
                                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php if(!empty($oins)) { ?>
                                    <div class="col-md-12">
                                    	<h3>Instructions</h3>
                                    	<p><?php echo ucwords($oins);?></p>
                                    </div>
                                    <?php } if(!empty($ota)) { ?>
                                    <div class="col-md-12">
                                        <h3>Test Advised</h3>
                                        <p><?php echo ucwords($ota);?></p>
                                    </div>
                                    <?php } if(!empty($ofd)) { ?>
                                    <div class="col-md-12">
                                        <h3>Follow Up</h3>
                                        <p><?php echo date('d-m-Y', strtotime($ofd));?></p>
                                    </div>
                                    <?php } ?>

                                    <!-- <div class="col-md-12">
                                    	<h3>Co - Morbidities</h3>
                                    	<p></p>
                                    </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <script type="text/javascript">
        window.print();
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) {
                console.log('before print dialog open');
            } else {
                history.back();
            }
        });
    </script>