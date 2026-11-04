@extends('layouts.general')
@section('content')
    <!--  <div style=" color:#919090">
                                                                                                            <h3 class="text-center">Seguimiento Integral de Indicadores del Bienestar</h3>
                                                                                                            <h4 class="text-center">(SIIBIEN)</h4>
                                                                                                        </div>
                                                                                                        <hr>-->
    <center style="background-image:url(resources/images/logo_bg.png);background-size:150px;">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"
            style="width:85%;background-image:url('resources/images/logo_bg.png')">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div style="background-color: #ffffff; padding: 10px; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0,0,0,0.05); margin-bottom: 10px;">
                        <img class="d-block w-100" src="resources/images/sliders/Grafica_PED.jpg" alt="primero">
                        <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;bottom:20px;"></div>
                            <div class="titleslider" style="display: none">
                                <h2 style="color:black;">Plan Estatal de Desarrollo 2022 - 2028</h2>
                                <!--<p style="color:black;">Instancia Técnica de Evaluación</p>-->
                            </div>
                        </div>
                </div>
                <!--   <div class="carousel-item" style="display: none">
                                                <img class="d-block w-100" src="resources/images/sliders/slider1.jpg" alt="primero">
                                                <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                                                    <div class="titleslider"
                                                        >
                                                        <h2 style="color:black;">Gobierno del Cambio</h2>
                                                        <h4 style="color:black;">La primavera Oaxaqueña ha llegado para quedarse, en Oaxaca comienza el cambio hacia la 4T, dónde nadie se queda fuera y nadie se queda atrás.</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="carousel-item" style="display: none">
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
                                            <div class="carousel-item" style="display: none">
                                                <img class="d-block w-100" src="resources/images/sliders/slider3.jpg" alt="tercero">
                                                <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                                                    <div class="titleslider"
                                                        >
                                                    <h2 style="color:black">Gobierno cercano a la gente</h2>
                                                    <h4 style="color:black">Las estrategias concebidas en la política pública de este Gobierno estan orientadas hacia el logro del bienestar para todas y todos.</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="carousel-item" style="display: none">
                                                <img class="d-block w-100" src="resources/images/sliders/slider4.jpg" alt="cuarto">
                                                <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                                                    <div class="titleslider"
                                                        >
                                                    <h2 style="color:black">Interculturalidad</h2>
                                                    <h4 style="color:black">Consciente de la riqueza étnica del Estado, este Gobierno busca fortalecer la identidad de los pueblos originarios y enaltecer sus costumbres y tradiciones.</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="carousel-item" style="display: none">
                                                <img class="d-block w-100" src="resources/images/sliders/slider5.jpg" alt="quinto">
                                                <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                                                    <div class="titleslider"
                                                        >
                                                    <h2 style="color:black">Primavera Oaxaqueña</h2>
                                                    <h4 style="color:black">El progreso es para todas y todos, en Oaxaca el tiempo de la transformación ya está sucediendo.</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="carousel-item" style="display: none">
                                                <img class="d-block w-100" src="resources/images/sliders/slider6.jpg" alt="First slide">
                                                <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                                                    <div class="titleslider"
                                                        >
                                                    <h2 style="color:black">Sostenibilidad</h2>
                                                    <h4 style="color:black">Un Gobierno comprometido con el desarrollo preponderando el cuidado y conservación ambiental de las ocho regiones del Estado.</h4>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="carousel-item" style="display: none">
                                                <img class="d-block w-100" src="resources/images/sliders/slider7.jpg" alt="First slide">
                                                <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                                                    <div class="titleslider"
                                                        >
                                                    <h2 style="color:black">Conservación del Patrimonio</h2>
                                                    <h4 style="color:black">La riqueza patrimonial debe conservarse y protegerse, es compromiso de este Gobierno impulsar acciones para la conservación de nuestro patrimonio.</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="carousel-item" style="display: none">
                                                <img class="d-block w-100" src="resources/images/sliders/slider8.jpg" alt="First slide">
                                                <div class="carousel-caption d-none d-md-block text-left" style="position: absolute;top:20px;">
                                                    <div class="titleslider"
                                                        >
                                                    <h2 style="color:black">Indicadores Estratégicos del Estado</h2>
                                                    <h4 style="color:black">Herramientas de Medición del Desempeño de este Gobierno.</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        -->
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

        <!--
        <div style="position:relative; top:-130px; background-color:;width:50%">
            <table style="width:100%" border="0">
                <tr>
                    <td
                        style="background-image: url(images/main/PEJES.svg);background-repeat:no-repeat;width:15%;height:250px;background-position:center;width: 16.6%">
                    </td>

                    <td style="background-image: url(images/main/EJE1.svg);background-repeat:no-repeat;background-size:70%;background-position:center;text-align:center;padding-left:20px; padding-right:20px;cursor:pointer;width: 16.6%"
                        onmouseover="$('#eje1text').css('display','block'); //setTimeout(function(){$('#eje1text').css('display','none');},2000);"
                        onmouseout="$('#eje1text').css('display','none');">
                        <a>
                            <div style="display:none;color:white;padding:15px;width:30%; background-color:rgb(78,172,162); opacity:.9; position:absolute; float:right; font-size:1em;text-align:left;z-index:50"
                                id="eje1text">
                                <span class="eje1" style="font-size:2em;">Eje 1</span>
                                <br />
                                <span class="eje1"> Estado de Bienestar para todas las oaxaqueñas y oaxaqueños</span>
                            </div>
                        </a>
                    </td>

                    <td style="background-image: url(images/main/EJE2.svg);background-repeat:no-repeat;background-size:70%;;background-position:center;text-align:center;padding-left:20px; padding-right:20px;cursor:pointer;width: 16.6%"
                        onmouseover="$('#eje2text').css('display','block'); //setTimeout(function(){$('#eje2text').css('display','none');},2000);"
                        onmouseout="$('#eje2text').css('display','none');">
                        <a>
                            <div style="display:none;color:white;padding:15px;width:30%; background-color:rgb(155,39,69); opacity:.9; position:absolute; float:right; font-size:1em;text-align:left;z-index:50"
                                id="eje2text" class="ejetext">
                                <span style="font-size:2em;">Eje 2</span>
                                <br />
                                <span>Gobierno honesto, cercano y transparente al servicio de los pueblos y
                                    comunidades</span>
                            </div>
                        </a>
                    </td>
                    <td style="background-image: url(images/main/EJE3.svg);background-repeat:no-repeat;background-size:70%;background-position:center;text-align:center;padding-left:20px; padding-right:20px;cursor:pointer;width: 16.6%"
                        onmouseover="$('#eje3text').css('display','block'); //setTimeout(function(){$('#eje3text').css('display','none');},2000);"
                        onmouseout="$('#eje3text').css('display','none');">
                        <a>
                            <div style="display:none;color:white;padding:15px;width:30%; background-color:rgb(97,119,172); opacity:.9; position:absolute; float:right; font-size:1em;text-align:left;z-index:50"
                                id="eje3text" class="ejetext">
                                <span style="font-size:2em;">Eje 3</span>
                                <br />
                                <span>Seguridad y Justicia para vivir en paz</span>
                            </div>
                        </a>
                    </td>
                    <td style="background-image: url(images/main/EJE4.svg);background-repeat:no-repeat;background-size:70%;background-position:center;text-align:center;padding-left:20px; padding-right:20px;cursor:pointer;width: 16.6%"
                        onmouseover="$('#eje4text').css('display','block'); //setTimeout(function(){$('#eje4text').css('display','none');},2000);"
                        onmouseout="$('#eje4text').css('display','none');">
                        <a>
                            <div style="display:none;color:white;padding:15px;width:30%; background-color:rgb(113,173,74); opacity:.9;position:absolute; float:right; font-size:1em;text-align:left;z-index:50"
                                id="eje4text" class="ejetext">
                                <span style="font-size:2em;">Eje 4</span>
                                <br />
                                <span>Crecimiento y Desarrollo Económico para las ocho regiones</span>
                            </div>
                        </a>
                    </td>
                    <td style="background-image: url(images/main/EJE5.svg);background-repeat:no-repeat;background-size:70%;background-position:center;text-align:center;padding-left:20px; padding-right:20px;cursor:pointer;width: 16.6%"
                        onmouseover="$('#eje5text').css('display','block'); //setTimeout(function(){$('#eje5text').css('display','none');},2000);"
                        onmouseout="$('#eje5text').css('display','none');">
                        <a>
                            <div style="display:none;color:white;padding:15px;width:30%; background-color:rgb(225,136,64); opacity:.9;position:absolute; float:right; font-size:1em;text-align:left;z-index:50"
                                id="eje5text" class="ejetext">
                                <span style="font-size:2em;">Eje 5</span>
                                <br />
                                <span>Infraestructura y servicios públicos para el desarrollo</span>
                            </div>
                        </a>
                    </td>
                </tr>
            </table>
        </div>

        <div style="position:relative; top:-140px;width:50%">
            <center>
                <table style="width: 100%;text-align:center;line-height:10px;z-index:0">

                    <tr>
                        <td colspan="4" style="background-color: rgb(163,65,110); color:white;border-radius:10px">
                            <br />
                            <h2>Ejes Transversales</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 100px;vertical-align:middle;">
                            <a>
                                <button class="btn btn-dark">
                                  Igualdad de género
                                </button>
                            </a>
                        </td>
                        <td>
                            <a>
                                <button class="btn btn-dark">
                                Desarrollo Sostenible
                                </button>
                            </a>
                        </td>
                        <td>
                            <a>
                                <button class="btn btn-dark">

                                    Interculturalidad
                                </button>
                            </a>
                        </td>
                        <td>
                            <a>
                                <button class="btn btn-dark">

                                    Niños, Niñas y Adolescentes
                                </button>
                            </a>
                        </td>
                    </tr>

                    <tr style="display: none">
                        <td>
                            <img src="{{ asset('/images/main/tran.png') }}" alt="">
                        </td>
                        <td>
                            <img src="{{ asset('/images/main/tran.png') }}" alt="">
                        </td>
                        <td>
                            <img src="{{ asset('/images/main/tran.png') }}" alt="">
                        </td>
                        <td>
                            <img src="{{ asset('/images/main/tran.png') }}" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td>

                        </td>
                    </tr>

                </table>
            </center>
        </div>
