<?php require APPROOT .'/views/inc_doctor/header.php'; ?>
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
 <style type="text/css">
         #unlist{
        max-height: 100px;
        max-width: 400px;
        min-width: 400px;
        position: absolute;
        overflow-x: hidden;
        background-color: white;
        border: solid;
        border-width: 1px;
        border-color: lightgray;
        font-size: 13px;
        cursor: pointer;
        z-index: 50;
        text-align: left;
      }
      .ipd_val{
        margin: 4px;
        font-size: 14px;
      }
      .ipd_val:hover
      {
        background-color: #EAEDED;
        margin-right: 10px;
      }
      ul.ui-autocomplete
      {
        z-index: 1100;
      } 
 </style>
<div class="wraper container-fluid">
                <div class="page-title"> 
                    <h3 class="title">Welcome &nbsp; <span style="color: #2980B9;">Dr. <?php echo ucwords($_SESSION['user_name']); ?></span></h3> 
                   
                </div>
               <div class="row">
                    <!-- <div class="col-lg-3 col-sm-6">
                    	<a data-target="#patientque" data-toggle="modal" >
                        <div class="widget-panel widget-style-2 bg-pink" style="padding:23px">
                        	<div style="color:; font-size: 16px;">OP Patient</div>
                            <i style="margin-top: -50px; height: 130px;width: 113px;" class="ion-ios7-person"></i>      
                            <div style="color:; font-size: 16px;">In Queue</div>
                            <div id="count"></div>
                        </div></a>
                        
                    </div> -->
                    <div class="col-lg-3 col-sm-6">
                        <a data-target="#patientque" data-toggle="modal" >
                        <div class="widget-panel widget-style-2 bg-pink">
                            <i class="ion-ios7-person" style="width: 113px; height: 137px;"></i> 
                            <h2 class="m-0 counter" id="count" style="color: white!important;">0</h2>
                            <div style="font-size: 13px;">OP(Visit) Queue</div>
                        </div></a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                    	<a href="<?php echo URLROOT;?>/doctors/admissions">
                        <div class="widget-panel widget-style-2 bg-purple" style="height: 135px;">
                            <i class="ion-ios7-people" style="height: 135px;"></i> 
                            <div style="font-size: 16px;">IP(Admit) Patient</div>
                            <div style="font-size: 16px;">Monitor</div>
                        </div>
                    </a>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                    	<a data-target="#reportupload" data-toggle="modal" >
                        <div class="widget-panel widget-style-2 bg-info" style="height: 135px;">
                            <i class="ion-android-note" style="height: 135px;"></i> 
                            <div style="font-size: 16px;">Reports</div>
                            <div style="font-size: 16px;">Upload</div>
                        </div></a>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                    	<a data-target="#printpris" data-toggle="modal" >
                        <div class="widget-panel widget-style-2 bg-success" style="height: 135px;">
                            <i class="ion-android-printer" style="height: 135px;"></i> 
                            <div style="font-size: 16px;">Prescription</div>
                            <div style="font-size: 16px;">Print</div>
                        </div></a>
                    </div>
                </div>

<!-- graph start here -->
               <!-- <div class="row">
                <div class="col-lg-3">
                </div>
                    <div class="col-lg-12">
                        <div class="portlet">
                            <div class="portlet-heading">
                                <h3 class="portlet-title text-dark">
                                    Patients Visit Chart
                                </h3>
                                <div class="clearfix"></div>
                            </div>
                            <div id="portlet2" class="panel-collapse collapse in">
                                <div class="portlet-body">
                                    <canvas id="lineChart" data-type="lineChart" height="250" width="800" ></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="page-title"> 
                    <h3 class="title">Patients details</h3> 
                </div>
                 <div class="wraper container-fluid">
                                  
                 <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-7">
                            <ul class="timeline" style="margin-right: 0px;">
                                <li class="timeline-inverted">
                                    <div class="timeline-badge info" ><i class="fa  fa-bed"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">Yearly</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <span>Total Patients: <?php echo $data['y'];?> </span>
                                           
                                        </div>
                                    </div>
                                </li>
                                <!-- <li class="timeline-inverted">
                                    <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
                                </li> -->
                                <li class="timeline-inverted">
                                    <div class="timeline-badge warning"><i class="fa  fa-bed"></i>
                                    </div>
                                   <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">Monthly </h4>
                                            
                                        </div>
                                        <div class="timeline-body">
                                            <span>Total Patients: <?php echo $data['m'];?></span>
                                            
                                        </div>
                                    </div>
                                </li>
                                
                                <li class="timeline-inverted">
                                    <div class="timeline-badge" style="background-color: tomato;"><i class="fa fa-bed"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">Today's </h4>
                                            
                                        </div>
                                        <div class="timeline-body">
                                            <span>Total Patients: <?php echo $data['d'];?></span>
                                           
                                        </div>
                                    </div>
                                </li>

                                                         
                            </ul>
                        </div>
                        
                    </div>
                </div>
          
                </div>

