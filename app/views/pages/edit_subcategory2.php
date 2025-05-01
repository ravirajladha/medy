<?php require APPROOT . '/views/inc/header.php'; ?>                   
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Edit secondary Categories</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/pages/index">Home</a></li>
                </ol>
            </div>
        </div>
    </div>          
</div>  
<?php $sa = $data['get_all_subcategory2'];?>
<div class="contentbar">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="<?php echo URLROOT; ?>/pages/all_subcategories2"><button class="btn btn-link pull-right">All secondary Categories</button></a>
                    <h5>Edit secondary Category</h5>
                    <hr>
                    <form action="<?php echo URLROOT; ?>/pages/updatesubCategoryDb2" method="POST">
                        <input type="text" name="cId2" value="<?php echo $sa->sc2_id;?>" style="display: none;">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">secondary Category Name</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="cName2" required="true" autocomplete="off" value="<?php echo $sa->sc2_name;?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
<?php if(isset($_SESSION['success'])){ ?>
    <script type="text/javascript">
        swal("<?php echo $_SESSION['success']; ?>");
    </script>
<?php } unset($_SESSION['success']); ?>
