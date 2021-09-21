    <script>
    $(document).ready(function() {
        inicializarDatatable();
        inicializaControlFecha();
        $("#SearchCasos").on('keyup',function(){
            var table = $('#tblReportes').DataTable();
            table.search(this.value).draw();
        });
        $( "#frm_lab_row").change(function() {
            var table = $('#tblReportes').DataTable();
            table.page.len(this.value).draw();
        });


    });

    function Buscar() {
        inicializarDatatable();
    }


    function inicializarDatatable() {
        $('#tblReportes').DataTable({
            ajax: 'getInweb',
            "destroy": true,
            "ordering": true,
            "info": false,
            "bPaginate": true,
            "bfilter": false,
            "searching": true,
            "pagingType": "full_numbers",
            "aaSorting": [
                [0, "desc"]
            ],
            "lengthMenu": [
                [10, 10, -1],
                [10, 30, "Todo"]
            ],
            "language": {
                "zeroRecords": "NO HAY RESULTADOS",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Última ",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                },
                "lengthMenu": "_MENU_",
                "emptyTable": "NO HAY DATOS DISPONIBLES",
                "search":     "BUSCAR"
            },

            columns: [
                { "data": "CUENTA" },
                { "data": "CLIENTE" },
                { "data": "REMITIDO" },
                { "data": "FUENTE" }
            ],
            "columnDefs": [
                {"className": "center", "targets": [ 0, 2 ]},
                {"className": "left", "targets": [ 1 ]},
                {"className": "right", "targets": [ 3 ]}

            ],
            "fnInitComplete": function (dta) {
                $("#tblReportes_filter").hide();
            }
        });

    }
</script>