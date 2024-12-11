@php
    use App\Models\LineaPED;
    use App\Models\AnexoEstadistico;
    use App\Models\InformeParrafo;
@endphp
@extends('layouts.administrador')
@section('encabezado')
   Tablero de Programas, Proyectos y Acciones (PPAs)
@endsection
@section('content')
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
            style="background-color: #681b2e;">
            <h6 class="m-0 font-weight-bold text-light">Programas, Proyectos y Acciones (PPAs) registrados.
            </h6>

        </div>
        <!-- Card Body -->
        <div class="card-body" id="indicadorContent">
            <center>
                <h4>Listado de Programas, Proyectos y Acciones (PPAs)</h4>
                <div style="text-align: right;padding-right:15px;">                    
                    <a href="{{route('informe.descargaallacciones',["consulta"=>1])}}" target="_blank"><button type="button" class="btn btn-primary"><i class="fas fa-download"></i> Acciones</button></a>                    
                </div>
                <hr />
                <table class="table table-bordered table-striped" style="padding: 15px; width:100%" id="tableAcciones">
                    <thead>
                        <tr style="padding: 15px;background-color:gray;color:white;text-align:center">
                            <th style="width: 5%">Id</th>
                            <th style="width: 25%">Acción</th>
                            <th style="width: 5%">Activa</th>
                            <th style="width: 5%">Creación</th>
                            <th style="width: 15%">Tema</th>
                            <th style="width: 5%">Responsable</th>
                            <th style="width: 22.5%">Alineación a nivel Linea de acción</th>
                            <th style="width: 22.5%">Alineación con anexo Estadístico</th>
                            <th style="width: 5%">Parrafos redactados</th>                            
                            <th style="width: 5%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($acciones->count() > 0)
                            @foreach ($acciones as $accion)
                                <tr>
                                    <td style="vertical-align: middle;text-align:center">{{ $accion->id }}</td>
                                    <td style="width: 15%" onclick="editElement('nombre{{ $accion->id }}',{{ $accion->id }},'nombre')">
                                        <span
                                            id="nombre{{ $accion->id }}">{{ $accion->nombre }}</span>
                                    </td>

                                    <td style="vertical-align: middle;text-align:center">
                                        <span id="contenedorStatus{{ $accion->id }}">
                                            <input id="status{{ $accion->id }}" type="checkbox"
                                                @if ($accion->status_accion == 1) checked @endif
                                                 disabled />
                                        </span>
                                    </td>
                                    <td style="vertical-align: middle;text-align:center">
                                        @if($accion->creacion=="a")
                                            Automática
                                        @else
                                            Manual
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle">
                                        <span id="temaAccion{{$accion->id}}" >
                                            {{ $accion->temaPEDClave . ' ' . $accion->temaPEDDescripcion }}
                                        </span>                                        
                                    </td>
                                    <td style="vertical-align: middle;text-align:center">
                                        <span id="dependenciaAccion{{$accion->id}}">
                                            <button class="btn btn-primary"
                                            title="{{ $accion->dependenciaNombre }}"
                                            data-title="{{ $accion->dependenciaNombre }}" data-toggle="tooltip"
                                            data-placement="top"
                                            >{{ $accion->dependenciaSiglas }}</button>
                                        </span>                                     

                                        </td>

                                    <td>

                                        @php
                                            //Jalamos las lineas de accion con las que se alinea la accion
                                            $lineas_ = explode('|', $accion->alineacion_la);
                                            if (count($lineas_) > 0) {
                                                array_pop($lineas_);
                                                foreach ($lineas_ as $lin) {
                                                    $infoLinea = LineaPED::where('idLAPED', $lin)->first();
                                                    if ($infoLinea != null) {
                                                        echo '<p><b>' .
                                                            $infoLinea->laPEDClave .
                                                            '</b> ' .
                                                            $infoLinea->laPEDDescripcion .
                                                            '</p>';
                                                    }
                                                }
                                            }
                                        @endphp
                                    </td>
                                    <td>
                                        @php
                                            //Jalamos los cuadros agregados
                                            $cuadros_ = explode('|', $accion->ae_cuadros);
                                            if (count($cuadros_) > 0) {
                                                array_pop($cuadros_);
                                                foreach ($cuadros_ as $cuad) {
                                                    $infoCuad = AnexoEstadistico::where('id', $cuad)->first();
                                                    if ($infoCuad != null) {
                                                        echo '<p><b>' .
                                                            $infoCuad->numero .
                                                            '</b> ' .
                                                            $infoCuad->cuadro .
                                                            '</p>';
                                                    }
                                                }
                                            }
                                        @endphp
                                    </td>
                                    <td style="text-align: center;vertical-align:middle">
                                        @php
                                            //contabilizamos los parrafos capturados
                                            $parrafos_capturados = InformeParrafo::where(
                                                'informe_acciones_id',
                                                $accion->id,
                                            )->get();
                                        @endphp
                                        {{ $parrafos_capturados->count() }}
                                    </td>                                   
                                    <td style="text-align: center;vertical-align:middle">
                                        <button class="btn btn-primary" onclick="showAccionModal({{ $accion->id }})"><i
                                                class="fas fa-info"></i></button>
                                        @if (false)
                                            <button class="btn btn-danger" onclick="deleteAccion({{ $accion->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </center>
        </div>
    </div>
    <div class="modal fade" id="accionModal" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="accionModalLabel">Párrafos redactados</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="body-parrafos">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>
@endsection



@section('scripts')
    <script>
        $(document).ready(function() {
            $("#collapseTwo").addClass("show");
            $("#menuIndicadores").addClass("active");
            $("#optppas").css('background-color', "rgb(217, 217, 217)");


            $('#tableAcciones thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#tableAcciones thead');

            dt = $('#tableAcciones').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 30, 50, 100],
                orderCellsTop: true,
                fixedHeader: true,
                initComplete: function() {
                    var api = this.api();

                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function(colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            if (colIdx != 8) {
                                $(cell).html(
                                    '<input type="text" class="form-control" placeholder="' +
                                    title + '" />');
                            } else {
                                $(cell).html('')
                            }


                            // On every keypress in this input
                            $(
                                    'input',
                                    $('.filters th').eq($(api.column(colIdx).header()).index())
                                )
                                .off('keyup change')
                                .on('change', function(e) {
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr =
                                        '({search})'; //$(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != '' ?
                                            regexr.replace('{search}', '(((' + this.value +
                                                ')))') :
                                            '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();
                                })
                                .on('keyup', function(e) {
                                    e.stopPropagation();

                                    $(this).trigger('change');
                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },
            });
        });




        function showAccionModal(idAccion) {

            $.ajax({
                type: 'GET',
                url: "{{ route('informe.accion.getparrafos') }}",
                data: {
                    idAccion: idAccion,
                },
                beforeSend: function() {
                    block(true)
                },
                success: function(response) {
                    $("#body-parrafos").html(response);
                }
            }).done(function(response) {
                block(false);
            }).fail(function(data) {
                block(false);
            })

            $("#accionModal").modal("show");
        }
        
    </script>
@endsection
