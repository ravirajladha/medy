
        <!-- Main Content Ends -->



        <!-- js placed at the end of the document so the pages load faster -->
        <script src="<?php echo URLROOT;?>/js/jquery.js"></script>
        <script src="<?php echo URLROOT;?>/js/bootstrap.min.js"></script>
        <script src="<?php echo URLROOT;?>/js/modernizr.min.js"></script>
        <script src="<?php echo URLROOT;?>/js/pace.min.js"></script>
        <script src="<?php echo URLROOT;?>/js/wow.min.js"></script>
        <script src="<?php echo URLROOT;?>/js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo URLROOT;?>/js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="<?php echo URLROOT;?>/assets/chat/moment-2.2.1.js"></script>

        <!-- Counter-up -->
        <script src="<?php echo URLROOT;?>/js/waypoints.min.js" type="text/javascript"></script>
        <script src="<?php echo URLROOT;?>/js/jquery.counterup.min.js" type="text/javascript"></script>

        <!-- EASY PIE CHART JS -->
        <script src="<?php echo URLROOT;?>/assets/easypie-chart/easypiechart.min.js"></script>
        <script src="<?php echo URLROOT;?>/assets/easypie-chart/jquery.easypiechart.min.js"></script>
        <script src="<?php echo URLROOT;?>/assets/easypie-chart/example.js"></script>


        <!--C3 Chart-->
        <script src="<?php echo URLROOT;?>/assets/c3-chart/d3.v3.min.js"></script>
        <script src="<?php echo URLROOT;?>/assets/c3-chart/c3.js"></script>

        <!--Morris Chart-->
        <script src="<?php echo URLROOT;?>/assets/morris/morris.min.js"></script>
        <script src="<?php echo URLROOT;?>/assets/morris/raphael.min.js"></script>

        <!-- sparkline -->
        <script src="<?php echo URLROOT;?>/assets/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="<?php echo URLROOT;?>/assets/sparkline-chart/chart-sparkline.js" type="text/javascript"></script>

        <!-- sweet alerts -->
        <script src="<?php echo URLROOT;?>/assets/sweet-alert/sweet-alert.min.js"></script>
        <script src="<?php echo URLROOT;?>/assets/sweet-alert/sweet-alert.init.js"></script>

        <script src="<?php echo URLROOT;?>/js/jquery.app.js"></script>
        <!-- Chat -->
        <script src="<?php echo URLROOT;?>/js/jquery.chat.js"></script>
        <!-- Dashboard -->
        <script src="<?php echo URLROOT;?>/js/jquery.dashboard.js"></script>

        <!-- Todo -->
        <script src="<?php echo URLROOT;?>/js/jquery.todo.js"></script>

        <script src="<?php echo URLROOT;?>/assets/select2/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo URLROOT;?>/assets/tagsinput/jquery.tagsinput.min.js"></script>
        <script src="<?php echo URLROOT;?>/assets/toggles/toggles.min.js"></script>
        <script src="<?php echo URLROOT;?>/assets/timepicker/bootstrap-timepicker.min.js"></script>
        <script src="<?php echo URLROOT;?>/assets/timepicker/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo URLROOT;?>/assets/colorpicker/bootstrap-colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo URLROOT;?>/assets/jquery-multi-select/jquery.multi-select.js"></script>
        <script type="text/javascript" src="<?php echo URLROOT;?>/assets/jquery-multi-select/jquery.quicksearch.js"></script>
        <script src="<?php echo URLROOT;?>/assets/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo URLROOT;?>/assets/spinner/spinner.min.js"></script>



<footer class="footer">
    <?php $yr = date('Y');?>
    <?php echo $yr;?> © MedHike<span style="float: right;">Kod Software Services Pvt. Ltd.</span>
</footer>
            <!-- Footer Ends -->
<script type="text/javascript">
        /* ==============================================
             Counter Up
             =============================================== */
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });
            });
        </script>
        <script>
            jQuery(document).ready(function() {

                // Tags Input
                jQuery('#tags').tagsInput({width:'auto'});

                // Form Toggles
                jQuery('.toggle').toggles({on: true});

                // Time Picker
                jQuery('#timepicker').timepicker({defaultTIme: false});
                jQuery('#timepicker2').timepicker({showMeridian: false});
                jQuery('#timepicker3').timepicker({minuteStep: 15});

                // Date Picker
                jQuery('#datepicker').datepicker();
                jQuery('#datepicker-inline').datepicker();
                jQuery('#datepicker-multiple').datepicker({
                    numberOfMonths: 3,
                    showButtonPanel: true
                });
                //colorpicker start

                $('.colorpicker-default').colorpicker({
                    format: 'hex'
                });
                $('.colorpicker-rgba').colorpicker();


                //multiselect start
                //spinner start
                $('#spinner1').spinner();
                $('#spinner2').spinner({disabled: true});
                $('#spinner3').spinner({value:0, min: 0, max: 10});
                $('#spinner4').spinner({value:0, step: 5, min: 0, max: 200});
                //spinner end

                // Select2
                jQuery(".select2").select2({
                    width: '100%'
                });
            });
        </script>

        </section>



    </body>
</html>
