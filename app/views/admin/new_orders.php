<?php require APPROOT .'/views/inc_admin/header.php';

$invoice_id_edit = 0; 

?>
<style type="text/css">
  input[type=number]::-webkit-inner-spin-button, 
  input[type=number]::-webkit-outer-spin-button
  { 
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      margin: 0; 
  }
</style>
<style type="text/css">
        .mid_pad{
          padding-top: 20px !important;
        }
        .listt{
         max-height: 100px;
        max-width: 414px;
        min-width: 414px;
        position: absolute;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        font-size: 13px;
        cursor: pointer;
        z-index: 50;
        text-align: left;
        }
       
       #listt0,#list5{
        max-height: 100px;
        max-width: 464px;
        min-width: 464px;
        position: absolute;
        overflow-y: auto;
        overflow-x: hidden;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        font-size: 13px;
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
        font-size: 13px;
        cursor: pointer;
        text-align: left;
      }

      .cc:hover,.ee:hover, .ff:hover, .cccc:hover{
        background-color: lightgray;
      }
      .cc,.ee,.ff,.cccc{
        padding: 3px;
        border-bottom: 1px #F8F9F9 solid;
      }

</style>


    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $(document).ready(function()
    {
        var i=1;
        $('#add_row').click(function()
        {
          i++;
          $('#addr1').append('<tr id="row'+i+'">\
            <?php if(isset($data['ty']) && $data['ty']=='l') 
            { 
            ?>
            <td class="labo" id="'+i+'"><input id="set'+i+'" type="text" name="product[]" placeholder="Test Name" class="form-control searchInput" autocomplete="off" />\
            <div id="listt'+i+'" class="listt" style="display: none"></div></td>\
            <div id="list" style="display: none"></div></td>\
            <?php 
            } 
            else
            {
            ?>
            <td class="xyz" id="'+i+'"><input id="set'+i+'" type="text" name="product[]" placeholder="Service ID / Name" class="form-control searchInput" autocomplete="off" />\
            <div id="listt'+i+'" class="listt" style="display: none"></div></td>\
            <div id="list" style="display: none"></div></td>\
            <?php
            }
            ?>
            <td><input type="number" id="qtybox'+i+'" name="qty[]" placeholder="Enter Qty" class="form-control qty" step="0" min="0"/></td>\
            <td><input type="number" id="cost'+i+'" name="price[]" placeholder="Enter Unit Price" class="form-control price" step="0.00" min="0"/>\
            </td>\
            <td><input type="number" id="totalbox" name="total[]" placeholder="0.0" class="form-control total" readonly/></td>\
            <td><a class="btn btn-warning btn-sm btn_remove" id="'+i+'">X</a></td></tr>');

        });

        $(document).on('click', '.btn_remove', function()
        {
          var button_id = $(this).attr("id"); 
          $('#row'+button_id+'').remove();
        });

        $(document).on('keyup', '.xyz', function()
        {
          var button_idq = $(this).attr("id"); 
          var query = $('#set'+button_idq+'').val();
          $.ajax(
          {
            url:'<?php echo URLROOT;?>/receptions/get_auto_complete',
            type:'POST',
            data:{query,button_idq},
            success:function(data)
            {
              $('#listt'+button_idq+'').fadeIn();
              $('#listt'+button_idq+'').html(data);
            }
          });
        });

        $(document).on('keyup', '.labo', function()
        {
          var button_idq = $(this).attr("id"); 
          var query = $('#set'+button_idq+'').val();
          $.ajax(
          {
            url:'<?php echo URLROOT;?>/receptions/get_auto_complete_lab',
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
    function setValue(u,y,w)
    {
        var x = document.getElementById('new'+y+'').getAttribute('value');
        document.getElementById('set'+u+'').value=x;
        document.getElementById('qtybox'+u+'').value=1;
        document.getElementById('cost'+u+'').value=w;
        calc();
        $(document).ready(function()
        {
          $(document).click(function (event)
          {
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
  $('#amt_paid').val((tax_sum+total-discount).toFixed(2));
}
</script>



<div class="row">
<div class="col-md-12">
  <div class="panel panel-default">
      <form id="fed">
        <div class="table-responsive">


          <table class="table table-bordered table-hover" id="tab_logic">
            <thead>
              <tr>
                <?php if(isset($data['ty']) && $data['ty']=='l') 
                { 
                  ?>
                  <th class="text-center"> Test Name </th>
                  <?php 
                } 
                else
                {
                  ?>
                  <th class="text-center"> Service Name </th>
                  <?php
                }
                ?>
                <th class="text-center" style="width: 120px;"> Qty </th>
                <th class="text-center" style="width: 150px;"> Price</th>
                <th class="text-center" style="width: 180px;"> Total </th>
              </tr>
            </thead>
            <?php if (isset($data['edit_order_details'])) { 
              foreach ($data['edit_order_details'] as $val)
              {
                
                $invoice_id_edit = $data['in_id']; 
                $inv_item = $val->invoice_item;
                $inv_item = explode(',', $inv_item);
                $inv_item_len = (sizeof($inv_item)-1)/4;
                $e_invoice_name = $val->invoice_name;
                $e_invoice_doctor = $val->invoice_doctor;
                $e_opip_id = $val->opip_id;
                $e_invoice_pay = $val->invoice_pay;
                $e_amount_paid = $val->amount_paid;
              }

              for ($t=0; $t < $inv_item_len; $t++) { 
              ?>
              <tbody>
              <tr>
              
                <?php if(isset($data['ty']) && $data['ty']=='l') 
                { 
                ?>
                  <td>
                    <input id="searchbox" type="text" name='product[]' placeholder='Test Name' class="form-control searchInput" autocomplete="off" value="<?php echo $inv_item[($t*4)+2].'|'.$inv_item[($t*4)];?>" />
                    <div id='listt0' class="listt" style="display: none"></div>
                  </td>
                <?php 
                } 
                else
                {
                ?>
                  <td>
                    <input id="searchbox" type="text" name='product[]' placeholder='Service ID / Name' class="form-control searchInput" autocomplete="off" value="<?php echo $inv_item[($t*4)+2].'|'.$inv_item[($t*4)];?>" />
                    <div id='listt0' style="display: none"></div>
                  </td>
                <?php
                }
                ?>
                <td>
                  <input type="number" id="qtybox" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0" value="<?php echo $inv_item[($t*4)+1];?>" />
                </td>
                <td>
                  <input type="number" id="cost" name='price[]' placeholder='Enter Unit Price' class="form-control price" step="0.00" min="0" value="<?php echo $inv_item[($t*4)+3];?>" />
                </td>
                <td>
                  <input type="number" id="totalbox" name='total[]' placeholder='0.00' class="form-control total" readonly/>
                </td>
                <td>
                 <!--  <a href="#" class="btn btn-warning btn-sm" onClick="rempro($(this).closest('tr').attr('id'));">X</a> -->
                </td>
                <script type="text/javascript">
                  calc();
                  calc_total();
                </script>
              </tr>
            </tbody>
            <?php }  }

            else {
            ?>
            <tbody id="addr1">
              <tr>
                <?php if(isset($data['ty']) && $data['ty']=='l') 
                { 
                ?>
                  <td>
                    <input id="searchbox" type="text" name='product[]' placeholder='Test Name' class="form-control searchInput" autocomplete="off" />
                    <div id='listt0' class="listt" style="display: none"></div>
                  </td>
                <?php 
                } 
                else
                {
                ?>
                  <td>
                    <input id="searchbox" type="text" name='product[]' placeholder='Service ID / Name' class="form-control searchInput" autocomplete="off" />
                    <div id='listt0' style="display: none"></div>
                  </td>
                <?php
                }
                ?>
                <td>
                  <input type="number" id="qtybox" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0"/>
                </td>
                <td>
                  <input type="number" id="cost" name='price[]' placeholder='Enter Unit Price' class="form-control price" step="0.00" min="0"/>
                </td>
                <td>
                  <input type="number" id="totalbox" name='total[]' placeholder='0.00' class="form-control total" readonly/>
                </td>
                <td>
                  <!-- <a href="#" class="btn btn-warning btn-sm" onClick="rempro($(this).closest('tr').attr('id'));">X</a> -->
                </td>
              </tr>
            </tbody>
            <?php } ?>
            <tbody id="addr1"></tbody>
            </table>


        <button type="button" id="add_row" class="btn btn-info" style="margin-top: 13px;color: white; border:none;">Add Row</button> 
          <div class="pull-right">
          	<table class="table table-bordered table-hover">
              <tr>
                <th class="text-center mid_pad">Sub Total</th>
                <td class="text-center">
                  <input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly/>
                </td>
              </tr>
            </table>
          </div>
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
            <th class="text-center mid_pad">Patient Name</th>
            <td class="text-center">
              <input type="text" id="cust" class="searchcustInput form-control" placeholder="Patient Name / ID" name="customer_val" autocomplete="off">
              <div id="list3" style="display: none;"></div>
             </td>
          </tr>
          <tr>
            <th class="text-center mid_pad">Doctor Name</th>
            <td class="text-center">
              <input type="text" id="doc" class="searchcustInput form-control" placeholder="Doctor Name / ID" name="customer_val" autocomplete="off">
              <div id="list4" style="display: none;"></div>
             </td>
          </tr>
          <tr>
            <th class="text-center mid_pad">IP/OP ID</th>
            <td class="text-center">
              <input type="text" id="ipop" class="searchcustInput form-control" placeholder="IP/OP ID" name="customer_val" autocomplete="off">
              <div id="list3" style="display: none;"></div>
             </td>
          </tr>
          <tr>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-md-4">
      <table class="table table-bordered table-hover" id="tab_logic_total">
        <tbody>
          <tr>
            <th class="text-center" >Discount <br>(Amt or %)</th>
            <td class="text-center">
                <input type="text" class="form-control" id="discount" placeholder="0" name="discount_val">
             </td>
          </tr>
          <tr <?php if(!isset($data['ty'])) { ?> style="display: none;" <?php } ?>> 
            <th class="text-center mid_pad">Extra Tax</th>
            <td class="text-center"><div class="input-group mb-2 mb-sm-0">
                <input type="number" class="form-control" id="tax" placeholder="0" name="extra_tax">
                <div class="input-group-addon">%</div>
              </div></td>
          </tr>
           <tr <?php if(!isset($data['ty'])) { ?> style="display: none;" <?php } ?>>
            <th class="text-center mid_pad">Tax Amount</th>
            <td class="text-center"><input type="number" name='tax_amount' id="tax_amount" placeholder='0.00' class="form-control" readonly/></td>
          </tr>
          <?php if(isset($data['ty']) && $data['ty'] == 'l') { ?>
            
          <?php } else { ?>
            <tr>
              <th class="text-center mid_pad mid_pad">Grand Total</th>
              <td class="text-center"><input type="number" name='total_amount' id="tata" placeholder='0.00' class="form-control" readonly/></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="col-md-4">
      <table class="table table-bordered table-hover" id="tab_logic_total">
        <tbody>
          <tr <?php if(!isset($data['ty'])) { ?> style="display: none;" <?php } ?>>
            <th class="text-center mid_pad mid_pad">Grand Total</th>
            <td class="text-center"><input type="number" name='total_amount' id="tata" placeholder='0.00' class="form-control" readonly/></td>
          </tr>
          <tr>
            <th class="text-center mid_pad">Pay Mode</th>
            <td class="text-center">
                <select class="form-control" name="pay_mode_val" id="paymode">
                	<option value="0">Select Payment Mode</option>
                	<option value="Debit Card">Debit Card</option>
                	<option value="Credit Card">Credit Card</option>
                	<option value="Cash">Cash</option>
                    <option value="UPI">UPI</option>
                	<option value="Net Banking">Net Banking</option>
                	<option value="Digital Wallets">Digital Wallets</option>
                </select>
               
             </td>
          </tr>

          <tr>
            <th class="text-center mid_pad">Amount Paid</th>
            <td class="text-center">
                <input type="number" id="amt_paid" class="form-control" placeholder="0" name="amount_paid_val">
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="row">
      <button style="margin-right: 10px;" id="refresh" type="button" class="btn btn-warning pull-right">Cancel</button>
      <button style="margin-right: 10px;" id="sp" type="button" class="btn btn-purple pull-right" onclick="xsave(<?php echo $val=3;?>);">Submit & Print</button> 
      <button style="margin-right: 10px;" id="sub" type="button" class="btn btn-info pull-right" onclick="xsave(<?php echo $val=2;?>);">Submit</button>
      <button style="margin-right: 10px;" id="sav" type="button" class="btn btn-success pull-right" onclick="xsave(<?php echo $val=1;?>);">Save & Print</button>
      
      
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
  
    

  <?php
    }
  ?>
   </div>
</div>

  

</div>
 
<?php
    if(isset($data['edit_order_details']))
    {
?>
      <script type="text/javascript">
        document.getElementById('cust').value = <?php echo json_encode($e_invoice_name); ?>;
        document.getElementById('doc').value = <?php echo json_encode($e_invoice_doctor); ?>;
        document.getElementById('ipop').value = <?php echo json_encode($e_opip_id); ?>;
        document.getElementById('paymode').value = <?php echo json_encode($e_invoice_pay); ?>;
        document.getElementById('amt_paid').value = <?php echo json_encode($e_amount_paid); ?>;
        

      </script>
<?php
    }



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
      var p_vis_id = "OP";
      p_vis_id += <?php echo $p_vis_id;?>;
      var p_name_opd = <?php echo $p_name_opd;?>;
      var nrf = <?php echo $data['nrf']; ?>;
      p_name_opd += '|';
      p_name_opd += p_id_opd;
      var d_name_opd = <?php echo $d_name_opd?>;
      d_name_opd += '|';
      d_name_opd += d_id_opd;
      
      document.getElementById('cust').value = p_name_opd;
      document.getElementById('doc').value = d_name_opd;
      document.getElementById('ipop').value = p_vis_id;
      document.getElementById('discount').value = nrf;
    </script>
    <?php
  }
?>

<?php
  if(isset($data['patient_name_ip']))
  {
    foreach ($data['ad_id_det_ip'] as $key)
    {
        $p_n_id = $key->ipd_patient_id;
        $d_n_id = $key->ipd_doctor_id;
    }

    $p_vis_id = $data['ad_id_ip'];

    foreach ($data['patient_name_ip'] as $key1)
    {
        $p_name_opd = json_encode($key1->patient_name);
    }

    foreach ($data['doctor_name_ip'] as $key2)
    {
        $d_name_opd = json_encode($key2->doctor_name);
    }
    ?>
    <script type="text/javascript">
      var p_id_opd = <?php echo $p_n_id;?>;
      var d_id_opd = <?php echo $d_n_id?>;
      var p_vis_id = "IP";
      p_vis_id += <?php echo $p_vis_id;?>;
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

  <?php if(isset($data['ty']) && $data['ty']=='l')
  {
  ?>
  <script type="text/javascript">
    $(document).ready(function(){
      $('.searchInput').keyup(function(){
        var query = $(this).val();
        if(query!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/receptions/get_auto_complete_lab_first',
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
              url:'<?php echo URLROOT;?>/receptions/get_value_of_amt_lab',
              type:'POST',
              data:{amt:amt},
              success:function(data)
              {
                $('#cost').val(data);
                $('#qtybox').val(q);
                calc();
              }
            });
           }  
      });
       
      $(document).click(function (event){
        $('#listt0').fadeOut(); 
      }); 
    });
  </script>
  <?php
  }
  else{ ?>
  <script type="text/javascript">
    $(document).ready(function(){
      $('.searchInput').keyup(function(){
        var query = $(this).val();
        if(query!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/receptions/get_auto_complete_first',
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
              url:'<?php echo URLROOT;?>/receptions/get_value_of_amt',
              type:'POST',
              data:{amt:amt},
              success:function(data)
              {
                $('#cost').val(data);
                $('#qtybox').val(q);
                calc();
              }
            });
           }  
      });
       
      $(document).click(function (event){
        $('#listt0').fadeOut(); 
      }); 
    });
  </script>
  <?php  
  }
  ?>

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
            url:'<?php echo URLROOT;?>/receptions/get_auto_patient_name',
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
       $(document).on('click', '.ee', function(){  
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
       $(document).on('click', '.ff', function(){  
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
            window.location.href = "<?php echo URLROOT;?>/admin/new_orders";
        }
        else{
            return false;
        }
    });
</script>
<?php if(isset($data['ty']) && $data['ty']=='l') 
  {
    $dep_type = '1';
  }
  else
  {
    $dep_type = '2';
  }
?>
<script type='text/javascript'>
  function xsave(b)
  {
    var inv_id_edit = <?php echo $invoice_id_edit;?>;
    var dep_type = <?php echo $dep_type;?>;
    var n_name = $('input[name^=product]').map(function(idx, elem)
                      {
                        return $(elem).val();
                      }).get();
    var qty = $('input[name^=qty]').map(function(idx, elem)
                {
                  return $(elem).val();
                }).get();
    var cost = $('input[name^=price]').map(function(idx, elem)
                {
                  return $(elem).val();
                }).get();

    var service_id = '';
    for (var i = 0; i < n_name.length; i++)
    {
      service_id+= n_name[i].split('|')[1];
      service_id+=',';
      service_id+= qty[i];
      service_id+=',';
      service_id+= n_name[i].split('|')[0];
      service_id+=',';
      service_id+=cost[i];
      service_id+=',';
    }
    var dist = $('#discount').val();
    var taxx = $('#tax').val();
    var invoice_bill = $('#sub_total').val();
    var grand_total = $('#tata').val();
    var patient_name = $('#cust').val();
    var doctor_name = $('#doc').val();
    var ipopid = $('#ipop').val();
    var pay_mode = $('#paymode').children('option:selected').val();
    var amount_paid = $('#amt_paid').val();
    if(n_name == "" || qty == "" || cost == "" || patient_name == "" || doctor_name == "" || ipopid == "" || pay_mode == 0)
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
              url:'<?php echo URLROOT;?>/admin/save_invoice',
              type:'POST',
              data:{inv_id_edit,status,service_id,invoice_bill,grand_total,patient_name,doctor_name,ipopid,pay_mode,amount_paid,dep_type,b,taxx,dist},
              success : function(data)
              {
                    if(data == "error")
                    {
                      swal("Error!", "Something Went Wrong", "error");
                    }
                    else
                    {
                      $('#fed').trigger('reset');
                      if(b==2)
                      {
                          swal({
                              title: "Updated!",
                              type: "success"
                          }, function() {
                               window.location = "<?php echo URLROOT;?>/admin/view_invoice/"+inv_id_edit+"";
                          });
                          
                      }

                      if(b==3 || b==1)
                      {
                          swal({
                              title: "Updated!",
                              type: "success"
                          }, function() {
                              window.location.replace("<?php echo URLROOT;?>/admin/print_invoice/"+inv_id_edit+"");
                          });
                      }
                    }
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
		// 	$(el).find("ul").slideDown();
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

  <script type="text/javascript">
    $(document).ready(function(){
      calc();
      calc_total();
    });  
  </script>

<?php require APPROOT .'/views/inc_admin/footer.php';?>

