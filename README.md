# Desafio técnico - UNISUAM

## Instruções para instalação:

- Criar arquivo .env com base no .env.example:

```
cp .env.example .env
```

- Executar o comando do Docker para fazer o build da aplicação:

```
docker compose up -d --build
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

- Executar análise estática do código com PHP-Stan:

```
composer analyse
```

- **Github API Client Secret:**

Para o projeto funcionar de acordo com o rate limit do Github, 
será necessário gerar um token para autenticação.

Para isso, acesse sua conta do Github e vá até Configurações → Desenvolvedor → Tokens de Acesso Pessoal.
Clique em "Gerar novo token" e selecione os escopos necessários.
Copie o token e insira no arquivo .env, na variável **GITHUB_API_CLIENT_SECRET.**

E por fim, execute o comando abaixo para atualizar o cache da aplicação:
```
php artisan optimize
```
