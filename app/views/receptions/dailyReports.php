<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Daily Reports</h3></div>
            <div class="row">
                <br>
                <div class="col-md-2">
                    <a href="<?php echo URLROOT; ?>/receptions/dailyGeneralReports"><button class="btn btn-primary" style="width: 200px;">Daily General Report By Cash</button></a>
                </div>
                <div class="col-md-2">
                <a href="<?php echo URLROOT; ?>/receptions/dailyGeneralReports"><button class="btn btn-primary" style="width: 200px;">Daily Lab Report By Cash</button></a>
                </div>
                <div class="col-md-2">
                <a href="<?php echo URLROOT; ?>/receptions/dailyGeneralReports"><button class="btn btn-primary" style="width: 200px;">Daily Lab Report By Digital</button></a>
                </div>
                <div class="col-md-2">
                <a href="<?php echo URLROOT; ?>/receptions/dailyGeneralReports"><button class="btn btn-primary" style="width: 200px;">Daily Lab Report By Digital</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT .'/views/inc_reception/footer.php'; ?>