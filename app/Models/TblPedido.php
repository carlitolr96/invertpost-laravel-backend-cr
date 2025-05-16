<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TblPedido extends Model
{
    protected $table = 'tblpedidos';
    protected $primaryKey = 'PedidoId';
    public $timestamps = true;

    protected $fillable = [
        'ClienteId',
        'ArticuloId',
        'fecha_pedido',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(TblCliente::class, 'ClienteId', 'ClienteId');
    }

    public function factura()
    {
        return $this->hasOne(TblFactura::class, 'PedidoId', 'PedidoId');
    }

    public function articulo(): BelongsTo
    {
        return $this->belongsTo(TblArticulo::class, 'ArticuloId', 'ArticuloId');
    }
}
