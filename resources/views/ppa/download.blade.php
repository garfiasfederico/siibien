<div class="tab-pane fade show active" id="nav-home" role="tabpanel"aria-labelledby="nav-home-tab">
    <div>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="6">
                    1. Datos Generales
                </td>
            </tr>
            <tr>
                <td class="sombreado" colspan="1">Folio:</td>
                <td class="value" align="center" colspan="1">{{ $ppa->id }}</td>
                <td class=" sombreado" style="" colspan="1"> Periodo:</td>
                <td class="value" align="center" colspan="1">{{ $periodo }}</td>
                <td class=" sombreado" style="" colspan="1"> Fecha de Evento:</td>
                <td class="value" align="center" colspan="1">{{ $ppa->fecha_evento }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Dependencia que reporta:</td>
                <td class="value" colspan="6">
                    {{ $dependencia->dependenciaNombre . ' (' . $dependencia->dependenciaSiglas . ')' }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Nombre del Programa, Proyecto o Acción (PPA):</td>
                <td class="value" align="justify" colspan="6">{{ $ppa->nombre }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Objetivo General del PPA:</td>
                <td class="value" align="justify" colspan="6">{{ $ppa->objetivo }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Descripción del PPA:</td>
                <td class="value" align="justify" colspan="6">{{ $ppa->descripcion }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Cobertura:</td>
                <td class="value" colspan="6">{{ $ppa->cobertura }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="2">
                    2. Alineación al PED y Programas Presupuestarios
                </td>
            </tr>
            <tr>
                <td class=" sombreado" style="width:20%" colspan="1">Eje PED:</td>
                <td class="value" style="width:80%">{{ $ejeped->ejePEDClave . ' ' . $ejeped->ejePEDDescripcion }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Tema PED:</td>
                <td class="value">{{ $temaped->temaPEDClave . ' ' . $temaped->temaPEDDescripcion }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Objetivo PED:</td>
                <td class="value">{{ $objetivoped->objetivoPEDClave . ' ' . $objetivoped->objetivoPEDDescripcion }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Estrategia PED:</td>
                <td class="value">
                    @if ($estrategiaped != '')
                        {{ $estrategiaped->estrategiaPEDClave . ' ' . $estrategiaped->estrategiaPEDDescripcion }}
                    @endif
                </td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Linea PED:</td>
                <td class="value">
                    @if ($lineaped != '')
                        {{ $lineaped->laPEDClave . ' ' . $lineaped->laPEDDescripcion }}
                    @endif
                </td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Programas Presupuestarios:</td>
                <td class="value">@foreach ($programas as $programa){{ $programa }}<br />@endforeach
                </td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="2">
                    3. Productos Entregados (Bienes o Servicios Públicos) e Inversión
                </td>
            </tr>
            <tr>
                <td class=" sombreado" style="width:15%" colspan="1">Fuente de Financiamiento:</td>
                <td class="value" align="left" style="width:18%">{{ $ppa->fuente_financiamiento }}</td>
                <td class=" sombreado" style="width:15%" colspan="1">Monto de Inversión para el Ejercicio:</td>
                <td class="value" align="right" style="width:18%">$
                    {{ number_format((float) $ppa->monto_inversion, 2) }}</td>
                <td class=" sombreado" style="width:15%" colspan="1">Monto de Inversión Ejercido en el periodo de
                    reporte:</td>
                <td class="value" align="right" style="width:19%">$
                    {{ number_format((float) $ppa->monto_ejercido, 2) }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="width:15%" colspan="1">Descripción del Bien o Servicio entregado:</td>
                <td class="value" align="left" style="width:18%">{{ $ppa->descripcion_bs }}</td>
                <td class=" sombreado" style="width:15%" colspan="1">Número de Entregas:</td>
                <td class="value" align="right" style="width:18%">{{ $ppa->entregas_bs }}</td>
                <td class=" sombreado" style="width:15%" colspan="1">Monto de Inversión Ejercido en el periodo de
                    reporte:</td>
                <td class="value" align="left" style="width:19%">{{ $ppa->um_bs }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="2">
                    4. Población Objetivo
                </td>
            </tr>
            <tr>
                <td class=" sombreado" style="width:15%" colspan="1">Tipo de beneficiario:</td>
                <td class="value" align="left" colspan="1" style="width: 18%">{{ $ppa->tipo_beneficiario }}
                </td>
                <td class=" sombreado" style="width:15%" colspan="1">Descripcion del beneficiario:</td>
                <td class="value" align="left" colspan="3" style="width:52%">
                    {{ $ppa->descripcion_beneficiario }}</td>
            </tr>
            <tr>
                @php
                    $poblacion_objetivo = explode('|', $ppa->poblacion_objetivo);
                @endphp
                <td class=" sombreado" style="width:15%" colspan="1">Población Objetivo:</td>
                <td class="value" align="right" style="width:18%">{{ $poblacion_objetivo[0] }}</td>
                <td class=" sombreado" style="width:15%" colspan="1">Mujeres:</td>
                <td class="value" align="right" style="width:18%">{{ $poblacion_objetivo[1] }}</td>
                <td class=" sombreado" style="width:15%" colspan="1">Hombres:</td>
                <td class="value" align="right" style="width:19%">{{ $poblacion_objetivo[2] }}</td>
            </tr>
            <tr>
                @php
                    $poblacion_atendida = explode('|', $ppa->poblacion_atendida);
                @endphp
                <td class=" sombreado" style="width:15%" colspan="1">Población Atendida:</td>
                <td class="value" align="right" style="width:18%">{{ $poblacion_atendida[0] }}</td>
                <td class=" sombreado" style="width:15%" colspan="1">Mujeres:</td>
                <td class="value" align="right" style="width:18%">{{ $poblacion_atendida[1] }}</td>
                <td class=" sombreado" style="width:15%" colspan="1">Hombres:</td>
                <td class="value" align="right" style="width:19%">{{ $poblacion_atendida[2] }}</td>
            </tr>
            <tr>
                @php
                    $poblacion_atender = explode('|', $ppa->poblacion_atender);
                @endphp
                <td class=" sombreado" style="width:15%" colspan="1">Población por Atender:</td>
                <td class="value" align="right" style="width:18%">{{ $poblacion_atender[0] }}</td>
                <td class=" sombreado" style="width:15%" colspan="1">Mujeres:</td>
                <td class="value" align="right" style="width:18%">{{ $poblacion_atender[1] }}</td>
                <td class=" sombreado" style="width:15%" colspan="1">Hombres:</td>
                <td class="value" align="right" style="width:19%">{{ $poblacion_atender[2] }}</td>
            </tr>
            <tr>
                @php
                    $poblacion_atender = explode('|', $ppa->poblacion_atender);
                @endphp
                <td class=" sombreado" style="width:15%" colspan="1">Regiones atendidas:</td>
                <td class="value" align="left" style="width:33%" colspan="2">
                    <ul>
                    @foreach ($regiones as $region)
                        <li>{{$regiones_array[(string)$region]}}</li>
                    @endforeach
                    </ul>

                </td>
                <td class=" sombreado" style="width:18%" colspan="1">Municipios Atendidos:</td>
                <td class="value" align="left" style="width:34%" colspan="2">{{ $ppa->municipios }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="6">
                    5. Impacto generado
                </td>
            </tr>
            <tr>
                <td class=" sombreado" style="width:15%" colspan="1">Impacto Social:</td>
                <td class="value" align="left" style="width:18%">{{ $ppa->impacto_social }}</td>
                <td class=" sombreado" style="width:15%" colspan="1">Impacto Económico:</td>
                <td class="value" align="left" style="width:18%">{{ $ppa->impacto_economico}}</td>
                <td class=" sombreado" style="width:15%" colspan="1">Impacto Ambiental:</td>
                <td class="value" align="left" style="width:19%">{{ $ppa->impacto_ambiental}}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="width:20%" colspan="1">Observaciones Generales:</td>
                <td class="value" align="left" style="width:80%" colspan="5">{{ $ppa->observaciones}}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="4">
                    5. Medios de Verificación Cargados
                </td>
            </tr>
            @foreach($medios as $medio)
                <tr>
                    <td class=" sombreado" style="width:15%" colspan="1">Nombre del Medio Cargado:</td>
                    <td class="value" align="left" style="width:35%">{{$medio->real}}</td>
                    <td class=" sombreado" style="width:15%" colspan="1">Descripcion:</td>
                    <td class="value" align="left" style="width:35%">{{$medio->descripcion}}</td>
                </tr>
            @endforeach
        </table>

        <table style="width:100%">
            <tr>
                <td class="field" colspan="4" style="text-align:center"> 6. Datos de los Responsables de la
                    Información</td>
            </tr>
            <tr>
                <td class="sombreado" colspan="1"> Dependencia: </td>
                <td class="text" colspan="3"><span style="font-weight:normal">
                    {{ $dependencia->dependenciaNombre . ' (' . $dependencia->dependenciaSiglas . ')' }}</span></td>
            </tr>
            <tr>
                <td class="sombreado" style="" colspan="2">Titular de la Dependencia</td>
                <td class="sombreado" style="" colspan="2">Enlace Institucional</td>
            </tr>
            <tr>
                <td class="sombreado" style="width:15%">Nombre:</td>
                <td class="text" style="width:35%">{{ $titular == null ? '' : $titular->nombre }}</td>
                <td class="sombreado" style="width:15%">Nombre:</td>
                <td class="text" style="width:35%">
                    {{ $enlace == null ? '' : $enlace->titulo . ' ' . $enlace->nombre . ' ' . $enlace->apellidoP . ' ' . $enlace->apellidoM }}
                </td>
            </tr>
            <tr>
                <td class="sombreado" style="width:15%">Cargo:</td>
                <td class="text" style="width:35%">{{ $titular == null ? '' : $titular->cargo }}</td>
                <td class="sombreado" style="width:15%">Cargo:</td>
                <td class="text" style="width:35%">{{ $enlace == null ? '' : $enlace->cargo }}</td>
            </tr>
            <tr>
                <td class="sombreado" style="width:15%">Firma:</td>
                <td class="text" style="width:35%;height:50px;"></td>
                <td class="sombreado" style="width:15%">Firma:</td>
                <td class="text" style="width:35%;height:70px;"></td>
            </tr>
        </table>
    </div>
</div>

<style>
    .field {
        background-color: #681b2e;

        color: white;
        text-align: left;
        border: solid 1px gray;
        height: 20px;
        font-weight: bold;
        font-size: 1em;
    }

    .value {
        text-align: left;
        border: dashed 1px gray;
        height: 20px;
        vertical-align: middle;
        font-size: .8em;
    }


    .text {
        text-align: left;
        border: dashed 1px gray;
        height: 20px;
        vertical-align: middle;
        font-size: .8em;
    }

    .valuee {
        text-align: left;
        height: 20px;
        border-right: dashed 1px gray;
        vertical-align: middle;
        font-size: .8em;

    }

    .textt {
        text-align: left;
        height: 20px;
        border-left: dashed 1px gray;
        vertical-align: middle;
        font-size: .8em;
    }

    table tr th {
        text-align: center;
        color: black;

    }

    .label {
        color: black;
        font-weight: bold;
        padding: 5px;
    }

    .valor {
        border-bottom: dashed 1px rgb(218, 218, 218);
        font-size: 1.1em;

    }

    .sombreado {
        background-color: rgb(218, 218, 218);
        font-size: .8em;
        border: solid 1px black;
        height: 18px;
        align-items: center;
        line-height: 15px;
    }
</style>
