@php
    use App\Models\LineaPED;
    use App\Models\Indicador;
@endphp
@extends('layouts.administrador')
@section('encabezado')
    ITAR / Reportes de Información <a href="{{ route('itar.listado') }}"><button class="btn btn-secondary"><i class="fas fa-arrow-left"></i> <i class="fas fa-home"></i> Tablero de PPAs</button></a>
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
<input type="hidden" id="idPPA" value="{{$ppa->id}}">
<div style="margin: 10px;text-align:right">
    <button id="btnSeguimiento" class="btn btn-success" onclick="showSeguimiento()"><i class="fas fa-chart-bar"></i> Reportes de Seguimiento</button>
    <button id="btnInfoGral" class="btn btn-primary" onclick="showGenerales()" style="display: none"><i class="fas fa-list"></i> Información General</button>
</div>
<div class="row" id="infoGral">
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex align-items-center justify-content-between"
                style="background-color: rgb(75,90,137);">
                <h6 class="m-0 font-weight-bold text-primary" style="color:white !important;cursor: pointer" onclick="toggle('chevdatosgenerales','body-datosgenerales')"
                >Datos Generales <i class="fas fa-chevron-down"
                    id="chevdatosgenerales"></i></h6>
                <div class="dropdown no-arrow">
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="body-datosgenerales">
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
                <h6 class="m-0 font-weight-bold text-primary" style="color:white !important;cursor:pointer" onclick="toggle('chevbss','body-bss')">Bienes o servicios <i class="fas fa-chevron-down"
                    id="chevbss"></i></h6>
                <div class="dropdown no-arrow">
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="body-bss">
                <center>
                <div class="row">
                @if($bss->count()>0)
                    @foreach ($bss as $bs )
                    <div class="col-xl-5 col-lg-7" style="padding-top:20px;border:solid 1px green;color:black;background-color:rgb(236, 236, 236);margin:10px;cursor:pointer" onmouseover="$(this).css('color','blue');$(this).css('background-color','white');" onmouseout="$(this).css('color','black');$(this).css('background-color','rgb(236, 236, 236)');">
                        <h4>{{$bs->nombreBS}}</h4>
                        <p style="font-size:.8em;text-align:justify">{{$bs->descripcionBS}}</p>                            
                        <div style="text-align: right;font-size:.7em">({{$bs->unidad_medidaBS}})</div>                            
                    </div>
                    @endforeach
                
                @else
                 <div class="alert alert-info col-xl-12 col-lg-5" style="text-align: center">No existen Bienes o Servicios dados de alta para este PPA.</div>
                @endif                
                </div>
                </center>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex align-items-center justify-content-between"
                style="background-color: rgb(75,90,137);">
                <h6 class="m-0 font-weight-bold text-primary" style="color:white !important;cursor: pointer;" onclick="toggle('chevalineacion','body-alineacion')">Alineación <i class="fas fa-chevron-down"
                    id="chevalineacion"></i></h6>
                <div class="dropdown no-arrow">
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="body-alineacion">
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
                <h6 class="m-0 font-weight-bold text-primary" style="color:white !important;cursor: pointer;" onclick="toggle('chevpoblacion','body-poblacion')">Población o área de enfoque <i class="fas fa-chevron-down"
                    id="chevpoblacion"></i></h6>
                <div class="dropdown no-arrow">
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="body-poblacion">
                @if($poblacion!=null)                        
                        @if(str_contains($poblacion->tipo,"p_"))    
                        <h4><i class="fas fa-users"></i> Población Objetivo</h4>                        
                            <table style="width:100%">
                                <tr>
                                    <td class="enc5" style="width:15%;border:1px solid gray">
                                        Tipo de población:
                                    </td>
                                    <td class="enc6" style="border:1px solid gray;font-size:1.3em">
                                       {{$poblacion->descripcion}} 
                                    </td>
                                    <td class="enc5" style="width:15%;border:1px solid gray">
                                        Descripción de la objetivo:
                                    </td>
                                    <td class="enc6" style="border:1px solid gray;font-size:1.3em">
                                       {{$poblacion->descripcion_poblacion}} 
                                    </td>                                    
                                </tr>
                            </table>
                            @endif
                            @if(str_contains($poblacion->tipo,"a_"))  
                                <br/>
                                <h4><i class="fas fa-check"></i> Área de enfoque objetivo</h4>                        
                                <table style="width:100%">
                                    <tr>
                                        <td class="enc5" style="width:15%;border:1px solid gray">
                                            Nombre del área de enfoque:
                                        </td>
                                        <td class="enc6" style="border:1px solid gray;font-size:1.3em">
                                        {{$poblacion->nombre_enfoque}} 
                                        </td>
                                        <td class="enc5" style="width:15%;border:1px solid gray">
                                            Descripción del área de enfoque:
                                        </td>
                                        <td class="enc6" style="border:1px solid gray;font-size:1.3em">
                                        {{$poblacion->descripcion_area}} 
                                        </td>                                    
                                    </tr>
                                </table>
                            @endif                       
                    @else
                        <div class="alert alert-info" style="text-align: center">No existe información de la población objetivo o área de enfoque.</div>
                @endif
            </div>
        </div>
    </div>
