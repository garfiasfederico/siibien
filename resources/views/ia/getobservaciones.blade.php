<td class="enc1">Observaciones</td>
<td>
    <input type="hidden" class="obs" value="@if($observaciones!=null){{$observaciones->idObservacion}}@endif" id="idObservacion"/>
    <textarea class="form-control" rows="10" id="observaciones" class="observacion" placeholder="Agrega las observaciones correspondientes al trimestre" style="color:black">@if($observaciones!=null){{$observaciones->observaciones}}@endif</textarea>
</td>