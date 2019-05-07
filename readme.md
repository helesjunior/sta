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
| Documentos Hábeis | Dominio_ou_ip/api/ler/dochabil |
| Empenhos | Dominio_ou_ip/api/ler/empenho |
| Detalhamento do Empenho | Dominio_ou_ip/api/ler/empenhodetalhado |
| Ordem Bancária | Dominio_ou_ip/api/ler/ordembancaria |
| Plano Interno | Dominio_ou_ip/api/ler/planointerno |
| Credor | Dominio_ou_ip/api/ler/credor |
| Unidades | Dominio_ou_ip/api/ler/unidade |




