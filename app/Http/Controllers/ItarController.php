<?php

namespace App\Http\Controllers;

use App\Models\Dependencia;
use App\Models\EjePED;
use App\Models\Indicador;
use App\Models\Itar;
use App\Models\ItarMedio;
use App\Models\ItarPresupuesto;
use App\Models\ItarRegion;
use App\Models\Poblacion;
use App\Models\ProgramasPresupuestales;
use App\Models\Region;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItarController extends Controller
{
    public function index(Request $request)
    {
        $dependencias = Dependencia::all();
        $ejes = EjePED::all();
        $indicadores = Indicador::where("status", 1)->get();
        $programas = ProgramasPresupuestales::all();
        $poblacion = Poblacion::all();
        $regiones = Region::all();
        if(isset($request->idITAR)){
            dd("Se modificará");
        }
        return view("itar.index")->with("dependencias", $dependencias)->with("ejes", $ejes)->with("indicadores", $indicadores)->with("programas", $programas)->with("poblacion", $poblacion)->with("regiones", $regiones);
    }

    public function almacena1(Request $request)
    {

        try {
            DB::beginTransaction();

            $periodo_reporte = $request->mesinicio . "-" . $request->mesfinal . " " . $request->anio;
            if ($request->idITAR == "") {
                $itar = Itar::create([
                    "periodo_reporte" => $periodo_reporte,
                    "tipo" => $request->tipo,
                    "reglas" => $request->reglas,
                    //reglas: reglas,
                    "nombre" => $request->nombre,
                    "objetivo" => $request->objetivo,
                    "descripcion" => $request->descripcion,
                    "cobertura" => $request->cobertura,
                    "periodicidad" => $request->periodicidad,
                    "anio_inicio" => $request->anio_inicio,
                    "idEjePED" => $request->idEjePED,
                    "idTemaPED" => $request->idTemaPED,
                    "idObjetivoPED" => $request->idObjetivoPED,
                    "idEstrategiaPED" => $request->idEstrategiaPED,
                    "idLAPED" => $request->idLAPED,
                    "transversales" => $request->transversales,
                    "idIndicador" => $request->idIndicador,
                    //"idITAR"=> $request->idITAR,
                    "idDependencia" => $request->idDependencia,
                    "ejercicio" => $request->anio,
                    "idUser" => auth()->user()->id
                ]);

                //Actualizamos el Folio del PPA
                $folio = "DITE-ITAR-";
                for ($x = 1; $x <= (5 - strlen($itar->id . "")); $x++) {
                    $folio .= "0";
                }
                $folio .= $itar->id;
                Itar::where("id", $itar->id)->update([
                    "folio" => $folio
                ]);

                $itar_ppa = Itar::where("id", $itar->id)->first();
            } else {
                //Actualizamos la información ya que el PPA ya fue almacenado Previamente
                Itar::where("id", $request->idITAR)->update([
                    "periodo_reporte" => $periodo_reporte,
                    "tipo" => $request->tipo,
                    "reglas" => $request->reglas,
                    //reglas: reglas,
                    "nombre" => $request->nombre,
                    "objetivo" => $request->objetivo,
                    "descripcion" => $request->descripcion,
                    "cobertura" => $request->cobertura,
                    "periodicidad" => $request->periodicidad,
                    "anio_inicio" => $request->anio_inicio,
                    "idEjePED" => $request->idEjePED,
                    "idTemaPED" => $request->idTemaPED,
                    "idObjetivoPED" => $request->idObjetivoPED,
                    "idEstrategiaPED" => $request->idEstrategiaPED,
                    "idLAPED" => $request->idLAPED,
                    "transversales" => $request->transversales,
                    "idIndicador" => $request->idIndicador,
                    //"idITAR"=> $request->idITAR,
                    "ejercicio" => $request->anio,
                ]);
                $itar_ppa = Itar::where("id", $request->idITAR)->first();
            }
            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "PPA almacenado correctamente!",
                "itar" => $itar_ppa->toArray()
            ]);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "ocurrio un erro al almacenar los datos Generald del PPA!" . $ex
            ]);
        }
    }

    public function almacena2(Request $request)
    {
        //procedemos a realizar el analisis de las cadenas de presupuesto;
        $nuevos = array();
        $presupuestos = $request->presupuestos;
        $presupuestos_array = explode("&", $presupuestos);

        array_pop($presupuestos_array);
        try {
            DB::beginTransaction();

            foreach ($presupuestos_array as $presupuesto) {
                $campos = explode("|", $presupuesto);
                array_pop($campos);

                if ($campos[0] == "") {
                    //dd( "'".$campos[1]."'");
                    $presupuesto_n =  ItarPresupuesto::create([
                        "idITAR" => $request->idITAR,
                        "ejercicio" => $campos[1],
                        "idPrograma" => $campos[2],

                        "f1m" => $campos[3] == "" ? null : $campos[3],
                        "f2m" => $campos[4] == "" ? null : $campos[4],
                        "f3m" => $campos[5] == "" ? null : $campos[5],
                        "f4m" => $campos[6] == "" ? null : $campos[6],

                        "e1m" => $campos[7] == "" ? null : $campos[7],
                        "e2m" => $campos[8] == "" ? null : $campos[8],
                        "e3m" => $campos[9] == "" ? null : $campos[9],
                        "e4m" => $campos[10] == "" ? null : $campos[10],

                        "m1m" => $campos[11] == "" ? null : $campos[11],
                        "m2m" => $campos[12] == "" ? null : $campos[12],
                        "m3m" => $campos[13] == "" ? null : $campos[13],
                        "m4m" => $campos[14] == "" ? null : $campos[14],

                        "f1e" => $campos[15] == "" ? null : $campos[15],
                        "f2e" => $campos[16] == "" ? null : $campos[16],
                        "f3e" => $campos[17] == "" ? null : $campos[17],
                        "f4e" => $campos[18] == "" ? null : $campos[18],

                        "e1e" => $campos[19] == "" ? null : $campos[19],
                        "e2e" => $campos[20] == "" ? null : $campos[20],
                        "e3e" => $campos[21] == "" ? null : $campos[21],
                        "e4e" => $campos[22] == "" ? null : $campos[22],

                        "m1e" => $campos[23] == "" ? null : $campos[23],
                        "m2e" => $campos[24] == "" ? null : $campos[24],
                        "m3e" => $campos[25] == "" ? null : $campos[25],
                        "m4e" => $campos[26] == "" ? null : $campos[26],

                        "fecha_corte" => $campos[27] == "" ? null : $campos[27],
                    ]);
                    array_push($nuevos, $presupuesto_n->id);
                } else {
                    ItarPresupuesto::where("id", $campos[0])->update([
                        "idITAR" => $request->idITAR,
                        "ejercicio" => $campos[1],
                        "idPrograma" => $campos[2],

                        "f1m" => $campos[3] == "" ? null : $campos[3],
                        "f2m" => $campos[4] == "" ? null : $campos[4],
                        "f3m" => $campos[5] == "" ? null : $campos[5],
                        "f4m" => $campos[6] == "" ? null : $campos[6],

                        "e1m" => $campos[7] == "" ? null : $campos[7],
                        "e2m" => $campos[8] == "" ? null : $campos[8],
                        "e3m" => $campos[9] == "" ? null : $campos[9],
                        "e4m" => $campos[10] == "" ? null : $campos[10],

                        "m1m" => $campos[11] == "" ? null : $campos[11],
                        "m2m" => $campos[12] == "" ? null : $campos[12],
                        "m3m" => $campos[13] == "" ? null : $campos[13],
                        "m4m" => $campos[14] == "" ? null : $campos[14],

                        "f1e" => $campos[15] == "" ? null : $campos[15],
                        "f2e" => $campos[16] == "" ? null : $campos[16],
                        "f3e" => $campos[17] == "" ? null : $campos[17],
                        "f4e" => $campos[18] == "" ? null : $campos[18],

                        "e1e" => $campos[19] == "" ? null : $campos[19],
                        "e2e" => $campos[20] == "" ? null : $campos[20],
                        "e3e" => $campos[21] == "" ? null : $campos[21],
                        "e4e" => $campos[22] == "" ? null : $campos[22],

                        "m1e" => $campos[23] == "" ? null : $campos[23],
                        "m2e" => $campos[24] == "" ? null : $campos[24],
                        "m3e" => $campos[25] == "" ? null : $campos[25],
                        "m4e" => $campos[26] == "" ? null : $campos[26],

                        "fecha_corte" => $campos[27] == "" ? null : $campos[27],
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "Información de Presupuesto almacenada satisfactoriamente!",
                "nuevos" => $nuevos
            ]);
        } catch (Exception $ex) {
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al almacenar la información del presupuesto!" . $ex
            ]);
            DB::rollback();
        }
    }

    public function almacena3(Request $request){
         //procedemos a realizar el analisis de las cadenas de presupuesto;
         $nuevos = array();
         $regiones = $request->regiones;
         $regiones_array = explode("&", $regiones);
         array_pop($regiones_array);
         try{
            DB::beginTransaction();
            //actualizamos la información del registro del ITAR
            Itar::where("id",$request->idITAR)->update([
                "descripcion_bs" => $request->descripcion_bs,
                "unidad_bs" => $request->unidad_bs,
                "bs1p" => $request->bs1p,
                "bs1r" => $request->bs1r,
                "bs2p" => $request->bs2p,
                "bs2r" => $request->bs2r,
                "bs3p" => $request->bs3p,
                "bs3r" => $request->bs3r,
                "bs4p" => $request->bs4p,
                "bs4r" => $request->bs4r,
                "idPoblacion" => $request->idPoblacion,
                "descripcion_pb" => $request->descripcion_pb,
                "po" => $request->po,
                "po_m" => $request->po_m,
                "po_h" => $request->po_h,
                "pb1_t" => $request->pb1_t,
                "pb1_m" => $request->pb1_m,
                "pb1_h" => $request->pb1_h,
                "pb2_t" => $request->pb2_t,
                "pb2_m" => $request->pb2_m,
                "pb2_h" => $request->pb2_h,
                "pb3_t" => $request->pb3_t,
                "pb3_m" => $request->pb3_m,
                "pb3_h" => $request->pb3_h,
                "pb4_t" => $request->pb4_t,
                "pb4_m" => $request->pb4_m,
                "pb4_h" => $request->pb4_h
            ]);

            //procedemos a almacenar la informacion de la atención a las regiones
            if(count($regiones_array)>0){
                foreach($regiones_array as $region){
                    $campos = explode("|",$region);
                    array_pop($campos);
                    if($campos[0]==""){
                        $ItarRegion = ItarRegion::create([
                            "idITAR" => $request->idITAR,
                            "idRegion" => $campos[1],
                            "tpm" => $campos[2],
                            "tph" => $campos[3],
                            "tp" => $campos[4],
                            "num_mun" => $campos[5]
                        ]);
                        array_push($nuevos,$ItarRegion->id);
                    }else{
                        ItarRegion::where("id",$campos[0])->update([
                            "idITAR" => $request->idITAR,
                            "idRegion" => $campos[1],
                            "tpm" => $campos[2],
                            "tph" => $campos[3],
                            "tp" => $campos[4],
                            "num_mun" => $campos[5]
                        ]);

                    }
                }

            }
            DB::commit();
            return response()->json([
                "result" =>"ok",
                "message" => "Información de Atención almacenada satisfactoriamente!",
                "nuevos" => $nuevos
            ]);
         }catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al almcacenar la información de atención".$ex
            ]);
         }



    }

    public function eliminap(Request $request)
    {
        try {
            DB::beginTransaction();
            ItarPresupuesto::where("id", $request->idPresupuesto)->delete();
            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "Registro de Presupuesto Eliminado Satisfactoriamente!"
            ]);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al intentar eliminar el registro de presupuesto!"
            ]);
        }
    }

    public function eliminaregion(Request $request)
    {
        try {
            DB::beginTransaction();
            ItarRegion::where("id", $request->idITARRegion)->delete();
            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "Registro de Region atendida Eliminado Satisfactoriamente!"
            ]);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al intentar eliminar el registro de región atendida!"
            ]);
        }
    }

    public function almacena4(Request $request){
        try{
            DB::beginTransaction();
            Itar::where("id",$request->idITAR)->update([
                "im_s" => $request->im_s,
                "im_e" => $request->im_e,
                "im_a" => $request->im_a,
                "p_o" => $request->p_o,
                "r_s" => $request->r_s,
                "b_d" => $request->b_d,
                "a_t" => $request->a_t,
                "a_p" => $request->a_p,
                "otro" => $request->otro,
            ]);

            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "Información de difusión e impacto almacenada correctamente!"
            ]);
        }catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al almacenar la información de difusión e impacto!".$ex
            ]);
        }

    }

    public function medioupload(Request $req)
    {
        try {
            $medio = $req->file('file');
            //dd($medio->getClientOriginalName());
            $extension = $medio->extension();
            $random = time() . rand(1, 100);
            $nombreMedio =  $random . '.' . $medio->extension();
            $carpeta = 'medios/itar/' . $req->idITARm;
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            $medio->move(public_path('medios/itar/' . $req->idITARm . "/"), $nombreMedio);
            DB::beginTransaction();
            $mediog = new ItarMedio();
            $mediog->idITAR = $req->idITARm;
            $mediog->tipo = "archivo";
            $mediog->ubicacion = $nombreMedio;
            $mediog->nombre = $medio->getClientOriginalName();
            $mediog->save();
            DB::commit();
            return response()->json([
                'result' => 'ok',
                'message' => 'Medio cargado Satisfactoriamente!',
                'filename' => $nombreMedio,
                'medio_id' => $mediog->id
            ],200);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                'result' => 'error',
                'message' => 'Ocurrió un error al cargar el medio!' . $ex,
            ],500);
        }
    }

    public function mediodelete(Request $request){
            $infoMedio = ItarMedio::find($request->medio_id);
            $file = public_path('medios/itar/') . $request->idITARm . "/" . $infoMedio->ubicacion;
            try {
                if (file_exists($file)) {
                    if (unlink($file)) {
                        $infoMedio->delete();
                    }
                }
                return response()->json([
                    'result' => 'ok',
                    'message' => 'Medio eliminado satisfactoriamente!',
                ]);
            } catch (Exception $ex) {
                return response()->json([
                    'result' => 'error',
                    'message' => 'Ocurrió un error al eliminar el medio!',
                ]);
            }
    }
    public function addlink(Request $request){
        try{
            DB::beginTransaction();
            DB::commit();
            $link = ItarMedio::create([
                "idITAR" => $request->idITAR,
                "tipo" => "link",
                "nombre" => $request->link,
                "descripcion" => $request->descripcion_link
            ]);
            return response()->json([
                "result" => "ok",
                "message" => "Link agregado satisfactoriamente!",
                "medio_id" => $link->id
            ]);
        }catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al agregar el link!"
            ]);

        }
    }

    public function deletelink(Request $request){
        $medio = ItarMedio::find($request->medio_id);
        try{
            $medio->delete();
            return response()->json([
                "result" => "ok",
                "message" => "Link eliminado satisfactoriamente!",
            ]);
        }catch(Exception $ex){
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al eliminar el link!"
            ]);
        }

    }

    public function almacenamedios(Request $request){
        $medios = $request->medios;
        $descripciones = $request->descripciones;
        try{
            if($medios != ""){
                $array_medios = explode("|",$medios);
                array_pop($array_medios);
                $array_descripciones = explode("|",$descripciones);
                array_pop($array_descripciones);
                $contador = 0;
                foreach($array_medios as $medio){
                    ItarMedio::where("id",$medio)->update([
                        "descripcion" => $array_descripciones[$contador]
                    ]);
                    $contador++;
                }
            }
            return response()->json([
                "result" => "ok",
                "message" => "Información almacenada satisfactoriamente!"
            ]);
        }catch(Exception $ex){
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al tratar de almacenar los medios!".$ex
            ]);
        }

    }

    public function listado(){
        $ppas = Itar::where("idDependencia",auth()->user()->enlace->idDependencia)->get();
        return view("itar.listado")->with("ppas",$ppas);
    }
}
