# Deploy RC em VPS com Docker

## Estrutura final

```text
deploy/
  app/
  apache/
  database/
  nginx/
  php/
  .env.example
  .env.production
  docker-compose.yml
  Dockerfile
  docker-entrypoint-rc.sh
  README_DEPLOY.md
  DEPLOY_CHECKLIST.md
```

## O que este pacote sobe

- `web`: `php:5.6-apache`, com extensoes `mysql`, `mysqli` e `pdo_mysql`
- `db`: `mysql:5.7`
- Porta publicada no host para validacao inicial: `8092:80`
- Porta publicada do MySQL no host: `127.0.0.1:3315:3306`
- Banco inicializado a partir de `database/01_rc_dump.sql`
- Uploads persistidos em volume Docker nomeado `rc_uploads_data`
- Dados do MySQL persistidos em volume Docker nomeado `rc_mysql_data`

## Variaveis necessarias

Revise `deploy/.env.production` antes de copiar para o VPS:

- `APP_URL`: ja definido como `https://apprc.gpros.com.br`
- `DB_NAME`: equivale ao `DB_DATABASE` esperado para o deploy deste projeto e ja esta definido como `wwgepr_crm_antigo`
- `DB_PASS`: equivale ao `DB_PASSWORD` esperado para o deploy deste projeto e precisa ser preenchido
- `MAIL_ENABLED=false`: mantem o envio de e-mail desabilitado no container
- `DB_USER`
- `DB_PASS`
- `MYSQL_ROOT_PASSWORD`
- `MYSQL_CHARACTER_SET_SERVER=latin1`
- `MYSQL_COLLATION_SERVER=latin1_swedish_ci`
- `UPLOAD_BASE_DIR=/var/appdata/uploads`
- `UPLOAD_MAX_SIZE=5242880`
- `SESSION_COOKIE_SECURE=1` se a publicacao final usar HTTPS no proxy

## Ordem de subida

1. Copiar o pacote para `/srv/rc` no VPS.
2. Revisar `deploy/.env.production`.
3. Se houver stack antiga com o mesmo projeto, parar antes de subir a nova.
4. Subir a stack:

```sh
cd /srv/rc/deploy
docker compose --env-file .env.production up -d --build
```

## Como testar localmente

No Mac ou em outro host com Docker:

```sh
cd deploy
docker compose --env-file .env.production up -d --build
docker compose ps
curl -I http://127.0.0.1:8092/
```

Se quiser resetar o banco local de teste:

```sh
cd deploy
docker compose down -v
docker compose --env-file .env.production up -d --build
```

## Como restaurar banco

### Fluxo padrao deste pacote

Em ambiente novo, o MySQL importa automaticamente `database/01_rc_dump.sql` na primeira inicializacao do volume `rc_mysql_data`.

### Restauracao manual posterior

Para restaurar novamente sobre um banco existente:

```sh
cd /srv/rc/deploy
docker compose --env-file .env.production exec -T db sh -lc 'mysql -u root -p"$MYSQL_ROOT_PASSWORD" "$DB_NAME"' < database/01_rc_dump.sql
```

Se quiser forcar reinicializacao completa com o dump:

```sh
cd /srv/rc/deploy
docker compose down -v
docker compose --env-file .env.production up -d --build
```

## Diretorios que exigem atencao

- `app/controller`
- `app/inc`
- `app/model`
- `app/view`
- `app/img`
- `database/01_rc_dump.sql`
- Volume Docker `rc_uploads_data`: persiste uploads fora do webroot
- Volume Docker `rc_mysql_data`: persiste o banco

## Observacoes de deploy controlado

- Durante a validacao inicial, o sistema responde em `http://IP_DO_VPS:8092`.
- Depois da validacao inicial, o proxy reverso deve apontar para `127.0.0.1:8092`.
- O arquivo `nginx/appcr.gpros1.com.br.conf` foi ajustado para `127.0.0.1:8092`.
- Os endpoints `migrar.controller.php` e `migrar_50_75.controller.php` sao negados no Apache do container.
- `MAIL_ENABLED=false` gera `sendmail_path=/bin/true` no bootstrap do container, evitando disparo real por `mail()`.
- O dump foi preparado para MySQL 5.7 com `latin1` e `latin1_swedish_ci`.
