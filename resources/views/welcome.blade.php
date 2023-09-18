@extends('layouts.general')
@section('content')
    <!--  <div style=" color:#919090">
                                                                                <h3 class="text-center">Seguimiento Integral de Indicadores del Bienestar</h3>
                                                                                <h4 class="text-center">(SIIBIEN)</h4>
                                                                            </div>
                                                                            <hr>-->
    <center style="background-image:url(resources/images/logo_bg.png);background-size:150px;">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"
            style="width:70%;background-image:url('resources/images/logo_bg.png')">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="resources/images/sliders/sliderA1.jpg" alt="primero">
                    <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                        <div class="titleslider" style="display: "
                            >
                            <h2 style="color:black;">Plan Estatal de Desarrollo 2022 - 2028</h2>
                            <!--<p style="color:black;">Instancia Técnica de Evaluación</p>-->
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="resources/images/sliders/slider1.jpg" alt="primero">
                    <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                        <div class="titleslider"
                            >
                            <h2 style="color:black;">Gobierno del Cambio</h2>
                            <h4 style="color:black;">La primavera Oaxaqueña ha llegado para quedarse, en Oaxaca comienza el cambio hacia la 4T, dónde nadie se queda fuera y nadie se queda atrás.</h4>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="resources/images/sliders/slider2.jpg" alt="segundo">
                    <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                        <div class="titleslider"
                            >
                            <h2 style="color:black;">Sistema para el Seguimiento Integral de los Indicadores de Bienestar (SIIBien)</h2>
                            <h4 style="color:black;">El SIIBien es un sistema Informático que concentra la información del Desempeño del Plan
                                Estatal
                                de Desarrollo 2022-2028 (PED 2022-2028) a través del Seguimiento de los Indicadores
                                Estratégicos
                                y de Gestión
                                derivados de los Objetivos, Estrategias y Líneas de Acción contenidos en el PED.</h4>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="resources/images/sliders/slider3.jpg" alt="tercero">
                    <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                        <div class="titleslider" 
                            >
                        <h2 style="color:black">Gobierno cercano a la gente</h2>
                        <h4 style="color:black">Las estrategias concebidas en la política pública de este Gobierno estan orientadas hacia el logro del bienestar para todas y todos.</h4>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="resources/images/sliders/slider4.jpg" alt="cuarto">
                    <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                        <div class="titleslider"
                            >
                        <h2 style="color:black">Interculturalidad</h2>
                        <h4 style="color:black">Consciente de la riqueza étnica del Estado, este Gobierno busca fortalecer la identidad de los pueblos originarios y enaltecer sus costumbres y tradiciones.</h4>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="resources/images/sliders/slider5.jpg" alt="quinto">
                    <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                        <div class="titleslider"
                            >
                        <h2 style="color:black">Primavera Oaxaqueña</h2>
                        <h4 style="color:black">El progreso es para todas y todos, en Oaxaca el tiempo de la transformación ya está sucediendo.</h4>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="resources/images/sliders/slider6.jpg" alt="First slide">
                    <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                        <div class="titleslider"
                            >
                        <h2 style="color:black">Sostenibilidad</h2>
                        <h4 style="color:black">Un Gobierno comprometido con el desarrollo preponderando el cuidado y conservación ambiental de las ocho regiones del Estado.</h4>
                    </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="resources/images/sliders/slider7.jpg" alt="First slide">
                    <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                        <div class="titleslider"
                            >
                        <h2 style="color:black">Conservación del Patrimonio</h2>
                        <h4 style="color:black">La riqueza patrimonial debe conservarse y protegerse, es compromiso de este Gobierno impulsar acciones para la conservación de nuestro patrimonio.</h4>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="resources/images/sliders/slider8.jpg" alt="First slide">
                    <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                        <div class="titleslider"
                            >
                        <h2 style="color:black">Indicadores Estratégicos del Estado</h2>
                        <h4 style="color:black">Herramientas de Medición del Desempeño de este Gobierno.</h4>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div style="position:relative; top:-130px; background-color:;width:70%">
            <table style="width:100%" border="0">
                <tr>
                    <td
                        style="background-image: url(images/main/PEJES.svg);background-repeat:no-repeat;width:15%;height:250px;background-position:center;width: 16.6%">
                    </td>
                    <td style="background-image: url(images/main/EJE1.svg);background-repeat:no-repeat;background-size:70%;background-position:center;text-align:center;padding-left:20px; padding-right:20px;cursor:pointer;width: 16.6%"
                        onmouseover="$('#eje1text').css('display','block'); setTimeout(function(){$('#eje1text').css('display','none');},2000);">
                        <center>
                            <div style="display:none;color:black;padding:15px;width:80%; background-color:white; opacity:.7;"
                                id="eje1text">
                                <span class="eje1">Eje 1</span>
                                <br />
                                <span class="eje1"> Estado de Bienestar para todas las oaxaqueñas y oaxaqueños</span>
                            </div>
                        </center>
                    </td>
                    <td style="background-image: url(images/main/EJE2.svg);background-repeat:no-repeat;background-size:70%;;background-position:center;text-align:center;padding-left:20px; padding-right:20px;cursor:pointer;width: 16.6%"
                        onmouseover="$('#eje2text').css('display','block'); setTimeout(function(){$('#eje2text').css('display','none');},2000);">
                        <center>
                            <div style="display:none;color:black;padding:15px;width:80%; background-color:white; opacity:.7;"
                                id="eje2text">
                                <span>Eje 2</span>
                                <br />
                                <span>Gobierno honesto, cercano y transparente</span>
                            </div>
                        </center>
                    </td>
                    <td style="background-image: url(images/main/EJE3.svg);background-repeat:no-repeat;background-size:70%;background-position:center;text-align:center;padding-left:20px; padding-right:20px;cursor:pointer;width: 16.6%"
                        onmouseover="$('#eje3text').css('display','block'); setTimeout(function(){$('#eje3text').css('display','none');},2000);">
                        <center>
                            <div style="display:none;color:black;padding:15px;width:80%; background-color:white; opacity:.7;"
                                id="eje3text">
                                <span>Eje 3</span>
                                <br />
                                <span>Seguridad y Justicia para vivir en paz</span>
                            </div>
                        </center>
                    </td>
                    <td style="background-image: url(images/main/EJE4.svg);background-repeat:no-repeat;background-size:70%;background-position:center;text-align:center;padding-left:20px; padding-right:20px;cursor:pointer;width: 16.6%"
                        onmouseover="$('#eje4text').css('display','block'); setTimeout(function(){$('#eje4text').css('display','none');},2000);">
                        <center>
                            <div style="display:none;color:black;padding:15px;width:80%; background-color:white; opacity:.7;"
                                id="eje4text">
                                <span>Eje 4</span>
                                <br />
                                <span>Crecimiento y Desarrollo Económico</span>
                            </div>
                        </center>
                    </td>
                    <td style="background-image: url(images/main/EJE5.svg);background-repeat:no-repeat;background-size:70%;background-position:center;text-align:center;padding-left:20px; padding-right:20px;cursor:pointer;width: 16.6%"
                        onmouseover="$('#eje5text').css('display','block'); setTimeout(function(){$('#eje5text').css('display','none');},2000);">
                        <center>
                            <div style="display:none;color:black;padding:15px;width:80%; background-color:white; opacity:.7;"
                                id="eje5text">
                                <span>Eje 5</span>
                                <br />
                                <span>Infraestructura y servicios públicos</span>
                            </div>
                        </center>
                    </td>
                </tr>
            </table>
        </div>
        <div class="text-center" style="background-color:transparent; width:70%">
            <h1 style="color:black;font-size:3em">Indicadores por áreas de interés</h1>
            <table style="width:100%">
                <tr>
                    <td style="width:15%;padding:20px;"><img class="imgarea"
                            src="{{ asset('images/main/areas/CAMPO.svg') }}" alt=""></td>
                    <td style="width:15%;padding:20px;"><img class="imgarea"
                            src="{{ asset('images/main/areas/IGUALDAD.svg') }}" alt=""></td>
                    <td style="width:15%;padding:20px;"><img class="imgarea"
                            src="{{ asset('images/main/areas/SALUD.svg') }}" alt=""></td>
                    <td style="width:15%;padding:20px;"><img class="imgarea"
                            src="{{ asset('images/main/areas/EDUCACION.svg') }}" alt=""></td>
                    <td style="width:15%;padding:20px;"><img class="imgarea"
                            src="{{ asset('images/main/areas/SEGURIDAD.svg') }}" alt=""></td>
                    <td style="width:15%;padding:20px;"><img class="imgarea"
                            src="{{ asset('images/main/areas/INFRAESTRUCTURA.svg') }}" alt=""></td>
                </tr>
                <tr>
                    <td style="width:15%;padding:20px;"><img class="imgarea"
                            src="{{ asset('images/main/areas/CULTURA.svg') }}" alt=""></td>
                    <td style="width:15%;padding:20px;"><img class="imgarea"
                            src="{{ asset('images/main/areas/MEDIO_AMBIENTE.svg') }}" alt=""></td>
                    <td style="width:15%;padding:20px;"><img class="imgarea"
                            src="{{ asset('images/main/areas/ECONOMIA.svg') }}" alt=""></td>
                    <td style="width:15%;padding:20px;"><img class="imgarea"
                            src="{{ asset('images/main/areas/GOBIERNO.svg') }}" alt=""></td>
                    <td style="width:15%;padding:20px;"><img class="imgarea"
                            src="{{ asset('images/main/areas/POBREZA.svg') }}" alt=""></td>
                    <td style="width:15%;padding:20px;"><img class="imgarea"
                            src="{{ asset('images/main/areas/INNOVACION.svg') }}" alt=""></td>
                </tr>
            </table>
        </div>
        <hr />

        <div class="text-center" style="background-color:#cbcbcb; color:white;width:70%">
            <br />
            <br />
            <h1 style="font-size:3em;">Ligas de Interés</h1>
            <table style="width:100%">
                <tr>
                    <td style="width: 10%;padding:10px;">
                        <a target="_blank" href="https://atlasdegenero.oaxaca.gob.mx/">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-ag.svg') }}" style="width: 80%;" />
                        </a>
                    </td>
                    <td style="width: 10%;padding:10px;">
                        <a target="_blank" href="https://www.inegi.org.mx/">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-inegi.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                    <td style="width: 10%;padding:10px;">
                        <a target="_blank" href="https://www.transparenciapresupuestaria.gob.mx/">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-TPF.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                    <td style="width: 10%;padding:10px;">
                        <a target="_blank" href="https://www.coneval.org.mx/Paginas/principal.aspx">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-coneval.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                    <td style="width: 10%;padding:10px;">
                        <a target="_blank" href="http://www.transparenciapresupuestaria.oaxaca.gob.mx/index.htm">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-Toaxaca.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                </tr>
                <tr>

                    <td style="width: 10%;padding:10px;">
                        <a target="_blank" href="http://sisplade.oaxaca.gob.mx/sisplade/">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-sisplade.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                    <td style="width: 10%;padding:10px;">
                        <a target="_blank" href="https://www.gob.mx/siap">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-siap.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                    <td style="width: 10%;padding:10px;">
                        <a target="_blank" href="https://www.gob.mx/conapo">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-conapo.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                    <td style="width: 10%;padding:10px;">
                        <a target="_blank" href="https://agenda2030.mx/#/home">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-ods.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                </tr>
            </table>
            <br />
            <br />
            <br />
        </div>
    </center>
    <style>
        .imgarea:hover {
            width: 90%;
            cursor: pointer;
            background-color: aliceblue;
        }
        .titleslider{
            background:rgba(255,255,255,1);
            background:linear-gradient(90deg,rgba(255,255,255,1) 0%,rgb(104, 27, 46) 100%); 
            opacity:.7; 
            padding:15px
        }
    </style>
@endsection
