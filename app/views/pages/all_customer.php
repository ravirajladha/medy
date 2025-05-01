<?php require APPROOT . '/views/inc/header.php'; ?>
   <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">All Customers</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                               
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                            <a href="<?php echo URLROOT;?>/pages/addcustomer"><button class="btn btn-primary">Add Customer</button>
                            </a>
                             
                        </div>                        
                    </div>
                </div>          
            </div>
            <!-- End Breadcrumbbar -->
            <div class="container mt-3" style="padding-left: 30px;padding-right: 30px;">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                           <!--  <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Search Item by Id" id="item">
                            </div> -->
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Search Item by Name" id="CustName">

                            </div>
                             <div class="col-md-3">
                               <!--  <input type="text" class="form-control" placeholder="Search by Company" id="itemComp"> -->
                                  <a href="<?php echo URLROOT;?>/pages/all_customer" class="btn btn-primary"><i class="ri-refresh-line"></i></a>
                            </div>
                           <!--  <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Search Item by Category" id="itemCat">
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start Contentbar -->    
            <div class="contentbar">                
                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-header">                                
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="card-title mb-0">All Customers</h5>
                                    </div>
                                    <div class="col-6">
                                        <ul class="list-inline-group text-right mb-0 pl-0">
                                            <li class="list-inline-item">
                                                  <div class="form-group mb-0 amount-spent-select">
                                                    <!-- <select class="form-control" id="formControlSelect">
                                                      <option>All</option>
                                                      <option>Last Week</option>
                                                      <option>Last Month</option>
                                                    </select> -->
                                                </div>
                                            </li>
                                        </ul>                                        
                                    </div>
                                </div>
                            </div>
                             <input type="text" id="temp" style="display: none;">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Work Phone</th>
                                                <th>City</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody id="all_customer">
                                               
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
<!-- <?php foreach ($data['all_customer'] as $k){ ?>
<tr>
    <td><?php echo $k->id;?></td>
    <td><?php echo $k->customer_display_name;?></td>
    <td><?php echo $k->customer_phno_work;?></td>
    <td><?php echo $k->b_city; ?></td>
    <td> <a href="<?php echo URLROOT; ?>/pages/edit_customer/<?php echo $k->id;?>" class="btn btn-success-rgba"><i class="ri-pencil-line"></i></a>  <a href="<?php echo URLROOT; ?>/pages/del_customer/<?php echo $k->id;?>" class="btn btn-danger-rgba"><i class="ri-delete-bin-3-line"></i></a></td>
</tr>
<?php }?> -->

<?php require APPROOT . '/views/inc/footer.php'; ?>
<script type="text/javascript">
  $(document).ready(function()
    {
        var lim = 9;
        var off = 0;
        var inc = 0;
            $.ajax({
            type: "POST",
            url: '<?php echo URLROOT;?>/pages/all_customer_un',
            data: {lim,off},
            cache: false,
            success:function(response)
            {
                $('#all_customer').html(response);
            }
            });
            $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height())
            {
                if(($('#temp').val())!="")
                {

                }
                else
                {  
                    lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/pages/all_customer_un',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                        inc++;
                        $('#all_customer').append(response);
                    }
                    });
                }
            }
        });
    });
</script>
<script type="text/javascript">
  $(document).ready(function(){
        $("#CustName").keyup(function(){
          var CustName = $('#CustName').val();
          if(CustName!=0)
          {
            $.ajax({
              type:'POST',
              url:'<?php echo URLROOT;?>/pages/allcustomer_byname',
              data:{CustName},
              success : function(data)
              {
                $('#all_customer').html(data);
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
