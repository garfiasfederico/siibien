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
                                        <td style="padding: 5px;border: dashed 1px gray;text-align:center">
                                            <img style="width:30px;" src="{{asset("/images/indicadores/adecuado_.png")}}">
                                        </td>
                                        <td style="padding: 5px;border: dashed 1px gray">Adecuado</td>                                       
                                        <td style="padding: 5px;border: dashed 1px gray;text-align:center">        
                                            <img style="width:30px;" src="{{asset("/images/indicadores/sin_cambio_.png")}}"></td>
                                        <td style="padding: 5px;border: dashed 1px gray">Sin Cambio</td>
                                        <td style="padding: 5px;border: dashed 1px gray;text-align:center">                                            
                                            <img style="width:30px;" src="{{asset("/images/indicadores/no_adecuado_.png")}}">
                                        </td>
                                        <td style="padding: 5px;border: dashed 1px gray">No Adecuado</td>
                                        <td style="padding: 5px;border: dashed 1px gray;text-align:center">
                                            <img style="width:30px;" src="{{asset("/images/indicadores/no_disponible.png")}}">                                            
                                        </td>
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
                            <li><input type="checkbox" onclick="toggleColumn(0)" id="column0" checked> Id</li>
                            <li><input type="checkbox" onclick="toggleColumn(1)" id="column1" checked> Indicador</li>
                            <li><input type="checkbox" onclick="toggleColumn(2)" id="column2" checked> Estatus</li>
                            <li><input type="checkbox" onclick="toggleColumn(3)" id="column3" checked> Responsable</li>
                            <li><input type="checkbox" onclick="toggleColumn(4)" id="column4" checked>Validación ITE</li>
                            <li><input type="checkbox" onclick="toggleColumn(5)" id="column5" checked> Entrega 2025</li>
                            <li><input type="checkbox" onclick="toggleColumn(6)" id="column6" checked> Validación CREMAA</li>
                            <li><input type="checkbox" onclick="toggleColumn(7)" id="column7" checked> Desempeño 2023</li>
                            <li><input type="checkbox" onclick="toggleColumn(8)" id="column8" checked> Desempeño 2024</li>
                            <li><input type="checkbox" onclick="toggleColumn(9)" id="column9" checked> Imprimir ficha</li>
                            <li><input type="checkbox" onclick="toggleColumn(10)" id="column10" checked> Permisos</li>
                            <li><input type="checkbox" onclick="toggleColumn(11)" id="column11" checked> Definición</li>
                            <li><input type="checkbox" onclick="toggleColumn(12)" id="column12" checked> Tipo</li>
                            <li><input type="checkbox" onclick="toggleColumn(13)" id="column13" checked> Dimension</li>
                            <li><input type="checkbox" onclick="toggleColumn(14)" id="column14" > Método de Cálculo</li>
                            <li><input type="checkbox" onclick="toggleColumn(15)" id="column15" checked> Fórmula</li>
                            <li><input type="checkbox" onclick="toggleColumn(16)" id="column16" checked> Unidad de Medida</li>
                            <li><input type="checkbox" onclick="toggleColumn(17)" id="column17" > Interpretación</li>
                            <li><input type="checkbox" onclick="toggleColumn(18)" id="column18" > Frecuencia</li>
                            <li><input type="checkbox" onclick="toggleColumn(19)" id="column19" checked> Sentido</li>
                            <li><input type="checkbox" onclick="toggleColumn(20)" id="column20" checked> Año Línea Base</li>
                            <li><input type="checkbox" onclick="toggleColumn(21)" id="column21" checked> Observaciones</li>
                            <li><input type="checkbox" onclick="toggleColumn(22)" id="column22" checked> Opciones</li>
                        </ul>

                        </div>
                    </div>
                    @if (count($indicadores) > 0)
                        <table class="table table-bordered" id="dataTableIndicadores" width="260%" cellspacing="0"
                            style="color: black" data-filter-control="true" data-show-search-clear-button="true">
                            <thead style="background-color: #919090;color:white;">
                                <tr>
                                    <th>Id</th>
                                    <th style="width: 15%;">Indicador</th>
                                    <th>Estatus</th>
                                    <th>Responsable</th>
                                    <th>Validación ITE</th>
                                    <th>Entrega 2025</th>
                                    <th>Validación CREMAA</th>
                                    <th>Desempeño 2023</th>
                                    <th>Desempeño 2024</th>
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
                                        <td class="text-center">
                                            <input type="checkbox" data-toggle="toggle" data-on="Validado"
                                                data-off="No validado" data-onstyle="success" data-offstyle="secondary"
                                                data-size="sm" {{ $indicador->validacion ? 'checked' : '' }}
                                                onchange="guardarValidacion({{ $indicador->idIndicador }}, $(this))">


                                        </td>

                                        <td class="text-center">
                                            <i class="fas fa-exclamation-circle"
                                            data-toggle="tooltip"
                                            title="
                                                    @if($indicador->estado_entrega === 'verde')
                                                        Entrega realizada en 2025
                                                    @elseif($indicador->estado_entrega === 'naranja')
                                                        Debía entregar en 2025, pendiente de captura
                                                    @else
                                                        No tiene entrega programada en 2025
                                                    @endif
                                            "
                                            style="
                                                    font-size: 30px;
                                                    color:
                                                        {{ $indicador->estado_entrega === 'verde'
                                                            ? '#28a745'
                                                            : ($indicador->estado_entrega === 'naranja'
                                                                ? '#fd7e14'
                                                                : '#b0b0b0')
                                                        }};
                                            ">
                                            </i>
                                        </td>


                                        <td>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                    title="Validar criterios CREMA"
                                                    onclick="abrirModalCrema({{ $indicador->idIndicador }}, '{{ addslashes($indicador->indicadorNombre) }}')">
                                                <i class="fas fa-award"></i> Validar CREMAA
                                            </button>
                                        </td>
                                        <td style="text-align: center">
                                            <h4>                                                
                                                    @if($indicador->pun2023 == 1)
                                                        <!--<i class="fas fa-circle"
                                                        data-toggle="tooltip"
                                                        title="Adecuado"
                                                        style="color: green">                                                    
                                                        </i>-->
                                                        <img style="width:80px;" src="{{asset("/images/indicadores/adecuado.png")}}">
                                                    @endif
                                                    @if($indicador->pun2023 == .5)
                                                        <!--<i class="fas fa-circle" style="color: yellow"
                                                        data-toggle="tooltip"
                                                        title="Sin cambio">                                                    
                                                        </i>-->
                                                        <img style="width:80px;" src="{{asset("/images/indicadores/sin_cambio.png")}}">
                                                    @endif
                                                    @if($indicador->pun2023 == "0")
                                                        <!--<i class="fas fa-circle" style="color: red"
                                                        data-toggle="tooltip"
                                                        title="No adecuado">                                                    
                                                        </i>-->
                                                        <img style="width:80px;" src="{{asset("/images/indicadores/no_adecuado.png")}}">
                                                    @endif  
                                                
                                                    @if(is_null($indicador->pun2023))
                                                        <!--<i class="fas fa-circle" style="color: gray"
                                                        data-toggle="tooltip"
                                                        title="No disponible">                                                    
                                                        </i>-->
                                                        <img style="width:50px;" src="{{asset("/images/indicadores/no_disponible.png")}}">
                                                    @endif                                             
                                            </h4>
                                        </td>
                                        <td style="text-align: center">
                                            <h4>                                                
                                                    @if($indicador->pun2024 == 1)
                                                        <!--<i class="fas fa-circle"
                                                        data-toggle="tooltip"
                                                        title="Adecuado"
                                                        style="color: green">                                                    
                                                        </i>-->
                                                        <img style="width:80px;" src="{{asset("/images/indicadores/adecuado.png")}}">
                                                    @endif
                                                    @if($indicador->pun2024 == .5)
                                                        <!--<i class="fas fa-circle" style="color: yellow"
                                                        data-toggle="tooltip"
                                                        title="Sin cambio">                                                    
                                                        </i>-->
                                                        <img style="width:80px;" src="{{asset("/images/indicadores/sin_cambio.png")}}">
                                                    @endif
                                                    @if($indicador->pun2024 == "0")
                                                        <!--<i class="fas fa-circle" style="color: red"
                                                        data-toggle="tooltip"
                                                        title="No adecuado">                                                    
                                                        </i>-->
                                                        <img style="width:80px;" src="{{asset("/images/indicadores/no_adecuado.png")}}">
                                                    @endif  
                                                
                                                    @if(is_null($indicador->pun2024))
                                                        <!--<i class="fas fa-circle" style="color: gray"
                                                        data-toggle="tooltip"
                                                        title="No disponible">                                                    
                                                        </i>-->
                                                        <img style="width:50px;" src="{{asset("/images/indicadores/no_disponible.png")}}">
                                                    @endif                                             
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
                                                        <td @if($indicador->meta) style="background-color:rgb(238, 255, 240)" @endif id="tdmeta{{$indicador->idIndicador}}"><input type="checkbox" onchange="updatePermission({{$indicador->idIndicador}},'meta',$(this))" name="" id="meta{{$indicador->idIndicador}}" @if($indicador->meta) checked  style="background-color:green" @endif > Metadatos</td>
                                                    </tr>
                                                    <tr>
                                                        <td @if($indicador->prog) style="background-color:rgb(238, 255, 240)"@endif id="tdprog{{$indicador->idIndicador}}"><input type="checkbox" onchange="updatePermission({{$indicador->idIndicador}},'prog',$(this))" `name="" id="prog{{$indicador->idIndicador}}" @if($indicador->prog) checked @endif> Históricos y Programación</td>
                                                    </tr>
                                                    @if(false)
                                                        <tr style="display: none">
                                                            <td @if($indicador->prog) style="background-color:rgb(238, 255, 240)"@endif id="tdprog{{$indicador->idIndicador}}"><input type="checkbox" onchange="updatePermission({{$indicador->idIndicador}},'histo',$(this))" name="" id="prog{{$indicador->idIndicador}}" @if($indicador->prog) checked @endif > Programacion</td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td @if($indicador->moni) style="background-color:rgb(238, 255, 240)"@endif id="tdmoni{{$indicador->idIndicador}}"><input type="checkbox" onchange="updatePermission({{$indicador->idIndicador}},'moni',$(this))" name="" id="moni{{$indicador->idIndicador}}" @if($indicador->moni) checked @endif> Monitoreo</td>
                                                    </tr>
                                                                                                        <tr>
                                                        <td @if($indicador->crema) style="background-color:rgb(238, 255, 240)"@endif id="tdcrema{{$indicador->idIndicador}}"><input type="checkbox" onchange="updatePermission({{$indicador->idIndicador}},'crema',$(this))" name="" id="crema{{$indicador->idIndicador}}" @if($indicador->crema) checked @endif> CREMAA</td>
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
    @include('indicador.validarCrema')
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
                            if (colIdx != 4 && colIdx != 16 && colIdx != 5 && colIdx != 7 && colIdx != 8 && colIdx != 6) {
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
            function initTogglesV361() {
                $('[data-toggle="toggle"]').each(function () {
                    const $el = $(this);

                    // evitar doble inicialización
                    if ($el.data('toggle-initialized')) return;

                    const isChecked = $el.prop('checked') === true;

                    $el.bootstrapToggle({
                        on:  $el.attr('data-on'),
                        off: $el.attr('data-off'),
                        onstyle: $el.data('onstyle') || 'success',
                        offstyle: $el.data('offstyle') || 'secondary',
                        size: $el.data('size') || 'sm'
                    });

                    $el.bootstrapToggle(isChecked ? 'on' : 'off', true);

                    const tooltipText = $el.data('tooltip');
                    if (tooltipText) {
                        const $toggleWrapper = $el.closest('.toggle');
                        $toggleWrapper
                            .attr('title', tooltipText)
                            .attr('data-toggle', 'tooltip')
                            .tooltip({ container: 'body' });
                    }

                    $el.data('toggle-initialized', true);
                });
            }




            dt.column(7).visible(true);
            dt.column(8).visible(true);            
            
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
        function aplicarPermisosCrema(canEdit){
            const $modal   = $('#modalCrema');
            const $form    = $('#formCrema');
            const $toggles = $form.find('input[type="checkbox"][data-toggle="toggle"]');

            // Botón Guardar
            $('#btnGuardarCrema').toggle(!!canEdit);

            // Botón lápiz 
            $modal.find('.card-actions [onclick^="abrirModalAgregarComentario"]').each(function(){
                $(this).toggle(!!canEdit);
            });

            // Toggles
            if (canEdit) {
                $toggles.each(function(){
                    const $chk = $(this);
                    $chk.removeAttr('data-solo-lectura').prop('disabled', false);
                    if ($chk.data('bs.toggle')) { try { $chk.bootstrapToggle('enable'); } catch(e){} }
                    $chk.off('.crema');
                    $chk.closest('.crema-card').removeClass('is-readonly');
                });
            } else {
                $toggles.each(function(){
                    const $chk = $(this);
                    const estadoInicial = $chk.prop('checked');

                    $chk.attr('data-solo-lectura','true').prop('disabled', true);
                    if ($chk.data('bs.toggle')) {
                        try {
                            $chk.bootstrapToggle('disable');
                            $chk.bootstrapToggle(estadoInicial ? 'on' : 'off', true);
                        } catch(e){}
                    }

                    $chk.off('click.crema keydown.crema change.crema mousedown.crema touchstart.crema')
                        .on('click.crema keydown.crema change.crema mousedown.crema touchstart.crema', function(e){
                            e.preventDefault(); e.stopImmediatePropagation();
                            $chk.prop('checked', estadoInicial);
                            if ($chk.data('bs.toggle')) {
                                try { $chk.bootstrapToggle(estadoInicial ? 'on' : 'off', true); } catch(err){}
                            }
                            return false;
                        });

                    $chk.closest('.crema-card').addClass('is-readonly');
                });
            }
        }

        // (admin || indicador.crema == 1)
function cargarPermisosCrema(idIndicador){
    aplicarPermisosCrema(false);

    $.get("{{ route('indicador.getstatus') }}", { indicador: idIndicador })
    .done(function(resp){
        let canEdit = false;

        if (window._esAdminCrema === true) {
            // Si es administrador, siempre puede editar
            canEdit = true;
        } else {
            // Si no es admin, depende del flag del backend
            canEdit = Number(resp?.crema) === 1;
        }

        aplicarPermisosCrema(canEdit);
    })
    .fail(function(){
        aplicarPermisosCrema(false);
    });
}


        function abrirModalCrema(idIndicador, nombreIndicador) {
            window._cremaProgrammatic = true;
            _cremaIndicadorActivo = idIndicador;

            _cremaPeticiones.forEach(x => { try { x.abort(); } catch(e){} });
            _cremaPeticiones = [];

            if (!$('#modalCrema').data('cremaHandlersBound')) {
                $('#modalCrema')
                    .on('change', 'input[type="checkbox"][data-toggle="toggle"]', function() {
                        const $card = $(this).closest('.crema-card');
                        $card.toggleClass('is-checked', $(this).prop('checked'));
                    })
                    .data('cremaHandlersBound', true);
            }

            $('#cremaIndicadorId').val(idIndicador);
            $('#modalCremaLabel').text(
                nombreIndicador
                    ? 'Validación CREMAA — [' + idIndicador + '] ' + nombreIndicador
                    : 'Validación CREMAA'
            );

            const $form   = $('#formCrema');
            const $checks = $form.find('input[type="checkbox"][data-toggle="toggle"]');

            $checks.each(function() {
                const $chk = $(this);
                if ($chk.data('bs.toggle') && typeof $chk.bootstrapToggle === 'function') {
                    try { $chk.bootstrapToggle('destroy'); } catch(e){}
                }
                $chk.prop('checked', false);
                $chk.closest('.crema-card').removeClass('is-checked is-readonly');
            });

            $checks.each(function() {
                const $chk = $(this);
                if (typeof $chk.bootstrapToggle === 'function') {
                    $chk.bootstrapToggle({
                        on:      $chk.data('on')      || 'Cumple',
                        off:     $chk.data('off')     || 'No cumple',
                        onstyle: $chk.data('onstyle') || 'success',
                        offstyle:$chk.data('offstyle')|| 'secondary',
                        width:   $chk.data('width')   || 120
                    });
                }
            });

            // Abre modal y muestra loader
            $('#modalCrema').modal('show');
            $('#cremaBodyContent').hide();
            $('#cremaLoader').show();

            //  Cargar permisos (admin || indicador.crema == 1)
            cargarPermisosCrema(idIndicador);

            const $btnGuardar = $('#btnGuardarCrema');
            $btnGuardar.prop('disabled', true);

            const cacheBuster = Date.now();
            const req = $.ajax({
                url: "{{ url('/indicadores') }}/" + encodeURIComponent(idIndicador) + "/crema?_=" + cacheBuster,
                method: 'GET',
                dataType: 'json',
                cache: false,
                headers: {
                    'Cache-Control': 'no-cache, no-store, must-revalidate',
                    'Pragma': 'no-cache',
                    'Expires': '0'
                }
            })
            .done(function(resp) {
                if (_cremaIndicadorActivo !== idIndicador) return;

                const keys = ['claro','relevante','economico','monitoreable','adecuado','aporteMarginal'];

                keys.forEach(k => {
                    const $chk = $form.find(`input[type="checkbox"][name="crema[${k}]"]`);
                    const estabaDisabled = $chk.is(':disabled');

                    if ($chk.data('bs.toggle')) { try { $chk.bootstrapToggle('enable'); } catch(e){} }
                    $chk.prop('disabled', false);

                    $chk.prop('checked', false);
                    if ($chk.data('bs.toggle')) { try { $chk.bootstrapToggle('off', true); } catch(e){} }
                    $chk.closest('.crema-card').removeClass('is-checked');

                    if (estabaDisabled) {
                        $chk.prop('disabled', true);
                        if ($chk.data('bs.toggle')) { try { $chk.bootstrapToggle('disable'); } catch(e){} }
                    }
                });

                if (resp && resp.data) {
                    keys.forEach(k => {
                        const v = Number(resp.data[k]) === 1;
                        const $chk = $form.find(`input[type="checkbox"][name="crema[${k}]"]`);
                        const estabaDisabled = $chk.is(':disabled');

                        if ($chk.data('bs.toggle')) { try { $chk.bootstrapToggle('enable'); } catch(e){} }
                        $chk.prop('disabled', false);

                        $chk.prop('checked', !!v);
                        if ($chk.data('bs.toggle')) { try { $chk.bootstrapToggle(v ? 'on' : 'off', true); } catch(e){} }
                        $chk.closest('.crema-card').toggleClass('is-checked', !!v);

                        if (estabaDisabled) {
                            $chk.prop('disabled', true);
                            if ($chk.data('bs.toggle')) { try { $chk.bootstrapToggle('disable'); } catch(e){} }
                        }
                    });
                }
            })
            .fail(function(xhr) {
                if (xhr.statusText === 'abort') return;
                console.error('Error al cargar datos CREMA', xhr);
            })
            .always(function() {
                if (_cremaIndicadorActivo !== idIndicador) return;

                window._cremaProgrammatic = false;

                $('#cremaLoader').hide();
                $('#cremaBodyContent').show();
                $btnGuardar.prop('disabled', false);

                actualizarEstadosBotonesComentarios(idIndicador);
            });

            _cremaPeticiones.push(req);
        }

        function guardarCrema() {
            const $form = $('#formCrema');
            const $btn = $('#btnGuardarCrema');
            const originalHtml = $btn.html();

            const idIndicador = $('#cremaIndicadorId').val();
            if (!idIndicador) {
                Swal.fire({ icon: 'warning', title: 'Falta el ID del indicador.' });
                return;
            }

            const url = "{{ url('/indicadores') }}/" + idIndicador + "/crema";

            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...');

            $.ajax({
                url,
                method: 'POST',
                data: $form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $form.find('input[name="_token"]').val(),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                dataType: 'json'
            })
            .done(function (resp) {
                if (resp.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Guardado',
                        text: resp.message || 'Validación guardada correctamente.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#modalCrema').modal('hide');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: resp.message || 'Ocurrió un problema inesperado.'
                    });
                }
            })
            .fail(function (xhr) {
                const msg = xhr.responseJSON?.message || 'Ocurrió un error al guardar la validación.';
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            })
            .always(function () {
                $btn.prop('disabled', false).html(originalHtml);
            });
        }
        let _cremaPeticiones = [];
        let _cremaIndicadorActivo = null;

        function setEstadoBotonComentarios($btn, tieneComentarios) {
            if (tieneComentarios) {
                $btn.removeClass('btn-secondary').addClass('btn-info')
                    .prop('disabled', false)
                    .attr('title', 'Ver comentarios');
            } else {
                $btn.removeClass('btn-info').addClass('btn-secondary')
                    .prop('disabled', true)
                    .attr('title', 'No hay comentarios');
            }
        }

        function actualizarEstadoBotonComentario(idIndicador, criterio, $btn, force = false) {
            const urlBase = `{{ route('crema.comentarios.mostrar', ':id') }}`.replace(':id', idIndicador);
            const cacheKey = idIndicador + '::' + criterio;

            if (!force) {
                const cachedKey = $btn.data('cremaCacheKey');
                const cachedVal = $btn.data('cremaTieneComentarios');
                if (cachedKey === cacheKey && typeof cachedVal !== 'undefined') {
                    setEstadoBotonComentarios($btn, !!cachedVal);
                    return;
                }
            }

            setEstadoBotonComentarios($btn, false);

            const prevReq = $btn.data('cremaReq');
            if (prevReq && typeof prevReq.abort === 'function') {
                try { prevReq.abort(); } catch(e){}
            }

            const cacheBuster = Date.now();

            const req = $.ajax({
                url: urlBase + `?criterio=${encodeURIComponent(criterio)}&_=${cacheBuster}`,
                method: 'GET',
                dataType: 'json',
                cache: false,
                headers: {
                    'Cache-Control': 'no-cache, no-store, must-revalidate',
                    'Pragma': 'no-cache',
                    'Expires': '0',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .done(function(resp) {
                if (_cremaIndicadorActivo !== idIndicador) return;

                const lista = resp?.comentarios || [];
                const tiene = lista.length > 0;

                $btn.data('cremaCacheKey', cacheKey);
                $btn.data('cremaTieneComentarios', tiene);

                setEstadoBotonComentarios($btn, tiene);
            })
            .fail(function(xhr) {
                if (xhr.statusText === 'abort') return;
                setEstadoBotonComentarios($btn, true);
            })
            .always(function() {
                $btn.removeData('cremaReq');
            });

            $btn.data('cremaReq', req);
            _cremaPeticiones.push(req);
        }


    function actualizarEstadosBotonesComentarios(idIndicador) {
        $('.card-actions').each(function() {
            const $acciones = $(this);
            const criterio = $acciones.data('criterio');
            const $btnVer = $acciones.find('[data-action="ver-comentarios"]');
            if (!criterio || $btnVer.length === 0) return;

            actualizarEstadoBotonComentario(idIndicador, criterio, $btnVer);
        });
    }
    function guardarValidacion(idIndicador, element) {
            const valor = element.prop('checked') ? 1 : 0;

            $.ajax({
                    type: 'POST',
                    url: "{{ url('indicador') }}/" + idIndicador + "/validacion",
                    data: {
                        validacion: valor,
                        _token: $("input[name='_token']").val()
                    }
                })
                .fail(function() {
                    element.prop('checked', !valor);
                    element.bootstrapToggle(valor ? 'off' : 'on', true);
                });
        }
    </script>
@endsection
