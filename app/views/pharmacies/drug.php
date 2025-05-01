<?php require APPROOT .'/views/inc_pharmacy/header.php'; ?>
<?php
foreach ($data['drug'] as $key)
{
    $drug_name = $key->drug_name;
    $drug_id = $key->drug_id;
    $drug_gen = $key->gen_name;
    $drug_manf = $key->drug_manufacturer;
    $drug_form = $key->drug_formulation;
}

// foreach ($data['stock'] as $key2)
// {
//     $stock_batch = $key2->stock_batch;
//     $stock_expiry =  $key2->stock_expiry;
//     $drug_sell_cost = $key2->drug_sell_cost;
//     $stock_quant = $key2->stock_quant;
//     $stock_total = $key2->stock_total;
//     $stock_distributor = $key2->stock_distributor;
// }
?>
    <div class="wraper container-fluid" style="background-color: white">
        <div class="row" >
            <div class="col-sm-12" >
                  <span class="bg-picture-overlay"></span><!-- overlay -->
                  <!-- meta -->
                  <div class="box-layout meta bottom">
                    <div class="col-sm-6 clearfix">
                      <div class="media-body">
                        <h1><?php echo ucwords($drug_name);?><small>(<?php echo $drug_id ?>)</small></h1>
                        <h5 class="text-black"><?php echo ucwords($drug_gen);?></h5>
                      </div>
                    </div>
                  </div>
                  <!--/ meta -->
            </div>
        </div>

        <div class="row m-t-30">
            <div class="col-sm-12">
                <div class="panel panel-default p-0">
                    <div class="panel-body p-0"> 
                        <ul class="nav nav-tabs profile-tabs">
                            <li class="active"><a data-toggle="tab" href="#aboutme">Basic Information</a></li>
                            <li class=""><a data-toggle="tab" href="#user-activities">Batch</a></li>
                            <li class=""><a data-toggle="tab" href="#edit-profile">Description</a></li>
                        </ul>

                        <div class="tab-content m-0"> 

                            <div id="aboutme" class="tab-pane active">
                            <div class="profile-desk">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>Drug Name</b></td>
                                            <td>
                                                <?php if(isset($drug_name)){ echo ucwords($drug_name); }?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Generic Name</b></td>
                                            <td>
                                                <?php if(isset($drug_gen)) { echo ucwords($drug_gen); } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Drug Manufacturer</b></td>
                                            <td><?php if(isset($drug_manf)) { echo ucwords($drug_manf); } ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Drug Formulation</b></td>
                                            <td>
                                                <?php if(isset($drug_form)) { echo $drug_form; } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div> <!-- end profile-desk -->
                        </div> <!-- about-me -->


                        <!-- Activities -->
                        <div id="user-activities" class="tab-pane">
                            <?php foreach ($data['stock'] as $key2)
                            { ?>
                             <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>Batch Name</b></td>
                                            <td>
                                                <?php if(isset($key2->stock_batch)) { echo ucwords($key2->stock_batch); } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Expiry Date</b></td>
                                            <td>
                                                <?php if(isset($key2->stock_expiry)) { echo $key2->stock_expiry; } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Sell Cost</b></td>
                                            <td><?php if(isset($key2->drug_sell_cost)) { echo $key2->drug_sell_cost; } ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Available Stocks</b></td>
                                            <td>
                                                <?php if(isset($key2->stock_quant)) { echo $key2->stock_quant; } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Total Stocks</b></td>
                                            <td>
                                                <?php if(isset($key2->stock_total)) { echo $key2->stock_total; } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Total Sold</b></td>
                                            <td>
                                                <?php if(isset($key2->stock_total) AND isset($key2->stock_quant)) { echo $key2->stock_total - $key2->stock_quant; } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Distributor</b></td>
                                            <td>
                                                <?php if(isset($stock_distributor)) { echo $stock_distributor; } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                        </div>

                        <!-- settings -->
                        <div id="edit-profile" class="tab-pane">
                            <h3>Coming Soon in Next Update</h3>
                        </div>


                        <!-- profile -->
                        <div id="projects" class="tab-pane">
                            <div class="row m-t-10">
                                <div class="col-md-12">
                                    <div class="portlet"><!-- /primary heading -->
                                        <div id="portlet2" class="panel-collapse collapse in">
                                            <div class="portlet-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Project Name</th>
                                                                <th>Start Date</th>
                                                                <th>Due Date</th>
                                                                <th>Status</th>
                                                                <th>Assign</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Velonic Admin</td>
                                                                <td>01/01/2015</td>
                                                                <td>07/05/2015</td>
                                                                <td><span class="label label-info">Work in Progress</span></td>
                                                                <td>Coderthemes</td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>Velonic Frontend</td>
                                                                <td>01/01/2015</td>
                                                                <td>07/05/2015</td>
                                                                <td><span class="label label-success">Pending</span></td>
                                                                <td>Coderthemes</td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>Velonic Admin</td>
                                                                <td>01/01/2015</td>
                                                                <td>07/05/2015</td>
                                                                <td><span class="label label-pink">Done</span></td>
                                                                <td>Coderthemes</td>
                                                            </tr>
                                                            <tr>
                                                                <td>4</td>
                                                                <td>Velonic Frontend</td>
                                                                <td>01/01/2015</td>
                                                                <td>07/05/2015</td>
                                                                <td><span class="label label-purple">Work in Progress</span></td>
                                                                <td>Coderthemes</td>
                                                            </tr>
                                                            <tr>
                                                                <td>5</td>
                                                                <td>Velonic Admin</td>
                                                                <td>01/01/2015</td>
                                                                <td>07/05/2015</td>
                                                                <td><span class="label label-warning">Coming soon</span></td>
                                                                <td>Coderthemes</td>
                                                            </tr>
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- /Portlet -->
                                </div>
                            </div>
                        </div>
                    </div>
     
                </div> 
            </div>
        </div>
    </div>
</div>
<?php require APPROOT .'/views/inc_pharmacy/footer.php'; ?>