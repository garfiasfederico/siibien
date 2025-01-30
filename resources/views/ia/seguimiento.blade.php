@extends('layouts.administrador')
@section('encabezado')
    ITAR / Seguimiento
@endsection
@section('styles')
    <style>
        .enc1 {
            padding: 5px !important;
            background-color: #c5c5c5;
            color: white;
        }

        .enc2 {
            padding: 5px !important;
            background-color: #7c2f42;
            color: white;
        }

        .resp {
            font-weight: bold;
        }

        .enc3 {
            background-color: #ececec;
            font-weight: bold;
        }

        input[type=text],
        select {
            height: 35px;
            color: black;
        }

        table tr td {
            padding: 5px;
            border: solid 2px white;
        }

        .invalid-feedback {
            width: 100%;
            background-color: rgb(252, 241, 241);
            color: gray;
            border-radius: 5px;
            text-align: center;
            padding: 10px;
        }

        textarea {
            color: black;
        }
    </style>
@endsection
@section('content')
    <div class="col-xl-12 col-lg-7">
        <input type="hidden" id="idPPA" value="{{ $infoPPA->id }}">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex align-items-center justify-content-between"
                style="background-color: #681b2e;">
                <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Seguimiento: PPA
                    {{ $infoPPA->id . ' ' . $infoPPA->nombre }}</h6>
                <div class="dropdown no-arrow">
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="indicadorContent">
                <div class="" style="width: 100%;text-align:right">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 75%;text-align:right"></td>
                            <td style="width:15%;text-align:right">
                                <select class="form-control" style="font-size:1.2em;" onchange="getSeguimiento()"
                                    id="anio">
                                    <option value="">Seleccione Ejercicio</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </td>
                            <td style="width:10%">
                                <button class="btn btn-primary"><i class="fas fa-sync"></i> Actualizar</button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="seguimientoContent">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalFuente" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel" data-backdrop="static" data-keyboard="false"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="accionModalLabel">Fuentes de financiamiento</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <div style="width: 100%;" id="fuenteFinanciamiento">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" onclick="Almacenar()" id="btnAlmacenarG">Almacenar</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function getSeguimiento() {
            if($("#anio").val()!=""){
                anio = $("#anio").val();
                idPPA = $("#idPPA").val();
                $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getseguimiento') }}",
                    data: {
                        idPPA: $("#idPPA").val(),
                        anio:anio
                    },
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#seguimientoContent").block({
                            message: '<h4>Procesando...</h4>',
                            css: {
                                border: '3px solid gray',
                                backgroundColor: 'black',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                width: "15%",
                                color: "white"
                            }
                        });
                    }
                }).done(function(response) {
                    $("#seguimientoContent").unblock();
                    $("#seguimientoContent").html(response);
                });
            }else{
                $("#seguimientoContent").html("");
            }
            
        }

        function toggle(icon, element) {
            if ($("#" + element).css("display") == "none") {
                $("#" + element).show("fast");
                $("#" + icon).removeClass("fa-chevron-right");
                $("#" + icon).addClass("fa-chevron-down");
            } else {
                $("#" + element).hide("fast");
                $("#" + icon).removeClass("fa-chevron-down");
                $("#" + icon).addClass("fa-chevron-right");
            }

        }

        function addPrograma(tipo){
            $.ajax({
                    type: 'POST',
                    url: "{{ route('ia.addprograma') }}",
                    data: {
                        ia_presupuesto_general_id: $("#ia_presupuesto_general_id").val(),
                        tipo:tipo,
                        _token:$("input[name='_token']").val()
                    },
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#programasContent").block({
                            message: '<h4>Procesando...</h4>',
                            css: {
                                border: '3px solid gray',
                                backgroundColor: 'black',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                width: "15%",
                                color: "white"
                            }
                        });
                    }
                }).done(function(response) {
                    setTimeout(function(){$("#programasContent").append(response);},500)                    
                    $("#programasContent").unblock();
                   
                });
        }

        function removePrograma(ia_presupuesto_tipog_id){
            Swal.fire({
                            icon: 'question',
                            title: 'Presupuesto General por año',
                            text: "¿Está seguro de querer eliminar este registro de Programa presupuestario?, tome en cuenta que toda la información reportada con respecto a este programa será eliminada permanentemente.",                                                                      
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Sí, Eliminar!',
                            showCancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                        type: 'POST',
                                        url: "{{ route('ia.removeprograma') }}",
                                        data: {ia_presupuesto_tipog_id : ia_presupuesto_tipog_id,_token:$("input[name='_token']").val()},
                                        dataType: 'json',
                                        beforeSend: function() {
                                            $("#programasContent").block({
                                                message: '<h4>Procesando...</h4>',
                                                css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                                            });
                                            //block(true);
                                        }
                                    }).done(function(response) {
                                        //block(false);
                                        $("#programasContent").unblock();
                                        if (response.result == "ok") {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Presupuesto General por año',
                                                text: response.message,
                                                confirmButtonColor: '#3085d6',
                                            }).then((result) => {$("#programa"+ia_presupuesto_tipog_id).hide("slow"); setTimeout(() => {
                                                $("#programa"+ia_presupuesto_tipog_id).remove();
                                            }, 500);});                        
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Presupuesto General por año',
                                                text: response.message,
                                                confirmButtonColor: '#3085d6',
                                            }).then((result) => {});
                                        }
                                    });
                            }                        
                        });
        }

        function fuenteFinanciamiento(){
            $("#modalFuente").modal("show");
        }

    </script>
@endsection
