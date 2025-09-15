@extends('layouts.administrador')

@section('content')
    <!-- Content Row -->
    <div style="text-align:right;display:none;top:-30px;position:relative" id="regresar">
        <center>
            <span id="indicadorTitulo" style="text-align: left;font-size:18pt;width:100%;color:black">

            </span>
            <hr />
            <button class="btn btn-outline-primary" onclick="returnIndicadores()">
                <i class="fas fa-arrow-left mr-2"></i> Regresar
            </button>
        </center>
    </div>
    <div class="row" id="indicadores">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3" style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white!important">Indicadores</h6>
                </div>

                <div class="card-body">
                    {{-- @if (auth()->user()->hasRole('administrador') || auth()->user()->hasRole('consulta'))
                    <h2>Filtros</h2>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="poreje">Por Eje:<span style="color: red"></span></label>
                            <select class="form-control selectpicker" id="poreje" name="poreje"
                                onchange="getIndicadoresByFiltro()">
                                <option value="0">Todos...</option>
                                <option value="1">1. Estado de bienestar para todas las oaxaqueñas y oaxaqueños</option>
                                <option value="2">2. Gobierno honesto, cercano y transparente al servicio de los pueblos y
                                    comunidades</option>
                                <option value="3">3. Seguridad y justicia para vivir en paz</option>
                                <option value="4">4. Crecimiento y Desarrollo Económico para las ocho regiones</option>
                                <option value="5">5. Infraestructura y Sevicios públicos para el desarrollo</option>
                                <option value="6">6. Igualdad de Genero</option>
                                <option value="7">7. Desarrollo sostenible</option>
                                <option value="8">8. Interculturalidad</option>
                                <option value="9">9. Niñas, Niños y Adolescentes</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="pordependencia">Por Dependencia:<span style="color: red"></span></label>
                            <select class="form-control" id="pordependencia" name="pordependencia"
                                onchange="getIndicadoresByFiltro()">
                                <option value="0">Todas...</option>
                                @foreach ($dependencias as $dependencia)
                                <option value="{{ $dependencia->idDependencia }}">
                                    {{ $dependencia->dependenciaNombre . ' (' . $dependencia->dependenciaSiglas . ')' }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="porsector">Por Sector:<span style="color: red"></span></label>
                            <select class="form-control" id="porsector" name="porsector"
                                onchange="getIndicadoresByFiltro()">
                                <option value="0">Todos...</option>
                            </select>
                        </div>
                    </div>
                    <hr />
                    @endif --}}

                    <div id="indicadoresContent">
                        @if (count($indicadores) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="tablaIndicadores">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width:80px;">ID</th>
                                            <th>Indicador</th>
                                            <th>Dependencia</th>
                                            <th>Sentido</th>
                                            <th style="width:220px;">Desempeño</th>
                                            <th style="width:240px;" class="text-right">Acciones</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($indicadores as $indicador)
                                            @php
                                                // Color por Eje
                                                switch ($indicador->idEjePED) {
                                                    case 1:
                                                        $color = '#83d0c8';
                                                        break;
                                                    case 2:
                                                        $color = '#AF7782';
                                                        break;
                                                    case 3:
                                                        $color = '#87A0D2';
                                                        break;
                                                    case 4:
                                                        $color = '#ADDB8A';
                                                        break;
                                                    case 5:
                                                        $color = '#F3B88B';
                                                        break;
                                                    default:
                                                        $color = '#000000';
                                                        break;
                                                }

                                                $pct = isset($indicador->desempeno_pct)
                                                    ? max(0, min(100, (float) $indicador->desempeno_pct))
                                                    : null;

                                                $sentidoRaw = trim((string) ($indicador->indicadorSentido ?? ''));
                                                $isAsc = strcasecmp($sentidoRaw, 'ascendente') === 0 || strcasecmp($sentidoRaw, 'asc') === 0 || $sentidoRaw === '↑';
                                                $isDesc = strcasecmp($sentidoRaw, 'descendente') === 0 || strcasecmp($sentidoRaw, 'desc') === 0 || $sentidoRaw === '↓';
                                                $sentidoTxt = $isAsc ? 'Ascendente' : ($isDesc ? 'Descendente' : ($sentidoRaw !== '' ? $sentidoRaw : '—'));
                                                $sentidoIcon = $isAsc ? 'fa-arrow-up' : ($isDesc ? 'fa-arrow-down' : 'fa-minus');
                                                $sentidoClas = $isAsc ? 'pill-asc' : ($isDesc ? 'pill-desc' : 'pill-neutral');

                                                // Dependencia
                                                $depSiglas = $indicador->dependenciaSiglas ?? null;
                                                $depNombre = $indicador->dependenciaNombre ?? null;

                                                // Si no traía $pct, se calcula con el último registro disponible
                                                $etiquetaPeriodo = null;
                                                if (is_null($pct)) {
                                                    $ultimo = \App\Models\ValoresProgramadosIndicador::where('idIndicador', $indicador->idIndicador)
                                                        ->whereNotNull('valoresReal')
                                                        ->where('valoresReal', '>', 0)
                                                        ->whereNotNull('valoresProgramado')
                                                        ->orderBy('valoresAnioMedicion', 'desc')
                                                        ->orderByRaw("FIELD(valoresCicloMedicion,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    'Anual','Semestral 2','Semestral 1',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    'Trimestral 4','Trimestral 3','Trimestral 2','Trimestral 1',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    'Mensual 12','Mensual 11','Mensual 10','Mensual 9','Mensual 8','Mensual 7',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    'Mensual 6','Mensual 5','Mensual 4','Mensual 3','Mensual 2','Mensual 1'
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                )")
                                                        ->first();

                                                    if ($ultimo) {
                                                        $alcanzado = (float) $ultimo->valoresReal;
                                                        $programado = (float) $ultimo->valoresProgramado;
                                                        $pct = $programado > 0 ? round(($alcanzado / $programado) * 100, 2) : null;
                                                        $etiquetaPeriodo = (string) $ultimo->valoresAnioMedicion; // solo año
                                                    }
                                                }
                                            @endphp

                                            <tr>
                                                {{-- ID --}}
                                                <td>
                                                    {{ $indicador->idIndicador }}
                                                </td>

                                                {{-- Indicador --}}
                                                <td class="text-wrap">
                                                    <div class="d-flex align-items-center indicador-cell">
                                                        <div class="indicador-thumb" style="border-color: {{ $color }};">
                                                            <img src="{{ asset('/images/ejes_icons/eje' . $indicador->idEjePED . '.png') }}"
                                                                alt="Indicador {{ $indicador->idIndicador }}" class="indicador-img">
                                                        </div>
                                                        <div class="ml-2">
                                                            <strong>{{ $indicador->indicadorNombre }}</strong>
                                                            <div class="mt-1">
                                                                <span class="badge badge-pill mr-1"
                                                                    style="background:#e8f0fe; color:#1a73e8;"
                                                                    title="Tipo de indicador">
                                                                    <i class="fas fa-tag"></i>
                                                                    {{ $indicador->indicadorTipo ?? '—' }}
                                                                </span>
                                                                <span class="badge badge-pill"
                                                                    style="background:#e6f4ea; color:#188038;"
                                                                    title="Dimensión del indicador">
                                                                    <i class="fas fa-layer-group"></i>
                                                                    {{ $indicador->indicadorDimension ?? '—' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                {{-- Dependencia --}}
                                                <td class="text-nowrap">
                                                    @if($depSiglas || $depNombre)
                                                        <span class="dep-pill" style="--dep-bg: {{ $color }};" data-toggle="tooltip"
                                                            title="{{ $depNombre ?? $depSiglas }}">
                                                            <i class="fas fa-building mr-1"></i>{{ $depSiglas ?? $depNombre }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>

                                                {{-- Sentido --}}
                                                <td class="text-nowrap">
                                                    <span class="pill {{ $sentidoClas }}" title="Sentido: {{ $sentidoTxt }}">
                                                        <i class="fas {{ $sentidoIcon }}" aria-hidden="true"></i>
                                                        <span class="pill-text">{{ $sentidoTxt }}</span>
                                                    </span>
                                                </td>

                                                {{-- Desempeño --}}
                                                <td>
                                                    <a href="#"
                                                        onclick="mostrarDesempenoHistorico({{ $indicador->idIndicador }}, '{{ $color }}', '{{ addslashes($indicador->indicadorNombre) }}')"
                                                        title="Ver desempeño histórico por año"
                                                        class="desempeno-link d-block text-reset text-decoration-none p-2 rounded">


                                                        @if(!is_null($pct))
                                                            <div class="progress" style="height:14px;background:#eee;">
                                                                <div class="progress-bar" role="progressbar"
                                                                    style="width: {{ min(100, $pct) }}%; background-color: {{ $color }};"
                                                                    aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                            <small class="text-muted d-block mt-1">
                                                                <b>{{ number_format($pct, 2) }}%</b>
                                                                @if(!empty($etiquetaPeriodo))
                                                                    ({{ $etiquetaPeriodo }})
                                                                @endif
                                                            </small>
                                                        @else
                                                            <span class="text-muted">Sin datos</span>
                                                        @endif
                                                    </a>
                                                </td>

                                                {{-- Acciones --}}
                                                <td class="text-right">
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-sm btn-primary" title="Ver comportamiento"
                                                            onclick="getDatas({{ $indicador->idIndicador }}, '{{ addslashes($indicador->indicadorNombre) }}')">
                                                            <i class="fas fa-chart-line"></i> Ver
                                                        </button>

                                                        <button class="btn btn-sm btn-success" title="Ficha técnica"
                                                            onclick="detallesIndicador({{ $indicador->idIndicador }})">
                                                            <i class="fas fa-info"></i> Ficha
                                                        </button>

                                                        @auth
                                                            @if (auth()->user()->hasRole('administrador') || auth()->user()->hasRole('consulta'))
                                                                <a class="btn btn-sm btn-dark" target="_blank"
                                                                    href="{{ url('/indicador/admindownload/' . $indicador->idIndicador) }}"
                                                                    title="Descargar PDF">
                                                                    <i class="fas fa-file-pdf"></i> PDF
                                                                </a>
                                                            @endif
                                                        @endauth
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="py-5 text-center">
                                <h2>No existen indicadores registrados</h2>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none" id="comportamientohistorico">
        <div class="row">
            <div class="col-lg-12 mb-3 d-flex justify-content-end align-items-center gap-8">
                <button class="btn btn-outline-success btn-action" onclick="detallesIndicador(idIndicadorg)"
                    title="Ver ficha técnica del indicador">
                    <i class="fas fa-info-circle"></i>
                    <span>Ficha técnica</span>
                </button>

                @auth
                    @if (auth()->user()->hasRole('administrador') || auth()->user()->hasRole('consulta'))
                        <form target="_blank" action="" method="GET" id="formDownload" class="m-0">
                            <button class="btn btn-outline-dark btn-action" type="submit" title="Descargar PDF">
                                <i class="fas fa-file-pdf"></i>
                                <span>Descargar PDF</span>
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <!-- Pendientes IE -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color: #681b2e">
                        <h6 class="m-0 font-weight-bold text-primary" style="color: white!important">Comportamiento
                            Histórico</h6>
                    </div>
                    <div class="card-body">
                        <center style="padding: 30px;" id="canvas">

                        </center>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <!-- Pendientes IE -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color: #681b2e">
                        <h6 class="m-0 font-weight-bold text-primary" style="color: white!important">Comportamiento Actual
                        </h6>
                    </div>
                    <div class="card-body">
                        <center style="padding: 30px;" id="actuales">


                        </center>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <!-- Pendientes IE -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color: #681b2e">
                        <h6 class="m-0 font-weight-bold text-primary" style="color: white!important">Metas Históricas
                        </h6>
                    </div>
                    <div class="card-body">
                        <center style="padding: 30px;" id="historicos_content">

                        </center>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 mb-4">
                <!-- Pendientes IE -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3" style="background-color: #681b2e">
                        <h6 class="m-0 font-weight-bold text-primary" style="color: white!important">Metas Programadas
                        </h6>
                    </div>
                    <div class="card-body">
                        <center style="padding: 30px;" id="programados_content">

                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Desempeño Histórico -->
    <div class="modal fade" id="modalDesempeno" tabindex="-1" role="dialog" aria-labelledby="modalDesempenoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background:#681b2e;">
                    <h5 class="modal-title text-white" id="modalDesempenoLabel">Desempeño histórico</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="desempeno_loader" class="text-center text-muted my-3" style="display:none;">
                        <i class="fas fa-spinner fa-spin"></i> Cargando…
                    </div>
                    <div id="desempeno_content"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .indicador:hover {
            color: black;
            background-color: ;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('resources/js/demo/chart-indicador.js') }}"></script>
    <script>
        var idIndicadorg = 0;
        $(document).ready(function () {

            $("#collapseTwo").addClass("show");
            $("#menuIndicadores").addClass("active");
            $("#optindicadorreportes").css('background-color', "rgb(217, 217, 217)");
            //getIndicadoresByFiltro();
        });

        function getDatas(idIndicador, nombreIndicador) {
            $("#canvas").html('<canvas id="chart' + idIndicador + '"></canvas>');
            $("#actuales").html('<canvas id="actuales' + idIndicador + '"></canvas>');
            $("#indicadores").hide('slow');
            $("#indicadorTitulo").html("<b>Indicador: </b>" + nombreIndicador);
            $("#regresar").show('slow');
            setTimeout(function () {
                showHistoricos('chart' + idIndicador);
            }, 500)
            setTimeout(function () {
                showActuales('actuales' + idIndicador);
                $("#comportamientohistorico").show('slow');
            }, 500)
            idIndicadorg = idIndicador;
            $("#idDownload").val(idIndicadorg);
            $("#formDownload").prop("action", "/indicador/admindownload/" + idIndicadorg);
        }

        function returnIndicadores() {
            $("#indicadorTitulo").html("");
            $("#comportamientohistorico").hide('slow');
            $("#indicadores").show('slow');
            $("#regresar").hide('slow');

        }
        function initIndicadoresDataTable() {
            if (!$.fn.DataTable) return;

            if ($.fn.DataTable.isDataTable('#tablaIndicadores')) {
                $('#tablaIndicadores').DataTable().destroy();
            }

            $('#tablaIndicadores').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [[0, 'asc']], // Orden por ID 
                language: { url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json' },
                dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" + "tip" // arriba: length+filter | abajo: table+info+pagination
            });
        }

        $(document).ready(function () {
            initIndicadoresDataTable();
        });

        function getIndicadoresByFiltro() {
            const eje = $("#poreje").val();
            const dependencia = $("#pordependencia").val();
            const sector = $("#porsector").val();

            if ($.fn.DataTable && $.fn.DataTable.isDataTable('#tablaIndicadores')) {
                $('#tablaIndicadores').DataTable().destroy();
            }

            $.ajax({
                type: 'GET',
                url: '{{ route('admin.indicadores.filtros') }}',
                data: { eje, dependencia, sector },
                beforeSend: function () { block(true); }
            })
                .done(function (response) {
                    block(false);
                    $("#indicadoresContent").html(response);

                    initIndicadoresDataTable();

                    if ($.fn.tooltip) $('[data-toggle="tooltip"]').tooltip();
                })
                .fail(function () {
                    block(false);
                });
        }


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
                beforeSend: function () {
                    $("#generalModal .modal-body").html(
                        '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>');
                }
            }).done(function (response) {
                $("#generalModal .modal-body").html(response).animate("slow");
            }).fail(function (data) {

            })
        }

        function mostrarDesempenoHistorico(idIndicador, color = '#666', nombreIndicador = '') {
            // Abre modal y limpia
            $('#modalDesempeno').modal('show');
            $('#desempeno_content').empty();
            $('#desempeno_loader').show();

            if (nombreIndicador) {
                $('#modalDesempenoLabel').html(
                    'Desempeño histórico – <span style="font-weight:normal;">[' + idIndicador + '] ' + nombreIndicador + '</span>'
                );
            } else {
                $('#modalDesempenoLabel').html(
                    'Desempeño histórico – <span style="font-weight:normal;">[' + idIndicador + ']</span>'
                );
            }

            $.get('/indicador/valores/programados', { idIndicador: idIndicador })
                .done(function (resp) {
                    const rows = Array.isArray(resp.programados) ? resp.programados : [];

                    if (!rows.length) {
                        $('#desempeno_content').html('<div class="text-muted">Sin datos históricos.</div>');
                        return;
                    }

                    const rank = {
                        'Anual': 100,
                        'Semestral 2': 92, 'Semestral 1': 91,
                        'Trimestral 4': 84, 'Trimestral 3': 83, 'Trimestral 2': 82, 'Trimestral 1': 81,
                        'Mensual 12': 72, 'Mensual 11': 71, 'Mensual 10': 70, 'Mensual 9': 69, 'Mensual 8': 68, 'Mensual 7': 67,
                        'Mensual 6': 66, 'Mensual 5': 65, 'Mensual 4': 64, 'Mensual 3': 63, 'Mensual 2': 62, 'Mensual 1': 61
                    };

                    const porAnio = {};
                    rows.forEach(r => {
                        const anio = parseInt(r.valoresAnioMedicion, 10);
                        const ciclo = String(r.valoresCicloMedicion || '');
                        const prog = parseFloat(r.valoresProgramado ?? 0);
                        const real = parseFloat(r.valoresReal ?? 0);

                        if (!(prog > 0)) return;

                        const pctRaw = (real / prog) * 100;
                        const weight = (rank[ciclo] ?? 0);

                        if (!porAnio[anio] || weight > porAnio[anio]._w) {
                            porAnio[anio] = { anio, ciclo, programado: prog, real, pctRaw, _w: weight };
                        }
                    });

                    const items = Object.values(porAnio).sort((a, b) => b.anio - a.anio);

                    if (!items.length) {
                        $('#desempeno_content').html('<div class="text-muted">Sin datos históricos consolidados por año.</div>');
                        return;
                    }

                    let html = '<div class="list-group">';
                    items.forEach(it => {
                        const pctDisplay = it.pctRaw != null ? it.pctRaw : 0;
                        const pctBar = Math.max(0, Math.min(100, pctDisplay));
                        html += `
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <div><strong>${it.anio}</strong> <span class="text-muted">(${it.ciclo})</span></div>
                                            <div><strong>${pctDisplay.toFixed(2)}%</strong></div>
                                        </div>
                                        <div class="progress" style="height:14px;background:#eee;">
                                            <div class="progress-bar" role="progressbar"
                                                style="width:${pctBar}%; background-color:${color};"
                                                aria-valuenow="${pctDisplay.toFixed(2)}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted d-block mt-1">
                                            Programado: ${it.programado} &nbsp;|&nbsp; Alcanzado: ${it.real}
                                        </small>
                                    </div>
                                `;
                    });
                    html += '</div>';

                    $('#desempeno_content').html(html);
                })
                .fail(function () {
                    $('#desempeno_content').html('<div class="text-danger">No se pudo cargar el desempeño histórico.</div>');
                })
                .always(function () {
                    $('#desempeno_loader').hide();
                });
        }



    </script>
