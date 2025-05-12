<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblFactura extends Model
{
    protected $table = 'tblfacturas';
    protected $primaryKey = 'FacturaId';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'PedidoId',
        'monto_total',
        'fecha_factura',
    ];

    public function pedido()
    {
        return $this->belongsTo(TblPedido::class, 'PedidoId');
    }
}
