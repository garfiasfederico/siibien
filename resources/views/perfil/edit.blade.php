@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Perfil / Cuenta</h1>
@endsection

@section('content')
    <div class="row">

        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #681b2e">
                    <h6 class="m-0 font-weight-bold text-light">Datos del Enlace</h6>                   
                </div>
                <!-- Card Body -->
                <div class="card-body" id="EnlaceContent">
                    <form id="formEnlace" action="{{ route('perfil.update') }}">
                        @csrf
                        <input type="hidden" name="idEnlaceDependencia" id="idEnlaceDependencia" value="{{ $enlace->idEnlaceDependencia }}">
                        <div class="form-row">
                            <div class="col-md-1 mb-3">
                                <label for="titulo">Titulo:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ing."
                                    value="{{ $enlace->titulo }}" required>
                                <div class="invalid-feedback">
                                    Indicar Titulo!
                                </div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="titulo">Nombre:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    placeholder="Nombre(s)" value="{{ $enlace->nombre }}" required>
                                <div class="invalid-feedback">
                                    Indicar Nombre o Nombres!
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="titulo">Apellido Paterno:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="apellidoP" name="apellidoP"
                                    placeholder="Apellido Paterno" value="{{ $enlace->apellidoP }}" required>
                                <div class="invalid-feedback">
                                    Indicar Apellido Paterno!
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="titulo">Apellido Materno:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="apellidoM" name="apellidoM"
                                    placeholder="Apellido Materno" value="{{ $enlace->apellidoM }}" required>
                                <div class="invalid-feedback">
                                    Indicar Apellido Materno!
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="titulo">Cargo:<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo"
                                    value="{{ $enlace->cargo }}" required>
                                <div class="invalid-feedback">
                                    Indicar Cargo!
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="titulo">Tipo de enlace:<span style="color: red">*</span></label>
                                <select class="form-control" id="tipoEnlace" name="tipoEnlace" disabled>
                                    <option value="0">Seleccione...</option>                                    
                                        <option value="operativo">Operativo</option>
                                        <option value="directivo">Directivo</option>                                     
                                </select>
                                <div class="invalid-feedback">
                                    Indicar Cargo!
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="titulo">Email:<span style="color: red">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="ejemplo@ejemplo.com" value="{{ $enlace->email }}" required>
                                <div class="invalid-feedback">
                                    Indicar Email Valido!
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="titulo">Telefono:</label>
                                <input type="number" class="form-control" id="telefono" name="telefono"
                                    placeholder="tel" value="{{ $enlace->telefono }}">
                                <div class="invalid-feedback">
                                    Indicar Telefono valido!
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="titulo">Celular:</label>
                                <input type="number" class="form-control" id="celular" name="celular"
                                    placeholder="num" value="{{ $enlace->celular }}">
                                <div class="invalid-feedback">
                                    Indicar Celular valido!
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="titulo">Teléfono de oficina:</label>
                                <input type="number" class="form-control" id="teloficina" name="teloficina"
                                    placeholder="num" value="{{ $enlace->teloficina }}">
                                <div class="invalid-feedback">
                                    Indica un Teléfono correcto!
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                                <label for="extension">Extensión:</label>
                                <input type="number" class="form-control" id="extension" name="extension"
                                    placeholder="extensión" value="{{ $enlace->extension }}">
                                <div class="invalid-feedback">
                                    Indica una extension correcta!
                                </div>
                            </div>
                        </div>
                        <div class="float-right">
                            <a href="{{route('main')}}"><button class="btn btn-secondary" type="button"
                                    onclick="">Cancelar</button></a>
                            &nbsp;
                            <button class="btn btn-primary" type="button" onclick="actualizaPerfil()">Almacenar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (){
            $("#tipoEnlace").val("{{$enlace->tipoEnlace}}")
        })

        
        function actualizaPerfil() {
            $.ajax({
                type: 'POST',
                url: $("#formEnlace").attr('action'),
                data: $("#formEnlace").serialize(),
                dataType: 'json',
                beforeSend: function() {
                    block(true);
                }
            }).done(function(response) {
                block(false);
                if (response.success == "ok") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Perfil Actualizado',
                        text: response.message,
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        window.location.replace("{{ route('perfil.edit') }}");
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ocurrió un error al intentar actualizar el Perfil',
                        text: '',
                        confirmButtonColor: '#3085d6',
                    })
                }
            }).fail(function(data) {
                block(false);
            })
        }
    </script>
@endsection
