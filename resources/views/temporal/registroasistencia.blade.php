@extends('layouts.temporal')
@section('content')
    <center>
        <div class="col-lg-5 mb-5">
            <!-- Pendientes IE -->
            <div class="card shadow mb-6">
                <div class="card-header py-4" style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-light text-right">Seguimiento a Indicadores de Gobierno</h6>
                </div>
                <img style="width:200px;position:absolute; top:0px;" src="{{ asset('/images/logo_blanco.png') }}" />
                <div class="card-body">
                    <center style="overflow:auto">
                        <table class="table table-light" style="width: 100%">
                            <tbody>
                                <tr style="text-align: center">
                                    <td style="border: solid 1px rgb(175,119,130);vertical-align:middle"><img style="width:100%;"
                                            src="{{ asset('/images/siibien_colores.png') }}"</td>
                                    <td
                                        style=" vertical-align:middle;background-color:rgb(175,119,130);color:white; text-align:center">
                                        <h2>Registro de Asistencia a la Capacitación de Enlaces</h2>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                    </center>
                    <form novalidate method="POST" action="{{ route('registraasistencia') }}">
                        @csrf
                        <div class="row text-left" style="color: black">
                            <div class="col-lg-12 mb-12">
                                <label for="nombre">Nombre Completo<span style="color: red">*</span></label>
                                <input type="text" class="form-control py-4" id="nombre" name="nombre"
                                    placeholder="Nombre del Enlace" value="{{old('nombre')}}" >
                                @error('nombre')
                                    <div class="alter alert-danger py-2 p-1">
                                        Ingresar Nombre Completo
                                    </div>
                                @enderror

                            </div>
                            <div class="col-lg-12 mb-12 p-3">
                                <label for="dependencia">Dependencia<span style="color: red">*</span></label>
                                <select class="form-control py-2" id="dependencia" name="dependencia" required>
                                    <option value="" selected>Seleccione...</option>
                                    @foreach ($dependencias as $dependencia)
                                        <option value="{{ $dependencia->idDependencia }}">
                                            {{ $dependencia->dependenciaNombre . ' (' . $dependencia->dependenciaSiglas . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dependencia')
                                    <div class="alter alert-danger py-2 p-1">
                                        Seleccione Dependencia
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-12 mb-12 p-3">
                                <label for="cargo">Cargo<span style="color: red">*</span></label>
                                <input type="text" class="form-control py-4" id="cargo" name="cargo" value="{{old('cargo')}}"
                                    placeholder="Cargo que desempeña" required>
                                @error('cargo')
                                    <div class="alter alert-danger py-2 p-1">
                                        Indicar el cargo que desempeña
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-12 mb-12 p-3">
                                <label for="email">Correo Electrónico<span style="color: red">*</span></label>
                                <input type="text" class="form-control py-4" id="email" name="email" value="{{old('email')}}"
                                    placeholder="ejemplo@ejemplo.com" required>
                                @error('email')
                                    <div class="alter alert-danger py-2 p-1">
                                        Indicar correo electrónico válido
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-12 mb-12 p-3">
                                <label for="telefono">Teléfono de contacto<span style="color: red">*</span></label>
                                <input type="text" class="form-control py-4" id="telefono" name="telefono" value="{{old('telefono')}}"
                                    placeholder="" required>
                                @error('telefono')
                                    <div class="alter alert-danger py-2 p-1">
                                        Indicar Teléfono de contacto
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-12 mb-12 p-3 text-right">
                                <a href="{{route('registro')}}"><button type="button" class="btn btn-secondary">Cancelar</button></a>
                                <button type="submit" class="btn" style="background-color: #681b2e; color:white">
                                    <h5>Registrar Asistencia</h5>
                                </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </center>
@endsection
