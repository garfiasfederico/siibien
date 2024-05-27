@extends('layouts.administrador')
@section('encabezado')
    Redacción del Segundo Informe de Gobierno
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
                                    <form action="{{route('informe.acciones')}}" method="POST" class="padding:10px;">
                                    @csrf
                                        <input type="hidden" value="{{auth()->user()->enlace->idDependencia}}" name="dependencia"/>
                                        <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                        <button class="btn btn-success">Redactar Informe</button>
                                    </form>
                                    <br/>
                                    <form action="{{route('informe.downloadword')}}" method="POST" class="padding:10px;">
                                        @csrf
                                            <input type="hidden" value="{{auth()->user()->enlace->idDependencia}}" name="dependencia"/>
                                            <input type="hidden" value="{{$tema->idTemaPED}}" name="tema"/>
                                            <button type="submit" class="btn btn-warning">Descargar Informe</button>
                                        </form>

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
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $("#collapse-informee").addClass("show");
            //$("#pparegistro").addClass("active");
        $("#informetemas").css('background-color', "rgb(217, 217, 217)");
    });
</script>
@endsection
