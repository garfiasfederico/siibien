<div class="modal fade" id="modalDatosGenerales" tabindex="-1" role="dialog" aria-labelledby="modalDatosGeneralesLabel"
    aria-hidden="true" style="color: black !important;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <!-- Encabezado -->
            <div class="modal-header" style="background-color: #681b2e; color:white">
                <h5 class="modal-title" id="modalDatosGeneralesLabel">Datos Generales del PPA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" style="color:white">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row mb-3">

            </div>

            <div class="col-12">
                <h5>
                    Información General del PPA:
                    <span id="dg-id">-</span> – <span id="dg-nombre">-</span>
                </h5>
            </div>
            <!--  Pestañas -->
            <div class="modal-body">
                <div class="container-fluid">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="tabsModal" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="datos-tab" data-toggle="tab" href="#datos" role="tab"
                                aria-controls="datos" aria-selected="true">Datos Generales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="alineacion-tab" data-toggle="tab" href="#alineacion" role="tab"
                                aria-controls="alineacion" aria-selected="false">Alineación</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="presupuesto-tab" data-toggle="tab" href="#presupuesto" role="tab"
                                aria-controls="presupuesto" aria-selected="false">Presupuesto</a>
                        </li>
                    </ul>

                    <!-- Contenido de pestañas -->
                    <div class="tab-content mt-3" id="tabsModalContent">

                        <!-- Pestaña: Datos Generales -->
                        <div class="tab-pane fade show active" id="datos" role="tabpanel" aria-labelledby="datos-tab">

                            <hr>

                            <table class="table table-bordered table-hover table-sm">
                                <tbody>
                                    <tr class="table-secondary font-weight-bold text-center">
                                        <td colspan="2">Programa, Proyecto o Acción</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nombre del PPA</strong></td>
                                        <td><span id="dg-nombreppa">-</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Bienes o servicios</strong></td>
                                        <td><span id="dg-bienes">-</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Objetivo:</strong></td>
                                        <td><span id="dg-objetivoaccion"></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Descripcion</strong>:</td>
                                        <td><span id="dg-descripcion"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pestaña: Alineación -->
                        <div class="tab-pane fade" id="alineacion" role="tabpanel" aria-labelledby="alineacion-tab">
                            <table class="table table-bordered table-hover table-sm">
                                <tbody>
                                    <tr class="table-secondary font-weight-bold text-center">
                                        <td colspan="2">Alineación General</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Eje</strong></td>
                                        <td><span id="dg-eje">-</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tema</strong></td>
                                        <td><span id="dg-tema">-</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Objetivo</strong></td>
                                        <td><span id="dg-objetivo_ped">-</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Estrategias</strong></td>
                                        <td><span id="dg-estrategias">-</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Líneas de Acción</strong></td>
                                        <td><span id="dg-lineas">-</span></td>
                                    </tr>

                                    <tr class="table-secondary font-weight-bold text-center">
                                        <td colspan="2">Sector</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Sector</strong></td>
                                        <td><span id="dg-sector">-</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Objetivo</strong></td>
                                        <td><span id="dg-obj-sector">-</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Estrategias</strong></td>
                                        <td><span id="dg-estrat-sector">-</span></td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                        <!-- Pestaña presupuesto -->
                        <div class="tab-pane fade" id="presupuesto" role="tabpanel" aria-labelledby="presupuesto-tab">
                            <hr>
                            <table class="table table-bordered table-hover table-sm">
                                <thead class="table-secondary text-center">
                                    <tr>
                                        <th colspan="5">Presupuesto</th>
                                    </tr>
                                    <tr>
                                        <th>Bien o servicio</th>
                                        <th>Año</th>
                                        <th>Tipo de gasto</th>
                                        <th>Suma</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="dg-presupuesto-body">

                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>