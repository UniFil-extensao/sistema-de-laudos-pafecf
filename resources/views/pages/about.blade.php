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
            <table>
                <tr>
                    <td>ACCIOLY S/A IMPORTACAO E COMERCIO</td>
                    <td>ADF – INFORMÁTICA E AUTOMAÇÃO COMERCIAL LTDA</td>
                </tr>

                <tr>
                    <td>AFTJ SISTEMAS DE COMPUTAÇÃO LTDA</td>
                    <td>AGROTIS AGROINFORMÁTICA LTDA</td>
                </tr>

                <tr>
                    <td>ANDERSON DA SILVA - SOFTWARE E CONSULTORIA ME</td>
                    <td>ARANDU SISTEMAS LTDA</td>
                </tr>

                <tr>
                    <td>ARROBBA SISTEMAS LTDA</td>
                    <td>ASTERSOFT SISTEMAS LTDA</td>
                </tr>

                <tr>
                    <td>AUTOMATIZA CONSULTORIA E SISTEMAS LTDA</td>
                    <td>BYTECOM SISTEMAS E SERVIÇOS LTDA</td>
                </tr>

                <tr>
                    <td>C-SYSTEMS CONSULTORIA E SISTEMAS LTDA</td>
                    <td>CELL CORPORAÇÃO TECNOLÓGICA LTDA – ME</td>
                </tr>

                <tr>
                    <td>CELTA SISTEMAS LTDA ME</td>
                    <td>CERTTUS SISTEMAS AUTOMOTIVOS LTDA.</td>
                </tr>

                <tr>
                    <td>CFG TECNOLOGIA DE INFORMAÇÃO LTDA</td>
                    <td>CHEINA INFORMÁTICA LTDA. </td>
                </tr>

                <tr>
                    <td>COMPUSOFT SOLUÇÕES EM INFORMAÇÕES LTDA</td>
                    <td>CONNECTUS DESENVOLVIMENTO DE SOFTWARES LTDA.</td>
                </tr>

                <tr>
                    <td>CONSISANET SISTEMAS DE INFORMAÇÃO LTDA</td>
                    <td>CONSYSTEM CONSULTORIA E SISTEMAS S/S LTDA</td>
                </tr>

                <tr>
                    <td>CS COMÉRCIO DE INFORMÁTICA LTDA</td>
                    <td>D&M SERVICO E COMERCIO DE SOFTWARES LTDA</td>
                </tr>

                <tr>
                    <td>DAROM MÓVEIS LTDA</td>
                    <td>DATAMAIS SISTEMAS LTDA EPP</td>
                </tr>

                <tr>
                    <td>DATAMICRO SISTEMA LTDA</td>
                    <td>DB1 INFORMÁTICA LTDA.</td>
                </tr>

                <tr>
                    <td>DELSOFT SISTEMAS LTDA</td>
                    <td>DZM INFORMATICA LTDA ME</td>
                </tr>

                <tr>
                    <td>E. C. SISTEMAS DE INFORMÁTICA LTDA. – EPP</td>
                    <td>EDITH RODRIGUES DA SILVA OLIVEIRA SANTA FÉ DO SUL – ME</td>
                </tr>

                <tr>
                    <td>EFICACIA SISTEMAS E CONSULTORIA LTDA</td>
                    <td>ELIZAMAR CASAGRANDE - ME</td>
                </tr>

                <tr>
                    <td>EMILIA YOSHIKO TAKAKURA OMORI COMPUTADORES ME</td>
                    <td>EVANDRO CARLOS MARTINS DA COSTA INFORMÁTICA ME</td>
                </tr>

                <tr>
                    <td>FALKEN SISTEMAS E AUTOMAÇÃO LTDA</td>
                    <td>FORTI INFORMATICA E COMERCIO LTDA - ME</td>
                </tr>

                <tr>
                    <td>G.P. MAGRI INFORMÁTICA-EPP</td>
                    <td>G1 SISTEMAS LTDA - EPP</td>
                </tr>

                <tr>
                    <td>GD INFORMÁTICA LTDA</td>
                    <td>GDI DESENVOLVIMENTO DE SISTEMAS LTDA</td>
                </tr>

                <tr>
                    <td>GDS SOLUÇÕES EM TREIN. E DESENV. SISTEMAS</td>
                    <td>GERENCIAL SOFTWARE LTDA</td>
                </tr>

                <tr>
                    <td>GERMAN TECH SISTEMAS LTDA.</td>
                    <td>GEW EMPREENDIMENTOS LTDA</td>
                </tr>

                <tr>
                    <td>HELLMANN E COLOGNI LTDA</td>
                    <td>ID BRASIL SISTEMAS LTDA ME</td>
                </tr>

                <tr>
                    <td>INFOEL SISTEMAS DE INFORMÁTICA LTDA</td>
                    <td>INFOLUTION COMÉRCIO E SERVIÇOS LTDA.</td>
                </tr>

                <tr>
                    <td>INFOMASTER EQUIP E SERV P/ INFORMATICA LTDA ME</td>
                    <td>J.VIEIRA DO NASCIMENTO NETO INFORMÁTICA ME</td>
                </tr>

                <tr>
                    <td>JOSE MARCOS NABHAN</td>
                    <td>JUNSOFT SISTEMAS DE INFORMATICA LTDA</td>
                </tr>

                <tr>
                    <td>KOINONIA SOFTWARE LTDA.</td>
                    <td>LINX SISTEMAS E CONSULTORIA LTDA</td>
                </tr>

                <tr>
                    <td>LMD DESENVOLVIMENTO DE SISTEMAS DE INFORMÁTICA LTDA ME</td>
                    <td>LONDRISOFT INFORMATICA LTDA</td>
                </tr>

                <tr>
                    <td>M. A. N CARDOSO INTERNET - EPP</td>
                    <td>MANOEL BENTO MOTTA & CIA LTDA</td>
                </tr>

                <tr>
                    <td>MARQUES & CHIQUETTI LTDA.</td>
                    <td>MASTERSEL INFORMÁTICA LTDA.</td>
                </tr>

                <tr>
                    <td>MAURICIO CAMPANA NONINO - ME</td>
                    <td>MAXWEB TECNOLOGIA DA INFORMACAO LTDA</td>
                </tr>

                <tr>
                    <td>MAZIERO & RIVERA LTDA - ME</td>
                    <td>MDK ASSISTENCIA, SUPORTE TECNICO E COMPUTADORES LTDA</td>
                </tr>

                <tr>
                    <td>MERCODATA ENGENHARIA DE SISTEMAS LTDA</td>
                    <td>META TECNOLOGIA EM SOFTWARE LTDA</td>
                </tr>

                <tr>
                    <td>MGA SISTEMAS DE AUTOMACAO LTDA - ME</td>
                    <td>MKJ IMPORTAÇÃO E COMÉRCIO LTDA</td>
                </tr>

                <tr>
                    <td>MNT AUTOMAÇÃO COMERCIAL LTDA</td>
                    <td>MÓVEIS ROMERA LTDA</td>
                </tr>

                <tr>
                    <td>MWA SISTEMAS LTDA</td>
                    <td>N M DOS S SILVA INFORMATICA</td>
                </tr>

                <tr>
                    <td>NI10 TECNOLOGIA E CONSULTORIA EM INFORMATICA LTDA - ME</td>
                    <td>NPA INFORMÁTICA LTDA</td>
                </tr>

                <tr>
                    <td>OLIVEIRA E MONTE LTDA</td>
                    <td>PAIO & ARFELLI LTDA - ME</td>
                </tr>

                <tr>
                    <td>PC INFORMÁTICA S.A</td>
                    <td>PC LIFE MANUTENÇÃO EM INFORMÁTICA LTDA</td>
                </tr>

                <tr>
                    <td>PMZC TECNOLOGIA LTDA ME</td>
                    <td>POLISOFTWARE DO BRASIL LTDA</td>
                </tr>

                <tr>
                    <td>PORTAL AMERICA COMERCIO DE EQUIPAMENTOS DE INFORMATICA LTDA - ME</td>
                    <td>PORTAL SYSTEM LTDA</td>
                </tr>

                <tr>
                    <td>PRECISA INFORMÁTICA DESENVOLVIMENTO DE SISTEMAS INTEGRADOS LTDA.</td>
                    <td>PRIMAK & CAMPOS LTDA – ME</td>
                </tr>

                <tr>
                    <td>PRO SYSTEM LTDA</td>
                    <td>PRODUTEC INFORMATICA LTDA</td>
                </tr>

                <tr>
                    <td>PROVENCO INFORMÁTICA LTDA</td>
                    <td>PUBLISOFT INFORMÁTICA LTDA</td>
                </tr>

                <tr>
                    <td>RCKY INFORMÁTICA LTDA </td>
                    <td>RDR GESTÃO EMPRESARIAL LTDA-ME</td>
                </tr>

                <tr>
                    <td>REDES DESENVOLVIMENTO DE SISTEMAS LTDA</td>
                    <td>REVOLUTION INFORMÁTICA LTDA</td>
                </tr>

                <tr>
                    <td>RJK SISTEMAS LTDA - ME</td>
                    <td>ROGÉRIO RICARDO SANTOS</td>
                </tr>

                <tr>
                    <td>SABIUM SISTEMAS E TECNOLOGIA DE INFORMATICA LTDA</td>
                    <td>SETADIGITAL SISTEMAS GERENCIAIS LTDA</td>
                </tr>

                <tr>
                    <td>SG SISTEMAS DE AUTOMAÇÃO LTDA</td>
                    <td>SIBRAX SOFTWARE LTDA – EPP</td>
                </tr>

                <tr>
                    <td>SIGANE PROVEDORA DE SOFTWARE LTDA</td>
                    <td>SIGHA EQUIPAMENTOS E SERVIÇOS DE INFORMATICA LTDA</td>
                </tr>

                <tr>
                    <td>SISAND SOLUÇÕES EM SISTEMAS DE GESTÃO LTDA</td>
                    <td>SISTERRA SOLUÇÕES CORPORATIVAS EIRELI - ME</td>
                </tr>

                <tr>
                    <td>SMART BR SOLUCOES TECNOLOGICAS LTDA - EPP</td>
                    <td>SOFTIN SISTEMAS LTDA EPP</td>
                </tr>

                <tr>
                    <td>SOFTISE SISTEMAS EMPRESARIAIS LTDA</td>
                    <td>SOFTMOBILI COMERCIO DE SISTEMAS LTDA</td>
                </tr>

                <tr>
                    <td>SOFTPHARMA DESENVOLVIMENTO E EDIÇÃO DE SOFTWARES COMERCIAIS LTDA</td>
                    <td>SOFTSA SISTEMAS DE INFORMAÇÃO LTDA</td>
                </tr>

                <tr>
                    <td>SS COMP SISTEMAS DE INFORMÁTICA LTDA</td>
                    <td>SUPRIDATTA TELEINFORMÁTICA LTDA</td>
                </tr>

                <tr>
                    <td>TASSARA INFORMATICA LTDA ME</td>
                    <td>TERASOFT SISTEMAS EM INFORMÁTICA LTDA - ME</td>
                </tr>

                <tr>
                    <td>TOTALL SISTEMAS LTDA</td>
                    <td>TRAVAIN E BRAMBILLA LTDA</td>
                </tr>

                <tr>
                    <td>TREE TOOLS INFORMÁTICA LTDA</td>
                    <td>TTJ SISTEMAS LTDA – ME</td>
                </tr>

                <tr>
                    <td>TWN INFORMÁTICA LTDA</td>
                    <td>UNIO TECNOLOGIA LTDA – ME</td>
                </tr>

                <tr>
                    <td>VIRTUAL AGE SOLUÇÕES EM TECNOLOGIA LTDA</td>
                    <td>VIRTUAL MACHINE TECHNOLOGY LTDA</td>
                </tr>

                <tr>
                    <td>VMS SOLUCOES LTDA</td>
                    <td>VSM INFORMÁTICA DE ASSIS LTDA</td>
                </tr>

                <tr>
                    <td>WEBTECH TECNOLOGIA DA INFORMAÇÃO LTDA. – EPP</td>
                    <td>WENDEL WAGNER MARTINS NOGUEIRA ME</td>
                </tr>

                <tr>
                    <td>WIZBANG TECNOLOGIA DO BRASIL LTDA</td>
                    <td>XPERT EMPREENDIMENTOS ELETRÔNICOS LTDA</td>
                </tr>

                <tr>
                    <td>ZAMBROTI E DIAS LTDA</td>
                </tr>
            </table>
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
