@php
    use App\Models\LineaPED;
    use App\Models\AnexoEstadistico;
    use App\Models\InformeParrafo;
@endphp
@extends('layouts.administrador')
@section('encabezado')
    Redacción por PPA del Tercer Informe de Gobierno
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
                <div style="text-align: left; padding:10px;">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalInformeHistorico">
                        <i class="fas fa-history"></i> Histórico Informes
                    </button>
                </div>
                    @if(!empty($tema->tipo) && strtoupper(trim($tema->tipo)) === 'CT')
                        <div class="text-left mb-3">
                            <button class="btn btn-primary" onclick="decidirModalInforme()">
                             <i class="fas fa-edit"></i>  Tema: {{ $tema->temaPEDClave}} Introducción y Conclusión
                            </button>
                        </div>
                    @endif

                <div style="width:100%;text-align:right;padding:10px;">
                    @if(false)
                    <button type="button" class="btn btn-success"
                        onclick="checkCountAcciones()"><i class="fas fa-plus"></i> Nueva Acción</button>
                    @endif
                        @if($acciones->count()>0)
                            <a target="_blank" href="{{route('informe.descargaacciones',["tema"=>$tema->idTemaPED])}}"><button type="button" class="btn btn-primary" onclick="descargaListado()"><i class="fas fa-download"></i> Descargar listado</button></a>
                        @endif
                </div>
                <table class="table table-bordered table-striped" style="padding: 15px;" id="tableAcciones">
                    <thead>
                        <tr style="padding: 15px;background-color:gray;color:white;text-align:center">
                            <th style="width: 5%">Id</th>
                            <th style="width: 10%">Se Reporta en Informe</th>
                            <th style="width: 20%">Nombre PPA</th>
                            <th style="width: 10"> Info.PPA</th>
                            <th style="width: 15%">Alineación a nivel Linea de acción</th>
                            <th style="width: 15%">Alineación con anexo Estadístico</th>
                            <th style="width: 5%">Parrafos redactados</th>
                            <th style="width: 20%">Acciones</th> 
                            
                        </tr>
                    </thead>
                    <tbody>
                        @if($acciones->count()>0)
                        @foreach ($acciones as $accion )
                            <tr id="rowaccion{{$accion->id}}" style="background-color: {{$accion->reporta4to==0?'#FFF0EB':''}}">
                                <td style="vertical-align: middle;text-align:center">{{$accion->id}}</td>
                                <td style="vertical-align: middle;text-align:center">
                                    @if(false)
                                        <input
                                        type="checkbox"
                                        data-toggle="toggle"
                                        data-on="Si se reportará"
                                        data-off="No se reportará"
                                        data-onstyle="success"
                                        data-offstyle="secondary"
                                        data-width="180"
                                        data-height="40"
                                        {{$accion->reporta4to==1?"checked":""}}
                                        onchange="sereportaInforme({{$accion->id}},{{$accion->reporta4to==1?0:1}})"
                                        id="reportainforme{{$accion->id}}"/>
                                        <div style="margin: 15px;display:{{$accion->reporta4to==1?"none":"block"}}" id="reportejus{{$accion->id}}">
                                            <select type="select" class="form-control" id="motivonoreporta{{$accion->id}}" onchange="sereportaInforme({{$accion->id}},0)">
                                                <option value="no_4to_trim" {{$accion->justificacion4to=="no_4to_trim"?"selected":""}}>No se tiene información para el 4to Trimestre de 2025</option>
                                                <option value="otro_ppa" {{$accion->justificacion4to=="otro_ppa"?"selected":""}}>La información de este PPA se reportará en otro PPA</option>
                                            </select>
                                        </div>
                                    @else
                                        <div class="alert {{$accion->reporta4to==1?"alert-success":"alert-secondary"}}" >
                                            {{$accion->reporta4to==1?" Si se reporta":"No se reporta"}}                                            
                                            @if($accion->reporta4to==0)
                                                <i class="fas fa-info-circle" onmouseover="$('#infojus{{$accion->id}}').show()" onmouseout="$('#infojus{{$accion->id}}').hide()"></i>
                                                <div class="alert alert-info" id="infojus{{$accion->id}}" style="display: none;position:absolute;z-index:999">
                                                    @if($accion->justificacion4to=="no_4to_trim")
                                                        No se tiene información para el 4to Trimestre de 2025
                                                    @else
                                                        La información de este PPA se reportará en otro PPA
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td style="vertical-align: middle">{{$accion->nombre}}</td>
                                <!-- Nuevo boton de datos Generales-->
                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="text-center">
                                     <button type="button" class="btn btn-sm btn-info" onclick="verDatosGenerales({{ $accion->id }})">
                                         <i class="fas fa-info-circle"></i> 
                                    </button>
                                    </div>
                                </td>
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
                                    @php
                                        //contabilizamos los parrafos capturados
                                        $parrafos_capturados = InformeParrafo::where("informe_acciones_id",$accion->id)->get();
                                    @endphp
                                    <span style="color: gray;font-weight:bold">{{$parrafos_capturados->count()}}</span>
                                </td>

                                <td style="text-align: center;vertical-align:middle">

                                    <button class="btn btn-primary" onclick="showAccionModal({{ $accion->id }})" id="infoppa{{$accion->id}}"><i
                                        class="fas fa-info"></i></button>
