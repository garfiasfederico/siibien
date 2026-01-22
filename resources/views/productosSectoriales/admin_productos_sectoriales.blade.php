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
        /*Estilos para alienar el contenido*/
        .table td, .table th {
        text-align: center;
        vertical-align: middle !important;
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
        <div class="row">
            @csrf
            <div class="col-xl-12 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex align-items-center justify-content-between"
                        style="background-color: #681b2e;">
                        <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Productos Sectoriales
                            Registrados</h6>
                        <div class="dropdown no-arrow">
                            <!-- Acciones futuras -->
                        </div>
                    </div>
                    <!-- Card Body -->                    
                    <div class="card-body" id="indicadorContent">
                        <div style="text-align: right; padding:10px;">
                            <a href="{{ route('productossectoriales.detalleExelPS') }}"><button class="btn btn-success"><i
                                        class="fas fa-download"></i> Descargar Listado</button></a>
                            <div style="text-align:right;">
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
                        </div>                        
                        <table class="table table-bordered table-striped" id="dataTableItar" width="100%" cellspacing="0"
                            style="color: black!important">
                            <thead style="background-color: #919090;color:white;">
                                <tr style="text-align: center">
                                    <th>Id</th>
                                    <th>Nombre del Producto</th>
                                    <th>Responsable</th>
                                    <th>Estatus</th>
                                    <th>Desempeño 2023</th>
                                    <th>Desempeño 2024</th>
                                    <th>Seguimiento</th>
                                    <th>Permisos</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($productos as $producto)
                                    <tr>
                                        <td>{{ $producto->idProducto }}</td>
                                        <td>{{ $producto->producto }}</td>

                                        <td style="text-align: center">
                                            <button class="btn btn-primary btn-responsable"
                                                data-id="{{ $producto->idProducto }}"
                                                data-siglas="{{ $producto->dependenciaSiglas ?? 'N/A' }}">
                                                {{ $producto->dependenciaSiglas ?? 'N/A' }}
                                            </button>


                                        </td>

                                        <td style="text-align: center">
                                            <select name="nuevo_estatus" class="form-control estatus-select" data-id="{{ $producto->idProducto }}"
                                                data-url="{{ route('productossectoriales.cambiarEstatus', $producto->idProducto) }}"
                                                onchange="cambiarEstatus(this)">
                                                <option value="activo" {{ $producto->estado_producto === 'activo' ? 'selected' : '' }}>Activo</option>
                                                <option value="revision" {{ $producto->estado_producto === 'revision' ? 'selected' : '' }}>En revisión</option>
                                            </select>
                                        </td>
                                        <td>
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
                                        <td>
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
                                        <td>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary mt-2 d-flex align-items-center gap-1"
                                                onclick="abrirModalAnios({{ $producto->idProducto }})">
                                                Habilitar Años <i class="fas fa-calendar-alt"></i>
                                            </button>
                                        </td>
                                        <td style="text-align: center">
                                            <button type="button"
                                                class="btn btn-success rounded-circle"
                                                style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;padding:0"
                                                onclick="abrirModalGuardado({{ $producto->idProducto }})"
                                                title="Habilitar/deshabilitar guardado">
                                                <i class="fas fa-key"></i>
                                            </button>
                                        </td>



                                        <td style="text-align: center">
                                            <button class="btn btn-sm btn-primary"
                                                style="margin:5px;width:150px;text-align:left"
                                                onclick="abrirModalProducto({{ $producto->idProducto }})">
                                                <i class="fas fa-info"></i> Datos Generales
                                            </button>
                                            <button class="btn btn-sm btn-success"
                                                style="margin:5px;width:150px;text-align:left"
                                                onclick="window.location.href='{{ route('productos.seguimiento', ['idProducto' => $producto->idProducto]) }}'">
                                                <i class="fas fa-tachometer-alt"></i> Seguimiento
                                            </button>
                                            <button class="btn btn-sm btn-info" style="margin:5px;width:150px;text-align:left"
                                                onclick="window.location.href='{{ route('productos.detalleReporte', ['idProducto' => $producto->idProducto]) }}'">
                                                <i class="fas fa-chart-line"></i> Reportes
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No hay productos registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="result-alert" style="position:absolute;right:10px; top:80px;color:white;padding:18px;display:none">
        </div>
        @include('productosSectoriales.modalAdminHabilitarAños')
        @include('productosSectoriales.modalHabilitarGuardado')
        @include('productosSectoriales.modal_datos_generales', [
        'ejes' => $ejes,
        'temas' => $temas,
        'objetivos' => $objetivos,
        'estrategias' => $estrategias,
        'lineasaccionped' => $lineasaccionped,
        'estrategiasSector' => $estrategiasSector,
        'ppas' => $ppas,
        'nombresbs' => $nombresbs,
        'listaSectores' => $listaSectores,
    ])


@endsection
<div class="modal fade" id="responsableModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #681b2e; color:white">
                <h5 class="modal-title" id="exampleModalLabel">Asignación de responsable</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body px-4">
                @csrf
                <input type="hidden" id="idIndicador">
                <div class="form-group">
                    <label for="responsable">Seleccione Nuevo Responsable: <span class="text-danger">*</span></label>
                    <select name="responsable" id="responsable" class="form-control">
                        @foreach ($dependencias as $dependencia)
                            <option value="{{ $dependencia->idDependencia }}">
                                {{ $dependencia->dependenciaNombre . ' (' . $dependencia->dependenciaSiglas . ')' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" type="button" onclick="changeResponsable()"
                    id="btnAceptar">Aceptar</button>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script id="temas-json" type="application/json">{!! json_encode($temas) !!}</script>
    <script id="objetivos-json" type="application/json">{!! json_encode($objetivos) !!}</script>
    <script id="estrategias-json" type="application/json">{!! json_encode($estrategias) !!}</script>
    <script id="lineasaccionped-json" type="application/json">{!! json_encode($lineasaccionped) !!}</script>
    <script id="sectores-json" type="application/json">[...]</script>
    <script id="objetivossector-json" type="application/json"> {!! json_encode($objetivosSector) !!}</script>
    <script id="estrategiassector-json" type="application/json">{!! json_encode($estrategiasSector) !!}</script>
    <script id="ppas-json" type="application/json">{!! json_encode($ppas) !!}</script>
    <script id="bienesservicios-json" type="application/json">{!! json_encode($nombresbs) !!}</script>
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
            limpiarModal();
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


                    // Mostrar encabezado con ID y nombre del producto
                    $('#info-producto').text(`Producto: ${data.idProducto} - ${data.Producto}`);


                    // Limpiar dinámicos
                    $('#body-bienes').empty();
                    $('#body-ppas').empty();

                    // Datos generales
                    $('#producto').val(data.Producto);
                    $('#idProducto').val(data.idProducto);
                    $('#eje').val(data.idEjePED);

                    // Cargar temas, objetivos, estrategias y líneas de acción
                    filtrarOpciones({
                        datos: temas,
                        idPadre: data.idEjePED,
                        campoFiltro: 'idEjePED',
                        selectDestino: document.getElementById('tema'),
                        campoValue: 'idTemaPED',
                        campoLabel: t => `${t.temaPEDClave} ${t.temaPEDDescripcion}`,
                        valorPreseleccionado: data.idTemaPED
                    });

                    filtrarOpciones({
                        datos: objetivos,
                        idPadre: data.idTemaPED,
                        campoFiltro: 'idTemaPED',
                        selectDestino: document.getElementById('objetivo_ped'),
                        campoValue: 'idObjetivoPED',
                        campoLabel: o => `${o.objetivoPEDClave} ${o.objetivoPEDDescripcion}`,
                        valorPreseleccionado: data.idObjetivoPED
                    });

                    filtrarOpciones({
                        datos: estrategias,
                        idPadre: data.idObjetivoPED,
                        campoFiltro: 'idObjetivoPED',
                        selectDestino: document.getElementById('estrategia'),
                        campoValue: 'idEstrategiaPED',
                        campoLabel: e => `${e.estrategiaPEDClave} ${e.estrategiaPEDDescripcion}`,
                        valorPreseleccionado: data.idEstrategiaPED
                    });

                    filtrarOpciones({
                        datos: lineasAccion,
                        idPadre: data.idEstrategiaPED,
                        campoFiltro: 'idEstrategiaPED',
                        selectDestino: document.getElementById('lineasAccionAlineacion'),
                        campoValue: 'idLAPED',
                        campoLabel: l => `${l.laPEDClave} ${l.laPEDDescripcion}`,
                        valorPreseleccionado: data.idLAPED
                    });
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


                    // --- Cargar todos los PPAs al select (especial para admin) ---
                    const selectPPA = document.getElementById('ppa');
                    const todosPPAs = JSON.parse(document.getElementById('ppas-json').textContent);
                    selectPPA.innerHTML = '<option value="">Seleccione un PPA...</option>';

                    // Filtrar solo los PPAs que pertenecen a la dependencia del producto
                    const ppasFiltrados = todosPPAs.filter(ppa => parseInt(ppa.idDependencia) === parseInt(data
                        .idDependencia));

                    ppasFiltrados.forEach(ppa => {
                        const option = document.createElement('option');
                        option.value = ppa.id;
                        option.textContent = `${ppa.id} ${ppa.nombre}`;
                        selectPPA.appendChild(option);
                    });


                    // Mostrar PPAs seleccionados
                    $('#nombrePPA').val(data.idPPA);
                    const ppasSeleccionadas = data.idPPA ? data.idPPA.split(',') : [];
                    ppasSeleccionadas.forEach(function(ppaId) {
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
                    });

                    // --- Cargar todos los Bienes o Servicios al select (especial para admin) ---
                    const selectBS = document.getElementById('bienServicio');
                    const todosBienes = JSON.parse(document.getElementById('bienesservicios-json').textContent);
                    selectBS.innerHTML = '<option value="">Seleccione el Bien o Servicio</option>';
                    todosBienes.forEach(bs => {
                        const option = document.createElement('option');
                        option.value = bs.idBS;
                        option.setAttribute('data-ia-id', bs.ia_id);
                        option.textContent = `${bs.idBS} ${bs.nombreBS}`;
                        selectBS.appendChild(option);
                    });

                    // Mostrar Bienes seleccionados
                    const bienesServicios = data.idBS ? data.idBS.split(',') : [];
                    bienesServicios.forEach(function(bienServicioId) {
                        const bienServicioNombre = $('#bienServicio option[value="' + bienServicioId +
                            '"]').text();
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
                    actualizarBienesSegunPPA();

                    $('#bienesServicios').val(bienesServicios.join(','));

                    // Datos del indicador
                    $('#nombreIndicador').val(data.nombreIndicador);
                    $('#tipoIndicador').val(data.tipoIndicador);
                    $('#calculoIndicador').val(data.calculoIndicador);
                    $('#frecuenciaMedicion').val(data.frecuencia_medicion);
                    $('#sentidoEsperado').val(data.sentido_esperado);
                    $('#unidadIndicador').val(data.unidadIndicador);
                    $('#unidadMedidaIndicador').val(data.unidad_medida_indicador);
                    $('#medioIndicador').val(data.medioIndicador);
                    actualizarContadorMedioIndicador();
                    $('#medioIndicador').on('input', actualizarContadorMedioIndicador);

                    // Mostrar el modal y activar primera pestaña
                    $('#modalGenerales').modal('show');
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

            $('#nombreLineasAccion').val(lineasSeleccionadas.join(',')); // 👈 Aquí

            /*
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

        //Funcion para abrir el modal del responsable
        // Abrir modal al hacer clic en el botón
        $(document).on('click', '.btn-responsable', function() {
            const id = $(this).data('id');
            const siglas = $(this).data('siglas');
            abrirModalResponsable(id, siglas);
        });

        // Función separada para abrir el modal y preseleccionar la opción
        function abrirModalResponsable(idProducto, siglas) {
            $('#idIndicador').val(idProducto);

            $('#responsable option').each(function() {
                const texto = $(this).text();
                $(this).prop('selected', texto.includes(`(${siglas})`));
            });

            $('#responsableModal').modal('show');
        }

        // Guardar el nuevo responsable sin recargar la página
        function changeResponsable() {
            const idProducto = $('#idIndicador').val();
            const nuevaDependencia = $('#responsable').val();
            const textoDependencia = $('#responsable option:selected').text();
            const siglas = textoDependencia.match(/\((.*?)\)/)?.[1] ?? textoDependencia;

            if (!nuevaDependencia) {
                Swal.fire('Error', 'Debe seleccionar una dependencia válida.', 'warning');
                return;
            }

            Swal.fire({
                title: '¿Está seguro?',
                text: `¿Asignar el nuevo responsable: ${textoDependencia}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (!result.isConfirmed) return;

                const $btn = $('#btnAceptar');
                $btn.prop('disabled', true).text('Guardando...');

                $.ajax({
                    url: `/productos/${idProducto}/asignar-responsable`,
                    type: 'PUT',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        idDependencia: nuevaDependencia
                    },
                    success: function(response) {
                        $('#responsableModal').modal('hide');

                        // Actualiza el botón de la tabla sin recargar
                        const $boton = $(`.btn-responsable[data-id="${idProducto}"]`);
                        $boton.text(siglas).data('siglas', siglas);

                        Swal.fire({
                            icon: 'success',
                            title: 'Responsable actualizado',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        const mensaje = xhr.responseJSON?.message || 'Error inesperado al actualizar.';
                        Swal.fire('Error', mensaje, 'error');
                    },
                    complete: function() {
                        $('#btnAceptar').prop('disabled', false).text('Aceptar');
                    }
                });
            });
        }
        //Funciones para habilitar años en el seguimeinto de metas de los productos sectoriales
        function abrirModalAnios(idProducto) {
            $('#anioProductoId').val(idProducto);
            $('#todosAnios').prop('checked', false);
            $('#listaAniosContainer input[type="checkbox"]').prop('checked', false);

            // Mostrar el modal de inmediato
            $('#modalAnios').modal('show');

            // Mostrar un spinner temporal dentro del modal
            $('#listaAniosContainer').html(
                '<div class="text-center py-3">Cargando años... <i class="fas fa-spinner fa-spin"></i></div>');

            // Hacer consulta AJAX en segundo plano
            $.get(`/productos/${idProducto}/anios-habilitados`, function(response) {
                if (response.result === 'ok') {
                    // Generar la lista completa con los años (2023–2028)
                    let html = '';
                    for (let anio = 2023; anio <= 2028; anio++) {
                        const checked = response.anios.includes(anio) ? 'checked' : '';
                        html += `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="anios[]" value="${anio}" id="anio_${anio}" ${checked}>
                        <label class="form-check-label" for="anio_${anio}">${anio}</label>
                    </div>
                `;
                    }

                    $('#listaAniosContainer').html(html);
                } else {
                    $('#listaAniosContainer').html(
                        '<div class="text-danger text-center">No se pudieron cargar los años.</div>');
                }
            }).fail(() => {
                $('#listaAniosContainer').html(
                    '<div class="text-danger text-center">Error al cargar los años.</div>');
            });
        }

        function guardarAniosHabilitados() {
            const form = $('#formAniosHabilitados');
            const data = form.serialize();
            const btnGuardar = $('#modalAnios .btn-success');

            btnGuardar.prop('disabled', true).text('Guardando...');

            $.post(form.attr('action'), data)
                .done(response => {
                    $('#modalAnios').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Años actualizados correctamente',
                        timer: 2000,
                        showConfirmButton: false
                    });
                })
                .fail(() => {
                    Swal.fire('Error', 'No se pudieron actualizar los años', 'error');
                })
                .always(() => {
                    btnGuardar.prop('disabled', false).text('Guardar');
                });
        }




        function toggleTodosAnios(checkbox) {
            $('#listaAniosContainer input[type="checkbox"]').prop('checked', checkbox.checked);
        }

        //Funciones para habilitar el guardado
        function abrirModalGuardado(idProducto) {
            // Limpiar el formulario
            $('#formGuardado')[0].reset();
            $('#guardadoProductoId').val(idProducto);

            // Oculta todo el contenido, solo muestra el spinner
            let $body = $('#modalGuardado .modal-body');
            let $originalContent = $body.children().not('#guardadoLoading'); // Guarda el contenido original
            $originalContent.hide(); // Lo oculta

            // Agrega spinner
            if ($('#guardadoLoading').length === 0) {
                $body.append('<div id="guardadoLoading" class="text-center py-2"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>');
            } else {
                $('#guardadoLoading').show();
            }

            // Muestra el modal
            $('#modalGuardado').modal('show');

            // AJAX para cargar datos
            $.ajax({
                url: `/productossectoriales/guardado-status/${idProducto}`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#switchGenerales').prop('checked', !!parseInt(response.guardar_generales));
                    $('#switchSeguimiento').prop('checked', !!parseInt(response.guardar_seguimiento));

                    // SECCIONES
                    $('#switchPED').prop('checked', !!parseInt(response.seccion_ped));
                    $('#switchPES').prop('checked', !!parseInt(response.seccion_pes));
                    $('#switchPPA').prop('checked', !!parseInt(response.seccion_ppa));
                    $('#switchDI').prop('checked', !!parseInt(response.seccion_DI));
                },
                complete: function() {
                    // Quita el spinner y muestra contenido
                    $('#guardadoLoading').hide();
                    $originalContent.show();
                    $('#switchGenerales').prop('disabled', false);
                    $('#switchSeguimiento').prop('disabled', false);
                    $('#switchPED').prop('disabled', false);
                    $('#switchPES').prop('disabled', false);
                    $('#switchPPA').prop('disabled', false);
                    $('#switchDI').prop('disabled', false);
                }
            });
        }

        function guardarGuardado() {
            var $form = $('#formGuardado');
            var formData = $form.serialize();
            var btnGuardar = $('#modalGuardado .btn-success'); 

            btnGuardar.prop('disabled', true).text('Guardando...');

            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.result === 'ok') {
                        $('#modalGuardado').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Guardado',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        // 
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Error al guardar la configuración', 'error');
                },
                complete: function() {
                    btnGuardar.prop('disabled', false).text('Guardar');
                }
            });
        }

        function cambiarEstatus(select){
            const $select = $(select);
            const url = $select.data('url');
            const nuevo = $select.val();
            const anterior = $select.data('prev') 
                ?? $select.find('option[selected]').val() 
                ?? (nuevo === 'activo' ? 'revision' : 'activo');

            $select.prop('disabled', true);
            const $optSel = $select.find('option:selected');
            const textoOriginal = $optSel.text();
            $optSel.text('Guardando...');

            $.ajax({
                url: url,
                type: 'PUT',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: { nuevo_estatus: nuevo },
                success: function(resp){
                    if(resp.result === 'ok'){  
                        Swal.fire({
                            icon: 'success',
                            title: 'Estatus actualizado',
                            text: resp.message,
                            timer: 1200,
                            showConfirmButton: false
                        });
                        $select.data('prev', nuevo);
                    } else {
                        $select.val(anterior);
                        Swal.fire('Error', resp.message ?? 'No se pudo actualizar el estatus', 'error');
                    }
                },
                error: function(xhr){
                    $select.val(anterior);
                    const msg = xhr.responseJSON?.message || 'Error al actualizar el estatus';
                    Swal.fire('Error', msg, 'error');
                },
                complete: function(){
                    $optSel.text(textoOriginal);
                    $select.prop('disabled', false);
                }
            });
        }

    </script>
@endsection