-->
<div style="width: 100%; margin: 0 auto;">

    <!-- Ejes Programáticos -->
    <div style="background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0,0,0,0.05); margin-bottom: 20px;">
        <table style="width: 50%; text-align: center; border-collapse: collapse;">
            <tr>
                <td style="width: 20%; padding: 15px; border-right: 1px solid #d1d1d1; vertical-align: middle;">
                    <div>
                        <img src="{{ asset('images/ejes_icons/programaticos/Ejes programaticos.svg') }}" style="width: 45px; height: 45px; margin-bottom: 10px;" alt="Icono Ejes">
                        <div style="color: #d31d0c; font-size: 2.2rem; font-weight: bold; line-height: 1;">5</div>
                        <div style="color: #555555; font-size: 0.85rem; font-weight: bold; margin-top: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Ejes Transversales</div>
                    </div>
                </td>
                <td style="width: 20%; padding: 15px; border-right: 1px solid #d1d1d1; vertical-align: middle;">
                    <div>
                        <img src="{{ asset('images/ejes_icons/programaticos/Temas.svg') }}" style="width: 45px; height: 45px; margin-bottom: 10px;" alt="Icono Temas">
                        <div style="color: #d31d0c; font-size: 2.2rem; font-weight: bold; line-height: 1;">36</div>
                        <div style="color: #555555; font-size: 0.85rem; font-weight: bold; margin-top: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Temas</div>
                    </div>
                </td>
                <td style="width: 20%; padding: 15px; border-right: 1px solid #d1d1d1; vertical-align: middle;">
                    <div>
                        <img src="{{ asset('images/ejes_icons/programaticos/Objetivos.svg') }}" style="width: 45px; height: 45px; margin-bottom: 10px;" alt="Icono Objetivos">
                        <div style="color: #d31d0c; font-size: 2.2rem; font-weight: bold; line-height: 1;">36</div>
                        <div style="color: #555555; font-size: 0.85rem; font-weight: bold; margin-top: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Objetivos</div>
                    </div>
                </td>
                <td style="width: 20%; padding: 15px; border-right: 1px solid #d1d1d1; vertical-align: middle;">
                    <div>
                        <img src="{{ asset('images/ejes_icons/programaticos/Estrategias.svg') }}" style="width: 45px; height: 45px; margin-bottom: 10px;" alt="Icono Estrategias">
                        <div style="color: #d31d0c; font-size: 2.2rem; font-weight: bold; line-height: 1;">102</div>
                        <div style="color: #555555; font-size: 0.85rem; font-weight: bold; margin-top: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Estrategias</div>
                    </div>
                </td>
                <td style="width: 20%; padding: 15px; vertical-align: middle;">
                    <div>
                        <img src="{{ asset('images/ejes_icons/programaticos/Lineas de accion.svg') }}" style="width: 45px; height: 45px; margin-bottom: 10px;" alt="Icono Líneas">
                        <div style="color: #d31d0c; font-size: 2.2rem; font-weight: bold; line-height: 1;">442</div>
                        <div style="color: #555555; font-size: 0.85rem; font-weight: bold; margin-top: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Líneas de Acción</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <br>

    <!-- Ejes Transversales -->
    <div style="background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0,0,0,0.05); margin-bottom: 20px;">
        <table style="width: 50%; text-align: center; border-collapse: collapse;">
            <tr>
                <td style="width: 20%; padding: 15px; border-right: 1px solid #d1d1d1; vertical-align: middle;">
                    <div>
                        <img src="{{ asset('images/ejes_icons/transversales/Ejes transversales.svg') }}" style="width: 45px; height: 45px; margin-bottom: 10px;" alt="Icono Ejes">
                        <div style="color: #c29b38; font-size: 2.2rem; font-weight: bold; line-height: 1;">4</div>
                        <div style="color: #555555; font-size: 0.85rem; font-weight: bold; margin-top: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Ejes Transversales</div>
                    </div>
                </td>
                <td style="width: 20%; padding: 15px; border-right: 1px solid #d1d1d1; vertical-align: middle;">
                    <div>
                        <img src="{{ asset('images/ejes_icons/transversales/Temas.svg') }}" style="width: 45px; height: 45px; margin-bottom: 10px;" alt="Icono Temas">
                        <div style="color: #c29b38; font-size: 2.2rem; font-weight: bold; line-height: 1;">36</div>
                        <div style="color: #555555; font-size: 0.85rem; font-weight: bold; margin-top: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Temas</div>
                    </div>
                </td>
                <td style="width: 20%; padding: 15px; border-right: 1px solid #d1d1d1; vertical-align: middle;">
                    <div>
                        <img src="{{ asset('images/ejes_icons/transversales/Objetivos.svg') }}" style="width: 45px; height: 45px; margin-bottom: 10px;" alt="Icono Objetivos">
                        <div style="color: #c29b38; font-size: 2.2rem; font-weight: bold; line-height: 1;">36</div>
                        <div style="color: #555555; font-size: 0.85rem; font-weight: bold; margin-top: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Objetivos</div>
                    </div>
                </td>
                <td style="width: 50%; padding: 15px; border-right: 1px solid #d1d1d1; vertical-align: middle;">
                    <div>
                        <img src="{{ asset('images/ejes_icons/transversales/Estrategias.svg') }}" style="width: 45px; height: 45px; margin-bottom: 10px;" alt="Icono Estrategias">
                        <div style="color: #c29b38; font-size: 2.2rem; font-weight: bold; line-height: 1;">102</div>
                        <div style="color: #555555; font-size: 0.85rem; font-weight: bold; margin-top: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Estrategias</div>
                    </div>
                </td>
                <td style="width: 20%; padding: 15px; vertical-align: middle;">
                    <div>
                        <img src="{{ asset('images/ejes_icons/transversales/Lineas de accion.svg') }}" style="width: 45px; height: 45px; margin-bottom: 10px;" alt="Icono Líneas">
                        <div style="color: #c29b38; font-size: 2.2rem; font-weight: bold; line-height: 1;">442</div>
                        <div style="color: #555555; font-size: 0.85rem; font-weight: bold; margin-top: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Líneas de Acción</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</div>

