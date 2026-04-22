@php
    use App\Models\LineaPED;
    use App\Models\Indicador;
    use App\Models\IAFuente;
    use App\Models\IABSEntrega;
    use App\Models\IABSPoblacion;
    use App\Models\IABSArea;
    use App\Models\IABSRegion;
    use App\Models\IABSPresupuesto;
@endphp
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programa de Comedores Populares para el Bienestar</title>
    <style>
    body { font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; }
    .container { max-width: 1200px; margin: 20px auto; padding: 20px; background-color: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
    .section { margin: 20px 0; }
    .encabezado { width: 100%; text-align: center; background-color: #525f8d; color: white; padding: 10px;font-weight: bold; height: 30px;line-height: .8cm }
    .encabezado-2 {width: 100%; text-align: center; background-color: #B9C6DE; color: black; padding: 10px;font-weight: bold; height: 30px;line-height: .8cm }
    .encabezado-3 { width: 100%;text-align: center; background-color: #d7e3f9; color: black; padding: 10px;font-weight: bold; height: 30px;line-height: .8cm }
    .first-column { background-color: #BAC7DC; color: black; font-weight: bold; height: 30px;margin: 10px;}
    .second-column { background-color: #f0f0f0; color: black;text-align: justify; }
    .cgris { background-color: #bebfbf; color: black; font-weight: bold;text-align: center;height: 20px;line-height: .5cm }
    .b-1 { background-color: #B9C6DE; color: black; font-weight: bold; }
    .table-firmas{ border-collapse: collapse; width: 100%;margin-top: 30px; border: 3px solid #616ea0; }
    .cf {   border-left: 1px solid #616ea0;border-right: 1px solid #616ea0; text-align: center;background-color: #616ea0;color: white; padding: 10px;font-weight: bold; }
    .cf-1 {     border-left: 1px solid #616ea0;border-right: 1px solid #616ea0; text-align:center;background-color: #ffffff;padding: 30px;;font-weight: normal;}
    .cf-2 {     border-left: 1px solid #616ea0;border-right: 1px solid #616ea0;text-align: center;background-color: #ffffff;color: black;padding: 10px;font-weight: bold;  }
    table { border: 1px solid #525f8d; width: 100%; border-collapse: collapse; margin-top: 20px;table-layout: fixed; }
    th, td { padding: 12px; text-align: left; border: 2px solid #ffffff; }
    th { background-color: #525f8d; color: white; text-align: center; /* Centrar el texto en los encabezados */ }
    td { text-align: left; /* Alineación izquierda para los datos */ }
    .celdas-8 { width: 12.5%; } /* Ajustar el ancho de la celda a 80% */
    .celdas-15 { width: 5.55%; } /* Ajustar el ancho de la celda a 80% */
    .celdas-10 { width: 5%; } 
    .codigo-formato {font-family: helvetica, sans-serif; font-size: 12pt;color: #ad8e65;text-align: right;}
    </style>
</head>
<div class="codigo-formato">
    F-SIIBIEN-ITAR-01
</div>

<body>
    <div class="container">
        <table>
            <tr>
                <td class="first-column">Nombre de PPA:</td>
                <td class="second-column" colspan="3">{{$infoPPA->nombre}}</td>
                <td class="first-column">Año reportado:</td>
                <td class="second-column">{{$anio}}</td>
            </tr>
        </table>
        <table>
            <!-- Daros Generales -->
            <tr>
                <th class="encabezado" colspan="6">Datos Generales</th>
            </tr>
            <tr>
                <th class="first-column">Dependencia/Entidad Responsable</th>
                <td class="second-column">{{$infoPPA->dependenciaNombre . " (" . $infoPPA->dependenciaSiglas . ")"}}</td>
                <th class="first-column">Cobertura</th>
                <td class="second-column">{{$infoPPA->cobertura}}</td>
                <th class="First-column">Año de inicio</th>
                <td class="second-column">{{$infoPPA->anio_inicio}}</td>
            </tr>
            <tr>
                <th class="first-column" colspan="1">Objetivo</th>
                <td class="second-column" colspan="5">{{$infoPPA->objetivo}}</td>
            </tr>
            <tr>
                <th class="first-column" colspan="1">Descripción</th>
                <td class="second-column" colspan="5">{{$infoPPA->descripcion}}</td>
            </tr>
            <!-- Alineacion -->
            @if($alineacion != null)
                @php
                    $ejes_transversales = [
                        "igualdad" => "Igualdad de Género",
                        "desarollo" => "Desarrollo Sostenible y Cambio Climático",
                        "ninas" => "Niñas, Niños y Adolescentes",
                        "interculturalidad" => "Interculturalidad"
                    ];
                    $transversales = explode(" ", $alineacion->ejes_trans);
                    $trans_t = "";
                    $lineas = "";
                    $lin_array = explode("|", $alineacion->lineas);
                    array_pop($lin_array);

                    $indicadores = "";
                    $indicadores_array = explode("|", $alineacion->i_estrategicos);
                    array_pop($indicadores_array);

                    foreach ($indicadores_array as $key => $indicador) {
                        $infoIndicador = Indicador::where("idIndicador", $indicador)->first();
                        if ($infoIndicador != null) {
                            $indicadores .= "[" . $infoIndicador->idIndicador . "] " . $infoIndicador->indicadorNombre . ", ";
                        }

                    }

                    foreach ($lin_array as $key => $linea) {
                        $infol = LineaPED::where("idLAPED", $linea)->first();
                        if ($infol != null)
                            $lineas .= $infol->laPEDClave . " " . $infol->laPEDDescripcion . "\n";
                    }

                    foreach ($transversales as $trans) {
                        if ($trans != "") {
                            $trans_t .= $ejes_transversales["" . $trans . ""] . ", ";
                        }
                    }
                @endphp
                <tr>
                    <th class="encabezado-2" colspan="6">Alineacion</th>
                </tr>
                <tr>
                    <th class="encabezado-3" colspan="6">Plan Estatal de Desarrollo 2022-2028</th>
                </tr>
                <tr>
                    <th class="first-column">Eje</th>
                    <td class="second-column" colspan="2">{{$alineacion->ejePEDClave . " " . $alineacion->ejePEDDescripcion}}
                    </td>
                    <th class="first-column">Tema</th>
                    <td class="second-column" colspan="2">{{$alineacion->temaPEDClave . " " . $alineacion->temaPEDDescripcion}}
                    </td>
                </tr>
                <tr>
                    <th class="first-column">Objetivo</th>
                    <td class="second-column" colspan="2">
                        {{$alineacion->objetivoPEDClave . " " . $alineacion->objetivoPEDDescripcion}}</td>
                    <th class="first-column">Lineas de accion</th>
                    <td class="second-column" colspan="2">{{$lineas}}</td>
                </tr>
                <tr>
                    <th class="first-column">Ejes transversales</th>
                    <td class="second-column" colspan="5">{{$trans_t}}</td>
                </tr>
                <tr>
                    <th class="encabezado-3" colspan="6">Planes Estratégicos Sectoriales /Planes especiales</th>
                </tr>

                <tr>
                    <th class="first-column">Sector / Transversal</th>
                    <td class="second-column" colspan="2">{{$alineacion->claveSector . " " . $alineacion->sector}}</td>
                    <th class="first-column">Objetivo</th>
                    <td class="second-column" colspan="2">{{$alineacion->claveObjetivo . " " . $alineacion->objetivo}}</td>
                </tr>
                <tr>
                    <th class="first-column">Estrategial</th>
                    <td class="second-column" colspan="2" style="vertical-align: middle">
                        {{$alineacion->claveEstrategia . " " . $alineacion->estrategia}}</td>
                    <th class="first-column">Indicador Estrategico</th>
                    <td class="second-column" colspan="2">{{$indicadores}}</td>
                </tr>
            @endif
            <!-- Presupuesrto Gneral por año -->
            <tr>
                <th class="encabezado-2" colspan="8">Presupuesto General por año</th>
            </tr>

            @if($presupuesto->count() > 0)

                @foreach($presupuesto as $pp_id => $registros)
                    @if(!$pp_id) @continue @endif

                    @php
                        $operativo = $registros->where('tipo_gasto', 'operativo')->first();
                        $inversion = $registros->where('tipo_gasto', 'inversion')->first();

                        $clave = $operativo?->clavePrograma ?? $inversion?->clavePrograma ?? '';
                        $desc = $operativo?->descripcionPrograma ?? $inversion?->descripcionPrograma ?? '';

                    @endphp

                    <tr>
                        <th class="first-column" colspan="3">Programa Presupuestario</th>
                        <td class="second-column" colspan="5">
                            <strong>{{ $clave }}</strong> {{ $desc }}
                        </td>
                    </tr>
                    

                    @if($operativo && $operativo->aplica)
                        <tr>
                            <th class="first-column">Tipo de gasto</th>
                            <td class="second-column">Operativo</td>

                            <th class="first-column">Estado</th>
                            <td class="second-column">
                                @if($operativo->estatus == 0) No aplica
                                @elseif($operativo->estatus == 1) No disponible
                                @elseif($operativo->estatus == 2) Aplica
                                @endif
                            </td>

                            <th class="first-column">Monto</th>
                            <td class="second-column" colspan="3" style="text-align:right; font-weight:bold">
                                @if($operativo->estatus == 2)
                                    $ {{ number_format($operativo->monto, 2) }}
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @endif

                    @if($inversion && $inversion->aplica)
                        <tr>
                            <th class="first-column">Tipo de gasto</th>
                            <td class="second-column">Inversión</td>

                            <th class="first-column">Estado</th>
                            <td class="second-column">
                                @if($inversion->estatus == 0) No aplica
                                @elseif($inversion->estatus == 1) No disponible
                                @elseif($inversion->estatus == 2) Aplica
                                @endif
                            </td>

                            <th class="first-column">Monto</th>
                            <td class="second-column" colspan="3" style="text-align:right; font-weight:bold">
                                @if($inversion->estatus == 2)
                                    $ {{ number_format($inversion->monto, 2) }}
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @endif

                    @if(!$loop->last)
                        <tr>
                            <td class="encabezado-3" colspan="8" style="height:4px; padding:0;"></td>
                        </tr>
                    @endif

                @endforeach

            @else
                <tr>
                    <td colspan="8" class="second-column" style="text-align:center">
                        No existe información de presupuesto para este año.
                    </td>
                </tr>
            @endif

            <!-- Poblacion o area de enfoque objetivo -->
            <tr>
                <th class="encabezado-2" colspan="8">Poblacion o área de enfoque objetivo</th>
            </tr>
            @if($poblacion != null)
                @if(str_contains($poblacion->tipo, "p_"))
                    <tr>
                        <th class="encabezado-3" colspan="8">Poblacion Objetivo</th>
                    </tr>
                    <tr>
                        <th class="first-column ">Tipo de Población</th>
                        <td class="second-column" colspan="2">{{$poblacion->descripcion . " " . $poblacion->tipo_poblacion_otro}}
                        </td>
                        <th class="first-column ">Descripción</th>
                        <td class="second-column " colspan="4">{{$poblacion->descripcion_poblacion}}</td>

                    </tr>
                    <tr>
                        <th class="first-column ">Total</th>
                        <td class="second-column " colspan="3">{{$infoP != null ? $infoP->total : ""}}</td>
                        <th class="first-column ">Mujeres</th>
                        <td class="second-column " colspan="">{{$infoP != null ? $infoP->mujeres : ""}}</td>
                        <th class="first-column ">Hombres</th>
                        <td class="second-column " colspan="">{{$infoP != null ? $infoP->hombres : ""}}</td>
                    </tr>
                @endif
                @if(str_contains($poblacion->tipo, "a_"))
                    <tr>
                        <th class="encabezado-3" colspan="8">Área de enfoque objetivo</th>
                    </tr>
                    <tr>
                        <th class="first-column ">Nombre</th>
                        <td class="second-column " colspan="3">{{$poblacion->nombre_enfoque}}</td>
                        <th class="first-column ">Descripcion</th>
                        <td class="second-column " colspan="">{{$poblacion->descripcion_area}}</td>
                        <th class="first-column ">Total</th>
                        <td class="second-column " colspan="">{{$infoP != null ? $infoP->total_area : ""}}</td>
                    </tr>
                @endif
                <!--Impacto esperado -->
                @php
                    $impactos_a = [
                        "social" => "Social",
                        "economico" => "Económico",
                        "ambiental" => "Ambiental"
                    ];
                    $impactos = $infoP != null ? $infoP->impacto_esperado : "";
                    $impacto_cadena = "";
                    if ($impactos != "") {
                        $impactos_s = explode(" ", $infoP->impacto_esperado);
                        //dd($impactos);
                        foreach ($impactos_s as $key => $impacto) {
                            $impacto_cadena .= $impactos_a["" . $impacto . ""] . " ";
                        }
                    }
                @endphp
                <tr>
                    <th class="encabezado-2" colspan="8">Impacto esperado</th>
                </tr>
                <tr>
                    <th class="first-column ">Tipo</th>
                    <td class="second-column ">{{$impacto_cadena}}</td>
                    <th class="first-column ">Descripcion</th>
                    <td class="second-column " colspan="5">{{$infoP != null ? $infoP->descripcion_impacto : ""}}</td>

                </tr>
            @endif
        </table><br><br>
        <!--Tabla de Bienes o Servicios -->
        <table>
            <tr>
                <th class="encabezado" colspan="8">Bienes o Servicios</th>
            </tr>
            <!-- Datos Generales -->
            @if($bss->count() > 0)
                @foreach ($bss as $bs)
                    @php
                        //obtenemos las metas del bien o servicio
                        $metasBS = IABSEntrega::where("idBS", $bs->idBS)->where("anio", $anio)->first();
                        $totalP = $metasBS != null ? ($metasBS->p1 + $metasBS->p2 + $metasBS->p3 + $metasBS->p4) : "0";
                        $totalR = $metasBS != null ? ($metasBS->r1 + $metasBS->r2 + $metasBS->r3 + $metasBS->r4) : "0";

                        if ($metasBS != null)
                            $av1 = $metasBS->p1 != 0 ? ((float) $metasBS->r1 / (float) $metasBS->p1) * 100 : "0";
                        else
                            $av1 = 0;

                        if ($metasBS != null)
                            $av2 = $metasBS->p2 != 0 ? ((float) $metasBS->r2 / (float) $metasBS->p2) * 100 : "0";
                        else
                            $av2 = 0;

                        if ($metasBS != null)
                            $av3 = $metasBS->p3 != 0 ? ((float) $metasBS->r3 / (float) $metasBS->p3) * 100 : "0";
                        else
                            $av3 = 0;

                        if ($metasBS != null)
                            $av4 = $metasBS->p4 != 0 ? ((float) $metasBS->r4 / (float) $metasBS->p4) * 100 : "0";
                        else
                            $av4 = 0;

                        if ($totalR == 0 || $totalP == 0)
                            $avT = 0;
                        else
                            $avT = ((float) $totalR / (float) $totalP) * 100;
                    @endphp
                    <tr>
                        <th class="encabezado" colspan="8">Bien o Servicio</th>
                    </tr>
                    <tr>
                        <th class="encabezado-2" colspan="8">Datos Generales</th>
                    </tr>
                    <tr>
                        <th class="first-column ">Nombre</th>
                        <td class="second-column " colspan="3">{{$bs->nombreBS}}</td>
                        <th class="first-column ">Periodicidad de entrega</th>
                        <td class="second-column " colspan="">{{$bs->p_entrega}}</td>
                        <th class="first-column ">Unidad de medida</th>
                        <td class="second-column " colspan="">{{$bs->unidad_medidaBS}}</td>
                    </tr>
                    <tr>
                        <th class="first-column ">Descipcion</th>
                        <td class="second-column " colspan="7">{{$bs->descripcionBS}}</td>
                    </tr>
                    <!--Programación de metas -->
                    <tr>
                        <th class="encabezado-2" colspan="6">Programación de metas</th>
                    </tr>
                    <tr>
                        <th class="cgris">Concepto/Trimestre</th>
                        <th class="cgris">Enero-Marzo</th>
                        <th class="cgris">Abril-Junio</th>
                        <th class="cgris">Julio-Septiembre</th>
                        <th class="cgris">Octubre-Diciembre</th>
                        <th class="cgris">Total</th>
                    </tr>
                    <tr>
                        <th class="b-1">Programado</th>
                        <th class="second-column " style="text-align: right">
                            {{$metasBS != null ? number_format((float) ($metasBS->p1), 2) : ""}}</th>
                        <th class="second-column " style="text-align: right">
                            {{$metasBS != null ? number_format((float) ($metasBS->p2), 2) : ""}}</th>
                        <th class="second-column " style="text-align: right">
                            {{$metasBS != null ? number_format((float) ($metasBS->p3), 2) : ""}}</th>
                        <th class="second-column " style="text-align: right">
                            {{$metasBS != null ? number_format((float) ($metasBS->p4), 2) : ""}}</th>
                        <th class="second-column " style="text-align: right">
                            {{$metasBS != null ? number_format((float) $totalP, 2) : ""}}</th>
                    </tr>
                    <tr>
                        <th class="b-1">Realizado</th>
                        <th class="second-column " style="text-align: right">
                            {{$metasBS != null ? number_format((float) ($metasBS->r1), 2) : ""}}</th>
                        <th class="second-column " style="text-align: right">
                            {{$metasBS != null ? number_format((float) ($metasBS->r2), 2) : ""}}</th>
                        <th class="second-column " style="text-align: right">
                            {{$metasBS != null ? number_format((float) ($metasBS->r3), 2) : ""}}</th>
                        <th class="second-column " style="text-align: right">
                            {{$metasBS != null ? number_format((float) ($metasBS->r4), 2) : ""}}</th>
                        <th class="second-column " style="text-align: right">
                            {{$metasBS != null ? number_format((float) $totalR, 2) : ""}}</th>
                    </tr>
                    <tr>
                        <th class="cgris">Avance</th>
                        <th class="cgris">{{number_format($av1, 2) . "%"}}</th>
                        <th class="cgris">{{number_format($av2, 2) . "%"}}</th>
                        <th class="cgris">{{number_format($av3, 2) . "%"}}</th>
                        <th class="cgris">{{number_format($av4, 2) . "%"}}</th>
                        <th class="cgris">{{number_format($avT, 2) . "%"}}</th>
                    </tr>

                    <!--Obtenemos información de la población objetivo atendida si la hubiere -->
                    @php
                        $poblacion_ob = IABSPoblacion::where("idBS", $bs->idBS)->where("anio", $anio)->first();
                        $area = IABSArea::where("idBS", $bs->idBS)->where("anio", $anio)->first();
                        $region1 = IABSRegion::where("idBS", $bs->idBS)->where("anio", $anio)->where("idRegion", 1)->first();
                        $region2 = IABSRegion::where("idBS", $bs->idBS)->where("anio", $anio)->where("idRegion", 2)->first();
                        $region3 = IABSRegion::where("idBS", $bs->idBS)->where("anio", $anio)->where("idRegion", 5)->first();
                        $region4 = IABSRegion::where("idBS", $bs->idBS)->where("anio", $anio)->where("idRegion", 3)->first();
                        $region5 = IABSRegion::where("idBS", $bs->idBS)->where("anio", $anio)->where("idRegion", 4)->first();
                        $region6 = IABSRegion::where("idBS", $bs->idBS)->where("anio", $anio)->where("idRegion", 6)->first();
                        $region7 = IABSRegion::where("idBS", $bs->idBS)->where("anio", $anio)->where("idRegion", 7)->first();
                        $region8 = IABSRegion::where("idBS", $bs->idBS)->where("anio", $anio)->where("idRegion", 8)->first();
                    @endphp
                    @if($poblacion_ob != null)
                        @php
                            //realizamos sumatorias
                            $tp1 = $poblacion_ob->pm1 + $poblacion_ob->ph1;
                            $tp2 = $poblacion_ob->pm2 + $poblacion_ob->ph2;
                            $tp3 = $poblacion_ob->pm3 + $poblacion_ob->ph3;
                            $tp4 = $poblacion_ob->pm4 + $poblacion_ob->ph4;

                            $ta1 = $poblacion_ob->am1 + $poblacion_ob->ah1;
                            $ta2 = $poblacion_ob->am2 + $poblacion_ob->ah2;
                            $ta3 = $poblacion_ob->am3 + $poblacion_ob->ah3;
                            $ta4 = $poblacion_ob->am4 + $poblacion_ob->ah4;



                            $tmp = $poblacion_ob->pm1 + $poblacion_ob->pm2 + $poblacion_ob->pm3 + $poblacion_ob->pm4;
                            $thp = $poblacion_ob->ph1 + $poblacion_ob->ph2 + $poblacion_ob->ph3 + $poblacion_ob->ph4;
                            $tp = $tmp + $thp;

                            $tma = $poblacion_ob->am1 + $poblacion_ob->am2 + $poblacion_ob->am3 + $poblacion_ob->am4;
                            $tha = $poblacion_ob->ah1 + $poblacion_ob->ah2 + $poblacion_ob->ah3 + $poblacion_ob->ah4;
                            $ta = $tma + $tha;


                            $am1 = $poblacion_ob->pm1 != 0 ? ($poblacion_ob->am1 / $poblacion_ob->pm1) * 100 : 0;
                            $am2 = $poblacion_ob->pm2 != 0 ? ($poblacion_ob->am2 / $poblacion_ob->pm2) * 100 : 0;
                            $am3 = $poblacion_ob->pm3 != 0 ? ($poblacion_ob->am3 / $poblacion_ob->pm3) * 100 : 0;
                            $am4 = $poblacion_ob->pm4 != 0 ? ($poblacion_ob->am4 / $poblacion_ob->pm4) * 100 : 0;

                            $ah1 = $poblacion_ob->ph1 != 0 ? ($poblacion_ob->ah1 / $poblacion_ob->ph1) * 100 : 0;
                            $ah2 = $poblacion_ob->ph2 != 0 ? ($poblacion_ob->ah2 / $poblacion_ob->ph2) * 100 : 0;
                            $ah3 = $poblacion_ob->ph3 != 0 ? ($poblacion_ob->ah3 / $poblacion_ob->ph3) * 100 : 0;
                            $ah4 = $poblacion_ob->ph4 != 0 ? ($poblacion_ob->ah4 / $poblacion_ob->ph4) * 100 : 0;


                            $at1 = $tp1 != 0 ? ($ta1 / $tp1) * 100 : 0;
                            $at2 = $tp2 != 0 ? ($ta2 / $tp2) * 100 : 0;
                            $at3 = $tp3 != 0 ? ($ta3 / $tp3) * 100 : 0;
                            $at4 = $tp4 != 0 ? ($ta4 / $tp4) * 100 : 0;

                            $atm = $tmp != 0 ? ($tma / $tmp) * 100 : 0;
                            $ath = $thp != 0 ? ($tha / $thp) * 100 : 0;

                            $tta = $tp != 0 ? ($ta / $tp) * 100 : 0;




                        @endphp
                        <tr><!-- Poblacion o area de enfoque-->
                            <th class="encabezado-2" colspan="6">Población o área de enfoque atendida</th>
                        </tr>
                        <tr>
                            <!--Poblacion atendida-->
                            <th class="encabezado-3" colspan="6">Población atendida</th>
                        </tr>
                        <tr>
                            <th class="cgris">Trimestre</th>
                            <th class="cgris">Enero-Marzo</th>
                            <th class="cgris">Abril-Junio</th>
                            <th class="cgris">Julio-Septiembre</th>
                            <th class="cgris">Octubre-Diciembre</th>
                            <th class="cgris">Total</th>
                        </tr>
                        <tr style="font-size:.9em">
                            <th class="cgris">Concepto</th>
                            <th class="cgris celdas-15">M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15">Total</th>
                            <th class="cgris celdas-15">M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15">Total</th>
                            <th class="cgris celdas-15">M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15">Total</th>
                            <th class="cgris celdas-15">M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15">Total</th>
                            <th class="cgris celdas-15">M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15">Total</th>

                        </tr>
                        <tr style="font-size:.9em">
                            <th class="first-column">Programada</th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->pm1, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ph1, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($tp1, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->pm2, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ph2, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($tp2, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->pm3, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ph3, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($tp3, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->pm4, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ph4, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($tp4, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($tmp, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($thp, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($tp, 0)}}
                            </th>

                        </tr>
                        <tr style="font-size:.9em">
                            <th class="first-column">Atendida</th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->am1, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ah1, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($ta1, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->am2, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ah2, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($ta2, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->am3, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ah3, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($ta3, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->am4, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ah4, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($ta4, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($tma, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($tha, 0)}}
                            </th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($ta, 0)}}
                            </th>

                        </tr>
                        <tr style="font-size:.9em">
                            <th class="cgris">Avance</th>
                            <th class="cgris celdas-15">{{number_format($am1, 2) . "%"}}</th>
                            <th class="cgris celdas-15">{{number_format($ah1, 2) . "%"}}</th>
                            <th class="cgris celdas-15">{{number_format($at1, 2) . "%"}}</th>
                            <th class="cgris celdas-15">{{number_format($am2, 2) . "%"}}</th>
                            <th class="cgris celdas-15">{{number_format($ah2, 2) . "%"}}</th>
                            <th class="cgris celdas-15">{{number_format($at2, 2) . "%"}}</th>
                            <th class="cgris celdas-15">{{number_format($am3, 2) . "%"}}</th>
                            <th class="cgris celdas-15">{{number_format($ah3, 2) . "%"}}</th>
                            <th class="cgris celdas-15">{{number_format($at3, 2) . "%"}}</th>
                            <th class="cgris celdas-15">{{number_format($am4, 2) . "%"}}</th>
                            <th class="cgris celdas-15">{{number_format($ah4, 2) . "%"}}</th>
                            <th class="cgris celdas-15">{{number_format($at4, 2) . "%"}}</th>
                            <th class="cgris celdas-15">{{number_format($atm, 2) . "%"}}</th>
                            <th class="cgris celdas-15">{{number_format($ath, 2) . "%"}}</th>
                            <th class="cgris celdas-15">{{number_format($tta, 2) . "%"}}</th>

                        </tr>
                        @php
                            $hayDesgloseRegional = false;

                            $regionesTmp = [
                                $region1,
                                $region2,
                                $region3,
                                $region4,
                                $region5,
                                $region6,
                                $region7,
                                $region8
                            ];

                            foreach ($regionesTmp as $r) {
                                if (
                                    $r && (
                                        ($r->m1 + $r->h1 + $r->m2 + $r->h2 +
                                            $r->m3 + $r->h3 + $r->m4 + $r->h4) > 0
                                    )
                                ) {
                                    $hayDesgloseRegional = true;
                                    break;
                                }
                            }
                        @endphp

                        @if($hayDesgloseRegional)
                            <tr>
                                <!-- Desglose regional-->
                                <th class="encabezado-3" colspan="10">Desglose regional</th>
                            </tr>
                            <tr>
                                <th class="cgris">Trimestre / Region</th>
                                <th class="cgris ">Sierra Flores Magón</th>
                                <th class="cgris ">Costa</th>
                                <th class="cgris "> Cuenca del Papaloapan</th>
                                <th class="cgris ">Istmo</th>
                                <th class="cgris ">Mixteca</th>
                                <th class="cgris ">Sierra Juárez</th>
                                <th class="cgris ">Sierra Sur</th>
                                <th class="cgris ">Valles centrales</th>
                                <th class="cgris ">Total</th>
                            </tr>

                            <tr>
                                <th class="cgris"></th>
                                <th class="cgris celdas-10">M</th>
                                <th class="cgris celdas-10">H</th>
                                <th class="cgris celdas-10">M</th>
                                <th class="cgris celdas-10">H</th>
                                <th class="cgris celdas-10">M</th>
                                <th class="cgris celdas-10">H</th>
                                <th class="cgris celdas-10">M</th>
                                <th class="cgris celdas-10">H</th>
                                <th class="cgris celdas-10">M</th>
                                <th class="cgris celdas-10">H</th>
                                <th class="cgris celdas-10">M</th>
                                <th class="cgris celdas-10">H</th>
                                <th class="cgris celdas-10">M</th>
                                <th class="cgris celdas-10">H</th>
                                <th class="cgris celdas-10">M</th>
                                <th class="cgris celdas-10">H</th>
                                <th class="cgris celdas-10">M</th>
                                <th class="cgris celdas-10">H</th>
                            </tr>

                            @php
                                $regiones = [
                                    $region1,
                                    $region2,
                                    $region3,
                                    $region4,
                                    $region5,
                                    $region6,
                                    $region7,
                                    $region8
                                ];

                                $totalesRegion = function (string $m, string $h) use ($regiones) {
                                    $tm = 0;
                                    $th = 0;

                                    foreach ($regiones as $r) {
                                        if ($r) {
                                            $tm += $r->{$m} ?? 0;
                                            $th += $r->{$h} ?? 0;
                                        }
                                    }

                                    return [$tm, $th, $tm + $th];
                                };

                                [$totalM1, $totalH1, $totalT1] = $totalesRegion('m1', 'h1');
                                [$totalM2, $totalH2, $totalT2] = $totalesRegion('m2', 'h2');
                                [$totalM3, $totalH3, $totalT3] = $totalesRegion('m3', 'h3');
                                [$totalM4, $totalH4, $totalT4] = $totalesRegion('m4', 'h4');
                            @endphp
                            <tr>
                                <th class="first-column">Enero-Marzo</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region1 != null ? $region1->m1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region1 != null ? $region1->h1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region2 != null ? $region2->m1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region2 != null ? $region2->h1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region3 != null ? $region3->m1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region3 != null ? $region3->h1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region4 != null ? $region4->m1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region4 != null ? $region4->h1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region5 != null ? $region5->m1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region5 != null ? $region5->h1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region6 != null ? $region6->m1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region6 != null ? $region6->h1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region7 != null ? $region7->m1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region7 != null ? $region7->h1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region8 != null ? $region8->m1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region8 != null ? $region8->h1 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right"><strong>{{ $totalM1 }}</strong></th>
                                <th class="second-column celdas-10" style="text-align: right"><strong>{{ $totalH1 }}</strong></th>

                            </tr>
                            <tr>
                                <th class="first-column">Abril-Junio</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region1 != null ? $region1->m2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region1 != null ? $region1->h2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region2 != null ? $region2->m2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region2 != null ? $region2->h2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region3 != null ? $region3->m2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region3 != null ? $region3->h2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region4 != null ? $region4->m2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region4 != null ? $region4->h2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region5 != null ? $region5->m2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region5 != null ? $region5->h2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region6 != null ? $region6->m2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region6 != null ? $region6->h2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region7 != null ? $region7->m2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region7 != null ? $region7->h2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region8 != null ? $region8->m2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region8 != null ? $region8->h2 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right"><strong>{{ $totalM2 }}</strong></th>
                                <th class="second-column celdas-10" style="text-align: right"><strong>{{ $totalH2 }}</strong></th>

                            </tr>
                            <tr>
                                <th class="first-column">Julio-Septiembre</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region1 != null ? $region1->m3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region1 != null ? $region1->h3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region2 != null ? $region2->m3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region2 != null ? $region2->h3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region3 != null ? $region3->m3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region3 != null ? $region3->h3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region4 != null ? $region4->m3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region4 != null ? $region4->h3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region5 != null ? $region5->m3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region5 != null ? $region5->h3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region6 != null ? $region6->m3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region6 != null ? $region6->h3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region7 != null ? $region7->m3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region7 != null ? $region7->h3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region8 != null ? $region8->m3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region8 != null ? $region8->h3 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right"><strong>{{ $totalM3 }}</strong></th>
                                <th class="second-column celdas-10" style="text-align: right"><strong>{{ $totalH3 }}</strong></th>

                            </tr>
                            <tr>
                                <th class="first-column">Octubre-Diciembre</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region1 != null ? $region1->m4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region1 != null ? $region1->h4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region2 != null ? $region2->m4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region2 != null ? $region2->h4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region3 != null ? $region3->m4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region3 != null ? $region3->h4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region4 != null ? $region4->m4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region4 != null ? $region4->h4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region5 != null ? $region5->m4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region5 != null ? $region5->h4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region6 != null ? $region6->m4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region6 != null ? $region6->h4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region7 != null ? $region7->m4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region7 != null ? $region7->h4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region8 != null ? $region8->m4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right">{{$region8 != null ? $region8->h4 : ""}}</th>
                                <th class="second-column celdas-10" style="text-align: right"><strong>{{ $totalM4 }}</strong></th>
                                <th class="second-column celdas-10" style="text-align: right"><strong>{{ $totalH4 }}</strong></th>
                            </tr>
                        @endif
                    @endif
                    @if($area != null)
                        @php
                            $tarp = $area->arp1 + $area->arp2 + $area->arp3 + $area->arp4;
                            $tara = $area->ara1 + $area->ara2 + $area->ara3 + $area->ara4;
                            $avar1 = $area->arp1 != 0 ? ($area->ara1 / $area->arp1) * 100 : "0";
                            $avar2 = $area->arp2 != 0 ? ($area->ara2 / $area->arp2) * 100 : "0";
                            $avar3 = $area->arp3 != 0 ? ($area->ara3 / $area->arp3) * 100 : "0";
                            $avar4 = $area->arp4 != 0 ? ($area->ara4 / $area->arp4) * 100 : "0";

                            $tavar = $tarp != 0 ? ($tara / $tarp) * 100 : "0";
                        @endphp
                        @php
                            $hayDesgloseArea = false;

                            $regionesTmp = [
                                $region1,
                                $region2,
                                $region3,
                                $region4,
                                $region5,
                                $region6,
                                $region7,
                                $region8
                            ];

                            foreach ($regionesTmp as $r) {
                                if (
                                    $r && (
                                        ($r->a1 + $r->a2 + $r->a3 + $r->a4) > 0
                                    )
                                ) {
                                    $hayDesgloseArea = true;
                                    break;
                                }
                            }
                        @endphp

                        <tr>
                            <!-- aREA DE ENFOQUE Atendida-->
                            <th class="encabezado-3" colspan="6">Área de enfoque atendida</th>
                        </tr>
                        <tr>
                            <th class="cgris">Concepto/Trimestre</th>
                            <th class="cgris ">Enero-Marzo</th>
                            <th class="cgris ">Abril-Junio</th>
                            <th class="cgris ">Julio-Septiembre</th>
                            <th class="cgris ">Octubre-Diciembre</th>
                            <th class="cgris ">Total</th>
                        </tr>
                        <tr>
                            <th class="first-column">Programada</th>
                            <th class="second-column" style="text-align: right">{{$area != null ? number_format($area->arp1, 2) : ""}}</th>
                            <th class="second-column" style="text-align: right">{{$area != null ? number_format($area->arp2, 2) : ""}}</th>
                            <th class="second-column" style="text-align: right">{{$area != null ? number_format($area->arp3, 2) : ""}}</th>
                            <th class="second-column" style="text-align: right">{{$area != null ? number_format($area->arp4, 2) : ""}}</th>
                            <th class="second-column" style="text-align: right">{{number_format($tarp, 2)}}</th>
                        </tr>
                        <tr>
                            <th class="first-column">Atendida</th>
                            <th class="second-column" style="text-align: right">{{$area != null ? number_format($area->ara1, 2) : ""}}</th>
                            <th class="second-column" style="text-align: right">{{$area != null ? number_format($area->ara2, 2) : ""}}</th>
                            <th class="second-column" style="text-align: right">{{$area != null ? number_format($area->ara3, 2) : ""}}</th>
                            <th class="second-column" style="text-align: right">{{$area != null ? number_format($area->ara4, 2) : ""}}</th>
                            <th class="second-column" style="text-align: right">{{number_format($tara, 2)}}</th>
                        </tr>
                        <tr>
                            <th class="cgris">%Avance</th>
                            <th class="cgris">{{number_format($avar1, 2) . "%"}}</th>
                            <th class="cgris">{{number_format($avar2, 2) . "%"}}</th>
                            <th class="cgris">{{number_format($avar3, 2) . "%"}}</th>
                            <th class="cgris">{{number_format($avar4, 2) . "%"}}</th>
                            <th class="cgris">{{number_format($tavar, 2) . "%"}}</th>
                        </tr>
                        @if($hayDesgloseArea)
                            <tr>
                                <!-- aREA DE ENFOQUE Atendida-->
                                <th class="encabezado-3" colspan="10">Desglose regional Área de enfoque</th>
                            </tr>
                            @php
                                $regiones = [
                                    $region1,
                                    $region2,
                                    $region3,
                                    $region4,
                                    $region5,
                                    $region6,
                                    $region7,
                                    $region8
                                ];

                                $totalesAreaRegion = function (string $campo) use ($regiones) {
                                    $total = 0;

                                    foreach ($regiones as $r) {
                                        if ($r) {
                                            $total += $r->{$campo} ?? 0;
                                        }
                                    }

                                    return $total;
                                };
                            @endphp
                            <tr>
                                <th class="cgris">Trimestre/Region</th>
                                <th class="cgris ">Sierra Flores Magón</th>
                                <th class="cgris ">Costa</th>
                                <th class="cgris ">Cuenca del Papaloapan</th>
                                <th class="cgris ">Istmo</th>
                                <th class="cgris ">Mixteca</th>
                                <th class="cgris ">Sierra Juárez</th>
                                <th class="cgris ">Sierra Sur</th>
                                <th class="cgris ">Valles centrales</th>
                                <th class="cgris ">Total</th>
                            </tr>
                            <tr>
                                <th class="first-column">Enero-Marzo</th>
                                <th class="second-column " style="text-align:right">{{$region1 != null ? $region1->a1 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region2 != null ? $region2->a1 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region3 != null ? $region3->a1 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region4 != null ? $region4->a1 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region5 != null ? $region5->a1 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region6 != null ? $region6->a1 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region7 != null ? $region7->a1 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region8 != null ? $region8->a1 : ""}}</th>
                                <th class="second-column " style="text-align:right"><strong>{{ $totalesAreaRegion('a1') }}</strong></th>
                            </tr>
                            <tr>
                                <th class="first-column">Abril-Junio</th>
                                <th class="second-column " style="text-align:right">{{$region1 != null ? $region1->a2 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region2 != null ? $region2->a2 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region3 != null ? $region3->a2 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region4 != null ? $region4->a2 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region5 != null ? $region5->a2 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region6 != null ? $region6->a2 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region7 != null ? $region7->a2 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region8 != null ? $region8->a2 : ""}}</th>
                                <th class="second-column " style="text-align:right"><strong>{{ $totalesAreaRegion('a2') }}</strong></th>
                            </tr>
                            <tr>
                                <th class="first-column">Julio-Septiembre</th>
                                <th class="second-column " style="text-align:right">{{$region1 != null ? $region1->a3 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region2 != null ? $region2->a3 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region3 != null ? $region3->a3 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region4 != null ? $region4->a3 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region5 != null ? $region5->a3 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region6 != null ? $region6->a3 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region7 != null ? $region7->a3 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region8 != null ? $region8->a3 : ""}}</th>
                                <th class="second-column " style="text-align:right"><strong>{{ $totalesAreaRegion('a3') }}</strong></th>
                            </tr>
                            <tr>
                                <th class="first-column">Octubre-Diciembre</th>
                                <th class="second-column " style="text-align:right">{{$region1 != null ? $region1->a4 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region2 != null ? $region2->a4 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region3 != null ? $region3->a4 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region4 != null ? $region4->a4 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region5 != null ? $region5->a4 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region6 != null ? $region6->a4 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region7 != null ? $region7->a4 : ""}}</th>
                                <th class="second-column " style="text-align:right">{{$region8 != null ? $region8->a4 : ""}}</th>
                                <th class="second-column " style="text-align:right"><strong>{{ $totalesAreaRegion('a4') }}</strong></th>
                            </tr>
                        @endif
                    @endif
                    <tr>
                        <th class="encabezado-2" colspan="6">Presupuesto por trimestre</th>
                    </tr>

                    @php
                        $programasBS = $presupuestoBS[$bs->idBS] ?? collect();
                    @endphp

                    @if($programasBS->count() > 0)

                        @foreach($programasBS as $ppId => $registros)

                            @php
                                $operativo = $registros->where('tipo_gasto', 'operativo')->first();
                                $inversion = $registros->where('tipo_gasto', 'inversion')->first();
                                
                                $componente = null;
                                $actividades = collect();

                                if($operativo && !empty($operativo->componente_nombre)) {
                                    $componente = $operativo->componente_nombre;
                                    $actividades = $operativo->actividades_nombres ?? collect();
                                }

                                if(!$componente && $inversion && !empty($inversion->componente_nombre)) {
                                    $componente = $inversion->componente_nombre;
                                    $actividades = $inversion->actividades_nombres ?? collect();
                                }

                                $t1 = ($operativo->t1 ?? 0) + ($inversion->t1 ?? 0);
                                $t2 = ($operativo->t2 ?? 0) + ($inversion->t2 ?? 0);
                                $t3 = ($operativo->t3 ?? 0) + ($inversion->t3 ?? 0);
                                $t4 = ($operativo->t4 ?? 0) + ($inversion->t4 ?? 0);
                            @endphp

                            <tr>
                                <th class="first-column" colspan="2">Programa Presupuestario</th>
                                <td class="second-column" colspan="4">
                                    <strong>{{ $registros->first()?->clavePrograma }}</strong>
                                    {{ $registros->first()?->descripcionPrograma }}

                                </td>
                            </tr>
                            <tr>
                                <th class="first-column" colspan="2">Componente</th>
                                <td class="second-column" colspan="4">
                                    {{ $componente ?? 'No definido' }}
                                </td>
                            </tr>

                            <tr>
                                <th class="first-column" colspan="2">Actividad</th>
                                <td class="second-column" colspan="4">
                                    @if($actividades->count())
                                        @foreach($actividades as $actividad)
                                            <div>{{ $actividad }}</div>
                                        @endforeach
                                    @else
                                        No definida
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th class="cgris">Concepto / Trimestre</th>
                                <th class="cgris">Enero-Marzo</th>
                                <th class="cgris">Abril-Junio</th>
                                <th class="cgris">Julio-Septiembre</th>
                                <th class="cgris">Octubre-Diciembre</th>
                                <th class="cgris">Total</th>
                            </tr>

                            @if($operativo && $operativo->aplica == 1)
                                <tr>
                                    <th class="first-column">Gasto Operativo</th>
                                    <td class="second-column" style="text-align:right">{{ number_format($operativo->t1, 2) }}</td>
                                    <td class="second-column" style="text-align:right">{{ number_format($operativo->t2, 2) }}</td>
                                    <td class="second-column" style="text-align:right">{{ number_format($operativo->t3, 2) }}</td>
                                    <td class="second-column" style="text-align:right">{{ number_format($operativo->t4, 2) }}</td>
                                    <td class="second-column" style="text-align:right">
                                        {{ number_format($operativo->t1 + $operativo->t2 + $operativo->t3 + $operativo->t4, 2) }}
                                    </td>
                                </tr>
                            @endif

                            @if($inversion && $inversion->aplica == 1)
                                <tr>
                                    <th class="first-column">Gasto de Inversión</th>
                                    <td class="second-column" style="text-align:right">{{ number_format($inversion->t1, 2) }}</td>
                                    <td class="second-column" style="text-align:right">{{ number_format($inversion->t2, 2) }}</td>
                                    <td class="second-column" style="text-align:right">{{ number_format($inversion->t3, 2) }}</td>
                                    <td class="second-column" style="text-align:right">{{ number_format($inversion->t4, 2) }}</td>
                                    <td class="second-column" style="text-align:right">
                                        {{ number_format($inversion->t1 + $inversion->t2 + $inversion->t3 + $inversion->t4, 2) }}
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <th class="cgris">Total</th>
                                <th class="cgris" style="text-align:right">{{ number_format($t1, 2) }}</th>
                                <th class="cgris" style="text-align:right">{{ number_format($t2, 2) }}</th>
                                <th class="cgris" style="text-align:right">{{ number_format($t3, 2) }}</th>
                                <th class="cgris" style="text-align:right">{{ number_format($t4, 2) }}</th>
                                <th class="cgris" style="text-align:right">
                                    {{ number_format($t1 + $t2 + $t3 + $t4, 2) }}
                                </th>
                            </tr>

                            @if(!$loop->last)
                                <tr>
                                    <td class="encabezado-3" colspan="6" style="height:4px; padding:0;"></td>
                                </tr>
                            @endif

                        @endforeach

                    @else
                        <tr>
                            <td colspan="6" class="second-column" style="text-align:center">
                                No existe información presupuestaria registrada.
                            </td>
                        </tr>
                    @endif










                @endforeach
            @else
                <tr>
                    <td class="alert" colspan="8" style="text-align: center">No existen bienes o servicios registrados para
                        este PPA!</td>
                </tr>
            @endif
        </table>

        <table>
            <tr>
                <!-- Medios de verificacion  -->
                <th class="encabezado-2" colspan="5">Ejemplos para Difusión</th>
            </tr>
            <tr>
                <th class="cgris">Trimestre</th>
                <th class="cgris " colspan="2"> Descripcion </th>
                <th class="cgris " colspan="2">Archivo</th>
            </tr>

            <tr>
                <th class="first-column">Enero-Marzo</th>
                @if($medios1->count() > 0)
                    <td colspan="4">
                        <table style="width: 100%">
                            @foreach($medios1 as $medio1)
                                <tr>
                                    <th class="second-column " colspan="2">{{$medio1->descripcion}}</th>
                                    <th class="second-column " colspan="2"><a target="_blank"
                                            href="{{asset('medios/itar/' . $idPPA . "/" . $anio . "/1/" . $medio1->archivo)}}">{{$medio1->nombre}}</a>
                                    </th>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                @else
                    <th colspan="4">
                        <div class="alert alert-info" style="text-align: center">No existen medio cargados para este
                            trimestre</div>
                    </th>
                @endif
            </tr>
            <tr>
                <th class="first-column">Abril-Junio</th>
                @if($medios2->count() > 0)
                    <td colspan="4">
                        <table style="width: 100%">
                            @foreach($medios2 as $medio2)
                                <tr>
                                    <td class="second-column " colspan="2">{{$medio2->descripcion}}</td>
                                    <td class="second-column " colspan="2"><a target="_blank"
                                            href="{{asset('medios/itar/' . $idPPA . "/" . $anio . "/2/" . $medio2->archivo)}}">{{$medio2->nombre}}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                @else
                    <th colspan="4">
                        <div class="alert alert-info" style="text-align: center">No existen medio cargados para este
                            trimestre</div>
                    </th>
                @endif
            </tr>
            <tr>
                <th class="first-column">Julio-Septiembre</th>
                @if($medios3->count() > 0)
                    <td colspan="4">
                        <table style="width: 100%">
                            @foreach($medios3 as $medio3)
                                <tr>
                                    <td class="second-column " colspan="2">{{$medio3->descripcion}}</td>
                                    <td class="second-column " colspan="2"><a target="_blank"
                                            href="{{asset('medios/itar/' . $idPPA . "/" . $anio . "/3/" . $medio3->archivo)}}">{{$medio3->nombre}}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                @else
                    <th colspan="4">
                        <div class="alert alert-info" style="text-align: center">No existen medio cargados para este
                            trimestre</div>
                    </th>
                @endif
            </tr>
            <tr>
                <th class="first-column">Octubre-Diciembre</th>
                @if($medios4->count() > 0)
                    <td colspan="4">
                        <table style="width: 100%">
                            @foreach($medios4 as $medio4)
                                <tr>
                                    <td class="second-column " colspan="2">{{$medio4->descripcion}}</td>
                                    <td class="second-column " colspan="2"><a target="_blank"
                                            href="{{asset('medios/itar/' . $idPPA . "/" . $anio . "/4/" . $medio4->archivo)}}">{{$medio4->nombre}}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                @else
                    <th colspan="4">
                        <div class="alert alert-info" style="text-align: center">No existen medio cargados para este
                            trimestre</div>
                    </th>
                @endif
            </tr>

            <tr>
                <!--  Observacion  -->
                <th class="encabezado-2" colspan="5">Observaciones</th>
            </tr>
            <tr>
                <th class="first-column">Enero-Marzo</th>
                <th class="second-column " colspan="4">{{$obs1 != null ? $obs1->observaciones : "Sin observaciones"}}</th>
            </tr>
            <tr>
                <th class="first-column">Abirl-Junio</th>
                <th class="second-column " colspan="4">{{$obs2 != null ? $obs2->observaciones : "Sin observaciones"}}</th>
            </tr>
            <tr>
                <th class="first-column">Julio-Septiembre</th>
                <th class="second-column " colspan="4">{{$obs3 != null ? $obs3->observaciones : "Sin observaciones"}}</th>
            </tr>
            <tr>
                <th class="first-column">Octubre-Diciembre</th>
                <th class="second-column " colspan="4">{{$obs4 != null ? $obs4->observaciones : "Sin observaciones"}}</th>
            </tr>




        </table><br><br>
        <table class="table-firmas" nobr="true">
            <tr>
                <!--  Firmas  -->
                <th class="cf">Validó</th>
                <th class="cf">Revisó</th>
                <th class="cf">Elaboró</th>
            </tr>
            <tr>
                <!--  Firmas  -->
                <th class=" cf-1" style="line-height: .5cm">
                    <br /><br /><br /><br /><br />
                    _____________________________________________<br />
                    {{$titular != null ? $titular->nombre : ""}}<br />{{$titular != null ? $titular->cargo : ""}}<br />{{$infoPPA->dependenciaNombre . " (" . $infoPPA->dependenciaSiglas . ")"}}
                </th>
                <th class="cf-1">
                    <br /><br /><br /><br /><br />
                    _____________________________________________<br />
                    {{$enlaceD != null ? $enlaceD->titulo . " " . $enlaceD->nombre . " " . $enlaceD->apellidoP . " " . $enlaceD->apellidoM : ""}}<br />{{$enlaceD != null ? $enlaceD->cargo : ""}}
                </th>
                <th class=" cf-1">
                    <br /><br /><br /><br /><br />
                    _____________________________________________<br />
                    {{$enlaceO != null ? $enlaceO->titulo . $enlaceO->nombre . " " . $enlaceO->apellidoP . " " . $enlaceO->apellidoM : ""}}<br />{{$enlaceO != null ? $enlaceO->cargo : ""}}
                </th>
            </tr>
            <tr>
                <!--  Firmas  -->
                <th class=" cf-2">Titular de la Institución</th>
                <th class=" cf-2">Enlace Directivo </th>
                <th class=" cf-2">Enlace Operativo</th>
            </tr>
        </table>



    </div>


</body>

</html>