<!-- Modal Generales y Alineación -->
<div class="modal fade" id="modalGenerales" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel"
    data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="formDatosGenerales" class="needs-validation" novalidate>
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <!-- Token de seguridad -->
                @csrf


                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" id="accionModalLabel">Datos Generales y Alineación</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="modal-body modal-body-padding">
                    <div class="mb-3">
                        <span id="info-producto"
                            style="font-size: 1.5rem; display: block; text-align: left;  color: black;"></span>


                        <!-- Pestañas de navegación -->
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" data-toggle="tab" href="#nav-home" role="tab"
                                    aria-controls="nav-home" aria-selected="true" data-target-tab="home">
                                    Datos Generales <span id="noti-home"></span>
                                </a>
                                <a class="nav-item nav-link" data-toggle="tab" href="#nav-alineacion" role="tab"
                                    aria-controls="nav-alineacion" aria-selected="false" data-target-tab="alineacion">
                                    Alineación <span id="noti-alineacion"></span>
                                </a>
                                <a class="nav-item nav-link" data-toggle="tab" href="#nav-indicador" role="tab"
                                    aria-controls="nav-indicador" aria-selected="false" data-target-tab="indicador">
                                    Datos del Indicador <span id="noti-indicador"></span>
                                </a>

                            </div>
                        </nav>

                        <!-- Contenido de las pestañas -->
                        <div class="tab-content" id="nav-tabContent">
                            <!-- Datos Generales -->
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                <div class="col-lg-12 content-padding">
                                    <div class="card shadow">
                                        <div class="card-header header-dark">
                                            <h6 class="m-0 font-weight-bold text-light"
                                                onclick="toggle('chevgenerales','body-generales')"
                                                style="cursor: pointer;">
                                                Datos Generales <i class="fas fa-chevron-down" id="chevgenerales"></i>
                                            </h6>
                                        </div>
                                        <div class="card-body" id="body-generales">
                                            @csrf
                                            <tr>
                                                <td colspan="3">
                                                    <input type="hidden" name="idProducto" id="idProducto">
                                                </td>
                                            </tr>
                                            <table class="full-width-table">
                                                <tr>
                                                    <td class="enc1" style="width: 20%">Producto PES / PE: <span
                                                            class="required">*</span> <i
                                                            class="fas fa-question-circle"></i>
                                                    </td>
                                                    <td colspan="3">
                                                        <textarea class="form-control" name="producto"
                                                            id="producto" rows="2"
                                                            placeholder="Indica el Nombre del Producto PES / PE"
                                                            required readonly></textarea>

                                                        <div class="invalid-feedback">
                                                            Debe indicar el Nombre del Producto PES / PE.
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="enc1">Responsable: <span class="required">*</span> <i
                                                            class="fas fa-question-circle"></i></td>
                                                    <td>
                                                        <select id="dependencia" class="form-control" required readonly
                                                            disabled>
                                                            @if (isset($producto->dependenciaNombre))
                                                                <option value="{{ $producto->idDependencia }}" selected>
                                                                    {{ $producto->dependenciaNombre . ' (' . $producto->dependenciaSiglas . ')' }}
                                                                </option>
                                                            @else
                                                                <option value="">No tienes una dependencia asignada</option>
                                                            @endif
                                                        </select>
                                                        {{-- Campo oculto para enviar el valor correcto --}}
                                                        <input type="hidden" name="dependencia"
                                                            value="{{ $producto->idDependencia ?? '' }}">
                                                        <div class="invalid-feedback">
                                                            Debe seleccionar una dependencia.
                                                        </div>
                                                    </td>
                                                </tr>


                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Alineación -->
                            <div class="tab-pane fade" id="nav-alineacion" role="tabpanel"
                                aria-labelledby="nav-alineacion-tab">
                                <div class="col-lg-12 content-padding">
                                    <div class="card shadow">
                                        <div class="card-header header-dark">
                                            <h6 class="m-0 font-weight-bold text-light"
                                                onclick="toggle('chev-alineacion','body-alineacion')"
                                                style="cursor: pointer;">
                                                Alineación <i class="fas fa-chevron-down" id="chev-alineacion"></i>
                                            </h6>
                                        </div>
                                        <div class="card-body" id="body-alineacion" style="display:none;">
                                            @csrf
                                            @if (isset($idProducto))
                                                <input type="hidden" name="idProducto" value="{{ $idProducto }}">
                                            @endif

                                            <table class="full-width-table">
                                                <tr>
                                                    <td class="enc1" style="width: 15%;">Eje: <span
                                                            class="required">*</span></td>
                                                    <td>
                                                        <select name="idEjePED" id="eje" class="form-control" required>
                                                            <option value="">Seleccione el eje correspondiente...
                                                            </option>
                                                            @foreach ($ejes as $eje)
                                                                <option value="{{ $eje->idEjePED }}">
                                                                    {{ $eje->ejePEDClave . ' ' . $eje->ejePEDDescripcion }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">Debe indicar el eje
                                                            correspondiente.
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="enc1">Tema: <span class="required">*</span></td>
                                                    <td>
                                                        <select name="idTemaPED" id="tema" class="form-control"
                                                            required>
                                                            <option value="">Seleccione el tema correspondiente...
                                                            </option>
                                                        </select>


                                                        <div class="invalid-feedback">Debe indicar el tema
                                                            correspondiente.
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="enc1">Objetivo: <span class="required">*</span></td>
                                                    <td>
                                                        <select name="idObjetivoPED" id="objetivo_ped"
                                                            class="form-control" required>
                                                            <option value="">Seleccione el objetivo
                                                                correspondiente...
                                                            </option>
                                                            @foreach ($objetivos as $objetivo)
                                                                <option value="{{ $objetivo->idObjetivoPED }}">
                                                                    {{ $objetivo->objetivoPEDClave . ' ' . $objetivo->objetivoPEDDescripcion }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">Debe indicar el objetivo.</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="enc1">Estrategias: <span class="required">*</span></td>
                                                    <td>
                                                        <select name="idEstrategiaPED" id="estrategia"
                                                            class="form-control" required>
                                                            <option value="">Seleccione la estrategia
                                                                correspondiente...
                                                            </option>
                                                            @foreach ($estrategias as $estrategia)
                                                                <option value="{{ $estrategia->idEstrategiaPED }}">
                                                                    {{ $estrategia->estrategiaPEDClave . ' ' . $estrategia->estrategiaPEDDescripcion }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">Debe indicar la estrategia.</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="enc1">Líneas de acción: <span class="required">*</span>
                                                    </td>
                                                    <td>
                                                        <select name="idLAPED" id="lineasAccionAlineacion"
                                                            class="form-control" required>
                                                            <option value="">Seleccione la línea de acción
                                                                correspondiente...</option>
                                                            @foreach ($lineasaccionped as $lineaaccionped)
                                                                <option value="{{ $lineaaccionped->idLAPED }}">
                                                                    {{ $lineaaccionped->laPEDClave . ' ' . $lineaaccionped->laPEDDescripcion }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">Debe indicar la línea de acción.
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>
                                    </div>

                                    <!-- Sector -->
                                    <div class="card shadow mt-3">
                                        <div class="card-header header-dark">
                                            <h6 class="m-0 font-weight-bold text-light"
                                                onclick="toggle('chev-sector','body-sector')" style="cursor: pointer;">
                                                Sector <i class="fas fa-chevron-down" id="chev-sector"></i>
                                            </h6>
                                        </div>
                                        <div class="card-body" id="body-sector" style="display:none;">

                                            @csrf
                                            <table class="full-width-table">
                                                <tr>
                                                    <td class="enc1" style="width: 15%;">Objetivo: <span
                                                            class="required">*</span></td>
                                                    <td>
                                                        <select name="idObjetivo" id="idObjetivo" class="form-control"
                                                            required>
                                                            <option value="">Seleccione el objetivo del sector
                                                                correspondiente...</option>
                                                            @foreach ($objetivosSector as $objetivoSector)
                                                                <option value="{{ $objetivoSector->idObjetivo }}">
                                                                    {{ $objetivoSector->claveObjetivo . ' ' . $objetivoSector->objetivo }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">Debe indicar el objetivo del
                                                            sector.
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="enc1">Estrategia: <span class="required">*</span></td>
                                                    <td>
                                                        <select name="idEstrategia" id="idEstrategia"
                                                            class="form-control" required>
                                                            <option value="">Seleccione la estrategia del sector
                                                                correspondiente...</option>
                                                            @foreach ($estrategiasSector as $estrategiaSector)
                                                                <option value="{{ $estrategiaSector->idEstrategia }}">
                                                                    {{ $estrategiaSector->claveEstrategia . ' ' . $estrategiaSector->estrategia }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">Debe indicar la estrategia del
                                                            sector.
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Programa, Proyecto o Acción -->
                                    <div class="card shadow mt-3">
                                        <div class="card-header header-dark">
                                            <h6 class="m-0 font-weight-bold text-light"
                                                onclick="toggle('chev-programa','body-programa')"
                                                style="cursor: pointer;">
                                                Programa, Proyecto o Acción <i class="fas fa-chevron-down"
                                                    id="chev-programa"></i>
                                            </h6>
                                        </div>
                                        <div class="card-body" id="body-programa">
                                            <table style="width: 100%">
                                                {{-- PPA --}}
                                                <tr>
                                                    <td class="enc1" style="width: 15%;">Nombre del PPA: <span
                                                            class="required">*</span></td>
                                                    <td colspan="3">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <select name="ppa" id="ppa" class="form-control me-2"
                                                                style="flex: 1;">
                                                                <option value="">Seleccione el PPA...</option>
                                                                @foreach ($ppas as $ppa)
                                                                    <option value="{{ $ppa->id }}">
                                                                        {{ $ppa->id . ' ' . $ppa->nombre }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            <button type="button" class="btn btn-success"
                                                                onclick="agregarPPA(event)">
                                                                <i class="fas fa-arrow-down"></i> Agregar PPA
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <table class="table full-width-table table-bordered table-sm"
                                                            style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th class="enc1 th-bs-id">
                                                                        ID</th>
                                                                    <th class="enc1 th-bs">Nombre
                                                                        del PPA</th>
                                                                    <th class="enc1 th-bs">
                                                                        Opciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="body-ppas">
                                                                <!-- PPAs agregados dinámicamente -->
                                                            </tbody>
                                                        </table>

                                                        <input type="hidden" name="nombrePPA" id="nombrePPA" value="">
                                                    </td>
                                                </tr>

                                                {{-- Bien o Servicio --}}
                                                <tr>
                                                    <td class="enc1" style="width:15%">Bien o Servicio: <span
                                                            class="required">*</span></td>
                                                    <td colspan="3">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <select id="bienServicio" name="bienServicio"
                                                                class="form-control me-2" required style="flex: 1;">
                                                                <option value="">Seleccione el Bien o Servicio</option>
                                                                @foreach ($nombresbs as $nombrebs)
                                                                    <option value="{{ $nombrebs->idBS }}"
                                                                        data-ia-id="{{ $nombrebs->ia_id }}">
                                                                        {{ $nombrebs->idBS . ' ' . $nombrebs->nombreBS }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                            <button type="button" class="btn btn-success"
                                                                onclick="agregarBienServicio(event)">
                                                                <i class="fas fa-arrow-down"></i> Agregarlo
                                                            </button>
                                                        </div>
                                                        <input type="hidden" id="bienesServicios" name="bienesServicios"
                                                            value="">
                                                        <div class="invalid-feedback">Debe seleccionar un Bien o
                                                            Servicio.
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <table class="table full-width-table table-bs">
                                                            <thead>
                                                                <tr>
                                                                    <th class="enc1 th-bs-id">ID</th>
                                                                    <th class="enc1 th-bs">Bien o Servicio</th>
                                                                    <th class="enc1 th-bs">Opciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="body-bienes" class="tbody-bs"></tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>



                                        </div>

                                    </div>

                                </div>
                            </div>

                            <!-- Datos del indicador -->
                            <div class="tab-pane fade" id="nav-indicador" role="tabpanel"
                                aria-labelledby="nav-indicador-tab">
                                <div class="col-lg-12 content-padding">
                                    <div class="card shadow">
                                        <div class="card-header header-dark">
                                            <h6 class="m-0 font-weight-bold text-light"
                                                onclick="toggle('chev-indicador','body-indicador')"
                                                style="cursor: pointer;">
                                                Datos del Indicador <i class="fas fa-chevron-down"
                                                    id="chev-indicador"></i>
                                            </h6>
                                        </div>
                                        <div class="card-body" id="body-indicador">
                                            @csrf <!-- Token de seguridad -->
                                            <table class="full-width-table">
                                                <tr>
                                                    <td class="enc1" style="width: 20%">Tipo: <span
                                                            class="required">*</span></td>
                                                    <td>
                                                        <select class="form-control" disabled>
                                                            <option value="gestion" selected>Gestión</option>
                                                        </select>
                                                        <input type="hidden" name="tipoIndicador" value="gestion">

                                                        <div class="invalid-feedback">Debe indicar el Tipo de Indicador.
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="enc1">Método de Cálculo: <span class="required">*</span>
                                                    </td>


                                                    <td>
                                                        <select class="form-control" disabled>
                                                            <option value="porcentaje" selected>Porcentaje</option>
                                                        </select>
                                                        <input type="hidden" name="calculoIndicador" value="porcentaje">

                                                        <div class="invalid-feedback">Debe indicar el Tipo de Indicador.
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="enc1">Frecuencia de Medición: <span
                                                            class="required">*</span>
                                                    </td>
                                                    <td>


                                                        <select class="form-control" disabled>
                                                            <option value="anual" selected>Anual</option>
                                                        </select>
                                                        <input type="hidden" name="frecuenciaMedicion" value="anual">
                                                        <div class="invalid-feedback">Debe indicar la Frecuencia de
                                                            Medición.</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="enc1">Sentido Esperado: <span class="required">*</span>
                                                    </td>
                                                    <td>

                                                        <select class="form-control" disabled>
                                                            <option value="Ascendente" selected>Ascendente</option>
                                                        </select>
                                                        <input type="hidden" name="sentidoEsperado" value="Ascendente">
                                                        <div class="invalid-feedback">Debe indicar el Sentido Esperado.
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="enc1">Unidad de Medida Producto: <span
                                                            class="required">*</span></td>
                                                    <td>
                                                        <textarea class="form-control" name="unidadIndicador"
                                                            id="unidadIndicador" maxlength="255"
                                                            placeholder="Indica la Unidad de Medida del Producto"
                                                            required></textarea>
                                                        <div class="invalid-feedback">Debe indicar la Unidad de Medida
                                                            del
                                                            Producto.</div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="enc1">Unidad de Medida Indicador: <span
                                                            class="required">*</span></td>


                                                    <td>
                                                        <select class="form-control" disabled>
                                                            <option value="porcentaje" selected>Porcentaje</option>
                                                        </select>
                                                        <input type="hidden" name="unidadMedidaIndicador"
                                                            value="porcentaje">

                                                        <div class="invalid-feedback">Debe indicar el Tipo de Indicador.
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="enc1">Medio de Verificación: <span
                                                            class="required">*</span>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="medioIndicador"
                                                            id="medioIndicador" maxlength="255"
                                                            placeholder="Indica el Medio de Verificación"
                                                            required></textarea>
                                                        <small id="contadorCaracteres" class="form-text text-muted">0 /
                                                            255
                                                            caracteres</small>

                                                        <div class="invalid-feedback">Debe indicar el Medio de
                                                            Verificación
                                                            correspondiente.</div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer del modal -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnAlmacenarG"
                            onclick="guardarProductoSectorialAjax()">Almacenar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<script id="temas-json" type="application/json">{!! json_encode($temas) !!}</script>
<script id="objetivos-json" type="application/json">{!! json_encode($objetivos) !!}</script>
<script id="estrategias-json" type="application/json">{!! json_encode($estrategias) !!}</script>
<script id="lineasaccionped-json" type="application/json">{!! json_encode($lineasaccionped) !!}</script>
<script id="estrategiassector-json" type="application/json">{!! json_encode($estrategiasSector) !!}</script>
<script id="ppas-json" type="application/json">{!! json_encode($ppas) !!}</script>
<script id="bienesservicios-json" type="application/json">{!! json_encode($nombresbs) !!}</script>



<script>
    //Scripts para filtrados


    document.addEventListener('DOMContentLoaded', function () {
        const temas = JSON.parse(document.getElementById('temas-json').textContent);
        const objetivos = JSON.parse(document.getElementById('objetivos-json').textContent);
        const estrategias = JSON.parse(document.getElementById('estrategias-json').textContent);
        const lineasaccionped = JSON.parse(document.getElementById('lineasaccionped-json').textContent);
        //Sector
        const estrategiasSector = JSON.parse(document.getElementById('estrategiassector-json').textContent);
        //ppas
        const ppas = JSON.parse(document.getElementById('ppas-json').textContent);

        const selectEje = document.getElementById('eje');
        const selectTema = document.getElementById('tema');
        const selectObjetivo = document.getElementById('objetivo_ped');
        const selectEstrategia = document.getElementById('estrategia');
        //Sector
        const selectObjetivoSector = document.getElementById('idObjetivo');
        const selectEstrategiaSector = document.getElementById('idEstrategia');
        //PPA
        const idDependencia = document.querySelector('input[name="dependencia"]').value;
        const bienesServiciosTodos = JSON.parse(document.getElementById('bienesservicios-json').textContent);


        const selectPPA = document.getElementById('ppa');
        // Eje → Tema
        selectEje.addEventListener('change', () => {
            const idEje = selectEje.value;
            filtrarOpciones({
                datos: temas,
                idPadre: idEje,
                campoFiltro: 'idEjePED',
                selectDestino: selectTema,
                campoValue: 'idTemaPED',
                campoLabel: (t) => `${t.temaPEDClave} ${t.temaPEDDescripcion}`
            });

            selectObjetivo.innerHTML = '<option value="">Seleccione un objetivo...</option>';
            selectEstrategia.innerHTML = '<option value="">Seleccione una estrategia...</option>';
        });

        // Tema → Objetivo
        selectTema.addEventListener('change', () => {
            const idTema = selectTema.value;
            filtrarOpciones({
                datos: objetivos,
                idPadre: idTema,
                campoFiltro: 'idTemaPED',
                selectDestino: selectObjetivo,
                campoValue: 'idObjetivoPED',
                campoLabel: (o) => `${o.objetivoPEDClave} ${o.objetivoPEDDescripcion}`
            });

            selectEstrategia.innerHTML = '<option value="">Seleccione una estrategia...</option>';
        });

        // Objetivo → Estrategia
        selectObjetivo.addEventListener('change', () => {
            const idObjetivo = selectObjetivo.value;
            filtrarOpciones({
                datos: estrategias,
                idPadre: idObjetivo,
                campoFiltro: 'idObjetivoPED',
                selectDestino: selectEstrategia,
                campoValue: 'idEstrategiaPED',
                campoLabel: (e) => `${e.estrategiaPEDClave} ${e.estrategiaPEDDescripcion}`
            });
        });

        // Estrategia → Línea de Acción
        selectEstrategia.addEventListener('change', () => {
            const idEstrategia = selectEstrategia.value;
            filtrarOpciones({
                datos: lineasaccionped,
                idPadre: idEstrategia,
                campoFiltro: 'idEstrategiaPED',
                selectDestino: document.getElementById('lineasAccionAlineacion'),
                campoValue: 'idLAPED',
                campoLabel: (l) => `${l.laPEDClave} ${l.laPEDDescripcion}`
            });
        });
        //Sector
        //Objetivo → Estrategia
        selectObjetivoSector.addEventListener('change', () => {
            const idObjetivoSector = selectObjetivoSector.value;

            filtrarOpciones({
                datos: estrategiasSector,
                idPadre: idObjetivoSector,
                campoFiltro: 'idObjetivo',
                selectDestino: selectEstrategiaSector,
                campoValue: 'idEstrategia',
                campoLabel: e => `${e.claveEstrategia} ${e.estrategia}`
            });
        });

        // PPA
        if (selectPPA && Array.isArray(ppas)) {
            selectPPA.innerHTML = '<option value="">Seleccione un PPA...</option>';

            ppas
                .filter(p => parseInt(p.idDependencia) === parseInt(idDependencia))
                .forEach(ppa => {
                    const option = document.createElement('option');
                    option.value = ppa.id;
                    option.textContent = `${ppa.id} ${ppa.nombre}`;
                    selectPPA.appendChild(option);
                });
        }
    });
    function filtrarOpciones({ datos, idPadre, campoFiltro, selectDestino, campoValue, campoLabel, valorPreseleccionado = null }) {
        if (!Array.isArray(datos) || !selectDestino) return;

        selectDestino.innerHTML = '<option value="">Seleccione una opción...</option>';

        datos
            .filter(item => parseInt(item[campoFiltro]) === parseInt(idPadre))
            .forEach(item => {
                const option = document.createElement('option');
                option.value = item[campoValue];
                option.textContent = typeof campoLabel === 'function' ? campoLabel(item) : item[campoLabel];
                if (valorPreseleccionado && parseInt(item[campoValue]) === parseInt(valorPreseleccionado)) {
                    option.selected = true;
                }
                selectDestino.appendChild(option);
            });
    }
    function actualizarBienesSegunPPA() {


        const bienesTodos = JSON.parse(document.getElementById('bienesservicios-json').textContent);
        const selectBien = document.getElementById('bienServicio');

        // Obtener todos los PPA actualmente agregados en la tabla
        const ppasAgregados = Array.from(document.querySelectorAll('#body-ppas tr')).map(row => {
            const id = row.id.replace('row-ppa-', '');
            return parseInt(id);
        });

        // Limpiar el selector
        selectBien.innerHTML = '<option value="">Seleccione el Bien o Servicio</option>';

        // Filtrar y agregar bienes que correspondan a algún ia_id relacionado con los PPAs
        const bienesFiltrados = bienesTodos.filter(bs => ppasAgregados.includes(parseInt(bs.ia_id)));

        bienesFiltrados.forEach(bs => {
            const option = document.createElement('option');
            option.value = bs.idBS;
            option.textContent = `${bs.idBS} ${bs.nombreBS}`;
            selectBien.appendChild(option);
        });
    }



    // Función toggle para cambiar entre expandir y contraer el contenido
     function toggle(iconId, contentId) {
            const content = document.getElementById(contentId);
            const icon = document.getElementById(iconId);

            const isVisible = window.getComputedStyle(content).display !== "none";

            if (isVisible) {
                content.style.display = "none";
                icon.classList.remove("fa-chevron-down");
                icon.classList.add("fa-chevron-right");
            } else {
                content.style.display = "block";
                icon.classList.remove("fa-chevron-right");
                icon.classList.add("fa-chevron-down");
            }
        }


    // Validación del formulario
    const form = document.getElementById('formDatosGenerales');
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
    function marcarPestañasIncompletas() {
        const pestañas = document.querySelectorAll('.nav-item.nav-link');

        pestañas.forEach(pestaña => {
            const target = pestaña.getAttribute('data-target-tab'); // ejemplo: 'home'
            const tabContent = document.getElementById(`nav-${target}`);
            const notiSpan = document.getElementById(`noti-${target}`);

            let incompleta = false;

            if (tabContent) {
                const campos = tabContent.querySelectorAll('[required]');
                campos.forEach(input => {
                    // ⚠️ Ignorar el select temporal de Bien o Servicio
                    if (input.id === 'bienServicio') return;

                    // Revisar si está vacío o no válido
                    if (!input.value || input.value.trim() === '') {
                        incompleta = true;
                    }
                });
            }

            pestaña.classList.remove('text-danger');
            if (notiSpan) {
                notiSpan.textContent = ''; // limpia
            }

            if (incompleta) {
                pestaña.classList.add('text-danger');
                if (notiSpan) {
                    notiSpan.textContent = '*';
                    notiSpan.style.color = 'red';
                    notiSpan.title = 'Campos incompletos';
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Activar validación dinámica en <select>
        document.querySelectorAll('select[required]').forEach(select => {
            select.addEventListener('change', function () {
                if (select.checkValidity()) {
                    select.classList.remove('is-invalid');
                    select.classList.add('is-valid');
                } else {
                    select.classList.remove('is-valid');
                    select.classList.add('is-invalid');
                }
            });
        });

        // Activar validación dinámica en <textarea>
        document.querySelectorAll('textarea[required]').forEach(textarea => {
            textarea.addEventListener('input', function () {
                if (textarea.checkValidity()) {
                    textarea.classList.remove('is-invalid');
                    textarea.classList.add('is-valid');
                } else {
                    textarea.classList.remove('is-valid');
                    textarea.classList.add('is-invalid');
                }
            });
        });
    });
</script>