@php
    $contador =1;
@endphp
@if ($fuentes->count() > 0)
    @foreach ($fuentes as $fuente)
        <tr>
            <td style="text-align: center;border:solid 1px gray;">{{$contador++}}</td>
            <td style="border:solid 1px gray;">{{$fuente->fuente}}</td>
            <td style="text-align: right;border:solid 1px gray;">{{"$ ".number_format($fuente->monto_federal,2)}}</td>
            <td style="text-align: right;border:solid 1px gray;">{{"$ ".number_format($fuente->monto_estatal,2)}}</td>
            <td style="text-align: right;border:solid 1px gray;">{{"$ ".number_format($fuente->monto_municipal,2)}}</td>
            <td style="text-align: right;border:solid 1px gray;">{{"$ ".number_format($fuente->monto_total,2)}}</td>
            <td style="border:solid 1px gray; text-align:center;width:10%">
                <button class="btn btn-ligth" onclick="getInfoFuente({{$fuente->id}})"><i class="fas fa-edit"></i></button>
                <button class="btn btn-ligth"><i class="fas fa-trash" style="color:red"></i></button>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="8" style="text-align: center;border:solid 1px gray;">No existen
            fuentes de financiamiento registradas para este Programa</td>
    </tr>
@endif