<!-- Indicadores -->
<div class="text-center" style="background-color: transparent; width: 100%; margin: 0 auto;">
    <h1 style="color: black; font-size: 2em;">INDICADORES</h1>
    
    <h3 style="margin-top: 20px;">Planes Estratégicos Sectoriales</h3>
    <table style="width: 70%; margin: 0 auto; text-align: center;">
        <tr>
            <td style="width: 20%; padding: 5px;"><img class="imgarea" src="{{ asset('images/main/areas/indicador/Estadodebienestar.svg') }}" style="width: 70%" alt=""></td>
            <td style="width: 20%; padding: 5px;"><img class="imgarea" src="{{ asset('images/main/areas/indicador/Educacion.svg') }}" style="width: 70%" alt=""></td>
            <td style="width: 20%; padding: 5px;"><img class="imgarea" src="{{ asset('images/main/areas/indicador/Salud.svg') }}" style="width: 70%" alt=""></td>
            <td style="width: 20%; padding: 5px;"><img class="imgarea" src="{{ asset('images/main/areas/indicador/Gobiernohonesto.svg') }}" style="width: 70%" alt=""></td>
            <td style="width: 20%; padding: 5px;"><img class="imgarea" src="{{ asset('images/main/areas/indicador/Seguridadyjusticia.svg') }}" style="width: 70%" alt=""></td>
        </tr>
        <tr>
            <td style="width: 20%; padding: 5px;"><img class="imgarea" src="{{ asset('images/main/areas/indicador/Crecimientoydesarrolloeconomico.svg') }}" style="width: 70%" alt=""></td>
            <td style="width: 20%; padding: 5px;"><img class="imgarea" src="{{ asset('images/main/areas/indicador/Fomentoagroalimentario.svg') }}" style="width: 70%" alt=""></td>
            <td style="width: 20%; padding: 5px;"><img class="imgarea" src="{{ asset('images/main/areas/indicador/Turismo.svg') }}" style="width: 70%" alt=""></td>
            <td style="width: 20%; padding: 5px;"><img class="imgarea" src="{{ asset('images/main/areas/indicador/Infraestructura.svg') }}" style="width: 70%" alt=""></td>
            <td style="width: 20%; padding: 5px;"><img class="imgarea" src="{{ asset('images/main/areas/indicador/Movilidad.svg') }}" style="width: 70%" alt=""></td>
        </tr>
    </table>

    <hr style="margin: 20px 0;" />

    <h2 style="margin-top: 20px;">Planes Especiales</h2>
    <table style="width: 70%; margin: 0 auto; text-align: center;">
        <tr>
            <td style="width: 25%; padding: 5px;"><img class="imgarea" src="{{ asset('images/main/areas/especiales/Igualdaddegenero.svg') }}" style="width: 70%" alt=""></td>
            <td style="width: 25%; padding: 5px;"><img class="imgarea" src="{{ asset('images/main/areas/especiales/Desarrollosostenible.svg') }}" style="width: 70%" alt=""></td>
            <td style="width: 25%; padding: 5px;"><img class="imgarea" src="{{ asset('images/main/areas/especiales/Interculturalidad.svg') }}" style="width: 70%" alt=""></td>
            <td style="width: 25%; padding: 5px;"><img class="imgarea" src="{{ asset('images/main/areas/especiales/niños.svg') }}" style="width: 70%" alt=""></td>
        </tr>
    </table>