@if(true)
                                    <span id="contentbtnedit{{$accion->id}}">
                                        <button class="btn btn-primary" title="Editar Acción del tema" data-toggle="tooltip" id="editppa{{$accion->id}}"
                                        data-placement="top" onclick="editarAccion({{$accion->id}})" style="{{$accion->reporta4to?"":"display:none"}}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </span>

                                    @if(count($lineas_)>0)
                                            <a href="{{route('informe.redactaparrafos',["id"=>$accion->id])}}">
                                            <button class="btn btn-success" title="Redactar Párrafos" data-toggle="tooltip"
                                            data-placement="top" id="redactarppa{{$accion->id}}" style="{{$accion->reporta4to?"":"display:none"}}">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            </a>
                                    @else
                                            <a>
                                                <button class="btn btn-secondary" title="Primero debe indicar la alineación al PED" data-toggle="tooltip"
                                                data-placement="top">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                </a>
                                    @endif


                                        <button @if($accion->creacion=="m") class="btn btn-danger" onclick="deleteAccion({{$accion->id}})" @else class="btn btn-secondary" disabled @endif title="Eliminar Acción" data-toggle="tooltip"
                                            data-placement="top" id="deleteppa{{$accion->id}}">
                                            <i class="fas fa-trash"></i>
                                        </button>
