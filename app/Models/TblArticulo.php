<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TblArticulo extends Model
{
    protected $table = 'tblarticulos';
    protected $primaryKey = 'ArticuloId';
    protected $fillable = ['descripcion', 'fabricante', 'codigo_barras', 'precio', 'stock'];

    public function pedidos(): BelongsToMany
    {
        return $this->belongsToMany(TblPedido::class, 'tbl_pedido_articulo', 'ArticuloId', 'PedidoId')->withPivot('cantidad');
    }
}
