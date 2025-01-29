<div style="border: solid 1px green;padding:20px;border-radius:20px;margin:10px;" id="programa{{$infoPrograma->id}}">
    <input type="hidden" id="ia_presupuesto_tipog_id" value="{{$infoPrograma->id}}">    
    <button class="close" type="button" aria-label="Close"
        style="color:red;position:realtive;bottom:30px;" onclick="removePrograma({{$infoPrograma->id}})">
        <span aria-hidden="true" style="font-size: .8em;"><i class="fas fa-trash"></i></span>
    </button>
    <table style="width: 100%">
        <tr>
            <td class="enc1" style="width: 10%">Programa Presupuestario:</td>
            <td>
                <select id="pp_id" class="form-control"></select>
            </td>
            <td class="enc1" style="width: 10%">Componente:</td>
            <td style="width: 40%">
                <input type="text" class="form-control"
                    placeholder="indicar el ID del componente" id="componente" />
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
                            <th style="width: 5%;text-align:center"><button
                                    class="btn btn-success" onclick="fuenteFinanciamiento()"><i
                                        class="fas fa-plus"></i></button></th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8"
                                style="text-align: center;border:solid 1px gray;">No existen
                                fuentes de financiamiento registradas para este Programa</td>
                        </tr>
                       <!-- <tr>
                            <td style="text-align: center;border:solid 1px gray;">1</td>
                            <td style="border:solid 1px gray;">FAS</td>
                            <td style="text-align: right;border:solid 1px gray;">$ 5,000.00
                            </td>
                            <td style="text-align: right;border:solid 1px gray;">$0.00</td>
                            <td style="text-align: right;border:solid 1px gray;">$0.00</td>
                            <td style="text-align: right;border:solid 1px gray;">$5,000.00</td>
                            <td style="border:solid 1px gray; text-align:center;width:10%">
                                <button class="btn btn-ligth"><i
                                        class="fas fa-edit"></i></button>
                                <button class="btn btn-ligth"><i class="fas fa-trash"
                                        style="color:red"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;border:solid 1px gray;">2</td>
                            <td style="border:solid 1px gray;">FOS</td>
                            <td style="text-align: right;border:solid 1px gray;">$ 5,000.00
                            </td>
                            <td style="text-align: right;border:solid 1px gray;">$0.00</td>
                            <td style="text-align: right;border:solid 1px gray;">$0.00</td>
                            <td style="text-align: right;border:solid 1px gray;">$5,000.00</td>
                            <td style="border:solid 1px gray; text-align:center;width:10%">
                                <button class="btn btn-ligth"><i
                                        class="fas fa-edit"></i></button>
                                <button class="btn btn-ligth"><i class="fas fa-trash"
                                        style="color:red"></i></button>
                            </td>
                        </tr>-->
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div>