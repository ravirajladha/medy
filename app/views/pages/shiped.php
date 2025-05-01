<?php require APPROOT . '/views/inc/header.php'; ?>

            <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">New Shipment</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                             
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                                              
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
                                        <label >Package# </label>
                                        <input type="text" class="form-control" placeholder="PKG-00004">
                                     </div>
                                     <div class="form-group">
                                        <label >Shipment Order# </label>
                                        <input type="text" class="form-control" placeholder="SHP-00006">
                                     <br>
                                        <label >Ship Date</label>
                                       <input type="Date" name="" value="2020-07-10" class="form-control">
                                       <br>
                                        <label >Carrier*</label>
                                        <input type="text" class="form-control" placeholder="Type">
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
                                       

                                         <label >Tracking#</label>
                                        <input type="text" class="form-control" placeholder="Type">
                                     </div>
                                     <div class="form-group">
                                        <label >Shipping Charges (if any) </label>
                                        <input type="text" class="form-control" placeholder="0.00">
                                     <br>
                                       
                                    </div>
                                       <a href="<?php echo URLROOT;?>/pages/sales_order"><button class="btn btn-primary" style="float: right; margin-left: 10px;">Cancle</button></a>
                                   <button class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#exampleStandardModal">Save</button>

                                    
                            </div>
                        </div>
                    </div> 
                    <!-- End col -->
     
                            


                    
                </div> 
                
                    
            </div>
            <!-- End Contentbar -->



<script type="text/javascript">

$(document).ready(function(){
    var i=1;
    $("#add_row").click(function(){b=i-1;
        $('#addr'+i).html($('#addr'+b).html()).find('td:first-child').html(i+1);
        $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
        i++; 
    });
    $("#delete_row").click(function(){
        if(i>1){
        $("#addr"+(i-1)).html('');
        i--;
        }
        calc();
    });
    
    $('#tab_logic tbody').on('keyup change',function(){
        calc();
    });
    $('#tax').on('keyup change',function(){
        calc_total();
    });
    

});

function calc()
{
    $('#tab_logic tbody tr').each(function(i, element) {
        var html = $(this).html();
        if(html!='')
        {
            var qty = $(this).find('.qty').val();
            var price = $(this).find('.price').val();
            $(this).find('.total').val(qty*price);
            
            calc_total();
        }
    });
}

function calc_total()
{
    total=0;
    $('.total').each(function() {
        total += parseInt($(this).val());
    });
    $('#sub_total').val(total.toFixed(2));
    tax_sum=total/100*$('#tax').val();
    $('#tax_amount').val(tax_sum.toFixed(2));
    $('#total_amount').val((tax_sum+total).toFixed(2));
}
</script>
                

                 <!-- Modal -->
                                <div class="modal fade" id="exampleStandardModal" tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleStandardModalLabel">Create</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                
                <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            
                            <div class="card-body">
                                     <div class="form-group">
                                        <label >Sales Order:  </label>
                                        <label >#SO-000003</label>
                                    </div>
                               
                                    <div class="form-group">
                                        <label >Status</label>
                                        <label >: Packed</label>
                                         <label >: Shipped</label>
                                    </div>
                                     <div class="form-group">
                                        <label >Reference#</label>
                                        <input type="text" class="form-control" value="#SO-00003">
                                    </div>

                                    <div class="form-group">
                                        <label >Sales Order Date</label>
                                         <input type="date" class="form-control" value="2020-07-12">
                                       
                                    </div>
                                     </div>
                                            <div class="modal-footer">
                                              
                                                <button type="button" class="btn btn-primary" onclick="success()">Mark As Delivered</button> 
                                                 <a href="<?php echo URLROOT;?>/pages/addinvoice"><button type="button" class="btn btn-primary">Convert to Invoice</button></a>
                               
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                   
                                   
                            </div>
                        </div>
                    </div> 
                    <!-- End col -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">

    function success(){
        swal("Conformed", "Thank You!", "success");
        // window.open('<?php echo URLROOT;?>/pages/sales_order');
    }
</script>
         
                    
                          
                    
<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
