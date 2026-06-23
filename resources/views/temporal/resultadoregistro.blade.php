@extends('layouts.temporal')
@section('content')
    <center>
        <div class="col-lg-6 mb-6">
            <!-- Pendientes IE -->
            <div class="card shadow mb-6">
                <div class="card-header py-4" style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-light">Informe de Gobierno del Estado de Oaxaca</h6>
                    <!--<h6 class="m-0 font-weight-bold text-light">Informe Trimestral de Avances y Resultados (ITAR)</h6>-->
                </div>
                <img style="width:200px;position:absolute; top:-15px;" src="{{ asset('/images/logo_blanco.png') }}" />
                <div class="card-body">
                    <center style="overflow:auto">
                        <table class="table table-light" style="width: 100%">
                            <tbody>
                                <tr style="text-align: center">
                                   <!-- <td style="border: solid 1px rgb(175,119,130);"><img style="width:400px;"
                                            src="{{ asset('/images/siibien_colores.png') }}"</td>-->
                                    <td
                                        style=" vertical-align:middle;background-color:rgb(175,119,130);color:white; text-align:center">
                                        <h2>Pre-registro para la Capacitación de Apertura</h2>
                                        <h4>4to. Informe de Gobierno</4>
                                        <!--<h4>Informe Trimestral de Avances y Resultados (ITAR)</4>-->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        @if ($resultado)
                        <div class="alert alert-success"><h5>Gracias: <b>{{$nombre}}</b> ha sido registrado correctamente, el código que deberá presentar el día de la capacitación para el registro de su asistencia es el siguiente:<h5>
                            <h2>{{$codigo}}</h2>
                        </div>
                        <!--<div>
                        </div>-->
                        @else
                        <div class="alert alert-danger"><h5>Ocurrió un error al tratar de registrar su asistencia, favor de intentar nuevamente!</h5></div>
                        @endif

                        <div class="text-right">
                            <a href="{{route('registro')}}"><button class="btn btn-success"><h5>Nuevo Registro</h5></button></a>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </center>
@endsection
