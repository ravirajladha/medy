<?php require APPROOT . '/views/inc/header.php'; ?>

   <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">Items</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                               
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                            <a href="<?php echo URLROOT;?>/pages/additem"><button class="btn btn-primary">Add Iteam</button>
                            </a>
                              <button class="btn btn-primary"><i class="ri-refresh-line mr-2"></i>Refresh</button>
                        </div>                        
                    </div>
                </div>          
            </div>
            <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->   
            <div class="container mt-3" style="padding-left: 30px;padding-right: 30px;">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Search Item by Id" id="item">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Search Item by Name" id="itemName">
                            </div>
                             <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Search by Company" id="itemComp">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Search Item by Category" id="itemCat">
                            </div>
                        </div>
                        <br>
                        <div class="row">
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
                              <div class="col-md-3"></div>
                              <div class="col-md-3">
                                  <a href="<?php echo URLROOT;?>/pages/search_by_category"></a>
                              </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="contentbar">                
                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-header">                                
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="card-title mb-0">All Items</h5>
                                    </div>
                                    <div class="col-6">
                                        <ul class="list-inline-group text-right mb-0 pl-0">
                                            <li class="list-inline-item">
                                                  <div class="form-group mb-0 amount-spent-select">
                                                    <select class="form-control" id="formControlSelect">
                                                      <option>All</option>
                                                      <option>Last Week</option>
                                                      <option>Last Month</option>
                                                    </select>
                                                </div>
                                            </li>
                                        </ul>                                        
                                    </div>
                                </div>
                            </div>
                            <input type="text" id="temp" style="display: none;">
                            <div class="card-body">
                                <div class="table-responsive" >
                                    <table class="table table-borderless" >
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Model</th>
                                                <th>Category</th>
                                                <th>Sub Category</th>
                                                <th>Selling Price</th>
                                                <th>Available Stock</th>
                                                <th>Actions</th>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>

<script type="text/javascript">
  $(document).ready(function()
	{
	var lim = 9;
	var off = 0;
	var inc = 0;
		$.ajax({
		type: "POST",
		url: '<?php echo URLROOT;?>/pages/allItems',
		data: {lim,off},
		cache: false,
		success:function(response)
		{
			$('#allItems').html(response);
		}
		});
    
    $(window).scroll(function() {
          if(($('#temp').val())!="")
          {

          }
          else
          {  
          		if($(window).scrollTop() + $(window).height() >= $(document).height())
          		{
          			lim = 10;
          			$.ajax({
          			type: "POST",
          			url: '<?php echo URLROOT;?>/pages/allItems',
          			data: {lim,inc},
          			cache: false,
          			success:function(response)
          			{ 
          				inc++;
          				$('#allItems').append(response);
          			}
          			});
          		}
          }
    });
	});
</script>

<script type="text/javascript">
  $(document).ready(function(){
        $("#item").keyup(function(){
          var itm = $('#item').val();
          if(itm!=0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/pages/allItemsById',
              data:{itm},
              success : function(data)
              {
                $('#allItems').html(data);
                $('#temp').val(1);
              }
            });
          }
          // else
          // {
          //   $(document).ready(function()
          // {
          //   var lim = 9;
          //   var off = 0;
          //   var inc = 0;
          //     $.ajax({
          //       type: "POST",
          //       url: '<?php echo URLROOT;?>/pages/allItems',
          //       data: {lim,off},
          //       cache: false,
          //       success:function(response)
          //       {
          //         $('#allItems').html(response);
          //       }
          //     });
          //      $(window).scroll(function() {
          //       if($(window).scrollTop() + $(window).height() >= $(document).height())
          //       {
          //         lim = 10;
          //           $.ajax({
          //           type: "POST",
          //           url: '<?php echo URLROOT;?>/pages/allItems',
          //           data: {lim,inc},
          //           cache: false,
          //           success:function(response)
          //           { 
          //             inc++;
          //             $('#allItems').append(response);
          //           }
          //         });
          //       }
          //   });
          // });
          // }
        });
    })
</script>

