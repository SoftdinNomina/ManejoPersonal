<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaeBarrio extends Model
{
	use HasFactory;

    public $timestamps = true;

    protected $table = 'mae_barrios';

    protected $fillable = ['ciudad_id','barrio','activo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function maeCiudad()
    {
        return $this->belongsTo(MaeCiudad::class, 'ciudad_id');
    }

}