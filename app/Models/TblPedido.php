<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TblPedido extends Model
{
    protected $table = 'tblpedidos';
    protected $primaryKey = 'PedidoId';
    public $timestamps = true;

    protected $fillable = [
        'ClienteId',
        'fecha_pedido',
    ];

    // Relaciones
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(TblCliente::class, 'ClienteId', 'ClienteId');
    }

    public function factura()
    {
        return $this->hasOne(TblFactura::class, 'PedidoId', 'PedidoId');
    }

    public function articulos(): HasMany
    {
        return $this->hasMany(TblPedido::class, 'PedidoId', 'PedidoId'); // opcional según tu sistema
    }
}
