<?php require APPROOT .'/views/inc_labs/header.php'; ?>
<div class="wraper container-fluid">
                <div class="page-title"> 
                    <h3 class="title">Welcome !</h3> 
                </div>

               <div class="row">
                    <div class="col-lg-4 col-sm-6">
                        <a href="<?php echo URLROOT;?>/labs/new_test">
                        <div class="widget-panel widget-style-2 white-bg">
                            <i style="color: #2196F3" class="fa fa-stethoscope"></i> 
                            <h3 style="color: gray">New Test</h3>
                            
                        </div></a>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                    	<a href="<?php echo URLROOT;?>/labs/orders">
                        <div class="widget-panel widget-style-2 white-bg">
                            <i style="color: #FF0066" class="fa fa-medkit"></i> 
                            <h3 style="color: gray">Lab Orders</h3>
                            
                        </div></a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                    	<a href="<?php echo URLROOT;?>/labs/test_group">
                        <div class="widget-panel widget-style-2 white-bg">
                            <i style="color: #660099" class="ion-clipboard"></i> 
                            <h3 style="color: gray">Tests</h3>
                            
                        </div></a>
                    </div>
                    
                    
                </div> <!-- end row -->
           <!-- End row -->
           </div>

<?php require APPROOT .'/views/inc_labs/footer.php'; ?>