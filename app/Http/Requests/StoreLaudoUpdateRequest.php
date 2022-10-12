<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLaudoUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data_inicio' => 'required',
            'data_termino' => 'required',
            'versao_er' => 'required',
            'envelope_seguranca_marca' => 'required',
            'envelope_seguranca_modelo' => 'required',
            'numero_envelope' => 'required',
            'requisitos_executados_sgbd' => 'required',
            'executavel_sgbd' => 'required',
            'funcao_sped' => 'required',
            'executavel_sped' => 'required',
            'executavel_nfe' => 'required',
            'parecer_conclusivo' => 'required'
            // 'ecf_analise_marca' => 'required',
            // 'ecf_analise_modelo' => 'required',
            // 'relacao_ecfs_marca' => 'required',
            // 'relacao_ecfs_marca' => 'required'
        ];
    }
}
