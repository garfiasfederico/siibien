@extends('layouts.administrador')

@section('encabezado')
    Productos Sectoriales / Seguimiento de Productos
    @php
        $ruta = auth()->user()->hasRole('administrador') || auth()->user()->hasRole('administrador_pes')
            ? route('productossectoriales.admin')
            : route('productossectoriales.index');
    @endphp

    <a href="{{ $ruta }}">
        <button class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> <i class="fas fa-home"></i> Productos Sectoriales
        </button>
    </a>

@endsection



@section('styles')
    <style>
        /* Estilos generales para la página */
        .card {
            margin-bottom: 20px;
        }

        /* Estilo común para los encabezados de todas las pestañas */
        .card-header {
            background-color: rgb(157, 36, 73);
            color: white;
            cursor: pointer;
        }

        .card-body {
            display: none;
            /* Ocultar el contenido de las pestañas al inicio */
        }

        /* Estilos adicionales */
        .btn-submenu {
            margin-bottom: 10px;
            width: 100%;
            text-align: left;
        }

        .submenu-header {
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Encabezados personalizados */
        .enc1,
        .enc2,
        .enc3 {
            padding: 5px !important;
            color: white;
        }

        .enc1 {
            background-color: #c5c5c5;
        }

        .enc2 {
            background-color: #7c2f42;
        }

        .enc3 {
            background-color: #ececec;
            font-weight: bold;
        }

        /* Estilos para los botones dentro de las filas */
        .btn-actions {
            margin: 5px;
            width: 150px;
            text-align: left;
        }

        .required {
            color: red;
        }

        .full-width-table {
            width: 100%;
        }

        textarea.form-control,
        select.form-control {
            color: black;
        }

        .dropzone {
            background-color: rgb(250, 255, 243) !important;
            border: 2px solid green !important;
            border-radius: 5px !important;
            padding: 20px !important;
            min-height: 160px !important;
            display: flex !important;
            text-align: center !important;
            align-items: center !important;
            justify-content: center !important;
            flex-direction: column !important;
        }

        .dropzone.dragover {
            background-color: #e0ffe0 !important;
            /* verde claro al arrastrar */
            transition: background-color 0.3s ease;
        }



        /* Estilo para el mensaje de error */
        .invalid-feedback {
            width: 100%;
            background-color: rgb(255, 195, 195);
            color: gray;
            border-radius: 5px;
            text-align: center;
            padding: 10px;
            border: solid 1px red;
        }

        #medios_cargados tr.nuevo {
            animation: fadeIn 0.4s ease-in;
            background-color: #f9f9f9;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Estilo para campos de texto y select */
        input[type=text],
        select {
            height: 35px;
            color: black;
        }

        /* Estilo para el área de texto */
        textarea {
            color: black;
        }

        .cgris {
            background-color: #f0f0f0;
            text-align: center;
        }
    </style>
@endsection
@section('content')
    <div class="card shadow mb-4">
        <!-- Card Header sin lógica ni dropdown -->
        <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background-color: #681b2e;">
            @if (isset($producto))
                <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">
                    Seguimiento: {{$producto->idProducto . ' ' . $producto->producto }}
                </h6>
            @else
                <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">
                    Producto no encontrado.
                </h6>
            @endif
        </div>
        <div class="container-fluid" id="body-bs">
            <!-- Formulario principal -->
            <form id="formSeguimiento" method="POST" action="{{ route('productos.guardarSeguimiento') }}">
                @csrf
                <input type="hidden" name="idProducto" id="idProducto" value="{{ $producto->idProducto }}">
                <hr />
                <!-- Selector de Año -->
                <div class="d-flex justify-content-end align-items-center mb-3"
                    style="gap: 10px; flex-wrap: wrap; margin-top: 20px;">
                    <label for="anio-medios" class="mb-0 mr-2" style="font-weight: bold;">Año:</label>
                    <select class="form-control" id="anio-medios" style="width: 200px;">

                        <option value="">Seleccione el año...</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                    </select>
                    <!-- Texto para mostrar el año seleccionado -->
                    <span id="anio-seleccionado-texto" class="font-weight-bold"
                        style="display: none; font-size: 1.7rem; text-align: left; width: 100%;"></span>
                </div>

                <!-- Contenedor ocultable -->
                <div id="seccion-seguimiento" style="display: none;">
                    <!-- Navegación de pestañas -->
                    <nav>
                        <div class="d-flex align-items-center">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist" style="flex-grow: 1;">
                                <a class="nav-item nav-link active" id="nav-presupuesto-tab" data-toggle="tab"
                                    href="#nav-presupuesto" role="tab" aria-controls="nav-presupuesto"
                                    data-target-tab="presupuesto">Programa Presupuestario</a>

                                <a class="nav-item nav-link" id="nav-metas-tab" data-toggle="tab" href="#nav-metas"
                                    role="tab" aria-controls="nav-metas" data-target-tab="metas">Seguimiento de Metas</a>

                                <a class="nav-item nav-link" id="nav-medios-tab" data-toggle="tab" href="#nav-medios"
                                    role="tab" aria-controls="nav-medios" data-target-tab="medios">Medios de
                                    Verificación</a>

                                <a class="nav-item nav-link" id="nav-observaciones-tab" data-toggle="tab"
                                    href="#nav-observaciones" role="tab" aria-controls="nav-observaciones"
                                    data-target-tab="observaciones">Observaciones</a>

                            </div>
                            <div>
                                <button type="button" id="btn-guardar" class="btn btn-success"
                                    onclick="guardarSeguimiento()">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>

                            </div>
                        </div>
                    </nav>
                    <hr />
                    <div class="tab-content" id="nav-tabContent">
                        <!-- Programa Presupuestario -->
                        <div class="tab-pane fade show active" id="nav-presupuesto" role="tabpanel"
                            aria-labelledby="nav-presupuesto-tab">
                            <div class="card shadow">
                                <div class="card-header" onclick="toggle('chevronPresupuesto', 'bodyPresupuesto')">
                                    <h6 class="m-0 font-weight-bold">
                                        Presupuesto General por Año
                                        <i id="chevronPresupuesto" class="fas fa-chevron-down float-right"></i>
                                    </h6>
                                </div>

                                <div class="card-body" id="bodyPresupuesto" style="display: block;">
                                    <!-- Campo oculto para enviar el año seleccionado -->
                                    <input type="hidden" name="anio" id="anio-hidden" value="">

                                    <hr />

                                    <!-- Contenido que solo se mostrará si se selecciona un año -->
                                    <div id="contenido-presupuesto" style="display:none;">

                                        <button type="button" class="btn btn-success mb-3"
                                            onclick="agregarProgramaPresupuestario(event)">
                                            <i class="fas fa-plus"></i> Agregar Programa Presupuestario
                                        </button>

                                        <!-- Contenedor donde se agregarán los programas presupuestarios dinámicamente -->
                                        <div id="programas-presupuestarios-container"></div>

                                        <!-- Aquí puedes mantener campos fijos si quieres, o eliminar si solo usarás los dinámicos -->

                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Seguimiento de Metas -->
                        <div class="tab-pane fade" id="nav-metas" role="tabpanel" aria-labelledby="nav-metas-tab">
                            <div class="card shadow">
                                <div class="card-header" onclick="toggle('chevronMetas', 'bodyMetas')">
                                    <h6 class="m-0 font-weight-bold">
                                        Seguimiento de Metas
                                        <i id="chevronMetas" class="fas fa-chevron-down float-right"></i>
                                    </h6>
                                </div>
                                <div class="card-body" id="bodyMetas" style="display: block;">
                                    <!-- Tabla de Seguimiento de Metas -->
                                    <div class="table-responsive">
                                        <table class="table" style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td colspan="13"
                                                    style="text-align: center; background-color: rgb(243, 203, 215); color: gray;">
                                                    Seguimiento de Metas <br /> [Captura de metas programadas y alcanzadas]
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- Tabla de conceptos y valores -->
                                        <table class="table" style="width: 100%; border-collapse: collapse;">
                                            <thead>
                                                <tr>
                                                    <th
                                                        style="text-align: center; background-color: #f0f0f0; font-weight: bold;">
                                                        Concepto</th>
                                                    <th class="col-2023">2023</th>
                                                    <th class="col-2024">2024</th>
                                                    <th class="col-2025">2025</th>
                                                    <th class="col-2026">2026</th>
                                                    <th class="col-2027">2027</th>
                                                    <th class="col-2028">2028</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: left; background-color: #f0f0f0;">Programado
                                                    </td>
                                                    <td class="col-2023" style="text-align: center;"><input type="number"
                                                            class="form-control form-control-sm" name="programado_2023"
                                                            placeholder="Indica el Valor Programado" />
                                                    </td>
                                                    <td class="col-2024" style="text-align: center;"><input type="number"
                                                            class="form-control form-control-sm" name="programado_2024"
                                                            placeholder="Indica el Valor Programado" />
                                                    </td>
                                                    <td class="col-2025" style="text-align: center;"><input type="number"
                                                            class="form-control form-control-sm" name="programado_2025"
                                                            placeholder="Indica el Valor Programado" />
                                                    </td>
                                                    <td class="col-2026" style="text-align: center;"><input type="number"
                                                            class="form-control form-control-sm" name="programado_2026"
                                                            placeholder="Indica el Valor Programado" />
                                                    </td>
                                                    <td class="col-2027" style="text-align: center;"><input type="number"
                                                            class="form-control form-control-sm" name="programado_2027"
                                                            placeholder="Indica el Valor Programado" />
                                                    </td>
                                                    <td class="col-2028" style="text-align: center;"><input type="number"
                                                            class="form-control form-control-sm" name="programado_2028"
                                                            placeholder="Indica el Valor Programado" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left; background-color: #f0f0f0;">Realizado</td>
                                                    <td class="col-2023" style="text-align: center;"><input type="number"
                                                            class="form-control form-control-sm" name="realizado_2023"
                                                            placeholder="Indica el Valor Realizado" />
                                                    </td>
                                                    <td class="col-2024" style="text-align: center;"><input type="number"
                                                            class="form-control form-control-sm" name="realizado_2024"
                                                            placeholder="Indica el Valor Realizado" />
                                                    </td>
                                                    <td class="col-2025" style="text-align: center;"><input type="number"
                                                            class="form-control form-control-sm" name="realizado_2025"
                                                            placeholder="Indica el Valor Realizado" />
                                                    </td>
                                                    <td class="col-2026" style="text-align: center;"><input type="numer"
                                                            class="form-control form-control-sm" name="realizado_2026"
                                                            placeholder=" Indica el Valor  Realizado" />
                                                    </td>
                                                    <td class="col-2027" style="text-align: center;"><input type="number"
                                                            class="form-control form-control-sm" name="realizado_2027"
                                                            placeholder="Indica el valor Realizado" />
                                                    </td>
                                                    <td class="col-2028" style="text-align: center;"><input type="number"
                                                            class="form-control form-control-sm" name="realizado_2028"
                                                            placeholder="Indica el Valor Realizado" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="cgris">Valor indicado</td>
                                                    <td class="col-2023 cgris">
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="valor_indicado_2023" readonly />
                                                    </td>
                                                    <td class="col-2024 cgris">
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="valor_indicado_2024" readonly />
                                                    </td>
                                                    <td class="col-2025 cgris">
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="valor_indicado_2025" readonly />
                                                    </td>
                                                    <td class="col-2026 cgris">
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="valor_indicado_2026" readonly />
                                                    </td>
                                                    <td class="col-2027 cgris">
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="valor_indicado_2027" readonly />
                                                    </td>
                                                    <td class="col-2028 cgris">
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="valor_indicado_2028" readonly />
                                                    </td>
                                                </tr>

                                                <!-- NUEVA FILA con inputs ocultos para enviar los valores decimales -->
                                                <tr style="display:none;">
                                                    <td></td> <!-- Vacío para alineación -->
                                                    <td><input type="hidden" name="valor_indicado_decimal_2023" /></td>
                                                    <td><input type="hidden" name="valor_indicado_decimal_2024" /></td>
                                                    <td><input type="hidden" name="valor_indicado_decimal_2025" /></td>
                                                    <td><input type="hidden" name="valor_indicado_decimal_2026" /></td>
                                                    <td><input type="hidden" name="valor_indicado_decimal_2027" /></td>
                                                    <td><input type="hidden" name="valor_indicado_decimal_2028" /></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Medios de Verificación -->
                        <div class="tab-pane fade" id="nav-medios" role="tabpanel" aria-labelledby="nav-medios-tab">
                            <div class="col-lg-12" style="padding:20px;">
                                <div class="card shadow">
                                    <div class="card-header py-3" style="background-color:rgb(157, 36, 73);color:white">
                                        <h6 class="m-0 font-weight-bold text-light"
                                            onclick="toggle('chevmedios','body-medios')"
                                            style="cursor: pointer;color:white">
                                            Carga de Medios de Verificación <i class="fas fa-chevron-down"
                                                id="chevmedios"></i>
                                        </h6>
                                    </div>
                                    <div class="card-body" id="body-medios" style="display: block;">
                                        <table style="width:100%; border-collapse: separate; border-spacing: 15px;">
                                            <tr>
                                                <td
                                                    style="width: 50%;border:solid 1px rgb(201, 201, 201);vertical-align:top;">
                                                    <table style="width: 100%">

                                                    </table>
                                                    <!-- Zona de Dropzone -->
                                                    <div id="areaDropzone" class="dropzone" style="display: none;">

                                                        <div id="dropzoneDiv"
                                                            style="width:100%; height:100%; text-align:center;">
                                                            <p><strong>Arrastra los archivos para cargarlos aquí</strong>
                                                            </p>
                                                            <p>o da clic aquí para seleccionarlos</p>
                                                        </div>
                                                        <input type="file" id="fileInput" multiple style="display:none;" />

                                                    </div>
                                                </td>
                                                <td
                                                    style="width: 50%;text-align:center;vertical-align:top;border:solid 1px rgb(201, 201, 201)">
                                                    <b>Medios de Verificación Cargados</b>
                                                    <div id="mediosCargados" style="width: 100%;text-align:center">
                                                        <table style="width: 100%">
                                                            <thead>
                                                                <tr>
                                                                    <th class="enc2">Archivo Cargado</th>
                                                                    <th class="enc2">Descripción</th>
                                                                    <th class="enc2">Acción</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="medios_cargados">
                                                                <!-- Aquí con JS agregamos filas así: -->

                                                            </tbody>

                                                        </table>
                                                        <div id="alertaNoMedios" class="alert alert-info"
                                                            style="display: none;">
                                                            No existen medios de verificación cargados en este año
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Observaciones -->
                        <div class="tab-pane fade" id="nav-observaciones" role="tabpanel"
                            aria-labelledby="nav-observaciones-tab">
                            <div class="card shadow">
                                <div class="card-header" onclick="toggle('chevronObservaciones', 'bodyObservaciones')"
                                    style="cursor:pointer;">
                                    <h6 class="m-0 font-weight-bold">
                                        Observaciones
                                        <i id="chevronObservaciones" class="fas fa-chevron-down float-right"></i>
                                    </h6>
                                </div>

                                <div class="card-body" id="bodyObservaciones" style="display: block;">
                                    <textarea name="observaciones" id="observaciones" class="form-control" rows="6"
                                        maxlength="255"
                                        placeholder="Agrega las observaciones correspondiente..."></textarea>
                                    <small id="contadorCaracteres" class="form-text text-muted">0 / 255 caracteres</small>

                                </div>
                            </div>
                        </div>


                    </div>
            </form>
        </div>
    </div>
@endsection

<script id="datos-programas-json" type="application/json">
    {!! json_encode($programapresupuestarios) !!}
</script>


@section('scripts')
    <script>

        window.programasPresupuestarios = JSON.parse(document.getElementById('datos-programas-json').textContent);
        const allYears = [2023, 2024, 2025, 2026, 2027, 2028];

        function toggle(chevId, bodyId) {
            const body = document.getElementById(bodyId);
            const chevIcon = document.getElementById(chevId);
            const isVisible = body.style.display === "block";
            body.style.display = isVisible ? "none" : "block";
            chevIcon.classList.toggle("fa-chevron-up", !isVisible);
            chevIcon.classList.toggle("fa-chevron-down", isVisible);
        }


        function marcarPestañasIncompletas() {
            const pestañas = document.querySelectorAll('.nav-item.nav-link');

            pestañas.forEach(pestaña => {
                const target = pestaña.getAttribute('data-target-tab');
                let incompleta = false;
                const tabContent = document.getElementById(`nav-${target}`);

                if (tabContent) {
                    const requeridos = tabContent.querySelectorAll('[required]');
                    requeridos.forEach(input => {
                        if (!input.value.trim()) {
                            incompleta = true;
                        }
                    });
                }

                pestaña.classList.remove('text-danger');
                pestaña.innerHTML = pestaña.innerHTML
                    .replace(/<span.*?class="campo-incompleto".*?>.*?<\/span>/, '')
                    .replace('⚠️', '')
                    .trim();

                if (incompleta) {
                    pestaña.classList.add('text-danger');
                    pestaña.innerHTML = `
                                                                                                                                                            ${pestaña.textContent.trim()}
                                                                                                                                                            <span class="campo-incompleto" title="Campos incompletos" style="color: red;">*</span>
                                                                                                                                                        `;
                }
            });
        }

        /*function validarDescripcionesMedios() {
            const descripcionesExistentes = document.querySelectorAll('input[name="medios[descripcion][]"]');
            for (let input of descripcionesExistentes) {
                if (!input.value.trim()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Falta descripción',
                        text: 'Por favor, ingresa una descripción para todos los archivos existentes antes de guardar.',
                    });
                    input.focus();
                    return false;
                }
            }

            const descripcionesNuevas = document.querySelectorAll('input[name="nuevosMedios[descripcion][]"]');
            for (let input of descripcionesNuevas) {
                if (!input.value.trim()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Falta descripción',
                        text: 'Por favor, ingresa una descripción para todos los archivos nuevos antes de guardar.',
                    });
                    input.focus();
                    return false;
                }
            }

            return true;
        }*/

        function actualizarContadorArchivos() {
            const total = document.querySelectorAll('#medios_cargados tr').length;
            const contador = document.getElementById('contadorArchivos');
            if (contador) {
                contador.textContent = `Total de archivos: ${total}`;
            }
        }

        function obtenerIconoArchivo(nombre) {
            const ext = nombre.split('.').pop().toLowerCase();
            const iconos = {
                'pdf': '📄',
                'doc': '📄',
                'docx': '📄',
                'xls': '📊',
                'xlsx': '📊',
            };
            return iconos[ext] || '📁';
        }

        //  SEGUIMIENTO DEL PRODUCTO

        function guardarSeguimiento() {
            const form = $('#formSeguimiento')[0];
            const anioSeleccionado = $('#anio-hidden').val();
            const tabActiva = $('.tab-pane.active').attr('id');

            // Si no hay año seleccionado (en flujo normal)
            if (!anioSeleccionado && !window.confirmacionPrimeraVez) {
                Swal.fire({
                    icon: 'info',
                    title: 'Sin año seleccionado',
                    text: 'No se seleccionó ningún año, no se realizarán cambios en seguimiento de metas.',
                });
                return;
            }

            //Validación para Programa Presupuestario
            // Validación para Programa Presupuestario
            const programas = document.querySelectorAll('.programa-presupuestario-item');

            // No mostrar la alerta si es el primer seguimiento
            if (!window.confirmacionPrimeraVez && programas.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Programa presupuestario requerido',
                    text: 'Debe agregar al menos un programa presupuestario antes de guardar.',
                });
                return;
            }



            // Validación de metas si estamos en la pestaña de metas
            if (tabActiva === 'nav-metas') {
                const inputProgramado = $(`input[name="programado_${anioSeleccionado}"]`);
                const inputRealizado = $(`input[name="realizado_${anioSeleccionado}"]`);

                const valorProgramado = inputProgramado.val();
                if (!valorProgramado || isNaN(valorProgramado) || Number(valorProgramado) <= 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Dato requerido',
                        text: `Debe ingresar un valor numérico válido en "Programado" del año ${anioSeleccionado}.`
                    });
                    inputProgramado.focus().addClass('is-invalid');
                    return;
                } else {
                    inputProgramado.removeClass('is-invalid');
                }

                if (!inputRealizado.val()) {
                    inputRealizado.val(0);
                }

                inputProgramado.trigger('input');
                inputRealizado.trigger('input');
            }

            marcarPestañasIncompletas();

            if (!form.checkValidity()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Formulario incompleto',
                    text: 'Por favor, complete todos los campos requeridos antes de guardar.',
                });

                $('input, select, textarea').each(function () {
                    if (!this.checkValidity()) {
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
                return;
            }

            // Serializar el formulario
            $(form).addClass('was-validated');
            const formData = $('#formSeguimiento').serialize();

            // Detectar si es la primera vez
            const esPrimeraVez = window.confirmacionPrimeraVez === true;
            const urlGuardar = esPrimeraVez
                ? '{{ route('productos.guardarSeguimientoPrimeraVez') }}'
                : '{{ route('productos.guardarSeguimiento') }}';

            // Enviar datos
            $.ajax({
                type: 'POST',
                url: urlGuardar,
                data: formData,
                dataType: 'json',
                beforeSend: function () {
                    $('#btn-guardar').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
                },
                success: function (response) {
                    if (response.result === 'ok') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Actualización Seguimiento',
                            text: response.message,
                        }).then(() => {
                            // Resetear primera vez
                            window.confirmacionPrimeraVez = false;
                            $('#formSeguimiento')[0].reset();
                            $('#formSeguimiento').removeClass('was-validated');
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error del servidor',
                        text: 'Ocurrió un error inesperado. Intenta más tarde.',
                    });
                },
                complete: function () {
                    $('#btn-guardar').prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Cambios');
                }
            });
        }

        function obtenerDatosProgramaPresupuestario(anio) {
            const data = datosPorAnio[anio];
            if (!data) return;

            $(`input[name="programado_${anio}"]`).val(data.programado || '');
            $(`input[name="realizado_${anio}"]`).val(data.realizado || '');
            $(`input[name="valor_indicado_${anio}"]`).val(
                data.valor_indicado ? (parseFloat(data.valor_indicado) * 100).toFixed(2) + ' %' : ''
            );

            const container = document.getElementById('programas-presupuestarios-container');
            container.innerHTML = '';

            const programasFiltrados = programasPresupuestarios.filter(p => p.anio == anio);

            let opcionesProgramas = `<option value="">Seleccione el programa correspondiente...</option>`;
            programasFiltrados.forEach(p => {
                opcionesProgramas += `<option value="${p.idPrograma}">${p.clavePrograma} ${p.descripcionPrograma} ${p.anio}</option>`;
            });

            const fragment = document.createDocumentFragment();

            data.programas.forEach((programa, index) => {
                const divPrograma = document.createElement('div');
                divPrograma.className = 'programa-presupuestario-item mb-3 p-3 border rounded';
                divPrograma.setAttribute('data-index', index + 1);

                const opcionesConSeleccion = opcionesProgramas.replace(
                    new RegExp(`value="${programa.idPrograma}"`, 'g'),
                    `value="${programa.idPrograma}" selected`
                );

                divPrograma.innerHTML = `
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h5 class="mb-0">Programa Presupuestario #${index + 1}</h5>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminarPrograma(${index + 1}, ${programa.idPrograma})" title="Eliminar programa">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                                <table class="full-width-table">
                                                    <tr>
                                                        <td class="enc1" style="width:20%;">Programa: <span class="required">*</span></td>
                                                        <td>
                                                            <select name="programas[${index + 1}][idPrograma]" id="idPrograma_${index + 1}" class="form-control" required>
                                                                ${opcionesConSeleccion}
                                                            </select>
                                                            <div class="invalid-feedback">Debe seleccionar un programa.</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="enc1">Componente: <span class="required">*</span></td>
                                                        <td>
                                                            <textarea name="programas[${index + 1}][componente]" id="componente_${index + 1}" class="form-control" rows="2" required maxlength="255" placeholder="Debe indicar un componente">${programa.componente || ''}</textarea>
                                                            <div class="invalid-feedback">Debe indicar el Componente correspondiente.</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="enc1">Actividad: <span class="required">*</span></td>
                                                        <td>
                                                            <textarea name="programas[${index + 1}][actividad]" id="actividad_${index + 1}" class="form-control" rows="2" required maxlength="255" placeholder="Debe indicar una actividad">${programa.actividad || ''}</textarea>
                                                            <div class="invalid-feedback">Debe indicar la Actividad correspondiente.</div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            `;

                divPrograma.querySelectorAll('select, textarea').forEach(function (input) {
                    input.addEventListener('input', function () {
                        input.classList.toggle('is-valid', input.checkValidity());
                        input.classList.toggle('is-invalid', !input.checkValidity());
                    });
                });

                fragment.appendChild(divPrograma);
            });

            container.appendChild(fragment);
        }

        function agregarProgramaPresupuestario(event) {
            event.preventDefault();
            const anioSeleccionado = document.getElementById('anio-medios').value;

            if (!anioSeleccionado) {
                Swal.fire('Error', 'Por favor selecciona un año antes de agregar un programa.', 'warning');
                return;
            }

            const container = document.getElementById('programas-presupuestarios-container');
            const nuevoIndex = container.querySelectorAll('.programa-presupuestario-item').length + 1;
            const programasFiltrados = programasPresupuestarios.filter(p => p.anio == anioSeleccionado);

            let opciones = `<option value="">Seleccione el programa correspondiente...</option>`;
            programasFiltrados.forEach(p => {
                opciones += `<option value="${p.idPrograma}">${p.clavePrograma} ${p.descripcionPrograma} ${p.anio}</option>`;
            });



            const divPrograma = document.createElement('div');
            divPrograma.classList.add('programa-presupuestario-item', 'mb-3', 'p-3', 'border', 'rounded');
            divPrograma.setAttribute('data-index', nuevoIndex);

            divPrograma.innerHTML = `
                                                                                                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                                                                                                <h5 class="mb-0">Programa Presupuestario #${nuevoIndex}</h5>
                                                                                                                                                <button type="button" class="btn btn-danger btn-sm" title="Eliminar programa"><i class="fas fa-trash-alt"></i></button>
                                                                                                                                            </div>
                                                                                                                                            <table class="full-width-table">
                                                                                                                                                <tr>
                                                                                                                                                    <td class="enc1" style="width:20%;">Programa: <span class="required">*</span></td>
                                                                                                                                                    <td>
                                                                                                                                                        <select name="programas[${nuevoIndex}][idPrograma]" id="idPrograma_${nuevoIndex}" class="form-control" required>${opciones}</select>
                                                                                                                                                        <div class="invalid-feedback">Debe seleccionar un programa.</div>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr>
                                                                                                                                                    <td class="enc1">Componente: <span class="required">*</span></td>
                                                                                                                                                    <td>
                                                                                                                                                        <textarea name="programas[${nuevoIndex}][componente]" id="componente_${nuevoIndex}" class="form-control" rows="2" required maxlength="255" placeholder="Debe indicar un componente"></textarea>
                                                                                                                                                        <div class="invalid-feedback">Debe indicar el Componente correspondiente.</div>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr>
                                                                                                                                                    <td class="enc1">Actividad: <span class="required">*</span></td>
                                                                                                                                                    <td>
                                                                                                                                                        <textarea name="programas[${nuevoIndex}][actividad]" id="actividad_${nuevoIndex}" class="form-control" rows="2" required maxlength="255" placeholder="Debe indicar una actividad"></textarea>
                                                                                                                                                        <div class="invalid-feedback">Debe indicar la Actividad correspondiente.</div>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                            </table>
                                                                                                                                        `;

            // Evento para validar selección de programa único al cambiar el select
            const selectPrograma = divPrograma.querySelector(`#idPrograma_${nuevoIndex}`);
            selectPrograma.addEventListener('change', () => {
                const idSeleccionado = selectPrograma.value;
                if (!idSeleccionado) return; // no validar si no seleccionó nada

                // Buscar si ya existe este programa seleccionado en otro div
                const selects = container.querySelectorAll('select');
                let existe = false;
                selects.forEach(sel => {
                    if (sel !== selectPrograma && sel.value === idSeleccionado) {
                        existe = true;
                    }
                });

                if (existe) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Programa ya agregado',
                        text: 'Este programa presupuestario ya se encuentra en la lista.'
                    });
                    // limpiar el select o resetearlo
                    selectPrograma.value = '';
                }
            });

            divPrograma.querySelectorAll('select, textarea').forEach(input => {
                input.addEventListener('input', function () {
                    input.classList.toggle('is-valid', input.checkValidity());
                    input.classList.toggle('is-invalid', !input.checkValidity());
                });
            });

            divPrograma.querySelector('button').addEventListener('click', () => {
                Swal.fire({
                    title: '¿Deseas eliminar este programa presupuestario?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then(result => {
                    if (result.isConfirmed) {
                        container.removeChild(divPrograma);
                        reajustarIndicesProgramas();
                    }
                });
            });

            container.appendChild(divPrograma);
        }


        ///
        function inicializarMedios() {
            const anioSeleccionado = document.getElementById('anio-medios').value;
            const idProducto = document.getElementById('idProducto').value;
            const areaDropzone = document.getElementById('areaDropzone');
            const mediosCargadosBody = document.getElementById('medios_cargados');
            const alertaNoMedios = document.getElementById('alertaNoMedios');

            if (anioSeleccionado) {
                areaDropzone.style.display = 'flex';
                cargarMediosCargados(idProducto, anioSeleccionado);
            } else {
                areaDropzone.style.display = 'none';
                mediosCargadosBody.innerHTML = '';
                alertaNoMedios.style.display = 'none';
                actualizarContadorArchivos();
            }
        }

        function cargarMediosCargados(idProducto, anio) {
            $.ajax({
                url: `/productos/${idProducto}/medios/${anio}`,
                dataType: 'json',
                success: function (response) {
                    const mediosCargadosBody = document.getElementById('medios_cargados');
                    const alertaNoMedios = document.getElementById('alertaNoMedios');
                    mediosCargadosBody.innerHTML = '';

                    if (response.medios?.length) {
                        alertaNoMedios.style.display = 'none';

                        response.medios.forEach(medio => {
                            const tr = document.createElement('tr');

                            const tdArchivo = document.createElement('td');
                            tdArchivo.innerHTML = `${obtenerIconoArchivo(medio.nombreArchivo)} 
                                                                                                                                                                    <a href="/${medio.rutaArchivo}" target="_blank">${medio.nombreArchivo}</a>`;
                            tr.appendChild(tdArchivo);

                            const tdDesc = document.createElement('td');
                            const inputDesc = document.createElement('input');
                            inputDesc.type = 'text';
                            inputDesc.name = 'medios[descripcion][]';
                            inputDesc.value = medio.descripcion || '';
                            inputDesc.classList.add('form-control');
                            inputDesc.setAttribute('data-idmedio', medio.idMedio);

                            const inputId = document.createElement('input');
                            inputId.type = 'hidden';
                            inputId.name = 'medios[idMedio][]';
                            inputId.value = medio.idMedio;

                            tdDesc.appendChild(inputDesc);
                            tdDesc.appendChild(inputId);
                            tr.appendChild(tdDesc);

                            const tdAccion = document.createElement('td');
                            const btnEliminar = document.createElement('button');
                            btnEliminar.type = 'button';
                            btnEliminar.className = 'btn btn-danger btn-sm';
                            btnEliminar.innerText = 'Eliminar';
                            btnEliminar.onclick = () => eliminarMedio(medio.idMedio, idProducto, anio);
                            tdAccion.appendChild(btnEliminar);
                            tr.appendChild(tdAccion);

                            mediosCargadosBody.appendChild(tr);

                            inputDesc.addEventListener('blur', () => {
                                actualizarDescripcionMedio(medio.idMedio, inputDesc.value);
                            });
                        });
                    } else {
                        alertaNoMedios.style.display = 'block';
                    }

                    actualizarContadorArchivos();
                },
                error: () => {
                    const alertaNoMedios = document.getElementById('alertaNoMedios');
                    document.getElementById('medios_cargados').innerHTML = '';
                    alertaNoMedios.style.display = 'block';
                    actualizarContadorArchivos();
                }
            });
        }


        function subirArchivo(archivo, idProducto, anio) {
            const dropzoneDiv = document.getElementById('dropzoneDiv');
            const mediosCargadosBody = document.getElementById('medios_cargados');
            const alertaNoMedios = document.getElementById('alertaNoMedios');

            const formData = new FormData();
            formData.append('archivo', archivo);
            formData.append('idProducto', idProducto);
            formData.append('anio', anio);
            formData.append('_token', '{{ csrf_token() }}');

            // Mostrar spinner y mensaje de subida
            dropzoneDiv.innerHTML = `
                                                                                                                                              <p>
                                                                                                                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> 
                                                                                                                                                Subiendo ${archivo.name}...
                                                                                                                                              </p>
                                                                                                                                            `;

            $.ajax({
                url: '{{ route('productos.subirMedio') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.result === 'ok') {
                        const archivoSubido = response.archivo;
                        const tr = document.createElement('tr');

                        const tdArchivo = document.createElement('td');
                        tdArchivo.innerHTML = `${obtenerIconoArchivo(archivoSubido.nombre)} 
                                                                                                                                                            <a href="/${archivoSubido.ruta}" target="_blank">${archivoSubido.nombre}</a>`;
                        tr.appendChild(tdArchivo);

                        const tdDesc = document.createElement('td');
                        const inputDesc = document.createElement('input');
                        inputDesc.type = 'text';
                        inputDesc.name = 'nuevosMedios[descripcion][]';
                        inputDesc.placeholder = 'Escribe una descripción...';
                        inputDesc.classList.add('form-control');

                        const inputNombre = document.createElement('input');
                        inputNombre.type = 'hidden';
                        inputNombre.name = 'nuevosMedios[nombreArchivo][]';
                        inputNombre.value = archivoSubido.nombre;

                        const inputRuta = document.createElement('input');
                        inputRuta.type = 'hidden';
                        inputRuta.name = 'nuevosMedios[rutaArchivo][]';
                        inputRuta.value = archivoSubido.ruta;

                        tdDesc.appendChild(inputDesc);
                        tdDesc.appendChild(inputNombre);
                        tdDesc.appendChild(inputRuta);
                        tr.appendChild(tdDesc);

                        const tdAccion = document.createElement('td');
                        const btnEliminar = document.createElement('button');
                        btnEliminar.className = 'btn btn-danger btn-sm';
                        btnEliminar.innerText = 'Eliminar';
                        btnEliminar.onclick = () => tr.remove();
                        tdAccion.appendChild(btnEliminar);
                        tr.appendChild(tdAccion);

                        mediosCargadosBody.appendChild(tr);
                        alertaNoMedios.style.display = 'none';
                        actualizarContadorArchivos();

                        // Mostrar mensaje  permanente en dropzone
                        dropzoneDiv.innerHTML = `
                                                                                                                                                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                                                                                                            Archivo <strong>${archivoSubido.nombre}</strong> subido correctamente.
                                                                                                                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                                                                                                                                                              <span aria-hidden="true">&times;</span>
                                                                                                                                                            </button>
                                                                                                                                                          </div>
                                                                                                                                                        `;

                        // Opcional: ocultar mensaje después de 3 segundos
                        setTimeout(() => {
                            dropzoneDiv.innerHTML = `<p><strong>Arrastra los archivos para cargarlos aquí</strong></p><p>o da clic aquí para seleccionarlos</p>`;
                        }, 3000);

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'No se pudo subir el archivo.'
                        });
                        // Restaurar mensaje original para que usuario pueda intentar otra vez
                        dropzoneDiv.innerHTML = `<p><strong>Arrastra los archivos para cargarlos aquí</strong></p><p>o da clic aquí para seleccionarlos</p>`;
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo subir el archivo.'
                    });
                    dropzoneDiv.innerHTML = `<p><strong>Arrastra los archivos para cargarlos aquí</strong></p><p>o da clic aquí para seleccionarlos</p>`;
                }
            });
        }

        function eliminarMedio(idMedio, idProducto, anio) {
            Swal.fire({
                title: '¿Deseas eliminar este archivo?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-trash-alt"></i> Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/productos/medios/eliminar/${idMedio}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        beforeSend: () => {
                            Swal.fire({
                                title: 'Eliminando...',
                                allowOutsideClick: false,
                                didOpen: () => Swal.showLoading()
                            });
                        },
                        success: function (response) {
                            if (response.result === 'ok') {
                                cargarMediosCargados(idProducto, anio);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Eliminado',
                                    text: 'Archivo eliminado correctamente.',
                                    timer: 1800,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        },
                        error: () => {
                            Swal.fire('Error del servidor', 'No se pudo eliminar el archivo.', 'error');
                        }
                    });
                }
            });
        }
        let datosPorAnio = {}; // variable fuera de la función para uso global

        function mostrarContenidoPorAnio() {
            const anioSeleccionado = document.getElementById('anio-medios').value;
            const contenidoPresupuesto = document.getElementById('contenido-presupuesto');
            const anioTexto = document.getElementById('anio-seleccionado-texto');
            const idProducto = document.getElementById('idProducto').value;
            const allYears = [2023, 2024, 2025, 2026, 2027, 2028];

            const seccion = document.getElementById('seccion-seguimiento');

            if (anioSeleccionado) {
                contenidoPresupuesto.style.display = 'block';
                anioTexto.style.display = 'inline-block';
                anioTexto.textContent = "Año seleccionado: " + anioSeleccionado;
                document.getElementById('anio-hidden').value = anioSeleccionado;
                seccion.style.display = 'block';

                // Mostrar el mensaje de "Procesando..."
                mostrarCargaGlobal();

                $.ajax({
                    url: `/productos/${idProducto}/seguimiento-todos`,
                    dataType: 'json',
                    success: function (response) {
                        if (response.result === 'ok') {
                            const datos = response.data;
                            const primeraVez = response.primera_vez;

                            if (primeraVez && !window.confirmacionPrimeraVez) {
                                const anioSeleccionado = document.getElementById('anio-medios').value;

                                Swal.fire({
                                    icon: 'info',
                                    title: `Programación de Metas <strong>"${anioSeleccionado}"</strong>`,
                                    html: `
                    <p>Por ser la primera vez que ingresa a este apartado, favor de capturar la programación de metas correspondientes del año 2023 al 2028.</p>
                    <p>  Posteriormente el seguimiento se realizará año con año.</p>
                `,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.confirmacionPrimeraVez = true;
                                    $('#nav-metas-tab').tab('show');
                                    mostrarContenidoPorAnio(); // Recargar datos después de la confirmación
                                });

                                limpiarCamposPorAño(allYears);
                                return;
                            }


                            allYears.forEach(anio => {
                                const prog = document.querySelector(`input[name="programado_${anio}"]`);
                                const real = document.querySelector(`input[name="realizado_${anio}"]`);
                                const valor = document.querySelector(`input[name="valor_indicado_${anio}"]`);
                                const hidden = document.querySelector(`input[name="valor_indicado_decimal_${anio}"]`);

                                if (prog) prog.value = datos[anio]?.programado ?? '';
                                if (real) real.value = datos[anio]?.realizado ?? '';
                                if (valor && datos[anio]?.valor_indicado) {
                                    const vi = parseFloat(datos[anio].valor_indicado);
                                    valor.value = (vi * 100).toFixed(2) + ' %';
                                } else if (valor) {
                                    valor.value = '';
                                }
                                if (hidden) hidden.value = datos[anio]?.valor_indicado ?? '';

                                if (primeraVez) {
                                    if (prog) prog.disabled = false;
                                    if (real) real.disabled = false;
                                } else {
                                    if (prog) {
                                        prog.disabled = (anio != anioSeleccionado);
                                        prog.required = (anio == anioSeleccionado);
                                    }
                                    if (real) real.disabled = (anio != anioSeleccionado);
                                }
                            });

                            // Observaciones
                            $.ajax({
                                url: `/productos/${idProducto}/observacion`,
                                data: { anio: anioSeleccionado },
                                dataType: 'json',
                                success: function (res) {
                                    if (res.result === 'ok') {
                                        $('#observaciones').val(res.data || '');
                                    } else {
                                        $('#observaciones').val('');
                                    }
                                    inicializarContadorCaracteres('observaciones', 'contadorCaracteres');
                                },
                                error: function () {
                                    $('#observaciones').val('');
                                }
                            });

                            datosPorAnio = response.data;
                            obtenerDatosProgramaPresupuestario(anioSeleccionado);
                        } else {
                            limpiarCamposPorAño(allYears);
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudieron obtener los datos de seguimiento.',
                        });
                        limpiarCamposPorAño(allYears);
                    },
                    complete: function () {
                        ocultarCargaGlobal();
                    }
                });
            } else {
                contenidoPresupuesto.style.display = 'none';
                anioTexto.style.display = 'none';
                anioTexto.textContent = '';
                document.getElementById('anio-hidden').value = '';
                seccion.style.display = 'none';
                limpiarCamposPorAño(allYears);
            }
        }



        // Función auxiliar para limpiar inputs si no hay datos
        function limpiarCamposPorAño(allYears) {
            allYears.forEach(anio => {
                const prog = document.querySelector(`input[name="programado_${anio}"]`);
                const real = document.querySelector(`input[name="realizado_${anio}"]`);
                const valor = document.querySelector(`input[name="valor_indicado_${anio}"]`);
                const hidden = document.querySelector(`input[name="valor_indicado_decimal_${anio}"]`);

                if (prog) {
                    prog.value = '';
                    prog.disabled = true;
                    prog.removeAttribute('required');
                }
                if (real) {
                    real.value = '';
                    real.disabled = true;
                    real.removeAttribute('required');
                }
                if (valor) valor.value = '';
                if (hidden) hidden.value = '';
            });

            $('#programas-presupuestarios-container').html('');
            $('#observaciones').val('');
            document.getElementById('medios_cargados').innerHTML = '';
            document.getElementById('alertaNoMedios').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const dropzoneDiv = document.getElementById('dropzoneDiv');
            const fileInput = document.getElementById('fileInput');
            const anioSelect = document.getElementById('anio-medios');
            const idProducto = document.getElementById('idProducto').value;

            // Evento: cuando cambia el año
            anioSelect.addEventListener('change', function () {
                inicializarMedios();
                mostrarContenidoPorAnio();
            });

            if (anioSelect.value) {
                mostrarContenidoPorAnio();
            }

            // Subir archivos al hacer clic en zona
            document.getElementById('areaDropzone').addEventListener('click', () => {
                document.getElementById('fileInput').click();
            });

            // Arrastrar archivos
            const dropzoneArea = document.getElementById('areaDropzone');

            ['dragover', 'dragenter'].forEach(evt =>
                dropzoneArea.addEventListener(evt, e => {
                    e.preventDefault();
                    dropzoneArea.classList.add('dragover');
                })
            );

            ['dragleave', 'drop'].forEach(evt =>
                dropzoneArea.addEventListener(evt, e => {
                    e.preventDefault();
                    dropzoneArea.classList.remove('dragover');
                })
            );

            dropzoneArea.addEventListener('drop', e => {
                e.preventDefault();
                procesarArchivos(e.dataTransfer.files);
            });

            fileInput.addEventListener('change', () => {
                procesarArchivos(fileInput.files);
                fileInput.value = '';
            });

            // Función reutilizable para validar y subir archivos
            function procesarArchivos(archivos) {
                const anio = anioSelect.value;
                const maxTamano = 2 * 1024 * 1024;
                const maxArchivosPorAnio = 5;
                const extensionesPermitidas = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];

                if (!anio) {
                    Swal.fire('Selecciona un año antes de subir archivos');
                    return;
                }

                const archivosCargados = document.querySelectorAll('#medios_cargados tr').length;
                if (archivosCargados + archivos.length > maxArchivosPorAnio) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Límite alcanzado',
                        text: `No puedes subir más de ${maxArchivosPorAnio} archivos por año.`
                    });
                    return;
                }

                for (let archivo of archivos) {
                    const ext = archivo.name.split('.').pop().toLowerCase();

                    if (!extensionesPermitidas.includes(ext)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Archivo no permitido',
                            text: 'Solo se permiten archivos .pdf, .doc, .docx, .xls y .xlsx'
                        });
                        continue;
                    }

                    if (archivo.size > maxTamano) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Archivo muy grande',
                            text: 'El archivo no puede superar los 2 MB.'
                        });
                        continue;
                    }

                    subirArchivo(archivo, idProducto, anio);
                }
            }


            // Evento: carga de archivos
            fileInput.addEventListener('change', () => {
                const archivos = fileInput.files;
                const anio = anioSelect.value;
                const maxTamano = 2 * 1024 * 1024;
                const maxArchivosPorAnio = 5;
                const extensionesPermitidas = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];

                if (!anio) {
                    Swal.fire('Selecciona un año antes de subir archivos');
                    fileInput.value = '';
                    return;
                }

                const archivosCargados = document.querySelectorAll('#medios_cargados tr').length;
                if (archivosCargados + archivos.length > maxArchivosPorAnio) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Límite alcanzado',
                        text: `No puedes subir más de ${maxArchivosPorAnio} archivos por año.`
                    });
                    fileInput.value = '';
                    return;
                }

                for (let archivo of archivos) {
                    const ext = archivo.name.split('.').pop().toLowerCase();

                    if (!extensionesPermitidas.includes(ext)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Archivo no permitido',
                            text: 'Solo se permiten archivos .pdf, .doc, .docx, .xls y .xlsx'
                        });
                        continue;
                    }

                    if (archivo.size > maxTamano) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Archivo muy grande',
                            text: 'El archivo no puede superar los 2 MB.'
                        });
                        continue;
                    }

                    subirArchivo(archivo, idProducto, anio);
                }

                fileInput.value = '';
            });

            // Calcular valores indicados en inputs
            allYears.forEach(anio => {
                const progInput = document.querySelector(`input[name="programado_${anio}"]`);
                const realInput = document.querySelector(`input[name="realizado_${anio}"]`);
                const valorInput = document.querySelector(`input[name="valor_indicado_${anio}"]`);
                const valorHidden = document.querySelector(`input[name="valor_indicado_decimal_${anio}"]`);

                if (progInput && realInput && valorInput && valorHidden) {
                    const calcular = () => {
                        const programado = parseFloat(progInput.value.replace(',', '.'));
                        const realizado = parseFloat(realInput.value.replace(',', '.'));

                        // Reset valores visuales
                        realInput.classList.remove('is-invalid');

                        // Validación básica de números válidos
                        if (!isNaN(programado) && programado > 0 && !isNaN(realizado)) {
                            // Validación adicional: realizado no puede ser mayor que programado


                            // Cálculo del porcentaje
                            const valorDecimal = realizado / programado;
                            valorInput.value = (valorDecimal * 100).toFixed(2) + ' %';
                            valorHidden.value = valorDecimal.toFixed(4);
                        } else {
                            // Si hay valores inválidos, limpiar
                            valorInput.value = '';
                            valorHidden.value = '';
                        }
                    };

                    // Asignar eventos
                    progInput.addEventListener('input', calcular);
                    realInput.addEventListener('input', calcular);
                }
            });


            // Validación en vivo para actualizar pestañas con campos incompletos
            document.querySelectorAll('[required]').forEach(input => {
                input.addEventListener('input', marcarPestañasIncompletas);
            });
        });

        function confirmarEliminarPrograma(index, idPrograma) {
            const idProducto = {{ $producto->idProducto }};
            const anioSeleccionado = document.getElementById('anio-medios').value;

            Swal.fire({
                title: '¿Deseas eliminar este programa presupuestario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/productos/${idProducto}/programa/${idPrograma}/${anioSeleccionado}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Eliminando...',
                                allowOutsideClick: false,
                                didOpen: () => Swal.showLoading()
                            });
                        },
                        success: function (response) {
                            if (response.result === 'ok') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Eliminado',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });

                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        },
                        error: function (xhr) {
                            Swal.fire('Error', 'No se pudo eliminar el programa.', 'error');
                        }
                    });
                }
            });
        }

        function inicializarContadorCaracteres(inputId, contadorId, max = 255) {
            const input = document.getElementById(inputId);
            const contador = document.getElementById(contadorId);

            if (input && contador) {
                // Evento en tiempo real
                input.addEventListener('input', function () {
                    let val = input.value;
                    if (val.length > max) input.value = val = val.substring(0, max);
                    contador.textContent = `${val.length} / ${max} caracteres`;
                });

                // Inicializa si ya hay texto cargado
                contador.textContent = `${input.value.length} / ${max} caracteres`;
            }
        }
        function mostrarCargaGlobal(mensaje = 'Procesando...') {
            $.blockUI({
                message: `<h4>${mensaje}</h4>`,
                css: {
                    border: '3px solid gray',
                    backgroundColor: '#444',
                    WebkitBorderRadius: '10px',
                    MozBorderRadius: '10px',
                    borderRadius: '10px',
                    width: '15%',
                    color: 'white',
                    padding: '15px',
                    textAlign: 'center',
                    fontSize: '16px'
                },
                overlayCSS: {
                    backgroundColor: '#000',
                    opacity: 0.5,
                    cursor: 'wait'
                }
            });
        }
        function ocultarCargaGlobal() {
            $.unblockUI();
        }


    </script>
@endsection