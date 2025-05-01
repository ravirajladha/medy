<?php
    if(isset($data['admin_check']))
    {
        if($data['admin_check'] == 2)
        {
            ?>
                <script type="text/javascript">
                    alert("Password does'nt match");
                </script>
            <?php
        }

        elseif($data['admin_check'] == 0)
        {
            ?>
                <script type="text/javascript">
                    alert('Username is not VALID.');
                </script>
            <?php
        }
    }
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="<?php echo URLROOT;?>/img/favicon.png">

        <title>Medhike</title>

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

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="<?php echo URLROOT;?>/assets/morris/morris.css">


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
    <body>
        <div class="wrapper-page animated fadeInDown">
            <div class="panel panel-color panel-primary">
                <div class="panel-heading"> 
                   <h3 class="text-center m-t-10"> Sign In to &nbsp;<img id="" style="height:40px;" src="<?php echo URLROOT;?>/img/logo.png" alt="logo"> </h3>
                </div> 

                <form class="form-horizontal m-t-40" action="<?php echo URLROOT;?>/admin/login" method="post">
                                            
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="username" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group ">
                        
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <label class="cr-styled">
                                <input type="checkbox" checked>
                                <i class="fa"></i> 
                                Remember me
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group text-right">
                        <div class="col-xs-12">
                            <button class="btn btn-primary w-md" type="submit">Log In</button>
                        </div>
                    </div>
                    <div class="form-group m-t-30">
                        <div class="col-sm-7">
                            <a href="recoverpw.html"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                        <div class="col-sm-5 text-right">
                            <a href="register.html">Create an account</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="<?php echo URLROOT;?>/js/jquery.js"></script>
        <script src="<?php echo URLROOT;?>/js/bootstrap.min.js"></script>
        <script src="<?php echo URLROOT;?>/js/pace.min.js"></script>
        <script src="<?php echo URLROOT;?>/js/wow.min.js"></script>
        <script src="<?php echo URLROOT;?>/js/jquery.nicescroll.js" type="text/javascript"></script>
            

        <!--common script for all pages-->
        <script src="<?php echo URLROOT;?>/js/jquery.app.js"></script>

    
    </body>
</html>