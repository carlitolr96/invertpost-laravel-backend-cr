<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class TblPY1 extends Authenticatable
{
    protected $table = 'tblpy1s';
    protected $primaryKey = 'UserId';
    protected $fillable = ['usuario', 'password', 'cedula', 'telefono', 'tipo_sangre'];

    // Si tu campo de contraseña no se llama 'password', descomenta y ajusta la siguiente línea:
    // public function getAuthPassword() { return $this->password; }
}