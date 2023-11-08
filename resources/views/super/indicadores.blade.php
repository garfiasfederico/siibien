@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Indicador / listar</h1>
    <!--<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm disabled"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generar Listado de Indicadores</a>-->
@endsection

@section('content')
    <div class="row">
        @csrf
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Indicadores Registrados</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Acciones:</div>
                            <a class="dropdown-item" href="{{ route('indicador') }}" style="cursor: pointer"><i
                                    class="fas fa-plus" style="color:green;"></i> Nuevo Indicador</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="indicadorContent" style="overflow: scroll">
                    @if (count($indicadores) > 0)
                        <table class="table table-bordered" id="dataTableIndicadores" width="150%" cellspacing="0"
                            style="color: black">
                            <thead style="background-color: #919090;color:white;">
                                <tr>
                                    <th>Id</th>
                                    <th style="width: 350px;">Indicador</th>
                                    <th>Estatus</th>
                                    <th>Responsable</th>
                                    <th>Objetivo</th>
                                    <th>Tipo</th>
                                    <th>Dimension</th>
                                    <th>Método de Cálculo</th>
                                    <th>Fórmula</th>
                                    <th>Unidad de Medida</th>
                                    <th>Interpretaciôn</th>
                                    <th>Frecuencia</th>
                                    <th>Tipo de Periodo</th>
                                    <th>Sentido</th>
                                    <th>Desagregación</th>
                                    <th>Año Línea Base</th>
                                    <th>Observaciones</th>
                                    <th>Responsable puede Editar</th>
                                    <th>Opciones</th>
                                    <th>Imprimir ficha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($indicadores as $indicador)
                                    <tr>
                                        <td>{{ $indicador->idIndicador }}</td>
                                        <td style="width:350px">{{ $indicador->indicadorNombre }}</td>
                                        <td>{{ $indicador->indicadorEstatus }}</td>
                                        <td class="text-center"><button
                                                onclick="responsableModal({{ $indicador->idIndicador . ',' . $indicador->idDependencia }})"
                                                class="btn btn-primary"
                                                id="btnResponsable{{ $indicador->idIndicador }}">{{ $indicador->dependenciaSiglas }}</button>
                                        </td>
                                        <td>{{ $indicador->indicadorObjetivo }}</td>
                                        <td>{{ $indicador->indicadorTipo }}</td>
                                        <td>{{ $indicador->indicadorDimension }}</td>
                                        <td>{{ $indicador->indicadorMetodo }}</td>
                                        <td>{{ $indicador->indicadorFormula }}</td>
                                        <td>{{ $indicador->indicadorUM }}</td>
                                        <td>{{ $indicador->indicadorInterpretacion }}</td>
                                        <td>{{ $indicador->indicadorFrecuencia }}</td>
                                        <td>{{ $indicador->indicadorTipoPeriodo }}</td>
                                        <td>{{ $indicador->indicadorSentido }}</td>
                                        <td>{{ $indicador->indicadorDesagregacion }}</td>
                                        <td>{{ $indicador->indicadorAnioLB }}</td>
                                        <td>{{ $indicador->observaciones }}</td>
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="editar{{$indicador->idIndicador}}" onclick="updateEditar({{$indicador->idIndicador}})" @if($indicador->editar) " checked " @endif>                                                
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if (Auth::user()->hasRole('consulta'))
                                                <button class="btn btn-sm btn-primary"
                                                    onclick="detallesIndicador({{ $indicador->idIndicador }})"><i
                                                        class="fas fa-info"></i></button>
                                            @else
                                                <button class="btn btn-sm btn-primary"
                                                    onclick="detallesIndicador({{ $indicador->idIndicador }})"><i
                                                        class="fas fa-info"></i></button>
                                                <!--<a target="_blank" href="{{ route('indicador.download', ['id' => $indicador->idIndicador]) }}"><button
                                                                class="btn btn-sm btn-success"><i
                                                                    class="fas fa-download"></i></button></a>-->
                                                <a
                                                    href="{{ route('admin.indicador.edit', ['id' => $indicador->idIndicador]) }}"><button
                                                        class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button></a>
                                                <!--<button class="btn btn-sm btn-danger"
                                                            onclick="deleteIndicador({{ $indicador->idIndicador . ",'" . $indicador->indicadorNombre }}')"><i
                                                                class="fas fa-trash"></i></button>-->
                                            @endif
                                        </td>
                                        <td>
                                            <a target="_blank"
                                                href="{{ route('indicador.download', ['id' => $indicador->idIndicador]) }}"><button
                                                    class="btn btn-sm btn-success"><i
                                                        class="fas fa-download"></i></button></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <h3>
                                No existen Indicadores Registrados!
                            </h3>
                            <a href="{{ route('indicador') }}">
                                <button class="btn btn-success">

                                    Agregar Indicador

                                </button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="responsableModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="exampleModalLabel">Asignación de responsable</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="margin-left:15px!important;margin-right:15px">
                    @csrf
                    <h3> Indicador: </h3>
                    <hr />
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="responsable">Seleccine Nuevo Responsable:<span style="color: red">*</span></label>
                            <input type="hidden" id="idIndicador">
                            <select name="responsable" id="responsable" class="form-control">
                                @foreach ($dependencias as $dependencia)
                                    <option value="{{ $dependencia->idDependencia }}">
                                        {{ $dependencia->dependenciaNombre . ' (' . $dependencia->dependenciaSiglas . ')' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="button" onclick="changeResponsable()"
                        id="btnAceptar">Aceptar</button>

                </div>
            </div>
        </div>
    </div>
    <style>
        table tr:hover {
            background-color: rgb(242, 242, 242);
        }

        .odd {
            background-color: #f3f3f3 !important;
        }
    </style>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#dataTableIndicadores").DataTable({
                pageLength: 10,
                lengthMenu: [10, 50, 100],
                order: [
                    [0, 'asc']
                ],
            })
            //$("#collapseTwo").addClass("show");
            $("#menuAdminIndicadores").addClass("active");
            //$("#optindicadorlistado").css('background-color',"rgb(217, 217, 217)"); 
        });

        function detallesIndicador(indicador) {
            $("#generalModal").modal("show");
            getInfoIndicador(indicador);

        }

        function getInfoIndicador(indicador) {
            $.ajax({
                type: 'GET',
                url: "{{ route('indicador.info') }}",
                data: {
                    indicador: indicador
                },
                beforeSend: function() {
                    $("#generalModal .modal-body").html(
                        '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>');
                }
            }).done(function(response) {
                $("#generalModal .modal-body").html(response).animate("slow");
            }).fail(function(data) {

            })
        }

        function deleteIndicador(idIndicador, nombreIndicador) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "La información del indicador: \"" + nombreIndicador + "\"  no estará disponible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, dar de baja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('indicador.delete') }}",
                        data: {
                            idIndicador: idIndicador,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            if (response.success = "ok") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Indicador ',
                                    text: response.message + " Indicador: " + nombreIndicador,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {
                                    window.location.replace("{{ route('indicador.list') }}");
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ocurrió un error al intentar dar de baja el Indicador',
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

        function responsableModal(indicador, dependencia) {
            $("#responsableModal").modal("show");
            $("#idIndicador").val(indicador);
            $("#responsable").val(dependencia);
        }

        function changeResponsable() {
            indicador = $("#idIndicador").val();
            responsable = $("#responsable").val();
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.indicador.updateresponsable') }}",
                data: {
                    indicador: indicador,
                    responsable: responsable,
                    _token: $("input[name='_token']").val()
                },
                beforeSend: function() {
                    anterior = $("#btnResponsable" + indicador).html();
                    $("#btnResponsable" + indicador).html(
                        '<div class="text-center"><i class="fas fa-spinner fa-spin"></i></div>');
                }
            }).done(function(response) {
                if (response.success == "ok") {
                    $("#btnResponsable" + indicador).html(
                        '' + response.siglas + '');
                } else {
                    $("#btnResponsable" + indicador).html(
                        '' + anterior + '');
                }
                $("#responsableModal").modal("hide");
            }).fail(function(data) {
                $("#btnResponsable" + indicador).html(
                    '' + anterior + '');
            })

        }

        function updateEditar(indicador){            
            editar =$("#editar"+indicador).prop("checked");
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.indicador.updateeditar') }}",
                data: {
                    indicador: indicador,
                    editar: editar,
                    _token: $("input[name='_token']").val()
                },
                beforeSend: function() {
                    
                }
            }).done(function(response) {
                if (response.success == "ok") {
                    $("#editar"+indicador).prop("checked",editar);
                } else {
                    $("#editar"+indicador).prop("checked",!editar);
                }
                
            }).fail(function(data) {
                $("#editar"+indicador).prop("checked",!editar);
            })
        }
    </script>
@endsection
