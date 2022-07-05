@extends('layouts.app')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <a href="/cadastros/{{ $empresa->id }}" class="btn btn-default">Editar Cadastro da Empresa</a>
    <h1>Cadastro de Ponto de Venda - PDV</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h3>Empresa Requerente: <b>{{ $empresa->razao_social }}</b></h3>
    @if (count($pdvs) > 0)
        <p>Lista de PDV's Cadastrados desta Empresa: </p>
        <div class="well">
            <ul>
                @foreach ($pdvs as $pdv)
                    <li><small><a style="color: black" href="/cadastros/PDV/{{$pdv->id}}">{{ $pdv->nome_comercial }}</a></small></li>
                @endforeach
            </ul>
        </div>
    @else
        <p>Não há nenhum PDV cadastrado por essa empresa</p>
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
    <form action="{{ route('cadastroPDV.store', $empresa, $empresa->id) }}" method="POST" name="formulario">
        @csrf
        <h3>Informações do Ponto de Venda: </h3>
        <small>Os campos obrigatórios estão representados com um asterisco (*).</small>
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#base" role="tab"><b>Informações Base</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#aplicacoes" role="tab"><b>Aplicações Especiais</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#impressao" role="tab"><b>Forma de Impressão</b></a>
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
                        id="nome_comercial" name="nome_comercial" placeholder="Nome comercial">
                    @error('nome_comercial')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-5">
                    <label for="versao">Versão do Programa</label>
                    <input type="text" class="form-control" id="versao" name="versao"
                        placeholder="Para qual versão vai o programa?">
                    @error('versao')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-12">
                    <label for="nome_principal_executavel">Nome do Executável Principal do Programa</label>
                    <input type="text" class="form-control" id="nome_principal_executavel"
                        name="nome_principal_executavel" placeholder="Nome Principal Executável">
                    @error('nome_principal_executavel')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-4">
                    <label for="linguagem">Linguagem de Programação</label>
                    <input type="text" class="form-control @error('linguagem') is-invalid @enderror" id="linguagem"
                        name="linguagem" placeholder="Nome comercial">
                    @error('linguagem')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-4">
                    <label for="sistema_operacional">Sistema Operacional</label>
                    <input type="text" class="form-control @error('sistema_operacional') is-invalid @enderror"
                        id="sistema_operacional" name="sistema_operacional" placeholder="Nome comercial">
                    @error('sistema_operacional')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-4">
                    <label for="data_base">Gerenciador de Banco de Dados</label>
                    <input type="text" class="form-control @error('data_base') is-invalid @enderror" id="data_base"
                        name="data_base" placeholder="Nome comercial">
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
                        <option value="comercializavel">Comercializável</option>
                        <option value="exclusivo_proprio">Exclusivo Próprio</option>
                        <option value="exclusivo_tercerizado">Exclusivo Tercerizado</option>
                    </select>
                </div>
                <div class="form-group control-label col-md-4">
                    <label for="tipo_funcionamento">Tipo de Funcionamento:</label>
                    <select name="tipo_funcionamento" id="tipo_funcionamento">
                        <option value="stand_alone">Exclusivo Stand Alone</option>
                        <option value="rede">Em Rede</option>
                        <option value="parametrizavel">Parametrizável</option>
                    </select>
                </div>
                <div class="form-group control-label col-md-4">
                    <label for="nfe">Emite Nota Fiscal Eletrônica - NF-e:</label>
                    <select name="nfe" id="nfe">
                        <option value="sim">Sim</option>
                        <option value="nao">Não</option>
                    </select>
                </div>
                <div class="form-group control-label col-md-6">
                    <label for="sped">Geração do Arquivo SINTEGRA ou EFD(SPED):</label>
                    <select name="sped" id="sped">
                        <option value="pelo_paf">Pelo PAF</option>
                        <option value="retaguarda">Pelo Sistema de Retaguarda</option>
                        <option value="ped_efd">Pelo Sistema de PED ou EFC</option>
                    </select>
                </div>
                <div class="form-group control-label col-md-5">
                    <label for="nfce">Emite Nota Fiscal Consumidor Eletrônica - NFC-e:</label>
                    <select name="nfce" id="nfce">
                        <option value="sim">Sim</option>
                        <option value="nao">Não</option>
                    </select>
                </div>
                <div class="form-group control-label col-md-6">
                    <label for="tratamento_interrupcao">Tratamento de Interrupção Durante a Emissão do Cupom
                        Fiscal:</label>
                    <select name="tratamento_interrupcao" id="tratamento_interrupcao">
                        <option value="recupera">Recuperação dos Dados</option>
                        <option value="cancela">Cancelamento Automático</option>
                        <option value="bloqueia">Bloqueio de Funções</option>
                    </select>
                </div>
                <div class="form-group control-label col-md-6">
                    <label for="integracao_paf">Integração do Programa Aplicativo Fiscal:</label>
                    <select name="integracao_paf" id="integracao_paf">
                        <option value="gestao_retaguarda">Com Sistema de Gestão ou Retaguarda</option>
                        <option value="ped">Com Sistema PED</option>
                        <option value="ambos">Com Ambos</option>
                        <option value="nao_integrado">Não Integrado</option>
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

                    <div>
                        <input type="checkbox" id="posto_com_bomba" name="aplicacoes_especiais[]" value="posto_com_bomba">
                        <label for="posto_com_bomba">Posto revendedor de Combusível COM Sistema de Interligação de
                            Bombas.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="posto_sem_bomba" name="aplicacoes_especiais[]" value="posto_sem_bomba">
                        <label for="posto_sem_bomba">Posto revendedor de Combusível SEM Sistema de Interligação de
                            Bombas.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="oficina_dav_os" name="aplicacoes_especiais[]" value="oficina_dav_os">
                        <label for="oficina_dav_os">Oficina de Conserto COM DAV-OS.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="oficina_conta_cliente" name="aplicacoes_especiais[]"
                            value="oficina_conta_cliente">
                        <label for="oficina_conta_cliente">Oficina de Conserto COM CONTA DE CLIENTE.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="bar_ecf_restaurante" name="aplicacoes_especiais[]"
                            value="bar_ecf_restaurante">
                        <label for="bar_ecf_restaurante">Bar, Restaurante e estabelecimento similiar com utilização de
                            ECF-RESTAURANTE e balança interligada.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="bar_ecf_normal" name="aplicacoes_especiais[]" value="bar_ecf_normal">
                        <label for="bar_ecf_normal">Bar, Restaurante e estabelecimento similiar com utilização de
                            ECF-NORMAL e balança interligada.
                        </label>
                    </div>
                    <div>
                        <input type="checkbox" id="bar_ecf_restaurante_sem_balanca" name="aplicacoes_especiais[]"
                            value="bar_ecf_restaurante_sem_balanca">
                        <label for="bar_ecf_restaurante_sem_balanca">Bar, Restaurante e estabelecimento similiar com
                            utilização de ECF-RESTAURANTE SEM balança interligada.
                        </label>
                    </div>
                    <div>
                        <input type="checkbox" id="bar_ecf_normal_sem_balanca" name="aplicacoes_especiais[]"
                            value="bar_ecf_normal_sem_balanca">
                        <label for="bar_ecf_normal_sem_balanca">Bar, Restaurante e estabelecimento similiar com
                            utilização de ECF-NORMAL SEM balança interligada.
                        </label>
                    </div>
                    <div>
                        <input type="checkbox" id="farmacia" name="aplicacoes_especiais[]" value="farmacia">
                        <label for="farmacia">Farmácia de Manipulação.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="transporte_passageiros" name="aplicacoes_especiais[]"
                            value="transporte_passageiros">
                        <label for="transporte_passageiros">Transporte de Passageiros.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="posto_pedagio" name="aplicacoes_especiais[]" value="posto_pedagio">
                        <label for="posto_pedagio">Posto de Pedágio.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="moteis" name="aplicacoes_especiais[]" value="moteis">
                        <label for="moteis">Estacionamento, Motéis e Similares, que pratiquem o Controle de Tráfego de
                            Veículos ou Pessoas.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="cinema" name="aplicacoes_especiais[]" value="cinema">
                        <label for="cinema">Prestador de Serviço de Cinema, Espetáculos ou Similares.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="demais" name="aplicacoes_especiais[]" value="demais" checked>
                        <label for="demais">Demais Atividades.</label>
                    </div>
                    <div>
                        <input type="checkbox" id="simples_nacional" name="aplicacoes_especiais[]" value="simples_nacional">
                        <label for="simples_nacional">Estabelecimento Enquadrado no SIMPLES NACIONAL (Art. 5º Ato COPETE
                            da ER-PAF-ECF).</label>
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
                        <input type="checkbox" id="concomitante" name="forma_impressao[]" value="concomitante">
                        <label for="concomitante">Concomitante</label>
                    </div>
                    <div>
                        <input type="checkbox" id="nao_concomitante" name="forma_impressao[]" value="nao_concomitante">
                        <label for="nao_concomitante">Não Concomitante com Impressão de DAV</label>
                    </div>
                    <div>
                        <input type="checkbox" id="nao_concomitante_pv" name="forma_impressao[]"
                            value="nao_concomitante_pv">
                        <label for="nao_concomitante_pv">Não Concomitante com controle de Pré-venda</label>
                    </div>
                    <div>
                        <input type="checkbox" id="nao_concomitante_cc" name="forma_impressao[]"
                            value="nao_concomitante_cc">
                        <label for="nao_concomitante_cc">Não Concomitante com controle de Conta de Cliente</label>
                    </div>
                    <div>
                        <input type="checkbox" id="dav_sem_impressao" name="forma_impressao[]" value="dav_sem_impressao">
                        <label for="dav_sem_impressao">DAV - Emitido sem possibilidade de Impressão</label>
                    </div>
                    <div>
                        <input type="checkbox" id="dav_impresso_nao_fiscal" name="forma_impressao[]"
                            value="dav_impresso_nao_fiscal">
                        <label for="dav_impresso_nao_fiscal">DAV - Impresso em Impressora Não Fiscal</label>
                    </div>
                    <div>
                        <input type="checkbox" id="dav_impresso_ecf" name="forma_impressao[]" value="dav_impresso_ecf">
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
                        <input type="checkbox" id="perfil_r" name="perfis[]" value="perfil_r">
                        <label for="perfil_r">Perfil R</label>
                    </div>
                    <div>
                        <input type="checkbox" id="perfil_s" name="perfis[]" value="perfil_s">
                        <label for="perfil_s">Perfil S</label>
                    </div>
                    <div>
                        <input type="checkbox" id="perfil_t" name="perfis[]" value="perfil_t">
                        <label for="perfil_t">Perfil T</label>
                    </div>
                    <div>
                        <input type="checkbox" id="perfil_u" name="perfis[]" value="perfil_u">
                        <label for="perfil_u">Perfil U</label>
                    </div>
                    <div>
                        <input type="checkbox" id="perfil_v" name="perfis[]" checked value="perfil_v">
                        <label for="perfil_v">Perfil V</label>
                    </div>
                    <div>
                        <input type="checkbox" id="perfil_w" name="perfis[]" value="perfil_w">
                        <label for="perfil_w">Perfil W</label>
                    </div>
                    <div>
                        <input type="checkbox" id="perfil_y" name="perfis[]" value="perfil_y">
                        <label for="perfil_y">Perfil Y</label>
                    </div>
                    <div>
                        <input type="checkbox" id="perfil_z" name="perfis[]" value="perfil_z">
                        <label for="perfil_z">Perfil Z</label>
                    </div>
                    @error('perfis')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <input type="submit" class="btn btn-success" value="Cadastrar PDV">
                </div>
            </div>
        </div>
    </form>
@endsection
