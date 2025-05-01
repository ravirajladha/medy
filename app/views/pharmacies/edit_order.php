<?php require APPROOT .'/views/inc_pharmacy/header.php';
$invoice_id_edit = 0; 
$pharmObj = new Pharmacy;
?>
<style type="text/css">
   .ui-autocomplete {
            max-height: 100px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
            font-size: 13px;
        }

        .listt{
        max-height: 100px;
        max-width: 326px;
        min-width: 326px;
        position: absolute;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        font-size: 17px;
        cursor: pointer;
        z-index: 50;
        text-align: left;
        }
       
       #listt0,#list5{
        max-height: 100px;
        max-width: 368px;                         
        min-width: 368px;
        position: absolute;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        font-size: 17px;
        cursor: pointer;
        z-index: 50;
        text-align: left;
      }

      #list2{
        max-height: 100px;
        max-width: 100px;
        min-width: 100px;
        position: absolute;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        padding-left: 10px;
        font-size: 13px;
        cursor: pointer;
      }

      #list3, #list4{
        max-height: 100px;
        max-width: 200px;
        min-width: 200px;
        position: absolute;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        padding-left: 0px;
        font-size: 17px;
        cursor: pointer;
        text-align: left;
      }
      .cc:hover, .cccc:hover, .ee:hover, .ff:hover
      {
        background-color: lightgray;
      }
      .cc,.ee,.ff,.cccc{
        padding: 3px;
        border-bottom: 1px #F8F9F9 solid;
      }

