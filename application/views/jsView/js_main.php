    <script>
    $(document).ready(function() {
        $('.modal').modal();

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



    function getTransac(nombre) {

        $('#mdlRemitidos').modal('open');
        $("#btn_load_factura").show();

        $("#id-lbl-load-factura").hide();
        $("#lbl_load_factura").html("");
        $("#id-footer").hide();
        $.ajax({
            url: "Info_Cuenta/"+nombre ,
            type: 'get',
            async: true,
            success: function(data) {
                if (data.length!=0) {
                    $.each(JSON.parse(data), function(i, item) {
                        var t = $('#tblRemitente').DataTable( {
                            order: [[ 0, 'asc' ]],
                            "destroy": true,
                            "columnDefs": [
                                {"className": "center", "targets": [ 0, 1,2,3,4,5,6 ]},
                                { "visible": false, "targets": [0,5] }

                            ]
                        } );
                        t.rows().remove().draw();
                        $("#id_lbl_cod_cliente").html(item['array_detalles'][0]['CLIENTE']);
                        $("#id_lbl_name_cliente").html(item['array_detalles'][0]['NOMBRE_CLIENTE']);
                        $("#id_lbl_dir_cliente").html(item['array_detalles'][0]['DIRECCION_FACTURA']);
                        $("#id_lbl_telefono_cliente").html(item['array_detalles'][0]['TELEFONO1']);
                        $("#id_factura_cliente").html(item['array_detalles'][0]['FACTURA']);
                        $("#id_factura_fecha_cliente").html(item['array_detalles'][0]['FECHA']);
                        $("#id_total_factura").html(numeral(item['array_detalles'][0]['TOTAL_FACTURA']).format('0,0.00'));

                        $.each(item['array_detalles'], function(i, item) {
                            t.row.add( [
                                item['LINEA'],
                                item['UNID_MEDIDA'],
                                item['ARTICULO'],
                                item['DESCRIPCION'],
                                numeral(item['CANTIDAD']).format('0,0'),
                                "C$ " + numeral(item['PRECIO_TOTAL']).format('0,0.00'),
                                item['FOUND'],
                            ] ).draw( true );

                        });

                        if(item['array_isViable']=="N"){
                            $("#btn_load_factura").hide();
                            $("#lbl_load_factura").html("Factura no es Apta  para cargar.");
                        }


                        if(item['array_BtnAccition']['Btn_Down']=="On"){
                            $("#id-lbl-load-factura").show();
                            $("#lbl_load_factura").html("Factura ya fue cargada");
                        }


                        (item['array_BtnAccition']['Btn_Load']=="On") ? $("#btn_load_factura").show()    : $("#btn_load_factura").hide();
                        (item['array_BtnAccition']['Btn_Down']=="On") ? $("#btn_down_factura").show()    : $("#btn_down_factura").hide();

                    });
                    $("#tblRemitente_info,#tblRemitente_filter").hide();





                }else if (data.length===0) {
                    alert("Error");
                }

            }
        });




    }

    $("#btn_load_factura").on("click",function () {
        mFactura        = $("#id_factura_cliente").html();
        Swal.fire({
            title: '¿Seguro de subir la Factura Nº:'+ mFactura +' ?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
            }).then((result) => {
            if (result.value) {
            procesarFactura(mFactura,"UP","")
        }

        });
    });

    $("#btn_down_factura").on("click",function () {
        mFactura        = $("#id_factura_cliente").html();



        Swal.fire({
            input: 'textarea',
            inputPlaceholder: 'Escribe la razon....',
            inputAttributes: {
                'aria-label': 'Escribe la razon.'
            },
            title: '¿Esta Seguro?',
            text: 'que desea descar esta factura ',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value) {
            procesarFactura(mFactura,"DOWN",result.value)

        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Cancelar',
                '',
                'error'
            )
        }
    })


    });

    function procesarFactura(mFactura,mAccion,Razon) {
         Razon = (Razon=="")? "ND" : Razon ;

        swal({
                title: 'Procesando, Espere...',
                onOpen: () => {
                swal.showLoading()
    }
    })


        $.ajax({
            url: "Load_factura/"+mFactura+"/"+mAccion ,
            type: "POST",
            async: true,
            success: function (data) {
                if(true){
                    swal({
                        text: "Cantidad actualizada!",
                        type: "success",
                        confirmButtonText: "aceptar"
                    }).then(function () {
                        Razon
                        $.ajax({
                            url: "save_log_factura/"+mFactura+"/"+mAccion+"/"+Razon ,
                            type: "POST",
                            async: true,
                            success: function () {
                                if(true){
                                    location.reload();
                                }
                            }
                        });
                    });


                }else{
                    swal({
                        text: "Ocurrio un error! Contáctese con el administrador",
                        type: "error",
                        confirmButtonText: "aceptar"
                    }).then(function () {
                        location.reload();
                    });
                }
            }
        });
    }



    function Buscar() {
        var mFechaDesde        = $("#desde").val();
        var mFechaHasta        = $("#hasta").val();


        if (mFechaDesde===""){
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Seleccione primer rango!'
            });
        }else if(mFechaHasta==="") {
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Seleccione segundo rango!'
            });
        }else{
            $('#tblReportes').DataTable({
                "ajax": {
                    'type': 'POST',
                    'url': 'BuscarSolicitud',
                    'data': {
                        f1: mFechaDesde,
                        f2: mFechaHasta
                    }
                },
                async:'false',
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
                    { "data": "N" },
                    { "data": "CUENTA" },
                    { "data": "CLIENTE" },
                    { "data": "REMITIDO" },
                    { "data": "FUENTE" },
                    { "data": "APTO" }
                ],
                "fnInitComplete": function (dta) {
                    $("#tblReportes_filter").hide();
                }
            });


        }

    }
    function inicializarDatatable() {
        $('#tblReportes').DataTable({
            ajax: 'getResumen',
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
            "columnDefs": [
                {"className": "center", "targets": [ 0, 1,2,3,4,5 ]}

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
                { "data": "N" },
                { "data": "CUENTA" },
                { "data": "CLIENTE" },
                { "data": "REMITIDO" },
                { "data": "FUENTE" },
                { "data": "APTO" }
            ],
            "fnInitComplete": function (dta) {
                $("#tblReportes_filter").hide();
            }
        });

    }
</script>