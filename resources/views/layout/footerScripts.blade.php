  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="{{ asset('webassets/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap -->
  <script src="{{ asset('webassets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- DataTables -->
  <script src="{{ asset('webassets/plugins/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('webassets/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
  <!-- overlayScrollbars -->
  <script src="{{ asset('webassets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  {{-- convert to arabic --}}
  <script src="{{ asset('webassets/plugins/persianNum.jquery-2.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('webassets/dist/js/adminlte.js') }}"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="{{ asset('webassets/dist/js/demo.js') }}"></script>

  <script>
      $(document).ready(function() {

          $('body').persianNum({
              numberType: 'arabic'
          });
          //Enter Key
          $('body').on('keypress', 'input, select', function(e) {
              if (e.key === "Enter") {
                  event.preventDefault();
                  var self = $(this),
                      form = self.parents('form:eq(0)'),
                      focusable, next;
                  focusable = form.find('input,a,select,button,textarea,object').filter(':input');
                  // focusable = form.find('*').filter(':selected');
                  // $('form').find('*').filter(':input:visible:first');
                  if (e.shiftKey) {
                      $(document).on('focus', '.select2-selection.select2-selection--single', function(
                      e) {
                          $(this).closest(".select2-container").siblings('select:enabled')
                              .select2('open');
                      });

                      // steal focus during close - only capture once and stop propogation
                      $('select.select2').on('select2:closing', function(e) {
                          $(e.target).data("select2").$selection.one('focus focusin', function(
                          e) {
                              e.stopPropagation();
                          });
                      });
                      next = focusable.eq(focusable.index(this) - 1);


                  } else {
                      $(document).on('focus', '.select2-selection.select2-selection--single', function(
                      e) {
                          $(this).closest(".select2-container").siblings('select:enabled')
                              .select2('open');
                      });

                      // steal focus during close - only capture once and stop propogation
                      $('select.select2').on('select2:closing', function(e) {
                          $(e.target).data("select2").$selection.one('focus focusin', function(
                          e) {
                              e.stopPropagation();
                          });
                      });
                      next = focusable.eq(focusable.index(this) + 1);

                  }
                  if (next.length) {
                      next.focus();

                  } else {
                      form.submit();
                  }
                  return false;
              }

          });
        //   bsCustomFileInput.init();

          // });

          $('body').persianNum({
              numberType: 'arabic'
          });
      })

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
