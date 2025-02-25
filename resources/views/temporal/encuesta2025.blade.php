@extends('layouts.temporal')
@section('content')
    <center>
        <div class="col-lg-5 mb-5">
            <!-- Pendientes IE -->
            <div class="card shadow mb-6">
                <div class="card-header py-4" style="background-color: #681b2e;padding-left: 60px;height:60px;">
                    <h6 class="m-0 font-weight-bold text-light text-right"></h6>
                </div>
                <img style="width:150px;position:absolute; top:-10px;" src="{{ asset('/images/logo_blanco.png') }}" />
                <div class="card-body">
                    <center style="overflow:auto">
                        <table class="table table-light" style="width: 100%">
                            <tbody>
                                <tr style="text-align: center">
                                    <td style="border: solid 1px rgb(175,119,130);vertical-align:middle"><img
                                            style="width:50%;" src="{{ asset('/images/siibien_colores.png') }}"</td>
                                    <td
                                        style=" vertical-align:middle;background-color:rgb(175,119,130);color:white; text-align:center">
                                        <h2>Encuesta de Satisfacción</h2>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                    </center>
                    <form novalidate method="POST" action="{{ route('registraencuesta') }}">
                        @csrf
                        <div class="row text-left" style="color: black">
                            <div class="col-lg-12 mb-12 py-3">
                                <h5>Instrucciones: Favor de contestar las siguientes preguntas seleccionando con base en la
                                    escala de satisfacción el nivel que usted considere</h5>
                                <table style="text-align: center;width:100%">
                                    <tr>
                                        <td>
                                            <img src="{{ asset('images/satisfaccion/satis1p.svg') }}" style="width: 50px;">
                                            <p>Malo</p>
                                        </td>
                                        <td>
                                            <img src="{{ asset('images/satisfaccion/satis2p.svg') }}" style="width: 50px;">
                                            <p>Regular</p>
                                        </td>
                                        <td>
                                            <img src="{{ asset('images/satisfaccion/satis3p.svg') }}" style="width: 50px;">
                                            <p>Bueno</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-lg-12 mb-12 py-3">
                                <label for="nombre">1.- la capacitación impartida me pareció:<span
                                        style="color: red">*</span></label>
                                <table style="text-align: center;width:100%">
                                    <tr>
                                        <td>
                                            <img class="satis" id="satis1p1"
                                                src="{{ asset('images/satisfaccion/satis1.svg') }}" style="width: 50px;"
                                                onclick="setSatis(1,'p1')">
                                        </td>
                                        <td>
                                            <img class="satis" id="satis2p1"
                                                src="{{ asset('images/satisfaccion/satis2.svg') }}" style="width: 50px;"
                                                onclick="setSatis(2,'p1')">
                                        </td>
                                        <td>
                                            <img class="satis" id="satis3p1"
                                                src="{{ asset('images/satisfaccion/satis3.svg') }}" style="width: 50px;"
                                                onclick="setSatis(3,'p1')">
                                        </td>
                                    </tr>
                                </table>
                                <input type="hidden" class="form-control py-4" id="p1" name="p1" placeholder=""
                                    value="{{ old('p1') }}">
                                @error('p1')
                                    <div class="alter alert-danger py-2 p-1">
                                        Indique que tan satisfecho está con la capacitación impartida.
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-12 mb-12 py-3">
                                <label for="nombre">2.- El tiempo asignado a la capacitación me pareció:<span
                                        style="color: red">*</span></label>
                                <table style="text-align: center;width:100%">
                                    <tr>
                                        <td>
                                            <img class="satis" id="satis1p2"
                                                src="{{ asset('images/satisfaccion/satis1.svg') }}" style="width: 50px;"
                                                onclick="setSatis(1,'p2')">
                                        </td>
                                        <td>
                                            <img class="satis" id="satis2p2"
                                                src="{{ asset('images/satisfaccion/satis2.svg') }}" style="width: 50px;"
                                                onclick="setSatis(2,'p2')">
                                        </td>
                                        <td>
                                            <img class="satis" id="satis3p2"
                                                src="{{ asset('images/satisfaccion/satis3.svg') }}" style="width: 50px;"
                                                onclick="setSatis(3,'p2')">
                                        </td>
                                    </tr>
                                </table>
                                <input type="hidden" class="form-control py-4" id="p2" name="p2" placeholder=""
                                    value="{{ old('p2') }}">
                                @error('p2')
                                    <div class="alter alert-danger py-2 p-1">
                                        Indique que tan satisfecho está con la capacitación impartida.
                                    </div>
                                @enderror


                            </div>
                            <div class="col-lg-12 mb-12 py-3">
                                <label for="nombre">3.- Los apoyos didácticos de la capacitación fueron: <span
                                        style="color: red">*</span></label>
                                <table style="text-align: center;width:100%">
                                    <tr>
                                        <td>
                                            <img class="satis" id="satis1p3"
                                                src="{{ asset('images/satisfaccion/satis1.svg') }}" style="width: 50px;"
                                                onclick="setSatis(1,'p3')">
                                        </td>
                                        <td>
                                            <img class="satis" id="satis2p3"
                                                src="{{ asset('images/satisfaccion/satis2.svg') }}" style="width: 50px;"
                                                onclick="setSatis(2,'p3')">
                                        </td>
                                        <td>
                                            <img class="satis" id="satis3p3"
                                                src="{{ asset('images/satisfaccion/satis3.svg') }}" style="width: 50px;"
                                                onclick="setSatis(3,'p3')">
                                        </td>
                                    </tr>
                                </table>
                                <input type="hidden" class="form-control py-4" id="p3" name="p3"
                                    placeholder="" value="{{ old('p3') }}">
                                @error('p3')
                                    <div class="alter alert-danger py-2 p-1">
                                        Indique que le parecio los apoyos didácticos de la capacitación.
                                    </div>
                                @enderror


                            </div>
                            <div class="col-lg-12 mb-12 py-3">
                                <label for="nombre">4.- ¿Como considera el manejo de los temas por parte de los
                                    capacitadores?<span style="color: red">*</span></label>
                                <table style="text-align: center;width:100%">
                                    <tr>
                                        <td>
                                            <img class="satis" id="satis1p4"
                                                src="{{ asset('images/satisfaccion/satis1.svg') }}" style="width: 50px;"
                                                onclick="setSatis(1,'p4')">
                                        </td>
                                        <td>
                                            <img class="satis" id="satis2p4"
                                                src="{{ asset('images/satisfaccion/satis2.svg') }}" style="width: 50px;"
                                                onclick="setSatis(2,'p4')">
                                        </td>
                                        <td>
                                            <img class="satis" id="satis3p4"
                                                src="{{ asset('images/satisfaccion/satis3.svg') }}" style="width: 50px;"
                                                onclick="setSatis(3,'p4')">
                                        </td>
                                    </tr>
                                </table>
                                <input type="hidden" class="form-control py-4" id="p4" name="p4"
                                    placeholder="" value="{{ old('p4') }}">
                                @error('p4')
                                    <div class="alter alert-danger py-2 p-1">
                                        Indique como considera el manejo de los temas por parte de los capacitadores.
                                    </div>
                                @enderror


                            </div>
                            <div class="col-lg-12 mb-12 py-3">
                                <label for="nombre">5.- El trato del Capacitador hacia los asistentes me pareció:<span
                                        style="color: red">*</span></label>
                                <table style="text-align: center;width:100%">
                                    <tr>
                                        <td>
                                            <img class="satis" id="satis1p5"
                                                src="{{ asset('images/satisfaccion/satis1.svg') }}" style="width: 50px;"
                                                onclick="setSatis(1,'p5')">
                                        </td>
                                        <td>
                                            <img class="satis" id="satis2p5"
                                                src="{{ asset('images/satisfaccion/satis2.svg') }}" style="width: 50px;"
                                                onclick="setSatis(2,'p5')">
                                        </td>
                                        <td>
                                            <img class="satis" id="satis3p5"
                                                src="{{ asset('images/satisfaccion/satis4.svg') }}" style="width: 50px;"
                                                onclick="setSatis(3,'p5')">
                                        </td>
                                    </tr>
                                </table>
                                <input type="hidden" class="form-control py-4" id="p5" name="p5"
                                    placeholder="" value="{{ old('p5') }}">
                                @error('p5')
                                    <div class="alter alert-danger py-2 p-1">
                                        Indique que le pareció el trato del capacitador hacia los asistentes.
                                    </div>
                                @enderror


                            </div>
                            <div class="col-lg-12 mb-12 py-3">
                                <label for="nombre"> 6.- ¿El capacitador resolvió las dudas de los asistentes?<span
                                        style="color: red">*</span></label>
                                <table style="text-align: center;width:100%">
                                    <tr>
                                        <td>
                                            <input type="radio" name="p6" value="si"> Si
                                        </td>
                                        <td>
                                            <input type="radio" name="p6" value="no"> No
                                        </td>
                                    </tr>
                                </table>
                                @error('p6')
                                    <div class="alter alert-danger py-2 p-1">
                                        Indique si el capacitador resolvió las dudas de los asistentes.
                                    </div>
                                @enderror




                            </div>
                            <div class="col-lg-12 mb-12 py-3">
                                <label for="p7">7.- Alguna recomendación o comentario respecto a la capacitación
                                    impartida</label>
                                <textarea class="form-control py-4" id="p7" name="p7">{{ old('p7') }}</textarea>
                            </div>

                            <div class="col-lg-12 mb-12 p-3 text-right">
                                <a href="{{ route('encuesta') }}"><button type="button"
                                        class="btn btn-secondary">Cancelar</button></a>
                                <button type="submit" class="btn" style="background-color: #681b2e; color:white">
                                    <h5>Almacenar Respuestas</h5>
                                </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </center>
    <style>
        .satis {
            cursor: pointer;
            border-bottom: solid 1px white;
        }

        .satis:hover {
            border-bottom: solid 1px gray;
        }
    </style>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            for (y = 1; y <= 6; y++) {
                if ($("#p" + y).val() != "") {
                    setSatis($("#p" + y).val(), 'p' + y);
                }
            }


        });


        function setSatis(satis, pregunta) {
            if ($("#satis" + satis + pregunta).attr('active') == "on") {
                $("#satis" + satis + pregunta).attr('active', "off");
                $("#satis" + satis + pregunta).attr('src', 'images/satisfaccion/satis' + satis + ".svg");
                $("#" + pregunta).val('');
            } else {
                $("#satis" + satis + pregunta).attr('active', "on");
                $("#satis" + satis + pregunta).attr('src', 'images/satisfaccion/satis' + satis + "p.svg");
                $("#" + pregunta).val(satis);
                for (x = 1; x <= 3; x++) {
                    if (x != satis) {
                        $("#satis" + x + pregunta).attr('active', "off");
                        $("#satis" + x + pregunta).attr('src', 'images/satisfaccion/satis' + x + ".svg");
                    }
                }
            }
        }
    </script>
@endsection
