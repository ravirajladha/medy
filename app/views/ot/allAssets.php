<?php require APPROOT .'/views/inc_ot/header.php'; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Assets</h3></div>
            <div class="row">
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table" >
                            <thead>
                                <tr>
                                    <th>Assets Id</th>
                                    <th>Assets Name</th>
                                    <th>Assets Type</th>
                                    <th>Assets Amount</th>
                                    <th>Assets Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['ot_assets'] as $k) { ?>
                                <tr>
                                    <td><?php echo $k->id; ?></td>
                                    <td><?php echo $k->a_name; ?></td>
                                    <td><?php echo $k->a_type; ?></td>
                                    <td><?php echo $k->a_amount; ?></td>
                                    <td><?php echo $k->a_date; ?></td>
                                    <td><a href="<?php echo URLROOT; ?>/ot/delete_asset/<?php echo $k->id; ?>" class="btn btn-danger">Delete</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT .'/views/inc_ot/footer.php'; ?>