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
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Indicadores Registrados: {{count($indicadores)}}</h6>
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
                    <div class="" style="text-align:right;position:relative;top:-10px;">
                        <a href="{{ route('admin.indicador.downloadxlsx') }}" target="_blank">
                            <button class="btn btn-success"><i class="fas fa-download"></i> Descargar Concentrado</button>
                        </a>
                    </div>
                    <div class="" style="text-align:left;position:relative;top:-10px;">
                        @php
                            $enrevision = 0;
                        @endphp
                        @foreach ($indicadores as $ind )
                            @php
                                if($ind->en_revision == "1"){
                                    $enrevision++;
                                }
                            @endphp
                        @endforeach
                        <div style="position: absolute; top:-40px;">
                        <span>Indicadores abiertos: <b> {{count($indicadores)-$enrevision}}</b></span>
                        <span>Indicadores cerrados: <b> {{$enrevision}} </b></span>
                        @php
                            $avance = number_format(($enrevision*100)/count($indicadores),2);
                            $color = "gray";
                            if($avance>0 && $avance<=30){
                                $color="red";
                            }
                            else{
                                    if($avance>30 && $avance<=80){
                                        $color ="yellow";
                                    }else{
                                        $color ="green";
                                    }
                                }
                        @endphp
                        <span>Avance: <button style="background-color:{{$color}};height:20px;width:20px;border:solid 1px {{$color}};"></button><b> {{$avance}}%</b> </span>
                        </div>
                        <button  onclick="showList()" class="btn btn-primary">
                            <i class="fas fa-plus" id="iconList"></i> Columnas del Listado
                        </button>
                        <div style="text-align:left;position:absolute;top:25px;width:250px;background-color:#ffffff;z-index:999;display:none;border:solid 1px gray;padding:15px;"
                            id="listadoColumnas">
                            <div style="text-align: right;position:absolute;top:5px;right:10px;">
                                <i class="fas fa-window-close" onclick="showList()" style="cursor: pointer"></i>
                            </div>
                            <ul>
                                <li><input type="checkbox" onclick="toggleColumn(0)" id="column0" checked/> Id</li>
                                <li><input type="checkbox" onclick="toggleColumn(1)" id="column1" checked/> Indicador</li>
                                <li><input type="checkbox" onclick="toggleColumn(2)" id="column2" checked/> Estatus</li>
                                <li><input type="checkbox" onclick="toggleColumn(3)" id="column3" checked/> Responsable</li>
                                <li><input type="checkbox" onclick="toggleColumn(4)" id="column4" /> Definicion</li>
                                <li><input type="checkbox" onclick="toggleColumn(5)" id="column5" checked/> Tipo</li>
                                <li><input type="checkbox" onclick="toggleColumn(6)" id="column6" checked/> Dimension</li>
                                <li><input type="checkbox" onclick="toggleColumn(7)" id="column7" checked/> Método de Cálculo</li>
                                <li><input type="checkbox" onclick="toggleColumn(8)" id="column8" checked/> Fórmula</li>
                                <li><input type="checkbox" onclick="toggleColumn(9)" id="column9" checked/> Unidad de Medida</li>
                                <li><input type="checkbox" onclick="toggleColumn(10)" id="column10" /> Interpretación</li>
                                <li><input type="checkbox" onclick="toggleColumn(11)" id="column11" checked/> Frecuencia</li>
                                <li><input type="checkbox" onclick="toggleColumn(12)" id="column12" checked/> Sentido</li>
                                <li><input type="checkbox" onclick="toggleColumn(13)" id="column13" /> Año de Línea Base</li>
                                <li><input type="checkbox" onclick="toggleColumn(14)" id="column14" /> Observaciones</li>
                            </ul>
                        </div>
                    </div>
                    @if (count($indicadores) > 0)
                        <table class="table table-bordered" id="dataTableIndicadores" width="250%" cellspacing="0"
                            style="color: black" data-filter-control="true" data-show-search-clear-button="true">
                            <thead style="background-color: #919090;color:white;">
                                <tr>
                                    <th>Id</th>
                                    <th style="width: 15%;">Indicador</th>
                                    <th>Estatus</th>
                                    <th>Responsable</th>
                                    <th style="width: 15%">Definición</th>
                                    <th>Tipo</th>
                                    <th>Dimension</th>
                                    <th>Método de Cálculo</th>
                                    <th>Fórmula</th>
                                    <th>Unidad de Medida</th>
                                    <th>Interpretaciôn</th>
                                    <th>Frecuencia</th>
                                    <th>Sentido</th>
                                    <th>Año Línea Base</th>
                                    <th>Observaciones</th>
                                    <th>Opciones</th>
                                    <th>Imprimir ficha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($indicadores as $indicador)
                                    <tr>
                                        <td>{{ $indicador->idIndicador }}</td>
                                        <td style="width: 15%">{{ $indicador->indicadorNombre }}</td>
                                        <td style="width:">
                                            <select class="form-control" id="editar{{ $indicador->idIndicador }}"
                                                onchange="updateEditar({{ $indicador->idIndicador }})">
                                                <option value="0" {{ $indicador->en_revision == 0 ? 'selected' : '' }}>
                                                    En
                                                    Edición</option>
                                                <option value="1" {{ $indicador->en_revision == 1 ? 'selected' : '' }}>
                                                    En
                                                    Revisión por Gabinete</option>
                                            </select>
                                            <span
                                                style="display: none">{{ $indicador->en_revision == 1 ? 'En revisión' : 'En edición' }}</span>

                                        </td>
                                        <td class="text-center"><button
                                                onclick="responsableModal({{ $indicador->idIndicador . ',' . $indicador->idDependencia }})"
                                                class="btn btn-primary"
                                                id="btnResponsable{{ $indicador->idIndicador }}">{{ $indicador->dependenciaSiglas }}</button>
                                        </td>
                                        <td style="width: 15%">{{ $indicador->indicadorObjetivo }}</td>
                                        @php
                                            switch($indicador->indicadorMetodo){
                                                case 'porcentaje':
                                                    $metodo = "Porcentaje";# code...
                                                    break;
                                                case 'indice':
                                                    $metodo = "Indice";# code...
                                                    break;
                                                case 'tasa':
                                                    $metodo = "Tasa";# code...
                                                    break;
                                                case 'tasa_v':
                                                    $metodo = "Tasa de variación";# code...
                                                    break;
                                                case 'razon':
                                                    $metodo = "Razón o promedio";# code...
                                                    break;
                                                default:
                                                    $metodo="No especificado";
                                                    break;
                                            }
                                        @endphp
                                        <td>{{ $indicador->indicadorTipo }}</td>
                                        <td>{{ $indicador->indicadorDimension }}</td>
                                        <td>{{ $metodo }}</td>
                                        <td>{{ $indicador->indicadorFormula }}</td>
                                        <td>{{ $indicador->indicadorUM }}</td>
                                        <td>{{ $indicador->indicadorInterpretacion }}</td>
                                        <td>{{ $indicador->indicadorFrecuencia }}</td>
                                        <td>{{ $indicador->indicadorSentido }}</td>
                                        <td>{{ $indicador->indicadorAnioLB }}</td>
                                        <td>{{ $indicador->observaciones }}</td>
                                        <!--<td class="text-center">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="editar{{ $indicador->idIndicador }}" onclick="updateEditar({{ $indicador->idIndicador }})" @if ($indicador->editar) " checked " @endif>
                                                    </div>
                                                </td>-->
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
                                                        class="btn btn-sm btn-info"><i
                                                            class="fas fa-edit"></i></button></a>
                                                <!--<button class="btn btn-sm btn-danger"
                                                                    onclick="deleteIndicador({{ $indicador->idIndicador . ",'" . $indicador->indicadorNombre }}')"><i
                                                                        class="fas fa-trash"></i></button>-->
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            <a target="_blank"
                                                href="{{ route('indicador.download', ['id' => $indicador->idIndicador]) }}"><button
                                                    class="btn btn-sm btn-dark"><i
                                                        class="fas fa-file-pdf"></i></button></a>
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
        var dt=null;
        $(document).ready(function() {
            dt = $("#dataTableIndicadores").DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 30, 50, 100],
                order: [
                    [0, 'asc']
                ],
            })

            dt.column(4).visible(false);
            dt.column(10).visible(false);
            dt.column(13).visible(false);
            dt.column(14).visible(false);
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

        function updateEditar(indicador) {
            editar = $("#editar" + indicador).val();
            noeditar = editar == 0 ? 1 : 0;
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
                    $("#editar" + indicador).val(editar);
                    $("#editar" + indicador).css("border", "solid 1px green")

                } else {
                    $("#editar" + indicador).val(noeditar);
                    $("#editar" + indicador).css("border", "solid 1px red")
                }

            }).fail(function(data) {
                $("#editar" + indicador).val(noeditar);
                $("#editar" + indicador).css("border", "solid 1px red")
            })
        }

        function showList() {
            $('#listadoColumnas').toggle('fast', function() {
                if ($('#listadoColumnas').is(':visible')) {
                    $("#iconList").removeClass("fa-plus");
                    $("#iconList").addClass("fa-minus");
                } else {
                    $("#iconList").removeClass("fa-minus");
                    $("#iconList").addClass("fa-plus");
                }
            })
        }

        function toggleColumn(index){
            if($("#column"+index).prop("checked"))
                dt.column(index).visible(true);
            else
                dt.column(index).visible(false);
        }
    </script>
@endsection
