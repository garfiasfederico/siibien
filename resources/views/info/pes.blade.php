@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Listado de Planes Estratégicos Sectoriales y Especiales 2022-2028</h1>
@endsection

@section('content')
    <style>

        #sectorimg img{
            width: 100px;
            background-color: #681b2e

        }
        .sector {
            cursor: pointer;
            border-bottom: solid 5px white !important;
            padding: 30px;
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
        .capital{
            color: #681b2e;
            font-weight: bold
        }

        .estrategico{
            width: 180px;
        }

        .estrategico:hover{
            background-color: rgb(243, 243, 243);

        }
    </style>
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background-color: #681b2e;">
                <h6 class="m-0 font-weight-bold text-light">Planes Estratégicos Sectoriales y Especiales 2022 - 2028</h6>
            </div>
            <div class="card-body">
                <center>
                    <div style="width: 90%">
                        <table style="color:white;text-align:center;font-size:1.3em;border:solid 1px white">
                            <tr><td colspan="5" style="font-size:2.5em;padding:15px;color:gray">
                                <span class="capital">P</span>lanes <span class="capital">E</span>stratégicos <span class="capital">S</span>ectoriales
                                <hr/>
                            </td></tr>
                            <tr>
                                <td class="sector" onclick="showObjetivos(1)" id="s1" descripcion="S1 Estado de Bienestar">
                                    <img class="estrategico"  src="{{ asset('images/main/areas/BIENESTAR.svg') }}" />
                                </td>
                                <td class="sector" onclick="showObjetivos(2)" id="s2" descripcion="S2 Educación">
                                    <img class="estrategico" src="{{ asset('images/main/areas/EDUCACION.svg') }}" />
                                </td>
                                <td class="sector" onclick="showObjetivos(3)" id="s3" descripcion="S3 Salud">
                                    <img class="estrategico" src="{{ asset('images/main/areas/SALUD.svg') }}" />
                                </td>
                                <td class="sector" onclick="showObjetivos(4)" id="s4" descripcion="S4 Gobierno Honesto, Cercano y Transparente">
                                    <img class="estrategico" src="{{ asset('images/main/areas/HONESTO.svg') }}" />
                                </td>
                                <td class="sector" onclick="showObjetivos(5)" id="s5" descripcion="S5 Seguridad y Justicia">
                                    <img class="estrategico" src="{{ asset('images/main/areas/SEGURIDAD.svg') }}" />
                                </td>
                            </tr>
                            <tr>
                                <td class="sector" onclick="showObjetivos(6)" id="s6" descripcion="S6 Crecimiento y Desarrollo Económico">
                                    <img class="estrategico" src="{{ asset('images/main/areas/ECONOMIA.svg') }}" />
                                </td>
                                <td class="sector" onclick="showObjetivos(7)" id="s7" descripcion="S7 Turismo">
                                    <img class="estrategico" src="{{ asset('images/main/areas/TURISMO.svg') }}" />
                                </td>
                                <td class="sector" onclick="showObjetivos(8)" id="s8" descripcion="S8 Fomento Agroalimentario y Desarrollo Rural">
                                    <img class="estrategico" src="{{ asset('images/main/areas/AGROALIMENTARIO.svg') }}" />
                                </td>
                                <td class="sector" onclick="showObjetivos(9)" id="s9" descripcion="S9 Infraestructuras y Sevicios Públicos">
                                    <img class="estrategico" src="{{ asset('images/main/areas/INFRAESTRUCTURA.svg') }}" />
                                </td>
                                <td class="sector" onclick="showObjetivos(10)" id="s10" descripcion="S10 Movilidad">
                                    <img class="estrategico" src="{{ asset('images/main/areas/MOVILIDAD.svg') }}" />
                                </td>
                            </tr>
                        </table>
                        <table style="color:white;text-align:center;font-size:1.3em;border:solid 1px white">
                            <tr>
                                <td colspan="4" style="font-size:2.5em;padding:15px;color:gray;text-align:center;">
                                    <span class="capital">P</span>lanes <span class="capital">E</span>speciales
                                    <hr/>
                                </td>
                            </tr>
                            <tr>
                                <td class="sector" onclick="showObjetivos(11)" id="s11" descripcion="E1 Igualdad de Gènero">
                                    <img class="estrategico" src="{{ asset('images/main/areas/IGUALDAD.svg') }}" />
                                </td>
                                <td class="sector" onclick="showObjetivos(12)" id="s12" descripcion="E2 Desarrollo Sostenible y Cambio Climático">
                                    <img class="estrategico" src="{{ asset('images/main/areas/SOSTENIBLE.svg') }}" />
                                </td>
                                <td class="sector" onclick="showObjetivos(13)" id="s13" descripcion="E3 Interculturalidad, Pueblos y Comunidades Indígenas y Afromexicanas">
                                    <img class="estrategico" src="{{ asset('images/main/areas/INTERCULTURALIDAD.svg') }}" />
                                </td>
                                <td class="sector" onclick="showObjetivos(14)" id="s14" descripcion="E4 Protecciòn Integral de Niñas, Niños y Adolescentes">
                                    <img class="estrategico" src="{{ asset('images/main/areas/NNA.svg') }}" />
                                </td>
                            </tr>
                        </table>
                </center>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_objetivos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title"><span id="sectorimg"></span> Objetivos del Plan Estratégico: <span id="sectoresdescripcion"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding:25px;" id="modal-body-temas">
                    <div class="row">
                        <div class="col-xl-12 col-lg-7">
                            <nav>
                                <div class="nav nav-tabs nav-fill justify-content-center" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-objetivos-tab" data-toggle="tab"
                                        href="#nav-objetivos" role="tab" aria-controls="nav-objetivos"
                                        aria-selected="false">Objetivos<span id="objetivosseleccionados"></span></a>
                                    <a class="nav-item nav-link" id="nav-estrategias-tab" data-toggle="tab"
                                        href="#nav-estrategias" role="tab" aria-controls="nav-estrategias"
                                        aria-selected="false">Estrategias<span id="estrategiasseleccionados"></span></a>
                                    <a class="nav-item nav-link" id="nav-productos-tab" data-toggle="tab"
                                        href="#nav-productos" role="tab" aria-controls="nav-productos"
                                        aria-selected="false">Productos<span id="productosselecionados"></span></a>
                                </div>
                            </nav>
                            <hr />
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-objetivos" role="tabpanel"
                                    aria-labelledby="nav-objetivos-tab">
                                    <center>
                                        <table class="table" style="width: 80%">
                                            <thead>
                                                <tr>
                                                    <th>Clave del Objetivo</th>
                                                    <th>Descrpcion</th>
                                                    <th>Estrategias</th>
                                                </tr>
                                            </thead>
                                            <tbody id="objetivosrows">

                                            </tbody>
                                        </table>
                                    </center>
                                </div>
                                <div class="tab-pane fade" id="nav-estrategias" role="tabpanel"
                                    aria-labelledby="nav-estrategias-tab">
                                    <center>
                                        <table class="table" style="width: 80%">
                                            <thead>
                                                <tr>
                                                    <th>Clave de la Estrategia</th>
                                                    <th>Descripción</th>
                                                    <th>Productos</th>
                                                </tr>
                                            </thead>
                                            <tbody id="estrategiasrows">

                                            </tbody>
                                        </table>
                                    </center>
                                </div>
                                <div class="tab-pane fade" id="nav-productos" role="tabpanel"
                                    aria-labelledby="nav-productos-tab">
                                    <center>
                                        <table class="table" style="width: 80%">
                                            <thead>
                                                <tr>
                                                    <th>Clave del Producto</th>
                                                    <th>Descrpcion</th>
                                                </tr>
                                            </thead>
                                            <tbody id="productosrows">

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

        function showObjetivos(sector) {
            $.ajax({
                type: 'GET',
                url: '{{ route('getobjetivossector') }}',
                data: {
                    idSector: sector
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
                    for (x = 0; x < response.objetivos.length; x++) {
                        cuerpo += "<tr style='background-color:" + (ban ? '#F3F3F3' : 'white') + "' id='objetivo"+response.objetivos[x].idObjetivo+"' class='objetivo'>" +
                            "<td>" +
                            response.objetivos[x].claveObjetivo + "</td>" +
                            "<td>" +
                            response.objetivos[x].objetivo + "</td>" +
                            "<td style='text-align:center'>" +
                            "<button onclick='showEstrategias(" + response.objetivos[x].idObjetivo +
                            ")' class='btn btn-primary'><i class='fas fa-info'></i></button>"
                        "</td>" +
                        "</tr>";
                        ban = !ban;
                    }
                    $("#objetivosrows").html(cuerpo);
                    $("#nav-objetivos-tab").click();
                    cuerpo="";
                    $("#estrategiasrows").html(cuerpo);
                    $("#productosrows").html(cuerpo);
                }

            }).fail(function(data) {
                block(false);
            })
            $("#sectoresdescripcion").html($("#s" + sector).attr("descripcion"));
            $("#sectorimg").html($("#s" + sector).html());
            $("#modal_objetivos").modal("show");
        }



        function showEstrategias(idObjetivo) {
            $.ajax({
                type: 'GET',
                url: '{{ route('getestrategiassector') }}',
                data: {
                    idObjetivoSector: idObjetivo
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {
                $(".objetivo").removeClass('selected');
                $("#objetivo"+idObjetivo).addClass('selected');
                block(false);
                cuerpo = "";
                if (response.success == "ok") {
                    ban = false;
                    for (x = 0; x < response.estrategias.length; x++) {
                        cuerpo += "<tr style='background-color:" + (ban ? '#F3F3F3' : 'white') + "' id='estrategia"+response.estrategias[x].idEstrategia+"' class='estrategia'>" +
                            "<td>" +
                            response.estrategias[x].claveEstrategia + "</td>" +
                            "<td>" +
                            response.estrategias[x].estrategia + "</td>" +
                            "<td style='text-align:center'>" +
                            "<button onclick='showProductos(" + response.estrategias[x].idEstrategia +
                            ")' class='btn btn-primary'><i class='fas fa-info'></i></button>"
                        "</td>" +
                        "</tr>";
                        ban = !ban;
                    }
                    $("#estrategiasrows").html(cuerpo);
                    $("#productosrows").html("");
                    $("#nav-estrategias-tab").click();
                }
            }).fail(function(data) {
                block(false);
            })
        }

        function showProductos(idEstrategia) {
            $.ajax({
                type: 'GET',
                url: '{{ route('getproductossector') }}',
                data: {
                    idEstrategiaSector: idEstrategia
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {
                $(".estrategia").removeClass('selected');
                $("#estrategia"+idEstrategia).addClass('selected');
                block(false);
                cuerpo = "";
                if (response.success == "ok") {
                    ban = false;
                    for (x = 0; x < response.productos.length; x++) {
                        cuerpo += "<tr style='background-color:" + (ban ? '#F3F3F3' : 'white') + "'>" +
                            "<td>" +
                            response.productos[x].claveProducto + "</td>" +
                            "<td>" +
                            response.productos[x].producto + "</td>" +
                        "</tr>";
                        ban = !ban;
                    }
                    $("#productosrows").html(cuerpo);
                    $("#nav-productos-tab").click();
                }
            }).fail(function(data) {
                block(false);
            })
        }
    </script>
@endsection
