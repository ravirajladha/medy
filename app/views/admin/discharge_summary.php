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

        foreach ($data['ipd'] as $value)
        {
            $admit_id = $value->ipd_admit_id;
            $patient_id = $value->ipd_patient_id;
            $doctor_id = $value->ipd_doctor_id;
            $doa = $value->admission_date_time;
            $dod = $value->discharge_date_time;
        }

        $recep_object = new Admin;
        $all_patient_details = $recep_object->get_all_patient_details($patient_id);
        $patient_name = $recep_object->get_patient_name_only($patient_id);
        $doctor_name = $recep_object->get_doctor_name_only($doctor_id);
        $doctor_spec = $recep_object->get_doctor_spec_only($doctor_id);

        foreach ($all_patient_details as $pat)
        {
            $address = $pat->patient_address;
            $age = $pat->patient_age;
            $dob = $pat->patient_dob;
            $pat_h = $pat->patient_history;
            $pat_fh = $pat->family_history;
            $ph = $pat->patient_phone;
        }
?>
            <div class="wraper container-fluid print">
                <div class="page-title"> 
                    <center><h3 class="title"><b>DISCHARGE SUMMARY</b></h3></center>
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
                                    <div class="col-md-10">
                                        <div class="pull-left m-t-30">
                                            <address>
                                              <strong>Patient Name: </strong> <?php echo ucwords($patient_name); ?> <br>
                                              <strong>Patient Age: </strong> <?php echo ucwords($age); ?> <br>
                                               <strong>Patient DOB: </strong> <?php echo $dob; ?> <br>
                                               <strong>Patient Phone Number: </strong> <?php echo $ph; ?> <br>

                                              <strong>Patient ID: </strong> <?php echo $patient_id; ?> <br>
                                              <strong>Admit ID: </strong> <?php echo $admit_id; ?> <br>
                                              <strong>Consultant Doctor: </strong> <?php echo ucwords($doctor_name); ?> <br>
                                              <!-- 795 Folsom Ave, Suite 600<br>
                                              San Francisco, CA 94107<br>
                                              <abbr title="Phone">P:</abbr> (123) 456-7890 -->
                                              </address>
                                        </div>
                                    
                                        <div class="pull-right m-t-30">
                                            
                                            <p> <strong>DOA:</strong>
                                                <?php echo $doa;?>
                                                <br>
                                                <strong>DOD:</strong>
                                                <?php
                                                if(empty($dod))
                                                    echo "not yet discharge";
                                                else
                                                    echo $dod;
                                                ?>
                                            </p>
                                            <p><strong>Address: </strong> 
                                            <?php $address = explode(',', $address);
                                                for ($i=0; $i < sizeof($address); $i++)
                                                { 
                                                    echo $address[$i];
                                                    echo "<br>";
                                                }
                                            ?></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="m-h-50">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <u><h3>Past History :</h3>
                                            </u><p>
                                            <strong>
                                                Patient History: <?php echo $pat_h;?>
                                                <br>
                                                Patient Family History: <?php echo $pat_fh; ?>
                                            </strong>
                                            </p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="m-h-50"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-30">
                                               <!-- <h3>Initial Condition</h3> -->

                                                <thead>
                                                    <tr>
                                                        <th style="text-align: left;">Initial Condition</th>
                                                        <th style="text-align: left;">First Diagnosis</th>
                                                        <th style="text-align: left;">Final Diagnosis

                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($data['ipd'] as $k) {
                                                    ?>
                                                    <tr>
                                                        <td style="text-align: left;"><?php echo ucwords($k->ipd_initial_condition); ?></td>
                                                        <td style="text-align: left;"><?php echo ucwords($k->ipd_first_diagnosis); ?></td>  
                                                        <td style="text-align: left;"><?php 
                                                        $a='';
                                                            foreach ($data['ipd_days_data'] as $gg) {  $a=$gg->ipd_day_diagnosis;
                                                                    }
                                                        echo ucwords($a);
                                                            
                                                         ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                               <!--  <div class="pagebreak"> </div> -->
                                <br><br>
                                <p>
                                    <u><h3>Patient Daywise Summary :</h3></u>
                                </p>
                                <div class="col-md-12">
                                        <div class="table-responsive">
                                            <?php
                                                        foreach ($data['ipd_days_data'] as $test) { 
                                                             $op = $test->ipd_day_prescription;
                                                             ?>
                                            <table class="table m-t-30">
                                               <h3>Date: <?php echo date('d-m-Y', strtotime($test->ipd_day_val)); ?></h3>
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: left;">Condition</th>
                                                        <th style="text-align: left;">Examination</th>
                                                        <th style="text-align: left;">Investigation</th>
                                                        <th style="text-align: left;">Diagnosis</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    <tr>
                                                        <td style="text-align: left;"><?php echo ucwords($test->ipd_day_condition); ?></td>
                                                        <td style="text-align: left;"><?php echo ucwords($test->ipd_day_examination); ?></td>
                                                        <td style="text-align: left;"><?php echo ucwords($test->ipd_day_investigation); ?></td>
                                                        <td style="text-align: left;"><?php echo ucwords($test->ipd_day_diagnosis); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table m-t-30">
                                                <?php 
                                                 if($op != NULL)
                                                    {
                                                        if($op != "$$")
                                                        {
                                                ?>
                                               <h4>Medicines</h4>
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: left;">Medicine Name</th>
                                                        <th style="text-align: left;">Dosage</th>
                                                        <th style="text-align: left;">Duration</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                                <?php
                                                                    $pres = explode('$$', $op);
                                                                    $pres0 = $pres[0];
                                                                    $pres0 = explode(',', $pres0);
                                                                    $pres1 = $pres[1];
                                                                    $pres1 = explode(',', $pres1);
                                                                    $proc = explode('$&$x', $test->ipd_day_procedure);
                                                                 for ($i=0; $i < count($pres0) ; $i++) 
                                                                { 
                                                                ?>  
                                                                <tr>
                                                                    <td style="text-align: left;"><?php $withoutId = explode('(', $pres0[$i]);
                                                                        echo ucwords($withoutId[0]);
                                                                    ?><br>
                                                                    <?php if($withoutId[1] > 1 ) { ?>    
                                                                        <small>(Units: <?php echo $withoutId[1];?>)</small>
                                                                    <?php } else { ?>
                                                                        <small>Unit: <?php echo $withoutId[1];?></small>
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
                                                               <?php } } } } ?>
                                                            </tbody>
                                            </table>
                                        </div><hr style="border:1px solid lightgray;">
                                    </div>

                                <div class="col-md-12">
                                    <div class="row">
                                       
                                            <div class="col-md-6">
                                            <p><strong>
                                            Review as advised with <?php echo ucwords($doctor_name);?> with prior appointment.
                                            </strong>
                                            </p>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <br><br><br><br><strong>
                                                <p style="float: right;">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ucwords($doctor_name);?>
                                                   <br>
                                                 <?php echo "( ".ucwords($doctor_spec)." )";?>
                                                  
                                                 </p></strong>
                                            </div>
                                        
                                </div><br><hr style="border:1px solid ;">
                                    </div>
                                </div>
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
                window.location.replace('<?php echo URLROOT; ?>/admin/view_profile_patient/<?php echo $patient_id; ?>');
            }
        });
</script>