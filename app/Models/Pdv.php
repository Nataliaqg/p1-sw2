<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pdv extends Model
{
    use HasFactory;
    protected $table = "pdv";
    protected $primaryKey = 'pdv_id';
    public $timestamps = true;
    const CREATED_AT = 'pdv_created_at';
    const UPDATED_AT = 'pdv_updated_at';
    protected $guarded = ['pdv_id'];
    // protected $appends = ['totalVentas', 'primeraVentaHora', 'ultimaVentaHora'];

    public function ventas()
    {
        return $this->hasMany(PdvVenta::class, 'pdv_id');
    }

    public function detalle_ventas()
    {
        return $this->hasMany(PdvVentaDetalle::class, 'pdv_id');
    }

    public function sku_pdv()
    {
        return $this->hasMany(Sku_pdv::class, 'skp_pdv_id');
    }


    public function UnidadesVentasByDate($dateStart, $dateEnd)
    {
        $cantidad = PdvVentaDetalle::join('pdv_ventas', 'pdv_ventas.id', 'pdv_ventas_detalles.pdv_ventas_id')
        ->where('pdv_ventas.pdv_id', $this->pdv_id)
        ->whereBetween('pdv_ventas.fecha', [$dateStart, $dateEnd])
        ->count();
        return $cantidad;
    }
    public function unidadesCantidadVentasByDate($dateStart, $dateEnd)
    {
        $sum = PdvVentaDetalle::join('pdv_ventas', 'pdv_ventas.id', 'pdv_ventas_detalles.pdv_ventas_id')
        ->where('pdv_ventas.pdv_id', $this->pdv_id)
        ->whereBetween('pdv_ventas.fecha', [$dateStart, $dateEnd])
        ->sum('pdv_ventas_detalles.cantidad');
        return $sum;
    }

    public function getTotalVentasAttribute()
    {
        return $this->ventas->count();
    }

    public function getPrimeraVentaHoraAttribute()
    {
        $primeraVenta = $this->ventas->sortBy('fecha')->first();
        return $primeraVenta ? $primeraVenta->fecha : null;
    }

    public function getUltimaVentaHoraAttribute()
    {
        $ultimaVenta = $this->ventas->sortBy('fecha')->last();
        return $ultimaVenta ? $ultimaVenta->fecha : null;
    }

    public function getTotalVentas($fecha)
    {
        $startDay = (new Carbon($fecha))->startOfDay();
        $endDay = (new Carbon($fecha))->endOfDay();
        return $this->ventas->whereBetween('fecha', [$startDay, $endDay])->count();
    }
    public function getTotalVentasSum($fecha)
    {
        $startDay = (new Carbon($fecha))->startOfDay();
        $endDay = (new Carbon($fecha))->endOfDay();
        return $this->ventas->whereBetween('fecha', [$startDay, $endDay])->sum('total');
    }

    public function getTotalUnidades($fecha)
    {
        $startDay = (new Carbon($fecha))->startOfDay();
        $endDay = (new Carbon($fecha))->endOfDay();
        return $this->UnidadesVentasByDate($startDay, $endDay);
    }
    public function getSumaUnidadesCantidad($fecha)
    {
        $startDay = (new Carbon($fecha))->startOfDay();
        $endDay = (new Carbon($fecha))->endOfDay();
        return $this->unidadesCantidadVentasByDate($startDay, $endDay);
    }

    public function getPrimeraVentaHora($fecha)
    {
        $startDay = (new Carbon($fecha))->startOfDay();
        $endDay = (new Carbon($fecha))->endOfDay();
        $primeraVenta = $this->ventas->whereBetween('fecha', [$startDay, $endDay])->first();
        return $primeraVenta ? $primeraVenta->fecha : 'S/V';
    }

    public function getUltimaVentaHora($fecha)
    {
        $startDay = (new Carbon($fecha))->startOfDay();
        $endDay = (new Carbon($fecha))->endOfDay();
        $ultimaVenta = $this->ventas->whereBetween('fecha', [$startDay, $endDay])->last();
        return $ultimaVenta ? $ultimaVenta->fecha : 'S/V';
    }
}