<script type="text/javascript">
  $(document).ready(function(){
        $("#itemName").keyup(function(){
          var itmName = $('#itemName').val();
          if(itmName!=0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/pages/allItemsByName',
              data:{itmName},
              success : function(data)
              {
                $('#allItems').html(data);
                $('#temp').val(1);
              }
            });
          }
          // else
          // {
          //   $(document).ready(function()
          // {
          //   var lim = 9;
          //   var off = 0;
          //   var inc = 0;
          //     $.ajax({
          //       type: "POST",
          //       url: '<?php echo URLROOT;?>/pages/allItems',
          //       data: {lim,off},
          //       cache: false,
          //       success:function(response)
          //       {
          //         $('#allItems').html(response);
          //       }
          //     });
          //      $(window).scroll(function() {
          //       if($(window).scrollTop() + $(window).height() >= $(document).height())
          //       {
          //         lim = 10;
          //           $.ajax({
          //           type: "POST",
          //           url: '<?php echo URLROOT;?>/pages/allItems',
          //           data: {lim,inc},
          //           cache: false,
          //           success:function(response)
          //           { 
          //             inc++;
          //             $('#allItems').append(response);
          //           }
          //         });
          //       }
          //   });
          // });
          // }
        });
    })
</script>

<script type="text/javascript">
  $(document).ready(function(){
        $("#itemCat").keyup(function(){
          var itemCat = $('#itemCat').val();
          if(itemCat!=0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/pages/allItemsByCat',
              data:{itemCat},
              success : function(data)
              {
                $('#allItems').html(data);
                $('#temp').val(1);
              }
            });
          }
          // else
          // {
          //   $(document).ready(function()
          // {
          //   var lim = 9;
          //   var off = 0;
          //   var inc = 0;
          //     $.ajax({
          //       type: "POST",
          //       url: '<?php echo URLROOT;?>/pages/allItems',
          //       data: {lim,off},
          //       cache: false,
          //       success:function(response)
          //       {
          //         $('#allItems').html(response);
          //       }
          //     });
          //      $(window).scroll(function() {
          //       if($(window).scrollTop() + $(window).height() >= $(document).height())
          //       {
          //         lim = 10;
          //           $.ajax({
          //           type: "POST",
          //           url: '<?php echo URLROOT;?>/pages/allItems',
          //           data: {lim,inc},
          //           cache: false,
          //           success:function(response)
          //           { 
          //             inc++;
          //             $('#allItems').append(response);
          //           }
          //         });
          //       }
          //   });
          // });
          // }
        });
    })
</script>
<script type="text/javascript">
  $(document).ready(function(){
        $("#itemComp").keyup(function(){
          var itemComp = $('#itemComp').val();
          if(itemComp!=0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/pages/allItemsByComp',
              data:{itemComp},
              success : function(data)
              {
                $('#allItems').html(data);
                $('#temp').val(1);
              }
            });
          }
          // else
          // {
          //   $(document).ready(function()
          // {
          //   var lim = 9;
          //   var off = 0;
          //   var inc = 0;
          //     $.ajax({
          //       type: "POST",
          //       url: '<?php echo URLROOT;?>/pages/allItems',
          //       data: {lim,off},
          //       cache: false,
          //       success:function(response)
          //       {
          //         $('#allItems').html(response);
          //       }
          //     });
          //      $(window).scroll(function() {
          //       if($(window).scrollTop() + $(window).height() >= $(document).height())
          //       {
          //         lim = 10;
          //           $.ajax({
          //           type: "POST",
          //           url: '<?php echo URLROOT;?>/pages/allItems',
          //           data: {lim,inc},
          //           cache: false,
          //           success:function(response)
          //           { 
          //             inc++;
          //             $('#allItems').append(response);
          //           }
          //         });
          //       }
          //   });
          // });
          // }
        });
    })
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
                $('#temp').val(1);
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
                $('#temp').val(1);
                categoryChange2();
            }
        });

    }
    function categoryChange2(subCategory1)
    {
        $.ajax({
            url: "<?php echo URLROOT; ?>/pages/subCategory_2",
            type: "POST",
            data: {subCategory1},

            success: function(response)
            {   
                $('#subCategory2').html(response);
                $('#temp').val(1);
                categoryChange3();
            }
        });  
    }
    function categoryChange3()
    {
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
                 $('#temp').val(1);
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
                  $('#temp').val(1);
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
                 $('#temp').val(1);
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
            url:'<?php echo URLROOT;?>/pages/by_allcategory',
            data:{category_id,subCategory,subCategory1,subCategory2},
            success : function(data)
            {
               $('#allItems').html(data);
            
            }
          });
        }
   }
</script>