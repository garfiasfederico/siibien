@if (count($titulares) > 0)
    <table class="" width="100%" cellspacing="1" style="color: black!important" style="border:1px dotted gray">
        <thead style="background-color: #919090;color:white;">
            <tr style="text-align:center;font-size:1.2em !important">
                <th style="width:10%">Id</th>                
                <th style="width:20%">Nombre</th>                
                <th style="width:20%">Cargo</th>
                <th style="width:30%">Dependencia</th>                
                <th style="width:20%">Siglas</th>    
                
            </tr>
        </thead>
        <tbody>
            @php($i = true)
            @foreach ($titulares as $titular)                        
                <tr style="text-align:left" class="{{!$i?'ban':''}}">
                    <td style="width:10%">{{ $titular->idTitular }}</td>
                    <td style="width:20%">{{ $titular->nombre }}</td>
                    <td style="width:20%">{{ $titular->cargo }}</td>
                    <td style="width:30%">{{ $titular->dependenciaNombre }}</td>
                    <td style="width:20%">{{ $titular->dependenciaSiglas }}</td>                    
                </tr>
            @php($i=!$i)   
            @endforeach
        </tbody>
    </table>
@else
    <div class="text-center">
        <h3>
            No existen Titulares Registrados!
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
