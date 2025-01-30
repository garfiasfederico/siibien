<div style="width: 100%;" id="fuenteFinanciamiento">
    <input type="hidden" id="ia_presupuesto_tipog_id_temp" value="{{$infoFuente->ia_presupuesto_tipog_id}}">
    <input id="ia_fuente_id" value="{{$infoFuente->id}}" type="hidden" >
    <table>
        <tr>
            <td class="enc1">Fuente de financiamiento:<span style="color: red">*</span></td>
            <td colspan="7">
                <select class="form-control" id="fuente_financiamiento" onchange="fotra()">
                    <option value="">Seleccione</option>
                    @foreach ($fuentes as $fuente )
                    <option value="{{$fuente->idFuente}}" @if($infoFuente->fuente_id == $fuente->idFuente) selected @endif>{{$fuente->fuente}}</option>                                            
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Debe indicar la fuente de financiamiento.
                </div>
                <input type="text" id="fotra" class="form-control" placeholder="Indique fuente de financiamiento" @if($infoFuente->id!=17) style="display:none" @endif value="{{$infoFuente->fotra}}"/>
                <div class="invalid-feedback">
                    Debe indicar la otra fuente de financiamiento.
                </div>
            </td>
        </tr>
        <tr>
            <td class="enc1" style="text-align: center">Monto Federal</td>                               
            <td class="enc1" style="text-align: center">Monto Estatal</td>
            <td class="enc1" style="text-align: center">Monto Municipal</td>
            <td class="enc1" style="text-align: center">Monto Total</td>
        </tr>
        <tr>
            <td><input type="number" class="form-control" style="text-align: right" id="monto_federal" onkeyup="refreshMonto()" value="{{$infoFuente->monto_federal}}"/></td>
            <td><input type="number" class="form-control" style="text-align: right" id="monto_estatal" onkeyup="refreshMonto()" value="{{$infoFuente->monto_estatal}}"/></td>
            <td><input type="number" class="form-control" style="text-align: right" id="monto_municipal" onkeyup="refreshMonto()" value="{{$infoFuente->monto_municipal}}"/></td>
            <td><input type="number" class="form-control" readonly style="text-align: right" id="monto_total" value="{{$infoFuente->monto_total}}"/></td>
        </tr>
        <tr>
            <td colspan="4">
                <input type="hidden" id="valida_monto">
                <div class="invalid-feedback">
                   Indique algún monto.
                </div>
            </td>
        </tr>
    </table>
</div>