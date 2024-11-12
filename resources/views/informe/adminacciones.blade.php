@php
    use App\Models\LineaPED;
    use App\Models\AnexoEstadistico;
    use App\Models\InformeParrafo;
@endphp
@extends('layouts.administrador')
@section('encabezado')
    Redacción por acciones del Segundo Informe de Gobierno
@endsection
@section('content')
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
            style="background-color: #681b2e;">
            <h6 class="m-0 font-weight-bold text-light">Acciones registradas
            </h6>

        </div>
        <!-- Card Body -->
        <div class="card-body" id="indicadorContent">
            <center>
                <h4>Listado Acciones</h4>
                <div style="text-align: right;padding-right:15px;">
                    <button type="button" class="btn btn-success"
                            onclick="showModalAccion()"><i class="fas fa-plus"></i> Nueva Acción</button>
                    <a href="{{route('informe.descargaallacciones')}}" target="_blank"><button type="button" class="btn btn-primary"><i class="fas fa-download"></i> Acciones</button></a>
                    <a href="{{route('informe.resumen')}}"><button type="button" class="btn btn-warning"><i class="fas fa-download"></i> Por Líneas de Acción</button></a>
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
                            <th style="width: 20%">Alineación a nivel Linea de acción</th>
                            <th style="width: 20%">Alineación con anexo Estadístico</th>
                            <th style="width: 5%">Parrafos redactados</th>
                            <th style="width: 5%">Límite de párrafos</th>

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
                                                onchange="changeStatus({{ $accion->id }})" />
                                        </span>
                                    </td>
                                    <td style="vertical-align: middle;text-align:center">
                                        @if($accion->creacion=="a")
                                            Automática
                                        @else
                                            Manual
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle" onclick="changeTema({{$accion->id}})">
                                        <span id="temaAccion{{$accion->id}}" >
                                            {{ $accion->temaPEDClave . ' ' . $accion->temaPEDDescripcion }}
                                        </span>
                                        <select id="temaSeleccion{{$accion->id}}" class="form-control select" onkeyup="regreat({{$accion->id}})" onchange="updateTema({{$accion->id}})" style="display:none">
                                            @foreach ($temas as $tema )
                                                <option value="{{$tema->idTemaPED}}" @if($accion->idTemaPED==$tema->idTemaPED) selected @endif>{{$tema->temaPEDClave." ".$tema->temaPEDDescripcion}}</option>
                                            @endforeach

                                        </select>
                                    </td>
                                    <td style="vertical-align: middle;text-align:center" onclick="changeDependencia({{$accion->id}})">
                                        <span id="dependenciaAccion{{$accion->id}}">
                                            <button class="btn btn-primary"
                                            title="{{ $accion->dependenciaNombre }}"
                                            data-title="{{ $accion->dependenciaNombre }}" data-toggle="tooltip"
                                            data-placement="top"
                                            onclick="changeDependencia({{$accion->id}})">{{ $accion->dependenciaSiglas }}</button>
                                        </span>
                                        <select class="form-control select" id="dependenciaSeleccion{{$accion->id}}" onkeyup="regreatDep({{$accion->id}})" onchange="updateDependencia({{$accion->id}})" style="display:none">
                                            @foreach ($dependencias as $dependencia)
                                                <option value="{{$dependencia->idDependencia}}" siglas="{{$dependencia->dependenciaSiglas}}" nombre="{{$dependencia->dependenciaNombre}}" @if($dependencia->idDependencia==$accion->idDependencia) selected @endif>{{$dependencia->dependenciaNombre." (".$dependencia->dependenciaSiglas.")"}}</option>
                                            @endforeach

                                        </select>


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
                                        <span style="color: gray;font-weight:bold"><input id="maxp{{ $accion->id }}"
                                                onchange="updateMaxP({{ $accion->id }})" style="width:60px;"
                                                type="number" value="{{ $accion->parrafos_max }}"
                                                class="form-control"></span>
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
    <div class="modal fade" id="nuevaAccionModal" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="accionModalLabel">Registrar nueva Acción</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAccion">
                        @csrf
                        <h1>Datos Generales</h1>
                        <hr />
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="nombre">Descripcion del PPA<span
                                        style="color: red">*</span></label>
                                <textarea class="form-control" id="nombre" name="nombre" placeholder="" value=""></textarea>
                                <div class="invalid-feedback"
                                    style="width: 100%;background-color:rgb(255, 102, 102);color:white;border-radius:5px;text-align:center;padding:10px;">
                                    Indique una descripción para la nueva acción.
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="nombre">Tema Asociado<span
                                        style="color: red">*</span></label>
                                <select class="form-control select" id="nuevoTema">
                                    <option value="">Seleccione..</option>
                                    @foreach ($temas as $tema )
                                        <option value="{{$tema->idTemaPED}}">{{$tema->temaPEDClave." ".$tema->temaPEDDescripcion}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"
                                    style="width: 100%;background-color:rgb(255, 102, 102);color:white;border-radius:5px;text-align:center;padding:10px;">
                                    Indique un tema al que se asocia el PPA.
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="nombre">Dependencia Responsable<span
                                        style="color: red">*</span></label>
                                <select class="form-control select" id="nuevaDependencia">
                                    <option value="">Seleccione..</option>
                                    @foreach ($dependencias as $dependencia )
                                        <option value="{{$dependencia->idDependencia}}">{{$dependencia->dependenciaNombre." (".$dependencia->dependenciaSiglas.")"}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"
                                    style="width: 100%;background-color:rgb(255, 102, 102);color:white;border-radius:5px;text-align:center;padding:10px;">
                                    Indique una dependencia responsable del PPA.
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="button" onclick="saveAccion()">Almacenar</button>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('scripts')
    <script>
        $(document).ready(function() {
            $("#collapseInforme").addClass("show");
            //$("#pparegistro").addClass("active");
            $("#informeacciones").css('background-color', "rgb(217, 217, 217)");


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

        function updateMaxP(idAccion) {
            max = $("#maxp" + idAccion).val();
            $.ajax({
                type: 'POST',
                url: "{{ route('informe.accion.updatemaxp') }}",
                data: {
                    idAccion: idAccion,
                    max: max,
                    _token: $("input[name='_token']").val()
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true)
                },
                success: function(response) {
                    $("#maxp" + idAccion).val(response.maxp);
                }
            }).done(function(response) {
                block(false);
            }).fail(function(data) {
                block(false);
            })
        }

        function deleteAccion(idAccion) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "Esta acción será eliminada de manera permanente así como los párrafos redactados y complementos cargados!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('informe.deleteaccion') }}",
                        data: {
                            idAccion: idAccion,
                            _token: $("input[name='_token']").val()
                        },
                        beforeSend: function() {
                            block(true)
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.result == "ok") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Acciones de Gobierno',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ocurrió un error al intentar eliminar la acción correspondiente!',
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

        function changeStatus(idAccion) {
            beforeval = !$("#status" + idAccion).prop("checked");
            val = $("#status" + idAccion).prop("checked") ? 1 : 0;
            $.ajax({
                type: 'POST',
                url: "{{ route('informe.changestatusaccion') }}",
                data: {
                    idAccion: idAccion,
                    status:val,
                    _token: $("input[name='_token']").val()
                },
                beforeSend: function() {
                    $("#contenedorStatus"+idAccion).html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    console.log(response);
                    checked = "";
                    if (response.result == "ok") {
                        if(response.status==1)
                        checked="checked";
                    } else {
                        if(beforeval)
                            checked="checked";
                    }
                    $("#contenedorStatus"+idAccion).html('<input id="status'+idAccion+'" type="checkbox" onchange="changeStatus('+idAccion+')" '+checked+' />');
                }
            }).done(function(response) {
                block(false);
            }).fail(function(data) {
                block(false);
            })






        }

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

        function editElement(element, indicador, campo) {
            valor = $("#" + element).html();
            if (valor.indexOf('</textarea>') < 0) {
                textarea = "<textarea id='textarea" + element + "' class='form-control' onkeypress='updateVal(\"" +
                    element + "\"," + indicador + ",\"" + campo + "\")'>" + valor + "</textarea>"
                $("#" + element).html(textarea);
                $("#textarea" + element).focus();
            }

        }

        function updateVal(elemento, accion, campo) {
            if (event.keyCode == 13) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('informe.accion.updatecampo') }}",
                    data: {
                        accion: accion,
                        campo: campo,
                        valor: $("#textarea" + elemento).val(),
                        _token: $("input[name='_token']").val()
                    },
                    beforeSend: function() {
                        $("#" + elemento).html("<i class='fas fa-spinner fa-spin'></i>");
                    }
                }).done(function(response) {
                    if (response.success == "ok") {
                        $("#" + elemento).html(response.valor);
                        $("#" + elemento).css('color', 'green');

                    } else {
                        $("#" + elemento).html(response.valor);
                        $("#" + elemento).css('color', 'red');
                    }
                }).fail(function(data) {
                    $("#" + elemento).css('color', 'red');
                })
            }
        }

        function changeTema(accion){
            $("#temaAccion"+accion).hide("fast");
            $("#temaSeleccion"+accion).show("fast");
            $("#temaSeleccion"+accion).focus();
        }

        function regreat(accion){
            if(event.keyCode==27){
                $("#temaAccion"+accion).show("fast");
                $("#temaSeleccion"+accion).hide("fast");
            }
        }

        function updateTema(accion){
            nuevo_tema = $("#temaSeleccion"+accion).val();
            $.ajax({
                    type: 'POST',
                    url: "{{ route('informe.accion.updatecampo') }}",
                    data: {
                        accion: accion,
                        campo: "idTemaPED",
                        valor: nuevo_tema,
                        _token: $("input[name='_token']").val()
                    },
                    beforeSend: function() {
                        $("#temaAccion"+accion).show("fast");
                        $("#temaAccion"+accion).html("<i class='fas fa-spinner fa-spin'></i>");
                    }
                }).done(function(response) {
                    if (response.success == "ok") {
                        $("#temaSeleccion"+accion).val(response.valor);
                        $("#temaSeleccion"+accion).hide("fast")
                        $("#temaAccion" + accion ).html($("#temaSeleccion"+accion+" option:selected").text());
                        $("#temaAccion" + accion ).css('color', 'green');

                    } else {
                        $("#temaSeleccion"+accion).val(response.valor);
                        $("#temaSeleccion"+accion).hide("fast")
                        $("#temaAccion" + accion ).html($("#temaSeleccion"+accion+" option:selected").text())
                        $("#temaAccion" + accion ).css('color', 'red');
                    }
                }).fail(function(data) {
                    $("#temaAccion"+accion ).css('color', 'red');
                })

        }

        function changeDependencia(accion){
            $("#dependenciaAccion"+accion).hide("fast");
            $("#dependenciaSeleccion"+accion).show("fast")
            $("#dependenciaSeleccion"+accion).focus();
        }
        function regreatDep(accion){
            if(event.keyCode==27){
                $("#dependenciaAccion"+accion).show("fast");
                $("#dependenciaSeleccion"+accion).hide("fast");
            }
        }

        function updateDependencia(accion){
            //nueva_dependencia = $("#dependenciaSeleccion"+accion+ " option:selected").attr("siglas");
            nueva_dependencia = $("#dependenciaSeleccion"+accion).val();
            $.ajax({
                    type: 'POST',
                    url: "{{ route('informe.accion.updatecampo') }}",
                    data: {
                        accion: accion,
                        campo: "idDependencia",
                        valor: nueva_dependencia,
                        _token: $("input[name='_token']").val()
                    },
                    beforeSend: function() {
                        $("#dependenciaAccion"+accion).show("fast");
                        $("#dependenciaAccion"+accion).html("<i class='fas fa-spinner fa-spin'></i>");
                    }
                }).done(function(response) {
                    if (response.success == "ok") {
                        $("#dependenciaSeleccion"+accion).val(response.valor);
                        $("#dependenciaSeleccion"+accion).hide("fast")
                        siglas = $("#dependenciaSeleccion"+accion+" option:selected").attr("siglas");
                        nombre = $("#dependenciaSeleccion"+accion+" option:selected").attr("nombre");
                        $("#dependenciaAccion" + accion ).html('<button class="btn btn-primary" title="'+nombre+'" data-title="'+nombre+'" data-toggle="tooltip" data-placement="top" onclick="changeDependencia('+accion+')">'+siglas+'</button>');
                        $("#dependenciaAccion" + accion ).css('color', 'green');

                    } else {
                        $("#dependenciaSeleccion"+accion).val(response.valor);
                        $("#dependenciaSeleccion"+accion).hide("fast")
                        siglas = $("#dependenciaSeleccion"+accion+" option:selected").attr("siglas");
                        nombre = $("#dependenciaSeleccion"+accion+" option:selected").attr("nombre");
                        $("#dependenciaAccion" + accion ).html('<button class="btn btn-primary" title="'+nombre+'" data-title="'+nombre+'" data-toggle="tooltip" data-placement="top" onclick="changeDependencia('+accion+')">'+siglas+'</button>');
                        $("#dependenciaAccion" + accion ).css('color', 'red');
                    }
                }).fail(function(data) {
                    $("#dependenciaAccion"+accion ).css('color', 'red');
                })

        }


        function showModalAccion() {
            $("#nuevaAccionModal").modal("show");
            $("#nombre").val("");
        }
        function saveAccion() {
            if (validaAccion()) {
                nombre = $("#nombre").val();
                dependencia = $("#nuevaDependencia").val();
                tema = $("#nuevoTema").val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('informe.nuevaaccion') }}",
                    data: {
                        dependencia: dependencia,
                        tema: tema,
                        nombre: nombre,
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        block(true)
                    },
                    success: function(response) {
                        if (response.result == "ok") {
                            Swal.fire({
                                icon: 'success',
                                title: 'PPA registrado',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {
                                //window.location.replace("{{ route('informe.acciones') }}");
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ocurrió un error al intentar almacenar el PPA',
                                text: response.message,
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

        }

        function validaAccion() {
            inputs = [
                "nombre",
            ];

            selects = [
                "nuevaDependencia",
                "nuevoTema"
            ];


            valid = true;

            for (var x = 0; x < inputs.length; x++) {
                if ($("#" + inputs[x]).val().trim().length == 0) {
                    $("#" + inputs[x]).addClass("is-invalid");
                    valid = false;
                } else {
                    $("#" + inputs[x]).removeClass("is-invalid");
                }
            }

            for (var x = 0; x < selects.length; x++) {
                if ($("#" + selects[x]).val() == 0) {
                    $("#" + selects[x]).addClass("is-invalid");
                    valid = false;
                } else {
                    $("#" + selects[x]).removeClass("is-invalid");
                }
            }

            return valid;
        }
    </script>
@endsection
