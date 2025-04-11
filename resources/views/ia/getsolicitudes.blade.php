@if($solicitudes->count()>0)
<table style="width: 100%; overflow:scroll;font-size:.8em;" class="table table-striped">
    <thead>
        <tr>
            <th class="enc1" style="border:solid 1px gray;text-align:center;">Id</th>
            <th class="enc1" style="border:solid 1px gray;text-align:center;">Nombre</th>
            <th class="enc1" style="border:solid 1px gray;text-align:center;">Tipo</th>
            <th class="enc1" style="border:solid 1px gray;text-align:center;">Descripción</th>
            <th class="enc1" style="border:solid 1px gray;text-align:center;">Objetivo</th>
            <th class="enc1" style="border:solid 1px gray;text-align:center;">Eje</th>
            <th class="enc1" style="border:solid 1px gray;text-align:center;">Tema</th>
            <th class="enc1" style="border:solid 1px gray;text-align:center;">Estado</th>
            <th class="enc1" style="border:solid 1px gray;text-align:center;">Justificación de la ITE en caso de rechazo</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($solicitudes as $solicitud )
        @php
            $color = "";
            switch ($solicitud->estado) {
                case 'pendiente':
                    $color="secondary";
                    break;
                case 'aceptado':
                    $color="success";
                    break;
                case 'rechazado':
                    $color="danger";
                    break;                                
            }
        @endphp
        <tr>
            <td style="border:solid 1px gray;vertical-align:middle;">{{$solicitud->idPPATemp}}</td>
            <td style="border:solid 1px gray;vertical-align:middle;">{{$solicitud->nombre}}</td>
            <td style="border:solid 1px gray;vertical-align:middle;">{{$solicitud->tipo}}</td>
            <td style="border:solid 1px gray;vertical-align:middle;">{{$solicitud->descripcion}}</td>
            <td style="border:solid 1px gray;vertical-align:middle;">{{$solicitud->objetivo}}</td>
            <td style="border:solid 1px gray;vertical-align:middle;">{{$solicitud->ejePEDClave." ".$solicitud->ejePEDDescripcion}}</td>
            <td style="border:solid 1px gray;vertical-align:middle;">{{$solicitud->temaPEDClave." ".$solicitud->temaPEDDescripcion}}</td>
            <td style="border:solid 1px gray;vertical-align:middle;"><button class="btn btn-{{$color}}" disabled>{{$solicitud->estado}}</button></td>
            <td style="border:solid 1px gray;vertical-align:middle;">{{$solicitud->justificacion}}</td>
        </tr>            
        @endforeach
    </tbody>    
</table>
@else
<center>
    <div class="alert alert-info">No existen solicitudes de alta de PPA registradas!</div>
</center>
@endif