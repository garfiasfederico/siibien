@php
    use App\Models\ProgramasPresupuestales;
@endphp


@extends('layouts.administrador')

@section('encabezado')
    <!--Heading-->
    <h1 class="h3 mb-0 text-gray-800">PPA / Edición</h1>
@endsection

@section('styles')
    <link href="{{ asset('resources/css/dropzone.css') }}" rel="stylesheet" type="text/css">
    <style>
        .enc1 {
            padding: 5px !important;
            background-color: #919090;
            color: white;
        }

        .enc2 {
            padding: 5px !important;
            background-color: #7c2f42;
            color: white;
        }

        .resp {
            font-weight: bold;
        }

        .enc3 {
            background-color: #ececec;
            font-weight: bold;
        }

        input[type=text],
        select {
            height: 35px;
        }

        table tr td {
            padding: 5px;
            border: solid 2px white;
        }
    </style>
@endsection

@section('content')
    <div class="row">

        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                    style="background-color: #681b2e;">
                    <h6 class="m-0 font-weight-bold text-light">Edición de Informe de Avance y Resultados de la
                        Transformación de Oaxaca (IARTO)
                    </h6>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="indicadorContent">
                    <h4 class="text-center">Fomulario para la edición del PPA</h4>
                    <form novalidate id="formPPA">
                        @csrf
                        <div style="width:100%;border:dotted 1px gray;">
                            <table style="width:100%">
                                <tr>
                                    <td class="enc1" title="Periodo Trimestral que se reporta"> Folio:
                                        <br />
                                    </td>
                                    <td class="resp">
                                        <h3>{{ $ppa->id }}</h3>
                                        <input type="hidden" name="id" value="{{ $ppa->id }}" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1" title="Periodo Trimestral que se reporta"> Periodo que se reporta:
                                        <span style="color: red">*</span>
                                        <br />
                                    </td>
                                    <td class="resp">
                                        <select class="form-control" name="periodo" id="periodo">
                                            <option value="">--Seleccione</option>
                                            <option value="42023">Octubre-Diciembre 2023</option>
                                            <option value="12024">Enero-Marzo 2024</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Debe seleccionar un periodo a reportar
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1">
                                        Dependencia o Entidad: <span style="color: red">*</span>
                                    </td>
                                    <td>
                                        <select class="form-control" style="width:100%" name="dependencia" id="dependencia"
                                            title="Elegir de la lista desplegable la institución de la que realiza el reporte">
                                            <option value="">--Seleccione</option>
                                            @foreach ($dependencias as $dependencia)
                                                <option value="{{ $dependencia->idDependencia }}">
                                                    {{ $dependencia->dependenciaNombre . ' (' . $dependencia->dependenciaSiglas . ')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Debe seleccionar la dependencia que reporta
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1">
                                        Fecha de Evento:
                                        <p style="font-style:oblique; font-size:.7em">En caso de que se haya realizado la
                                            entrega en un evento público indicar la fecha.</p>
                                    </td>
                                    <td>
                                        <input class="form-control" type="date" name="fecha_evento" id="fecha_evento"
                                            value="{{ $ppa->fecha_evento }}">
                                    </td>
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td colspan="2" class="enc2" style="text-align: center">1. Datos Generales</td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 30%">Nombre del Programa, Proyecto o Acción (PPA):
                                        <span style="color: red">*</span>
                                    </td>
                                    <td>
                                        <textarea class="form-control" name="nombre" style="width: 100%;" required id="nombre"
                                            title='Describa brevemente el nombre del PPA'>{{ $ppa->nombre }}</textarea>
                                        <div class="invalid-feedback">
                                            Debe indicar el nombre del programa, proyecto o acción a reportar.
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 30%">Objetivo General del PPA: <span
                                            style="color: red">*</span></td>
                                    <td>
                                        <textarea class="form-control" style="width: 100%;" name="objetivo" id="objetivo" required
                                            title='Describa el objetivo que busca atender el PPA. Por ejemplo: Reducir los indicadores de carencia alimentaria.'>{{ $ppa->objetivo }}</textarea>
                                        <div class="invalid-feedback">
                                            Debe indicar el objetivo general del PPA.
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 30%">Descripción del PPA:<span
                                            style="color: red">*</span></td>
                                    <td>
                                        <textarea class="form-control" style="width: 100%;" name="descripcion" id="descripcion" required
                                            title="Describa de manera general en qué consiste el PPA, con una extensión máxima de 40 a 70 palabras.">{{ $ppa->descripcion }}</textarea>
                                        <div class="invalid-feedback">
                                            Debe indicar la descripción del PPA.
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 30%">Cobertura: <span style="color: red">*</span></td>
                                    <td>
                                        <select class="form-control" style="width:100%;" name="cobertura" id="cobertura"
                                            title="Seleccionar del menú desplegable según corresponda; estatal, regional o municipal.">
                                            <option value="">--Seleccione</option>
                                            <option value="Municipal">Municipal</option>
                                            <option value="Distrital">Distrital</option>
                                            <option value="Regional">Regional</option>
                                            <option value="Estatal">Estatal</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Seleccione la cobertura
                                        </div>
                                    </td>
                                </tr>
                                <!--
                                                                <tr>
                                                                    <td class="enc3"  style="width: 30%">Compromiso Atendido:</td>
                                                                    <td><textarea class="form-control" style="width: 100%;" name="compromiso" required></textarea></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="enc3" style="width: 30%">Tipo PPA:</td>
                                                                    <td>
                                                                        <select class="form-control" style="width:100%;" name="tipo_ppa" title="Seleccionar de las opciones dadas, si el PPA se creó con propósito de la contingencia o si se trata de un PPA ya existente que fue modificado exprofeso.">
                                                                            <option value="1">Creado Exprofeso</option>
                                                                            <option value="2">Innovado o modificado Exprofeso</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>-->
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td colspan="4" class="enc2" style="text-align: center">2. Alineación PED</td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 15%">Eje:<span style="color: red">*</span></td>
                                    <td>
                                        <select name="eje_ped" id="eje_ped" class="form-control"
                                            onchange="getTemas()">
                                            <option value="">--Seleccione</option>
                                            @foreach ($ejes as $eje)
                                                <option value="{{ $eje->idEjePED }}">
                                                    {{ $eje->idEjePED . '. ' . $eje->ejePEDDescripcion }}</option>
                                            @endforeach

                                        </select>
                                        <div class="invalid-feedback">
                                            Seleccione un eje del PED
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 15%">Tema:<span style="color: red">*</span></td>
                                    <td>
                                        <select name="tema_ped" id="tema_ped" class="form-control"
                                            onchange="getObjetivos()">
                                            <option value="">--Seleccione</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Seleccione un tema del PED
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 15%">Objetivo:<span style="color: red">*</span></td>
                                    <td>
                                        <select name="objetivo_ped" id="objetivo_ped" class="form-control"
                                            onchange="getEstrategias()">
                                            <option value="">--Seleccione</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Seleccione un objetivo del PED
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 15%">Estrategia:</td>
                                    <td>
                                        <select name="estrategia_ped" id="estrategia_ped" class="form-control"
                                            onchange="getLineas()">
                                            <option value="">--Seleccione</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 15%">Linea de Acción:</td>
                                    <td>
                                        <select name="linea_ped" id="linea_ped" class="form-control">
                                            <option value="">--Seleccione</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                            <table style="width: 100%">
                                <tr>
                                    <td colspan="4" class="enc2" style="text-align: center">3. Programas
                                        Presupuestales</td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 15%">Programas Presupuestales:</td>
                                    <td>
                                        <select name="programa" id="programa" class="form-control">
                                            <option value="">--Seleccione</option>
                                            @foreach ($programas as $programa)
                                                <option value="{{ $programa->idPrograma }}">
                                                    {{ $programa->clavePrograma . '. ' . $programa->descripcionPrograma }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-success" type="button" onclick="addPrograma()"><i
                                                class="fas fa-plus"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1">
                                        Programas Relacionados:
                                    </td>
                                    <td>
                                        <table style="width: 100%" id="programasContent">
                                            @php
                                                $programas = explode('|', $ppa->alineacion_pp);
                                            @endphp
                                            @foreach ($programas as $programa)
                                                @if ($programa != '')
                                                    @php
                                                        $pinfo = ProgramasPresupuestales::where('idPrograma', $programa)->first();
                                                    @endphp
                                                    <tr style='width:100%' id='padded{{ $pinfo->idPrograma }}'
                                                        class=''>
                                                        <td><input type='hidden' name='programa_[]' class='prog'
                                                                value='{{ $pinfo->idPrograma }}'>{{ $pinfo->clavePrograma . '. ' . $pinfo->descripcionPrograma }}
                                                        </td>
                                                        <td><button class='btn btn-danger' type='button'
                                                                onclick='removeP("{{ $pinfo->idPrograma }}")'><i
                                                                    class='fas fa-trash'></i></button></td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                        </table>
                                        <input type="hidden" name="programas" id="programas" class="form-control" />
                                        <div class="invalid-feedback">
                                            Debe de Indicar al menos un programa presupuestario.
                                        </div>

                                    </td>

                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td colspan="6" class="enc2" style="text-align: center">4. Productos Entregados
                                        (Bienes o Servicios Públicos) e Inversión</td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 15%">Fuente de Financiamiento:<span
                                            style="color: red">*</span></td>
                                    <td>
                                        <input class="form-control" style="width: 100%;" name="fuente_financiamiento"
                                            id="fuente_financiamiento" required
                                            title='Señalar si se refiere a “Programa Normal Estatal”, “En coordinación con la Federación (pari-passu)” o “Programa Ejercido por el Gobierno Federal”, o en su caso si se trata de un programa emergente derivado de la emergencia. Escribir el nombre del programa presupuestario o fuente de financimiento del cual proviene el recurso a ejercer.'
                                            value="{{ $ppa->fuente_financiamiento }}" />
                                        <div class="invalid-feedback">
                                            Debe indicar la fuente de financiamiento.
                                        </div>
                                    </td>
                                    <td class="enc1" style="width: 15%">Monto de Inversión para el ejercicio:<span
                                            style="color: red">*</span>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" style="width: 100%;"
                                            name="monto_inversion" id="monto_inversion" required
                                            title='Escribir en formato de número con decimales.'
                                            value="{{ $ppa->monto_inversion }}" />
                                        <div class="invalid-feedback">
                                            Debe de indicar monto de inversión.
                                        </div>
                                    </td>
                                    <td class="enc1" style="width: 15%">Monto de Inversión ejercido en el periodo del
                                        reporte:<span style="color: red">*</span>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" style="width: 100%;"
                                            name="monto_ejercido" id="monto_ejercido" required
                                            title='Escribir en formato de número con decimales.'
                                            value="{{ $ppa->monto_ejercido }}" />
                                        <div class="invalid-feedback">
                                            Debe de indicar el monto ejercido del periodo
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 15%">Descripción del bien o servicio entregado:<span
                                            style="color: red">*</span></td>
                                    <td>
                                        <textarea class="form-control" style="width: 100%;" name="descripcion_bs" id="descripcion_bs" required
                                            title="Escribir el bien o servicio entregado.">{{ $ppa->descripcion_bs }}</textarea>
                                        <div class="invalid-feedback">
                                            Indique la descripcion del bien o servicio.
                                        </div>
                                    </td>
                                    <td class="enc1" style="width: 15%">Número de Entregas:<span
                                            style="color: red">*</span></td>
                                    <td>
                                        <input class="form-control" style="width: 100%;" name="entregas_bs"
                                            id="entregas_bs" required title="Escribir con número." type="number"
                                            value="{{ $ppa->entregas_bs }}" />
                                        <div class="invalid-feedback">
                                            Indique el número de entregas.
                                        </div>
                                    </td>
                                    <td class="enc1" style="width: 15%">Unidad de Medida:<span
                                            style="color: red">*</span></td>
                                    <td>
                                        <input class="form-control" style="width: 100%;" name="um_bs" id="um_bs"
                                            required title="Por ejemplo: Despensas, kilómetros, créditos, etc."
                                            value="{{ $ppa->um_bs }}" />
                                        <div class="invalid-feedback">
                                            Indique la unidad de medida.
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td colspan="6" class="enc2" style="text-align: center">5. Población Objetivo
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 15%">Tipo de beneficiario:<span
                                            style="color: red">*</span>
                                        <p style="font-style:oblique; font-size:.7em">Por ejemplo: Productores del campo,
                                            Artesanos, Microempresas, Niñas y Niños, etc.</p>
                                    </td>
                                    <td colspan="2" style="">
                                        <input class="form-control" style="width: 100%;" name="tipo_beneficiario"
                                            id="tipo_beneficiario" required
                                            title="Por ejemplo: Productores del campo, Artesanos, Microempresas, Niñas y Niños, etc."
                                            value="{{ $ppa->tipo_beneficiario }}" />
                                        <div class="invalid-feedback">
                                            Indique el tipo de beneficiario.
                                        </div>
                                    </td>
                                    <td class="enc1" style="width: 15%">Descripción del Beneficiario:<span
                                            style="color: red">*</span>
                                        <p style="font-style:oblique; font-size:.7em">Por ejemplo: Jefas de familia de los
                                            municipios de atención prioritaria.</p>
                                    </td>
                                    <td colspan="2" style="">
                                        <textarea class="form-control" style="width: 100%;" name="descripcion_beneficiario" id="descripcion_beneficiario"
                                            required title="Por ejemplo: Jefas de familia de los municipios de atención prioritaria.">{{ $ppa->descripcion_beneficiario }}</textarea>
                                        <div class="invalid-feedback">
                                            Indique la descripción del beneficiario
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 15%">Población Objetivo:<span
                                            style="color: red">*</span>
                                        <p style="font-style:oblique; font-size:.7em">Población que se planea atender en el
                                            año 2024.</p>
                                    </td>
                                    <td colspan="" style="width: 17.5%">
                                        @php
                                            $poblacion_objetivo = explode('|', $ppa->poblacion_objetivo);
                                            $poblacion_atender = explode('|', $ppa->poblacion_atender);
                                            $poblacion_atendida = explode('|', $ppa->poblacion_atendida);
                                        @endphp
                                        <input class="form-control" style="width: 100%;" name="p_o" id="p_o"
                                            required type="number"
                                            title="Población que se planea atender en el año 2024."
                                            value="{{ $poblacion_objetivo[0] }}" />
                                        <div class="invalid-feedback">
                                            Indique la población objetivo total
                                        </div>
                                    </td>
                                    <td class="enc1" style="width: 15%">Mujeres:<span style="color: red">*</span></td>
                                    <td colspan="" style="width: 17.5%">
                                        <input class="form-control" style="width: 100%;" name="p_o_m" id="p_o_m"
                                            required type="number" value="{{ $poblacion_objetivo[1] }}" />
                                        <div class="invalid-feedback">
                                            Indique la cantidad de mujeres totales atendidas.
                                        </div>
                                    </td>
                                    <td class="enc1" style="width: 15%">Hombres:<span style="color: red">*</span></td>
                                    <td colspan="" style="width: 17.50%">
                                        <input class="form-control" style="width: 100%;" name="p_o_h" id="p_o_h"
                                            required type="number" value="{{ $poblacion_objetivo[2] }}" />
                                        <div class="invalid-feedback">
                                            Indique la cantidad de hombres totales atendidos.
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 15%">Población Atendida:<span
                                            style="color: red">*</span>
                                        <p style="font-style:oblique; font-size:.7em">Población atendida en el periodo
                                            seleccionado.</p>
                                    </td>
                                    <td colspan="" style="width: 17.50%">
                                        <input class="form-control" style="width: 100%;" name="p_a" id="p_a"
                                            required type="number"
                                            title="Población atendida en el periodo seleccionado. "
                                            value="{{ $poblacion_atendida[0] }}" />
                                        <div class="invalid-feedback">
                                            Indique la población atendida con este PPA.
                                        </div>
                                    </td>
                                    <td class="enc1" style="width: 15%">Mujeres:<span style="color: red">*</span></td>
                                    <td colspan="" style="width: 17.50%">
                                        <input class="form-control" style="width: 100%;" name="p_a_m" id="p_a_m"
                                            required type="number" value="{{ $poblacion_atendida[1] }}" />
                                        <div class="invalid-feedback">
                                            Indique la cantidad de mujeres atendidas con este PPA.
                                        </div>
                                    </td>
                                    <td class="enc1" style="width: 15%">Hombres:<span style="color: red">*</span></td>
                                    <td colspan="" style="width: 17.50%">
                                        <input class="form-control" style="width: 100%;" name="p_a_h" id="p_a_h"
                                            required type="number" value="{{ $poblacion_atendida[2] }}" />
                                        <div class="invalid-feedback">
                                            Indique la cantidad de hombres atendidos con este PPA.
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 15%">Población por Atender:<span
                                            style="color: red">*</span>
                                        <p style="font-style:oblique; font-size:.7em">Población por atender en el resto del
                                            año. No aplica 2023.</p>
                                    </td>
                                    <td colspan="" style="width: 17.50%">
                                        <input class="form-control" style="width: 100%;" name="p_pa" id="p_pa"
                                            required type="number"
                                            title="Población por atender en el resto del año. No aplica 2023."
                                            value="{{ $poblacion_atender[0] }}" />
                                        <div class="invalid-feedback">
                                            Indique la población pendiente de atender
                                        </div>
                                    </td>
                                    <td class="enc1" style="width: 15%">Mujeres:<span style="color: red">*</span></td>
                                    <td colspan="" style="width: 17.50%">
                                        <input class="form-control" style="width: 100%;" name="p_pa_m" id="p_pa_m"
                                            required type="number" value="{{ $poblacion_atender[1] }}" />
                                        <div class="invalid-feedback">
                                            Indique la población de mujeres pendiente de atender
                                        </div>
                                    </td>
                                    <td class="enc1" style="width: 15%">Hombres:<span style="color: red">*</span></td>
                                    <td colspan="" style="width: 17.50%">
                                        <input class="form-control" style="width: 100%;" name="p_pa_h" id="p_pa_h"
                                            required type="number" value="{{ $poblacion_atender[2] }}" />
                                        <div class="invalid-feedback">
                                            Indique la población de hombres pendiente de atender.
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 15%"
                                        title="Señalar la o las regiones en las cuales se tiene programada la intervención.">
                                        Region(es):
                                        <p style="font-style:oblique; font-size:.7em">De click sobre las regiones
                                            atendidas. Vuelva a dar clic para descartarla.</p>
                                    </td>
                                    <td colspan="2">
                                        @php
                                            $regiones = explode('|', $ppa->regiones);
                                        @endphp
                                        <table style="width:100%;">
                                            <tr>
                                                <td><button
                                                        class="btn @if (array_search('caniada', $regiones) !== false) btn-success @else  btn-light @endif "
                                                        type="button" onclick="toggleRegion('caniada')" id="btncaniada"
                                                        style='width:180px;'><input id="caniada" style="display:none"
                                                            class="region @if (array_search('caniada', $regiones) !== false) region_seleccionada @endif"
                                                            type="checkbox" value="caniada" name="region[]"
                                                            @if (array_search('caniada', $regiones) !== false) checked @endif />Sierra de Flores Magón</button>
                                                </td>

                                                <td><button
                                                        class="btn @if (array_search('costa', $regiones) !== false) btn-success @else  btn-light @endif"
                                                        type="button" onclick="toggleRegion('costa')" id="btncosta"
                                                        style='width:180px;'><input id="costa" style="display:none"
                                                            type="checkbox"
                                                            class="region @if (array_search('costa', $regiones) !== false) region_seleccionada @endif"
                                                            value="costa" name="region[]"
                                                            @if (array_search('costa', $regiones) !== false) checked @endif />Costa</button>
                                                </td>


                                            </tr>
                                            <tr>
                                                <td><button
                                                    class="btn @if (array_search('istmo', $regiones) !== false) btn-success @else  btn-light @endif"
                                                    type="button" onclick="toggleRegion('istmo')" id="btnistmo"
                                                    style='width:180px;'><input id="istmo" style="display:none"
                                                        type="checkbox"
                                                        class="region @if (array_search('istmo', $regiones) !== false) region_seleccionada @endif"
                                                        value="istmo" name="region[]"
                                                        @if (array_search('istmo', $regiones) !== false) checked @endif />Istmo</button>
                                                </td>
                                                <td><button
                                                        class="btn @if (array_search('mixteca', $regiones) !== false) btn-success @else  btn-light @endif"
                                                        type="button" onclick="toggleRegion('mixteca')" id="btnmixteca"
                                                        style='width:180px;'><input id="mixteca" style="display:none"
                                                            type="checkbox"
                                                            class="region @if (array_search('mixteca', $regiones) !== false) region_seleccionada @endif"
                                                            value="mixteca" name="region[]"
                                                            @if (array_search('mixteca', $regiones) !== false) checked @endif />Mixteca</button>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td><button
                                                        class="btn @if (array_search('papaloapam', $regiones) !== false) btn-success @else  btn-light @endif"
                                                        type="button" onclick="toggleRegion('papaloapam')"
                                                        id="btnpapaloapam" style='width:180px;'><input id="papaloapam"
                                                            style="display:none" type="checkbox"
                                                            class="region @if (array_search('papaloapam', $regiones) !== false) region_seleccionada @endif"
                                                            value="papaloapam" name="region[]"
                                                            @if (array_search('papaloapam', $regiones) !== false) checked @endif />Papaloapan
                                                </td>

                                                <td><button
                                                        class="btn @if (array_search('sierra_norte', $regiones) !== false) btn-success @else  btn-light @endif"
                                                        type="button" onclick="toggleRegion('sierra_norte')"
                                                        id="btnsierra_norte" style='width:180px;'><input
                                                            id="sierra_norte" style="display:none" type="checkbox"
                                                            class="region @if (array_search('sierra_norte', $regiones) !== false) region_seleccionada @endif"
                                                            value="sierra_norte" name="region[]"
                                                            @if (array_search('sierra_norte', $regiones) !== false) checked @endif />Sierra
                                                        de Juárez</button></td>
                                            </tr>
                                            <tr>
                                                <td><button
                                                        class="btn @if (array_search('sierra_sur', $regiones) !== false) btn-success @else  btn-light @endif"
                                                        type="button" onclick="toggleRegion('sierra_sur')"
                                                        id="btnsierra_sur" style='width:180px;'><input id="sierra_sur"
                                                            style="display:none" type="checkbox"
                                                            class="region @if (array_search('sierra_sur', $regiones) !== false) region_seleccionada @endif"
                                                            value="sierra_sur" name="region[]"
                                                            @if (array_search('sierra_sur', $regiones) !== false) checked @endif />Sierra
                                                        Sur</button></td>

                                                <td><button
                                                        class="btn @if (array_search('valles_centrales', $regiones) !== false) btn-success @else  btn-light @endif"
                                                        type="button" onclick="toggleRegion('valles_centrales')"
                                                        id="btnvalles_centrales" style='width:180px;'><input
                                                            id="valles_centrales" style="display:none" type="checkbox"
                                                            class="region @if (array_search('valles_centrales', $regiones) !== false) region_seleccionada @endif"
                                                            value="valles_centrales" name="region[]"
                                                            @if (array_search('valles_centrales', $regiones) !== false) checked @endif />Valles
                                                        Centrales</button></td>
                                            </tr>
                                        </table>
                                        <input type="hidden" id="regiones">
                                        <div class="invalid-feedback">
                                            Indique al menos una región atendida.
                                        </div>
                                    </td>
                                    <td class="enc1" style="width: 15%">Municipio(s):</td>
                                    <td colspan="2">
                                        <textarea class="form-control" style="width: 100%;" name="municipios" id="municipios" required
                                            title='Especificar los municipios atendidos con el "Programa", "Proyecto" o "Acción". En caso de tratarse de mas de cinco, reportar el total de municipios atendidos.'>{{ $ppa->municipios }}</textarea>
                                    </td>
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td colspan="6" class="enc2" style="text-align: center">6. Impacto Generado
                                        <p style="font-style:oblique; font-size:.7em">Describir en no más de 40 palabras el
                                            impacto generado o que se espera generar con el PPA, en el aspecto que aplique
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="enc1" style="width: 15%">Social:
                                    </td>
                                    <td colspan="">
                                        <textarea class="form-control" style="width: 100%;" name="impacto_social" required
                                            title="Población por atender en el resto del año. No aplica 2023.">{{ $ppa->impacto_social }}</textarea>
                                    </td>
                                    <td class="enc1" style="width: 15%">Económico:</td>
                                    <td colspan="">
                                        <textarea class="form-control" style="width: 100%;" name="impacto_economico" required>{{ $ppa->impacto_economico }}</textarea>
                                    </td>
                                    <td class="enc1" style="width: 15%">Ambiental:</td>
                                    <td colspan="">
                                        <textarea class="form-control" style="width: 100%;" name="impacto_ambiental" required>{{ $ppa->impacto_ambiental }}</textarea>
                                    </td>
                                </tr>
                            </table>
                            <table style="width: 100%">
                                <tr>
                                    <td colspan="6" class="enc1" style="text-align: center"
                                        title="Capturar comentarios adicionales que sea importante reportar.">6.
                                        Observaciones Generales</td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="enc1" style="text-align: center">
                                        <textarea class="form-control" style="width: 100%" name="observaciones_generales"
                                            title="Capturar comentarios adicionales que sea importante reportar.">{{ $ppa->observaciones }}</textarea>
                                    </td>
                                </tr>
                                <!-- <tr>
                                                        <td colspan="3" class="enc1" style="text-align: center">
                                                            <textarea class="form-control" style="width: 100%" name="elaboro"></textarea>
                                                        </td>
                                                        <td colspan="3" class="enc1" style="text-align: center">
                                                            <textarea class="form-control" style="width: 100%" name="aprobo"></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="enc1" style="text-align: center">Elaboró<br />(Nombre y
                                                            cargo)</td>
                                                        <td colspan="3" class="enc1" style="text-align: center">Aprobó <br /> (Nombre y
                                                            cargo)</td>
                                                    </tr>-->
                                <tr>
                                    <td colspan="6">
                                        <center class="enc2">7. Medios de Verificación</center>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" align="center">

                                        <table style="width: 50%" class="table">
                                            <thead>
                                                <tr class="enc1">
                                                    <th>Medio cargado</th>
                                                    <th>Descripcion</th>
                                                    <th>Opcion</th>
                                                </tr>
                                            </thead>
                                            <tbody id="medios_cargados">
                                                @foreach ($medios as $medio)
                                                    <tr id="rowmedio{{ $medio->id }}">
                                                        <td class="medioppa" medio=""><input type="hidden"
                                                                name="medio[]" value="{{ $medio->id }}"><a
                                                                target="blank_"
                                                                href="{{ asset('medios/ppa/' . $ppa->id . '/' . $medio->original) }}">{{ $medio->real }}</a>
                                                        </td>
                                                        <td>
                                                            <textarea placeholder="Agrega Descripción" class="medioppa" name="descripcionmedio[]">{{ $medio->descripcion }}</textarea>
                                                        </td>
                                                        <td><button type="button" class="btn btn-danger"
                                                                onclick="deleteMedioRelacionado('{{ $medio->id }}')"><i
                                                                    class="fas fa-trash"></i></button></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>

                                </tr>
                            </table>

                        </div>
                    </form>
                    <div class="">
                        <div class="col-xl-12" style="height:200px;overflow:scroll;">
                            <form action="{{ route('ppa.medioupload') }}" method="POST" enctype="multipart/form-data"
                                class="dropzone" id="medios-ppa" style="color:blue">
                                @csrf
                                <input type="hidden" name="ppa_id" id="ppa_id" value="{{ $ppa->id }}">
                            </form>
                        </div>
                    </div>
                    <div align="center">
                        <input class="form-control btn btn-primary" type='button'
                            style="width:300px;cursor:pointer;height:80px" value="Almacenar Reporte trimestral"
                            onclick="almacenaPPA()">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('resources/js/dropzone-min.js') }}"></script>
    <script>
        $(document).ready(function() {
            dependencia = {{ session('idDependencia') }};
            if (!dependencia == 0) {
                $('#dependencia').val(dependencia);
                $('#dependencia').prop('disabled', true);
            }
            $("#collapsePPA").addClass("show");
            //$("#pparegistro").addClass("active");
            $("#ppalistado").css('background-color', "rgb(217, 217, 217)");
            //fillEjemplo();

            //Llenamos los select del formulario
            $("#periodo").val('{{ $ppa->periodo }}');
            $("#dependencia").val('{{ $ppa->dependencia_id }}');
            $("#cobertura").val('{{ $ppa->cobertura }}');

            alineacion_ped = '{{ $ppa->alineacion_ped }}'.split('|');

            $("#eje_ped").val(alineacion_ped[0]);
            getTemas();
            setTimeout(function() {
                $("#tema_ped").val(alineacion_ped[1]);
                getObjetivos()
            }, 500);
            setTimeout(function() {
                $("#objetivo_ped").val(alineacion_ped[2]);
                getEstrategias()
            }, 1000);

            if (alineacion_ped[3] != '') {
                setTimeout(function() {
                    $("#estrategia_ped").val(alineacion_ped[3]);
                    getLineas()
                }, 1500);
                if (alineacion_ped[4] != '') {
                    setTimeout(function() {
                        $("#linea_ped").val(alineacion_ped[4]);
                    }, 2000);
                }
            }

            inicializaDropZone();


        });

        function getTemas() {
            if ($("#eje_ped").val() != 0) {
                $("#objetivosped").html("");
                $.ajax({
                    type: 'GET',
                    url: "{{ route('gettemas') }}",
                    data: {
                        idEjePED: $("#eje_ped").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {

                    }
                }).done(function(response) {

                    options = "<option value=''>--Seleccione</option>";
                    if (response.success = "ok") {
                        for (x = 0; x < response.temas.length; x++) {
                            options += "<option value='" + response.temas[x].idTemaPED + "'>" +
                                response.temas[x].temaPEDClave + " " + response.temas[x].temaPEDDescripcion +
                                "</option>";
                        }
                        $("#tema_ped").html(options);
                        $("#objetivo_ped").html("<option value=''>--Seleccione</option>");
                        $("#estrategia_ped").html("<option value=''>--Seleccione</option>");
                        $("#linea_ped").html("<option value=''>--Seleccione</option>");
                    }
                });
            } else {}
        }

        function getObjetivos() {
            if ($("#tema_ped").val() != 0) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('getobjetivos') }}",
                    data: {
                        idTemaPED: $("#tema_ped").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {

                    }
                }).done(function(response) {

                    if (response.success = "ok") {
                        options = "<option value=''>--Seleccione</option>";
                        for (x = 0; x < response.objetivos.length; x++) {
                            for (x = 0; x < response.objetivos.length; x++) {
                                options += "<option value='" + response.objetivos[x].idObjetivoPED + "'>" +
                                    response.objetivos[x].objetivoPEDClave + " " + response.objetivos[x]
                                    .objetivoPEDDescripcion +
                                    "</option>";
                            }
                        }
                        $("#objetivo_ped").html(options);
                        $("#estrategia_ped").html("<option value=''>--Seleccione</option>");
                        $("#linea_ped").html("<option value=''>--Seleccione</option>");
                    }
                });
            } else {}

        }

        function getEstrategias() {
            if ($("#objetivo_ped").val() != 0) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('getestrategias') }}",
                    data: {
                        idObjetivoPED: $("#objetivo_ped").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {

                    }
                }).done(function(response) {

                    if (response.success = "ok") {
                        options = "<option value=''>--Seleccione</option>";
                        for (x = 0; x < response.estrategias.length; x++) {
                            for (x = 0; x < response.estrategias.length; x++) {
                                options += "<option value='" + response.estrategias[x].idEstrategiaPED + "'>" +
                                    response.estrategias[x].estrategiaPEDClave + " " + response.estrategias[x]
                                    .estrategiaPEDDescripcion +
                                    "</option>";
                            }
                        }
                        $("#estrategia_ped").html(options);
                    }
                });
            } else {}

        }

        function getLineas() {
            if ($("#estrategia_ped").val() != 0) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('getlineas') }}",
                    data: {
                        idEstrategiaPED: $("#estrategia_ped").val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        //block(true);
                    }
                }).done(function(response) {
                   // block(false);
                    if (response.success = "ok") {
                        options = "<option value=''>--Seleccione</option>";
                        for (x = 0; x < response.lineas.length; x++) {
                            for (x = 0; x < response.lineas.length; x++) {
                                options += "<option value='" + response.lineas[x].idLAPED + "'>" +
                                    response.lineas[x].laPEDClave + " " + response.lineas[x].laPEDDescripcion +
                                    "</option>";
                            }
                        }
                        $("#linea_ped").html(options);
                    }
                });
            } else {}

        }

        function addPrograma() {
            programa = $('#programa').val();
            if (programa != '') {
                programa_text = $('#programa option:selected').text();
                if ($('#padded' + programa).length < 1) {
                    row = "<tr style='width:100%' id='padded" + programa +
                        "' class=''><td><input type='hidden' name='programa_[]' class='prog' value='" + programa + "'>" +
                        programa_text +
                        "</td><td><button class='btn btn-danger' type='button' onclick='removeP(" + programa +
                        ")'><i class='fas fa-trash'></i></button></td></tr>"
                    $("#programasContent").append(row);
                }
            }
        }

        function removeP(programa) {
            $("#padded" + programa).remove();
        }

        function almacenaPPA() {


            //alert(formData);
            if (validaCampos()) {

                $("#dependencia").prop('disabled', false);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ppa.store') }}",
                    data: $("#formPPA").serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        block(true)
                    }
                }).done(function(response) {

                    if (response.success != "ok") {
                        $("#dependencia").prop('disabled', true);
                        Swal.fire({
                            icon: 'error',
                            title: 'Ocurrió un error al tratar de almacenar el PPA ',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {

                        });

                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'PPA actualizado satisfactoriamente!',
                            text: "PPA actualizado",
                            confirmButtonColor: '#3085d6',
                        }).then((result) => {
                            window.location.replace("{{ route('ppa.listado') }}");
                        });
                    }
                    block(false)
                }).fail(function(data) {
                    block(false)
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Favor de atender las observaciones en el formulario',
                    text: "Detalles de Captura",
                    confirmButtonColor: '#3085d6',
                }).then((result) => {

                });
            }
        }

        function validaCampos() {
            inputs = [
                "nombre",
                "objetivo",
                "descripcion",
                "fuente_financiamiento",
                "monto_inversion",
                "monto_ejercido",
                "descripcion_bs",
                "entregas_bs",
                "um_bs",
                "descripcion_beneficiario",
                "tipo_beneficiario",
                "p_o",
                "p_o_m",
                "p_o_h",
                "p_a",
                "p_a_m",
                "p_a_h",
                "p_pa",
                "p_pa_m",
                "p_pa_h",

            ];
            selects = [
                "periodo",
                "dependencia",
                "cobertura",
                "eje_ped",
                "tema_ped",
                "objetivo_ped",
            ];
            valid = true;

            for (var x = 0; x < inputs.length; x++) {
                if ($("#" + inputs[x]).val().trim().length == 0) {
                    $("#" + inputs[x]).addClass("is-invalid");
                    valid = false;
                } else {
                    $("#" + inputs[x]).removeClass("is-invalid");
                }
            }

            for (var x = 0; x < selects.length; x++) {
                if ($("#" + selects[x]).val() == '') {
                    $("#" + selects[x]).addClass("is-invalid");
                    valid = false;
                } else {
                    $("#" + selects[x]).removeClass("is-invalid");
                }
            }

            if ($(".region_seleccionada").length == 0) {
                $('#regiones').addClass('is-invalid')
                valid = false;
            } else {
                $('#regiones').removeClass('is-invalid')
            }

      /*      if ($(".prog").length == 0) {
                $('#programas').addClass('is-invalid');
                valid = false;
            } else {
                $('#programas').removeClass('is-invalid')
            }*/




            return valid;

        }

        function toggleRegion(region) {
            if (!$("#" + region).prop('checked')) {
                $("#" + region).prop('checked', true)
                $('#btn' + region).removeClass('btn-light');
                $('#btn' + region).addClass('btn-success');
                $("#" + region).addClass('region_seleccionada');
            } else {
                $("#" + region).prop('checked', false)
                $('#btn' + region).addClass('btn-light');
                $('#btn' + region).removeClass('btn-success');
                $("#" + region).removeClass('region_seleccionada');
            }

        }

        function inicializaDropZone() {
            miareadecarga = new Dropzone("#medios-ppa", {
                thumbnailWidth: 500,
                maxFilesize: 5,
                //disablePreviews:true,
                acceptedFiles: ".jpg,.jpeg,.png,.tiff,.raw,.pdf,.zip,.docx,.xlsx,.doc,.xls,application/x-zip-compressed,application/zip",
                buttonRemove: true
            });
            miareadecarga.on("addedfile", file => {
                //idIndicador = $("#idIndicador").val();
            });

            miareadecarga.on("success", function(file, response) {
                if (response.success == "ok") {
                    nombre = file.name;
                    filename = response.filename;
                    rowmedio = '<tr id="rowmedio' + response.medio_id + '">' +
                        '<td class="medioppa" medio=""><input type="hidden" name="medio[]" value="' + response
                        .medio_id + '"><a target="blank_" href="{{ asset('medios') }}' + '/ppa/' + $("#id").val() +
                        "/" + filename + '">' + nombre + '</a></td>' +
                        '<td><textarea placeholder="Agrega Descripción" class="medioppa" name="descripcionmedio[]"></textarea></td>' +
                        '<td><button type="button" class="btn btn-danger" onclick="deleteMedioRelacionado(' +
                        response.medio_id + ')"><i class="fas fa-trash"></i></button></td>' +
                        '</tr>';
                    $("#medios_cargados").append(rowmedio).show("slow");
                }
            });
        }

        function deleteMedioRelacionado(medio_id) {
            ppa_id = $("#ppa_id").val();
            $.ajax({
                type: 'GET',
                url: "{{ route('ppa.medio.tempremove') }}",
                data: {
                    medio_id: medio_id,
                    base: "1",
                    ppa_id: ppa_id

                },
                dataType: 'json',
                beforeSend: function() {
                    block(true)
                }
            }).done(function(response) {

                if (response.success == "ok") {
                    $("#rowmedio" + medio_id).hide('slow');
                    setTimeout(function() {
                        $("#rowmedio" + medio_id).remove()
                    }, 200);
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'El medio temporal no pudo eliminarse',
                        text: "Medio Temporales",
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {});
                }
                block(false)
            }).fail(function(data) {
                block(false)
            });

        }
    </script>
@endsection
