# STA

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

## Instalação e Configuração no Docker

Basta executar o comando:

```
chmod +x up.sh
./up.sh
```
__*Observação: O usuário que executar esses comandos deverá ter as permissões necessárias.*__

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
  "ug": "110096",
  "gestao": "00001",
  "numero": "2019NE800015",
  "emissao": "2019-01-22",
  "tipofavorecido": "1",
  "favorecido": "xxxxxxxxxx",
  "observacao": "CONTRATACAO DE EMPRESA ESPECIALIZADA NA PRESTACAO DOS SERVICOS DE RECEPÇÃO...",
  "fonte": "0100000000",
  "naturezadespesa": "339039",
  "planointerno": "AGU0048",
  "itens": {
    "001": {
      "subitem": "79",
      "quantidade": "0.03606",
      "descricao": "PRESTACAO DE SERVICOS DE APOIO ADMINISTRATIVO",
      "valorunitario": "2048138.93",
      "valortotal": "73855.89"
    }
  },
  "ordensbancarias": [
    {
      "numero": "2019OB800460",
      "emissao": "2019-02-05",
      "valor": "519.27",
      "documentoorigem": "2019NP000329",
      "favorecido": "10091536000113"
    },
    {
      "numero": "2019OB800463",
      "emissao": "2019-02-05",
      "valor": "8836.37",
      "documentoorigem": "2019NP000331",
      "favorecido": "08247960000162"
    }
  ]
}
```

##### 2 - __Consultar Ordens Bancárias por Favorecido__
- __URL:__ dominio_ou_ip/api/ordembancaria/favorecido/{cnpj_cpf_idgenerico_ug}
- __Exemplo:__ dominio_ou_ip/api/ordembancaria/favorecido/110062

Retorno:
```
{
  "1": {
    "ug": "110581",
    "gestao": "00001",
    "numero": "2014OB800466",
    "emissao": "2014-02-05",
    "tipofavorecido": "2",
    "favorecido": "110062",
    "observacao": "PROC 000751/14 DOC GERADO PELO SCDP. PCDP 000751/14 P/ PGTO. DE  ...",
    "tipoob": "11",
    "processo": "",
    "cancelamentoob": "0",
    "numeroobcancelamento": "",
    "valor": "2.735,00",
    "documentoorigem": "2014AV000469"
  },
  "2": {
    "ug": "110581",
    "gestao": "00001",
    "numero": "2014OB802071",
    "emissao": "2014-03-20",
    "tipofavorecido": "2",
    "favorecido": "110062",
    "observacao": "PROC 000113/14 DOC GERADO PELO SCDP. PCDP 000113/14 P/ PGTO. DE  ...",
    "tipoob": "11",
    "processo": "",
    "cancelamentoob": "0",
    "numeroobcancelamento": "",
    "valor": "178,46",
    "documentoorigem": "2014AV002054"
  }
}
```

##### 3 - __Consultar Ordens Bancárias por Ano e Unidade Gestora__
- __URL:__ dominio_ou_ip/api/ordembancaria/ano/{ano}/ug/{ug}
- __Exemplo:__ dominio_ou_ip/api/ordembancaria/ano/2019/ug/110161

Retorno:
```
{
  "1": {
    "ug": "110592",
    "gestao": "00001",
    "numero": "2019OB800002",
    "emissao": "2019-01-02",
    "tipofavorecido": "1",
    "favorecido": "00000000000191",
    "observacao": "LIQUIDACAO DO  REAVISO DE VENCIMENTO DE DÉBITO - 87692513  DE 10/12/18, ...",
    "tipoob": "59",
    "processo": "00677.000021/2018-18",
    "cancelamentoob": "0",
    "numeroobcancelamento": "",
    "valor": "7250.61",
    "documentoorigem": "2018NP001947"
  },
  "2": {
    "ug": "110592",
    "gestao": "00001",
    "numero": "2019OB800001",
    "emissao": "2019-01-02",
    "tipofavorecido": "1",
    "favorecido": "64799539000135",
    "observacao": "LIQUIDAÇÃO, POR RECONHECIMENTO DE DÍVIDA DA FATURA 90697 E NF 33303, ...",
    "tipoob": "12",
    "processo": "00677.000353/2018-94",
    "cancelamentoob": "0",
    "numeroobcancelamento": "",
    "valor": "513.94",
    "documentoorigem": "2018NP001948"
  }
}
```
