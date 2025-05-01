<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <select class="form-control" style="float: right;width: 200px;" onchange="location = this.value;">
              <option value="<?php echo URLROOT; ?>/receptions/all_orders" >Regular Orders</option>
              <option value="<?php echo URLROOT; ?>/receptions/all_orders_lab" selected="">Lab Orders</option>
              <option value="<?php echo URLROOT; ?>/receptions/all_orders_bal" >Balance Orders</option>
              <option value="<?php echo URLROOT; ?>/receptions/all_orders_discount">Discount Orders</option>
              
            </select>
            <div class="" ><h3 class="panel-title">Lab All Orders</h3></div>
            <hr style="border-top: 1px solid lightgray;">
            <div class="row">
             <div class="col-sm-3" style="padding-top: 10px">
                  <input type="number" id="invoice_id_value" class="form-control" placeholder="Search By Invoice ID">
             </div>
             <div class="col-sm-6">
             <div class="input-group m-t-10"> 
                          <input type="date" class="form-control" placeholder="Enter start date" autocomplete="off" id="order_start_date" style="width: 50%;">

                          <input type="date" class="form-control" placeholder="Enter end date" autocomplete="off" id="order_end_date" style="width: 50%;">
                          
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-effect-ripple btn-primary" id="get_wrt_date"><i class="fa fa-search"></i></button>
                          </span>
                      </div>
             </div>

             <div class="col-sm-3" style="padding-top: 10px">
                    <!-- <div class="input-group m-t-10"> -->
                        <input type="text" id="search_by_name_value"class="form-control" placeholder="Search By Patient Name/Phone">
                        <!-- <span class="input-group-btn">
                        <button type="button" class="btn btn-effect-ripple btn-primary"><i class="fa fa-search"></i></button>
                        </span> -->
                    <!-- </div> -->
             </div>
             </div>
             <br>
              <div class="row">
                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table" style="margin-bottom: 0px;">
                                                <thead>
                                                    <tr>
                                                        <th>Invoice Id</th>
                                                        <th style="text-align: left;">Customer Name</th>
                                                        <th>Total Amount</th>
                                                        <th>Amount Paid</th>
                                                        <th>Balance</th>
                                                        <th>Order Date</th>
                                                        <th width="250">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="all_orders" >
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Pay Balance</h4>
        </div>
        <form action="<?php echo URLROOT; ?>/receptions/payBalance" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
          <div class="row">
              <div class="form-group">
                <label>Invoice Id</label>
                <input type="text" name="invId" id="invId" class="form-control" readonly="">
              </div>
          </div>
          <div class="row">
              <div class="form-group">
                <label>Balance Amount</label>
                <input type="number" name="balAmt" id="balAmt" class="form-control">
              </div>
          </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" >Submit</button>
        </div>
        </form>
      </div>
    </div>
  </div>      
<?php require APPROOT .'/views/inc_reception/footer.php';?>
<script type="text/javascript">
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/receptions/all_orders1_lab',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_orders').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/receptions/all_orders1_lab',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_orders').append(response);
                    }
                  });
                }
            });
          });
</script>
<script type="text/javascript">
  $(document).ready(function(){
        $("#invoice_id_value").keyup(function(){
          var inv = $('#invoice_id_value').val();
          if(inv!=0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/receptions/search_by_inv_id',
              data:{inv},
              success : function(data)
              {
                $('#all_orders').html(data);
              }
            });
          }
          else
          {
            $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/receptions/all_orders1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_orders').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/receptions/all_orders1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_orders').append(response);
                    }
                  });
                }
            });
          });
          }
        });
    })
</script>

<script type="text/javascript">
  $(document).ready(function(){
        $("#search_by_name_value").keyup(function(){
          var patient_name = $('#search_by_name_value').val();
          if(patient_name!=0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/receptions/search_by_name_value',
              data:{patient_name},
              success : function(data)
              {
                $('#all_orders').html(data);
              }
            });
          }
          else
          {
            $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/receptions/all_orders1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_orders').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/receptions/all_orders1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_orders').append(response);
                    }
                  });
                }
            });
          });
          }
        });
    })
</script>

<script type="text/javascript">
  $(document).ready(function(){
        $("#get_wrt_date").click(function(){
          var start = $('#order_start_date').val();
          var end = $('#order_end_date').val();
          if(start != '' && end != '')
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/receptions/get_all_orders_wrt_dates',
              data:{start, end},
              success : function(data)
              {
                $('#all_orders').html(data);
              }
            });
          }
          else
          {
          $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/receptions/all_orders1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_orders').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/receptions/all_orders1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_orders').append(response);
                    }
                  });
                }
            });
          });
          }
        });
    })
</script>

<script type="text/javascript">
  function cancel_order(id)
  {
      swal({   
            title: "Are you sure?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#2ECC71",   
            confirmButtonText: "Yes",
            cancelButtonColor: "#FFA726",   
            cancelButtonText: "No",   
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm){   
            if (isConfirm)
            { 
                $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/receptions/cancel_invoice',
                    data: {id},
                    cache: false,
                    success:function(response)
                    {
                      if(response)
                      {
                        swal("Order Cancelled!", "", "success");
                        after_remove();
                      }
                      else
                      {
                        swal("Error!", "", "error");
                        after_remove();
                      }
                    }
                  });    
            } 
            else
            {     
                swal("Cancelled", "", "error");   
            } 
        });
  }
</script>

<script type="text/javascript">
  function after_remove()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/receptions/all_orders1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_orders').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/receptions/all_orders1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_orders').append(response);
                    }
                  });
                }
            });
          }
</script>

<script type="text/javascript">
  function undo_cancel(id)
  {
      $.ajax({
        url:'<?php echo URLROOT ?>/receptions/undo_cancel',
        type:'POST',
        data:{id},
        success : function (data)
        {
            swal("Updated!");
            after_remove();
        }
      });
  }
</script>

<script type="text/javascript">
  function openModal(inv, bal)
  {
    $('#invId').val(inv);
    $('#balAmt').val(bal);
    $('#myModal').modal('show');
  }
</script>