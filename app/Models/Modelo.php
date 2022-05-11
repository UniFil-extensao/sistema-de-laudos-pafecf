<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marca;

/**
 * Classe Model dos Modelos das Marcas de ECF
 * @author Pedro Fernando Dalbello Rocha
 * @version 2.0
 * @copyright NPI © 2022, Núcleo de Práticas em Informática LTDA.
 * @access public
 */

class Modelo extends Model
{
    use HasFactory;

    public $fillable = [
        'nome'
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }
}
