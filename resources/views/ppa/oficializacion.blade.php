<div class="tab-pane fade show active" id="nav-home" role="tabpanel"aria-labelledby="nav-home-tab">
    <div>
        <table style="width:100%;text-align:left">
            <thead>
                <tr>
                    <th class="" colspan="4" style="text-align: center">
                        <h2> Periodo: {{ $periodo }}</h2>
                    </th>
                </tr>
                <tr>
                    <th class="field" colspan="4" style="text-align: center">
                        1. Datos de los reportes oficilizados
                    </th>
                </tr>
                @if ($ppas->count() > 0)
                    <tr>
                        <th class="field" style="width: 5%">Folio</th>
                        <th class="field" style="width: 25%">Nombre</th>
                        <th class="field" style="width: 40%">Descripcion</th>
                        <th class="field" style="width: 15%">Monto Inversion</th>
                        <th class="field" style="width: 15%">Monto Ejercido</th>
                    </tr>
            </thead>
            <tbody>
                @foreach ($ppas as $ppa)
                    <tr>
                        <th class="" style="width: 5%;text-align:center">{{ $ppa->id }}</th>
                        <th class="" style="width: 25%;text-align:left">{{ $ppa->nombre }}</th>
                        <th class="" style="width: 40%;text-align:left">{{ $ppa->descripcion }}</th>
                        <th class="" style="width: 15%;text-align:right">$
                            {{ number_format($ppa->monto_inversion, 2) }}</th>
                        <th class="" style="width: 15%;text-align:right">$
                            {{ number_format($ppa->monto__ejercido, 2) }}</th>
                    </tr>
                @endforeach
            </tbody>
            @else
            <tbody>
                <tr>
                    <td colspan="4" style="text-align: center">
                        <h5>No existen PPAs registrados!</h5>
                    </td>
                </tr>
            </tbody>
            @endif

        </table>


        <table style="width:100%">
            <tr>
                <td class="field" colspan="4" style="text-align:center"> 2. Datos de los Responsables de la
                    Información</td>
            </tr>
            <tr>
                <td class="sombreado" colspan="1"> Dependencia: </td>
                <td class="text" colspan="3"><span style="font-weight:normal">
                        {{ $dependencia->dependenciaNombre . ' (' . $dependencia->dependenciaSiglas . ')' }}</span></td>
            </tr>
            <tr>
                <td class="sombreado" style="" colspan="2">Titular de la Dependencia</td>
                <td class="sombreado" style="" colspan="2">Enlace Institucional</td>
            </tr>
            <tr>
                <td class="sombreado" style="width:15%">Nombre:</td>
                <td class="text" style="width:35%">{{ $titular == null ? '' : $titular->nombre }}</td>
                <td class="sombreado" style="width:15%">Nombre:</td>
                <td class="text" style="width:35%">
                    {{ $enlace == null ? '' : $enlace->titulo . ' ' . $enlace->nombre . ' ' . $enlace->apellidoP . ' ' . $enlace->apellidoM }}
                </td>
            </tr>
            <tr>
                <td class="sombreado" style="width:15%">Cargo:</td>
                <td class="text" style="width:35%">{{ $titular == null ? '' : $titular->cargo }}</td>
                <td class="sombreado" style="width:15%">Cargo:</td>
                <td class="text" style="width:35%">{{ $enlace == null ? '' : $enlace->cargo }}</td>
            </tr>
            <tr>
                <td class="sombreado" style="width:15%">Firma:</td>
                <td class="text" style="width:35%;height:50px;"></td>
                <td class="sombreado" style="width:15%">Firma:</td>
                <td class="text" style="width:35%;height:70px;"></td>
            </tr>
        </table>
    </div>
</div>

<style>
    .field {
        background-color: #681b2e;

        color: white;
        text-align: left;
        border: solid 1px gray;
        height: 20px;
        font-weight: bold;
        font-size: 1em;
    }

    .value {
        text-align: left;
        border: dashed 1px gray;
        height: 20px;
        vertical-align: middle;
        font-size: .8em;
    }


    .text {
        text-align: left;
        border: dashed 1px gray;
        height: 20px;
        vertical-align: middle;
        font-size: .8em;
    }

    .valuee {
        text-align: left;
        height: 20px;
        border-right: dashed 1px gray;
        vertical-align: middle;
        font-size: .8em;

    }

    .textt {
        text-align: left;
        height: 20px;
        border-left: dashed 1px gray;
        vertical-align: middle;
        font-size: .8em;
    }

    table tr th {
        text-align: center;
        color: black;

    }

    .label {
        color: black;
        font-weight: bold;
        padding: 5px;
    }

    .valor {
        border-bottom: dashed 1px rgb(218, 218, 218);
        font-size: 1.1em;

    }

    .sombreado {
        background-color: rgb(218, 218, 218);
        font-size: .8em;
        border: solid 1px black;
        height: 18px;
        align-items: center;
        line-height: 15px;
    }
</style>
