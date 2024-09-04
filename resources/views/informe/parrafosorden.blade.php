@if($parrafos->count()>0)

<h2>Párrafos redactados del tema: {{$tema->temaPEDClave." ".$tema->temaPEDDescripcion}}</h2>
<div style="width: 100%"><b>Instrucciones: </b> Capture el orden correspondiente para cada párrafo y presione la tecla "Enter" para guardar el dato por cada párrafo.</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Id</th>
            <th>Orden</th>
            <th>Párrafo</th>
            <th>Responsable</th>
        </tr>
    </thead>
    <tbody>
        @foreach ( $parrafos as $parrafo )
            <tr>
                <td id="p{{$parrafo->idParrafo}}" style="vertical-align: middle">{{$parrafo->idParrafo}}</td>
                <td style="vertical-align: middle"><input type="number" min="1" size="2" step="1" class="form-control" value="{{$parrafo->orden_ct}}" id="parrafo{{$parrafo->idParrafo}}" onchange="updateOrden({{$parrafo->idParrafo}})" style="width: 80px;"/></td>
                <td style="vertical-align: middle">{{$parrafo->resultado}}</td>
                <td style="vertical-align: middle"> {{$parrafo->dependenciaSiglas}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info">No existen párrafos redactados para este tema!</div>
@endif
