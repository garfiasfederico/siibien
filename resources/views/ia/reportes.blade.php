@php
    use App\Models\LineaPED;
    use App\Models\Indicador;
@endphp
@extends('layouts.administrador')
@section('encabezado')
    ITAR / Reportes de Información
@endsection
@section('styles')

    <style>
        .enc1 {
            padding: 5px !important;
            background-color: #c5c5c5;
            color: white;
        }

        .enc2 {
            padding: 5px !important;
            background-color: #7c2f42;
            color: white;
        }

        .resp {
            font-weight: bold;
        }

        .enc3 {
            background-color: #ececec;
            font-weight: bold;
        }

        input[type=text],
        select {
            height: 35px;
            color: black;
        }

        table tr td {
            padding: 5px;
            border: solid 2px white;
        }

        .invalid-feedback {
            width: 100%;
            background-color: rgb(255, 195, 195);
            color: gray;
            border-radius: 5px;
            text-align: center;
            padding: 10px;
            border:solid 1px red;
        }

        textarea {
            color: black;
        }

        .dropzone{
            background-color: rgb(250, 255, 243);
            border: solid 2px green;
        }

        bss:hover{
            background-color: black;
            color: white;
        }

        .bss div:hover{
            background-color: black;
            color: white;
        }
        .enc4{
            background-color: black;
            color: white;
        }
        .enc5{
            background-color: rgb(167,176,207);
            color: black;
            width: 15%;
            font-weight: bold;
        }
        .enc6{
            background-color: rgb(228, 228, 228);
            color: black;
        }
    </style>
@endsection
@section('content')
<h4 class="alert alert-warning" style="background-color: #681b2e;color:white">{{ $ppa->id . ' ' . $ppa->nombre }}</h4>
<div class="row">
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex align-items-center justify-content-between"
                style="background-color: rgb(75,90,137);">
                <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Datos Generales</h6>
                <div class="dropdown no-arrow">
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="datosgeneralesContent">
                <table style="width: 100%">
                    <tr>
                        <td class="enc5">Tipo:</td>
                        <td class="enc6">{{$ppa->tipo}}</td>
                        <td class="enc5">Nombre:</td>
                        <td class="enc6">{{$ppa->nombre}}</td>                        
                    </tr>
                    <tr>
                        <td class="enc5">Descripcion:</td>
                        <td class="enc6">{{$ppa->descripcion}}</td>
                        <td class="enc5">Objetivo:</td>
                        <td class="enc6">{{$ppa->objetivo}}</td>
                    </tr>
                    <tr>
                        <td class="enc5">Cobertura:</td>
                        <td class="enc6">{{$ppa->cobertura}}</td>
                        <td class="enc5">Año de Inicio:</td>
                        <td class="enc6">{{$ppa->anio_inicio}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>      
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex align-items-center justify-content-between"
                style="background-color: rgb(75,90,137);">
                <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Bienes o servicios</h6>
                <div class="dropdown no-arrow">
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="bssContent">
                @if($bss->count()>0)
                    @foreach ($bss as $bs )
                    <div class="col-md" style="padding-top:20px;border:solid 1px green;color:black;background-color:rgb(236, 236, 236);margin:10px;cursor:pointer" onmouseover="$(this).css('color','blue');$(this).css('background-color','white');" onmouseout="$(this).css('color','black');$(this).css('background-color','rgb(236, 236, 236)');" onclick="getInfoMonitoreo({{$bs->idBS}})">
                        <h4>{{$bs->nombreBS}}</h4>
                        <p style="font-size:.8em">{{$bs->descripcionBS}}</p>                            
                        <div style="text-align: right;font-size:.7em">({{$bs->unidad_medidaBS}})</div>                            
                    </div>
                    @endforeach
                @else
                 <div class="alert alert-info" style="text-align: center">No existen Bienes o Servicios dados de alta para este PPA.</div>
                @endif                
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex align-items-center justify-content-between"
                style="background-color: rgb(75,90,137);">
                <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Alineación</h6>
                <div class="dropdown no-arrow">
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="alineacionContent">
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
                    <table style="width: 100%">
                        <tr>
                            <td colspan="4" class="enc5" style="text-align: center">
                                Plan Estatal de Desarrollo 2022-2028
                            </td>
                        </tr>
                        <tr>
                            <td class="enc5">Eje:</td>
                            <td class="enc6">{{$alineacion->ejePEDClave." ".$alineacion->ejePEDDescripcion}}</td>
                            <td class="enc5">Tema:</td>
                            <td class="enc6">{{$alineacion->temaPEDClave." ".$alineacion->temaPEDDescripcion}}</td>                        
                        </tr>
                        <tr>
                            <td class="enc5">Objetivo:</td>
                            <td class="enc6">{{$alineacion->objetivoPEDClave." ".$alineacion->objetivoPEDDescripcion}}</td>
                            <td class="enc5">Lineas:</td>                            
                            <td class="enc6">{{$lineas}}</td>                        
                        </tr>
                        <tr>
                            <td class="enc5">Ejes Transversales:</td>
                            <td class="enc6" colspan="3">{{$trans_t}}</td>                        
                        </tr>
                        <tr>
                            <td colspan="4" class="enc5" style="text-align: center">
                                Planes Estratégicos Sectoriales/Especiales
                            </td>
                        </tr>
                        <tr>
                            <td class="enc5">Sector:</td>
                            <td class="enc6">{{$alineacion->claveSector." ".$alineacion->sector}}</td>
                            <td class="enc5">Objetivo:</td>                            
                            <td class="enc6">{{$alineacion->claveObjetivo." ".$alineacion->objetivo}}</td>                        
                        </tr>
                        <tr>
                            <td class="enc5">Estrategia:</td>
                            <td class="enc6" colspan="3">{{$alineacion->claveEstrategia." ".$alineacion->estrategia}}</td>                            

                        </tr>
                        <tr>
                            <td class="enc5">Indicadores Estratégicos:</td>                            
                            <td class="enc6" colspan="3">{{$indicadores}}</td>                        
                        </tr>
                    </table>
                @else                
                    <div class="alert alert-info" style="text-align: center">Este PPA no ha sido alineado a los instrumentos de planeación.</div>
                @endif
            </div>
        </div>
    </div> 
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex align-items-center justify-content-between"
                style="background-color: rgb(75,90,137);">
                <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Población o área de enfoque</h6>
                <div class="dropdown no-arrow">
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="poblacionContent">
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
           
        });
    </script>

@endsection
