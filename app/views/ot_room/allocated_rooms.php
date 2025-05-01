<?php require APPROOT .'/views/inc_ot_room/header.php'; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Hospital Available Room Details</h3></div>
            <div class="row">
             </div>
             <br>
              <div class="row">
                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table" >
                                                <thead>
                                                    <tr>
                                                <th>Room No</th>
                                                 <th>Room Type</th>
                                                 <th>Floor No</th>
                                                 <th>Building No</th>
                                                 <th>Address</th>
                                                 <th>Status</th>
                                                
                                                    </tr>
                                                </thead>
                                                <tbody id="stock_all" >
                                                     <?php foreach ($data['ot'] as $key) { 
                                                        if($key->status != '0')
                                                        { ?>
                                                     <tr>
                                                     	<td><?php echo $key->room_no; ?></td>
                    									<td><?php echo ucwords($key->room_type); ?></td>
                                                        <td><?php echo $key->floor_no; ?></td>
                                                        <td><?php echo $key->building_no; ?></td>
                                                        <td><?php echo $key->address; ?></td>
                                                        <td><?php echo "Allocated"; ?></td>
                                                     </tr>
                                                     <?php } } ?>	
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
<?php require APPROOT .'/views/inc_ot_room/footer.php'; ?>