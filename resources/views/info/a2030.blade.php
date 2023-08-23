@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Agenda 2030</h1>
@endsection

@section('content')
    <style>
        .opcion {
            cursor: pointer;
            border-bottom: solid 5px white;
        }

        .opcion:hover {
            border-bottom: solid 5px gray;
        }
    </style>
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="background-color: #681b2e;">
                <h6 class="m-0 font-weight-bold text-light">Objetivos de Desarrollo Sostenible</h6>
            </div>
            <div class="card-body">
                <center>
                    <p style="width:90%;text-align:justify">
                        Los Objetivos de desarrollo sostenible son el plan maestro para conseguir un futuro sostenible para
                        todos. Se interrelacionan entre sí e incorporan los desafíos globales a los que nos enfrentamos día
                        a día, como la pobreza, la desigualdad, el clima, la degradación ambiental, la prosperidad, la paz y
                        la justicia. Para no dejar a nadie atrás, es importante que logremos cumplir con cada uno de estos
                        objetivos para 2030. Si quieres saber más sobre algún tema o objetivo en especial, pincha sobre el
                        objetivo que te interese.
                    </p>
                    <table style="width: 100%;text-align:center">
                        <tr>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_01.png') }}" onclick="showInfo(1)"
                                    data-toggle="modal" data-target="#modalInfo" />
                            </td>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_02.png') }}"
                                    onclick="showInfo(2)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_03.png') }}"
                                    onclick="showInfo(3)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_04.png') }}"
                                    onclick="showInfo(4)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_05.png') }}"
                                    onclick="showInfo(5)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_06.png') }}"
                                    onclick="showInfo(6)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_07.png') }}"
                                    onclick="showInfo(7)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_08.png') }}"
                                    onclick="showInfo(8)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_09.png') }}"
                                    onclick="showInfo(9)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_10.png') }}"
                                    onclick="showInfo(10)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_11.png') }}"
                                    onclick="showInfo(11)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_12.png') }}"
                                    onclick="showInfo(12)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_13.png') }}"
                                    onclick="showInfo(13)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_14.png') }}"
                                    onclick="showInfo(14)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_15.png') }}"
                                    onclick="showInfo(15)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                            <td>
                                <img class="opcion" src="{{ asset('resources/images/ODS/ODS_16.png') }}"
                                    onclick="showInfo(16)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                            <td>
                                <img class="opcion"src="{{ asset('resources/images/ODS/ODS_17.png') }}"
                                    onclick="showInfo(17)" data-toggle="modal" data-target="#modalInfo" />
                            </td>
                        </tr>
                    </table>
                </center>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title">Información del Objetivo de Desarrollo Sostenible</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding:25px;" id="modal-body-ods">
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
        function showInfo(ods) {
            $.ajax({
                type: 'GET',
                url: '{{route("info.infoods")}}',
                data: {ods_id:ods},
                //dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {
                block(false);
                $("#modal-body-ods").html(response);
               
            }).fail(function(data) {
                block(false);
            })
            $("#modal_info").modal("show");
        }
    </script>
@endsection
