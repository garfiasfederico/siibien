<div class="programa-item" style="border:1px solid green;padding:15px;border-radius:20px;margin:10px;">

    <input type="hidden" class="tipog_operativo_id" value="{{ $operativo->id }}">
    <input type="hidden" class="tipog_inversion_id" value="{{ $inversion->id }}">

    <button class="close" style="color:red"
        onclick="removePrograma({{ $operativo->id }}, {{ $inversion->id }})">
        <i class="fas fa-trash"></i>
    </button>

    <table style="width:100%">
        <tr>
            <td class="enc1" style="width:25%">Programa presupuestario:</td>
            <td style="width:75%">
                <select class="form-control pp_id">
                    <option value="">Seleccione</option>
                    @foreach ($programas as $p)
                        <option value="{{ $p->idPrograma }}">
                            {{ $p->clavePrograma }} {{ $p->descripcionPrograma }}
                        </option>
                    @endforeach
                </select>
            </td>
        </tr>

        <tr>
            <td class="enc1">Tipo de gasto:</td>
            <td>
                <div style="display:flex; gap:40px; align-items:center;">

                    <div style="display:flex; align-items:center; gap:10px;">
                        <span class="enc1">Operativo</span>
                        <input type="checkbox"
                            class="toggle-gasto toggle-operativo"
                            data-id="{{ $operativo->id }}"
                            data-toggle="toggle"
                            data-on="Aplica"
                            data-off="No aplica"
                            data-onstyle="success"
                            data-offstyle="secondary">
                    </div>

                    <div style="display:flex; align-items:center; gap:10px;">
                        <span class="enc1">Inversión</span>
                        <input type="checkbox"
                            class="toggle-gasto toggle-inversion"
                            data-id="{{ $inversion->id }}"
                            data-toggle="toggle"
                            data-on="Aplica"
                            data-off="No aplica"
                            data-onstyle="primary"
                            data-offstyle="secondary">
                    </div>

                </div>
            </td>
        </tr>
    </table>

    <hr>

    <div class="bloque-operativo" style="display:none">

        <table style="width:100%">
            <tr>
                <td class="enc1" style="width:25%">Monto operativo:</td>
                <td style="width:40%">
                    <select class="form-control form-control-sm selector-gasto"
                        data-id="{{ $operativo->id }}" style="width:220px;">
                        <option value="">Seleccione una opción</option>
                        <option value="0">No aplica</option>
                        <option value="1">No disponible</option>
                        <option value="2">Aplica</option>
                    </select>
                </td>
                <td style="width:35%">
                    <input type="number"
                        class="form-control form-control-sm monto-gasto"
                        data-id="{{ $operativo->id }}"
                        placeholder="$ 0.00"
                        readonly>
                </td>
            </tr>
        </table>

    </div>

    <hr>

    <div class="bloque-inversion" style="display:none">

        <table style="width:100%">
            <tr>
                <td class="enc1" style="width:25%">Monto inversión:</td>
                <td style="width:40%">
                    <select class="form-control form-control-sm selector-gasto"
                        data-id="{{ $inversion->id }}" style="width:220px;">
                        <option value="">Seleccione una opción</option>
                        <option value="0">No aplica</option>
                        <option value="1">No disponible</option>
                        <option value="2">Aplica</option>
                    </select>
                </td>
                <td style="width:35%">
                    <input type="number"
                        class="form-control form-control-sm monto-gasto"
                        data-id="{{ $inversion->id }}"
                        placeholder="$ 0.00"
                        readonly>
                </td>
            </tr>
        </table>

    </div>

</div>
