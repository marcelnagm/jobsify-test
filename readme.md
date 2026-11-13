# jobsify-test

Solução de um **desafio técnico PHP** (Jobsity): API REST com **Slim 4** para consultar cotações de ações, com autenticação, histórico por usuário e envio assíncrono de e-mail por fila.

## Funcionalidades

| Método | Rota | Descrição |
|---|---|---|
| `POST` | `/register` | Cadastra usuário |
| `POST` | `/login` | Autentica e devolve o token JWT |
| `POST` | `/stock` | Consulta a cotação de uma ação (via API externa) e grava no histórico; dispara um e-mail pela fila |
| `GET` | `/history/` | Lista as consultas feitas pelo usuário |
| `GET` | `/users/{id}` | Consulta um usuário |

## Stack

PHP 7.3/8, Slim 4 + PHP-DI, Eloquent (`illuminate/database`), migrações com Phoenix, Guzzle, JWT (`jweety`), Basic Auth (`slim-basic-auth`), Swift Mailer, **RabbitMQ** (`php-amqplib`), Monolog, PHPUnit e Docker Compose.

## Como rodar

```bash
composer install
cp .env.sample .env                   # configure banco, e-mail, RabbitMQ e API de cotações
php vendor/bin/phoenix migrate        # cria as tabelas

# fila de e-mails (RabbitMQ)
docker volume create rabbitmq_data
docker compose up rabbitmq

composer start                        # http://localhost:8080
composer test                         # PHPUnit
```

## Estrutura

```
app/    # bootstrap, rotas, serviços (logger, mailer, eloquent, auth)
src/    # controllers, middleware de auth e models (User, Quote)
public/ # index.php
migrations/
```
