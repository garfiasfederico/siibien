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

    #modalCrema .btn-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        font-size: 1.1rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, .1);
    }

    #modalCrema .btn-icon i {
        pointer-events: none;
    }

    /* Lectura */
    #modalComentariosList .list-group-item {
        border: 1px solid #eee;
    }

    #modalComentariosList .meta {
        font-size: .85rem;
        color: #6b6b6b;
    }
</style>
@php
    $esAdmin = Auth::user()->hasRole('administrador');
@endphp


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

                    <div id="cremaLoader" class="text-center my-5" style="display:none;">
                        <div class="spinner-border text-danger mb-3" role="status" aria-hidden="true"></div>
                        <div class="small text-muted">Cargando...</div>
                    </div>
                    <div id="cremaBodyContent">
                        <!-- Intro -->
                        <div class="mb-3">
                            <p class="mb-1 text-dark fw-bold" style="font-size:1.15rem;">
                                Evalúe si el indicador cumple con los criterios:
                            </p>
                            <div class="text-secondary" style="font-size:1rem; font-weight:500;">
                                Claro, Relevante, Económico, Monitoreable, Adecuado y Aporte Marginal.
                            </div>
                        </div>

                        <!-- Criterios en filas (card izq + acciones der) -->
                        <div class="row">
                            <div class="col-12">

                                <!-- Claro -->
                                <div class="row align-items-start mb-3">
                                    <!-- IZQ: card -->
                                    <div class="col-md-10">
                                        <div class="crema-card">
                                            <div class="crema-card-head">
                                                <div class="crema-title">Claro (C)</div>
                                                <div>
                                                    <input type="hidden" name="crema[claro]" value="0">
                                                    <input type="checkbox" id="c_claro" name="crema[claro]"
                                                        value="1" data-toggle="toggle" data-on="Cumple"
                                                        data-off="No cumple" data-onstyle="success"
                                                        data-offstyle="secondary" data-width="120"
                                                        {{ !empty($cremaPrev['claro']) && $cremaPrev['claro'] == 1 ? 'checked' : '' }}
                                                        {{ $esAdmin ? '' : 'data-solo-lectura=true' }}>
                                                </div>
                                            </div>
                                            <div class="crema-desc">Definición comprensible, sin ambigüedad.</div>
                                        </div>
                                    </div>
                                    <!-- DER: iconos -->
                                    <div class="col-md-1 d-flex flex-column align-items-center card-actions"
                                        data-criterio="claro">
                                        <button type="button" class="btn btn-info btn-icon mb-2"
                                            data-action="ver-comentarios"
                                            onclick="abrirModalVerComentarios('claro', $('#cremaIndicadorId').val())">
                                            <i class="fas fa-comments"></i>
                                        </button>
                                        @if ($esAdmin)
                                            <button type="button" class="btn btn-success btn-icon"
                                                onclick="abrirModalAgregarComentario('claro', $('#cremaIndicadorId').val())">
                                                <i class="fas fa-comment-medical"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Relevante -->
                                <div class="row align-items-start mb-3">
                                    <div class="col-md-10">
                                        <div class="crema-card">
                                            <div class="crema-card-head">
                                                <div class="crema-title">Relevante (R)</div>
                                                <div>
                                                    <input type="hidden" name="crema[relevante]" value="0">
                                                    <input type="checkbox" id="c_relevante" name="crema[relevante]"
                                                        value="1" data-toggle="toggle" data-on="Cumple"
                                                        data-off="No cumple" data-onstyle="success"
                                                        data-offstyle="secondary" data-width="120"
                                                        {{ !empty($cremaPrev['relevante']) && $cremaPrev['relevante'] == 1 ? 'checked' : '' }}
                                                        {{ $esAdmin ? '' : 'data-solo-lectura=true' }}>
                                                </div>
                                            </div>
                                            <div class="crema-desc">Aporta al objetivo/resultado clave.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 d-flex flex-column align-items-center card-actions"
                                        data-criterio="relevante">
                                        <button type="button" class="btn btn-info btn-icon mb-2"
                                            data-action="ver-comentarios"
                                            onclick="abrirModalVerComentarios('relevante', $('#cremaIndicadorId').val())">
                                            <i class="fas fa-comments"></i>
                                        </button>
                                        @if ($esAdmin)
                                            <button type="button" class="btn btn-success btn-icon"
                                                onclick="abrirModalAgregarComentario('relevante', $('#cremaIndicadorId').val())">
                                                <i class="fas fa-comment-medical"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Económico -->
                                <div class="row align-items-start mb-3">
                                    <div class="col-md-10">
                                        <div class="crema-card">
                                            <div class="crema-card-head">
                                                <div class="crema-title">Económico (E)</div>
                                                <div>
                                                    <input type="hidden" name="crema[economico]" value="0">
                                                    <input type="checkbox" id="c_economico" name="crema[economico]"
                                                        value="1" data-toggle="toggle" data-on="Cumple"
                                                        data-off="No cumple" data-onstyle="success"
                                                        data-offstyle="secondary" data-width="120"
                                                        {{ !empty($cremaPrev['economico']) && $cremaPrev['economico'] == 1 ? 'checked' : '' }}
                                                        {{ $esAdmin ? '' : 'data-solo-lectura=true' }}>
                                                </div>
                                            </div>
                                            <div class="crema-desc">Costo razonable de medición/seguimiento.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 d-flex flex-column align-items-center card-actions"
                                        data-criterio="economico">
                                        <button type="button" class="btn btn-info btn-icon mb-2"
                                            data-action="ver-comentarios"
                                            onclick="abrirModalVerComentarios('economico', $('#cremaIndicadorId').val())">
                                            <i class="fas fa-comments"></i>
                                        </button>

                                        @if ($esAdmin)
                                            <button type="button" class="btn btn-success btn-icon"
                                                onclick="abrirModalAgregarComentario('economico', $('#cremaIndicadorId').val())">
                                                <i class="fas fa-comment-medical"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Monitoreable -->
                                <div class="row align-items-start mb-3">
                                    <div class="col-md-10">
                                        <div class="crema-card">
                                            <div class="crema-card-head">
                                                <div class="crema-title">Monitoreable (M)</div>
                                                <div>
                                                    <input type="hidden" name="crema[monitoreable]" value="0">
                                                    <input type="checkbox" id="c_monitoreable"
                                                        name="crema[monitoreable]" value="1"
                                                        data-toggle="toggle" data-on="Cumple" data-off="No cumple"
                                                        data-onstyle="success" data-offstyle="secondary"
                                                        data-width="120"
                                                        {{ !empty($cremaPrev['monitoreable']) && $cremaPrev['monitoreable'] == 1 ? 'checked' : '' }}
                                                        {{ $esAdmin ? '' : 'data-solo-lectura=true' }}>
                                                </div>
                                            </div>
                                            <div class="crema-desc">Datos disponibles, trazables y con periodicidad.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 d-flex flex-column align-items-center card-actions"
                                        data-criterio="monitoreable">
                                        <button type="button" class="btn btn-info btn-icon mb-2"
                                            data-action="ver-comentarios"
                                            onclick="abrirModalVerComentarios('monitoreable', $('#cremaIndicadorId').val())">
                                            <i class="fas fa-comments"></i>
                                        </button>
                                        @if ($esAdmin)
                                            <button type="button" class="btn btn-success btn-icon"
                                                onclick="abrirModalAgregarComentario('monitoreable', $('#cremaIndicadorId').val())">
                                                <i class="fas fa-comment-medical"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Adecuado -->
                                <div class="row align-items-start mb-3">
                                    <div class="col-md-10">
                                        <div class="crema-card">
                                            <div class="crema-card-head">
                                                <div class="crema-title">Adecuado (A)</div>
                                                <div>
                                                    <input type="hidden" name="crema[adecuado]" value="0">
                                                    <input type="checkbox" id="c_adecuado" name="crema[adecuado]"
                                                        value="1" data-toggle="toggle" data-on="Cumple"
                                                        data-off="No cumple" data-onstyle="success"
                                                        data-offstyle="secondary" data-width="120"
                                                        {{ !empty($cremaPrev['adecuado']) && $cremaPrev['adecuado'] == 1 ? 'checked' : '' }}
                                                        {{ $esAdmin ? '' : 'data-solo-lectura=true' }}>
                                                </div>
                                            </div>
                                            <div class="crema-desc">Coherente con la dimensión y el tipo de indicador.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 d-flex flex-column align-items-center card-actions"
                                        data-criterio="adecuado">
                                        <button type="button" class="btn btn-info btn-icon mb-2"
                                            data-action="ver-comentarios"
                                            onclick="abrirModalVerComentarios('adecuado', $('#cremaIndicadorId').val())">
                                            <i class="fas fa-comments"></i>
                                        </button>
                                        @if ($esAdmin)
                                            <button type="button" class="btn btn-success btn-icon"
                                                onclick="abrirModalAgregarComentario('adecuado', $('#cremaIndicadorId').val())">
                                                <i class="fas fa-comment-medical"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Aporte Marginal -->
                                <div class="row align-items-start mb-3">
                                    <div class="col-md-10">
                                        <div class="crema-card">
                                            <div class="crema-card-head">
                                                <div class="crema-title">Aporte Marginal (A)</div>
                                                <div>
                                                    <input type="hidden" name="crema[aporteMarginal]"
                                                        value="0">
                                                    <input type="checkbox" id="c_aporteMarginal"
                                                        name="crema[aporteMarginal]" value="1"
                                                        data-toggle="toggle" data-on="Cumple" data-off="No cumple"
                                                        data-onstyle="success" data-offstyle="secondary"
                                                        data-width="120"
                                                        {{ !empty($cremaPrev['aporteMarginal']) && $cremaPrev['aporteMarginal'] == 1 ? 'checked' : '' }}
                                                        {{ $esAdmin ? '' : 'data-solo-lectura=true' }}>
                                                </div>
                                            </div>
                                            <div class="crema-desc">Contribuye de manera incremental al logro del
                                                objetivo.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 d-flex flex-column align-items-center card-actions"
                                        data-criterio="aporteMarginal">
                                        <button type="button" class="btn btn-info btn-icon mb-2"
                                            data-action="ver-comentarios"
                                            onclick="abrirModalVerComentarios('aporteMarginal', $('#cremaIndicadorId').val())">
                                            <i class="fas fa-comments"></i>
                                        </button>
                                        @if ($esAdmin)
                                            <button type="button" class="btn btn-success btn-icon"
                                                onclick="abrirModalAgregarComentario('aporteMarginal', $('#cremaIndicadorId').val())">
                                                <i class="fas fa-comment-medical"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    @if (Auth::user()->hasRole('administrador'))
                        <button type="button" id="btnGuardarCrema" class="btn btn-success"
                            onclick="guardarCrema()">
                            <i class="fas fa-save"></i> Guardar validación
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>



