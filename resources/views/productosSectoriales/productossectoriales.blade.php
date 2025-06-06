@extends('layouts.administrador')

@section('encabezado')
    Productos Sectoriales / Listado de Productos
@endsection

@section('styles')
    <style>
        /* Encabezados de tabla con estilos específicos */
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

        /* Estilo para la tabla y celdas */
        table tr td {
            padding: 5px;
            border: solid 2px white;
        }

        /* Estilos para campos de texto y select */
        input[type=text],
        select {
            height: 35px;
            color: black;
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

        /* Estilo para el área de texto */
        textarea {
            color: black;
        }

        /* Estilo para los botones dentro de las filas */
        .btn-actions {
            margin: 5px;
            width: 150px;
            text-align: left;
        }

        /* Estilos personalizados para el modal */
        .modal-header-custom {
            background-color: #681b2e;
            color: white;
        }

        .modal-body-padding {
            padding: 30px;
        }

        .content-padding {
            padding: 20px;
        }

        .header-dark {
            background-color: rgb(157, 36, 73);
            color: white;
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

        /* Estilos de la tabla */
        /* Tabla de Bienes y Servicios */
        .table-bs {
            width: 100%;
            border-collapse: collapse;
        }

        /* Encabezados */
        .th-bs,
        .th-bs-id,
        .th-bs-opciones {
            border: solid 1px gray;
            text-align: center;
            padding: 5px;
        }

        .th-bs-id {
            width: 10%;
        }

        .th-bs-opciones {
            width: 15%;
        }

        /* Cuerpo de la tabla */
        .tbody-bs {
            color: gray;
        }

        /* Celdas */
        .td-bs {
            border: solid 1px gray;
            padding: 5px;
        }

        /* Centrado de texto */
        .text-center {
            text-align: center;
        }

        .botones-alineados {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            /* fuerza todos a ocupar el mismo ancho */
            width: 200px;
            /* el ancho deseado */
            margin: 0 auto;
            gap: 10px;
        }

        .botones-alineados .btn {
            width: 100%;
            text-align: center;
        }
    </style>
@endsection


@section('content')
    @csrf
    <div class="row">
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between "
                    style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Productos Registrados</h6>
                </div>
                <div class="card-body" id="indicadorContent">
                    <!-- Tabla de productos -->

                    <div class="table-responsive">

                        @if ($productos->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="alert alert-info mb-0">
                                        No existen productos asociados a la dependencia, favor de informar al Administrador.
                                    </div>
                                </td>
                            </tr>
                        @else
                            <table class="table table-bordered table-striped" id="dataTableItar" width="100%" cellspacing="0"
                                style="color: black!important">
                                <thead style="background-color: #919090;color:white;">
                                    <tr style="text-align: center">
                                        <th>Id</th>
                                        <th>Nombre del Producto</th>
                                        <th>Responsable</th>
                                        <th>Estatus</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($productos as $producto)
                                        <tr>
                                            <td style="vertical-align: middle">{{ $producto->idProducto }}</td>
                                            <td style="vertical-align: middle">{{ $producto->nombre_producto }}</td>
                                            <td style="text-align: center; vertical-align: middle">
                                                {{ $producto->dependenciaSiglas ?? 'Sin responsable' }}
                                            </td>
                                            <!--Pendiente-->
                                            <td style="vertical-align: middle; text-align:center">
                                                <!--<button class="btn btn-warning" id="btnRevision{{ $producto->idProducto }}"
                                                    onclick="RevisionProducto({{ $producto->idProducto }})">
                                                    <i class="fas fa-paper-plane"></i> Enviar a revisión
                                                </button>-->
                                            </td>

                                            <td style="vertical-align: middle; text-align: left;">
                                                <div class="botones-alineados" id="contenedorBotones{{ $producto->idProducto }}">
                                                    @if ($producto->estado !== 'revision')
                                                        <button class="btn btn-sm btn-primary btn-ver-producto"
                                                            id="btnEditar{{ $producto->idProducto }}"
                                                            data-id="{{ $producto->idProducto }}"
                                                            data-nombre="{{ $producto->nombre_producto }}"
                                                            data-responsable="{{ $producto->dependenciaNombre }}"
                                                            data-ppa="{{ $producto->idPPA }}" data-bs="{{ $producto->idBS }}"
                                                            data-objetivo="{{ $producto->idObjetivoPED }}" title="Datos Generales">
                                                            <i class="fas fa-list"></i> Datos Generales
                                                        </button>

                                                        <a href="{{ route('productos.seguimiento', ['idProducto' => $producto->idProducto]) }}"
                                                            class="btn btn-sm btn-success"
                                                            id="btnSeguimiento{{ $producto->idProducto }}" title="Seguimiento">
                                                            <i class="fas fa-tachometer-alt"></i> Seguimiento
                                                        </a>
                                                    @endif

                                                    <a href="{{ route('productos.detalleReporte', ['idProducto' => $producto->idProducto]) }}"
                                                        class="btn btn-sm btn-info" title="Reportes">
                                                        <i class="fas fa-chart-line"></i> Reportes
                                                    </a>
                                                </div>
                                            </td>





                                        </tr>
                                    @endforeach
                        @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Datos Generales (común para todos los productos) -->
    @include('productosSectoriales.modal_datos_generales', ['ejes' => $ejes])
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // Inicializar DataTable
            var table = $('#dataTableItar').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 50],
                order: [
                    [0, 'asc']
                ]
            });

            // Cargar datos al hacer clic en "Ver Datos Generales"
            $(document).on('click', '.btn-ver-producto', function () {
                limpiarModal(); // Limpia TODO antes de cargar nuevo producto
                const idProducto = $(this).data('id');

                if (idProducto) {
                    abrirModalProducto(idProducto); // Carga datos desde el servidor
                } else {
                    $('#modalGenerales').modal('show'); // Modal limpio para nuevo producto

                }
            });


            // Limpiar validación al cerrar modal
            $('#modalGenerales').on('hidden.bs.modal', function () {
                $('#formDatosGenerales').removeClass('was-validated');

            });
        });
        function actualizarContadorMedioIndicador() {
            const max = 255;
            const currentLength = $('#medioIndicador').val().length;

            $('#contadorCaracteres').text(`${currentLength} / ${max} caracteres`);

            if (currentLength >= max) {
                $('#medioIndicador').val($('#medioIndicador').val().substring(0, max));
            }
        }
        // Función para abrir el modal con los datos de un producto
        function abrirModalProducto(idProducto) {
            $.ajax({
                url: '/productos/' + idProducto + '/datos-generales',
                type: 'GET',
                success: function (data) {
                    const temas = JSON.parse(document.getElementById('temas-json').textContent);
                    const objetivos = JSON.parse(document.getElementById('objetivos-json').textContent);
                    const estrategias = JSON.parse(document.getElementById('estrategias-json').textContent);
                    const lineasAccion = JSON.parse(document.getElementById('lineasaccionped-json').textContent);
                    const estrategiasSector = JSON.parse(document.getElementById('estrategiassector-json').textContent);
                    // Mostrar Producto +ID + nombre del producto 
                    $('#info-producto').text(`Producto: ${data.idProducto} - ${data.nombreProducto}`);

                    // Limpiar dinámicos
                    $('#body-bienes').empty();
                    $('#body-ppas').empty();

                    // Datos básicos
                    $('#nombreProducto').val(data.nombreProducto);
                    $('#idProducto').val(data.idProducto);

                    // Eje
                    $('#eje').val(data.idEjePED);

                    // Tema
                    filtrarOpciones({
                        datos: temas,
                        idPadre: data.idEjePED,
                        campoFiltro: 'idEjePED',
                        selectDestino: document.getElementById('tema'),
                        campoValue: 'idTemaPED',
                        campoLabel: t => `${t.temaPEDClave} ${t.temaPEDDescripcion}`,
                        valorPreseleccionado: data.idTemaPED
                    });

                    // Objetivo PED
                    filtrarOpciones({
                        datos: objetivos,
                        idPadre: data.idTemaPED,
                        campoFiltro: 'idTemaPED',
                        selectDestino: document.getElementById('objetivo_ped'),
                        campoValue: 'idObjetivoPED',
                        campoLabel: o => `${o.objetivoPEDClave} ${o.objetivoPEDDescripcion}`,
                        valorPreseleccionado: data.idObjetivoPED
                    });

                    // Estrategia PED
                    filtrarOpciones({
                        datos: estrategias,
                        idPadre: data.idObjetivoPED,
                        campoFiltro: 'idObjetivoPED',
                        selectDestino: document.getElementById('estrategia'),
                        campoValue: 'idEstrategiaPED',
                        campoLabel: e => `${e.estrategiaPEDClave} ${e.estrategiaPEDDescripcion}`,
                        valorPreseleccionado: data.idEstrategiaPED
                    });

                    // Línea de acción
                    filtrarOpciones({
                        datos: lineasAccion,
                        idPadre: data.idEstrategiaPED,
                        campoFiltro: 'idEstrategiaPED',
                        selectDestino: document.getElementById('lineasAccionAlineacion'),
                        campoValue: 'idLAPED',
                        campoLabel: l => `${l.laPEDClave} ${l.laPEDDescripcion}`,
                        valorPreseleccionado: data.idLAPED
                    });

                    // Objetivo y estrategia del sector
                    $('#idObjetivo').val(data.idObjetivo);
                    filtrarOpciones({
                        datos: estrategiasSector,
                        idPadre: data.idObjetivo,
                        campoFiltro: 'idObjetivo',
                        selectDestino: document.getElementById('idEstrategia'),
                        campoValue: 'idEstrategia',
                        campoLabel: e => `${e.claveEstrategia} ${e.estrategia}`,
                        valorPreseleccionado: data.idEstrategia
                    });

                    // PPAs (cargar múltiples)
                    $('#nombrePPA').val(data.idPPA);
                    const ppasSeleccionadas = data.idPPA ? data.idPPA.split(',') : [];

                    ppasSeleccionadas.forEach(function (ppaId) {
                        const nombre = $('#ppa option[value="' + ppaId + '"]').text();
                        if (nombre) {
                            $('#body-ppas').append(`
                                                                                                        <tr id="row-ppa-${ppaId}">
                                                                                                            <td style="text-align:center;">${ppaId}</td>
                                                                                                            <td>${nombre}</td>
                                                                                                            <td style="text-align:center;">
                                                                                                                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarPPA('${ppaId}')">
                                                                                                                    <i class="fas fa-trash-alt"></i> Quitar
                                                                                                                </button>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    `);
                        }
                    }); actualizarBienesSegunPPA();


                    // Bienes y servicios
                    const bienesServicios = data.idBS ? data.idBS.split(',') : [];
                    bienesServicios.forEach(function (bienServicioId) {
                        const bienServicioNombre = $('#bienServicio option[value="' + bienServicioId + '"]').text();
                        if (bienServicioNombre) {
                            $('#body-bienes').append(`
                                                                                                        <tr id="row-bien${bienServicioId}" class="bien">
                                                                                                            <td style="text-align:center;border:solid 1px gray">${bienServicioId}</td>
                                                                                                            <td style="border:solid 1px gray">${bienServicioNombre}</td>
                                                                                                            <td style="text-align:center;border:solid 1px gray">
                                                                                                                <button type="button" class="btn btn-danger btn-sm" onclick="removeBienServicio(${bienServicioId})">
                                                                                                                    <i class="fas fa-trash-alt"></i> Quitar
                                                                                                                </button>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    `);
                        }
                    });

                    $('#bienesServicios').val(bienesServicios.join(','));

                    // Indicador
                    $('#tipoIndicador').val(data.tipoIndicador);
                    $('#calculoIndicador').val(data.calculoIndicador);
                    $('#frecuenciaMedicion').val(data.frecuencia_medicion);
                    $('#sentidoEsperado').val(data.sentido_esperado);
                    $('#unidadIndicador').val(data.unidadIndicador);
                    $('#unidadMedidaIndicador').val(data.unidad_medida_indicador);
                    $('#medioIndicador').val(data.medioIndicador)
                    actualizarContadorMedioIndicador();
                    $('#medioIndicador').on('input', actualizarContadorMedioIndicador);


                    // Mostrar modal
                    $('#modalGenerales').modal('show');

                    $('#modalGenerales .nav-tabs .nav-item:first-child .nav-link').tab('show');

                    // Activar siempre la primera pestaña
                    $('#modalGenerales .nav-tabs .nav-link').removeClass('active');
                    $('#modalGenerales .tab-pane').removeClass('active show');
                    $('#modalGenerales .nav-tabs .nav-link:first').addClass('active');
                    $('#modalGenerales .tab-pane:first').addClass('active show');

                },
                error: function () {
                    Swal.fire('Error', 'No se pudieron cargar los datos del producto.', 'error');
                }
            });
        }




        // Función para limpiar el modal antes de abrirlo para la creación de un nuevo producto
        function limpiarModal() {
            const form = $('#formDatosGenerales');

            // Resetear el formulario completo
            form[0].reset();

            // Quitar validaciones visuales Bootstrap
            form.removeClass('was-validated');
            form.find('select, textarea, input').removeClass('is-valid is-invalid');

            // Limpiar selects manualmente
            $('#eje, #tema, #objetivo_ped, #estrategia, #lineasAccionAlineacion, #idObjetivo, #idEstrategia, #nombrePPA, #bienServicio').val('');

            // Campo oculto
            $('#idProducto').val('');
            $('#bienesServicios').val('');

            // Limpiar tabla dinámica
            $('#body-bienes').empty();
            $('#emptyBienes').show();

            // Limpiar notificaciones en pestañas (asteriscos rojos)
            $('.nav-item.nav-link').each(function () {
                $(this).removeClass('text-danger');
                const span = $(this).find('span');
                span.text('');
                span.removeAttr('title').css('color', '');
            });
            //Contraer 
            // Contraer todas las secciones al abrir un nuevo modal
            const secciones = [
                { body: 'body-alineacion', icon: 'chev-alineacion' },
                { body: 'body-sector', icon: 'chev-sector' },
                { body: 'body-programa', icon: 'chev-programa' },
                { body: 'body-indicador', icon: 'chev-indicador' }
            ];

            secciones.forEach(({ body, icon }) => {
                const elBody = document.getElementById(body);
                const elIcon = document.getElementById(icon);

                if (elBody && elIcon) {
                    elBody.style.display = 'none'; // Contraer la sección
                    elIcon.classList.remove('fa-chevron-up');
                    elIcon.classList.add('fa-chevron-down');
                }
            });

        }


        // Guardar con validación AJAX
        function guardarProductoSectorialAjax() {
            marcarPestañasIncompletas();

            // Eliminar la validación del select temporal antes de validar el formulario
            $('#bienServicio').prop('required', false).removeClass('is-invalid is-valid');

            const form = $('#formDatosGenerales')[0];
            form.classList.add('was-validated');

            if (!form.checkValidity()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Formulario incompleto',
                    text: 'Por favor, complete todos los campos requeridos antes de proceder con el guardado.'
                });

                $('input, select').each(function () {
                    if (!this.checkValidity()) {
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid').addClass('is-valid');
                    }
                });

                return;
            }


            //Validación: al menos un PPA agregado
            const ppasSeleccionados = $('#nombrePPA').val();
            if (!ppasSeleccionados || ppasSeleccionados.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Falta seleccionar un PPA',
                    text: 'Debe agregar al menos un Programa, Proyecto o Acción antes de proceder con el guardado.'
                });
                return;
            }

            // Validación: al menos un Bien o Servicio agregado
            const bienesServiciosSeleccionados = [];
            $('#body-bienes tr').each(function () {
                const id = $(this).find('td').eq(0).text().trim();
                if (id) bienesServiciosSeleccionados.push(id);
            });

            if (bienesServiciosSeleccionados.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Falta seleccionar Bien o Servicio',
                    text: 'Debe agregar al menos un Bien o Servicio antes de guardar.'
                });
                return;
            }

            $('#bienesServicios').val(bienesServiciosSeleccionados.join(','));



            // Enviar datos
            const formData = $('#formDatosGenerales').serialize();

            $.ajax({
                type: 'POST',
                url: '{{ route("productossectoriales.store") }}',
                data: formData,
                dataType: 'json',
                beforeSend: function () {
                    $('#btnAlmacenarG').prop('disabled', true).text('Guardando...');
                },
                success: function (response) {
                    if (response.result === 'ok') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Actualización de Datos Generales',
                            text: response.message
                        }).then(() => {
                            $('#modalGenerales').modal('hide');
                            $('#formDatosGenerales')[0].reset();
                            $('#formDatosGenerales').removeClass('was-validated');
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Formulario incompleto',
                            text: response.message || 'Debe tener seleccionado un bien o servicio antes de guardar.'
                        });
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error del servidor',
                        text: 'Ocurrió un error inesperado. Intenta más tarde.'
                    });
                },
                complete: function () {
                    $('#btnAlmacenarG').prop('disabled', false).text('Almacenar');
                }
            });
        }



        // Función para agregar bienes o servicios a la tabla
        function agregarBienServicio(event) {
            event.preventDefault();

            const bienServicioId = $('#bienServicio').val();
            const bienServicioNombre = $('#bienServicio option:selected').text();

            if (!bienServicioId) {
                Swal.fire('Falta selección', 'Por favor, seleccione un bien o servicio.', 'warning');
                return;
            }

            if ($('#row-bien' + bienServicioId).length > 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'Ya está agregado',
                    text: 'Este bien o servicio ya se encuentra en la lista.'
                });
                return;
            }

            const fila = $(`
                                                                                                                <tr id="row-bien${bienServicioId}" class="bien">
                                                                                                                    <td style="text-align:center;border:solid 1px gray">${bienServicioId}</td>
                                                                                                                    <td style="border:solid 1px gray">${bienServicioNombre}</td>
                                                                                                                    <td style="text-align:center;border:solid 1px gray">
                                                                                                                        <button type="button" class="btn btn-danger btn-sm btn-quitar-bien" title="Quitar bien">
                                                                                                                            <i class="fas fa-trash-alt"></i> Quitar
                                                                                                                        </button>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            `);

            fila.find('.btn-quitar-bien').on('click', function () {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: '¿Desea eliminar este bien o servicio de la lista?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        fila.remove();

                        const bienesServicios = [];
                        $('#body-bienes tr').each(function () {
                            const id = $(this).find('td').eq(0).text().trim();
                            if (id) bienesServicios.push(id);
                        });

                        $('#bienesServicios').val(bienesServicios.join(','));

                        if (bienesServicios.length === 0) {
                            $('#emptyBienes').show();
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: 'El bien o servicio fue eliminado de la lista.'
                        });
                    }
                });
            });

            $('#body-bienes').append(fila);

            const bienesServicios = [];
            $('#body-bienes tr').each(function () {
                const id = $(this).find('td').eq(0).text().trim();
                if (id) bienesServicios.push(id);
            });

            $('#bienesServicios').val(bienesServicios.join(','));
            $('#emptyBienes').hide();
            $('#bienServicio').val('');
            $('#bienServicio').removeClass('is-invalid is-valid');
        }



        // Función para eliminar un bien o servicio de la lista
        function removeBienServicio(bienId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Desea eliminar este bien o servicio de la tabla?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const productoId = $('#idProducto').val();

                    $.ajax({
                        url: `/productos/${productoId}/eliminar-bien/${bienId}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.success) {
                                // Desvanecer visualmente la fila eliminada
                                $('#row-bien' + bienId).fadeOut(600, function () {
                                    $(this).remove();

                                    Swal.fire(
                                        'Eliminado',
                                        'El bien o servicio ha sido eliminado.',
                                        'success'
                                    ).then(() => {
                                        //Limpiar validaciones anteriores
                                        $('#formDatosGenerales').removeClass('was-validated');
                                        $('#formDatosGenerales input, #formDatosGenerales select').removeClass('is-invalid');

                                        // Recargar los datos actualizados del producto
                                        abrirModalProducto(productoId);
                                    });
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    response.message || 'No se pudo eliminar el bien.',
                                    'error'
                                );
                            }
                        },
                        error: function () {
                            Swal.fire(
                                'Error',
                                'Error del servidor al intentar eliminar.',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        //Agregar Multiples PPAS
        function agregarPPA(event) {
            event.preventDefault();

            const selectPPA = document.getElementById('ppa');
            const idPPA = selectPPA.value;
            const nombrePPA = selectPPA.options[selectPPA.selectedIndex]?.text || '';
            const inputPPAs = document.getElementById('nombrePPA');
            const tablaPPAs = document.getElementById('body-ppas');

            if (!idPPA) {
                Swal.fire('Falta selección', 'Por favor, seleccione un PPA válido.', 'warning');
                return;
            }

            const ppasExistentes = inputPPAs.value ? inputPPAs.value.split(',') : [];

            if (ppasExistentes.includes(idPPA)) {
                Swal.fire({
                    icon: 'info',
                    title: 'Ya está agregado',
                    text: 'Este PPA ya se encuentra en la lista.'
                });
                return;
            }

            const fila = document.createElement('tr');
            fila.id = `row-ppa-${idPPA}`;
            fila.innerHTML = `
                                                                                <td style="text-align:center;border:solid 1px gray;">${idPPA}</td>
                                                                                <td style="border:solid 1px gray;">${nombrePPA}</td>
                                                                                <td style="text-align:center;border:solid 1px gray;">
                                                                                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarPPA('${idPPA}')">
                                                                                        <i class="fas fa-trash-alt"></i> Quitar
                                                                                    </button>
                                                                                </td>
                                                                            `;

            tablaPPAs.appendChild(fila);

            ppasExistentes.push(idPPA);
            inputPPAs.value = ppasExistentes.join(',');
            actualizarBienesSegunPPA();

            // Limpiar selección y feedback visual
            $('#ppa').val('');
            $('#ppa').removeClass('is-invalid is-valid');
        }
        // Función para eliminar un PPA de la lista
        function eliminarPPA(idPPA) {
            const productoId = $('#idProducto').val();

            // Detectar bienes relacionados al PPA (en la vista)
            const bienesRelacionados = [];
            $('#body-bienes tr').each(function () {
                const bienId = $(this).find('td').eq(0).text().trim();
                const bienOption = $(`#bienServicio option[value="${bienId}"]`);
                const ia_id = bienOption.data('ia-id');

                if (parseInt(ia_id) === parseInt(idPPA)) {
                    bienesRelacionados.push(bienId);
                }
            });

            // Mensaje condicional
            let mensaje = '¿Está seguro de que desea eliminar este PPA? Si tiene bienes o servicios relacionados, también serán eliminados.';
            if (bienesRelacionados.length > 0) {
                mensaje = `Este PPA tiene ${bienesRelacionados.length} bien(es) o servicio(s) asociados. También se eliminarán. ¿Deseas continuar?`;
            }

            // Alerta desde JavaScript
            Swal.fire({
                title: 'Confirmación',
                text: mensaje,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar AJAX directamente sin que el backend decida si confirmar
                    $.ajax({
                        url: `/productos/${productoId}/eliminar-ppa/${idPPA}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.success) {
                                // Quitar fila de PPA
                                $(`#row-ppa-${idPPA}`).remove();

                                // Quitar bienes eliminados
                                if (response.bienesEliminados && Array.isArray(response.bienesEliminados)) {
                                    response.bienesEliminados.forEach(bienId => {
                                        $(`#row-bien${bienId}`).remove();
                                    });

                                    // Actualizar campo oculto
                                    const nuevosBienes = $('#bienesServicios').val()
                                        .split(',')
                                        .filter(id => !response.bienesEliminados.includes(id));
                                    $('#bienesServicios').val(nuevosBienes.join(','));
                                }

                                // Actualizar campo oculto de PPAs
                                const ppasActualizadas = $('#nombrePPA').val()
                                    .split(',')
                                    .filter(id => id !== idPPA);
                                $('#nombrePPA').val(ppasActualizadas.join(','));

                                Swal.fire('Eliminado', response.message, 'success');
                                actualizarBienesSegunPPA();
                            } else {
                                Swal.fire('Error', response.message || 'No se pudo eliminar el PPA.', 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error', 'Error del servidor al intentar eliminar el PPA.', 'error');
                        }
                    });
                }
            });
        }

        //Botón enviar a revisión
        /*function RevisionProducto(idProducto) {
            Swal.fire({
                title: '¿Está seguro?',
                text: `La información del producto [${idProducto}] será enviada a revisión. No podrá ser modificado mientras la ITE realice la revisión.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, enviar a revisión',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('productos.enviarRevision') }}",
                        data: {
                            idProducto: idProducto,
                            _token: $("input[name='_token']").val()
                        },
                        dataType: 'json',
                        beforeSend: function () {
                            $('#btnRevision' + idProducto).html('<i class="fas fa-spinner fa-spin"></i> Enviando...');
                        },
                        success: function (response) {
                            if (response.result === 'ok') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Enviado',
                                    text: response.message || 'El producto fue enviado a revisión correctamente.'
                                });

                                // Ocultar botones de edición
                                $('#btnEditar' + idProducto).remove();
                                $('#btnSeguimiento' + idProducto).remove();

                                // Cambiar el botón de envío a deshabilitado
                                $('#btnRevision' + idProducto)
                                    .removeClass('btn-warning')
                                    .addClass('btn-secondary')
                                    .prop('disabled', true)
                                    .html('<i class="fas fa-paper-plane"></i> Producto En revisión');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'No se pudo enviar a revisión.'
                                });

                                $('#btnRevision' + idProducto).html('<i class="fas fa-paper-plane"></i> Enviar a revisión');
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error del servidor',
                                text: 'Ocurrió un problema al enviar el producto a revisión.'
                            });

                            $('#btnRevision' + idProducto).html('<i class="fas fa-paper-plane"></i> Enviar a revisión');
                        }
                    });
                }
            });
        }*/





    </script>

@endsection