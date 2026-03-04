<div class="codigo-formato">
    F-SIIBIEN-IE-01
</div>
<div class="tab-pane fade show active" id="nav-home" role="tabpanel"aria-labelledby="nav-home-tab">
    <div>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="6">
                    1. Datos de Identificación del Indicador
                </td>
            </tr>
            <tr>
                <td class="sombreado" style="" colspan="1">1.1 Nombre</td>
                <td class="value" colspan="5">{{ "[".$indicador->idIndicador."] ".$indicador->indicadorNombre }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1"> 1.2 Definición</td>
                <td class="value" colspan="5">{{ $indicador->indicadorObjetivo }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1"> 1.3 Tipo</td>
                <td class="value" colspan="1">{{ $indicador->indicadorTipo }}</td>
                <td class=" sombreado" style="" colspan="1"> 1.4 Dimensión</td>
                <td class="value" colspan="1">{{ $indicador->indicadorDimension }}</td>
                <td class=" sombreado" style="" colspan="1"> 1.5 Método de Cálculo</td>
                @php
                     $metodo = [
                        "porcentaje" => 'Porcentaje',
                        "indice" => 'Indice',
                        "tasa" => 'Tasa',
                        "tasa_v" => 'Tasa de variación',
                        "razon" => 'Razón o promedio',
            ];
                @endphp
            <td class="value" colspan="1">
                 {{ isset($metodo[$indicador->indicadorMetodo]) ? $metodo[$indicador->indicadorMetodo] : ' ' }}
            </td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1"> 1.6 Fórmula de Cálculo</td>
                <td class="value" colspan="3">{{ $indicador->indicadorFormula }}</td>
                <td class=" sombreado" style="" colspan="1"> 1.7 Unidad de Medida </td>
                <td class="value" colspan="1">{{ $indicador->indicadorUM }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1"> 1.8 Sentido Esperado</td>
                <td class="value" colspan="1">{{ $indicador->indicadorSentido }}</td>
                <td class="value sombreado" style="" colspan="1"> 1.9 Interpretación</td>
                <td class="value" colspan="3">{{ $indicador->indicadorInterpretacion }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1"> 1.10 Frecuencia de Medición</td>
                <td class="value" colspan="1">{{ $indicador->indicadorFrecuencia }}</td>
                <td class=" sombreado" style="" colspan="1"> 1.11 Línea Base (Año/Valor)</td>
                <td class="value" colspan="1">{{ $indicador->indicadorAnioLB . ' / ' . $indicador->valorAnioLB }}
                </td>
                <td class=" sombreado" style="" colspan="1"> 1.12 Fecha de Próxima Actualización</td>
                <td class="value" colspan="1">{{ $indicador->proxima_actualizacion }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1"> 1.13 Fuente de Información</td>
                <td class=" value" style="" colspan="5">{{$indicador->fuente_informacion}}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="6"> 1.14 Comentarios Técnicos</td>
            </tr>
            <tr>
                <td class="value" style="" colspan="6">{{ $indicador->observaciones }}</td>
            </tr>

        </table>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center" colspan="4">
                    2. Alineación
                </td>
            </tr>
            <tr>
                <td class="sombreado" colspan="4" style="text-align:center;background-color:rgb(215, 215, 215)">
                    2.1 Plan Estatal de Desarrollo 2022-2028
                </td>
            </tr>
            @foreach ($objetivos as $objetivo)
                <tr>
                    <td class="sombreado" colspan="1" style="margin-top:10px;width:20%">
                        2.1.1 Eje:
                    </td>
                    <td class="text" colspan="1" style="margin-top:10px;width:30%">
                        {{ $objetivo->ejePEDClave . ' ' . $objetivo->ejePEDDescripcion }}
                    </td>
                    <td class="sombreado" colspan="1" style="margin-top:10px;width:20%">
                        2.1.2 Tema del PED:
                    </td>
                    <td class="text" colspan="1" style="margin-top:10px;width:30%">
                        {{ $objetivo->temaPEDClave . ' ' . $objetivo->temaPEDDescripcion }}
                    </td>
                </tr>
                <tr>
                    <td class="sombreado" colspan="1" style="margin-top:10px;width:30%">
                        2.1.3 Objetivo del PED:
                    </td>
                    <td class="text" colspan="3" style="margin-top:10px;width:70%">
                        {{ $objetivo->objetivoPEDClave . ' ' . $objetivo->objetivoPEDDescripcion }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td class="sombreado" colspan="4" style="text-align:center;background-color:rgb(215, 215, 215)">
                    2.2 Plan sectorial / especial
                </td>
            </tr>
            <tr>
                <td class="text" colspan="4" style="text-align:center;">
                    @if ($sectores->count()>0)
                    <table>
                        <thead>
                            <tr>
                                <th>Clave</th>
                                <th>Sector</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sectores as $sector)
                                    <tr>
                                        <th>Sector {{$sector->claveSector}}</th>
                                        <th>{{$sector->sector}}</th>
                                    </tr>
                            @endforeach                        
                        </tbody>
                    </table>
                    @else
                        <center>
                            <div class="alert alert-info">
                                El indicador no está alineado a ningún Sector!
                            </div>
                        </center>
                    @endif
                </td>
            </tr>

        </table>
        <?php $cont = 0;
        $contods = 0; ?>
        <table style="width:100%">
            <tr>
                <td class="sombreado" colspan="4" style="text-align:center;background-color:rgb(215, 215, 215)">
                    2.3 Programas Presupuestarios
                </td>
            </tr>
            @php
                $niveles=['Fin','Proposito','Componente','Actividad'];
            @endphp
                <tr>
                        <td class="sombreado" style="width:12%; text-align:center;">Año</td>
                        <td class="sombreado" style="width:18%;">Clave</td>
                        <td class="sombreado" style="width:50%;">Nombre del programa</td>
                        <td class="sombreado" style="width:20%; text-align:center;">Nivel de la MIR</td>
                    </tr>

                    {{-- Filas de Programas --}}
                    @if ($programas->count() > 0)
                        @foreach ($programas as $programa)
                            <tr>
                                <td class="text" style="text-align:center;">
                                    {{ $programa->anio ?? 'N/D' }}
                                </td>
                                <td class="text">
                                    {{ $programa->clavePrograma }}
                                </td>
                                <td class="text">
                                    {{ $programa->descripcionPrograma }}
                                </td>
                                <td class="text" style="text-align:center;">
                                    @if(!is_null($programa->nivel))
                                        {{ $niveles[$programa->nivel - 1] ?? 'N/D' }}
                                    @else
                                        N/D
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text" colspan="4" style="text-align:center;">
                                ¡Sin programas presupuestarios!
                            </td>
                        </tr>
                    @endif
            <tr>
                <td class="sombreado" colspan="4" style="text-align: center">
                    2.4 Objetivos de Desarrollo Sostenible (ODS)
                </td>
            </tr>

            @foreach ($objetivosods as $objetivo)
                    <tr>
                        <td class="sombreado">
                            2.4.1 ODS
                        </td>
                        <td class="text" colspan="3" style="margin-top:10px;">
                            {{ $objetivo->clave }}
                            {{ $objetivo->descripcion }}
                        </td>
                    </tr>
            @endforeach

            <!--<tr>
                    <td class="value" colspan="1" rowspan="2" style="margin-top:10px;width:30%">
                        2.3.3 Metas ODS
                    </td>
                    <td class="text" colspan="1" style="margin-top:10px;width:70%">

                    </td>
                </tr>

                <tr>
                    <td class="text" colspan="1" style="margin-top:10px;width:70%">

                    </td>
                </tr>-->
        </table>

        <table style="width:100%">
            <tr>
                <td class="field" colspan="10" style="text-align: center">
                    3. Variables y comportamiento histórico
                </td>
            </tr>
            <tr>
                <td class="sombreado" colspan="1" rowspan="2"
                    style="width:25%;background-color:rgb(215, 215, 215);text-align:center">
                    3.1 Variables
                </td>
                <td class="sombreado" colspan="1" rowspan="2"
                    style="width:25%;background-color:rgb(215, 215, 215);text-align:center">
                    3.2 Unidad de Medida
                </td>
                <td class="sombreado" colspan="8" rowspan="1"
                    style="width:50%;background-color:rgb(215, 215, 215);text-align:center">
                    3.3 Valores históricos
                </td>
            </tr>
            <tr style="font-size: .8em !important;;">
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2017</td>
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2018</td>
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2019</td>
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2020</td>
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2021</td>
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2022</td>
            </tr>
            @foreach ($variables as $variable)
                <?php
                $vals = [
                    '2017' => 'n',
                    '2018' => 'n',
                    '2019' => 'n',
                    '2020' => 'n',
                    '2021' => 'n',
                    '2022' => 'n',
                ];
                $valores = DB::table('valoreshistoricosvariable')
                    ->where('idVariable', $variable->idVariable)
                    ->get();
                foreach ($valores as $val) {
                    $vals[$val->valoresCicloMedicion] = $val->valoresHistorico;
                }
                ?>

                <tr style="font-size: .8em !important;;">
                    <td class="value" colspan="1" style="width:25%;"> {{ $variable->variableNombre }}</td>
                    <td class="value" colspan="1" style="width:25%;"> {{ $variable->variableUM }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $vals['2017']=='n'?'':number_format((float)$vals['2017'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $vals['2018']=='n'?'':number_format((float)$vals['2018'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $vals['2019']=='n'?'':number_format((float)$vals['2019'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $vals['2020']=='n'?'':number_format((float)$vals['2020'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $vals['2021']=='n'?'':number_format((float)$vals['2021'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $vals['2022']=='n'?'':number_format((float)$vals['2022'],2) }}</td>
                </tr>
            @endforeach

            <tr style="font-size: .8em !important;;">
                <td class="sombreado" colspan="1" style="width:25%;">3.4 valores del indicador</td>
                <td class="value" colspan="1" style="width:25%;"></td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    @if($valoreshistoricos['2017']!=''){{ $valoreshistoricos['2017'] }}@endif</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    @if($valoreshistoricos['2018']!=''){{ $valoreshistoricos['2018'] }}@endif</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    @if($valoreshistoricos['2019']!=''){{ $valoreshistoricos['2019'] }}@endif</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    @if($valoreshistoricos['2020']!=''){{ $valoreshistoricos['2020'] }}@endif</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    @if($valoreshistoricos['2021']!=''){{ $valoreshistoricos['2021'] }}@endif</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    @if($valoreshistoricos['2022']!=''){{ $valoreshistoricos['2022'] }}@endif</td>
            </tr>
        </table>
        <!--<br pagebreak="true" />-->
        <table style="width:100%">
            <tr>
                <td class="field" colspan="10" style="text-align: center">
                    4. Programaciôn de metas
                </td>
            </tr>
            <tr>
                <td class="sombreado" colspan="1" rowspan="2"
                    style="width:25%;background-color:rgb(215, 215, 215);text-align:center">
                    4.1 Variables
                </td>
                <td class="sombreado" colspan="1" rowspan="2"
                    style="width:25%;background-color:rgb(215, 215, 215);text-align:center">
                    4.2 Unidad de Medida
                </td>
                <td class="sombreado" colspan="8" rowspan="1"
                    style="width:50%;background-color:rgb(215, 215, 215);text-align:center">
                    4.3 Valores Programados
                </td>
            </tr>
            <tr style="font-size: .8em !important;;">
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2023</td>
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2024</td>
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2025</td>
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2026</td>
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2027</td>
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2028</td>
            </tr>
            @foreach ($variables as $variable)
                <?php
                $vals = [
                    '2022' => '',
                    '2023' => '',
                    '2024' => '',
                    '2025' => '',
                    '2026' => '',
                    '2027' => '',
                    '2028' => '',
                ];
                $valores = DB::table('valoresvariable')
                    ->where('idVariable', $variable->idVariable)
                    ->get();
                foreach ($valores as $val) {
                    $vals[$val->valoresCicloMedicion] = $val->valoresProgramado;
                }
                ?>

                <tr style="font-size: .8em !important;;">
                    <td class="value" colspan="1" style="width:25%;"> {{ $variable->variableNombre }}</td>
                    <td class="value" colspan="1" style="width:25%;"> {{ $variable->variableUM }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $vals['2023']==''?'':number_format((float)$vals['2023'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $vals['2024']==''?'':number_format((float)$vals['2024'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $vals['2025']==''?'':number_format((float)$vals['2025'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $vals['2026']==''?'':number_format((float)$vals['2026'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $vals['2027']==''?'':number_format((float)$vals['2027'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $vals['2028']==''?'':number_format((float)$vals['2028'],2) }}</td>
                </tr>
            @endforeach

            <tr style="font-size: .8em !important;;">
                <td class="sombreado" colspan="1" style="width:25%;">4.4 valores del indicador</td>
                <td class="value" colspan="1" style="width:25%;"></td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoresprogramados['2023']==''?'':$valoresprogramados['2023'] }}</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoresprogramados['2024']==''?'':$valoresprogramados['2024'] }}</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoresprogramados['2025']==''?'':$valoresprogramados['2025'] }}</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoresprogramados['2026']==''?'':$valoresprogramados['2026'] }}</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoresprogramados['2027']==''?'':$valoresprogramados['2027'] }}</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoresprogramados['2028']==''?'':$valoresprogramados['2028'] }}</td>
            </tr>
        </table>
        <!--<br pagebreak="true" />-->
        <table style="width:100%">
            <tr>
                <td class="field" colspan="10" style="margin-top:10px;text-align:center">
                    5. Monitoreo de Metas
                </td>
            </tr>
            <tr>
                <td class="sombreado" colspan="1" rowspan="2"
                    style="width:25%;background-color:rgb(215, 215, 215);text-align:center">
                    5.1 Variables
                </td>
                <td class="sombreado" colspan="1" rowspan="2"
                    style="width:25%;background-color:rgb(215, 215, 215);text-align:center">
                    5.2 Unidad de Medida
                </td>
                <td class="sombreado" colspan="8" rowspan="1"
                    style="width:50%;background-color:rgb(215, 215, 215);text-align:center">
                    5.3 Valores Alcanzados
                </td>
            </tr>
            <tr style="font-size: .8em !important;;">
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2023</td>
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2024</td>
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2025</td>
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2026</td>
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2027</td>
                <td class="sombreado" colspan="1"
                    style="width:8.33%;background-color:rgb(215, 215, 215);text-align:center">2028</td>
            </tr>
            @foreach ($variables as $variable)
                <?php
                $valsr = [
                    '2022' => '',
                    '2023' => '',
                    '2024' => '',
                    '2025' => '',
                    '2026' => '',
                    '2027' => '',
                    '2028' => '',
                ];
                $valores = DB::table('valoresvariable')
                    ->where('idVariable', $variable->idVariable)
                    ->get();
                foreach ($valores as $val) {
                    $valsr[$val->valoresCicloMedicion] = $val->valoresReal;
                }
                ?>
                <tr style="font-size: .8em !important;;">
                    <td class="value" colspan="1" style="width:25%;"> {{ $variable->variableNombre }}</td>
                    <td class="value" colspan="1" style="width:25%;"> {{ $variable->variableUM }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valsr['2023']==''?'':number_format((float)$valsr['2023'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valsr['2024']==''?'':number_format((float)$valsr['2024'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valsr['2025']==''?'':number_format((float)$valsr['2025'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valsr['2026']==''?'':number_format((float)$valsr['2026'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valsr['2027']==''?'':number_format((float)$valsr['2027'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valsr['2028']==''?'':number_format((float)$valsr['2028'],2) }}</td>
                </tr>
            @endforeach
            <tr style="font-size: .8em !important;;">
                <td class="sombreado" colspan="1" style="width:25%;">5.4 valores del indicador</td>
                <td class="value" colspan="1" style="width:25%;"></td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valoresreales['2023']==''?'':$valoresreales['2023'] }}
                </td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valoresreales['2024']==''?'':$valoresreales['2024'] }}
                </td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valoresreales['2025']==''?'':$valoresreales['2025'] }}
                </td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valoresreales['2026']==''?'':$valoresreales['2026'] }}
                </td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valoresreales['2027']==''?'':$valoresreales['2027'] }}
                </td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valoresreales['2028']==''?'':$valoresreales['2028'] }}
                </td>
            </tr>
        </table>

        <table style="width:100%">
            <tr>
                <td class="field" colspan="7" style="margin-top:10px;text-align:center">
                    6. Medios de Verificación
                </td>
            </tr>
            <tr>
                <td class="sombreado" colspan="1" rowspan="2"
                    style="width:25%;background-color:rgb(215, 215, 215);text-align:center">
                    6.1 Variables
                </td>
                <td class="sombreado" colspan="7" rowspan="1"
                    style="width:75%;background-color:rgb(215, 215, 215);text-align:center">
                    6.2 Medios Cargados
                </td>
            </tr>
            <tr style="font-size: .8em !important;;">
                <td class="sombreado" colspan="1"
                    style="width:12.5%;background-color:rgb(215, 215, 215);text-align:center">2023</td>
                <td class="sombreado" colspan="1"
                    style="width:12.5%;background-color:rgb(215, 215, 215);text-align:center">2024</td>
                <td class="sombreado" colspan="1"
                    style="width:12.5%;background-color:rgb(215, 215, 215);text-align:center">2025</td>
                <td class="sombreado" colspan="1"
                    style="width:12.5%;background-color:rgb(215, 215, 215);text-align:center">2026</td>
                <td class="sombreado" colspan="1"
                    style="width:12.5%;background-color:rgb(215, 215, 215);text-align:center">2027</td>
                <td class="sombreado" colspan="1"
                    style="width:12.5%;background-color:rgb(215, 215, 215);text-align:center">2028</td>
            </tr>
            @foreach ($variables as $variable)
                <?php
                $mediosV = [
                    '2022' => '',
                    '2023' => '',
                    '2024' => '',
                    '2025' => '',
                    '2026' => '',
                    '2027' => '',
                    '2028' => '',
                ];
                $valores = DB::table('mediosvariable')
                    ->join("valoresvariable",'valoresvariable.idValores',"=","mediosvariable.idValoresVariable")
                    ->join("variable","variable.idVariable","=","valoresvariable.idVariable")
                    ->where('variable.idVariable', $variable->idVariable)
                    ->get();
                foreach ($valores as $val) {
                    $mediosV[$val->valoresCicloMedicion] .= "[".asset("medios/")."/".$val->idIndicador."/variables/".$val->idVariable."/".$val->idValoresVariable."/".$val->filename."] ".$val->archivo." ; ".$val->descripcion."|\n";
                }
                ?>
                <tr style="font-size: .8em !important;;">
                    <td class="value" colspan="1" style="width:25%;"> {{ $variable->variableNombre }}</td>
                    <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosV['2023'] }}</td>
                    <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosV['2024'] }}</td>
                    <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosV['2025'] }}</td>
                    <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosV['2026'] }}</td>
                    <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosV['2027'] }}</td>
                    <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosV['2028'] }}</td>
                </tr>
            @endforeach
            @php
                $mediosIndicadora=[
                    '2022' => '',
                    '2023' => '',
                    '2024' => '',
                    '2025' => '',
                    '2026' => '',
                    '2027' => '',
                    '2028' => '',
                ];
            @endphp
            @foreach ($mediosindicador as $medio)
                @php
                    $mediosIndicadora[$medio->valoresCicloMedicion] .= "[".asset("medios/")."/".$medio->idIndicador."/".$medio->idValoresIndicador."/".$medio->filename."] ".$medio->archivo." ; ".$medio->descripcion."|\n";
                @endphp
            @endforeach

            <tr style="font-size: .8em !important;;">
                <td class="sombreado" colspan="1" style="width:25%;">6.3 indicador</td>
                <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosIndicadora['2023'] }}
                </td>
                <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosIndicadora['2024'] }}
                </td>
                <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosIndicadora['2025'] }}
                </td>
                <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosIndicadora['2026'] }}
                </td>
                <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosIndicadora['2027'] }}
                </td>
                <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosIndicadora['2028'] }}
                </td>
            </tr>
        </table>
