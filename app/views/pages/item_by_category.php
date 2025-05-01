<?php require APPROOT . '/views/inc/header.php'; ?>
  <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-lg-11">
                        <h4 class="page-title">Items By Category</h4>
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
                                        <h5 class="card-title mb-0" style="font-size: 28px;">Items By Category</h5>
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
                                                        <select name="type_id" id="type_id" class="form-control" onchange="categoryChange4(this.value)">
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
                                                           <!--  <?php foreach ($data['cat1'] as $key) {
                                                            ?>
                                                                <option value="<?php echo $key->sc_id; ?>"><?php echo $key->sc_name ?></option>
                                                            <?php
                                                            } ?> -->
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
                                                            
                                                           <!--  <?php foreach ($data['cat3'] as $key) {
                                                            ?>
                                                                <option value="<?php echo $key->sc3_id; ?>"><?php echo $key->sc3_name ?></option>
                                                            <?php
                                                            } ?> -->
                                                        </select>
                                                    </div> 
                                                </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-11"> </div>
                                            <div class="col-md-1">
                                                <form action="<?php echo URLROOT;?>/pages/print_items_by_category_wise" method="POST">
                                                <input type="text" id="c" name="c1" style="display: none;">
                                                <input type="text" id="s1" name="s1" style="display: none;">
                                                <input type="text" id="s2" name="s2" style="display: none;">
                                                <input type="text" id="s3" name="s3" style="display: none;">
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
                                                <th>Name</th>
                                                <th>Receivable(QTY)</th>
                                                <th>Type</th>
                                                <th>Model</th>
                                                <th>Category</th>
                                                <th>Sub category</th>
                                             
                                                <th>Available Stock</th>
                                                <th>Total</th>
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
        //     $(window).scroll(function() {
        //     if($(window).scrollTop() + $(window).height() >= $(document).height())
        //     {
        //         lim = 10;
        //         $.ajax({
        //         type: "POST",
        //         url: '<?php echo URLROOT;?>/pages/allItemsforcatreport',
        //         data: {lim,inc},
        //         cache: false,
        //         success:function(response)
        //         { 
        //             inc++;
        //             $('#allItems').append(response);
        //         }
        //         });
        //     }
        // });

        });
 </script>
<script>
    function categoryChange(categoryId)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/subCategory",
            type: "POST",
            data: {categoryId},

            success: function(response)
            {   
                $('#subCategory').html(response);
                $('#c').val(categoryId);
                categoryChange1();
            }
        });
    }
     function categoryChange1(subCategory)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/subCategory1",
            type: "POST",
            data: {subCategory},

            success: function(response)
            {   
                $('#subCategory1').html(response);
                $('#s1').val(subCategory);
                categoryChange2();
            }
        });

    }
    function categoryChange2(subCategory1)
    {
        $('#s2').val(subCategory1);
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/subCategory_2",
            type: "POST",
            data: {subCategory1},

            success: function(response)
            {   
                $('#subCategory2').html(response);
                
                categoryChange3();
            }
        });  
    }
    function categoryChange3(subCategory2)
    {
      $('#s3').val(subCategory2);
      get_all_category_search();
    }


    function categoryChange4(typeid)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/types",
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
        if(category_id!=0)
        {
          $.ajax({
            type:'POST',
            url:'<?php echo URLROOT;?>/pages/by_allcategory_item_cat1',
            data:{category_id,subCategory,subCategory1,subCategory2},
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
<script type="text/javascript">
   $(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script>