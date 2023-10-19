<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdvVenta extends Model
{
    use HasFactory;
    protected $table = "pdv_ventas";
    public $timestamps = false;
    protected $guarded = ['id'];

    public function Pdv()
    {
        return  $this->belongsTo('App\Models\Pdv', 'pdv_id');
    }

    public function VentaDetalle()
    {
        return $this->hasMany(PdvVentaDetalle::class, 'pdv_ventas_id');
    }

    public function getDetalleVentaofOnePdv()
    {
        return $this->where('pdv_id', $this->pdv_id);
    }

    public function detalles()
    {
        return $this->hasMany(PdvVentaDetalle::class, 'pdv_ventas_id');
    }
}
