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
        $rec_obj_model = new Reception;
       
		$invoice_related_to_general = $rec_obj_model->get_the_invoice_for_general($data['id']);
		$invoice_related_to_lab = $rec_obj_model->get_the_invoice_for_lab($data['id']);
		$invoice_related_to_pharm = $rec_obj_model->get_the_invoice_for_pharm($data['id']);

		foreach ($invoice_related_to_general as $pp)
        {
            $ppid = explode('|', $pp->invoice_name);
            $ppid = trim($ppid[1]);
            $ipop_id1 = $pp->opip_id;
            $onlyID1 = substr($ipop_id1,0,2);
            $onlyID2 = substr($ipop_id1,2);
			$invoice_id = $pp->invoice_id;
			$inv_item = $pp->invoice_item;
			$inv_item = explode(',', $inv_item);
			$inv_item_len = (sizeof($inv_item)-1)/4;
			$patient_name = explode('|', $pp->invoice_name);
			$invoice_date = $pp->invoice_date;
			$doctor_name = explode('|', $pp->invoice_doctor);
			$ipop_id = $pp->opip_id;
			$onlyID = substr($ipop_id,0,2);
			$invoice_bill = $pp->invoice_bill;
			$invoice_total = $pp->invoice_total;
			$dis = $pp->invoice_discount;
			$amount_paid = $pp->amount_paid;
			$advance_pay = $pp->advance_pay;
			$payment = $pp->invoice_pay;
			$invoice_status = $pp->invoice_status;
        }

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
		$alltotal = 0;
        
?>

