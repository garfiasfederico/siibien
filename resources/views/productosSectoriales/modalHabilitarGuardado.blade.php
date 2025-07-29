<!-- Modal Habilitar Secciones y Guardado -->
<div class="modal fade" id="modalGuardado" tabindex="-1" role="dialog" aria-labelledby="modalGuardadoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form id="formGuardado" method="POST" action="{{ route('productossectoriales.habilitarGuardado') }}">
            @csrf
            <input type="hidden" name="idProducto" id="guardadoProductoId">

            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="modalGuardadoLabel">
                        Habilitar o deshabilitar secciones y guardado
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body px-4">

                    <div class="mb-3">
                        <p class="font-weight-bold" style="font-size: 1.1rem;">
                            Seleccione qué secciones o acciones quiere habilitar/deshabilitar:
                        </p>
                    </div>

                    <div class="mb-2 mt-2">
                        <span class="font-weight-bold text-secondary" style="font-size:1rem;">
                            Secciones de <span style="color:#7c2f42">Datos Generales</span>
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="seccion_ped" id="switchPED">
                            <label class="form-check-label font-weight-bold" for="switchPED">
                                Plan Estatal de Desarrollo
                            </label>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="seccion_pes" id="switchPES">
                            <label class="form-check-label font-weight-bold" for="switchPES">
                                Planes Estratégicos Sectoriales y Especiales
                            </label>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="seccion_ppa" id="switchPPA">
                            <label class="form-check-label font-weight-bold" for="switchPPA">
                                Programa, Proyecto o Acción
                            </label>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="seccion_DI" id="switchDI">
                            <label class="form-check-label font-weight-bold" for="switchDI">
                                Datos del Indicador
                            </label>
                        </div>
                    </div>

                    <hr class="mb-3 mt-3">

                    <div class="mb-2">
                        <span class="font-weight-bold text-secondary" style="font-size:1rem;">
                            <i class="fas fa-save"></i> Permitir Guardado en:
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="guardar_generales"
                                id="switchGenerales">
                            <label class="form-check-label font-weight-bold" for="switchGenerales">
                                Botón de <span style="color:#7c2f42">Datos Generales</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="guardar_seguimiento"
                                id="switchSeguimiento">
                            <label class="form-check-label font-weight-bold" for="switchSeguimiento">
                                Botón de <span style="color:#7c2f42">Seguimiento</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="guardarGuardado()">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>