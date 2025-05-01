<?php require APPROOT .'/views/inc_labs/header.php'; ?>
 <div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Orders</h3></div>
            <div class="row">
             <div class="col-sm-3" style="padding-top: 10px">
                  <input type="text" id="invoice_id_value" class="form-control" placeholder="Search By Invoice ID">
             </div>
             <div class="col-sm-6">
             <div class="input-group m-t-10"> 
                          <input type="date" class="form-control" placeholder="Enter start date" autocomplete="off" name="order_start_date" style="width: 50%;">

                          <input type="date" class="form-control" placeholder="Enter end date" autocomplete="off" name="order_end_date" style="width: 50%;">
                          
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-effect-ripple btn-primary"><i class="fa fa-search"></i></button>
                          </span>
                      </div>
             </div>

             <div class="col-sm-3" style="padding-top: 10px">
                    <!-- <div class="input-group m-t-10"> -->
                        <input type="text" id="search_by_name_value"class="form-control" placeholder="Search By Patient Name">
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
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Order Id</th>
                                                        <th style="text-align: left;">Patient Name</th>
                                                        <th style="text-align: left;">Investigations</th>
                                                        <th style="text-align: left;">Doctor</th>
                                                        <th style="text-align: left;">Order Date</th>
                                                        <th>Action</th>
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
<?php require APPROOT .'/views/inc_labs/footer.php';?>
<script type="text/javascript">
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/labs/orders1',
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
                    url: '<?php echo URLROOT;?>/labs/orders1',
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
  function cancel_lab_order(id)
  { 
      if(confirm('Are you Sure?!'))
      {
          $.ajax({
            url : '<?php echo URLROOT;?>/labs/cancel_lab_order',
            data : {id},
            type : 'POST',
            cache : false,
            success : function (response)
            {
              alert(response);
              after_cancel();
            }
        }); 
      }
      else
      {

      }
      
  }
</script>

<script type="text/javascript">
  function after_cancel()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/labs/orders1',
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
                    url: '<?php echo URLROOT;?>/labs/orders1',
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
