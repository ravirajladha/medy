<?php require APPROOT . '/views/inc/header.php'; ?>
   <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">Min and Max Stock Details</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                               
                            </ol>
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
                                <a class="btn btn-info" style="color: white" id="minstock">Sort by Min</a> 
                           
                               <a class="btn btn-info" style="color: white" id="maxstock">Sort by Max</a> 
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
                                   
                                </div>
                            </div>
                            <input type="text" id="temp" style="display: none;">
                            <div class="card-body">
                                <div class="table-responsive" >
                                    <table class="table table-borderless" >
                                        <thead>
                                            <tr>
                                                <th>Item ID</th>
                                                <th>Item name</th>
                                                <th>Type</th>
                                                <th>Model</th>
                                                <th>Category</th>
                                                <th>Sub Category</th>
                                                <th>Min Stock</th>
                                                <th>Available Stock</th>
                                                <th>Max Stock</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="all_stock">
                                          
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
		url: '<?php echo URLROOT;?>/pages/all_stock_water_level',
		data: {lim,off},
		cache: false,
		success:function(response)
		{
			$('#all_stock').html(response);
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
          			url: '<?php echo URLROOT;?>/pages/all_stock_water_level',
          			data: {lim,inc},
          			cache: false,
          			success:function(response)
          			{ 
          				inc++;
          				$('#all_stock').append(response);
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
              url:'<?php echo URLROOT;?>/pages/allItemsById_water_level',
              data:{itm},
              success : function(data)
              {
                $('#all_stock').html(data);
                $('#temp').val(1);
              }
            });
          }
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
              url:'<?php echo URLROOT;?>/pages/allItemsByName_water_level',
              data:{itmName},
              success : function(data)
              {
                $('#all_stock').html(data);
                $('#temp').val(1);
              }
            });
          }
        });
    })
</script>
<script type="text/javascript">
$("#minstock").click(function(){
  var itmName = $('#minstock').val();
    $.ajax({
      type:'POST',
      url:'<?php echo URLROOT;?>/pages/stort_by_min_water_level',
      data:{itmName},
      success : function(data)
      {
        $('#all_stock').html(data);
        $('#temp').val(1);
      }
    });
});
</script>
<script type="text/javascript">
        $("#maxstock").click(function(){
          var itmName = $('#maxstock').val();
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/pages/stort_by_max_water_level',
              data:{itmName},
              success : function(data)
              {
                $('#all_stock').html(data);
                $('#temp').val(1);
              }
            });
        });
</script>




