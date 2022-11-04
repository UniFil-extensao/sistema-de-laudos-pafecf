@extends('layouts.app')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <h1>Gerar Laudo</h1>
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

    <form action="/laudo" method="POST" name="formulario">
        @csrf
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#base" role="tab"><b>Informações Básicas</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#homologacao" role="tab"><b>Arquivos da Homologação</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#identificacao" role="tab"><b>Identificação dos
                        Executáveis</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#relatorio" role="tab"><b>Relatório Final</b></a>
            </li>
        </ul>

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

        <br>

        <div class="tab-content">
            <div class="tab-pane active" id="base" role="tabpanel">
                <div class="form-group col-md-12" id="botoes">
                    <a class="btn btn-default">Voltar</a>
                    <a class="btn btn-primary proximo pull-right">Próximo</a>
                </div>
                <div class="form-group control-label col-md-6">
                    <label for="empresa">Selecione a Empresa</label>
                    <select name="empresa" id="empresa" required>
                        <option selected value="">Selecione uma Empresa</option>
                        @foreach ($empresas as $empresa)
                            <option value="{{ $empresa->id }}">{{ $empresa->razao_social }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group control-label col-md-6">
                    <label for="pdv">Selecione o PDV Homologado</label>
                    <select name="pdv" id="pdv" required>
                        <option selected value="">Nenhuma Empresa Selecionada</option>
                    </select>
                </div>

                <script>
                    $(document).ready(function() {
                        $("#empresa").change(function() {
                            let id = this.value;
                            $.get('/getPDVs?empresa=' + id, function(data) {
                                $("#pdv").html(data);
                            })
                        })
                    })
                </script>

                <script>
                    $(function() {
                        var hoje = new Date();

                        var mes = hoje.getMonth() + 1;
                        var dia = hoje.getDate();
                        var ano = hoje.getFullYear();
                        if (mes < 10)
                            mes = '0' + mes.toString();
                        if (dia < 10)
                            dia = '0' + dia.toString();

                        var maxDate = ano + '-' + mes + '-' + dia;
                        ano = ano - 1;
                        var minDate = ano + '-' + mes + '-' + dia;

                        $('#data_inicio').attr('max', maxDate);
                        $('#data_inicio').attr('min', minDate);
                        $('#data_termino').attr('max', maxDate);
                        $('#data_termino').attr('min', minDate);
                    });
                </script>

                <div class="form-group control-label col-md-3">
                    <label for="data_inicio">Data de Início do Serviço</label>
                    <input id="data_inicio" type="date" class="form-control" name="data_inicio"
                        onkeydown="return false" />
                    @error('data_inicio')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-3">
                    <label for="data_termino">Data de Término do Serviço</label>
                    <input id="data_termino" type="date" class="form-control" name="data_termino"
                        onkeydown="return false" />
                    @error('data_termino')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-4">
                    <label for="versao_er">Versão da Especificação de Requisitos</label>
                    <input type="text" class="form-control @error('versao_er') is-invalid @enderror" id="versao_er"
                        name="versao_er" placeholder="Versão ER" value="02.06">
                    @error('versao_er')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="control-label col-md-12">
                    <label>Identificação do Envelope de Segurança: </label>
                </div>
                <div class="form-group control-label col-md-4">
                    <label for="envelope_seguranca_marca">Marca</label>
                    <input type="text" class="form-control @error('envelope_seguranca_marca') is-invalid @enderror"
                        id="envelope_seguranca_marca" name="envelope_seguranca_marca" placeholder="Marca" value="Starlock">
                    @error('envelope_seguranca_marca')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-3">
                    <label for="envelope_seguranca_modelo">Modelo</label>
                    <input type="text" class="form-control @error('envelope_seguranca_modelo') is-invalid @enderror"
                        id="envelope_seguranca_modelo" name="envelope_seguranca_modelo" placeholder="Modelo" value="7">
                    @error('envelope_seguranca_modelo')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-3">
                    <label for="numero_envelope">Número do Envelope</label>
                    <input type="text" class="form-control @error('numero_envelope') is-invalid @enderror"
                        id="numero_envelope" name="numero_envelope" placeholder="Número">
                    @error('numero_envelope')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

            <div class="tab-pane" id="homologacao" role="tabpanel">
                <form action="{{ route('laudo.carregarArquivos') }}" method="post" name="formulario">
                    @csrf
                    <div class="form-group col-md-12" id="botoes">
                        <a class="btn btn-primary proximo pull-right">Próximo</a>
                        <a class="btn btn-primary anterior">Voltar</a>
                    </div>
                    <div class="control-label col-md-12">
                        <label>Carregue os Arquivos Gerados na Homologação: </label>
                    </div>
                    <div class="form-group control-label col-md-6">
                        <label for="relacao">Arquivo relacao.txt</label>
                        <input type="hidden" name="relacao" id="relacao">
                        <input type="file" accept=".txt">
                    </div>
                    <br>
                    <div class="form-group control-label col-md-6">
                        <label for="relacao2">Arquivo relacao2.txt</label>
                        <input type="hidden" name="relacao2" id="relacao2">
                        <input type="file" accept=".txt">
                    </div>
                    <div class="form-group control-label col-md-6">
                        <label for="md5">Arquivo md5.txt</label>
                        <input type="hidden" name="md5" id="md5">
                        <input type="file" accept=".txt">
                    </div>
                    <br>
                    <div class="form-group control-label col-md-6">
                        <label for="bytes">Arquivo bytes.txt</label>
                        <input type="hidden" name="bytes" id="bytes">
                        <input type="file" accept=".txt">
                    </div>
                    <div class="form-group col-md-12">
                        <input type="submit" class="btn btn-success" value="Validar Arquivos">
                    </div>
                </form>
            </div>

            <div class="tab-pane" id="identificacao" role="tabpanel">
                <div class="form-group col-md-12" id="botoes">
                    <a class="btn btn-primary proximo pull-right">Próximo</a>
                    <a class="btn btn-primary anterior">Voltar</a>
                </div>
                <div class="control-label col-md-12">
                    <label>Identificação do Sistema de Gestão ou Retaguarda que executa pelo menos um dos Requisitos
                        Atribuídos
                        ao
                        PAF-ECF, que funciona integrado ao PAF-ECF: </label>
                </div>
                <div class="form-group control-label col-md-2">
                    <label for="requisitos_executados_sgbd">Requisitos Executados</label>
                    <input type="text" class="form-control @error('requisitos_executados_sgbd') is-invalid @enderror"
                        id="requisitos_executados_sgbd" name="requisitos_executados_sgbd" placeholder="Requisitos"
                        value="II">
                    @error('requisitos_executados_sgbd')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-7">
                    <label for="executavel_sgbd">Escolha o Arquivo Executável Responsável pelo SGBD e seu Respectivo
                        MD5</label>
                    @error('executavel_sgbd')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                    <div style="margin-top: -22px;">
                        <label for="executavel_sgbd"></label>
                        <input type="text" class="form-control @error('executavel_sgbd') is-invalid @enderror"
                            id="executavel_sgbd" name="executavel_sgbd" value="">
                    </div>
                </div>
                <br>
                <div class="control-label col-md-12">
                    <label>Identificação dos Sistemas de PED (SPED/SINTEGRA/DOCUMENTOS/LIVROS) que Funcionam integrados ao
                        PAF-ECF:</label>
                </div>
                <div class="form-group control-label col-md-4">
                    <label for="funcao_sped">Função</label>
                    <input type="text" class="form-control @error('funcao_sped') is-invalid @enderror"
                        id="funcao_sped" name="funcao_sped" placeholder="Requisitos"
                        value="SPED/SINTEGRA/DOCUMENTO E LIVROS">
                    @error('funcao_sped')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group control-label col-md-7">
                    <label for="executavel_sped">Escolha o Arquivo Executável Responsável pelo SPED e seu Respectivo
                        MD5</label>
                    @error('executavel_sped')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                    <div style="margin-top: -22px;">
                        <label for="executavel_sped"></label>
                        <input type="text" class="form-control @error('executavel_sped') is-invalid @enderror"
                            id="executavel_sped" name="executavel_sped" value="">
                    </div>
                </div>
                <div class="control-label col-md-12">
                    <label>Identificação dos Sistemas de PED que geram a NF-e e funcionam integrados ao PAF-ECF: </label>
                </div>
                <div class="form-group control-label col-md-7">
                    <label for="executavel_nfe">Escolha o Arquivo Executável Responsável pelo gerador de NF-e e seu
                        Respectivo MD5
                    </label>
                    @error('executavel_nfe')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                    <div style="margin-top: -22px;">
                        <label for="executavel_nfe"></label>
                        <input type="text" class="form-control @error('executavel_nfe') is-invalid @enderror"
                            id="executavel_nfe" name="executavel_nfe" value="">
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="relatorio" role="tabpanel">
                <div class="form-group col-md-12" id="botoes">
                    <a class="btn btn-primary anterior">Voltar</a>
                    <a class="btn btn-default pull-right">Próximo</a>
                </div>
                <div class="control-label col-md-12">
                    <label>Identificação dos Equipamentos ECF Utilizados para a Análise Funcional: </label>
                </div>

                <div class="form-group control-label col-md-6" style="width: auto">
                    <label for="ecf_analise_marca">Marca</label>
                    @error('ecf_analise_marca')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                    <select name="ecf_analise_marca" id="ecf_analise_marca" required>
                        <option selected value="">Selecione uma Marca</option>
                        @foreach ($marcas as $marca)
                            <option value="{{ $marca->id }}">{{ $marca->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group control-label col-md-6">
                    <label for="ecf_analise_modelo">Modelo</label>
                    @error('ecf_analise_modelo')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                    <select name="ecf_analise_modelo" id="ecf_analise_modelo" required>
                        <option selected value="">Selecione Primeiro a Marca</option>
                    </select>
                </div>

                <div class="form-group control-label col-md-4 form-group control-label col-md-6">
                    <table class="table" id="tabela_ecfs">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align: center">Marca</th>
                                <th scope="col" style="text-align: center">Modelo</th>
                                <th scope="col" style="text-align: center"><a class="btn btn-default"
                                        href="javascript:void(0)" id="AddButtom"><img id="mais"
                                            src="{{ url('img\mais.png') }}" width="15" heigth="15"></a></th>
                            </tr>
                        </thead>
                        <tbody id="marcaModeloAnalise">

                        </tbody>
                    </table>
                </div>

                <script>
                    $(document).ready(function() {
                        $("#ecf_analise_marca").change(function() {
                            let id = this.value;
                            $.get('/getModelosStore?ecf_analise_marca=' + id, function(data) {
                                $("#ecf_analise_modelo").html(data);
                            })
                        })
                    })
                </script>

                <div class="control-label col-md-12">
                    <label>Relação de marcas e modelos de equipamentos ECF compatíveis com o PAF-ECF: </label>
                </div>

                <div class="form-group control-label col-md-12">
                    <label>Marcas e Modelos Compatíveis e Utilizados:</label>
                </div>

                <div class="form-group control-label col-md-6" style="width: auto">
                    <label for="relacao_ecfs_marca">Marca</label>
                    @error('relacao_ecfs_marca')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                    <select name="relacao_ecfs_marca" id="relacao_ecfs_marca" required>
                        <option selected value="">Selecione uma Marca</option>
                        @foreach ($marcas as $marca)
                            <option value="{{ $marca->id }}">{{ $marca->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group control-label col-md-6">
                    <label for="relacao_ecfs_modelo">Modelo</label>
                    @error('relacao_ecfs_modelo')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                    <select name="relacao_ecfs_modelo" id="relacao_ecfs_modelo" required>
                        <option selected value="">Selecione Primeiro a Marca</option>
                    </select>
                </div>

                <script>
                    $(document).ready(function() {
                        $("#relacao_ecfs_marca").change(function() {
                            let id = this.value;
                            $.get('/getModelosAnaliseStore?relacao_ecfs_marca=' + id, function(data) {
                                $("#relacao_ecfs_modelo").html(data);
                            })
                        })
                    })
                </script>

                <div class="form-group control-label col-md-4 form-group control-label col-md-6">
                    <table class="table" id="tabela_relacao_ecfs">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align: center">Marca</th>
                                <th scope="col" style="text-align: center">Modelo</th>
                                <th scope="col" style="text-align: center"><a class="btn btn-default"
                                        href="javascript:void(0)" id="buttomMore"><img id="mais"
                                            src="{{ url('img\mais.png') }}" width="15" heigth="15"></a></th>
                            </tr>
                        </thead>
                        <tbody id="marcaModeloRelacao">

                        </tbody>
                    </table>
                </div>

                <div class="form-group control-label col-md-12">
                    <label for="parecer_conclusivo">Parecer conclusivo: </label>
                    @error('parecer_conclusivo')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                    <div>
                        <input type="radio" id="nao_conformidade" name="parecer_conclusivo" value="0">
                        <label for="nao_conformidade">Constatada(s) “Não Conformidade” relacionada(s) no campo “Relatório
                            de Não Conformidade”.
                        </label>
                    </div>
                    <div>
                        <input type="radio" id="em_conformidade" name="parecer_conclusivo" value="1">
                        <label for="em_conformidade">Não constatou “Não Conformidade” em nenhum dos testes aplicados. O
                            sistema passou em todas as especificações e testes.
                        </label>
                    </div>
                </div>
                <div class="control-label col-md-12">
                    <label>Relatório de não conformidade: <br> <small class="form-group control-label"
                            style="color: red">Só
                            deve ser preenchido com comentários caso existam inconfomidades no sistema. Favor adicionar o
                            item do requisito e o comentário referente.</small>
                    </label>
                </div>
                <div class="control-label col-md-4" style="margin-top: 8px">
                    <label for="comentarios">Comentários: </label>
                    <textarea type="text" class="form-control" id="comentarios" name="comentarios" placeholder="Comentários"
                        rows="6" cols="40" maxlength="500"></textarea>
                </div>
                <div class="form-group control-label col-md-4">
                    <label for="responsavel_testes">Responsável da Empresa pela Execução dos Testes:</label>
                    <input type="text" class="form-control @error('responsavel_testes') is-invalid @enderror"
                        id="responsavel_testes" name="responsavel_testes" placeholder="Responsável pelos Testes">
                    @error('responsavel_testes')
                        <div class="invalid-feedback" style="color: red">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <input type="submit" class="btn btn-success" value="Cadastrar Laudo">
                </div>
            </div>
        </div>
    </form>
    <script defer>
        var receber
        receber = $('#marcaModeloAnalise')

        $(document).ready(function() {
            $("#AddButtom").click(function() {
                var analise_marca = $("#ecf_analise_marca").children("option:selected").text()
                var analise_modelo = $("#ecf_analise_modelo").children("option:selected").text()

                var botaoHtml =
                    `<a class="remove" href="javascript:void(0)"><img src="{{ url('img/minimize-o-sinal.png') }}" width="15" heigth="15"></a>`

                var innerHtml = '<tr>' +
                    '<td>' + '<input style="border: none" name="an_marca[]" value="' + analise_marca +
                    '">' + '</td>' +
                    '<td>' + '<input style="border: none" name="an_modelo[]" value="' + analise_modelo +
                    '">' + '</td>' +
                    '<td>' + botaoHtml + '</td>' +
                    '</tr>'
                receber.append(innerHtml)

            });

            $(receber).on("click", ".remove", function(e) {
                e.preventDefault();
                $(this).parent().parent('tr').remove();

            });
        })
    </script>

    <script defer>
        var wrapper
        wrapper = $('#marcaModeloRelacao')

        $(document).ready(function() {
            $("#buttomMore").click(function() {
                var relacao_marca = $("#relacao_ecfs_marca").children("option:selected").text()
                var relacao_modelo = $("#relacao_ecfs_modelo").children("option:selected").text()

                var HTMLButton =
                    `<a class="remove" href="javascript:void(0)"><img src="{{ url('img/minimize-o-sinal.png') }}" width="15" heigth="15"></a>`

                var innerHTML = '<tr>' +
                    '<td>' + '<input style="border: none" name="re_marca[]" value="' + relacao_marca +
                    '">' + '</td>' +
                    '<td>' + '<input style="border: none" name="re_modelo[]" value="' + relacao_modelo +
                    '">' + '</td>' +
                    '<td>' + HTMLButton + '</td>' +
                    '</tr>'
                wrapper.append(innerHTML)

            });

            $(wrapper).on("click", ".remove", function(e) {
                e.preventDefault();
                $(this).parent().parent('tr').remove();

            });
        })
    </script>

@endsection
