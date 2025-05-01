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
        $em = $data['em'];

?>
<div class="wraper container-fluid print">
                <div class="page-title"> 
                    <center><h3 class="title"><b>Emergency</b></h3></center>
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
                                              <strong>Patient Name: </strong> <?php echo ucwords($em->p_name);?><br>
                                              <strong>Patient ID: </strong> <?php echo $em->p_id;?><br>
                                             
                                              <strong>Emergency ID: </strong> <?php echo $em->id;?><br>
                                              <strong>Doctor Name: </strong> Dr. <?php echo ucwords($em->d_name);?><br>
                                              <strong>Doctor ID: </strong> <?php echo ucwords($em->d_mem_id);?><br>
                                              <!-- 795 Folsom Ave, Suite 600<br>
                                              San Francisco, CA 94107<br>
                                              <abbr title="Phone">P:</abbr> (123) 456-7890 -->
                                              </address>
                                        </div>
                                        <div class="pull-right m-t-30">
                                            <p><strong>Visit Date: </strong> <?php echo date('d-m-Y', strtotime($em->created_by));?></p>
                                            <!-- <p class="m-t-10"><strong>Order ID: </strong> #123456</p> -->
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="m-h-50"></div>
                                <div class="col-md-12">
                                    <h3>Consultation details</h3>
                                <p><?php echo $em->details; ?></p>        
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