@extends('layouts.administrador')
@section('encabezado')
    ITAR / Solicitudes de alta de PPAs
@endsection
@section('styles')
    <style>
        .enc1 {
            padding: 5px !important;
            background-color: #c5c5c5;
            color: white;
        }

        .enc2 {
            padding: 5px !important;
            background-color: #7c2f42;
            color: white;
        }

        .resp {
            font-weight: bold;
        }

        .enc3 {
            background-color: #ececec;
            font-weight: bold;
        }

        input[type=text],
        select {
            height: 35px;
            color: black;
        }

        table tr td {
            padding: 5px;
            border: solid 2px white;
        }

        .invalid-feedback {
            width: 100%;
            background-color: rgb(255, 195, 195);
            color: gray;
            border-radius: 5px;
            text-align: center;
            padding: 10px;
            border: solid 1px red;
        }

        textarea {
            color: black;
        }
    </style>
@endsection
@section('content')
    <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex align-items-center justify-content-between"
                style="background-color: #681b2e;">
                <h6 class="m-0 font-weight-bold text-primary" style="color:white !important">Solicitudes de alta</h6>
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
            <!-- Card Body -->
            <div class="card-body" id="">
                @if ($solicitudes->count() > 0)
                    <table style="width: 100%; overflow:scroll" class="table table-striped" id="tableSolicitudes">
                        <thead>
                            <tr>
                                <th class="enc1" style="border:solid 1px rgb(224, 224, 224);text-align:center;">Id</th>
                                <th class="enc1" style="border:solid 1px rgb(224, 224, 224);text-align:center;">Nombre</th>
                                <th class="enc1" style="border:solid 1px rgb(224, 224, 224);text-align:center;">Tipo</th>
                                <th class="enc1" style="border:solid 1px rgb(224, 224, 224);text-align:center;">Descripción</th>
                                <th class="enc1" style="border:solid 1px rgb(224, 224, 224);text-align:center;width:10%">Bienes o Servicios</th>
                                <th class="enc1" style="border:solid 1px rgb(224, 224, 224);text-align:center;">Objetivo</th>
                                <th class="enc1" style="border:solid 1px rgb(224, 224, 224);text-align:center;">Eje</th>
                                <th class="enc1" style="border:solid 1px rgb(224, 224, 224);text-align:center;">Tema</th>
                                <th class="enc1" style="border:solid 1px rgb(224, 224, 224);text-align:center;">Solicitante</th>
                                <th class="enc1" style="border:solid 1px rgb(224, 224, 224);text-align:center;">Opciones </th>
                                <th class="enc1" style="border:solid 1px rgb(224, 224, 224);text-align:center;">Justificación en caso de rechazo</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($solicitudes as $solicitud)
                                @php
                                    $color = '';
                                    switch ($solicitud->estado) {
                                        case 'pendiente':
                                            $color = 'gray';
                                            break;
                                        case 'aceptado':
                                            $color = 'green';
                                            break;
                                        case 'rechazado':
                                            $color = 'red';
                                            break;
                                    }
                                @endphp
                                <tr id="solicitud{{$solicitud->idPPATemp}}">
                                    <td style="border:solid 1px rgb(224, 224, 224);vertical-align:middle;">{{ $solicitud->idPPATemp }}
                                    </td>
                                    <td style="border:solid 1px rgb(224, 224, 224);vertical-align:middle;">{{ $solicitud->nombre }}</td>
                                    <td style="border:solid 1px rgb(224, 224, 224);vertical-align:middle;">{{ $solicitud->tipo }}</td>
                                    <td style="border:solid 1px rgb(224, 224, 224);vertical-align:middle;">{{ $solicitud->descripcion }}</td>
                                    <td style="border:solid 1px rgb(224, 224, 224);vertical-align:middle;">{{ $solicitud->bss }}</td>
                                    <td style="border:solid 1px rgb(224, 224, 224);vertical-align:middle;">{{ $solicitud->objetivo }}</td>
                                    <td style="border:solid 1px rgb(224, 224, 224);vertical-align:middle;">
                                        {{ $solicitud->ejePEDClave . ' ' . $solicitud->ejePEDDescripcion }}</td>
                                    <td style="border:solid 1px rgb(224, 224, 224);vertical-align:middle;">
                                        {{ $solicitud->temaPEDClave . ' ' . $solicitud->temaPEDDescripcion }}</td>
                                    <td style="border:solid 1px rgb(224, 224, 224);vertical-align:middle;text-align:center">
                                            <b>{{ $solicitud->dependenciaSiglas }}</b></td>
                                    <td style="border:solid 1px rgb(224, 224, 224);vertical-align:middle;text-align:center" >
                                        @if($solicitud->estado == "pendiente")
                                            <button class="btn btn-success" style="width: 110px;margin:5px;" onclick="procesaSolicitud({{$solicitud->idPPATemp}},1)"><i class="fas fa-check"></i> Aceptar</button>                                            
                                            <button class="btn btn-danger" style="width: 110px;" onclick="procesaSolicitud({{$solicitud->idPPATemp}},0)"><i class="fas fa-times"></i> Rechazar</button>
                                        @else
                                            <b style="color:{{$color}}">{{$solicitud->estado}}</b>
                                        @endif
                                    </td>
                                    <td style="border:solid 1px rgb(224, 224, 224);vertical-align:middle;text-align:justify" >
                                        {{$solicitud->justificacion}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <center>
                        <div class="alert alert-info">No existen solicitudes de alta de PPA registradas!</div>
                    </center>
                @endif
            </div>
        </div>
    @endsection

@section("scripts")
<script>
    $(document).ready(function(){
        $("#tableSolicitudes").DataTable({
                pageLength: 10,
                lengthMenu: [20, 50, 100],
                order: [
                    [0, 'asc']
                ],
            }) 
    });

    function procesaSolicitud(idPPATemp,solicita){
        if(solicita)
            des = "la aceptación de";
        else
            des = "rechazar";

        justificacion = "";

        if(solicita){
            Swal.fire({
                            icon: 'question',
                            title: 'Solicitudes de alta de PPAs',
                            text: "A continuación se procede a "+des+" la solicitud de alta de PPA, tome en cuenta que esta acción es irreversible en el sistema",                                                                      
                            showCancelButton: true,
                            confirmButtonColor: '#008000',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Sí, Continuar!',
                            showCancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                        type: 'POST',
                                        url: "{{ route('ia.admin.procesasolicitud') }}",
                                        data: {idPPATemp : idPPATemp, solicitud:solicita ,_token:$("input[name='_token']").val()},
                                        dataType: 'json',
                                        beforeSend: function() {
                                            $("#solicitud"+idPPATemp).block({
                                                message: '<h4>Procesando...</h4>',
                                                css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                                            });
                                            //block(true);
                                        }
                                    }).done(function(response) {
                                        //block(false);
                                        $("#solicitud"+idPPATemp).unblock();
                                        if (response.result == "ok") {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Solicitud de alta de PPA',
                                                text: response.message,
                                                confirmButtonColor: '#3085d6',
                                            }).then((result) => {location.reload()});                        
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Solicitud de alta de PPA',
                                                text: response.message,
                                                confirmButtonColor: '#3085d6',
                                            }).then((result) => {});
                                        }
                                    });
                            }                        
                        });

        }else{
            Swal.fire({
                title: "Solicitudes de alta de PPAs!",
                text: "A continuación se procede a "+des+" la solicitud de alta de PPA, tome en cuenta que esta acción es irreversible en el sistema. Favor de indicar la justificación de rechazo de esta solicitud",
                input: 'textarea',
                inputPlaceholder: 'Justificación de rechazo',
                icon:'question',
                confirmButtonColor: '#008000',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, Continuar!',
                showCancelButtonText: 'Cancelar',
                showCancelButton: true        
            }).then((result) => {
                if (result.value) {
                    justificacion = result.value;
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('ia.admin.procesasolicitud') }}",
                        data: {idPPATemp : idPPATemp, solicitud:solicita ,_token:$("input[name='_token']").val(),justificacion:justificacion},
                        dataType: 'json',
                        beforeSend: function() {
                            $("#solicitud"+idPPATemp).block({
                                message: '<h4>Procesando...</h4>',
                                css: { border: '3px solid gray', backgroundColor:'black','-webkit-border-radius': '10px','-moz-border-radius':'10px',width:"15%",color:"white" }
                            });
                            //block(true);
                        }
                    }).done(function(response) {
                        //block(false);
                        $("#solicitud"+idPPATemp).unblock();
                        if (response.result == "ok") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Solicitud de alta de PPA',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {location.reload()});                        
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Solicitud de alta de PPA',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                            }).then((result) => {});
                        }
                    });                            
                }
            });

        }                
    }

</script>
@endsection
