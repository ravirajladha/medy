<?php require APPROOT .'/views/inc_pharmacy/header.php'; ?>
<style type="text/css">
#list3{
        max-height: 100px;
        max-width: 307px;
        min-width: 307px;
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
        z-index: 50;
        text-align: left;
      }
.ee:hover{
    background-color: lightgray;
}  
.ee{
    font-size: 15px;
}  
.vatt:hover{
    background-color: red;
}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
        <div class="row">

            <div class="col-md-3"  style="position: fixed;">
                <div class="input-group m-t-10">
                    <input type="text" id="cust" name="" class="form-control" placeholder="Search..." autocomplete="off">
                    <span class="input-group-btn">
                    <button id="search_drug" class="btn btn-effect-ripple btn-primary"><i class="fa fa-search"></i></button>
                    </span>
                </div>
                <div id="list3" style="display: none;"></div>


                <div class="panel-heading">
                <br> 
                    <h4 class="panel-title">Sort Search</h4> 
                </div> 
                    <div class="list-group" style="border:1px solid lightgray">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase" class="list-group-item"><i class="ion-arrow-graph-up-right" style="font-size: 15px;"></i>&nbsp; Latest Stocks</a>
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/2" class="list-group-item" ><i class="ion-arrow-up-a" style="font-size: 15px;"></i>&nbsp; Oldest Stocks</a>
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/3" class="list-group-item" ><i class="ion-arrow-down-a" style="font-size: 15px;"></i>&nbsp; Low Stock Quantity</a>
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/4" class="list-group-item" ><i class="ion-podium" style="font-size: 15px;"></i>&nbsp; Expiring Stocks</a>
                    </div>

                                    <div class="panel-heading">
                <br> 
                    <h4 class="panel-title">Search By Alphabets</h4> 
                </div> 
                    <div class="list-group" style="border:1px solid lightgray; padding-left:10px; padding-right: 10px;">
                        <div class="row alphabet">
                            <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/A" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">A</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/B" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">B</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/C" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">C</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/D" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">D</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/E" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">E</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/F" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">F</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/G" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">G</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/H" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">H</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/I" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">I</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/J" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">J</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/K" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">K</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/L" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">L</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/M" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">M</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/N" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">N</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/O" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">O</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/P" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">P</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/Q" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">Q</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/R" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">R</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/S" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">S</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/T" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">T</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/U" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">U</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/V" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">V</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/W" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">W</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/X" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">X</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/Y" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">Y</a>
                    </div>
                    <div class="col-md-1">
                        <a href="<?php echo URLROOT;?>/pharmacies/all_purchase_sort/Z" style="color: #2980B9; font-weight: 600; font-size: 16px; margin: 5px;">Z</a>
                    </div>
                </div>
              </div>
                </div>
            <div class="col-md-4"></div>
            <div class="col-md-8" style="position: sticky;">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <th style="text-align: left;">Drug Name</th>
                            <th>Stock</th>
                            <th>Batch</th>
                            <th>Expiry</th>
                            <th>Purchase</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="all_drugs">
                             
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
    $(document).ready(function(){
      $('#cust').keyup(function(){
        var query3 = $(this).val();
        if(query3!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/pharmacies/get_auto_drug',
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
  $(document).ready(function()
          {
            var filter = <?php echo json_encode($data['sort']);?>;
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/pharmacies/all_purchase1',
                data: {filter,lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_drugs').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/pharmacies/all_purchase1',
                    data: {filter,lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_drugs').append(response);
                    }
                  });
                }
            });
          });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#search_drug').click(function(){
            var drug = $('#cust').val();
            drug = drug.split("|");
            var drg = drug[1].trim();
            window.location.href = "<?php echo URLROOT;?>/pharmacies/drug/"+drg+"";
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', 'button[data-id]', function () {
            var drug_id = $(this).attr('data-id');
            $.ajax({
                url:'<?php echo URLROOT;?>/pharmacies/remove_drug',
                type:'POST',
                data:{drug_id},
                success : function(response)
                {
                    alert(response);
                    after_delete();
                }
            });
        });
    });
</script>

<script type="text/javascript">
 function after_delete()
          {
            var filter = <?php echo json_encode($data['check']);?>;
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/pharmacies/all_purchase1',
                data: {filter,lim,off},
                cache: false,
                success:function(response)
                {
                  $('#all_drugs').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/pharmacies/all_purchase1',
                    data: {filter,lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#all_drugs').append(response);
                    }
                  });
                }
            });
          }
</script>

