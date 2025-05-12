<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblCliente extends Model
{
    protected $table = 'tblclientes'; 
    protected $fillable = ['nombre', 'telefono', 'tipo_cliente'];
}