<div class="container">
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
                                </div>
                                <div class="row">
                                    <br>
                                    <div class="container">
                                        <table>
                                            <tbody>
                                                <td>
													<strong>Patient Name: </strong><?php echo ucwords($patient_name[0]);?>(<?php echo $patient_name[1]?>)<br>
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
                                                <td width="300">
                                                    <center>	
                                                        <?php
                                                        if($invoice_status == "saved")
                                                        {
                                                            echo "<b>FINAL BILL</b>";
                                                        }
                                                        else
                                                        {
                                                            if($onlyID == "ip" || $onlyID == "IP") 
                                                            { 
                                                                echo "<b>FINAL BILL</b>";
                                                            }
                                                            else
                                                            {
                                                                echo "<b>FINAL BILL</b>";
                                                            }
                                                        }
                                                        ?>
                                                    </center>
                                                </td>
                                                <td>
                                                    <strong>Bill Number: </strong><?php echo $invoice_id;?><br>
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
                                                </td>
                                            </thead>
                                        </table>
                                    </div>
                                </div>    
								<br>
								<?php 
								$tt_gen = 0; 
									if($invoice_related_to_general)
									{
								?>
											<?php
											$i = 0;
											$sl_nu_array = array();
											$service_array = array();
											$qty_array = array();
											$unit_cost_array = array();
											$total_cost_array = array();
											$service_type_array = array();

											foreach ($invoice_related_to_general as $key)
											{
												
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
												$advance_pay = $key->advance_pay;
												$payment = $key->invoice_pay;
												$invoice_status = $key->invoice_status;
												$tt_gen_w = 0;
											?>
											<?php 
												for ($t=0; $t < $inv_item_len; $t++) 
												{  	
													$sl_nu_array[] 		= $invoice_date;
													$service_array[] 	= $inv_item[($t*4)+2];
													$qty_array[] 		= $inv_item[($t*4)+1];
													$unit_cost_array[] 	= $inv_item[($t*4)+3];
													$total_cost_array[] = ($inv_item[($t*4)+1]) * ($inv_item[($t*4)+3]);
													$service_type_array[] = $rec_obj_model->get_the_service_type_by_service_name($inv_item[($t*4)+2]);
															$tt_gen_w = ($inv_item[($t*4)+1]) * ($inv_item[($t*4)+3]);
														?>
											<?php } ?> 
											<?php 
												$tt_gen = $tt_gen + $tt_gen_w;
												$i++;
													}
											?>
					<?php } ?>


					<?php
						$sorted_array = array_unique($service_type_array);
						$sorted_array = array_values($sorted_array);

						for ($po=0; $po < sizeof($sorted_array); $po++) 
						{ 
							$sub_ttl = 0;
							?>
								<div class="row">
									<center><h3><?php echo $sorted_array[$po] ?></h3></center>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table ">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th style="text-align: left;padding-left: 50px;">Service</th>
                                                        <th style="text-align: left;padding-left: 50px;">Quantity</th>
                                                        <th>Unit Cost</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
												<tbody>
													<?php
														for ($ui=0; $ui < sizeof($service_type_array); $ui++) 
														{ 
															if($service_type_array[$ui] == $sorted_array[$po])
															{
													?>
													<tr>
														<td><?php echo date('d-m-Y', strtotime($sl_nu_array[$ui])); ?></td>
														<td style="text-align: left;"><?php echo $service_array[$ui] ?></td>
														<td><?php echo $qty_array[$ui] ?></td>
														<td><?php echo $unit_cost_array[$ui] ?></td>
														<td><?php echo $total_cost_array[$ui] ?></td>
													</tr>
													<?php
															$sub_ttl += $total_cost_array[$ui];
															}
														}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="row" style="border-radius: 0px;">
									<p class="text-right"><b>Sub-total:</b> &nbsp;&nbsp;₹<?php echo $sub_ttl;?> </p>
								</div>
							<?php $alltotal += $sub_ttl; ?>
					<?php
						}
					?>


					<?php  
					$tt_gen1 = 0;
						if($invoice_related_to_lab)
						{
					?>
					<div class="row">
									<center><h3>Lab</h3></center>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
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
											<?php
											$i = 0;
											
											foreach ($invoice_related_to_lab as $key)
											{
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
												$advance_pay = $key->advance_pay;
												$payment = $key->invoice_pay;
												$invoice_status = $key->invoice_status;
												$tt_gen_w = 0;
											?>
											<?php for ($t=0; $t < $inv_item_len; $t++) {  ?>
												<tr>
													<td><?php echo $t+1+$i;?></td>
													<td style="text-align: left; padding-left: 50px;"><?php echo $inv_item[($t*4)+2]?></td>
													<td style="text-align: left; padding-left: 50px;"><?php echo $inv_item[($t*4)+1];?></td>
													<td>&nbsp;<?php echo $inv_item[($t*4)+3];?></td>
													<td>
													<?php 
														$tt_gen_w = ($inv_item[($t*4)+1]) * ($inv_item[($t*4)+3]);
														echo ($inv_item[($t*4)+1]) * ($inv_item[($t*4)+3]);
													?>
													</td>
												</tr>
											<?php } ?> 
											<?php 
												$tt_gen1 = $tt_gen1 + $tt_gen_w;
												$i++;
													}
											?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="row" style="border-radius: 0px;">
						<div class="col-md-3 col-md-offset-9">
							<p class="text-right"><b>Sub-total:</b> &nbsp;&nbsp;₹<?php echo $tt_gen1;?> </p>
							<?php $alltotal += $tt_gen1; ?>
						</div>
					</div>
					<?php
						}
					?>
						<div class="row">
							<center><h3>Pharmacy</h3></center>
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
										<th>UNIT COST</th>
									</tr></thead>
									<tbody>
										<?php
										$tot = 0;
											foreach ($invoice_related_to_pharm as $key)
											{
												$invoice_id = $key->invoice_id;
												$invoice_name = $key->invoice_name;
												$invoice_doctor = $key->invoice_doctor;
												$items = $key->invoice_items;
												$batch = $key->items_batch;
												$dis = $key->discount;
												$inv_total = $key->invoice_total;
												$total = "";
											?>
								
                                                    <?php
                                                        $item1 = explode(',', $items);
                                                        $batch1 = explode(',', $batch);
                                                        for ($i=0,$j=0,$k=1; $i < sizeof($batch1) ; $i++,$j = $j+2,$k = $k+2)
                                                        { 
                                                            $manf = new Receptions;
                                                            $manf_name = $manf->get_manf_name($item1[$j]);
                                                            $stock_details = $manf->get_stock_detail($batch1[$i]);
                                                            foreach ($stock_details as $value)
                                                            {
                                                                $exp = $value->stock_expiry;
                                                                $txb_amt = $value->drug_taxable_amount;
                                                                $sell = $value->drug_sell_cost;
                                                                $gst = ($sell - $txb_amt)/2;
                                                                $cgst = $value->drug_cgst;
                                                                $sgst = $value->drug_sgst;
                                                            }
                                                    ?>
                                                    <tr>
                                                        <td> <?php echo $item1[$j];?> </td>
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
                                               
						<?php
							}
						?>
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
					</div>
				</div>

							<hr>
                                <div class="row container" style="border-radius: 0px;">
                                    <div class="">
                                     <div class="pull-left">
                                        <a  class="text">&nbsp;<strong>Payment Mode: <?php if(!empty($payment)){ echo $payment; }?></strong></a><br>
                                    </div>
								
								<div class="col-md-3 col-md-offset-9">
									<p class="text-right" style="padding-right: 7px;"><b>Total Bill amount(Rs):</b> <?php echo (int)$tot + (int)$alltotal;?>
									</p>
								</div>
								<div class="col-md-3 col-md-offset-9">
									<p class="text-right" style="padding-right: 7px;"><b>Net Bill amount(Rs):</b> <?php echo (int)$tot + (int)$alltotal;?>
									</p>
								</div>
								<div class="col-md-3 col-md-offset-9">
									<p class="text-right" style="padding-right: 7px;"><b>Advance(Rs):</b> <?php echo $data['advance']?>
									</p>
								</div>
								<div class="col-md-3 col-md-offset-9">
									<p class="text-right" style="padding-right: 7px;"><b>Balance(Rs):</b> <?php echo (int)$tot + (int)$alltotal - $data['advance']?>
									</p>
								</div>
								<!-- <div class="col-md-3 col-md-offset-9">
									<p class="text-right" style="padding-right: 7px;"><b>Final total:</b> &nbsp;&nbsp;₹ <?php echo (int)$tt_gen - (int)$tot  - (int)$tt_gen1 - (int)$data['advance'];?>
									</p>
								</div> -->
                                
                                <div class="hidden-print">
                                    <div class="pull-right">
                                        <a href="<?php echo URLROOT;?>/receptions/print_invoice/<?php echo $invoice_id;?>" class="btn btn-success"><i class="fa fa-print"></i> &nbsp;Print</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="row">
				<div class="table-responsive">
					<table class="table">
						<?php
							if(isset($data['all_advance']))
							{
								?>
								<h5 class="">&nbsp;&nbsp;&nbsp;<b>Receipts Details</b></h5>
								<?php
							}
						?>
						<thead>
							<tr>
								<th style="text-align: left;">Date Time</th>
								<th style="text-align: left;">Payment Type</th>
								<th style="text-align: left;">Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i = 1;
								foreach ($data['all_advance'] as $key) 
								{
							?>
							<tr>
								<td style="text-align: left;"><?php echo date('d-M-Y H:i a', strtotime($key->created_date_time)) ?></td>
								<td style="text-align: left;"><?php echo $key->payment_type; ?></td>
								<td style="text-align: left;"><?php echo $key->amount; ?></td>
							</tr>
							<?php
								$i++;
								}
							?>
						</tbody>
					</table>
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