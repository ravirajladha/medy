<?php require APPROOT .'/views/inc_labs/header.php';?>
<style type="text/css">
    #no_arrow::-webkit-inner-spin-button, 
    #no_arrow::-webkit-outer-spin-button
    { 
      -webkit-appearance: none; 
       margin: 0; 
    }
</style>
<?php
$order_id_lab = $data['id'];
foreach ($data['row'] as $key)
{
    $patient_name = $key->invoice_name;
    $patient_name = explode('|', $patient_name);
    $order_id = $key->invoice_id;
    $invoice_item = explode(',', $key->invoice_item);
    $count = count($invoice_item);
    $count = $count - 1;
}
$c_cont = new labs;
?>

<br>
<div class="col-lg-12">
    <div class="alert alert-success" style="background-color:#1B4F72;color: white">
       	<span>Order ID : #<?php echo $order_id?> | Patient Name : <?php echo $patient_name[0]?></span>
        <span style="float: right;"><button class="btn btn-primary btn-xs m-b-5" data-toggle="modal" data-target="#exampleModal">Upload Doc</button></span>
        <?php foreach ($data['labTestData'] as $key) {
            $testDoc = $key->lab_test_document;
        }
        if(isset($testDoc))
        {
        ?>
        <hr>
        <span><?php
            $testDoc = explode(',', $testDoc); 
            for ($y=0; $y < sizeof($testDoc); $y++) { 
                ?>
                    <a href="<?php echo URLROOT; ?>/reports/<?php echo $testDoc[$y]; ?>" target="_blank"><button class="btn btn-success btn-xs m-b-5"><i class="fa fa-file-text" aria-hidden="true"></i> <?php echo $testDoc[$y]; ?></button></a>
                <?php
            }
        ?></span>
        <?php } ?>
    </div> 
</div>


<!-- ############################################################################################## -->
<div class="col-lg-12">
    <div class="panel-group panel-group-joined" id="accordion-test">
<?php 
    for($i=1,$j=0;$i<=$count/4;$i++,$j++)
    { 
        $x = $j + $i;
?>
        <div class="panel panel-default"> 
            <div class="panel-heading"> 
                <h4 class="panel-title"> 
                    <a data-toggle="collapse" data-parent="#accordion-test" href="#collapseOne<?php echo $i?>" class="collapsed">
                        <?php echo $invoice_item[2*$x];
                        $lab_test_id_per = trim($invoice_item[2*$x - 2]);
                        $lab_test_val_det = $c_cont->get_lab_test_val_for_id($lab_test_id_per);
                        $data_after_update = $c_cont->get_data_after_update($order_id_lab,$lab_test_id_per);
                        foreach ($data_after_update as $key3)
                        {
                            $val_1234 = $key3->lab_test_values;
                            $status = $key3->lab_test_status;
                        }
                        
                        if($val_1234 == NULL)
                        {
                            foreach ($lab_test_val_det as $key2)
                            {
                                $object = explode(',',$key2->lab_test_values);
                                $loop = count($object);
                                for ($kk=0; $kk < $loop/4; $kk++)
                                { 
                                    $span_unit = $object[($kk * 4) + 2];
                                }
                            }
                        }


                        else
                        {
                            foreach ($data_after_update as $key4)
                            {
                                $object = explode(',',$key4->lab_test_values);
                                $loop = count($object);
                                $loop = $loop - 1;
                            }

                            foreach ($lab_test_val_det as $key2)
                            {
                                $object1 = explode(',',$key2->lab_test_values);
                                $loop1 = count($object1);
                                for ($kk=0; $kk < $loop1/4; $kk++)
                                { 
                                    $span_unit = $object1[($kk * 4) + 2];
                                }
                            }
                        }
                        ?>
                    </a> 
                </h4> 
            </div> 
<!-- ############################################################################################## -->

            <div id="collapseOne<?php echo $i;?>" class="panel-collapse collapse">
      
             <form action="<?php echo URLROOT;?>/labs/update_the_test_data" method="POST"> 
                <div class="panel-body">
                   <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Object</th>
                                    <th>Specimen</th>
                                    <th>Result</th>
                                    <th>Biol.Ref.Int</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                for ($k=0; $k < $loop/4; $k++)
                                { 
                            ?>    
                                <tr>
                                    <td>
                                        <input type="number" name="i_id" style="display: none" value="<?php echo $order_id_lab?>">
                                        <input type="number" name="t_id" style="display: none" value="<?php echo $lab_test_id_per?>">
                                        <p style="margin-top: 13px;"><?php echo $object[$k * 4];?></p>
                                        <input style="display: none" type="text" name="object[]" value="<?php echo $object[$k * 4];?>">
                                    </td>
                                    <td>
                                       <input class="form-control" style="border: solid gray 1px;margin-top: 10px;" type="text" name="specimen[]" value="<?php echo $object[($k * 4) + 1];?>"  <?php if(isset($status) and $status == 2) {?> disabled <?php } ?>> 
                                    </td>
                                    <td>
                                        <div class="input-group m-t-10">
                                            <input class="form-control" style="border: solid gray 1px" type="text" name="result[]" <?php if($status != 0) { ?>value="<?php if(isset($object[($k * 4) + 2])){echo $object[($k * 4) + 2];}}?>"  <?php if(isset($status) and $status == 2) {?> disabled <?php } ?>>
                                            <span class="input-group-addon" style="border: solid gray 1px; border-left: none;"><?php echo $span_unit;?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <p style="margin-top: 13px;"><?php echo $object[($k * 4) + 3];?></p>
                                        <input style="display: none" type="text" name="bri[]" value="<?php echo $object[($k * 4) + 3];?>">
                                    </td>
                                </tr>
                            <?php 
                                } 
                            ?>    
                            </tbody>
                        </table>
                    </div>
                    <?php if(isset($status) and $status != 2)
                    {
                        ?>
                    <input type="submit" name="update_button" style="margin-top: 8px;" class="btn btn-primary w-sm m-b-5" value="Update">
                    <input type="submit" name="Finish_button" style="margin-top: 8px;" class="btn btn-success w-sm m-b-5" value="Finish">
                <?php } ?>
                </div> 
            </form>
            </div> 
        </div><br> 
<?php }?>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Upload Document</h5>
      </div>
      <form action="<?php echo URLROOT;?>/labs/uploadTestDocument/<?php echo $order_id; ?>" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-group">
            <label>Select Document</label>
            <input type="number" name="t_id" style="display: none" value="<?php echo $lab_test_id_per?>">
            <input type="file" name="docs[]" class="form-control" multiple="" accept="application/pdf,application/vnd.ms-word">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Upload</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </form>
    </div>
  </div>
</div>

<?php require APPROOT .'/views/inc_labs/footer.php'; ?>


<script type="text/javascript">
    $('.panel-collapse').on('shown.bs.collapse', function (e) {
    var $panel = $(this).closest('.panel');
    $('html,body').animate({
        scrollTop: $panel.offset().top-60
    }, 500); 
}); 
</script>