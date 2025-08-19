@extends('layouts.temporal')

@section('content')
<center>
    <div class="col-lg-5 mb-5">
        <div class="card shadow mb-6">
            <div class="card-header py-4" style="background-color: #681b2e;">
                <h6 class="m-0 font-weight-bold text-light text-right">3er Informe de Gobierno</h6>
            </div>

            <img style="width:200px;position:absolute; top:-20px;" src="{{ asset('/images/logo_blanco.png') }}" />

            <div class="card-body">

                {{-- 🔹 Alerta general si hay algún error --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li> {{-- Solo mensajes amigables, sin mostrar datos de BD --}}
                            @endforeach
                        </ul>
                    </div>
                @endif

                <center style="overflow:auto">
                    <table class="table table-light" style="width: 100%">
                        <tbody>
                            <tr style="text-align: center">
                                <td style="vertical-align:middle;background-color:rgb(175,119,130);color:white; text-align:center">
                                    <h2>Nuevo registro con código QR 2025</h2>
                                    <h4>3er Informe de Gobierno</h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                </center>

                <form novalidate method="POST" action="{{ route('registro.guardar') }}">
                    @csrf

                    <div class="row text-left" style="color: black">
                        <div class="col-lg-12 mb-12 p-2">
                            <label for="tipo_enlace">Tipo de Enlace<span style="color: red">*</span></label>
                            <select name="tipo_enlace" id="tipo_enlace" class="form-control" required>
                                <option value="">--Seleccione</option>
                                <option value="Directivo" {{ old('tipo_enlace') == 'Directivo' ? 'selected' : '' }}>Directivo</option>
                                <option value="Operativo" {{ old('tipo_enlace') == 'Operativo' ? 'selected' : '' }}>Operativo</option>
                                <option value="Otro"      {{ old('tipo_enlace') == 'Otro'      ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>

                        <div class="col-lg-12 mb-12 p-2">
                            <label for="nombre">Nombre Completo<span style="color: red">*</span></label>
                            <input type="text" class="form-control py-4" id="nombre" name="nombre"
                                   placeholder="Nombre del Enlace" value="{{ old('nombre') }}" required>
                        </div>

                        <div class="col-lg-12 mb-12 p-2">
                            <label for="dependencia">Institución<span style="color: red">*</span></label>
                            <select class="form-control py-2" id="dependencia" name="dependencia" required>
                                <option value="">Seleccione...</option>
                                @foreach ($dependencias as $dep)
                                    <option value="{{ $dep->idDependencia }}" @selected(old('dependencia') == $dep->idDependencia)>
                                        {{ $dep->dependenciaNombre }} ({{ $dep->dependenciaSiglas }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-12 mb-12 p-2">
                            <label for="cargo">Cargo<span style="color: red">*</span></label>
                            <input type="text" class="form-control py-4" id="cargo" name="cargo"
                                   value="{{ old('cargo') }}" placeholder="Cargo que desempeña" required>
                        </div>

                        <div class="col-lg-12 mb-12 p-2">
                            <label for="perfil">Perfil Académico<span style="color: red">*</span></label>
                            <input type="text" class="form-control py-4" id="perfil" name="perfil"
                                   value="{{ old('perfil') }}" placeholder="Perfil académico" required>
                        </div>

                        <div class="col-lg-12 mb-12 p-2">
                            <label for="email">Correo Electrónico<span style="color: red">*</span></label>
                            <input type="email" class="form-control py-4" id="email" name="email"
                                   value="{{ old('email') }}" placeholder="ejemplo@ejemplo.com" required>
                        </div>

                        <div class="col-lg-12 mb-12 p-2">
                            <label for="telefono">Teléfono de contacto<span style="color: red">*</span></label>
                            <input type="tel" class="form-control py-4" id="telefono" name="telefono"
                                   value="{{ old('telefono') }}" placeholder="Ej: 9991234567" required>
                        </div>

                        <div class="col-lg-12 mb-12 p-2 text-right">
                            <a href="{{ route('registro.nuevo') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn" style="background-color: #681b2e; color:white">
                                <h5 class="m-0">Registrar Asistencia</h5>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</center>
@endsection
