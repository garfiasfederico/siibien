<button class="btn btn-secondary" onclick="backListadoBS()"><i class="fas fa-arrow-left" ></i> Regresar al Listado</button>
<hr/>
<center>
<table style="width:100%">
    <tr><td colspan="4" style="text-align: center;background-color:rgb(243,203,215);color:gray;cursor:pointer" onclick="toggle('chevbsgenerales','body-bsgenerales')">Datos Generales <i class="fas fa-chevron-down" id="chevbsgenerales"></i></td></tr>
    <tr class="body-bsgenerales">
        <td class="enc1" style="width: 15%;border:solid 1px gray;">Nombre:</td>
        <td style="border:solid 1px gray;color:black">{{$infoBS->nombreBS}}</td>
        <td class="enc1" style="width: 15%;border:solid 1px gray;">Periodicidad de Entrega:</td>
        <td style="border:solid 1px gray;color:black">{{$infoBS->p_entrega}}</td>
    </tr>
    <tr class="body-bsgenerales">
        <td class="enc1" style="width: 15%;border:solid 1px gray;">Descripción:</td>
        <td style="border:solid 1px gray;color:black">{{$infoBS->descripcionBS}}</td>
        <td class="enc1" style="width: 15%;border:solid 1px gray;">Unidad de medida:</td>
        <td style="border:solid 1px gray;color:black">{{$infoBS->unidad_medidaBS}}</td>
    </tr>
    <tr><td colspan="4" style="text-align: center;background-color:rgb(243,203,215);color:gray;cursor:pointer" onclick="toggle('chevbsmonitoreo','body-bsmonitoreo')">Monitoreo de metas <i class="fas fa-chevron-down" id="chevbsmonitoreo"></i></td></tr>
    <tr id="body-bsmonitoreo">
        <td colspan="4">
            <table style="width: 100%">
                <tr>
                    <td class="enc1" style="border: solid 1px gray;text-align:left">Periodo</td>
                    <td class="enc1" style="border: solid 1px gray;text-align:center">Enero-Marzo</td>
                    <td class="enc1" style="border: solid 1px gray;text-align:center">Abril-Junio</td>
                    <td class="enc1" style="border: solid 1px gray;text-align:center">Julio-Septiembre</td>
                    <td class="enc1" style="border: solid 1px gray;text-align:center">Octubre-Diciembre</td>
                    <td class="enc1" style="border: solid 1px gray;text-align:center">Total anual</td>
                </tr>
                <tr>
                    <td class="enc1" style="border: solid 1px gray">Programado</td>
                    <td style="border: solid 1px gray">
                        <input type="number" class="form-control"  id="1p" onchange="refreshMetas()" style="text-align: right; font-size:1.3em;"/>
                        <div class="invalid-feedback">
                            Debe indicar la meta para este trimestre
                        </div>
                    </td>
                    <td style="border: solid 1px gray">
                        <input type="number" class="form-control"  id="2p" onchange="refreshMetas()" style="text-align: right; font-size:1.3em;"/>
                        <div class="invalid-feedback">
                            Debe indicar la meta para este trimestre
                        </div>
                    </td>
                    <td style="border: solid 1px gray">
                        <input type="number" class="form-control"  id="3p" onchange="refreshMetas()" style="text-align: right; font-size:1.3em;"/>
                        <div class="invalid-feedback">
                            Debe indicar la meta para este trimestre
                        </div>
                    </td>
                    <td style="border: solid 1px gray">
                        <input type="number" class="form-control"  id="4p" onchange="refreshMetas()" style="text-align: right; font-size:1.3em;"/>
                        <div class="invalid-feedback">
                            Debe indicar la meta para este trimestre
                        </div>
                    </td>
                    <td class="enc4" style="text-align: right;border: solid 1px gray;font-weight:bold;font-size:1.5em" id="tap">
                    </td>
                </tr>
                <tr>
                    <td class="enc1" style="border: solid 1px gray">Realizado</td>
                    <td style="border: solid 1px gray"><input type="number" class="form-control"  id="1r" onchange="refreshMetas()" style="text-align: right; font-size:1.3em;"/></td>
                    <td style="border: solid 1px gray"><input type="number" class="form-control"  id="2r" onchange="refreshMetas()" style="text-align: right; font-size:1.3em;"/></td>
                    <td style="border: solid 1px gray"><input type="number" class="form-control"  id="3r" onchange="refreshMetas()" style="text-align: right; font-size:1.3em;"/></td>
                    <td style="border: solid 1px gray"><input type="number" class="form-control"  id="4r" onchange="refreshMetas()" style="text-align: right; font-size:1.3em;"/></td>
                    <td class="enc4" style="text-align: right;border: solid 1px gray;font-weight:bold;font-size:1.5em" id="tar"></td>
                </tr>
                <tr>
                    <td class="enc1" style="border: solid 1px gray"  id="">Avance</td>
                    <td class="enc4" style="text-align: right;border:solid 1px gray;font-weight:bold; font-size:1.5em" id="1a"> </td>
                    <td class="enc4" style="text-align: right;border:solid 1px gray;font-weight:bold; font-size:1.5em" id="2a"> </td>
                    <td class="enc4" style="text-align: right;border:solid 1px gray;font-weight:bold; font-size:1.5em" id="3a"> </td>
                    <td class="enc4" style="text-align: right;border:solid 1px gray;font-weight:bold; font-size:1.5em" id="4a"> </td>
                    <td class="enc4" style="text-align: right;border:solid 1px gray;font-weight:bold; font-size:1.5em" id="taa"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td colspan="4" style="text-align: center;background-color:rgb(243,203,215);color:gray;cursor:pointer" onclick="toggle('chevpoblacionatendida','body-poblacionatendida')">Población atendida <i class="fas fa-chevron-down" id="chevpoblacionatendida"></i></td></tr>
    <tr id="body-poblacionatendida">
        <td colspan="4">
            <table style="width: 100%">
                <tr>
                    <td class="enc1" style="width: 15%;" rowspan="2">Periodo</td>
                    <td class="enc1" colspan="3" style="width:21.25%;text-align:center">Enero-Marzo</td>
                    <td class="enc1" colspan="3" style="width:21.25%;text-align:center">Abril-Junio</td>
                    <td class="enc1" colspan="3" style="width:21.25%;text-align:center">Julio-Septiembre</td>
                    <td class="enc1" colspan="3" style="width:21.25%;text-align:center">Octubre-Diciembre</td>
                </tr>
                <tr>
                    <td class="enc1" style="text-align: center">
                        Programada
                    </td>
                    <td class="enc1" style="text-align: center">
                        Atendida
                    </td>
                    <td class="enc1" style="text-align: center">
                        Avance
                    </td>
                    <td class="enc1" style="text-align: center">
                        Programada
                    </td>
                    <td class="enc1" style="text-align: center">
                        Atendida
                    </td>
                    <td class="enc1" style="text-align: center">
                        Avance
                    </td>
                    <td class="enc1" style="text-align: center">
                        Programada
                    </td>
                    <td class="enc1" style="text-align: center">
                        Atendida
                    </td>
                    <td class="enc1" style="text-align: center">
                        Avance
                    </td>
                    <td class="enc1" style="text-align: center">
                        Programada
                    </td>
                    <td class="enc1" style="text-align: center">
                        Atendida
                    </td>
                    <td class="enc1" style="text-align: center">
                        Avance
                    </td>
                </tr>
                <tr class="p_">
                    <td class="enc1">Hombres:</td>
                    <td><input type="text" class="form-control" id="ph1"/></td>
                    <td><input type="text" class="form-control" id="ah1"/></td>
                    <td class="enc4" id="avh1"></td> 
                    <td><input type="text" class="form-control" id="ph2"/></td>
                    <td><input type="text" class="form-control" id="ah2"/></td>
                    <td class="enc4" id="avh2"></td>
                    <td><input type="text" class="form-control" id="ph3"/></td>
                    <td><input type="text" class="form-control" id="ah3"/></td>
                    <td class="enc4" id="avh3"></td>
                    <td><input type="text" class="form-control" id="ph4"/></td>
                    <td><input type="text" class="form-control" id="ah4"/></td>     
                    <td class="enc4" id="avh4"></td>               
                </tr>
                <tr class="p_">
                    <td class="enc1">Mujeres:</td>
                    <td><input type="text" class="form-control" id="pm1"/></td>
                    <td><input type="text" class="form-control" id="am1"/></td>
                    <td class="enc4" id="avm1"></td>
                    <td><input type="text" class="form-control" id="pm2"/></td>
                    <td><input type="text" class="form-control" id="am2"/></td>
                    <td class="enc4" id="avm2"></td>
                    <td><input type="text" class="form-control" id="pm3"/></td>
                    <td><input type="text" class="form-control" id="am3"/></td>
                    <td class="enc4" id="avm3"></td>
                    <td><input type="text" class="form-control" id="pm4"/></td>
                    <td><input type="text" class="form-control" id="am4"/></td>   
                    <td class="enc4" id="avm4"></td>                 
                </tr>
                <tr class="p_">
                    <td class="enc1">Total:</td>
                    <td class="enc4" id="tp1"></td>
                    <td class="enc4" id="ta1"></td>
                    <td class="" id=""></td>
                    <td class="enc4" id="tp2"></td>
                    <td class="enc4" id="ta2"></td>
                    <td class="" id=""></td>
                    <td class="enc4" id="tp3"></td>
                    <td class="enc4" id="ta3"></td>
                    <td class="" id=""></td>
                    <td class="enc4" id="tp4"></td>
                    <td class="enc4" id="ta4"></td>                    
                    <td class="" id=""></td>                    
                </tr>
                <tr class="a_">
                    <td class="enc1" colspan="13" style="text-align: center">Área de enfoque</td>
                </tr>
                <tr class="a_">
                    <td class="enc1">{{$poblacion->nombre_enfoque}}</td>
                    <td><input type="text" class="form-control" id="arp1"/></td>
                    <td><input type="text" class="form-control" id="ara1"/></td>
                    <td class="enc4" id="ava1"></td>
                    <td><input type="text" class="form-control" id="arp2"/></td>
                    <td><input type="text" class="form-control" id="ara2"/></td>
                    <td class="enc4" id="ava2"></td>
                    <td><input type="text" class="form-control" id="arp3"/></td>
                    <td><input type="text" class="form-control" id="ara3"/></td>
                    <td class="enc4" id="ava3"></td>
                    <td><input type="text" class="form-control" id="arp4"/></td>
                    <td><input type="text" class="form-control" id="ara4"/></td>     
                    <td class="enc4" id="ava4"></td>               
                </tr>
                <tr class="">
                    <td class="enc1" colspan="13" style="text-align: right"><button class="btn btn-primary" onclick="showDesglose()"><i class="fas fa-list"></i> Desagregación por región</button></td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</center>

<h6 class="m-0 font-weight-bold text-light"
                         style="cursor: pointer;color:white">
                        Monitoreo por bien o servicio <i class="fas fa-chevron-down" id="chevmonitoreo"></i>
                    </h6>