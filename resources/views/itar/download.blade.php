<div class="tab-pane fade show active" id="nav-home" role="tabpanel"aria-labelledby="nav-home-tab" style="font-size: 10pt">
    <div>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="6">
                    1. Datos Generales
                </td>
            </tr>
            <tr>
                <td class="sombreado" colspan="1">Folio:</td>
                <td class="value" align="center" colspan="1" style="background-color:gray;color:white;">
                    <b>{{ $ppa->folio }}</b></td>
                <td class=" sombreado" colspan="1"> Periodo de reporte:</td>
                <td class="value" align="center" colspan="1">{{ $periodo }}</td>
                <td class=" sombreado" style="" colspan="1"> Fecha de envío:</td>
                <td class="value" align="center" colspan="1">{{ $ppa->fecha_evento }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Dependencia/Entidad:</td>
                <td class="value" colspan="6" style="text-align: center;font-size:11pt;">
                    <b>{{ $dependencia->dependenciaNombre . ' (' . $dependencia->dependenciaSiglas . ')' }}</b>
                </td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Tipo:</td>
                <td class="value" align="justify" colspan="6"><b>{{ Str::title($ppa->tipo) }}</b></td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Nombre del Programa, Proyecto o Acción (PPA):</td>
                <td class="value" align="justify" colspan="6">{{ $ppa->nombre }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Objetivo del PPA:</td>
                <td class="value" align="justify" colspan="6">{{ $ppa->objetivo }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Descripción del PPA:</td>
                <td class="value" align="justify" colspan="6">{{ $ppa->descripcion }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Cobertura del PPA:</td>
                <td class="value" colspan="1" align="center">{{ Str::title($ppa->cobertura) }}</td>
                <td class=" sombreado" style="" colspan="1">Periodicidad:</td>
                <td class="value" colspan="1" align="center">{{ Str::title($ppa->periodicidad) }}</td>
                <td class=" sombreado" style="" colspan="1">Año de Inicio:</td>
                <td class="value" colspan="1" align="center">{{ Str::title($ppa->anio_inicio) }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="5">
                    2. Alineación al PED
                </td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Eje:</td>
                <td class="value" align="justify" colspan="5">
                    {{ $ejeped->ejePEDClave . ' ' . $ejeped->ejePEDDescripcion }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Tema:</td>
                <td class="value" align="justify" colspan="5">
                    {{ $temaped->temaPEDClave . ' ' . $temaped->temaPEDDescripcion }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Objetivo:</td>
                <td class="value" align="justify" colspan="5">
                    {{ $objetivoped->objetivoPEDClave . ' ' . $objetivoped->objetivoPEDDescripcion }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Estrategia:</td>
                <td class="value" align="justify" colspan="5">
                    {{ $estrategiaped->estrategiaPEDClave . ' ' . $estrategiaped->estrategiaPEDDescripcion }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Linea:</td>
                <td class="value" align="justify" colspan="5">
                    {{ $lineaped->laPEDClave . ' ' . $lineaped->laPEDDescripcion }}</td>
            </tr>
            <tr>
                @php
                    $transversales = $ppa->transversales;
                    $array_trans = explode('|', $transversales);
                    if (count($array_trans) > 0) {
                        array_pop($array_trans);
                    }

                @endphp
                <td class=" sombreado" style="" colspan="1">Eje(s) tranversales:</td>
                <td class="value" align="justify" colspan="1" align="center"><input type="checkbox"
                        name="box" value="1" style="transform: scale(2);"
                        @if (array_search('igualdad', $array_trans) !== false) checked="true" @endif readonly="true" />Igualdad de género
                </td>
                <td class="value" align="justify" colspan="1" align="center"><input type="checkbox"
                        name="box" value="1" style="transform: scale(2);"
                        @if (array_search('desarrollo', $array_trans) !== false) checked="true" @endif readonly="true" />Desarrollo sostenible
                    y cambio climático</td>
                <td class="value" align="justify" colspan="1" align="center"><input type="checkbox"
                        name="box" value="1" style="transform: scale(2);"
                        @if (array_search('interculturalidad', $array_trans) !== false) checked="true" @endif readonly="true" />Interculturalidad
                </td>
                <td class="value" align="justify" colspan="1" align="center"><input type="checkbox"
                        name="box" value="1" style="transform: scale(2);"
                        @if (array_search('ninas', $array_trans) !== false) checked="true" @endif readonly="true" />Niñas, Niños y
                    Adolescentes</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Indicador Estratégico:</td>
                <td class="value" align="justify" colspan="5">
                    {{ '[' . $indicador->idIndicador . '] ' . $indicador->indicadorNombre }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="5">
                    3. Presupuesto
                </td>
            </tr>
            @if ($presupuestos->count() > 0)
                @foreach ($presupuestos as $presupuesto)
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            Ejercicio:
                        </td>
                        <td colspan="4" class="value">
                            {{ $presupuesto->ejercicio }}
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            Programa:
                        </td>
                        <td colspan="4" class="value">
                            {{ $presupuesto->clavePrograma . ' ' . $presupuesto->descripcionPrograma }}
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            Fecha de corte:
                        </td>
                        <td colspan="4" class="value">
                            {{ $presupuesto->fecha_corte }}
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="5">
                            Federal
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            Presupuesto
                        </td>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            enero-marzo
                        </td>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            abril-junio
                        </td>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            julio-septiembre
                        </td>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            octubre-diciembre
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            Modificado:
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->f1m }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->f2m }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->f3m }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->f4m }}
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            Ejercido:
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->f1e }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->f2e }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->f3e }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->f4e }}
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            Porcentaje:
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            <b>{{ $presupuesto->f1m > 0 ? ($presupuesto->f1e / $presupuesto->f1m) * 100 : '' }} %</b>
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            <b>{{ $presupuesto->f2m > 0 ? ($presupuesto->f2e / $presupuesto->f2m) * 100 : '' }} %</b>
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            <b>{{ $presupuesto->f3m > 0 ? ($presupuesto->f3e / $presupuesto->f3m) * 100 : '' }} %</b>
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            <b>{{ $presupuesto->f4m > 0 ? ($presupuesto->f4e / $presupuesto->f4m) * 100 : '' }} %</b>
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="5">
                            Estatal
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            Presupuesto
                        </td>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            enero-marzo
                        </td>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            abril-junio
                        </td>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            julio-septiembre
                        </td>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            octubre-diciembre
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            Modificado:
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->e1m }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->e2m }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->e3m }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->e4m }}
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            Ejercido:
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->e1e }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->e2e }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->e3e }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->e4e }}
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            Porcentaje:
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            <b>{{ $presupuesto->e1m > 0 ? ($presupuesto->e1e / $presupuesto->e1m) * 100 : '' }} %</b>
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            <b>{{ $presupuesto->e2m > 0 ? ($presupuesto->e2e / $presupuesto->e2m) * 100 : '' }} %</b>
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            <b>{{ $presupuesto->e3m > 0 ? ($presupuesto->e3e / $presupuesto->e3m) * 100 : '' }} %</b>
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            <b>{{ $presupuesto->e4m > 0 ? ($presupuesto->e4e / $presupuesto->e4m) * 100 : '' }} %</b>
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="5">
                            Municipal
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            Presupuesto
                        </td>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            enero-marzo
                        </td>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            abril-junio
                        </td>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            julio-septiembre
                        </td>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            octubre-diciembre
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            Modificado:
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->m1m }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->m2m }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->m3m }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->m4m }}
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            Ejercido:
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->m1e }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->m2e }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->m3e }}
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            {{ $presupuesto->m4e }}
                        </td>
                    </tr>
                    <tr>
                        <td class="sombreado" style="text-align: center;" colspan="1">
                            Porcentaje:
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            <b>{{ $presupuesto->m1m > 0 ? number_format(($presupuesto->m1e / $presupuesto->m1m) * 100, 2) : '' }}
                                %</b>
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            <b>{{ $presupuesto->m2m > 0 ? number_format(($presupuesto->m2e / $presupuesto->m2m) * 100, 2) : '' }}
                                %</b>
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            <b>{{ $presupuesto->m3m > 0 ? number_format(($presupuesto->m3e / $presupuesto->m3m) * 100, 2) : '' }}
                                %</b>
                        </td>
                        <td class="value" style="text-align: center;" colspan="1">
                            <b>{{ $presupuesto->m4m > 0 ? numer_format(($presupuesto->m4e / $presupuesto->m4m) * 100, 2) : '' }}
                                %</b>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="5">
                    4. Bienes o servicios que se entregan
                </td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1">Descripción del bien o servicio:</td>
                <td class="value" align="justify" colspan="2">{{ $ppa->descripcion_bs }}</td>
                <td class=" sombreado" style="" colspan="1">Unidad de medida:</td>
                <td class="value" align="justify" colspan="1">{{ $ppa->unidad_bs }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1" align="center">Cantidad</td>
                <td class=" sombreado" style="" colspan="1" align="center">enero-marzo</td>
                <td class=" sombreado" style="" colspan="1" align="center">abril-junio</td>
                <td class=" sombreado" style="" colspan="1" align="center">julio-septiembre</td>
                <td class=" sombreado" style="" colspan="1" align="center">octubre-diciembre</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1" align="center">Programada:</td>
                <td class=" value" style="" colspan="1" align="center">{{ $ppa->bs1p }}</td>
                <td class=" value" style="" colspan="1" align="center">{{ $ppa->bs2p }}</td>
                <td class=" value" style="" colspan="1" align="center">{{ $ppa->bs3p }}</td>
                <td class=" value" style="" colspan="1" align="center">{{ $ppa->bs4p }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1" align="center">Realizada:</td>
                <td class=" value" style="" colspan="1" align="center">{{ $ppa->bs1r }}</td>
                <td class=" value" style="" colspan="1" align="center">{{ $ppa->bs2r }}</td>
                <td class=" value" style="" colspan="1" align="center">{{ $ppa->bs3r }}</td>
                <td class=" value" style="" colspan="1" align="center">{{ $ppa->bs4r }}</td>
            </tr>
            <tr>
                <td class=" sombreado" style="" colspan="1" align="center">Avance:</td>
                <td class=" value" style="" colspan="1" align="center">
                    <b>{{ $ppa->bs1r > 0 ? ($ppa->bs1r / $ppa->bs1p) * 100 : '' }}%</b></td>
                <td class=" value" style="" colspan="1" align="center">
                    <b>{{ $ppa->bs2r > 0 ? ($ppa->bs2r / $ppa->bs2p) * 100 : '' }}%</b></td>
                <td class=" value" style="" colspan="1" align="center">
                    <b>{{ $ppa->bs3r > 0 ? ($ppa->bs3r / $ppa->bs3p) * 100 : '' }}%</b></td>
                <td class=" value" style="" colspan="1" align="center">
                    <b>{{ $ppa->bs4r > 0 ? ($ppa->bs4r / $ppa->bs4p) * 100 : '' }}%</b></td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="9">
                    5. Población beneficiaria
                </td>
            </tr>
            <tr>
                <td class="sombreado" colspan="1">Tipo de población:</td>
                <td class="value" colspan="3">{{ $ppa->descripcion }}</td>
                <td class="sombreado" colspan="2">Descripción de la población beneficiaría:</td>
                <td class="value" colspan="3">{{ $ppa->descripcion_pb }}</td>
            </tr>
            <tr>
                <td class="sombreado" colspan="2">Población objetivo:</td>
                <td class="value" colspan="3"><b>{{ $ppa->po }}</b></td>
                <td class="sombreado" colspan="1">Mujeres:</td>
                <td class="value" colspan="1">{{ $ppa->po_m }}</td>
                <td class="sombreado" colspan="1">Hombres:</td>
                <td class="value" colspan="1">{{ $ppa->po_h }}</td>
            </tr>
            <tr>
                <td class="sombreado" colspan="1" align="center" rowspan="4">Población beneficiada por
                    trimestre:</td>
                <td class="sombreado" colspan="2" align="center">enero-marzo</td>
                <td class="sombreado" colspan="2" align="center">abril-junio</td>
                <td class="sombreado" colspan="2" align="center">julio-septiembre</td>
                <td class="sombreado" colspan="2" align="center">octubre-diciembre</td>
            </tr>
            <tr>
                <td class="value" colspan="2" align="center"><b>{{ $ppa->pb1_t }}</b></td>
                <td class="value" colspan="2" align="center"><b>{{ $ppa->pb2_t }}</b></td>
                <td class="value" colspan="2" align="center"><b>{{ $ppa->pb3_t }}</b></td>
                <td class="value" colspan="2" align="center"><b>{{ $ppa->pb4_t }}</b></td>
            </tr>
            <tr>
                <td class="sombreado" colspan="1" align="center">Mujeres</td>
                <td class="sombreado" colspan="1" align="center">Hombres</td>
                <td class="sombreado" colspan="1" align="center">Mujeres</td>
                <td class="sombreado" colspan="1" align="center">Hombres</td>
                <td class="sombreado" colspan="1" align="center">Mujeres</td>
                <td class="sombreado" colspan="1" align="center">Hombres</td>
                <td class="sombreado" colspan="1" align="center">Mujeres</td>
                <td class="sombreado" colspan="1" align="center">Hombres</td>
            </tr>
            <tr>
                <td class="value" colspan="1" align="center">{{ $ppa->pb1_m }}</td>
                <td class="value" colspan="1" align="center">{{ $ppa->pb1_h }}</td>
                <td class="value" colspan="1" align="center">{{ $ppa->pb2_m }}</td>
                <td class="value" colspan="1" align="center">{{ $ppa->pb2_h }}</td>
                <td class="value" colspan="1" align="center">{{ $ppa->pb3_m }}</td>
                <td class="value" colspan="1" align="center">{{ $ppa->pb3_h }}</td>
                <td class="value" colspan="1" align="center">{{ $ppa->pb4_m }}</td>
                <td class="value" colspan="1" align="center">{{ $ppa->pb4_h }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="8">
                    6. Distribución territorial / área geográfica atendida
                </td>
            </tr>
            @if ($regiones->count() > 0)
                @foreach ($regiones as $region)
                    <tr>
                        <td class="sombreado" rowspan="2" colspan="2">Región atendida en el periodo que se
                            reporta</td>
                        <td class="value" colspan="8" align="center" style="line-height: 20px;font-size:10pt;">
                            <b>{{ $region->nombre }}</b></td>
                    </tr>
                    <tr>
                        <td class="sombreado">Total:</td>
                        <td class="value" align="center"><b>{{ $region->tp }}</b></td>
                        <td class="sombreado">Mujeres:</td>
                        <td class="value" align="center">{{ $region->tpm }}</td>
                        <td class="sombreado">Hombres:</td>
                        <td class="value" align="center">{{ $region->tph }}</td>
                    </tr>
                    <tr>
                        <td class="sombreado" colspan="2" align="center">Municipios atendidos:</td>
                        <td class="value" colspan="6" align="center" style="line-height: 20px;">
                            <br /><b>{{ $region->num_mun }}</b></td>
                    </tr>
                @endforeach
            @endif
        </table>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="6">
                    7. Impacto
                </td>
            </tr>
            <tr>
                <td class="sombreado">Impacto social</td>
                <td class="value">{{ $ppa->im_s }}</td>
                <td class="sombreado">Impacto económico</td>
                <td class="value">{{ $ppa->im_e }}</td>
                <td class="sombreado">Impacto ambiental</td>
                <td class="value">{{ $ppa->im_a }}</td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="3">
                    8. Medios de verificación
                </td>
            </tr>
            <tr>
                <td class="sombreado" style="width: 10%;">Tipo</td>
                <td class="sombreado" style="width: 35%;">Nombre</td>
                <td class="sombreado" style="width: 35%;">Descripción</td>
                <td class="sombreado" style="width: 20%;">Fecha de carga</td>
            </tr>
            @if ($medios->count() > 0)
                @foreach ($medios as $medio)
                    <tr>
                        <td class="value" align="center">{{ $medio->tipo }}</td>
                        <td class="value"><a target="_blank"
                                href="{{ asset('medios') . '/itar/' . $ppa->id . '/' . $medio->ubicacion }}">{{ $medio->nombre }}</a>
                        </td>
                        <td class="value">{{ $medio->descripcion }}</td>
                        <td class="value">{{ $medio->updated_at }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="value" align="center" colspan="3">No existen medio cargados actualmente!</td>
                </tr>
            @endif
        </table>
        <table style="width:100%">
            <tr>
                <td class="field" style="text-align: center;" colspan="3">
                    9. Difusión e Interacción con la ciudadanía
                </td>
            </tr>
            <tr>
                <td class="sombreado" align="center">Sitio oficial</td>
                <td class="sombreado" align="center">Redes Sociales</td>
                <td class="sombreado" align="center">Buzón Digital</td>
            </tr>
            <tr>
                <td class="value" align="center">
                    @php
                        $cadena_paginas = $ppa->p_o;
                    @endphp
                    @if(Str::length($cadena_paginas) > 0)
                    <table style="width: 100%;" id="table_po" style="font-size: .8em" border="1">
                        <thead>
                            <tr style="text-align: center">
                                <th class="sombreado" align="center">Link</th>
                                <th class="sombreado" align="center">Alcance</th>
                            </tr>
                        </thead>
                        <tbody>
                    @php
                            $array_p = explode(';', $cadena_paginas);
                            array_pop($array_p);
                            if (count($array_p) > 0) {
                                foreach ($array_p as $vals) {
                                    $array_vals = explode('|', $vals);
                                    $row =
                                        '<tr>' .
                                        '<td style="text-align: left" class="link_po">' .
                                        $array_vals[0] .
                                        '</td>' .
                                        '<td style="text-align: center" class="alcance_po">' .
                                        $array_vals[1] .
                                        '</td>' .
                                        '</tr>';
                                    echo $row;
                                }
                            }
                    @endphp
                        </tbody>
                    </table>
                    @endif
                </td>
                <td class="value">
                    @php
                        $cadena_paginas = $ppa->r_s;
                    @endphp
                    @if(Str::length($cadena_paginas) > 0)
                    <table style="width: 100%;" id="table_po" style="font-size: .8em" border="1">

                            <tr style="text-align: center">
                                <th class="sombreado" align="center">Red</th>
                                <th class="sombreado" align="center">Alcance</th>
                            </tr>

                    @php
                            $array_p = explode(';', $cadena_paginas);
                            array_pop($array_p);
                            if (count($array_p) > 0) {
                                foreach ($array_p as $vals) {
                                    $array_vals = explode('|', $vals);
                                    $row =
                                        '<tr>' .
                                        '<td style="text-align: left" class="link_po">' .
                                        $array_vals[0] .
                                        '</td>' .
                                        '<td style="text-align: center" class="alcance_po">' .
                                        $array_vals[1] .
                                        '</td>' .
                                        '</tr>';
                                    echo $row;
                                }
                            }
                    @endphp

                    </table>
                    @endif
                </td>
                <td class="value">
                    @php
                        $cadena_paginas = $ppa->b_d;
                    @endphp
                    @if(Str::length($cadena_paginas) > 0)
                    <table style="width: 100%;" id="table_po" style="font-size: .8em" border="1">
                        <thead>
                            <tr style="text-align: center">
                                <th class="sombreado" align="center">Correo</th>
                                <th class="sombreado" align="center">Alcance</th>
                            </tr>
                        </thead>
                        <tbody>
                    @php
                            $array_p = explode(';', $cadena_paginas);
                            array_pop($array_p);
                            if (count($array_p) > 0) {
                                foreach ($array_p as $vals) {
                                    $array_vals = explode('|', $vals);
                                    $row =
                                        '<tr>' .
                                        '<td style="text-align: left" class="link_po">' .
                                        $array_vals[0] .
                                        '</td>' .
                                        '<td style="text-align: center" class="alcance_po">' .
                                        $array_vals[1] .
                                        '</td>' .
                                        '</tr>';
                                    echo $row;
                                }
                            }
                    @endphp
                        </tbody>
                    </table>
                    @endif

                </td>
            </tr>
            <tr>
                <td class="sombreado" align="center">Atención telefónica</td>
                <td class="sombreado" align="center">Atención personal</td>
                <td class="sombreado" align="center">Otro medio</td>
            </tr>
            <tr>
                <td class="value" align="center">
                    @php
                        $cadena_paginas = $ppa->a_t;
                    @endphp
                    @if(Str::length($cadena_paginas) > 0)
                    <table style="width: 100%;" id="table_po" style="font-size: .8em" border="1">
                        <thead>
                            <tr style="text-align: center">
                                <th class="sombreado" align="center">Teléfono</th>
                                <th class="sombreado" align="center">Alcance</th>
                            </tr>
                        </thead>
                        <tbody>
                    @php
                            $array_p = explode(';', $cadena_paginas);
                            array_pop($array_p);
                            if (count($array_p) > 0) {
                                foreach ($array_p as $vals) {
                                    $array_vals = explode('|', $vals);
                                    $row =
                                        '<tr>' .
                                        '<td style="text-align: left" class="link_po">' .
                                        $array_vals[0] .
                                        '</td>' .
                                        '<td style="text-align: center" class="alcance_po">' .
                                        $array_vals[1] .
                                        '</td>' .
                                        '</tr>';
                                    echo $row;
                                }
                            }
                    @endphp
                        </tbody>
                    </table>
                    @endif
                </td>
                <td class="value">
                    @php
                        $cadena_paginas = $ppa->a_p;
                    @endphp
                    @if(Str::length($cadena_paginas) > 0)
                    <table style="width: 100%;" id="table_po" style="font-size: .8em" border="1">

                            <tr style="text-align: center">
                                <th class="sombreado" align="center">Oficina</th>
                                <th class="sombreado" align="center">Alcance</th>
                            </tr>

                    @php
                            $array_p = explode(';', $cadena_paginas);
                            array_pop($array_p);
                            if (count($array_p) > 0) {
                                foreach ($array_p as $vals) {
                                    $array_vals = explode('|', $vals);
                                    $row =
                                        '<tr>' .
                                        '<td style="text-align: left" class="link_po">' .
                                        $array_vals[0] .
                                        '</td>' .
                                        '<td style="text-align: center" class="alcance_po">' .
                                        $array_vals[1] .
                                        '</td>' .
                                        '</tr>';
                                    echo $row;
                                }
                            }
                    @endphp

                    </table>
                    @endif
                </td>
                <td class="value">
                    @php
                        $cadena_paginas = $ppa->otro;
                    @endphp
                    @if(Str::length($cadena_paginas) > 0)
                    <table style="width: 100%;" id="table_po" style="font-size: .8em" border="1">
                        <thead>
                            <tr style="text-align: center">
                                <th class="sombreado" align="center">Otro</th>
                                <th class="sombreado" align="center">Alcance</th>
                            </tr>
                        </thead>
                        <tbody>
                    @php
                            $array_p = explode(';', $cadena_paginas);
                            array_pop($array_p);
                            if (count($array_p) > 0) {
                                foreach ($array_p as $vals) {
                                    $array_vals = explode('|', $vals);
                                    $row =
                                        '<tr>' .
                                        '<td style="text-align: left" class="link_po">' .
                                        $array_vals[0] .
                                        '</td>' .
                                        '<td style="text-align: center" class="alcance_po">' .
                                        $array_vals[1] .
                                        '</td>' .
                                        '</tr>';
                                    echo $row;
                                }
                            }
                    @endphp
                        </tbody>
                    </table>
                    @endif

                </td>
            </tr>
        </table>
        <table style="width:100%">
            <tr>
                <td class="field" colspan="4" style="text-align:center"> 10. Datos de los Responsables de la
                    Información</td>
            </tr>
           <!-- <tr>
                <td class="sombreado" colspan="1"> Dependencia: </td>
                <td class="text" colspan="3"><span style="font-weight:normal">
                        {{ $dependencia->dependenciaNombre . ' (' . $dependencia->dependenciaSiglas . ')' }}</span>
                </td>
            </tr>-->
            <tr>
                <td class="sombreado" style="" colspan="2">Titular de la Dependencia</td>
                <td class="sombreado" style="" colspan="2">Enlace Institucional</td>
            </tr>
            <tr>
                <td class="sombreado" style="width:15%">Nombre:</td>
                <td class="text" style="width:35%">{{ $titular == null ? '' : $titular->nombre }}</td>
                <td class="sombreado" style="width:15%">Nombre:</td>
                <td class="text" style="width:35%">
                    {{ $enlace == null ? '' : $enlace->titulo . ' ' . $enlace->nombre . ' ' . $enlace->apellidoP . ' ' . $enlace->apellidoM }}
                </td>
            </tr>
            <tr>
                <td class="sombreado" style="width:15%">Cargo:</td>
                <td class="text" style="width:35%">{{ $titular == null ? '' : $titular->cargo }}</td>
                <td class="sombreado" style="width:15%">Cargo:</td>
                <td class="text" style="width:35%">{{ $enlace == null ? '' : $enlace->cargo }}</td>
            </tr>
            <tr>
                <td class="sombreado" style="width:15%">Firma:</td>
                <td class="text" style="width:35%;height:50px;"></td>
                <td class="sombreado" style="width:15%">Firma:</td>
                <td class="text" style="width:35%;height:70px;"></td>
            </tr>
        </table>
    </div>
</div>

<style>
    .field {
        background-color: #681b2e;

        color: white;
        text-align: left;
        border: solid 1px gray;
        height: 20px;
        font-weight: bold;
        font-size: 1em;
    }

    .value {
        text-align: left;
        border: dashed 1px gray;
        height: 20px;
        vertical-align: middle;
        font-size: .8em;
    }


    .text {
        text-align: left;
        border: dashed 1px gray;
        height: 20px;
        vertical-align: middle;
        font-size: .8em;
    }

    .valuee {
        text-align: left;
        height: 20px;
        border-right: dashed 1px gray;
        vertical-align: middle;
        font-size: .8em;

    }

    .textt {
        text-align: left;
        height: 20px;
        border-left: dashed 1px gray;
        vertical-align: middle;
        font-size: .8em;
    }

    table tr th {
        text-align: center;
        color: black;

    }

    .label {
        color: black;
        font-weight: bold;
        padding: 5px;
    }

    .valor {
        border-bottom: dashed 1px rgb(218, 218, 218);
        font-size: 1.1em;

    }

    .sombreado {
        background-color: rgb(218, 218, 218);
        font-size: .8em;
        border: solid 1px black;
        height: 18px;
        align-items: center;
        line-height: 15px;
        color: #5c5c5c;
    }
</style>
