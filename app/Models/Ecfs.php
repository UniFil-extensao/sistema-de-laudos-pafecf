<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marca;
use App\Models\Modelo;
use Dotenv\Parser\Value;

/**
 * Classe Model da ECF
 * @author Leonardo Lima
 * @author Pedro Fernando Dalbello Rocha
 * @version 2.0
 * @copyright NPI © 2022, Núcleo de Práticas em Informática LTDA.
 * @access public
 */
class Ecfs extends Model
{
    public function allEcfs()
    {
        Marca::resolveRelationUsing('nome', function ($marcaModel) {
            return $marcaModel->belongsTo(Modelo::class, 'marca_id');
        });
    }

}
