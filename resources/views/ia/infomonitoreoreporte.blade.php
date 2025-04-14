<center>    
<table style="width:100%">
    <tr><td colspan="4" style="text-align: center;background-color: rgb(167,176,207);color:white;cursor:pointer" onclick="toggle('chevbsgenerales','body-bsgenerales')">Datos Generales <i class="fas fa-chevron-down" id="chevbsgenerales"></i></td></tr>
    <tr class="body-bsgenerales">
        <td class="enc5" style="width: 15%;border:solid 1px gray;">Nombre:</td>
        <td class="enc6" style="border:solid 1px gray;color:black">{{$infoBS->nombreBS}}</td>
        <td class="enc5" style="width: 15%;border:solid 1px gray;">Periodicidad de Entrega:</td>
        <td class="enc6" style="border:solid 1px gray;color:black">{{$infoBS->p_entrega}}</td>
    </tr>
    <tr class="body-bsgenerales">
        <td class="enc5" style="width: 15%;border:solid 1px gray;">Descripción:</td>
        <td class="enc6" style="border:solid 1px gray;color:black">{{$infoBS->descripcionBS}}</td>
        <td class="enc5" style="width: 15%;border:solid 1px gray;">Unidad de medida:</td>
        <td class="enc6" style="border:solid 1px gray;color:black">{{$infoBS->unidad_medidaBS}}</td>
    </tr>
    <tr><td colspan="4" style="text-align: center;background-color: rgb(167,176,207);color:white;cursor:pointer" onclick="toggle('chevbsmonitoreo','body-bsmonitoreo')">Monitoreo de metas <i class="fas fa-chevron-down" id="chevbsmonitoreo"></i></td></tr>
    <tr id="body-bsmonitoreo">
        <td colspan="4">
            @if($entregas!=null)
            <table style="width: 100%">
                <tr>
                    <td class="enc5" style="border: solid 1px gray;text-align:left">Periodo</td>
                    <td class="enc5" style="border: solid 1px gray;text-align:center">Enero-Marzo</td>
                    <td class="enc5" style="border: solid 1px gray;text-align:center">Abril-Junio</td>
                    <td class="enc5" style="border: solid 1px gray;text-align:center">Julio-Septiembre</td>
                    <td class="enc5" style="border: solid 1px gray;text-align:center">Octubre-Diciembre</td>
                    <td class="enc5" style="border: solid 1px gray;text-align:center">Total anual</td>
                </tr>
                <tr>
                    <td class="enc5" style="border: solid 1px gray">Programado</td>
                    <td style="border: solid 1px gray;text-align:right" id="1p" class="enc6">
                         {{$entregas->p1}}                        
                    </td>
                    <td style="border: solid 1px gray;text-align:right" id="2p" class="enc6">
                        {{$entregas->p2}}                        
                    </td>
                    <td style="border: solid 1px gray;text-align:right" id="3p" class="enc6">
                        {{$entregas->p3}}                        
                    </td>
                    <td style="border: solid 1px gray;text-align:right" id="4p" class="enc6">
                        {{$entregas->p4}}                        
                    </td>
                    <td class="enc6" style="text-align: right;border: solid 1px gray;font-weight:bold;font-size:1.5em" id="tap">
                    </td>
                </tr>
                <tr>
                    <td class="enc5" style="border: solid 1px gray">Realizado</td>
                    <td style="border: solid 1px gray;text-align:right" id="1r" class="enc6">{{$entregas->r1}}</td>
                    <td style="border: solid 1px gray;text-align:right" id="2r" class="enc6">{{$entregas->r2}}</td>
                    <td style="border: solid 1px gray;text-align:right" id="3r" class="enc6">{{$entregas->r3}}</td>
                    <td style="border: solid 1px gray;text-align:right" id="4r" class="enc6">{{$entregas->r4}}</td>
                    <td class="enc6" style="text-align: right;border: solid 1px gray;font-weight:bold;font-size:1.5em" id="tar"></td>
                </tr>
                <tr>
                    <td class="enc5" style="border: solid 1px gray"  id="">Avance</td>
                    <td class="enc6" style="text-align: right;border:solid 1px gray;font-weight:bold; font-size:1.5em" id="1a"> </td>
                    <td class="enc6" style="text-align: right;border:solid 1px gray;font-weight:bold; font-size:1.5em" id="2a"> </td>
                    <td class="enc6" style="text-align: right;border:solid 1px gray;font-weight:bold; font-size:1.5em" id="3a"> </td>
                    <td class="enc6" style="text-align: right;border:solid 1px gray;font-weight:bold; font-size:1.5em" id="4a"> </td>
                    <td class="enc6" style="text-align: right;border:solid 1px gray;font-weight:bold; font-size:1.5em" id="taa"></td>
                </tr>
            </table>
            <script>
               // refreshMetas();
                // loadPP_a();
            </script>
            @else
                <div class="alert alert-info" style="text-align:center">No se ha registrado información de las metas!</div>
            @endif
        </td>
    </tr>
    <tr><td colspan="4" style="text-align: center;background-color: rgb(167,176,207);;color:white;cursor:pointer" onclick="toggle('chevpoblacionatendida','body-poblacionatendida')">Población beneficiada o área de enfoque atendida <i class="fas fa-chevron-down" id="chevpoblacionatendida"></i></td></tr>    
    <tr id="body-poblacionatendida">
        <td colspan="4">
            @if($poblacionmeta!=null || $areameta != null)            
                <table style="width: 100%;font-size:.8em;">                
                    <tr>       
                        <td class="enc5" rowspan="2" style="width:20%;text-align:center">Periodo</td>             
                        <td class="enc5" colspan="3" style="width:20%;text-align:center">Enero-Marzo</td>
                        <td class="enc5" colspan="3" style="width:20%;text-align:center">Abril-Junio</td>
                        <td class="enc5" colspan="3" style="width:20%;text-align:center">Julio-Septiembre</td>
                        <td class="enc5" colspan="3" style="width:20%;text-align:center">Octubre-Diciembre</td>
                        <td class="enc5" colspan="3" style="width:20%;text-align:center">Total Anual</td>
                    </tr>
                    <tr>
                        <td class="enc5" style="text-align: center;width:6.60%">
                            Prog.
                        </td>
                        <td class="enc5" style="text-align: center;width:6.60%">
                            Atendida
                        </td>
                        <td class="enc5" style="text-align: center;width:6.60%">
                            Avance
                        </td>
                        <td class="enc5" style="text-align: center;width:6.60%">
                            Prog.
                        </td>
                        <td class="enc5" style="text-align: center;width:6.60%">
                            Atendida
                        </td>
                        <td class="enc5" style="text-align: center;width:6.60%">
                            Avance
                        </td>
                        <td class="enc5" style="text-align: center;width:6.60%">
                            Prog.
                        </td>
                        <td class="enc5" style="text-align: center;width:6.60%">
                            Atendida
                        </td>
                        <td class="enc5" style="text-align: center;width:6.60%">
                            Avance
                        </td>
                        <td class="enc5" style="text-align: center;width:6.60%">
                            Prog.
                        </td>
                        <td class="enc5" style="text-align: center;width:6.60%">
                            Atendida
                        </td>
                        <td class="enc5" style="text-align: center;width:6.60%">
                            Avance
                        </td>
                        <td class="enc5" style="text-align: center;width:6.60%">
                            Prog.
                        </td>
                        <td class="enc5" style="text-align: center;width:6.67%">
                            Atendida
                        </td>
                        <td class="enc5" style="text-align: center;width:6.67%">
                            Avance
                        </td>
                    </tr>
                    @if($poblacionmeta!=null)
                        <tr class="p_" @if(!$poblacionmeta!=null)style="display:none"@endif>
                            <td class="enc5">Hombres:</td>
                            <td id="ph1" class="enc6" style="text-align:right">@if($poblacionmeta!=null){{$poblacionmeta->ph1}}@endif</td>
                            <td id="ah1" class="enc6" style="text-align:right">@if($poblacionmeta!=null){{$poblacionmeta->ah1}}@endif</td>
                            <td class="enc5" id="avh1" style="text-align:right"></td> 
                            <td id="ph2" class="enc6" style="text-align:right">@if($poblacionmeta!=null){{$poblacionmeta->ph2}}@endif</td>
                            <td id="ah2" class="enc6" style="text-align:right">@if($poblacionmeta!=null){{$poblacionmeta->ah2}}@endif</td>
                            <td class="enc5" id="avh2" style="text-align:right"></td>
                            <td id="ph3" class="enc6" style="text-align:right">@if($poblacionmeta!=null){{$poblacionmeta->ph3}}@endif</td>
                            <td id="ah3" class="enc6" style="text-align:right">@if($poblacionmeta!=null){{$poblacionmeta->ah3}}@endif</td>
                            <td class="enc5" id="avh3" style="text-align:right"></td>
                            <td id="ph4" class="enc6" style="text-align:right">@if($poblacionmeta!=null){{$poblacionmeta->ph4}}@endif</td>
                            <td id="ah4" class="enc6" style="text-align:right">@if($poblacionmeta!=null){{$poblacionmeta->ah4}}@endif</td>     
                            <td class="enc5" id="avh4" style="text-align:right"></td>
                            <td class="enc5" id="thp" style="text-align:right"></td>
                            <td class="enc5" id="that" style="text-align:right"></td>
                            <td class="enc5" id="tha" style="text-align:right"></td>                    
                        </tr>
                        <tr class="p_" @if(!$poblacionmeta!=null) style="display: none" @endif>
                            <td class="enc5">Mujeres:</td>
                            <td id="pm1" style="text-align:right" class="enc6">@if($poblacionmeta!=null){{$poblacionmeta->pm1}}@endif</td>
                            <td id="am1" style="text-align:right" class="enc6">@if($poblacionmeta!=null){{$poblacionmeta->am1}}@endif</td>
                            <td class="enc5" id="avm1" style="text-align:right"></td>
                            <td id="pm2" style="text-align:right" class="enc6">@if($poblacionmeta!=null){{$poblacionmeta->pm2}}@endif</td>
                            <td id="am2" style="text-align:right" class="enc6">@if($poblacionmeta!=null){{$poblacionmeta->am2}}@endif</td>
                            <td class="enc5" id="avm2" style="text-align:right"></td>
                            <td id="pm3" style="text-align:right" class="enc6">@if($poblacionmeta!=null){{$poblacionmeta->pm3}}@endif</td>
                            <td id="am3" style="text-align:right" class="enc6">@if($poblacionmeta!=null){{$poblacionmeta->am3}}@endif</td>
                            <td class="enc5" id="avm3" style="text-align:right"></td>
                            <td id="pm4" style="text-align:right" class="enc6">@if($poblacionmeta!=null){{$poblacionmeta->pm4}}@endif</td>
                            <td id="am4" style="text-align:right" class="enc6">@if($poblacionmeta!=null){{$poblacionmeta->am4}}@endif</td>   
                            <td class="enc5" id="avm4" style="text-align:right"></td>   
                            <td class="enc5" id="tmp" style="text-align:right"></td>
                            <td class="enc5" id="tmat" style="text-align:right"></td>
                            <td class="enc5" id="tma" style="text-align:right"></td>                                  
                        </tr>
                        <tr class="p_" style="">
                            <td class="enc5">Total:</td>
                            <td class="enc5" id="tp1" style="text-align:right"></td>
                            <td class="enc5" id="ta1" style="text-align:right"></td>
                            <td class="enc5" id="tap1" style="text-align: right;font-weight:bold"></td>
                            <td class="enc5" id="tp2" style="text-align:right"></td>
                            <td class="enc5" id="ta2" style="text-align:right"></td>
                            <td class="enc5 id="tap2" style="text-align: right;font-weight:bold"></td>
                            <td class="enc5" id="tp3" style="text-align:right"></td>
                            <td class="enc5" id="ta3" style="text-align:right"></td>
                            <td class="enc5 id="tap3" style="text-align: right;font-weight:bold"></td>
                            <td class="enc5" id="tp4" style="text-align:right"></td>
                            <td class="enc5" id="ta4" style="text-align:right"></td>                    
                            <td class="enc5 id="tap4" style="text-align: right;font-weight:bold"></td>                      
                            <td class="enc5" id="ttp" style="text-align:right"></td>
                            <td class="enc5" id="ttat" style="text-align:right"></td>
                            <td class="enc5" id="tta" style="text-align:right"></td>                  
                        </tr>
                    @endif
                    @if($areameta != null)
                        <tr class="a_" style="">
                            <td class="enc5" colspan="16" style="text-align: center">Área de enfoque</td>
                        </tr>
                        <tr class="a_" style="">
                            <td class="enc5">{{$poblacion->nombre_enfoque}}</td>
                            <td class="enc6" id="arp1" style="text-align: right">@if($areameta!=null){{$areameta->arp1}}@endif</td>
                            <td class="enc6" id="ara1" style="text-align: right">@if($areameta!=null){{$areameta->ara1}}@endif</td>
                            <td class="enc5" id="ava1" style="text-align:right"></td>
                            <td class="enc6" id="arp2" style="text-align: right">@if($areameta!=null){{$areameta->arp2}}@endif</td>
                            <td class="enc6" id="ara2" style="text-align: right">@if($areameta!=null){{$areameta->ara2}}@endif</td>
                            <td class="enc5" id="ava2" style="text-align:right"></td>
                            <td class="enc6" id="arp3" style="text-align: right">@if($areameta!=null){{$areameta->arp3}}@endif</td>
                            <td class="enc6" id="ara3" style="text-align: right">@if($areameta!=null){{$areameta->ara3}}@endif</td>
                            <td class="enc5" id="ava3" style="text-align:right"></td>
                            <td class="enc6" id="arp4" style="text-align: right">@if($areameta!=null){{$areameta->arp4}}@endif</td>
                            <td class="enc6" id="ara4" style="text-align: right">@if($areameta!=null){{$areameta->ara4}}@endif</td>     
                            <td class="enc5" id="ava4" style="text-align:right"></td>  
                            <td class="enc5" id="tapr" style="text-align:right"></td>
                            <td class="enc5" id="taat" style="text-align:right"></td>
                            <td class="enc5" id="taav" style="text-align:right"></td>             
                        </tr>
                    @endif
                    <tr class="">
                        <td class="enc1" colspan="16" style="text-align: right">
                            <button class="btn btn-primary" onclick="showCargaMunicipios({{$infoBS->idBS}})" disabled><i class="fas fa-arrow-up"></i> Desglose por municipios</button>
                            <button class="btn btn-primary" onclick="showDesglose({{$infoBS->idBS}})"><i class="fas fa-list"></i> Desglose por región</button>                        
                        </td>
                    </tr>

                </table>
            @else
                <div class="alert alert-info" style="text-align:center">No existe información registrada de población o área de enfoque!</div>
            @endif
            <script>
                @if($poblacionmeta!=null)
                    //selectAtencion("poblacion");
                @endif
                @if($areameta!=null)
                   // selectAtencion("area");
                @endif
                ///refreshPoblacionAtendida();
                // refreshAreaEnfoque();
            </script>
        </td>
    </tr>
    <tr><td colspan="4" style="text-align: center;background-color: rgb(167,176,207);color:white;cursor:pointer" onclick="toggle('chevpresupuestotrimestral','body-presupuestotrimestral')">Presupuesto modificado y ejercido por trimestre <i class="fas fa-chevron-down" id="chevpresupuestotrimestral"></i></td></tr>    
    <tr id="body-presupuestotrimestral">
        <td colspan="4">
            <hr/>
            <div id="gasto_operativo_bs">                
                <h4>Gasto Operativo</h4>              
                <div id="operativoBSContent"> 
                    @if($operativos->count()>0)
                        @foreach($operativos as $operativo)
                            <div style="border: solid 1px blue;border-radius:5px;padding:10px;margin:10px;" id="operativobs{{$operativo->idPrograma}}">
                                <table class="operativo_bs" programa="{{$operativo->idPrograma}}">
                                    <thead>
                                        <tr>
                                            <td class="enc5" colspan="1">Programa Prespuestario:</td>
                                            <td class="enc6" colspan="2">{{$operativo->clavePrograma." ".$operativo->descripcionPrograma}}</td>
                                            <td class="enc5" colspan="1">Componente:</td>
                                            <td class="enc6" colspan="2">{{$operativo->componente}}</td>
                                        </tr>
                                        <tr>
                                            <td class="enc5">Concepto/Trimestre</td>
                                            <td class="enc5">Enero-Marzo</td>
                                            <td class="enc5">Abril-Junio</td>
                                            <td class="enc5">Julio-Septiembre</td>
                                            <td class="enc5">Octubre-Diciembre</td>
                                            <td class="enc5">Total Anual</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="po_">
                                            <td class="enc5">Modificado</td>
                                            <td class="pom1 enc6" style="text-align: right">{{$operativo->m1}}</td>
                                            <td class="pom2 enc6" style="text-align: right">{{$operativo->m2}}</td>
                                            <td class="pom3 enc6" style="text-align: right">{{$operativo->m3}}</td>
                                            <td class="pom4 enc6" style="text-align: right">{{$operativo->m4}}</td>
                                            <td class="enc5 tamo" style="text-align:right;font-size:1.5em"></td>
                                        </tr>
                                        <tr class="op_">
                                            <td class="enc5">Ejercido</td>
                                            <td class="poe1 enc6" style="text-align: right" >{{$operativo->e1}}</td>
                                            <td class="poe2 enc6" style="text-align: right" >{{$operativo->e2}}</td>
                                            <td class="poe3 enc6" style="text-align: right" >{{$operativo->e3}}</td>
                                            <td class="poe4 enc6" style="text-align: right" >{{$operativo->e4}}</td>
                                            <td class="enc5 taeo" style="text-align:right;font-size:1.5em"></td>
                                        </tr>
                                        <tr class="op_">
                                            <td class="enc5">Avance</td>
                                            <td class="enc5 avo1" style="text-align:right;font-size:1.3em"></td>
                                            <td class="enc5 avo2" style="text-align:right;font-size:1.3em"></td>
                                            <td class="enc5 avo3" style="text-align:right;font-size:1.3em"></td>
                                            <td class="enc5 avo4" style="text-align:right;font-size:1.3em"></td>
                                            <td class="enc5 tao" style="text-align:right;font-size:1.5em"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info" style="text-align:center">No existen registros de presupuesto en el área de gasto operativo!</div>
                    @endif                                                                                                  
                </div>   
            </div>                                    
                <hr/>
                <div id="gasto_inversion_bs" >
                    <h4>Gasto de Inversión</h4>
                    <div id="inversionBSContent">   
                        @if($inversiones->count()>0)
                            @foreach($inversiones as $inversion)
                            <div style="border: solid 1px blue;border-radius:5px;padding:10px;margin:10px;" id="inversionbs{{$inversion->idPrograma}}"><table class="inversion_bs" programa="{{$inversion->idPrograma}}">
                                <thead>                                   
                                    <tr>
                                        <td class="enc5" colspan="1">Programa Prespuestario:</td>
                                        <td colspan="2" class="enc6">{{$inversion->clavePrograma." ".$inversion->descripcionPrograma}}</td>
                                        <td class="enc5" colspan="1">Componente:</td>
                                        <td class="enc6" colspan="2">{{$inversion->componente}}</td>
                                    </tr>
                                    <tr>
                                        <td class="enc5">Concepto/Trimestre</td>
                                        <td class="enc5">Enero-Marzo</td>
                                        <td class="enc5">Abril-Junio</td>
                                        <td class="enc5">Julio-Septiembre</td>
                                        <td class="enc5">Octubre-Diciembre</td>
                                        <td class="enc5">Total Anual</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="pi_">
                                        <td class="enc5">Modificado</td>
                                        <td class="pim1 enc6" style="text-align: right">{{$inversion->m1}}</td>
                                        <td class="pim2 enc6" style="text-align: right">{{$inversion->m2}}</td>
                                        <td class="pim3 enc6" style="text-align: right">{{$inversion->m3}}</td>
                                        <td class="pim4 enc6" style="text-align: right">{{$inversion->m4}}</td>
                                        <td class="enc5 tami" style="text-align:right;font-size:1.5em"></td>
                                    </tr>
                                    <tr class="pi_">
                                        <td class="enc5">Ejercido</td>
                                        <td class="pie1 enc6" style="text-align: right">{{$inversion->e1}}</td>
                                        <td class="pie2 enc6" style="text-align: right">{{$inversion->e2}}</td>
                                        <td class="pie3 enc6" style="text-align: right">{{$inversion->e3}}</td>
                                        <td class="pie4 enc6" style="text-align: right">{{$inversion->e4}}</td>
                                        <td class="enc5 taei" style="text-align:right;font-size:1.5em"></td>
                                    </tr>
                                    <tr class="pi_">
                                        <td class="enc5">Avance</td>
                                        <td class="enc5 avi1" style="text-align:right;font-size:1.3em"></td>
                                        <td class="enc5 avi2" style="text-align:right;font-size:1.3em"></td>
                                        <td class="enc5 avi3" style="text-align:right;font-size:1.3em"></td>
                                        <td class="enc5 avi4" style="text-align:right;font-size:1.3em"></td>
                                        <td class="enc5 tai" style="text-align:right;font-size:1.5em"></td>
                                    </tr>
                                </tbody>
                            </table></div>
                            @endforeach  
                        @else
                            <div class="alert alert-info" style="text-align:center">No existen registros de presupuesto en el área de gasto de inversión!</div>
                        @endif                        
                    </div> 

                </div>
                @if(false)
                    <table style="width: 100%;display:none">
                        <tr>
                            <td class="enc1" style="text-align: center">Tipo de gasto</td>    
                            <td class="enc1" style="text-align: center">Concepto/Trimestre</td>    
                            <td class="enc1" style="text-align: center">Enero-Marzo</td>    
                            <td class="enc1" style="text-align: center">Abril-Junio</td>    
                            <td class="enc1" style="text-align: center">Julio-Septiembre</td>    
                            <td class="enc1" style="text-align: center">Octubre-Diciembre</td>    
                            <td class="enc1" style="text-align: center">Total anual</td>    
                        </tr>
                        <tr class="op_">
                            <td rowspan="3" class="enc1">Operativo</td>
                            <td class="enc1">Modificado</td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="pom1" onchange="refreshPresupuesto()" @if($operativo!=null) value="{{$operativo->m1}}" @endif></td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="pom2" onchange="refreshPresupuesto()" @if($operativo!=null) value="{{$operativo->m2}}" @endif></td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="pom3" onchange="refreshPresupuesto()" @if($operativo!=null) value="{{$operativo->m3}}" @endif></td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="pom4" onchange="refreshPresupuesto()" @if($operativo!=null) value="{{$operativo->m4}}" @endif></td>
                            <td class="enc4" id="tamo" style="text-align:right;font-size:1.5em"></td>
                        </tr>
                        <tr class="op_">                    
                            <td class="enc1">Ejercido</td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="poe1" onchange="refreshPresupuesto()" @if($operativo!=null) value="{{$operativo->e1}}" @endif></td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="poe2" onchange="refreshPresupuesto()" @if($operativo!=null) value="{{$operativo->e2}}" @endif></td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="poe3" onchange="refreshPresupuesto()" @if($operativo!=null) value="{{$operativo->e3}}" @endif></td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="poe4" onchange="refreshPresupuesto()" @if($operativo!=null) value="{{$operativo->e4}}" @endif></td>
                            <td class="enc4" id="taeo" style="text-align:right;font-size:1.5em"></td>
                        </tr>
                        <tr class="op_">
                            <td class="enc1">Avance</td>
                            <td class="enc4" id="avo1" style="text-align:right;font-size:1.3em"></td>
                            <td class="enc4" id="avo2" style="text-align:right;font-size:1.3em"></td>
                            <td class="enc4" id="avo3" style="text-align:right;font-size:1.3em"></td>
                            <td class="enc4" id="avo4" style="text-align:right;font-size:1.3em"></td>
                            <td class="enc4" id="tao" style="text-align:right;font-size:1.5em"></td>
                        </tr>
                        <tr class="op_">
                            <td rowspan="3" class="enc1">Inversión</td>
                            <td class="enc1">Modificado</td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="pim1" onchange="refreshPresupuesto()" @if($inversion!=null) value="{{$inversion->m1}}" @endif></td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="pim2" onchange="refreshPresupuesto()" @if($inversion!=null) value="{{$inversion->m2}}" @endif></td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="pim3" onchange="refreshPresupuesto()" @if($inversion!=null) value="{{$inversion->m3}}" @endif></td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="pim4" onchange="refreshPresupuesto()" @if($inversion!=null) value="{{$inversion->m4}}" @endif></td>
                            <td class="enc4" id="tami" style="text-align:right;font-size:1.5em"></td>
                        </tr>
                        <tr class="op_">                    
                            <td class="enc1">Ejercido</td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="pie1" onchange="refreshPresupuesto()" @if($inversion!=null) value="{{$inversion->e1}}" @endif></td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="pie2" onchange="refreshPresupuesto()" @if($inversion!=null) value="{{$inversion->e2}}" @endif></td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="pie3" onchange="refreshPresupuesto()" @if($inversion!=null) value="{{$inversion->e3}}" @endif></td>
                            <td><input type="number" class="form-control" style="text-align:right;font-size:1.3em" id="pie4" onchange="refreshPresupuesto()" @if($inversion!=null) value="{{$inversion->e4}}" @endif></td>
                            <td class="enc4" id="taei" style="text-align:right;font-size:1.5em"></td>
                        </tr>
                        <tr class="op_">
                            <td class="enc1">Avance</td>
                            <td class="enc4" id="avi1" style="text-align:right;font-size:1.3em"></td>
                            <td class="enc4" id="avi2" style="text-align:right;font-size:1.3em"></td>
                            <td class="enc4" id="avi3" style="text-align:right;font-size:1.3em"></td>
                            <td class="enc4" id="avi4" style="text-align:right;font-size:1.3em"></td>
                            <td class="enc4" id="tai" style="text-align:right;font-size:1.5em"></td>
                        </tr>
                    </table>
                @endif

            <script>
                //refreshPresupuesto();
            </script>
        </td>
    </tr>

</table>
</center>

<h6 class="m-0 font-weight-bold text-light"
                         style="cursor: pointer;color:white">
                        Monitoreo por bien o servicio <i class="fas fa-chevron-down" id="chevmonitoreo"></i>
                    </h6>