@endif
                                </td>
                                
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </center>
        </div>
    </div>
    <div class="modal fade" id="accionNModal" tabindex="-1" role="dialog" aria-labelledby="accionNModalLabel"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="accionNModalLabel">Registrar nueva Acción</h5>
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
                                <textarea class="form-control" id="nombre" name="nombre" placeholder="" value="" readonly></textarea>
                                <div class="invalid-feedback"
                                    style="width: 100%;background-color:rgb(255, 102, 102);color:white;border-radius:5px;text-align:center;padding:10px;">
                                    Indique una descripción para la nueva acción.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="alineacion_la">Lineas de acción que atiende:</label>
                                <select name="lineas" id="lineas" class="form-control" disabled>
                                    <option value="">--Seleccione</option>
                                    @foreach ($lineas as $linea)
                                        <option value="{{ $linea->idLAPED }}">
                                            {{ $linea->laPEDClave . ' ' . $linea->laPEDDescripcion }}</option>
                                    @endforeach
                                </select>
                                <div style="text-align: right;padding:10px;">
                                    <button class="btn btn-primary" type="button" onclick="@if(false) addLinea() @endif" disabled><i
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
    <div class="modal fade" id="accionModal" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel"
    aria-hidden="true" style="color: black!important">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #681b2e; color:white">
                <h5 class="modal-title" id="accionModalLabel">Párrafos redactados</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="body-parrafos">

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>
    @include('informe.modalInformeHistorico')
    @include('informe.modalDatosGenerales')
    @include('informe.modalRedactarInforme')

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
            $("#accionNModal").modal("show");
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
                            $("#accionNModal").modal("show");
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

        function checkCountAcciones(){
            dependencia = $("#dependencia").val();
            tema = $("#tema").val();
            //Realizamos la consulta de acciones registradas de manera manual para restringir la creacion de más acciones
            $.ajax({
                    type: 'POST',
                    url: "{{ route('informe.checkacciones') }}",
                    data: {
                        dependencia: dependencia,
                        tema: tema,
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        block(true)
                    },
                    success: function(response) {
                        if (response.result == "ok") {
                           showModalAccion();
                        } else {
                            Swal.fire({
                                icon: 'info',
                                title: 'Registro de Acciones',
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

        function deleteAccion(idAccion){
            Swal.fire({
                title: '¿Está Seguro?',
                text: "Esta acción será eliminada de manera permanente así como los párrafos redactados y complementos cargados!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('informe.deleteaccion') }}",
                        data: {
                            idAccion: idAccion,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.result == "ok") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Acciones de Gobierno',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {location.reload();});
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ocurrió un error al intentar eliminar la acción correspondiente!',
                                    text: '',
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
            })
        }

        function showAccionModal(idAccion) {

            $.ajax({
                type: 'GET',
                url: "{{ route('informe.accion.getparrafos') }}",
                data: {
                    idAccion: idAccion,
                },
                beforeSend: function() {
                    block(true)
                },
                success: function(response) {
                    $("#body-parrafos").html(response);
                }
            }).done(function(response) {
                block(false);
            }).fail(function(data) {
                block(false);
            })

            $("#accionModal").modal("show");
        }
        //Evento para el Boton  de los parrafos  en el botón informe
            $('#modalInforme2024').on('shown.bs.modal', function () {
            // Cierra todos los collapse al abrir el modal
            $(this).find('.collapse').each(function () {
                $(this).collapse('hide'); // fuerza oculto
            });

            $('.collapse').off('shown.bs.collapse hidden.bs.collapse');

            $('.collapse').on('shown.bs.collapse', function () {
                const targetId = $(this).attr('id');
                const $button = $(`button[data-target="#${targetId}"]`);
                $button.text($button.text().replace('Ver', 'Ocultar'));
            });

            $('.collapse').on('hidden.bs.collapse', function () {
                const targetId = $(this).attr('id');
                const $button = $(`button[data-target="#${targetId}"]`);
                $button.text($button.text().replace('Ocultar', 'Ver'));
            });
        });
        //# mODAL DE Informacion Generales
         function verDatosGenerales(idAccion) {
            $('#modalDatosGenerales').modal('show');
            $('#tabsModal a[href="#datos"]').tab('show'); // ← Siempre abre en "Datos Generales"

            $.ajax({
                url: "{{ route('informe.accion.datosgenerales') }}",
                method: 'GET',
                data: {
                    idAccion
                },
                success: function(response) {
                    if (response.result === 'ok' && response.accion) {
                        $('#dg-id').text(response.accion.id || '-');
                        $('#dg-nombre').text(response.accion.nombre || '-');
                        $('#dg-nombreppa').text(response.accion.nombre || '-');
                        $('#dg-objetivoaccion').text(response.accion.objetivo || '-');
                        $('#dg-descripcion').text(response.accion.descripcion || '-');
                        $('#dg-bienes').html(response.accion.bienes || '-');
                        $('#dg-eje').html(response.accion.eje || '-');
                        $('#dg-tema').html(response.accion.tema || '-');
                        $('#dg-objetivo_ped').html(response.accion.objetivo_ped || '-');
                        $('#dg-estrategias').html(response.accion.estrategias || '-');
                        $('#dg-lineas').html(response.accion.lineas || '-');
                        $('#dg-sector').html(response.accion.sector || '-');
                        $('#dg-obj-sector').html(response.accion.obj_sector || '-');
                        $('#dg-estrat-sector').html(response.accion.estrat_sector || '-');

                        // Renderizar tabla de presupuesto
                        let htmlPresupuesto = '';
                        const formatoMoneda = new Intl.NumberFormat('es-MX', {
                            style: 'currency',
                            currency: 'MXN',
                            minimumFractionDigits: 2
                        });
                        const formatoNumero = new Intl.NumberFormat('es-MX', {
                        minimumFractionDigits: 0
                        });

                        presupuestobefore2026 = 1;
                        presupuestoafter2026 = 1;


                        if (Array.isArray(response.accion.presupuesto) && response.accion.presupuesto.length >
                            0) {
                            response.accion.presupuesto.forEach(item => {
                                const e1 = parseFloat(item.e1) || 0;
                                const e2 = parseFloat(item.e2) || 0;
                                const e3 = parseFloat(item.e3) || 0;
                                const e4 = parseFloat(item.e4) || 0;

                                const valores = [e1, e2, e3, e4];
                                const suma = valores.reduce((acc, val) => acc + val, 0);
                                const sumaTexto = valores.map(v => `(${formatoMoneda.format(v)})`).join(' + ');
                                const sumaTotal = `${formatoMoneda.format(suma)}`;

                                htmlPresupuesto += `
           <tr>
                <td>${item.bien}</td>
                <td>${item.anio}</td>
                <td>${item.tipo === 'o' || item.tipo === 'O' ? 'Operativo' : item.tipo === 'i' || item.tipo === 'I' ? 'Inversión' : '-'}</td>
                <td>${item.descripcionPrograma || '-'}</td>
                <td style="text-align: right;">${formatoMoneda.format(e1)}</td>
                <td style="text-align: right;">${formatoMoneda.format(e2)}</td>
                <td style="text-align: right;">${formatoMoneda.format(e3)}</td>
                <td style="text-align: right;">${formatoMoneda.format(e4)}</td>
                <td style="text-align: right;">${formatoMoneda.format(suma)}</td>
            </tr>`;
                            });
                        } else {
                            //htmlPresupuesto = `<tr><td colspan="5" class="text-center">Sin datos de presupuesto</td></tr>`;
                            presupuestobefore2026 = 0;
                        }

                        if (Array.isArray(response.accion.presupuestodes2025) && response.accion.presupuestodes2025.length >
                            0) {
                            response.accion.presupuestodes2025.forEach(item => {
                                const e1 = parseFloat(item.t1) || 0;
                                const e2 = parseFloat(item.t2) || 0;
                                const e3 = parseFloat(item.t3) || 0;
                                const e4 = parseFloat(item.t4) || 0;

                                const valores = [e1, e2, e3, e4];
                                const suma = valores.reduce((acc, val) => acc + val, 0);
                                const sumaTexto = valores.map(v => `(${formatoMoneda.format(v)})`).join(' + ');
                                const sumaTotal = `${formatoMoneda.format(suma)}`;

                                htmlPresupuesto += `
           <tr>
                <td>${item.bien}</td>
                <td>${item.anio}</td>
                <td>${item.tipo_gasto === 'operativo' || item.tipo_gasto === 'OPERATIVO' ? 'Operativo' : item.tipo_gasto === 'inversion' || item.tipo_gasto === 'INVERSION' ? 'Inversión' : '-'}</td>
                <td>${item.descripcionPrograma || '-'}</td>
                <td style="text-align: right;">${formatoMoneda.format(e1)}</td>
                <td style="text-align: right;">${formatoMoneda.format(e2)}</td>
                <td style="text-align: right;">${formatoMoneda.format(e3)}</td>
                <td style="text-align: right;">${formatoMoneda.format(e4)}</td>
                <td style="text-align: right;">${formatoMoneda.format(suma)}</td>
            </tr>`;
                            });
                        } else {
                            //htmlPresupuesto = `<tr><td colspan="5" class="text-center">Sin datos de presupuesto</td></tr>`;
                            presupuestoafter2026 = 0;
                        }

                        if(presupuestoafter2026 == 0 && presupuestobefore2026 == 0){
                            htmlPresupuesto = `<tr><td colspan="5" class="text-center">Sin datos de presupuesto</td></tr>`;
                        }



                        $('#dg-presupuesto-body').html(htmlPresupuesto);
                        //Se redneriza la  tabla de entregas de Bienes o servicios
                        // Renderizar tabla de entregas
                    let htmlEntregas = '';
                    if (Array.isArray(response.accion.entregas) && response.accion.entregas.length > 0) {
                     response.accion.entregas.forEach(item => {
                        const r1 = parseFloat(item.r1) || 0;
                        const r2 = parseFloat(item.r2) || 0;
                        const r3 = parseFloat(item.r3) || 0;
                        const r4 = parseFloat(item.r4) || 0;
                        const total = r1 + r2 + r3 + r4;

                            htmlEntregas += `
                                <tr>
                                <td>${item.bien || '-'}</td>
                                <td style="text-align: center;">${item.anio || '-'}</td>
                                <td style="text-align: right;">${formatoNumero.format(r1)}</td>
                                <td style="text-align: right;">${formatoNumero.format(r2)}</td>
                                <td style="text-align: right;">${formatoNumero.format(r3)}</td>
                                <td style="text-align: right;">${formatoNumero.format(r4)}</td>
                                <td style="text-align: right;">${formatoNumero.format(total)}</td>


                                </tr>`;
                        });
                    } else {
                        htmlEntregas = `<tr><td colspan="7" class="text-center">Sin datos de entregas</td></tr>`;
                    }
                    $('#dg-entregasbs-body').html(htmlEntregas);

                    } else {
                        limpiarCampos('Sin datos', 'No se encontró la acción');
                    }
                },
                error: function(xhr) {
                    console.error("Error AJAX:", xhr.responseText);
                    limpiarCampos('Error', 'No se pudo cargar');
                }
            });
        }

        function limpiarCampos(idTexto = '-', nombreTexto = '-') {
            $('#dg-id').text(idTexto);
            $('#dg-nombre').text(nombreTexto);
            $('#dg-nombreppa').text('-');
            $('#dg-descripcion').text('-');
            $('#dg-objetivoaccion').text('-');
            $('#dg-bienes').html('-');
            $('#dg-eje').html('-');
            $('#dg-tema').html('-');
            $('#dg-objetivo-ped').html('-');
            $('#dg-estrategias').html('-');
            $('#dg-lineas').html('-');
            $('#dg-sector').html('-');
            $('#dg-obj-sector').html('-');
            $('#dg-estrat-sector').html('-');
            $('#dg-presupuesto-body').html('');
            $('#dg-entregasbs-body').html('');

        }
        //fUNCIOENS PARA REDDACTAR INTRODUCCION Y CONCLUSION PARA EL INFORME
        //Se mofica para 2 parrafos
    function agregarParrafoConTexto(seccion, texto = '', idInformeCT = null) {
        const contenedor = seccion === 'introduccion' ? '#contenedorIntroduccion' : '#contenedorConclusion';
        const numActuales = $(`${contenedor} .card`).length;

        if (numActuales >= 3) {
            Swal.fire('Límite alcanzado', 'Solo puedes agregar hasta 3 párrafos por sección.', 'info');
            return;
        }

        const cardId = `${seccion}-parrafo-${Date.now()}`;

        const eliminarBtn = `
<button type="button" class="btn btn-sm btn-danger position-absolute" style="top:10px; right:10px;"
    onclick="eliminarParrafo(${idInformeCT ?? 'null'}, '${cardId}', '${seccion}')">
    <i class="fas fa-trash"></i>
</button>`;

        const tarjeta = `
<div class="card mb-3 shadow-sm" id="${cardId}">
    <div class="card-body position-relative">
        <textarea class="form-control border-0" rows="3" name="${seccion}[]" data-idinformect="${idInformeCT ?? ''}"
            placeholder="Escriba el párrafo aquí..." maxlength="800">${texto}</textarea>
        ${eliminarBtn}
    </div>
</div>
`;

        $(contenedor).append(tarjeta);

        // Ocultar mensaje de "no hay párrafos"
        $(`#mensaje${seccion.charAt(0).toUpperCase() + seccion.slice(1)}Vacia`).hide();
    }


    // Funcion para abrir Modal de redacción de informe
    $('#modalRedactarInforme').on('show.bs.modal', function () {
        const idTemaPED = document.getElementById('idTemaPED').value;
        const anio = document.getElementById('anioInforme').value;


        $('#loaderOverlay').show();
        $('#contenedorIntroduccion').hide().html('');
        $('#contenedorConclusion').hide().html('');
        $('#mensajeIntroduccionVacia').hide();
        $('#mensajeConclusionVacia').hide();

        fetch('/informes/get-informe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({ idTemaPED,anio })
        })
            .then(res => res.json())
            .then(data => {
                if (data.introduccion && data.introduccion.length > 0) {
                    data.introduccion.forEach(p => {
                        agregarParrafoConTexto('introduccion', p.parrafo, p.idInformeCT);
                    });
                } else {
                    $('#mensajeIntroduccionVacia').show();
                }

                if (data.conclusion && data.conclusion.length > 0) {
                    data.conclusion.forEach(p => {
                        agregarParrafoConTexto('conclusion', p.parrafo, p.idInformeCT);
                    });
                } else {
                    $('#mensajeConclusionVacia').show();
                }

                $('#loaderOverlay').hide();
                $('#contenedorIntroduccion').show();
                $('#contenedorConclusion').show();
            })
            .catch(() => {
                $('#loaderOverlay').hide();
                Swal.fire('Error', 'No se pudo cargar el contenido.', 'error');
            });
    });

    function guardarInforme() {
        const idTemaPED = document.getElementById('idTemaPED').value;
        const anio = document.getElementById('anioInforme').value;

        const obtenerParrafos = (seccion) => {
            return Array.from(document.querySelectorAll(`#contenedor${seccion.charAt(0).toUpperCase() + seccion.slice(1)}
textarea`))
                .map(textarea => ({
                    idInformeCT: textarea.dataset.idinformect || null,
                    parrafo: textarea.value.trim()
                }))
                .filter(p => p.parrafo !== '');
        };

        const introduccion = obtenerParrafos('introduccion');
        const conclusion = obtenerParrafos('conclusion');

        if (introduccion.length === 0 && conclusion.length === 0) {
            Swal.fire('Sin contenido', 'Debe agregar al menos un párrafo.', 'warning');
            return;
        }

        fetch('/informes/guardar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({
                idTemaPED,
                introduccion,
                conclusion,
                anio
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Éxito', data.message || 'Informe guardado con éxito.', 'success');
                    $('#modalRedactarInforme').modal('hide');
                } else {
                    Swal.fire('Error', data.message || 'No se pudo guardar el informe.', 'error');
                }
            })
            .catch(error => {
                console.error('Error al guardar:', error);
                Swal.fire('Error de red', 'No se pudo conectar al servidor.', 'error');
            });
    }


    function eliminarParrafo(idInformeCT, cardId, seccion = null) {
        Swal.fire({
            title: '¿Eliminar párrafo?',
            text: idInformeCT
                ? 'Esta acción no se puede deshacer. El párrafo ya fue guardado.'
                : 'Este párrafo aún no ha sido guardado. ¿Deseas eliminarlo?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                if (idInformeCT) {
                    // Backend delete
                    fetch('/informes/eliminar-parrafo', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify({ id: idInformeCT })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                $(`#${cardId}`).remove();
                                Swal.fire('Eliminado', data.message, 'success');
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'No se pudo eliminar el párrafo.', 'error');
                        });
                } else {
                    // Solo DOM
                    $(`#${cardId}`).remove();

                    // Mostrar mensaje si ya no queda ninguno
                    if (seccion) {
                        const contenedor = seccion === 'introduccion' ? '#contenedorIntroduccion' : '#contenedorConclusion';
                        const mensaje = `#mensaje${seccion.charAt(0).toUpperCase() + seccion.slice(1)}Vacia`;
                        if ($(contenedor + ' .card').length === 0) {
                            $(mensaje).show();
                        }
                    }
                }
            }
        });
    }
    function decidirModalInforme() {
        const idTemaPED = document.getElementById('idTemaPED').value;
        const anio = document.getElementById('anioInforme').value;

        console.log(' idTemaPED:', idTemaPED);

        fetch('/informes/get-informe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({ idTemaPED, anio })
        })
            .then(res => {
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.json();
            })
            .then(data => {
                console.log(' Respuesta del backend:', data);

                const tieneContenido = (Array.isArray(data.introduccion) && data.introduccion.length > 0)
                    || (Array.isArray(data.conclusion) && data.conclusion.length > 0);

                if (tieneContenido) {
                    console.log(' Tiene contenido → abrir visualización');
                    abrirModalVisualizacion();
                } else {
                    console.log(' No hay contenido → abrir redacción');
                    $('#modalRedactarInforme').modal('show');
                }
            })
            .catch(err => {
                console.error(' Error al verificar el informe:', err);
                Swal.fire('Error', 'No se pudo verificar el contenido del informe.', 'error');
            });
    }
    function abrirModalVisualizacion() {
        const idTemaPED = document.getElementById('idTemaPED').value;
        const anio = document.getElementById('anioInforme').value;


        $('#verIntroduccion').html('<em>Cargando...</em>');
        $('#verConclusion').html('<em>Cargando...</em>');
        $('#modalVerInforme').modal('show');

        fetch('/informes/get-informe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({ idTemaPED, anio })
        })
            .then(res => res.json())
            .then(data => {
                let htmlIntro = '';
                (data.introduccion || []).forEach(p => {
                    htmlIntro += `<p>${p.parrafo}</p>`;
                });
                $('#verIntroduccion').html(htmlIntro || '<em>No hay contenido.</em>');

                let htmlConcl = '';
                (data.conclusion || []).forEach(p => {
                    htmlConcl += `<p>${p.parrafo}</p>`;
                });
                $('#verConclusion').html(htmlConcl || '<em>No hay contenido.</em>');
            })
            .catch(() => {
                $('#verIntroduccion, #verConclusion').html('<em>Error al cargar el contenido.</em>');
            });
    }
    function abrirModalEdicion() {
        // Cierra el modal de visualización
        $('#modalVerInforme').modal('hide');

        // Cuando el modal se haya cerrado completamente...
        $('#modalVerInforme').on('hidden.bs.modal', function () {
            // Mostrar el modal de redacción
            $('#modalRedactarInforme').modal('show');

            // Quitar el evento para evitar múltiples registros en futuros clics
            $(this).off('hidden.bs.modal');
        });
    }

    function sereportaInforme(acciones_id,reporta,element){
        if(reporta==0){
            motivonoreporta = $("#motivonoreporta"+acciones_id).val();
        }else{
            motivonoreporta="";
        }
        
        $.ajax({
                    type: 'POST',
                    url: "{{ route('informe.changereporte') }}",
                    data: {
                        acciones_id:acciones_id,
                        reporta:reporta,
                        _token: $("input[name='_token']").val(),
                        motivonoreporta:motivonoreporta
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        block(true)
                    },
                    success: function(response) {
                        if (response.result == "ok") {
                            if(reporta==1){
                                $("#rowaccion"+acciones_id).css("background-color","white");                                
                                $("#reportainforme"+acciones_id).attr("onchange","sereportaInforme("+acciones_id+","+0+")")
                                $("#reportejus"+acciones_id).hide();
                                deshabilitaBotones(acciones_id,true)
                            }else{ 
                                $("#rowaccion"+acciones_id).css("background-color","#FFF0EB");
                                $("#reportainforme"+acciones_id).attr("onchange","sereportaInforme("+acciones_id+","+1+")")
                                $("#reportejus"+acciones_id).show();
                                deshabilitaBotones(acciones_id,false)
                            }                           
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ocurrió un error al intentar cambiar el Estatus de reporte de este PPA',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            })
                            if(reporta==1){                                
                                $("#reportainforme"+acciones_id).attr("onchange","sereportaInforme("+acciones_id+","+1+")")
                                $("#reportejus"+acciones_id).show();
                                deshabilitaBotones(acciones_id,false)
                            }else{                                 
                                $("#reportainforme"+acciones_id).attr("onchange","sereportaInforme("+acciones_id+","+0+")")
                                $("#reportejus"+acciones_id).hide();
                                deshabilitaBotones(acciones_id,true)
                            }                           
                        }
                    }
                }).done(function(response) {
                    block(false);
                }).fail(function(data) {
                    block(false);
                })
    }

    function deshabilitaBotones(ppa,habilitar){
        if(habilitar){
            $("#editppa"+ppa).prop("disabled",false)            
            $("#redactarppa"+ppa).show();
            $("#editppa"+ppa).show();

        }else{
            $("#editppa"+ppa).prop("disabled",true)            
            $("#redactarppa"+ppa).hide();
            $("#editppa"+ppa).hide();
        }            
    }
    </script>
@endsection
