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
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Indicadores Registrados:
                        {{ count($indicadores) }}</h6>
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
                            <button class="btn btn-success"><i class="fas fa-download"></i> Generales</button>
                        </a>
                        <a href="{{ route('admin.indicador.downloadxlsxdetallado') }}" target="_blank">
                            <button class="btn btn-primary"><i class="fas fa-download"></i> Con Metas</button>
                        </a>
                    </div>
                    <div class="" style="text-align:left;position:relative;top:-10px;">
                        @php
                            $enrevision = 0;
                        @endphp
                        @foreach ($indicadores as $ind)
                            @php
                                if ($ind->en_revision == '1') {
                                    $enrevision++;
                                }
                            @endphp
                        @endforeach
                        <div style="position: absolute; top:-40px;">
                            <span>Indicadores abiertos: <b> {{ count($indicadores) - $enrevision }}</b></span>
                            <span>Indicadores cerrados: <b> {{ $enrevision }} </b></span>
                            @php
                                $avance = number_format(($enrevision * 100) / count($indicadores), 2);
                                $color = 'gray';
                                if ($avance > 0 && $avance <= 30) {
                                    $color = 'red';
                                } else {
                                    if ($avance > 30 && $avance <= 80) {
                                        $color = 'yellow';
                                    } else {
                                        $color = 'green';
                                    }
                                }
                            @endphp
                            <span>Avance: <button
                                    style="background-color:{{ $color }};height:20px;width:20px;border:solid 1px {{ $color }};"></button><b>
                                    {{ $avance }}%</b> </span>
                        </div>
                        <div style="text-align:right;">
                            <hr />
                            <a style="cursor: pointer"><b>Simbología del semáforo de desempeño.</b></a>
                            <div style="text-align:right;width:100%;">
                                <table align="right">
                                    <tr>
                                        <td style="padding: 5px;border: dashed 1px gray;text-align:center"><i
                                                class="fas fa-circle" style="color:red"></i></td>
                                        <td style="padding: 5px;border: dashed 1px gray">No Adecuado</td>
                                        <td style="padding: 5px;border: dashed 1px gray;text-align:center"><i
                                                class="fas fa-circle" style="color:yellow"></i></td>
                                        <td style="padding: 5px;border: dashed 1px gray">Sin Cambio</td>
                                        <td style="padding: 5px;border: dashed 1px gray;text-align:center"><i
                                                class="fas fa-circle" style="color:green"></i></td>
                                        <td style="padding: 5px;border: dashed 1px gray">Adecuado</td>
                                        <td style="padding: 5px;border: dashed 1px gray;text-align:center"><i
                                                class="fas fa-circle" style="color:gray"></i></td>
                                        <td style="padding: 5px;border: dashed 1px gray">No Disponible</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <button onclick="showList()" class="btn btn-primary">
                            <i class="fas fa-plus" id="iconList"></i> Columnas del Listado
                        </button>
                        <div style="text-align:left;position:absolute;top:25px;width:250px;background-color:#ffffff;z-index:999;display:none;border:solid 1px gray;padding:15px;"
                            id="listadoColumnas">
                            <div style="text-align: right;position:absolute;top:5px;right:10px;">
                                <i class="fas fa-window-close" onclick="showList()" style="cursor: pointer"></i>
                            </div>
                            <ul>
                                <li><input type="checkbox" onclick="toggleColumn(0)" id="column0" checked /> Id</li>
                                <li><input type="checkbox" onclick="toggleColumn(1)" id="column1" checked /> Indicador
                                </li>
                                <li><input type="checkbox" onclick="toggleColumn(2)" id="column2" checked /> Estatus</li>
                                <li><input type="checkbox" onclick="toggleColumn(3)" id="column3" checked /> Responsable
                                </li>
                                <li><input type="checkbox" onclick="toggleColumn(7)" id="column7" /> Definicion</li>
                                <li><input type="checkbox" onclick="toggleColumn(8)" id="column8" checked /> Tipo</li>
                                <li><input type="checkbox" onclick="toggleColumn(9)" id="column9" checked /> Dimension
                                </li>
                                <li><input type="checkbox" onclick="toggleColumn(10)" id="column10" checked /> Método de
                                    Cálculo</li>
                                <li><input type="checkbox" onclick="toggleColumn(11)" id="column11" checked /> Fórmula
                                </li>
                                <li><input type="checkbox" onclick="toggleColumn(12)" id="column12" checked /> Unidad de
                                    Medida</li>
                                <li><input type="checkbox" onclick="toggleColumn(13)" id="column13" /> Interpretación
                                </li>
                                <li><input type="checkbox" onclick="toggleColumn(14)" id="column14" checked />
                                    Frecuencia</li>
                                <li><input type="checkbox" onclick="toggleColumn(15)" id="column15" checked /> Sentido
                                </li>
                                <li><input type="checkbox" onclick="toggleColumn(16)" id="column16" /> Año de Línea Base
                                </li>
                                <li><input type="checkbox" onclick="toggleColumn(17)" id="column17" /> Observaciones
                                </li>
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
                                    <th>Desempeño 2023</th>
                                    <th>Imprimir ficha</th>
                                    <th>Permisos</th>
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($indicadores as $indicador)
                                    <tr>
                                        <td>{{ $indicador->idIndicador }}</td>
                                        <td style="width: 15%" onclick="editElement('nombre{{ $indicador->idIndicador }}',{{ $indicador->idIndicador }},'indicadorNombre')">
                                            <span
                                                id="nombre{{ $indicador->idIndicador }}">{{ $indicador->indicadorNombre }}</span>

                                        </td>
                                        <td style="width:">
                                            <select class="form-control" id="editar{{ $indicador->idIndicador }}"
                                                onchange="updateEditar({{ $indicador->idIndicador }})">
                                                <option value="0"
                                                    {{ $indicador->en_revision == 0 ? 'selected' : '' }}>
                                                    En
                                                    Edición</option>
                                                <option value="1"
                                                    {{ $indicador->en_revision == 1 ? 'selected' : '' }}>
                                                    En
                                                    Revisión por Gabinete</option>
                                                <option value="2"
                                                {{ $indicador->en_revision == 2 ? 'selected' : '' }}>
                                                Baja</option>
                                            </select>
                                            <span
                                                style="display: none">{{ $indicador->en_revision == 1 ? 'En revisión' : 'En edición' }}</span>

                                        </td>
                                        <td class="text-center"><button
                                                onclick="responsableModal({{ $indicador->idIndicador . ',' . $indicador->idDependencia }})"
                                                class="btn btn-primary"
                                                id="btnResponsable{{ $indicador->idIndicador }}">{{ $indicador->dependenciaSiglas }}</button>
                                        </td>
                                        <td style="text-align: center">
                                            <h4>
                                                <i class="fas fa-circle" style="color: gray"></i>
                                            </h4>
                                        </td>
                                        <td style="text-align: center">
                                            <a target="_blank"
                                                href="{{ route('indicador.admin.download', ['id' => $indicador->idIndicador]) }}"><button
                                                    class="btn btn-sm btn-dark"><i
                                                        class="fas fa-file-pdf"></i></button></a>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-success" onclick="showPermisos({{$indicador->idIndicador}})">
                                                <i class="fas fa-key">
                                                </i>
                                            </button>
                                            <div class="permisos" style="border:dashed 1px gray;width:250px; background-color:rgb(255, 255, 255);text-align: left;position:absolute;display:none;z-index:999" id="permisos{{$indicador->idIndicador}}">
                                                <table style="width: 100%">
                                                    <tr>
                                                        <td @if($indicador->meta) style="background-color:rgb(238, 255, 240)" @endif id="tdmeta{{$indicador->idIndicador}}"><input type="checkbox" onchange="updatePermission({{$indicador->idIndicador}},'meta',$(this))" name="" id="meta{{$indicador->idIndicador}}" @if($indicador->meta) checked  style="background-color:green" @endif > Editar Metadatos</td>
                                                    </tr>
                                                    <tr>
                                                        <td @if($indicador->histo) style="background-color:rgb(238, 255, 240)"@endif id="tdhisto{{$indicador->idIndicador}}"><input type="checkbox" onchange="updatePermission({{$indicador->idIndicador}},'histo',$(this))" `name="" id="histo{{$indicador->idIndicador}}" @if($indicador->histo) checked @endif> Editar Historicos</td>
                                                    </tr>
                                                    <tr>
                                                        <td @if($indicador->prog) style="background-color:rgb(238, 255, 240)"@endif id="tdprog{{$indicador->idIndicador}}"><input type="checkbox" onchange="updatePermission({{$indicador->idIndicador}},'prog',$(this))" name="" id="prog{{$indicador->idIndicador}}" @if($indicador->prog) checked @endif > Editar Programacion</td>
                                                    </tr>
                                                    <tr>
                                                        <td @if($indicador->moni) style="background-color:rgb(238, 255, 240)"@endif id="tdmoni{{$indicador->idIndicador}}"><input type="checkbox" onchange="updatePermission({{$indicador->idIndicador}},'moni',$(this))" name="" id="moni{{$indicador->idIndicador}}" @if($indicador->moni) checked @endif> Editar Editar Monitoreo</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                        <td style="width: 15%"
                                            onclick="editElement('definicion{{ $indicador->idIndicador }}',{{ $indicador->idIndicador }},'indicadorObjetivo')">
                                            <span
                                                id="definicion{{ $indicador->idIndicador }}">{{ $indicador->indicadorObjetivo }}</span>
                                        </td>
                                        @php
                                            switch ($indicador->indicadorMetodo) {
                                                case 'porcentaje':
                                                    $metodo = 'Porcentaje'; # code...
                                                    break;
                                                case 'indice':
                                                    $metodo = 'Indice'; # code...
                                                    break;
                                                case 'tasa':
                                                    $metodo = 'Tasa'; # code...
                                                    break;
                                                case 'tasa_v':
                                                    $metodo = 'Tasa de variación'; # code...
                                                    break;
                                                case 'razon':
                                                    $metodo = 'Razón o promedio'; # code...
                                                    break;
                                                default:
                                                    $metodo = 'No especificado';
                                                    break;
                                            }
                                        @endphp
                                        <td>{{ $indicador->indicadorTipo }}</td>
                                        <td>{{ $indicador->indicadorDimension }}</td>
                                        <td>{{ $metodo }}</td>
                                        <td
                                            onclick="editElement('formula{{ $indicador->idIndicador }}',{{ $indicador->idIndicador }},'indicadorFormula')">
                                            <span
                                                id="formula{{ $indicador->idIndicador }}">{{ $indicador->indicadorFormula }}</span>
                                        </td>
                                        <td>{{ $indicador->indicadorUM }}</td>
                                        <td
                                            onclick="editElement('interpretacion{{ $indicador->idIndicador }}',{{ $indicador->idIndicador }},'indicadorInterpretacion')">
                                            <span
                                                id="interpretacion{{ $indicador->idIndicador }}">{{ $indicador->indicadorInterpretacion }}</span>
                                        </td>
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
        .odd {
            background-color: #f3f3f3 !important;
        }
    </style>
@endsection
@section('scripts')
    <script>
        var dt = null;
        $(document).ready(function() {
            /*   dt = $("#dataTableIndicadores").DataTable({
                   pageLength: 5,
                   lengthMenu: [5, 10, 30, 50, 100],
                   order: [
                       [0, 'asc']
                   ],
               })*/


            $('#dataTableIndicadores thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#dataTableIndicadores thead');

            dt = $('#dataTableIndicadores').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 30, 50, 100],
                orderCellsTop: true,
                fixedHeader: true,
                initComplete: function() {
                    var api = this.api();

                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function(colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            if (colIdx != 4 && colIdx != 16 && colIdx != 5) {
                                $(cell).html(
                                    '<input type="text" class="form-control" placeholder="' +
                                    title + '" />');
                            } else {
                                $(cell).html('')
                            }


                            // On every keypress in this input
                            $(
                                    'input',
                                    $('.filters th').eq($(api.column(colIdx).header()).index())
                                )
                                .off('keyup change')
                                .on('change', function(e) {
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr =
                                        '({search})'; //$(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != '' ?
                                            regexr.replace('{search}', '(((' + this.value +
                                                ')))') :
                                            '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();
                                })
                                .on('keyup', function(e) {
                                    e.stopPropagation();

                                    $(this).trigger('change');
                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },
            });

            dt.column(7).visible(false);
            dt.column(13).visible(false);
            dt.column(16).visible(false);
            dt.column(17).visible(false);
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

        function toggleColumn(index) {
            if ($("#column" + index).prop("checked"))
                dt.column(index).visible(true);
            else
                dt.column(index).visible(false);
        }

        function editElement(element, indicador, campo) {
            valor = $("#" + element).html();
            if (valor.indexOf('</textarea>') < 0) {
                textarea = "<textarea id='textarea" + element + "' class='form-control' onkeypress='updateVal(\"" +
                    element + "\"," + indicador + ",\"" + campo + "\")'>" + valor + "</textarea>"
                $("#" + element).html(textarea);
                $("#textarea" + element).focus();
            }

        }

        function updateVal(elemento, indicador, campo) {

            if (event.keyCode == 13) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.indicador.updatedata') }}",
                    data: {
                        indicador: indicador,
                        campo: campo,
                        valor: $("#textarea" + elemento).val(),
                        _token: $("input[name='_token']").val()
                    },
                    beforeSend: function() {
                        $("#" + elemento).html("<i class='fas fa-spinner fa-spin'></i>");
                    }
                }).done(function(response) {
                    if (response.success == "ok") {
                        $("#" + elemento).html(response.valor);
                        $("#" + elemento).css('color', 'green');

                    } else {
                        $("#" + elemento).html(response.valor);
                        $("#" + elemento).css('color', 'red');
                    }
                }).fail(function(data) {
                    $("#" + elemento).css('color', 'red');
                })


            }
        }
        function showPermisos(idIndicador){

            if($("#permisos"+idIndicador).css('display')=="none"){
                $(".active").hide();
                $("#active").removeClass('active');
                $("#permisos"+idIndicador).addClass('active');
                $("#permisos"+idIndicador).show('fast');
            }
            else{
                $("#permisos"+idIndicador).removeClass('active');
                $("#permisos"+idIndicador).hide('fast');
            }

        }

        function updatePermission(indicador,campo,element){
            valor = element.prop('checked');
            color = element.css('background-color');
            $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.indicador.updatepermission') }}",
                    data: {
                        indicador: indicador,
                        campo: campo,
                        valor: valor===false?0:1,
                        _token: $("input[name='_token']").val()
                    },
                    beforeSend: function() {
                        $("#td" + campo+indicador).css("background-color","gray");
                    }
                }).done(function(response) {
                    if (response.success == "ok") {
                        //alert(valor);
                        if(valor){
                            $("#td" + campo + indicador).css('background-color','rgb(238, 255, 240)');
                        }
                        else{
                            $("#td" + campo + indicador).css('background-color','white');
                        }

                    } else {
                        $("#" + campo+indicador).css('background-color',color);
                        element.prop('checked',!valor);
                    }
                }).fail(function(data) {
                        $("#" + campo+indicador).css('background-color',color);
                        element.prop('checked',!valor);
                })

        }
    </script>
@endsection
