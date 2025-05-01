<?php require APPROOT .'/views/inc_labs/header.php'; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Orders</h3></div>
            <div class="row">
             <div class="col-sm-4">
                    <div class="input-group m-t-10">
                        <input type="email" id="example-input2-group2" name="example-input2-group2" class="form-control" placeholder="Search By Order ID">
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-effect-ripple btn-primary"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
             </div>
             <div class="col-sm-4">
                    
             </div>
             <div class="col-sm-4">
                    
             </div>
             </div>
             <br>
              <div class="row">
                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Order ID</th>
                                                        <th>Patient Name</th>
                                                        <th>Investigations</th>
                                                        <th>Doctor</th>
                                                        <th>Invoice ID</th>
                                                        <th>Order Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Mark</td>
                                                        <td>Otto</td>
                                                        <td>Otto</td>
                                                        <td>Otto</td>
                                                        <td>Otto</td>
                                                        <td>
                                                     
                                                            <button style="width: 54px" type="button" class="btn btn-info btn-xs m-b-5">View</button>
                                                            <button style="width: 54px" type="button" class="btn btn-warning btn-xs m-b-5">Cancel</button>
                                                        
                                                        </td>
                                                    </tr>  
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<?php require APPROOT .'/views/inc_labs/footer.php'; ?>
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