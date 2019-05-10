# API STA

Ferramenta de Leitura de arquivos do STA - Sistema de Transferência de Arquivos - STN

## Tecnologia Utilizada

A ferramenta é desenvolvida em PHP, utilizando  Framework Laravel versão 5.8.*

## Objetivos

Seu objetivo principal é a disponibilização das informações constantes do SIAFI, por meio de uma API RestFull.

Essa ferramenta é Gratuita, e cada Instituição Pública poderá utilizá-la sem limites.
 
Caso o órgão queira implementar nova funcionalidade, pedimos que disponibilize esta para que outras instituições possa utilizar.

## Versões, Requisitos, Instalação e Configuração

### Versões

- Laravel 5.8;
- PHP 7.1+;
- PostgreSQL 9.6+

### Requisitos para instalação

- Git;
- Composer.

### Instalação

Para baixar o conteúdo via Git utilize o seguinte comando:
```
git clone https://github.com/helesjunior/sta.git
```

Para instalação entre no diretorio "sta" e execute o comando composer:
```
cd sta
composer install
```

### Configuração

Execute os comando para configuração do Laravel 5.8:
```
cp .env.example .env
php artisan key:generate
php artisan migrate
```

Edite as seguintes variáveis do arquivo .env para configurar a conexão com o Banco de Dados PostgreSQL e os Diretórios que se encontram os arquivos enviados pelo STA - Sistema de Transferência de Arquivos - STN.

```
DB_CONNECTION=pgsql
DB_HOST=host_ou_ip
DB_PORT=5432
DB_DATABASE=nome_banco
DB_USERNAME=nome_usuario
DB_PASSWORD=senha_usuario

ARQUIVOS_QWARE_RECEBIDOS=Z:\STA\RECEBIDOS\
ARQUIVOS_QWARE_PROCESSADOS=Z:\STA\PROCESSADOS\
```

## Instalação e Configuração no Docker

Basta executar o comando:

```
chmod +x up.sh
./up.sh
```
__*Observação: O usuário que executar esses comandos deverá ter as permissões necessárias.*__

## Como configurar Q-ware no STA

