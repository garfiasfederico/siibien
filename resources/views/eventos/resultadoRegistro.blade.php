@extends('layouts.temporal')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow">
                    <div class="card-header py-3" style="background-color:#681b2e;">
                        <h6 class="m-0 font-weight-bold text-light">3er Informe de Gobierno</h6>
                    </div>

                    <div class="position-relative">
                        <img src="{{ asset('/images/logo_blanco.png') }}" alt="Logo"
                            style="width:200px;position:absolute;top:-20px;left:20px;">
                    </div>

                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="p-3 text-white" style="background-color:rgb(175,119,130);">
                                <h2 class="mb-1">Registro Exitoso</h2>
                            </div>
                        </div>

                        <hr>

                        @if ($resultado)
                            <div class="alert alert-success" role="alert" aria-live="polite">
                                @if ($esNuevo)
                                    <h5 class="mb-0">
                                        ¡Gracias, <strong>{{ e($nombre) }}</strong>! Tu registro se creó correctamente.
                                    </h5>
                                    {{-- <small class="d-block mt-2">
                                        En breve recibirás tu material de capacitación.
                                    </small> --}}
                                @else
                                    <h5 class="mb-0">
                                        ¡Hola de nuevo, <strong>{{ e($nombre) }}</strong>! Tus datos se actualizaron correctamente.
                                    </h5>
                                    <small class="d-block mt-2">
                                        Se conservará tu código QR anterior, pero hemos guardado los cambios que hiciste.
                                    </small>
                                @endif
                            </div>

                            {{-- Mostrar QR SOLO cuando es nuevo y se generó --}}
                            @if ($esNuevo && !empty($qr_svg))
                                <div class="text-center my-4">
                                    <div id="qr-container">
                                        {!! $qr_svg !!}
                                    </div>
                                    <p class="mt-2">
                                        Este es tu código QR personal. Guárdalo para presentarlo el día del evento.
                                    </p>
                                    <a id="download-qr" class="btn btn-outline-success" download="mi_codigo_qr.png">
                                        Descargar QR
                                    </a>
                                </div>
                            @endif

                        @else
                            <div class="alert alert-danger" role="alert" aria-live="assertive">
                                <h5 class="mb-1">Ocurrió un problema al registrar tu asistencia.</h5>
                                <small>Por favor, intenta nuevamente.</small>

                                @if(app()->environment('local') && !empty($error))
                                    <div class="mt-2 small text-monospace">
                                        <strong>Detalle:</strong> {{ $error }}
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('registro.nuevo') }}" class="btn btn-success">
                                Nuevo registro
                            </a>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                                Regresar al inicio
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Script para convertir el SVG del QR a PNG y descargarlo --}}
    @if ($esNuevo && !empty($qr_svg))
        {{-- Script para convertir SVG a PNG y habilitar descarga --}}
        @if ($esNuevo && !empty($qr_svg))
            <script>
                function prepararDescargaSVGcomoPNG(svgSelector, linkSelector, nombreArchivo = "qr.png") {
                    const svgElement = document.querySelector(svgSelector);
                    const downloadLink = document.querySelector(linkSelector);

                    if (!svgElement || !downloadLink) return;

                    const serializer = new XMLSerializer();
                    const svgString = serializer.serializeToString(svgElement);
                    const svgBlob = new Blob([svgString], { type: "image/svg+xml;charset=utf-8" });
                    const url = URL.createObjectURL(svgBlob);

                    const image = new Image();
                    image.onload = function () {
                        const escala =3;
                        const canvas = document.createElement("canvas");
                        canvas.width = image.width * escala;
                        canvas.height = image.height * escala;
                        const ctx = canvas.getContext("2d");
                        ctx.scale(escala,escala);
                        ctx.drawImage(image, 0, 0);
                        URL.revokeObjectURL(url);

                        canvas.toBlob(function (blob) {
                            const pngUrl = URL.createObjectURL(blob);
                            downloadLink.href = pngUrl;
                            downloadLink.download = nombreArchivo;
                        }, "image/png");
                    };
                    image.src = url;
                }

                document.addEventListener("DOMContentLoaded", function () {
                    prepararDescargaSVGcomoPNG("#qr-container svg", "#download-qr", "mi_codigo_qr.png");
                });
            </script>
        @endif

    @endif
@endsection