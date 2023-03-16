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

    // public function scopeSearch($query, $term){
    //     $term='%'. $term . '%';
    //     $query->where(function($query) use ($term){
    //         $query->where('departamento','like', $term);
    //     });
    // }
    // protected function activo(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => $value ? 'true' : 'false',
    //         set: fn ($value) => $value,
    //     );
    // }

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
