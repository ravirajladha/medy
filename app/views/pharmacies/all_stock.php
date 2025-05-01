<?php  require APPROOT .'/views/inc_pharmacy/header.php'; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Stock Details</h3></div>
            <div class="row">
             </div>
             <br>
              <div class="row">
                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table" >
                                                <thead>
                                                    <tr>
                                                        <th>Stock Id</th>
                                                        <th>drug name</th>
                                                        <th>stock quant</th>
                                                        <th>stock batch</th>
                                                        <th>stock expiry</th>
                                                        <th>stock distributor</th>
                                                        <th>drug cgst</th>
                                                        <th>drug sgst</th>
                                                        <th>drug tax able amount </th>
                                                        <th>drug buy cost</th>
                                                        <th>drug sell cost</th>
                                                        <th>stock total</th>
                                                        <th>stock date</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="stock_all" >
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php require APPROOT .'/views/inc_pharmacy/footer.php'; ?>

<script type="text/javascript">
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/pharmacies/all_stock1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#stock_all').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/pharmacies/all_stock1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#stock_all').append(response);
                    }
                  });
                }
            });
          });
</script>
