<!-- Input Con campos ocultos-->
<input type="hidden" id="idTemaPED" value="{{ $tema->idTemaPED }}">
<input type="hidden" id="anioInforme" value="2025"><!--Aqui se debe  cambia el año  -->

<div class="modal fade" id="modalRedactarInforme" tabindex="-1" role="dialog" aria-labelledby="modalRedactarLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow">
            <div class="modal-header" style="background-color: #681b2e; color:white">
                <h5 class="modal-title" id="modalRedactarLabel">
                    <i class="fas fa-pen-nib"></i> Redacción del Informe de Gobierno
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Añadimos position: relative para permitir el overlay -->
            <div class="modal-body" style="position: relative;">
                @csrf

                <!--  Tema Actual -->
                <div class="alert alert-secondary mb-4" role="alert">
                    <strong>Tema:</strong>
                    {{ $tema->temaPEDClave }} - {{ $tema->temaPEDDescripcion }}
                </div>

                <!--  Sección de Introducción -->
                <div class="mb-4">
                    <h6><strong>Introducción</strong></h6>
                    <div id="contenedorIntroduccion"></div>
                    <div id="mensajeIntroduccionVacia" class="text-muted" style="display: none;">
                        <em>No se ha redactado ningún párrafo de introducción.</em>
                    </div>
                    <button id="btnAgregarIntroduccion" class="btn btn-outline-primary mt-2"
                        onclick="agregarParrafoConTexto('introduccion')">
                        <i class="fas fa-plus-circle"></i> Agregar Párrafo
                    </button>
                </div>

                <!--  Sección de Conclusión -->
                <div class="mb-4">
                    <h6><strong>Conclusión</strong></h6>
                    <div id="contenedorConclusion"></div>
                    <div id="mensajeConclusionVacia" class="text-muted" style="display: none;">
                        <em>No se ha redactado ningún párrafo de conclusión.</em>
                    </div>
                    <button id="btnAgregarConclusion" class="btn btn-outline-secondary mt-2"
                        onclick="agregarParrafoConTexto('conclusion')">
                        <i class="fas fa-plus-circle"></i> Agregar Párrafo
                    </button>
                </div>


                <!-- Overlay Loader centrado -->
                <div id="loaderOverlay" style="
                    display: none;
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(255,255,255,0.8);
                    z-index: 1000;
                    text-align: center;
                    padding-top: 150px;
                ">
                    <i class="fas fa-spinner fa-spin fa-3x text-danger"></i><br>
                    <span class="text-dark font-weight-bold mt-3 d-block">Procesando...</span>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-success" onclick="guardarInforme()">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Visualizar Informe -->
<div class="modal fade" id="modalVerInforme" tabindex="-1" role="dialog" aria-labelledby="modalVerLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow">

            <!--  Cabecera con estilo del tema -->
            <div class="modal-header text-white" style="background-color: #681b2e;">
                <h5 class="modal-title" id="modalVerLabel">
                    <i class="fas fa-eye"></i> Visualización del Tercer Informe de Gobierno (Introducción y Conclusión)
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!--  Contenido -->
            <div class="modal-body position-relative">

                <!--  Botón de editar (esquina superior derecha) -->
                <div class="text-right mb-3">
                    <button class="btn btn-warning" onclick="abrirModalEdicion()">
                        <i class="fas fa-pen"></i> Editar Introducción y Conclusión
                    </button>
                </div>

                <!--  Información del tema -->
                <div class="alert alert-secondary mb-4" role="alert">
                    <strong>Tema:</strong>
                    {{ $tema->temaPEDClave }} - {{ $tema->temaPEDDescripcion }}
                </div>

                <!--  Sección de Introducción -->
                <div class="mb-4">
                    <h6 class="font-weight-bold text-uppercase text-secondary">
                        <i class="fas fa-paragraph"></i> Introducción
                    </h6>
                    <div id="verIntroduccion" class="text-dark text-justify" style="line-height: 1.6;"></div>
                </div>

                <!--  Sección de Conclusión -->
                <div>
                    <h6 class="font-weight-bold text-uppercase text-secondary">
                        <i class="fas fa-paragraph"></i> Conclusión
                    </h6>
                    <div id="verConclusion" class="text-dark text-justify" style="line-height: 1.6;"></div>
                </div>
            </div>

            <!--  Pie de modal -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
