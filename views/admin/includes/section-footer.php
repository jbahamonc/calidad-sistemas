</div>
<!-- /.content-wrapper -->
<!-- Main Footer -->
        <footer class="main-footer index">
            <div class="info-box text-center" style="box-shadow: none;">
                <img width="150" src="../../resource/img/logo_ufps_blanco.png">
                <h3>Universidad Fransisco de Paula Santander</h3>
                <h5>Programa Ingenieria de Sistemas</h5>
                <p>Creado por: <b>Jefferson Bahamon Cuevas - Wilmer Fernando Gelves - Andrea Parra - Alexander Ibarra</b></p>
            </div>
        </footer>
    </div>
  <!-- ./wrapper -->

  <!-- REQUIRED JS SCRIPTS -->

  <!-- Bootstrap 3.3.6 
  <script src="bootstrap/js/bootstrap.min.js"></script>
   AdminLTE App -->
  <script src="../../resource/js/jquery-2.2.3.min.js"></script>
  <script src="../../resource/js/jquery.slimscroll.min.js"></script>
  <script src="../../resource/bootstrap/js/bootstrap.min.js"></script>
  <script src="../../resource/js/jquery.jgrowl.min.js"></script>
  <script src="../../resource/js/jquery.dataTables.min.js"></script>
  <script src="../../resource/js/dataTables.bootstrap.min.js"></script>
  <script src="../../resource/js/ajax.js"></script>
  <script src="../../resource/js/app.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $('#example').DataTable({
            "zeroRecords":    "No hay resultados",
            "search":         "Buscar:",
            "emptyTable":     "No hay resultados",
            "infoEmpty":      "Mostrando 0 to 0 de 0 entradas",
            "paginate": {
                "first":      "Inicio",
                "last":       "Ultimo",
                "next":       "Sig",
                "previous":   "Ant"
            }
        });
        $('#example2').DataTable();
    });
  </script>
  <script>
    $('#modal-update-est').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); 
      var action = button.data("whatever");
      var modal = $(this);      
      if (action == "register") {
        modal.find("#action").val(action);
      }
      else {
        var title = button.data('title');
        var place = button.data('place');
        var date_ini = button.data('date-ini');
        var date_fin = button.data('date-fin');
        var thesis = button.data('thesis');
        var id = button.data('id');
                
        modal.find('#id_est').val(id);        
        modal.find('#titulo').val(title);
        modal.find('#fecha_inicio').val(date_ini);
        modal.find('#lugar').val(place);
        modal.find('#fecha_fin').val(date_fin);
        modal.find('#tesis').val(thesis);
      }
      var id_doc = button.data('doc');
      modal.find('#id_doc').val(id_doc);
    });
  </script>
</body>
</html>