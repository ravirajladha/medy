<?php require APPROOT . '/views/inc/header.php'; ?>

            <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title">NEW EXPENSES</h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                             
                            </ol>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                               

                        <button type="button" class="btn btn-primary" data-toggle="modal" style="float: right;" data-target="#exampleModal">
                       Create Type
                        </button>

                             
                        </div>                        
                    </div>
                </div>          
            </div>


            <div class="contentbar">
                <!-- Start row -->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-lg-6">
                        <div class="card m-b-30">
                            
                            <div class="card-body">
                                   <form action="<?php echo URLROOT; ?>/pages/create_expenses" method="POST"  enctype="multipart/form-data" >  
                                 <div class="col-md-12 form-group">
                                      <label>Select Type</label>
                                                <select class="form-control" id="formControlSelect" name="expensetype" value="">
                                                      <option>--SELECT--</option>
                                                         <?php foreach ($data['typee'] as $k){ ?>
                                                                                                
                                                    <option><?php echo $k->typee  ?></option>
                                                 <?php } ?>
                                                 </select>
                                            
                                 </div>
                                    <div class="form-group">
                                        <label >Expense Detail</label>
                                         <input type="text" class="form-control" placeholder="expense detail" name="expensedetail">
                                       
                                    </div>

                                       <div class="form-group">
                                        <label >Expense Date</label>
                                         <input type="date" class="form-control" placeholder="expense date" name="expensedate">
                                       
                                    </div>


                             
                         </div>
                     </div>
                 </div>


                  <div class="col-lg-6">
                        <div class="card m-b-30">
                            
                            <div class="card-body">
                                      <div class="col-md-12 form-group">
                                      <label>Upload Document</label>
                                      <br>
                                     <input type="file" name="files">

                                            
                                </div>
                                  <div class="form-group">
                                        <label >Expense Value</label>
                                         <input type="text" class="form-control" placeholder="expense value" name="expensevalue">
                                       
                                    </div>
                                     <div>
                                           <a href="<?php echo URLROOT;?>/pages/all_expenses"><button class="btn btn-primary" style="float: right;">Create</button></a>
                                    </div>
                                   


                            </div>
                        </div>
                    </div>
                </form>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo URLROOT; ?>/pages/create_type" method="POST">
          <div>
           <p style="color:#273272"><strong>Enter Type</strong></p>
          </div>
        
          <div class="form-group">
            <input class="form-control" type="text" name="typee"/>
          </div>

      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create</button>
      </div>
  </form>
    </div>
  </div>
</div>



                </div>
            </div>

            <?php require APPROOT . '/views/inc/footer.php'; ?>



