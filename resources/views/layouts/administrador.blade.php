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
    <link href="{{ asset('resources/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @yield('styles')


    <!-- Custom styles for this template-->
</head>

<body class="font-sans antialiased" id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('main') }}">
                <div class="sidebar-brand-icon" style="padding-top:30px;">
                    <img src="{{ asset('images/siibien_blanco.png') }}" style="width: 200px;" />
                </div>
                <!--<div class="sidebar-brand-text mx-3">SIIBien</div>-->
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-3">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('main') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Principal</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{ route('info.ped') }}">
                    <i class="fas fa-fw fa-book"></i>
                    <span>PED 2022-2028</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{ route('info.a2030') }}">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Agenda 2030</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{ route('info.material') }}">
                    <i class="fas fa-fw fa-file"></i>
                    <span>Material de Apoyo</span></a>
            </li>

            @if (auth()->user()->ie)
                <!-- Divider -->
                <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading">
                    Monitoreo de Indicadores de Desempeño
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item" id="menuIndicadores">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-chart-line"></i>
                        <span>Indicadores Estratégicos</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Opciones:</h6>
                            <!--  <a class="collapse-item" href="{{ route('indicador') }}" id="optindicador">Registrar
                            Indicador</a>-->
                            <a class="collapse-item" href="{{ route('indicador.programacion') }}"
                                id="optindicadorprogramacion">Programación de Metas</a>
                            <a class="collapse-item" href="{{ route('indicador.monitoreo') }}"
                                id="optindicadormonitoreo">Monitoreo de Metas</a>
                            <a class="collapse-item" href="{{ route('indicador.list') }}"
                                id="optindicadorlistado">Listado</a>
                            <a class="collapse-item" href="{{ route('indicador.reportes') }}"
                                id="optindicadorreportes">Reportes</a>

                        </div>
                    </div>
                </li>
            @endif

            <!-- Nav Item - Utilities Collapse Menu -->
            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Indicadores de Gestión</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Opciones:</h6>
                        <a class="collapse-item" href="{{ route('building') }}">OELA</a>
                        <a class="collapse-item" href="{{ route('building') }}">Registar Indicador OELA</a>
                        <a class="collapse-item" href="{{ route('building') }}">Programacion de Metas</a>
                        <a class="collapse-item" href="{{ route('building') }}">Monitoreo</a>
                        <a class="collapse-item" href="{{ route('building') }}">Reportes</a>

                    </div>
                </div>
            </li>-->
            <!--
            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Seguimiento a Programas Proyectos y Acciones
            </div>-->
            @if (auth()->user()->iarto && auth()->user()->cuenta != 'SIIBIEN.IARTO')
                <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading">
                    Informe de Avances y Resultados de la Transformación de Oaxaca
                </div>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePPA"
                        aria-expanded="true" aria-controls="collapsePPA">
                        <i class="fas fa-fw fa-check"></i>
                        <span>IARTO</span>
                    </a>
                    <div id="collapsePPA" class="collapse" aria-labelledby="headingTwo"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Opciones:</h6>
                            <a class="collapse-item" id="pparegistro" href="{{ route('ppa.index') }}">Registro de
                                PPA</a>
                            <a class="collapse-item" id="ppalistado" href="{{ route('ppa.listado') }}">Listado de
                                PPA</a>
                            <!--<a class="collapse-item" href="{{ route('building') }}">Reportes</a>-->

                        </div>
                    </div>
                </li>
            @endif

            @if (auth()->user()->informe)
                <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading">
                    Informe Anual de Gobierno
                </div>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse-informee"
                        aria-expanded="true" aria-controls="collapsePPA">
                        <i class="fas fa-fw fa-check"></i>
                        <span>Informe de Gobierno</span>
                    </a>
                    <div id="collapse-informee" class="collapse" aria-labelledby="headingTwo"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Opciones:</h6>
                            <a class="collapse-item" id="informetemas" href="{{ route('informe.redactar') }}">Temas Asignados</a>
                            <!--<a class="collapse-item" href="{{ route('building') }}">Reportes</a>-->

                        </div>
                    </div>
                </li>
            @endif
            @if (auth()->user()->itar)
                <hr class="sidebar-divider">
                <!-- Heading -->
                <div class="sidebar-heading">
                    Informe Trimestral de Avances y Resultados
                </div>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse-itar"
                        aria-expanded="true" aria-controls="collapse-itar">
                        <i class="fas fa-fw fa-check"></i>
                        <span>ITAR</span>
                    </a>
                    <div id="collapse-itar" class="collapse" aria-labelledby="headingTwo"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Opciones:</h6>
                            <a class="collapse-item" id="itarregistro" href="{{ route('itar.index') }}">Registro PPA</a>
                            <a class="collapse-item" id="itarlistado" href="{{ route('itar.listado') }}">Listado PPA</a>
                        </div>
                    </div>
                </li>
            @endif


            @if (auth()->user()->hasRole("administrador") || auth()->user()->hasRole("administrador_informe") )
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Administración - Informe de Gobierno
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInforme"
                    aria-expanded="true" aria-controls="collapseInforme">
                    <i class="fas fa-fw fa-check"></i>
                    <span>Informe de Gobierno</span>
                </a>
                <div id="collapseInforme" class="collapse" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Opciones:</h6>
                        <a class="collapse-item" id="informematriz" href="{{ route('matriz') }}">Matriz de Coordinación</a>
                        <a class="collapse-item" id="informecarga" href="{{ route('informe.cargas') }}">Información Cargada</a>
                        <a class="collapse-item" id="informeacciones" href="{{ route('informe.adminacciones') }}">Listado de Acciones</a>
                        <!--<a class="collapse-item" href="{{ route('building') }}">Reportes</a>-->

                    </div>
                </div>
            </li>
            @endif
            @if (auth()->user()->hasRole("administrador") || auth()->user()->hasRole("administrador_itar") )
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Administración - Informe Trimestral
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseItarAdmin"
                    aria-expanded="true" aria-controls="collapseItarAdmin">
                    <i class="fas fa-fw fa-check"></i>
                    <span>ITAR</span>
                </a>
                <div id="collapseItarAdmin" class="collapse" aria-labelledby="headingTwo"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Opciones:</h6>
                        <a class="collapse-item" id="itarconcentrado" href="{{ route('admin.itar') }}">Concentrado de PPAs</a>
                    </div>
                </div>
            </li>
            @endif
            <!-- Divider -->
            <hr class="sidebar-divider">
            @if (session('idDependencia') == 0 &&
                    auth()->user()->hasRole('administrador') &&
                    auth()->user()->cuenta != 'SIIBIEN.IARTO')
                <!-- Heading -->
                <div class="sidebar-heading">
                    Administración Procesos SIIBien
                </div>
                <li class="nav-item" id="menuAdminIndicadores">
                    <a class="nav-link" href="{{ route('admin.indicadores') }}">
                        <i class="fas fa-fw fa-list"></i>
                        <span>Administrar Indicadores</span></a>
                </li>
                <li class="nav-item" id="menuAdminPPA">
                    <a class="nav-link" href="{{ route('admin.ppas') }}">
                        <i class="fas fa-fw fa-check"></i>
                        <span>Administrar IARTO</span></a>
                </li>
                <div class="sidebar-heading">
                    Catálogos
                </div>
                <li class="nav-item" id="menuDependencias">
                    <a class="nav-link" href="{{ route('dependencias') }}">
                        <i class="fas fa-fw fa-building"></i>
                        <span>Dependencias</span></a>
                </li>
                <!-- Nav Item - Charts -->
                <li class="nav-item" id="menuTitulares">
                    <a class="nav-link" href="{{ route('titulares') }}">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Titulares</span></a>
                </li>
                <li class="nav-item" id="menuEnlaces">
                    <a class="nav-link" href="{{ route('enlaces') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Enlaces y Usuarios</span></a>
                </li>
                <li class="nav-item" id="menuNotificaciones">
                    <a class="nav-link" href="{{ route('notificaciones') }}">
                        <i class="fas fa-fw fa-bell"></i>
                        <span>Mensajes y Notificaciones</span></a>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
            @endif

            @if (auth()->user()->cuenta == 'SIIBIEN.IARTO')
                <li class="nav-item" id="menuAdminPPA">
                    <a class="nav-link" href="{{ route('admin.ppas') }}">
                        <i class="fas fa-fw fa-check"></i>
                        <span>Administrar IARTO</span></a>
                </li>
            @endif

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <!--<div class="sidebar-card d-none d-lg-flex">
                    <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                    <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
                    <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
                </div>-->

        </ul>
        <div id="content-wrapper" class="d-flex flex-column" style="">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar"
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>-->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <!--  <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>-->
                        <!-- Counter - Alerts -->
                        <!--      <span class="badge badge-danger badge-counter">3+</span>
                            </a>-->
                        <!-- Dropdown - Alerts -->
                        <!--<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header" style="background-color: #681b2e;">
                                    Notificaciones
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to
                                            download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All
                                    Alerts</a>
                            </div>
                        </li>-->

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter" id="canMensajes"></span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header" style="background-color: #681b2e;">
                                    Bandeja de Mensajes
                                </h6>
                                <div id="mensajes">

                                </div>
                                <a class="dropdown-item text-center small text-gray-500" href="#"
                                    onclick="showMensajes()">Mostrar
                                    Mensajes Recibidos</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <!-- <img class="img-profile rounded-circle"
                                        src="img/undraw_profile.svg">-->
                                <i class="fas fa-user fa-sm fa-fw mr-2"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('perfil.edit') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cuenta
                                </a>
                                <a class="dropdown-item" href="#"
                                    onclick="changePassword({{ Auth::id() }})">
                                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cambiar Contraseña
                                </a>
                                <a class="dropdown-item" href="{{ route('perfil.responsiva') }}" target="_blank">
                                    <i class="fas fa-check fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Responsiva de Cuenta
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}" style="cursor:pointer">
                                    @csrf
                                    <a class="dropdown-item"
                                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Cerrar Sesión
                                    </a>
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        @yield('encabezado')
                    </div>
                    <main style="">
                        @yield('content')
                    </main>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Seguimiento Integral de Indicadores del Bienestar (SIIBien), Instancia
                            Técnica de
                            Evaluación, Jefatura de Gabinete, Gobierno del Estado de Oaxaca.</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- Page Content -->

    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
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

    <div class="modal fade" id="mensajeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="exampleModalLabel">Mensaje Recibido</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"
                        style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td style="width: 10%">Fecha: </td>
                            <td id="fechaMensaje" style="color:black;width:90%"> </td>
                        </tr>
                        <tr>
                            <td>Emisor: </td>
                            <td id="creadorMensaje" style="color:black"> Administrador </td>
                        </tr>
                        <tr>
                            <td>Mensaje: </td>
                            <td id="contentMensaje" style="color:black"> </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mensajesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="exampleModalLabel">Mensajes Recibidos</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"
                        style="color:white">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="allMensajes">
                    <table class="table">
                        <thead>
                            <tr>
                                <td style="width: 10%">Fecha: </td>
                                <td style="width: 20%">Emisor: </td>
                                <td style="width: 70%">Mensaje: </td>
                            </tr>
                        </thead>
                        <tbody id="cuerpoMensajes">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    @include('perfil.password')


    <script src="{{ asset('resources/vendor/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('resources/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


    <!-- Core plugin JavaScript-->
    <script src="{{ asset('resources/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('resources/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins-->
    <script src="{{ asset('resources/vendor/chart.js/Chart.min.js') }}"></script>


    <!-- Page level custom scripts-->
    <!--<script src="resources/js/demo/chart-area-demo.js"></script>-->



    <!-- Cargamos Sweet Alert-->
    <script src="{{ asset('resources/vendor/sweetalert/js/sweetalert2.min.js') }}"></script>

    <!--tables-->
    <script src="{{ asset('resources/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('resources/js/demo/datatables-demo.js') }}"></script>
    <script src="{{ asset('resources/js/jquery.blockUI.js') }}"></script>



    @yield('scripts')
    <script lang="javascript" type="text/javascript">
        function hola() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            })
        }
        $(document).ready(function() {
            getNotificaciones();
            $('[data-toggle="tooltip"]').tooltip();
        })

        function getNotificaciones() {
            $.ajax({
                type: 'GET',
                url: "{{ route('notificacion.get') }}",
                data: {
                    idUser: {{ Auth::id() }}
                },
                beforeSend: function() {
                    block(true)
                }
            }).done(function(response) {
                block(false);
                mensajes = "";
                if (response.success == "ok") {
                    if (response.notificaciones.length > 0) {
                        $("#canMensajes").html(response.notificaciones.length);
                    } else {
                        $("#canMensajes").html("");
                        mensajes =
                            "<center><i class='fas fa-info btn-circle'></i><br/>No hay mensajes pendientes de ver</center>";
                    }
                    for (x = 0; x < response.notificaciones.length; x++) {
                        fecha = new Date(response.notificaciones[x].created_at);
                        mensajes +=
                            '<a class="dropdown-item d-flex align-items-center" href="#" onclick="mensajeCompleto(' +
                            response.notificaciones[x].idNotificacion + ')">' +
                            '<div class="dropdown-list-image mr-3">' +
                            '<img class="rounded-circle" src="{{ asset('images/icon_.png') }}" alt="...">' +
                            '<div class="status-indicator bg-success"></div>' +
                            '</div>' +
                            '<div class="font-weight-bold">' +
                            '<div class="text-truncate">' + response.notificaciones[x].descripcion + '</div>' +
                            '<div class="small text-gray-500">Administrador · ' + fecha.getDate() + '/' + (fecha
                                .getMonth() + 1) + '/' + fecha.getFullYear() + '</div>' +
                            '</div>' +
                            '</a>';
                    }
                    $("#mensajes").html(mensajes);
                }
            }).fail(function(data) {

            });
        }

        function mensajeCompleto(idNotificacion) {
            //Obtenemos la información del mensaje
            $.ajax({
                type: 'GET',
                url: "{{ route('notificacion.info') }}",
                data: {
                    idNotificacion: idNotificacion
                },
                beforeSend: function() {
                    block(true)
                }
            }).done(function(response) {

                mensajes = "";
                if (response.success == "ok") {
                    fecha = new Date(response.info.created_at);
                    $("#fechaMensaje").html(fecha.getDate() + "/" + (fecha.getMonth() + 1) + "/" + fecha
                        .getFullYear());
                    $("#contentMensaje").html(response.info.descripcion);
                    getNotificaciones();
                } else {}
                $("#mensajeModal").modal("show");
                block(false);

            }).fail(function(data) {

            });

        }

        function showMensajes() {
            $.ajax({
                type: 'GET',
                url: "{{ route('notificacion.all') }}",
                data: {
                    idUser: {{ Auth::id() }}
                },
                beforeSend: function() {
                    block(true)
                }
            }).done(function(response) {
                block(false);
                mensajes = "";
                if (response.success == "ok") {
                    if (response.notificaciones.length == 0)
                        $("#allMensajes").html(
                            "<center><i class='fas fa-info btn-circle'></i><br/>No hay mensajes pendientes de ver</center>"
                            );
                    for (x = 0; x < response.notificaciones.length; x++) {
                        fecha = new Date(response.notificaciones[x].created_at);
                        mensajes += '<tr>' +
                            '<td id="fechaMensaje" style="color:black;width:10%">' + fecha.getDate() + '/' + (fecha
                                .getMonth() + 1) + '/' + fecha.getFullYear() + '</td>' +
                            '<td id="creadorMensaje" style="color:black;width:20%"> Administrador </td>' +
                            '<td id="contentMensaje" style="color:black;width:70%">' + response.notificaciones[x]
                            .descripcion + '</td>' +
                            '</tr>';
                    }
                    $("#cuerpoMensajes").html(mensajes);
                }
                $("#mensajesModal").modal("show");
            }).fail(function(data) {

            });
        }

        function block(val) {
            if (val) {
                $.blockUI({
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    },
                    message: "<h4>Procesando...</h4>"
                });
            } else {
                $.unblockUI();
            }
        }
    </script>

</body>

</html>
