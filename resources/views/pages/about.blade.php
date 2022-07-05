@extends('layouts.app')

@section('content')
    <h1 style="color: #f97316">{{ $title }}</h1>
    <div class="title-body col-md-9">
        <h2 style="color: black; font-weight: bold">Programa Aplicativo Fiscal - Unifil</h2>
        <font size="3" style="color: #636b6f">
            <p>O Programa Aplicativo Fiscal do Emissor de Cupom Fiscal, mais conhecido pela sigla PAF-ECF, é um programa do
                Governo Federal que tem como objetivo aumentar a fiscalização contra desvios fiscais, como sonegação de
                impostos e prática de caixa dois.</p>
            <p>Este programa regulamenta o protocolo de comunicação de sistemas de Ponto de Venda, os PDVs, com os
                equipamentos Emissores de Cupom Fiscal, os ECF, como as famosas impressoras térmicas de caixas de pagamento.
            </p>
            <p>Suas normas e regras estão estabelecidas em lei e definidas no Ato Cotepe 06/08 e no Convênio ICMS 15/08,
                ambos do Fisco.</p>
        <br>
        </font>
        <h2 style="color: black; font-weight: bold">Como funciona?</h2>
        <font size="3" style="color: #636b6f">
            <p>O programa define que, todo sistema de informação que utilize ECF, deve ser certificado por uma instituição
                credenciada, recebendo uma assinatura eletrônica única que o identifica e autoriza a se comunicar com o
                equipamento.</p>
            <p>Sem essa assinatura, a impressora rejeita pedidos de operação do computador.</p>
            <p>Utilizar um ECF que não possua este mecanismo, ou tentar contorná-lo nas que possuem, é ilegal em alguns
                estados do Brasil.</p>
            <p>Mesmo com o acesso legal ao ECF, o sistema precisa seguir um protocolo de operações, que varia conforme a
                finalidade da operação financeira, havendo regras específicas para postos de combustíveis, bares,
                restaurantes, farmácias de manipulação, oficina de consertos, transportes públicos, dentre outros.</p>
            <p>Desde 2009, a UniFil é uma instituição credenciada a homologar sistemas pelo PAF-ECF, com emissão de laudo de
                certificação válido pelo CONFAZ, gerando a assinatura digital para seu sistema interfacear com máquinas ECF
                legais.</p>

            <p>A Instituição oferece tanto consultoria prévia de atendimento personalizado para tirar dúvidas, quanto
                sessões de avaliação para homologação.</p>

            <p>Tais serviços são oferecidos pelo Colegiado dos cursos da área de computação da UniFil, com conhecimento
                técnico de sistemas em geral e infraestrutura de laboratórios de informática.</p>

            <p>A atuação é de extrema correção e presteza, com mais de 10 anos de experiência, atendendo mais de 180
                empresas de todo o Brasil, em mais de 600 homologações.</p>

            <p>Entre em contato e solicite avaliação de seus sistemas em nossa instituição!</p>

            <p>Estão disponíveis ofertas especiais para renovação de laudos, que vencem em dois anos por lei, e para membros
                da APL de Londrina.</p>
        </font>
        <br>
        <h2 style="color: black; font-weight: bold">Empresas Homologadas</h2>
        <font size="3" style="color: #636b6f;">
            <p>"lista de empresas de todos os anos"</p>
        </font>
        <br>
        <h2 style="color: black; font-weight: bold">Atendimento</h2>
        <font size="3" style="color: #636b6f">
            <body>
                De segunda a sexta-feira, das 08h às 17h30 <br />
                Av. Juscelino Kubitschek, nº 1626, Vila Ipiranga, Londrina – PR (Campus Sede)<br />
                43 3375 7326<br />
                computacao@unifil.br / paf.ecf@unifil.br<br />
            </body>
        </font>
    </div>
@endsection
