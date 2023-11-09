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
                <td class="value" colspan="5">{{ $indicador->indicadorNombre }}</td>
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
                <td class="value" colspan="1">{{ $indicador->indicadorMetodo }}</td>
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
                <td class=" sombreado" style="" colspan="6"> 1.13 Comentarios Técnicos</td>
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
            @if (count($programas) > 0)
                @foreach ($programas as $programa)
                    <tr>
                        <td class="sombreado" colspan="1" style="margin-top:10px;width:20%;">
                            2.3.1 Nombre del Programa
                        </td>
                        <td class="text" style="margin-top:10px;width:60%;">
                            {{ $programa->clavePrograma }}
                            {{ $programa->descripcionPrograma }}
                        </td>
                        <td class="sombreado" colspan="1" style="width:10%">2.3.2 Nivel de la MIR</td>
                        <td class="text" colspan="1" style="width:10%">{{ $niveles[$programa->nivel-1] }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text" colspan="4" style="margin-top:10px;width:100%">
                        Sin programas Prespuestarios!
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
                    '2017' => '',
                    '2018' => '',
                    '2019' => '',
                    '2020' => '',
                    '2021' => '',
                    '2022' => '',                    
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
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$vals['2017'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$vals['2018'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$vals['2019'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$vals['2020'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$vals['2021'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$vals['2022'],2) }}</td>                
                </tr>
            @endforeach

            <tr style="font-size: .8em !important;;">
                <td class="sombreado" colspan="1" style="width:25%;">3.4 valores del indicador</td>
                <td class="value" colspan="1" style="width:25%;"></td>                
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ number_format($valoreshistoricos['2017'],2) }}</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ number_format($valoreshistoricos['2018'],2) }}</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoreshistoricos['2019'] }}</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoreshistoricos['2020'] }}</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoreshistoricos['2021'] }}</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoreshistoricos['2022'] }}</td>                
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
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$vals['2023'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$vals['2024'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$vals['2025'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$vals['2026'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$vals['2027'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$vals['2028'],2) }}</td>
                </tr>
            @endforeach

            <tr style="font-size: .8em !important;;">
                <td class="sombreado" colspan="1" style="width:25%;">3.4 valores del indicador</td>
                <td class="value" colspan="1" style="width:25%;"></td>                
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoresprogramados['2023'] }}</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoresprogramados['2024'] }}</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoresprogramados['2025'] }}</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoresprogramados['2026'] }}</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoresprogramados['2027'] }}</td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">
                    {{ $valoresprogramados['2028'] }}</td>
            </tr>
        </table>

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
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$valsr['2023'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$valsr['2024'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$valsr['2025'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$valsr['2026'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$valsr['2027'],2) }}</td>
                    <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ number_format((float)$valsr['2028'],2) }}</td>
                </tr>
            @endforeach
            <tr style="font-size: .8em !important;;">
                <td class="sombreado" colspan="1" style="width:25%;">3.4 valores del indicador</td>
                <td class="value" colspan="1" style="width:25%;"></td>                
                <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valoresreales['2023'] }}
                </td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valoresreales['2024'] }}
                </td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valoresreales['2025'] }}
                </td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valoresreales['2026'] }}
                </td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valoresreales['2027'] }}
                </td>
                <td class="value" colspan="1" style="width:8.33%;text-align:right">{{ $valoresreales['2028'] }}
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
                    $mediosV[$val->valoresAnioMedicion] .= $val->archivo." ; ".$val->descripcion."|\n";
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
                $mediosIndicador=[
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
                    $mediosIndicador[$medio->valoresCicloMedicion] .= $medio->archivo." ; ".$medio->descripcion."|\n";
                @endphp
            @endforeach    

            <tr style="font-size: .8em !important;;">
                <td class="sombreado" colspan="1" style="width:25%;">6.4 indicador</td>                
                <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosIndicador['2023'] }}
                </td>
                <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosIndicador['2024'] }}
                </td>
                <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosIndicador['2025'] }}
                </td>
                <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosIndicador['2026'] }}
                </td>
                <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosIndicador['2027'] }}
                </td>
                <td class="value" colspan="1" style="width:12.5%;text-align:right">{{ $mediosIndicador['2028'] }}
                </td>
            </tr>
        </table>

      <!--  <table style="width:100%">
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

        <table style="width:100%">
            <tr>
                <td class="field" colspan="4" style="text-align:center"> 7. Datos de los Responsables de la Información</td>
            </tr>
            <tr>
                <td class="sombreado" colspan="1"> 7.1 Nombre de la dependencia: </td>
                <td class="text" colspan="3"><span style="font-weight:normal">
                    {{ $indicador->dependenciaNombre . ' (' . $indicador->dependenciaSiglas . ')' }}</span></td>
            </tr>
            <tr>
                <td class="sombreado" style="" colspan="2">7.2 Datos del Titular de la Dependencia</td>
                <td class="sombreado" style="" colspan="2">7.3 Datos del Enlace Institucional</td>
            </tr>
            <tr>
                <td class="sombreado" style="width:15%">7.2.1 Nombre:</td>
                <td class="text" style="width:35%">{{ $titular == null ? '' : $titular->nombre }}</td>
                <td class="sombreado" style="width:15%">7.3.1 Nombre:</td>
                <td class="text" style="width:35%">
                    {{ $enlace == null ? '' : $enlace->nombre . ' ' . $enlace->apellidoP . ' ' . $enlace->apellidoM }}
                </td>
            </tr>
            <tr>
                <td class="sombreado" style="width:15%">7.2.2 Cargo:</td>
                <td class="text" style="width:35%">{{ $titular == null ? '' : $titular->cargo }}</td>
                <td class="sombreado" style="width:15%">7.3.2 Cargo:</td>
                <td class="text" style="width:35%">{{ $enlace == null ? '' : $enlace->cargo }}</td>
            </tr>
            <tr>
                <td class="sombreado" style="width:15%">7.2.3 Firma:</td>
                <td class="text" style="width:35%;height:50px;"></td>
                <td class="sombreado" style="width:15%">7.3.3 Firma:</td>
                <td class="text" style="width:35%;height:70px;"></td>
            </tr>
        </table>

        <table style="width:100%">
            <tr>
                <td class="sombreado" style="width: 30%"> 7.4 Fecha de actualización</td>
                <td class="text" style="width: 70%"> {{ date('Y m d H:i:s') }} </td>
            </tr>
        </table>
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
</style>
