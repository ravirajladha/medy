<?php require APPROOT .'/views/inc_admin/header.php'; ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">All Reference Lab</h3></div>
               <div class="panel-body">
				<div class="row">
					<div class="table-responsive">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th style="text-align: left;">Sl. No.</th>
                                    <th style="text-align: left;">Reference Lab Name</th>
                                    <th style="text-align: left;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                foreach($data['ref'] as $ref) { ?>
                                <tr>
                                    <td style="text-align: left;"><?php echo $i; ?></td>
                                    <td style="text-align: left;"><?php echo ucwords($ref->ref_lab_name); ?></td>
                                    <td style="text-align: left;">
                                        <button class="btn btn-warning btn-xs" onclick="removeRefLab(<?php echo $ref->ref_lab_id ?>)">Remove</button>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                                }
                                ?>
                            </tbody>    
                        </table>
                    </div>
                </div>
			</div>
		</div>
    </div>
</div>
<?php require APPROOT .'/views/inc_admin/footer.php'; ?>
<script>
    function removeRefLab(ref_lab_id)
    {
        $.ajax({
            url: '<?php echo URLROOT; ?>/admin/removeRefLabBy',
            type: 'POST',
            data: {ref_lab_id},

            success: function(response)
            {
                swal(response);
            }
        });
    }
</script>