<!-- graph end here -->
                 <!-- end row -->
           <!-- End row -->
        </div>

        <div id="patientque" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog"> 
                        <div class="modal-content"> 
                            <div class="modal-header"> 
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
            </div>


                



        <div id="reportupload" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <!-- <form method="post" action="" enctype="multipart/form-data">  -->
                    <div class="modal-dialog"> 
                        <div class="modal-content"> 
                            <div class="modal-header"> 
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                                <h4 class="modal-title">Upload Reports</h4> 
                            </div> 
                            <div class="modal-body">
                            <div class="row"> 
                                <div class="col-md-12">
                                    <div class="col-md-6">
						                <div class="form-group">
											<label for="exampleInputEmail1">Enter ID</label>
						                        <input style="margin-top: 10px;" name="report_up" type="text" class="form-control autocomplete" placeholder="" id="a">
									    </div>
									</div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select ID Type</label>
                                            <select class="form-control" id="idType" style="margin-top: 10px;">
                                                <option value="1">IP(Admit)</option>
                                                <option value="2">OP(visit)</option>
                                            </select>
                                        </div>
                                    </div>
									<div class="col-md-12">
						                <div class="form-group">
											<label for="exampleInputEmail1">Enter Report Title</label>
						                        <input style="margin-top: 10px;" type="text" id="rep_tit" class="form-control" placeholder="" name="report_title">
									    </div>
                      <!-- <input type='text' id='a' class="autocomplete"> -->
									</div>
									<div class="col-md-12">
						                <div class="form-group">
                                            <label for="exampleInputEmail1">Please Select a Report</label>
                                            <input style="margin-top: 10px;" name="file" type="file" id="file" class="form-control" placeholder="">
                                        </div>
									</div>
                                    <div class="col-md-12">
                                        <div class="progress aft_upd1" style="display: none;">
                                            <div class="progress-bar progress-bar-success progress-bar-striped progress-animated wow animated" role="progressbar" aria-valuenow="48" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                            </div>
                                        </div> 
                                        <div class="aft_upd2" style="display: none;">
                                            <span style="color: #81C784">File Uploaded Successfully.</span>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" id="upl_doc" class="btn btn-info w-md m-b-5">Upload</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="pgbar"></div>
                                </div> 
                            </div>  
                        </div>
                    </div>
                </div>
            <!-- </form> -->
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
                                                        <th>Date</th>
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
<?php require APPROOT .'/views/inc_doctor/footer.php'; ?>

<script type="text/javascript">
 setInterval(function(){ 
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/doctors/all_visit_ajax',
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
                    url: '<?php echo URLROOT;?>/doctors/all_visit_ajax',
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
                url: '<?php echo URLROOT;?>/doctors/all_visit_ajax',
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
                    url: '<?php echo URLROOT;?>/doctors/all_visit_ajax',
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
  }, 5000);
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

<script type="text/javascript">
     $(document).ready(function(){
      $('#ip_rep').keyup(function(){
        var query3 = $(this).val();
        if(query3!=0)
        {
          $.ajax({
            url:'<?php echo URLROOT;?>/doctors/autocomplete_ip_patients',
            type:'POST',
            data:{query3:query3}, 
            success:function(data)
            {
              $('#unlist').fadeIn();
              $('#unlist').html(data);
            }
          });
        }
        else
        {
          $('#unlist').fadeOut();
        }
      });
       $(document).on('click', '.ipd_val', function(){
           $('#ip_rep').val($(this).text()); 
           $('#unlist').fadeOut();  
      });
      $(document).click(function (event){
        $('#unlist').fadeOut(); 
      });  
    });
  </script>

<script type="text/javascript"> 
$(document).ready(function() { 
    $("#upl_doc").click(function() { 
        var ip_rep = $('#a').val();
        var idType = $('#idType').val();
        var rep_tit = $('#rep_tit').val();
        var fd = new FormData(); 
        var files = $('#file')[0].files[0]; 
        fd.append('file', files); 
        $.ajax({ 
            url: '<?php echo URLROOT; ?>/doctors/doc_upload_jq', 
            type: 'POST', 
            data: fd,
            contentType: false, 
            processData: false, 
            success: function(response){ 
                if(response != 0){ 
                   $('.aft_upd1').css("display", "block");
                   setTimeout( function(){ 
                    $('.aft_upd2').css("display", "block"); 
                  }  , 5000 );
                    save_other_upload_details(ip_rep, rep_tit, idType);
                } 
                else{ 
                    alert('file not uploaded'); 
                } 
            }, 
        }); 
    }); 
}); 

function save_other_upload_details(ip_rep, rep_tit, idType)
{
    $.ajax({
        url:'<?php echo URLROOT; ?>/doctors/save_other_upload_details',
        type:'POST',
        data:{ip_rep, rep_tit, idType},
        success : function(data)
        {
            return true;
        }
    });
}
</script>

<!-- Script -->
<script src='<?php echo URLROOT; ?>/autocomp/jquery-3.1.1.min.js' type='text/javascript'></script>

<!-- jQuery UI -->
<link href='<?php echo URLROOT; ?>/autocomp/jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo URLROOT; ?>/autocomp/jquery-ui.min.js' type='text/javascript'></script>

</head>
<body>

<script type='text/javascript' >
$( function() {
    $( "#a" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "<?php echo URLROOT ?>/doctors/autocomplete_ip_patients1",
                type: 'post',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        select: function (event, ui) {
            $('#a').val(ui.item.label); // display the selected text
            return false;
        }
    });
});

function split( val ) {
  return val.split( /,\s*/ );
}
function extractLast( term ) {
  return split( term ).pop();
}

</script>