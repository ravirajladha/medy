<?php require APPROOT . '/views/inc/header.php'; ?>
  <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-lg-11">
                        <h4 class="page-title">Change Password</h4>
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
                        <div class="card">
                        	<div class="card-body">
                        		<!-- Profile Settings Form -->
                        		<form method="post" action="<?php echo URLROOT;?>/pages/change_password" enctype="multipart/form-data">
                        		
                        			<div class="row form-row">
                        				<div class="col-12 col-md-6">
                        					<div class="form-group">
                        						<label>Current Password</label>
                        						<input type="password" class="form-control" value="" name="opass" required="true"  />
                        					</div>
                        					<div class="form-group">
                        						<label>New Password</label>
                        						<input type="password" class="form-control" value="" name="npass" required="true"/>
                        					</div>
                        					<div class="form-group">
                        						<label>Conform Password</label>
                        						<input type="password" class="form-control" value="" name="cpass" required="true"/>
                        					</div>
                        				</div>
                        			</div>
                        			<div class="submit-section">
                        				<button type="submit" class="btn btn-primary submit-btn">Change Password</button>
                        			</div>
                        		</form>
                        		<!-- /Profile Settings Form -->
                        		
                        	</div>
                        </div>
                    </div>
                </div>
            </div>

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