<div class="modal fade" id="modalComentarioAdd" tabindex="-1" aria-labelledby="modalComentarioAddLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <form id="formComentarioAdd" method="POST" action="javascript:void(0);"> <!-- evita submit real -->
            @csrf

            <input type="hidden" name="idIndicador" id="comentarioIndicadorId">
            <input type="hidden" name="criterio" id="comentarioCriterioKey">
            <input type="hidden" name="idComentario" id="comentarioId">

            <div class="modal-content shadow-lg">
                <div class="modal-header" style="background-color:#681b2e; color:#fff;">
                    <h5 class="modal-title" id="modalComentarioAddLabel" style="font-size:1.25rem; font-weight:600;">
                        <i class="fas fa-comment-medical mr-2"></i>
                        <span id="comentarioModalTitulo">Agregar comentario</span> —
                        <span id="comentarioCriterioNombre"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"
                        style="color:#fff;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div id="comentarioLoader" class="text-center my-5" style="display:none;">
                        <div class="spinner-border text-danger mb-3" role="status"></div>
                        <p class="text-muted mb-0">Cargando comentario...</p>
                    </div>

                    <div id="comentarioFormContent" style="display:none;">
                        <div class="form-group mb-2 d-flex justify-content-between align-items-center">
                            <label class="font-weight-bold mb-1 mb-0">Comentario</label>
                            <button type="button" id="btnEliminarComentario" class="btn btn-outline-danger btn-sm"
                                style="display:none" onclick="eliminarComentarioDesdeEditor()">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>

                        <textarea name="comentario" id="comentarioTexto" class="form-control" rows="5" maxlength="500" required
                            placeholder="Escribe tu comentario..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    {{-- <button type="button" id="btnEliminarComentario" class="btn btn-outline-danger mr-auto" style="display:none"
            onclick="eliminarComentarioDesdeEditor()">
            <i class="fas fa-trash"></i> Eliminar
        </button> --}}
                    <button type="button" id="btnGuardarComentario" class="btn btn-success"
                        onclick="guardarComentarioCrema()">
                        <i class="fas fa-save"></i> Guardar comentario
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalComentariosList" tabindex="-1" aria-labelledby="modalComentariosListLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header" style="background-color:#681b2e; color:#fff;">
                <h5 class="modal-title" id="modalComentariosListLabel" style="font-size:1.25rem; font-weight:600;">
                    <i class="fas fa-comments mr-2"></i> Comentarios — <span id="listaCriterioNombre"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" style="color:#fff;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div id="comentariosLoader" class="text-center my-4" style="display:none;">
                    <div class="spinner-border text-danger" role="status" aria-hidden="true"></div>
                    <div class="small text-muted mt-2">Cargando comentarios...</div>
                </div>

                <div id="comentariosVacios" class="text-center text-muted my-4" style="display:none;">
                    <i class="far fa-comment-dots fa-2x d-block mb-2"></i>
                    Aún no hay comentarios para este criterio.
                </div>

                <div id="comentariosError" class="alert alert-danger d-none" role="alert">
                    Ocurrió un error al cargar los comentarios. Inténtalo de nuevo.
                </div>

                <ul id="comentariosLista" class="list-group"></ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>
    function aplicarClaseChecked($scope) {
        $scope.find('input[type="checkbox"][data-toggle="toggle"]').each(function() {
            const $chk = $(this);
            const $card = $chk.closest('.crema-card');
            $card.toggleClass('is-checked', $chk.prop('checked'));
        });
    }



    function activarCremaToggle() {
        const $modal = $('#modalCrema');

        $modal.off('hidden.bs.modal.crema')
            .on('hidden.bs.modal.crema', function() {
                const $scope = $(this);
                $scope.find('.crema-card').removeClass('is-checked is-readonly');
                $scope.find('input[type="checkbox"][data-toggle="toggle"]')
                    .prop('disabled', false)
                    .off('.crema'); // limpia handlers namespaced
            });

        $modal.off('change.crema', 'input[type="checkbox"][data-toggle="toggle"]')
            .on('change.crema', 'input[type="checkbox"][data-toggle="toggle"]', function() {
                if (window._cremaProgrammatic) return;
                const $chk = $(this);
                $chk.closest('.crema-card').toggleClass('is-checked', $chk.prop('checked'));
            });

        $modal.off('shown.bs.modal.crema')
            .on('shown.bs.modal.crema', function() {
                const $scope = $(this);

                requestAnimationFrame(function() {
                    $scope.find('input[type="checkbox"][data-toggle="toggle"]').each(function() {
                        const $chk = $(this);

                        if (!$chk.data('bs.toggle') && typeof $chk.bootstrapToggle === 'function') {
                            $chk.bootstrapToggle({
                                on: $chk.data('on') || 'Cumple',
                                off: $chk.data('off') || 'No cumple',
                                onstyle: $chk.data('onstyle') || 'success',
                                offstyle: $chk.data('offstyle') || 'secondary',
                                width: $chk.data('width') || 120
                            });
                        }

                        const v = $chk.prop('checked');
                        if ($chk.data('bs.toggle')) {
                            try {
                                $chk.bootstrapToggle(v ? 'on' : 'off', true);
                            } catch (e) {}
                        }
                    });

                    aplicarClaseChecked($scope);

                    $scope.find('input[type="checkbox"][data-toggle="toggle"][data-solo-lectura="true"]')
                        .each(function() {
                            const $chk = $(this);
                            const estadoInicial = $chk.prop('checked');

                            $chk.prop('disabled', true);
                            try {
                                $chk.bootstrapToggle('disable');
                            } catch (e) {}

                            // Bloquea cualquier intento de interacción
                            $chk.off(
                                    'click.crema keydown.crema change.crema mousedown.crema touchstart.crema'
                                    )
                                .on('click.crema keydown.crema change.crema mousedown.crema touchstart.crema',
                                    function(e) {
                                        e.preventDefault();
                                        e.stopImmediatePropagation();
                                        // Restituye estado lógico + UI del plugin
                                        $chk.prop('checked', estadoInicial);
                                        try {
                                            $chk.bootstrapToggle(estadoInicial ? 'on' : 'off', true);
                                        } catch (err) {}
                                        return false;
                                    });

                            $chk.closest('.crema-card').addClass('is-readonly');
                        });
                });
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        activarCremaToggle();
    });




    // Abre el modal para AGREGAR comentario
    function abrirModalAgregarComentario(criterio, idIndicador) {
        const nombres = {
            claro: 'Claro (C)',
            relevante: 'Relevante (R)',
            economico: 'Económico (E)',
            monitoreable: 'Monitoreable (M)',
            adecuado: 'Adecuado (A)',
            aporteMarginal: 'Aporte Marginal (A)'
        };

        $('#comentarioIndicadorId').val(idIndicador);
        $('#comentarioCriterioKey').val(criterio);
        $('#comentarioCriterioNombre').text(nombres[criterio] || criterio);

        $('#comentarioModalTitulo').text('Agregar comentario');
        $('#comentarioTexto').val('');
        $('#comentarioId').val('');
        $('#btnEliminarComentario').hide();

        $('#modalComentarioAdd').modal('show');

        $('#comentarioLoader').show();
        $('#comentarioFormContent').hide();
        $('#comentarioError').remove();

        const url = `{{ route('crema.comentarios.mostrar', ':id') }}`.replace(':id', idIndicador);

        $.get(url, {
                criterio
            })
            .done(function(resp) {
                const lista = resp?.comentarios || [];
                if (lista.length > 0) {
                    const ultimo = lista[0];
                    $('#comentarioId').val(ultimo.idComentario);
                    $('#comentarioTexto').val(ultimo.comentario);
                    $('#comentarioModalTitulo').text('Editar comentario');
                    $('#btnEliminarComentario').show();
                }
            })
            .fail(function() {
                const alerta = `
            <div id="comentarioError" class="alert alert-danger mt-2">
              No se pudo cargar el comentario previo.
            </div>`;
                $('#comentarioFormContent').before(alerta);
            })
            .always(function() {
                $('#comentarioLoader').hide();
                $('#comentarioFormContent').show();
            });
    }

    // Abre el modal para VER comentarios
    function abrirModalVerComentarios(criterio, idIndicador) {
        const nombres = {
            claro: 'Claro (C)',
            relevante: 'Relevante (R)',
            economico: 'Económico (E)',
            monitoreable: 'Monitoreable (M)',
            adecuado: 'Adecuado (A)',
            aporteMarginal: 'Aporte Marginal (A)'
        };

        $('#listaCriterioNombre').text(nombres[criterio] || criterio);

        $('#modalComentariosList').modal('show');
        $('#btnGuardarComentario').prop('disabled', false);


        $('#comentariosLista').empty();
        $('#comentariosLoader').show();
        $('#comentariosVacios').hide();
        $('#comentariosError').addClass('d-none');

        const url = `{{ route('crema.comentarios.mostrar', ':id') }}`.replace(':id', idIndicador);

        $.get(url, {
                criterio
            })
            .done(function(resp) {
                $('#comentariosLoader').hide();

                const lista = resp?.comentarios || [];
                if (lista.length === 0) {
                    $('#comentariosVacios').show();
                    return;
                }
                let html = '';
                lista.forEach(c => {
                    html += `
                <li class="list-group-item">
                    <div style="font-size:1.1rem; font-weight:bold;">
                    ${c.comentario}
                    </div>
                    <small class="text-muted d-block mt-1">
                    Última actualización: ${new Date(c.updated_at).toLocaleString()}
                    </small>
                </li>
                `;
                });
                $('#comentariosLista').html(html);
            })
            .fail(function() {
                $('#comentariosLoader').hide();
                $('#comentariosError').removeClass('d-none');
            });
    }



    function guardarComentarioCrema() {
        const idIndicador = $('#comentarioIndicadorId').val();
        const urlBase = "{{ url('indicadores') }}";
        const url = `${urlBase}/${idIndicador}/crema/comentarios`;

        const token = $('#formComentarioAdd input[name="_token"]').val();

        const payload = {
            _token: token,
            idComentario: $('#comentarioId').val() || null,
            criterio: $('#comentarioCriterioKey').val(),
            comentario: $('#comentarioTexto').val()
        };

        const $btn = $('#btnGuardarComentario');
        $btn.prop('disabled', true);

        $.ajax({
                url,
                method: 'POST',
                data: payload,
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                dataType: 'json'
            })
            .done(function(resp) {
                const criterio = $('#comentarioCriterioKey').val();
                $('#modalComentarioAdd')
                    .one('hidden.bs.modal', function() {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: resp?.message || 'Comentario guardado correctamente.',
                            confirmButtonColor: '#28a745'
                        });

                        setTimeout(function() {
                            try {
                                const $btnVer = $(
                                    `.card-actions[data-criterio="${criterio}"] [data-action="ver-comentarios"]`
                                    );
                                actualizarEstadoBotonComentario(idIndicador, criterio, $btnVer);

                                if ($('#modalComentariosList').hasClass('show')) {
                                    abrirModalVerComentarios(criterio, idIndicador);
                                }
                            } catch (e) {
                                console.error('Post-guardado: error refrescando UI', e);
                            }
                        }, 0);
                    })
                    .modal('hide');

                // Limpieza de campos (no afecta al hidden del criterio)
                $('#comentarioTexto').val('');
                $('#comentarioId').val('');
                $('#btnEliminarComentario').hide();
            })
            .fail(function(xhr) {
                const msg = xhr.responseJSON?.message || 'Error al guardar comentario.';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg,
                    confirmButtonColor: '#dc3545'
                });
            })
            .always(function() {
                $btn.prop('disabled', false);
            });
    }


    function eliminarComentarioDesdeEditor() {
        const idComentario = $('#comentarioId').val();
        if (!idComentario) return;

        const idIndicador = $('#comentarioIndicadorId').val();
        const criterioKey = $('#comentarioCriterioKey').val();
        const urlBase = "{{ url('indicadores') }}";
        const url = `${urlBase}/${idIndicador}/crema/comentarios/${idComentario}`;
        const token = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();

        Swal.fire({
            title: '¿Eliminar comentario?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc3545'
        }).then((result) => {
            if (!result.isConfirmed) return;

            $.ajax({
                    url,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .done(function(resp) {
                    $('#comentarioTexto').val('');
                    $('#comentarioId').val('');
                    $('#btnEliminarComentario').hide();
                    $('#modalComentarioAdd').modal('hide');
                    const $btnVer = $(
                        `.card-actions[data-criterio="${criterioKey}"] [data-action="ver-comentarios"]`);
                    actualizarEstadoBotonComentario(idIndicador, criterioKey, $btnVer);

                    if ($('#modalComentariosList').hasClass('show')) {
                        abrirModalVerComentarios(criterioKey, idIndicador);
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Eliminado',
                        text: resp.message || 'Comentario eliminado correctamente.',
                        confirmButtonColor: '#28a745'
                    });

                    if ($('#modalComentariosList').hasClass('show')) {
                        abrirModalVerComentarios(criterioKey, idIndicador);
                    }
                })
                .fail(function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Error al eliminar el comentario.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: msg,
                        confirmButtonColor: '#dc3545'
                    });
                });
        });
    }
</script>
