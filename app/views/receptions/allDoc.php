<?php require APPROOT .'/views/inc_reception/header.php'; ?>
<div class="wraper container-fluid">       
                <div class="row">
                    <div class="col-md-9">
                      <div class="page-title"> 
                    <h3 class="title">All Doctors</h3> 
                </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                        <input style="margin-top: 10px; border:1px solid gray; border-radius: 9px;" type="text" class="form-control" id="search_doc" placeholder="Search Doctor Name">
    	    			        </div>
                    </div>               
                </div> <!-- End row -->
				        
                <div class="row" id="display_doctors">
                     <!-- end col -->                  
                </div>
<?php require APPROOT .'/views/inc_reception/footer.php'; ?>

<script type="text/javascript">
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/receptions/display_doc',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#display_doctors').html(response);
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/receptions/display_doc',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#display_doctors').append(response);
                    }
                  });
                }
            });
          });
</script>


<script type="text/javascript">
$(document).ready(function()
{
    $('#search_doc').keyup(function(){
    var search = $('#search_doc').val();
    if(search != 0)
    {
      $.ajax({
        type: "POST",
        url: '<?php echo URLROOT;?>/receptions/display_doc_search',
        data: {search},
        cache: false,
        success:function(response)
        {
          $('#display_doctors').html(response);
        }
      });
    }
    else
    {
    $(document).ready(function()
      {
        var lim = 9;
        var off = 0;
        var inc = 0;
          $.ajax({
            type: "POST",
            url: '<?php echo URLROOT;?>/receptions/display_doc',
            data: {lim,off},
            cache: false,
            success:function(response)
            {
              $('#display_doctors').html(response);
            }
          });
           $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height())
            {
              lim = 10;
                $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/receptions/display_doc',
                data: {lim,inc},
                cache: false,
                success:function(response)
                { 
                  inc++;
                  $('#display_doctors').append(response);
                }
              });
            }
        });
      });
    }
  });
});
</script>