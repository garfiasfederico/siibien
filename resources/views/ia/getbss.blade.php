<table style="width:100%;">
    <thead>
        <tr>
            <th class="enc1" style="border: solid 1px gray;width:10%;text-align:center">Id</th>
            <th class="enc1" style="border: solid 1px gray;text-align:center">Bien o Servicio</th>
            <th class="enc1" style="border: solid 1px gray;text-align:center">Descripción</th>
            <th class="enc1" style="border: solid 1px gray;text-align:center">Periodo de entrega</th>
            <th class="enc1" style="border: solid 1px gray;text-align:center">Configurar Desglose</th>
            <th class="enc1" style="border: solid 1px gray;width:15%;text-align:center">Opciones</th>
        </tr>
    </thead>
    <tbody id="body-indicadores" style="color:gray">                            
        @if ($bss->count() > 0)                                            
            @foreach ( $bss as $bs )
                <tr>
                    <td style="border: solid 1px gray;width:10%;text-align:center">{{$bs->idBS}}</td>
                    <td style="border: solid 1px gray;">{{$bs->nombreBS}}</td>
                    <td style="border: solid 1px gray;">{{$bs->descripcionBS}}</td>
                    <td style="border: solid 1px gray;text-align:center">{{$bs->p_entrega}}</td>
                    <td style="border: solid 1px gray;text-align:center">
                        <button 
                            class="btn btn-info btn-sm"
                            onclick="configurarDesglose({{ $bs->idBS }})">
                             Configurar Desglose
                        </button>
                    </td>

                    <td style="border: solid 1px gray;width:15%;text-align:center">
                        <button class="btn btn-primary" onclick="editbs({{$bs->idBS}})"><i class="fas fa-edit"></i></button>                
                        <button class="btn btn-danger" onclick="removebs({{$bs->idBS}})"><i class="fas fa-trash"></i></button>                
                    </td>
                </tr>        
            @endforeach        
        @else
                <tr id="emptybs" style="">
                    <td colspan="5" style="text-align: center;border:solid 1px gray;">No se han registrado bienes o servicios para este PPA!</td>
                </tr>
        @endif
        
    </tbody>                                    
</table>