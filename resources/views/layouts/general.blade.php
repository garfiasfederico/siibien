<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Seguimiento Integral de los Indicadores del Bienestar">
    <meta name="author" content="Instancia Técnica de EValuación">
    <meta name="keywords" content="Indicadores, Indicadores Estratégicos, Indicadores de Oaxaca, Oaxaca, Seguimiento a Indicadores en Oxaca, Seguimiento de Indicadores, Desempeño" />

    <title>SIIBien</title>

    <link rel="icon" href="{{ asset('images/icon_.png') }}" type="image/ico" />
    <link href="{{ asset('resources/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/vendor/sweetalert/css/sweetalert2.min.css') }}" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    @yield('styles')
   <style>
    .ligas a:link {
        color: black;
        text-decoration: none;
    }

    .ligas a:hover {
        font-size: 1em;
        text-decoration: underline red;
    }

    .sombra-imagen {
        /
        box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.3) !important; 
        border-radius: 20px; 
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    
    .sombra-imagen:hover {
        transform: translateY(-5px);
        box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.45) !important;
    }
    .contenedor-scroll {
        width: 300px;           
        height: 200px;          
        overflow-y: auto;       
        border: 1px solid #ccc; 
        }
</style>


    <!-- Custom styles for this template-->
</head>

<body class="font-sans antialiased" style="background-image:url('{{ asset('resources/images/logo_bg.png') }}');"
    id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <div style="background-color:black;color:white;text-align:center; height:50px;display:table;width:100%">
                    <div style="display:table-cell; vertical-align:middle">
                        "2026, Año del Bicentenario del Natalicio de Margarita Maza Parada, ejemplo de dignidad, lealtad y servicio a la nación."
                    </div>
                </div>
                <div
                    style="background-image: url(images/main/cintillo_rombo.svg);width:100%;height:50px;background-repeat:no-repeat;background-size: 100%">
                </div>
                <nav class="navbar navbar-expand-md navbar-light bg-white">
                    <div class="container">
                        <a class="navbar-brand alert-heading" style="color:black;text-weight:bold" href="#">
                            <img src="{{ asset('images/siibien_colores.png') }}" style="width:200px;" />
                            <!--<h1><b>SIIBien</b></h1>-->
                        </a>
                       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                       <div class="collapse navbar-collapse" id="navbarsExample07">
                            <ul class="navbar-nav mr-auto align-items-center" style="font-size:1.1em;color:black">

                                <li class="nav-item active px-2">
                                    <a class="btn btn-light shadow-sm rounded-pill px-4" href="#">Inicio</a>
                                    <span class="sr-only">(current)</span>
                                </li>

                                <li class="nav-item" style="padding: 10px;">
                                    <a class="btn btn-light shadow-sm rounded-pill px-4" href="#">Marco Normativo</a>
                                </li>

                                <li class="nav-item px-2">
                                    <a class="btn shadow-sm rounded-pill px-4 text-white" style="background-color: #681b2e;" href="{{ route('login') }}">
                                        Ingresar al Sistema
                                    </a>
                                </li>

                                <!--
                                    <li class="nav-item px-2">
                                        <a target="_blank" class="btn shadow-sm rounded-pill px-4 text-white" style="background-color: rgb(179, 142, 93);" href="http://www.datos.oaxaca.gob.mx:8085/">
                                            Anexo Estadístico
                                        </a>
                                    </li>
                                -->
                                        <!--<li class="nav-item">
                                    <a class="nav-link disabled" href="#">Disabled</a>
                                </li>-->
                                        <!--<li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                                    <div class="dropdown-menu" aria-labelledby="dropdown07">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </li>-->
                            </ul>
                            <img src="resources/images/logo_finanzas.png" style="width:150px;">
                        </div>
                    </div>
                </nav>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        @yield('encabezado')
                    </div>
                    <div>
                        @yield('content')
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-black">
                <div style="width: 100%; margin: 0 auto;">
    
                    <div class="text-center" style="background-color:#cbcbcb; color:white;width:100%">
                        <br>
                        <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                        <h1 style="color:black; font-size:2em;">LIGAS DE INTERÉS</h1>
                        <div class="col-12">
                            <div class="contenedor-scroll px-3" style="overflow-x: auto; white-space: nowrap; width: 100%;">
                                    <table style="width: 100%; text-align: center; border-collapse: collapse;">
                                        <tr>
                                            <td style="width: 10%;padding:15px;">
                                                <a target="_blank" href="https://atlasdegenero.oaxaca.gob.mx/" class="sombra-imagen d-flex justify-content-center align-items-center bg-white shadow-sm text-decoration-none" style="width: 100px; height: 100px; padding: 20px;">
                                                    <img class="imgmaps" src="{{ asset('images/main/maps/map-ag.svg') }}" style="width: 150%; height: 150%; object-fit: contain;" alt="Atlas de Género" />
                                                </a>
                                            </td>
                                            <td style="width: 10%;padding:15px;">
                                                <a target="_blank" href="https://www.inegi.org.mx/" class="sombra-imagen d-flex justify-content-center align-items-center bg-white shadow-sm text-decoration-none" style="width: 100px; height: 100px; padding: 20px;">
                                                    <img class="imgmaps" src="{{ asset('images/main/maps/map-inegi.svg') }}"style="width: 150%; height: 150%; object-fit: contain;" alt="INEGI" />
                                                </a>
                                            </td>
                                            <td style="width: 10%; padding: 15px;">
                                                <a target="_blank" href="https://www.transparenciapresupuestaria.gob.mx/" class="sombra-imagen d-flex justify-content-center align-items-center bg-white shadow-sm text-decoration-none" style="width: 100px; height: 100px; padding: 20px;">
                                                    <img class="imgmaps" src="{{ asset('images/main/maps/map-TPF.svg') }}" style="width: 150%; height: 150%; object-fit: contain;" alt="transparenciapresupuestaria" />
                                                </a>
                                            </td>
                                            <td style="width: 10%;padding:15px;">
                                                <a target="_blank" href="https://www.coneval.org.mx/Paginas/principal.aspx" class="sombra-imagen d-flex justify-content-center align-items-center bg-white shadow-sm text-decoration-none" style="width: 100px; height: 100px; padding: 20px;">
                                                    <img class="imgmaps" src="{{ asset('images/main/maps/map-coneval.svg') }}"style="width: 150%; height: 150%; object-fit: contain;" alt="coneval" />
                                                </a>
                                            </td>
                                            <td style="width: 10%;padding:15px;">
                                                <a target="_blank" href="http://www.transparenciapresupuestaria.oaxaca.gob.mx/index.htm" class="sombra-imagen d-flex justify-content-center align-items-center bg-white shadow-sm text-decoration-none" style="width: 100px; height: 100px; 20px; padding: 20px;">
                                                    <img class="imgmaps" src="{{ asset('images/main/maps/map-Toaxaca.svg') }}"
                                                        style="width: 150%; height: 150%; object-fit: contain;" alt="transparenciapresupuestaria" />
                                                </a>
                                            </td>
                                        

                                            <td style="width: 10%;padding:15px;">
                                                <a target="_blank" href="http://sisplade.oaxaca.gob.mx/sisplade/" class="sombra-imagen d-flex justify-content-center align-items-center bg-white shadow-sm text-decoration-none" style="width: 100px; height: 100px; padding: 20px;">
                                                    <img class="imgmaps" src="{{ asset('images/main/maps/map-sisplade.svg') }}"
                                                        style="width: 150%; height: 150%; object-fit: contain;" alt="sisplade" />
                                                </a>
                                            </td>
                                            <td style="width: 10%;padding:15px;">
                                                <a target="_blank" href="https://www.gob.mx/siap" class="sombra-imagen d-flex justify-content-center align-items-center bg-white shadow-sm text-decoration-none" style="width: 100px; height: 100px; padding: 20px;">
                                                    <img class="imgmaps" src="{{ asset('images/main/maps/map-siap.svg') }}"
                                                        style="width: 150%; height: 150%; object-fit: contain;" alt="siap" />
                                                </a>
                                            </td>
                                            <td style="width: 10%;padding:15px;">
                                                <a target="_blank" href="https://www.gob.mx/conapo" class="sombra-imagen d-flex justify-content-center align-items-center bg-white shadow-sm text-decoration-none" style="width: 100px; height: 100px; 20px; padding: 20px;">
                                                    <img class="imgmaps" src="{{ asset('images/main/maps/map-conapo.svg') }}"
                                                        style="width: 150%; height: 150%; object-fit: contain;" alt="conapo" />
                                                </a>
                                            </td>
                                            <td style="width: 10%;padding:15px;">
                                                <a target="_blank" href="https://agenda2030.mx/#/home" class="sombra-imagen d-flex justify-content-center align-items-center bg-white shadow-sm text-decoration-none" style="width: 100px; height: 100px; padding: 20px;">
                                                    <img class="imgmaps" src="{{ asset('images/main/maps/map-ods.svg') }}"
                                                        style="width: 150%; height: 150%; object-fit: contain;" alt="agenda2030" />
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
                <center style="background-color: #000000">
                <div
                    style="background-image: url(images/main/cintillo_cafe.svg);width:100%;height:50px;background-repeat:no-repeat;background-size: 100%">
                </div>
                <table style="background-color:#000000;font-size:.8em;width:90%;">
                    <tr>
                        <td style="vertical-align: top;display:none">
                            <div style="padding:10px;color:white;" class="ligas">
                                <h1 style="text-decoration: underline red;">Ligas de Interés</h1>
                                <p><a href="#" style="color: white">
                                        Gobierno del Estado de Oaxaca
                                    </a></p>
                                <p><a href="#" style="color: white">
                                    Instituto de Planeación para el Bienestar
                                    </a></p>
                                <p><a href="#" style="color: white">
                                        Consejo Nacional de Evaluación (CONEVAL)
                                    </a></p>
                                <p><a href="#" style="color: white">
                                        Transparencia Presupuestaeria SHCP
                                    </a></p>
                            </div>
                        </td>
                        <td style="vertical-align: top">
                            <div style="padding: 10px;color: white;" class="ligas">
                                <h2 style="color: white; font-size: 1rem; font-weight: bold; letter-spacing: 1px; margin-bottom: 15px; text-transform: uppercase;">CONTACTO</h2>
                                <p style="color: white; margin-bottom: 8px; line-height: 1;">Secretaría de Finanzas</p>
                                <p style="color: white; margin-bottom: 8px; line-height: 1;">Dirección de la Instancia Técnica de Evaluación</p>
                                <p style="color: white; margin-bottom: 8px; line-height: 1;">Tel. 951 50 15 000 extensiones: 11410, 11252 y 11250</p>
                                <p style="color: white; margin-bottom: 8px; line-height: 1;">Correo electrónico: siibien.oaxaca@gmail.com</p>
                            </div>
                        </td>

                        <td style="vertical-align: top">
                            <div style="padding: 10px;color: white; background-color: #000000;" class="ligas">
                                <h2 style="color: white; font-size: 1rem; font-weight: bold; letter-spacing: 1px; margin-bottom: 15px; text-transform: uppercase;">DIRECCIÓN</h2>
                                <p style="color: white; margin-bottom: 8px; line-height: 1;">Complejo Administrativo "Benemérito de las Américas", Edificio 3 "Andrés Henestrosa", 1er nivel.</p>
                                <p style="color: white; margin-bottom: 8px; line-height: 1;">Carretera Oaxaca-Istmo Km. 11.5 Tlalixtac de Cabrera Oaxaca.</p>
                            </div>
                        </td>
        
                        <td style="vertical-align: middle">
                            <table>
                                <tr>
                                    <td style="text-align: right;">
                                        <img src="{{ asset('images/logoite.jpg') }}" style="width:500px;"
                                            class="flex">
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </center>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- Page Content -->

    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <script src="{{ asset('resources/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('resources/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('resources/js/sb-admin-2.min.js') }}"></script>

</body>


</html>
