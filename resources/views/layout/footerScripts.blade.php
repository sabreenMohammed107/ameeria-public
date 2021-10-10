  <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('webassets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('webassets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
      <!-- DataTables -->
      <script src="{{ asset('plugins/datatables/jquery.dataTables.js')}}"></script>
      <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('webassets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('webassets/dist/js/adminlte.js')}}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('webassets/dist/js/demo.js')}}"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <!--<script src="{{ asset('webassets/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{ asset('webassets/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{ asset('webassets/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{ asset('webassets/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
 ChartJS
<script src="{{ asset('webassets/plugins/chart.js/Chart.min.js')}}"></script>-->

    <!-- PAGE SCRIPTS -->
    <script src="{{ asset('webassets/dist/js/pages/dashboard2.js')}}"></script>

    @yield('scripts')
</body>

</html>
