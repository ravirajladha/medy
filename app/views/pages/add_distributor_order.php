<?php require APPROOT . '/views/inc/header.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style>
  .brde
  {
    border: 1px solid red;
  }
</style>
<?php $d = new Page;  ?>
<!-- Start Breadcrumbbar -->
<div class="breadcrumbbar">
  <div class="row align-items-center">
    <div class="col-md-8 col-lg-8">
      <h4 class="page-title">New Distributor Order</h4>
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
<!-- End Breadcrumbbar -->
<!-- Start Contentbar -->
<form method="POST" action="<?php echo URLROOT; ?>/pages/create_distributor_order" enctype="multipart/form-data" id="salesForm">
  <div class="contentbar">
    <!-- Start row -->
    <div class="row">
      <!-- Start col -->
      <div class="col-lg-6">
        <div class="card m-b-30">

          <div class="card-body">
            <div class="form-group">
              <label>Distributor Name</label>
              <input type="text" class="form-control" placeholder="Enter Distributor Name" name="distributor" id="dname" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off">
              <div class="dropdown-menu" id="dropDownAjaxdname" style="width: 300px;padding-bottom: 0px;padding-top: 0px;">
              </div> 
              <input type="text" name="distributor_id" id="dname_id" style="display: none;" />
            </div>
            <div class="form-group">
              <label>Billing Address</label>
              <textarea class="form-control" id="bill_address" name="bill_address" readonly></textarea>
            </div>
            <div class="form-group">
              <label>Distributor Order#</label>
              <input type="text" class="form-control" placeholder="ex D0-00001" name="distributor_order">
            </div>
            <div class="form-group">
              <label>Reference#</label>
              <input type="text" class="form-control" placeholder="" name="reference">
            </div>

            
            <div class="form-group">
              <label>State</label>
              <select name="state_for_tax" id="stateSelect" class="form-control">
                <option selected disabled>--select--</option>
                <option value="1">Within State</option>
                <option value="2" >Outside State</option>
              </select>
            </div>
            <div class="form-group">
              <label>Distributor Order Date</label>
              <input type="date" class="form-control" placeholder="" name="ndate" min='1960-01-01' max="<?php echo date('Y-m-d'); ?>">
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
              <label>Expected Shipment Date</label>
              <input type="date" class="form-control" placeholder="" name="expected_delivery_date" min='1960-01-01' max="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-group">
              <label>Payment Terms</label>
              <select class="form-control" id="formControlSelect" name="payment_terms">
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
            <div class="form-group">
              <label>Delivery Method</label>
              <textarea class="form-control" name="delivery_method"></textarea>

            </div>
            <div class="form-group">
              <label>Salesperson</label>
              <textarea class="form-control" name="salesperson"></textarea>
            </div>
            
            <div class="form-group">
              <label>Warehouse Name</label>
              <input type="text" class="form-control" placeholder="Warehouse Name" name="warehouse_name">
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
                      <th class="text-center"> Item </th>
                      <th class="text-center"> Qty </th>
                      <th class="text-center"> Price </th>
                      <th class="text-center"> Tax(%) </th>
                      <th class="text-center"> Total </th>
                    </tr>
                  </thead>
                  <tbody id='addr1'>
                    <tr id='addr0'>
                      <td>1</td>
                      <td>
                        <input type="text" name='product[]' placeholder='Enter Item Name' class="form-control" id="tags" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" autocomplete="off" />
                        <div class="dropdown-menu" id="dropDownAjax" style="width: 450px;padding-bottom: 0px;padding-top: 0px;">
                        </div>
                        <input type="text" id="item_id_for_qty" style="display: none;">
                      </td>
                      <input type="hidden" id="tTax" value="0">
                      <td><input type="number" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0" onclick="calculateTheGst(this.value)" id="qty"/></td>
                      <td><input type="number" name='price[]' placeholder='Enter Unit Price' class="form-control price" id="price" step="0.00" min="0" /></td>
                      <td id="gst">

                      </td>
                      <td><input type="number" name='total[]' placeholder='0.00' class="form-control total" id="totalRow" readonly /></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row clearfix">
              <div class="col-md-12">
                <a style="color: white;" class="btn btn-default pull-left" onclick="addRowForBill()">Add Another Line</a>
               <!--  <a style="color: white;" id='delete_row' class="pull-right btn btn-default">X</a> -->
              </div>
            </div>


            <div class="row clearfix" style="margin-top:20px;float: right;">
              <div class="pull-right col-md-6" style="margin-top: 30px;">
                <table class="table table-bordered table-hover" id="tab_logic_total">
                  <tbody>
                    <tr>
                      <th class="text-center">Tax</th>
                      <td class="" id="taxPart">
                        <p class="allTax"></p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="pull-right col-md-6" style="margin-top: 30px;">
                <table class="table table-bordered table-hover" id="tab_logic_total">
                  <tbody>
                    <tr>
                      <th class="text-center">Sub Total</th>
                      <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly /></td>
                    </tr>
                    <tr style="display: none;">
                      <th class="text-center">Tax</th>
                      <td class="text-center">
                        <div class="input-group mb-2 mb-sm-0">
                          <input type="number" class="form-control" id="tax" placeholder="0" name="tax">
                          <div class="input-group-addon">%</div>
                        </div>
                      </td>
                    </tr>
                    <tr >
                      <th class="text-center">Discount</th>
                      <td class="text-center"><div class="input-group mb-2 mb-sm-0">
                        <input type="text" name="discount" class="form-control" id="discount" placeholder="0" >
                      </div></td>
                    </tr>
                    <tr >
                      <th class="text-center">Discount Amount</th>
                      <td class="text-center"><input type="number" name='discount_amount' id="discount_amount" placeholder='0.00' class="form-control" readonly/></td>
                    </tr>
                    <tr>
                    <tr style="">
                      <th class="text-center">Total GST</th>
                      <td class="text-center"><input type="number" name='tax_amount' id="tax_amount" placeholder='0.00' class="form-control" readonly /></td>
                    </tr>
                    <tr>
                      <th class="text-center">Grand Total</th>
                      <td class="text-center"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" value="" /></td>
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
              <label>Customer Notes</label>
              <textarea class="form-control" placeholder="Enter any notes to be displayed in your transaction" name="customer_notes"></textarea>
            </div>

            <div class="form-group">
              <label>Attach File(s)</label>
              <input type="file" name="files" class="form-control">

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
              <label>Terms & Conditions</label>
              <textarea class="form-control" placeholder="Enter the terms and Conditions of your business to be displayed in your transaction " name="t_and_c"></textarea>
            </div>
            <br><br>
            <div class="form-group" style="float: right;">
              <a class="btn btn-info text-white" onclick="addRowForBillSubmit()">Submit</a>
              <a class="btn btn-warning" href="<?php echo URLROOT; ?>/pages/sales_order" style="color: white;">Cancel</a> &nbsp;
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
  $(document).ready(function() {
    var i = 1;
    $("#add_row").click(function() {
      b = i - 1;
      $('#addr' + i).html($('#addr' + b).html()).find('td:first-child').html(i + 1);
      $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
      i++;
    });
    $("#delete_row").click(function() {
      if (i > 1) {
        $("#addr" + (i - 1)).html('');
        i--;
      }
      calc();

    });

    $('#tab_logic tbody').on('keyup change', function() {
      calc();
    });
    $('#tax').on('keyup change', function() {
      calc_total();
    });
    $('#discount').on('keyup change',function(){
        calc_total1();
      });
  });

  function calc() {
    $('#tab_logic tbody tr').each(function(i, element) {
      var html = $(this).html();
      if (html != '') {
        var qty = $(this).find('.qty').val();
        var price = $(this).find('.price').val();
        $(this).find('.total').val(qty * price);
        calc_total();
      }
    });
  }
  function ind_tax()
  {
    var t = qty * price ;
    sum = t / 100 * $('#xgst').val();
    $(this).find('.total').val(t+sum);
  }

  function calc_total() {
    total = 0;
    $('.total').each(function() {
      total += parseInt($(this).val());
    });
    sub_total = $('#sub_total').val(total.toFixed(2));
    tax_sum = total / 100 * $('#tax').val();
    $('#tax_amount').val(tax_sum.toFixed(2));
    $('#total_amount').val((tax_sum + total).toFixed(2));
    calc_tax_total();
  }

  function calc_tax_total()
  {
    var tTotal = parseInt($('#tTax').val());
    var total = parseInt($('#total_amount').val());
    $('#total_amount').val((tTotal + total).toFixed(2));
  }

  function calc_total1()
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
      $('#discount_amount').val(discount);
    $('#total_amount').val((tax_sum+total-discount).toFixed(2));
  }

