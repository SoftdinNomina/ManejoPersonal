<?php

namespace App\Models;

use App\Models\MaePais;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Attribute;

class MaeDepartamento extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'mae_departamentos';

    protected $fillable = ['pais_id', 'departamento', 'codigodane', 'codigo_iso', 'activo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function maeCiudades()
    {
        return $this->hasMany(MaeCiudad::class, 'departamento_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function maePais()
    {
        return $this->belongsTo(MaePais::class, 'pais_id', 'id');
    }
}