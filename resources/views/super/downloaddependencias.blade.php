@if (count($dependencias) > 0)
    <table class="" width="100%" cellspacing="1" style="color: black!important" style="border:1px dotted gray">
        <thead style="background-color: #919090;color:white;">
            <tr style="text-align:center;font-size:1.2em !important">
                <th style="width:10%">Id</th>                
                <th style="width:50%">Nombre</th>                
                <th style="width:30%">Siglas</th>
                <th style="width:10%">Numero UR</th>                                                
            </tr>
        </thead>
        <tbody>
            @php($i = true)
            @foreach ($dependencias as $dependencia)                        
                <tr style="text-align:left" class="{{!$i?'ban':''}}">
                    <td style="width:10%">{{ $dependencia->idDependencia }}</td>
                    <td style="width:50%">{{ $dependencia->dependenciaNombre }}</td>
                    <td style="width:30%">{{ $dependencia->dependenciaSiglas }}</td>
                    <td style="width:10%">{{ $dependencia->numeroUR }}</td>                    
                </tr>
            @php($i=!$i)   
            @endforeach
        </tbody>
    </table>
@else
    <div class="text-center">
        <h3>
            No existen Dependencias Registradas!
        </h3>
    </div>
@endif
<style>
    table tr th {
        background-color: #681b2e;
        font-weight: bold;     
        color: white;
        height:20px;   
    }

    table{
        font-size: .8em
    }

    table tr td{
        vertical-align: baseline;
    }

    .ban{
        background-color: rgb(208, 208, 208);
    }
</style>
