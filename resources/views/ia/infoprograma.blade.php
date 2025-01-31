<div style="border: solid 1px green;padding:20px;border-radius:20px;margin:10px;" id="programa{{ $infoPrograma->id }}">
    <input type="hidden" id="ia_presupuesto_tipog_id" class="ia_presupuesto_tipog_id" value="{{ $infoPrograma->id }}">
    <button class="close" type="button" aria-label="Close" style="color:red;position:realtive;bottom:30px;"
        onclick="removePrograma({{ $infoPrograma->id }})">
        <span aria-hidden="true" style="font-size: .8em;"><i class="fas fa-trash"></i></span>
    </button>
    <table style="width: 100%">
        <tr>
            <td class="enc1" style="width: 10%">Programa Presupuestario:</td>
            <td>
                <select id="pp_id" class="form-control pp_id">
                    <option value="">Seleccione</option>
                    @foreach ($programas as $programa)
                        <option value="{{ $programa->idPrograma }}">
                            {{ $programa->clavePrograma . ' ' . $programa->descripcionPrograma }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Debe seleccionar un programa presupuestario.
                </div>
            </td>
            <td class="enc1" style="width: 10%">Componente:</td>
            <td style="width: 40%">
                <input type="text" class="form-control componente" placeholder="indicar el ID del componente" id="componente" />
                <div class="invalid-feedback">
                    Debe indicar el componente o componentes relacionados con el presupuesto.
                </div>
            </td>
           
        </tr>
        <tr>
            <td colspan="4">
                <table style="width: 100%">
                    <thead>
                        <tr>
                            <th class="enc1">No.</th>
                            <th class="enc1">Fuente de financiamiento</th>
                            <th class="enc1">Monto Federal</th>
                            <th class="enc1">Monto Estatal</th>
                            <th class="enc1">Monto Municipal</th>
                            <th class="enc1">Monto Total</th>
                            <th class="enc1">Opciones</th>
                            <th style="width: 5%;text-align:center"><button class="btn btn-success"
                                    onclick="fuenteFinanciamiento({{ $infoPrograma->id }})"><i
                                        class="fas fa-plus"></i></button></th>

                        </tr>
                    </thead>
                    <tbody id="tabla_presupuesto{{ $infoPrograma->id }}">
                        <tr>
                            <td colspan="8" style="text-align: center;border:solid 1px gray;">No existen
                                fuentes de financiamiento registradas para este Programa</td>
                        </tr>
                    </tbody>
                </table>                
            </td>
        </tr>
    </table>
</div>
