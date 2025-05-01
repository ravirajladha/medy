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
        foreach ($data['ipd'] as $key)
        {
        	$visit_id = $key->ipd_admit_id;
        	$p_id = $key->ipd_patient_id;
        	$visit_date = $key->admission_date_time;
        	$opc = $key->ipd_initial_condition;
        	$oe = $key->ipd_first_examination;
        	$oi = $key->ipd_first_investigation;
        	$on = $key->ipd_initial_notes;
        	$od = $key->ipd_first_diagnosis;
        	$oins = $key->ipd_initial_instruction;
        	$ota = $key->ipd_initial_test_advised;
        }

        foreach ($data['patient_name'] as $key2)
        {
            $p_name = $key2->patient_name;
        }

        foreach ($data['doc_name'] as $key3)
        {
            $d_name = $key3->doctor_name;
        }


?>
<div class="wraper container-fluid print">
	<div class="page-title"> 
		<h3 class="title">Prescription</h3>
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
								<h4><b><address>
									Patient Name &nbsp;:&nbsp; <?php echo ucwords($p_name);?><br>
									Patient ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; <?php echo $p_id;?><br>
									Visit ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; <?php echo $visit_id;?><br>
									Doctor Name &nbsp;&nbsp;:&nbsp; <?php echo ucwords($d_name);?><br>
									
									</address></b></h4>
							</div>
							<div class="pull-right m-t-30">
								<h4><b><p>Visit Date: <?php echo $visit_date;?></p></b></h4>
								<!-- <p class="m-t-10"><strong>Order ID: </strong> #123456</p> -->
							</div>
						</div>
					</div>
					
					
					
					
				
					<div class="col-md-12">
							<div class="table-responsive">
								<table class="table m-t-30">
									<h4><b>Prescription</b></h4>
									<thead>
										<tr>
											<th style="text-align: left;"><h4>Medicine Name</h4></th>
											<th style="text-align: left;"><h4> Dosage</h4></th>
											<th style="text-align: left;"><h4> Duration / Unit </h4></th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($data['all_ipd'] as $key)
										{
										$pres = $key->ipd_day_prescription;

										if($pres != NULL)
										{
										$proc = $key->ipd_day_procedure;
										$pres = explode('$$', $pres);
										$proc = explode('$&$x', $proc);
										$medi = explode(',', $pres[0]);
										$units = explode(',', $pres[1]);
										for ($r=0; $r < sizeof($medi); $r++)
										{ 
										$proc2 = explode(',', $proc[$r]);
										$name_without_id = explode('|', $medi[$r]);
										?>
										<tr>
										<td style="text-align: left;">
											<h5>
											<?php echo $name_without_id[0];?>
											</h5>
											</td>
										<td style="text-align: left;">
											<?php
											for ($l=0; $l < sizeof($proc2)/4 ; $l++)
											{ 
												for ($k=$l, $j=0; $k < sizeof($proc2); $k = $k + sizeof($proc2)/4, $j++)
												{ 
												if($j == 0)
												{
													if($l != 0)
													{
													echo "<hr>";
													}
													echo "<b>Days - </b>".$proc2[$k];
													echo " | ";
												}
												if($j == 1)
												{
													echo "<b>Qty - </b>".$proc2[$k];
													echo "<br>";
												}
												if($j == 2)
												{
													echo "<b>Food Manner - </b>";
													echo $proc2[$k];
													echo " | ";
												}
												if($j == 3)
												{
													echo "<b>Timings - </b>";
													echo $proc2[$k];
												}
												}
											}
											?>
										</td>
										<td style="text-align: left;">
											<h5>
											<?php echo $units[$r];?> Units</td>
											</h5>
										</tr>
										<?php } } } ?>
									</tbody>
								</table>
							</div>
						</div>
							<div class="pagebreak"> </div>
						<div class="col-md-12">
							<h4><b> Instructions</b></h4>
							<!-- <p><?php //echo $oins;?></p> -->
							<h4 style="padding-left: 100px;"><u>Test Advised: <br><br></u>
							
							
							<?php foreach($data['reports'] as $k)
							{ ?>

							<p style="padding-left: 30px;">

							<?php echo "* ".ucwords($k->report_title); ?></p>
							<?php } ?>
							</h4>
							<br>
						</div>

					

						<div class="col-md-12">
							<h4><b>Co - Morbidities</b></h4>
							<div style="padding-left: 100px;">
							<?php
								foreach ($data['comorb'] as $e)
								{
									?><hr><h4>1.<u>Hypertension:</u></h4><?php

									?><h4 style="padding-left: 50px;"> <?php echo $e->hypertension; ?></h4><hr><?php

									?><h4>2.<u>Diabetes Mellitus:</u></h4><?php

									?><h4 style="padding-left: 50px;"> <?php echo $e->diabetes; ?></h4><hr><?php
									
									?><h4>3.<u>Coronary Artery Disease: </u></h4><?php
									
									?><h4 style="padding-left: 50px;"> <?php echo $e->coronary; ?></h4><hr><?php
									
									?><h4>4.<u>Cerebrovascular disease / Peripheral Vascular Disease: </u></h4><?php

									?><h4 style="padding-left: 50px;"> <?php echo $e->cerebro; ?></h4><hr><?php
									
									?><h4>5.<u>Dyslipidaemia: </u></h4><?php

									?><h4 style="padding-left: 50px;"> <?php echo $e->dyslipidaemia; ?></h4><hr><?php
									
									?><h4>6.<u>Hypothyroidism: </u></h4><?php

									?><h4 style="padding-left: 50px;"> <?php echo $e->hypothyroidism; ?></h4><hr><?php
									
									?><h4>7.<u>Other allergic/ chronic disorders: </u></h4><?php

									?><h4 style="padding-left: 50px;"> <?php echo $e->other; ?></h4><hr><?php
									
								}
							?>
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
                history.back();
            }
        });
    </script>