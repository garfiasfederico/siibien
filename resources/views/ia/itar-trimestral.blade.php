    @php
        use App\Models\LineaPED;
        use App\Models\Indicador;
        use App\Models\IAFuente;
        use App\Models\IABSEntrega;
        use App\Models\IABSPoblacion;
        use App\Models\IABSArea;
        use App\Models\IABSRegion;
        use App\Models\IABSPresupuesto;    
        use App\Models\IAObservacion; 
    @endphp
    
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Tecnica del Indicador</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 5px; }
        .container { max-width: 800px; margin: 0 auto; padding: 10px; margin-top: 0px; }
        table { width: 100%; border-collapse: collapse; margin-top: 0px; }
        th, td { padding: 10px; border: 0.5px solid #B08D57; text-align: left;  table-layout: fixed  }
        td { background-color: white; } /* Asegura que las celdas vacías tengan fondo blanco */
        .first-column{background-color: #D8C3A5;font-weight: bold; }
        .second-column{background-color: #eae8e3; }
        .sc{text-align: center; }
        .bs{width: 3%}
        .bs2{width: 9%}
        .bs3{width: 28%}
        .es{ height: 40px}
        .encabezado{ background-color: #B08D57; color: black; font-weight: bold; text-align: center; }
        .encabezado2{ background-color: #c3b096;text-align: center; font-weight: bold; }
        .firma{ padding: 30px; height: 80px}
        .codigo-formato {font-family: helvetica, sans-serif;font-size: 12pt;color: #ad8e65;text-align: right;}

    </style>
</head>
<div class="codigo-formato">
    F-SIIBIEN-ITAR-02
</div>

<body>
    <div class="container">
        <table>
            <tr>
                <td class="first-column">Nombre de PPA:</td>
                <td class="second-column" colspan="3">{{$infoPPA->nombre}}</td>
                <td class="first-column">Periodo de reporte:</td>
                <td class="second-column">{{$trimestres[$trim-1]}}</td>
            </tr>
            <tr>
                <td colspan="6"></td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="encabezado" colspan="8"></td>
            </tr>
            <tr>
                <td class="first-column" colspan="2">Dependencia/Entidad Responsable</td>
                <td colspan="2">{{$infoPPA->dependenciaNombre." (".$infoPPA->dependenciaSiglas.")"}}</td>
                <td class="first-column sc">Cobertura</td>
                <td>{{$infoPPA->cobertura}}</td>
                <td class="first-column sc">Año de Inicio</td>
                <td>{{$infoPPA->anio_inicio}}</td>
            </tr>
            <tr>
                <td class="first-column" colspan="2"> Objetivo</td>
                <td colspan="6">{{$infoPPA->objetivo}}</td>
            </tr>
            <tr>
                <td class="first-column" colspan="2"> Descripción</td>
                <td colspan="6">{{$infoPPA->descripcion}}</td>
            </tr>
            <tr>
                <td class="first-column" colspan="2"> Eje</td>
                <td colspan="6">{{$alineacion!=null?$alineacion->ejePEDClave." ".$alineacion->ejePEDDescripcion:""}}</td>
            </tr>
            <tr>
                <td class="first-column" colspan="2"> Tema PED 2022-2028</td>
                <td colspan="6">{{$alineacion!=null?$alineacion->temaPEDClave." ".$alineacion->temaPEDDescripcion:""}}</td>
            </tr>
            <tr>
                <td class="first-column" colspan="2"> PES/PE</td>
                <td colspan="6">{{$alineacion!=null?$alineacion->claveSector." ".$alineacion->sector:""}}</td>
            </tr>
            <!--Presupuesto ejercido-->
            <tr>
                <td class="encabezado2" colspan="8">
                    Presupuesto General ({{ $anio }})
                </td>
            </tr>

            @if($presupuesto->count() > 0)

                @foreach($presupuesto as $pp_id => $registros)
                    @if(!$pp_id) @continue @endif

                    @php
                        $operativo = $registros->where('tipo_gasto','operativo')->first();
                        $inversion = $registros->where('tipo_gasto','inversion')->first();

                        $clave = $operativo->clavePrograma ?? $inversion->clavePrograma;
                        $desc  = $operativo->descripcionPrograma ?? $inversion->descripcionPrograma;
                    @endphp

                    {{-- Programa Presupuestario --}}
                    <tr>
                        <td class="first-column" colspan="2">Programa Presupuestario</td>
                        <td colspan="6">
                            <strong>{{ $clave }}</strong> {{ $desc }}
                        </td>
                    </tr>

                    {{-- Gasto Operativo --}}
                    @if($operativo && $operativo->aplica)
                    <tr>
                        <td class="first-column">Tipo de gasto</td>
                        <td class="second-column">Operativo</td>

                        <td class="first-column">Estado</td>
                        <td class="second-column">
                            @if($operativo->estatus == 0) No aplica
                            @elseif($operativo->estatus == 1) No disponible
                            @elseif($operativo->estatus == 2) Aplica
                            @endif
                        </td>

                        <td class="first-column">Monto</td>
                        <td class="second-column" colspan="3" style="text-align:right">
                            @if($operativo->estatus == 2)
                                $ {{ number_format($operativo->monto,2) }}
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                    @endif

                    {{-- Gasto de Inversión --}}
                    @if($inversion && $inversion->aplica)
                    <tr>
                        <td class="first-column">Tipo de gasto</td>
                        <td class="second-column">Inversión</td>

                        <td class="first-column">Estado</td>
                        <td class="second-column">
                            @if($inversion->estatus == 0) No aplica
                            @elseif($inversion->estatus == 1) No disponible
                            @elseif($inversion->estatus == 2) Aplica
                            @endif
                        </td>

                        <td class="first-column">Monto</td>
                        <td class="second-column" colspan="3" style="text-align:right">
                            @if($inversion->estatus == 2)
                                $ {{ number_format($inversion->monto,2) }}
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                    @endif

                @endforeach

            @else
            <tr>
                <td colspan="8" style="text-align:center">
                    No existe información registrada del presupuesto general.
                </td>
            </tr>
            @endif
            <!--Poblacion o area de enfoque atendida-->
            <tr>
                <td class="encabezado2" colspan="9">Población o área de enfoque atendida</td>
            </tr>
            @if($poblacion!=null)
                @if(str_contains($poblacion->tipo,"p_"))
                    <tr>
                        <td class="first-column">Tipo de población</td>
                        <td>{{$poblacion->descripcion." ".$poblacion->tipo_poblacion_otro}}</td>
                        <td class="first-column sc">Total</td>
                        <td>{{$infoP!=null?$infoP->total:""}}</td>
                        <td class="first-column sc">Mujeres</td>
                        <td>{{$infoP!=null?$infoP->mujeres:""}}</td>
                        <td class="first-column sc">Hombres</td>
                        <td>{{$infoP!=null?$infoP->hombres:""}}</td>
                    </tr>
                @endif
                @if(str_contains($poblacion->tipo,"a_"))
                    <tr>
                        <td class="first-column">Área de enfoque</td>
                        <td colspan="5">{{$poblacion->nombre_enfoque}}</td>
                        <td class="first-column"> Total </td>
                        <td class="">{{$infoP!=null?$infoP->total_area:""}}</td>
                    </tr>
                @endif
                @php
                    //Obtenemos el total de regiones atendidas en el trimestre
                    $trim = $trim;
                    $query = "select DISTINCT ia_bs_region.idRegion, COUNT(*) from ia_bs_region inner join ia_bs on ia_bs.idBS = ia_bs_region.idBS inner join informe_acciones on informe_acciones.id = ia_bs.ia_id where informe_acciones.id = $idPPA  AND ia_bs_region.anio = $anio AND (ia_bs_region.h$trim <> '' OR ia_bs_region.m$trim <> '') GROUP BY ia_bs_region.idRegion";                    
                    $total_regiones = DB::select($query);
                    //dd(count($total_regiones));
                        
                @endphp
                <tr>
                    <td class="first-column" colspan="2">Total de Regiones atendidas en el trimestre</td>
                    <td colspan="2">{{count($total_regiones)}}</td>
                    <td class="first-column" colspan="2">Total de Municipios atendidos</td>
                    <td colspan="2">N/D</td>
                </tr>
            @endif
        </table><br/><br/>



        <table>
            <!--Bienes o serivicios-->
            <tr>
                <td class="encabezado2" colspan="9">Bienes o Servicios</td>
            </tr>
            <tr>
                <td colspan="9"></td>
            </tr>
            <tr>
                <td class="encabezado2" colspan="9">Realizado Trimestre</td>
            </tr>
            <tr>
                <td class="first-column" rowspan="2" colspan="2">Nombre del bien o servicio</td>
                <td class="first-column sc" rowspan="2">Total</td>
                <td class="first-column sc" rowspan="2">Unidad de medida</td>
                <td class="first-column sc" colspan="3">Población atendida</>
                </td>
                <td class="first-column sc" rowspan="2">Área de enfoque atendida</td>
                <td class="first-column sc" rowspan="2">Presupuesto ejercido/ Inversión</td>
            </tr>
            <tr>
                <td class="first-column sc">Total</td>
                <td class="first-column sc">Mujeres</td>
                <td class="first-column sc">Hombres</td>
            </tr>
            @if($bss->count()>0)
                @foreach ($bss as $bs )  
                    @php

                        $valor = "";                             
                        $valorPoblacionH = "";
                        $valorPoblacionM = "";
                        $valorTPoblacion = "";
                        $valorArea = "";

                        $valorArea = "";
                        $entregas = IABSEntrega::where("idBS",$bs->idBS)->where("anio",$anio)->first();
                        $poblacion_ob = IABSPoblacion::where("idBS",$bs->idBS)->where("anio",$anio)->first();
                        $area = IABSArea::where("idBS",$bs->idBS)->where("anio",$anio)->first();
                        $presupuestoBS = IABSPresupuesto::select(DB::raw("sum(e1) as e1"),DB::raw("sum(e2) as e2"),DB::raw("sum(e3) as e3"),DB::raw("sum(e4) as e4"))->where("idBS",$bs->idBS)->where("anio",$anio)->first();
                        $pres = 0;

                        if($entregas!=null){
                            switch ($trim) {
                                case 1:
                                    $valor = $entregas->r1;
                                    $valorPoblacionH = $poblacion_ob!=null?$poblacion_ob->ah1:0;
                                    $valorPoblacionM = $poblacion_ob!=null?$poblacion_ob->am1:0;
                                    $valorArea = $area!=null?$area->ara1:0;
                                    $pres = $presupuestoBS!=null?$presupuestoBS->e1:0;
                                    break;
                                case 2:
                                    $valor = $entregas->r2;
                                    $valorPoblacionH = $poblacion_ob!=null?$poblacion_ob->ah2:0;
                                    $valorPoblacionM = $poblacion_ob!=null?$poblacion_ob->am2:0;
                                    $valorArea = $area!=null?$area->ara2:0;
                                    $pres = $presupuestoBS!=null?$presupuestoBS->e2:0;
                                    break;
                                case 3:
                                    $valor = $entregas->r3;
                                    $valorPoblacionH = $poblacion_ob!=null?$poblacion_ob->ah3:0;
                                    $valorPoblacionM = $poblacion_ob!=null?$poblacion_ob->am3:0;
                                    $valorArea = $area!=null?$area->ara3:0;
                                    $pres = $presupuestoBS!=null?$presupuestoBS->e3:0;
                                    break;
                                case 4:
                                    $valor = $entregas->r4;
                                    $valorPoblacionH = $poblacion_ob!=null?$poblacion_ob->ah4:0;
                                    $valorPoblacionM = $poblacion_ob!=null?$poblacion_ob->am4:0;
                                    $valorArea = $area!=null?$area->ara4:0;
                                    $pres = $presupuestoBS!=null?$presupuestoBS->e4:0;
                                    break;                                                                
                                default:
                                    $valor = "";
                                    $valorPoblacionH = 0;
                                    $valorPoblacionM = 0;                                    
                                    $valorArea = ""; 
                                    $pres = 0;                                   
                                    break;
                            }
                            $valorTPoblacion = $valorPoblacionH + $valorPoblacionM;

                        }
                        
                    @endphp                          
                    <tr>
                        <td colspan="2">{{$bs->nombreBS}}</td>
                        <td style="text-align: center">{{$valor}}</td>
                        <td style="text-align: center">{{$bs->unidad_medidaBS}}</td>
                        <td style="text-align: center">{{$valorTPoblacion}}</td>
                        <td style="text-align: center">{{$valorPoblacionM}}</td>
                        <td style="text-align: center">{{$valorPoblacionH}}</td>
                        <td style="text-align: center">{{number_format((float)$valorArea)}}</td>
                        <td style="text-align: center">$ {{number_format((float)$pres,2)}}</td>
                    </tr>
                @endforeach
            @endif
            <tr>
                <td colspan="9"></td>
            </tr>
            <!--desglose regional población y area de enfoque-->
            <tr>
                <td class="encabezado2" colspan="10">Desglose regional población y área de enfoque atendida</td>
            </tr>

            <tr>
                <td class="first-column bs3" rowspan="2">
                    Bien o servicio
                </td>
                <td class="first-column bs2 sc" colspan="3">Sierra Flores Magón</>
                </td>
                <td class="first-column bs2 sc " colspan="3">
                    <>Costa</>
                </td>
                <td class="first-column bs2 sc" colspan="3">
                    <>Cuenca del Papaloapan</>
                </td>
                <td class="first-column bs2 sc" colspan="3">
                    <>Istmo</>
                </td>
                <td class="first-column bs2 sc" colspan="3">
                    <>Mixteca</>
                </td>
                <td class="first-column bs2 sc" colspan="3">
                    <>Sierra de Juárez</>
                </td>
                <td class="first-column bs2 sc" colspan="3">
                    <>Sierra Sur</>
                </td>
                <td class="first-column bs2 sc" colspan="3">
                    <>Valles Centrales</>
                </td>
            </tr>
            <tr>
                <!-- Repetir M H AE por cada región -->
                <td class="first-column bs sc">M</td>
                <td class="first-column bs sc">H</td>
                <td class="first-column bs sc">AE</td>

                <td class="first-column bs sc">M</td>
                <td class="first-column bs sc">H</td>
                <td class="first-column bs sc">AE</td>

                <td class="first-column bs sc">M</td>
                <td class="first-column bs sc">H</td>
                <td class="first-column bs sc">AE</td>

                <td class="first-column bs sc">M</td>
                <td class="first-column bs sc">H</td>
                <td class="first-column bs sc">AE</td>

                <td class="first-column bs sc">M</td>
                <td class="first-column bs sc">H</td>
                <td class="first-column bs sc">AE</td>

                <td class="first-column bs sc">M</td>
                <td class="first-column bs sc">H</td>
                <td class="first-column bs sc">AE</td>

                <td class="first-column bs sc">M</td>
                <td class="first-column bs sc">H</td>
                <td class="first-column bs sc">AE</td>

                <td class="first-column bs sc">M</td>
                <td class="first-column bs sc">H</td>
                <td class="first-column bs sc">AE</td>
            </tr>

            @if($bss->count()>0)
                @foreach ($bss as $bs )
                    @php
                        //Obtenemos el desglose por región
                        $region1 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",1)->first();
                        $region2 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",2)->first();
                        $region3 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",3)->first();
                        $region4 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",4)->first();
                        $region5 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",5)->first();
                        $region6 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",6)->first();
                        $region7 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",7)->first();
                        $region8 = IABSRegion::where("idBS",$bs->idBS)->where("anio",$anio)->where("idRegion",8)->first();
                        $region1 = $region1!=null?$region1->toArray():null;                                               
                        $region2 = $region2!=null?$region2->toArray():null;                                               
                        $region3 = $region3!=null?$region3->toArray():null;                                               
                        $region4 = $region4!=null?$region4->toArray():null;                                               
                        $region5 = $region5!=null?$region5->toArray():null;                                               
                        $region6 = $region6!=null?$region6->toArray():null;                                               
                        $region7 = $region7!=null?$region7->toArray():null;                                               
                        $region8 = $region8!=null?$region8->toArray():null;                                               

                        $m = "m".$trim;
                        $h = "h".$trim;
                        $a = "a".$trim;                    
                    @endphp

                    <tr>
                        <td>{{$bs->nombreBS}}</td>
                        <td class="bs" style="text-align:center">{{$region1!=null?$region1[$m]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region1!=null?$region1[$h]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region1!=null?$region1[$a]:""}}</td>

                        <td class="bs" style="text-align:center">{{$region2!=null?$region2[$m]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region2!=null?$region2[$h]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region2!=null?$region2[$a]:""}}</td>
                        
                        <td class="bs" style="text-align:center">{{$region5!=null?$region5[$m]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region5!=null?$region5[$h]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region5!=null?$region5[$a]:""}}</td>

                        <td class="bs" style="text-align:center">{{$region3!=null?$region3[$m]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region3!=null?$region3[$h]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region3!=null?$region3[$a]:""}}</td>

                        <td class="bs" style="text-align:center">{{$region4!=null?$region4[$m]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region4!=null?$region4[$h]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region4!=null?$region4[$a]:""}}</td>

                        <td class="bs" style="text-align:center">{{$region6!=null?$region6[$m]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region6!=null?$region6[$h]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region6!=null?$region6[$a]:""}}</td>

                        <td class="bs" style="text-align:center">{{$region7!=null?$region7[$m]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region7!=null?$region7[$h]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region7!=null?$region7[$a]:""}}</td>

                        <td class="bs" style="text-align:center">{{$region8!=null?$region8[$m]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region8!=null?$region8[$h]:""}}</td>
                        <td class="bs" style="text-align:center">{{$region8!=null?$region8[$a]:""}}</td>                    
                    </tr>
                @endforeach
            @endif
            <!--desglose regional población y area de enfoque-->
            <tr>
                <td class=" sc" colspan="25"><Strong> *AE: Área de enfoque</Strong> </td>
            </tr>

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
                <td class=" encabezado2 sc" colspan="25">Impacto generado (Social,economico,ambiental)</td>
            </tr>
            <tr>
                <td class="es " colspan="25">{{$impacto_cadena}}<br/>{{$infoP!=null?$infoP->descripcion_impacto:""}}</td>
            </tr>
            <tr>
                <td colspan="25"> </td>
            </tr>
            @php
                $obs = IAObservacion::where("ia_id",$idPPA)->where("anio",$anio,)->where("trimestre",$trim)->first();
            @endphp
            <tr>
                <td class=" encabezado2 sc" colspan="25"> Medios de Verificación </td>
            </tr>
            <tr>
                <td class="es " colspan="25">
                    <table style="width: 100%">
                        <tr>                            
                            <th class="encabezado2  "> Descripcion </th>
                            <th class="encabezado2 ">Archivo</th>
                        </tr>                        
                        @if($medios->count()>0)
                            @foreach($medios as $mediot)
                                <tr>
                                    <td class="" colspan="">{{$mediot->descripcion!=""?$mediot->descripcion:"Sin descripción"}}</td>
                                    <td class="" colspan=""><a target="_blank" href="{{asset('medios/itar/'.$idPPA."/".$anio."/".$trim."/".$mediot->archivo)}}">{{$mediot->nombre}}</a></td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </td>
            </tr>
            <tr>
                <td class=" encabezado2 sc" colspan="25"> Observaciones </td>
            </tr>
            <tr>
                <td class="es " colspan="25">{{$obs!=null?$obs->observaciones:""}}</td>
            </tr>

        </table><br><br>
        <table>
            <tr>
                <td class="first-column sc">Validó</td>
                <td class="first-column sc">Revisó</td>
                <td class="first-column sc">Elaboró</td>
            </tr>
            <!--<tr>
                <td class="sc es">(Nombre y firma)</td>
                <td class="sc es">(Nombre y firma)</td>
                <td class="sc es">(Nombre y firma)</td>
            </tr>-->

            <tr>
                <td class="sc es"><Strong><br/><br/><br/><br/><br/>
                    _____________________________________________<br/>
                    {{$titular!=null?$titular->nombre:""}}<br/>{{$titular!=null?$titular->cargo:""}}<br/>{{$infoPPA->dependenciaNombre." (".$infoPPA->dependenciaSiglas.")"}}</Strong></td>
                <td class="sc es"><Strong><br/><br/><br/><br/><br/>
                    _____________________________________________<br/>
                    {{$enlaceD!=null?$enlaceD->titulo." ".$enlaceD->nombre." ".$enlaceD->apellidoP." ".$enlaceD->apellidoM:""}}<br/>{{$enlaceD!=null?$enlaceD->cargo:""}}<br/>(Enlace Directivo)</Strong></td>
                <td class="sc es"><Strong><br/><br/><br/><br/><br/>
                    _____________________________________________<br/>
                    {{$enlaceO!=null?$enlaceO->titulo.$enlaceO->nombre." ".$enlaceO->apellidoP." ".$enlaceO->apellidoM:""}}<br/>{{$enlaceO!=null?$enlaceO->cargo:""}}<br/>(Enlace Operativo)</Strong></td>
            </tr>
        </table>




    </div>
</body>

</html>