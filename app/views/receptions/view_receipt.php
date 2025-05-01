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
        $rec_model = new Reception;
        $pat_data = $rec_obj->get_patients_data_to_print($data['patient_id']);
       
?>
<div class="wraper container-fluid">
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
                                       
                                    </div>
                                </div>
                                <hr>
								<center><h3>Advance Receipt</h3></center>
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <div class="pull-left m-t-30">
                                            <address>
                                              <strong>Patient Name: </strong><?php echo ucwords($data['patient']->patient_name);?><br>
                                              <strong>Patient ID : </strong><?php echo $data['patient']->patient_id;?><br>
                                              <strong>
                                              Admit ID: </strong> <?php echo $data['admit_id'];?><br>
                                              <strong>Age : </strong>
                                              <?php
                                                $curr_yr = date('Y-m-d');
												$dob = $data['patient']->patient_dob;
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
                                                    $au_year = $data['patient']->patient_age;
                                                    $c_year = date('Y');
                                                    $age = $age + ($c_year - $au_year);
                                                    if($age > 1)
                                                    {
                                                        echo $au_year;
                                                        echo " years";
                                                    }
                                                    else
                                                    {
                                                        echo $au_year;
                                                        echo " year";
                                                    }
                                                }
                                            ?>
											<br>
											<strong>Doctor Name:</strong> 
											<?php 
												$doc_name = $rec_model->get_doctor_by_id_single($data['ipd_details']->ipd_doctor_id);
												echo $doc_name->doctor_name;
											?><br>
                                        </div>
                                        <div class="pull-right m-t-30">
                                            <p><strong>Bill Date: </strong><?php echo date('d-m-Y h:i a', strtotime($data['advance']->created_date_time));?></p>
                                            <p>
                                                <strong>Admission Date: </strong>
                                                    <?php echo date('d-m-Y h:i A', strtotime($data['ipd_details']->admission_date_time));?>
                                            </p>
                                                <?php if($data['ipd_details']->discharge_date_time != NULL) {?>
                                            <p>
                                                <strong>Discharged Date: </strong>
                                                    <?php echo date('d-m-Y h:i A', strtotime($data['ipd_details']->discharge_date_time));?>
                                            </p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="">
                                     <div class="pull-left">
                                        <a  class="text">&nbsp;<strong>Received Amount: 
										</strong> ₹ <?php 
											echo $data['advance']->amount;
										?></a>
                                    </div>
                                </div>
								<br>
								<div class="">
                                     <div class="pull-left">
                                        <a  class="text">&nbsp;<strong>Payment Mode: 
										</strong><?php 
											echo $data['advance']->payment_type;
										?></a>
                                    </div>
                                </div>
								<br>
								<div class="">
                                     <div class="pull-left">
                                        <a  class="text">&nbsp;<strong>Received with thanks: 
										</strong>
										<span>
										<?php
											echo $amount_in_words = displaywords((int)$data['advance']->amount);
										?></span></a>
                                    </div>
                                </div>
								<br>					
								<br>					
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

<?php

	function displaywords(float $amount)
	{
	   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
	   // Check if there is any number after decimal
	   $amt_hundred = null;
	   $count_length = strlen($num);
	   $x = 0;
	   $string = array();
	   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
		 3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
		 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
		 10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
		 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
		 16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
		 19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
		 40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
		 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
	  $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
	  while( $x < $count_length ) {
		   $get_divider = ($x == 2) ? 10 : 100;
		   $amount = floor($num % $get_divider);
		   $num = floor($num / $get_divider);
		   $x += $get_divider == 10 ? 1 : 2;
		   if ($amount) {
			 $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
			 $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
			 $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
			 '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
			 '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
			 }else $string[] = null;
		   }
	   $implode_to_Rupees = implode('', array_reverse($string));
	   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
	   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
	   return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
	}

?>
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
