<?php require APPROOT . '/views/inc/header.php'; ?>
  <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-lg-11">
                        <h4 class="page-title">Salary Details</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                               
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <!-- <a class="btn btn-primary" style="color: white" onclick="print_page()"><i class="fa fa-print" aria-hidden="true"></i></a> -->
                    </div>
                </div>          
            </div>
            <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->    
            <div class="contentbar">                
                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-header">                                
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <center>
                                         <h6><?php echo URLROOT1;?><h6>
                                        <h5 class="card-title mb-0" style="font-size: 28px;">Salary Details</h5>
                                        <br>
                                       <!--  <h6>From 01/07/2020 To 31/07/2020<h6> -->
                                            </center>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-border">
                                        <thead>
                                            <tr>
                                                <th>Employee Id</th>
                                                <th>Employee Name</th>
                                                <th>Total Days Present</th>
                                                <th>Total Days Absent</th>
                                                <th>Total working days</th>
                                                <th>Per month Salary</th>
                                                <th>Per day salary</th>
                                                <th>Salary lost</th>
                                                <th>Salary earned</th>
                                                
                                                <th>Loan Per month due</th>
                                                <th>Loan Deduction</th>
                                                <th>Final Salary</th>                     
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php $page = new Page(); ?>
                                            <?php foreach ($data['all_salary'] as $key) { ?>
                                            <tr>
                                            <td class="text-center"><?php echo $key->employee_id;  ?>
                                            </td>
                                            <td class="text-center"><?php echo ucwords($key->emp_name); ?>
                                            </td>
                                           
                                            <td class="text-center"><?php echo $key->total_present; ?>
                                            </td>
                                            <td class="text-center"><?php echo $key->total_absent; ?>
                                            </td>
                                            <td class="text-center"> <?php echo $key->total_working_days; ?>
                                            </td>
                                            <td class="text-center"><?php echo $key->salary; ?>
                                            </td>
                                            <td class="text-center"><?php echo $key->per_day_sal; ?> 
                                            </td>
                                            <td class="text-center"><?php echo $key->salary_lost; ?> 
                                            </td>
                                            <td class="text-center"><?php echo $key->salary_accumilated; ?> 
                                            </td>
                                            
                                            <td class="text-center"><?php echo $key->per_month_due; ?></td>
                                            <td class="text-center"><?php echo $key->loan_deduction; ?></td>
                                            <td class="text-center">&#8377; <?php echo $key->final_salary; ?> 
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
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
<script type="text/javascript">
   $(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script>