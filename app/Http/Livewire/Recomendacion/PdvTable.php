<?php

namespace App\Http\Livewire\Recomendacion;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Pdv;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class PdvTable extends DataTableComponent
{
    protected $model = Pdv::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Tienda id", "pdv_id")
                ->sortable(),
            Column::make("Nombre", "pdv_nom")
                ->searchable()
                ->sortable()
                ->format(function ($value, $row) {
                    if ($row->pdv_nom) {
                        return $row->pdv_nom;
                    } else {
                        return ' ';
                    }
                }),
            Column::make("Direccion", "pdv_dir")
                ->searchable()
                ->sortable()
                ->format(function ($value, $row) {
                    if ($row->pdv_dir) {
                        return $row->pdv_dir;
                    } else {
                        return 'Sin direccion';
                    }
                }),
            ButtonGroupColumn::make('Acciones')
                ->attributes(function ($row) {
                    return [
                        'class' => 'space-x-2',
                    ];
                })
                ->buttons([
                    LinkColumn::make('Edit')
                        ->title(fn ($row) => 'Ver Tiendas similares')
                        ->location(fn ($row) => route('tiendaSimilar', $row->pdv_id))
                        ->attributes(fn ($row) => [
                            'class' => 'btn btn-success',
                        ]),
                ])

        ];
    }
}
