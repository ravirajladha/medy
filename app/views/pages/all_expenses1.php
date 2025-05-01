<?php require APPROOT . '/views/inc/header.php'; ?>
   <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">All expenses</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                               
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                            <a href="<?php echo URLROOT;?>/pages/addexpenses"><button class="btn btn-primary">Add expenses</button>
                            </a>
                              <button class="btn btn-primary"><i class="ri-refresh-line mr-2"></i>Refresh</button>
                        </div>                        
                    </div>
                </div>          
            </div>
            <!-- End Breadcrumbbar -->

            <!-- Start Contentbar -->    
            <div class="contentbar">   
                <form action="<?php echo URLROOT; ?>/pages/all_expenses1" method="POST" >
           
                 
                <div class="col-md-12">
                    
                 <div class="row">

                
                            <div class="col-md-3 form-group">
                                <label>Start Time</label>
                                <input type="date" name="start" id="start"/>
                            </div>
                            
                              <div class="col-md-3 form-group">
                                <label>End Time</label>
                                <input type="date" name="end" id="start"/>
                            </div>
                            <div class="col-md-3 form-group"><br>
                                <label>&nbsp;</label>
                            <button type="submit" class="btn btn-info" >Submit</button>
                        </div>
   
                
                        </div>
            </div>
                        </form>

                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-12">
                       <div class="card m-b-30">
                            <div class="card-header">                                
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="card-title mb-0">All expenses</h5>
                                    </div>
                             
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                              
                                                <th>Expense Type</th>
                                                <th>Expense detail</th>
                                                <th>Expense date</th>
                                                   <th>Expense Value</th>

                                              
                                                   <th>Created_By</th>
                                                      <th>Created_At</th>
                                                        <th>Action</th>
                                              
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                               <?php foreach ($data['all_expenses'] as $k){ ?>
                                            <tr>
                                                <td><?php echo $k->expenseid;?></td>
                                                
                                                <td><?php echo $k->expensetype;?></td>
                                                <td><?php echo $k->expensedetail;?></td>
                                                  <td><?php echo $k->expensedate;?></td>
                                                    <td><?php echo $k->expensevalue;?></td>
                                                   
                                                      <td><?php echo $k->created_by;?></td>
                                                        <td><?php echo $k->created_at;?></td>
                                                         <td>  <a target="_BLANK" href="<?php echo URLROOT; ?>/uploads/<?php echo $k->document; ?>"><button class="btn btn-info"  >View Document</button></a>
</td>
                                                
                                                                                     </tr>
                                            <?php }?>
                                            
                                           
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
            <!-- End Contentbar -->

<?php require APPROOT . '/views/inc/footer.php'; ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
