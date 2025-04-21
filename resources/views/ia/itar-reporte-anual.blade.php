@php
    use App\Models\LineaPED;
    use App\Models\Indicador;
    use App\Models\IAFuente;
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
    .encabezado { width: 100%; text-align: center; background-color: #525f8d; color: white; padding: 10px;font-weight: bold; }
    .encabezado-2 {width: 100%; text-align: center; background-color: #B9C6DE; color: black; padding: 10px;font-weight: bold; }
    .encabezado-3 { width: 100%;text-align: center; background-color: #d7e3f9; color: black; padding: 10px;font-weight: bold; }
    .first-column { background-color: #BAC7DC; color: black; font-weight: bold; }
    .second-column { background-color: #f0f0f0; color: black;text-align: justify }
    .cgris { background-color: #bebfbf; color: black; font-weight: bold;text-align: center }
    .b-1 { background-color: #B9C6DE; color: black; font-weight: bold; }
    .table-firmas{ border-collapse: collapse; width: 100%;margin-top: 30px; border: 3px solid #616ea0; }
    .cf {   border-left: 1px solid #616ea0;border-right: 1px solid #616ea0; text-align: center;background-color: #616ea0;color: white; padding: 10px;font-weight: bold; }
    .cf-1 {     border-left: 1px solid #616ea0;border-right: 1px solid #616ea0; text-align:center;line-height: 80px;background-color: #ffffff;padding: 30px;height: 100px;font-weight: normal; }
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
                <th  class="encabezado"colspan="6" >Datos Generales</th>
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
        <tr>
            <th  class="encabezado-3"colspan="8" >Poblacion Objetivo</th>
        </tr>
        <tr>
            <th class="first-column ">Tipo de Población</th>
            <td class="second-column"colspan="2">Población con carencia alimentaria</td>
            <th class="first-column ">Descripción</th>
            <td class="second-column "colspan="4">Infantes de 2 a 5 años 11 meses no escolarizados, 
                personas mayores, personas con discapacidad o en 
                situación de abandono y carencia alimentaria
            </td>

        </tr>
        <tr>
            <th class="first-column ">Total</th>
            <td class="second-column " colspan="3">97,500</td>
            <th class="first-column ">Mujeres</th>
            <td class="second-column "colspan="">50,700</td>
            <th class="first-column ">Hombres</th>
            <td class="second-column " colspan="">46,800</td>
        </tr>
        <tr>
            <th  class="encabezado-3"colspan="8" >Área de enfoque objetivo</th>
        </tr>
        <tr>
            <th class="first-column ">Nombre</th>
            <td class="second-column " colspan="3"></td>
            <th class="first-column ">Descripcion</th>
            <td class="second-column "colspan=""></td>
            <th class="first-column ">Total</th>
            <td class="second-column " colspan=""></td>
        </tr>
        <!--Impacto esperado -->
        <tr>
            <th  class="encabezado-2"colspan="8" >Impacto esperado</th>
        </tr>
        <tr>
            <th class="first-column ">Tipo</th>
            <td class="second-column " >Social, Económico </td>
            <th class="first-column ">Descripcion</th>
            <td class="second-column "colspan="5">La instalación y operación de comedores comunitarios como programa social puede tener un impacto en la reducción de la 
                inseguridad alimentaria, mejora de la salud pública, se fortalece la cohesión social, puede haber un impacto económico al reducir 
                el gasto familiar, se pueden lograr empleos locales, por otro lado, también al involucrar a voluntarios y organizaciones en la 
                operación de los comedores, se fomenta la corresponsabilidad y el trabajo en equipo para solucionar problemas comunes.
                </td>

        </tr>
        </table><br><br>
        <!--Tabla de Bienes o Servicios -->
        <table>
            <tr>
                <th  class="encabezado"colspan="8" >Bienes o Servicios</th>
            </tr>
            <!-- Datos Generales -->
            <tr>
                <th  class="encabezado-2"colspan="8" >Datos Generales</th>
            </tr>
            <tr>
                <th class="first-column ">Nombre</th>
                <td class="second-column " colspan="3">Entrega de dotaciones de alimentos con calidad nutricia </td>
                <th class="first-column ">Periodicidad de entrega</th>
                <td class="second-column "colspan="">Bimestral</td>
                <th class="first-column ">Unidad de medida</th>
                <td class="second-column " colspan="">Dotaciones alimenticias con calidad 
                    nutricia</td>
            </tr>
            <tr>
                <th class="first-column ">Descipcion</th>
                <td class="second-column " colspan="7">Entrega de dotaciones alimenticias con calidad nutricia, tomando en cuenta las edades y los menús destinados para ello. </td>
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
                <th class="second-column ">-</th>
                <th class="second-column ">-</th>
                <th class="second-column ">-</th>
                <th class="second-column ">-</th>
                <th class="second-column "></th>  
            </tr>
            <tr>
                <th class="b-1">Realizado</th>
                <th class="second-column ">-</th>
                <th class="second-column ">-</th>
                <th class="second-column ">-</th>
                <th class="second-column ">-</th>
                <th class="second-column "></th>  
            </tr>
            <tr>
                <th class="cgris">Avance</th>
                <th class="cgris">-</th>
                <th class="cgris">-</th>
                <th class="cgris">-</th>
                <th class="cgris">-</th>
                <th class="cgris"></th>  
            </tr>
            
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
            <tr>
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
            <tr>
                <th class="first-column">Programada</th>
                <th class="second-column celdas-15" >-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15" >-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15" >-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15" >-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15" >-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15">-</th>
 
            </tr>
            <tr>
                <th class="first-column">Atendida</th>
                <th class="second-column celdas-15" >-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15" >-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15" >-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15" >-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15" >-</th>
                <th class="second-column celdas-15">-</th>
                <th class="second-column celdas-15">-</th>

            </tr>
            <tr>
                <th class="cgris">Avance</th>
                <th class="cgris celdas-15" >-</th>
                <th class="cgris celdas-15">-</th>
                <th class="cgris celdas-15">-</th>
                <th class="cgris celdas-15" >-</th>
                <th class="cgris celdas-15">-</th>
                <th class="cgris celdas-15">-</th>
                <th class="cgris celdas-15" >-</th>
                <th class="cgris celdas-15">-</th>
                <th class="cgris celdas-15">-</th>
                <th class="cgris celdas-15" >-</th>
                <th class="cgris celdas-15">-</th>
                <th class="cgris celdas-15">-</th>
                <th class="cgris celdas-15" >-</th>
                <th class="cgris celdas-15">-</th>
                <th class="cgris celdas-15">-</th>

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
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
 
            </tr>
            <tr>
                <th class="first-column">Abril-Junio</th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
 
            </tr>
            <tr>
                <th class="first-column">Julio-Septiembre</th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
 
            </tr>
            <tr>
                <th class="first-column">Octubre-Diciembre</th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
                <th class="second-column celdas-15" ></th>
                <th class="second-column celdas-15"></th>
 
            </tr>
            <tr>
                <!-- aREA DE ENFOQUE Atendida-->
                <th  class="encabezado-3"colspan="6" >Área de enfoque atendida</th>
            </tr>
            <tr>
                <th class="cgris">Concepto/Trimestre</th>
                <th class="cgris " >Enero-Marzo</th>
                <th class="cgris ">Abril-Mayo</th>
                <th class="cgris " >Julio-Septiembre</th>
                <th class="cgris ">Octubre-Diciembre</th>
                <th class="cgris " >Total</th>
            </tr>
            <tr>
                <th class="first-column">Programada</th>
                <th class="second-column " ></th>
                <th class="second-column "></th>
                <th class="second-column " ></th>
                <th class="second-column "></th>
                <th class="second-column " ></th>
            </tr>
            <tr>
                <th class="first-column">Atendida</th>
                <th class="second-column " ></th>
                <th class="second-column "></th>
                <th class="second-column " ></th>
                <th class="second-column "></th>
                <th class="second-column " ></th>
            </tr>
            <tr>
                <th class="cgris">%Avance</th>
                <th class="cgris " ></th>
                <th class="cgris "></th>
                <th class="cgris " ></th>
                <th class="cgris "></th>
                <th class="cgris " ></th>
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
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
            </tr>
            <tr>
                <th class="first-column">Abril-Junio</th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
            </tr>
            <tr>
                <th class="first-column">Julio-Septiembre</th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
            </tr>
            <tr>
                <th class="first-column">Octubre-Diciembre</th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
                <th class="second-column " ></th>
            </tr>
            <tr>
                <!-- Presupuesto ejercido -->
                <th  class="encabezado-2"colspan="6" >Presupuesto ejercido</th>
            </tr>
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
                <th class="second-column " > </th>
                <th class="second-column "></th>
                <th class="second-column "></th>
                <th class="second-column "></th>
                <th class="second-column "></th>

            </tr>
            <tr>
                <th class="first-column">Ejercido</th>
                <th class="second-column " > </th>
                <th class="second-column ">$241,753,980.00 </th>
                <th class="second-column "></th>
                <th class="second-column "></th>
                <th class="second-column "></th>

            </tr>
            <tr>
                <th class="cgris">Avance</th>
                <th class="cgris " > 0% </th>
                <th class="cgris ">0%</th>
                <th class="cgris "></th>
                <th class="cgris "></th>
                <th class="cgris "></th>

            </tr>
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
                <th class="second-column " colspan="2"> Reportes de la Plataforma de Seguimiento de los Programas de Asistencia Alimentaria
                    del Sistema DIF Oaxaca, administrado por la Dirección de Operación de Asistencia
                    Alimentaria </th>
                <th class="second-column " colspan="2"></th>
            </tr>
            <tr>
                <th class="first-column">Abril-Junio</th>
                <th class="second-column " colspan="2"> Reportes de la Plataforma de Seguimiento de los Programas de Asistencia Alimentaria
                    del Sistema DIF Oaxaca, administrado por la Dirección de Operación de Asistencia
                    Alimentaria </th>
                <th class="second-column " colspan="2"></th>
            </tr>
            <tr>
                <th class="first-column">Julio-Septiembre</th>
                <th class="second-column " colspan="2"> Reportes de la Plataforma de Seguimiento de los Programas de Asistencia Alimentaria
                    del Sistema DIF Oaxaca, administrado por la Dirección de Operación de Asistencia
                    Alimentaria </th>
                <th class="second-column " colspan="2"></th>
            </tr>
            <tr>
                <th class="first-column">Octubre-Diciembre</th>
                <th class="second-column " colspan="2"> Reportes de la Plataforma de Seguimiento de los Programas de Asistencia Alimentaria
                    del Sistema DIF Oaxaca, administrado por la Dirección de Operación de Asistencia
                    Alimentaria </th>
                <th class="second-column " colspan="2"></th>
            </tr>

            <tr>
                <!--  Observacion  -->
                <th  class="encabezado-2"colspan="5" >Observaciones</th>
            </tr>
            <tr>
                <th class="first-column">Enero-Marzo</th>
                <th class="second-column " colspan="4"> Para el caso del avance por trimestre del presupuesto modificado o ejercido no es la suma aritmética en el total anual
                </th>
            </tr>
            <tr>
                <th class="first-column">Abirl-Junio</th>
                <th class="second-column " colspan="4"> Para el caso del avance por trimestre del presupuesto modificado o ejercido no es la suma aritmética en el total anual
                </th>
            </tr>
            <tr>
                <th class="first-column">Julio-Septiembre</th>
                <th class="second-column " colspan="4"> Para el caso del avance por trimestre del presupuesto modificado o ejercido no es la suma aritmética en el total anual
                </th>
            </tr>
            <tr>
                <th class="first-column">Octubre-Diciembre</th>
                <th class="second-column " colspan="4"> Para el caso del avance por trimestre del presupuesto modificado o ejercido no es la suma aritmética en el total anual
                </th>
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
                <th  class=" cf-1" >Nombre Cargo</th>
                <th  class="cf-1" >NOMBRE CARGO</th>
                <th  class=" cf-1" >NOMBRE CARGO</th>
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