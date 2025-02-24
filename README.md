# Desafio técnico - UNISUAM

## Instruções para instalação:

- Executar o comando do Docker para fazer o build da aplicação:

```
docker compose up -d --build
```

- Criar arquivo .env com base no .env.example:

```
cp .env.example .env
```

- Executar o comando para instalar dependências do composer:

```
composer install
```

- Executar comando para gerar application key (Laravel):

```
php artisan key:generate
```

- Criar as tabelas e seed do banco de dados:

```
php artisan migrate --seed
```
