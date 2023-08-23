<style>
    th{
        background-color: #{{$color}};
        padding:5px;
        color:white;
    }
    td{
        padding:5px;
    }

</style>
<center>
    <h2 style="color:#{{$color}}">{{$odsdesc}}</h2>
    <table style="width: 80%" border="1">
        <tr>
            <th>Clave:</th>
            <td>{{ $ods->clave }}</td>
        </tr>
        <tr>
            <th>Descripcion:</th>
            <td>{{ $ods->descripcion }}</td>
        </tr>
        <tr>
            <th>Metas</th>
            <td>
                <table style="width: 100%">
                    <thead>
                        <tr style="text-align: center">
                            <th>Clave</th>
                            <th>Descripcion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($metas as $meta)
                            <tr>
                                <td>
                                    {{ $meta->clave }}
                                </td>
                                <td>
                                    {{ $meta->descripcion }}
                                </td>
                            </tr>
                    </tbody>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
</center>
