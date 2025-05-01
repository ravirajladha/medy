<?php require APPROOT .'/views/inc_pharmacy/header.php';
$invoice_id_edit = 0; 
?>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
$(document).ready(function(){
  var i=1;
 
  $('#add_row').click(function(){
    i++;
    $('#addr1').append('<tr id="row'+i+'">\
            <td class="xyz" id="'+i+'"><input id="set'+i+'" type="text" name="product[]" placeholder="Item Name" class="form-control" autocomplete="off" />\
            <div id="listt'+i+'" class="listt" style="display: none"></div></td>\
            <td><input type="number" id="qtybox'+i+'" name="qty[]" placeholder="Enter Qty" class="form-control qty" step="0" min="0"/></td>\
            <td><input type="text" id="bat'+i+'" name="bat[]" placeholder="Enter Actual Price" class="form-control" step="0" min="0"/></td>\
            <div id="list" style="display: none"></div></td>\
            <td><input type="number" id="cost'+i+'" name="price[]" placeholder="Enter Unit Price" class="form-control price" step="0.00" min="0"/>\
            </td>\
            <td><input type="date" name="due_date[]" class="form-control"/></td>\
            <td><input type="number" id="totalbox" name="total[]" placeholder="0.0" class="form-control total" readonly/></td>\
            <td><a class="btn btn-warning btn-sm btn_remove" id="'+i+'">X</a></td></tr>');

  });
  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id"); 
    $('#row'+button_id+'').remove();
  });

$(document).on('keyup', '.xyz', function(){
    var button_idq = $(this).attr("id"); 
    var query = $('#set'+button_idq+'').val();
    $.ajax({
            url:'<?php echo URLROOT;?>/pharmacies/get_drug_autocomplete1',
            type:'POST',
            data:{query,button_idq},
            success:function(data)
            {
              $('#listt'+button_idq+'').fadeIn();
              $('#listt'+button_idq+'').html(data);
            }
          });
  });


    });
  </script>

  <script type="text/javascript">
    function mydat_val(u,y,w)
    {
        var amt = y;
        var r = document.getElementById('new'+y+'').getAttribute('value');
        document.getElementById('set'+u+'').value=r;
        document.getElementById('qtybox'+u+'').value=1;
        // document.getElementById('cost'+u+'').value=w;
        $.ajax({
              url:'<?php echo URLROOT;?>/pharmacies/get_drug_costx',
              type:'POST',
              data:{amt},
              success:function(data)
              {
                $('#bat'+u+'').html(data);
                calc();
              }
            });

        $('#bat'+u+'').change(function(){
          var selected = $(this).children("option:selected").val();
          $.ajax({
            url:'<?php echo URLROOT;?>/pharmacies/get_drug_cost2',
            type:'POST',
            data:{selected},
            success:function(data)
            {
              var com = data.split('|');
              $('#cost'+u+'').val(com[1]);
              $('#avl_stock_w').show();
              $('#avl_stock').text(com[0]);
              calc();
            }
          });            
        });
        calc();
        $(document).ready(function(){
         $(document).click(function (event){
        $('#listt'+u+'').fadeOut(); 
      });
        });
    }
  </script>



