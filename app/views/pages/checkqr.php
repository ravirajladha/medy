<?php require APPROOT . '/views/inc/header.php'; ?>
  <!-- Start Breadcrumbbar -->   
  <script type="text/javascript"> var gl=0;</script>                 
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-lg-11">
                        <h4 class="page-title">Check QR</h4>
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
                                            <h5 class="card-title mb-0" style="font-size: 28px;">Check QR</h5>
                                            <br>                                     
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row ">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <button class="btn btn-info pull-left" id="scstart" onclick="startscan()">Scan QR CODE</button>
                                                    <button class="btn btn-warning pull-left" id="scend" onclick="endscan()" style="display: none;">End Scan Items</button>
                                                </div> 
                                            </div>
                                             <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="text" name="barcode" id="scnitem" class="form-control" />
                                                </div> 
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <p id="alert" style="color: red"></p>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
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
                                                    url: "<?php echo URLROOT; ?>/pages/scanQRforcheck",
                                                    data:{barcode},
                                                    success:function(data)
                                                    {
                                                        $("#scnitem").focus();
                                                        $("#scnitem").val(empty);
                                                        endscan();
                                                        $('#allItems').html(data);
                                                        

                                                    }
                                                });
                                            }

                                        }, 1400);
                                }
                            </script>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-border" id="allItems">
                                        <!-- <thead>
                                            <tr>
                                                <th>Stock ID</th>
                                                <th>Item ID</th>
                                                <th>Item Name</th>
                                                <th>Batch</th>
                                                <th>Stock In Hand</th>
                                                <th>Position</th>
                                                <th>Received IN</th>
                                                <th>Received Date</th>
                                                <th>Item Age</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                          
                                        </tbody> -->
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
 <script>
    function generate_qr($id) 
    {
        var boxstockid = $id;
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/print_item_qr_for_single_pieces",
            type: "POST",
            data: {boxstockid},
            success: function(response)
            {
                 window.open(response);
                 //alert(response);
            }
        });
    }
    function generate_qr2($id) {
        var boxstockid = $id;
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/print_item_qr_for_single_pieces",
            type: "POST",
            data: {boxstockid},
            success: function(response)
            {
                 window.open(response);
            }
        });
    }
    function nonpurunbox($id) 
    {
        var boxstockid = $id;
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/convert_box_item_for_qr_check",
            type: "POST",
            data: {boxstockid},
            success: function(response)
            {
                
                $("#scnitem").val(response.trim());
                 startscan();
            }
        });
    }
    function purunbox($id) 
    {
        var boxstockid = $id;
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/convert_box_item_purchase_check_qr",
            type: "POST",
            data: {boxstockid},
            success: function(response)
            {
                $("#scnitem").val(response.trim());
                startscan();
            }
        });
    }
    

</script>
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