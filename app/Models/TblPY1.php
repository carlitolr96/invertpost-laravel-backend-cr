<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblPY1 extends Model
{
    protected $table = 'tblpy1s';
    protected $primaryKey = 'UserId';
    protected $fillable = ['usuario', 'password', 'cedula', 'telefono', 'tipo_sangre'];
}