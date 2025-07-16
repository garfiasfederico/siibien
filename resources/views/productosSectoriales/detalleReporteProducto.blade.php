@extends('layouts.administrador')

@section('encabezado')
    Productos Sectoriales / Reportes de Información

    @php
        $ruta = auth()->user()->hasRole('administrador') || auth()->user()->hasRole('administrador_pes')
            ? route('productossectoriales.admin')
            : route('productossectoriales.index');
    @endphp
    <a href="{{ $ruta }}">
        <button class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> <i class="fas fa-home"></i> Productos Sectoriales
        </button>
    </a>
@endsection

@section('styles')
    <style>
        :root {
            --color-principal: #7c2f42;
            --color-secundario: #c5c5c5;
            --color-claro: #ececec;
            --color-resaltado: #ffc3c3;
            --texto-oscuro: black;
            --texto-claro: white;
            --borde: white;
            --fondo-dropzone: #fafff3;
        }

        .enc1 {
            padding: 5px !important;
            background-color: var(--color-secundario);
            color: var(--texto-claro);
        }

        .enc2 {
            padding: 5px !important;
            background-color: var(--color-principal);
            color: var(--texto-claro);
        }

        .resp {
            font-weight: bold;
        }

        .enc3 {
            background-color: var(--color-claro);
            font-weight: bold;
        }

        input[type=text],
        select,
        textarea {
            height: 35px;
            color: var(--texto-oscuro);
        }

        table tr td {
            padding: 5px;
            border: solid 2px var(--borde);
        }

        .invalid-feedback {
            width: 100%;
            background-color: var(--color-resaltado);
            color: gray;
            border-radius: 5px;
            text-align: center;
            padding: 10px;
            border: solid 1px red;
        }



        .bss div:hover {
            background-color: black;
            color: white;
        }

        .enc4 {
            background-color: black;
            color: white;
        }

        .enc5 {
            background-color: #f3d5db;
            color: black;
            width: 15%;
            font-weight: bold;
        }

        .enc6 {
            background-color: var(--color-claro);
            color: black;
        }

        .enc7 {
            background-color: rgb(157, 36, 73);
            color: white;
            width: 15%;
            font-weight: bold;
            text-align: center;
        }

        .header-custom {
            background-color: var(--color-principal);
            color: white !important;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    @if (isset($producto))
        <h4 class="alert alert-warning" style="background-color: #681b2e; color: white">
            {{ $producto->idProducto . ' ' . $producto->producto }}
        </h4>
    @else
        <h4 class="alert alert-warning" style="background-color: #681b2e; color: white">
            Repirtes de Información[Producto no encontrado]
        </h4>
        <input type="hidden" id="idPPA" value="">
    @endif
    <input type="hidden" id="idPPA" value="">
    <div style="margin: 10px;text-align:right">
        <a href="{{ route('producto.reporte', ['id' => $producto->idProducto]) }}" class="btn btn-success" target="_blank">
            <i class="fas fa-chart-bar"></i> Descargar Reporte General
        </a>

        <button id="btnInfoGral" class="btn btn-primary" onclick="showGenerales()" style="display: none"><i
                class="fas fa-list"></i> Información General</button>
    </div>
    <!-- Alineacion -->
    <div class="row" id="infoGral">
        <div class="col-xl-6 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between header-custom">
                    <h6 class="m-0 font-weight-bold" style="cursor: pointer"
                        onclick="toggle('chevAlineacion','body-Alineacion')">
                        Alineación <i class="fas fa-chevron-down" id="chevAlineacion"></i>
                    </h6>
                </div>
                <div class="card-body" id="body-Alineacion">
                    <table style="width: 100%">
                        <tr>
                            <td class="enc5">Eje:</td>
                            <td class="enc6" colspan="3">
                                @if (count($ejes))
                                    <ul>
                                        @foreach ($ejes as $eje)
                                            <li>{{ $eje }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    No disponible
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="enc5">Tema:</td>
                            <td class="enc6" colspan="3">
                                @if (count($temas))
                                    <ul>
                                        @foreach ($temas as $tema)
                                            <li>{{ $tema }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    No disponible
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="enc5">Objetivo:</td>
                            <td class="enc6" colspan="3">
                                @if (count($objetivosPed))
                                    <ul>
                                        @foreach ($objetivosPed as $objetivo)
                                            <li>{{ $objetivo }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    No disponible
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="enc5">Estrategias:</td>
                            <td class="enc6" colspan="3">
                                @if (count($estrategiasPed))
                                    <ul>
                                        @foreach ($estrategiasPed as $estrategia)
                                            <li>{{ $estrategia }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    No disponible
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td class="enc5">Línea de Acción:</td>
                            <td class="enc6" colspan="3">
                                @if(count($lineasAccion))
                                    <ul>
                                        @foreach($lineasAccion as $la)
                                            <li>{{ $la->laPEDClave }} - {{ $la->laPEDDescripcion }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No hay líneas de acción registradas.</p>
                                @endif
                            </td>

                        </tr>
                        <tr>
                            <td class="enc7" colspan="4">Sector</td>
                        </tr>
                        <tr>
                            <td class="enc5">Sector:</td>
                            <td class="enc6">{{ $producto->sector_nombre ?? 'No disponible' }}</td>
                        </tr>
                        <tr>
                            <td class="enc5">Objetivo:</td>
                            <td class="enc6" colspan="3">{{ $producto->objetivo_sector ?? 'No disponible' }}</td>
                        </tr>
                        <tr>
                            <td class="enc5">Estrategias:</td>
                            <td class="enc6" colspan="3">{{ $producto->estrategia_sector ?? 'No disponible' }}</td>
                        </tr>
                        <tr>
                            <td class="enc7" colspan="4">Programa, Proyecto o Acción</td>
                        </tr>
                        <tr>
                            <td class="enc5">Nombre del PPA:</td>
                            <td class="enc6">
                                @if (count($ppasSeleccionados))
                                    <ul>
                                        @foreach ($ppasSeleccionados as $ppa)
                                            <li>{{ $ppa->nombre }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    No hay PPAs registrados.
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="enc5">Bienes o servicios</td>
                            <td class="enc6">
                                @if (count($bienesServicios))
                                    <ul>
                                        @foreach ($bienesServicios as $bs)
                                            <li>{{ $bs->nombreBS }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    No hay bienes o servicios registrados.
                                @endif
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
        <!-- Datos del Indicador -->
        <div class="col-xl-6 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between header-custom">
                    <h6 class="m-0 font-weight-bold" style="cursor: pointer"
                        onclick="toggle('chevindicador','body-indicador')">
                        Datos del Indicador <i class="fas fa-chevron-down" id="chevindicador"></i>
                    </h6>
                </div>
                <div class="card-body" id="body-indicador">
                    @if (!$indicador)
                        <p class="enc6">No se ha capturado información del indicador.</p>
                    @else
                        <table style="width: 100%">
                            <tr>
                                <td class="enc7" colspan="4">Datos del Indicador</td>
                            </tr>
                            <tr>
                                <td class="enc5" style="width: 45%">Nombre del Indicador</td>
                                <td class="enc6">{{ $indicador->nombreIndicador ?? 'No disponible' }}</td>
                            </tr>
                            <tr>
                                <td class="enc5" style="width: 45%"> Tipo</td>
                                <td class="enc6">{{ ucfirst($indicador->tipo ?? 'No especificado') }}</td>
                            </tr>
                            <tr>
                                <td class="enc5" style="45%">Metodo de Calculo</td>
                                <td class="enc6">{{ ucfirst($indicador->metodo_calculo ?? 'No Disponible') }}</td>

                            </tr>

                            <tr>
                                <td class="enc5" style="45%">Frecuenncia de Medición</td>
                                <td class="enc6">{{ ucfirst($indicador->frecuencia_medicion ?? 'No disponible') }}</td>
                            </tr>
                            <tr>
                                <td class="enc5" style="45%">Sentido Esperado</td>
                                <td class="enc6">{{ ucfirst($indicador->sentido_esperado ?? 'No disponible') }}</td>
                            </tr>
                            <tr>
                                <td class="enc5" style="40%">Unidad de medida Producto</td>
                                <td class="enc6">{{ $indicador->unidad_medida_producto ?? 'No disponible  ' }}</td>
                            </tr>
                            <tr>
                                <td class="enc5" style="45%">Unidad de Medida Indicador</td>
                                <td class="enc6">{{ ucfirst($indicador->unidad_medida_indicador) }}</td>
                            </tr>
                            <tr>
                                <td class="enc5" style="45%">Medio de Verificación</td>
                                <td class="enc6">{{ $indicador->medio_verificacion_indicador }}</td>
                            </tr>
                        </table>
                    @endif

                </div>
            </div>
        </div>

        <!-- Programa Presupuestario -->
        <div class="col-xl-6 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between header-custom">
                    <h6 class="m-0 font-weight-bold" style="cursor: pointer"
                        onclick="toggle('chevppresupuestario','body-ppresupuestario')">
                        Programa Presupuestario
                        <i class="fas fa-chevron-down" id="chevppresupuestario"></i>
                    </h6>
                </div>
                <div class="card-body" id="body-ppresupuestario">

                    <div class="table-responsive">
                        <table class="table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="enc5">Año</th>
                                    <th class="enc5">Programa</th>
                                    <th class="enc5">Componente</th>
                                    <th class="enc5">Actividad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($programas as $programa)
                                    <tr>
                                        <td class="enc6">{{ $programa->anio }}</td>
                                        <td class="enc6">
                                            {{ $programa->clavePrograma }} - {{ $programa->descripcionPrograma }}
                                        </td>
                                        <td class="enc6 ">{{ $programa->componente }}</td>
                                        <td class="enc6 ">{{ $programa->actividad }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="enc6">No hay programas presupuestarios registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seguimeinto de Metas -->
        <div class="col-xl-6 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between header-custom">
                    <h6 class="m-0 font-weight-bold" style="cursor: pointer"
                        onclick="toggle('chevseguimientoMetas','body-seguimientoMetas')">
                        Seguimiento de Metas <i class="fas fa-chevron-down" id="chevseguimientoMetas"></i>
                    </h6>
                </div>
                <div class="card-body" id="body-seguimientoMetas">
                    <table style="width: 100%">
                        <thead>
                            <tr>
                                <td class="enc5">Año</td>
                                <td class="enc5">Programado</td>
                                <td class="enc5">Realizado</td>
                                <td class="enc5">Valor indicado</td>
                                <td class="enc5">Desempeño</td>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $filtrados = $seguimientos->filter(function ($meta) {
                                    return !is_null($meta->programado) || !is_null($meta->realizado) || !is_null($meta->valor_indicador);
                                });
                            @endphp

                            @forelse ($filtrados as $meta)
                                <tr>
                                    <td class="enc6" style="text-align: center">{{ $meta->año }}</td>
                                    <td class="enc6" style="text-align: right">{{ number_format($meta->programado, 2) }}</td>
                                    <td class="enc6" style="text-align: right">{{ number_format($meta->realizado, 2) }}</td>
                                    <td class="enc6" style="text-align: right">
                                        @if (is_numeric($meta->valor_indicador))
                                            {{ round($meta->valor_indicador * 100,2) }} %
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td style="text-align: center" class="enc6">
                                        @php
                                            $color = "gray";
                                            $avance = $meta->valor_indicador * 100;
                                            if($avance>0 && $avance<=25)
                                                $color = "red";
                                            if($avance>25 && $avance<=50)
                                                $color = "orange";
                                            if($avance>50 && $avance<=75)
                                                $color = "yellow";
                                            if($avance>75 && $avance<=95)
                                                $color = "lightgreen";
                                            if($avance>95)
                                                $color = "green";

                                        @endphp
                                            <i class="fa fa-circle" aria-hidden="true" style="color:{{$color}};font-size:1.5em"></i>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="enc6 text-center" colspan="4">No hay seguimiento registrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!--MEDIOS DE VERIFICACION-->
        <div class="col-xl-6 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between header-custom">
                    <h6 class="m-0 font-weight-bold" style="cursor: pointer"
                        onclick="toggle('chevmediosVerificacion','body-mediosVerificacion')">
                        Medios de Verificación <i class="fas fa-chevron-down" id="chevmediosVerificacion"></i>
                    </h6>
                </div>
                <div class="card-body" id="body-mediosVerificacion">
                    <table style="100%">
                        <thead>
                            <tr>
                                <th class="enc5">Año</th>
                                <th class="enc5">Descripción</th>
                                <th class="enc5">Archivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mediosVerificacion as $medio)
                                <tr>
                                    <td class="enc6">{{ $medio->anio }}</td>
                                    <td class="enc6">{{ $medio->descripcion }}</td>
                                    <td class="enc6">
                                        @if ($medio->rutaArchivo)
                                            <a href="{{ asset($medio->rutaArchivo) }}" target="_blank">
                                                {{ $medio->nombreArchivo }}
                                            </a>
                                        @else
                                            No disponible
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center enc6" colspan="3">No hay medios de verificación registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between header-custom">
                    <h6 class="m-0 font-weight-bold" style="cursor: pointer"
                        onclick="toggle('chevseguimientoGrafica','body-seguimientoGrafica')">
                        Progreso de Metas por Año <i class="fas fa-chevron-down" id="chevseguimientoGrafica"></i>
                    </h6>
                </div>
                <div class="card-body" id="body-seguimientoGrafica">
                    <div id="contenedorGraficaMetas" style="display: none;">
                        <canvas id="graficaMetas" height="250"></canvas>
                    </div>

                    <div id="mensajeSinMetas" class="text-center enc6">
                        No se ha registrado seguimiento de metas.
                    </div>


                </div>
            </div>
        </div>

    </div>


@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('scripts')
    <script>
        //Funciones para mostrar y ocultar secciones
        function showSeguimiento() {
            document.getElementById("btnInfoGral").style.display = "";
            document.getElementById("btnSeguimiento").style.display = "none";
            document.getElementById("infoGral").style.display = "none";
            document.getElementById("infoSeguimiento").style.display = "";
        }

        function showGenerales() {
            document.getElementById("btnInfoGral").style.display = "none";
            document.getElementById("btnSeguimiento").style.display = "";
            document.getElementById("infoGral").style.display = "";
            document.getElementById("infoSeguimiento").style.display = "none";
        }

        function toggle(iconId, contentId) {
            const content = document.getElementById(contentId);
            const icon = document.getElementById(iconId);

            const isVisible = window.getComputedStyle(content).display !== "none";

            if (isVisible) {
                content.style.display = "none";
                icon.classList.remove("fa-chevron-down");
                icon.classList.add("fa-chevron-right");
            } else {
                content.style.display = "block";
                icon.classList.remove("fa-chevron-right");
                icon.classList.add("fa-chevron-down");
            }
        }



        //Graficar el seguimiento de Metas
        document.addEventListener('DOMContentLoaded', function () {
            const datos = @json($seguimientos);

            if (datos.length === 0) {
                // Mostrar mensaje y ocultar gráfica
                document.getElementById('mensajeSinMetas').style.display = 'block';
                document.getElementById('contenedorGraficaMetas').style.display = 'none';
                return;
            }

            // Ocultar mensaje, mostrar canvas
            document.getElementById('mensajeSinMetas').style.display = 'none';
            document.getElementById('contenedorGraficaMetas').style.display = 'block';

            const ctx = document.getElementById('graficaMetas').getContext('2d');

            const labels = datos.map(item => item.año);
            const programado = datos.map(item => item.programado);
            const realizado = datos.map(item => item.realizado);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Programado',
                            data: programado,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            tension: 0.3,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            borderWidth: 3
                        },
                        {
                            label: 'Realizado',
                            data: realizado,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            tension: 0.3,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            borderWidth: 3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 13
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Seguimiento de Metas (Programado Y Realizado)',
                            font: {
                                size: 16,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10,
                                bottom: 30
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Valor'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Año'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection