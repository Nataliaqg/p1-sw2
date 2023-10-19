<div>
    @if ($modalShowProducto)
        <div class="modald">
            <div class="modald-contenido" tabindex="-1" role="dialog">
                <div class="modal-dialog d-flex align-items-center justify-content-center" role="document"
                    style="position: fixed; top: 50%; left: 48%; transform: translate(-50%, -50%);">
                    <div class="modal-content text-center ">
                        <div class="modal-header ">
                            <b>
                                Productos Recomendados</b>
                        </div>
                        <div class="modal-body" style="max-height: 400px; width: 400px;   overflow-y: auto;">
                            @foreach ($productos as $producto)
                                <div class="card mb-2">
                                    <div class="card-body">
                                        {{ $producto->sku_nom }}
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div align="center">
                            <button type="button" class="btn btn-secondary btn-sm my-2 mx-2"
                                wire:click="cancelar()">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
