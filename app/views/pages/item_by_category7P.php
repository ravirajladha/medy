<?php require APPROOT . '/views/inc/header.php'; ?>
  <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-lg-11">
                        <h4 class="page-title">Direct Package order</h4>
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
                                            <h5 class="card-title mb-0" style="font-size: 28px;">Direct Package order</h5>
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
                                                  <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label >Model</label>
                                                        <select name="modelid" id="modelid" class="form-control" onchange="newmod(this.value)">
                                                            <option selected="" disabled="">--select--</option>
                                                            
                                                                <option value="0">All</option>
                                                                <?php foreach ($data['mod'] as $key) {
                                                            
                                                                    $post = new Page();
                                                                    $modelid= $post->get_single_model($key->model_name);?>
                                                                <option value="<?php echo   $modelid->model_id ?>"><?php echo $key->model_name ?></option>
                                                            <?php
                                                            } ?>
                                        
                                                        </select>
                                                    </div> 
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
                                                <th>Customer Name</th>
                                                <th>Item Id</th>
                                                <th>Item name</th>
                                                <th>Order QTY</th>
                                                <th>Type</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="allItems">
                                          
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                          <!-- ending -->
                        </div>
                    </div>
                </div>
            </div>





<?php require APPROOT . '/views/inc/footer.php'; ?>
<script type="text/javascript">
 
      $(document).ready(function()
        {
            $('#s4').val(1);
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

           function newmod(argument) {
        $('#s4').val(argument);
       get_all_category_search();
    }


        </script>


        <script type="text/javascript">
  function get_all_category_search()
    {
        var sort = $('#modelid').val();
               
        
          $.ajax({
            type:'POST',
            url:'<?php echo URLROOT;?>/pages/by_allcategory_item_cat8P',
            data:{sort},
            success : function(data)
            {
               $('#allItems').html(data);
            
            }
          });
        
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




