<?php require APPROOT .'/views/inc_nurse/header.php'; ?>
<script type="text/javascript">
    var jan = <?php echo $data['jan'];?>;
    var feb = <?php echo $data['feb'];?>;
    var mar = <?php echo $data['mar'];?>;
    var apr = <?php echo $data['apr'];?>;
    var may = <?php echo $data['may'];?>;
    var jun = <?php echo $data['jun'];?>;
    var jul = <?php echo $data['jul'];?>;
    var aug = <?php echo $data['aug'];?>;
    var sep = <?php echo $data['sep'];?>;
    var oct = <?php echo $data['oct'];?>;
    var nov = <?php echo $data['nov'];?>;
    var dec = <?php echo $data['dec'];?>;
    sessionStorage.setItem("jan", jan);
    sessionStorage.setItem("feb", feb);
    sessionStorage.setItem("mar", mar);
    sessionStorage.setItem("apr", apr);
    sessionStorage.setItem("may", may);
    sessionStorage.setItem("jun", jun);
    sessionStorage.setItem("jul", jul);
    sessionStorage.setItem("aug", aug);
    sessionStorage.setItem("sep", sep);
    sessionStorage.setItem("oct", oct);
    sessionStorage.setItem("nov", nov);
    sessionStorage.setItem("dec", dec);
 </script>
<div class="wraper container-fluid">
                <div class="page-title"> 
                    <h3 class="title">Welcome !</h3> 
                </div>
               <div class="row">
                    <div class="col-lg-3 col-sm-6">
                    	<a data-target="#patientque" data-toggle="modal" >
                        <div class="widget-panel widget-style-2 white-bg" style="padding:23px">
                        	<div style="color:gray; font-size: 16px;">OP(Visit) Patient</div>
                            <i style="color:tomato; padding:5px" class="ion-ios7-person"></i>      
                            <div style="color:gray; font-size: 16px;">In Queue</div>
                            <div id="count"></div>
                        </div></a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                    	<a href="<?php echo URLROOT;?>/nurses/admits">
                        <div class="widget-panel widget-style-2 white-bg" style="padding:30px">
                        	<div style="color:gray; font-size: 16px;">IP(Admit) Patient</div>
                            <i style="color: #660099; padding: 5px;" class="ion-ios7-people"></i>                             
                            <div style="color: gray; font-size: 16px;">Monitor</div>
                            <h2 style="color: gray" class=""; style=""></h2>
                        </div></a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                    	<a data-target="#reportupload" data-toggle="modal" >
                        <div class="widget-panel widget-style-2 white-bg" style="padding:30px">
                        	<div style="color:gray; font-size: 16px;">Reports</div>
                            <i style="color:gray; padding: 5px;" class="ion-android-note"></i>                             
                            <div style="color: gray; font-size: 16px;">Upload</div>
                            <h2 style="color: gray" class=""; style=""></h2>
                        </div></a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                    	<a data-target="#printpris" data-toggle="modal" >
                        <div class="widget-panel widget-style-2 white-bg" style="padding:30px">
                        	<div style="color:gray; font-size: 16px;">Prescription</div>
                            <i style="color: #2874A6; padding: 5px;" class="ion-android-printer"></i>                             
                            <div style="color: gray; font-size: 16px;">Print</div>
                            <h2 style="color: gray" class=""; style=""></h2>
                        </div></a>
                    </div>
                </div>
               <div class="row">
                <div class="col-lg-3">
                    
                </div>
                    <!-- <div class="col-lg-12">
                        <div class="portlet">
                            <div class="portlet-heading">
                                <h3 class="portlet-title text-dark">
                                    Bar chart
                                </h3>
                                <div class="portlet-widgets">
                                    <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                    <span class="divider"></span>
                                    <a data-toggle="collapse" data-parent="#accordion1" href="#portlet2"><i class="ion-minus-round"></i></a>
                                    <span class="divider"></span>
                                    <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div id="portlet2" class="panel-collapse collapse in">
                                <div class="portlet-body">
                                    <canvas id="lineChart" data-type="lineChart" height="250" width="800" ></canvas>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                 <!-- end row -->
           <!-- End row -->
        </div>

        <div id="patientque" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog"> 
                        <div class="modal-content"> 
                            <div class="modal-header" style=""> 
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                <h4 class="modal-title">Patients in Queue</h4> 
                            </div> 
                            <div class="modal-body">
                            <div class="row"> 
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Visit ID</th>
                                                    <th>Patient</th>                              
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="display_visit">
                                                 
                                            </tbody>
                                        </table>
                                    </div>
                                 </div>
                            </div> 
                            </div>
                        </div>
                    </div>
                </div>


                



        <div id="reportupload" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <form method="post" action="<?php echo URLROOT;?>/nurses/report_up" enctype="multipart/form-data"> 
                    <div class="modal-dialog"> 
                        <div class="modal-content"> 
                            <div class="modal-header"> 
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                <h4 class="modal-title">Upload Reports</h4> 
                            </div> 
                            <div class="modal-body">
                            <div class="row"> 
                                <div class="col-md-12">
                                    <div class="col-md-12">
						                <div class="form-group">
											<label for="exampleInputEmail1">Enter Visit ID</label>
						                        <input style="margin-top: 10px;" name="report_vid" type="text" class="form-control" placeholder="">
									    </div>
									</div>
									<div class="col-md-12">
						                <div class="form-group">
											<label for="exampleInputEmail1">Enter Report Title</label>
						                        <input style="margin-top: 10px;" type="text" class="form-control" placeholder="" name="report_title">
									    </div>
									</div>
									<div class="col-md-12">
						                <div class="form-group">
                                            <label for="exampleInputEmail1">Please Select a Report</label>
                                            <input style="margin-top: 10px;" name="files" type="file" class="form-control" placeholder="">
                                        </div>
									</div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info w-md m-b-5">Create Test</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="pgbar"></div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </form>
                </div>
                <div id="printpris" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog"> 
                        <div class="modal-content"> 
                            <div class="modal-header"> 
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                <h4 class="modal-title">Prescriptions</h4> 
                            </div> 
                            <div class="modal-body">
                            <div class="row"> 
                                <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Visit ID</th>
                                                        <th>Doctor</th>                              
                                                        <th>Patient</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="prec_display">
                                                      
                                                </tbody>
                                            </table>
                                        </div>
                                     </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
<?php require APPROOT .'/views/inc_nurse/footer.php'; ?>

<script type="text/javascript">
 setInterval(function(){ 
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/nurses/all_visit_ajax',
                data: {lim,off},
                cache: false,
                success:function(response)
                {``
                  $('#display_visit').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/nurses/all_visit_ajax',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#display_visit').append(response);
                    }
                  });
                }
            });
          });
  }, 30000);
</script>
<script type="text/javascript">
    $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/nurses/all_visit_ajax',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#display_visit').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/nurses/all_visit_ajax',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#display_visit').append(response);
                    }
                  });
                }
            });
          });
</script>

<script type="text/javascript">
 setInterval(function(){ 
  $(document).ready(function()
          {
            $.ajax({
                url : '<?php echo URLROOT;?>/doctors/get_count',
                success : function(data){
                    $('#count').html(data);
                }
            });
        });
  }, 50000);
</script>


<script type="text/javascript">
    $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/doctors/all_prescription',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#prec_display').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/doctors/all_prescription',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#prec_display').append(response);
                    }
                  });
                }
            });
          });
</script>


