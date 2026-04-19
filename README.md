# Test Deep Laravel

Aplicação Laravel 12 com autenticação Auth0, interface Blade + Tailwind/Flowbite e arquitetura em camadas (Domain, Application, Infra, Presentation). Em ambiente local, o armazenamento S3 é emulado com LocalStack via Laravel Sail.

# Diagrama da Arquitetura

<img width="1654" height="1169" alt="Diagrama sem nome" src="https://github.com/user-attachments/assets/f8cd6141-352c-4d40-b61f-b1909994e2af" />

## Visão Geral

- Framework: Laravel 12
- Runtime: PHP 8.2+
- Frontend: Blade, Vite, Tailwind CSS v4, Flowbite
- Auth: Auth0 (`auth0/login`)
- Storage: S3 (`league/flysystem-aws-s3-v3`)
- Ambiente local: Docker + Sail + MySQL + LocalStack

## Arquitetura

```text
domain/        Modelos e contratos (interfaces)
application/   Casos de uso (orquestração de regras)
infra/         Implementações concretas (Eloquent, S3, integrações)
presentation/  Controllers HTTP
resources/     Views Blade e assets
routes/        Rotas web
docker/        Scripts de ambiente local
```

### Decisões técnicas

- Usuário local + Auth0: após autenticação, o sistema garante um usuário local para manter consistência dos dados internos.
- S3 em dev com LocalStack: mesmo fluxo de upload usado em produção, com endpoint local no desenvolvimento.
- Assets de avatar/produto servidos pelo backend: evita dependência direta de URL interna do bucket no navegador.

## Pré-requisitos

- Docker e Docker Compose
- PHP e Composer (opcional local; Sail já cobre no container)
- Node.js (opcional local; normalmente via Sail)
- Auth0 CLI (para gerar arquivos locais de configuração)

## Setup rápido

```bash
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail composer install
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

## Onboarding de novo desenvolvedor

Alguns arquivos não são versionados por segurança e devem ser criados localmente:

- `.env`
- `.auth0.app.json`
- `.auth0.api.json` (opcional)

### 1) Configurar `.env`

A partir de `.env.example`, ajuste no mínimo:

- `APP_URL=http://localhost`
- conexão MySQL do Sail
- configurações S3/LocalStack

Observação:

- O projeto foi configurado para expor o app em `localhost` (bind `127.0.0.1`) para evitar problemas de sessão/state no Auth0.

### 2) Gerar arquivo local do Auth0

Autentique no Auth0 CLI:

```bash
auth0 login
```

Gere o app web local:

```bash
auth0 apps create \
    --name "Test Deep Laravel (Local)" \
    --type "regular" \
    --auth-method "post" \
    --callbacks "http://localhost/callback" \
    --logout-urls "http://localhost" \
    --reveal-secrets \
    --no-input \
    --json > .auth0.app.json
```

Opcional (API local):

```bash
auth0 apis create \
    --name "Test Deep Laravel API" \
    --identifier "https://test-deep-laravel.local/api" \
    --offline-access \
    --no-input \
    --json > .auth0.api.json
```

Se usar porta diferente da 80, ajuste callback/logout URLs de acordo.

### 3) Checklist de validação local

- Abrir `http://localhost`
- Clicar em `Entrar` e concluir callback sem erro
- Acessar `/dashboard`
- Cadastrar produto com imagem e verificar listagem

## Variáveis e configuração local

### Banco

- `DB_CONNECTION=mysql`
- `DB_HOST=mysql`
- `DB_PORT=3306`
- credenciais conforme `.env`

### S3 (LocalStack)

- `AWS_DEFAULT_REGION=us-east-1`
- `AWS_BUCKET=test-deep`
- `AWS_ENDPOINT=http://localstack:4566`
- `AWS_USE_PATH_STYLE_ENDPOINT=true`

### Auth0

- Fluxo recomendado: `.auth0.app.json` / `.auth0.api.json` (não commitar)
- O pacote `auth0/login` detecta automaticamente esses arquivos locais

## Execução

Subir ambiente:

```bash
./vendor/bin/sail up -d
```

Frontend (dev):

```bash
./vendor/bin/sail npm run dev
```

Build de produção local:

```bash
./vendor/bin/sail npm run build
```

Testes:

```bash
./vendor/bin/sail composer test
```

## Seeders opcionais

O seeder de produtos usa Faker PHP e nao e executado automaticamente no fluxo padrao. Rode somente quando quiser popular o ambiente de desenvolvimento com dados de exemplo.

O `ProductSeeder` tambem gera imagens ficticias (SVG) e envia para o S3/LocalStack, preenchendo a capa do produto e a galeria (`product_images`).

Com Sail:

```bash
./vendor/bin/sail artisan db:seed --class=Database\\Seeders\\ProductSeeder
```

Sem Sail:

```bash
php artisan db:seed --class=Database\\Seeders\\ProductSeeder
```

Observacao:

- Se o S3/LocalStack estiver indisponivel, o seeder ainda cria os produtos, mas sem imagens.

## Rotas principais

Públicas:

- `GET /`
- `GET/POST /usuarios/cadastro`

Autenticadas:

- `GET /dashboard`
- `GET /perfil`
- `PUT /perfil`
- `GET /perfil/avatar`
- `GET /produtos`
- `POST /produtos`
- `PUT /produtos/{product}`
- `DELETE /produtos/{product}`

## Segurança

- Nunca commitar `.env`
- Nunca commitar `.auth0.*.json`
- Nunca commitar binários locais (ex.: `auth0`)
- Tratar `client_secret` e chaves como credenciais sensíveis

## Troubleshooting

### Invalid state no login

- Use sempre `localhost` (não misture com `127.0.0.1` ou `0.0.0.0`)
- Verifique no Auth0: Allowed Callback URLs `http://localhost/callback`.
- Verifique no Auth0: Allowed Logout URLs `http://localhost`.
- Verifique no Auth0: Allowed Web Origins `http://localhost`.

### Imagem não aparece na listagem

- Verifique se LocalStack está ativo
- Confira bucket e endpoint no `.env`
- Revalide permissões e rota de stream da imagem no backend
