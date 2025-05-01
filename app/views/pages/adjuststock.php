<?php require APPROOT . '/views/inc/header.php'; ?>

            <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">Adjust Stock - Ganesha Rahashya</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                             
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                           <!--  <a href="<?php echo URLROOT;?>/pages/add_sales_order"><button class="btn btn-primary">cancel</button> -->
                        </div>                        
                    </div>
                </div>          
            </div>
            <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->    
            <div class="contentbar">
                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6">
                        <div class="card m-b-30">
                            
                            <div class="card-body">
                               
                               
                                	
                                    <div class="form-group">
                                        <label >Date</label>
                                        <input type="Date" class="form-control" placeholder="09/07/2020">
                                    </div>
                                    <div class="form-group">
                                        <label >Account*</label>
                                        <select class="form-control" id="formControlSelect">
                                            <option>Cost of Goods Sold</option>
                                            <option>Materials</option>
                                            <option>Labor</option>
                                            <option>Transportation Expense</option>
                                           
                                        </select>
                                       
                                    </div>
                                    <div class="form-group">
                                        <label >Reference Number</label>
                                    	 <input type="text" class="form-control" placeholder="">
                                    </div>
                                   
                            </div>
                        </div>
                    </div> 
                    <!-- End col -->
                     <!-- Start col -->
                    <div class="col-lg-6">
                        <div class="card m-b-30">
                            
                            <div class="card-body">
                               
                               
                                	
                                    <div class="form-group">
                                        <label >Quantity Available</label>
                                        <input type="text" class="form-control" placeholder="5200 pc" >
                                       
                                    </div>
                                      <div class="form-group">
                                        <label >New Quantity on hand</label>
                                        <input type="text" class="form-control" placeholder="0.00">
                                       
                                    </div>
                                      <div class="form-group">
                                        <label >Quantity Adjusted*</label>
                                        <input type="text" class="form-control" placeholder="Eg +10">
                                      
                                    </div>
                                    
                            </div>
                        </div>
                    </div> 
                    <!-- End col -->
                 
                      <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            
                            <div class="card-body">
                               
                                    <div class="form-group">
                                        <label >Reason</label>
                                         <select class="select2-single form-control" name="state">
                                        <option>calculation mistake</option>
                                        <option value="AK">adjustement in stock</option>
                                        <option value="HI">other</option>
                                   </select>

                                    </div>
                                      
                                      <div class="form-group">
                                        <label >Description</label>
                                      <textarea class="form-control"></textarea>
                                    </div>
                                     
                                    
                            </div>
                        </div>
                    </div> 
                    <!-- End col -->


					
                </div> 
                <div class="row">
                	<div class="col-lg-12">

                  		<a href="<?php echo URLROOT;?>/pages/stocks"><button class="btn btn-primary" style="float: right; margin-left: 10px;">Cancle</button></a>
                  		<a href="<?php echo URLROOT;?>/pages/stocks"><button class="btn btn-primary" style="float: right;">Submit</button></a>
                  	</div><!-- End row -->
                </div><br>
                	
            </div>
            <!-- End Contentbar -->

				


         
                    
                          
                    
<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>