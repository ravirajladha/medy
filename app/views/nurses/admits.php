<?php require APPROOT .'/views/inc_nurse/header.php'; ?>
<div class="wraper container-fluid">       
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
          <!--   <input style="margin-top: 10px; border:1px solid lightgray; border-radius: 3px;" type="text" class="form-control" id="search_doc" placeholder="Search Ipd Patient Name"> -->
            </div>
        </div>
    </div> <!-- End row -->
    <div class="page-title"> 
        <h3 class="title">Ipd Patients</h3> 
    </div>
    <div class="row" id="display_ipd">
         <!-- end col -->                  
    </div>
</div>
<?php require APPROOT .'/views/inc_nurse/footer.php'; ?>

<script type="text/javascript">
  $(document).ready(function()
          {
            var lim = 9;
            var off = 0;
            var inc = 0;
              $.ajax({
                type: "POST",
                url: '<?php echo URLROOT;?>/nurses/display_ipd',
                data: {lim,off},
                cache: false,
                success:function(response)
                {
                  $('#display_ipd').html(response); 
                }
              });
               $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height())
                {
                  lim = 10;
                    $.ajax({
                    type: "POST",
                    url: '<?php echo URLROOT;?>/nurses/display_ipd',
                    data: {lim,inc},
                    cache: false,
                    success:function(response)
                    { 
                      inc++;
                      $('#display_ipd').append(response);
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
        url: '<?php echo URLROOT;?>/doctors/display_doc_search',
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
            url: '<?php echo URLROOT;?>/doctors/display_doc',
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
                url: '<?php echo URLROOT;?>/doctors/display_doc',
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
