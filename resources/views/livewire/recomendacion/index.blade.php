<div class="p-2">
    <head>
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    </head>
    <div>
        @livewire('recomendacion.producto-modal.producto-index')
    </div>
    <div class="card">
        <div class="card-body">
            <livewire:recomendacion.pdv-table theme="bootstrap-4" />
        </div>
    </div>
</div>
