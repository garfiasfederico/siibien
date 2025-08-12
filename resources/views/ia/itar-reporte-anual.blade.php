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
    </style>
</head>
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
        <table >
          <!-- Daros Generales -->
            <tr>
                <th  class="encabezado" colspan="6" >Datos Generales</th>
            </tr>
            <tr>
                <th class="first-column">Dependencia/Entidad Responsable</th>
                <td class="second-column" >{{$infoPPA->dependenciaNombre." (".$infoPPA->dependenciaSiglas.")"}}</td>
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
            @if($alineacion!=null)
            @php
                    $ejes_transversales = [
                        "igualdad" => "Igualdad de Género",
                        "desarollo" => "Desarrollo Sostenible y Cambio Climático",
                        "ninas" => "Niñas, Niños y Adolescentes",
                        "interculturalidad" => "Interculturalidad"];
                    $transversales = explode(" ",$alineacion->ejes_trans);
                    $trans_t = "";
                    $lineas = "";
                    $lin_array = explode("|",$alineacion->lineas);
                    array_pop($lin_array);

                    $indicadores = "";
                    $indicadores_array = explode("|",$alineacion->i_estrategicos);
                    array_pop($indicadores_array);

                    foreach ($indicadores_array as $key => $indicador) {
                        $infoIndicador = Indicador::where("idIndicador",$indicador)->first();
                        if($infoIndicador != null){
                            $indicadores .= "[".$infoIndicador->idIndicador."] ".$infoIndicador->indicadorNombre.", ";
                        }

                    }

                    foreach ($lin_array as $key => $linea) {
                        $infol = LineaPED::where("idLAPED",$linea)->first();
                        if($infol!=null)
                            $lineas .= $infol->laPEDClave." ".$infol->laPEDDescripcion."\n";
                    }

                    foreach ($transversales as $trans) {
                        if($trans != ""){
                            $trans_t .= $ejes_transversales["".$trans.""].", ";
                        }
                    }
        @endphp
                <tr>
                    <th  class="encabezado-2"colspan="6" >Alineacion</th>
                </tr>
                <tr>
                    <th  class="encabezado-3"colspan="6" >Plan Estatal de Desarrollo 2022-2028</th>
                </tr>
                <tr >
                    <th class="first-column">Eje</th>
                    <td class="second-column" colspan="2">{{$alineacion->ejePEDClave." ".$alineacion->ejePEDDescripcion}}</td>
                    <th class="first-column">Tema</th>
                    <td  class="second-column"colspan="2">{{$alineacion->temaPEDClave." ".$alineacion->temaPEDDescripcion}}</td>
                </tr>
                <tr>
                    <th class="first-column">Objetivo</th>
                    <td class="second-column" colspan="2">{{$alineacion->objetivoPEDClave." ".$alineacion->objetivoPEDDescripcion}}</td>
                    <th class="first-column">Lineas de accion</th>
                    <td class="second-column" colspan="2">{{$lineas}}</td>
                </tr>
                <tr>
                    <th class="first-column">Ejes transversales</th>
                    <td class="second-column" colspan="5">{{$trans_t}}</td>
                </tr>
                <tr>
                    <th  class="encabezado-3"colspan="6" >Planes Estratégicos Sectoriales /Planes especiales</th>
                </tr>

            <tr>
                <th class="first-column">Sector / Transversal</th>
                <td class="second-column" colspan="2">{{$alineacion->claveSector." ".$alineacion->sector}}</td>
                <th class="first-column">Objetivo</th>
                <td class="second-column" colspan="2">{{$alineacion->claveObjetivo." ".$alineacion->objetivo}}</td>
            </tr>
            <tr>
                <th class="first-column">Estrategial</th>
                <td class="second-column" colspan="2" style="vertical-align: middle">{{$alineacion->claveEstrategia." ".$alineacion->estrategia}}</td>
                <th class="first-column">Indicador Estrategico</th>
                <td class="second-column" colspan="2">{{$indicadores}}</td>
            </tr>
        @endif
         <!-- Presupuesrto Gneral por año -->
        <tr>
            <th  class="encabezado-2"colspan="6" >Presupuesto General por año</th>
        </tr>
        @if($presupuesto->count()>0)
        @php
            $gasto_operativo_ids = array();
            $gasto_inversion_ids = array();
            $gasto_operativo_nombres = array();
            $gasto_inversion_nombres = array();
            foreach($presupuesto  as $pre){
                if($pre->tipo_gasto=="operativo" && $pre->pp_id!=null){
                    array_push($gasto_operativo_ids,$pre->id);
                    array_push($gasto_operativo_nombres,$pre->clavePrograma." ".$pre->descripcionPrograma);
                }

                if($pre->tipo_gasto=="inversion" && $pre->pp_id!=null){
                    array_push($gasto_inversion_ids,$pre->id);
                    array_push($gasto_inversion_nombres,$pre->clavePrograma." ".$pre->descripcionPrograma);
                }
            }
        @endphp
        @if(count($gasto_operativo_ids)>0)
        <tr>
            <th  class="encabezado-3"colspan="8" >Gasto Operativo</th>
        </tr>

        @foreach ($gasto_operativo_nombres as $key => $gastoop )

            @php
                //obtenemos las fuentes de financiamiento
                $fuentes = IAFuente::where("ia_presupuesto_tipog_id",$gasto_operativo_ids[$key])
                            ->join("fuente_financiamiento","fuente_financiamiento.idFuente","=","ia_fuente.fuente_id")
                            ->get();
            @endphp

            @if($fuentes->count()>0)

                 @foreach ($fuentes as $fuente )
                        <tr>
                            <th class="first-column" colspan="2">Programa Presupuestario</th>
                            <td class="second-column" colspan="2">{{$gastoop}}</td>
                            <th class="first-column" colspan="2">Fuente de financiamiento</th>
                            <td class="second-column" colspan="2">{{$fuente->fuente}}</td>
                        </tr>
                        <tr>
                            <th class="first-column celdas-8">Monto Total</th>
                            <td class="second-column celdas-8">$ {{number_format($fuente->monto_total,2)}}</td>
                            <th class="first-column celdas-8">Federal</th>
                            <td class="second-column celdas-8">$ {{number_format($fuente->monto_federal,2)}}</td>
                            <th class="first-column celdas-8">Estatal</th>
                            <td class="second-column celdas-8">$ {{number_format($fuente->monto_estatal,2)}}</td>
                            <th class="first-column celdas-8">Municipal</th>
                            <td class="second-column celdas-8">$ {{number_format($fuente->monto_municipal,2)}}</td>
                        </tr>
                @endforeach
            @else
                <tr>
                    <th class="first-column">Programa Presupuestario</th>
                    <td class="second-column" colspan="2">{{$gastoop}}</td>
                    <th class="first-column">Fuente de financiamiento</th>
                    <td class="second-column" colspan="2"><div class="alert alert-info">No se registraron fuentes de financimiento para este Programa Prespuestario</div></td>
                </tr>
            @endif
        @endforeach
        @endif

        @if(count($gasto_inversion_ids)>0)
            <tr>
                <th  class="encabezado-3"colspan="8" >Gasto de Inversion</th>
            </tr>


            @foreach ($gasto_inversion_nombres as $key => $gastoin )
                @php
                //obtenemos las fuentes de financiamiento
                $fuentes = IAFuente::where("ia_presupuesto_tipog_id",$gasto_inversion_ids[$key])
                            ->join("fuente_financiamiento","fuente_financiamiento.idFuente","=","ia_fuente.fuente_id")
                            ->get();
                @endphp

                @if($fuentes->count()>0)
                @foreach ($fuentes as $fuente )
                    <tr>
                        <th class="first-column" colspan="2">Programa Presupuestario</th>
                        <td class="second-column" colspan="2">{{$gastoin}}</td>
                        <th class="first-column" colspan="2">Fuente de financiamiento</th>
                        <td class="second-column" colspan="2">{{$fuente->fuente}}</td>
                    </tr>
                    <tr >
                        <th class="first-column celdas-8">Monto Total</th>
                        <td class="second-column celdas-8">$ {{number_format($fuente->monto_total,2)}}</td>
                        <th class="first-column celdas-8">Federal</th>
                        <td class="second-column celdas-8">$ {{number_format($fuente->monto_federal,2)}}</td>
                        <th class="first-column celdas-8">Estatal</th>
                        <td class="second-column celdas-8">$ {{number_format($fuente->monto_estatal,2)}}</td>
                        <th class="first-column celdas-8">Municipal</th>
                        <td class="second-column celdas-8">$ {{number_format($fuente->monto_municipal,2)}}</td>
                    </tr>
                @endforeach
                @else
                    <tr>
                        <th class="first-column">Programa Presupuestario</th>
                        <td class="second-column" colspan="3">{{$gastoin}}</td>
                        <th class="first-column">Fuente de financiamiento</th>
                        <td class="second-column" colspan="3"><div class="alert alert-info">No se registraron fuentes de financimiento para este Programa Prespuestario</div></td>
                    </tr>
                @endif
            @endforeach
        @endif

        @endif
        <!-- Poblacion o area de enfoque objetivo -->
        <tr>
            <th  class="encabezado-2"colspan="8" >Poblacion o área de enfoque objetivo</th>
        </tr>
        @if($poblacion!=null)
        @if(str_contains($poblacion->tipo,"p_"))
            <tr>
                <th  class="encabezado-3"colspan="8" >Poblacion Objetivo</th>
            </tr>
            <tr>
                <th class="first-column ">Tipo de Población</th>
                <td class="second-column"colspan="2">{{$poblacion->descripcion." ".$poblacion->tipo_poblacion_otro}}</td>
                <th class="first-column ">Descripción</th>
                <td class="second-column "colspan="4">{{$poblacion->descripcion_poblacion}}</td>

            </tr>
            <tr>
                <th class="first-column ">Total</th>
                <td class="second-column " colspan="3">{{$infoP!=null?$infoP->total:""}}</td>
                <th class="first-column ">Mujeres</th>
                <td class="second-column "colspan="">{{$infoP!=null?$infoP->mujeres:""}}</td>
                <th class="first-column ">Hombres</th>
                <td class="second-column " colspan="">{{$infoP!=null?$infoP->hombres:""}}</td>
            </tr>
        @endif
        @if(str_contains($poblacion->tipo,"a_"))
            <tr>
                <th  class="encabezado-3"colspan="8" >Área de enfoque objetivo</th>
            </tr>
            <tr>
                <th class="first-column ">Nombre</th>
                <td class="second-column " colspan="3">{{$poblacion->nombre_enfoque}}</td>
                <th class="first-column ">Descripcion</th>
                <td class="second-column "colspan="">{{$poblacion->descripcion_area}}</td>
                <th class="first-column ">Total</th>
                <td class="second-column " colspan="">{{$infoP!=null?$infoP->total_area:""}}</td>
            </tr>
        @endif
            <!--Impacto esperado -->
            @php
                $impactos_a = [
                    "social"=>"Social",
                    "economico" => "Económico",
                    "ambiental" => "Ambiental"
                ];
                $impactos =  $infoP!=null?$infoP->impacto_esperado:"";
                $impacto_cadena = "";
                if($impactos!=""){
                    $impactos_s = explode(" ",$infoP->impacto_esperado);
                    //dd($impactos);
                    foreach ($impactos_s as $key => $impacto) {
                        $impacto_cadena .= $impactos_a["".$impacto.""]." ";
                    }
                }
            @endphp
            <tr>
                <th  class="encabezado-2"colspan="8" >Impacto esperado</th>
            </tr>
            <tr>
                <th class="first-column ">Tipo</th>
                <td class="second-column " >{{$impacto_cadena}}</td>
                <th class="first-column ">Descripcion</th>
                <td class="second-column "colspan="5">{{$infoP!=null?$infoP->descripcion_impacto:""}}</td>

            </tr>
        @endif
        </table><br><br>
        <!--Tabla de Bienes o Servicios -->
        <table>
            <tr>
                <th  class="encabezado"colspan="8" >Bienes o Servicios</th>
            </tr>
            <!-- Datos Generales -->
            @if($bss->count()>0)
                @foreach ($bss as $bs )
                    @php
                        //obtenemos las metas del bien o servicio
                        $metasBS = IABSEntrega::where("idBS",$bs->idBS)->where("anio",$anio)->first();
                        $totalP = $metasBS!=null?($metasBS->p1 + $metasBS->p2 + $metasBS->p3 + $metasBS->p4):"0";
                        $totalR = $metasBS!=null?($metasBS->r1 + $metasBS->r2 + $metasBS->r3 + $metasBS->r4):"0";

                        if($metasBS!=null)
                            $av1 =   $metasBS->p1!=0 ?((float)$metasBS->r1 / (float)$metasBS->p1)*100:"0";
                        else
                            $av1 = 0;

                        if($metasBS!=null)                            
                            $av2 =  $metasBS->p2!=0?((float)$metasBS->r2 / (float)$metasBS->p2)*100:"0";
                        else
                            $av2 = 0;

                        if($metasBS!=null)
                            $av3 =  $metasBS->p3!=0?((float)$metasBS->r3 / (float)$metasBS->p3)*100:"0";
                        else
                            $av3 = 0;

                        if($metasBS!=null)    
                            $av4 =   $metasBS->p4!=0?((float)$metasBS->r4 / (float)$metasBS->p4)*100:"0";                    
                        else
                            $av4 = 0;
                        
                        if($totalR==0 || $totalP==0)
                            $avT = 0;
                        else
                            $avT = ((float)$totalR / (float)$totalP) *100;
                    @endphp
                    <tr>
                        <th  class="encabezado"colspan="8" >Bien o Servicio</th>
                    </tr>
                    <tr>
                        <th  class="encabezado-2"colspan="8" >Datos Generales</th>
                    </tr>
                    <tr>
                        <th class="first-column ">Nombre</th>
                        <td class="second-column " colspan="3">{{$bs->nombreBS}}</td>
                        <th class="first-column ">Periodicidad de entrega</th>
                        <td class="second-column "colspan="">{{$bs->p_entrega}}</td>
                        <th class="first-column ">Unidad de medida</th>
                        <td class="second-column " colspan="">{{$bs->unidad_medidaBS}}</td>
                    </tr>
                    <tr>
                        <th class="first-column ">Descipcion</th>
                        <td class="second-column " colspan="7">{{$bs->descripcionBS}}</td>
                    </tr>
                    <!--Programación de metas -->
                    <tr>
                        <th  class="encabezado-2"colspan="6" >Programación de metas</th>
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
                        <th class="second-column " style="text-align: right">{{$metasBS!=null?number_format((float)($metasBS->p1),2):""}}</th>
                        <th class="second-column " style="text-align: right">{{$metasBS!=null?number_format((float)($metasBS->p2),2):""}}</th>
                        <th class="second-column " style="text-align: right">{{$metasBS!=null?number_format((float)($metasBS->p3),2):""}}</th>
                        <th class="second-column " style="text-align: right">{{$metasBS!=null?number_format((float)($metasBS->p4),2):""}}</th>
                        <th class="second-column " style="text-align: right">{{$metasBS!=null?number_format((float)$totalP,2):""}}</th>
                    </tr>
                    <tr>
                        <th class="b-1">Realizado</th>
                        <th class="second-column " style="text-align: right">{{$metasBS!=null?number_format((float)($metasBS->r1),2):""}}</th>
                        <th class="second-column " style="text-align: right">{{$metasBS!=null?number_format((float)($metasBS->r2),2):""}}</th>
                        <th class="second-column " style="text-align: right">{{$metasBS!=null?number_format((float)($metasBS->r3),2):""}}</th>
                        <th class="second-column " style="text-align: right">{{$metasBS!=null?number_format((float)($metasBS->r4),2):""}}</th>
                        <th class="second-column " style="text-align: right">{{$metasBS!=null?number_format((float)$totalR,2):""}}</th>
                    </tr>
                    <tr>
                        <th class="cgris">Avance</th>
                        <th class="cgris">{{number_format($av1,2)."%"}}</th>
                        <th class="cgris">{{number_format($av2,2)."%"}}</th>
                        <th class="cgris">{{number_format($av3,2)."%"}}</th>
                        <th class="cgris">{{number_format($av4,2)."%"}}</th>
                        <th class="cgris">{{number_format($avT,2)."%"}}</th>
                    </tr>

                    <!--Obtenemos información de la población objetivo atendida si la hubiere -->
                    @php
                        $poblacion_ob = IABSPoblacion::where("idBS",$bs->idBS)->where("anio",$anio)->first();
                        $area = IABSArea::where("idBS",$bs->idBS)->where("anio",$anio)->first();
                        $region1 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",1)->first();
                        $region2 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",2)->first();
                        $region3 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",3)->first();
                        $region4 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",4)->first();
                        $region5 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",5)->first();
                        $region6 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",6)->first();
                        $region7 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",7)->first();
                        $region8 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",8)->first();
                    @endphp
                    @if($poblacion_ob!=null)
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


                            $am1 = $poblacion_ob->pm1!=0?($poblacion_ob->am1 / $poblacion_ob->pm1)*100:0;
                            $am2 = $poblacion_ob->pm2!=0?($poblacion_ob->am2 / $poblacion_ob->pm2)*100:0;
                            $am3 = $poblacion_ob->pm3!=0?($poblacion_ob->am3 / $poblacion_ob->pm3)*100:0;
                            $am4 = $poblacion_ob->pm4!=0?($poblacion_ob->am4 / $poblacion_ob->pm4)*100:0;

                            $ah1 = $poblacion_ob->ph1!=0?($poblacion_ob->ah1 / $poblacion_ob->ph1)*100:0;
                            $ah2 = $poblacion_ob->ph2!=0?($poblacion_ob->ah2 / $poblacion_ob->ph2)*100:0;
                            $ah3 = $poblacion_ob->ph3!=0?($poblacion_ob->ah3 / $poblacion_ob->ph3)*100:0;
                            $ah4 = $poblacion_ob->ph4!=0?($poblacion_ob->ah4 / $poblacion_ob->ph4)*100:0;


                            $at1 =  $tp1!=0?($ta1 / $tp1)*100:0;
                            $at2 =  $tp2!=0?($ta2 / $tp2)*100:0;
                            $at3 =  $tp3!=0?($ta3 / $tp3)*100:0;
                            $at4 =  $tp4!=0?($ta4 / $tp4)*100:0;

                            $atm = $tmp!=0?($tma / $tmp)*100:0;
                            $ath = $thp!=0?($tha / $thp)*100:0;

                            $tta = $tp!=0?($ta / $tp)*100:0;




                        @endphp
                        <tr><!-- Poblacion o area de enfoque-->
                            <th  class="encabezado-2"colspan="6" >Población o área de enfoque atendida</th>
                        </tr>
                        <tr>
                            <!--Poblacion atendida-->
                            <th  class="encabezado-3"colspan="6" >Población atendida</th>
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
                            <th class="cgris celdas-15" >M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15">Total</th>
                            <th class="cgris celdas-15" >M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15">Total</th>
                            <th class="cgris celdas-15" >M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15">Total</th>
                            <th class="cgris celdas-15" >M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15">Total</th>
                            <th class="cgris celdas-15" >M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15">Total</th>

                        </tr>
                        <tr style="font-size:.9em">
                            <th class="first-column">Programada</th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->pm1,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ph1,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($tp1,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->pm2,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ph2,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($tp2,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->pm3,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ph3,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($tp3,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->pm4,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ph4,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($tp4,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($tmp,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($thp,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($tp,0)}}</th>

                        </tr>
                        <tr style="font-size:.9em">
                            <th class="first-column">Atendida</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{number_format($poblacion_ob->am1,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ah1,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($ta1,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{number_format($poblacion_ob->am2,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ah2,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($ta2,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{number_format($poblacion_ob->am3,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ah3,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($ta3,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{number_format($poblacion_ob->am4,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{number_format($poblacion_ob->ah4,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($ta4,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold" >{{number_format($tma,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($tha,0)}}</th>
                            <th class="second-column celdas-15" style="text-align: right;font-weight:bold">{{number_format($ta,0)}}</th>

                        </tr>
                        <tr style="font-size:.9em">
                            <th class="cgris">Avance</th>
                            <th class="cgris celdas-15" >{{number_format($am1,2)."%"}}</th>
                            <th class="cgris celdas-15">{{number_format($ah1,2)."%"}}</th>
                            <th class="cgris celdas-15">{{number_format($at1,2)."%"}}</th>
                            <th class="cgris celdas-15" >{{number_format($am2,2)."%"}}</th>
                            <th class="cgris celdas-15">{{number_format($ah2,2)."%"}}</th>
                            <th class="cgris celdas-15">{{number_format($at2,2)."%"}}</th>
                            <th class="cgris celdas-15" >{{number_format($am3,2)."%"}}</th>
                            <th class="cgris celdas-15">{{number_format($ah3,2)."%"}}</th>
                            <th class="cgris celdas-15">{{number_format($at3,2)."%"}}</th>
                            <th class="cgris celdas-15" >{{number_format($am4,2)."%"}}</th>
                            <th class="cgris celdas-15">{{number_format($ah4,2)."%"}}</th>
                            <th class="cgris celdas-15">{{number_format($at4,2)."%"}}</th>
                            <th class="cgris celdas-15" >{{number_format($atm,2)."%"}}</th>
                            <th class="cgris celdas-15">{{number_format($ath,2)."%"}}</th>
                            <th class="cgris celdas-15">{{number_format($tta,2)."%"}}</th>

                        </tr>
                        <tr>
                            <!-- Desglose regional-->
                            <th  class="encabezado-3"colspan="9" >Desglose regional</th>
                        </tr>
                        <tr>
                            <th class="cgris">Trimestre / Region</th>
                            <th class="cgris " >Sierra Flores Magón</th>
                            <th class="cgris ">Costa</th>
                            <th class="cgris "> Cuenca del Papaloapan</th>
                            <th class="cgris " >Istmo</th>
                            <th class="cgris ">Mixteca</th>
                            <th class="cgris ">Sierra Juárez</th>
                            <th class="cgris " >Sierra Sur</th>
                            <th class="cgris ">Valles centrales</th>                            
                        </tr>
                        <tr>
                            <th class="cgris"></th>
                            <th class="cgris celdas-15" >M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15" >M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15" >M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15" >M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15" >M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15" >M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15" >M</th>
                            <th class="cgris celdas-15">H</th>
                            <th class="cgris celdas-15" >M</th>
                            <th class="cgris celdas-15">H</th>
                        </tr>
                        <tr>
                            <th class="first-column">Enero-Marzo</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region1!=null?$region1->m1:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region1!=null?$region1->h1:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region2!=null?$region2->m1:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region2!=null?$region2->h1:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region3!=null?$region3->m1:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region3!=null?$region3->h1:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region4!=null?$region4->m1:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region4!=null?$region4->h1:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region5!=null?$region5->m1:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region5=null?$region5->h1:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region6!=null?$region6->m1:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region6!=null?$region6->h1:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region7!=null?$region7->m1:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region7!=null?$region7->h1:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region8!=null?$region8->m1:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region8!=null?$region8->h1:""}}</th>

                        </tr>
                        <tr>
                            <th class="first-column">Abril-Junio</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region1!=null?$region1->m2:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region1!=null?$region1->h2:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region2!=null?$region2->m2:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region2!=null?$region2->h2:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region3!=null?$region3->m2:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region3!=null?$region3->h2:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region4!=null?$region4->m2:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region4!=null?$region4->h2:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region5!=null?$region5->m2:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region5=null?$region5->h2:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region6!=null?$region6->m2:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region6!=null?$region6->h2:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region7!=null?$region7->m2:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region7!=null?$region7->h2:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region8!=null?$region8->m2:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region8!=null?$region8->h2:""}}</th>

                        </tr>
                        <tr>
                            <th class="first-column">Julio-Septiembre</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region1!=null?$region1->m3:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region1!=null?$region1->h3:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region2!=null?$region2->m3:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region2!=null?$region2->h3:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region3!=null?$region3->m3:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region3!=null?$region3->h3:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region4!=null?$region4->m3:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region4!=null?$region4->h3:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region5!=null?$region5->m3:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region5=null?$region5->h3:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region6!=null?$region6->m3:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region6!=null?$region6->h3:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region7!=null?$region7->m3:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region7!=null?$region7->h3:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region8!=null?$region8->m3:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region8!=null?$region8->h3:""}}</th>

                        </tr>
                        <tr>
                            <th class="first-column">Octubre-Diciembre</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region1!=null?$region1->m4:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region1!=null?$region1->h4:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region2!=null?$region2->m4:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region2!=null?$region2->h4:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region3!=null?$region3->m4:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region3!=null?$region3->h4:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region4!=null?$region4->m4:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region4!=null?$region4->h4:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region5!=null?$region5->m4:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region5=null?$region5->h4:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region6!=null?$region6->m4:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region6!=null?$region6->h4:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region7!=null?$region7->m4:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region7!=null?$region7->h4:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right" >{{$region8!=null?$region8->m4:""}}</th>
                            <th class="second-column celdas-15" style="text-align: right">{{$region8!=null?$region8->h4:""}}</th>
                        </tr>
                    @endif
                    @if($area!=null)
                        @php
                            $tarp = $area->arp1 + $area->arp2 + $area->arp3 + $area->arp4;
                            $tara = $area->ara1 + $area->ara2 + $area->ara3 + $area->ara4;
                            $avar1 = $area->arp1!=0?($area->ara1 / $area->arp1)*100:"0";
                            $avar2 = $area->arp2!=0?($area->ara2 / $area->arp2)*100:"0";
                            $avar3 = $area->arp3!=0?($area->ara3 / $area->arp3)*100:"0";
                            $avar4 = $area->arp4!=0? ($area->ara4 / $area->arp4)*100:"0";

                            $tavar =  $tarp!=0? ($tara / $tarp) * 100 : "0";
                        @endphp
                        <tr>
                            <!-- aREA DE ENFOQUE Atendida-->
                            <th  class="encabezado-3"colspan="6" >Área de enfoque atendida</th>
                        </tr>
                        <tr>
                            <th class="cgris">Concepto/Trimestre</th>
                            <th class="cgris " >Enero-Marzo</th>
                            <th class="cgris ">Abril-Junio</th>
                            <th class="cgris " >Julio-Septiembre</th>
                            <th class="cgris ">Octubre-Diciembre</th>
                            <th class="cgris " >Total</th>
                        </tr>
                        <tr>
                            <th class="first-column">Programada</th>
                            <th class="second-column" style="text-align: right">{{$area!=null?number_format($area->arp1,2):""}}</th>
                            <th class="second-column" style="text-align: right">{{$area!=null?number_format($area->arp2,2):""}}</th>
                            <th class="second-column" style="text-align: right">{{$area!=null?number_format($area->arp3,2):""}}</th>
                            <th class="second-column" style="text-align: right">{{$area!=null?number_format($area->arp4,2):""}}</th>
                            <th class="second-column" style="text-align: right">{{number_format($tarp,2)}}</th>
                        </tr>
                        <tr>
                            <th class="first-column">Atendida</th>
                            <th class="second-column" style="text-align: right">{{$area!=null?number_format($area->ara1,2):""}}</th>
                            <th class="second-column" style="text-align: right">{{$area!=null?number_format($area->ara2,2):""}}</th>
                            <th class="second-column" style="text-align: right">{{$area!=null?number_format($area->ara3,2):""}}</th>
                            <th class="second-column" style="text-align: right">{{$area!=null?number_format($area->ara4,2):""}}</th>
                            <th class="second-column" style="text-align: right">{{number_format($tara,2)}}</th>
                        </tr>
                        <tr>
                            <th class="cgris">%Avance</th>
                            <th class="cgris">{{number_format($avar1,2)."%"}}</th>
                            <th class="cgris">{{number_format($avar2,2)."%"}}</th>
                            <th class="cgris">{{number_format($avar3,2)."%"}}</th>
                            <th class="cgris">{{number_format($avar4,2)."%"}}</th>
                            <th class="cgris">{{number_format($tavar,2)."%"}}</th>
                        </tr>
                        <tr>
                            <!-- aREA DE ENFOQUE Atendida-->
                            <th  class="encabezado-3"colspan="9" >Desglose regional</th>
                        </tr>
                        <tr>
                            <th class="cgris">Trimestre/Region</th>
                            <th class="cgris " >Sierra Flores Magón</th>
                            <th class="cgris ">Costa</th>
                            <th class="cgris " >Cuenca del Papaloapan</th>
                            <th class="cgris ">Istmo</th>
                            <th class="cgris " >Mixteca</th>
                            <th class="cgris " >Sierra Juárez</th>
                            <th class="cgris " >Sierra Sur</th>
                            <th class="cgris " >Valles centrales</th>
                        </tr>
                        <tr>
                            <th class="first-column">Enero-Marzo</th>
                            <th class="second-column " style="text-align:right" >{{$region1!=null?$region1->a1:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region2!=null?$region2->a1:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region3!=null?$region3->a1:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region4!=null?$region4->a1:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region5!=null?$region5->a1:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region6!=null?$region6->a1:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region7!=null?$region7->a1:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region8!=null?$region8->a1:""}}</th>
                        </tr>
                        <tr>
                            <th class="first-column">Abril-Junio</th>
                            <th class="second-column " style="text-align:right" >{{$region1!=null?$region1->a2:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region2!=null?$region2->a2:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region3!=null?$region3->a2:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region4!=null?$region4->a2:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region5!=null?$region5->a2:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region6!=null?$region6->a2:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region7!=null?$region7->a2:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region8!=null?$region8->a2:""}}</th>
                        </tr>
                        <tr>
                            <th class="first-column">Julio-Septiembre</th>
                            <th class="second-column " style="text-align:right" >{{$region1!=null?$region1->a3:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region2!=null?$region2->a3:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region3!=null?$region3->a3:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region4!=null?$region4->a3:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region5!=null?$region5->a3:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region6!=null?$region6->a3:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region7!=null?$region7->a3:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region8!=null?$region8->a3:""}}</th>
                        </tr>
                        <tr>
                            <th class="first-column">Octubre-Diciembre</th>
                            <th class="second-column " style="text-align:right" >{{$region1!=null?$region1->a4:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region2!=null?$region2->a4:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region3!=null?$region3->a4:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region4!=null?$region4->a4:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region5!=null?$region5->a4:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region6!=null?$region6->a4:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region7!=null?$region7->a4:""}}</th>
                            <th class="second-column " style="text-align:right" >{{$region8!=null?$region8->a4:""}}</th>
                        </tr>
                    @endif
                    <tr>
                        <!-- Presupuesto ejercido -->
                        <th  class="encabezado-2"colspan="6" >Presupuesto ejercido</th>
                    </tr>
                    @php
                        $presupuestoOperativo = IABSPresupuesto::where("idBS",$bs->idBS)->where("anio",$anio)->where("tipo","o")->get();
                        $presupuestoInversion = IABSPresupuesto::where("idBS",$bs->idBS)->where("anio",$anio)->where("tipo","i")->get();

                        $operativom1 = 0;
                        $operativom2 = 0;
                        $operativom3 = 0;
                        $operativom4 = 0;

                        $operativoe1 = 0;
                        $operativoe2 = 0;
                        $operativoe3 = 0;
                        $operativoe4 = 0;

                        foreach($presupuestoOperativo as $po){
                            $operativom1 += $po->m1;
                            $operativom2 += $po->m2;
                            $operativom3 += $po->m3;
                            $operativom4 += $po->m4;
                            $operativoe1 += $po->e1;
                            $operativoe2 += $po->e2;
                            $operativoe3 += $po->e3;
                            $operativoe4 += $po->e4;
                        }
                        $totaloperativom = $operativom1 + $operativom2 + $operativom3 + $operativom4;
                        $totaloperativoe = $operativoe1 + $operativoe2 + $operativoe3 + $operativoe4;

                        $avop1 = $operativom1!=0? ($operativoe1 / $operativom1)*100:"0";
                        $avop2 = $operativom2!=0? ($operativoe2 / $operativom2)*100:"0";
                        $avop3 = $operativom3!=0? ($operativoe3 / $operativom3)*100:"0";
                        $avop4 = $operativom4!=0? ($operativoe4 / $operativom4)*100:"0";
                        $totalope = $totaloperativoe!=0? ($totaloperativoe / $totaloperativom)*100:"0";

                        $inversionm1 = 0;
                        $inversionm2 = 0;
                        $inversionm3 = 0;
                        $inversionm4 = 0;

                        $inversione1 = 0;
                        $inversione2 = 0;
                        $inversione3 = 0;
                        $inversione4 = 0;
                        foreach($presupuestoInversion as $pi){
                            $inversionm1 += $pi->m1;
                            $inversionm2 += $pi->m2;
                            $inversionm3 += $pi->m3;
                            $inversionm4 += $pi->m4;
                            $inversione1 += $pi->e1;
                            $inversione2 += $pi->e2;
                            $inversione3 += $pi->e3;
                            $inversione4 += $pi->e4;
                        }

                        $totalinversionm = $inversionm1 + $inversionm2 + $inversionm3 + $inversionm4;
                        $totalinversione = $inversione1 + $inversione2 + $inversione3 + $inversione4;


                        $avin1 = $inversionm1!=0? ($inversione1 / $inversionm1)*100:"0";
                        $avin2 = $inversionm2!=0? ($inversione2 / $inversionm2)*100:"0";
                        $avin3 = $inversionm3!=0? ($inversione3 / $inversionm3)*100:"0";
                        $avin4 = $inversionm4!=0? ($inversione4 / $inversionm4)*100:"0";
                        $totalinv = $totalinversionm!=0? ($totalinversione / $totalinversionm)*100:"0";

                    @endphp
                    @if($presupuestoOperativo->count()>0)
                    <tr>
                        <!-- Gasto Operativo  -->
                        <th  class="encabezado-3"colspan="6" > Gasto Operativo</th>
                    </tr>
                    <tr>
                        <th class="cgris">Trimestre</th>
                        <th class="cgris " > Enero-Marzo </th>
                        <th class="cgris ">Abril-Junio</th>
                        <th class="cgris ">Julio-Septiembre</th>
                        <th class="cgris ">Octubre-Diciembre</th>
                        <th class="cgris ">Total</th>

                    </tr>
                    <tr>
                        <th class="first-column">Modificado</th>
                        <th class="second-column " style="text-align: right">$ {{number_format($operativom1,2)}}</th>
                        <th class="second-column " style="text-align: right">$ {{number_format($operativom2,2)}}</th>
                        <th class="second-column " style="text-align: right">$ {{number_format($operativom3,2)}}</th>
                        <th class="second-column " style="text-align: right">$ {{number_format($operativom4,2)}}</th>
                        <th class="second-column " style="text-align: right">$ {{number_format($totaloperativom,2)}}</th>

                    </tr>
                    <tr>
                        <th class="first-column">Ejercido</th>
                        <th class="second-column" style="text-align: right;">$ {{number_format($operativoe1,2)}}</th>
                        <th class="second-column" style="text-align: right;">$ {{number_format($operativoe2,2)}}</th>
                        <th class="second-column" style="text-align: right;">$ {{number_format($operativoe3,2)}}</th>
                        <th class="second-column" style="text-align: right;">$ {{number_format($operativoe4,2)}}</th>
                        <th class="second-column" style="text-align: right;">$ {{number_format($totaloperativoe,2)}}</th>

                    </tr>
                    <tr>
                        <th class="cgris">Avance</th>
                        <th class="cgris " >{{number_format($avop1,2)."%"}}</th>
                        <th class="cgris ">{{number_format($avop2,2)."%"}}</th>
                        <th class="cgris ">{{number_format($avop3,2)."%"}}</th>
                        <th class="cgris ">{{number_format($avop4,2)."%"}}</th>
                        <th class="cgris ">{{number_format($totalope,2)."%"}}</th>

                    </tr>
                    @endif

                    @if($presupuestoInversion->count()>0)
                    <tr>
                        <!-- Gasto de Inversión  -->
                        <th  class="encabezado-3"colspan="6" > Gasto de Inversión</th>
                    </tr>
                    <tr>
                        <th class="cgris">Trimestre</th>
                        <th class="cgris " > Enero-Marzo </th>
                        <th class="cgris ">Abril-Junio</th>
                        <th class="cgris ">Julio-Septiembre</th>
                        <th class="cgris ">Octubre-Diciembre</th>
                        <th class="cgris ">Total</th>

                    </tr>
                    <tr>
                        <th class="first-column">Modificado</th>
                        <th class="second-column " style="text-align: right">$ {{number_format($inversionm1,2)}}</th>
                        <th class="second-column " style="text-align: right">$ {{number_format($inversionm2,2)}}</th>
                        <th class="second-column " style="text-align: right">$ {{number_format($inversionm3,2)}}</th>
                        <th class="second-column " style="text-align: right">$ {{number_format($inversionm4,2)}}</th>
                        <th class="second-column " style="text-align: right">$ {{number_format($totalinversionm,2)}}</th>

                    </tr>
                    <tr>
                        <th class="first-column">Ejercido</th>
                        <th class="second-column" style="text-align: right;">$ {{number_format($inversione1,2)}}</th>
                        <th class="second-column" style="text-align: right;">$ {{number_format($inversione2,2)}}</th>
                        <th class="second-column" style="text-align: right;">$ {{number_format($inversione3,2)}}</th>
                        <th class="second-column" style="text-align: right;">$ {{number_format($inversione4,2)}}</th>
                        <th class="second-column" style="text-align: right;">$ {{number_format($totalinversione,2)}}</th>

                    </tr>
                    <tr>
                        <th class="cgris">Avance</th>
                        <th class="cgris " >{{number_format($avin1,2)."%"}}</th>
                        <th class="cgris ">{{number_format($avin2,2)."%"}}</th>
                        <th class="cgris ">{{number_format($avin3,2)."%"}}</th>
                        <th class="cgris ">{{number_format($avin4,2)."%"}}</th>
                        <th class="cgris ">{{number_format($totalinv,2)."%"}}</th>

                    </tr>
                    @endif










                @endforeach
            @else
                <tr>
                    <td class="alert" colspan="8" style="text-align: center">No existen bienes o servicios registrados para este PPA!</td>
                </tr>
            @endif
            </table>

            <table>
            <tr>
                <!-- Medios de verificacion  -->
                <th  class="encabezado-2"colspan="5" >Medios de verificación</th>
            </tr>
            <tr>
                <th class="cgris">Trimestre</th>
                <th class="cgris " colspan="2"> Descripcion </th>
                <th class="cgris " colspan="2">Archivo</th>
            </tr>

            <tr>
                <th class="first-column">Enero-Marzo</th>
                @if($medios1->count()>0)
                <td colspan="4">
                    <table style="width: 100%">
                @foreach($medios1 as $medio1)
                        <tr>
                            <th class="second-column " colspan="2">{{$medio1->descripcion}}</th>
                            <th class="second-column " colspan="2"><a target="_blank" href="{{asset('medios/itar/'.$idPPA."/".$anio."/1/".$medio1->archivo)}}">{{$medio1->nombre}}</a></th>
                        </tr>
                @endforeach
                    </table>
                </td>
                @else
                <th colspan="4">
                    <div class="alert alert-info" style="text-align: center">No existen medio cargados para este trimestre</div>
                </th>
                @endif
            </tr>
            <tr>
                <th class="first-column">Abril-Junio</th>
                @if($medios2->count()>0)
                <td colspan="4">
                    <table style="width: 100%">
                        @foreach($medios2 as $medio2)
                        <tr>
                            <td class="second-column " colspan="2">{{$medio2->descripcion}}</td>
                            <td class="second-column " colspan="2"><a target="_blank" href="{{asset('medios/itar/'.$idPPA."/".$anio."/2/".$medio2->archivo)}}">{{$medio2->nombre}}</a></td>
                        </tr>
                        @endforeach
                    </table>
                </td>
                @else
                <th colspan="4">
                    <div class="alert alert-info" style="text-align: center">No existen medio cargados para este trimestre</div>
                </th>
                @endif
            </tr>
            <tr>
                <th class="first-column">Julio-Septiembre</th>
                @if($medios3->count()>0)
                <td colspan="4">
                    <table style="width: 100%">
                        @foreach($medios3 as $medio3)
                        <tr>
                            <td class="second-column " colspan="2">{{$medio3->descripcion}}</td>
                            <td class="second-column " colspan="2"><a target="_blank" href="{{asset('medios/itar/'.$idPPA."/".$anio."/3/".$medio3->archivo)}}">{{$medio3->nombre}}</a></td>
                        </tr>
                        @endforeach
                    </table>
                </td>
                @else
                <th colspan="4">
                    <div class="alert alert-info" style="text-align: center">No existen medio cargados para este trimestre</div>
                </th>
                @endif
            </tr>
            <tr>
                <th class="first-column">Octubre-Diciembre</th>
                @if($medios4->count()>0)
                <td colspan="4">
                    <table style="width: 100%">
                        @foreach($medios4 as $medio4)
                        <tr>
                            <td class="second-column " colspan="2">{{$medio4->descripcion}}</td>
                            <td class="second-column " colspan="2"><a target="_blank" href="{{asset('medios/itar/'.$idPPA."/".$anio."/4/".$medio4->archivo)}}">{{$medio4->nombre}}</a></td>
                        </tr>
                        @endforeach
                    </table>
                </td>
                @else
                <th colspan="4">
                    <div class="alert alert-info" style="text-align: center">No existen medio cargados para este trimestre</div>
                </th>
                @endif
            </tr>

            <tr>
                <!--  Observacion  -->
                <th  class="encabezado-2"colspan="5" >Observaciones</th>
            </tr>
            <tr>
                <th class="first-column">Enero-Marzo</th>
                <th class="second-column " colspan="4">{{$obs1!=null?$obs1->observaciones:"Sin observaciones"}}</th>
            </tr>
            <tr>
                <th class="first-column">Abirl-Junio</th>
                <th class="second-column " colspan="4">{{$obs2!=null?$obs2->observaciones:"Sin observaciones"}}</th>
            </tr>
            <tr>
                <th class="first-column">Julio-Septiembre</th>
                <th class="second-column " colspan="4">{{$obs3!=null?$obs3->observaciones:"Sin observaciones"}}</th>
            </tr>
            <tr>
                <th class="first-column">Octubre-Diciembre</th>
                <th class="second-column " colspan="4">{{$obs4!=null?$obs4->observaciones:"Sin observaciones"}}</th>
            </tr>




        </table><br><br>
        <table class="table-firmas">
            <tr>
                <!--  Firmas  -->
                <th  class="cf" >Validó</th>
                <th  class="cf" >Revisó</th>
                <th  class="cf" >Elaboró</th>
            </tr>
            <tr>
                <!--  Firmas  -->
                <th  class=" cf-1" style="line-height: .5cm" >
                    <br/><br/><br/><br/><br/>
                    _____________________________________________<br/>
                    {{$titular!=null?$titular->nombre:""}}<br/>{{$titular!=null?$titular->cargo:""}}<br/>{{$infoPPA->dependenciaNombre." (".$infoPPA->dependenciaSiglas.")"}}</th>
                <th  class="cf-1" >
                    <br/><br/><br/><br/><br/>
                    _____________________________________________<br/>
                    {{$enlaceD!=null?$enlaceD->titulo." ".$enlaceD->nombre." ".$enlaceD->apellidoP." ".$enlaceD->apellidoM:""}}<br/>{{$enlaceD!=null?$enlaceD->cargo:""}}
                </th>
                <th  class=" cf-1" >
                    <br/><br/><br/><br/><br/>
                    _____________________________________________<br/>
                    {{$enlaceO!=null?$enlaceO->titulo.$enlaceO->nombre." ".$enlaceO->apellidoP." ".$enlaceO->apellidoM:""}}<br/>{{$enlaceO!=null?$enlaceO->cargo:""}}
                </th>
            </tr>
            <tr>
                <!--  Firmas  -->
                <th  class=" cf-2" >Titular de la Institucion</th>
                <th  class=" cf-2" >Enlace directivo </th>
                <th  class=" cf-2" >Enlace Operativo</th>
            </tr>
        </table>



    </div>


</body>

</html>