<?php require APPROOT .'/views/inc_pharmacy/header.php'; ?>


<div class="panel panel-default">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3">
			
                <div class="widget-panel widget-style-1 bg-info">
                    <i class="fa fa-shopping-cart" style="padding-right: 15px;"></i> 
                    <h2 class="m-0 counter">22056</h2>
                    <div>Orders</div>
                </div>
            
            </div>
            
			<div class="col-md-3">
            
                <div class="widget-panel widget-style-1 bg-info">
                    <i class="fa fa-rupee" style="padding-right: 15px;"></i> 
                    <h2 class="m-0 counter">1268</h2>
                    <div>Revenue</div>
         
            </div>
        </div>

        <div class="col-md-3">
         
                <div class="widget-panel widget-style-1 bg-info">
                    <i class="fa fa-rupee" style="padding-right: 15px;"></i> 
                    <h2 class="m-0 counter">1268</h2>
                    <div>Profits</div>
                </div>
         
        </div>
			<div class="col-md-3">
         
                <div class="widget-panel widget-style-1 bg-info">
                    <i class="ion-stats-bars" style="padding-right: 15px;"></i> 
                    <h2 class="m-0 counter">1268</h2>
                    <div>Discounts</div>
                </div>
         
        </div>
            </div>
            <div>
                <br>
                <br>
            </div>
            <div class="row">
           <!--  <div class="col-md-6">
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="email" id="example-email" name="example-email" class="form-control" placeholder="Email">
                    </div>
                </div>      
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-effect-ripple btn-primary">Print Report</button>
            </div>
            </div> -->
            <br>
            <br>

            <div class="row">
                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Invoice ID</th>
                                                        <th>Customer Name</th>
                                                        <th>Total Amount</th>
                                                        <th>Order Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="all_orders">
                                                     
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
		</div>
	</div>
</div>	


<?php require APPROOT .'/views/inc_pharmacy/footer.php'; ?>
<?php
if (isset($data['year_date']))
{
    $year_date = json_encode($data['year_date']);
    $today = json_encode($data['today']);
?>
    <script type="text/javascript">
          $(document).ready(function()
                  {
                    var year_date = <?php echo $year_date;?>;
                    var today = <?php echo $today;?>;
                    var lim = 9;
                    var off = 0;
                    var inc = 0;
                      $.ajax({
                        type: "POST",
                        url: '<?php echo URLROOT;?>/pharmacies/patient_report_year',
                        data: {lim,off,year_date,today},
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
                            url: '<?php echo URLROOT;?>/pharmacies/patient_report_year',
                            data: {lim,inc,year_date,today},
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
<?php
}
?>
<?php

if(isset($data['month_date']))
{
    $month_date = json_encode($data['month_date']);
    $today = json_encode($data['today']);
    ?>
        <script type="text/javascript">
          $(document).ready(function()
                  {
                    var month_date = <?php echo $month_date;?>;
                    var today = <?php echo $today;?>;
                    var lim = 9;
                    var off = 0;
                    var inc = 0;
                      $.ajax({
                        type: "POST",
                        url: '<?php echo URLROOT;?>/pharmacies/patient_report_month',
                        data: {lim,off,month_date,today},
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
                            url: '<?php echo URLROOT;?>/pharmacies/patient_report_month',
                            data: {lim,inc,month_date,today},
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
    <?php
}
?>
<?php if (isset($data['date_filter']))
{
    $date = json_encode($data['date_filter']);
?>
<script type="text/javascript">
  $(document).ready(function()
          {
            var date = <?php echo $date;?>;
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/pharmacies/patient_report',
                data: {lim,off,date},
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
                    url: '<?php echo URLROOT;?>/pharmacies/patient_report',
                    data: {lim,inc,date},
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
<?php
    }
?>


<?php if (isset($data['from']))
{
    $from = json_encode($data['from']);
    $to = json_encode($data['to']);
?>
<script type="text/javascript">
  $(document).ready(function()
          {
            var from = <?php echo $from;?>;
            var to = <?php echo $to;?>;
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/pharmacies/custom_date_rep',
                data: {lim,off,from,to},
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
                    url: '<?php echo URLROOT;?>/pharmacies/custom_date_rep',
                    data: {lim,inc,from,to},
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
<?php
    }
?>