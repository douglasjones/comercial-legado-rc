# Backup e Implantacao do CRM

## Escopo do backup

O backup completo deste projeto contem:

- codigo-fonte do CRM;
- arquivo `.env` com a configuracao do ambiente;
- dump do banco MySQL;
- arquivos de upload persistidos no volume Docker;
- metadados com versoes e parametros principais do ambiente.

Os artefatos sao gerados em `backups/<timestamp>/`.

## Versoes e configuracao identificadas

### Stack principal

- PHP: `5.6.40`
- Apache HTTP Server: `2.4.25 (Debian)`
- MySQL Server: `5.7.44`
- Imagem PHP base: `php:5.6-apache`
- Imagem MySQL base: `mysql:5.7`

### Modulos PHP habilitados

- `mysql`
- `mysqli`
- `pdo_mysql`
- `rewrite_module` no Apache

### Parametros atuais do PHP

- `Loaded Configuration File => (none)` (usa defaults da imagem)
- `memory_limit => 128M`
- `max_execution_time => 0`
- `upload_max_filesize => 2M`
- `post_max_size => 8M`
- `default_charset => UTF-8`
- `date.timezone => no value` no `php.ini`
- timezone da aplicacao: `America/Sao_Paulo` em [`inc/php/config.php`](/Volumes/HDDisco/dev/docker/crm-comercial-antigo/inc/php/config.php)

### Parametros atuais do MySQL

- banco padrao: `wwgepr_crm_antigo`
- usuario da aplicacao: `crm_user`
- `sql_mode` vazio (`--sql-mode=""` no `docker-compose`)
- `character_set_server => latin1`
- `collation_server => latin1_swedish_ci`
- `time_zone => SYSTEM`

### Variaveis de ambiente usadas pela aplicacao

Arquivo principal: [`.env`](/Volumes/HDDisco/dev/docker/crm-comercial-antigo/.env)

- `APP_ENV`
- `APP_URL`
- `DB_HOST`
- `DB_NAME`
- `DB_USER`
- `DB_PASS`
- `MYSQL_ROOT_PASSWORD`
- `UPLOAD_BASE_DIR`
- `UPLOAD_MAX_SIZE`
- `SESSION_COOKIE_SECURE`
- `SESSION_COOKIE_SAMESITE`

### Pontos de configuracao no projeto

- Docker Compose: [`docker-compose.yml`](/Volumes/HDDisco/dev/docker/crm-comercial-antigo/docker-compose.yml)
- Compose de producao: [`docker-compose.prod.yml`](/Volumes/HDDisco/dev/docker/crm-comercial-antigo/docker-compose.prod.yml)
- Build do PHP/Apache: [`Dockerfile`](/Volumes/HDDisco/dev/docker/crm-comercial-antigo/Dockerfile)
- Conexao com banco: [`inc/classes/bestflow/DataBase.php`](/Volumes/HDDisco/dev/docker/crm-comercial-antigo/inc/classes/bestflow/DataBase.php)
- Configuracao de sessao e timezone: [`inc/php/config.php`](/Volumes/HDDisco/dev/docker/crm-comercial-antigo/inc/php/config.php)
- Proxy Nginx: [`deploy/nginx/appcr.gpros1.com.br.conf`](/Volumes/HDDisco/dev/docker/crm-comercial-antigo/deploy/nginx/appcr.gpros1.com.br.conf)

## Como gerar o backup

Script criado: [`scripts/backup_crm.sh`](/Volumes/HDDisco/dev/docker/crm-comercial-antigo/scripts/backup_crm.sh)

Executar na raiz do projeto:

```sh
chmod +x scripts/backup_crm.sh scripts/restore_db.sh
./scripts/backup_crm.sh
```

### Artefatos gerados

- `crm-comercial-antigo_files_<timestamp>.tar.gz`: codigo-fonte e arquivos do projeto
- `wwgepr_crm_antigo_<timestamp>.sql.gz`: dump do banco
- `crm-comercial-antigo_uploads_<timestamp>.tar.gz`: arquivos do volume de uploads
- `dotenv_<timestamp>.env`: copia do `.env`
- `metadata_<timestamp>.txt`: versoes e parametros do ambiente

## Como restaurar o backup

### 1. Restaurar os arquivos do projeto

```sh
mkdir -p /opt/crm-comercial-antigo
tar -xzf crm-comercial-antigo_files_<timestamp>.tar.gz -C /opt/crm-comercial-antigo
cp dotenv_<timestamp>.env /opt/crm-comercial-antigo/.env
```

### 2. Subir os containers

```sh
cd /opt/crm-comercial-antigo
docker compose up -d --build
```

### 3. Restaurar o banco

Script criado: [`scripts/restore_db.sh`](/Volumes/HDDisco/dev/docker/crm-comercial-antigo/scripts/restore_db.sh)

```sh
cd /opt/crm-comercial-antigo
./scripts/restore_db.sh /caminho/para/wwgepr_crm_antigo_<timestamp>.sql.gz
```

Comando equivalente sem script:

```sh
gzip -dc wwgepr_crm_antigo_<timestamp>.sql.gz | docker exec -i crm_db sh -lc 'mysql -uroot -p"$MYSQL_ROOT_PASSWORD" "$MYSQL_DATABASE"'
```

### 4. Restaurar os uploads

```sh
docker exec -i crm_web sh -lc 'tar -C /var/appdata -xzf -' < crm-comercial-antigo_uploads_<timestamp>.tar.gz
```

### 5. Validar a aplicacao

- abrir a aplicacao na porta `8081` ou no dominio publicado pelo Nginx;
- validar login;
- validar consultas que leem dados do banco;
- validar upload e download de anexos.

## Como implantar em outro servidor

### Requisitos

- Docker Engine com plugin `docker compose`
- espaco em disco para o codigo, dump e volume de uploads
- porta `8081` livre localmente
- se houver proxy externo, liberar a porta `80` para o Nginx publicar o dominio

### Passos

1. Copiar o projeto ou extrair o backup de arquivos.
2. Ajustar o `.env` com senhas e URL do ambiente alvo.
3. Subir a stack com `docker compose up -d --build`.
4. Restaurar o banco com o dump `.sql.gz`.
5. Restaurar os uploads.
6. Configurar o proxy reverso Nginx para encaminhar `server_name appcr.gpros1.com.br` para `127.0.0.1:8081`.

### Exemplo de publicacao via Nginx

Configuracao base em [`deploy/nginx/appcr.gpros1.com.br.conf`](/Volumes/HDDisco/dev/docker/crm-comercial-antigo/deploy/nginx/appcr.gpros1.com.br.conf):

- `proxy_pass http://127.0.0.1:8081;`
- limite de login: `10r/m`
- limite de upload: `20r/m`
- `client_max_body_size 6m`
- bloqueio direto de `/uploads/`

## Observacoes importantes

- O PHP 5.6 e o MySQL 5.7 estao fora de suporte. Para manter este ambiente, preserve exatamente essas versoes na restauracao.
- O projeto usa credenciais via variaveis de ambiente, nao hardcode no codigo.
- O dump do banco precisa respeitar `latin1`, porque o servidor atual esta nesse charset.
- O valor de `UPLOAD_MAX_SIZE` no `.env` esta em `5 MB`, mas o PHP atual aceita apenas `2 MB` por `upload_max_filesize`; se quiser manter 5 MB reais, ajuste o container PHP.
