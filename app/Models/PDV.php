<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;

/**
 * Classe Model do PDV
 * @author Leonardo Lima
 * @version 1.0
 * @copyright NPI © 2022, Núcleo de Práticas em Informática LTDA.
 * @access public
 */
class PDV extends Model
{
    /**
     * Valores das varíaveis/campos do banco de dados sempre tem que estar declarados como fillable.
     */
    protected $table = "pdvs";
    protected $fillable = [
        'id_empresa', 'nome_comercial',
        'versao', 'nome_principal_executavel', 'linguagem',
        'sistema_operacional', 'data_base', 'tipo_desenvolvimento',
        'tipo_funcionamento', 'nfe', 'sped', 'nfce',
        'tratamento_interrupcao', 'integracao_paf',
        'aplicacoes_especiais',
        'forma_impressao', 'perfis'
    ];

    /**
     * Função responsável por fazer o relacionamento entre a empresa e o PDV.
     * @return void
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, "id_empresa", "id");
    }

    /**
     * Função responsável por fazer o relacionamento entre o PDV e o Laudo.
     * @return void
     */
    public function laudo()
    {
        return $this->belongsTo(Laudo::class, "id_pdv", "id");
    }

    /**
     * Função responsável por receber o array de entradas da checkbox
     *  e transformar num longText antes de passar para o controller.
     * @param $value - objeto contendo os arrays a serem trasnformados antes de passagem para o controller.
     * @return void
     */
    public function setCategoryAttribute($value)
    {
        $this->attributes['aplicacoes_especiais'] = json_encode($value);
        $this->attributes['forma_impressao'] = json_encode($value);
        $this->attributes['perfis'] = json_encode($value);
    }

    /**
     * Função responsável por receber o array de entradas da checkbox
     *  e transformar num longText antes de passar para o controller.
     * @param $value - objeto contendo os arrays a serem trasnformados antes de passagem para o controller.
     * @return void
     */
    public function getCategoryAttribute($value)
    {
        return $this->attributes['aplicacoes_especiais'] = json_decode($value);
        return $this->attributes['forma_impressao'] = json_decode($value);
        return $this->attributes['perfis'] = json_decode($value);
    }
}
