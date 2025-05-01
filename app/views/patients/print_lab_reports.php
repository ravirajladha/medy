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
        @media print {
    .pagebreak { page-break-before: always; } /* page-break-after works, as well */
}
    </style>
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
<div class="wraper container-fluid print">
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
                                        <h4 class="text-right"><img src="img/logo_dark.png" alt="velonic"></h4>
                                        
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
                                <?php foreach($data['report'] as $key2) { 
                                    $lab_test_values = $key2->lab_test_values;
                                    $lab_test_values = explode(',', $lab_test_values);
                                    $length = sizeof($lab_test_values);
                                    $length = $length - 1;
                                ?>
                                <div class="m-h-50"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-30">
                                                <thead>
                                                    <tr><th>Object Name</th>
                                                    <th>Specimen</th>
                                                    <th>Result</th>
                                                    <th>Biol.Ref.Int</th>
                                                </tr></thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    while ($i < $length) {
                                                       
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $lab_test_values[$i];?></td>
                                                        <td><?php echo $lab_test_values[$i+1];?></td>
                                                        <td><?php echo $lab_test_values[$i+2];?></td>
                                                        <td><?php echo $lab_test_values[$i+3];?></td>
                                                    </tr>
                                                <?php 
                                                $i = $i+4;
                                                    }  
                                                ?>
                                                </tbody>
                                            </table>
                                            <div class="pagebreak"> </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php 
                                            
                                        }?>
                                        
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <script type="text/javascript">
        window.print();
    </script>