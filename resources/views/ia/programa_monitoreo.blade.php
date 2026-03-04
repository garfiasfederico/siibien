@php
    $first = $registros->first();
    $operativo = $registros->where('tipo_gasto', 'operativo')->first();
    $inversion = $registros->where('tipo_gasto', 'inversion')->first();
@endphp

<div class="bloque-programa" data-programa-id="{{ $first->pp_id }}"
    data-id-componente="{{ $idComponente ?? ($first->idComponente ?? '') }}"
    data-componente-texto="{{ $componente_texto ?? ($first->componente_texto ?? '') }}"
    data-actividad-texto="{{ $actividad_texto ?? ($first->actividad_texto ?? '') }}"
    style="border: solid 1px blue; border-radius:5px; padding:10px; margin:10px;">

    <table style="width:100%">
        <thead>

            <tr>
                <td class="enc1" style="width:20%">Programa Presupuestario:</td>
                <td colspan="5">
                    {{ $first->clavePrograma }}
                    {{ $first->descripcionPrograma }}
                </td>
            </tr>

            {{-- COMPONENTE --}}
            @php
                $componenteMostrar = $componente_texto ?? ($componente ?? ($first->componente_texto ?? null));
            @endphp

            @if (!empty($componenteMostrar))
                <tr>
                    <td class="enc1">Componente:</td>
                    <td colspan="5">
                        {{ $componenteMostrar }}
                    </td>
                </tr>
            @endif

            {{-- ACTIVIDADES (2026 - RELACIONAL) --}}
            @if (isset($actividades) && count($actividades))
                <tr>
                    <td class="enc1">Actividades:</td>
                    <td colspan="5">
                        <ul style="margin:0; padding-left:18px;">
                            @foreach ($actividades as $actividad)
                                <li class="actividad-item" data-id="{{ $actividad->idActividad ?? '' }}">
                                    {{ $actividad->claveActividad ?? '' }}
                                    {{ $actividad->descripcionActividad ?? ($actividad->descripcion ?? '') }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endif

            @if (!empty($first->actividad_texto))
                <tr>
                    <td class="enc1">Actividad:</td>
                    <td colspan="5">
                        {{ $first->actividad_texto }}
                    </td>
                </tr>
            @endif

            <tr>
                <td class="enc1">Concepto / Trimestre</td>
                <td class="enc1">Enero–Marzo</td>
                <td class="enc1">Abril–Junio</td>
                <td class="enc1">Julio–Septiembre</td>
                <td class="enc1">Octubre–Diciembre</td>
                <td class="enc1">Total Anual</td>
            </tr>

        </thead>

        <tbody>

            @if ($operativo && $operativo->aplica)
                <tr data-tipo="operativo" data-monto-anual="{{ $operativo->monto }}">
                    <td class="enc1">Gasto Operativo</td>
                    <td>
                        <input type="number" class="form-control monto-trimestre" value="{{ $operativo->t1 }}"
                            oninput="calcularTotalFila(this)">
                    </td>
                    <td>
                        <input type="number" class="form-control monto-trimestre" value="{{ $operativo->t2 }}"
                            oninput="calcularTotalFila(this)">
                    </td>
                    <td>
                        <input type="number" class="form-control monto-trimestre" value="{{ $operativo->t3 }}"
                            oninput="calcularTotalFila(this)">
                    </td>
                    <td>
                        <input type="number" class="form-control monto-trimestre" value="{{ $operativo->t4 }}"
                            oninput="calcularTotalFila(this)">
                    </td>
                    <td class="enc4 total-fila"></td>
                </tr>
            @endif

            @if ($inversion && $inversion->aplica)
                <tr data-tipo="inversion" data-monto-anual="{{ $inversion->monto }}">
                    <td class="enc1">Gasto de Inversión</td>
                    <td>
                        <input type="number" class="form-control monto-trimestre" value="{{ $inversion->t1 }}"
                            oninput="calcularTotalFila(this)">
                    </td>
                    <td>
                        <input type="number" class="form-control monto-trimestre" value="{{ $inversion->t2 }}"
                            oninput="calcularTotalFila(this)">
                    </td>
                    <td>
                        <input type="number" class="form-control monto-trimestre" value="{{ $inversion->t3 }}"
                            oninput="calcularTotalFila(this)">
                    </td>
                    <td>
                        <input type="number" class="form-control monto-trimestre" value="{{ $inversion->t4 }}"
                            oninput="calcularTotalFila(this)">
                    </td>
                    <td class="enc4 total-fila"></td>
                </tr>
            @endif

        </tbody>

        <tfoot>
            <tr class="fila-total-programa">
                <td class="enc1">Total</td>
                <td class="enc4 t1"></td>
                <td class="enc4 t2"></td>
                <td class="enc4 t3"></td>
                <td class="enc4 t4"></td>
                <td class="enc4 total-programa"></td>
            </tr>
        </tfoot>

    </table>
</div>