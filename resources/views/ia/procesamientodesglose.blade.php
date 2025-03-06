<table style="width:100%;font-size:.8em;">
    <tr>
        <td colspan="4" class="enc2" style="text-align: center">Municipios procesados</td>
    </tr>
    <tr>
        <td class="enc2" style="text-align: center">Clave</td>
        <td class="enc2" style="text-align: center">Municipio</td>
        <td class="enc2" style="text-align: center">Región</td>
        <td class="enc2" style="text-align: center">Estatus de procesamiento</td>
    </tr>
    @foreach ($municipios as $municipio )
        <tr>
            <td style="border: solid 1px gray">{{$municipio->clave}}</td>
            <td style="border: solid 1px gray">{{$municipio->municipio}}</td>
            <td style="border: solid 1px gray">{{$municipio->nombre}}</td>
            <td style="text-align: center;border: solid 1px gray"><i class="fas fa-check-circle" style="color: green"></i></td>
        </tr>    
    @endforeach
    
</table>