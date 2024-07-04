@if ($parrafos->count() > 0)
    <table style="width: 100%" class="table table-striped">
        <thead>
            <tr style="background-color: gray; color:white">
                <th style="padding: 15px;">id</th>
                <th style="padding: 15px;">Parrafo</th>
                <th style="padding: 15px;">Creador</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parrafos as $parrafo)
            <tr>
                <td style="padding: 15px;vertical-align:middle">{{$parrafo->idParrafo}}</td>
                <td style="padding: 15px;vertical-align:middle;text-align:justify">{{$parrafo->resultado}}</td>
                <td style="padding: 15px;vertical-align:middle">{{$parrafo->dependenciaSiglas}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="alert alert-info" style="text-align: center;font-size:1.3em">No existen párrafos redactados para esta acción!</div>
@endif
