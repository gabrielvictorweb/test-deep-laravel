# test-deep-laravel

Aplicação Laravel 12 com autenticação via Auth0, UI em Blade + Tailwind e uma arquitetura em camadas (Domain/Application/Infra/Presentation). O projeto usa S3 via Laravel Storage; em desenvolvimento local, o S3 é emulado com LocalStack.

## Stack

- PHP 8.2+
- Laravel 12
- Auth0 (`auth0/login`)
- Blade + Vite + Tailwind CSS
- Storage S3 (`league/flysystem-aws-s3-v3`)
- Docker (Laravel Sail) + MySQL + LocalStack (S3)

## Estrutura do projeto

Este repositório separa responsabilidades por camadas e usa PSR-4 para mapear namespaces em `composer.json`:

```
domain/        -> regras centrais: models e contracts (interfaces)
application/   -> casos de uso (orquestração de negócio)
infra/         -> implementações concretas (Eloquent, S3, integrações)
presentation/  -> controllers HTTP (entrada/saída web)
resources/     -> views Blade, CSS/JS
routes/        -> rotas web
docker/        -> scripts auxiliares (ex.: init do LocalStack)
```

### Domain

- `domain/Models`: entidades principais (ex.: `User`, `Product`).
- `domain/Contracts`: contratos usados pela camada de aplicação para persistência/integrações.

Motivação: a camada de aplicação depende de contratos, não de implementações.

### Application

- `application/UseCases/**`: casos de uso, com regras de fluxo e dependências injetadas via interfaces.

Exemplo: `FindRegisteredUserUseCase` resolve/garante um usuário local a partir do usuário autenticado (Auth0).

### Infra

- `infra/Repositories/**`: implementações das interfaces do domínio.
    - `Eloquent*Repository`: acesso a banco via Eloquent.
    - `S3*StorageRepository`: upload/delete/url em S3 via `Storage::disk('s3')`.
- `infra/Providers/AppServiceProvider.php`: faz o bind das interfaces do domínio para as implementações.

O provider é registrado em `bootstrap/providers.php`.

### Presentation

- `presentation/Http/Controllers/**`: controllers finos, chamando use cases e retornando responses/views.
- `routes/web.php`: organiza rotas públicas e rotas protegidas por `auth`.

## Decisões técnicas (por quê)

### 1) Auth0 + “usuário local”

O login é feito via Auth0 (rotas/middleware do pacote são registradas automaticamente via `config/auth0.php`).

Como o usuário autenticado pode existir no Auth0 mas ainda não existir na tabela `users`, foi adotado um padrão:

- Use cases e controllers de rotas protegidas usam `FindRegisteredUserUseCase` com `createWhenMissing=true`.
- Se não existir usuário local, ele é criado automaticamente (nome/email e `auth_identifier` quando disponível).

Benefícios:

- Evita redirecionar o usuário logado para um “cadastro público” só para criar registro local.
- Permite tratar perfil/produtos de forma consistente, sempre com um `Domain\Models\User` persistido.

### 2) Storage S3 via LocalStack em dev

O upload de imagens (avatar e imagens de produto) é feito via `Storage::disk('s3')`.

Em ambiente local, o S3 é emulado pelo LocalStack (serviço `localstack` em `compose.yaml`). No boot, o bucket é criado pelo script `docker/localstack/init.sh`:

- Bucket padrão: `test-deep`

Motivação:

- Mesmo código para dev e prod (troca apenas por variáveis de ambiente/endpoints).

Observação importante (Docker):

- O container do app e o LocalStack precisam estar na mesma rede Docker para o hostname `localstack` resolver. O `compose.yaml` já garante isso.

### 3) Servir avatar via Laravel (stream) ao invés de URL direta

Para não depender do frontend acessando diretamente o endpoint/bucket, o avatar é servido por uma rota autenticada:

- `GET /perfil/avatar` -> retorna `Storage::disk('s3')->response($path)`

Com fallback:

- Se não houver arquivo no S3, redireciona para uma URL externa (ex.: `picture` do Auth0), quando existir.

Benefícios:

- Controle de acesso no backend.
- Facilidade para trocar o provedor de storage sem mudar as views.

### 4) UI em tema claro

As views Blade e componentes UI foram ajustados para um tema claro consistente (sem dark mode), com sidebar e layout do dashboard padronizados.

## Como rodar localmente (Sail)

Pré-requisitos:

- Docker + Docker Compose

Subir containers:

```bash
./vendor/bin/sail up -d
```

Instalar dependências e preparar o app (opção 1):

```bash
./vendor/bin/sail composer setup
```

Ou passo a passo (opção 2):

```bash
./vendor/bin/sail composer install
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

## Variáveis de ambiente (resumo)

Use `.env.example` como base e ajuste `.env`.

Banco de dados:

- O `compose.yaml` sobe MySQL. Para usar via Sail, configure `DB_CONNECTION=mysql` e os valores de `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` conforme seu `.env`.
- Se preferir SQLite (padrão do `.env.example`), garanta que o arquivo do SQLite existe e ajuste a app para rodar sem o MySQL.

S3/LocalStack (exemplo típico para dev):

- `AWS_DEFAULT_REGION=us-east-1`
- `AWS_BUCKET=test-deep`
- `AWS_ENDPOINT=http://localstack:4566`
- `AWS_USE_PATH_STYLE_ENDPOINT=true`

Auth0:

- As variáveis dependem do pacote `auth0/login`. Consulte `config/auth0.php` e a documentação do Auth0 Laravel para configurar domínio, client id/secret, audience e redirect URLs.

## Rotas principais

Público:

- `GET /` (welcome)
- `GET/POST /usuarios/cadastro`

Autenticado:

- `GET /dashboard`
- `GET /perfil`
- `PUT /perfil`
- `GET /perfil/avatar`
- CRUD de produtos em `/produtos`

## Notas de segurança

- Nunca commite `.env`.
- Arquivos `.auth0.*.json` são ignorados por padrão (ver `.gitignore`) e podem conter segredos; trate-os como credenciais.

## Testes

```bash
./vendor/bin/sail composer test
```