</div>
<div id="infoSeguimiento" style="display: none;">
    <div class="row" id="infoGral">
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex align-items-center justify-content-between"
                    style="background-color: rgb(75,90,137);">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Reportes de Seguimiento</h6>
                    <div class="dropdown no-arrow">
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <table style="width: 100%">
                        <tr>
                            <td class="enc5">Seleccione Año: </td>
                            <td class="enc6">
                                <select name="" id="anio" class="form-control" onchange="getSeguimiento()">
                                    <option value="">Seleccione</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <div id="seguimientoContent" style="display: none">                                               
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="modal fade" id="modalBSMonitoreo" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel" data-backdrop="static" data-keyboard="false"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(75,90,137);;color: white;font-weight: bold;">
                    <h5 class="modal-title" id="accionModalLabel" >Información de monitoreo por bien o servicio</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <div style="width: 100%;" id="infoBS">
                    </div>
                </div>
                <div class="modal-footer">                    
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
</div>
<div class="modal fade" id="modalDesglose" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel" data-backdrop="static" data-keyboard="false"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgb(75,90,137);;color: white;font-weight: bold;">
                    <h5 class="modal-title" id="accionModalLabel">Desglose de población y/o área de enfoque por región</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px;" id="body-desglose">                                       
                </div>
                <div class="modal-footer">                    
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $("#collapse-itar").addClass("show");
            $('#modalDesglose')
            .on('hidden.bs.modal', function (e) {
                $("#modalBSMonitoreo").modal("show");
            });
            $('#modalDesglose')
            .on('show.bs.modal', function (e) {
                $("#modalBSMonitoreo").modal("hide");
            });
        });

        function showSeguimiento(){
            $("#btnInfoGral").show();
            $("#btnSeguimiento").hide();
            $("#infoGral").hide("slow");
            $("#infoSeguimiento").show("slow");
        }      
        
        function showGenerales(){
            $("#btnInfoGral").hide("slow");
            $("#btnSeguimiento").show("slow");
            $("#infoGral").show("slow");
            $("#infoSeguimiento").hide("slow");
        }

        function getSeguimiento(){
            idPPA = $("#idPPA").val();
            anio = $("#anio").val();
            if($("#anio").val()!=""){
                $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getseguimientoreporte') }}",
                    data: {idPPA:idPPA,anio:anio},
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#seguimientoContent").block({
                            message: '<h7>Procesando...</h7>',
                            css: {
                                border: '3px solid gray',
                                backgroundColor: 'black',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                width: "15%",
                                color: "white",                                
                            }
                        });
                    }
                    }).done(function(response) {                        
                        $("#seguimientoContent").unblock();
                        $("#seguimientoContent").html(response);                                                
                        $("#seguimientoContent").show("slow");
                    });
            }else{
                $("#seguimientoContent").hide("slow");                
            }            
        }

        function toggle(icon,element){
            if($("#"+element).css("display")=="none"){
                $("#"+element).show("fast");
                $("#"+icon).removeClass("fa-chevron-right");
                $("#"+icon).addClass("fa-chevron-down");
            }else{
                $("#"+element).hide("fast");                
                $("#"+icon).removeClass("fa-chevron-down");
                $("#"+icon).addClass("fa-chevron-right");
            }
            
        }

        function getInfoMonitoreo(idBS){
        $.ajax({
                type: 'GET',
                url: "{{ route('ia.getmonitoreoreporte') }}",
                data: {idBS:idBS,idPPA:$("#idPPA").val(),anio:$("#anio").val()},
                //dataType: 'json',
                beforeSend: function() {
                    $("#monitoreo-bs").block({
                        message: '<h7>Procesando...</h7>',
                        css: {
                            border: '3px solid gray',
                            backgroundColor: 'black',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            width: "15%",
                            color: "white",                                
                        }
                    });
                }
                }).done(function(response) {                        
                    $("#monitoreo-bs").unblock();
                    $("#infoBS").html(response);
                    $("#modalBSMonitoreo").modal("show");
                });
        } 

        function toggle(icon, element) {
            if(element=="body-bsgenerales"){
                if ($("." + element).css("display") == "none") {
                    $("." + element).show("fast");
                    $("#" + icon).removeClass("fa-chevron-right");
                    $("#" + icon).addClass("fa-chevron-down");
                } else {
                    $("." + element).hide("fast");
                    $("#" + icon).removeClass("fa-chevron-down");
                    $("#" + icon).addClass("fa-chevron-right");
                }

            }else{
                if ($("#" + element).css("display") == "none") {
                    $("#" + element).show("fast");
                    $("#" + icon).removeClass("fa-chevron-right");
                    $("#" + icon).addClass("fa-chevron-down");
                } else {
                    $("#" + element).hide("fast");
                    $("#" + icon).removeClass("fa-chevron-down");
                    $("#" + icon).addClass("fa-chevron-right");
                }
            }
        }

        function refreshMetas(){
            //Obtenemos información de los datos por trimestre
            
            p1 = parseFloat($("#1p").html()==""?"0":$("#1p").html().replace(/,/g,""));
            p2 = parseFloat($("#2p").html()==""?"0":$("#2p").html().replace(/,/g,""));
            p3 = parseFloat($("#3p").html()==""?0:$("#3p").html().replace(/,/g,""));
            p4 = parseFloat($("#4p").html()==""?0:$("#4p").html().replace(/,/g,""));

            r1 = parseFloat($("#1r").html()==""?0:$("#1r").html().replace(/,/g,""));
            r2 = parseFloat($("#2r").html()==""?0:$("#2r").html().replace(/,/g,""));
            r3 = parseFloat($("#3r").html()==""?0:$("#3r").html().replace(/,/g,""));
            r4 = parseFloat($("#4r").html()==""?0:$("#4r").html().replace(/,/g,""));

            a1 = (r1/p1)*100;
            a2 = (r2/p2)*100;
            a3 = (r3/p3)*100;
            a4 = (r4/p4)*100;

            $("#1a").html(isNaN(a1)?"":a1.toFixed(2)+"%");
            $("#2a").html(isNaN(a2)?"":a2.toFixed(2)+"%");
            $("#3a").html(isNaN(a3)?"":a3.toFixed(2)+"%");
            $("#4a").html(isNaN(a4)?"":a4.toFixed(2)+"%");

            tap = p1 + p2 + p3 + p4;
            tar = r1 + r2 + r3 + r4;
            taa = (tar/tap)*100            

            $("#tap").html(tap.toLocaleString("es-MX"))
            $("#tar").html(tar.toLocaleString("es-MX"))
            $("#taa").html(isNaN(taa)?"":taa.toFixed(2)+"%")


        }

        function refreshPoblacionAtendida(){
            ph1 = parseFloat($("#ph1").html()==""?0:$("#ph1").html().replace(/,/g,""));
            ah1 = parseFloat($("#ah1").html()==""?0:$("#ah1").html().replace(/,/g,""));
            avh1 = (ah1/ph1)*100;
            $("#avh1").html(isNaN(avh1)?"":avh1.toFixed(2)+"%");

            ph2 = parseFloat($("#ph2").html()==""?0:$("#ph2").html().replace(/,/g,""));
            ah2 = parseFloat($("#ah2").html()==""?0:$("#ah2").html().replace(/,/g,""));
            avh2 = (ah2/ph2)*100;
            $("#avh2").html(isNaN(avh2)?"":avh2.toFixed(2)+"%");

            ph3 = parseFloat($("#ph3").html()==""?0:$("#ph3").html().replace(/,/g,""));
            ah3 = parseFloat($("#ah3").html()==""?0:$("#ah3").html().replace(/,/g,""));
            avh3 = (ah3/ph3)*100;
            $("#avh3").html(isNaN(avh3)?"":avh3.toFixed(2)+"%");

            ph4 = parseFloat($("#ph4").html()==""?0:$("#ph4").html().replace(/,/g,""));
            ah4 = parseFloat($("#ah4").html()==""?0:$("#ah4").html().replace(/,/g,""));
            avh4 = (ah4/ph4)*100;
            $("#avh4").html(isNaN(avh4)?"":avh4.toFixed(2)+"%");

            pm1 = parseFloat($("#pm1").html()==""?0:$("#pm1").html().replace(/,/g,""));
            am1 = parseFloat($("#am1").html()==""?0:$("#am1").html().replace(/,/g,""));
            avm1 = (am1/pm1)*100;
            $("#avm1").html(isNaN(avm1)?"":avm1.toFixed(2)+"%");

            pm2 = parseFloat($("#pm2").html()==""?0:$("#pm2").html().replace(/,/g,""));
            am2 = parseFloat($("#am2").html()==""?0:$("#am2").html().replace(/,/g,""));
            avm2 = (am2/pm2)*100;
            $("#avm2").html(isNaN(avm2)?"":avm2.toFixed(2)+"%");

            pm3 = parseFloat($("#pm3").html()==""?0:$("#pm3").html().replace(/,/g,""));
            am3 = parseFloat($("#am3").html()==""?0:$("#am3").html().replace(/,/g,""));
            avm3 = (am3/pm3)*100;
            $("#avm3").html(isNaN(avm3)?"":avm3.toFixed(2)+"%");

            pm4 = parseFloat($("#pm4").html()==""?0:$("#pm4").html().replace(/,/g,""));
            am4 = parseFloat($("#am4").html()==""?0:$("#am4").html().replace(/,/g,""));
            avm4 = (am4/pm4)*100;
            $("#avm4").html(isNaN(avm4)?"":avm4.toFixed(2)+"%");

            tp1 = ph1+pm1;
            ta1 = ah1+am1;

            tp2 = ph2+pm2;
            ta2 = ah2+am2;

            tp3 = ph3+pm3;
            ta3 = ah3+am3;

            tp4 = ph4+pm4;
            ta4 = ah4+am4;

            thp = ph1 + ph2 + ph3 + ph4;
            tmp = pm1 + pm2 + pm3 + pm4;            

            that = ah1 + ah2 + ah3 + ah4;
            tmat = am1 + am2 + am3 + am4;

            tha = (that / thp) * 100;
            tma = (tmat / tmp) * 100;

            ttp = thp + tmp;
            ttat = that + tmat;

            tta = (ttat / ttp) * 100;
            //alert(ttp+" / "+ttat +" = "+tta);

            $("#thp").html(thp.toLocaleString("es-MX"));
            $("#tmp").html(tmp.toLocaleString("es-MX"));

            $("#that").html(that.toLocaleString("es-MX"));
            $("#tmat").html(tmat.toLocaleString("es-MX"));

            $("#tha").html(isNaN(tha)?0:tha.toFixed(2)+"%");
            $("#tma").html(isNaN(tma)?0:tma.toFixed(2)+"%");

            $("#ttp").html(ttp.toLocaleString("es-MX"));
            $("#ttat").html(ttat.toLocaleString("es-MX"));
            $("#tta").html(isNaN(tta)?0:tta.toFixed(2)+"%");



            $("#tp1").html((tp1.toLocaleString("es-MX")));
            $("#ta1").html((ta1.toLocaleString("es-MX")));

            $("#tp2").html((tp2.toLocaleString("es-MX")));
            $("#ta2").html((ta2.toLocaleString("es-MX")));

            $("#tp3").html((tp3.toLocaleString("es-MX")));
            $("#ta3").html((ta3.toLocaleString("es-MX")));

            $("#tp4").html((tp4.toLocaleString("es-MX")));
            $("#ta4").html((ta4.toLocaleString("es-MX")));

            tap1 = (ta1/tp1)*100;
            tap2 = (ta2/tp2)*100;
            tap3 = (ta3/tp3)*100;
            tap4 = (ta4/tp4)*100;

            $("#tap1").html(isNaN(tap1)?"":tap1.toFixed(2)+"%");
            $("#tap2").html(isNaN(tap2)?"":tap2.toFixed(2)+"%");
            $("#tap3").html(isNaN(tap3)?"":tap3.toFixed(2)+"%");
            $("#tap4").html(isNaN(tap4)?"":tap4.toFixed(2)+"%");
        }

        function refreshAreaEnfoque(){            
            arp1 = parseFloat($("#arp1").html()==""?0:$("#arp1").html().replace(/,/g,""));
            ara1 = parseFloat($("#ara1").html()==""?0:$("#ara1").html().replace(/,/g,""));

            arp2 = parseFloat($("#arp2").html()==""?0:$("#arp2").html().replace(/,/g,""));
            ara2 = parseFloat($("#ara2").html()==""?0:$("#ara2").html().replace(/,/g,""));

            arp3 = parseFloat($("#arp3").html()==""?0:$("#arp3").html().replace(/,/g,""));
            ara3 = parseFloat($("#ara3").html()==""?0:$("#ara3").html().replace(/,/g,""));

            arp4 = parseFloat($("#arp4").html()==""?0:$("#arp4").html().replace(/,/g,""));
            ara4 = parseFloat($("#ara4").html()==""?0:$("#ara4").html().replace(/,/g,""));

            ava1 = (ara1/arp1)*100;
            ava2 = (ara2/arp2)*100;
            ava3 = (ara3/arp3)*100;
            ava4 = (ara4/arp4)*100;

            $("#ava1").html(isNaN(ava1)?"":ava1.toFixed(2)+"%");
            $("#ava2").html(isNaN(ava2)?"":ava2.toFixed(2)+"%");
            $("#ava3").html(isNaN(ava3)?"":ava3.toFixed(2)+"%");
            $("#ava4").html(isNaN(ava4)?"":ava4.toFixed(2)+"%");

            tapr = arp1 + arp2 + arp3 + arp4;
            taat = ara1 + ara2 + ara3 + ara4;
            taav = ( taat / tapr ) * 100;

            $("#tapr").html(tapr.toLocaleString("es-MX"));
            $("#taat").html(taat.toLocaleString("es-MX"));
            $("#taav").html(isNaN(taav)?0:taav.toFixed(2)+"%")


        }

        function refreshPresupuesto(){
            $(".operativo_bs").each(function(){
                pom1 = parseFloat($(this).find(".pom1").eq(0).html()==""?0:$(this).find(".pom1").eq(0).html().replace(/,/g,""));
                pom2 = parseFloat($(this).find(".pom2").eq(0).html()==""?0:$(this).find(".pom2").eq(0).html().replace(/,/g,""));
                pom3 = parseFloat($(this).find(".pom3").eq(0).html()==""?0:$(this).find(".pom3").eq(0).html().replace(/,/g,""));
                pom4 = parseFloat($(this).find(".pom4").eq(0).html()==""?0:$(this).find(".pom4").eq(0).html().replace(/,/g,""));

                poe1 = parseFloat($(this).find(".poe1").eq(0).html()==""?0:$(this).find(".poe1").eq(0).html().replace(/,/g,""));
                poe2 = parseFloat($(this).find(".poe2").eq(0).html()==""?0:$(this).find(".poe2").eq(0).html().replace(/,/g,""));
                poe3 = parseFloat($(this).find(".poe3").eq(0).html()==""?0:$(this).find(".poe3").eq(0).html().replace(/,/g,""));
                poe4 = parseFloat($(this).find(".poe4").eq(0).html()==""?0:$(this).find(".poe4").eq(0).html().replace(/,/g,""));

                avo1 = (poe1/pom1)*100;
                avo2 = (poe2/pom2)*100;
                avo3 = (poe3/pom3)*100;
                avo4 = (poe4/pom4)*100;

                $(this).find(".avo1").eq(0).html(isNaN(avo1)?"":avo1.toFixed(2)+"%");
                $(this).find(".avo2").eq(0).html(isNaN(avo2)?"":avo2.toFixed(2)+"%");
                $(this).find(".avo3").eq(0).html(isNaN(avo3)?"":avo3.toFixed(2)+"%");
                $(this).find(".avo4").eq(0).html(isNaN(avo4)?"":avo4.toFixed(2)+"%");

                tamo = pom1 +  pom2 + pom3 + pom4;
                taeo = poe1 + poe2 + poe3 + poe4;

                tao = (taeo/tamo)*100;

                $(this).find(".tamo").eq(0).html(isNaN(tamo)?"":new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD',}).format(tamo,2));
                $(this).find(".taeo").eq(0).html(isNaN(taeo)?"":new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD',}).format(taeo,2));
                $(this).find(".tao").eq(0).html(isNaN(tao)?"":tao.toFixed(2)+"%");
            })

            $(".inversion_bs").each(function(){
                pim1 = parseFloat($(this).find(".pim1").eq(0).html()==""?0:$(this).find(".pim1").eq(0).html().replace(/,/g,""));
                pim2 = parseFloat($(this).find(".pim2").eq(0).html()==""?0:$(this).find(".pim2").eq(0).html().replace(/,/g,""));
                pim3 = parseFloat($(this).find(".pim3").eq(0).html()==""?0:$(this).find(".pim3").eq(0).html().replace(/,/g,""));
                pim4 = parseFloat($(this).find(".pim4").eq(0).html()==""?0:$(this).find(".pim4").eq(0).html().replace(/,/g,""));

                pie1 =  parseFloat($(this).find(".pie1").eq(0).html()==""?0:$(this).find(".pie1").eq(0).html().replace(/,/g,""));
                pie2 =  parseFloat($(this).find(".pie2").eq(0).html()==""?0:$(this).find(".pie2").eq(0).html().replace(/,/g,""));
                pie3 =  parseFloat($(this).find(".pie3").eq(0).html()==""?0:$(this).find(".pie3").eq(0).html().replace(/,/g,""));
                pie4 =  parseFloat($(this).find(".pie4").eq(0).html()==""?0:$(this).find(".pie4").eq(0).html().replace(/,/g,""));

                avi1 = (pie1/pim1)*100;
                avi2 = (pie2/pim2)*100;
                avi3 = (pie3/pim3)*100;
                avi4 = (pie4/pim4)*100;           

                $(this).find(".avi1").eq(0).html(isNaN(avi1)?"":avi1.toFixed(2)+"%");
                $(this).find(".avi2").eq(0).html(isNaN(avi2)?"":avi2.toFixed(2)+"%");
                $(this).find(".avi3").eq(0).html(isNaN(avi3)?"":avi3.toFixed(2)+"%");
                $(this).find(".avi4").eq(0).html(isNaN(avi4)?"":avi4.toFixed(2)+"%");

                
                tami = pim1 + pim2 + pim3 + pim4;
                taei = pie1 + pie2 + pie3 + pie4;

                
                tai = (taei/tami)*100;

                
                $(this).find(".tami").eq(0).html(isNaN(tami)?"":new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD',}).format(tami,2));
                $(this).find(".taei").eq(0).html(isNaN(taei)?"":new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD',}).format(taei,2));

                
                $(this).find(".tai").eq(0).html(isNaN(tai)?"":tai.toFixed(2)+"%");
            })
        }
        function showDesglose(idBS){
            ah1 = $("#ah1").html();
            ah2 = $("#ah2").html();
            ah3 = $("#ah3").html();
            ah4 = $("#ah4").html();

            am1 = $("#am1").html();
            am2 = $("#am2").html();
            am3 = $("#am3").html();
            am4 = $("#am4").html();

            ara1 = $("#ara1").html();
            ara2 = $("#ara2").html();
            ara3 = $("#ara3").html();
            ara4 = $("#ara4").html();

            if(ah1 == "" && ah2 == "" && ah3 == "" && ah4 == "" && am1 == "" && am2 == "" && am3 == "" && am4 == "" && ara1 == "" && ara2 == "" && ara3 == "" && ara4 == ""){
                Swal.fire({
                                icon: 'info',
                                title: 'Atención a población o área de enfoque',
                                text: "No existe información de atención de población o de área de enfoque",
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {});
            }else{
                getDesglose();
                $("#modalDesglose").modal("show");
                setTimeout(function(){
                    validaDesglose();                    
                },800)
                
            }           
        }

        function getDesglose(){
            anio = $("#anio").val();
            idBS = $("#idBS").val();
            poblacion_ = $(".p_").length>0?true:false;
            area_ = $(".a_").length>0?true:false;
            $.ajax({
                    type: 'GET',
                    url: "{{ route('ia.getdesglosereporte') }}",
                    data: {anio:anio,idBS:idBS,poblacion:poblacion_,area:area_},
                    //dataType: 'json',
                    beforeSend: function() {
                        $("#body-desglose").block({
                            message: '<h7>Procesando...</h7>',
                            css: {
                                border: '3px solid gray',
                                backgroundColor: 'black',
                                '-webkit-border-radius': '10px',
                                '-moz-border-radius': '10px',
                                width: "15%",
                                color: "white",                                
                            }
                        });
                    }
                    }).done(function(response) {                        
                        $("#body-desglose").unblock();
                        $("#body-desglose").html(response);
                    });
        }

        function validaDesglose(){
            valid = true;
            poblacion_ = $(".p_").length>0?true:false;
            area_ = $(".a_").length>0?true:false;

            if(poblacion_){
                ah1 = parseFloat($("#ah1").html()==""?0:$("#ah1").html().replace(/,/g,""));
                am1 = parseFloat($("#am1").html()==""?0:$("#am1").html().replace(/,/g,""));

                ah2 = parseFloat($("#ah2").html()==""?0:$("#ah2").html().replace(/,/g,""));
                am2 = parseFloat($("#am2").html()==""?0:$("#am2").html().replace(/,/g,""));
                
                ah3 = parseFloat($("#ah3").html()==""?0:$("#ah3").html().replace(/,/g,""));
                am3 = parseFloat($("#am3").html()==""?0:$("#am3").html().replace(/,/g,""));
                
                ah4 = parseFloat($("#ah4").html()==""?0:$("#ah4").html().replace(/,/g,""));
                am4 = parseFloat($("#am4").html()==""?0:$("#am4").html().replace(/,/g,""));

                trh1 = parseFloat($("#trh1").html()==""?0:$("#trh1").html().replace(/,/g,""));
                trm1 = parseFloat($("#trm1").html()==""?0:$("#trm1").html().replace(/,/g,""));
                
                trh2 = parseFloat($("#trh2").html()==""?0:$("#trh2").html().replace(/,/g,""));
                trm2 = parseFloat($("#trm2").html()==""?0:$("#trm2").html().replace(/,/g,""));

                trh3 = parseFloat($("#trh3").html()==""?0:$("#trh3").html().replace(/,/g,""));
                trm3 = parseFloat($("#trm3").html()==""?0:$("#trm3").html().replace(/,/g,""));

                trh4 = parseFloat($("#trh4").html()==""?0:$("#trh4").html().replace(/,/g,""));
                trm4 = parseFloat($("#trm4").html()==""?0:$("#trm4").html().replace(/,/g,""));

                msg=true;

                if(trh1!=ah1){
                    msg=false;
                    $("#trh1").css("background-color","red");
                }else
                    $("#trh1").css("background-color","black");
                
                if(trh2!=ah2){
                    msg=false;
                    $("#trh2").css("background-color","red");
                }else
                    $("#trh2").css("background-color","black");

                if(trh2!=ah2){
                    msg=false;
                    $("#trh2").css("background-color","red");
                }else
                    $("#trh2").css("background-color","black");
                
                if(trh3!=ah3){
                    msg=false;
                    $("#trh3").css("background-color","red");
                }else
                    $("#trh3").css("background-color","black");

                if(trh4!=ah4){
                    msg=false;
                    $("#trh4").css("background-color","red");
                }else
                    $("#trh4").css("background-color","black");
                
                if(trm1!=am1){
                    msg=false;
                    $("#trm1").css("background-color","red");
                }else
                    $("#trm1").css("background-color","black");
                
                if(trm2!=am2){
                    msg=false;
                    $("#trm2").css("background-color","red");
                }else
                    $("#trm2").css("background-color","black");
                
                if(trm3!=am3){
                    msg=false;
                    $("#trm3").css("background-color","red");
                }else
                    $("#trm3").css("background-color","black");
                
                if(trm4!=am4){
                    msg=false;
                    $("#trm4").css("background-color","red");
                }else
                    $("#trm4").css("background-color","black");                                           
            }

            if(area_){                
                tro1 = parseFloat($("#tro1").html().replace(/,/g,""));
                tro2 = parseFloat($("#tro2").html().replace(/,/g,""));
                tro3 = parseFloat($("#tro3").html().replace(/,/g,""));
                tro4 = parseFloat($("#tro4").html().replace(/,/g,""));

                ara1 = parseFloat($("#ara1").html()==""?0:$("#ara1").html().replace(/,/g,""));
                ara2 = parseFloat($("#ara2").html()==""?0:$("#ara2").html().replace(/,/g,""));
                ara3 = parseFloat($("#ara3").html()==""?0:$("#ara3").html().replace(/,/g,""));
                ara4 = parseFloat($("#ara4").html()==""?0:$("#ara4").html().replace(/,/g,""));

                msg=true;

                if(tro1!=ara1){
                    msg = false;
                    $("#tro1").css("background-color","red");
                }else
                    $("#tro1").css("background-color","black");
                
                if(tro2!=ara2){
                    msg = false;
                    $("#tro2").css("background-color","red");
                }else
                    $("#tro2").css("background-color","black");
                
                if(tro3!=ara3){
                    msg = false;
                    $("#tro3").css("background-color","red");
                }else
                    $("#tro3").css("background-color","black");
            
                if(tro4!=ara4){
                    msg = false;
                    $("#tro4").css("background-color","red");
                }else
                    $("#tro4").css("background-color","black");
            }   

           /* if(!msg){
                    Swal.fire({
                                icon: 'warning',
                                title: 'Validación de Datos de Desglose por región',
                                text: "Los totales no son congruentes con las metas reportadas en el monitoreo de población beneficiada o área de enfoque atendida (El total del desglose debe ser igual a las metas alcanzadas en el trimestre)",
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {});
                }*/
            
            return valid;
        }

        function toggleTrimestre(elemento,trimestre){
            if(elemento.prop("checked")){
                $(".trim"+trimestre).show("slow");
            }else{
                $(".trim"+trimestre).hide("slow");
            }
        }

        function refreshDesglose(){
            sumah1 = 0;
            sumah2 = 0;
            sumah3 = 0;
            sumah4 = 0;
            
            sumam1 = 0;
            sumam2 = 0;
            sumam3 = 0;
            sumam4 = 0;

            sumao1 = 0;
            sumao2 = 0;
            sumao3 = 0;
            sumao4 = 0;

            for(x=1;x<=8;x++){                
                sumah1 += parseFloat($("#h1"+x).html()==""?0:$("#h1"+x).html());
                sumah2 += parseFloat($("#h2"+x).html()==""?0:$("#h2"+x).html());
                sumah3 += parseFloat($("#h3"+x).html()==""?0:$("#h3"+x).html());
                sumah4 += parseFloat($("#h4"+x).html()==""?0:$("#h4"+x).html());
                
                sumam1 += parseFloat($("#m1"+x).html()==""?0:$("#m1"+x).html());
                sumam2 += parseFloat($("#m2"+x).html()==""?0:$("#m2"+x).html());
                sumam3 += parseFloat($("#m3"+x).html()==""?0:$("#m3"+x).html());
                sumam4 += parseFloat($("#m4"+x).html()==""?0:$("#m4"+x).html());

                sumao1 += parseFloat($("#o1"+x).html()==""?0:$("#o1"+x).html());
                sumao2 += parseFloat($("#o2"+x).html()==""?0:$("#o2"+x).html());
                sumao3 += parseFloat($("#o3"+x).html()==""?0:$("#o3"+x).html());
                sumao4 += parseFloat($("#o4"+x).html()==""?0:$("#o4"+x).html());
            }
            //alert(sumah1);

            $("#trh1").html(isNaN(sumah1)?"":sumah1.toLocaleString("es-MX"));
            $("#trh2").html(isNaN(sumah2)?"":sumah2.toLocaleString("es-MX"));
            $("#trh3").html(isNaN(sumah3)?"":sumah3.toLocaleString("es-MX"));
            $("#trh4").html(isNaN(sumah4)?"":sumah4.toLocaleString("es-MX"));

            $("#trm1").html(isNaN(sumam1)?"":sumam1.toLocaleString("es-MX"));
            $("#trm2").html(isNaN(sumam2)?"":sumam2.toLocaleString("es-MX"));
            $("#trm3").html(isNaN(sumam3)?"":sumam3.toLocaleString("es-MX"));
            $("#trm4").html(isNaN(sumam4)?"":sumam4.toLocaleString("es-MX"));

            $("#tro1").html(isNaN(sumao1)?"":sumao1.toLocaleString("es-MX"));
            $("#tro2").html(isNaN(sumao2)?"":sumao2.toLocaleString("es-MX"));
            $("#tro3").html(isNaN(sumao3)?"":sumao3.toLocaleString("es-MX"));
            $("#tro4").html(isNaN(sumao4)?"":sumao4.toLocaleString("es-MX"));
        }
    </script>

@endsection
