<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Itar;
use App\Models\EjePED;
use App\Models\Region;
use App\Models\TemaPED;
use App\Models\LineaPED;
use App\Models\Indicador;
use App\Models\ItarMedio;
use App\Models\Poblacion;
use App\Models\ItarRegion;
use App\Models\Dependencia;
use App\Models\ObjetivoPED;
use Illuminate\Http\Request;
use App\Models\EstrategiaPED;
use App\Http\Utils\ReportePDF;
use App\Models\FuenteFinanciamiento;
use App\Models\IAAlineacion;
use App\Models\IABS;
use App\Models\IABSArea;
use App\Models\IABSEntrega;
use App\Models\IABSPoblacion;
use App\Models\IABSPresupuesto;
use App\Models\IABSOrigenInfo;
use App\Models\IAPresupuestoTrimestral;
use Illuminate\Support\Collection; 
use App\Models\IABSRegion;
use App\Models\IAFuente;
use App\Models\IAMedio;
use App\Models\IAObservacion;
use App\Models\IAPoblacion;
use App\Models\IAPoblacionAnual;
use App\Models\IAPresupuestoGeneral;
use App\Models\IAPresupuestoTipoG;
use App\Models\InformeAccion;
use App\Models\ItarBS;
use App\Models\ItarPresupuesto;
use App\Models\Municipio;
use App\Models\ProgramaPresupuestario;
use Illuminate\Support\Facades\DB;
use App\Models\ProgramasPresupuestales;
use App\Models\Sector;
use Excel;
use App\Exports\ItarExport;
use App\Mail\TestEmail;
use App\Models\InformeAccionTemporal;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Models\Titular;
use App\Exports\IADetalladoExport;
use App\Models\IABSMunicipio;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;

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

        if (isset($request->idITAR)) {
            $infoItar = Itar::where("id", $request->idITAR)->first();
            $itarPresupuestos = ItarPresupuesto::where("idITAR", $request->idITAR)->get();
            $itarRegiones = ItarRegion::where("idITAR", $request->idITAR)->get();
            $itarMedios = ItarMedio::where("idITAR", $request->idITAR)->where("tipo", "archivo")->get();
            $itarLinks = ItarMedio::where("idITAR", $request->idITAR)->where("tipo", "link")->get();
            $itarBS = ItarBS::where("idItar", $request->idITAR)->get();

            return view("itar.index")->with("dependencias", $dependencias)->with("ejes", $ejes)->with("indicadores", $indicadores)->with("programas", $programas)->with("poblacion", $poblacion)->with("regiones", $regiones)
                ->with("itar", $infoItar)
                ->with("itarRegiones", $itarRegiones)
                ->with("itarPresupuestos", $itarPresupuestos)
                ->with("itarMedios", $itarMedios)
                ->with("itarLinks", $itarLinks)
                ->with("itarBS", $itarBS);
        }
        return view("itar.index")->with("dependencias", $dependencias)->with("ejes", $ejes)->with("indicadores", $indicadores)->with("programas", $programas)->with("poblacion", $poblacion)->with("regiones", $regiones);
    }

    public function almacena1(Request $request)
    {

        try {
            DB::beginTransaction();

            $periodo_reporte = $request->mesinicio . "-" . $request->mesfinal . "-" . $request->anio;
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
                    "tipologia_gasto" => $request->tipologia,
                    "idUser" => auth()->user()->id
                ]);

                $dependencia = Dependencia::where("idDependencia",$request->idDependencia)->first();
                //Actualizamos el Folio del PPA
                $folio = "DITE-ITAR-".$dependencia->dependenciaSiglas."-";
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
                    "tipologia_gasto" => $request->tipologia,
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

    public function almacena3(Request $request)
    {
        //procedemos a realizar el analisis de las cadenas de presupuesto;
        $nuevos = array();
        $nuevos_bienes = array();
        $regiones = $request->regiones;
        $regiones_array = explode("&", $regiones);
        array_pop($regiones_array);
        try {
            DB::beginTransaction();
            //actualizamos la información del registro del ITAR
            Itar::where("id", $request->idITAR)->update([
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
                "pb4_h" => $request->pb4_h,
                "o_a" => $request->o_a,
                "o_e" => $request->o_e,
                "p_acumulada" => $request->p_acumulada=="true"?1:0

            ]);

            //almacenamos los bienes o servicios agregados
            $bss = $request->bss;
            $bss_array = explode("&", $bss);
            array_pop($bss_array);
            if (count($bss_array) > 0) {
                foreach ($bss_array as $bs) {
                    $campos = explode("|", $bs);
                    if ($campos[0] == "") {
                        $nuevobs = ItarBS::create([
                            "descripcion_bs" => $campos[1],
                            "unidad_bs" => $campos[2],
                            "bs1p" => $campos[3],
                            "bs1r" => $campos[4],
                            "bs2p" => $campos[5],
                            "bs2r" => $campos[6],
                            "bs3p" => $campos[7],
                            "bs3r" => $campos[8],
                            "bs4p" => $campos[9],
                            "bs4r" => $campos[10],
                            "idItar" => $request->idITAR
                        ]);
                        array_push($nuevos_bienes,$nuevobs->id);
                    } else {
                        ItarBS::where("id",$campos[0])->update([
                            "descripcion_bs" => $campos[1],
                            "unidad_bs" => $campos[2],
                            "bs1p" => $campos[3],
                            "bs1r" => $campos[4],
                            "bs2p" => $campos[5],
                            "bs2r" => $campos[6],
                            "bs3p" => $campos[7],
                            "bs3r" => $campos[8],
                            "bs4p" => $campos[9],
                            "bs4r" => $campos[10],
                            "idItar" => $request->idITAR
                        ]);
                    }
                }
            }

            //procedemos a almacenar la informacion de la atención a las regiones
            if (count($regiones_array) > 0) {
                foreach ($regiones_array as $region) {
                    $campos = explode("|", $region);
                    array_pop($campos);
                    if ($campos[0] == "") {
                        $ItarRegion = ItarRegion::create([
                            "idITAR" => $request->idITAR,
                            "idRegion" => $campos[1],
                            "tpm" => $campos[2],
                            "tph" => $campos[3],
                            "tp" => $campos[4],
                            "num_mun" => $campos[5]
                        ]);
                        array_push($nuevos, $ItarRegion->id);
                    } else {
                        ItarRegion::where("id", $campos[0])->update([
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
                "result" => "ok",
                "message" => "Información de Atención almacenada satisfactoriamente!",
                "nuevos" => $nuevos,
                "nuevos_bienes" => $nuevos_bienes
            ]);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al almcacenar la información de atención" . $ex
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

    public function almacena4(Request $request)
    {
        try {
            DB::beginTransaction();
            Itar::where("id", $request->idITAR)->update([
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
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al almacenar la información de difusión e impacto!" . $ex
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
            ], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                'result' => 'error',
                'message' => 'Ocurrió un error al cargar el medio!' . $ex,
            ], 500);
        }
    }

    public function mediodelete(Request $request)
    {
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
    public function addlink(Request $request)
    {
        try {
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
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al agregar el link!"
            ]);
        }
    }

    public function deletelink(Request $request)
    {
        $medio = ItarMedio::find($request->medio_id);
        try {
            $medio->delete();
            return response()->json([
                "result" => "ok",
                "message" => "Link eliminado satisfactoriamente!",
            ]);
        } catch (Exception $ex) {
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al eliminar el link!"
            ]);
        }
    }

    public function almacenamedios(Request $request)
    {
        $medios = $request->medios;
        $descripciones = $request->descripciones;
        try {
            if ($medios != "") {
                $array_medios = explode("|", $medios);
                array_pop($array_medios);
                $array_descripciones = explode("|", $descripciones);
                array_pop($array_descripciones);
                $contador = 0;
                foreach ($array_medios as $medio) {
                    ItarMedio::where("id", $medio)->update([
                        "descripcion" => $array_descripciones[$contador]
                    ]);
                    $contador++;
                }
            }
            return response()->json([
                "result" => "ok",
                "message" => "Información almacenada satisfactoriamente!"
            ]);
        } catch (Exception $ex) {
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al tratar de almacenar los medios!" . $ex
            ]);
        }
    }

    public function listado()
    {
        //$ppas = Itar::where("idDependencia", auth()->user()->enlace->idDependencia)->get();
        $ppas = InformeAccion::where("informe_acciones.idDependencia",auth()->user()->enlace->idDependencia)
                ->join("dependencia","dependencia.idDependencia","informe_acciones.idDependencia")
                ->where("itar_seg",1)
                ->get();
        $ejes = EjePED::all();
        return view("itar.listado")->with("ppas", $ppas)->with("ejes",$ejes);
    }

    public function download($id)
    {
        ReportePDF::setHeaderCallback(function ($pdf) {
            $image_file = public_path("images/siibien_colores.png");
            $pdf->Image($image_file, 150, 6, 50, '', 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
            $image_file = public_path("images/logo_gabinete.png");
            //$pdf->Image($image_file, 10, 5, 50, '', 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
            $pdf->SetFont('helvetica', 'B', 11);
            //$pdf->SetFont('montserratsemib');

            $pdf->SetY(10);
            $pdf->SetX(15);
            $pdf->SetFontSize(10);
            $pdf->setTextColor(104, 27, 46);
            $pdf->Cell(0, 20, 'INFORME TRIMESTRAL DE AVANCES Y RESULTADOS (ITAR)', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->SetY(18);
            $pdf->SetX(15);
            $pdf->SetFontSize(11);
            //$pdf->Cell(10, 15, 'Reporte de Seguimiento Trimestral (ITAR)', 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->SetDrawColor(104, 27, 46);
            //$pdf->Line(15, 23, 200, 23);
            $pdf->SetLineStyle(array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(104, 27, 46)));
            $pdf->Line(15, 15, 120, 15);
        });


        ReportePDF::setFooterCallback(function ($pdf) {
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->SetX(0);
            $pdf->SetY(-15);
            $pdf->SetFontSize(8);
            $pdf->Cell(10, 15, 'Fecha de Impresión: ' . date("Y-m-d H:i:s"), 0, false, 'L', 0, '', 0, false, 'M', 'M');
            $pdf->SetY(-15);
            $pdf->Cell(200, 15, 'Página: ' . $pdf->getAliasNumPage() . "/" . $pdf->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'M', 'M');
        });

        // ReportePDF::SetHeaderData("images/header_line.png", 25, "Reporte de Indicadores Estratégicos", "NINGUNO");
        ReportePDF::SetTitle('Reporte ITAR - Secretaría de Finanzas');
        ReportePDF::SetMargins(10, 23, 10);
        //ReportePDF::SetHeaderMargin(25);
        ReportePDF::AddPage();
        ReportePDF::SetFontSize(10);


        //Información del Indicador
        $infoPPA = ITAR::select("itar.*","itar_poblacion.id as idPoblacion")->where("itar.id",$id)->join("itar_poblacion","itar_poblacion.id","=","itar.idPoblacion")->first();
        $dependencia = Dependencia::where("idDependencia", $infoPPA->idDependencia)->first();

        $periodo = $infoPPA->periodo_reporte;


        $ejeped = EjePED::where("idEjePED", $infoPPA->idEjePED)->first();;
        $temaped = TemaPED::where("idTemaPED", $infoPPA->idTemaPED)->first();
        $objetivoped = ObjetivoPED::where("idObjetivoPED", $infoPPA->idObjetivoPED)->first();
        $estrategiaped = EstrategiaPED::where("idEstrategiaPED", $infoPPA->idEstrategiaPED)->first();
        $lineaped = LineaPED::where("idLAPED", $infoPPA->idLAPED)->first();

        $itarPresupuestos = ItarPresupuesto::where("idITAR", $infoPPA->id)
                            ->join("programaspresupuestales","programaspresupuestales.idPrograma","=","itar_presupuestos.idPrograma")
                            ->get();

        $itarRegiones = ItarRegion::where("idITAR", $infoPPA->id)
                                    ->join("regiones","regiones.id","=","itar_regiones.idRegion")
                                    ->get();
        $itarMedios = ItarMedio::where("idITAR", $infoPPA->id)->get();
        //$itarLinks = ItarMedio::where("idITAR", $infoPPA->id)->where("tipo", "link")->get();

        $indicador = Indicador::where("idIndicador",$infoPPA->idIndicador)->first();

        //Variables del Indicador
        $itarBS = ItarBS::where("idItar",$infoPPA->id)->get();

        //Titular
        $titular = DB::table("titulares")->where("idDependencia", $infoPPA->idDependencia)->first();

        //Enlace
        $enlace = DB::table("enlacedependencia")->where("idEnlaceDependencia", auth()->user()->idEnlaceDependencia)->first();

        $html = \View::make("itar.download")->with("ppa", $infoPPA)
            ->with("titular", $titular)
            ->with("enlace", $enlace)
            ->with('periodo', $periodo)
            ->with('ejeped', $ejeped)
            ->with('temaped', $temaped)
            ->with('estrategiaped', $estrategiaped)
            ->with('objetivoped', $objetivoped)
            ->with('presupuestos', $itarPresupuestos)
            ->with('regiones', $itarRegiones)
            ->with('medios', $itarMedios)
            //->with('links', $itarLinks)
            ->with('lineaped', $lineaped)
            ->with('dependencia', $dependencia)
            ->with('indicador', $indicador)
            ->with('itarbs',$itarBS);

        //die($html);

        ReportePDF::writeHTML($html, true, false, true, false, '');

        ReportePDF::Output(public_path('ppa' . $id . '.pdf'), 'I');
        //return response()->download(public_path('indicador'.$indicador.'.pdf'));
    }

    public function indexadmin(){
        $ppas = InformeAccion::select("id","nombre","descripcion", "objetivo","dependencia.dependenciaSiglas","informe_acciones.p_entrega","prioritario",DB::raw("count(ia_bs.idBS) as bienes_servicios"),"informe_acciones.estado as estadoPPA","vigente")
                                ->join("dependencia","dependencia.idDependencia","=","informe_acciones.idDependencia")->orderBy("id")
                                ->leftjoin("ia_bs","ia_bs.ia_id","=","informe_acciones.id")
                                ->groupBy("informe_acciones.id","informe_acciones.nombre","informe_acciones.descripcion","informe_acciones.objetivo","dependencia.dependenciaSiglas","informe_acciones.p_entrega","informe_acciones.estado","informe_acciones.prioritario","vigente")
                                ->get();

        return view("itar.listadoadmin")->with("ppas", $ppas);
    }

    function uptestado(Request $request){

        try{
            //Itar::where("id",$request->idITAR)->first()->update([
              //  "estado" => $request->estado
            //]);
            InformeAccion::where("id",$request->idPPA)->first()->update([
                "estado" => $request->estado
            ]);
            return response()->json([
                "result" => "ok",
                "message" => "El estatus fue actualizado correctamente"
            ]);
        }catch(Exception $ex){
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al actualizar el estatus"
            ]);
        }
    }


    function eliminabs(Request $request){
        try {
            DB::beginTransaction();
            ItarBS::where("id", $request->idBS)->delete();
            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "Registro de Bien o servicio entregado Eliminado Satisfactoriamente!"
            ]);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al intentar eliminar el registro del bien o servicio!"
            ]);
        }
    }
    //Nuevo Itar
    function actualizagenerales(Request $request){
        try{
            DB::beginTransaction();
            InformeAccion::where("id",$request->idPPA)->update([
                "tipo" => $request->tipo,
                "objetivo" => $request->objetivo,
                "descripcion" => $request->descripcion,
                "cobertura" => $request->cobertura,
                //"p_entrega" => $request->p_entrega,
                //"p_otro" => $request->p_otro,
                "anio_inicio" => $request->anio_inicio,                
                "r_o" => $request->reglas,                
                "link_r_o" => $request->link_ro                                
            ]);
            
            // Almacenamos la información de alineación
            //verificamos si existe el registro de alineación
            $alineacion = IAAlineacion::where("ia_id",$request->idPPA)->first();
            if($alineacion == null){
                IAAlineacion::create([
                    "ia_id" => $request->idPPA,
                    "idEjePED" => $request->idEjePED,
                    "idTemaPED" => $request->idTemaPED,
                    "idObjetivoPED" => $request->idObjetivoPED,
                    "lineas" => $request->lineas,
                    "ejes_trans" => $request->transversales,
                    "idSector" => $request->idSector,
                    "idObjetivoSector" => $request->idObjetivoSector,
                    "idEstrategiaSector" => $request->idEstrategiaSector,
                    //"idProductoSector" => $request->idProductoSector,
                    "i_estrategicos" => $request->indicadores,

                ]);
            }else{
                IAAlineacion::where("ia_id",$request->idPPA)->update([                    
                    "idEjePED" => $request->idEjePED,
                    "idTemaPED" => $request->idTemaPED,
                    "idObjetivoPED" => $request->idObjetivoPED,
                    "lineas" => $request->lineas,
                    "ejes_trans" => $request->transversales,
                    "idSector" => $request->idSector,
                    "idObjetivoSector" => $request->idObjetivoSector,
                    "idEstrategiaSector" => $request->idEstrategiaSector,
                    //"idProductoSector" => $request->idProductoSector,
                    "i_estrategicos" => $request->indicadores,
                ]);
            }
            //Almacenamos registros de población
            $iaPoblacion = IAPoblacion::where("ia_id",$request->idPPA)->first();
            if($iaPoblacion == null){
                IAPoblacion::create([
                    "tipo" => $request->tipo_p,
                    "tipo_poblacion_id" => $request->tipo_poblacion_id,
                    "tipo_poblacion_otro" => $request->tipo_poblacion_otro,
                    "descripcion_poblacion" => $request->descripcion_poblacion,
                    "nombre_enfoque"=> $request->nombre_enfoque,
                    "descripcion_area"=> $request->descripcion_area,
                    "ia_id" => $request->idPPA
                ]);
            }else{
                IAPoblacion::where("ia_id",$request->idPPA)->update([
                    "tipo" => $request->tipo_p,
                    "tipo_poblacion_id" => $request->tipo_poblacion_id,
                    "tipo_poblacion_otro" => $request->tipo_poblacion_otro,
                    "descripcion_poblacion" => $request->descripcion_poblacion,
                    "nombre_enfoque"=> $request->nombre_enfoque,
                    "descripcion_area"=> $request->descripcion_area,
                    "ia_id" => $request->idPPA
                ]);
            }

            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "Datos actualizados satisfactoriamente"
            ],200);
        }catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al intentar actualizar los Datos"
            ],200);
        }   
    }
    
    function getdatosgenerales(Request $request){
        $ppa = InformeAccion::where("id",$request->idPPA)->first();
        $ejes = EjePED::all();
        $alineaciones = IAAlineacion::where("ia_id",$request->idPPA)->first();
        $sectores = Sector::all();
        $indicadores = Indicador::where("en_revision","<>",2)->get();          
        $poblacion = Poblacion::all();
        $infoPoblacion = IAPoblacion::where("ia_id",$request->idPPA)->first();
        return view("ia.info")->with("ppa",$ppa)->with("ejes",$ejes)->with("alineaciones",$alineaciones)->with("sectores",$sectores)->with("indicadores",$indicadores)->with("poblacion",$poblacion)->with("infoPoblacion",$infoPoblacion);
    }

    function almacenabs (Request $request){
        $idBS = $request->idBS;
        try{
            DB::beginTransaction();
            if($idBS==""){
                //creamos el nuevo Bien o servicio
                IABS::create([
                    "nombreBS" => $request->nombreBS,                
                    "descripcionBS" => $request->descripcionBS,
                    "p_entrega" => $request->p_entrega,
                    "p_otro" => $request->p_otro,
                    "unidad_medidaBS" => $request->unidad_medidaBS,
                    "ia_id" => $request->ia_id,
                ]);

            }else{
                IABS::where("idBS",$request->idBS)->update([
                    "nombreBS" => $request->nombreBS,                
                    "descripcionBS" => $request->descripcionBS,
                    "p_entrega" => $request->p_entrega,
                    "p_otro" => $request->p_otro,
                    "unidad_medidaBS" => $request->unidad_medidaBS,
                    "ia_id" => $request->ia_id,
                ]);
            }
            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "El bien o servicio fue almacenado satisfactoriamente!"
            ]);
        }catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al tratar de almacenar el bien o servicio, intente más tarde"
            ]);
        }
    }

    function getbss(Request $request){
        if($request->ia_id != ""){
            $bss = IABS::where("ia_id",$request->ia_id)->get();
            return view("ia.getbss")->with("bss",$bss);
        }        
    }

    function getinfobs(Request $request){
        $infobs = IABS::where("idBS",$request->idBS)->first();
        return response()->json([
            "result" => "ok",
            "bs" => $infobs
        ]);
    }

    function removebs(Request $request){
        try{
            IABS::where("idBS",$request->idBS)->update(["status"=>0]);
            return response()->json([
                "result" => "ok",
                "message" => "Se ha eliminado satisfactoriamente el registro!"
            ]);
        }catch(Exception $ex){
            return response()->json([
                "result" => "error",
                "message" => "Ha ocurrido un error al intentar eliminar el registro!"
            ]);
        }
        
    }

    function seguimiento(Request $request){
        $infoPPA = InformeAccion::where("id",$request->idPPA)->first();
        $fuentes = FuenteFinanciamiento::all();  
        return view("ia.seguimiento")->with("infoPPA",$infoPPA)->with("fuentes",$fuentes);
    }

    public function getseguimiento(Request $request)
    {
        $infoPresupuesto = IAPresupuestoGeneral::where("ia_id", $request->idPPA)
            ->where("anio", $request->anio)
            ->first();

        if (!$infoPresupuesto) {
            $infoPresupuesto = IAPresupuestoGeneral::create([
                "ia_id" => $request->idPPA,
                "anio" => $request->anio
            ]);
        }

        $registros = IAPresupuestoTipoG::where(
            "ia_presupuesto_general_id",
            $infoPresupuesto->id
        )->get();

        foreach ($registros->whereNotNull('pp_id')->groupBy('pp_id') as $pp_id => $items) {

            if (!$pp_id) {
                continue;
            }

            if (!$items->where('tipo_gasto', 'operativo')->first()) {
                IAPresupuestoTipoG::create([
                    'ia_presupuesto_general_id' => $infoPresupuesto->id,
                    'tipo_gasto' => 'operativo',
                    'pp_id' => (int) $pp_id,
                    'aplica' => 0
                ]);
            }

            if (!$items->where('tipo_gasto', 'inversion')->first()) {
                IAPresupuestoTipoG::create([
                    'ia_presupuesto_general_id' => $infoPresupuesto->id,
                    'tipo_gasto' => 'inversion',
                    'pp_id' => (int) $pp_id,
                    'aplica' => 0
                ]);
            }
        }
        


        $programasAgrupados = IAPresupuestoTipoG::where(
            "ia_presupuesto_general_id",
            $infoPresupuesto->id
        )->get()->groupBy('pp_id');

        $programas = ProgramaPresupuestario::where(
            "anio",
            $request->anio
        )->get();

        $poblacion = IAPoblacion::where("ia_id", $request->idPPA)
            ->leftJoin("itar_poblacion", "itar_poblacion.id", "=", "tipo_poblacion_id")
            ->first();

        $infoP = null;

        if ($poblacion) {
            $infoP = IAPoblacionAnual::where(
                "idPoblacion",
                $poblacion->idPoblacion
            )->where(
                    "anio",
                    $request->anio
                )->first();
        }

        $bss = IABS::where("ia_id", $request->idPPA)->get();
        

        return view("ia.infoseguimiento", [
            "infoPresupuesto" => $infoPresupuesto,
            "programasAgrupados" => $programasAgrupados,
            "programas" => $programas,
            "poblacion" => $poblacion,
            "infoP" => $infoP,
            "bss" => $bss
        ]);
    }

    public function addprograma(Request $request)
    {
        DB::beginTransaction();

        try {
            $operativo = IAPresupuestoTipoG::create([
                'ia_presupuesto_general_id' => $request->ia_presupuesto_general_id,
                'tipo_gasto' => 'operativo',
                'pp_id' => null
            ]);

            $inversion = IAPresupuestoTipoG::create([
                'ia_presupuesto_general_id' => $request->ia_presupuesto_general_id,
                'tipo_gasto' => 'inversion',
                'pp_id' => null
            ]);

            $infoPresupuesto = IAPresupuestoGeneral::findOrFail(
                $request->ia_presupuesto_general_id
            );

            $programas = ProgramaPresupuestario::where(
                'anio',
                $request->anio
            )->get();

            DB::commit();

            return view('ia.infoprograma', [
                'operativo' => $operativo,
                'inversion' => $inversion,
                'programas' => $programas,
                'infoPresupuesto' => $infoPresupuesto
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true], 500);
        }
    }
    public function savePrograma(Request $request)
    {
        $request->validate([
            'operativo_id' => 'required|exists:ia_presupuesto_tipog,id',
            'inversion_id' => 'required|exists:ia_presupuesto_tipog,id',
            'pp_id' => 'required|exists:programa_presupuestario,idPrograma',
        ]);

        $iaPresupuestoGeneralId = IAPresupuestoTipoG::whereIn(
            'id',
            [$request->operativo_id, $request->inversion_id]
        )->value('ia_presupuesto_general_id');

        $existe = IAPresupuestoTipoG::where('pp_id', $request->pp_id)
            ->where('ia_presupuesto_general_id', $iaPresupuestoGeneralId)
            ->whereNotIn('id', [$request->operativo_id, $request->inversion_id])
            ->exists();

        if ($existe) {
            return response()->json([
                'error' => true,
                'type' => 'duplicado'
            ], 422);
        }

        DB::beginTransaction();

        try {
            IAPresupuestoTipoG::whereIn('id', [
                $request->operativo_id,
                $request->inversion_id
            ])->update([
                        'pp_id' => $request->pp_id
                    ]);

            DB::commit();

            return response()->json(['ok' => true]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => true], 500);
        }
    }
    function removeprograma(Request $request)
    {
        try {
            DB::beginTransaction();
            IAPresupuestoTipoG::whereIn('id', [
                $request->operativo_id,
                $request->inversion_id
            ])->delete();

            DB::commit();

            return response()->json([
                "result" => "ok",
                "message" => "El registro del programa presupuestario ha sido eliminado satisfactoriamente!"
            ], 200);

        } catch (Exception $ex) {
            DB::rollBack();

            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al intentar eliminar el registro de programa asociado."
            ], 200);
        }
    }
    public function updateTipoGastoBasico(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:ia_presupuesto_tipog,id',
            'estatus' => 'nullable|in:0,1,2',
            'aplica' => 'nullable|in:0,1'
        ]);

        DB::beginTransaction();

        try {
            $data = [];

            if ($request->has('estatus')) {
                $data['estatus'] = (int) $request->estatus;

                if ((int) $request->estatus !== 2) {
                    $data['monto'] = null;
                }
            }

            if ($request->has('aplica')) {
                $data['aplica'] = (int) $request->aplica;
            }

            if (!empty($data)) {
                IAPresupuestoTipoG::where('id', $request->id)->update($data);
            }

            DB::commit();
            return response()->json(['result' => 'ok']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['result' => 'error'], 500);
        }
    }

    function addfuente(Request $request){
        $ia_presupuesto_tipog_id = $request->ia_presupuesto_tipog_id;
        $ia_fuente_id = $request->ia_fuente_id;        
        $fuente_id = $request->fuente_id;
        $f_otra = $request->f_otra;
        $monto_federal = $request->monto_federal;
        $monto_estatal = $request->monto_estatal;
        $monto_municipal = $request->monto_municipal;
        $monto_total = $request->monto_total;
        try{
            DB::beginTransaction();
            if($ia_fuente_id==""){
                IAFuente::create([
                    "fuente_id" => $fuente_id,
                    "monto_total" => $monto_total,
                    "monto_federal" => $monto_federal,
                    "monto_estatal" => $monto_estatal,
                    "monto_municipal" => $monto_municipal,
                    "ia_presupuesto_tipog_id" => $ia_presupuesto_tipog_id,
                    "f_otra" => $f_otra
                ]);
            }else{
                IAFuente::where("id",$ia_fuente_id)->update([
                    "fuente_id" => $fuente_id,
                    "monto_total" => $monto_total,
                    "monto_federal" => $monto_federal,
                    "monto_estatal" => $monto_estatal,
                    "monto_municipal" => $monto_municipal,
                    "ia_presupuesto_tipog_id" => $ia_presupuesto_tipog_id,
                    "f_otra" => $f_otra
                ]);
            }
            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "La fuente se ha registrado satisfactoriamente"
            ]);
        }catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al registrar la fuente".$ex
            ]);
        }
        
    }

    function getfuentes(Request $request){
        $fuentes = IAFuente::where("ia_presupuesto_tipog_id",$request->ia_presupuesto_tipog_id)
                    ->join("fuente_financiamiento","fuente_financiamiento.idFuente","=","fuente_id")
                    ->get();
        return view("ia.fuentes")->with("fuentes",$fuentes);
    }

    function getinfofuente(Request $request){
        $infoFuente = IAFuente::where("id",$request->ia_fuente_id)->first();
        $fuentes = FuenteFinanciamiento::all();
        return view("ia.getinfofuente")->with("infoFuente",$infoFuente)->with("fuentes",$fuentes);
    }

    function removefuente(Request $request){
        try{
            DB::beginTransaction();
            IAFuente::where("id",$request->ia_fuente_id)->delete();
            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "El registro de la fuente ha sido eliminado satisfactoriamente!"
            ],200);

        }catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al intentar eliminar el registro de la fuente"
            ],200);
        }
    }

    function updateseguimiento(Request $request){
        try{
            DB::beginTransaction();
            //procesamos los datos de los programas y componenetes asociados al presupuesto global
            $presupuestos = $request->presupuestos;
            $presupuestos_array = explode("&",$presupuestos);
            if(count($presupuestos_array)>0){
                array_pop($presupuestos_array);
                foreach($presupuestos_array as $pre){
                    $datos = explode("|",$pre);
                    IAPresupuestoTipoG::where("id",$datos[0])->update([
                        "pp_id" => $datos[1],
                        "componente" => $datos[2]
                    ]);
                }
            }
            //Actualizamos información de la población o área de enfoque a atender
            $pob = IAPoblacionAnual::where("idPoblacion",$request->idPoblacion)->where("anio",$request->anio)->first();
            if($pob == null){
                IAPoblacionAnual::create([
                    "idPoblacion" => $request->idPoblacion,
                    "anio" => $request->anio,
                    "mujeres" => $request->mujeres,
                    "hombres" => $request->hombres,
                    "total" => $request->total,                    
                    "impacto_esperado" => $request->impacto,                    
                    "descripcion_impacto" => $request->descripcion_impacto,
                    "total_area" => $request->total_area, 
                ]);
            }else{
                IAPoblacionAnual::where("idPoblacion",$request->idPoblacion)->where("anio",$request->anio)->update([
                    "idPoblacion" => $request->idPoblacion,
                    "anio" => $request->anio,
                    "mujeres" => $request->mujeres,
                    "hombres" => $request->hombres,
                    "total" => $request->total,                    
                    "impacto_esperado" => $request->impacto,                    
                    "descripcion_impacto" => $request->descripcion_impacto,
                    "total_area" => $request->total_area,
                ]);
            }

            //Procesamos las descripciones de los medios cargados
            if($request->medios !=""){
                $medios = explode("&",$request->medios);
                array_pop($medios);
                foreach($medios as $medio){
                    $datos = explode("|",$medio);
                    IAMedio::where("idMedio",$datos[0])->update([
                        "descripcion" => $datos[1]
                    ]);
                }
            }

            //Procesamos las observaciones
            if($request->observaciones !=""){
                $ob = explode("|",$request->observaciones);
                if($ob[0]==""){
                    IAObservacion::create([
                        "ia_id" => $request->idPPA,
                        "anio" => $request->anio,
                        "trimestre" => $request->trimestre_obs,
                        "observaciones" => $ob[1]
                    ]);
                }else{
                    IAObservacion::where("idObservacion",$ob[0])->update([
                        "ia_id" => $request->idPPA,
                        "anio" => $request->anio,
                        "trimestre" => $request->trimestre_obs,
                        "observaciones" => $ob[1]
                    ]);
                }
            }
            if ($request->filled('montos')) {
                $items = explode('&', rtrim($request->montos, '&'));

                foreach ($items as $item) {
                    [$id, $monto] = explode('|', $item);

                    IAPresupuestoTipoG::where('id', $id)->update([
                        'monto' => $monto
                    ]);
                }
            }

            
            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "Los datos de seguimiento se han actualizado satisfactoriamente."
            ],200);
            
        }catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un detalle al actualizar los datos de seguimiento.".$ex
            ]);
        
        }

    }

    public function uploadmedio(Request $req)
    {
        try {
            $medio = $req->file('file');
            //dd($medio->getClientOriginalName());
            $extension = $medio->extension();
            $random = time() . rand(1, 100);
            $nombreMedio =  $random . '.' . $medio->extension();
       
            $carpeta = 'medios/itar/' . $req->idPPA_M. "/".$req->anio_M."/".$req->trim_M;
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            $medio->move(public_path('medios/itar/' . $req->idPPA_M . "/".$req->anio_M."/".$req->trim_M."/"), $nombreMedio);
            DB::beginTransaction();
            $mediog = new IAMedio();
            $mediog->ia_id = $req->idPPA_M;
            $mediog->nombre = $medio->getClientOriginalName();
            $mediog->archivo = $nombreMedio;
            $mediog->anio = $req->anio_M;
            $mediog->trimestre = $req->trim_M;
            $mediog->save();
            DB::commit();
            return response()->json([
                'success' => 'ok',
                'message' => 'Medio cargado Satisfactoriamente!',
                'filename' => $nombreMedio,
                'anio' => $mediog->anio,
                'idPPA' => $mediog->ia_id,
                'trimestre' => $mediog->trimestre,
                'extension' => $extension,
            ]);                      
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                'success' => 'error',
                'message' => 'Ocurrió un error al cargar el medio!' . $ex,
            ]);
        }
    }

    public function getmedios(Request $request){
        $medios = IAMedio::where("ia_id",$request->idPPA)->where("anio",$request->anio,)->where("trimestre",$request->trimestre)->get();
        return view("ia.getmedios")->with("medios",$medios);
    }

    public function removemedio(Request $request){
        try{
            DB::beginTransaction();
            //procedemos a borrar el medio de manera lógica en la carpeta de medios
            $infoMedio = IAMedio::where("idMedio",$request->idMedio)->first();            
            
            if(file_exists("medios/itar/".$infoMedio->ia_id."/".$infoMedio->anio."/".$infoMedio->trimestre."/".$infoMedio->archivo)){
            
                unlink("medios/itar/".$infoMedio->ia_id."/".$infoMedio->anio."/".$infoMedio->trimestre."/".$infoMedio->archivo);
            }
            IAMedio::where("idMedio",$request->idMedio)->delete();
            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "El medio de verificación ha sido eliminado satisfactoriamente!"
            ],200);

        }catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al intentar eliminar el medio de verificación."
            ],200);
        }
    }
    
    public function getobservaciones(Request $request){
        $observaciones = IAObservacion::where("ia_id",$request->idPPA)->where("anio",$request->anio,)->where("trimestre",$request->trimestre)->first();
        return view("ia.getobservaciones")->with("observaciones",$observaciones);
    }

    public function getmonitoreo(Request $request){
        $infobs = IABS::where("idBS",$request->idBS)->first();
        $estado = \DB::table('ia_bs_estado')->where('idBs', $request->idBS) ->where('anio', $request->anio)->value('aplica')?? 1; 

        $poblacion = IAPoblacion::where("ia_id",$request->idPPA)->first();
        $entregas = IABSEntrega::where("idBS",$request->idBS)->where("anio",$request->anio)->first();
        $poblacionmeta = IABSPoblacion::where("idBS",$request->idBS)->where("anio",$request->anio)->first();
        $areameta = IABSArea::where("idBS",$request->idBS)->where("anio",$request->anio)->first();
        // $operativos = IABSPresupuesto::where("idBS",$request->idBS)->where("ia_bs_presupuesto.anio",$request->anio)->where("tipo","o")
        //              ->join("programa_presupuestario","programa_presupuestario.idPrograma","=","ia_bs_presupuesto.idPrograma")->get();
        // $inversiones = IABSPresupuesto::where("idBS",$request->idBS)->where("ia_bs_presupuesto.anio",$request->anio)->where("tipo","i")
        //              ->join("programa_presupuestario","programa_presupuestario.idPrograma","=","ia_bs_presupuesto.idPrograma")->get();
        $origenInfo = IABSOrigenInfo::where('idBS', $request->idBS)->where('anio', $request->anio)->first();
        $presupuestoGeneral = IAPresupuestoGeneral::where('ia_id', $request->idPPA)->where('anio', $request->anio)->first();

        $programasSeguimiento = collect();

        if ($presupuestoGeneral) {

            $programasSeguimiento = IAPresupuestoTipoG::where(
                    'ia_presupuesto_general_id',
                    $presupuestoGeneral->id
                )
                ->whereNotNull('pp_id')
                ->whereIn('pp_id', function ($q) use ($request) {
                    $q->select('programa_presupuestario_id')
                    ->from('ia_presupuesto_trimestral')
                    ->where('idBS', $request->idBS)
                    ->where('anio', $request->anio);
                })
                ->join(
                    'programa_presupuestario',
                    'programa_presupuestario.idPrograma',
                    '=',
                    'ia_presupuesto_tipog.pp_id'
                )
                ->get()
                ->groupBy('pp_id');
        }


        $programasSeguimiento = $this->cargarPresupuestoTrimestral($request->idBS,$request->anio,$programasSeguimiento);
        $programasDisponibles = collect();

        if ($presupuestoGeneral) {

            $programasDisponibles = IAPresupuestoTipoG::where(
                    'ia_presupuesto_general_id',
                    $presupuestoGeneral->id
                )
                ->whereNotNull('pp_id')
                ->whereNotIn('pp_id', $programasSeguimiento->keys())
                ->join(
                    'programa_presupuestario',
                    'programa_presupuestario.idPrograma',
                    '=',
                    'ia_presupuesto_tipog.pp_id'
                )
                ->select('programa_presupuestario.*')
                ->distinct()
                ->get();
        }




        return view("ia.infomonitoreo")->with("infoBS",$infobs)->with("poblacion",$poblacion)->with("entregas",$entregas)->with("poblacionmeta",$poblacionmeta)->with("areameta",$areameta)->with("estado",$estado)->with("origenInfo",$origenInfo)->with("programasSeguimiento", $programasSeguimiento)->with("programasDisponibles",$programasDisponibles);
    }

    public function getmonitoreoreporte(Request $request){
        $infobs = IABS::where("idBS",$request->idBS)->first();
        $poblacion = IAPoblacion::where("ia_id",$request->idPPA)->first();
        $entregas = IABSEntrega::where("idBS",$request->idBS)->where("anio",$request->anio)->first();
        $poblacionmeta = IABSPoblacion::where("idBS",$request->idBS)->where("anio",$request->anio)->first();    
        $areameta = IABSArea::where("idBS",$request->idBS)->where("anio",$request->anio)->first();
        // $operativos = IABSPresupuesto::where("idBS",$request->idBS)->where("ia_bs_presupuesto.anio",$request->anio)->where("tipo","o")
        //              ->join("programa_presupuestario","programa_presupuestario.idPrograma","=","ia_bs_presupuesto.idPrograma")->get();
        // $inversiones = IABSPresupuesto::where("idBS",$request->idBS)->where("ia_bs_presupuesto.anio",$request->anio)->where("tipo","i")
        //              ->join("programa_presupuestario","programa_presupuestario.idPrograma","=","ia_bs_presupuesto.idPrograma")->get();
        $presupuestoGeneral = IAPresupuestoGeneral::where('ia_id', $request->idPPA)->where('anio', $request->anio)->first();

        $programasSeguimiento = collect();

        if ($presupuestoGeneral) {

            $programasSeguimiento = IAPresupuestoTipoG::where(
                    'ia_presupuesto_general_id',
                    $presupuestoGeneral->id
                )
                ->whereNotNull('pp_id')
                ->whereIn('pp_id', function ($q) use ($request) {
                    $q->select('programa_presupuestario_id')
                    ->from('ia_presupuesto_trimestral')
                    ->where('idBS', $request->idBS)
                    ->where('anio', $request->anio);
                })
                ->join(
                    'programa_presupuestario',
                    'programa_presupuestario.idPrograma',
                    '=',
                    'ia_presupuesto_tipog.pp_id'
                )
                ->get()
                ->groupBy('pp_id');
        }
        $origenInfo = IABSOrigenInfo::where('idBS', $request->idBS)->where('anio', $request->anio)->first();

        $programasSeguimiento = $this->cargarPresupuestoTrimestral(
            $request->idBS,
            $request->anio,
            $programasSeguimiento
        );

        foreach ($programasSeguimiento as $ppId => $registros) {

        foreach ($registros as $registro) {

            if ((int)$request->anio === 2026 && $registro->idComponente) {

                $componente = DB::table('componente_presupuestario')
                    ->where('idComponente', $registro->idComponente)
                    ->selectRaw("CONCAT(claveComponente,' ',descripcionComponente) as nombre")
                    ->first();

                $registro->componente_nombre = $componente->nombre ?? null;

            } else {

                $registro->componente_nombre = $registro->componente_texto ?? null;
            }

            if ((int)$request->anio === 2026 && isset($registro->actividades)) {

                $registro->actividades_nombres = $registro->actividades
                    ->map(function ($a) {
                        return trim(($a->claveActividad ?? '') . ' ' . ($a->descripcionActividad ?? ''));
                    });

            } else {

                $registro->actividades_nombres = collect([
                    $registro->actividad_texto
                ])->filter();
            }
        }
    }
       $estadoDesglose = DB::table('ia_bs_estado')->where('idBs', $request->idBS)->where('anio', $request->anio)->select('app_dm', 'app_dr', 'just_dm', 'just_dr')->first();
        
        return view("ia.infomonitoreoreporte")->with("infoBS",$infobs)->with("poblacion",$poblacion)->with("entregas",$entregas)->with("poblacionmeta",$poblacionmeta)->with("areameta",$areameta)->with("programasSeguimiento", $programasSeguimiento)->with("origenInfo",$origenInfo)->with("estadoDesglose", $estadoDesglose);;
    }

    public function almacenamonitoreo(Request $request){
        $infoMonitoreo = IABSEntrega::where("idBS",$request->idBS)->where("anio",$request->anio)->first();
        $infoPoblacion = IABSPoblacion::where("idBS",$request->idBS)->where("anio",$request->anio)->first();
        $infoArea = IABSArea::where("idBS",$request->idBS)->where("anio",$request->anio)->first();
        try{
                DB::beginTransaction();
                //insertamos o actualizamos información de las entregas
                if($infoMonitoreo!=null){
                    IABSEntrega::where("idBS",$request->idBS)->where("anio",$request->anio)->update([
                        "p1" => $request->p1,
                        "p2" => $request->p2,
                        "p3" => $request->p3,
                        "p4" => $request->p4,
                        "r1" => $request->r1,
                        "r2" => $request->r2,
                        "r3" => $request->r3,
                        "r4" => $request->r4,
                    ]);
        
                }else{
                    IABSEntrega::create([
                        "idBS" => $request->idBS,
                        "p1" => $request->p1,
                        "p2" => $request->p2,
                        "p3" => $request->p3,
                        "p4" => $request->p4,
                        "r1" => $request->r1,
                        "r2" => $request->r2,
                        "r3" => $request->r3,
                        "r4" => $request->r4,
                        "anio" => $request->anio
                    ]);        
                }

                //insertamos o actualizamos información de la población beneficiada
                if($request->selectp == "false"){
                    IABSPoblacion::where("idBS",$request->idBS)->where("anio",$request->anio)->delete();
                }else{
                    if($infoPoblacion!=null){
                        IABSPoblacion::where("idBS",$request->idBS)->where("anio",$request->anio)->update([                        
                            "ph1" => $request->ph1,
                            "ah1" => $request->ah1,
                            "ph2" => $request->ph2,
                            "ah2" => $request->ah2,
                            "ph3" => $request->ph3,
                            "ah3" => $request->ah3,
                            "ph4" => $request->ph4,
                            "ah4" => $request->ah4,
                            "pm1" => $request->pm1,
                            "am1" => $request->am1,
                            "pm2" => $request->pm2,
                            "am2" => $request->am2,
                            "pm3" => $request->pm3,
                            "am3" => $request->am3,
                            "pm4" => $request->pm4,
                            "am4" => $request->am4,
                            "anio" => $request->anio
                        ]);
                    }else{
                        IABSPoblacion::create([
                            "idBS" => $request->idBS,
                            "ph1" => $request->ph1,
                            "ah1" => $request->ah1,
                            "ph2" => $request->ph2,
                            "ah2" => $request->ah2,
                            "ph3" => $request->ph3,
                            "ah3" => $request->ah3,
                            "ph4" => $request->ph4,
                            "ah4" => $request->ah4,
                            "pm1" => $request->pm1,
                            "am1" => $request->am1,
                            "pm2" => $request->pm2,
                            "am2" => $request->am2,
                            "pm3" => $request->pm3,
                            "am3" => $request->am3,
                            "pm4" => $request->pm4,
                            "am4" => $request->am4,
                            "anio" => $request->anio
                        ]);
                    }
                }

                //Insertamos o actualizamos información del área de enfoque atendida
                if($request->selecta == "false"){
                    IABSArea::where("idBS",$request->idBS)->where("anio",$request->anio)->delete();
                }else{
                    if($infoArea!=null){
                        IABSArea::where("idBS",$request->idBS)->where("anio",$request->anio)->update([
                            "arp1" => $request->arp1,
                            "ara1" => $request->ara1,
                            "arp2" => $request->arp2,
                            "ara2" => $request->ara2,
                            "arp3" => $request->arp3,
                            "ara3" => $request->ara3,
                            "arp4" => $request->arp4,
                            "ara4" => $request->ara4,
                        ]);
                    }else{
                        IABSArea::create([
                            "idBS" => $request->idBS,
                            "arp1" => $request->arp1,
                            "ara1" => $request->ara1,
                            "arp2" => $request->arp2,
                            "ara2" => $request->ara2,
                            "arp3" => $request->arp3,
                            "ara3" => $request->ara3,
                            "arp4" => $request->arp4,
                            "ara4" => $request->ara4,
                            "anio" => $request->anio
                        ]); 

                    }
                }

                //Procesamos los registros del presupuesto
                if($request->operativo !=""){                    
                    $presupuesto_operativo = explode("&",$request->operativo);
                    array_pop($presupuesto_operativo);
                    foreach($presupuesto_operativo as $po){
                            $po_array =  explode("|",$po);
                            $presupuesto_o = IABSPresupuesto::where("idBS",$request->idBS)->where("anio",$request->anio)->where("tipo","o")->where("idPrograma",$po_array[0])->first();
                            if($presupuesto_o!=null){                        
                                IABSPresupuesto::where("idBS",$request->idBS)->where("anio",$request->anio)->where("tipo","o")->where("idPrograma",$po_array[0])->update([                                    
                                    "componente" => $po_array[1],
                                    "m1" => $po_array[2]==""?null:$po_array[2],
                                    "m2" => $po_array[3]==""?null:$po_array[3],
                                    "m3" => $po_array[4]==""?null:$po_array[4],
                                    "m4" => $po_array[5]==""?null:$po_array[5],
                                    "e1" => $po_array[6]==""?null:$po_array[6],
                                    "e2" => $po_array[7]==""?null:$po_array[7],
                                    "e3" => $po_array[8]==""?null:$po_array[8],
                                    "e4" => $po_array[9]==""?null:$po_array[9],
                                ]);
                            }else{
                                IABSPresupuesto::create([
                                    "idBS" => $request->idBS,
                                    "anio" => $request->anio,
                                    "tipo" => "o",
                                    "idPrograma" => $po_array[0],
                                    "componente" => $po_array[1],
                                    "m1" => $po_array[2]==""?null:$po_array[2],
                                    "m2" => $po_array[3]==""?null:$po_array[3],
                                    "m3" => $po_array[4]==""?null:$po_array[4],
                                    "m4" => $po_array[5]==""?null:$po_array[5],
                                    "e1" => $po_array[6]==""?null:$po_array[6],
                                    "e2" => $po_array[7]==""?null:$po_array[7],
                                    "e3" => $po_array[8]==""?null:$po_array[8],
                                    "e4" => $po_array[9]==""?null:$po_array[9],
                                ]);
                            }
                        }
                    }

                    

                if($request->inversion != ""){                    
                    $presupuesto_inversion = explode("&",$request->inversion);
                    array_pop($presupuesto_inversion);
                    foreach($presupuesto_inversion as $pi){
                        $pi_array = explode ("|",$pi);
                        $presupuesto_i = IABSPresupuesto::where("idBS",$request->idBS)->where("anio",$request->anio)->where("tipo","i")->where("idPrograma",$pi_array[0])->first();
                        if($presupuesto_i != null){
                            IABSPresupuesto::where("idBS",$request->idBS)->where("anio",$request->anio)->where("tipo","i")->where("idPrograma",$pi_array[0])->update([
                                "componente" => $pi_array[1],
                                "m1" => $pi_array[2]==""?null:$pi_array[2],
                                "m2" => $pi_array[3]==""?null:$pi_array[3],
                                "m3" => $pi_array[4]==""?null:$pi_array[4],
                                "m4" => $pi_array[5]==""?null:$pi_array[5],
                                "e1" => $pi_array[6]==""?null:$pi_array[6],
                                "e2" => $pi_array[7]==""?null:$pi_array[7],
                                "e3" => $pi_array[8]==""?null:$pi_array[8],
                                "e4" => $pi_array[9]==""?null:$pi_array[9],
                            ]);
                        }else{
                            IABSPresupuesto::create([
                                "idBS" => $request->idBS,
                                "anio" => $request->anio,
                                "tipo" => "i",
                                "idPrograma" => $pi_array[0],
                                "componente" => $pi_array[1],
                                "m1" => $pi_array[2]==""?null:$pi_array[2],
                                "m2" => $pi_array[3]==""?null:$pi_array[3],
                                "m3" => $pi_array[4]==""?null:$pi_array[4],
                                "m4" => $pi_array[5]==""?null:$pi_array[5],
                                "e1" => $pi_array[6]==""?null:$pi_array[6],
                                "e2" => $pi_array[7]==""?null:$pi_array[7],
                                "e3" => $pi_array[8]==""?null:$pi_array[8],
                                "e4" => $pi_array[9]==""?null:$pi_array[9],
                            ]);
                        }

                    }
                }
                
                DB::commit();
                return response()->json([
                    "result" => "ok",
                    "message" => "Monitoreo almacenado satisfactoriamente!"
                ]);
        }catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al intentar almacenar el monitoreo!".$ex
            ]);
        }
        
    }

    public function almacenadesglose(Request $request){
        try{
            DB::beginTransaction();
            //Procesamos la información del desglose correspondiente
            //primero procesamos las eliminaciones de datos
            $voids = $request->voids;
            $vacias = explode("_",$voids);
            if(count($vacias)>0){
                array_pop($vacias);
                foreach($vacias as $vacia){
                    IABSRegion::where("idBS",$request->idBS)->where("anio",$request->anio)->where("idRegion",$vacia)->delete();
                }
            }

            //Procesamos las que contienen datos de desglose
            $datos  = $request->datos;
            $regiones = explode("&",$datos);
            if(count($regiones)>0){
                array_pop($regiones);
                foreach($regiones as $region){
                    $datos = explode("_",$region);
                    $valores = explode("|",$datos[1]);
                    array_pop($valores);
                    $existe = IABSRegion::where("idBS",$request->idBS)->where("anio",$request->anio)->where("idRegion",$datos[0])->first();
                    if($existe!=null){
                        IABSRegion::where("idBS",$request->idBS)->where("anio",$request->anio)->where("idRegion",$datos[0])->update([
                            "h1" => $valores[0]=="" || $valores[0]=="undefined"?null:$valores[0],
                            "m1"=> $valores[1]=="" || $valores[1]=="undefined"?null:$valores[1],
                            "a1"=> $valores[2]=="" || $valores[2]=="undefined"?null:$valores[2],
                            "h2"=> $valores[3]=="" || $valores[3]=="undefined"?null:$valores[3],
                            "m2"=> $valores[4]=="" || $valores[4]=="undefined"?null:$valores[4],
                            "a2"=> $valores[5]=="" || $valores[5]=="undefined"?null:$valores[5],
                            "h3"=> $valores[6]=="" || $valores[6]=="undefined"?null:$valores[6],
                            "m3"=> $valores[7]=="" || $valores[7]=="undefined"?null:$valores[7],
                            "a3"=> $valores[8]=="" || $valores[8]=="undefined"?null:$valores[8],
                            "h4"=> $valores[9]=="" || $valores[9]=="undefined"?null:$valores[9],
                            "m4"=> $valores[10]=="" || $valores[10]=="undefined"?null:$valores[10],
                            "a4"=> $valores[11]=="" || $valores[11]=="undefined"?null:$valores[11],
                        ]);
                    }else{
                        IABSRegion::create([
                            "idBS" => $request->idBS,
                            "idRegion" => $datos[0],
                            "anio" => $request->anio,
                            "h1" => $valores[0]=="" || $valores[0]=="undefined"?null:$valores[0],
                            "m1"=> $valores[1]=="" || $valores[1]=="undefined"?null:$valores[1],
                            "a1"=> $valores[2]=="" || $valores[2]=="undefined"?null:$valores[2],
                            "h2"=> $valores[3]=="" || $valores[3]=="undefined"?null:$valores[3],
                            "m2"=> $valores[4]=="" || $valores[4]=="undefined"?null:$valores[4],
                            "a2"=> $valores[5]=="" || $valores[5]=="undefined"?null:$valores[5],
                            "h3"=> $valores[6]=="" || $valores[6]=="undefined"?null:$valores[6],
                            "m3"=> $valores[7]=="" || $valores[7]=="undefined"?null:$valores[7],
                            "a3"=> $valores[8]=="" || $valores[8]=="undefined"?null:$valores[8],
                            "h4"=> $valores[9]=="" || $valores[9]=="undefined"?null:$valores[9],
                            "m4"=> $valores[10]=="" || $valores[10]=="undefined"?null:$valores[10],
                            "a4"=> $valores[11]=="" || $valores[11]=="undefined"?null:$valores[11],
                        ]);
                    }
                }
            }
            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "Desglose por región almacenado Satisfactoriamente!"
            ]);

        }catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al almacenar el desglose por región!".$ex
            ]);
        }

        

    }

    public function getdesglose(Request $request){
        $anio = $request->anio;
        $idBS = $request->idBS;
        $poblacion = $request->poblacion;
        $area = $request->area;
        $regiones = Region::all();
        return view("ia.getdesglose")->with("anio",$anio)->with("idBS",$idBS)->with("regiones",$regiones)->with("poblacion",$poblacion)->with("area",$area);
    }

    public function getdesglosereporte(Request $request){
        $anio = $request->anio;
        $idBS = $request->idBS;
        $poblacion = $request->poblacion;
        $area = $request->area;
        $regiones = Region::all();
        return view("ia.getdesglosereporte")->with("anio",$anio)->with("idBS",$idBS)->with("regiones",$regiones)->with("poblacion",$poblacion)->with("area",$area);
    }

    public function uploadmunicipios(Request $req){
        try {
            $medio = $req->file('file');
            //dd($medio->getClientOriginalName());
            $extension = $medio->extension();
            $random = time() . rand(1, 100);
            $random = "last_load".$req->trimestre_C;
            $nombreMedio =  $random . '.' . $medio->extension();
       
            $carpeta = 'medios/itar/' .$req->idPPA_C.'/bsmunicipios/'. $req->idBS_C. "/".$req->anio_C.'/municipios';
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            $medio->move(public_path('medios/itar/' .$req->idPPA_C.'/bsmunicipios/'. $req->idBS_C. "/".$req->anio_C.'/municipios/'), $nombreMedio);
            /*DB::beginTransaction();
            $mediog = new IAMedio();
            $mediog->ia_id = $req->idPPA_M;
            $mediog->nombre = $medio->getClientOriginalName();
            $mediog->archivo = $nombreMedio;
            $mediog->anio = $req->anio_M;
            $mediog->trimestre = $req->trim_M;
            $mediog->save();
            DB::commit();
            return response()->json([
                'success' => 'ok',
                'message' => 'Medio cargado Satisfactoriamente!',
                'filename' => $nombreMedio,
                'anio' => $mediog->anio,
                'idPPA' => $mediog->ia_id,
                'trimestre' => $mediog->trimestre,
                'extension' => $extension,
            ]);     */        
            return response()->json([
                'success' => 'ok',
                'message' => 'Medio cargado Satisfactoriamente!',
                'ruta' => 'medios/itar/' .$req->idPPA_C.'/bsmunicipios/'. $req->idBS_C. "/".$req->anio_C.'/municipios/',
                'archivo' => $nombreMedio
            ]);         
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                'success' => 'error',
                'message' => 'Ocurrió un error al cargar el medio!' . $ex,
            ]);
        }       
    }

    public function getprocesamientodesglose(Request $request){
        $municipios = Municipio::join("regiones","regiones.id","=","municipios.idRegion")->orderBy("clave")->get();        
        if(!file_exists(public_path($request->ruta)."/".$request->archivo)){
            return view("ia.procesamientodesglose")->with("estatus","error")->with("mensaje","No fue posible procesar el archivo cargado.");
        }else{
            $path = public_path($request->ruta)."/".$request->archivo;
            $datas = new ReaderXlsx();
            $worksheetInfo = $datas->listWorksheetInfo($path);
            $totalColumnas = $worksheetInfo[0]['totalColumns'];
            $letraFinalColumna = $worksheetInfo[0]['lastColumnLetter'];

            if($totalColumnas==8 && $letraFinalColumna=="H"){
                //comenzamos a realizar la lectura del archivo
                $reader = new ReaderXlsx();
                $spreadsheet = $reader->load($path);                
                $sheet = $spreadsheet->getActiveSheet();                
                //procedemos a eliminar los registros de la tabla ia_bs_municipios
                IABSMunicipio::where("idBS",$request->idBS)->where("anio",$request->anio)->where("trimestre",$request->trimestre)->delete();
                for($x=3;$x<=$sheet->getHighestRow();$x++){
                    $clave = $sheet->getCellByColumnAndRow(1, $x);                     
                    $clave_valor = (integer)$clave->getOldCalculatedValue();
                    if($clave_valor!=0){
                        if(strlen($clave_valor)==1)
                            $clave_valor = "00".$clave_valor;
                        else
                            if(strlen($clave_valor)==2)
                                $clave_valor = "0".$clave_valor;                         
                    }
                    
                    $mujeres = $sheet->getCellByColumnAndRow(4, $x)->getValue();
                    $hombres = $sheet->getCellByColumnAndRow(5, $x)->getValue();
                    $area = $sheet->getCellByColumnAndRow(7, $x)->getValue();
                    $entregas = $sheet->getCellByColumnAndRow(8, $x)->getValue();
                    if($clave_valor!=0){
                        IABSMunicipio::create([
                            "idBS" => $request->idBS,
                            "clave_municipio" => $clave_valor,
                            "anio" => $request->anio,
                            "trimestre" => $request->trimestre,
                            "mujeres" => $mujeres,
                            "hombres" => $hombres,
                            "area" => $area,
                            "entregas" => $entregas
                        ]);
                    }
                }
                $municipios_atendidos = IABSMunicipio::where("idBS",$request->idBS)->where("anio",$request->anio)->where("trimestre",$request->trimestre)
                                        ->join("municipios","municipios.clave","=","ia_bs_municipios.clave_municipio")
                                        ->join("regiones","regiones.id","=","municipios.idRegion")
                                        ->get();
                return view("ia.procesamientodesglose")->with("municipios",$municipios_atendidos);
            }else{
                return view("ia.procesamientodesglose")->with("estatus","error")->with("mensaje","Plantilla no válida, vuelva a intentar descargar la plantilla y volverla a llenar.");
            }
            
            //$extension = pathinfo(public_path($request->ruta)."/".$request->archivo, PATHINFO_EXTENSION);
            



            



            return view("ia.procesamientodesglose")->with("municipios",$municipios);
        }                
    }

    public function removepresupuestobs(Request $request){
        try{
            DB::beginTransaction();
            IABSPresupuesto::where("idBS",$request->idBS)->where("ia_bs_presupuesto.anio",$request->anio)->where("tipo",$request->tipo)->where("idPrograma",$request->idPrograma)->delete();
            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "Registro de presupuesto eliminado satisfactoriamente!"
            ]);
        }catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al tratar de eliminar el registro de presupuesto!"
            ]);

        }
    }

    public function exportitar(){
        return Excel::download(new ItarExport, 'ResumenITAR' . date('YmdHis') . '.xlsx');
    }

    public function getinfoppa(Request $request){
        $ppa = InformeAccion::where("id",$request->idPPA)->first();
        $ejes = EjePED::all();
        $alineaciones = IAAlineacion::where("ia_id",$request->idPPA)->first();
        $sectores = Sector::all();
        $indicadores = Indicador::where("en_revision","<>",2)->get();          
        $poblacion = Poblacion::all();
        $infoPoblacion = IAPoblacion::where("ia_id",$request->idPPA)->first();
        $bss = IABS::where("ia_id",$request->idPPA)->get();
        return view("ia.infocompletappa")->with("ppa",$ppa)->with("ejes",$ejes)->with("alineaciones",$alineaciones)->with("sectores",$sectores)->with("indicadores",$indicadores)->with("poblacion",$poblacion)->with("infoPoblacion",$infoPoblacion)->with("bss",$bss);        
    }

    public function almacenappatemporal(Request $request){
        try{
            DB::beginTransaction();
            InformeAccionTemporal::create([
                "tipo" => $request->tipo,
                "r_o" => $request->r_o,
                "link_r_o" => $request->link_r_o,
                "nombre" => $request->nombre,
                "objetivo" => $request->objetivo,
                "descripcion" => $request->descripcion, 
                "idEjePED" => $request->idEjePED, 
                "idTemaPED" => $request->idTemaPED,
                "idDependencia" => $request->idDependencia,
                "bss" => $request->bss
            ]);
            DB::commit();
            //Mail::to('informes.gobierno.oaxaca@gmail.com')->send(new TestEmail());
            //Mail::to('informes.gobierno.oaxaca@gmail.com')->send(new TestEmail($request->nombre,$request->objetivo,$request->descripcion));
            return response()->json([
                "result" => "ok",
                "message" => "La solicitud ha sido dada de alta satisfactoriamente, consulte el estatus en el listado en el boton de solicitudes"
            ]);

        }catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al intentar almacenar la solicitud de alta del PPA., intente más tarde.".$ex
            ]);
        }
    }

    public function getsolicitudes(Request $req){
        $solicitudes = InformeAccionTemporal::where("idDependencia",$req->idDependencia)
                        ->join("ejeped","ejeped.idEjePED","=","informe_acciones_temporal.idEjePED")
                        ->join("temaped","temaped.idTemaPED","=","informe_acciones_temporal.idTemaPED")
                        ->get();
        return view("ia.getsolicitudes")->with("solicitudes",$solicitudes);
    }

    public function getadminsolicitudes(){
        $solicitudes = InformeAccionTemporal::
            join("ejeped","ejeped.idEjePED","=","informe_acciones_temporal.idEjePED")
            ->join("temaped","temaped.idTemaPED","=","informe_acciones_temporal.idTemaPED")
            ->join("dependencia","dependencia.idDependencia","=","informe_acciones_temporal.idDependencia")
            ->get();
        return view("ia.adminsolicitudes")->with("solicitudes",$solicitudes);
    }

    public function procesasolicitud(Request $request){
        $des = $request->solicitud==1?"aceptada":"rechazada";
        try{
            DB::beginTransaction();
            InformeAccionTemporal::where("idPPATemp",$request->idPPATemp)->update([
                "estado" => $des=="aceptada"?"aceptado":"rechazado",
                "justificacion" => isset($request->justificacion)?$request->justificacion:null
            ]);          
            
            if($des=="aceptada"){
                $infoTemp = InformeAccionTemporal::where("idPPATemp",$request->idPPATemp)->first();
                InformeAccion::create([
                    "tipo" => $infoTemp->tipo,
                    "r_o" => $infoTemp->r_o,
                    "link_r_o" => $infoTemp->link_r_o,
                    "nombre" => $infoTemp->nombre,
                    "objetivo" => $infoTemp->objetivo,
                    "descripcion" => $infoTemp->descripcion,
                    "idTemaPED" => $infoTemp->idTemaPED, 
                    "idDependencia" => $infoTemp->idDependencia,                    
                ]);
            }


            DB::commit();
            return response()->json([
                "result"=>"ok",
                "message"=>"Solicitud ".$des." satisfactoriamente!."
            ]);

        }catch(Exception $ex){
            return response()->json([
                "result"=>"error",
                "message"=>"Ocurrió un error al procesar la"
            ]);
        }

        
    }

    public function reportes(Request $request){
        $ppa = InformeAccion::where("id",$request->idPPA)->first();
        $alineacion = IAAlineacion::where("ia_id",$request->idPPA)
                    ->leftjoin("ejeped","ejeped.idEjePED","=","ia_alineacion.idEjePED")
                    ->leftjoin("temaped","temaped.idTemaPED","=","ia_alineacion.idTemaPED")
                    ->leftjoin("objetivoped","objetivoped.idObjetivoPED","=","ia_alineacion.idObjetivoPED")
                    ->leftjoin("sectores","sectores.idSector","=","ia_alineacion.idSector")
                    ->leftjoin("objetivosector","objetivosector.idObjetivo","=","ia_alineacion.idObjetivoSector")
                    ->leftjoin("estrategiasector","estrategiasector.idEstrategia","=","ia_alineacion.idEstrategiaSector")
                    ->first();        
        $bss = IABS::where("ia_id",$request->idPPA)->get();
        $poblacion = IAPoblacion::where("ia_id",$request->idPPA)
                    ->leftjoin("itar_poblacion","itar_poblacion.id","=","tipo_poblacion_id")
                    ->first();
        return view("ia.reportes")->with("ppa",$ppa)->with("alineacion",$alineacion)->with("bss",$bss)->with("poblacion",$poblacion);
    }

    public function getseguimientoreporte(Request $request)
    {
        $anio = $request->anio;
        $idPPA = $request->idPPA;

        $presupuestoGeneral = IAPresupuestoGeneral::where('anio', $anio)
            ->where('ia_id', $idPPA)
            ->first();

        if (!$presupuestoGeneral) {
            $presupuestoGeneral = new \stdClass();
            $presupuestoGeneral->aplica = 1;
        }

        $presupuesto = IAPresupuestoTipoG::select("ia_presupuesto_tipog.*", "programa_presupuestario.*")->join("ia_presupuesto_general", "ia_presupuesto_general.id", "=", "ia_presupuesto_tipog.ia_presupuesto_general_id")
            ->where("ia_presupuesto_general.anio", $request->anio)
            ->where("ia_presupuesto_general.ia_id", $request->idPPA)
            ->leftjoin("programa_presupuestario", "programa_presupuestario.idPrograma", "=", "ia_presupuesto_tipog.pp_id")
            ->get();

        //dd($presupuesto);  
        $poblacion = IAPoblacion::where("ia_id", $request->idPPA)
            ->leftjoin("itar_poblacion", "itar_poblacion.id", "=", "tipo_poblacion_id")
            ->first();
        $infoP = null;
        if ($poblacion != null) {
            $infoP = IAPoblacionAnual::where("idPoblacion", "=", $poblacion->idPoblacion)->where("anio", "=", $request->anio)->first();
        }

        $bss = IABS::where("ia_bs.ia_id", $request->idPPA)
            ->leftJoin('ia_bs_estado', function ($join) use ($anio) {
                $join->on('ia_bs.idBS', '=', 'ia_bs_estado.idBs')
                    ->where('ia_bs_estado.anio', '=', $anio);
            })
            ->select('ia_bs.*', 'ia_bs_estado.aplica as aplica_estado')
            ->get();
        $medios1 = IAMedio::where("ia_id", $request->idPPA)->where("anio", $request->anio, )->where("trimestre", "1")->get();
        $medios2 = IAMedio::where("ia_id", $request->idPPA)->where("anio", $request->anio, )->where("trimestre", "2")->get();
        $medios3 = IAMedio::where("ia_id", $request->idPPA)->where("anio", $request->anio, )->where("trimestre", "3")->get();
        $medios4 = IAMedio::where("ia_id", $request->idPPA)->where("anio", $request->anio, )->where("trimestre", "4")->get();

        $obs1 = IAObservacion::where("ia_id", $request->idPPA)->where("anio", $request->anio, )->where("trimestre", "1")->get();
        $obs2 = IAObservacion::where("ia_id", $request->idPPA)->where("anio", $request->anio, )->where("trimestre", "2")->get();
        $obs3 = IAObservacion::where("ia_id", $request->idPPA)->where("anio", $request->anio, )->where("trimestre", "3")->get();
        $obs4 = IAObservacion::where("ia_id", $request->idPPA)->where("anio", $request->anio, )->where("trimestre", "4")->get();

        return view("ia.getseguimientoreporte")
            ->with("anio", $anio)
            ->with("presupuestoGeneral", $presupuestoGeneral)
            ->with("presupuesto", $presupuesto)
            ->with("poblacion", $poblacion)
            ->with("infoP", $infoP)
            ->with("bss", $bss)
            ->with("medios1", $medios1)
            ->with("medios2", $medios2)
            ->with("medios3", $medios3)
            ->with("medios4", $medios4)
            ->with("obs1", $obs1)
            ->with("obs2", $obs2)
            ->with("obs3", $obs3)
            ->with("obs4", $obs4)
            ->with("idPPA", $idPPA);
    }

    public function listadoppasitar(Request $request){
        $ppas = InformeAccion::select("id","nombre","descripcion", "objetivo","dependencia.dependenciaSiglas","informe_acciones.p_entrega","informe_acciones.prioritario",DB::raw("count(ia_bs.idBS) as bienes_servicios"),"informe_acciones.estado as estadoPPA")
                                ->join("dependencia","dependencia.idDependencia","=","informe_acciones.idDependencia")->orderBy("id")
                                ->leftjoin("ia_bs","ia_bs.ia_id","=","informe_acciones.id")
                                ->groupBy("informe_acciones.id","informe_acciones.nombre","informe_acciones.descripcion","informe_acciones.objetivo","dependencia.dependenciaSiglas","informe_acciones.p_entrega","informe_acciones.estado","informe_acciones.prioritario")
                                ->get();
        return view("itar.listadoconsulta")->with("ppas", $ppas);
    }

    public function listadodetalladoitar(Request $request){
        return Excel::download(new IADetalladoExport, 'AvanceITAR'.date("Y-m-d_His").'.xlsx');
    }

    function setprioritario(Request $request){

        try{
            //Itar::where("id",$request->idITAR)->first()->update([
              //  "estado" => $request->estado
            //]);
            InformeAccion::where("id",$request->idPPA)->first()->update([
                "prioritario" => $request->prioritario
            ]);
            return response()->json([
                "result" => "ok",
                "message" => "El estatus fue actualizado correctamente"
            ]);
        }catch(Exception $ex){
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al actualizar el estatus".$ex
            ]);
        }
    }

    function getdesglosemunicipal(Request $request){
        $trimestre1 = IABSMunicipio::where("idBS",$request->idBS)->where("anio",$request->anio)->where("trimestre",1)
                        ->join("municipios","municipios.clave","=","ia_bs_municipios.clave_municipio")
                        ->join("regiones","regiones.id","=","municipios.idRegion")
                        ->orderby("municipios.clave")
                        ->get();
        $trimestre2 = IABSMunicipio::where("idBS",$request->idBS)->where("anio",$request->anio)->where("trimestre",2)
                        ->join("municipios","municipios.clave","=","ia_bs_municipios.clave_municipio")
                        ->join("regiones","regiones.id","=","municipios.idRegion")
                        ->orderby("municipios.clave")
                        ->get();
        $trimestre3 = IABSMunicipio::where("idBS",$request->idBS)->where("anio",$request->anio)->where("trimestre",3)
                        ->join("municipios","municipios.clave","=","ia_bs_municipios.clave_municipio")
                        ->join("regiones","regiones.id","=","municipios.idRegion")
                        ->orderby("municipios.clave")
                        ->get();
        $trimestre4 = IABSMunicipio::where("idBS",$request->idBS)->where("anio",$request->anio)->where("trimestre",4)
                        ->join("municipios","municipios.clave","=","ia_bs_municipios.clave_municipio")
                        ->join("regiones","regiones.id","=","municipios.idRegion")
                        ->orderby("municipios.clave")
                        ->get();
        return view("ia.desglosemunicipal")->with("trimestre1",$trimestre1)->with("trimestre2",$trimestre2)->with("trimestre3",$trimestre3)->with("trimestre4",$trimestre4);
    }

    function setaplica(Request $request){
        try{
            DB::beginTransaction();
            IAPresupuestoGeneral::where("ia_id","$request->idPPA")->where("anio","$request->anio")->update([
                "aplica"=>$request->aplica=="true"?true:false
            ]);
            DB::commit();
            return response()->json([
                "result" => "ok",
                "message" => "Estado actualizado satisfactoriamente"
            ]);
        }catch(Exception $ex){
            DB::rollBack();
            return response()->json([
                "result" => "error",
                "message" => "Ocurrió un error al actualizar el estatus de Aplicación"
            ]);
        }

    }
    public function setVigente(Request $request)
    {
        try {
            InformeAccion::where("id", $request->idPPA)
            ->update([
                "vigente" => $request->vigente
            ]);
            return response()->json([
                "result" => "OK"
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "result" => "error",
                "message" => "NO se pudo actualizar la vigencia"
            ]);
        }
    }
    public function setaplicaBS(Request $request)
    {
        $validated = $request->validate([
            'idBS' => 'required|exists:ia_bs,idBS',
            'anio' => 'required|integer',
            'aplica' => 'required|boolean',
        ]);

        \DB::table('ia_bs_estado')->updateOrInsert(
            ['idBs' => $validated['idBS'], 'anio' => $validated['anio']],
            ['aplica' => $validated['aplica']]
        );

        return response()->json(['success' => true]);
    }
    public function getDesgloseBs(Request $request)
    {
        $idBs = $request->idBs;

        $bs = DB::table('ia_bs')
            ->where('idBS', $idBs)
            ->first();

        $estados = DB::table('ia_bs_estado')
            ->where('idBs', $idBs)
            ->select('idEstado', 'anio', 'app_dm', 'app_dr')
            ->orderBy('anio')
            ->get();

        return response()->json([
            'success' => true,
            'bien_servicio' => [
                'id' => $bs->idBS,
                'nombre' => $bs->nombreBS
            ],
            'estados' => $estados
        ]);
    }
    public function updateDesglose(Request $request)
    {
        DB::table('ia_bs_estado')
            ->where('idEstado', $request->idEstado)
            ->update([
                $request->campo => $request->valor
            ]);

        return response()->json(['success' => true]);
    }
    public function getEstadoDesgloseBs(Request $request)
    {
        $request->validate([
            'idBS' => 'required|exists:ia_bs,idBS',
            'anio' => 'required|integer'
        ]);

        $estado = DB::table('ia_bs_estado')
            ->where('idBs', $request->idBS)
            ->where('anio', $request->anio)
            ->select('app_dm', 'app_dr', 'just_dm', 'just_dr')
            ->first();

        return response()->json([
            'success' => true,
            'app_dm'  => $estado->app_dm ?? 0,
            'app_dr'  => $estado->app_dr ?? 0,
            'just_dm' => $estado->just_dm ?? '',
            'just_dr' => $estado->just_dr ?? ''
        ]);
    }

    public function guardarJustificaciones(Request $request)
    {
        $request->validate([
            'just_dm' => 'nullable|string|max:500',
            'just_dr' => 'nullable|string|max:500',
        ]);

        try {

            DB::table('ia_bs_estado')
                ->where('idBs', $request->idBS)
                ->where('anio', $request->anio)
                ->update([
                    'just_dm' => $request->just_dm,
                    'just_dr' => $request->just_dr,
                ]);

            return response()->json([
                'success' => true
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar las justificaciones'
            ], 500);
        }
    }

    public function guardarOrigenInfo(Request $request)
    {
        $request->validate([
            'idBS' => 'required|exists:ia_bs,idBS',
            'anio' => 'required|integer',
            'origen_informacion' => 'nullable|string|max:255',
        ]);

        IABSOrigenInfo::updateOrCreate(
            [
                'idBS' => $request->idBS,
                'anio' => $request->anio,
            ],
            [
                'origen_informacion' => $request->origen_informacion,
            ]
        );

        return response()->json(['success' => true]);
    }
    
    public function guardarPresupuestoTrimestral(Request $request)
    {
        DB::beginTransaction();

        try {

            $request->validate([
                'idBS' => 'required|integer',
                'anio' => 'required|integer',
                'programas' => 'required|array'
            ]);

            foreach ($request->programas as $item) {

                $data = [
                    't1' => $item['t1'] ?? 0,
                    't2' => $item['t2'] ?? 0,
                    't3' => $item['t3'] ?? 0,
                    't4' => $item['t4'] ?? 0,
                ];

                $claves = [
                    'idBS' => $request->idBS,
                    'anio' => $request->anio,
                    'programa_presupuestario_id' => $item['programa_presupuestario_id'],
                    'tipo_gasto' => $item['tipo_gasto'],
                ];

                if ((int)$request->anio === 2026) {
                    $claves['idComponente'] = $item['idComponente'] ?? null;
                    $data['idComponente'] = $item['idComponente'] ?? null;
                    $data['componente_texto'] = null;
                    $data['actividad_texto'] = null;
                } else {
                    $claves['componente_texto'] = $item['componente_texto'] ?? null;
                    $data['idComponente'] = null;
                    $data['componente_texto'] = $item['componente_texto'] ?? null;
                    $data['actividad_texto'] = $item['actividad_texto'] ?? null;
                }

                $registro = IAPresupuestoTrimestral::updateOrCreate(
                    $claves,
                    $data
                );

                if ((int)$request->anio === 2026) {

                    $nuevasActividades = $item['actividades'] ?? [];

                    $actividadesActuales = DB::table('ia_presupuesto_trimestral_actividad')
                        ->where('idPresupuestoTrimestral', $registro->idPresupuestoTrimestral)
                        ->pluck('idActividad')
                        ->toArray();

                    $paraInsertar = array_diff($nuevasActividades, $actividadesActuales);

                    foreach ($paraInsertar as $actividadId) {
                        DB::table('ia_presupuesto_trimestral_actividad')->insert([
                            'idPresupuestoTrimestral' => $registro->idPresupuestoTrimestral,
                            'idActividad' => $actividadId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    $paraEliminar = array_diff($actividadesActuales, $nuevasActividades);

                    if (!empty($paraEliminar)) {
                        DB::table('ia_presupuesto_trimestral_actividad')
                            ->where('idPresupuestoTrimestral', $registro->idPresupuestoTrimestral)
                            ->whereIn('idActividad', $paraEliminar)
                            ->delete();
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    private function cargarPresupuestoTrimestral(
        int $idBS,
        int $anio,
        Collection $programasSeguimiento
    ) {

        if ($programasSeguimiento->isEmpty()) {
            return $programasSeguimiento;
        }

        $presupuestoTrimestral = IAPresupuestoTrimestral::where('idBS', $idBS)
            ->where('anio', $anio)
            ->get();

        foreach ($programasSeguimiento as $ppId => $registros) {

            foreach ($registros as $registro) {

                $fila = $presupuestoTrimestral
                    ->where('programa_presupuestario_id', $ppId)
                    ->where('tipo_gasto', $registro->tipo_gasto)
                    ->first();

                if ($fila) {

                
                    $registro->t1 = $fila->t1;
                    $registro->t2 = $fila->t2;
                    $registro->t3 = $fila->t3;
                    $registro->t4 = $fila->t4;

                    $registro->idComponente = $fila->idComponente;
                    $registro->componente_texto = $fila->componente_texto;
                    $registro->actividad_texto = $fila->actividad_texto;

                    if ($anio == 2026) {

                        $registro->actividades = DB::table('ia_presupuesto_trimestral_actividad')
                            ->join('actividad', 'actividad.idActividad', '=', 'ia_presupuesto_trimestral_actividad.idActividad')
                            ->where('ia_presupuesto_trimestral_actividad.idPresupuestoTrimestral', $fila->idPresupuestoTrimestral)
                            ->select('actividad.*')
                            ->get();
                    }

                } else {

                    $registro->t1 = null;
                    $registro->t2 = null;
                    $registro->t3 = null;
                    $registro->t4 = null;
                    $registro->idComponente = null;
                    $registro->componente_texto = null;
                    $registro->actividad_texto = null;
                    $registro->actividades = collect();
                }
            }
        }

        return $programasSeguimiento;
    }
    public function getProgramaMonitoreo(Request $request)
    {
        $presupuestoGeneral = IAPresupuestoGeneral::where('ia_id', $request->idPPA)
            ->where('anio', $request->anio)
            ->first();

        if (!$presupuestoGeneral) {
            return '';
        }

        $registros = IAPresupuestoTipoG::where(
            'ia_presupuesto_general_id',
            $presupuestoGeneral->id
        )
            ->where('pp_id', $request->pp_id)
            ->join(
                'programa_presupuestario',
                'programa_presupuestario.idPrograma',
                '=',
                'ia_presupuesto_tipog.pp_id'
            )
            ->get()
            ->groupBy('pp_id');

        $registros = $this->cargarPresupuestoTrimestral(
            $request->idBS,
            $request->anio,
            $registros
        );
        $actividadesData = [];

        if ($request->has('actividades')) {

            $actividades = json_decode($request->actividades, true);

            if (is_array($actividades) && count($actividades)) {

                if ($request->anio == 2026) {

                    $ids = collect($actividades)->pluck('id')->toArray();

                    $actividadesData = DB::table('actividad')
                        ->whereIn('idActividad', $ids)
                        ->get();

                } 
                else {

                    $actividadesData = collect($actividades)->map(function ($a) {
                        return (object)[
                            'claveActividad' => '',
                            'descripcionActividad' => $a['descripcion']
                        ];
                    });
                }
            }
        }
        $componente_texto = $request->componente_texto;
        $actividad_texto  = $request->actividad_texto;
                return view('ia.programa_monitoreo', [
            'registros'     => $registros->first(),
            'idComponente'  => $request->idComponente,
            'componente'    => $request->idComponente 
                                ? DB::table('componente_presupuestario')
                                    ->where('idComponente', $request->idComponente)
                                    ->value(DB::raw("CONCAT(claveComponente,' ',descripcionComponente)"))
                                : null,
            'componente_texto' => $componente_texto,
            'actividad_texto'  => $actividad_texto,
            'actividades'   => $actividadesData
        ]);

    }
    public function deletePresupuestoTrimestral(Request $request)
    {
        $request->validate([
            'idBS' => 'required|integer',
            'anio' => 'required|integer',
            'pp_id' => 'required|integer',
        ]);

        try {

            $deleted = IAPresupuestoTrimestral::where('idBS', $request->idBS)
                ->where('anio', $request->anio)
                ->where('programa_presupuestario_id', $request->pp_id)
                ->delete();

            if ($deleted === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'El programa presupuestario no existe o ya fue eliminado.'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Programa presupuestario eliminado correctamente.'
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al eliminar el programa presupuestario.'
            ]);
        }
    }

    public function getComponentesPorPrograma($idPrograma)
    {
        return DB::table('componente_presupuestario')
            ->where('idPrograma', $idPrograma)
            ->orderBy('claveComponente')
            ->get([
                'idComponente as id',
                DB::raw("CONCAT(claveComponente,' ',descripcionComponente) as nombre")
            ]);
    }

    public function getActividadesPorComponente($idComponente)
    {
        return DB::table('actividad')
            ->where('idComponente', $idComponente)
            ->orderBy('claveActividad')
            ->get([
                'idActividad',
                'idComponente',
                'claveActividad',
                'descripcionActividad'
            ]);
    }
    

}