<script>
    
    $(document).ready(function(){
    var i=1;
    $("#add_rowddd").click(function(){b=i-1;
        $('#addr'+i).html($('#addr'+b).html()).find('td:first-child').html(i+1);
        $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
        i++; 


        $('#addr'+j+ ' .batchval').empty();
        $('<option>').val('0').text('Select Batch').appendTo('#addr'+j+ ' .batchval');
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
        max-width: 400px;
        min-width: 400px;
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
<div class="row">
<div class="col-md-12">
  <div class="panel panel-default">
    <form action="<?php echo URLROOT;?>/pharmacies/save_invoice_s" method="POST">
        <div class="table-responsive">
      <table class="table table-bordered table-hover" id="tab_logic">
        <thead>
          <tr>
            <th class="text-center"> Item Name </th>
            <th class="text-center" style="width: 120px;"> Qty </th>
            <th class="text-center" style="width: 120px;"> Item Price/Item </th>
            
            <th class="text-center" style="width: 150px;">Buying Price/Item</th>
            <th class="text-center" style="width: 180px;"> Due Date </th>
            <th class="text-center" style="width: 180px;"> Total </th>
          </tr>
        </thead>
        <tbody id="addr1">
          <tr>
            <td><input id="searchbox" type="text" name='product[]' placeholder='Enter Item Name' class="form-control searchInput" autocomplete="off" />
            <div id='listt0' style="display: none"></div></td>
           

            <td><input type="number" id="qtybox" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0"/></td>
             <td><input type="text" id="bat" name='bat[]' placeholder='Enter Actual Price' class="form-control" step="0" min="0"/></td>
            <td><input type="number" id="cost" name='price[]' placeholder='Enter Unit Price' class="form-control price" step="0.00" min="0"/>
            <!-- <div id="cost"></div> -->
            </td>
            <td><input type="date" name='due_date[]' class="form-control"/></td>
            
            <td><input type="number" id="totalbox" name='total[]' placeholder='0.00' class="form-control total" readonly/></td>
            <td><!-- <a href="#" class="btn btn-warning btn-sm" onClick="rempro($(this).closest('tr').attr('id'));">X</a> --></td>
          </tr>
        </tbody>
        </table>
        <button type="button" id="add_row" class="btn btn-info">Add Row</button>
          <div class="pull-right">
            <table class="table table-bordered table-hover"><tr>
                  <th class="text-center">Sub Total</th>
                  <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly/></td>
                </tr>
            </table>
          </div>
          <!-- <div id="avl_stock_w" style="display: none;"><br><span style="color: red">Available Stock: </span><span id="avl_stock" style="color: red">f</span></div> -->
        </div>
    
  </div>
<div class="panel panel-default">
  <div class="row clearfix">
    <div class="col-md-12">  
    
  <div class="row clearfix" style="margin-top:20px">
    <div class="col-md-4">
      <table class="table table-bordered table-hover" id="tab_logic_total">
        <tbody>
         <tr>
            <th class="text-center">Mode Of Delivery</th>
            <td class="text-center">
              <input type="text"  class="searchcustInput form-control" placeholder="Enter Mode Of Delivery" name="customer_val" autocomplete="off">
             <!--  <div id="list4" style="display: none;"></div> -->
             </td>
          </tr>
          <tr>
            <th class="text-center">GST</th>
            <td class="text-center"><div class="input-group mb-2 mb-sm-0">
                <input type="number" class="form-control" id="tax" placeholder="0" name="extra_tax">
                <div class="input-group-addon">%</div>
              </div></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-md-4">
      <table class="table table-bordered table-hover" id="tab_logic_total">
        <tbody>
          <tr style="display: none;">
            <th class="text-center">Discount <br>(Amt or %)</th>
            <td class="text-center">
                <input type="text" class="form-control" id="discount" placeholder="0" name="discount_val">
             </td>
          </tr>
          
           <tr>
            <th class="text-center">Tax Amount</th>
            <td class="text-center"><input type="number" name='tax_amount' id="tax_amount" placeholder='0.00' class="form-control" readonly/></td>
          </tr>
          <tr>
            <th class="text-center">Grand Total</th>
            <td class="text-center"><input type="number" name='total_amount' id="tata" placeholder='0.00' class="form-control" readonly/></td>
          </tr>
         
        </tbody>
      </table>
    </div>
    <div class="col-md-4">
      <table class="table table-bordered table-hover" id="tab_logic_total">
        <tbody>
          
          <tr>
            <th class="text-center">Payment Terms</th>
            <td class="text-center"><input type="number" name="payment_terms" id="tata" placeholder='Number of Terms' class="form-control"/></td>
          </tr>

          <tr>
            <th class="text-center">Final Expected Date</th>
            <td class="text-center">
                <input type="date" id="amt_paid" class="form-control" placeholder="0" name="expected_date">
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-md-12">
      <table class="table table-bordered table-hover" id="tab_logic_total">
        <tbody>
           <tr>
            <th class="text-center" width="200">Company Name</th>
            <td class="text-center">
              <input type="text" id="cust" class="searchcustInput form-control" placeholder="Enter Company Name" name="comany_name" autocomplete="off">
              <div id="list3" style="display: none;"></div>
             </td>
          </tr>
          <!-- <tr>
            <th class="text-center">Comany Address</th>
            <td class="text-center"><input type="text" name='comapny_details' placeholder='Comany Address' class="form-control"/></td>
          </tr> -->
          <tr>
            <th class="text-center">Delivery Address</th>
            <td class="text-center"><input type="text" name="delivery_address" placeholder='Delivery Address' class="form-control" value="<?php echo $data['add'] ?>"></td>
          </tr>
        </tbody>
      </table>
    </div>
      <button style="margin-right: 10px;" id="refresh" type="button" class="btn btn-warning pull-right">Cancel</button> 
      <button style="margin-right: 10px;" type="submit" class="btn btn-purple pull-right">Submit & Print</button>
  </div>
  </form>
</div>
</div>
  <div id="add_btn_for_save">
  <?php if(isset($_SESSION['service_id']))
    {
       // 3,1,General Ward Nursing Charge ,200
      $ser = $_SESSION['service_id'];
      $ser1 = explode(',',$ser);
      $serid = $ser1[0];
      $serq = $ser1[1];
      $sern = json_encode($ser1[2]);
      $serc = $ser1[3];
      $_SESSION['invoice_bill'];
      $_SESSION['grand_total'];
      $pname = json_encode($_SESSION['patient_name']);
      $dname = json_encode($_SESSION['doctor_name']);
      $ipopid = json_encode($_SESSION['ipopid']);
      $paydet = json_encode($_SESSION['pay_mode']);
      $amtpaid = json_encode($_SESSION['amount_paid']);
  ?>
  
    <button class="btn btn-danger btn-xs m-b-5" onclick="de();">Click here</button> to access previously saved data

  <?php
    }
  ?>
   </div>
</div>

  

</div>
 
<?php
    if(isset($data['edit_order_details']))
    {
      foreach ($data['edit_order_details'] as $key)
      {
        $service_name = json_encode($key->invoice_item);
        $patient_name = json_encode($key->invoice_name);
        $invoice_id_edit = $key->invoice_id;
      }
?>
      <script type="text/javascript">
        var i = <?php echo $service_name;?>;
        var p_name = <?php echo $patient_name;?>;
        i = i.split(',');
        var s_name = i[2];
        s_name += '|';
        s_name += i[0];
        var qty = i[1];
        document.getElementById('searchbox').value = s_name;
        document.getElementById('qtybox').value = qty;
        document.getElementById('cost').value = i[3];
        document.getElementById('cust').value = p_name;
        calc();
      </script>
<?php
    }
?>

<?php
  if(isset($data['patient_name']))
  {
    foreach ($data['vis_id_det'] as $key)
    {
        $p_n_id = $key->opd_patient_id;
        $d_n_id = $key->opd_doctor_id;
    }

    $p_vis_id = $data['vis_id'];

    foreach ($data['patient_name'] as $key1)
    {
        $p_name_opd = json_encode($key1->patient_name);
    }

    foreach ($data['doctor_name'] as $key2)
    {
        $d_name_opd = json_encode($key2->doctor_name);
    }
    ?>
    <script type="text/javascript">
      var p_id_opd = <?php echo $p_n_id;?>;
      var d_id_opd = <?php echo $d_n_id?>;
      var p_vis_id = <?php echo $p_vis_id;?>;
      var p_name_opd = <?php echo $p_name_opd;?>;
      p_name_opd += '|';
      p_name_opd += p_id_opd;
      var d_name_opd = <?php echo $d_name_opd?>;
      d_name_opd += '|';
      d_name_opd += d_id_opd;
      
      document.getElementById('cust').value = p_name_opd;
      document.getElementById('doc').value = d_name_opd;
      document.getElementById('ipop').value = p_vis_id;
    </script>
    <?php
  }
?>

   <script>
   $(function() {
    var options = {
        source: 'product_name.php'
    };
    $(document.body).on('focus', 'input.searchInput' ,function(){
        $(this).autocomplete(options);
    });
    });

   $(function() {
    var options = {
        source: 'customer_name.php'
    };
    $(document.body).on('focus', 'input.searchcustInput' ,function(){
        $(this).autocomplete(options);
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

  
  <script type="text/javascript">
    $(document).ready(function(){
      $('.searchInput').keyup(function(){
        var query = $(this).val();
        if(query!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/pharmacies/get_auto_item_name',
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
           $('.searchInput').val($(this).text());
           $('#listt0').fadeOut();
           var amt = $('.searchInput').val();
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
                $('#avl_stock_w').show();
                $('#avl_stock').text(com[0]);
                calc();
              }
            });            
        });
       
      $(document).click(function (event){
        $('#listt0').fadeOut(); 
      }); 
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function(){
      $('#batchbox').click(function(){
        var query2 = $('#searchbox').val();
        if(query2!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/receptions/get_auto_batch',
            type:'POST',
            data:{query2:query2},
            success:function(data)
            {
              $('#list2').fadeIn();
              $('#list2').html(data);
            }
          });
        }
      });
      $(document).on('click', '.dd', function(){  
           $('#batchbox').val($(this).text()); 
           $('#list2').fadeOut();
           var amt = $('#batchbox').val();
           // alert(amt);
           if(amt!=0)
           {
            $.ajax({
              url:'<?php echo URLROOT;?>/admins/get_value_of_amt',
              type:'POST',
              data:{amt:amt},
              success:function(data)
              {
                $('#cost').val(data);
                calc();
              }
            });
           }
      }); 
    });
  </script>



  <script type="text/javascript">
     $(document).ready(function(){
      $('#cust').keyup(function(){
        var query3 = $(this).val();
        if(query3!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/pharmacies/get_auto_doc_name',
            type:'POST',
            data:{query3:query3}, 
            success:function(data)
            {
              $('#list3').fadeIn();
              $('#list3').html(data);
            }
          });
        }
        else
        {
          $('#list3').fadeOut();
        }
      });
       $(document).on('click', '.ff', function(){  
           $('#cust').val($(this).text());  
           $('#list3').fadeOut();  
      });
      $(document).click(function (event){
        $('#list3').fadeOut(); 
      });  
    });
  </script>

  <script type="text/javascript">
     $(document).ready(function(){
      $('#doc').keyup(function(){
        var query3 = $(this).val();
        if(query3!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/receptions/get_auto_doc_name',
            type:'POST',
            data:{query3:query3}, 
            success:function(data)
            {
              $('#list4').fadeIn();
              $('#list4').html(data);
            }
          });
        }
        else
        {
          $('#list4').fadeOut();
        }
      });
       $(document).on('click', '.ee', function(){  
           $('#doc').val($(this).text());  
           $('#list4').fadeOut();  
      });
      $(document).click(function (event){
        $('#list4').fadeOut(); 
      });  
    });
  </script>


  <script>
    $("#refresh").click(function(){

        if(confirm("Are you sure you want to cancel this?")){
            $('#fed').trigger("reset");
        }
        else{
            return false;
        }
    });
</script>
<script type='text/javascript'>
  function xsave(b)
  {
    // var inv_id_edit = <?php echo $invoice_id_edit;?>;
    var n_name = $('input[name^=product]').map(function(idx, elem)
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

    for (var i = 0; i < n_name.length; i++)
    {
      var namex= n_name[i].split('(')[1];
      service_id+= namex.split(')')[0];
      service_id+=',';
      service_id+= qty[i];
      service_id+=',';
    }
    var invoice_bill = $('#sub_total').val();
    var grand_total = $('#tata').val();
    var patient_name = $('#cust').val();
    var doctor_name = $('#doc').val();
    var ipopid = $('#ipop').val();
    var pay_mode = $('#paymode').children('option:selected').val();
    var amount_paid = $('#amt_paid').val();
    var discount = $('#discount').val();

    // alert(service_id + bat + invoice_bill + grand_total + patient_name + doctor_name + ipopid + pay_mode + amount_paid);
    if(n_name == "")
    {
      alert("Fill all the fields.");
    }

    else
    {
      if(b==1)
    {
      var status = 'saved';
    }
    else if(b==2)
    {
      var status = 'submit,0,0';
    }
    else
    {
      var status = 'submit_and_print,0,1';
    }

    $.ajax({
              url:'<?php echo URLROOT;?>/pharmacies/save_invoice',
              type:'POST',
              data:{service_id,bat,invoice_bill, grand_total, patient_name, doctor_name, ipopid, pay_mode, amount_paid, discount},
              success : function(data)
              {
                  alert(data);
                  // $('#fed').trigger('reset');
                  // $('#add_btn_for_save').html('<button class="btn btn-danger btn-xs m-b-5" onclick="de();">Click here</button> to access previously saved data');
                  // if(b==2)
                  // {
                  //     window.location.replace("<?php echo URLROOT;?>/receptions/view_invoice/"+inv_id_edit+"");
                  // }

                  // if(b==3)
                  // {
                  //     window.location.replace("<?php echo URLROOT;?>/receptions/print_invoice/"+inv_id_edit+"");
                  // }
              }
          });
    }
  }
    
  
</script>

  <script type="text/javascript">
    function checkpro (alo,trid) {
    $.ajax({
        type: 'POST',
        url: 'find_batch.php',
        data: { proname: alo },
        success: function(response) {
          response = JSON.parse(response);
          $('#'+trid+' .batchval').empty();
          $('<option>').val('0').text('Select Batch').appendTo('#'+trid+' .batchval');
          for(var i=0;i<response.length;i++){
            $('<option>').val(response[i]).text(response[i]).appendTo('#'+trid+' .batchval');
            }
        }
    });

    }

    function checkbatch (balo,trid) {
    $.ajax({
        type: 'POST',
        url: 'product_cost.php',
        data: { batchname: balo },
        success: function(response) {
            $('#' + trid + ' input:eq(2)').val(response);
        }
    });
    }

    function rempro (rmtrid) {
    $('#' + rmtrid).hide();
    $('#' + rmtrid).find('input, textarea, button, select').attr('disabled','disabled');
    }

$(document).keydown(function(e) {
    if (e.altKey && e.shiftKey){
    $('#add_row').trigger('click');
    }
})



"use strict";
$('#lglogo').hide();
var Dashboard = function () {
  var global = {
    tooltipOptions: {
      placement: "right"
    },
    menuClass: ".c-menu"
  };

  var menuChangeActive = function menuChangeActive(el) {
    var hasSubmenu = $(el).hasClass("has-submenu");
    $(global.menuClass + " .is-active").removeClass("is-active");
    $(el).addClass("is-active");

    // if (hasSubmenu) {
    //  $(el).find("ul").slideDown();
    // }
  };

  var sidebarChangeWidth = function sidebarChangeWidth() {
    var $menuItemsTitle = $("li .menu-item__title");

    $("body").toggleClass("sidebar-is-reduced sidebar-is-expanded");
    $(".hamburger-toggle").toggleClass("is-opened");

    if ($("body").hasClass("sidebar-is-expanded")) {
      $('#smlogo').hide();
            $('#lglogo').show();
      $('[data-toggle="tooltip"]').tooltip("destroy");
    } else {
      $('#lglogo').hide();
            $('#smlogo').show();
      $('[data-toggle="tooltip"]').tooltip(global.tooltipOptions);
    }
  };

  return {
    init: function init() {
      $(".js-hamburger").on("click", sidebarChangeWidth);

      $(".js-menu li").on("click", function (e) {
        menuChangeActive(e.currentTarget);
      });

      $('[data-toggle="tooltip"]').tooltip(global.tooltipOptions);
    }
  };
}();

Dashboard.init();
//# sourceURL=pen.js
  </script>
  <script type="text/javascript">
    function de()
    {
      var ser = <?php echo $sern?>;
      ser+=' | ';
      ser+= <?php echo $serid?>;
      var serq = <?php echo $serq?>;
        var serc = <?php echo $serc?>;
        var pname = <?php echo $pname?>;
        var dname = <?php echo $dname?>;
        var ipopid = <?php echo $ipopid?>;
        var paydet = <?php echo $paydet?>;
        var amtpaid = <?php echo $amtpaid?>;
        document.getElementById('searchbox').value = ser;
        document.getElementById('qtybox').value = serq;
        document.getElementById('cost').value = serc;
        document.getElementById('cust').value = pname;
        document.getElementById('doc').value = dname;
        document.getElementById('ipop').value = ipopid;
        document.getElementById('paymode').value = paydet;
        document.getElementById('amt_paid').value = amtpaid;
        calc();
    }
  </script>
 
<?php require APPROOT .'/views/inc_pharmacy/footer.php';?>