<!--
     <table style="width:100%">
            <tr>
                <td class="field"> 5. Referencias Adicionales</td>
            </tr>
            <tr>
                <td class="value"> 5.1 Comentarios Técnicos</td>
            </tr>
            <tr>
                <td class="text" style="height: 30px"></td>
            </tr>
        </table>-->
        <table style="width:100%;">
            <tr>
                <td class="field" colspan="4" style="margin-top:10px; text-align:center;">
                    7. Validación CREMAA
                </td>
            </tr>

            <tr style="font-size:.8em !important;">
                <td class="sombreado" style="width:8%; background-color:rgb(215, 215, 215); text-align:center;">Sigla</td>
                <td class="sombreado" style="width:20%; background-color:rgb(215, 215, 215); text-align:center;">Criterio</td>
                <td class="sombreado" style="width:12%; background-color:rgb(215, 215, 215); text-align:center;">Cumple</td>
                <td class="sombreado" style="width:60%; background-color:rgb(215, 215, 215); text-align:center;">Justificación</td>
            </tr>


            <!-- Fila Claro -->
            <tr style="font-size:.8em !important;">
                <td class="sombreado" style="background-color:rgb(215, 215, 215); text-align:center;">C</td>
                <td class="sombreado" style="background-color:rgb(215, 215, 215); text-align:center;">Claro</td>
                <td class="value {{ $crema && $crema->claro ? 'value-si' : 'value-no' }}"
                    style="text-align:center; height:20px; line-height:20px;">
                    {{ $crema ? ($crema->claro ? 'SI' : 'NO') : ' ' }}
                </td>
                <td style="text-align:justify; font-size: 0.8em; padding: 2px; border: 0.1px solid #888;">
                    {{ $comentariosCrema['claro'] ?? ' ' }}
                </td>
            </tr>

            <!-- Fila Relevante -->
            <tr style="font-size:.8em !important;">
                <td class="sombreado" style="background-color:rgb(215, 215, 215); text-align:center;">R</td>
                <td class="sombreado" style="background-color:rgb(215, 215, 215); text-align:center;">Relevante</td>
                <td class="value {{ $crema && $crema->relevante ? 'value-si' : 'value-no' }}"
                    style="text-align:center; height:20px; line-height:20px;">
                    {{ $crema ? ($crema->relevante ? 'SI' : 'NO') : ' ' }}
                </td>
                <td style="text-align:justify; font-size: 0.8em; padding: 2px; border: 0.1px solid #888;">
                    {{ $comentariosCrema['relevante'] ?? ' ' }}
                </td>
            </tr>

            <!-- Fila Económico -->
            <tr style="font-size:.8em !important;">
                <td class="sombreado" style="background-color:rgb(215, 215, 215); text-align:center;">E</td>
                <td class="sombreado" style="background-color:rgb(215, 215, 215); text-align:center;">Económico</td>
                <td class="value {{ $crema && $crema->economico ? 'value-si' : 'value-no' }}"
                    style="text-align:center; height:20px; line-height:20px;">
                    {{ $crema ? ($crema->economico ? 'SI' : 'NO') : ' ' }}
                </td>
                <td style="text-align:justify; font-size: 0.8em; padding: 2px; border: 0.1px solid #888;">
                    {{ $comentariosCrema['economico'] ?? ' ' }}
                </td>
            </tr>

            <!-- Fila Monitoreable -->
            <tr style="font-size:.8em !important;">
                <td class="sombreado" style="background-color:rgb(215, 215, 215); text-align:center;">M</td>
                <td class="sombreado" style="background-color:rgb(215, 215, 215); text-align:center;">Monitoreable</td>
                <td class="value {{ $crema && $crema->monitoreable ? 'value-si' : 'value-no' }}"
                    style="text-align:center; height:20px; line-height:20px;">
                    {{ $crema ? ($crema->monitoreable ? 'SI' : 'NO') : ' ' }}
                </td>
                <td style="text-align:justify; font-size: 0.8em; padding: 2px; border: 0.1px solid #888;">
                    {{ $comentariosCrema['monitoreable'] ?? ' ' }}
                </td>
            </tr>

            <!-- Fila Adecuado -->
            <tr style="font-size:.8em !important;">
                <td class="sombreado" style="background-color:rgb(215, 215, 215); text-align:center;">A</td>
                <td class="sombreado" style="background-color:rgb(215, 215, 215); text-align:center;">Adecuado</td>
                <td class="value {{ $crema && $crema->adecuado ? 'value-si' : 'value-no' }}"
                    style="text-align:center; height:20px; line-height:20px;">
                    {{ $crema ? ($crema->adecuado ? 'SI' : 'NO') : ' ' }}
                </td>
                <td style="text-align:justify; font-size: 0.8em; padding: 2px; border: 0.1px solid #888;">
                    {{ $comentariosCrema['adecuado'] ?? ' ' }}
                </td>
            </tr>

            <!-- Fila Aporte Marginal -->
            <tr style="font-size:.8em !important;">
                <td class="sombreado" style="background-color:rgb(215, 215, 215); text-align:center;">A</td>
                <td class="sombreado" style="background-color:rgb(215, 215, 215); text-align:center;">Aporte Marginal</td>
                <td class="value {{ $crema && $crema->aporteMarginal ? 'value-si' : 'value-no' }}"
                    style="text-align:center; height:20px; line-height:20px;">
                    {{ $crema ? ($crema->aporteMarginal ? 'SI' : 'No Aplica') : ' ' }}
                </td>
                <td style="text-align:justify; font-size: 0.8em; padding: 2px; border: 0.1px solid #888;">
                    {{ $comentariosCrema['aporteMarginal'] ?? ' ' }}
                </td>
            </tr>
        </table>



        <table style="width:100%">
            <tr>
                <td class="field" colspan="4" style="text-align:center"> 8. Datos de los Responsables de la Información</td>
            </tr>
            <tr>
                <td class="sombreado" colspan="1"> 8.1 Nombre de la dependencia: </td>
                <td class="text" colspan="3"><span style="font-weight:normal">
                    {{ $indicador->dependenciaNombre . ' (' . $indicador->dependenciaSiglas . ')' }}</span></td>
            </tr>
            <tr>
                <td class="sombreado" style="" colspan="2">8.2 Datos del Titular de la Dependencia</td>
                <td class="sombreado" style="" colspan="2">8.3 Datos del Enlace Directivo</td>
            </tr>
            <tr>
                <td class="sombreado" style="width:15%">8.2.1 Nombre:</td>
                <td class="text" style="width:35%">{{ $titular == null ? '' : $titular->nombre }}</td>
                <td class="sombreado" style="width:15%">8.3.1 Nombre:</td>
                <td class="text" style="width:35%">
                    {{ $enlace == null ? '' : $enlace->titulo." ".$enlace->nombre . ' ' . $enlace->apellidoP . ' ' . $enlace->apellidoM }}
                </td>
            </tr>
            <tr>
                <td class="sombreado" style="width:15%">8.2.2 Cargo:</td>
                <td class="text" style="width:35%">{{ $titular == null ? '' : $titular->cargo }}</td>
                <td class="sombreado" style="width:15%">8.3.2 Cargo:</td>
                <td class="text" style="width:35%">{{ $enlace == null ? '' : $enlace->cargo }}</td>
            </tr>
            <tr>
                <td class="sombreado" style="width:15%">8.2.3 Firma:</td>
                <td class="text" style="width:35%;height:50px;"></td>
                <td class="sombreado" style="width:15%">8.3.3 Firma:</td>
                <td class="text" style="width:35%;height:70px;"></td>
            </tr>
        </table>

        <table style="width:100%">
            <tr>
                <td class="sombreado" style="width: 30%"> 8.4 Fecha de actualización</td>
                <td class="text" style="width: 70%"> {{ date('Y m d H:i:s') }} </td>
            </tr>
           <!-- <tr>
                <td colspan="2" style="text-align: justify;"><p style="font-size: .8em"><br/>Se valida la responsabilidad de este indicador, para el reporte de monitoreo y seguimiento de los objetivos establecidos en el Plan Estatal de Desarrollo 2022-2028.
                    La información de alineación y metadatos del indicador, queda sujeta a modificación derivado de la revisión de la Instancia Técnica de Evaluación.
                    La información de valores históricos y metas programadas, del indicador y sus variables quedarán establecidas y definidas, una vez que sean atendidas las observaciones realizadas por la ITE.</p></td>
            </tr>-->
        </table><br><br><br>
        <table style="width:100%; margin-top:15px;">
            <tr>
                <td class="leyenda">
                    <strong>NOTA:</strong> La dependencia o entidad es responsable de este indicador; aún cuando sus datos,
                    desempeño y variables puedan depender o pertenecer a fuentes externas.
                </td>
            </tr>
        </table><br><br>
    </div>
</div>

<style>
    .field {
        background-color: rgb(0, 171, 172);
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
        align-items:center;
        line-height: 15px;
    }

    .value-si {
        background-color: #d4edda; 
    }
    .value-no {
        background-color: #e9ecef; 

    }
    .leyenda {
        background-color:#f2f4f5;
        color:#333;
        font-size:.75em;
        text-align:justify;
        border-left:4px solid rgb(0,171,172);
        padding:8px;
    }
    .codigo-formato {
        font-family: helvetica, sans-serif;
        font-size: 8pt;
        color: #ad8e65;
        text-align: right;
    }
</style>
