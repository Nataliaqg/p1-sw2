<?php

namespace App\Livewire\Dashboard;

use App\Models\PdvVenta;
use Livewire\Component;

class PdvDashboard extends Component
{
    protected $listeners = ['clearDateFilters'];
    public $start_date = null;
    public $end_date = null;
    public $conFiltroDate = false;

    protected $rules = [
        'start_date' => 'required|date|before:end_date',
        'end_date' => 'required|date|after:start_date',
    ];

    protected $messages = [
        'start_date.required' => 'La Fecha y Hora de inicio es requerida.',
        'end_date.required' => 'La Fecha y Hora de fin es requerida.',
        'end_date.after' => 'La Fecha Fin no puede ser menor que la Fecha inicio.',
        'start_date.before' => 'La Fecha Inicio no puede ser mayor que la Fecha Fin.',
    ];

    public function clearDateFilters()
    {
        $this->start_date = null;
        $this->end_date = null;
        $this->conFiltroDate = false;
        $this->resetValidation();
        $this->render();
    }

    public function updated($propertyName)
    {
        if ($this->start_date && $this->end_date) {
            $this->conFiltroDate = true;
            $this->validateOnly($propertyName, $this->rules);
        }
    }

    public function render()
    {

        if ($this->start_date && $this->end_date) {
            $pdvVentas = PdvVenta::selectRaw('pdv.pdv_nom as tiendas, COUNT(pdv_ventas.id) as ventas')
                ->join('pdv', 'pdv.pdv_id', 'pdv_ventas.pdv_id')
                ->whereBetween('fecha', [$this->start_date, $this->end_date])
                ->groupby('pdv.pdv_nom')
                ->orderby('ventas', 'desc')
                ->get();
        } else {
            $pdvVentas = PdvVenta::selectRaw('pdv.pdv_nom as tiendas, COUNT(pdv_ventas.id) as ventas')
                ->join('pdv', 'pdv.pdv_id', 'pdv_ventas.pdv_id')
                ->groupby('pdv.pdv_nom')
                ->orderby('ventas', 'desc')
                ->get();
        }

        $data = [
            'labels' => $pdvVentas->pluck('tiendas')->toArray(),
            'data' => $pdvVentas->pluck('ventas')->toArray(),
        ];

        $this->emitDrawPdv($data);

        return view('livewire.dashboard.pdv-dashboard', compact('data'));
    }

    public function emitDrawPdv($data)
    {
        $this->emit('drawPdv', $data);
    }
}
