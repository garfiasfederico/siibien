<!-- Modal para seleccioanr años habilitados -->
<div class="modal fade" id="modalAnios" tabindex="-1" role="dialog" aria-labelledby="modalAniosLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form id="formAniosHabilitados" method="POST" action="{{ route('productos.habilitarAnios') }}">
            @csrf
            <input type="hidden" name="idProducto" id="anioProductoId">

            <div class="modal-content">
                <div class="modal-header" style="background-color: #681b2e; color:white">
                    <h5 class="modal-title" id="modalAniosLabel">
                        “Habilitar y deshabilitar campo de programación por año”
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body px-4">
                    <!-- Selector de todos los años -->
                    <div class="mb-3">
                        <p class="font-weight-bold" style="font-size: 1.1rem;">
                            Seleccione los años en los que desea habilitar o deshabilitar el campo de programación de
                            metas.
                        </p>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="todosAnios"
                            onchange="toggleTodosAnios(this)">
                        <label class="form-check-label font-weight-bold" for="todosAnios">
                            Seleccionar todos los años
                        </label>
                    </div>

                    <!-- Lista de años -->
                    <div id="listaAniosContainer" class="list-group">
                        @foreach (range(2023, 2028) as $anio)
                            <label class="list-group-item d-flex align-items-center">
                                <input class="form-check-input me-2" type="checkbox" name="anios[]"
                                    value="{{ $anio }}" id="anio_{{ $anio }}">
                                <span class="ms-1">{{ $anio }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="guardarAniosHabilitados()">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
