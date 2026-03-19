@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Material de Apoyo</h1>
@endsection

@section('content')
<div>
    <center>
        <h4>Video Capacitación del ITAR 2026</h4>
        <hr/>
        <video width="1280" height="720" controls autoplay>
            <source src="materialapoyo/videoitar2026.mp4"}}" type="video/mp4">
            <p>Tu navegador no admite la etiqueta de video.</p>
            <!-- Texto alternativo -->
        </video>
    </center>
</div>

@endsection
