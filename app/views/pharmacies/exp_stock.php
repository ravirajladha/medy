<?php  require APPROOT .'/views/inc_pharmacy/header.php'; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Expiring Stock Details</h3></div>
            <div class="row">
             </div>
             <br>
              <div class="row">
                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table " >
                                                <thead>
                                                    <tr>
                                                        <th>Stock Id</th>
                                                        <th>drug name</th>
                                                        <th>gen name</th>
                                                        <th>drug dossage</th>
                                                        <th>stock quant</th>
                                                        <th>stock batch</th>
                                                        <th>stock total</th>
                                                        <th>stock expiry</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="exp_stock" >
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
                url: '<?php echo URLROOT;?>/pharmacies/exp_stock1',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#exp_stock').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/pharmacies/exp_stock1',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#exp_stock').append(response);
                    }
                  });
                }
            });
          });
</script>
