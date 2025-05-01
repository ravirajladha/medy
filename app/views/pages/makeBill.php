<?php require APPROOT . '/views/inc/header.php'; ?>                
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Purchase Bill</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                </ol>
            </div>
        </div>
    </div>          
</div> 
<div class="contentbar card card-body">  
    <form action="<?php echo URLROOT; ?>/pages/saveBill/<?php echo $data['pid'] ?>" method="POST">
    <div class="row clearfix">
        <div class="col-md-12 ">
        <table class="table table-bordered table-hover mt-5" id="tab_logic">
            <thead>
            <tr>
                <th class="text-center"> # </th>
                <th class="text-center"> Item </th>
                <th class="text-center"> Qty </th>
                <th class="text-center"> Price </th>
                <th class="text-center"> Total </th>
            </tr>
            </thead>
            <tbody>
                <input type="hidden" name="rid" value="<?php echo $data['rid']; ?>">
            <?php
            
            $itemId = explode('|||', $data['rDetails']->item_id);
            $itemName = explode('|||', $data['rDetails']->item_name);
            $receivedQty = explode('|||', $data['rDetails']->received_qty);
            $rowPrice = explode('|||', $data['po']->row_price);
            $poItemId = explode('|||', $data['po']->item_id);
            

            for ($i=0; $i < sizeof($itemId); $i++)
            { 
                $priceKey = array_search($itemId[$i], $itemId);
                $priceAct = $rowPrice[$priceKey];
            ?>
            <tr id='addr0'>
                <td><?php echo $i + 1; ?></td>
                <td><input type="text" name='product[]'  placeholder='Enter Product Name' class="form-control" value="<?php echo $itemName[$i]?>(<?php echo $itemId[$i] ?>)"/></td>
                <td><input type="number" name='qty[]' placeholder='Enter Qty' class="form-control qty" step="0" min="0" value="<?php echo $receivedQty[$i]; ?>"/></td>
                <td><input type="number" name='price[]' placeholder='Enter Unit Price' class="form-control price" step="0.00" min="0" value="<?php echo $priceAct ?>" /></td>
                <td><input type="number" name='total[]' placeholder='0.00' class="form-control total" readonly/></td>
            </tr>
            <?php } ?>
            <tr id='addr1'></tr>
            </tbody>
        </table>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12">
        </div>
    </div>
    <div class="row clearfix" style="margin-top:20px">
        <div class="col-md-8"></div>
        <div class="pull-right col-md-4" style="float: right;">
        <table class="table table-bordered table-hover" id="tab_logic_total">
            <tbody>
            <tr>
                <th class="text-center">Sub Total</th>
                <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly/></td>
            </tr>
            
            <tr>
                <th class="text-center">Tax</th>
                <td class="text-center"><div class="input-group mb-2 mb-sm-0">
                    <!-- <input type="number" name="tax" class="form-control" id="tax" placeholder="0" value="<?php echo $data['po']->po_tax ?>"> -->
                    <select name="" id="tax" class="form-control">
                        <option value="0">0</option>
                        <option value="5">5</option>
                        <option value="12">12</option>
                        <option value="18">18</option>
                        <option value="28">28</option>
                    </select>
                    <div class="input-group-addon" >%</div>
                </div></td>
            </tr>
            <tr>
                <th class="text-center">Tax Amount</th>
                <td class="text-center"><input type="number" name='tax_amount' id="tax_amount" placeholder='0.00' class="form-control" readonly/></td>
            </tr>
            <tr >
                <th class="text-center">Discount</th>
                <td class="text-center"><div class="input-group mb-2 mb-sm-0">
                    <input type="text" name="discount" class="form-control" id="discount" placeholder="0" value="<?php echo $data['po']->po_discount ?>">
                </div></td>
            </tr>
            <tr >
                <th class="text-center">Discount Amount</th>
                <td class="text-center"><input type="number" name='discount_amount' id="discount_amount" placeholder='0.00' class="form-control" readonly/></td>
            </tr>
            <tr>
                <th class="text-center">Grand Total</th>
                <td class="text-center"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" readonly/></td>
            </tr>
            </tbody>
        </table>
        <a href="#" class="btn btn-warning pull-right text-white">Cancel</a>
        <button type="submit" class="btn btn-primary pull-right mr-1">submit</button>
        </div>
    </div>
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>      


<script type="text/javascript">
  $(document).ready(function(){
        calc();
        calc_total();
        calc_total1();
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
   $('#discount').on('keyup change',function(){
    calc_total1();
  });'['
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


$('#add_row').on("click",function(e){
    e.preventDefault();
});

$('#delete_row').on("click",function(e){
    e.preventDefault();
});
</script> 
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
