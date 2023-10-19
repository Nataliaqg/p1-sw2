<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Pdv;
use App\Models\PdvVenta;
use Livewire\Component;
use Carbon\Carbon;

class CantVentas extends Component
{
    public $pdvs = null;
    public $pdv_id = null;
    public $interval = 1;
    public $start_date;
    public $end_date;
    public $errorMessage = '';

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

    public function __construct()
    {
        $this->loadPdvs();
        $currentDate = (new Carbon())->format('Y-m-d');
        $this->start_date = $currentDate . ' 00:00:00';
        $this->end_date = $currentDate . ' 23:59:59';
    }


    public function render()
    {
        $this->loadPdvs();

        if ($this->pdv_id) {
            $ventas = PdvVenta::selectRaw("DATE_FORMAT(fecha, '{$this->getInterval()}') as time, COUNT(id) as cant")
                ->whereBetween('fecha', [$this->start_date, $this->end_date])
                ->where('pdv_id', $this->pdv_id)
                ->groupBy('time')
                ->get();
        } else {
            $ventas = PdvVenta::selectRaw("DATE_FORMAT(fecha, '{$this->getInterval()}') as time, COUNT(id) as cant")
                ->whereBetween('fecha', [$this->start_date, $this->end_date])
                ->groupBy('time')
                ->get();
        }

        $total = $ventas->SUM('cant');
        $count = sizeof($ventas) > 0 ? sizeof($ventas) : 1;
        $avg = round($total / $count, 2);

        $data = [
            'labels' => $ventas->pluck('time')->toArray(),
            'data' => $ventas->pluck('cant')->toArray(),
        ];
        $this->emitDrawPdvVentas($data);

        return view('livewire.dashboard.cant-ventas', compact('data', 'total', 'avg'));
    }

    public function getInterval()
    {
        switch ($this->interval) {
            case 1:
                return "%Y-%m-%d %H:00";
                break;
            case 2:
                return "%Y-%m-%d";
                break;
            case 3:
                return "%Y-%m";
                break;
        }
    }

    public function emitDrawPdvVentas($data)
    {
        $this->emit('drawPdvVentas', $data);
    }

    public function loadPdvs()
    {
        $this->pdvs = Pdv::select('pdv_id', 'pdv_nom')
            ->orderby('pdv_nom', 'asc')
            ->get();
    }
}
