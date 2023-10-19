<div class="px-3">
    <h2 class="py-4" style="display: flex; justify-content: center ; font-weight: bold; color: orange">Ventas</h2>
    <div class="row py-4">
        <div class="col-md-3">
            <label>Tiendas:</label>
            <select class="form-control" id="exampleFormControlSelect1" wire:model="pdv_id">
                <option selected value="">Todo</option>
                @foreach ($pdvs as $pdv)
                    <option value="{{ $pdv->pdv_id }}">{{ $pdv->pdv_nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <label>Intervalo:</label>
            <select class="form-control" id="exampleFormControlSelect1" wire:model="interval">
                <option value="1">Hora</option>
                <option value="2">Dia</option>
                <option value="3">Mes</option>
            </select>
        </div>
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
    </div>

    <div style="margin-top: 20px">
        <canvas id="lineChartVentas" style="width: 50%"></canvas>
    </div>

    <div style="display: flex; justify-content: center">
        <p style="font-weight: bold; color: orange; font-size: 15px">Total: {{ $total }} - Media:
            {{ $avg }}</p>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {

            let lineChart = null;

            draw(@json($data));

            Livewire.on('drawPdvVentas', function(data) {
                draw(data);
            });

            function draw(newData) {
                let ctx = document.getElementById('lineChartVentas').getContext('2d');

                const data = {
                    labels: newData.labels,
                    datasets: [{
                        label: 'Nro. de ventas',
                        data: newData.data,
                        borderColor: 'orange',
                        borderWidth: 2,
                        fill: false
                    }]
                };

                const options = {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Tiempo'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Cantidad de Ventas'
                            },
                            beginAtZero: true
                        }
                    }
                };


                if (lineChart) {
                    lineChart.destroy()
                }

                lineChart = new Chart(ctx, {
                    type: 'line',
                    data: data,
                    options: options
                });

                lineChart.render();
            }
        });
    </script>
</div>
