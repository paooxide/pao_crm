
    <!-- Jquery Core Js -->
    <script src="<?=base_url()?>assets/bsb/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?=base_url()?>assets/bsb/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?=base_url()?>assets/bsb/plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?=base_url()?>assets/bsb/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?=base_url()?>assets/bsb/plugins/node-waves/waves.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="<?=base_url()?>assets/bsb/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>


    <!-- Morris Plugin Js -->
    <script src="<?=base_url()?>assets/bsb/plugins/raphael/raphael.min.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/morrisjs/morris.js"></script>


    <!-- ChartJs -->
    <script src="<?=base_url()?>assets/bsb/plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="<?=base_url()?>assets/bsb/plugins/flot-charts/jquery.flot.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/flot-charts/jquery.flot.time.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <!-- Custom Js -->
    <script src="<?=base_url()?>assets/bsb/js/admin.js"></script>
    <script src="<?=base_url()?>assets/bsb/js/pages/tables/jquery-datatable.js"></script>
    <script src="<?=base_url()?>assets/bsb/js/pages/forms/basic-form-elements.js"></script>
    <script src="<?=base_url()?>assets/bsb/js/pages/index.js"></script>
    <!-- Demo Js -->
    <script src="<?=base_url()?>assets/bsb/js/demo.js"></script>

    <script src="<?=base_url()?>assets/bsb/plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="<?=base_url()?>assets/bsb/plugins/raphael/raphael.min.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/morrisjs/morris.js"></script>


    <!-- ChartJs -->
    <script src="<?=base_url()?>assets/bsb/plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="<?=base_url()?>assets/bsb/plugins/flot-charts/jquery.flot.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/flot-charts/jquery.flot.time.js"></script>
    <script src="<?=base_url()?>assets/bsb/plugins/jquery-sparkline/jquery.sparkline.js"></script>
    <!-- Custom Js -->




<script type="text/javascript">


$('#subevents').click(function () {
    $('#exat').find('tr').each(function () {
        var row = $(this);
        if (row.find('input[name="events_list"]').is(':checked')) {
            console.log(this.value);
        }
    });
});


    //
    // $("#subevents").button().click(function(){
    //   var selectedEvents = $("input[name=events_list]:checked").map(
    //       function () {return this.value;}).get().join(",");
    //       console.log(selectedEvents);

    //   $.ajax({
    //     url:"<?=base_url()?>index.php/client/submitholiday",
    //    method:"POST", //First change type to method here
     //
    //    data:{
    //      events: selectedEvents, // Second add quotes on the value.
    //    },
    //    success:function(response) {
    //     if (response === "success") {
    //       location.href = "<?=base_url()?>index.php/client/selectedevents"
    //     } else {
    //       alert('Please check your internet connection');
    //     }
     //
     //
    //   },
    //   error:function(){
    //    alert("error");
    //   }
     //
    //  });

    // });

</script>
</body>

</html>
