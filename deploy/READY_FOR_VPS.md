# READY FOR VPS

## Status final do pacote

- Status: pronto para copiar para `/srv/rc`
- Validacao local equivalente ao VPS: concluida
- Subida local a partir de `deploy/`: concluida
- Teste esperado no host: `curl -I http://127.0.0.1:8092` deve retornar `HTTP/1.1 200 OK`
- Porta publicada para validacao inicial: `8092:80`
- Porta publicada do MySQL no host: `127.0.0.1:3315:3306`
- Banco: `mysql:5.7`, com import inicial de `database/01_rc_dump.sql`
- Aplicacao: `php:5.6-apache`

## Comando exato para copiar para o VPS

Se o arquivo compactado estiver no seu Mac:

```sh
scp /Volumes/HDDisco/dev/docker/crm-comercial-antigo/deploy_rc_vps.tar.gz root@SEU_VPS:/srv/
```

No VPS:

```sh
mkdir -p /srv/rc
tar -xzf /srv/deploy_rc_vps.tar.gz -C /srv/rc
cd /srv/rc/deploy
```

## Comando exato para subir no VPS

```sh
cd /srv/rc/deploy
docker compose --env-file .env.production up -d --build
```

## Campos obrigatorios a editar no `.env.production`

Ja fechado:

- `APP_URL=https://apprc.gpros.com.br`
- `DB_NAME=wwgepr_crm_antigo` (equivale ao `DB_DATABASE` deste projeto)

Edicao obrigatoria:

- `DB_PASS` (`DB_PASSWORD` neste projeto)
- `MYSQL_ROOT_PASSWORD`

Observacao:

- `DB_NAME` e o equivalente de `DB_DATABASE` neste projeto. Ele ja esta definido como `wwgepr_crm_antigo`.

Podem permanecer como estao:

- `APP_ENV=production`
- `MAIL_ENABLED=false`
- `DB_HOST=db`
- `DB_NAME=wwgepr_crm_antigo`
- `DB_USER=rc_app`
- `MYSQL_CHARACTER_SET_SERVER=latin1`
- `MYSQL_COLLATION_SERVER=latin1_swedish_ci`
- `UPLOAD_BASE_DIR=/var/appdata/uploads`
- `UPLOAD_MAX_SIZE=5242880`
- `SESSION_COOKIE_SECURE=1`
- `SESSION_COOKIE_SAMESITE=Lax`
- `TZ=America/Sao_Paulo`
- `COMPOSE_PROJECT_NAME=rc`

## Teste exato pos-subida

No VPS:

```sh
cd /srv/rc/deploy
docker compose --env-file .env.production ps
curl -I http://127.0.0.1:8092
```

Resultado esperado do `curl`:

```text
HTTP/1.1 200 OK
```

## Bloqueios restantes

- Nenhum bloqueio tecnico no pacote.
- Para subir no VPS ainda faltam apenas os placeholders de senha no `.env.production`.
- Depois da validacao inicial em `http://IP_DO_VPS:8092`, o proxy reverso do Apache/cPanel/Nginx deve encaminhar para `127.0.0.1:8092`.
- Se o VPS nao tiver acesso ao Docker Hub, o `docker compose up -d --build` vai depender de imagens ja presentes ou de um registry/cache interno.
