@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Plan Estatal de Desarrollo 2022 - 2028</h1>
@endsection

@section('content')
    <style>
        .eje {
            cursor: pointer;
            border-bottom: solid 5px white !important;
        }

        .eje:hover {
            /*box-shadow: 10px 10px 10px #681b2e!important;*/
            border-bottom: solid 5px gray !important;
        }

        .trans:hover {
            color: gray
        }

        .selected {
            background-color: #dfc3ca!important;
            color: black;
        }
    </style>
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background-color: #681b2e;">
                <h6 class="m-0 font-weight-bold text-light">PED 2022 - 2028</h6>
            </div>
            <div class="card-body">
                <center>
                    <p style="width:90%;text-align:justify">

                    </p>
                    <table style="width: 100%;text-align:center">

                    </table>
                    <div style="width: 100%">
                        <img style="width:200px;" src="{{ asset('resources/images/logo_ped.png') }}" </div>
                        <table style="color:white;text-align:center;font-size:1.3em;border:solid 1px white">
                            <tr>
                                <td class="eje" onclick="showTemas(1)" id="eje1"
                                    style="background-color: rgb(129,78,147);width:20%;padding:10px;height:250px;cursor:pointer;border:solid 10px white;border-radius:40px;">
                                    <!--<img style="width: 100px;" src="{{ asset('resources/images/ped.png') }}" /><br /><br />-->
                                    1. Estado de Bienestar para todas las oaxaqueñas y oaxaqueños
                                </td>
                                <td class="eje" onclick="showTemas(2)" id="eje2"
                                    style="background-color: rgb(222,98,109);width:20%;padding:10px;height:250px;cursor:pointer;border:solid 10px white;border-radius:40px;">
                                    <!--<img style="width: 100px;" src="{{ asset('resources/images/ped.png') }}" /><br /><br />-->
                                    2. Gobierno honesto, cercano y Transparente al servicio de los pueblos y comunidades
                                </td>
                                <td class="eje" onclick="showTemas(3)" id="eje3"
                                    style="background-color: rgb(83,182,170);width:20%;padding:10px;height:250px;cursor:pointer;border:solid 10px white;border-radius:40px;">
                                    <!--<img style="width: 100px;" src="{{ asset('resources/images/ped.png') }}" /><br /><br />-->
                                    3. Seguridad y justicia para vivir en paz
                                </td>
                                <td class="eje" onclick="showTemas(4)" id="eje4"
                                    style="background-color: rgb(96,120,172);width:20%;padding:10px;height:250px;cursor:pointer;border:solid 10px white;border-radius:40px;">
                                    <!--<img style="width: 100px;" src="{{ asset('resources/images/ped.png') }}" /><br /><br />-->
                                    4. Crecimiento y desarrollo económico para las ocho regiones
                                </td>
                                <td class="eje" onclick="showTemas(5)" id="eje5"
                                    style="background-color: rgb(114,184,90);width:20%;padding:10px;height:250px;cursor:pointer;border:solid 10px white;border-radius:40px;">
                                    <!--<img style="width: 100px;" src="{{ asset('resources/images/ped.png') }}" /><br /><br />-->
                                    5. Infraestructura y servicios públicos para el desarrollo de Oaxaca
                                </td>
                            </tr>
                            <tr>
                                <td><img style="width: 100px;" src="{{ asset('resources/images/trans.png') }}" /></td>
                                <td><img style="width: 100px;" src="{{ asset('resources/images/trans.png') }}" /></td>
                                <td><img style="width: 100px;" src="{{ asset('resources/images/trans.png') }}" /></td>
                                <td><img style="width: 100px;" src="{{ asset('resources/images/trans.png') }}" /></td>
                                <td><img style="width: 100px;" src="{{ asset('resources/images/trans.png') }}" /></td>
                            </tr>
                            <tr>
                                <td colspan="5" style="width: 20%">
                                    <div
                                        style="width:100%;color:black;background-color: rgb(255, 255, 255);padding:5px;border:solid 2px rgb(222,98,109);border-radius:30px;">
                                        <p class="trans" style="font-size:.8em!important;cursor: pointer;"
                                            onclick="showTemas(6)">Igualdad de género</p>
                                        <p class="trans" style="font-size:.8em!important;cursor: pointer;"
                                            onclick="showTemas(7)">Desarrollo sostenible</p>
                                        <p class="trans" style="font-size:.8em!important;cursor: pointer;"
                                            onclick="showTemas(8)">Interculturalidad</p>
                                        <p class="trans" style="font-size:.8em!important;cursor: pointer;"
                                            onclick="showTemas(9)">Niños, Niñas y Adolescentes</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                </center>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_temas" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title">Temas del Eje: <span id="ejedescripcion"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding:25px;" id="modal-body-temas">

                    <div class="row">
                        <div class="col-xl-12 col-lg-7">
                            <nav>
                                <div class="nav nav-tabs nav-fill justify-content-center" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-temas-tab" data-toggle="tab"
                                        href="#nav-temas" role="tab" aria-controls="nav-profile"
                                        aria-selected="false">Temas<span id="temasseleccionado"></span></a>
                                    <a class="nav-item nav-link" id="nav-objetivos-tab" data-toggle="tab"
                                        href="#nav-objetivos" role="tab" aria-controls="nav-contact"
                                        aria-selected="false">Objetivos<span id="objetivosseleccionado"></span></a>
                                    <a class="nav-item nav-link" id="nav-estrategias-tab" data-toggle="tab"
                                        href="#nav-estrategias" role="tab" aria-controls="nav-contact"
                                        aria-selected="false">Estrategias<span id="estrategiasseleccionado"></span></a>
                                    <a class="nav-item nav-link" id="nav-lineas-tab" data-toggle="tab"
                                        href="#nav-lineas" role="tab" aria-controls="nav-contact"
                                        aria-selected="false">Lineas<span id="lineasseleccionado"></span></a>
                                </div>
                            </nav>
                            <hr />
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-temas" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <center>
                                        <table class="table" style="width: 80%">
                                            <thead>
                                                <tr>
                                                    <th>Clave de Tema</th>
                                                    <th>Descrpcion</th>
                                                    <th>Objetivos</th>
                                                </tr>
                                            </thead>
                                            <tbody id="temasrows">

                                            </tbody>
                                        </table>
                                    </center>
                                </div>
                                <div class="tab-pane fade" id="nav-objetivos" role="tabpanel"
                                    aria-labelledby="nav-contact-tab">
                                    <center>
                                        <table class="table" style="width: 80%">
                                            <thead>
                                                <tr>
                                                    <th>Clave del Objetivo</th>
                                                    <th>Descrpcion</th>
                                                    <th>Estratégias</th>
                                                </tr>
                                            </thead>
                                            <tbody id="objetivosrows">

                                            </tbody>
                                        </table>
                                    </center>
                                </div>
                                <div class="tab-pane fade" id="nav-estrategias" role="tabpanel"
                                    aria-labelledby="nav-contact-tab">
                                    <center>
                                        <table class="table" style="width: 80%">
                                            <thead>
                                                <tr>
                                                    <th>Clave de la Estrategia</th>
                                                    <th>Descrpcion</th>
                                                    <th>Lineas de Accion</th>
                                                </tr>
                                            </thead>
                                            <tbody id="estrategiasrows">

                                            </tbody>
                                        </table>
                                    </center>
                                </div>
                                <div class="tab-pane fade" id="nav-lineas" role="tabpanel"
                                    aria-labelledby="nav-contact-tab">
                                    <center>
                                        <table class="table" style="width: 80%">
                                            <thead>
                                                <tr>
                                                    <th>Clave de la Línea de Acción</th>
                                                    <th>Descrpcion</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody id="lineasrows">

                                            </tbody>
                                        </table>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var color = "";

        function showTemas(eje) {
            color = "";
            switch (eje) {
                case 1:
                    color = "rgb(129,78,147)";
                    break;
                case 2:
                    color = "rgb(222,98,109)";
                    break;
                case 3:
                    color = "rgb(83,182,170)";

                    break;
                case 4:
                    color = "rgb(96,120,172)";
                    break;
                case 5:
                    color = "rgb(114,184,90)";
                    break;
            }

            $.ajax({
                type: 'GET',
                url: '{{ route('gettemas') }}',
                data: {
                    idEjePED: eje
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {
                block(false);
                cuerpo = "";
                if (response.success == "ok") {
                    ban = false;
                    for (x = 0; x < response.temas.length; x++) {
                        cuerpo += "<tr style='background-color:" + (ban ? '#F3F3F3' : 'white') + "' id='tema"+response.temas[x].idTemaPED+"' class='tema'>" +
                            "<td>" +
                            response.temas[x].temaPEDClave + "</td>" +
                            "<td>" +
                            response.temas[x].temaPEDDescripcion + "</td>" +
                            "<td>" +
                            "<button onclick='showObjetivos(" + response.temas[x].idTemaPED +
                            ")' class='btn btn-info' style='border:solid 1px " + color + ";background-color:" +
                            color + "'><i class='fas fa-info'></i></button>"
                        "</td>" +
                        "</tr>";
                        ban = !ban;
                    }
                    $("#temasrows").html(cuerpo);
                    $("#nav-temas-tab").click();
                    cuerpo="";
                    $("#objetivosrows").html(cuerpo);
                    $("#estrategiasrows").html(cuerpo);
                    $("#lineasrows").html(cuerpo);

                }

            }).fail(function(data) {
                block(false);
            })
            $("#ejedescripcion").html($("#eje" + eje).html());
            $("#modal_temas").modal("show");
        }

        function showObjetivos(temas_id) {
            $.ajax({
                type: 'GET',
                url: '{{ route('getobjetivos') }}',
                data: {
                    idTemaPED: temas_id
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {

                $(".tema").removeClass('selected');
                $("#tema"+temas_id).addClass('selected');
                block(false);
                cuerpo = "";
                if (response.success == "ok") {
                    ban = false;
                    for (x = 0; x < response.objetivos.length; x++) {
                        cuerpo += "<tr style='background-color:" + (ban ? '#F3F3F3' : 'white') + "' id='objetivo"+response.objetivos[x].idObjetivoPED+"' class='objetivo'>" +
                            "<td>" +
                            response.objetivos[x].objetivoPEDClave + "</td>" +
                            "<td>" +
                            response.objetivos[x].objetivoPEDDescripcion + "</td>" +
                            "<td>" +
                            "<button onclick='showEstrategias(" + response.objetivos[x].idObjetivoPED +
                            ")' class='btn btn-info' style='border:solid 1px " + color + ";background-color:" +
                            color + "'><i class='fas fa-info'></i></button>"
                        "</td>" +
                        "</tr>";
                        ban = !ban;
                    }
                    $("#objetivosrows").html(cuerpo);
                    $("#nav-objetivos-tab").click();

                }

            }).fail(function(data) {
                block(false);
            })
        }

        function showEstrategias(objetivos_id) {
            $.ajax({
                type: 'GET',
                url: '{{ route('getestrategias') }}',
                data: {
                    idObjetivoPED: objetivos_id
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {
                $(".objetivo").removeClass('selected');
                $("#objetivo"+objetivos_id).addClass('selected');
                block(false);
                cuerpo = "";
                if (response.success == "ok") {
                    ban = false;
                    for (x = 0; x < response.estrategias.length; x++) {
                        cuerpo += "<tr style='background-color:" + (ban ? '#F3F3F3' : 'white') + "' id='estrategia"+response.estrategias[x].idEstrategiaPED+"' class='estrategia'>" +
                            "<td>" +
                            response.estrategias[x].estrategiaPEDClave + "</td>" +
                            "<td>" +
                            response.estrategias[x].estrategiaPEDDescripcion + "</td>" +
                            "<td>" +
                            "<button onclick='showLineas(" + response.estrategias[x].idEstrategiaPED +
                            ")' class='btn btn-info' style='border:solid 1px " + color + ";background-color:" +
                            color + "'><i class='fas fa-info'></i></button>"
                        "</td>" +
                        "</tr>";
                        ban = !ban;
                    }
                    $("#estrategiasrows").html(cuerpo);
                    $("#nav-estrategias-tab").click();
                }
            }).fail(function(data) {
                block(false);
            })
        }

        function showLineas(estrategias_id) {
            $.ajax({
                type: 'GET',
                url: '{{ route('getlineas') }}',
                data: {
                    idEstrategiaPED: estrategias_id
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {
                $(".estrategia").removeClass('selected');
                $("#estrategia"+estrategias_id).addClass('selected');
                block(false);
                cuerpo = "";
                if (response.success == "ok") {
                    ban = false;
                    for (x = 0; x < response.lineas.length; x++) {
                        cuerpo += "<tr style='background-color:" + (ban ? '#F3F3F3' : 'white') + "'>" +
                            "<td>" +
                            response.lineas[x].laPEDClave + "</td>" +
                            "<td>" +
                            response.lineas[x].laPEDDescripcion + "</td>" +                            
                        "</tr>";
                        ban = !ban;
                    }
                    $("#lineasrows").html(cuerpo);
                    $("#nav-lineas-tab").click();
                }
            }).fail(function(data) {
                block(false);
            })
        }
    </script>
@endsection
