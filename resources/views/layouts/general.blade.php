<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Seguimiento Integral de los Indicadores del Bienestar">
    <meta name="author" content="Jefatura de Gabinete">
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
                        "2024, BICENTENARIO DE LA INTEGRACIÓN DE OAXACA A LA REPÚBLICA MEXICANA"
                    </div>
                </div>
                <div
                    style="background-image: url(images/main/cintillo.svg);width:100%;height:50px;background-repeat:no-repeat;background-size: 100%">
                </div>
                <nav class="navbar navbar-expand-lg" style="background-color:white;">
                    <div class="container" style="width: 80%">
                        <a class="navbar-brand alert-heading" style="color:black;text-weight:bold" href="#">
                            <img src="{{ asset('images/siibien_colores.png') }}" style="width:200px;" />
                            <!--<h1><b>SIIBien</b></h1>-->
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="true"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarsExample07">
                            <ul class="nav mr-auto nav-pills nav-fill " style="font-size:1.2em;color:black">
                                <li class="nav-item active" style="padding: 10px;">
                                    <a class="nav-link" style="color:black;" href="#">Inicio <span
                                            class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item" style="padding: 10px;">
                                    <a class="nav-link" style="color:black;" href="#">Marco Normativo</a>
                                </li>
                                <li class="nav-item" style="padding: 10px;">
                                    <button class="btn" style="background-color:#681b2e;">
                                        <a class="nav-link" style="color:white;" href="{{ route('login') }}">Ingresar al
                                            Sistema</a>
                                    </button>
                                </li>
                                <li class="nav-item" style="padding: 10px;">
                                    <button class="btn btn-dark" >
                                        <a target="_blank" class="nav-link" style="color:white;" href="http://www.datos.oaxaca.gob.mx:8085/">Anexo Estadístico</a>
                                    </button>
                                </li>
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
                <div
                    style="background-image: url(images/main/cintillo_footer.svg);width:100%;height:50px;background-repeat:no-repeat;background-size: 100%">
                </div>
                <center style="background-color: #000000">
                <table style="background-color:#000000;font-size:.8em;width:80%;">
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
                            <div style="padding:10px;color:white;" class="ligas">
                                <h1 style="text-decoration: underline white;color:white;">Contacto</h1>
                                <p style="color:white;line-height:1px;">Secretaría de Finanzas</p>
                                <p style="color:white;line-height:1px;">Dirección de la Instancia Técnica de Evaluación</p>
                                <p style="color:white;line-height:1px;">Tel. 951 50 15 000 extensiones: 11410, 11252 y 11250</p>
                                <p style="color:white;line-height:1px;">Correo electrónico: siibien.oaxaca@gmail.com</p>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding:10px;color:black;background-color:#000000" class="ligas">
                                <h1 style="text-decoration: underline white;color:white;">Dirección</h1>
                                <table style="width:100%" border="0">
                                    <tr>
                                        <td>
                                            <p style="color:white;line-height:1px;">Complejo Administrativo "Benemérito de las Américas", Edificio 3 "Andrés Henestrosa", 1er nivel.</p>
                                            <p style="color:white;line-height:1px;">Carretera Oaxaca-Istmo Km. 11.5 Tlalixtac de Cabrera Oaxaca.</p>
                                        </td>

                                    </tr>
                                </table>
                            </div>
                        </td>
                        <td style="vertical-align: middle">
                            <table>
                                <tr>
                                    <td style="text-align: right;">
                                        <img src="{{ asset('images/logo_blanco.png') }}" style="width:200px;"
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
