<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        th,
        td {
            padding: 2px;
            font-size: 9px;
            line-height: 1.2;
            border: 1px solid #ffffff;
        }

        .cell {
            height: 22px;
            line-height: 1.3;
            padding-top: 3px;
            padding-bottom: 3px;
        }

        .colorP {
            background-color: #5fb99f;
            font-size: 8px;
            font-weight: normal;
            line-height: 1.1;
            padding: 1px;
        }

        .ctr {
            text-align: center;
        }

        .colorS {
            background-color: #f1f1f1;
        }

        .header {
            margin-bottom: 2px;
        }

        .info-table {
            margin: 0;
        }

        .table-wrapper {
            margin-bottom: 0.1px;
            line-height: 0.1;
        }

        .texto-descriptivo {
            font-family: 'Montserrat', helvetica, sans-serif;
            font-size: 9px;
            text-align: justify;
            margin: 0;
            line-height: 1.2;
        }

        .texto-protesta {
            font-family: 'Montserrat', helvetica, sans-serif;
            font-size: 7pt;
            font-style: italic;
            font-weight: normal;
            line-height: 1.25;
            text-align: justify;
            padding: 3px;
        }

        .tabla-firmas {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-firmas td {
            width: 33.33%;
            padding: 4px;
        }

        .firma-box {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #bdbdbd;
        }

        .firma-header {
            background-color: #5fb99f;
            font-size: 9px;
            font-weight: normal;
            text-align: center;
            padding: 4px;
        }

        .firma-body {
            height: 70px;
            text-align: center;
            font-size: 8px;
            vertical-align: bottom;
            border-bottom: 1px solid #8c8c8c;
        }

        .firma-footer {
            background-color: #e6e6e6;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
            height: 26px;
            line-height: 26px;
            padding: 0;
        }

        .codigo-formato {
            font-family: helvetica, sans-serif;
            font-size: 8pt;
            color: #ad8e65;
            text-align: right;
        }
        .leyenda {
            display: block;
            width: 100%;
            background-color: #f2f4f5;
            color: #333;
            font-family: 'Montserrat', helvetica, sans-serif;
            font-size: 8pt;
            line-height: 1.3;
            text-align: justify;
            border-left: 4px solid #5fb99f;
            padding: 6px 8px;
            box-sizing: border-box;
        }
    </style>
</head>
<div class="codigo-formato">
    F-SIIBIEN-PSE-02
</div>

<body>
    <div class="container">

        <div class="header" style="text-align:center;">
            <span style="font-family:helvetica; font-size:9pt;">
                Formato.
            </span>
            <span style="font-family:helvetica; font-size:11pt; font-weight:bold;">
                NOTIFICACIÓN DE CAPTURA DE PRODUCTOS SECTORIALES /<br> ESPECIALES EN EL SISTEMA
            </span>


        </div><br>
        <div class="table-wrapper">
            <table class="info-table" cellpadding="3">
                <tr>
                    <th style="width: 17%"></th>
                    <th style="width: 17%"></th>
                    <th class="colorP" style="width: 18%">Fecha de descarga del formato</th>
                    <td class="colorS" style="width: 14%">{{ now()->format('d/m/Y') }}</td>
                    <th class="colorP cell" style="width: 12%">Folio de entrega</th>
                    <td class="colorS" style="width: 22%">SIIBIEN-PSE-02-{{ $dependencia->dependenciaSiglas }}-2026</td>
                </tr>
            </table>
        </div>
        <div class="table-wrapper">
            <table class="info-table" cellpadding="3">
                <tr>
                    <th class="colorP">(UR) Dependencia / Entidad responsable</th>
                    <td class="colorS" colspan="3">{{ $dependencia->dependenciaNombre ?? '' }}
                        ({{ $dependencia->dependenciaSiglas }})</td>
                    <th class="colorP">Año de reporte</th>
                    <td class="colorS">{{ $anio }}</td>
                </tr>
            </table>
        </div>
        <div class="table-wrapper">
            <table class="info-table">
                <tr>
                    <th class="texto-descriptivo">En cumplimiento a las disposiciones normativas vigentes, se informa
                        que se ha realizado la
                        captura de
                        las metas
                        alcanzadas de los productos sectoriales /especiales (PSE) en el SIIBIEN, correspondiente al año
                        de
                        reporte
                        solicitado, cumpliendo con los siguientes parámetros:</th>
                </tr>
            </table>
        </div>
        <div class="table-wrapper">
            <table class="info-table" cellpadding="3">
                <tr>
                    <th class="colorP cell">Total de productos programados</th>
                    <td class="colorS">{{ $totalProgramados }}</td>
                    <th class="colorP">Total de productos Cargados</th>
                    <td class="colorS">{{ $totalCargados }}</td>
                    <th class="colorP">Total de archivos adjuntos</th>
                    <td class="colorS">{{ $totalAdjuntos }}</td>
                </tr>
            </table>
        </div>
        <div class="table-wrapper">
            <table class="tabla-productos" cellpadding="3" style="width:100%; table-layout:fixed;">
                <thead>
                    <tr>
                        <th class="colorP ctr" rowspan="2" style="width:10%;">ID_SIIBIEN</th>
                        <th class="colorP ctr" rowspan="2" style="width:24%;">Nombre del Producto</th>
                        <th class="colorP ctr" colspan="2" style="width:16%;">Meta</th>
                        <th class="colorP ctr" rowspan="2" style="width:25%;">Medio de Verificación</th>
                        <th class="colorP ctr" rowspan="2" style="width:25%;">Observaciones</th>
                    </tr>
                    <tr>
                        <th class="colorP ctr" style="width:8%;">Programada</th>
                        <th class="colorP ctr" style="width:8%;">Realizada</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $producto)
                        @php
                            $meta = $seguimientos[$producto->idProducto] ?? null;

                            $listaMedios = '';
                            if (isset($medios[$producto->idProducto])) {
                                foreach ($medios[$producto->idProducto] as $m) {
                                    if (!empty($m->rutaArchivo)) {
                                        $url = asset($m->rutaArchivo);
                                        $listaMedios .=
                                            ($m->descripcion ?? 'Archivo') .
                                            ' <a href="' . $url . '">' .
                                            basename($m->rutaArchivo) .
                                            '</a>';
                                    }
                                }
                            }

                            $obs = $observaciones[$producto->idProducto]->observacion ?? '';
                        @endphp

                        <tr>
                            <td class="colorS ctr" style="width:10%;">{{ $producto->idProducto }}</td>
                            <td class="colorS" style="width:24%;">{{ $producto->producto }}</td>
                            <td class="colorS ctr" style="width:8%;">{{ $meta->programado ?? '' }}</td>
                            <td class="colorS ctr" style="width:8%;">{{ $meta->realizado ?? '' }}</td>
                            <td class="colorS" style="width:25%;">{!! $listaMedios !!}</td>
                            <td class="colorS" style="width:25%;">{{ $obs }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="colorS" colspan="6" style="text-align:center;">
                                Sin información capturada para el año {{ $anio }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-wrapper">
            <table class="info-table" cellpadding="3" nobr="true">
                <tr>
                    <th class="texto-protesta">
                        "Bajo protesta de decir verdad, manifiesto que la información capturada en el Sistema de
                        Seguimiento Integral de Indicadores del Bienestar (SIIBien) es fidedigna, verificable y coincide
                        plenamente con los registros físicos y evidencias documentales que obran en los archivos de esta
                        Unidad Responsable. Se hace constar que los datos fueron ingresados siguiendo los lineamientos
                        técnicos y metodológicos vigentes para el presente ejercicio"
                    </th>
                </tr>
            </table>
        </div>
        <div class="table-wrapper">
            <table class="tabla-firmas" cellpadding="0" nobr = "true">
                <tr>
                    <td>
                        <table class="firma-box" cellpadding="2">
                            <tr>
                                <th class="firma-header">Elaboró</th>
                            </tr>
                            <tr>
                                <td class="firma-body">
                                    <br><br><br>
                                    {{ $enlaceOperativo->titulo ?? '' }}
                                    {{ $enlaceOperativo->nombre ?? '' }}
                                    {{ $enlaceOperativo->apellidoP ?? '' }}
                                    {{ $enlaceOperativo->apellidoM ?? '' }}<br>
                                    {{ $enlaceOperativo->cargo ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="firma-footer">
                                    Enlace Operativo
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td>
                        <table class="firma-box" cellpadding="2">
                            <tr>
                                <th class="firma-header">Revisó</th>
                            </tr>
                            <tr>
                                <td class="firma-body">
                                    <br><br><br>
                                    {{ $enlaceDirectivo->titulo ?? '' }}
                                    {{ $enlaceDirectivo->nombre ?? '' }}
                                    {{ $enlaceDirectivo->apellidoP ?? '' }}
                                    {{ $enlaceDirectivo->apellidoM ?? '' }}<br>
                                    {{ $enlaceDirectivo->cargo ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="firma-footer">
                                    Enlace Directivo
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table class="firma-box" cellpadding="2">
                            <tr>
                                <th class="firma-header">Validó</th>
                            </tr>
                            <tr>
                                <td class="firma-body">
                                    <br><br><br>
                                    {{ $titular->nombre ?? '' }},<br> {{ $titular->cargo ?? '' }}

                                </td>
                            </tr>
                            <tr>
                                <td class="firma-footer">
                                    Titular de la Dependencia/Entidad
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class="leyenda">
            <strong>NOTA:</strong> La dependencia o entidad es responsable de este producto;
            aún cuando sus datos, desempeño y variables puedan depender o pertenecer a fuentes externas.
        </div>
    </div>
</body>

</html>