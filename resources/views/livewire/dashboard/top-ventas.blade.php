<div class="px-3">
    <h2 class="py-4" style="display: flex; justify-content: center; font-weight: bold; color: #FF8A8A">
        Top Ventas por Tienda
    </h2>
    <div class="row py-3">
        <div class="col-md-3">
            <label for="start_date">Fecha y hora Inicio:</label>
            <input class="form-control @error('start_date') is-invalid @enderror" wire:model="start_date"
                type="datetime-local" id="start_date" name="start_date">
            @error('start_date')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="end_date">Fecha y hora Fin:</label>
            <input class="form-control @error('end_date') is-invalid @enderror" wire:model="end_date"
                type="datetime-local" id="end_date" name="end_date">
            @error('end_date')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div style="margin-top: 24px">
            @if ($conFiltroDate)
                <button class="btn btn-secondary my-2 mr-1" wire:click='clearDateFilters()'>Limpiar Filtros de
                    fecha</button>
            @endif
        </div>
    </div>

    <div style="width: 100%; margin: 0 auto; padding-bottom: 25px">
        <canvas id="horizontalBarChart" width="50%"></canvas>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            let horizontalBarChart = null;

            draw(@json($data));
            Livewire.on('drawPdv', function(data) {
                draw(data);
            });

            function draw(newData) {
                var ctx = document.getElementById('horizontalBarChart').getContext('2d');
                var chartData = {
                    labels: newData.labels,
                    datasets: [{
                        label: 'Nro. de Ventas',
                        data: newData.data,
                        backgroundColor: '#FF8A8A',
                        borderColor: '#D10000',
                        borderWidth: 1
                    }]
                };

                var chartOptions = {
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                };

                if (horizontalBarChart) {
                    horizontalBarChart.destroy()
                }

                horizontalBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: chartOptions
                });

                horizontalBarChart.render();

            }
        });
    </script>

</div>