Para utilizar essa API, primeiro deverá configurar um Servidor Q-ware seguindo as orientações constantes dos links:
- [STA - Sistema de Transferência de Arquivos](http://www.serpro.gov.br/menu/suporte/downloads/downloads-e-softwares/sta);
- [Ajuda - STA - Sistema de Transferência de Arquivos](https://sta.tesouro.fazenda.gov.br/pcasp/ajuda/ajuda_index.htm).

## Agendamentos no STA - Sistema de Transferência de Arquivos

Agendamentos necessários para utilização da API STA.

Entre no sistema [Sistema de Transferência de Arquivos](https://sta.tesouro.fazenda.gov.br) e agende as seguintes consultas:


| Nome  | Periodicidade | Tipo Arquivo | Nome Arquivo | Forma Extração |
| ----- | ------------- | ------------ | ------------ | -------------- |
| UG  | Diária  | Tabela-Administrativo | 	Unidade Gestora | Acumulada |
| CREDOR  | Diária  | Tabela-Administrativo | 	Credor | Acumulada |
| PI  | Diária  | 	Tabela-Orçamentária | 	Plano Interno | Acumulada |
| NE  | Diária  | Documento | Empenho - NE | Incremental |
| NEITENS  | Diária  | Documento | Descrição de Empenho (Lista de itens) | Incremental |
| OB  | Diária  | Documento | Ordem Bancária - OB | Incremental |

## Como Usar a API

### Links para leitura dos arquivos do STA


| Descrição | URL |
|-----------|-----|
| Documentos Hábeis | dominio_ou_ip/api/ler/dochabil |
| Empenhos | dominio_ou_ip/api/ler/empenho |
| Detalhamento dos Empenhos | dominio_ou_ip/api/ler/empenhodetalhado |
| Ordens Bancárias | dominio_ou_ip/api/ler/ordembancaria |
| Plano Interno | dominio_ou_ip/api/ler/planointerno |
| Credores | dominio_ou_ip/api/ler/credor |
| Unidades | dominio_ou_ip/api/ler/unidade |

*Esse links devem ser adicionados no Crontab do servidor para que sejam executados diariamente de forma automática:*

Exemplo de crontab:

```
0 8 * * * lynx -dump http://dominio_ou_ip/api/ler/empenho
5 8 * * * lynx -dump http://dominio_ou_ip/api/ler/empenhodetalhado
10 8 * * * lynx -dump http://dominio_ou_ip/api/ler/ordembancaria
```

### Acesso as informações da API

Para que tenha acesso as informações no Banco de Dados via API, basta acessar os links:

##### 1 - __Consultar Empenho__
- __URL:__ dominio_ou_ip/api/empenho/{ug}{gestao}{numero_empenho}
- __Exemplo:__ dominio_ou_ip/api/empenho/110096000012019NE800015

Retorno:
```
{
  "ug": "110102",
  "gestao": "00001",
  "numero": "2019NE800534",
  "emissao": "2019-05-08",
  "tipocredor": "1",
  "cpfcnpjugidgener": "10.439.655/0001-14",
  "nome": "PEDRO REGINALDO DE ALBERNAZ FARIA E FAGUNDES LTDA",
  "observacao": "CONTRATAÇÃO PARA PRESTAÇÃO DE SERVIÇO CONTINUADO DE ZELADOR ...",
  "fonte": "0100000000",
  "naturezadespesa": "339039",
  "picodigo": "AGU9999",
  "pidescricao": "PLANO INTERNO NÃO CADASTRADO"
}
```

##### 2 - __Consultar Empenho por Ano e Unidade Gestora (UG)__
- __URL:__ dominio_ou_ip/api/empenho/ano/{ano}/ug/{ug}
- __Exemplo:__ dominio_ou_ip/api/empenho/ano/2019/ug/110099

Retorno:
```
[
  {
    "ug": "110099",
    "gestao": "00001",
    "numero": "2019NE000102",
    "emissao": "2019-05-08",
    "tipocredor": "1",
    "cpfcnpjugidgener": "43.714.674/0001-60",
    "nome": "CONSTRUTORA E INCORPORADORA EXATA LTDA",
    "observacao": "ATENDER REEMBOLSO DE DESP. DE AGUA E ESGOTO DO ED. OFFICE ...",
    "fonte": "0100000000",
    "naturezadespesa": "339093",
    "picodigo": "AGU0033",
    "pidescricao": "SERVICOS DE ÁGUA E COLETA DE ESGOTO"
  }
  {
    ...
  }
]
```

##### 3 - __Consultar Detalhamento do Empenho__
- __URL:__ dominio_ou_ip/api/empenhodetalhado/{ug}{gestao}{numero_empenho}
- __Exemplo:__ dominio_ou_ip/api/empenhodetalhado/110096000012019NE800015

Retorno:
```
[
  {
    "numitem": "001",
    "subitem": "02",
    "quantidade": "1.00000",
    "valorunitario": "8187.36",
    "valortotal": "8187.36"
  }
  {
    ...
  }
]
```

##### 4 - __Consultar Ordens Bancárias por Favorecido__
- __URL:__ dominio_ou_ip/api/ordembancaria/favorecido/{cnpj_cpf_idgenerico_ug}
- __Exemplo:__ dominio_ou_ip/api/ordembancaria/favorecido/08247960000162

Retorno:
```
[
  {
    "ug": "110096",
    "gestao": "00001",
    "numero": "2019OB802087",
    "emissao": "2019-05-08",
    "tipofavorecido": "1",
    "favorecidocodigo": "08.247.960/0001-62",
    "favorecidonome": "REAL JG SERVICOS GERAIS EIRELI",
    "observacao": "PAGAMENTO DAS NFS. 6823/6825 DE 02/MAR/2019, REF. ABR/2019 ...",
    "tipoob": "12",
    "processo": "00506.000056/2019-91",
    "cancelamentoob": "0",
    "numeroobcancelamento": "",
    "valor": "8.879,97",
    "documentoorigem": "2019NP001694",
    "empenhos": [
      "110096000012019NE800015",
      "110096000012019NE800017",
      "110096000012019NE800018",
      "110096000012019NE800019"
    ]
  },
  {
    ...
  }
]
```

##### 5 - __Consultar Ordens Bancárias por Ano e Unidade Gestora__
- __URL:__ dominio_ou_ip/api/ordembancaria/ano/{ano}/ug/{ug}
- __Exemplo:__ dominio_ou_ip/api/ordembancaria/ano/2019/ug/110161

Retorno:
```
[
  {
    "ug": "110161",
    "gestao": "00001",
    "numero": "2019OB801553",
    "emissao": "2019-05-08",
    "tipofavorecido": "1",
    "favorecidocodigo": "00.000.000/0001-91",
    "favorecidonome": "BANCO DO BRASIL SA",
    "observacao": "PAGAMENTO DE FATURA DO CPGF REFERENTE AO PERÍODO 27/03 ...",
    "tipoob": "59",
    "processo": "00400.000044/2019-45",
    "cancelamentoob": "0",
    "numeroobcancelamento": "",
    "valor": "168,00",
    "documentoorigem": "2019SF000001",
    "empenhos": [
      "110161000012019NE800189"
    ]
  },
  {
    ....
  }
]
```
