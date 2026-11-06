# PetShop — Donos, Pets e Agendamento de Serviços

**Dupla:** Thiago e Pedro

## Funcionalidades

- *Administrador:* CRUD de donos, pets, serviços e agendamentos, com busca, paginação e exclusão lógica (soft delete).
- *Dono:* cadastra-se sozinho, vê os próprios pets, os serviços, agenda e cancela agendamentos, edita o perfil e a senha.
- *Upload de imagens (Módulo 1):* imagem do serviço, salva em `storage/app/public/servicos`.
- Login único, com perfil `admin` ou `dono`.
- Validação com Form Requests, proteção CSRF, rotas protegidas por middleware, ids criptografados nas URLs.

## Requisitos

PHP 8.2 ou superior, Composer e MySQL.

## Como executar

    git clone <URL-DO-REPOSITORIO>
    cd <PASTA-DO-PROJETO>

    composer update
    cp .env.example .env
    php artisan key:generate

Crie um banco vazio e configure o `.env` (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`). Depois:
    deixe  SESSION_DRIVER=file e CACHE_STORE=file

    php artisan migrate --seed
    php artisan storage:link
    php artisan serve

Acesse http://127.0.0.1:8000

Para recriar o banco do zero: `php artisan migrate:fresh --seed`

## Logins de teste

| Perfil | E-mail | Senha |
|---|---|---|
| Administrador | admin@petshop.com | 12345678 |
| Dono | e-mail de qualquer dono cadastrado | 12345678 |

## Banco de dados

- `users` (login): `role` e `id_dono` ligam o usuário ao cadastro do dono.
- `donos` 1—N `pets`
- `pets` 1—N `agendamentos`
- `servicos` 1—N `agendamentos`