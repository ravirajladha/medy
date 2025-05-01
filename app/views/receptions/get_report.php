<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<?php
    if(!isset($_SESSION['user_id_medhike_87_71_18_08_80_none_med_hi_ke_no']) AND $_SESSION['type'] != 'rec')
    {
        redirect('users/login');
    }
?>
<div class="panel panel-default">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-4">
			<div class="col-md-9 col-sm-6">
                <div class="widget-panel widget-style-1 bg-info">
                    <i class="fa fa-shopping-cart" style="padding-right: 15px;"></i> 
                    <h2 class="m-0 counter"><?php echo $data['ord_count'];?></h2>
                    <div>Orders</div>
                </div>
            </div>
            </div>
            
			<div class="col-md-4">
                <div class="col-md-9 col-sm-10">
                    <div class="widget-panel widget-style-1 bg-info">
                        <i class="fa fa-rupee" style="padding-right: 15px;"></i> 
                        <h2 class="m-0 counter"><?php echo $data['rev']->total;?></h2>
                        <div>Revenue</div>
                    </div>
                </div>
            </div>
			<div class="col-md-4">
                <div class="col-md-9 col-sm-6">
                    <div class="widget-panel widget-style-1 bg-info">
                        <i class="ion-stats-bars" style="padding-right: 15px;"></i> 
                        <h2 class="m-0 counter"><?php echo $data['dis']->dis;?></h2>
                        <div>Discounts</div>
                    </div>
                </div>
            </div>
            </div>
            <div>
                <br>
                <br>
            </div>
            
            <br>
            <br>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Invoice ID</th>
                                    <th style="text-align: left;">Patient Name</th>
                                    <th>Net Amount</th>
                                    <th>Bill Total</th>
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
                        url: '<?php echo URLROOT;?>/receptions/patient_report_year',
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
                            url: '<?php echo URLROOT;?>/receptions/patient_report_year',
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
                        url: '<?php echo URLROOT;?>/receptions/patient_report_month',
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
                            url: '<?php echo URLROOT;?>/receptions/patient_report_month',
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
                url: '<?php echo URLROOT;?>/receptions/patient_report',
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
                    url: '<?php echo URLROOT;?>/receptions/patient_report',
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

<?php if (isset($data['to_cust']))
{
    $to = json_encode($data['to_cust']);
    $frm = json_encode($data['from_cust']);
?>
<script type="text/javascript">
  $(document).ready(function()
          {
            var to = <?php echo $to;?>;
            var frm = <?php echo $frm;?>;
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/receptions/patient_report_custom',
                data: {lim,off,to,frm},
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
                    url: '<?php echo URLROOT;?>/receptions/patient_report_custom',
                    data: {lim,inc,to,frm},
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
<?php require APPROOT .'/views/inc_reception/footer.php'; ?>
