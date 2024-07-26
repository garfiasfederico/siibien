@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">Material de Apoyo</h1>
@endsection

@section('content')
<div>
    <center>
        <h4>Video tutorial para el uso de Módulo de Informe</h4>
        <hr/>
        <video width="1280" height="720" controls autoplay>
            <source src="materialapoyo/m_informe_siibien.mp4"}}" type="video/mp4">
            <p>Tu navegador no admite la etiqueta de video.</p>
            <!-- Texto alternativo -->
        </video>
    </center>
</div>

@endsection
