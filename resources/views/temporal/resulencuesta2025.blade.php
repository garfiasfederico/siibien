@extends('layouts.temporal')
@section('content')
    <center>
        <div class="col-lg-6 mb-6">
            <!-- Pendientes IE -->
            <div class="card shadow mb-6">
                <div class="card-header py-4" style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-light">Encuesta de Satisfacción</h6>
                </div>
                <img style="width:180px;position:absolute; top:-10px;" src="{{ asset('/images/logo_blanco.png') }}" />
                <div class="card-body">
                    <center style="overflow:auto">
                        <table class="table table-light" style="width: 100%">
                            <tbody>
                                <tr style="text-align: center">
                                    <td style="border: solid 1px rgb(175,119,130);vertical-align:middle"><img style="width:400px;"
                                            src="{{ asset('/images/sefin_ite.jpeg') }}"</td>
                                    <td
                                        style=" vertical-align:middle;background-color:rgb(175,119,130);color:white; text-align:center">
                                        <h2>Encuesta de satisfacción de la capacitación recibida</h2>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        @if ($resultado)
                        <div class="alert alert-success"><h5>Gracias por su participación.<h5></div>                    
                        @else
                        <div class="alert alert-danger"><h5>Ocurrió un error al registar la información proporcionada, favor de intentar nuevamente!</h5></div>
                        @endif

                        <div class="text-right">
                            <a href="{{route('encuesta2025')}}"><button class="btn btn-success"><h5>Llenar nueva Encuesta</h5></button></a>                            
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </center>
@endsection
