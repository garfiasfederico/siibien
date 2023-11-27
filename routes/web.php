<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DependenciaController;
use App\Http\Controllers\EnlaceController;
use App\Http\Controllers\IndicadorController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\MediosVerificacionController;
use App\Http\Controllers\NotificacionesController;
use App\Http\Controllers\PEDController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\VariableController;
use App\Http\Controllers\PPAController;
use App\Http\Controllers\TemporalController;
use App\Http\Controllers\TitularController;
use App\Models\Dependencia;
use App\Models\Indicador;

use Illuminate\Support\Facades\Route;

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
});

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
    $dependencias = Dependencia::all();
    return view("temporal.registroasistencia")->with('dependencias',$dependencias);
})->name('registro');

Route::get('/descarga', function () {    
    return view("temporal.descarga");
})->name('descarga');

Route::get('/encuesta', function () {    
    return view("temporal.encuesta");
})->name('encuesta');

Route::get('/encuestaresultados', function () {    
    return view("temporal.encuestaresultados");
})->name('encuestaresultados');


Route::post('/almacenaregistro',[TemporalController::class, 'registraasistencia'])->name('registraasistencia');
Route::get('/descargaasistencias',[TemporalController::class, 'downloadasistencias'])->name('descargaasistencias');

Route::post('/registraencuesta',[TemporalController::class, 'registraencuesta'])->name('registraencuesta');
Route::get('/resultadosencuesta',[TemporalController::class, 'downloadresultadosencuesta'])->name('encuestaresultados');



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
        Route::get('/indicador/info', [IndicadorController::class, 'info'])->name('indicador.info');
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
        Route::get('/indicador/historicos', [IndicadorController::class, 'gethistoricos'])->name('indicador.valores.gethistoricos');
        Route::post('/indicador/valores/delete', [IndicadorController::class, 'deletevalorhistorico'])->name('indicador.valoreshistoricos.delete');

        Route::post('/indicador/valores/programado', [IndicadorController::class, 'addprogramado'])->name('indicador.valores.addprogramado');
        Route::get('/indicador/valores/programados', [IndicadorController::class, 'getprogramados'])->name('indicador.valores.programados');
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
        Route::get('/indicador/reportes', [IndicadorController::class, 'reportes'])->name('indicador.reportes');
    });

        Route::get('/perfil', [PerfilController::class, 'edit'])->name('perfil.edit');
        Route::post('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
        Route::post('/perfil/changepassword', [PerfilController::class, 'changepassword'])->name('perfil.changepassword');
        Route::get('/perfil/responsiva', [PerfilController::class, 'responsiva'])->name('perfil.responsiva');
        Route::post('/perfil/responsivap', [PerfilController::class, 'responsiva'])->name('perfil.responsivap');

        Route::get('/ppa', [PPAController::class, 'index'])->name('ppa.index');

       

        Route::get('/gettemas', [PEDController::class, 'gettemas'])->name('gettemas');
        Route::get('/getobjetivos', [PEDController::class, 'getobjetivos'])->name('getobjetivos');
        Route::get('/getestrategias', [PEDController::class, 'getestrategias'])->name('getestrategias');
        Route::get('/getlineas', [PEDController::class, 'getlineas'])->name('getlineas');
        Route::get('/getprogramas', [PEDController::class, 'getprogramas'])->name('getprogramas');

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

            
        });
        Route::post('/admin/indicador/updateeditar', [IndicadorController::class, 'updateeditar'])->name("admin.indicador.updateeditar");
        Route::get('/notificacion/get', [NotificacionesController::class, 'getnotificaciones'])->name("notificacion.get");
        Route::get('/notificacion/info', [NotificacionesController::class, 'info'])->name("notificacion.info");
        Route::get('/notificacion/all', [NotificacionesController::class, 'getallnotificaciones'])->name("notificacion.all");
        Route::get('/notificacion/getusers', [NotificacionesController::class, 'getusers'])->name("notificacion.getusers");
        Route::post('/notificacion/delete', [NotificacionesController::class, 'delete'])->name("notificacion.delete");
        Route::get('/a2030', [InfoController::class, 'a2030'])->name("info.a2030");
        Route::get('/infoods', [InfoController::class, 'infoods'])->name("info.infoods");
        Route::get('/ped', [InfoController::class, 'ped'])->name("info.ped");
        Route::get('/material', function () {
            return view('info.material');
        })->name("info.material");

        Route::get('/herramientaproyeccion', function () {
    
            return response()->download(public_path('/materialapoyo/estrategias_proyeccion_IE.xlsm'));
        
        })->name('hproyeccion');
        
    });
});



require __DIR__ . '/auth.php';
