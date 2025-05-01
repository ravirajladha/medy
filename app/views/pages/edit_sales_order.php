<?php require APPROOT . '/views/inc/header.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
     <?php $d = new Page;  ?>
            <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">Edit Sales Order</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                             
                        </div>                        
                    </div>
                </div>          
            </div>
            <?php $p = $data['sales']; ?>

            <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->  
            <form method="POST" action="<?php echo URLROOT;?>/pages/update_sales_order" enctype="multipart/form-data">  
               <input type="text" name="id" value="<?php echo $p->id;?>" style="display: none;">
            <div class="contentbar">
                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6">
                        <div class="card m-b-30">
                            
                            <div class="card-body">
                                     <div class="form-group">
                                        <label >Customer Name</label>
                                        <?php $all_cust = $d->get_all_customers() ?>
                                        <select class="form-control" name="customer"  >
                                            
                                            <?php foreach ($all_cust as $v) { ?>
                                              <option selected="" value="<?php echo $p->customer_id."|".$p->customer_name; ?>"><?php echo $p->customer_name; ?></option>

                                                <option value="<?php echo $v->id."|".$v->customer_display_name;?>"><?php echo $v->customer_display_name;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                     <div class="form-group">
                                        <label >Sales Order#</label>
                                        <input type="text" class="form-control" placeholder="ex S0-00001" name="sales_order" value="<?php echo $p->sales_order; ?>">
                                    </div>
                                     <div class="form-group">
                                        <label >Reference#</label>
                                        <input type="text" class="form-control" placeholder="" name="reference" value="<?php echo $p->reference; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label >Sales Order Date</label>
                                         <input type="date" class="form-control" placeholder="" name="ndate" value="<?php echo date('Y-m-d', strtotime($p->ndate)); ?>">
                                         <br><br>
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
                                        <label >Expected Shipment Date</label>
                                         <input type="date" class="form-control" placeholder="" name="expected_delivery_date" value="<?php echo date('Y-m-d', strtotime($p->expected_delivery_date)); ?>">
                                    </div>
                               

                                    <div class="form-group">
                                        <label >Payment Terms</label>
                                        <select class="form-control" id="formControlSelect" name="payment_terms" onclick="ch()">
                                            <option selected="" id="c"><?php echo $p->payment_terms;?></option>
                                            <option>Due on Receipt</option>
                                            <option>Net 15</option>
                                            <option>Net 30</option>
                                            <option>Net 45</option>
                                            <option>Net 60</option>
                                            <option>Due end of the month</option>
                                            <option>Due end of the next month</option>
                                            <option>Due on Recipt</option>
                                         </select>
                                       
                                    </div>
                                    <script type="text/javascript"> 
                                      function ch()
                                      {
                                        document.getElementById('c').style.display = "none";
                                      }
                                    </script>
                                      <div class="form-group">
                                        <label >Delivery Method</label>
                                        <textarea class="form-control" name="delivery_method"><?php echo $p->delivery_method; ?></textarea>
                                    </div>
                                     <div class="form-group">
                                        <label >Salesperson</label>
                                         <textarea class="form-control" name="salesperson"><?php echo $p->salesperson; ?></textarea>
                                       
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
                                    <th class="text-center"> Product </th>
                                    <th class="text-center"> Qty </th>
                                    <th class="text-center"> Price </th>
                                    <th class="text-center"> Total </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php  $p1 = explode("|", $p->product);
                                  $p2 = explode("|", $p->qty);
                                  $p3 = explode("|", $p->price);
                                  $p4 = explode("|", $p->total);
                                   ?>
                                  <?php for($a=1,$i=0;$i<sizeof($p1); $i++,$a++) {  ?>
                                  
                                  <tr id='addr0'>
                                      <td><?php echo $a;?></td>
                                      <td>
                                        <!-- onchange="location = this.value;" -->
                                        <!-- select2-single -->
                                        <?php $d = new Page;  ?>
                                        <?php $all_items = $d->get_all_items() ?> 
                                        <select class="form-control" name='product[]'  >
                                            <option selected=""><?php echo $p1[$i]; ?></option>
                                            <?php foreach ($all_items as $it) { ?>
                                                <option value="<?php echo $it->name;?>"><?php echo $it->name;?></option>
                                            <?php }?>
                                          
                                        </select>

                                      </td>
                                      <td><input type="number" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0" value="<?php echo $p2[$i]; ?>"/></td>

                                      <td><input type="number" name='price[]' placeholder='Enter Unit Price' class="form-control price" step="0.00" min="0" value="<?php echo $p3[$i]; ?>"/></td>

                                      <td><input type="number" name='total[]' placeholder='0.00' class="form-control total" readonly value="<?php echo $p4[$i]; ?>"/></td>
                                  </tr>
                                   <?php } ?>
                                    
                                  <tr id='addr1'></tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="row clearfix">
                            <div class="col-md-12">
                              <a style="color: white;" id="add_row" class="btn btn-default pull-left">Add Another Line</a>
                              <a style="color: white;" id='delete_row' class="pull-right btn btn-default">X</a>
                            </div>
                          </div>


                          <div class="row clearfix" style="margin-top:20px;float: right;">
                               

                            <div class="pull-right col-md-12" style="margin-top: 30px;">
                              <table class="table table-bordered table-hover" id="tab_logic_total">
                                <tbody>
                                  <tr>
                                    <th class="text-center">Sub Total</th>
                                    <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly value="<?php echo $p->sub_total;?>" /></td>
                                  </tr>
                                  <tr>
                                    <th class="text-center">Tax</th>
                                    <td class="text-center"><div class="input-group mb-2 mb-sm-0">
                                        <input type="number" class="form-control" id="tax" placeholder="0" name="tax" value="<?php echo $p->tax;?>">
                                        <div class="input-group-addon">%</div>
                                      </div></td>
                                  </tr>
                                  <tr>
                                    <th class="text-center">Tax Amount</th>
                                    <td class="text-center"><input type="number" name='tax_amount' id="tax_amount" placeholder='0.00' class="form-control" readonly value="<?php echo $p->tax_amount;?>"/></td>
                                  </tr>
                                  <tr>
                                    <th class="text-center">Grand Total</th>
                                    <td class="text-center"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" readonly value="<?php echo $p->total_amount;?>"/></td>
                                  </tr>
                                </tbody>
                              </table> 
                            </div>
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
                                        <label >Customer Notes</label>
                                         <textarea class="form-control" placeholder="Enter any notes to be displayed in your transaction" name="customer_notes"><?php echo $p->customer_notes; ?></textarea>
                                         </div>
                               
                                      <div class="form-group">
                                        <label >Attach File(s)</label>
                                        <input type="file" name="files" class="form-control">
                                        previous attachment
                                        <a href="<?php echo URLROOT;?>/uploads/<?php echo $p->img;?>" download=""><?php echo $p->img;?></a>
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
                                        <label >Terms & Conditions</label>
                                         <textarea class="form-control" placeholder="Enter the terms and Conditions of your business to be displayed in your transaction " name="t_and_c"><?php echo $p->t_and_c; ?></textarea>
                                    </div>
                                    <br><br>
                                    <div class="form-group" style="float: right;">
                                     <button type="Submit" class="btn btn-primary" >Update</button>
                                      <a class="btn btn-primary" href="<?php echo URLROOT;?>/pages/sales_order" style="color: white;">Cancle</a> &nbsp;
                                     </div>
                                    
                                    
                            </div>
                        </div>
                    </div> 
                    <!-- End col -->
                </div>  
            </div>
            </form>
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

<script>
  $('#tags').keyup(function(){
      var searchedName = $('#tags').val();
      if(searchedName.length > 2)
      {
       var location = $('#search_input').val();
          $.ajax({
        url: '<?php echo URLROOT; ?>/pages/get_all_items',
        type: "POST",
        data: {searchedName, location},
        success : function(res)
        {
          $('.dropDownAjax').html(res);
        }
          });
      }
  });
  </script>
  <div class="form-group">
    <!-- <input type="text" class="form-control" id="search_input" placeholder="Type address..." /> -->
    <input type="hidden" id="loc_lat" />
    <input type="hidden" id="loc_long" />
</div>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyB4w76d1YypSdzwTx-sch_JUaDimfw3jZk"></script>

<script>
    $(document).on('change', '#'+searchInput, function () {
        document.getElementById('latitude_input').value = '';
        document.getElementById('longitude_input').value = '';
        
        document.getElementById('latitude_view').innerHTML = '';
        document.getElementById('longitude_view').innerHTML = '';
    });
    var searchInput = 'search_input';

$(document).ready(function () {
    var autocomplete;
    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
        types: ['geocode'],
    });
  
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var near_place = autocomplete.getPlace();
        document.getElementById('loc_lat').value = near_place.geometry.location.lat();
        document.getElementById('loc_long').value = near_place.geometry.location.lng();
    
        document.getElementById('latitude_view').innerHTML = near_place.geometry.location.lat();
        document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng();
    });
});
</script>    
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">

                swal("<?php echo $_SESSION['success']; ?>");
    </script>
  <?php } unset($_SESSION['success']); ?>            
                    
<?php require APPROOT . '/views/inc/footer.php'; ?>
