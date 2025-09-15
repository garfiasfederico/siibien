<style>
    #modalCrema .crema-body {
        font-size: 1rem;
    }

    #modalCrema .crema-card {
        border: 1px solid #e6e6e6;
        border-radius: .5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        background: #fff;
        transition: box-shadow .2s ease, border-color .2s ease;
    }

    #modalCrema .crema-card:hover {
        box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
        border-color: #dedede;
    }

    #modalCrema .crema-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .25rem;
    }

    #modalCrema .crema-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: #2b2b2b;
        border-left: 4px solid #681b2e;
        padding-left: .5rem;
    }

    #modalCrema .crema-desc {
        color: #6b6b6b;
        font-size: .98rem;
    }

    /* Preselecioanrlo */

    #modalCrema .crema-card.is-checked {
        border-color: #28a745;
        box-shadow: 0 8px 22px rgba(40, 167, 69, .18);
        background: rgba(40, 167, 69, .06);
    }

    #modalCrema .crema-card.is-checked .crema-title {
        border-left-color: #28a745;
        color: #215a38;
    }

    #modalCrema .crema-card.is-checked .crema-desc {
        color: #2f6d48;
    }
</style>

<div class="modal fade" id="modalCrema" tabindex="-1" aria-labelledby="modalCremaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form id="formCrema" method="POST" action="">
            @csrf
            <input type="hidden" name="idIndicador" id="cremaIndicadorId">

            <div class="modal-content shadow-lg">
                <div class="modal-header" style="background-color:#681b2e; color:#fff;">
                    <h5 class="modal-title" id="modalCremaLabel" style="font-size:1.35rem; font-weight:600;">
                        <i class="fas fa-clipboard-check mr-2"></i> Validación CREMAA
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" style="color:#fff;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body crema-body">
                    <!-- Intro -->
                    <div class="mb-3">
                        <p class="mb-1 text-dark fw-bold" style="font-size:1.15rem;">
                            Evalúe si el indicador cumple con los criterios:
                        </p>
                        <div class="text-secondary" style="font-size:1rem; font-weight:500;">
                            Claro, Relevante, Económico, Monitoreable, Adecuado y Aporte Marginal.
                        </div>
                    </div>

                    <!-- Criterios en una sola columna -->
                    <div class="row">
                        <div class="col-12">

                            <!-- Claro -->
                            <div class="crema-card">
                                <div class="crema-card-head">
                                    <div class="crema-title">Claro (C)</div>
                                    <div>
                                        <input type="hidden" name="crema[claro]" value="0">
                                        <input type="checkbox" id="c_claro" name="crema[claro]" value="1"
                                            data-toggle="toggle" data-on="Cumple" data-off="No cumple"
                                            data-onstyle="success" data-offstyle="secondary" data-width="120">
                                    </div>
                                </div>
                                <div class="crema-desc">Definición comprensible, sin ambigüedad.</div>
                            </div>

                            <!-- Relevante -->
                            <div class="crema-card">
                                <div class="crema-card-head">
                                    <div class="crema-title">Relevante (R)</div>
                                    <div>
                                        <input type="hidden" name="crema[relevante]" value="0">
                                        <input type="checkbox" id="c_relevante" name="crema[relevante]" value="1"
                                            data-toggle="toggle" data-on="Cumple" data-off="No cumple"
                                            data-onstyle="success" data-offstyle="secondary" data-width="120">
                                    </div>
                                </div>
                                <div class="crema-desc">Aporta al objetivo/resultado clave.</div>
                            </div>

                            <!-- Económico -->
                            <div class="crema-card">
                                <div class="crema-card-head">
                                    <div class="crema-title">Económico (E)</div>
                                    <div>
                                        <input type="hidden" name="crema[economico]" value="0">
                                        <input type="checkbox" id="c_economico" name="crema[economico]" value="1"
                                            data-toggle="toggle" data-on="Cumple" data-off="No cumple"
                                            data-onstyle="success" data-offstyle="secondary" data-width="120">
                                    </div>
                                </div>
                                <div class="crema-desc">Costo razonable de medición/seguimiento.</div>
                            </div>

                            <!-- Monitoreable -->
                            <div class="crema-card">
                                <div class="crema-card-head">
                                    <div class="crema-title">Monitoreable (M)</div>
                                    <div>
                                        <input type="hidden" name="crema[monitoreable]" value="0">
                                        <input type="checkbox" id="c_monitoreable" name="crema[monitoreable]" value="1"
                                            data-toggle="toggle" data-on="Cumple" data-off="No cumple"
                                            data-onstyle="success" data-offstyle="secondary" data-width="120">
                                    </div>
                                </div>
                                <div class="crema-desc">Datos disponibles, trazables y con periodicidad.</div>
                            </div>

                            <!-- Adecuado -->
                            <div class="crema-card">
                                <div class="crema-card-head">
                                    <div class="crema-title">Adecuado (A)</div>
                                    <div>
                                        <input type="hidden" name="crema[adecuado]" value="0">
                                        <input type="checkbox" id="c_adecuado" name="crema[adecuado]" value="1"
                                            data-toggle="toggle" data-on="Cumple" data-off="No cumple"
                                            data-onstyle="success" data-offstyle="secondary" data-width="120">
                                    </div>
                                </div>
                                <div class="crema-desc">Coherente con la dimensión y el tipo de indicador.</div>
                            </div>

                            <!-- Aporte Marginal -->
                            <div class="crema-card">
                                <div class="crema-card-head">
                                    <div class="crema-title">Aporte Marginal (A)</div>
                                    <div>
                                        <input type="hidden" name="crema[aporteMarginal]" value="0">
                                        <input type="checkbox" id="c_aporteMarginal" name="crema[aporteMarginal]" value="1"
                                            data-toggle="toggle" data-on="Cumple" data-off="No cumple"
                                            data-onstyle="success" data-offstyle="secondary" data-width="120">
                                    </div>
                                </div>
                                <div class="crema-desc">Contribuye de manera incremental al logro del objetivo.</div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    @if (Auth::user()->hasRole('administrador'))  
                    <button type="button" id="btnGuardarCrema" class="btn btn-success" onclick="guardarCrema()">
                        <i class="fas fa-save"></i> Guardar validación
                    </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function activarCremaToggle() {
        $('#modalCrema').off('change', 'input[type="checkbox"][data-toggle="toggle"]')
            .on('change', 'input[type="checkbox"][data-toggle="toggle"]', function () {
                const $card = $(this).closest('.crema-card');
                if ($(this).prop('checked')) {
                    $card.addClass('is-checked');
                } else {
                    $card.removeClass('is-checked');
                }
            });
    }


</script>