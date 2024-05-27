@extends('layouts.administrador')
@section('encabezado')
    Redacción por acciones del Segundo Informe de Gobierno
@endsection
@section('content')
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
            style="background-color: #681b2e;">
            <h6 class="m-0 font-weight-bold text-light">Acciones Identificadas del tema
            </h6>

        </div>
        <!-- Card Body -->
        <div class="card-body" id="indicadorContent">
            <center>
                <h1>{{ auth()->user()->enlace->dependencia->dependenciaNombre . ' (' . $dependencia->dependenciaSiglas . ')' }}
                </h1>
                <h4>Acciones identificadas para ser reportadas</h4>
                <h4>Tema: {{ $tema->temaPEDClave . ' ' . $tema->temaPEDDescripcion }}</h4>
                <a href="{{ route('informe.redactar') }}"><button class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                        Volver al listado de Temas</button></a>
                <hr />
                <div style="width:100%;text-align:right;padding:10px;"><button type="button" class="btn btn-success"
                        onclick="showModalAccion()"><i class="fas fa-plus"></i> Nueva Acción</button></div>
                <table class="table" style="padding: 15px;">
                    <thead>
                        <tr style="padding: 15px;background-color:gray;color:white;">
                            <th>Id</th>
                            <th>Acción</th>
                            <th>Alineación a nivel Linea de acción</th>
                            <th>Alineación con anexo Estadístico</th>
                            <th>Redactar Párrafos</th>
                        </tr>
                    </thead>
                </table>
            </center>

        </div>
    </div>
    <div class="modal fade" id="accionModal" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="accionModalLabel">Registrar nueva Acción</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formTitular">
                        @csrf
                        <input type="hidden" name="dependencia" id="dependencia" value="{{ $dependencia->idDependencia }}">
                        <input type="hidden" name="tema" id="tema" value="{{ $tema->idTemaPED }}">
                        <h3> Tema: {{ $tema->temaPEDClave . ' ' . $tema->temaPEDDescripcion }}</h3>
                        <hr />
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nombre">Descripcion de la Acción a registrar:<span
                                        style="color: red">*</span></label>
                                <textarea class="form-control" id="nombre" name="nombre" placeholder="" value=""></textarea>
                                <div class="invalid-feedback"
                                    style="width: 100%;background-color:rgb(255, 102, 102);color:white;border-radius:5px;text-align:center;padding:10px;">
                                    Indique una descripción para la nueva acción.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="alineacion_la">Lineas de acción que atiende:</label>
                                <select name="lineas" id="lineas" class="form-control">
                                    <option value="">--Seleccione</option>
                                    @foreach ($lineas as $linea)
                                        <option value="{{ $linea->idLAPED }}">
                                            {{ $linea->laPEDClave . ' ' . $linea->laPEDDescripcion }}</option>
                                    @endforeach
                                </select>
                                <div style="text-align: right">
                                    <button class="btn btn-primary" type="button" onclick="addLinea()"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                                <div class="invalid-feedback">
                                    Indique las lineas de acción a las que atiende esta acción.
                                </div>
                                <div style="padding-top: 20px">
                                    <table style="width:100%" border="1">
                                        <thead>
                                            <tr style="background-color:gray;color:white">
                                                <th style="width: 5%;display:none">Id</th>
                                                <th style="width: 85%;padding:10px;">Linea</th>
                                                <th style="width: 15%;text-align:center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_lineas">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="alineacion_ae">Cuadros del Anexo Estadístico:</label>
                                <select name="cuadros" id="cuadros" class="form-control">
                                    <option value="">--Seleccione</option>
                                    @foreach ($lineas as $linea)
                                        <option value="{{ $linea->idLAPED }}">
                                            {{ $linea->laPEDClave . ' ' . $linea->laPEDDescripcion }}</option>
                                    @endforeach
                                </select>
                                <div style="text-align: right">
                                    <button class="btn btn-primary" type="button" onclick="addCuadro()"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                                <div style="padding-top: 20px">
                                    <table style="width:100%" border="1">
                                        <thead>
                                            <tr style="background-color:gray;color:white">
                                                <th style="width: 5%;display:none">Id</th>
                                                <th style="width: 85%;padding:10px;">Cuadro</th>
                                                <th style="width: 15%;text-align:center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_cuadros">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="button" onclick="saveAccion()">Almacenar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#collapse-informee").addClass("show");
            //$("#pparegistro").addClass("active");
            $("#informetemas").css('background-color', "rgb(217, 217, 217)");
        });

        function showModalAccion() {
            $("#accionModal").modal("show");
        }

        function addLinea() {
            linea = $("#lineas").val();
            text = $("#lineas option:selected").text();
            if (linea != "") {
                if ($("#linea" + linea).length == 0) {
                    row = '<tr id="linea' + linea + '" >' +
                        '<td class="linea_asociada" id="asociada" style="display:none;">' + linea + '</td>' +
                        '<td style="padding:10px;">' + text + '</td>' +
                        '<td style="text-align:center"><button type="button" class="btn btn-danger" onclick="quitLinea(' +
                        linea + ')"><i class="fas fa-trash"></i></button></td>' +
                        '</tr>'
                    $("#body_lineas").append(row);
                }
            }
        }

        function quitLinea(linea) {
            $("#linea" + linea).remove();
        }

        function saveAccion() {
            if (validaAccion()) {
                nombre = $("#nombre").val();
                lineas = "";
                dependencia = $("#dependencia").val();
                tema = $("#tema").val();
                cuadros = "";
                if ($(".linea_asociada").length > 0) {
                    $(".linea_asociada").each(function() {
                        lineas += $(this).html().trim() + "|";
                    });
                }
                $.ajax({
                    type: 'POST',
                    url: "{{ route('informe.saveaccion') }}",
                    data: {
                        dependencia: dependencia,
                        tema: tema,
                        nombre: nombre,
                        lineas: lineas,
                        cuadros: cuadros,
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        block(true)
                    },
                    success: function(response) {
                        if (response.result = "ok") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Acción registrada',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {
                                //window.location.replace("{{ route('informe.acciones') }}");
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ocurrió un error al intentar almacenar la Acción',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            })
                        }
                    }
                }).done(function(response) {
                    block(false);
                }).fail(function(data) {
                    block(false);
                })
            }

        }

        function validaAccion() {
            inputs = [
                "nombre",
            ];

            selects = [];


            valid = true;

            for (var x = 0; x < inputs.length; x++) {
                if ($("#" + inputs[x]).val().trim().length == 0) {
                    $("#" + inputs[x]).addClass("is-invalid");
                    valid = false;
                } else {
                    $("#" + inputs[x]).removeClass("is-invalid");
                }
            }

            for (var x = 0; x < selects.length; x++) {
                if ($("#" + selects[x]).val() == 0) {
                    $("#" + selects[x]).addClass("is-invalid");
                    valid = false;
                } else {
                    $("#" + selects[x]).removeClass("is-invalid");
                }
            }

            return valid;
        }
    </script>
@endsection
