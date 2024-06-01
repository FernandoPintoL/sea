<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TipoVivienda;
use App\Models\Condominio;
class Vivienda extends Model
{
    use HasFactory;
    protected $table = "vivienda";
    protected $primaryKey = "id";
    protected $fillable = [
        'nroVivienda' => "",
        'detalle' => "",
        'nroEspacios' => 0,
        "tipo_vivienda_id" => 0,
        "condominio_id" => 0,
    ];

    public function tipoVivienda(){
        return $this->belongsTo(TipoVivienda::class,"tipo_vivienda_id", 'id');
    }
    public function condominio(){
        return $this->belongsTo(Condominio::class,"condominio_id", 'id');
    }
}