</style>
<script type="text/javascript">
  $(document).ready(function(){
  $('#tab_logic tbody').on('keyup change',function(){
    calc();
  });
  $('#tab_logic tbody').change(function(){
    calc();
  });
  $('#tax').on('keyup change',function(){
    calc_total();
  });
  $('#discount').on('keyup change',function(){
    calc_total();
  });
  $('#shippingcost').on('keyup change',function(){
    calc_total();
  });
  $('#handlingcost').on('keyup change',function(){
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
  discount=$('#discount').val();
  var distype = discount[discount.length -1];
    if(distype=="%"){
    discount=total/100*parseInt(discount);
    }
    $('#tax_amount').val(tax_sum.toFixed(2));
  $('#tata').val((tax_sum+total-discount).toFixed(2));
}
</script>


<style type="text/css">
  input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
</style>
<div class="row">
<div class="col-md-12">
  <div class="panel panel-default">
      <div class="table-responsive">
      <form action="<?php echo URLROOT; ?>/pharmacies/saveEditOrderDetail/<?php echo $data['id'] ?>" method="POST">
      <table class="table table-bordered table-hover" id="tab_logic">
        <thead>
          <tr>
            <th class="text-center"> Drug Name </th>
            <th class="text-center" style="width: 120px;"> Batch </th>
            <th class="text-center" style="width: 80px;"> Qty </th>
            <th class="text-center" style="width: 120px;"> Price</th>
            <th class="text-center" style="width: 120px;"> Total</th>
          </tr>
        </thead>
        
        <tbody id="addr1">
          
          <?php foreach ($data['edit'] as $key) {
          ?>
          <tr>
            <td>
              <input type="number" name="id[]" style="display: none;" value="<?php echo $key->edit_id; ?>">
              <input <?php if($key->edit_status == 1) { ?>id="searchbox" <?php } ?> type="text" name='product[]' placeholder='Drug Name/Drug ID/Barcode' class="form-control searchInput" autocomplete="off" value="<?php if($key->edit_drug_name != NULL) { echo $key->edit_drug_name;?>(<?php echo $key->edit_drug_id;?>) <?php } ?>" <?php if($key->edit_status == 0) { ?> readonly <?php } ?>>
              <?php if($key->edit_status == 1) { ?>
              <div id="listt0"></div>
              <?php } ?>
            </td>
            
            <td><select type="text" <?php if($key->edit_status == 1) { ?>id="bat" <?php } ?> class="mName form-control" name='bat[]' placeholder='Enter Batch' class="form-control" step="0" min="0">
              <?php if($key->edit_status == 0) { ?>
                  <option><?php echo $key->edit_batch; ?></option>
              <?php } ?>
              <?php if($key->edit_status == 1) { ?>
                  <option><?php echo $key->edit_batch; ?></option>
              <?php } ?>
            </select></td>
            <td><input type="number" <?php if($key->edit_status == 1) { ?>id="qtybox" <?php } ?> name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" value="<?php echo $key->edit_qty ?>" <?php if($key->edit_status == 0) { ?> readonly <?php } ?>></td>
            <td><input type="number" <?php if($key->edit_status == 1) { ?>id="cost" <?php } ?> name='price[]' placeholder='Enter Unit Price'  class="form-control price" step="0.00" min="1" value="<?php echo $key->edit_price; ?>" <?php if($key->edit_status == 0) { ?> readonly <?php } ?>>
            </td>
            <td><input type="number" id="totalbox" name='total[]' placeholder='0.00' class="form-control total" readonly/></td>
            <td style="width: 120px;">
              <?php if($key->edit_status != 1) { ?>
              <button class="btn btn-info btn-sm btn_remove" type="submit" name="edit" value="<?php echo $key->edit_id; ?>"><i class="ion-edit"></i></button>
              <?php } ?>
              <button class="btn btn-warning btn-sm btn_remove" type="submit" name="remove" value="<?php echo $key->edit_id; ?>"><i class="ion-close-round"></i></button>

            </td>
          </tr>
          <?php } ?>
        </tbody>
        </table>
        <button type="submit" id="add_row" class="btn btn-info" name="add">Add Row</button>
        <button class="defaultSubmit" type="submit" name="default" style="display: none;">DefaultSubmit</button>
        </form>
          <div class="pull-right">
            <table class="table table-bordered table-hover"><tr>
                  <th class="text-center">Sub Total</th>
                  <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly/></td>
                </tr>
            </table>
          </div>
          <div id="avl_stock_w" style="display: none;"><br><span style="color: red">Available Stock: </span><span id="avl_stock" style="color: red">f</span></div>
        </div>
    
  </div>
<div class="panel panel-default">
  <div class="row clearfix">
    <div class="col-md-12">  
    
  <div class="row clearfix" style="margin-top:20px">
    <div class="col-md-4">
      <table class="table table-bordered table-hover" id="tab_logic_total">
        <?php foreach ($data['invoice_details'] as $value) {
        ?>
        <tbody>
          <tr>
            <th class="text-center">Patient Name</th>
            <td class="text-center">
              <input type="text" id="cust" class="searchcustInput form-control" placeholder="Patient Name / ID" name="customer_val" autocomplete="off" value="<?php echo $value->invoice_name; ?>">
              <div id="list3" style="display: none;"></div>
             </td>
          </tr>
          <tr>
            <th class="text-center">Doctor Name</th>
            <td class="text-center">
              <input type="text" id="doc" class="searchcustInput form-control" placeholder="Doctor Name / ID" name="customer_val" autocomplete="off" value="<?php echo $value->invoice_doctor; ?>">
             </td>
          </tr>
          <tr>
            <th class="text-center">IP/OP ID</th>
            <td class="text-center">
              <input type="text" id="ipop" class="searchcustInput form-control" placeholder="IP/OP ID" name="customer_val" autocomplete="off" value="">
             </td>
          </tr>
          <tr>
          </tr>
        </tbody>
        <?php } ?>
      </table>
    </div>
    <div class="col-md-4">
      <table class="table table-bordered table-hover" id="tab_logic_total">
        <tbody>
          <tr>
            <th class="text-center">Discount <br>(Amt or %)</th>
            <td class="text-center">
                <input type="text" class="form-control" id="discount" placeholder="0" name="discount_val">
             </td>
          </tr>
          <tr>
            <th class="text-center">Extra Tax</th>
            <td class="text-center"><div class="input-group mb-2 mb-sm-0">
                <input type="number" class="form-control" id="tax" placeholder="0" name="extra_tax">
                <div class="input-group-addon">%</div>
              </div></td>
          </tr>
           <tr>
            <th class="text-center">Tax Amount</th>
            <td class="text-center"><input type="number" name='tax_amount' id="tax_amount" placeholder='0.00' class="form-control" readonly/></td>
          </tr>
         
        </tbody>
      </table>
    </div>
    <div class="col-md-4">
      <table class="table table-bordered table-hover" id="tab_logic_total">
        <tbody>
          <tr>
            <th class="text-center">Grand Total</th>
            <td class="text-center"><input type="number" name='total_amount' id="tata" placeholder='0.00' class="form-control" readonly/></td>
          </tr>
          <tr>
            <th class="text-center">Pay Mode</th>
            <td class="text-center">
                <select class="form-control" name="pay_mode_val" id="paymode">
                  <option value="Debit Card">Debit Card</option>
                  <option value="Credit Card">Credit Card</option>
                  <option value="Cash">Cash</option>
                  <option value="Net Banking">Net Banking</option>
                  <option value="Digital Wallets">Digital Wallets</option>
                </select>
             </td>
          </tr>
          <tr>
            <th class="text-center">Amount Paid</th>
            <td class="text-center">
                <input type="number" id="amt_paid" class="form-control" placeholder="0" name="amount_paid_val">
            </td>
          </tr>
        </tbody>
      </table>
    </div>
      <button style="margin-right: 10px;" id="refresh" type="button" class="btn btn-warning pull-right">Cancel</button> 
      <button style="margin-right: 10px;" id="sp" type="button" class="btn btn-purple pull-right">Submit & Print</button> 
      <button style="margin-right: 10px;" id="sub" type="button" class="btn btn-info pull-right">Submit</button>
      <button style="margin-right: 10px;display: none;" id="sav" type="button" class="btn btn-success pull-right">Save</button>
  </div>
  </form>
</div>
</div>
</div>
</div>
 
<script type="text/javascript">
  $(document).ready(function(){
    calc();
    calc_total();
  });
</script>
<script type="text/javascript">
    $(document).ready(function(){
      $('#searchbox').keyup(function(){
        var query = $(this).val();
        if(query!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/pharmacies/get_drug_autocomplete',
            type:'POST',
            data:{query:query},
            success:function(data)
            {
              $('#listt0').fadeIn();
              $('#listt0').html(data);
            }
          });
        }
        else
        {
           $('#listt0').fadeOut();
        }
      });
       $(document).on('click', '.cc', function(){  
           $('#searchbox').val($(this).text());
           $('#listt0').fadeOut();
           var amt = $('#searchbox').val();
           var q = 1;
           if(amt!=0)
           {
            $.ajax({
              url:'<?php echo URLROOT;?>/pharmacies/get_drug_cost1',
              type:'POST',
              data:{amt:amt},
              success:function(data)
              {
                $('#bat').html(data);
                $('#qtybox').val(q);
                calc();
              }
            });
           }  
      });

        $("#bat").change(function(){
            var selected = $(this).children("option:selected").val();
            $.ajax({
              url:'<?php echo URLROOT;?>/pharmacies/get_drug_cost2',
              type:'POST',
              data:{selected},
              success:function(data)
              {
                var com = data.split('|');
                $('#cost').val(com[1]);
                // $('#avl_stock_w').show();
                // $('#avl_stock').text(com[0]);
                calc();
              }
            });            
        });
       
      $(document).click(function (event){
        $('#listt0').fadeOut(); 
      }); 
    });
  </script>


  <div class="gototop js-top">
  <a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
  </div>
  <!-- jQuery -->
  <script src="js/jquery-ui.js"></script>
  <!-- jQuery Easing -->
  <script src="js/jquery.easing.1.3.js"></script>
  <!-- Bootstrap -->
  <!-- Waypoints -->
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- countTo -->
  <script src="js/jquery.countTo.js"></script>
  <!-- Magnific Popup -->
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/magnific-popup-options.js"></script>
  <!-- Stellar -->
  <script src="js/jquery.stellar.min.js"></script>
  <!-- Main -->
  <script src="js/main.js"></script>
  <script src="js/admin.js"></script>
  <script src="<?php echo URLROOT;?>/js/sample.js"></script>
  <script type="text/javascript" src="order_list_script.js"></script> 

  
  
<?php require APPROOT .'/views/inc_pharmacy/footer.php';?>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript">
    $('#sub').click(function(){
      $(".defaultSubmit").click();
    });
  </script>

  <?php
    if(isset($_SESSION['forCheckEditComplete']))
    {
      ?>  
          <script type="text/javascript">
            setTimeout(
  function() 
  {
    //do something special
  
            $(document).ready(function(){
              var invId = <?php echo $data['id']; ?>;
              var drugName =  $('input[name^=product]').map(function(idx, elem)
                              {
                                return $(elem).val();
                              }).get();
              var qty = $('input[name^=qty]').map(function(idx, elem)
                        {
                          return $(elem).val();
                        }).get();
              var bat = $('select[name^=bat]').map(function(idx, elem)
                        {
                          return $(elem).val();
                        }).get();
              var service_id = '';

              for (var i = 0; i < drugName.length; i++)
              {
                var namex= drugName[i].split('(')[1];
                service_id+= namex.split(')')[0];
                service_id+=',';
                service_id+= qty[i];
                service_id+=',';
              }          
              var patientName = $('#cust').val();
              var doctorName = $('#doc').val();
              var ipOp = $('#ipop').val();
              var grandTotal = $('#tata').val();
              var payment = $('#paymode').val();
              var amountPaid = $('#amt_paid').val();
              var invoiceId = <?php echo $data['id']; ?>;
              var invoice_bill = $('#sub_total').val();
              var discount = $('#discount').val();
              if(drugName.includes('') || qty.includes('') || bat.includes(''))
              {
                swal("Do not leave any fields Empty.");
              }
              else
              {
                $.ajax({
                    url : '<?php echo URLROOT; ?>/pharmacies/editInvoiceSubmit',
                    type : 'POST',
                    data : {service_id, drugName, qty, bat, patientName, doctorName, ipOp, grandTotal, payment, amountPaid, invoiceId, discount, invoice_bill},
                    success : function(res)
                    {
                      swal(res);
                      window.location.replace("<?php echo URLROOT;?>/pharmacies/all_orders");
                    }
                });
              }
            });
          }, 2000);
          </script>
      <?php
    }
  ?>

<!--   <script type="text/javascript">
    function submitTheData()
    {  
      var drugName = $('input[name^=product]').map(function(idx, elem)
                      {
                        return $(elem).val();
                      }).get();
      var qty = $('input[name^=qty]').map(function(idx, elem)
                {
                  return $(elem).val();
                }).get();
      var bat = $('select[name^=bat]').map(function(idx, elem)
                {
                  return $(elem).val();
                }).get();
      var patientName = $('#cust').val();
      var doctorName = $('#doc').val();
      var ipOp = $('#ipop').val();
      var grandTotal = $('#tata').val();
      var payment = $('#paymode').val();
      var amountPaid = $('#amt_paid').val();
      var invoiceId = <?php //echo $data['id']; ?>;
      if(drugName.includes('') || qty.includes('') || bat.includes(''))
      {
        swal("Do not leave any fields Empty.");
      }
      else
      {
        $.ajax({
            url : '<?php //echo URLROOT; ?>/pharmacies/editInvoiceSubmit',
            type : 'POST',
            data : {drugName, qty, bat, patientName, doctorName, ipOp, grandTotal, payment, amountPaid, invoiceId},
            success : function(res)
            {
              if(res === "medhike")
              {
                swal(res);
              } 
              else
              {
                swal(res);
              } 
            }
        });
      }
    }
  </script> -->

