<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PDV;

/**
 * Classe Modelo da Empresa
 * @author Leonardo Lima
 * @version 1.0
 * @copyright NPI © 2022, Núcleo de Práticas em Informática LTDA.
 * @access public
 */
class Empresa extends Model
{
    /**
     * Função responsável por fazer o relacionamento entre a empresa e o PDV.
     * @return void
     */
    public function pdvs()
    {
        return $this->hasMany(PDV::class, "id_empresa", "id");
    }
}
