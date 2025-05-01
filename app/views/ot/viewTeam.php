<?php require APPROOT .'/views/inc_ot/header.php'; ?>
<div class="wraper container-fluid">       
    <div class="page-title"> 
    	<?php if(isset($data['ot']->ot_team_doc) || isset($data['ot']->ot_team_nur) || isset($data['ot']->ot_team_oth)) { ?>
         <h3 class="title">Operation Team</h3> 
     	<?php } ?>
    </div>
    <?php
    	$docTeam = explode(',', $data['ot']->ot_team_doc);
    	$nurTeam = explode(',', $data['ot']->ot_team_nur);
    	$othTeam = explode(',', $data['ot']->ot_team_oth);
    ?>
    <div class="row">
    	<?php if(isset($data['ot']->ot_team_doc)) { ?>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><center><h3 class="panel-title">Doctors / Surgeon</h3></center></div>
                <div class="panel-body" style="padding-top: 0px!important">
                    <table class="table"> 
                        <thead> 
                            <tr> 
                                <th style="text-align: left;">Name</th> 
                                <th style="text-align: left;">Responsibility</th> 
                            </tr> 
                        </thead> 
                        <tbody> 
                        	<?php for ($i=0, $j=0; $i < sizeof($docTeam); $i = $i + 2, $j++) { 
                        	?>
                            <tr> 
                                <td style="text-align: left;"><?php echo $docTeam[$j]; ?></td> 
                                <td style="text-align: left;"><?php echo $docTeam[$j+2]; ?></td> 
                            </tr> 
                        	<?php } ?>
                        </tbody>
                    </table>
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div>
    	<?php } ?>
    	<?php if(isset($data['ot']->ot_team_doc)) { ?>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><center><h3 class="panel-title">Nurses</h3></center></div>
                <div class="panel-body" style="padding-top: 0px!important">
                    <table class="table"> 
                        <thead> 
                            <tr> 
                                <th style="text-align: left;">Name</th> 
                                <th style="text-align: left;">Responsibility</th> 
                            </tr> 
                        </thead> 
                        <tbody> 
                        	<?php for ($i=0, $j=0; $i < sizeof($nurTeam); $i = $i + 2, $j++) { 
                        	?>
                            <tr> 
                                <td style="text-align: left;"><?php echo $nurTeam[$j]; ?></td> 
                                <td style="text-align: left;"><?php echo $nurTeam[$j+2]; ?></td> 
                            </tr> 
                        	<?php } ?>
                        </tbody>
                    </table>
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div>
    	<?php } ?>
        <?php if(isset($data['ot']->ot_team_doc)) { ?>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><center><h3 class="panel-title">Others</h3></center></div>
                <div class="panel-body" style="padding-top: 0px!important">
                    <table class="table"> 
                        <thead> 
                            <tr> 
                                <th style="text-align: left;">Name</th> 
                                <th style="text-align: left;">Responsibility</th> 
                            </tr> 
                        </thead> 
                        <tbody> 
                        	<?php for ($i=0, $j=0; $i < sizeof($othTeam); $i = $i + 2, $j++) { 
                        	?>
                            <tr> 
                                <td style="text-align: left;"><?php echo $othTeam[$j]; ?></td> 
                                <td style="text-align: left;"><?php echo $othTeam[$j+2]; ?></td> 
                            </tr> 
                        	<?php } ?>
                        </tbody>
                    </table>
                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    	<?php } ?>
</div>
<?php require APPROOT .'/views/inc_ot/footer.php'; ?>