</script>



<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php if (isset($_SESSION['success'])) { ?>
  <script type="text/javascript">
    swal("<?php echo $_SESSION['success']; ?>");
  </script>
<?php }
unset($_SESSION['success']); ?>
<script>
  $('#tags').keyup(function() {
    var tags = $('#tags').val();
    $.ajax({
      url: '<?php echo URLROOT; ?>/pages/getTheItems',
      type: "POST",
      data: {
        tags
      },
      success: function(res) {
        $('#dropDownAjax').html(res);
      }
    });
  });
</script>

<script>
  function selectProduct(val)
  {
    var st = $('#stateSelect').val();
    if(st)
    {
      $.ajax({
        url: "<?php echo URLROOT; ?>/pages/getItemDetailsById",
        type: "POST",
        data: {val},
        success: function(response)
        {
          var itemName = response.trim();
          $('#tags').val(itemName);
          getTheCostPriceForAnItem(val);
          getTheTaxSystem(val, st);
          getTheqtyForAnItem(val);
          $('#item_id_for_qty').val(val);
          // calc();
          // calc_total();
          // calc_total1();
        }
      });
    }
    else
    {
      $('#stateSelect').addClass('brde');
      swal('Please select state to proceed.');
    }
  }
  function getTheqtyForAnItem(val)
  {
    $.ajax({
      url: "<?php echo URLROOT; ?>/pages/getTheItem_for_qty",
      type: "POST",
      data: { val },
      success: function(response1)
      {
        $('#qty').val(parseInt(response1));
        // check_qty();
      }
    });
  }

  function getTheCostPriceForAnItem(val)
  {
    $.ajax({
      url: "<?php echo URLROOT; ?>/pages/getTheItemCostPrice",
      type: "POST",
      data: {
        val
      },
      success: function(response1)
      {
        $('#price').val(parseInt(response1));
      }
    });
  }

  // function changeTheState(itemId)
  // {

  // }

  function getTheTaxSystem(itemId, st)
  {
    $.ajax({
      url: "<?php echo URLROOT; ?>/pages/getTheTaxSystem",
      type: "POST",
      data: {
        itemId, st
      },

      success: function(response2)
      {
        $('#gst').html(response2);
      }
    });
  }

  function calculateTheGst(qtyValue)
  {
    var igst;
    var totalRow;
    var calcVal;
    if($('#igst').is(":visible"))
    {
      igst = $('#igst').val();
      totalRow = $('#totalRow').val();

      calcVal = (igst*totalRow)/100;

      $('#totalRow').val(totalRow + calcVal);
    }
  }

  function addRowForBill()
  {
    if(($('#tags').val())=="")
    {
      alert("Enter Item First");
    }
    else
    {
      var x = $('#temp_check').val();
      var sta = $('#stateSelect').val();
      var sItem = $('#tags').val();
      var sQty = $('#qty').val();
      var sPrice = $('#price').val();
      var sTax = $('#xgst').val();
      var sTotal = $('#totalRow').val();
      var allTax = (sTax * sTotal)/100;
      $.ajax({
        url: "<?php echo URLROOT; ?>/pages/temp_distributorData",
        type: "POST",
        data: {
          sta, sItem, sQty, sPrice, sTax, sTotal
        },

        success: function(response4)
        {
          $('#addr1').append(response4);
          $('#stateSelect').prop("readonly", true);
          $('#tags').val("");
          $('#qty').val("");
          $('#price').val("");
          $('#xgst').val("");
          $('#totalRow').val("");
          $('.allTax').removeClass('allTax');
          $('#taxPart').append('<p class="allTax"></p>');
          // calc();
          // calc_total();
          // calc_total1();
          $('#temp_check').val(x);
        }
      });
    }
  }

  function addRowForBillSubmit()
  {
    var sta = $('#stateSelect').val();
    var sItem = $('#tags').val();
    var sQty = $('#qty').val();
    var sPrice = $('#price').val();
    var sTax = $('#xgst').val();
    var sTotal = $('#totalRow').val();
    var allTax = (sTax * sTotal)/100;
    $.ajax({
      url: "<?php echo URLROOT; ?>/pages/temp_distributorData",
      type: "POST",
      data: {
        sta, sItem, sQty, sPrice, sTax, sTotal
      },
      success: function(response4)
      {
        $('#addr1').append(response4);
        $('#stateSelect').prop("readonly", true);
        $('#tags').val("");
        $('#qty').val("");
        $('#price').val("");
        $('#xgst').val("");
        $('#totalRow').val("");
        $('.allTax').removeClass('allTax');
        $('#taxPart').append('<p class="allTax"></p>');
        // calc();
        // calc_total();
        // calc_total1();
        $('#salesForm').submit();
      }
    });
  }
