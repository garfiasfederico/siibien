@php
    use App\Models\InformeParrafo;
@endphp
@extends('layouts.administrador')
@section('encabezado')
    Redacción del Tercer Informe de Gobierno
@endsection
@section('content')
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
            style="background-color: #681b2e;">
            <h6 class="m-0 font-weight-bold text-light">Temas en los que participa
            </h6>
        </div>
        <!-- Card Body -->
        <div class="card-body" id="indicadorContent">
            <center>
                <h1>{{ auth()->user()->enlace->dependencia->dependenciaNombre." (".auth()->user()->enlace->dependencia->dependenciaSiglas.")" }}</h1>
                <h4>Temas en los que participa</h4>
                @if($temas->count()>0)
                @csrf
                <table style="width: 90%" class="table table-striped">
                    <thead>
                        <tr style="background-color: gray;color:white;">
                            <th>Eje</th>
                            <th>Tema</th>
                            <th>Rol</th>
                            <th>Redactar</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 1.1em;">
                        @foreach ($temas as $tema )
                            <tr>
                                <td style="vertical-align:middle">{{$tema->ejePEDClave." ".$tema->ejePEDDescripcion}}</td>
                                <td style="vertical-align: middle">{{$tema->temaPEDClave." ".$tema->temaPEDDescripcion}}</td>
                                <td style="text-align:center;background-color:@if($tema->tipo=="P") gray @else black @endif;color:white;vertical-align:middle">{{$tema->tipo}}</td>
                                <td style="vertical-align: middle">
                                    @if(!$tema->bloqueado)
                                        <form action="{{route('informe.acciones')}}" method="POST" class="padding:10px;">
                                        @csrf
                                            <input type="hidden" value="{{auth()->user()->enlace->idDependencia}}" name="dependencia"/>
                                            <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                            <button class="btn btn-success" title="Redactar Informe por acciones del tema" data-toggle="tooltip" data-placement="top">Redactar Informe</button>
                                        </form>
                                        <br/>
                                    @else
                                        <button class="btn btn-secondary" title="Redactar Informe por acciones del tema (bloqueado)" data-toggle="tooltip" data-placement="top" disabled>Redactar Informe</button>
                                        <br/>
                                        <br/>

                                    @endif
                                    @php
                                                    if($tema->tipo=="CT"){
                                                        //obtenemos todos los parrafos redactados del tema
                                                        $parrafos = InformeParrafo::join("informe_acciones","informe_acciones.id","=","informe_parrafos.informe_acciones_id")
                                                                                  ->where("informe_acciones.idTemaPED",$tema->idTemaPED)
                                                                                  ->where("informe_acciones.status","=",1)
                                                                                  ->get();

                                                    }else{
                                                        //obtenemos todos los parrafos redactados del tema y por dependencia
                                                        $parrafos = InformeParrafo::join("informe_acciones","informe_acciones.id","=","informe_parrafos.informe_acciones_id")
                                                                                  ->where("informe_acciones.idTemaPED",$tema->idTemaPED)
                                                                                  ->where("informe_acciones.idDependencia",$tema->dependencias_id)
                                                                                  ->where("informe_acciones.status","=",1)
                                                                                  ->get();
                                                    }
                                    @endphp
                                    <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                        @csrf
                                            <input type="hidden" value="{{auth()->user()->enlace->idDependencia}}" name="dependencia"/>
                                            <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                            @if($parrafos->count()>0)
                                                <button type="submit" class="btn btn-warning" title="Descargar formato Word con información concentrada" data-toggle="tooltip"
                                                data-placement="top">Descargar Informe</button>
                                            @endif
                                                <div style="font-size:.8em;color:rgb(180, 180, 180);padding:3px;font-weight:bold;font-style:italic ">
                                                    ({{$parrafos->count()}}) párrafos
                                                </div>
                                    </form>
                                    @if($parrafos->count()>1 && $tema->tipo=="CT")
                                        <button class="btn btn-primary" onclick="showParrafosct({{$tema->idTemaPED}})">Ordenar Párrafos</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-info"> No existen temas asociados a la dependencia, favor de informar al Administrador!</div>
                @endif

            </center>

        </div>
    </div>
    <div class="modal fade" id="modalOrden" tabindex="-1" role="dialog" aria-labelledby="accionModalLabel"
        aria-hidden="true" style="color: black!important">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="accionModalLabel">Indicar Orden</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <div style="width: 100%;" id="parrafosContent">

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $("#collapse-informee").addClass("show");
            //$("#pparegistro").addClass("active");
        $("#informetemas").css('background-color', "rgb(217, 217, 217)");
    });

    function showParrafosct(idTemaPED){
        $("#modalOrden").modal("show");
        $.ajax({
                type: 'GET',
                url: "{{ route('informe.getparrafosct') }}",
                data: {
                    idTemaPED: idTemaPED,
                },
                //dataType: 'json',
                beforeSend: function() {
                    block(true)
                },
                success: function(response) {
                        $("#parrafosContent").html(response)
                }
            }).done(function(response) {
                block(false);
            }).fail(function(data) {
                block(false);
                $("#parrafosContent").html("<div class='alert alert-warning' style='text-align:center'>Ocurrio un error, intentar más tarde</div>");
            })
    }
    function updateOrden(idParrafo){
        val = $("#parrafo"+idParrafo).val();

        $.ajax({
                type: 'POST',
                url: "{{ route('informe.updateordenct') }}",
                data: {
                    idParrafo: idParrafo,
                    orden:val,
                    _token: $("input[name='_token']").val()
                },
                dataType: 'json',
                beforeSend: function() {
                    block(true)
                },
                success: function(response) {
                        if(response.result=="ok"){
                            $("#p"+idParrafo).css("background-color","#e4ffe1");
                        }else{
                            $("#p"+idParrafo).css("background-color","red");
                        }
                }
            }).done(function(response) {
                block(false);
            }).fail(function(data) {
                block(false);
                $("#p"+idParrafo).css("background-color","red ");
            })






    }
</script>
@endsection
