<?php 
    $d = $_SESSION['print_qr'];
    $data=[ 
        'temp_qr_id'=>$d['temp_qr_id'],
        'itemid'=>$d['itemid'],
        'rQty' => $d['rQty'],
        'itemName'=>$d['itemName'],
        'receivable_type' => $d['receivable_type'],
        'temp_qr_print_all' => $d['temp_qr_print_all'],
      ];
      // unset($_SESSION['print_qr']);
?>

<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Print QR Purchase Receive</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="contentbar">
    <div class="row">

        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-header bg-primary-rgba">
                    <h5 class="card-title text-primary">Print QR Purchase Receive</h5>
                </div>
                <div class="card-body">
                	

                	<div class="col-lg-6">
                        <div class="card m-b-30">
                            <div class="card-header">
                                
                            </div>
                            <div class="card-body">
                                <!-- Modal -->
                                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                                 QR PRINT
                                </button> 

                                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    	<!-- <form method="POST" action="<?php echo URLROOT;?>/pages/print_item_qr"> -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Print QR</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                             <div class="modal-body">
                                            	 <table>
                                                    <thead>
                                                        <tr>
															<th>QTY</th>
															<th>Item ID</th>
															<th style="width: 150px;">Item Name</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                <?php 
                                                    $temp_qr_id = explode('|', $data['temp_qr_id']); 
                                                    $itemid = explode('|', $data['itemid']); 
                                                    $rQty = explode('|', $data['rQty']); 
                                                    $itemName = explode('|', $data['itemName']); 
                                                    $receivable_type = explode('|', $data['receivable_type']);
                                                ?>
                                                <?php for ($i=0; $i < sizeof($temp_qr_id); $i++) { ?>
                                                        <tr>
                                                            <td><input type="text" name="qty" class="form-control" id="qty<?php echo $i;?>" value="<?php echo $rQty[$i]; ?>" readonly="true" autocomplete="off" /></td>
                                                             <input type="hidden" id="typeq<?php echo $i;?>" value="<?php echo $receivable_type[$i]; ?>">
                                                             <td><input type="text" id="item_id<?php echo $i;?>" name="item_id" class="form-control" value="<?php echo $itemid[$i]; ?>" readonly="true" autocomplete="off" /></td>
                                                             <input type="hidden" name="temp_qr_id" id="temp_qr_id<?php echo $i;?>" value="<?php echo $temp_qr_id[$i];?>">
                                                             
                                                            <td ><?php echo $itemName[$i]; ?></td>
                                                            <td><button type="submit" id="qrprint<?php echo $i;?>" class="btn btn-primary">Print</button></td>
                                                        </tr>

                                                        <script>
                                                             $('#qrprint<?php echo $i;?>').click(function(){
                                                                var qty = $('#qty<?php echo $i;?>').val();
                                                                var item_id = $('#item_id<?php echo $i;?>').val();
                                                                var typeq = $('#typeq<?php echo $i;?>').val();
                                                                 var temp_qr_id = $('#temp_qr_id<?php echo $i;?>').val();
                                                                $.ajax({
                                                                    url: "<?php echo URLROOT; ?>/pages/print_item_qr",
                                                                    type: "POST",
                                                                    data: {qty,item_id,temp_qr_id,typeq},
                                                                    success: function(response)
                                                                    {
                                                                        window.open(response);
                                                                        
                                                                    }
                                                                });
                                                             });
                                                             
                                                        </script>
                                                        
                                                <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-secondary text-white" data-dismiss="modal">Close</a>
                                                <a id="qrprint_all" class="btn btn-primary text-white">Print QR All</a>
                                                <script type="text/javascript">
                                                    $('#qrprint_all').click(function()
                                                    {
                                                        var temp_qr_print_all = 0;
                                                        temp_qr_print_all = parseInt(<?php echo $data['temp_qr_print_all']; ?>);

                                                        $.ajax({
                                                            url: "<?php echo URLROOT; ?>/pages/print_item_qr_all",
                                                            type: "POST",
                                                            data: {temp_qr_print_all},
                                                            success: function(response)
                                                            {
                                                                window.open(response);
                                                                // alert(response);
                                                                
                                                            }
                                                        });
                                                     });
                                                </script>
                                            </div>
                                        </div>
                                       <!--  </form> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 



                </div>
               
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
<div class="modal fade" id="barcodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <p id="myIframe1"></p>

        </div>
    </div>
</div>
<div class="modal fade" id="qrcodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <p id="myIframe2"></p>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function()
	{
		$('#exampleModalLong').modal('show');
	});
</script>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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