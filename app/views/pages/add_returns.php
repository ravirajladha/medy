<?php require APPROOT . '/views/inc/header.php'; ?>

            <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">New Sales Return</h4>
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
                                        <label >RMA# </label>
                                        <input type="text" class="form-control" placeholder="RMA-00004">
                                     <br>
                                        <label >Date</label>
                                       <input type="Date" name="" value="2020-07-10" class="form-control">
                                        <br>
                                        <label >Reason</label>
                                       <input type="text" name=""  class="form-control">
                                    </div>
                                    
                            </div>
                        </div>
                    </div> 
                    <!-- End col -->
                                <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Item Details</h5>
                </div>
                <div class="card-body">
                 
                          <div class="row clearfix">
                            <div class="col-md-12">
                              <table class="table table-bordered table-hover" id="tab_logic">
                                <thead>
                                  <tr>
                                    <th class="text-center"> # </th>
                                    <th class="text-center"> Items </th>
                                    <th class="text-center"> Shipped </th>
                                    <th class="text-center"> Returned </th>
                                    <th class="text-center"> Return Quantity</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr id='addr0'>
                                    <td>1</td>
                                    <td><input type="text" name='product[]'  placeholder='Enter Product Name' class="form-control"/></td>
                                    <td><input type="number" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0"/></td>
                                    <td><input type="number" name='price[]' placeholder='Enter Unit Price' class="form-control price" step="0.00" min="0"/></td>
                                    <td><input type="number" name='total[]' placeholder='0.00' class="form-control total" readonly/></td>
                                  </tr>
                                  <tr id='addr1'></tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="row clearfix">
                            <div class="col-md-12">
                              <button id="add_row" class="btn btn-default pull-left">Add Another Line</button>
                              <button id='delete_row' class="pull-right btn btn-default">X</button>
                            </div>
                          </div>


                          <div class="row clearfix" style="margin-top:20px;float: right;">
                               

                            <div class="pull-right col-md-12" style="margin-top: 30px;">
                              <table class="table table-bordered table-hover" id="tab_logic_total">
                                <!--  -->
                              </table> 

                               <a href="<?php echo URLROOT;?>/pages/sales_order"><button class="btn btn-primary" style="float: right; margin-left: 10px;">Cancle</button></a>
                                   <button class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#exampleStandardModal">Save</button>
                            </div>
                          </div>
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
                                        <label >Status: </label>
                                        <label >Item Return</label>
                                    </div>
                                     <div class="form-group">
                                        <label >Reference#</label>
                                        <input type="text" class="form-control" value="#RMA-00004">
                                    </div>

                                    <div class="form-group">
                                        <label >Sales Order Date</label>
                                         <input type="date" class="form-control" value="2020-07-12">
                                       
                                    </div>
                                     </div>
                                            <div class="modal-footer">
                                              
                                               
                                               <!--  <a href="<?php echo URLROOT;?>/pages/addinvoice"><button type="button" class="btn btn-primary">Convert to Invoice</button></a>
                                                 -->
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                   
                                   
                            </div>
                        </div>
                    </div> 
                    <!-- End col -->


         
                    
                          
                    
<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>