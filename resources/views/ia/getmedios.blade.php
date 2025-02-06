@if($medios->count()>0)
@foreach ($medios as $medio )
<tr id="rowmedio{{$medio->idMedio}}" idMedio="{{$medio->idMedio}}" class="medioia">
    <td>
        <a target="blank_" href="{{ asset('medios') }}/itar/{{$medio->ia_id}}/{{$medio->anio}}/{{$medio->trimestre}}/{{$medio->archivo}}">{{$medio->nombre}}</a>                
    <td><textarea placeholder="Agrega Descripción" class="descripcionmedioia form-control" name="descripcionmedioia[]">{{$medio->descripcion}}</textarea></td>
    <td><button type="button" class="btn btn-danger" onclick="deleteMedio({{$medio->idMedio}})"><i class="fas fa-trash"></i></button></td>
</tr>    
@endforeach
@else
<tr>
    <td colspan="4">
        <div class="alert alert-info">No existen medios de verificación cargados en este trimestre</div>
    </td>
</tr>
@endif