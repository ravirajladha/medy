<!doctype html>
<html>
<head>
    <title>jQuery UI autocomplete with PHP and AJAX</title>
    
    <!-- Script -->
    <script src='<?php echo URLROOT; ?>/autocomp/jquery-3.1.1.min.js' type='text/javascript'></script>

    <!-- jQuery UI -->
    <link href='<?php echo URLROOT; ?>/autocomp/jquery-ui.min.css' rel='stylesheet' type='text/css'>
    <script src='<?php echo URLROOT; ?>/autocomp/jquery-ui.min.js' type='text/javascript'></script>
    
</head>
<body>

    <table>
        <?php for ($i=0; $i < 4; $i++) { 
        ?>
        <tr>
            <td>Single selection</td>
            <td><input type='text' id='a<?php echo $i ?>' class="autocomplete"></td>
        </tr>
        <?php } ?>

    </table>
    <!-- Script -->
    <?php for ($j=0; $j < 4; $j++) { 
    ?>
    <script type='text/javascript' >
    $( function() {
        $( "#a<?php echo $j; ?>" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "<?php echo URLROOT ?>/receptions/at_test",
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
                $('#a<?php echo $j ?>').val(ui.item.value); // display the selected text
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
    <?php } ?>

</body>
</html>



