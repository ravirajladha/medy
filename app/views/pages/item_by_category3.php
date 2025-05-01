<?php require APPROOT . '/views/inc/header.php'; ?>
  <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-lg-11">
                        <h4 class="page-title">Model wise sales</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                               
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <!-- <a class="btn btn-primary" style="color: white" onclick="print_page()"><i class="fa fa-print" aria-hidden="true"></i></a> -->
                    </div>
                </div>          
            </div>
            <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->    
            <div class="contentbar">                
                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-header">                                
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <center>
                                         <h6><?php echo URLROOT1;?><h6>
                                        <h5 class="card-title mb-0" style="font-size: 28px;">Model wise sales</h5>
                                        <br>
                                       <!--  <h6>From 01/07/2020 To 31/07/2020<h6> -->
                                            </center>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row ">
                                                <!-- <div class="col-md-3">
                                                   <label >Manufacturer</label>
                                                    <select name="" id="" class="form-control" onchange="mfgonchage(this.value)">
                                                            <option selected="" disabled="">--select--</option>
                                                            <?php foreach ($data['all_mfg'] as $key) {
                                                            ?>
                                                                <option value="<?php echo $key->mfg_id; ?>"><?php echo $key->mfg_name ?></option>
                                                            <?php
                                                            } ?>
                                                    </select>
                                                </div> -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label >Type</label>
                                                        <select name="type_id" id="type_id" class="form-control" onchange="categoryChange4111(this.value)">
                                                            <option selected="" disabled="">--select--</option>
                                                            <?php foreach ($data['type'] as $key) {
                                                            ?>
                                                                <option value="<?php echo $key->type_id; ?>"><?php echo $key->type_name ?></option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                    </div> 
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Model</label>
                                                        
                                                        <select name="model_id" id="model1" class="form-control" onclick="categoryChange5(this.value)">
                                                            <option selected="" disabled="">--select--</option>
                                                           
                                                        </select>
                                                    </div> 
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Category</label>
                                                        <select name="category_new_id" id="category_new" class="form-control" onclick="categoryChange6(this.value)">
                                                            
                                                           <!--  <?php foreach ($data['cat2'] as $key) {
                                                            ?>
                                                                <option value="<?php echo $key->sc2_id; ?>"><?php echo $key->sc2_name ?></option>
                                                            <?php
                                                            } ?> -->
                                                        </select>
                                                    </div> 
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Sub category</label>
                                                        <select name="subcategory_new_id" id="subcat_new" class="form-control" onclick="categoryChange7(this.value)">
                                                            
                                                           
                                                        </select>
                                                    </div> 
                                                </div>
                                                  <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Start Date</label>
                                                        <input name="todate" type="Date" id="start_dates"  class="form-control"/>
                                                            
                                                           
                                                        </select>
                                                    </div> 
                                                </div>
                                                  <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>End Date</label>
                                                        <input  name="fromdate" type="Date" id="end_dates"  class="form-control"/>
                                                            
                                                           
                                                        
                                                    </div> 
                                                </div>
                                            
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-11"> </div>
                                            <div class="col-md-1">
                                                <form action="<?php echo URLROOT;?>/pages/print_items_by_category_wise3" method="POST">
                                                <input type="text" id="c" name="c1" style="display: none;">
                                                <input type="text" id="s1" name="s1" style="display: none;">
                                                <input type="text" id="s2" name="s2" style="display: none;">
                                                <input type="text" id="s3" name="s3" style="display: none;">
                                                 <input type="Date" id="s4" name="s4" style="display: none;">
                                                  <input type="Date" id="s5" name="s5" style="display: none;">
                                                <button class="btn btn-primary" style="color: white" ><i class="fa fa-print" aria-hidden="true"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-border">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                   
                                               
                                                <th>Model</th>
                                                 <th>Type</th>
                                                <th>Category</th>
                                                <th>Sub category</th>
                                                <th>Brand</th>
                                                                                                
                                                <th>Total Stock</th>
                                                <th>Sale</th>
                                                <th>Color</th>
                                                <th>Size<th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody id="allItems">
                                          
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
            <!-- End Contentbar -->

<?php require APPROOT . '/views/inc/footer.php'; ?>
<script type="text/javascript">
 
      $(document).ready(function()
        {
        var lim = 0;
        var off = 0;
        var inc = 0;
            $.ajax({
            type: "POST",
            url: '<?php echo URLROOT;?>/pages/allItemsforcatreport',
            data: {lim,off},
            cache: false,
            success:function(response)
            {
                $('#allItems').html(response);
            }
            });
        });
 </script>
<script>
   


       function categoryChange41(typeid)
    {   
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/types1",
            type: "POST",
            data: {typeid},

            success: function(response)
            {   
                $('#model1').html(response);
                $('#c').val(typeid);
                categoryChange5();
            }
        });
    }
         function categoryChange411(typeid)
    {   
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/types2",
            type: "POST",
            data: {typeid},

            success: function(response)
            {   
                $('#model1').html(response);
                $('#c').val(typeid);
                categoryChange5();
            }
        });
    }
      function categoryChange4111(typeid)
    {   
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/types3",
            type: "POST",
            data: {typeid},

            success: function(response)
            {   
                $('#model1').html(response);
                $('#c').val(typeid);
                categoryChange5();
            }
        });
    }

     function categoryChange5(model)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/models",
            type: "POST",
            data: {model},

            success: function(response)
            {   
                $('#category_new').html(response);
                 $('#s1').val(model);
                categoryChange6();
            }
        });

    }
    function categoryChange6(cat_new)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/category_new",
            type: "POST",
            data: {cat_new},

            success: function(response)
            {   
                $('#subcat_new').html(response);
                $('#s2').val(cat_new);
                categoryChange7();
            }
        });
       
    }
    function categoryChange7(subcat_new)
    {
        $('#s3').val(subcat_new);
            newcat();

       
    }
      

    function newcat() {
       get_all_category_search();
    }
     
</script>
<script type="text/javascript">
  function get_all_category_search()
    {
        
        var category_id = $('#type_id').val();
        var subCategory = $('#model1').val();
        var subCategory1 = $('#category_new').val();
        var subCategory2 = $('#subcat_new').val();
        var to = $('#start_dates').val();
        var from = $('#end_dates').val();
        if(category_id!=0)
        {
          $.ajax({
            type:'POST',
            url:'<?php echo URLROOT;?>/pages/by_allcategory_item_cat4',
            data:{category_id,subCategory,subCategory1,subCategory2,to,from},
            success : function(data)
            {
                $('#allItems').html(data);

            
            }
          });
        }
   }
</script>

<script type="text/javascript">
    function print_page()
    {
        window.print();
    }
</script>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
