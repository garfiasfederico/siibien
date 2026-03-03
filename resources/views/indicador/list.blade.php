@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Indicador / listar</h1>
    <!--<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm disabled"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Generar Listado de Indicadores</a>-->
@endsection

@section('content')
    <div class="row">
        @csrf
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Indicadores Registrados</h6>
                    <div class="dropdown no-arrow">
                        <!--<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">Acciones:</div>
                                                <a class="dropdown-item" href="{{ route('indicador') }}" style="cursor: pointer"><i
                                                        class="fas fa-plus" style="color:green;"></i> Nuevo Indicador</a>
                                            </div>-->
                    </div>
                </div>
                <div style="text-align:right;padding-right:10px;">
                    <hr />
                    <a style="cursor: pointer"><b>Simbología del semáforo de desempeño.</b></a>
                    <div style="text-align:right;width:100%;">
                        <table align="right">
                            <tr>
                                <td style="padding: 5px;border: dashed 1px gray;text-align:center">
                                    <img style="width:30px;" src="{{asset("/images/indicadores/adecuado_.png")}}">
                                </td>
                                <td style="padding: 5px;border: dashed 1px gray">Adecuado</td>                                
                                <td style="padding: 5px;border: dashed 1px gray;text-align:center">        
                                    <img style="width:30px;" src="{{asset("/images/indicadores/sin_cambio_.png")}}"></td>
                                <td style="padding: 5px;border: dashed 1px gray">Sin Cambio</td>
                                <td style="padding: 5px;border: dashed 1px gray;text-align:center">                                            
                                    <img style="width:30px;" src="{{asset("/images/indicadores/no_adecuado_.png")}}">
                                </td>
                            <td style="padding: 5px;border: dashed 1px gray">No Adecuado</td>
                                <td style="padding: 5px;border: dashed 1px gray;text-align:center">
                                    <img style="width:30px;" src="{{asset("/images/indicadores/no_disponible.png")}}">                                            
                                </td>
                                <td style="padding: 5px;border: dashed 1px gray">No Disponible</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="indicadorContent">
                    @if (count($indicadores) > 0)
                        <table class="table table-bordered table-striped" id="dataTableIndicadores" width="100%"
                            cellspacing="0" style="color: black!important">
                            <thead style="background-color: #919090;color:white;">
                                <tr>
                                    <th>Id</th>
                                    <th style="width: 40%">Nombre</th>
                                    <th>Validación ITE</th>
                                    <th>Entrega 2025</th>
                                    <th>Definición</th>
                                    <th style="display: none">Tipo</th>
                                    <th style="display: none">Dimension</th>
                                    <th style="display: none">Responsable</th>
                                    <th>Próxima actualización</th>                                    
                                    <th>Validación CREMAA</th>
                                    <th>Desempeño 2023</th>
                                    <th>Desempeño 2024</th>
                                    <th>Opciones</th>
                                    <th>Envío</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($indicadores as $indicador)
                                @if($indicador->en_revision!=2)
                                    <tr>
                                        <td>{{ $indicador->idIndicador }}</td>
                                        <td id="indicadornombre{{$indicador->idIndicador}}">{{ $indicador->indicadorNombre }}</td>
                                        <td class="text-center">
                                            <input type="checkbox" data-toggle="toggle" data-on="Validado"
                                                data-off="No validado" data-onstyle="success" data-offstyle="secondary"
                                                data-size="sm" {{ $indicador->validacion ? 'checked' : '' }} disabled>
                                        </td>
                                        <td class="text-center">
                                                <i class="fas fa-exclamation-circle" data-toggle="tooltip"
                                                    title="
                                                    @if ($indicador->estado_entrega === 'verde') Entrega realizada en 2025
                                                    @elseif($indicador->estado_entrega === 'naranja')
                                                        Debía entregar en 2025, pendiente de captura
                                                    @else
                                                        No tiene entrega programada en 2025 @endif
                                                "
                                                    style="
                                                    font-size: 22px;
                                                    color:
                                                        {{ $indicador->estado_entrega === 'verde'
                                                            ? '#28a745'
                                                            : ($indicador->estado_entrega === 'naranja'
                                                                ? '#fd7e14'
                                                                : '#b0b0b0') }};
                                                ">
                                                </i>
                                        </td>


                                        <td>{{ $indicador->indicadorObjetivo }}</td>
                                        <td style="display: none">{{ $indicador->indicadorTipo }}</td>
                                        <td style="display: none">{{ $indicador->indicadorDimension }}</td>
                                        <td style="display: none">{{ $indicador->dependenciaSiglas }}</td>
                                        <td>{{ $indicador->proxima_actualizacion }}</td>
                                        <td>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                title="Validar criterios CREMA"
                                                onclick="abrirModalCrema({{ $indicador->idIndicador }}, '{{ addslashes($indicador->indicadorNombre) }}')">
                                            <i class="fas fa-award"></i> Validar CREMAA
                                        </button>
                                        </td>
                                        <td style="text-align: center">
                                            <h4>                                                
                                                    @if($indicador->pun2023 == 1)
                                                        <!--<i class="fas fa-circle"
                                                        data-toggle="tooltip"
                                                        title="Adecuado"
                                                        style="color: green">                                                    
                                                        </i>-->
                                                        <img style="width:80px;" src="{{asset("/images/indicadores/adecuado.png")}}">
                                                    @endif
                                                    @if($indicador->pun2023 == .5)
                                                        <!--<i class="fas fa-circle" style="color: yellow"
                                                        data-toggle="tooltip"
                                                        title="Sin cambio">                                                    
                                                        </i>-->
                                                        <img style="width:80px;" src="{{asset("/images/indicadores/sin_cambio.png")}}">
                                                    @endif
                                                    @if($indicador->pun2023 == "0")
                                                        <!--<i class="fas fa-circle" style="color: red"
                                                        data-toggle="tooltip"
                                                        title="No adecuado">                                                    
                                                        </i>-->
                                                        <img style="width:80px;" src="{{asset("/images/indicadores/no_adecuado.png")}}">
                                                    @endif  
                                                
                                                    @if(is_null($indicador->pun2023))
                                                        <!--<i class="fas fa-circle" style="color: gray"
                                                        data-toggle="tooltip"
                                                        title="No disponible">                                                    
                                                        </i>-->
                                                        <img style="width:50px;" src="{{asset("/images/indicadores/no_disponible.png")}}">
                                                    @endif                                             
                                            </h4>
                                        </td>
                                        <td style="text-align: center">
                                            <h4>                                                
                                                    @if($indicador->pun2024 == 1)
                                                        <!--<i class="fas fa-circle"
                                                        data-toggle="tooltip"
                                                        title="Adecuado"
                                                        style="color: green">                                                    
                                                        </i>-->
                                                        <img style="width:80px;" src="{{asset("/images/indicadores/adecuado.png")}}">
                                                    @endif
                                                    @if($indicador->pun2024 == .5)
                                                        <!--<i class="fas fa-circle" style="color: yellow"
                                                        data-toggle="tooltip"
                                                        title="Sin cambio">                                                    
                                                        </i>-->
                                                        <img style="width:80px;" src="{{asset("/images/indicadores/sin_cambio.png")}}">
                                                    @endif
                                                    @if($indicador->pun2024 == "0")
                                                        <!--<i class="fas fa-circle" style="color: red"
                                                        data-toggle="tooltip"
                                                        title="No adecuado">                                                    
                                                        </i>-->
                                                        <img style="width:80px;" src="{{asset("/images/indicadores/no_adecuado.png")}}">
                                                    @endif  
                                                
                                                    @if(is_null($indicador->pun2024))
                                                        <!--<i class="fas fa-circle" style="color: gray"
                                                        data-toggle="tooltip"
                                                        title="No disponible">                                                    
                                                        </i>-->
                                                        <img style="width:50px;" src="{{asset("/images/indicadores/no_disponible.png")}}">
                                                    @endif                                             
                                            </h4>
                                        </td>
                                        <td class="text-center" style="width:150px">
                                            @if (Auth::user()->hasRole('consulta'))
                                                <button class="btn btn-sm btn-primary"
                                                    onclick="detallesIndicador({{ $indicador->idIndicador }})"><i
                                                        class="fas fa-info"></i></button>
                                            @else
                                                <button class="btn btn-sm btn-primary"
                                                    onclick="detallesIndicador({{ $indicador->idIndicador }})"><i
                                                        class="fas fa-info"></i></button>
                                                <a target="_blank"
                                                    href="{{ route('indicador.download', ['id' => $indicador->idIndicador]) }}"><button
                                                        class="btn btn-sm btn-dark"><i
                                                            class="fas fa-file-pdf"></i></button></a>
                                                @if (!$indicador->en_revision && $indicador->meta)
                                                    <a id="btneditar{{ $indicador->idIndicador }}"
                                                        href="{{ route('indicador.edit', ['id' => $indicador->idIndicador]) }}"><button
                                                            class="btn btn-sm btn-info"><i
                                                                class="fas fa-edit"></i></button></a>
                                                @endif

                                                <!--<button class="btn btn-sm btn-danger"
                                                                        onclick="deleteIndicador({{ $indicador->idIndicador . ",'" . $indicador->indicadorNombre }}')"><i
                                                                            class="fas fa-trash"></i></button>-->
                                            @endif
                                        </td>
                                        <td style="text-align: center" id="revision{{ $indicador->idIndicador }}">
                                            @if (!$indicador->en_revision)
                                                <button id="btnrevision{{ $indicador->idIndicador }}"
                                                    onclick="updateEditar({{ $indicador->idIndicador }})"
                                                    class="btn btn-sm btn-warning"><i class="fas fa-check"></i> Enviar a
                                                    Revisión</button>
                                            @else
                                                <a><button disabled class="btn btn-sm btn-secondary"><i
                                                            class="fas fa-paper-plane"></i> Indicador en
                                                        Revisión</button></a>
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                <tr style="color: gray">
                                    <td>{{ $indicador->idIndicador }}</td>
                                    <td id="indicadornombre{{$indicador->idIndicador}}">{{ $indicador->indicadorNombre }}</td>
                                    <td class="text-center"><i class="fas fa-ban"></i></td>
                                    <td class="text-center"><i class="fas fa-ban"></i></td>
                                    <td>{{ $indicador->indicadorObjetivo }}</td>
                                    <td>{{ $indicador->indicadorTipo }}</td>
                                    <td>{{ $indicador->indicadorDimension }}</td>
                                    <td>{{ $indicador->dependenciaSiglas }}</td>
                                    <td>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                title="Validar criterios CREMA"
                                                onclick="abrirModalCrema({{ $indicador->idIndicador }}, '{{ addslashes($indicador->indicadorNombre) }}')">
                                            <i class="fas fa-award"></i> Validar CREMAA
                                        </button>
                                    </td>
                                    <td style="text-align: center">
                                        <h4>                                                
                                                @if($indicador->pun2023 == 1)
                                                    <!--<i class="fas fa-circle"
                                                    data-toggle="tooltip"
                                                    title="Adecuado"
                                                    style="color: green">                                                    
                                                    </i>-->
                                                    <img style="width:80px;" src="{{asset("/images/indicadores/adecuado.png")}}">
                                                @endif
                                                @if($indicador->pun2023 == .5)
                                                    <!--<i class="fas fa-circle" style="color: yellow"
                                                    data-toggle="tooltip"
                                                    title="Sin cambio">                                                    
                                                    </i>-->
                                                    <img style="width:80px;" src="{{asset("/images/indicadores/sin_cambio.png")}}">
                                                @endif
                                                @if($indicador->pun2023 == "0")
                                                    <!--<i class="fas fa-circle" style="color: red"
                                                    data-toggle="tooltip"
                                                    title="No adecuado">                                                    
                                                    </i>-->
                                                    <img style="width:80px;" src="{{asset("/images/indicadores/no_adecuado.png")}}">
                                                @endif  
                                            
                                                @if(is_null($indicador->pun2023))
                                                    <!--<i class="fas fa-circle" style="color: gray"
                                                    data-toggle="tooltip"
                                                    title="No disponible">                                                    
                                                    </i>-->
                                                    <img style="width:50px;" src="{{asset("/images/indicadores/no_disponible.png")}}">
                                                @endif                                             
                                        </h4>
                                    </td>
                                    <td style="text-align: center">
                                        <h4>                                                
                                                @if($indicador->pun2024 == 1)
                                                    <!--<i class="fas fa-circle"
                                                    data-toggle="tooltip"
                                                    title="Adecuado"
                                                    style="color: green">                                                    
                                                    </i>-->
                                                    <img style="width:80px;" src="{{asset("/images/indicadores/adecuado.png")}}">
                                                @endif
                                                @if($indicador->pun2024 == .5)
                                                    <!--<i class="fas fa-circle" style="color: yellow"
                                                    data-toggle="tooltip"
                                                    title="Sin cambio">                                                    
                                                    </i>-->
                                                    <img style="width:80px;" src="{{asset("/images/indicadores/sin_cambio.png")}}">
                                                @endif
                                                @if($indicador->pun2024 == "0")
                                                    <!--<i class="fas fa-circle" style="color: red"
                                                    data-toggle="tooltip"
                                                    title="No adecuado">                                                    
                                                    </i>-->
                                                    <img style="width:80px;" src="{{asset("/images/indicadores/no_adecuado.png")}}">
                                                @endif  
                                            
                                                @if(is_null($indicador->pun2024))
                                                    <!--<i class="fas fa-circle" style="color: gray"
                                                    data-toggle="tooltip"
                                                    title="No disponible">                                                    
                                                    </i>-->
                                                    <img style="width:50px;" src="{{asset("/images/indicadores/no_disponible.png")}}">
                                                @endif                                             
                                        </h4>
                                    </td>
                                    <td class="text-center" style="width:150px">
                                        @if (Auth::user()->hasRole('consulta'))
                                            <button class="btn btn-sm btn-primary"
                                                onclick="detallesIndicador({{ $indicador->idIndicador }})"><i
                                                    class="fas fa-info"></i></button>
                                        @else
                                            <button class="btn btn-sm btn-primary"
                                                onclick="detallesIndicador({{ $indicador->idIndicador }})"><i
                                                    class="fas fa-info"></i></button>
                                            <a target="_blank"
                                                href="{{ route('indicador.download', ['id' => $indicador->idIndicador]) }}"><button
                                                    class="btn btn-sm btn-dark"><i
                                                        class="fas fa-file-pdf"></i></button></a>
                                            <!--<button class="btn btn-sm btn-danger"
                                                                    onclick="deleteIndicador({{ $indicador->idIndicador . ",'" . $indicador->indicadorNombre }}')"><i
                                                                        class="fas fa-trash"></i></button>-->
                                        @endif
                                    </td>
                                    <td style="text-align: center" id="revision{{ $indicador->idIndicador }}">
                                        <div>
                                            <span>Indicador dado de baja</span>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <h3>
                                No existen Indicadores Registrados!
                            </h3>
                            <a href="{{ route('indicador') }}">
                                <button class="btn btn-success">

                                    Agregar Indicador

                                </button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style>
        table tr:hover {
            background-color: rgb(242, 242, 242);
        }

        .odd {
            background-color: #f3f3f3 !important;
        }
    </style>
    @include('indicador.validarCrema')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#dataTableIndicadores").DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 20],
                order: [
                    [0, 'asc']
                ],
            })
            $("#collapseTwo").addClass("show");
            $("#menuIndicadores").addClass("active");
            $("#optindicadorlistado").css('background-color', "rgb(217, 217, 217)");
        });

        function detallesIndicador(indicador) {
            $("#generalModal").modal("show");
            getInfoIndicador(indicador);

        }

        function getInfoIndicador(indicador) {
            $.ajax({
                type: 'GET',
                url: "{{ route('indicador.info') }}",
                data: {
                    indicador: indicador
                },
                beforeSend: function() {
                    $("#generalModal .modal-body").html(
                        '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>');
                }
            }).done(function(response) {
                $("#generalModal .modal-body").html(response).animate("slow");
            }).fail(function(data) {

            })
        }

        function deleteIndicador(idIndicador, nombreIndicador) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "La información del indicador: \"" + nombreIndicador + "\"  no estará disponible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, dar de baja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('indicador.delete') }}",
                        data: {
                            idIndicador: idIndicador,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            if (response.success = "ok") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Indicador ',
                                    text: response.message + " Indicador: " + nombreIndicador,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {
                                    window.location.replace("{{ route('indicador.list') }}");
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ocurrió un error al intentar dar de baja el Indicador',
                                    text: '',
                                    confirmButtonColor: '#3085d6',
                                })
                            }
                        }
                    }).done(function(response) {
                        block(false);
                    }).fail(function(data) {
                        block(false);
                    })
                }
            })
        }

        function updateEditar(indicador) {
            editar = 1;
            indicadornombre = $("#indicadornombre"+indicador).html()
            Swal.fire({
                title: '¿Está Seguro?',
                text: "La información del indicador: [" + indicador+ "] " +indicadornombre+" no podrá ser modificada!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Enviar a Revisión!',
                showCancelButtonText:'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.indicador.updateeditar') }}",
                        data: {
                            indicador: indicador,
                            editar: editar,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            $("#btnrevision" + indicador).html(
                                '<i class="fas fa-spinner fa-spin"></i> Procesando...');
                        }
                    }).done(function(response) {
                        if (response.success == "ok") {
                            $("#revision" + indicador).html(
                                '<a><button disabled class="btn btn-sm btn-secondary"><i class="fas fa-paper-plane"></i> Indicador en Revisión</button></a>'
                            );
                            $("#btneditar" + indicador).remove();
                        } else {
                            $("#revision" + indicador).html('<button id="btnrevision' + indicador +
                                '" onclick="updateEditar(' + indicador +
                                ')" class="btn btn-sm btn-warning"><i class="fas fa-check"></i> Enviar a Revisión</button>'
                            );
                        }

                    }).fail(function(data) {
                        $("#revision" + indicador).html('<button id="btnrevision' + indicador +
                            '" onclick="updateEditar(' +
                            indicador +
                            ')" class="btn btn-sm btn-warning"><i class="fas fa-check"></i> Enviar a Revisión</button>'
                            );
                    })
                }
            });
        }

        function aplicarPermisosCrema(canEdit){
            const $modal   = $('#modalCrema');
            const $form    = $('#formCrema');
            const $toggles = $form.find('input[type="checkbox"][data-toggle="toggle"]');

            // Botón Guardar
            $('#btnGuardarCrema').toggle(!!canEdit);

            // Botón lápiz 
            $modal.find('.card-actions [onclick^="abrirModalAgregarComentario"]').each(function(){
                $(this).toggle(!!canEdit);
            });

            // Toggles
            if (canEdit) {
                $toggles.each(function(){
                    const $chk = $(this);
                    $chk.removeAttr('data-solo-lectura').prop('disabled', false);
                    if ($chk.data('bs.toggle')) { try { $chk.bootstrapToggle('enable'); } catch(e){} }
                    $chk.off('.crema');
                    $chk.closest('.crema-card').removeClass('is-readonly');
                });
            } else {
                $toggles.each(function(){
                    const $chk = $(this);
                    const estadoInicial = $chk.prop('checked');

                    $chk.attr('data-solo-lectura','true').prop('disabled', true);
                    if ($chk.data('bs.toggle')) {
                        try {
                            $chk.bootstrapToggle('disable');
                            $chk.bootstrapToggle(estadoInicial ? 'on' : 'off', true);
                        } catch(e){}
                    }

                    $chk.off('click.crema keydown.crema change.crema mousedown.crema touchstart.crema')
                        .on('click.crema keydown.crema change.crema mousedown.crema touchstart.crema', function(e){
                            e.preventDefault(); e.stopImmediatePropagation();
                            $chk.prop('checked', estadoInicial);
                            if ($chk.data('bs.toggle')) {
                                try { $chk.bootstrapToggle(estadoInicial ? 'on' : 'off', true); } catch(err){}
                            }
                            return false;
                        });

                    $chk.closest('.crema-card').addClass('is-readonly');
                });
            }
        }

        // (admin || indicador.crema == 1)
        function cargarPermisosCrema(idIndicador){
            aplicarPermisosCrema(false);

            $.get("{{ route('indicador.getstatus') }}", { indicador: idIndicador })
            .done(function(resp){
                const cremaFlag = Number(resp?.crema) === 1;
                const canEdit   = (window._esAdminCrema === true) || cremaFlag;
                aplicarPermisosCrema(canEdit);
            })
            .fail(function(){
                aplicarPermisosCrema(false);
            });
        }


        function abrirModalCrema(idIndicador, nombreIndicador) {
            window._cremaProgrammatic = true;
            _cremaIndicadorActivo = idIndicador;

            _cremaPeticiones.forEach(x => { try { x.abort(); } catch(e){} });
            _cremaPeticiones = [];

            if (!$('#modalCrema').data('cremaHandlersBound')) {
                $('#modalCrema')
                    .on('change', 'input[type="checkbox"][data-toggle="toggle"]', function() {
                        const $card = $(this).closest('.crema-card');
                        $card.toggleClass('is-checked', $(this).prop('checked'));
                    })
                    .data('cremaHandlersBound', true);
            }

            $('#cremaIndicadorId').val(idIndicador);
            $('#modalCremaLabel').text(
                nombreIndicador
                    ? 'Validación CREMAA — [' + idIndicador + '] ' + nombreIndicador
                    : 'Validación CREMAA'
            );

            const $form   = $('#formCrema');
            const $checks = $form.find('input[type="checkbox"][data-toggle="toggle"]');

            $checks.each(function() {
                const $chk = $(this);
                if ($chk.data('bs.toggle') && typeof $chk.bootstrapToggle === 'function') {
                    try { $chk.bootstrapToggle('destroy'); } catch(e){}
                }
                $chk.prop('checked', false);
                $chk.closest('.crema-card').removeClass('is-checked is-readonly');
            });

            $checks.each(function() {
                const $chk = $(this);
                if (typeof $chk.bootstrapToggle === 'function') {
                    $chk.bootstrapToggle({
                        on:      $chk.data('on')      || 'Cumple',
                        off:     $chk.data('off')     || 'No cumple',
                        onstyle: $chk.data('onstyle') || 'success',
                        offstyle:$chk.data('offstyle')|| 'secondary',
                        width:   $chk.data('width')   || 120
                    });
                }
            });

            // Abre modal y muestra loader
            $('#modalCrema').modal('show');
            $('#cremaBodyContent').hide();
            $('#cremaLoader').show();

            //  Cargar permisos (admin || indicador.crema == 1)
            cargarPermisosCrema(idIndicador);

            const $btnGuardar = $('#btnGuardarCrema');
            $btnGuardar.prop('disabled', true);

            const cacheBuster = Date.now();
            const req = $.ajax({
                url: "{{ url('/indicadores') }}/" + encodeURIComponent(idIndicador) + "/crema?_=" + cacheBuster,
                method: 'GET',
                dataType: 'json',
                cache: false,
                headers: {
                    'Cache-Control': 'no-cache, no-store, must-revalidate',
                    'Pragma': 'no-cache',
                    'Expires': '0'
                }
            })
            .done(function(resp) {
                if (_cremaIndicadorActivo !== idIndicador) return;

                const keys = ['claro','relevante','economico','monitoreable','adecuado','aporteMarginal'];

                keys.forEach(k => {
                    const $chk = $form.find(`input[type="checkbox"][name="crema[${k}]"]`);
                    const estabaDisabled = $chk.is(':disabled');

                    if ($chk.data('bs.toggle')) { try { $chk.bootstrapToggle('enable'); } catch(e){} }
                    $chk.prop('disabled', false);

                    $chk.prop('checked', false);
                    if ($chk.data('bs.toggle')) { try { $chk.bootstrapToggle('off', true); } catch(e){} }
                    $chk.closest('.crema-card').removeClass('is-checked');

                    if (estabaDisabled) {
                        $chk.prop('disabled', true);
                        if ($chk.data('bs.toggle')) { try { $chk.bootstrapToggle('disable'); } catch(e){} }
                    }
                });

                if (resp && resp.data) {
                    keys.forEach(k => {
                        const v = Number(resp.data[k]) === 1;
                        const $chk = $form.find(`input[type="checkbox"][name="crema[${k}]"]`);
                        const estabaDisabled = $chk.is(':disabled');

                        if ($chk.data('bs.toggle')) { try { $chk.bootstrapToggle('enable'); } catch(e){} }
                        $chk.prop('disabled', false);

                        $chk.prop('checked', !!v);
                        if ($chk.data('bs.toggle')) { try { $chk.bootstrapToggle(v ? 'on' : 'off', true); } catch(e){} }
                        $chk.closest('.crema-card').toggleClass('is-checked', !!v);

                        if (estabaDisabled) {
                            $chk.prop('disabled', true);
                            if ($chk.data('bs.toggle')) { try { $chk.bootstrapToggle('disable'); } catch(e){} }
                        }
                    });
                }
            })
            .fail(function(xhr) {
                if (xhr.statusText === 'abort') return;
                console.error('Error al cargar datos CREMA', xhr);
            })
            .always(function() {
                if (_cremaIndicadorActivo !== idIndicador) return;

                window._cremaProgrammatic = false;

                $('#cremaLoader').hide();
                $('#cremaBodyContent').show();
                $btnGuardar.prop('disabled', false);

                actualizarEstadosBotonesComentarios(idIndicador);
            });

            _cremaPeticiones.push(req);
        }



        function guardarCrema() {
            const $form = $('#formCrema');
            const $btn = $('#btnGuardarCrema');
            const originalHtml = $btn.html();

            const idIndicador = $('#cremaIndicadorId').val();
            if (!idIndicador) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Falta el ID del indicador.'
                });
                return;
            }

            const url = "{{ url('/indicadores') }}/" + idIndicador + "/crema";

            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...');

            $.ajax({
                    url,
                    method: 'POST',
                    data: $form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $form.find('input[name="_token"]').val(),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    dataType: 'json'
                })
                .done(function(resp) {
                    if (resp.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Guardado',
                            text: resp.message || 'Validación guardada correctamente.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#modalCrema').modal('hide');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: resp.message || 'Ocurrió un problema inesperado.'
                        });
                    }
                })
                .fail(function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Ocurrió un error al guardar la validación.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: msg
                    });
                })
                .always(function() {
                    $btn.prop('disabled', false).html(originalHtml);
                });
        }

        let _cremaPeticiones = [];
        let _cremaIndicadorActivo = null;

        function setEstadoBotonComentarios($btn, tieneComentarios) {
            if (tieneComentarios) {
                $btn.removeClass('btn-secondary').addClass('btn-info')
                    .prop('disabled', false)
                    .attr('title', 'Ver comentarios');
            } else {
                $btn.removeClass('btn-info').addClass('btn-secondary')
                    .prop('disabled', true)
                    .attr('title', 'No hay comentarios');
            }
        }

        function actualizarEstadoBotonComentario(idIndicador, criterio, $btn, force = false) {
            const urlBase = `{{ route('crema.comentarios.mostrar', ':id') }}`.replace(':id', idIndicador);
            const cacheKey = idIndicador + '::' + criterio;

            if (!force) {
                const cachedKey = $btn.data('cremaCacheKey');
                const cachedVal = $btn.data('cremaTieneComentarios');
                if (cachedKey === cacheKey && typeof cachedVal !== 'undefined') {
                    setEstadoBotonComentarios($btn, !!cachedVal);
                    return;
                }
            }

            setEstadoBotonComentarios($btn, false);

            const prevReq = $btn.data('cremaReq');
            if (prevReq && typeof prevReq.abort === 'function') {
                try { prevReq.abort(); } catch(e){}
            }

            const cacheBuster = Date.now();

            const req = $.ajax({
                url: urlBase + `?criterio=${encodeURIComponent(criterio)}&_=${cacheBuster}`,
                method: 'GET',
                dataType: 'json',
                cache: false,
                headers: {
                    'Cache-Control': 'no-cache, no-store, must-revalidate',
                    'Pragma': 'no-cache',
                    'Expires': '0',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .done(function(resp) {
                if (_cremaIndicadorActivo !== idIndicador) return;

                const lista = resp?.comentarios || [];
                const tiene = lista.length > 0;

                $btn.data('cremaCacheKey', cacheKey);
                $btn.data('cremaTieneComentarios', tiene);

                setEstadoBotonComentarios($btn, tiene);
            })
            .fail(function(xhr) {
                if (xhr.statusText === 'abort') return;
                setEstadoBotonComentarios($btn, true);
            })
            .always(function() {
                $btn.removeData('cremaReq');
            });

            $btn.data('cremaReq', req);
            _cremaPeticiones.push(req);
        }


    function actualizarEstadosBotonesComentarios(idIndicador) {
        $('.card-actions').each(function() {
            const $acciones = $(this);
            const criterio = $acciones.data('criterio');
            const $btnVer = $acciones.find('[data-action="ver-comentarios"]');
            if (!criterio || $btnVer.length === 0) return;

            actualizarEstadoBotonComentario(idIndicador, criterio, $btnVer);
        });
    }


    </script>
@endsection
