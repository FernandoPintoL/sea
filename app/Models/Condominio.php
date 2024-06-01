<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Perfil;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Condominio extends Model
{
    use HasFactory;
    protected $table = "condominios";
    protected $primaryKey = "id";
    protected $fillable = [
        'propietario'=> 'Pedro I',
        'razonSocial'=> 'Condominios I',
        'nit' => '0',
        'cantidad_viviendas' => 0,
        'perfil_id'
    ];
    public function perfil(): BelongsTo {
        return $this->belongsTo(Perfil::class, 'perfil_id', 'id');
    }
}