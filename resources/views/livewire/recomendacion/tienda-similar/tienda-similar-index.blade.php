<div>
    @livewire('recomendacion.producto-modal.producto-index')
    <table class="table" id="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tienda</th>
                <th>Grado de Similitud</th>
                <th>Acción</th> <!-- Nueva columna para el botón -->
            </tr>
        </thead>
        <tbody>
            @foreach ($tiendas as $item)
                <tr>
                    @if ($item['pdv_id'] != $this->pdv_id)
                        <td>{{ $item['pdv_id'] }}</td>
                        <td>{{ $item['pdv_nom'] }}</td>
                        <td>%{{ round($item['similitud'], 2) * 100 }}</td>
                        <td>
                            <button class="btn btn-success" wire:click="openShowProductoModal({{ $this->pdv_id }},{{ $item['pdv_id'] }})">Ver
                                Productos Recomendados</button>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#data-table').DataTable();
        });
    </script>
</div>
