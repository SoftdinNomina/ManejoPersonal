<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Attribute;

class MaePais extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'mae_paises';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pais',
        'codigo_alfa2',
        'codigo_alfa3',
        'codigo_numerico',
        'continente',
        'bandera',
        'activo',
    ];

    // protected function activo(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => $value ? 'true' : 'false',
    //         set: fn ($value) => $value,
    //     );
    // }


}
