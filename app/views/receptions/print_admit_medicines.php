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
        }

        $recep_object = new Receptions;
        $patient_name = $recep_object->get_patient_name_only($patient_id);
        $doctor_name = $recep_object->get_doctor_name_only($doctor_id);
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
                                              <strong>Patient Name: </strong> <?php echo ucwords($patient_name); ?> <br>
                                              <strong>Patient ID: </strong> <?php echo $patient_id; ?> <br>
                                              <strong>Admit ID: </strong> <?php echo $admit_id; ?> <br>
                                              <strong>Doctor Name: </strong> Dr. <?php echo ucwords($doctor_name); ?> <br>
                                              <!-- 795 Folsom Ave, Suite 600<br>
                                              San Francisco, CA 94107<br>
                                              <abbr title="Phone">P:</abbr> (123) 456-7890 -->
                                              </address>
                                        </div>
                                        <!-- <div class="pull-right m-t-30">
                                            <p><strong>Visit Date: </strong> </p>
                                            <p class="m-t-10"><strong>Order ID: </strong> #123456</p>
                                        </div> -->
                                    </div>
                                </div>
                                
                                <div class="m-h-50"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                            foreach ($data['ipd_days'] as $key) {
                                                $op = $key->ipd_day_prescription;
                                                if($op != NULL)
                                                {
                                                    if($op != "$$")
                                                    {
                                                        $pres = explode('$$', $op);
                                                        $pres0 = $pres[0];
                                                        $pres0 = explode(',', $pres0);
                                                        $pres1 = $pres[1];
                                                        $pres1 = explode(',', $pres1);
                                                        $proc = explode('$&$x', $key->ipd_day_procedure);
                                                
                                            ?>
                                        <div class="table-responsive">
                                            <h3>Date: <?php echo date('d-m-Y', strtotime($key->ipd_day_val)); ?></h3>
                                            <table class="table m-t-30">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: left;">Medicine Name</th>
                                                        <th style="text-align: left;">Dosage</th>
                                                        <th style="text-align: left;">Duration</th>
                                                    </tr>
                                                </thead>
                                               
                                                <tbody>
                                                    <?php for ($i=0; $i < count($pres0) ; $i++) 
                                                                { 
                                                                ?>  
                                                                <tr>
                                                                    <td style="text-align: left;"><?php $withoutId = explode('(', $pres0[$i]);
                                                                        echo ucwords($withoutId[0]);
                                                                    ?><br>
                                                                    <?php if($withoutId[1] > 1 ) { ?>    
                                                                        <small>(Units: <?php echo $withoutId[1];?></small>
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
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                        <hr>
                                        <div class="pagebreak"> </div>
                                        <?php } } } ?>
                                    </div>
                                </div>
                                <!-- 
                                <br><br>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table m-t-30">
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <script type="text/javascript">
        window.print();
    </script>