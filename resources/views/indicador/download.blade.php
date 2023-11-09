
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel"aria-labelledby="nav-home-tab">
        <div>
            <table style="width:100%">
                <tr>
                    <td class="field" colspan="3">
                        1. Datos de Identificación del Indicador
                    </td>
                </tr>
                <tr>
                    <td class="value" colspan="3"> 1.1 Nombre</td>
                </tr>
                <tr>
                    <td class="text" colspan="3"> {{ $indicador->indicadorNombre }}</td>
                </tr>
                <tr>
                    <td class="value" colspan="3"> 1.2 Objetivo</td>
                </tr>
                <tr>
                    <td class="text" colspan="3"> {{ $indicador->indicadorObjetivo }}</td>
                </tr>
                <tr>
                    <td class="value"> 1.3 Tipo</td>
                    <td class="value"> 1.4 Dimensión</td>
                    <td class="value"> 1.5 Método de Cálculo</td>
                </tr>
                <tr>
                    <td class="text"> {{ $indicador->indicadorTipo }}</td>
                    <td class="text"> {{ $indicador->indicadorDimension }}</td>
                    <td class="text"> {{ $indicador->indicadorMetodo }}</td>
                </tr>
                <tr>
                    <td class="value" colspan="2"> 1.6 Fórmula de Cálculo</td>
                    <td class="value"> 1.7 Unidad de Medida</td>
                </tr>
                <tr>
                    <td class="text" colspan="2"> {{ $indicador->indicadorFormula }}</td>
                    <td class="text"> {{ $indicador->indicadorUM }}</td>
                </tr>
                <tr>
                    <td class="value" colspan="2"> 1.8 Interpretación</td>
                    <td class="value"> 1.9 Frecuencia de Medición</td>
                </tr>
                <tr>
                    <td class="text" colspan="2"> {{ $indicador->indicadorInterpretacion }}</td>
                    <td class="text"> {{ $indicador->indicadorFrecuencia }}</td>
                </tr>
                <tr>
                    <td class="value"> 1.10 Sentido</td>
                    <td class="value"> 1.11 Linea Base (Año)</td>
                    <td class="value"> 1.12 Línea Base (Valor)</td>
                </tr>
                <tr>
                    <td class="text"> {{ $indicador->indicadorSentido }}</td>
                    <td class="text"> {{ $indicador->indicadorAnioLB }}</td>
                    <td class="text"> {{ $indicador->valorAnioLB }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="value"> 1.13 Proxima actualización</td>                    
                </tr>
                <tr>
                    <td colspan="3" class="text"> {{ $indicador->proxima_actualizacion }}</td>                    
                </tr>
                <tr>
                    <td class="value" colspan="3"> 1.14 Observaciones</td>
                </tr>
                <tr>
                    <td class="text" colspan="3"> {{ $indicador->observaciones }}</td>
                </tr>
            </table>
            <table style="width:100%">
                <tr>
                    <td class="field" colspan="2">
                        2. Alineación
                    </td>
                </tr>
                <tr>
                    <td class="value" colspan="2" style="margin-top:10px;background-color:rgb(215, 215, 215)">
                        2.1 Plan Estatal de Desarrollo
                    </td>
                </tr>
                @foreach ($objetivos as $objetivo)
                    <tr>
                        <td class="value" colspan="1" style="margin-top:10px;width:30%">
                            2.1.1 Eje del PED:
                        </td>
                        <td class="text" colspan="1" style="margin-top:10px;width:70%">
                            {{ $objetivo->ejePEDClave . ' ' . $objetivo->ejePEDDescripcion }}
                        </td>
                    </tr>
                    <tr>
                        <td class="value" colspan="1" style="margin-top:10px;width:30%">
                            2.1.2 Tema del PED:
                        </td>
                        <td class="text" colspan="1" style="margin-top:10px;width:70%">
                            {{ $objetivo->temaPEDClave . ' ' . $objetivo->temaPEDDescripcion }}
                        </td>
                    </tr>
                    <tr>
                        <td class="value" colspan="1" style="margin-top:10px;width:30%">
                            2.1.3 Objetivo del PED:
                        </td>
                        <td class="text" colspan="1" style="margin-top:10px;width:70%">
                            {{ $objetivo->objetivoPEDClave . ' ' . $objetivo->objetivoPEDDescripcion }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td class="value" colspan="2" style="margin-top:10px;background-color:rgb(215, 215, 215)">
                        2.2 Planes Sectoriales
                    </td>
                </tr>
                <tr>
                    <td class="" colspan="2" style="margin:0px;border:solid 1px gray">
                        <table style="width:100%" border="0">
                            <?php $sectores=array()?>
                            @foreach ($objetivos as $objetivo)
                            @if(array_search("".$objetivo->sector."",$sectores)=== false)                            
                                <tr>
                                    <td class="valuee" style="width:20%">
                                        2.2.1 Sector:
                                    </td>
                                    <td class="textt" style="width:30%">
                                        {{ $objetivo->sector }}
                                    </td>
                                    <td class="valuee" style="width:20%">
                                        2.2.2 Subsector:
                                    </td>
                                    <td class="textt" style="width:30%">
                                        <?php $subsectores = DB::table('subsector')
                                            ->where('idSector', $objetivo->idSector)
                                            ->get(); ?>
                                        @if (count($subsectores) > 0)
                                            @foreach ($subsectores as $subsector)
                                                - {{ $subsector->subsector }}<br />
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <?php array_push($sectores,$objetivo->sector);  ?>
                            @endif    
                            @endforeach                            
                        </table>
                    </td>
                </tr>
            </table>
            <?php $cont = 0;
            $contods = 0; ?>
            <table style="width:100%">
                <tr>
                    <td class="value" colspan="2" style="margin-top:10px;background-color:rgb(215, 215, 215)">
                        2.3 Programas Presupuestarios
                    </td>
                </tr>
                <tr>
                    <td class="value" colspan="1" rowspan="{{ count($programas)>0?count($programas):1 }}"
                        style="margin-top:10px;width:30%;">
                        2.3.1 Nombre de los Programas Presupuestarios
                    </td>
                    @if(count($programas)>0)
                    @foreach ($programas as $programa)
                        <?php $cont++; ?>
                        @if ($cont == 1)
                            <td class="text" style="margin-top:10px;width:70%;">
                                {{ $programa->clavePrograma }}
                                {{ $programa->descripcionPrograma }}
                            </td>
                        </tr>
                        @else
                            <tr>
                                <td class="text" colspan="1" style="margin-top:10px;width:70%">
                                    {{ $programa->clavePrograma }}
                                    {{ $programa->descripcionPrograma }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @else
                            <td class="text" colspan="1" style="margin-top:10px;width:70%">
                                Sin programas Prespuestarios!
                            </td>   
                        </tr>
                @endif
                <tr>
                    <td class="value" colspan="1" rowspan="{{count($objetivosods)}}" style="margin-top:10px;width:30%">
                        2.3.2 Objetivos de Desarrollo Sostenible
                    </td>

                    @foreach ($objetivosods as $objetivo)
                        <?php $contods++; ?>
                        @if ($contods == 1)
                            <td class="text" colspan="1" style="margin-top:10px;width:70%">
                                {{ $objetivo->clave }}
                                {{ $objetivo->descripcion }}
                            </td>
                </tr>
            @else
                <tr>
                    <td class="text" colspan="1" style="margin-top:10px;width:70%">
                        {{ $objetivo->clave }}
                        {{ $objetivo->descripcion }}
                    </td>
                </tr>
                @endif
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

            <!--<br pagebreak="true" />-->            
            <table style="width:100%">
                <tr>
                    <td class="field" colspan="10">
                        3. Comportamiento de las variables programadas
                    </td>
                </tr>
                <tr>
                    <td class="value" colspan="1" rowspan="2"
                        style="width:25%;background-color:rgb(215, 215, 215)">
                        3.1 Variables
                    </td>
                    <td class="value" colspan="1" rowspan="2"
                        style="width:25%;background-color:rgb(215, 215, 215)">
                        3.2 Unidad de Medida
                    </td>
                    <td class="value" colspan="8" rowspan="1"
                        style="width:50%;background-color:rgb(215, 215, 215)">
                        3.1 Comportamiento programado (años)
                    </td>
                </tr>
                <tr style="font-size: .8em !important;;">
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215); text-align:center">B2021</td>
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215);text-align:center">2022</td>
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215);text-align:center">2023</td>
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215);text-align:center">2024</td>
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215);text-align:center">2025</td>
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215);text-align:center">2026</td>
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215);text-align:center">2027</td>
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215);text-align:center">2028</td>
                </tr>
                @foreach ($variables as $variable)
                    <?php
                        $vals = [
                            "2022"=>'',
                            "2023"=>'',
                            "2024"=>'',
                            "2025"=>'',
                            "2026"=>'',
                            "2027"=>'',
                            "2028"=>'',
                    ];
                    $valores = DB::table("valoresvariable")->where("idVariable",$variable->idVariable)->get();
                    foreach($valores as $val){
                        $vals[$val->valoresAnioMedicion]=$val->valoresProgramado;
                    }                                
                    ?>

                    <tr style="font-size: .8em !important;;">
                        <td class="value" colspan="1" style="width:25%;"> {{ $variable->variableNombre }}</td>
                        <td class="value" colspan="1" style="width:25%;"> {{ $variable->variableUM }}</td>
                        <td class="value" colspan="1" style="width:6.25%;"></td>
                        <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$vals["2022"]}}</td>
                        <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$vals["2023"]}}</td>
                        <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$vals["2024"]}}</td>
                        <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$vals["2025"]}}</td>
                        <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$vals["2026"]}}</td>
                        <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$vals["2027"]}}</td>
                        <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$vals["2028"]}}</td>
                    </tr>
                @endforeach
                                               
                <tr style="font-size: .8em !important;;">
                    <td class="value" colspan="1" style="width:25%;">3.4 valores del indicador</td>
                    <td class="value" colspan="1" style="width:25%;"></td>
                    <td class="value" colspan="1" style="width:6.25%;"></td>
                    <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valoresprogramados["2022"]}}</td>
                    <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valoresprogramados["2023"]}}</td>
                    <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valoresprogramados["2024"]}}</td>
                    <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valoresprogramados["2025"]}}</td>
                    <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valoresprogramados["2026"]}}</td>
                    <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valoresprogramados["2027"]}}</td>
                    <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valoresprogramados["2028"]}}</td>
                </tr>
            </table>

            <table style="width:100%">
                <tr>
                    <td class="field" colspan="10" style="margin-top:10px;">
                        4. Comportamiento de las variables reales
                    </td>
                </tr>
                <tr>
                    <td class="value" colspan="1" rowspan="2"
                        style="width:25%;background-color:rgb(215, 215, 215)">
                        4.1 Variables
                    </td>
                    <td class="value" colspan="1" rowspan="2"
                        style="width:25%;background-color:rgb(215, 215, 215)">
                        4.2 Fuentes(medios de verificación)
                    </td>
                    <td class="value" colspan="8" rowspan="1"
                        style="width:50%;background-color:rgb(215, 215, 215)">
                        4.1 Comportamiento real (años)
                    </td>
                </tr>
                <tr style="font-size: .8em !important;;">
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215); text-align:center">B2021</td>
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215);text-align:center">2022</td>
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215);text-align:center">2023</td>
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215);text-align:center">2024</td>
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215);text-align:center">2025</td>
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215);text-align:center">2026</td>
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215);text-align:center">2027</td>
                    <td class="value" colspan="1"
                        style="width:6.25%;background-color:rgb(215, 215, 215);text-align:center">2028</td>
                </tr>
                @foreach ($variables as $variable)
                <?php
                $valsr = [
                            "2022"=>'',
                            "2023"=>'',
                            "2024"=>'',
                            "2025"=>'',
                            "2026"=>'',
                            "2027"=>'',
                            "2028"=>'',
                    ];
                    $valores = DB::table("valoresvariable")->where("idVariable",$variable->idVariable)->get();
                    foreach($valores as $val){
                        $valsr[$val->valoresAnioMedicion]=$val->valoresReal;
                    }
                    ?>
                    <tr style="font-size: .8em !important;;">
                        <td class="value" colspan="1" style="width:25%;"> {{ $variable->variableNombre }}</td>
                        <td class="value" colspan="1" style="width:25%;"> {{ $variable->variableUM }}</td>
                        <td class="value" colspan="1" style="width:6.25%;"></td>
                        <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valsr["2022"]}}</td>
                        <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valsr["2023"]}}</td>
                        <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valsr["2024"]}}</td>
                        <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valsr["2025"]}}</td>
                        <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valsr["2026"]}}</td>
                        <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valsr["2027"]}}</td>
                        <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valsr["2028"]}}</td>
                    </tr>
                @endforeach
                <tr style="font-size: .8em !important;;">
                    <td class="value" colspan="1" style="width:25%;">3.4 valores del indicador</td>
                    <td class="value" colspan="1" style="width:25%;"></td>
                    <td class="value" colspan="1" style="width:6.25%;"></td>
                    <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valoresreales["2022"]}}</td>
                    <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valoresreales["2023"]}}</td>
                    <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valoresreales["2024"]}}</td>
                    <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valoresreales["2025"]}}</td>
                    <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valoresreales["2026"]}}</td>
                    <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valoresreales["2027"]}}</td>
                    <td class="value" colspan="1" style="width:6.25%;text-align:right">{{$valoresreales["2028"]}}</td>
                </tr>
            </table>

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
            </table>

            <table style="width:100%">
                <tr>
                    <td class="field" colspan="4"> 6. Datos de los Responsables de la Información</td>
                </tr>
                <tr>
                    <td class="value" colspan="4"> 6.1 Nombre de la dependencia: <span style="font-weight:normal"> {{$indicador->dependenciaNombre." (".$indicador->dependenciaSiglas.")"}}</span></td>
                </tr>
                <tr>
                    <td class="value" style="" colspan="2">6.2 Datos del Titular de la Dependencia</td>
                    <td class="value" style="" colspan="2">6.3 Datos del Enlace Institucional</td>
                </tr>
                <tr>
                    <td class="value" style="width:15%">6.2.1 Nombre:</td>
                    <td class="text" style="width:35%">{{$titular==null?"":$titular->nombre}}</td>
                    <td class="value" style="width:15%">6.3.1 Nombre:</td>
                    <td class="text" style="width:35%">{{$enlace==null?"":$enlace->nombre." ".$enlace->apellidoP." ".$enlace->apellidoM}}</td>
                </tr>
                <tr>
                    <td class="value" style="width:15%">6.2.2 Cargo:</td>
                    <td class="text" style="width:35%">{{$titular==null?"":$titular->cargo}}</td>
                    <td class="value" style="width:15%">6.3.2 Cargo:</td>
                    <td class="text" style="width:35%">{{$enlace==null?"":$enlace->cargo}}</td>
                </tr>
                <tr>
                    <td class="value" style="width:15%">6.2.3 Firma:</td>
                    <td class="text" style="width:35%;height:50px;"></td>
                    <td class="value" style="width:15%">6.3.3 Firma:</td>
                    <td class="text" style="width:35%;height:70px;"></td>
                </tr>
            </table>

            <table style="width:100%">
                <tr>
                    <td class="value" style="width: 30%"> 6.4 Fecha de actualización</td>
                    <td class="text" style="width: 70%"> {{date("Y m d H:i:s")}} </td>
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
        font-weight: bold;
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
        font-weight: bold;
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
</style>
