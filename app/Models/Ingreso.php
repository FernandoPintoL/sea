<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Habitante;
use App\Models\TipoVisita;
use App\Models\User;

class Ingreso extends Model
{
    use HasFactory;
    protected $table = "ingresos";
    protected $primaryKey = "id";
    protected $fillable = [
        'visita_id' => 0,
        'autoriza_habitante_id' => 0,
        'ingresa_habitante_id' => 0,
        'tipo_ingreso' => 'caminando',
        'vehiculo_id' => 0,
        'detalle' => '',
        'isAutorizado' => false,
        'tipo_visita_id' => 0,
        'user_id'
    ];
    public function autoriza(){
        return $this->belongsTo(Habitante::class, 'autoriza_habitante_id','id');
    }
    public function ingresa(){
        return $this->belongsTo(Habitante::class, 'ingresa_habitante_id','id');
    }
    public function tipoVisita(){
        return $this->belongsTo(TipoVisita::class, 'tipo_visita_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
}