<?php

namespace App\Http\Livewire\Recomendacion\ProductoModal;

use Livewire\Component;
use GuzzleHttp\Client;

class ProductoIndex extends Component
{
    protected $listeners = ['openShowProductoModal'];

    public $modalShowProducto = false;
    public $pdvA; // Declaración de la variable pdvId en el componente
    public $pdvB; // Declaración de la variable pdvId en el componente


    public function render()
    {
        $productos = $this->getRecomendations();
        return view('livewire.recomendacion.producto-modal.producto-index', compact('productos'));
    }
    public function openShowProductoModal($pdvA, $pdvB)
    {
        $this->modalShowProducto = true;
        $this->pdvA = $pdvA;
        $this->pdvB = $pdvB;
    }

    public function cancelar()
    {
        $this->limpiar();
    }

    public function limpiar()
    {
        $this->modalShowProducto = false;
    }
    public function getRecomendations()
    {
        $data = [];
        if ($this->pdvA && $this->pdvB){
            $url = config('app.app_python') . "/recommendations?cliente_a={$this->pdvA}&cliente_b={$this->pdvB}";
            $client = new Client();
            $response = $client->get($url);
            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody());
            }
        }
        return $data;
    }
}