</div>

<hr />
        <!--
        <div class="text-center" style="background-color:#cbcbcb; color:white;width:105%">
            {{-- asignamos un contenedor flexibe para que se puedan mostrar de manera lineal todos --}}
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
            <h1 style="font-size:3em;">Ligas de Interés</h1>
            <table style="width:100%">
                
                    <td style="width: 10%;padding:5px;">
                        <a target="_blank" href="https://atlasdegenero.oaxaca.gob.mx/">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-ag.svg') }}" style="width: 80%;" />
                        </a>
                    </td>
                    <td style="width: 10%;padding:5px;">
                        <a target="_blank" href="https://www.inegi.org.mx/">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-inegi.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                    <td style="width: 10%;padding:5px;">
                        <a target="_blank" href="https://www.transparenciapresupuestaria.gob.mx/">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-TPF.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                    <td style="width: 10%;padding:5px;">
                        <a target="_blank" href="https://www.coneval.org.mx/Paginas/principal.aspx">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-coneval.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                    <td style="width: 10%;padding:5px;">
                        <a target="_blank" href="http://www.transparenciapresupuestaria.oaxaca.gob.mx/index.htm">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-Toaxaca.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                

                    <td style="width: 10%;padding:5px;">
                        <a target="_blank" href="http://sisplade.oaxaca.gob.mx/sisplade/">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-sisplade.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                    <td style="width: 10%;padding:5px;">
                        <a target="_blank" href="https://www.gob.mx/siap">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-siap.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                    <td style="width: 10%;padding:5px;">
                        <a target="_blank" href="https://www.gob.mx/conapo">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-conapo.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                    <td style="width: 10%;padding:5px;">
                        <a target="_blank" href="https://agenda2030.mx/#/home">
                            <img class="imgmaps" src="{{ asset('images/main/maps/map-ods.svg') }}"
                                style="width: 80%;" />
                        </a>
                    </td>
                
            </table>
            <br />
            <br />
            <br />
        </div>

-->
    </center>
    <style>
        .imgarea:hover {
            width: 90%;
            cursor: pointer;
            background-color: aliceblue;
        }

        .titleslider {
            background: rgba(255, 255, 255, 1);
            background: linear-gradient(90deg, rgba(255, 255, 255, 1) 0%, rgb(104, 27, 46) 100%);
            opacity: .7;
            padding: 15px
        }
    </style>
@endsection

<!--<a href="{{ route('indicadoreseje', 0) }}">-->
