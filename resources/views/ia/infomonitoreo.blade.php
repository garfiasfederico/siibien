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
    <tr><td colspan="4" style="text-align: center;background-color:rgb(243,203,215);color:gray;">Monitoreo de metas</td></tr>
    <tr>
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
                    <td  style="border: solid 1px gray"><input type="number" class="form-control" /></td>
                    <td style="border: solid 1px gray"><input type="number" class="form-control" /></td>
                    <td style="border: solid 1px gray"><input type="number" class="form-control" /></td>
                    <td style="border: solid 1px gray"><input type="number" class="form-control" /></td>
                    <td style="text-align: right;border: solid 1px gray">$ 0.00</td>
                </tr>
                <tr>
                    <td class="enc1" style="border: solid 1px gray">Realizado</td>
                    <td style="border: solid 1px gray"><input type="number" class="form-control" /></td>
                    <td style="border: solid 1px gray"><input type="number" class="form-control" /></td>
                    <td style="border: solid 1px gray"><input type="number" class="form-control" /></td>
                    <td style="border: solid 1px gray"><input type="number" class="form-control" /></td>
                    <td style="text-align: right;border: solid 1px gray">$ 0.00</td>
                </tr>
                <tr>
                    <td class="enc1">Avance</td>
                    <td style="text-align: right;border:solid 1px gray">0 %</td>
                    <td style="text-align: right;border:solid 1px gray">0 %</td>
                    <td style="text-align: right;border:solid 1px gray">0 %</td>
                    <td style="text-align: right;border:solid 1px gray">0 %</td>
                    <td style="text-align: right;border:solid 1px gray">0 %</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td colspan="4" style="text-align: center;background-color:rgb(243,203,215);color:gray;">Población atendida</td></tr>
</table>
</center>

<h6 class="m-0 font-weight-bold text-light"
                         style="cursor: pointer;color:white">
                        Monitoreo por bien o servicio <i class="fas fa-chevron-down" id="chevmonitoreo"></i>
                    </h6>