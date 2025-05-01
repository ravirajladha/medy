<?php require APPROOT . '/views/inc/header.php'; ?>
  <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-lg-11">
                        <h4 class="page-title"> Purchase sales</h4>
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
                                         <h6><?php echo URLROOT1;?><h6>
                                        <h5 class="card-title mb-0" style="font-size: 28px;">Purchase Report</h5>
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
                                                        <label>Start Date</label>
                                                        <input name="todate" type="Date" id="start_dates"   class="form-control"/>
                                                            
                                                           
                                                        </select>
                                                    </div> 
                                                </div>
                                                  <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>End Date</label>
                                                        <input  name="fromdate" type="Date" id="end_dates"   class="form-control"/>
                                                            
                                                           
                                                        
                                                    </div> 
                                                </div>
                                <div class="col-md-3 form-group"><br>
                                <label>&nbsp;</label>
                            <button type="submit" onclick="get_all_category_search()" class="btn btn-info" >Submit</button>
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
                                                <th>Vendor</th>
                                                <th>ndate</th>
                                                <th>Item Id</th>
                                                <th>Item Name</th>
                                                <th>Action</th>
                                             
                                            </tr>
                                        </thead>
                                        <tbody id="allItems">
                                          
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <br>
<?php require APPROOT . '/views/inc/footer.php'; ?>


                            <script type="text/javascript">
  function get_all_category_search()
    {
        
    
        var to = $('#start_dates').val();
        var from = $('#end_dates').val();
                 $.ajax({
            type:'POST',
            url:'<?php echo URLROOT;?>/pages/by_allcategory_item_cat6',
            data:{to,from},
            success : function(data)
            {
                $('#allItems').html(data);

            
            }
          });
        }
   
</script>          










