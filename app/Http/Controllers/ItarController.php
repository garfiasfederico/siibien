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
use App\Models\IAAlineacion;
use App\Models\InformeAccion;
use App\Models\ItarBS;
use App\Models\ItarPresupuesto;
use Illuminate\Support\Facades\DB;
use App\Models\ProgramasPresupuestales;
use App\Models\Sector;

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
        return view("itar.listado")->with("ppas", $ppas);
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
        $ppas = Itar::join("dependencia","dependencia.idDependencia","=","itar.idDependencia")->get();
        return view("itar.listadoadmin")->with("ppas", $ppas);
    }

    function uptestado(Request $request){

        try{
            Itar::where("id",$request->idITAR)->first()->update([
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
                    "idProductoSector" => $request->idProductoSector,
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
                    "idProductoSector" => $request->idProductoSector,
                    "i_estrategicos" => $request->indicadores,
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
        return view("ia.info")->with("ppa",$ppa)->with("ejes",$ejes)->with("alineaciones",$alineaciones)->with("sectores",$sectores)->with("indicadores",$indicadores);
    }

}
