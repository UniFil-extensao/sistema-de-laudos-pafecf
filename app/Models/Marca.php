<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Modelo;

/**
 * Classe Model das Marcas de ECF
 * @author Pedro Fernando Dalbello Rocha
 * @version 2.0
 * @copyright NPI © 2022, Núcleo de Práticas em Informática LTDA.
 * @access public
 */

class Marca extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $fillable = [ 'nome' ];

    public function modelos()
    {
        return $this->hasMany(Modelo::class);
    }
}
