<?php require APPROOT . '/views/inc/header.php'; ?>
  <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h4 class="page-title">Change DataBase</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                               
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-1">
                       <a href="<?php echo URLROOT;?>/pages/download_db" class="btn btn-danger">Dont Press</a>
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
                                        <h5 class="card-title mb-0" style="font-size: 28px;">Change DataBase</h5>
                                        </center>
                                    </div>
                                </div>
                            </div>
                           <div class="card-body">
                                <form action="<?php echo URLROOT;?>/pages/update_change_DB" method="post">
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col">
                                            <label for="chickpet_db">Chickpet DB</label>
                                            <input type="Radio" name="chickpet_db" id="chickpet_db" class="form-group chb"  >
                                        </div>
                                        <div class="col">
                                             <label for="chamarajpet_db">Chamarajpet DB</label>
                                            <input type="Radio" name="chamarajpet_db" id="chamarajpet_db" class="form-group chb" >
                                        </div>
                                        <div class="col">
                                           <button class="btn btn-info">Change</button>
                                        </div>
                                         <div class="col"></div>
                                    </div>
                                </form>
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
<script type="text/javascript">
    $(".chb").change(function() {
    $(".chb").prop('checked', false);
    $(this).prop('checked', true);
});
</script>