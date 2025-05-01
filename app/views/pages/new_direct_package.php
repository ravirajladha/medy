<?php require APPROOT . '/views/inc/header.php'; ?>
  <!-- Start Breadcrumbbar -->   
  <script type="text/javascript"> var gl=0;</script>                 
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-lg-11">
                        <h4 class="page-title">Direct Package</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-1">
                        
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
                                            <h5 class="card-title mb-0" style="font-size: 28px;">Direct Package</h5>
                                            <br>                                     
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="card">
                                    <form action="<?php echo URLROOT;?>/pages/create_direct_package" method="POST">
                                    <div class="card-body">
                                        <div class="row ">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Customer Name</label>
                                                    <select class="select2-single form-control" id="customer_id" name="customer_id" required="">
                                                        <option disabled="">--Select--</option>
                                                        <?php foreach ($data['customer'] as $cu) { ?>
                                                        <option value="<?php echo $cu->id;?>"><?php echo $cu->customer_display_name;?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="col-md-5">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label></label>
                                                        <div class="form-group" style="display: none;">
                                                            <a class="btn btn-info pull-left text-white" id="scstart" onclick="startscan()">Start Scan</a>
                                                            <a class="btn btn-warning pull-left text-white" id="scend" onclick="endscan()" style="display: none;">End Scan</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label></label>
                                                        <div class="form-group">
                                                            <input type="text" name="barcode" id="scnitem" class="form-control" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label></label>
                                                <div class="form-group">
                                                    <button class="btn btn-primary">Submit</button>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label></label>
                                                <div class="form-group">
                                                    <p id="alert" style="color: red; display: none;"></p>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            <script type="text/javascript">
                                function startscan()
                                {
                                    gl=1;
                                    $("#scnitem").focus();
                                    selectProduct()
                                    document.getElementById("scstart").style.display = "none";
                                    document.getElementById("scend").style.display = "block";
                                }
                                function endscan()
                                {
                                    gl=0;
                                    selectProduct()
                                    document.getElementById("scstart").style.display = "block";
                                    document.getElementById("scend").style.display = "none";
                                }

                                function selectProduct()
                                {   
                                        var empty='';
                                        var interval = setInterval(function()
                                        {
                                            if(gl==0)
                                            {
                                                clearInterval(interval);
                                                document.getElementById("alert").innerHTML="";
                                            }
                                            var y = document.getElementById("scnitem").value;
                                            if(y!="")
                                            {
                                                var emp="";
                                                var item_id_for_qty =0;
                                                var barcode = document.getElementById("scnitem").value;
                                                $.ajax({
                                                    type:"POST",
                                                    url: "<?php echo URLROOT; ?>/pages/scanQRfordirect_package",
                                                    data:{barcode},
                                                    success:function(data)
                                                    {
                                                        $("#scnitem").focus();
                                                        $("#scnitem").val(empty);
                                                        // $('#allItems').html(data);
                                                        all_temp_scan_table();
                                                        $("#alert").html(data);
                                                    }
                                                });
                                            }

                                        }, 200);
                                }
                            </script>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-border" >
                                        <thead>
                                        <tr>
                                            <th>Item ID</th>
                                            <th>Stock ID</th>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th>Type</th>
                                            <th>QR Code</th>
                                        </tr>
                                    </thead>
                                        <tbody id="allItems" >
                                          
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
<script type="text/javascript">
    $(document).ready(function()
    {
    startscan();
    // var lim = 0;
    // var off = 0;
    // var inc = 0;
    //     $.ajax({
    //     type: "POST",
    //     url: '<?php //echo URLROOT;?>/pages/allItemsforcatreport',
    //     data: {lim,off},
    //     cache: false,
    //     success:function(response)
    //     {
    //         $('#allItems').html(response);
    //     }
    //     });
    });
 </script>
 <script type="text/javascript">
 function all_temp_scan_table() {
        $.ajax({
        type: "POST",
        url: '<?php echo URLROOT;?>/pages/getscaneditemsdirect_package',
        data: {},
        success:function(response)
        {
            $('#allItems').html(response);
        }
        });
}
$('#customer_id').change(function()
    { 
        startscan();
        var ini = setInterval(function()
        {
         $("#scnitem").focus();
         clearInterval(ini);
        },300);
    });
</script>


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