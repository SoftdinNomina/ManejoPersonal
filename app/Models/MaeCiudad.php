<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaeCiudad extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'mae_ciudades';

    protected $fillable = ['departamento_id', 'ciudad', 'codigodane', 'activo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function maeBarrio()
    {
        return $this->hasOne('App\Models\MaeBarrio', 'ciudad_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function maeDepartamento()
    {
        return $this->belongsTo(MaeDepartamento::class, 'departamento_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function maeDirecciones()
    {
        return $this->hasMany('App\Models\MaeDireccion', 'ciudad_id', 'id');
    }
}