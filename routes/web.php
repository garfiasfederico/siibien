<?php

use App\Models\Indicador;
use App\Models\Dependencia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PEDController;
use App\Http\Controllers\PPAController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\EnlaceController;
use App\Http\Controllers\MatrizController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TitularController;
use App\Http\Controllers\TemporalController;
use App\Http\Controllers\VariableController;
use App\Http\Controllers\IndicadorController;
use App\Http\Controllers\DependenciaController;
use App\Http\Controllers\NotificacionesController;

use App\Http\Controllers\MediosVerificacionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\ItarController;
use App\Http\Controllers\SectorialController;

use App\Http\Controllers\ProductoSectorialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');

Route::get('/', function () {
    return view('welcome');
})->name('inicio');

Route::get('/test', function () {
    return view('test');
})->name('test');

Route::get('/building', function () {
    return view('building');
})->name('building');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/nopermitido', function () {
    return view("nopermitido");
})->name('nopermitido');

Route::get('/registro', function () {
    $dependencias = Dependencia::select("*")->orderBy("dependenciaNombre","ASC")->get();
    return view("temporal.registroasistencia")->with('dependencias', $dependencias);
})->name('registro');

Route::get('/descarga', function () {
    return view("temporal.descarga");
})->name('descarga');

Route::get('/encuesta', function () {
    return view("temporal.encuesta");
})->name('encuesta');

Route::get('/encuesta2025', function () {
    return view("temporal.encuesta2025");
})->name('encuesta2025');

Route::get('/encuestaresultados', function () {
    return view("temporal.encuestaresultados");
})->name('encuestaresultados');

Route::get('/indicadoreseje/{eje_id}', [TemporalController::class, 'indicadoreseje'])->name('indicadoreseje');



Route::post('/almacenaregistro', [TemporalController::class, 'registraasistencia'])->name('registraasistencia');
Route::get('/descargaasistencias', [TemporalController::class, 'downloadasistencias'])->name('descargaasistencias');

Route::post('/registraencuesta', [TemporalController::class, 'registraencuesta'])->name('registraencuesta');
Route::post('/registraencuesta2025', [TemporalController::class, 'registraencuesta2025'])->name('registraencuesta2025');

Route::get('/resultadosencuesta', [TemporalController::class, 'downloadresultadosencuesta'])->name('encuestaresultados');
Route::get('/resultadosencuesta2025', [TemporalController::class, 'downloadresultadosencuesta2025'])->name('encuestaresultados2025');
Route::get('/indicador/info', [IndicadorController::class, 'info'])->name('indicador.info');
Route::get('/indicador/historicos', [IndicadorController::class, 'gethistoricos'])->name('indicador.valores.gethistoricos');
Route::get('/indicador/valores/programados', [IndicadorController::class, 'getprogramados'])->name('indicador.valores.programados');



