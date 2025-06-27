<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Tecnica del Indicador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 5px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 10px;
            margin-top: 0px;
        }

        h1,
        h2 {
            text-align: center;
            font-weight: bold;
            margin-top: 0px;
        }

        h1 {
            font-size: 16px;
            color: #8a1538;
        }

        h2 {
            font-size: 16px;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0px;
        }

        th,
        td {
            padding: 10px;
            border: 0.5px solid #e1d3c2;
            text-align: left;
            table-layout: fixed
        }

        td {
            background-color: white;
        }

        /* Asegura que las celdas vacías tengan fondo blanco */
        .bg-red {
            background-color: #9c244c;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .bg-gold {
            background-color: #b28e5c;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .bg-custom {
            background-color: #efe9dd;
            color: black;
        }

        .firma {
            padding: 30px;
            height: 80px;
        }

        .section-title {
            background-color: #D8C3A5;
            font-weight: bold;
            border: 1px solid #B08D57;
        }

        .section-header {
            background-color: #9c244c;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .centered {
            text-align: center;
        }

        .section-filas {
            background-color: #b28e5c;
            font-weight: bold;
            border: 1px solid #b28e5c;
            width: 100%;
        }

        .wide-col {
            width: 50%;
        }

        .medium-col {
            width: 30%;
        }

        .small-col {
            width: 20%;
        }

        .full-width {
            width: 100%;
        }

        .no-border {
            border: none;
        }

        .white-bg {
            background-color: white;
        }

        .custom-title {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            color: #9c244c;
        }

        .custom-title-md {
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            color: #000000;
            margin-top: 0px
        }

        .first-column {
            width: 25%;
        }

        .second-column {
            width: 75%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 class="custom-title ">
                INDICADORES DE PRODUCTO DE LOS PLANES ESTRATÉGICOS SECTORIALES Y PLANES ESPECIALES
            </h1>
            <h2 class="custom-title-md">
                FICHA TÉCNICA DEL INDICADOR
            </h2>

        </div>

        <table>
            <!-- Datos Generales -->
            <tr>
                <th class="bg-gold first-column">Producto PES/PE</th>
                <th class="second-column">
                    {{ $producto->producto ?? 'No Disponible' }}
                </th>
            </tr>
            <tr>
                <th class="bg-gold first-column">Responsable</th>
                <th class="second-column">
                    {{ $dependenciaUsuario->dependenciaNombre ?? 'No asignado' }}
                </th>
            </tr>

            <br>

            <!-- Alineación -->
            <tr>
                <th colspan="2" class="bg-gold">1. Alineación</th>
            </tr>
            <tr>
                <td colspan="2" class="bg-gold">1.1 PED 2022-2028</td>
            </tr>
            <tr class="bg-custom">
                <td>1.1.1 Eje</td>
                <td class="white-bg">
                    @if (count($ejes))
                        <ul style="margin: 0; padding-left: 18px;">
                            @foreach ($ejes as $eje)
                                <li>{{ $eje }}</li>
                            @endforeach
                        </ul>
                    @else
                        No disponible
                    @endif
                </td>
            </tr>

            <tr class="bg-custom">
                <td>1.1.2 Tema</td>
                <td class="white-bg">
                    @if (count($temas))
                        <ul style="margin: 0; padding-left: 18px;">
                            @foreach ($temas as $tema)
                                <li>{{ $tema }}</li>
                            @endforeach
                        </ul>
                    @else
                        No disponible
                    @endif
                </td>
            </tr>

            <tr class="bg-custom">
                <td>1.1.3 Objetivo</td>
                <td class="white-bg">
                    @if (count($objetivosPed))
                        <ul style="margin: 0; padding-left: 18px;">
                            @foreach ($objetivosPed as $objetivo)
                                <li>{{ $objetivo }}</li>
                            @endforeach
                        </ul>
                    @else
                        No disponible
                    @endif
                </td>
            </tr>

            <tr class="bg-custom">
                <td>1.1.4 Estrategia</td>
                <td class="white-bg">
                    @if (count($estrategiasPed))
                        <ul style="margin: 0; padding-left: 18px;">
                            @foreach ($estrategiasPed as $estrategia)
                                <li>{{ $estrategia }}</li>
                            @endforeach
                        </ul>
                    @else
                        No disponible
                    @endif
                </td>
            </tr>


            <tr class="bg-custom">
                <td>1.1.5 Línea de acción</td>
                <td class="white-bg">
                    @if(count($lineasAccion))
                        <ul style="margin-bottom: 0;">
                            @foreach($lineasAccion as $la)
                                <li>{{ $la->laPEDClave }} - {{ $la->laPEDDescripcion }}</li>
                            @endforeach
                        </ul>
                    @else
                        No hay Lineas de acción registradas.
                    @endif
                </td>
            </tr>


            <tr>
                <td colspan="2" class="bg-gold">1.2 Sector</td>
            </tr>
            <tr>
                <td class="bg-custom">1.2 Sector</td>
                <td class="white-bg ">{{ $producto->sector_nombre ?? 'No disponible' }}</td>
            </tr>
            <tr class="bg-custom">
                <td>1.2.1 Objetivo</td>
                <td class="white-bg">{{ $producto->objetivo_sector ?? 'No disponible' }}</td>
            </tr>
            <tr class="bg-custom">
                <td>1.2.2 Estrategia</td>
                <td class="white-bg"> {{ $producto->estrategia_sector ?? 'No disponible' }}</td>
            </tr>
            <!--- Prograa presupuestario-->

            <tr>
                <th colspan="4" class="bg-gold" style="text-align: center;">1.3 Programa presupuestario</th>
            </tr>

            <!-- Encabezado de columnas -->
            <tr class="section-title">
                <th style="width: 15%;">Año</th>
                <th style="width: 40%;">Programa</th>
                <th style="width: 22.5%;">Componente</th>
                <th style="width: 22.5%;">Actividad</th>
            </tr>

            @php
                $programasPorAnio = $programas->groupBy('anio');
            @endphp

            @forelse($programasPorAnio as $anio => $programasAnio)
                @foreach($programasAnio as $programa)
                    <tr>
                        <td class="bg-custom" style="border: 1px solid #B08D57; ">{{ $programa->anio }}</td>
                        <td style="border: 1px solid #B08D57; ; word-wrap: break-word; white-space: normal;">
                            {{ $programa->clavePrograma }} - {{ $programa->descripcionPrograma }}
                        </td>
                        <td style="border: 1px solid #B08D57; ">{{ $programa->componente }}</td>
                        <td style="border: 1px solid #B08D57; ">{{ $programa->actividad }}</td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; font-size: 10px; border: 1px solid #B08D57;">
                        No hay programas presupuestarios registrados.
                    </td>
                </tr>
            @endforelse


            <!-- PPA -->
            <tr>
                <td colspan="4" class="bg-gold">1.4 Programa, Proyecto o Acción</td>
            </tr>
            <tr class="bg-custom">
                <td style="width: 25%">1.4.1 Nombre de PPA</td>
                <td style="width:75%" class="white-bg">
                    @if(count($ppasSeleccionados))
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($ppasSeleccionados as $ppa)
                                <li style="margin-bottom: 3px;">{{ $ppa->nombre }}</li>
                            @endforeach
                        </ul>
                    @else
                        No hay PPAs registrados.
                    @endif
                </td>
            </tr>
            <tr class="bg-custom">
                <td>1.4.2 Bien o servicio</td>
                <td class="white-bg">
                    @if (count($bienesServicios))
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach ($bienesServicios as $bs)
                                <li style="margin-bottom: 3px;">{{ $bs->nombreBS }}</li>
                            @endforeach
                        </ul>
                    @else
                        No hay bienes o servicios registrados.
                    @endif
                </td>
            </tr>

            <!-- Datos del Indicador -->
            <tr>
                <th colspan="2" class="bg-gold">2. Datos del Indicador</th>
            </tr>

            @if ($indicador)
                <tr>
                    <td class="bg-custom">2.1 Nombre del Indicador</td>
                    <td class="white-bg">{{ $indicador->nombreIndicador ?? '' }}</td>
                </tr>
                <tr class="bg-custom">
                    <td>2.2 Tipo</td>
                    <td class="white-bg">{{ ucfirst($indicador->tipo ?? '') }}</td>
                </tr>
                <tr class="bg-custom">
                    <td>2.3 Método de cálculo</td>
                    <td class="white-bg">{{ ucfirst($indicador->metodo_calculo ?? '') }}</td>
                </tr>
                <tr class="bg-custom">
                    <td>2.4 Frecuencia de medición</td>
                    <td class="white-bg">{{ ucfirst($indicador->frecuencia_medicion ?? '') }}</td>
                </tr>
                <tr class="bg-custom">
                    <td>2.5 Sentido esperado</td>
                    <td class="white-bg">{{ ucfirst($indicador->sentido_esperado ?? '') }}</td>
                </tr>
                <tr class="bg-custom">
                    <td>2.6 Unidad de medida Producto</td>
                    <td class="white-bg">{{ $indicador->unidad_medida_producto ?? '' }}</td>
                </tr>
                <tr class="bg-custom">
                    <td>2.7 Unidad de medida Indicador</td>
                    <td class="white-bg">{{ucfirst($indicador->unidad_medida_indicador ?? '') }}</td>
                </tr>
                <tr class="bg-custom">
                    <td>2.8 Medio de verificación</td>
                    <td class="white-bg">{{ $indicador->medio_verificacion_indicador ?? '' }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="2" style="text-align: center; background-color: #f9f9f9;">
                        No se ha capturado información del indicador.
                    </td>
                </tr>
            @endif



            <!-- Seguimiento de metas -->

            <tr>
                <th colspan="2" class="bg-gold">3. Seguimiento de metas 2023-2028</th>
            </tr>
            <tr class="section-title">
                <th style="width: 25%;">Concepto / Año</th>
                <th style="width: 12.5%; text-align: center;">2023</th>
                <th style="width: 12.5%; text-align: center;">2024</th>
                <th style="width: 12.5%; text-align: center;">2025</th>
                <th style="width: 12.5%; text-align: center;">2026</th>
                <th style="width: 12.5%; text-align: center;">2027</th>
                <th style="width: 12.5%; text-align: center;">2028</th>
            </tr>

            @php
                // Años esperados
                $anios = ['2023', '2024', '2025', '2026', '2027', '2028'];

                // Organiza datos por tipo
                $valores = [
                    'programado' => [],
                    'realizado' => [],
                    'valor_indicador' => [],
                ];

                foreach ($seguimientos as $meta) {
                    $anio = $meta->año;
                    $valores['programado'][$anio] = $meta->programado;
                    $valores['realizado'][$anio] = $meta->realizado;
                    $valores['valor_indicador'][$anio] = $meta->valor_indicador;
                }
            @endphp

            <tr style="border: 1px solid #B08D57;">
                <td class="bg-custom">Programado</td>
                @foreach ($anios as $anio)
                    <td style="text-align: center">
                        {{ isset($valores['programado'][$anio]) ? number_format($valores['programado'][$anio], 2) : '' }}
                    </td>
                @endforeach
            </tr>
            <tr style="border: 1px solid #B08D57;">
                <td class="bg-custom">Realizado</td>
                @foreach ($anios as $anio)
                    <td style="text-align: center">
                        {{ isset($valores['realizado'][$anio]) ? number_format($valores['realizado'][$anio], 2) : '' }}
                    </td>
                @endforeach
            </tr>
            <tr class="section-title">
                <th>Valor indicador</th>
                @foreach ($anios as $anio)
                    <th style="text-align: center">
                        @if (isset($valores['valor_indicador'][$anio]) && is_numeric($valores['valor_indicador'][$anio]))
                            {{ round($valores['valor_indicador'][$anio] * 100,2) }}%
                        @else
                            -
                        @endif
                    </th>
                @endforeach
            </tr>


            <!-- Medios de verificación -->
            <tr>
                <th colspan="3" class="bg-gold full-width">4. Medios de verificación</th>
            </tr>
            <tr class="section-title">
                <th style="width: 15%;">Año</th>
                <th style="width: 40%;">Descripción</th>
                <th style="width: 45%;">Link de descarga</th>
            </tr>

            @forelse ($mediosVerificacion->sortBy('anio') as $medio)
                <tr>
                    <td class="bg-custom">{{ $medio->anio }}</td>
                    <td class="white-bg">{{ $medio->descripcion }}</td>
                    <td class="white-bg">
                        @if ($medio->rutaArchivo)
                            <a href="{{ asset($medio->rutaArchivo) }}" target="_blank">
                                {{ $medio->nombreArchivo ?? 'Descargar archivo' }}
                            </a>
                        @else
                            No disponible
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="white-bg" style="text-align: center;">
                        No hay medios de verificación registrados.
                    </td>
                </tr>
            @endforelse


        </table>
        <table>
            <thead>
                <tr>
                    <th class="bg-gold" colspan="4">5. Datos de los Responsables de la Información</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="bg-custom">5.1 Nombre de la dependencia</td>
                    <td colspan="3">
                        @if ($dependenciaUsuario)
                            {{ $dependenciaUsuario->dependenciaNombre }} ({{ $dependenciaUsuario->dependenciaSiglas }})
                        @else
                            No disponible
                        @endif
                    </td>
                </tr>

                <tr class="bg-custom">
                    <td colspan="2">5.2 Datos del Titular de la Dependencia</td>
                    <td colspan="2">5.3 Datos del Enlace Directivo</td>
                </tr>

                <tr>
                    <td style="width: 15%;" class="bg-custom">5.2.1 Nombre:</td>
                    <td style="width: 35%;">
                        {{ $titular && $titular->nombre ? $titular->nombre : 'No disponible' }}
                    </td>

                    <td style="width: 15%;" class="bg-custom">5.3.1 Nombre:</td>
                    <td style="width: 35%;">
                        @if ($enlace)
                            {{ trim("{$enlace->titulo} {$enlace->nombre} {$enlace->apellidoP} {$enlace->apellidoM}") }}
                        @else
                            No disponible
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="bg-custom">5.2.2 Cargo:</td>
                    <td>{{ $titular && $titular->cargo ? $titular->cargo : 'No disponible' }}</td>

                    <td class="bg-custom">5.3.2 Cargo:</td>
                    <td>{{ $enlace && $enlace->cargo ? $enlace->cargo : 'No disponible' }}</td>
                </tr>

                <tr>
                    <td class="bg-custom firma">5.2.3 Firma</td>
                    <td class="firma">&nbsp;</td>
                    <td class="bg-custom firma">5.3.3 Firma</td>
                    <td class="firma">&nbsp;</td>
                </tr>

                <tr>
                    <td style="width: 35%" class="bg-custom">5.4 Fecha de actualización</td>
                    <td style="width: 65%">
                        {{ $fechaActualizacion ?? now()->format('Y-m-d H:i:s') }}
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</body>

</html>