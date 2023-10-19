<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Sku extends Model
{
    use HasFactory;
    protected $table = "sku";
    protected $primaryKey = 'sku_id';
    public $timestamps = false;
    protected $guarded = ['sku_id'];



    public function producto()
    {
        return $this->belongsTo(Producto::class, 'sku_pro_id');
    }

    public function medida()
    {
        return $this->belongsTo(Unidad_medida::class, 'sku_uni_id');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'sku_mar_id');
    }

    public function submarca()
    {
        return $this->belongsTo(Submarca::class, 'sku_sma_id');
    }

    public function tipo_empaque()
    {
        return $this->belongsTo(Tipo_Empaque::class, 'sku_tpq_id');
    }

    public function sabores()
    {
        return $this->belongsTo(Sabor::class, 'sku_sab_id');
    }

    public function fragancia()
    {
        return $this->belongsTo(Fragancia::class, 'sku_fra_id');
    }

    public function forma_producto()
    {
        return $this->belongsTo(Forma_Producto::class, 'sku_fpr_id');
    }

    public function color_empaque()
    {
        return $this->belongsTo(Colorempaque::class, 'sku_cpq_id');
    }

    public function calidad_producto()
    {
        return $this->belongsTo(Calidad_Producto::class, 'sku_cpr_id');
    }

    public function sku_pdv()
    {
        return $this->hasMany(Sku_pdv::class, 'skp_sku_id');
    }

    public function SkuBusqueda()
    {
        return $this->hasMany(SkuBusqueda::class, 'sku_id');
    }

    public function sold($total)
    {


        $hoy = new Carbon();
        $lastsold = $this->sku_lastsold ? new Carbon($this->sku_lastsold) : new Carbon();

        $dateday = $hoy->toRfc850String();
        $dia = substr($dateday, 0, strrpos($dateday, ","));

        $wtotal = $total;
        $mtotal = $total;

        if ($dia !== "Monday" || $hoy->format('Y-m-d') == $lastsold->format('Y-m-d')) {
            $wtotal = $this->sku_wksold + $wtotal;
        }

        if ($hoy->format('d') !== 1 || $hoy->format('Y-m-d') == $lastsold->format('Y-m-d')) {
            $mtotal = $this->sku_mthsold + $mtotal;
        }

        $this->update([
            'sku_lastsold' => $hoy,
            'sku_wksold' => $wtotal,
            'sku_mthsold' => $mtotal
        ]);
    }

    public function getUpc()
    {
        return $this->sku_upc;
    }
}