Route::middleware('auth')->group(function () {

    Route::middleware('blocked')->group(function () {

        Route::get('/main', function () {
            if (session("idDependencia") == 0)
                $indicadores = Indicador::join("dependencia", "dependencia.idDependencia", "=", "indicador.idDependencia")
                    ->where("indicador.status", 1)
                    ->get();
            else
                $indicadores = Indicador::where("indicador.idDependencia", session("idDependencia"))
                    ->where("indicador.status", 1)
                    ->join("dependencia", "dependencia.idDependencia", "=", "indicador.idDependencia")->get();

            return view('main')->with("indicadores", $indicadores);
        })->middleware(['auth', 'verified'])->name('main');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('/indicador/list', [IndicadorController::class, 'list'])->name('indicador.list');

        Route::get('/indicador/getstatus', [IndicadorController::class, 'getstatus'])->name('indicador.getstatus');

        Route::middleware('enlace')->group(function () {
            Route::get('/indicador', [IndicadorController::class, 'index'])->name('indicador');
            Route::post('/indicador', [IndicadorController::class, 'create'])->name('indicador.storage');


            Route::get('/indicador/edit/{id}', [IndicadorController::class, 'edit'])->middleware('indicador.permission')->name('indicador.edit');
            Route::post('/indicador/update', [IndicadorController::class, 'update'])->name('indicador.update');
            Route::post('/indicador/delete', [IndicadorController::class, 'delete'])->name('indicador.delete');
            Route::get('/indicador/download/{id}', [IndicadorController::class, 'download'])->name('indicador.download');
            Route::get('/indicador/programacion', [IndicadorController::class, 'programacion'])->name('indicador.programacion');

            Route::post('/indicador/historico', [IndicadorController::class, 'addhistorico'])->name('indicador.valores.addhistoricos');

            Route::post('/indicador/valores/delete', [IndicadorController::class, 'deletevalorhistorico'])->name('indicador.valoreshistoricos.delete');

            Route::post('/indicador/valores/programado', [IndicadorController::class, 'addprogramado'])->name('indicador.valores.addprogramado');

            Route::post('/indicador/valores/programados/delete', [IndicadorController::class, 'deletevalorprogramado'])->name('indicador.valoresprogramados.delete');

            Route::get('/indicador/variables', [IndicadorController::class, 'getvariables'])->name('indicador.variables');


            Route::post('/variable/historicos', [VariableController::class, 'addhistorico'])->name('variable.valores.addhistorico');
            Route::get('/variable/historicos', [VariableController::class, 'gethistoricos'])->name('variable.valores.historicos');
            Route::post('/variable/valores/historicos/delete', [VariableController::class, 'deletevalorhistorico'])->name('variable.valoreshistoricos.delete');

            Route::post('/variable/programados', [VariableController::class, 'addprogramado'])->name('variable.valores.addprogramado');
            Route::get('/variable/programados', [VariableController::class, 'getprogramados'])->name('variable.valores.programados');
            Route::post('/variable/valores/programados/delete', [VariableController::class, 'deletevalorprogramado'])->name('variable.valoresprogramados.delete');

            Route::get('/indicador/monitoreo', [IndicadorController::class, 'monitoreo'])->name('indicador.monitoreo');
            Route::post('/indicador/metas', [IndicadorController::class, 'updatemeta'])->name('indicador.metas.setvalor');

            Route::post('/variable/metas', [VariableController::class, 'updatemeta'])->name('variable.valores.setmeta');

            Route::post('/indicador/valor/medio', [MediosVerificacionController::class, 'storevalindicador'])->name('indicador.valor.medioverificacion');
            Route::get('/indicador/valor/medios', [MediosVerificacionController::class, 'getmediosbyindicador'])->name('indicador.valor.medios');
            Route::post('/indicador/valor/deletemedio', [MediosVerificacionController::class, 'deletemedio'])->name('indicador.valor.deletemedio');

            Route::post('/variable/valor/medio', [MediosVerificacionController::class, 'storevalvariable'])->name('variable.valor.medioverificacion');
            Route::get('/variable/valor/medios', [MediosVerificacionController::class, 'getmediosbyvariable'])->name('variable.valor.medios');
            Route::post('/variable/valor/deletemedio', [MediosVerificacionController::class, 'deletemediovariable'])->name('variable.valor.deletemedio');
        });
        Route::get('/indicador/reportes', [IndicadorController::class, 'reportes'])->name('indicador.reportes');

        Route::get('/perfil', [PerfilController::class, 'edit'])->name('perfil.edit');
        Route::post('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
        Route::post('/perfil/changepassword', [PerfilController::class, 'changepassword'])->name('perfil.changepassword');
        Route::get('/perfil/responsiva', [PerfilController::class, 'responsiva'])->name('perfil.responsiva');
        Route::post('/perfil/responsivap', [PerfilController::class, 'responsiva'])->name('perfil.responsivap');

        Route::get('/ppa', [PPAController::class, 'index'])->name('ppa.index');
        Route::post('/ppa/store', [PPAController::class, 'store'])->name('ppa.store');
        Route::get('/ppa/listado', [PPAController::class, 'listado'])->name('ppa.listado');
        Route::get('/ppa/edit/{id}', [PPAController::class, 'edit'])->name('ppa.edit');
        Route::get('/ppa/download/{id}', [PPAController::class, 'download'])->name('ppa.download');
        Route::post('/ppa/medios/upload', [PPAController::class, 'medioupload'])->name('ppa.medioupload');
        Route::get('/ppa/mediotemp/remove', [PPAController::class, 'mediotempremove'])->name('ppa.medio.tempremove');
        Route::get('/ppa/oficializar', [PPAController::class, 'oficializar'])->name('ppa.oficializar');







        Route::get('/gettemas', [PEDController::class, 'gettemas'])->name('gettemas');
        Route::get('/getobjetivos', [PEDController::class, 'getobjetivos'])->name('getobjetivos');
        Route::get('/getestrategias', [PEDController::class, 'getestrategias'])->name('getestrategias');
        Route::get('/getlineas', [PEDController::class, 'getlineas'])->name('getlineas');
        Route::get('/getlineasbyobjetivo', [PEDController::class, 'getlineasbyobjetivo'])->name('getlineasbyobjetivo');
        Route::get('/getprogramas', [PEDController::class, 'getprogramas'])->name('getprogramas');

        //funciones para los catalogos de los sectoriales
        Route::get('/getobjetivossector', [SectorialController::class, 'getobjetivossector'])->name('getobjetivossector');
        Route::get('/getestrategiassector', [SectorialController::class, 'getestrategiassector'])->name('getestrategiassector');
        Route::get('/getproductossector', [SectorialController::class, 'getproductossector'])->name('getproductossector');


        //Funciones para solo superusuarios

        Route::middleware('permission')->group(function () {
            Route::get('/dependencias', [DependenciaController::class, 'list'])->name("dependencias");
            Route::post('/dependencias/save', [DependenciaController::class, 'save'])->name("dependencia.save");
            Route::post('/dependencias/delete', [DependenciaController::class, 'delete'])->name("dependencia.delete");
            Route::get('/dependencia/download', [DependenciaController::class, 'downloaddependencias'])->name("dependencia.download");
            Route::get('/dependencia/downloadxls', [DependenciaController::class, 'downloaddependenciasxls'])->name("dependencia.downloadxls");
            Route::get('/dependencia/downloadcsv', [DependenciaController::class, 'downloaddependenciascsv'])->name("dependencia.downloadcsv");

            Route::get('/titulares', [TitularController::class, 'list'])->name("titulares");
            Route::post('/titular/save', [TitularController::class, 'save'])->name("titular.save");
            Route::post('/titular/delete', [TitularController::class, 'delete'])->name("titular.delete");
            Route::get('/titular/download', [TitularController::class, 'downloadtitulares'])->name("titular.download");
            Route::get('/titular/downloadxls', [TitularController::class, 'downloadtitularesxls'])->name("titular.downloadxls");
            Route::get('/titular/downloadcsv', [TitularController::class, 'downloadtitularescsv'])->name("titular.downloadcsv");

            Route::get('/enlaces', [EnlaceController::class, 'list'])->name("enlaces");
            Route::post('/enlace/save', [EnlaceController::class, 'save'])->name("enlace.save");
            Route::post('/enlace/delete', [EnlaceController::class, 'delete'])->name("enlace.delete");
            Route::get('/enlace/download', [EnlaceController::class, 'downloadenlaces'])->name("enlace.download");
            Route::get('/enlace/downloadxls', [EnlaceController::class, 'downloadenlacesxls'])->name("enlace.downloadxls");
            Route::get('/enlace/downloadcsv', [EnlaceController::class, 'downloadenlacescsv'])->name("enlace.downloadcsv");
            Route::post('/enlace/validalayout', [EnlaceController::class, 'validalayout'])->name("enlace.validalayout");
            Route::get('/enlace/leelayout/{layout}', [EnlaceController::class, 'leelayout'])->name("enlace.leelayout");
            Route::post('/enlace/upload', [EnlaceController::class, 'enlaceupload'])->name("enlace.upload");


            Route::get('/user', [EnlaceController::class, 'user'])->name("user");
            Route::post('/user/save', [EnlaceController::class, 'usersave'])->name("user.save");
            Route::post('/user/setstatus', [EnlaceController::class, 'updatestatususer'])->name("user.updatestatus");

            Route::get('/notificaciones', [NotificacionesController::class, 'index'])->name("notificaciones");
            Route::post('/notificacion/add', [NotificacionesController::class, 'save'])->name("notificacion.save");

            Route::get('/admin/indicadores', [IndicadorController::class, 'adminindicadores'])->name("admin.indicadores");
            Route::post('/admin/indicador/updateresponsable', [IndicadorController::class, 'updateresponsable'])->name("admin.indicador.updateresponsable");
            Route::get('/admin/indicador/edit/{id}', [IndicadorController::class, 'adminedit'])->name("admin.indicador.edit");
            Route::get('/admin/indicador/downloadxlsx', [IndicadorController::class, 'admindownloadxlsx'])->name("admin.indicador.downloadxlsx");
            Route::get('/admin/indicador/downloadxlsxdetallado', [IndicadorController::class, 'admindownloadxlsxdetallado'])->name("admin.indicador.downloadxlsxdetallado");

            Route::post('/admin/indicador/updatedata', [IndicadorController::class, 'updatedata'])->name("admin.indicador.updatedata");




            Route::post('/admin/indicadores/updatepermission', [IndicadorController::class, 'updatepermission'])->name("admin.indicador.updatepermission");


            Route::get('/admin/ppas', [PPAController::class, 'adminppas'])->name("admin.ppas");
            Route::get('/admin/ppas/downloadxlsx', [PPAController::class, 'admindownloadxlsx'])->name("admin.ppas.downloadxlsx");

            Route::post('/user/updateestatuspermiso', [EnlaceController::class, 'updateestatuspermiso'])->name("user.updateestatuspermiso");


        });

        Route::get('/indicador/admindownload/{id}', [IndicadorController::class, 'admindownload'])->name('indicador.admin.download');
        Route::get('/admin/indicadores/filtros', [IndicadorController::class, 'getindicadoresbyfiltros'])->name("admin.indicadores.filtros");

        Route::middleware('admin.informe')->group(function () {
            Route::get('/matriz', [MatrizController::class, 'index'])->name("matriz");
            Route::post('/matriz/uptroltema', [MatrizController::class, 'uptroltema'])->name("matriz.uptroltema");
            Route::get('/informe/cargas', [InformeController::class, 'index'])->name("informe.cargas");
            Route::get('/informe/adminacciones', [InformeController::class, 'adminacciones'])->name("informe.adminacciones");
            Route::post('/informe/accion/updatemaxp', [InformeController::class, 'updatemaxp'])->name("informe.accion.updatemaxp");
            //Route::get('/informe/accion/getparrafos', [InformeController::class, 'getparrafos'])->name("informe.accion.getparrafos");
            Route::post('/informe/tema/getcomplementoszip', [InformeController::class, 'getcomplementoszip'])->name("informe.tema.getcomplementoszip");
            Route::post('/informe/accion/updatecampo', [InformeController::class, 'updatecampo'])->name("informe.accion.updatecampo");
            Route::post('/informe/accion/nueva', [InformeController::class, 'nuevaaccion'])->name("informe.nuevaaccion");
            Route::post('/informe/redaccion/bloqueotema', [InformeController::class, 'bloqueotema'])->name("informe.bloqueotema");
            Route::get('/informe/cumplimiento', [InformeController::class, 'cumplimiento'])->name("informe.cumplimiento");
            Route::get('/informe/resumen', [InformeController::class, 'resumen'])->name("informe.resumen");
            Route::get('/informe/porlineas', [InformeController::class, 'porlineas'])->name("informe.porlineas");




        });


        //Route::middleware('admin.itar')->group(function () {
        //  Route::get('/itaradmin', [ItarController::class, 'indexadmin'])->name("admin.itar");
        //});

        Route::middleware('admin.itar')->group(function () {
            Route::get('/itaradmin', [ItarController::class, 'indexadmin'])->name("admin.nuevoitar");
        });
        Route::post('/itaradmin/updateestado', [ItarController::class, 'uptestado'])->name("admin.itar.uptestado");
        Route::post('/itaradmin/setprioritario', [ItarController::class, 'setprioritario'])->name("admin.itar.setprioritario");
        Route::get('/informe/redactar', [InformeController::class, 'redactar'])->name("informe.redactar");
        Route::post('/informe/acciones', [InformeController::class, 'acciones'])->name("informe.acciones");
        Route::post('/informe/downloadword', [InformeController::class, 'downloadword'])->name("informe.downloadword");
        Route::post('/informe/saveaccion', [InformeController::class, 'saveaccion'])->name("informe.saveaccion");
        Route::get('/informe/getinfoaccion', [InformeController::class, 'getinfoaccion'])->name("informe.getinfoaccion");
        Route::get('/informe/accion/redactar/{id}', [InformeController::class, 'redactaparrafos'])->name("informe.redactaparrafos");
        Route::post('/informe/accion/almacenap', [InformeController::class, 'almacenap'])->name("informe.almacenap");
        Route::post('/informe/accion/updateordenparrafo', [InformeController::class, 'updateordenparrafo'])->name("informe.updateordenparrafo");
        Route::post('/informe/accion/updatestatusparrafo', [InformeController::class, 'updatestatusparrafo'])->name("informe.updatestatusparrafo");
        Route::get('/informe/accion/getinfoparrafo', [InformeController::class, 'getinfoparrafo'])->name("informe.getinfoparrafo");
        Route::post('/informe/parrafo/uploadcomplemento', [InformeController::class, 'uploadcomplemento'])->name("informe.uploadcomplemento");
        Route::get('/informe/parrafo/getcomplementos', [InformeController::class, 'getcomplementos'])->name("informe.getcomplementos");
        Route::post('/informe/parrafo/delcomplemento', [InformeController::class, 'deletecomplemento'])->name("informe.deletecomplemento");
        Route::post('/informe/accion/delete', [InformeController::class, 'deleteaccion'])->name("informe.deleteaccion");
        Route::post('/informe/accion/changestatus', [InformeController::class, 'changestatus'])->name("informe.changestatusaccion");

        Route::post('/informe/parrafo/savecomplementos', [InformeController::class, 'savecomplementos'])->name("informe.savecomplementos");
        Route::post('/informe/deleteparrafo', [InformeController::class, 'deleteparrafo'])->name("informe.deleteparrafo");
        Route::post('/informe/tema/acciones', [InformeController::class, 'checkacciones'])->name("informe.checkacciones");
        Route::post('/informe/tema/accion/parrafos', [InformeController::class, 'checkparrafos'])->name("informe.checkparrafos");
        Route::get('/informe/tema/acciones/descargalistado', [InformeController::class, 'descargalistado'])->name("informe.descargaacciones");
        Route::get('/informe/getparrafosct', [InformeController::class, 'getparrafosct'])->name("informe.getparrafosct");
        Route::post('/informe/updateordenct', [InformeController::class, 'updateordenct'])->name("informe.updateordenct");

        //Boton datos generales para infromes
        Route::get('/informe/accion/datosgenerales', [InformeController::class, 'getDatosGenerales'])->name('informe.accion.datosgenerales');
        //Funciones para el informe de seguimiento
Route::post('/informes/guardar', [InformeController::class, 'guardarInformeCoordinador']);
Route::post('/informes/get-informe', [InformeController::class, 'getInformeCoordinadorContenido']);
Route::delete('/informes/eliminar-parrafo', [InformeController::class, 'eliminarParrafoInforme'])->name('informes.eliminar-parrafo');



        Route::get('/itar', [ItarController::class, 'index'])->name("itar.index");
        Route::post('/itar/edit', [ItarController::class, 'index'])->name("itar.edit");
        Route::post('/itar/almacena1', [ItarController::class, 'almacena1'])->name("itar.almacena1");
        Route::post('/itar/almacena2', [ItarController::class, 'almacena2'])->name("itar.almacena2");
        Route::post('/itar/almacena3', [ItarController::class, 'almacena3'])->name("itar.almacena3");
        Route::post('/itar/eliminap', [ItarController::class, 'eliminap'])->name("itar.eliminap");
        Route::post('/itar/eliminaregion', [ItarController::class, 'eliminaregion'])->name("itar.eliminaregion");
        Route::post('/itar/eliminabs', [ItarController::class, 'eliminabs'])->name("itar.eliminabs");
        Route::post('/itar/almacena4', [ItarController::class, 'almacena4'])->name("itar.almacena4");
        Route::post('/itar/medios/upload', [ItarController::class, 'medioupload'])->name('itar.medioupload');
        Route::post('/itar/medios/delete', [ItarController::class, 'mediodelete'])->name('itar.mediodelete');
        Route::post('/itar/medios/addlink', [ItarController::class, 'addlink'])->name('itar.medioaddlink');
        Route::post('/itar/medios/deletelink', [ItarController::class, 'deletelink'])->name('itar.deletelink');
        Route::post('/itar/medios/almacena', [ItarController::class, 'almacenamedios'])->name('itar.almacenamedios');
        Route::get('/itar/listado', [ItarController::class, 'listado'])->name("itar.listado");
        Route::get('/itar/download/{id}', [ItarController::class, 'download'])->name('itar.download');

        //Nuevo ITAR
        Route::post('/ia/actualizagenerales', [ItarController::class, 'actualizagenerales'])->name('ia.actualizagenerales');
        Route::get('/ia/getdatosgenerales', [ItarController::class, 'getdatosgenerales'])->name('ia.getdatosgenerales');
        Route::post('/ia/almacenabs', [ItarController::class, 'almacenabs'])->name('ia.almacenabs');
        Route::get('/ia/getbss', [ItarController::class, 'getbss'])->name('ia.getbss');
        Route::get('/ia/getinfobs', [ItarController::class, 'getinfobs'])->name('ia.getinfobs');
        Route::post('/ia/removebs', [ItarController::class, 'removebs'])->name('ia.removebs');
        Route::post('/ia/seguimiento', [ItarController::class, 'seguimiento'])->name('ia.seguimiento');
        Route::post('/ia/reportes', [ItarController::class, 'reportes'])->name('ia.reportes');
        Route::get('/ia/getseguimiento', [ItarController::class, 'getseguimiento'])->name('ia.getseguimiento');
        Route::post('/ia/getseguimiento/addprograma', [ItarController::class, 'addprograma'])->name('ia.addprograma');
        Route::post('/ia/getseguimiento/removeprograma', [ItarController::class, 'removeprograma'])->name('ia.removeprograma');
        Route::post('/ia/seguimiento/programa/addfuente', [ItarController::class, 'addfuente'])->name('ia.addfuente');
        Route::get('/ia/seguimiento/programa/getfuentes', [ItarController::class, 'getfuentes'])->name('ia.getfuentes');
        Route::get('/ia/seguimiento/programa/getinfofuente', [ItarController::class, 'getinfofuente'])->name('ia.getinfofuente');
        Route::post('/ia/seguimiento/programa/removefuente', [ItarController::class, 'removefuente'])->name('ia.removefuente');
        Route::post('/ia/seguimiento/updateseguimiento', [ItarController::class, 'updateseguimiento'])->name('ia.updateseguimiento');
        Route::post('/ia/seguimiento/uploadmedio', [ItarController::class, 'uploadmedio'])->name('ia.uploadmedio');
        Route::get('/ia/seguimiento/getmedios', [ItarController::class, 'getmedios'])->name('ia.getmedios');
        Route::post('/ia/seguimiento/removemedio', [ItarController::class, 'removemedio'])->name('ia.removemedio');
        Route::get('/ia/seguimiento/getobservaciones', [ItarController::class, 'getobservaciones'])->name('ia.getobservaciones');
        Route::get('/ia/seguimiento/getmonitoreo', [ItarController::class, 'getmonitoreo'])->name('ia.getmonitoreo');
        Route::get('/ia/seguimiento/getmonitoreoreporte', [ItarController::class, 'getmonitoreoreporte'])->name('ia.getmonitoreoreporte');   
        Route::post('/monitoreo/estado', [ItarController::class, 'setaplicaBS'])->name('monitoreo.guardarEstado');

        Route::post('/ia/seguimiento/almacenamonitoreo', [ItarController::class, 'almacenamonitoreo'])->name('ia.almacenamonitoreo');
        Route::post('/ia/seguimiento/bs/almacenadesglose', [ItarController::class, 'almacenadesglose'])->name('ia.almacenadesglose');
        Route::get('/ia/seguimiento/bs/getdesglose', [ItarController::class, 'getdesglose'])->name('ia.getdesglose');
        Route::get('/ia/seguimiento/bs/getdesglosemunicipal', [ItarController::class, 'getdesglosemunicipal'])->name('ia.getdesglosemunicipal');
        Route::get('/ia/seguimiento/bs/getdesglosereporte', [ItarController::class, 'getdesglosereporte'])->name('ia.getdesglosereporte');
        Route::post('/ia/seguimiento/munitoreo/uploadmunicipios', [ItarController::class, 'uploadmunicipios'])->name('ia.uploadconcentradomunicipio');
        Route::post('/ia/seguimiento/munitoreo/getprocesamientodesglose', [ItarController::class, 'getprocesamientodesglose'])->name('ia.getprocesamientodesglose');
        Route::post('/ia/seguimiento/munitoreo/removepresupuestobs', [ItarController::class, 'removepresupuestobs'])->name('ia.remuevepresupuestobs');
        Route::get('/ia/seguimiento/munitoreo/descargadesglose', function () {
            return response()->download(public_path('materialapoyo/desglose_municipios.xlsx'));
        })->name('ia.descargaplantilladesglose');
        Route::get('/ia/export', [ItarController::class, 'exportitar'])->name('ia.exportitar');
        Route::get('/ia/getinfoppa', [ItarController::class, 'getinfoppa'])->name('ia.getinfoppa');
        Route::post('/ia/almacenappatemporal', [ItarController::class, 'almacenappatemporal'])->name('ia.almacenappatemporal');
        Route::get('/ia/getsolicitudes', [ItarController::class, 'getsolicitudes'])->name('ia.getsolicitudes');
        Route::get('/ia/admin/solicitudes', [ItarController::class, 'getadminsolicitudes'])->name('ia.admin.getsolicitudes');
        Route::post('/ia/admin/procesasolicitud', [ItarController::class, 'procesasolicitud'])->name('ia.admin.procesasolicitud');
        Route::get('/ia/getseguimientoreporte', [ItarController::class, 'getseguimientoreporte'])->name('ia.getseguimientoreporte');
        Route::get('/ia/listadodetalladoitar', [ItarController::class, 'listadodetalladoitar'])->name('ia.listadodetalladoitar');
        Route::get('/ia/reporte/pdf', [TemporalController::class, 'downloadpdf'])->name('ia.dowloaditarppa');
        Route::get('/ia/itar_reporte_anual', [TemporalController::class, 'verItarReporteAnual'])->name('ia.itaranualreporte');
        Route::get('/ia/itar_trimestral', [TemporalController::class, 'verItarTrimestral'])->name('ia.itartrimestral');
        Route::post('/ia/seguimiento/setaplica', [ItarController::class, 'setaplica'])->name('ia.setaplica');


        //Para usuarios CONSULTA
        Route::get('/ppas/listado', [InformeController::class, 'listadoppas'])->name("ppas.listado");
        Route::get('/informe/accion/getparrafos', [InformeController::class, 'getparrafos'])->name("informe.accion.getparrafos");
        Route::get('/informe/acciones/descarga', [InformeController::class, 'descargaacciones'])->name("informe.descargaallacciones");
        Route::get('/ppas/itar', [ItarController::class, 'listadoppasitar'])->name("ppas.itar");

        Route::post('/admin/indicador/updateeditar', [IndicadorController::class, 'updateeditar'])->name("admin.indicador.updateeditar");
        Route::get('/notificacion/get', [NotificacionesController::class, 'getnotificaciones'])->name("notificacion.get");
        Route::get('/notificacion/info', [NotificacionesController::class, 'info'])->name("notificacion.info");
        Route::get('/notificacion/all', [NotificacionesController::class, 'getallnotificaciones'])->name("notificacion.all");
        Route::get('/notificacion/getusers', [NotificacionesController::class, 'getusers'])->name("notificacion.getusers");
        Route::post('/notificacion/delete', [NotificacionesController::class, 'delete'])->name("notificacion.delete");
        Route::get('/a2030', [InfoController::class, 'a2030'])->name("info.a2030");
        Route::get('/infoods', [InfoController::class, 'infoods'])->name("info.infoods");
        Route::get('/ped', [InfoController::class, 'ped'])->name("info.ped");
        Route::get('/pes', [InfoController::class, 'pes'])->name("info.pes");
        Route::get('/material', function () {
            return view('info.material');
        })->name("info.material");

        Route::get('/herramientaproyeccion', function () {

            return response()->download(public_path('/materialapoyo/estrategias_proyeccion_IE.xlsm'));

        })->name('hproyeccion');

        Route::get('/manual', function () {

            return response()->download(public_path('/materialapoyo/Manual-Modulo-Indicadores.pdf'));

        })->name('manual');

        Route::get('/manualitar', function () {

            return response()->download(public_path('/materialapoyo/Manual-Modulo-itar.pdf'));

        })->name('manualitar');

        Route::get('/video-informe', function () {

            return view("info.video");

        })->name('video');

        Route::get('/presentacioni', function () {

            return response()->download(public_path('/materialapoyo/presentacioni_pes.pdf'));

        })->name('presentacioni');

        Route::get('/presentacionitar', function () {

            return response()->download(public_path('/materialapoyo/presentacion_itar.pdf'));

        })->name('presentacionitar');
        //Material 3er informe
        Route::get('/lineamientosGenerales', function () {
            return response()->download(public_path('/materialapoyo/Material3erInforme/1.Lineamientos Generales para la integración del Informe de Gobierno.2022-2028.pdf'));
        })->name('lineamientosGenerales');
        Route::get('/proceso-3er-informe', function () {
            return response()->download(public_path('/materialapoyo/Material3erInforme/2.Proceso 3er Informe de Gobierno.pdf'));
        })->name('proceso-3er-informe');
        Route::get('/alineación-PED-Informe', function () {
            return response()->download(public_path('/materialapoyo/Material3erInforme/3.Alineación PED-Informe_INPLAN (Conflicto de codificación Unicode).pdf'));
        })->name('alineación-PED-Informe');
        Route::get('/informe-inversion-publica', function () {
            return response()->download(public_path('/materialapoyo/Material3erInforme/4.Informe-inversión pública_DSIP_SEFIN.pdf'));
        })->name('informe-inversion-publica');
    });


    // Reportes generales (PDF, vistas ITAR)

    Route::get('/reporte/pdf', [TemporalController::class, 'downloadpdf']);
    Route::get('/ver-itar-reporte-anual', [TemporalController::class, 'verItarReporteAnual']);
    Route::get('/ver-itar-trimestral', [TemporalController::class, 'verItarTrimestral']);

    // Módulo: Productos Sectoriales
        // Listar productos sectoriales
    Route::get('/productos-sectoriales', [ProductoSectorialController::class, 'listarProductosSectoriales'])
        ->name('productossectoriales.index');
    // Formulario de de captira de datos de producto sectorial
    Route::get('/productos-sectoriales/formulario', [ProductoSectorialController::class, 'mostrarFormularioCaptura'])
        ->name('productossectoriales.formulario');
    // Guardar producto sectorial
    Route::post('/productos-sectoriales', [ProductoSectorialController::class, 'guardarProductoSectorial'])
        ->name('productossectoriales.store');

    Route::get('/productos/{id}/datos-generales', [ProductoSectorialController::class, 'obtenerDatosGenerales']);

    // Seguimiento
    Route::get('/productos/seguimiento/{idProducto}', [ProductoSectorialController::class, 'mostrarFormularioSeguimiento'])
        ->name('productos.seguimiento');
    Route::get('/productos/{idProducto}/seguimiento-todos', [ProductoSectorialController::class, 'obtenerDatosSeguimientoTodos']);
    Route::post('/productos/guardar-seguimiento', [ProductoSectorialController::class, 'guardarSeguimientoProductosSectoriales'])
        ->name('productos.guardarSeguimiento');
    Route::post('/productos/seguimiento/primera-vez', [ProductoSectorialController::class, 'guardarSeguimientoPrimeraVez'])
        ->name('productos.guardarSeguimientoPrimeraVez');
    // Lineas de Accion,Bienes, PPA y Programas
    Route::delete('/productos/{producto}/eliminar-linea-accion/{lineaAccion}', [ProductoSectorialController::class, 'eliminarLineaAccion'])
    ->name('productos.eliminarLineaAccion');
    Route::delete('/productos/{productoId}/eliminar-bien/{bienId}', [ProductoSectorialController::class, 'eliminarBien']);
    Route::delete('/productos/{productoId}/eliminar-ppa/{ppaId}', [ProductoSectorialController::class, 'eliminarPPA']);
    Route::delete('/productos/{idProducto}/programa/{idPrograma}/{anio}', [ProductoSectorialController::class, 'eliminarProgramaProducto'])
        ->name('productos.eliminarProgramaProducto');
    // Medios de Verificación
    Route::post('/productos/medios/subir', [ProductoSectorialController::class, 'subirMedioVerificacion'])
        ->name('productos.subirMedio');
    Route::get('/productos/{idProducto}/medios/{anio}', [ProductoSectorialController::class, 'getMediosVerificacion']);
    Route::delete('/productos/medios/eliminar/{idMedio}', [ProductoSectorialController::class, 'eliminarMedio']);
    Route::put('/productos/medios/actualizar-descripcion/{idMedio}', [ProductoSectorialController::class, 'actualizarDescripcionMedio'])
        ->name('productos.medios.actualizarDescripcion');
    // Observaciones
    Route::get('/productos/{idProducto}/observacion', [ProductoSectorialController::class, 'obtenerObservacion'])
        ->name('productos.obtenerObservacion');
    // Reportes por producto
    Route::get('/productos/{idProducto}/detalle-reporte', [ProductoSectorialController::class, 'detalleReporteProducto'])
        ->name('productos.detalleReporte');
    Route::get('/producto/reporte/{id}', [ProductoSectorialController::class, 'verReportePS'])
        ->name('producto.reporte');
    // Envío a revisión
    Route::post('/productos/enviar-revision', [ProductoSectorialController::class, 'enviarRevision'])
        ->name('productos.enviarRevision');
    // Rutas del Administrador
    Route::get('/admin-ps', [ProductoSectorialController::class, 'listarProductosAdministrador'])
        ->name('productossectoriales.admin');
    Route::put('/productossectoriales/{id}/estatus', [ProductoSectorialController::class, 'cambiarEstatus'])
        ->name('productossectoriales.cambiarEstatus');
    Route::get('/productos-sectoriales/detalle-excel', [ProductoSectorialController::class, 'detalleExelPS'])
        ->name('productossectoriales.detalleExelPS');
    Route::put('/productos/{id}/asignar-responsable', [ProductoSectorialController::class, 'asignarResponsable']);
    Route::post('/productos/habilitar-anios', [ProductoSectorialController::class, 'habilitarAnios'])
    ->name('productos.habilitarAnios');
    Route::get('/productos/{idProducto}/anios-habilitados', [ProductoSectorialController::class, 'obtenerAniosHabilitados']);
    Route::get('/productossectoriales/guardado-status/{idProducto}', [ProductoSectorialController::class, 'getGuardadoStatus']);
    Route::post('/productossectoriales/habilitar-guardado', [ProductoSectorialController::class, 'habilitarGuardado'])->name('productossectoriales.habilitarGuardado');


});


require __DIR__ . '/auth.php';
