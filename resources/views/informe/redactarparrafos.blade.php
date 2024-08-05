@php
    use App\Models\MatrizCoordinacion;
@endphp
@extends('layouts.administrador')
@section('encabezado')
    Redacción de Párrafos para el informe de gobierno
@endsection
@section('content')
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
            style="background-color: #681b2e;">
            <h6 class="m-0 font-weight-bold text-light">Redacción de Párrafos por Acción
            </h6>
        </div>
        <!-- Card Body -->
        <div class="card-body" id="indicadorContent">
            <input type="hidden" id="accion_id" value="{{ $accion->id }}" />
            <table>
                <tr>
                    <td class="field">Dependencia:</td>
                    <td class="value">{{ $accion->dependenciaNombre . ' (' . $accion->dependenciaSiglas . ')' }}</td>
                </tr>
                <tr>
                    <td class="field">Tema:</td>
                    <td class="value">{{ $accion->temaPEDClave . ' ' . $accion->temaPEDDescripcion }}</td>
                </tr>
                <tr>
                    <td class="field">Accion:</td>
                    <td class="value" style="font-size: 1.5em"><b>{{ $accion->id . ' ' . $accion->nombre }}</b></td>
                </tr>
            </table>
            <center>
                <div style="width: 100%;padding:10px">
                    <form action="{{ route('informe.acciones') }}" method="POST" class="padding:10px;">
                        @csrf
                        <input type="hidden" value="{{ $accion->idDependencia }}" name="dependencia" />
                        <input type="hidden" value="{{ $accion->idTemaPED }}" name="tema" />
                        <button class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Regresar al Listado de
                            Acciones</button>
                    </form>
                </div>
                <h4>Párrafos redactados</h4>
                <div style="width: 100%; text-align:right;padding:10px;">
                    <button class="btn btn-success" onclick="checkCountParrafos()"><i class="fas fa-plus"> </i>
                        Nuevo Párrafo</button>
                </div>
                <table class="table table-bordered table-striped" id="tableParrafos">
                    <thead>
                        <tr>
                            <th style="width:5%">Id</th>
                            <th style="width:10%">Incluido en el Informe</th>
                            <th style="width:5%">Orden</th>
                            <th style="width:70%">Párrafo</th>
                            <th style="width:10%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($parrafos->count() > 0)
                            @foreach ($parrafos as $parrafo)
                                <tr>
                                    <td style="text-align:center;vertical-align:middle">{{ $parrafo->id }}</td>
                                    <td style="text-align:center;vertical-align:middle"><input
                                            id="status{{ $parrafo->id }}"type="checkbox" class="form-control"
                                            @if ($parrafo->status) checked @endif
                                            onchange="updateStatus({{ $parrafo->id }},$(this).prop('checked'))"></td>
                                    <td style="text-align:center;vertical-align:middle"><input
                                            id="orden{{ $parrafo->id }}" type="number" class="" size="1"
                                            style="width: 50px;text-align:center" value="{{ $parrafo->orden }}"
                                            onchange="updateOrden({{ $parrafo->id }},$(this).val())" /></td>
                                    <td style="text-align: justify;padding:20px">{{ $parrafo->resultado }}</td>
                                    <td style="text-align: center;vertical-align:middle">
                                        <button class="btn btn-primary" title="Editar párrafo" data-toggle="tooltip"
                                    data-placement="top"
                                            onclick="getInfoPlantilla({{ $parrafo->id }},{{ $parrafo->tipo }})"> <i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-dark" title="Cargar Complementos" data-toggle="tooltip"
                                    data-placement="top"
                                            onclick="showComplementos({{ $parrafo->id }})"> <i
                                                class="fas fa-upload"></i></button>
                                        <button class="btn btn-danger" onclick="deleteParrafo({{$parrafo->id}})" title="Eliminar párrafo" data-toggle="tooltip"
                                            data-placement="top">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="alert alert-info" style="text-align: center">No existen párrafos
                                    registrados!</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </center>
        </div>
    </div>
    <div class="modal fade" id="parrafoModal" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="accionModalLabel">Redactar Párrafo</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="parrafo_id">
                    <div>
                        <p><b>Instrucciones:</b> Selecciona una plantilla de párrafo para comenzar con la redacción</p>
                    </div>
                    <div class="" id="seleccionPlantilla">
                        <input type="hidden" id="plantillaElegida">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 50%;padding:15px;">
                                    <button class="btn btn-light" style="height:300px;text-align:justify"
                                        onclick="showPlantilla(1)">
                                        <h1>Plantilla 1</h1>
                                        Con el objetivo de [<b class="campo">describir objetivo</b>], del [<b
                                            class="campo">periodo de reporte</b>] el Gobierno del Estado, a través de [<b
                                            class="campo">nombre institución (SIGLAS)</b>], mediante una inversión de [<b
                                            class="campo">monto de inversión</b>], como parte del [<b
                                            class="campo">programa, proyecto</b>], proporcionó [<b class="campo">bien o
                                            servicio otorgado</b>] en beneficio de [<b class="campo">número total personas
                                            (número total mujeres y número total hombres)</b>], en [<b
                                            class="campo">regiones o municipios atendidos</b>], [<b
                                            class="campo">Impacto de la acción en la sociedad</b>].
                                    </button>
                                </td>
                                <td style="width: 50%;padding:15px;">
                                    <button class="btn btn-light"
                                        style="height:300px;text-align:justify;display:table-cell;vertical-align:top"
                                        onclick="showPlantilla(2)">
                                        <h1>Plantilla 2</h1>
                                        Como parte del [<b class="campo">programa, proyecto</b>], el Gobierno de la
                                        Primavera Oaxaqueña, a través de [<b class="campo">nombre institución
                                            (SIGLAS)</b>], con el propósito de [<b class="campo">describir propósito</b>],
                                        durante [<b class="campo">periodo de reporte</b>], con una inversión de [<b
                                            class="campo">monto de inversión</b>], realizó [<b class="campo">obra o
                                            acción
                                            realizada</b>], lo cual benefició a [<b class="campo">número total personas
                                            (número total mujeres y número total hombres)</b>], en [<b
                                            class="campo">regiones o municipios atendidos</b>], [<b
                                            class="campo">Impacto de la acción en la sociedad</b>].
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;padding:15px;">
                                    <button class="btn btn-light"
                                        style="height:300px;text-align:justify;display:table-cell;vertical-align:top"
                                        onclick="showPlantilla(3)">
                                        <h1>Plantilla 3</h1>
                                        Mediante una inversión de [<b class="campo">monto de inversión</b>], por medio del
                                        [<b class="campo">programa, proyecto</b>], el Gobierno de la Transformación, a
                                        través de [<b class="campo">nombre institución (SIGLAS)</b>], a fin de [<b
                                            class="campo">describir objetivo</b>], del [<b class="campo">periodo de
                                            reporte</b>], brindó [<b class="campo">bien o servicio otorgado</b>], esta
                                        acción permitió beneficiar a [<b class="campo">número total personas (número total
                                            mujeres y número total hombres)</b>], en [<b class="campo">regiones o
                                            municipios atendidos</b>]. [<b
                                            class="campo">Impacto de la acción en la sociedad</b>].
                                    </button>
                                </td>
                                <td style="width: 50%;padding:15px;">
                                    <button class="btn btn-light" style="width:100%;height:300px;text-align:center;"
                                        onclick="showPlantilla(4)">
                                        <h1>[Párrafo Libre]</h1>
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="width: 100%;padding-left:100px;padding-right:100px;padding-top:30px;padding-bottom:30px;font-size:1.2em;border:solid 1px gray; display:none"
                        id="plantilla1">
                        <div style="width: 100%;text-align:left">
                            <button class="btn btn-light" onclick="backPlantillas(1)"><i class="fas fa-arrow-left"></i>
                                Regresar a las plantillas</button>
                        </div>
                        <center>
                            <hr />
                            <h4>Plantilla 1 (captura)</h4>
                            <hr />
                            <p style="text-align: justify">
                                Con el objetivo de <input type="text" class="campo_text p1c" name="campo[]"
                                    placeholder="describir objetivo" onkeyup="resize(this)" maxlength="100"
                                    campo="p1-c1" />, del <input type="text" class="campo_text p1c" name="campo[]"
                                    placeholder="periodo de reporte" maxlength="100" onkeyup="resize(this)"
                                    campo="p1-c2" /> el Gobierno del Estado, a través de <input type="text"
                                    class="campo_text p1c" name="campo[]" placeholder="institucion (SIGLAS)"
                                    onkeyup="resize(this)" campo="p1-c3" maxlength="100" />, mediante una
                                inversión de <input type="text" class="campo_text p1c" name="campo[]"
                                    placeholder="monto de inversión" onkeyup="resize(this)" campo="p1-c4" maxlength="100" />, como parte
                                del <input type="text" class="campo_text p1c" name="campo[]"
                                    placeholder="programa, proyecto" onkeyup="resize(this)" campo="p1-c5" maxlength="100" />,
                                proporcionó
                                <input type="text" class="campo_text p1c" name="campo[]"
                                    placeholder="bien o servicio otorgado" onkeyup="resize(this)" campo="p1-c6" maxlength="100" /> en
                                beneficio de <input type="text" class="campo_text p1c" name="campo[]"
                                    placeholder="total de personas" onkeyup="resize(this)" campo="p1-c7" maxlength="100" />, en <input
                                    type="text" class="campo_text p1c" name="campo[]"
                                    placeholder="regiones o municipios atendidos" onkeyup="resize(this)"
                                    campo="p1-c8" maxlength="100" />, <input
                                    type="text" class="campo_text p1c" name="campo[]"
                                    placeholder="Impacto de la acción en la sociedad" onkeyup="resize(this)"
                                    campo="p1-c9" maxlength="100" />
                            </p>
                        </center>
                        <center>

                            <hr />
                            <h4>Párrafo resultante</h4>
                            <hr />
                            <p style="text-align: justify">
                                Con el objetivo de <span id="p1-c1"></span>, del <span id="p1-c2"></span> el
                                Gobierno del Estado, a través de <span id="p1-c3"></span>, mediante una
                                inversión de <span id="p1-c4"></span>, como parte del <span id="p1-c5"></span>,
                                proporcionó
                                <span id="p1-c6"></span> en beneficio de <span id="p1-c7"></span>, en <span
                                    id="p1-c8"></span>, <span
                                    id="p1-c9"></span>.
                            </p>

                        </center>
                    </div>
                    <div style="width: 100%;padding-left:100px;padding-right:100px;padding-top:30px;padding-bottom:30px;font-size:1.2em;border:solid 1px gray; display:none"
                        id="plantilla2">
                        <div style="width: 100%;text-align:left">
                            <button class="btn btn-light" onclick="backPlantillas(2)"><i class="fas fa-arrow-left"></i>
                                Regresar a las plantillas</button>
                        </div>
                        <center>
                            <hr />
                            <h4>Plantilla 2 (captura)</h4>
                            <hr />
                            <p style="text-align: justify">
                                Como parte del <input type="text" class="campo_text p2c" name="campo[]"
                                    placeholder="programa o proyecto" onkeyup="resize(this)" maxlength="100"
                                    campo="p2-c1" />, el Gobierno de la
                                Primavera Oaxaqueña, a través de <input type="text" class="campo_text p2c"
                                    name="campo[]" placeholder="Institución (SIGLAS)" onkeyup="resize(this)"
                                    maxlength="100" campo="p2-c2" />, con el propósito de <input type="text"
                                    class="campo_text p2c" name="campo[]" placeholder="proposito" onkeyup="resize(this)"
                                    maxlength="100" campo="p2-c3" />, durante <input type="text"
                                    class="campo_text p2c" name="campo[]" placeholder="periodo de reporte"
                                    onkeyup="resize(this)" maxlength="100" campo="p2-c4" />, con una inversión de <input
                                    type="text" class="campo_text p2c" name="campo[]"
                                    placeholder="monto de inversión" onkeyup="resize(this)" maxlength="100"
                                    campo="p2-c5" />, realizó <input type="text" class="campo_text p2c"
                                    name="campo[]" placeholder="obra o accion realizada" onkeyup="resize(this)"
                                    maxlength="100" campo="p2-c6" />, lo cual benefició a <input type="text"
                                    class="campo_text p2c" name="campo[]" placeholder="total de personas beneficiadas"
                                    onkeyup="resize(this)" maxlength="100" campo="p2-c7" />, en <input type="text"
                                    class="campo_text p2c" name="campo[]" placeholder="regiones o municipios"
                                    onkeyup="resize(this)" maxlength="100" campo="p2-c8" />, <input
                                    type="text" class="campo_text p2c" name="campo[]"
                                    placeholder="Impacto de la acción en la sociedad" onkeyup="resize(this)"
                                    campo="p2-c9" maxlength="100" />.
                            </p>
                        </center>
                        <center>
                            <hr />
                            <h4>Párrafo resultante</h4>
                            <hr />
                            <p style="text-align: justify">
                                Como parte del <span id="p2-c1"></span>, el Gobierno de la
                                Primavera Oaxaqueña, a través de <span id="p2-c2"></span>, con el propósito de <span
                                    id="p2-c3"></span>, durante <span id="p2-c4"></span>, con una inversión de
                                <span id="p2-c5"></span>, realizó <span id="p2-c6"></span>, lo cual benefició a
                                <span id="p2-c7"></span>, en <span id="p2-c8"></span>,<span id="p2-c9"></span>.
                            </p>

                        </center>
                    </div>
                    <div style="width: 100%;padding-left:100px;padding-right:100px;padding-top:30px;padding-bottom:30px;font-size:1.2em;border:solid 1px gray; display:none"
                        id="plantilla3">
                        <div style="width: 100%;text-align:left">
                            <button class="btn btn-light" onclick="backPlantillas(3)"><i class="fas fa-arrow-left"></i>
                                Regresar a las plantillas</button>
                        </div>
                        <center>
                            <hr />
                            <h4>Plantilla 3 (captura)</h4>
                            <hr />
                            <p style="text-align: justify">
                                Mediante una inversión de <input type="text" class="campo_text p3c" name="campo[]"
                                    placeholder="monto de inversión" onkeyup="resize(this)" maxlength="100"
                                    campo="p3-c1" />, por medio del
                                <input type="text" class="campo_text p3c" name="campo[]"
                                    placeholder="programa, proyecto" onkeyup="resize(this)" maxlength="100"
                                    campo="p3-c2" />, el Gobierno de la Transformación, a
                                través de <input type="text" class="campo_text p3c" name="campo[]"
                                    placeholder="Institución (SIGLAS)" onkeyup="resize(this)" maxlength="100"
                                    campo="p3-c3" />, a fin de <input type="text" class="campo_text p3c"
                                    name="campo[]" placeholder="describir objetivo" onkeyup="resize(this)"
                                    maxlength="100" campo="p3-c4" />, del <input type="text" class="campo_text p3c"
                                    name="campo[]" placeholder="periodo de reporte" onkeyup="resize(this)"
                                    maxlength="100" campo="p3-c5" />, brindó <input type="text"
                                    class="campo_text p3c" name="campo[]" placeholder="bien o servicio otorgado"
                                    onkeyup="resize(this)" maxlength="100" campo="p3-c6" />, esta
                                acción permitió beneficiar a <input type="text" class="campo_text p3c" name="campo[]"
                                    placeholder="total de beneficiados" onkeyup="resize(this)" maxlength="100"
                                    campo="p3-c7" />, en <input type="text" class="campo_text p3c" name="campo[]"
                                    placeholder="regiones o municipios atendidos" onkeyup="resize(this)" maxlength="100"
                                    campo="p3-c8" />. <input
                                    type="text" class="campo_text p3c" name="campo[]"
                                    placeholder="Impacto de la acción en la sociedad" onkeyup="resize(this)"
                                    campo="p3-c9" maxlength="100"/>.
                            </p>
                        </center>
                        <center>
                            <hr />
                            <h4>Párrafo resultante</h4>
                            <hr />
                            <p style="text-align: justify">
                                Mediante una inversión de <span id="p3-c1"></span>, por medio del
                                <span id="p3-c2"></span>, el Gobierno de la Transformación, a
                                través de <span id="p3-c3"></span>, a fin de <span id="p3-c4"></span>, del <span
                                    id="p3-c5"></span>, brindó <span id="p3-c6"></span>, esta
                                acción permitió beneficiar a <span id="p3-c7"></span>, en <span
                                    id="p3-c8"></span>. <span
                                    id="p3-c9"></span>.
                            </p>

                        </center>
                    </div>
                    <div style="width: 100%;padding-left:100px;padding-right:100px;padding-top:30px;padding-bottom:30px;font-size:1.2em;border:solid 1px gray; display:none"
                        id="plantilla4">
                        <div style="width: 100%;text-align:left">
                            <button class="btn btn-light" onclick="backPlantillas(4)"><i class="fas fa-arrow-left"></i>
                                Regresar a las plantillas</button>
                        </div>
                        <center>
                            <hr />
                            <h4>Párrafo libre</h4>
                            <hr />
                            <textarea name="" id="parrafoLibre" class="form-control" rows="7"
                                style="font-size:1.3em;text-align:justify" onkeyup="countLetters(this)" maxlength="510"></textarea>
                            <span id="cuenta">0</span>/510
                        </center>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="button" onclick="saveParrafo()">Almacenar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="complementosModal" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="accionModalLabel">Carga de complementos</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <h2>Complementos cargados</h2>
                    <div id="complementosCargados" style="min-height:200px; max-height: 300px;overflow:scroll;">

                    </div>
                    <h2>Área de carga de complementos</h2>
                    <div class="">
                        <form action="{{ route('informe.uploadcomplemento') }}" method="POST"
                            enctype="multipart/form-data" class="dropzone" id="medios-informe" style="color:blue">
                            @csrf
                            <input type="hidden" name="idParrafo" id="idParrafo" value="">
                        </form>
                    </div>
                </div>


                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="button" onclick="saveComplementos()">Almacenar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link href="{{ asset('resources/css/dropzone.css') }}" rel="stylesheet" type="text/css">
    <style>
        th {
            background-color: gray;
            color: white;
        }

        .field {
            background-color: gray;
            color: white;
            padding: 10px;
        }

        .value {
            padding: 10px;
            font-size: 1.3em;
            color: black;
            border-bottom: solid 1px gray;
        }

        .campo {
            color: purple
        }

        .campo_text {
            max-width: 400px;
            border: none;
            margin: 3px;
            background-color: rgb(219, 219, 219);

        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('resources/js/dropzone-min.js') }}"></script>
    <script>
        var miareadecarga = null;
        $(document).ready(function() {
            $("#collapseInforme").addClass("show");
            $("#informecarga").css('background-color', "rgb(217, 217, 217)");
            $("#tableParrafos").DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 20],
                order: [
                    [0, 'asc']
                ],
            })
            inicializaDropZone();
        });

        function resize(elemento) {
            contador = $(elemento).val().length;
            if (contador > 0)
                $(elemento).prop("size", $(elemento).val().length);
            else
                $(elemento).css("min-width", "200px");

            $("#" + $(elemento).attr("campo")).html($(elemento).val());
        }

        function showParrafoModal() {
            $("#parrafo_id").val("");
            $("#plantilla1").hide("fast");
            $("#plantilla2").hide("fast");
            $("#plantilla3").hide("fast");
            $("#plantilla4").hide("fast");
            $("#seleccionPlantilla").show("show");
            $("#parrafoModal").modal("show");
        }

        function showPlantilla(plantilla) {
            $("#plantillaElegida").val(plantilla);
            $("#seleccionPlantilla").hide("slow");
            $("#plantilla" + plantilla).show("slow");
        }

        function backPlantillas(plantilla) {
            $("#plantillaElegida").val("");
            $("#plantilla" + plantilla).hide("slow");
            $("#seleccionPlantilla").show("slow");
        }

        function countLetters() {
            count = $("#parrafoLibre").val().length;
            $("#cuenta").html(count);
        }

        function saveParrafo() {
            accion_id = $("#accion_id").val();
            plantilla = $("#plantillaElegida").val();
            campos = "";
            texto = "";
            parrafo_id = $("#parrafo_id").val();
            if (plantilla != "") {
                if (plantilla <= 3) {
                    $(".p" + plantilla + "c").each(function() {
                        campos += $(this).val() + "|";
                    });
                } else {
                    texto = $("#parrafoLibre").val();
                }

                $.ajax({
                    type: 'POST',
                    url: "{{ route('informe.almacenap') }}",
                    data: {
                        parrafo_id: parrafo_id,
                        accion_id: accion_id,
                        plantilla: plantilla,
                        campos: campos,
                        texto: texto,
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
                                title: 'Párrafo almacenado satisfactoriamente!',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {
                                //window.location.replace("{{ route('informe.acciones') }}");
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ocurrió un error al intentar almacenar el Párrafo',
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

        function updateOrden(parrafo, orden) {
            $.ajax({
                type: 'POST',
                url: "{{ route('informe.updateordenparrafo') }}",
                data: {
                    parrafo: parrafo,
                    orden: orden,
                    _token: $("input[name='_token']").val()
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true)
                },
                success: function(response) {
                    if (response.result == "ok") {
                        $("#orden" + parrafo).css("border", "solid 1px green")
                    } else {
                        $("#orden" + parrafo).css("border", "solid 1px red")
                    }
                }
            }).done(function(response) {
                block(false);
            }).fail(function(data) {
                block(false);
            })
        }

        function updateStatus(parrafo, status) {
            $.ajax({
                type: 'POST',
                url: "{{ route('informe.updatestatusparrafo') }}",
                data: {
                    parrafo: parrafo,
                    status: status,
                    _token: $("input[name='_token']").val()
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true)
                },
                success: function(response) {
                    if (response.result == "ok") {
                        $("#status" + parrafo).css("border", "solid 1px green")
                    } else {
                        $("#status" + parrafo).prop("checked", !status);
                        $("#status" + parrafo).css("border", "solid 1px red")
                    }
                }
            }).done(function(response) {
                block(false);
            }).fail(function(data) {
                block(false);
            })
        }

        function getInfoPlantilla(parrafo, plantilla) {
            $("#plantilla1").hide("slow");
            $("#plantilla2").hide("slow");
            $("#plantilla3").hide("slow");
            $("#plantilla4").hide("slow");
            $("#plantillaElegida").val(plantilla);
            $("#seleccionPlantilla").hide("slow");
            $("#plantilla" + plantilla).show("slow");
            $("#parrafo_id").val(parrafo);

            //obtenemos la informacion del parrafo
            $.ajax({
                type: 'GET',
                url: "{{ route('informe.getinfoparrafo') }}",
                data: {
                    parrafo: parrafo,
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true)
                },
                success: function(response) {
                    if (response.result == "ok") {
                        if (response.parrafo.tipo != 4) {
                            campos = response.parrafo.campos.split("|");
                            $("#p" + response.parrafo.tipo + "-c1").html(campos[0]);
                            $("#p" + response.parrafo.tipo + "-c2").html(campos[1]);
                            $("#p" + response.parrafo.tipo + "-c3").html(campos[2]);
                            $("#p" + response.parrafo.tipo + "-c4").html(campos[3]);
                            $("#p" + response.parrafo.tipo + "-c5").html(campos[4]);
                            $("#p" + response.parrafo.tipo + "-c6").html(campos[5]);
                            $("#p" + response.parrafo.tipo + "-c7").html(campos[6]);
                            $("#p" + response.parrafo.tipo + "-c8").html(campos[7]);
                            $("#p" + response.parrafo.tipo + "-c9").html(campos[8]);
                            $("input[campo='p" + response.parrafo.tipo + "-c1'").val(campos[0]);
                            $("input[campo='p" + response.parrafo.tipo + "-c2'").val(campos[1]);
                            $("input[campo='p" + response.parrafo.tipo + "-c3'").val(campos[2]);
                            $("input[campo='p" + response.parrafo.tipo + "-c4'").val(campos[3]);
                            $("input[campo='p" + response.parrafo.tipo + "-c5'").val(campos[4]);
                            $("input[campo='p" + response.parrafo.tipo + "-c6'").val(campos[5]);
                            $("input[campo='p" + response.parrafo.tipo + "-c7'").val(campos[6]);
                            $("input[campo='p" + response.parrafo.tipo + "-c8'").val(campos[7]);
                            $("input[campo='p" + response.parrafo.tipo + "-c9'").val(campos[8]);
                        } else {
                            $("#parrafoLibre").val(response.parrafo.resultado);
                            countLetters();

                        }
                    }
                }
            }).done(function(response) {
                block(false);
            }).fail(function(data) {
                block(false);
            })

            $("#parrafoModal").modal("show");
        }

        function showComplementos(idParrafo) {
            getComplementos(idParrafo);
            $("#idParrafo").val(idParrafo);
            miareadecarga.emit("resetFiles");
            $("#complementosModal").modal("show");
        }

        function inicializaDropZone() {
            miareadecarga = new Dropzone("#medios-informe", {
                thumbnailWidth: 500,
                maxFilesize: 5,
                //disablePreviews:true,
                acceptedFiles: ".jpg,.jpeg,.png,.tiff,.raw,.pdf,.zip,.docx,.xlsx,.doc,.xls,application/x-zip-compressed,application/zip",
                buttonRemove: true
            });
            miareadecarga.on("addedfile", file => {
                //idIndicador = $("#idIndicador").val();
            });

            miareadecarga.on("success", function(file, response) {
                if (response.result == "ok") {
                    getComplementos($("#idParrafo").val());
                }
            });
        }

        function getComplementos(idParrafo) {
            $.ajax({
                type: 'GET',
                url: "{{ route('informe.getcomplementos') }}",
                data: {
                    idParrafo: idParrafo
                },
                //dataType: 'json',
                beforeSend: function() {
                    block(true)
                },
                success: function(response) {
                    $("#complementosCargados").html(response);
                }
            }).done(function(response) {
                block(false);
            }).fail(function(data) {
                block(false);
            })
        }

        function removeComplemento(idComplemento) {
            Swal.fire({
                title: '¿Está Seguro?',
                text: "No será posible recuperar el complemento cargado una vez eliminado!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('informe.deletecomplemento') }}",
                        data: {
                            idParrafo: $("#idParrafo").val(),
                            idComplemento: idComplemento,
                            _token: $("input[name='_token']").val()
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            block(true)
                        }
                    }).done(function(response) {
                        if (response.result == "ok") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Complementos eliminados',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {
                                $("#rowcomplemento" + idComplemento).hide('slow');
                                setTimeout(function() {
                                    $("#rowcomplemento" + idComplemento).remove()
                                }, 200);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Complementos cargados',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {});
                        }
                        block(false)
                    }).fail(function(data) {
                        block(false)
                    });
                }
            });

        }

        function saveComplementos() {
            //obtenemos los ids de complementos
            complementos = "";
            descripciones = "";

            if ($(".complemento").length > 0) {

                $(".complemento").each(function() {
                    complementos += $(this).attr("complemento") + "|";
                });

                $(".descripcion").each(function() {
                    descripciones += $(this).val() + "|";
                })

                $.ajax({
                    type: 'POST',
                    url: "{{ route('informe.savecomplementos') }}",
                    data: {
                        complementos:complementos,
                        descripciones: descripciones,
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {
                    if (response.result == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Complementos almacenados',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            location.reload();
                        });

                    }
                    block(false)
                }).fail(function(data) {
                    block(false)
                });
            }
        }

        function deleteParrafo(idParrafo){
            Swal.fire({
                title: '¿Está Seguro?',
                text: "Este párrafo será eliminado permanentemente, así como los complementos cargados!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('informe.deleteparrafo') }}",
                        data: {
                            idParrafo: idParrafo,
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
                                    title: 'Párrafo Eliminado',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                }).then((result) => {location.reload();});
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Ocurrió un error al intentar eliminar el párrafo corrrespondiente',
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

        function checkCountParrafos(){
            accion_id = $("#accion_id").val();
            $.ajax({
                    type: 'POST',
                    url: "{{ route('informe.checkparrafos') }}",
                    data: {
                        accion_id: accion_id,
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        block(true)
                    },
                    success: function(response) {
                        if (response.result == "ok") {
                            showParrafoModal()
                        } else {
                            Swal.fire({
                                icon: 'info',
                                title: 'Cantidad de Párrafos por Acción',
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
    </script>
@endsection
