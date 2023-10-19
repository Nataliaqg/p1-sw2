<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdvVentaDetalle extends Model
{
    use HasFactory;
    protected $table="pdv_ventas_detalles";
    protected $guarded = ['id'];

    public function PdvVenta()
    {
        return  $this->belongsTo(PdvVenta::class,'pdv_ventas_id');
    }

    public function Pdv()
    {
        return  $this->belongsTo(Pdv::class,'pdv_id');
    }

    public function Sku()
    {
        return  $this->belongsTo(Sku::class,'sku_id');
    }
}