@endsection
<style>
    #tablaIndicadores td,
    #tablaIndicadores th {
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background: #f7f7fb;
    }


    .badge-dark {
        background: #343a40;
    }

    /* Imagen del indicador más grande con borde del color del Eje */
    .indicador-cell .indicador-thumb {
        width: 56px;
        height: 56px;
        min-width: 56px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 2px solid;
        border-radius: 14px;
        background: #fff;
    }

    .indicador-img {
        width: 44px;
        height: 44px;
        object-fit: contain;
    }

    /* Estilos de la columa dependencia */
    .dep-pill {
        display: inline-block;
        padding: .25rem .6rem;
        border-radius: 999px;
        background: color-mix(in srgb, var(--dep-bg, #6c757d) 15%, #fff);
        border: 1px solid color-mix(in srgb, var(--dep-bg, #6c757d) 40%, #fff);
        color: #2c2c2c;
        font-weight: 500;
    }

    @supports not (color: color-mix(in srgb, #000 10%, #fff)) {
        .dep-pill {
            background: #f1f3f5;
            border-color: #dee2e6;
        }
    }

    /* Píldora sobria */
    .pill {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .25rem .6rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: .85rem;
        letter-spacing: .2px;
        border: 1px solid transparent;
        line-height: 1;
    }

    /* Estilos del sentido */
    .pill i {
        font-size: .9rem;
    }

    .pill-asc,
    .pill-desc {
        background: #f3f4f6;
        /* gris claro */
        color: #374151;
        /* gris oscuro */
        border-color: #e5e7eb;
        /* borde gris */
    }

    .pill-neutral {
        background: #f3f4f6;
        color: #374151;
        border-color: #e5e7eb;
    }


    .desempeno-link {
        transition: background-color 0.2s ease, color 0.2s ease;
        cursor: pointer;
    }

    /* Efefcto al pasar el cursor*/
    .desempeno-link {
        transition: background-color 0.2s ease;
        cursor: pointer;
    }

    .desempeno-link:hover {
        background-color: rgba(0, 0, 0, 0.04);
        /* fondo suave */
    }

    .desempeno-link .progress-bar {
        transition: filter 0.3s ease;
    }

    .desempeno-link:hover .progress-bar {
        filter: brightness(0.9) saturate(1.3);
        /* intensifica la barra */
    }

    /* Estilos para las tablas */
    .table-wrap {
        width: 100%;
        overflow-x: auto;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }

    .table-elegant {
        border-collapse: collapse;
        width: 100%;
        font-size: 0.9rem;
    }

    .table-elegant thead th {
        background: #eef2f7;
        color: #1e293b;
        font-weight: 700;
        padding: 10px 14px;
        text-align: left;
    }

    .table-elegant tbody td {
        padding: 10px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #111827;
    }

    .table-elegant tbody tr {
        transition: all 0.2s ease;
    }

    .table-elegant tbody tr:hover {
        background: #f9fafb;
        box-shadow: inset 4px 0 0 #3b82f6;
        /* línea azul izquierda */
    }
</style>