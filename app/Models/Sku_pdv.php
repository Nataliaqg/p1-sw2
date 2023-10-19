<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Sku_pdv extends Model
{
    use HasFactory;
    protected $table = "sku_pdv";
    protected $primaryKey = 'skp_id';
    public $timestamps = true;
    const CREATED_AT = 'skp_created_at';
    const UPDATED_AT = 'skp_updated_at';
    protected $guarded = ['skp_id'];

    public function Sku()
    {
        return  $this->belongsTo('App\Models\Sku', 'skp_sku_id');
    }
    public function Pdv()
    {
        return  $this->belongsTo('App\Models\Pdv', 'skp_pdv_id');
    }


    public function sold($total)
    {

        $hoy = new Carbon();
        $lastsold = $this->skp_lastsold ? new Carbon($this->skp_lastsold) : new Carbon();

        $dateday = $hoy->toRfc850String();
        $dia = substr($dateday, 0, strrpos($dateday, ","));

        $wtotal = $total;
        $mtotal = $total;

        if ($dia !== "Monday" || $hoy->format('Y-m-d') == $lastsold->format('Y-m-d')) {
            $wtotal = $this->skp_wksold + $wtotal;
        }

        if ($hoy->format('d') !== 1 || $hoy->format('Y-m-d') == $lastsold->format('Y-m-d')) {
            $mtotal = $this->skp_mthsold + $mtotal;
        }

        $this->update([
            'skp_lastsold' => $hoy,
            'skp_wksold' => $wtotal,
            'skp_mthsold' => $mtotal
        ]);
        $this->Sku->sold($total);
    }

    public function updateStocks($cantidad)
    {
        $stockActual = $this->skp_cantidad;
        $stock = $stockActual + $cantidad;
        if ($stock < 0) {
            $stock = 0;
        }
        $this->update([
            'skp_cantidad' => $stock,
        ]);
    }
}
