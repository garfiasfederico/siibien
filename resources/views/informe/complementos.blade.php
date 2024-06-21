@if ($complementos->count() > 0)
    <table class="table" style="width: 100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Complemento</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $complementos as $complemento )
            <tr class="complemento" complemento="{{$complemento->id}}" id="rowcomplemento{{$complemento->id}}">
                <td>{{$complemento->id}}</td>
                <td><a target="_blank" href="{{ asset('medios') }}/informe/2do/{{ $complemento->idParrafo . '/' . $complemento->ubicacion }}">{{ $complemento->nombre }}</a></td>
                <td>
                    <textarea  name="" id="" class="descripcion form-control">{{$complemento->descripcion}}</textarea>
                </td>
                <td style="text-align: center; vertical-align:middle">
                    <button class="btn btn-danger" onclick="removeComplemento({{$complemento->id}})"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
@else
    <div style="width: 100%;text-align:center;font-size:1.3em" class="alert alert-info">No existen complementos cargados para
        este párrafo!</div>
@endif
