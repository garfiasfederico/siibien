<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

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

<body class="font-sans antialiased" style="background-image:url('{{ asset('resources/images/logo_bg.png') }}');background-size:50px;"
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
                    style="background-image: url({{asset('images/main/cintillo.svg')}});width:100%;height:50px;background-repeat:no-repeat;background-size: 100%">
                </div>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        @yield('encabezado')
                    </div>
                    <div style="background-image:url('{{ asset('resources/images/logo_bg.png') }}');background-size:50px;">
                        @yield('content')
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


        </div>
        <!-- Page Content -->

    </div>
    <!-- General Modal-->
    <div class="modal fade" id="generalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="exampleModalLabel">Información del Indicador</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"
                        style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <script src="{{ asset('resources/vendor/jquery/jquery.min.js') }}"></script>
    @yield('scripts')
   <!-- <script src="{{ asset('resources/vendor/bootstrap/js/bootstrap.min.js') }}"></script>


    <script src="{{ asset('resources/vendor/jquery-easing/jquery.easing.min.js') }}"></script>


    <script src="{{ asset('resources/js/sb-admin-2.min.js') }}"></script>-->

</body>


</html>
