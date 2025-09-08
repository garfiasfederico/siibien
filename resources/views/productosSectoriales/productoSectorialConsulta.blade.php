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

        #btnAlmacenarG:disabled {
            background-color: #cccccc !important;
            border-color: #cccccc !important;
            color: #666666 !important;
            cursor: not-allowed;
            opacity: 1;
        }

        .select-readonly {
            background: #f0f0f8 !important;
            color: #444 !important;
            box-shadow: 0 0 0 2px #eee inset;
            pointer-events: none;
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
                                            <td style="vertical-align: middle">{{ $producto->producto }}</td>
                                            <td style="text-align: center; vertical-align: middle">
                                                {{ $producto->dependenciaSiglas ?? 'Sin responsable' }}
                                            </td>
                                            <td style="vertical-align: middle; text-align:center">
                                                @if ($producto->estado_producto !== 'revision')
                                                    <button class="btn btn-warning" id="btnRevision{{ $producto->idProducto }}">
                                                        <i class="fas fa-paper-plane"></i> Producto en edición
                                                    </button>
                                                @else
                                                    <button class="btn btn-secondary" disabled>
                                                        <i class="fas fa-paper-plane"></i> Producto en revisión
                                                    </button>
                                                @endif
                                            </td>


                                            <td style="vertical-align: middle; text-align: left;">
                                                <div class="botones-alineados" id="contenedorBotones{{ $producto->idProducto }}">
                                                    {{-- @if ($producto->estado_producto !== 'revision')
                                                    <button class="btn btn-sm btn-primary btn-ver-producto"
                                                        id="btnEditar{{ $producto->idProducto }}"
                                                        data-id="{{ $producto->idProducto }}"
                                                        data-nombre="{{ $producto->producto }}"
                                                        data-responsable="{{ $producto->dependenciaNombre }}"
                                                        data-ppa="{{ $producto->idPPA }}" data-bs="{{ $producto->idBS }}"
                                                        data-objetivo="{{ $producto->idObjetivoPED }}" data-sector={{
                                                        $producto->idSector }} title="Datos Generales">
                                                        <i class="fas fa-list"></i> Datos Generales
                                                    </button>

                                                    <a href="{{ route('productos.seguimiento', ['idProducto' => $producto->idProducto]) }}"
                                                        class="btn btn-sm btn-success"
                                                        id="btnSeguimiento{{ $producto->idProducto }}" title="Seguimiento">
                                                        <i class="fas fa-tachometer-alt"></i> Seguimiento
                                                    </a>
                                                    @endif --}}

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

        function RevisionProducto(idProducto) {
            Swal.fire({
                title: '¿Está seguro?',
                text: `La información del producto [${idProducto}] será enviada a revisión. No podrá ser modificada mientras la ITE realice la revisión.`,
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
                        url: '/productos/enviar-revision',
                        data: {
                            idProducto: idProducto,
                            _token: $("input[name='_token']").val()
                        },
                        dataType: 'json',
                        beforeSend: function () {
                            $('#btnRevision' + idProducto).html(
                                '<i class="fas fa-spinner fa-spin"></i> Enviando...');
                        },
                        success: function (response) {
                            if (response.result === 'ok') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Enviado',
                                    text: response.message ||
                                        'El producto fue enviado a revisión correctamente.'
                                });

                                // Ocultar botones de edición si existen
                                $('#btnEditar' + idProducto).hide();
                                $('#btnSeguimiento' + idProducto).hide();

                                // Reemplazar botón por uno deshabilitado indicando que está en revisión
                                $('#btnRevision' + idProducto)
                                    .removeClass('btn-warning')
                                    .addClass('btn-secondary')
                                    .prop('disabled', true)
                                    .html('<i class="fas fa-paper-plane"></i> Producto en revisión');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'No se pudo enviar a revisión.'
                                });

                                $('#btnRevision' + idProducto).html(
                                    '<i class="fas fa-paper-plane"></i> Enviar a revisión');
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error del servidor',
                                text: 'Ocurrió un problema al enviar el producto a revisión.'
                            });

                            $('#btnRevision' + idProducto).html(
                                '<i class="fas fa-paper-plane"></i> Enviar a revisión');
                        }
                    });
                }
            });
        }

    </script>
@endsection