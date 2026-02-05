@php
    use App\Models\SeguimientoMeta;
@endphp
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
                <div style="text-align:right;padding-right: 10px;">
                    <hr />
                    <a style="cursor: pointer"><b>Simbología del semáforo de desempeño.</b></a>
                    <div style="text-align:right;width:100%;">
                        <table align="right">
                            <tr>
                                <td style="padding: 5px;border: dashed 1px gray;text-align:center">
                                    <img style="width:30px;" src="{{asset("/images/productos/sobresaliente.svg")}}">
                                </td>
                                <td style="padding: 5px;border: dashed 1px gray">Sobresaliente</td>                                       
                                <td style="padding: 5px;border: dashed 1px gray;text-align:center">        
                                    <img style="width:30px;" src="{{asset("/images/productos/satisfactorio.svg")}}"></td>
                                <td style="padding: 5px;border: dashed 1px gray">Satisfactorio</td>
                                <td style="padding: 5px;border: dashed 1px gray;text-align:center">                                            
                                    <img style="width:30px;" src="{{asset("/images/productos/regular.svg")}}">
                                </td>
                                <td style="padding: 5px;border: dashed 1px gray">Regular</td>
                                <td style="padding: 5px;border: dashed 1px gray;text-align:center">
                                    <img style="width:30px;" src="{{asset("/images/productos/no_satisfactorio.svg")}}">                                            
                                </td>
                                <td style="padding: 5px;border: dashed 1px gray">No Satisfactorio</td>
                                <td style="padding: 5px;border: dashed 1px gray;text-align:center">
                                    <img style="width:30px;" src="{{asset("/images/productos/no_atendido.svg")}}">                                            
                                </td>
                                <td style="padding: 5px;border: dashed 1px gray">No Atendido</td>
                                <td style="padding: 5px;border: dashed 1px gray;text-align:center">
                                    <img style="width:30px;" src="{{asset("/images/productos/no_aplica.svg")}}">                                            
                                </td>
                                <td style="padding: 5px;border: dashed 1px gray">No Aplica</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-body" id="indicadorContent">
                    <div style="text-align: left; padding:10px;">
                        <label for="anio" style="margin-right: 10px; font-weight: bold;">
                            Año:
                        </label>

                        <select id="anio" class="form-control d-inline-block" style="width: 120px; margin-right: 15px;">
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                        </select>

                        <a href="#" class="btn btn-success" onclick="verAcusePS()">
                            <i class="fas fa-file-pdf"></i> Descargar Acuse de Captura
                        </a>


                    </div>

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
                            <table class="table table-bordered table-striped" id="dataTableItar" width="100%"
                                cellspacing="0" style="color: black!important">
                                <thead style="background-color: #919090;color:white;">
                                    <tr style="text-align: center">
                                        <th>Id</th>
                                        <th>Nombre del Producto</th>
                                        <th>Responsable</th>
                                        <th>Desempeño 2023</th>
                                        <th>Desempeño 2024</th>
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
                                            <td style="vertical-align: middle;text-align:center">
                                                @php
                                                    $meta2023 = SeguimientoMeta::where("idProducto",$producto->idProducto)->where("año",2023)->first();
                                                    if($meta2023 != null):                                                                                                       
                                                        if($meta2023->valor_indicador <= 0 )
                                                            $img2023 = "no_atendido.png";
                                                        elseif ($meta2023->valor_indicador >= .1 && $meta2023->valor_indicador <= .60)
                                                            $img2023 = "no_satisfactorio.png";
                                                        elseif ($meta2023->valor_indicador >= .61 && $meta2023->valor_indicador <= .79)
                                                            $img2023 = "regular.png";
                                                        elseif ($meta2023->valor_indicador >= .80 && $meta2023->valor_indicador <= .90)
                                                            $img2023 = "satisfactorio.png";
                                                        else
                                                            $img2023 = "sobresaliente.png";                                                
                                                    else:
                                                        $img2023 = "no_aplica.svg";
                                                    endif;
                                                @endphp
                                                
                                                <img style="width:50px;" src="{{asset("/images/productos/".$img2023)}}">
                                            </td>
                                            <td style="vertical-align: middle;text-align:center">
                                                @php
                                                    $meta2024 = SeguimientoMeta::where("idProducto",$producto->idProducto)->where("año",2024)->first();
                                                    if($meta2024 != null):                                                                                                       
                                                        if($meta2024->valor_indicador <= 0 )
                                                            $img2024 = "no_atendido.png";
                                                        elseif ($meta2024->valor_indicador >= .1 && $meta2024->valor_indicador <= .60)
                                                            $img2024 = "no_satisfactorio.png";
                                                        elseif ($meta2024->valor_indicador >= .61 && $meta2024->valor_indicador <= .79)
                                                            $img2024 = "regular.png";
                                                        elseif ($meta2024->valor_indicador >= .80 && $meta2024->valor_indicador <= .90)
                                                            $img2024 = "satisfactorio.png";
                                                        else
                                                            $img2024 = "sobresaliente.png";                                                
                                                    else:
                                                        $img2024 = "no_aplica.svg";
                                                    endif;
                                                @endphp
                                                <img style="width:50px;" src="{{asset("/images/productos/".$img2024)}}">
                                            </td>
                                            <td style="vertical-align: middle; text-align:center">
                                                @if ($producto->estado_producto !== 'revision')
                                                    <button class="btn btn-warning"
                                                        id="btnRevision{{ $producto->idProducto }}"
                                                        onclick="RevisionProducto({{ $producto->idProducto }})">
                                                        <i class="fas fa-paper-plane"></i> Enviar a revisión
                                                    </button>
                                                @else
                                                    <button class="btn btn-secondary" disabled>
                                                        <i class="fas fa-paper-plane"></i> Producto en revisión
                                                    </button>
                                                @endif
                                            </td>


                                            <td style="vertical-align: middle; text-align: left;">
                                                <div class="botones-alineados"
                                                    id="contenedorBotones{{ $producto->idProducto }}">
                                                    @if ($producto->estado_producto !== 'revision')
                                                        <button class="btn btn-sm btn-primary btn-ver-producto"
                                                            id="btnEditar{{ $producto->idProducto }}"
                                                            data-id="{{ $producto->idProducto }}"
                                                            data-nombre="{{ $producto->producto }}"
                                                            data-responsable="{{ $producto->dependenciaNombre }}"
                                                            data-ppa="{{ $producto->idPPA }}"
                                                            data-bs="{{ $producto->idBS }}"
                                                            data-objetivo="{{ $producto->idObjetivoPED }}"
                                                            data-sector={{ $producto->idSector }} title="Datos Generales">
                                                            <i class="fas fa-list"></i> Datos Generales
                                                        </button>

                                                        <a href="{{ route('productos.seguimiento', ['idProducto' => $producto->idProducto]) }}"
                                                            class="btn btn-sm btn-success"
                                                            id="btnSeguimiento{{ $producto->idProducto }}"
                                                            title="Seguimiento">
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
            $(document).ready(function() {
                // Inicializar DataTable
                var table = $('#dataTableItar').DataTable({
                    pageLength: 5,
                    lengthMenu: [5, 10, 50],
                    order: [
                        [0, 'asc']
                    ]
                });

                // Cargar datos al hacer clic en "Ver Datos Generales"
                $(document).on('click', '.btn-ver-producto', function() {
                    limpiarModal(); // Limpia TODO antes de cargar nuevo producto
                    const idProducto = $(this).data('id');

                    if (idProducto) {
                        abrirModalProducto(idProducto); // Carga datos desde el servidor
                    } else {
                        $('#modalGenerales').modal('show'); // Modal limpio para nuevo producto

                    }
                });


                // Limpiar validación al cerrar modal
                $('#modalGenerales').on('hidden.bs.modal', function() {
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
                    success: function(data) {
                        const temas = JSON.parse(document.getElementById('temas-json').textContent);
                        const objetivos = JSON.parse(document.getElementById('objetivos-json').textContent);
                        const estrategias = JSON.parse(document.getElementById('estrategias-json').textContent);
                        const lineasAccion = JSON.parse(document.getElementById('lineasaccionped-json')
                            .textContent);
                        const objetivosSector = JSON.parse(document.getElementById('objetivossector-json')
                            .textContent);
                        const estrategiasSector = JSON.parse(document.getElementById('estrategiassector-json')
                            .textContent);


                        // Mostrar Producto +ID + nombre del producto 
                        $('#info-producto').text(`Producto: ${data.idProducto} - ${data.Producto}`);

                        // Limpiar dinámicos
                        $('#body-bienes').empty();
                        $('#body-ppas').empty();

                        // Datos básicos
                        $('#producto').val(data.Producto);
                        $('#idProducto').val(data.idProducto);
                        $('#dependenciaTexto').val(
                        data.dependenciaNombre
                            ? `${data.dependenciaNombre} (${data.dependenciaSiglas})`
                            : 'Sin dependencia asignada'
                    );

                    $('#dependenciaHidden').val(data.idDependencia);

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

                        // Línea de acción seleccionada múltiple

                        $('#lineasAccionAlineacion').val(null).trigger('change');
                        const lineasSeleccionadas = data.idLAPED ? data.idLAPED.split(',') : [];
                        $('#nombreLineasAccion').val(lineasSeleccionadas.join(','));
                        $('#body-lineas').empty();

                        lineasSeleccionadas.forEach(function(laId) {
                            const linea = lineasAccion.find(l => String(l.idLAPED) === laId.trim());

                            if (linea) {
                                const nombre = `${linea.laPEDClave} ${linea.laPEDDescripcion}`;
                                $('#body-lineas').append(`
                <tr id="row-linea${laId}">
                    <td style="text-align:center;">${laId}</td>
                    <td>${nombre}</td>
                    <td style="text-align:center;">
                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarLineaAccion('${laId}')">
                            <i class="fas fa-trash-alt"></i> Quitar
                        </button>
                    </td>
                </tr>
            `);
                            } else {
                                // Si no se encuentra en el JSON, mostrar con nombre genérico
                                $('#body-lineas').append(`
                <tr id="row-linea${laId}">
                    <td style="text-align:center;">${laId}</td>
                    <td><em>No disponible</em></td>
                    <td style="text-align:center;">
                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarLineaAccion('${laId}')">
                            <i class="fas fa-trash-alt"></i> Quitar
                        </button>
                    </td>
                </tr>
            `);
                            }
                        });


                        $('#idSector').val(data.idSector);

                        filtrarOpciones({
                            datos: objetivosSector,
                            idPadre: data.idSector,
                            campoFiltro: 'idSector',
                            selectDestino: document.getElementById('idObjetivo'),
                            campoValue: 'idObjetivo',
                            campoLabel: o => `${o.claveObjetivo} ${o.objetivo}`,
                            valorPreseleccionado: data.idObjetivo
                        });

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

                        ppasSeleccionadas.forEach(function(ppaId) {
                            const nombre = $('#ppa option[value="' + ppaId + '"]').text();
                            if (nombre) {
                                $('#body-ppas').append(
                                    `
                                                                                                                                <tr id="row-ppa-${ppaId}">
                                                                                                                                    <td style="text-align:center;">${ppaId}</td>
                                                                                                                                    <td>${nombre}</td>
                                                                                                                                    <td style="text-align:center;">
                                                                                                                                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarPPA('${ppaId}')">
                                                                                                                                            <i class="fas fa-trash-alt"></i> Quitar
                                                                                                                                        </button>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            `
                                );
                            }
                        });
                        actualizarBienesSegunPPA();


                        // Bienes y servicios
                        const bienesServicios = data.idBS ? data.idBS.split(',') : [];
                        bienesServicios.forEach(function(bienServicioId) {
                            const bienServicioNombre = $('#bienServicio option[value="' + bienServicioId +
                                '"]').text();
                            if (bienServicioNombre) {
                                $('#body-bienes').append(
                                    `
                                                                                                                                <tr id="row-bien${bienServicioId}" class="bien">
                                                                                                                                    <td style="text-align:center;border:solid 1px gray">${bienServicioId}</td>
                                                                                                                                    <td style="border:solid 1px gray">${bienServicioNombre}</td>
                                                                                                                                    <td style="text-align:center;border:solid 1px gray">
                                                                                                                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeBienServicio(${bienServicioId})">
                                                                                                                                            <i class="fas fa-trash-alt"></i> Quitar
                                                                                                                                        </button>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            `
                                );
                            }
                        });

                        $('#bienesServicios').val(bienesServicios.join(','));

                        // Indicador
                        $('#nombreIndicador').val(data.nombreIndicador);
                        $('#tipoIndicador').val(data.tipoIndicador);
                        $('#calculoIndicador').val(data.calculoIndicador);
                        $('#frecuenciaMedicion').val(data.frecuencia_medicion);
                        $('#sentidoEsperado').val(data.sentido_esperado);
                        $('#unidadIndicador').val(data.unidadIndicador);
                        $('#unidadMedidaIndicador').val(data.unidad_medida_indicador);
                        $('#medioIndicador').val(data.medioIndicador)
                        actualizarContadorMedioIndicador();
                        $('#medioIndicador').on('input', actualizarContadorMedioIndicador);
                        // Habilitar/deshabilitar el botón Almacenar según guardar_generales
                        if (typeof data.guardar_generales !== "undefined") {
                            if (parseInt(data.guardar_generales) === 1) {
                             $('#btnAlmacenarG').prop('disabled', false);
                         } else {
                             $('#btnAlmacenarG').prop('disabled', true);
                            }
                        }
                        // Ejemplo dentro del success de AJAX
    // ------ SECCION PED -------
    // ------ SECCION PED -------
    if (data.seccion_ped == 0) {
        bloquearSelect($('#eje'), true);
        bloquearSelect($('#tema'), true);
        bloquearSelect($('#objetivo_ped'), true);
        bloquearSelect($('#estrategia'), true);
        bloquearSelect($('#lineasAccionAlineacion'), true);
        $('#body-alineacion button').prop('disabled', true);
        $('#body-alineacion input[type="text"], #body-alineacion input[type="number"], #body-alineacion textarea').prop('readonly', true);
    } else {
        bloquearSelect($('#eje'), false);
        bloquearSelect($('#tema'), false);
        bloquearSelect($('#objetivo_ped'), false);
        bloquearSelect($('#estrategia'), false);
        bloquearSelect($('#lineasAccionAlineacion'), false);
        $('#body-alineacion button').prop('disabled', false);
        $('#body-alineacion input[type="text"], #body-alineacion input[type="number"], #body-alineacion textarea').prop('readonly', false);
    }

    // ------ SECCION PES -------
    if (data.seccion_pes == 0) {
        bloquearSelect($('#idSector'), true);
        bloquearSelect($('#idObjetivo'), true);
        bloquearSelect($('#idEstrategia'), true);
        $('#body-sector input[type="text"], #body-sector input[type="number"], #body-sector textarea').prop('readonly', true);
    } else {
        bloquearSelect($('#idSector'), false);
        bloquearSelect($('#idObjetivo'), false);
        bloquearSelect($('#idEstrategia'), false);
        $('#body-sector input[type="text"], #body-sector input[type="number"], #body-sector textarea').prop('readonly', false);
    }

    // ------ SECCION PPA -------
    if (data.seccion_ppa == 0) {
        bloquearSelect($('#ppa'), true);
        bloquearSelect($('#bienServicio'), true);
        $('#body-programa button').prop('disabled', true);
        $('#body-ppas button, #body-bienes button').prop('disabled', true);
        $('#body-programa input[type="text"], #body-programa input[type="number"], #body-programa textarea').prop('readonly', true);
    } else {
        bloquearSelect($('#ppa'), false);
        bloquearSelect($('#bienServicio'), false);
        $('#body-programa button').prop('disabled', false);
        $('#body-ppas button, #body-bienes button').prop('disabled', false);
        $('#body-programa input[type="text"], #body-programa input[type="number"], #body-programa textarea').prop('readonly', false);
    }

    // ------ SECCION DI -------
    if (data.seccion_DI == 0) {
        $('#body-indicador textarea').prop('readonly', true);
        $('#body-indicador input[type="text"], #body-indicador input[type="number"]').prop('readonly', true);
    } else {
        $('#body-indicador textarea').prop('readonly', false);
        $('#body-indicador input[type="text"], #body-indicador input[type="number"]').prop('readonly', false);
    }






                        // Mostrar modal
                        $('#modalGenerales').modal('show');

                        $('#modalGenerales .nav-tabs .nav-item:first-child .nav-link').tab('show');

                        // Activar siempre la primera pestaña
                        $('#modalGenerales .nav-tabs .nav-link').removeClass('active');
                        $('#modalGenerales .tab-pane').removeClass('active show');
                        $('#modalGenerales .nav-tabs .nav-link:first').addClass('active');
                        $('#modalGenerales .tab-pane:first').addClass('active show');

                    },
                    error: function() {
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
                $('#eje, #tema, #objetivo_ped, #estrategia, #lineasAccionAlineacion, #idObjetivo, #idEstrategia, #nombrePPA, #bienServicio')
                    .val('');

                // Campo oculto
                $('#idProducto').val('');
                $('#bienesServicios').val('');

                // Limpiar tabla dinámica
                $('#body-bienes').empty();
                $('#emptyBienes').show();

                // Limpiar notificaciones en pestañas (asteriscos rojos)
                $('.nav-item.nav-link').each(function() {
                    $(this).removeClass('text-danger');
                    const span = $(this).find('span');
                    span.text('');
                    span.removeAttr('title').css('color', '');
                });
                //Contraer 
                // Contraer todas las secciones al abrir un nuevo modal
                const secciones = [{
                        body: 'body-alineacion',
                        icon: 'chev-alineacion'
                    },
                    {
                        body: 'body-sector',
                        icon: 'chev-sector'
                    },
                    {
                        body: 'body-programa',
                        icon: 'chev-programa'
                    },
                    //{ body: 'body-indicador', icon: 'chev-indicador' }
                ];

                secciones.forEach(({
                    body,
                    icon
                }) => {
                    const elBody = document.getElementById(body);
                    const elIcon = document.getElementById(icon);

                    if (elBody && elIcon) {
                        elBody.style.display = 'none'; // Contraer la sección
                        elIcon.classList.remove('fa-chevron-down', 'fa-chevron-up');
                        elIcon.classList.add('fa-chevron-right');
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

                    $('input, select').each(function() {
                        if (!this.checkValidity()) {
                            $(this).addClass('is-invalid');
                        } else {
                            $(this).removeClass('is-invalid').addClass('is-valid');
                        }
                    });

                    return;
                }
                /*
                // Validación: al menos una Línea de Acción agregada
                const lineasSeleccionadas = [];
                $('#body-lineas tr').each(function() {
                    const id = $(this).find('td').eq(0).text().trim();
                    if (id) lineasSeleccionadas.push(id);
                });

                if (lineasSeleccionadas.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Falta seleccionar Línea de Acción',
                        text: 'Debe agregar al menos una Línea de Acción antes de guardar.'
                    });
                    return;
                }

                $('#nombreLineasAccion').val(lineasSeleccionadas.join(','));

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
                $('#body-bienes tr').each(function() {
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
                */


                // Enviar datos
                const formData = $('#formDatosGenerales').serialize();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('productossectoriales.store') }}',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btnAlmacenarG').prop('disabled', true).text('Guardando...');
                    },
                    success: function(response) {
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
                                text: response.message ||
                                    'Debe tener seleccionado un bien o servicio antes de guardar.'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error del servidor',
                            text: 'Ocurrió un error inesperado. Intenta más tarde.'
                        });
                    },
                    complete: function() {
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

                const fila = $(
                    `
                                                                                                                                        <tr id="row-bien${bienServicioId}" class="bien">
                                                                                                                                            <td style="text-align:center;border:solid 1px gray">${bienServicioId}</td>
                                                                                                                                            <td style="border:solid 1px gray">${bienServicioNombre}</td>
                                                                                                                                            <td style="text-align:center;border:solid 1px gray">
                                                                                                                                                <button type="button" class="btn btn-danger btn-sm btn-quitar-bien" title="Quitar bien">
                                                                                                                                                    <i class="fas fa-trash-alt"></i> Quitar
                                                                                                                                                </button>
                                                                                                                                            </td>
                                                                                                                                        </tr>
                                                                                                                                    `
                );

                fila.find('.btn-quitar-bien').on('click', function() {
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
                            $('#body-bienes tr').each(function() {
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
                $('#body-bienes tr').each(function() {
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
                            success: function(response) {
                                if (response.success) {
                                    // Desvanecer visualmente la fila eliminada
                                    $('#row-bien' + bienId).fadeOut(600, function() {
                                        $(this).remove();

                                        Swal.fire(
                                            'Eliminado',
                                            'El bien o servicio ha sido eliminado.',
                                            'success'
                                        ).then(() => {
                                            //Limpiar validaciones anteriores
                                            $('#formDatosGenerales').removeClass(
                                                'was-validated');
                                            $('#formDatosGenerales input, #formDatosGenerales select')
                                                .removeClass('is-invalid');

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
                            error: function() {
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
                const productoId = document.getElementById('idProducto')?.value || null; // Asegúrate de tener esto

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
                fila.setAttribute('data-guardado', 'false');

                fila.innerHTML = `
            <td style="text-align:center;border:solid 1px gray;">${idPPA}</td>
            <td style="border:solid 1px gray;">${nombrePPA}</td>
            <td style="text-align:center;border:solid 1px gray;">
                <button type="button" class="btn btn-danger btn-sm btn-quitar-ppa" title="Quitar PPA">
                    <i class="fas fa-trash-alt"></i> Quitar
                </button>
            </td>
        `;

                fila.querySelector('.btn-quitar-ppa').addEventListener('click', () => {
                    Swal.fire({
                        title: '¿Está seguro?',
                        text: '¿Desea quitar este PPA de la lista? Si tiene Bienes o servicios relacionados tambien se quitaran de la lista',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, quitar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si NO está guardado
                            if (fila.getAttribute('data-guardado') === 'false') {
                                fila.remove();
                                actualizarListaPPA();
                                actualizarBienesSegunPPA
                            (); // <-- esto actualiza la tabla de bienes según los PPAs seleccionados
                                Swal.fire('Eliminado', 'El PPA fue eliminado de la lista.', 'success');
                            } else {
                                // Si está guardado → eliminar vía AJAX
                                fetch(`/alineacion/${productoId}/eliminar-ppa/${idPPA}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').content,
                                            'Accept': 'application/json'
                                        }
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            fila.remove();
                                            actualizarListaPPA();
                                            Swal.fire('Eliminado', data.message, 'success');
                                            actualizarBienesSegunPPA();
                                        } else {
                                            Swal.fire('Error', data.message, 'error');
                                        }
                                    })
                                    .catch(err => {
                                        Swal.fire('Error', 'No se pudo eliminar el PPA. Intente más tarde.',
                                            'error');
                                        console.error(err);
                                    });
                            }
                        }
                    });
                });

                tablaPPAs.appendChild(fila);
                ppasExistentes.push(idPPA);
                inputPPAs.value = ppasExistentes.join(',');

                actualizarBienesSegunPPA();
                $('#ppa').val('');
                $('#ppa').removeClass('is-invalid is-valid');
            }

            // Actualiza el input oculto con los PPAs actuales del DOM
            function actualizarListaPPA() {
                const ids = [];
                document.querySelectorAll('#body-ppas tr').forEach(row => {
                    const id = row.querySelector('td')?.textContent?.trim();
                    if (id) ids.push(id);
                });
                document.getElementById('nombrePPA').value = ids.join(',');
                actualizarBienesSegunPPA();
            }

            // Función para eliminar un PPA de la lista
            function eliminarPPA(idPPA) {
                const productoId = $('#idProducto').val();

                // Detectar bienes relacionados al PPA (en la vista)
                const bienesRelacionados = [];
                $('#body-bienes tr').each(function() {
                    const bienId = $(this).find('td').eq(0).text().trim();
                    const bienOption = $(`#bienServicio option[value="${bienId}"]`);
                    const ia_id = bienOption.data('ia-id');

                    if (parseInt(ia_id) === parseInt(idPPA)) {
                        bienesRelacionados.push(bienId);
                    }
                });

                // Mensaje condicional
                let mensaje =
                    '¿Está seguro de que desea eliminar este PPA? Si tiene bienes o servicios relacionados, también serán eliminados.';
                if (bienesRelacionados.length > 0) {
                    mensaje =
                        `Este PPA tiene ${bienesRelacionados.length} bien(es) o servicio(s) asociados. También se eliminarán. ¿Deseas continuar?`;
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
                            success: function(response) {
                                if (response.success) {
                                    // Quitar fila de PPA
                                    $(`#row-ppa-${idPPA}`).remove();

                                    // Quitar bienes eliminados
                                    if (response.bienesEliminados && Array.isArray(response
                                            .bienesEliminados)) {
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
                                    Swal.fire('Error', response.message || 'No se pudo eliminar el PPA.',
                                        'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error', 'Error del servidor al intentar eliminar el PPA.',
                                    'error');
                            }
                        });
                    }
                });
            }

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
                            beforeSend: function() {
                                $('#btnRevision' + idProducto).html(
                                    '<i class="fas fa-spinner fa-spin"></i> Enviando...');
                            },
                            success: function(response) {
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
                            error: function() {
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

            //Agregar Multiples lineas de Acción
            function agregarLineaAccion(event) {
                event.preventDefault();

                const lineaAccionId = $('#lineasAccionAlineacion').val();
                const lineaAccionNombre = $('#lineasAccionAlineacion option:selected').text();

                if (!lineaAccionId) {
                    Swal.fire('Falta selección', 'Por favor, seleccione una línea de acción.', 'warning');
                    return;
                }

                if ($('#row-linea' + lineaAccionId).length > 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Ya está agregada',
                        text: 'Esta línea de acción ya se encuentra en la lista.'
                    });
                    return;
                }

                const fila = $(`
                <tr id="row-linea${lineaAccionId}" class="linea-accion">
                    <td style="text-align:center;border:solid 1px gray">${lineaAccionId}</td>
                    <td style="border:solid 1px gray">${lineaAccionNombre}</td>
                    <td style="text-align:center;border:solid 1px gray">
                        <button type="button" class="btn btn-danger btn-sm btn-quitar-linea" title="Quitar línea de acción">
                            <i class="fas fa-trash-alt"></i> Quitar
                        </button>
                    </td>
                </tr>
            `);

                fila.find('.btn-quitar-linea').on('click', function() {
                    Swal.fire({
                        title: '¿Está seguro?',
                        text: '¿Desea eliminar esta línea de acción de la lista?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fila.remove();

                            const lineasAccion = [];
                            $('#body-lineas tr').each(function() {
                                const id = $(this).find('td').eq(0).text().trim();
                                if (id) lineasAccion.push(id);
                            });

                            $('#nombreLineasAccion').val(lineasAccion.join(','));

                            Swal.fire({
                                icon: 'success',
                                title: 'Eliminado',
                                text: 'La línea de acción fue eliminada de la lista.'
                            });
                        }
                    });
                });

                $('#body-lineas').append(fila);

                const lineasAccion = [];
                $('#body-lineas tr').each(function() {
                    const id = $(this).find('td').eq(0).text().trim();
                    if (id) lineasAccion.push(id);
                });

                $('#nombreLineasAccion').val(lineasAccion.join(','));
                $('#lineasAccionAlineacion').val('');
                $('#lineasAccionAlineacion').removeClass('is-invalid is-valid');
            }

            function eliminarLineaAccion(idLAPED) {
                const productoId = $('#idProducto').val();

                Swal.fire({
                    title: '¿Está seguro?',
                    text: '¿Desea eliminar esta línea de acción? Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/productos/${productoId}/eliminar-linea-accion/${idLAPED}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Eliminar del DOM
                                    $(`#row-linea${idLAPED}`).remove();

                                    // Actualizar campo oculto
                                    const nuevasLineas = [];
                                    $('#body-lineas tr').each(function() {
                                        const id = $(this).find('td').eq(0).text().trim();
                                        if (id) nuevasLineas.push(id);
                                    });

                                    $('#nombreLineasAccion').val(nuevasLineas.join(','));

                                    Swal.fire('Eliminado', response.message, 'success');
                                } else {
                                    Swal.fire('Error', response.message ||
                                        'No se pudo eliminar la línea de acción.', 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error',
                                    'Error del servidor al intentar eliminar la línea de acción.',
                                    'error');
                            }
                        });
                    }
                });
            }
                function bloquearSelect($select, bloquear = true) {
                    if (bloquear) {
                        $select.addClass('select-readonly');
                        $select.on('mousedown.readonly', function (e) { e.preventDefault(); this.blur(); });
                        $select.on('keydown.readonly', function (e) { e.preventDefault(); });
                    } else {
                        $select.removeClass('select-readonly');
                        $select.off('mousedown.readonly');
                        $select.off('keydown.readonly');
                    }
                }

                function verAcusePS() {
                    const anio = document.getElementById('anio').value;

                    if (!anio) {
                        Swal.fire(
                            'Atención',
                            'Debe seleccionar un año para descargar el acuse.',
                            'warning'
                        );
                        return;
                    }

                    const url = "{{ route('productosSectoriales.verAcuse') }}" + "?anio=" + anio;

                    window.open(url, '_blank');
                }


        </script>
@endsection
