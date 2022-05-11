@extends('layouts.app')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <a href="/cadastros/{{ $empresa->id }}" class="btn btn-default">Editar Cadastro da Empresa</a>
    <h1>Editar Cadastro de Ponto de Venda - PDV</h1>
    <h3>Empresa Requerente: <b>{{ $empresa->razao_social }}</b></h3>
    <h3>Informações do Ponto de Venda: <b>{{ $pdv->nome_comercial }}</b></h3>
    <small>Os campos obrigatórios estão representados com um asterisco (*).</small>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <script type="text/javascript">
        $(document).ready(function() {
            $('.proximo').click(function() {
                $('.nav-tabs .active').parent().next('li').find('a').trigger('click');
            });

            $('.anterior').click(function() {
                $('.nav-tabs .active').parent().prev('li').find('a').trigger('click');
            });
        });
    </script>
     <script>
        function validarExclusao(frm) {
            var validador = confirm("Tem certeza que deseja excluir este PDV da empresa?");
            if (validador == false) {
                return false;
            } else {
                return true;
            }
        }
    </script>
    <form action="{{ route('pdv.destroy', $pdv) }}" method="post"
        onsubmit="return validarExclusao();">
        @csrf
        <button type="submit" class="btn btn-danger pull-right">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-trash-fill"
                viewBox="0 0 16 13" style="color: red">
                <path
                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z">
                </path>
            </svg>
            Excluir PDV
        </button>
    </form>
    <form action="{{ route('cadastroPDV.update', $pdv, $pdv->id) }}" method="post" name="formulario">
        @csrf
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#base" role="tab">Informações Base</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#aplicacoes" role="tab">Aplicações Especiais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#impressao" role="tab">Forma de Impressão</a>
            </li>
        </ul>
        <br>
        <div class="tab-content">
            <div class="tab-pane active" id="base" role="tabpanel">
                <div class="form-group col-md-12" id="botoes">
                    <a class="btn btn-default">Voltar</a>
                    <a class="btn btn-primary proximo pull-right">Próximo</a>
                </div>
                <div class="form-group control-label col-md-7">
                    <label for="nome_comercial">Nome Comercial do Programa</label>
                    <input type="text" class="form-control @error('nome_comercial') is-invalid @enderror"
                        id="nome_comercial" name="nome_comercial" placeholder="Nome comercial"
                        value="{{ $pdv->nome_comercial }}">
                    @error('nome_comercial')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-5">
                    <label for="versao">Versão do Programa</label>
                    <input type="text" class="form-control" id="versao" name="versao"
                        placeholder="Para qual versão vai o programa?" value="{{ $pdv->versao }}">
                    @error('versao')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-12">
                    <label for="nome_principal_executavel">Nome do Executável Principal do Programa</label>
                    <input type="text" class="form-control" id="nome_principal_executavel"
                        name="nome_principal_executavel" placeholder="Nome Principal Executável"
                        value="{{ $pdv->nome_principal_executavel }}">
                    @error('nome_principal_executavel')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-4">
                    <label for="linguagem">Linguagem de Programação</label>
                    <input type="text" class="form-control @error('linguagem') is-invalid @enderror" id="linguagem"
                        name="linguagem" placeholder="Linguagem de Programação" value="{{ $pdv->linguagem }}">
                    @error('linguagem')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-4">
                    <label for="sistema_operacional">Sistema Operacional</label>
                    <input type="text" class="form-control @error('sistema_operacional') is-invalid @enderror"
                        id="sistema_operacional" name="sistema_operacional" placeholder="Sistema Operacional"
                        value="{{ $pdv->sistema_operacional }}">
                    @error('sistema_operacional')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-4">
                    <label for="data_base">Gerenciador de Banco de Dados</label>
                    <input type="text" class="form-control @error('data_base') is-invalid @enderror" id="data_base"
                        name="data_base" placeholder="Gerenciador de Banco de Dados" value="{{ $pdv->data_base }}">
                    @error('data_base')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <br>
                <div class="form-group control-label col-md-4">
                    <label for="tipo_desenvolvimento">Tipo de Desenvolvimento:</label>
                    <select name="tipo_desenvolvimento" id="tipo_desenvolvimento">
                        @if ($pdv->tipo_desenvolvimento == 'comercializavel')
                            <option selected value="comercializavel">Comercializável</option>
                            <option value="exclusivo_proprio">Exclusivo Próprio</option>
                            <option value="exclusivo_tercerizado">Exclusivo Tercerizado</option>
                        @elseif (($pdv->tipo_desenvolvimento) == 'exclusivo_proprio')
                            <option selected value="exclusivo_proprio">Exclusivo Próprio</option>
                            <option value="comercializavel">Comercializável</option>
                            <option value="exclusivo_tercerizado">Exclusivo Tercerizado</option>
                        @elseif (($pdv->tipo_desenvolvimento) == 'exclusivo_tercerizado')
                            <option selected value="exclusivo_tercerizado">Exclusivo Tercerizado</option>
                            <option value="comercializavel">Comercializável</option>
                            <option value="exclusivo_proprio">Exclusivo Próprio</option>
                        @endif
                    </select>
                </div>
                <div class="form-group control-label col-md-4">
                    <label for="tipo_funcionamento">Tipo de Funcionamento:</label>
                    <select name="tipo_funcionamento" id="tipo_funcionamento">
                        @if ($pdv->tipo_funcionamento == 'stand_alone')
                            <option value="stand_alone" selected>Exclusivo Stand Alone</option>
                            <option value="rede">Em Rede</option>
                            <option value="parametrizavel">Parametrizável</option>
                        @elseif (($pdv->tipo_funcionamento) == 'rede')
                            <option value="stand_alone">Exclusivo Stand Alone</option>
                            <option value="rede" selected>Em Rede</option>
                            <option value="parametrizavel">Parametrizável</option>
                        @elseif (($pdv->tipo_funcionamento) == 'parametrizavel')
                            <option value="stand_alone">Exclusivo Stand Alone</option>
                            <option value="rede">Em Rede</option>
                            <option value="parametrizavel" selected>Parametrizável</option>
                        @endif
                    </select>
                </div>
                <div class="form-group control-label col-md-4">
                    <label for="nfe">Emite Nota Fiscal Eletrônica - NF-e:</label>
                    <select name="nfe" id="nfe">
                        @if ($pdv->nfe == 'sim'))
                            <option value="sim" selected>Sim</option>
                            <option value="nao">Não</option>
                        @else
                            <option value="sim">Sim</option>
                            <option value="nao" selected>Não</option>
                        @endif
                    </select>
                </div>
                <div class="form-group control-label col-md-6">
                    <label for="sped">Geração do Arquivo SINTEGRA ou EFD(SPED):</label>
                    <select name="sped" id="sped">
                        @if ($pdv->sped == 'pelo_paf')
                            <option value="pelo_paf" selected>Pelo PAF</option>
                            <option value="retaguarda">Pelo Sistema de Retaguarda</option>
                            <option value="ped_efd">Pelo Sistema de PED ou EFC</option>
                        @elseif (($pdv->sped) == 'retaguarda')
                            <option value="pelo_paf">Pelo PAF</option>
                            <option value="retaguarda" selected>Pelo Sistema de Retaguarda</option>
                            <option value="ped_efd">Pelo Sistema de PED ou EFC</option>
                        @elseif (($pdv->sped) == 'ped_efd')
                            <option value="pelo_paf">Pelo PAF</option>
                            <option value="retaguarda">Pelo Sistema de Retaguarda</option>
                            <option value="ped_efd" selected>Pelo Sistema de PED ou EFC</option>
                        @endif
                    </select>
                </div>
                <div class="form-group control-label col-md-5">
                    <label for="nfce">Emite Nota Fiscal Consumidor Eletrônica - NFC-e:</label>
                    <select name="nfce" id="nfce">
                        @if ($pdv->nfce == 'sim'))
                            <option value="sim" selected>Sim</option>
                            <option value="nao">Não</option>
                        @else
                            <option value="sim">Sim</option>
                            <option value="nao" selected>Não</option>
                        @endif
                    </select>
                </div>
                <div class="form-group control-label col-md-6">
                    <label for="tratamento_interrupcao">Tratamento de Interrupção Durante a Emissão do Cupom
                        Fiscal:</label>
                    <select name="tratamento_interrupcao" id="tratamento_interrupcao">
                        @if ($pdv->tratamento_interrupcao == 'recupera')
                            <option value="recupera" selected>Recuperação dos Dados</option>
                            <option value="cancela">Cancelamento Automático</option>
                            <option value="bloqueia">Bloqueio de Funções</option>
                        @elseif (($pdv->tratamento_interrupcao) == 'cancela')
                            <option value="recupera">Recuperação dos Dados</option>
                            <option value="cancela" selected>Cancelamento Automático</option>
                            <option value="bloqueia">Bloqueio de Funções</option>
                        @elseif (($pdv->tratamento_interrupcao) == 'bloqueia')
                            <option value="recupera">Recuperação dos Dados</option>
                            <option value="cancela">Cancelamento Automático</option>
                            <option value="bloqueia" selected>Bloqueio de Funções</option>
                        @endif
                    </select>
                </div>
                <div class="form-group control-label col-md-6">
                    <label for="integracao_paf">Integração do Programa Aplicativo Fiscal:</label>
                    <select name="integracao_paf" id="integracao_paf">
                        @if ($pdv->integracao_paf == 'gestao_retaguarda')
                            <option value="gestao_retaguarda" selected>Com Sistema de Gestão ou Retaguarda</option>
                            <option value="ped">Com Sistema PED</option>
                            <option value="ambos">Com Ambos</option>
                            <option value="nao_integrado">Não Integrado</option>
                        @elseif (($pdv->integracao_paf) == 'ped')
                            <option value="gestao_retaguarda">Com Sistema de Gestão ou Retaguarda</option>
                            <option value="ped" selected>Com Sistema PED</option>
                            <option value="ambos">Com Ambos</option>
                            <option value="nao_integrado">Não Integrado</option>
                        @elseif (($pdv->integracao_paf) == 'ambos')
                            <option value="gestao_retaguarda">Com Sistema de Gestão ou Retaguarda</option>
                            <option value="ped">Com Sistema PED</option>
                            <option value="ambos" selected>Com Ambos</option>
                            <option value="nao_integrado">Não Integrado</option>
                        @elseif (($pdv->integracao_paf) == 'nao_integrado')
                            <option value="gestao_retaguarda">Com Sistema de Gestão ou Retaguarda</option>
                            <option value="ped">Com Sistema PED</option>
                            <option value="ambos">Com Ambos</option>
                            <option value="nao_integrado" selected>Não Integrado</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="tab-pane" id="aplicacoes" role="tabpanel">
                <div class="form-group col-md-12" id="botoes">
                    <a class="btn btn-primary anterior">Voltar</a>
                    <a class="btn btn-primary proximo pull-right">Próximo</a>
                </div>
                <div class="form-group control-label col-md-9">
                    <label for="aplicacoes_especiais">Aplicações Especiais:</label>

                    <div class="form-group control-label col-md-12">
                        <label for="executavel_sgbd">Nome do Arquivo Executável Responsável pelo SGBD</label>
                        <input type="text" class="form-control @error('executavel_sgbd') is-invalid @enderror"
                            id="executavel_sgbd" name="executavel_sgbd" placeholder="Executavel SGBD"
                            value="{{ $pdv->executavel_sgbd }}">
                        @error('executavel_sgbd')
                            <div class="invalid-feedback" style="color: red">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group control-label col-md-12">
                        <label for="executavel_sped">Nome do Arquivo Executável Responsável pelo SPED</label>
                        <input type="text" class="form-control @error('executavel_sped') is-invalid @enderror"
                            id="executavel_sped" name="executavel_sped" placeholder="Executavel SPED"
                            value="{{ $pdv->executavel_sped }}">
                        @error('executavel_sped')
                            <div class="invalid-feedback" style="color: red">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group control-label col-md-12">
                        <label for="executavel_nfe">Nome do Arquivo Executável Responsável pelo gerador de NF-e</label>
                        <input type="text" class="form-control @error('executavel_nfe') is-invalid @enderror"
                            id="executavel_nfe" name="executavel_nfe" placeholder="Executavel NF-e"
                            value="{{ $pdv->executavel_nfe }}">
                        @error('executavel_nfe')
                            <div class="invalid-feedback" style="color: red">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div>
                        <input type="checkbox" id="posto_com_bomba" name="aplicacoes_especiais[]" value="posto_com_bomba"
                            @foreach ($aplicacoes as $valor)
                        @if ($valor == 'posto_com_bomba')
                            checked
                        @endif
                        @endforeach>
                        <label for="posto_com_bomba">Posto revendedor de Combusível COM Sistema de Interligação de
                            Bombas.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="posto_sem_bomba" name="aplicacoes_especiais[]" value="posto_sem_bomba"
                            @foreach ($aplicacoes as $valor)
                        @if ($valor == 'posto_sem_bomba')
                            checked
                        @endif
                        @endforeach>
                        <label for="posto_sem_bomba">Posto revendedor de Combusível SEM Sistema de Interligação de
                            Bombas.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="oficina_dav_os" name="aplicacoes_especiais[]" value="oficina_dav_os"
                            @foreach ($aplicacoes as $valor)
                        @if ($valor == 'oficina_dav_os')
                            checked
                        @endif
                        @endforeach>
                        <label for="oficina_dav_os">Oficina de Conserto COM DAV-OS.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="oficina_conta_cliente" name="aplicacoes_especiais[]"
                            value="oficina_conta_cliente" @foreach ($aplicacoes as $valor)
                        @if ($valor == 'oficina_conta_cliente')
                            checked
                        @endif
                        @endforeach>
                        <label for="oficina_conta_cliente">Oficina de Conserto COM CONTA DE CLIENTE.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="bar_ecf_restaurante" name="aplicacoes_especiais[]"
                            value="bar_ecf_restaurante" @foreach ($aplicacoes as $valor)
                        @if ($valor == 'bar_ecf_restaurante')
                            checked
                        @endif
                        @endforeach>
                        <label for="bar_ecf_restaurante">Bar, Restaurante e estabelecimento similiar com utilização de
                            ECF-RESTAURANTE e balança interligada.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="bar_ecf_normal" name="aplicacoes_especiais[]" value="bar_ecf_normal"
                            @foreach ($aplicacoes as $valor)
                        @if ($valor == 'bar_ecf_normal')
                            checked
                        @endif
                        @endforeach>
                        <label for="bar_ecf_normal">Bar, Restaurante e estabelecimento similiar com utilização de
                            ECF-NORMAL
                            e balança interligada.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="bar_ecf_restaurante_sem_balanca" name="aplicacoes_especiais[]"
                            value="bar_ecf_restaurante_sem_balanca" @foreach ($aplicacoes as $valor)
                        @if ($valor == 'bar_ecf_restaurante_sem_balanca')
                            checked
                        @endif
                        @endforeach>
                        <label for="bar_ecf_restaurante_sem_balanca">Bar, Restaurante e estabelecimento similiar com
                            utilização de ECF-RESTAURANTE SEM balança interligada.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="bar_ecf_normal_sem_balanca" name="aplicacoes_especiais[]"
                            value="bar_ecf_normal_sem_balanca" @foreach ($aplicacoes as $valor)
                        @if ($valor == 'bar_ecf_normal_sem_balanca')
                            checked
                        @endif
                        @endforeach>
                        <label for="bar_ecf_normal_sem_balanca">Bar, Restaurante e estabelecimento similiar com
                            utilização
                            de ECF-NORMAL SEM balança interligada.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="farmacia" name="aplicacoes_especiais[]" value="farmacia" @foreach ($aplicacoes as $valor)
                        @if ($valor == 'farmacia')
                            checked
                        @endif
                        @endforeach>
                        <label for="farmacia">Farmácia de Manipulação.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="transporte_passageiros" name="aplicacoes_especiais[]"
                            value="transporte_passageiros" @foreach ($aplicacoes as $valor)
                        @if ($valor == 'transporte_passageiros')
                            checked
                        @endif
                        @endforeach>
                        <label for="transporte_passageiros">Transporte de Passageiros.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="posto_pedagio" name="aplicacoes_especiais[]" value="posto_pedagio"
                            @foreach ($aplicacoes as $valor)
                        @if ($valor == 'posto_pedagio')
                            checked
                        @endif
                        @endforeach>
                        <label for="posto_pedagio">Posto de Pedágio.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="moteis" name="aplicacoes_especiais[]" value="moteis" @foreach ($aplicacoes as $valor)
                        @if ($valor == 'moteis')
                            checked
                        @endif
                        @endforeach>
                        <label for="moteis">Estacionamento, Motéis e Similares, que pratiquem o Controle de Tráfego de
                            Veículos ou Pessoas.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="cinema" name="aplicacoes_especiais[]" value="cinema" @foreach ($aplicacoes as $valor)
                        @if ($valor == 'cinema')
                            checked
                        @endif
                        @endforeach>
                        <label for="cinema">Prestador de Serviço de Cinema, Espetáculos ou Similares.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="demais" name="aplicacoes_especiais[]" value="demais" @foreach ($aplicacoes as $valor)
                        @if ($valor == 'demais')
                            checked
                        @endif
                        @endforeach>
                        <label for="demais">Demais Atividades.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="simples_nacional" name="aplicacoes_especiais[]" value="simples_nacional"
                            @foreach ($aplicacoes as $valor)
                        @if ($valor == 'simples_nacional')
                            checked
                        @endif
                        @endforeach>
                        <label for="simples_nacional">Estabelecimento Enquadrado no SIMPLES NACIONAL (Art. 5º Ato COPETE
                            da
                            ER-PAF-ECF).</label>
                    </div>
                    @error('aplicacoes_especiais')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="tab-pane" id="impressao" role="tabpanel">
                <div class="form-group col-md-12" id="botoes">
                    <a class="btn btn-primary anterior">Voltar</a>
                    <a class="btn btn-default pull-right">Próximo</a>
                </div>
                <div class="form-group control-label col-md-5">
                    <label for="forma_impressao">Forma de Impressão de Item em Cupom Fiscal:</label>
                    <div>
                        <input type="checkbox" id="concomitante" name="forma_impressao[]" value="concomitante" @foreach ($forma_impressao as $valor)
                        @if ($valor == 'concomitante')
                            checked
                        @endif
                        @endforeach>
                        <label for="concomitante">Concomitante</label>
                    </div>
                    <div>
                        <input type="checkbox" id="nao_concomitante" name="forma_impressao[]" value="nao_concomitante"
                            @foreach ($forma_impressao as $valor)
                        @if ($valor == 'nao_concomitante')
                            checked
                        @endif
                        @endforeach>
                        <label for="nao_concomitante">Não Concomitante com Impressão de DAV</label>
                    </div>
                    <div>
                        <input type="checkbox" id="nao_concomitante_pv" name="forma_impressao[]" value="nao_concomitante_pv"
                            @foreach ($forma_impressao as $valor)
                        @if ($valor == 'nao_concomitante_pv')
                            checked
                        @endif
                        @endforeach>
                        <label for="nao_concomitante_pv">Não Concomitante com controle de Pré-venda</label>
                    </div>
                    <div>
                        <input type="checkbox" id="nao_concomitante_cc" name="forma_impressao[]" value="nao_concomitante_cc"
                            @foreach ($forma_impressao as $valor)
                        @if ($valor == 'nao_concomitante_cc')
                            checked
                        @endif
                        @endforeach>
                        <label for="nao_concomitante_cc">Não Concomitante com controle de Conta de Cliente</label>
                    </div>
                    <div>
                        <input type="checkbox" id="dav_sem_impressao" name="forma_impressao[]" value="dav_sem_impressao"
                            @foreach ($forma_impressao as $valor)
                        @if ($valor == 'dav_sem_impressao')
                            checked
                        @endif
                        @endforeach>
                        <label for="dav_sem_impressao">DAV - Emitido sem possibilidade de Impressão</label>
                    </div>
                    <div>
                        <input type="checkbox" id="dav_impresso_nao_fiscal" name="forma_impressao[]"
                            value="dav_impresso_nao_fiscal" @foreach ($forma_impressao as $valor)
                        @if ($valor == 'dav_impresso_nao_fiscal')
                            checked
                        @endif
                        @endforeach>
                        <label for="dav_impresso_nao_fiscal">DAV - Impresso em Impressora Não Fiscal</label>
                    </div>
                    <div>
                        <input type="checkbox" id="dav_impresso_ecf" name="forma_impressao[]" value="dav_impresso_ecf"
                            @foreach ($forma_impressao as $valor)
                        @if ($valor == 'dav_impresso_ecf')
                            checked
                        @endif
                        @endforeach>
                        <label for="dav_impresso_ecf">DAV - Impresso em ECF</label>
                    </div>
                    @error('forma_impressao')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-5">
                    <label for="perfis">Perfis:</label>
                    <div>
                        <input type="checkbox" id="perfil_r" name="perfis[]" value="perfil_r" @foreach ($perfis as $valor)
                        @if ($valor == 'perfil_r')
                            checked
                        @endif
                        @endforeach>
                        <label for="perfil_r">Perfil R</label>
                    </div>
                    <div>
                        <input type="checkbox" id="perfil_s" name="perfis[]" value="perfil_s" @foreach ($perfis as $valor)
                        @if ($valor == 'perfil_s')
                            checked
                        @endif
                        @endforeach>
                        <label for="perfil_s">Perfil S</label>
                    </div>
                    <div>
                        <input type="checkbox" id="perfil_t" name="perfis[]" value="perfil_t" @foreach ($perfis as $valor)
                        @if ($valor == 'perfil_t')
                            checked
                        @endif
                        @endforeach>
                        <label for="perfil_t">Perfil T</label>
                    </div>
                    <div>
                        <input type="checkbox" id="perfil_u" name="perfis[]" value="perfil_u" @foreach ($perfis as $valor)
                        @if ($valor == 'perfil_u')
                            checked
                        @endif
                        @endforeach>
                        <label for="perfil_u">Perfil U</label>
                    </div>
                    <div>
                        <input type="checkbox" id="perfil_v" name="perfis[]" checked value="perfil_v" @foreach ($perfis as $valor)
                        @if ($valor == 'perfil_v')
                            checked
                        @endif
                        @endforeach>
                        <label for="perfil_v">Perfil V</label>
                    </div>
                    <div>
                        <input type="checkbox" id="perfil_w" name="perfis[]" value="perfil_w" @foreach ($perfis as $valor)
                        @if ($valor == 'perfil_w')
                            checked
                        @endif
                        @endforeach>
                        <label for="perfil_w">Perfil W</label>
                    </div>
                    <div>
                        <input type="checkbox" id="perfil_y" name="perfis[]" value="perfil_y" @foreach ($perfis as $valor)
                        @if ($valor == 'perfil_y')
                            checked
                        @endif
                        @endforeach>
                        <label for="perfil_y">Perfil Y</label>
                    </div>
                    <div>
                        <input type="checkbox" id="perfil_z" name="perfis[]" value="perfil_z" @foreach ($perfis as $valor)
                        @if ($valor == 'perfil_z')
                            checked
                        @endif
                        @endforeach>
                        <label for="perfil_z">Perfil Z</label>
                    </div>
                    @error('perfis')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <input type="submit" class="btn btn-success" value="Salvar Alterações">
                </div>
            </div>
        </div>
    </form>
@endsection