</script>
<script>
  $(document).ready(function(){
    $('#qty').change(function(){
      var sTax = $('#xgst').val();
      var sTotal = $('#totalRow').val();
      var allTax = (sTax * sTotal)/100;
      var sta = $('#stateSelect').val();
      var tTax = parseInt($('#tTax').val());
      var addTax = allTax + tTax;
      $('#tTax').val(addTax);
      if(sta == 1)
      {
        $('.allTax').html('<p>CGST '+sTax/2+'% - '+allTax/2+'</p><p>SGST '+sTax/2+'% - '+allTax/2+'</p>');
      }
      if(sta == 2)
      {
        $('.allTax').html('<p>IGST '+sTax+'% - '+allTax+'</p>');
      }
    });
  });
</script>
<script>
  $('#dname').keyup(function(){
        var dname = $('#dname').val();
        $.ajax({
            url: '<?php echo URLROOT; ?>/pages/get_all_distributorr_for_auto_complete_dname',
            type: "POST",
            data: {dname},
            success : function(res)
            {
                $('#dropDownAjaxdname').html(res);
                // alert(res);

            }
        });
  });
</script>
<script>
    function selectProductcname(val)
    {
        document.getElementById("dname_id").value = val.id;
        document.getElementById("dname").value = val.name;
      document.getElementById("bill_address").value = val.address;
           
    }
</script>
<script type="text/javascript">
   $(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>