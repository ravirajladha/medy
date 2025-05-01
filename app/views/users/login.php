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

                <div class="form-horizontal m-t-40">
                    
                    <!-- <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="hos_id" placeholder="Medhike ID">
                        </div>
                    </div> -->

					<center><span class="text-danger" id="error"></span></center>
					<br>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" id="userId" placeholder="Username" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" id="pass" placeholder="Password">
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
                            <button class="btn btn-primary w-md" type="submit" id="signIn">Log In</button>
                        </div>
                    </div>
                </div>

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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


		<script type="text/javascript">
			$(document).ready(function(){
				$('#signIn').click(function(){
					var userId = $('#userId').val();
					var password = $('#pass').val();
					if(userId && password)
					{
						$(this).html('<i class="fa fa-spinner fa-pulse fa-2x fa-fw" style="padding:0px;margin:0px; margin-top:8px; color:white;"></i>');
						$('#signIn').prop('disabled', true);
						setTimeout(function(){
							$.ajax({
								url  : '<?php echo URLROOT; ?>/users/primaryMedhikeLogin',
								type : 'POST',
								data : {userId, password},

								success : function(res)
								{
									res = JSON.parse(res);
									if(res.type === 'admin')
									{
										window.location.replace('<?php echo URLROOT; ?>/admin/index');
									}
									if(res.type === 'rec')
									{
										window.location.replace('<?php echo URLROOT; ?>/receptions/index');
									}
									if(res.type === 'doc')
									{
										window.location.replace('<?php echo URLROOT; ?>/doctors/index');
									}
									if(res.type === 'pharm')
									{
										window.location.replace('<?php echo URLROOT; ?>/pharmacies/index');
									}
									if(res.type === 'lab')
									{
										window.location.replace('<?php echo URLROOT; ?>/labs/index');
									}
									if(res.type === 'nur')
									{
										window.location.replace('<?php echo URLROOT; ?>/nurses/index');
									}

									if(res.type === 'ot')
									{
										window.location.replace('<?php echo URLROOT; ?>/ot/index');
									}

									if(res.type === 'ot_room')
									{
										window.location.replace('<?php echo URLROOT; ?>/ot_room/index');
									}

									if(res.type == 'acc')
									{
										window.location.replace('<?php echo URLROOT; ?>/acc/index');
									}
									if(res.type === 'x_ray')
									{								
										window.location.replace('<?php echo URLROOT; ?>/xrays/index');
									}
									if(res.type == 'patient')
									{
										window.location.replace('<?php echo URLROOT; ?>/patients/index');
									}

									if(res.type == 'medhike')
									{
										window.location.replace('<?php echo URLROOT; ?>/super_admin/index');
									}
									if(res.type == "0")
									{
										$('#signIn').html('Sign In');
										$('#signIn').prop('disabled', false);
										$('#error').html("Invalid User ID or Password.");
									}
									// else
									// {
									// 	$('#signIn').html('Sign In');
									// 	$('#error').html("Something Went Wrong. Please try again.");
									// }
								}
							})
						}, 1000);
					}
					else
					{
						$('#error').html("Enter All Fields.");
					}
				});
			});

			$(document).keypress(function(event){
				var keycode = (event.keyCode ? event.keyCode : event.which);
				if(keycode == '13'){
					$('#signIn').click();
				}
			});
		</script>
    
    </body>
</html>