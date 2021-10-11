  <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('webassets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('webassets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
      <!-- DataTables -->
      <script src="{{ asset('webassets/plugins/datatables/jquery.dataTables.js')}}"></script>
      <script src="{{ asset('webassets/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('webassets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('webassets/dist/js/adminlte.js')}}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('webassets/dist/js/demo.js')}}"></script>

    <script>
        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>

    @yield('scripts')
</body>

</html>
