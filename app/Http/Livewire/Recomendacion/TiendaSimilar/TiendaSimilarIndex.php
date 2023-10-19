<?php

namespace App\Http\Livewire\Recomendacion\TiendaSimilar;

use App\Models\Pdv;
use Livewire\Component;
use GuzzleHttp\Client;

class TiendaSimilarIndex extends Component
{
    public $pdv_id;

    public function mount($pdv_id)
    {
        $this->pdv_id = $pdv_id;
    }

    public function render()
    {
        $url = config('app.app_python') . "/similarity/{$this->pdv_id}";
        $client = new Client();
        $response = $client->get($url);
        $data = [];
        if ($response->getStatusCode() === 200) {
            $data = json_decode($response->getBody());

            $tiendas_id = array_map(function ($item) {
                return $item->tienda;
            }, $data);

            $tiendas = Pdv::whereIn('pdv_id', $tiendas_id)->get()->toArray();
            foreach ($tiendas as &$tienda) {
                $elemento = $this->search($data, $tienda['pdv_id']);
                $tienda['similitud'] = $elemento->similitud;
            }

            usort($tiendas, function ($a, $b) {
                return strcmp($b['similitud'], $a['similitud']);
            });
        }
        return view('livewire.recomendacion.tienda-similar.tienda-similar-index', compact('tiendas'));
    }

    public function search($data, $pdv_id)
    {
        $filteredData = array_filter($data, function ($item) use ($pdv_id) {
            return $item->tienda == $pdv_id;
        });
        return count($filteredData) > 0 ? reset($filteredData) : null;
    }

    public function openShowProductoModal($pdvA, $pdvB)
    {
        $this->emit('openShowProductoModal', $pdvA,$pdvB);
    }
}
