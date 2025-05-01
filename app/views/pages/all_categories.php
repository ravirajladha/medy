<?php require APPROOT . '/views/inc/header.php'; ?>                   
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">All Main Categories</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                </ol>
            </div>
        </div>
    </div>          
</div>  
<div class="contentbar">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <h5>All Main Category List</h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="allCategory">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>

<script type="text/javascript">
  $(document).ready(function()
	{
	var lim = 9;
	var off = 0;
	var inc = 0;
		$.ajax({
		type: "POST",
		url: '<?php echo URLROOT;?>/pages/allCategories',
		data: {lim,off},
		cache: false,
		success:function(response)
		{
			$('#allCategory').html(response);
		}
		});
		$(window).scroll(function() {
		if($(window).scrollTop() + $(window).height() >= $(document).height())
		{
			lim = 10;
			$.ajax({
			type: "POST",
			url: '<?php echo URLROOT;?>/pages/allCategories',
			data: {lim,inc},
			cache: false,
			success:function(response)
			{ 
				inc++;
				$('#allCategory').append(response);
			}
			});
		}
	});
	});
</script>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
