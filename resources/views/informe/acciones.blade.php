@php
    use App\Models\LineaPED;
    use App\Models\AnexoEstadistico;
@endphp
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
                <table class="table table-bordered table-striped" style="padding: 15px;" id="tableAcciones">
                    <thead>
                        <tr style="padding: 15px;background-color:gray;color:white;text-align:center">
                            <th style="width: 5%">Id</th>
                            <th style="width: 35%">Acción</th>
                            <th style="width: 20%">Alineación a nivel Linea de acción</th>
                            <th style="width: 20%">Alineación con anexo Estadístico</th>
                            <th style="width: 20%">Redactar Párrafos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($acciones->count()>0)
                        @foreach ($acciones as $accion )
                            <tr>
                                <td style="vertical-align: middle;text-align:center">{{$accion->id}}</td>
                                <td style="vertical-align: middle">{{$accion->nombre}}</td>
                                <td>
                                    @php
                                        //Jalamos las lineas de accion con las que se alinea la accion
                                        $lineas_ = explode("|",$accion->alineacion_la);
                                        if(count($lineas_)>0){
                                            array_pop($lineas_);
                                            foreach ($lineas_ as  $lin) {
                                                $infoLinea = LineaPED::where("idLAPED",$lin)->first();
                                                if($infoLinea!=null){
                                                    echo "<p><b>".$infoLinea->laPEDClave."</b> ".$infoLinea->laPEDDescripcion."</p>";
                                                }
                                            }
                                        }
                                    @endphp
                                </td>
                                <td>
                                    @php
                                    //Jalamos los cuadros agregados
                                    $cuadros_ = explode("|",$accion->ae_cuadros);
                                    if(count($cuadros_)>0){
                                        array_pop($cuadros_);
                                        foreach ($cuadros_ as  $cuad) {
                                            $infoCuad = AnexoEstadistico::where("id",$cuad)->first();
                                            if($infoCuad!=null){
                                                echo "<p><b>".$infoCuad->numero."</b> ".$infoCuad->cuadro."</p>";
                                            }
                                        }
                                    }
                                @endphp
                                </td>
                                <td style="text-align: center;vertical-align:middle">

                                    <button class="btn btn-primary" title="Editar Acción" onclick="editarAccion({{$accion->id}})">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <a href="{{route('informe.redactaparrafos',["id"=>$accion->id])}}">
                                    <button class="btn btn-success" title="Redactar Párrafos">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
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
                    <form id="formAccion">
                        @csrf
                        <input type="hidden" name="accion_id" id="accion_id" value="">
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
                                <div style="text-align: right;padding:10px;">
                                    <button class="btn btn-primary" type="button" onclick="addLinea()"><i
                                            class="fas fa-plus"></i> Agregar Linea de Acción</button>
                                </div>
                                <div class="invalid-feedback">
                                    Indique las lineas de acción a las que atiende esta acción.
                                </div>
                                <div style="padding-top: 20px">
                                    <table style="width:100%" border="1" >
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
                                <label for="alineacion_ae">Relación con Cuadros del Anexo Estadístico:</label>
                                <select name="cuadros" id="cuadros" class="form-control">
                                    <option value="">--Seleccione</option>
                                    @foreach ($cuadros as $cuadro)
                                        <option value="{{ $cuadro->id }}">
                                            {{ $cuadro->numero . ' ' . $cuadro->cuadro }}</option>
                                    @endforeach
                                </select>
                                <div style="text-align: right;padding:10px;">
                                    <button class="btn btn-primary" type="button" onclick="addCuadro()"><i
                                            class="fas fa-plus"></i>Agregar Cuadro Estadístico</button>
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

            $("#tableAcciones").DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 20],
                order: [
                    [0, 'asc']
                ],
            })
        });

        function showModalAccion() {
            $("#accionModal").modal("show");
            $("#accion_id").val("");
            $("#body_lineas").html("");
            $("#body_cuadros").html("");
            $("#nombre").val("");
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

        function addCuadro(){
            cuadro = $("#cuadros").val();
            text = $("#cuadros option:selected").text();
            if (cuadro != "") {
                if ($("#cuadro" + cuadro).length == 0) {
                    row = '<tr id="cuadro' + cuadro + '" >' +
                        '<td class="cuadro_asociado" id="asociada_c" style="display:none;">' + cuadro + '</td>' +
                        '<td style="padding:10px;">' + text + '</td>' +
                        '<td style="text-align:center"><button type="button" class="btn btn-danger" onclick="quitCuadro(' +
                        cuadro + ')"><i class="fas fa-trash"></i></button></td>' +
                        '</tr>'
                    $("#body_cuadros").append(row);
                }
            }
        }
        function quitCuadro(cuadro) {
            $("#cuadro" + cuadro).remove();
        }

        function saveAccion() {
            if (validaAccion()) {
                id=$("#accion_id").val();
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
                if ($(".cuadro_asociado").length > 0) {
                    $(".cuadro_asociado").each(function() {
                        cuadros += $(this).html().trim() + "|";
                    });
                }
                $.ajax({
                    type: 'POST',
                    url: "{{ route('informe.saveaccion') }}",
                    data: {
                        id:id,
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
                        if (response.result == "ok") {
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

        function editarAccion(accion){

            //obtenemos los datos de la accion en cuestión
            $.ajax({
                    type: 'GET',
                    url: "{{ route('informe.getinfoaccion') }}",
                    data: {
                        id:accion
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        block(true)
                    },
                    success: function(response) {
                        if (response.result = "ok") {
                            $("#accion_id").val(accion);
                            $("#accionModal").modal("show");
                            $("#nombre").val(response.info.nombre);
                            $("#body_lineas").html(response.lineas);
                            $("#body_cuadros").html(response.cuadros);
                        } else {

                        }
                    }
                }).done(function(response) {
                    block(false);
                }).fail(function(data) {
                    block(false);
                })
        }
    </script>
@endsection
