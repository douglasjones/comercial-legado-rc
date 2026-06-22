# UPDATE_INSTRUCTIONS_RC

## O que entra nesta atualização
- `release/app/` com arquivos de aplicação alterados (diff com `deploy/app`).
- `release/Dockerfile` e `release/docker-compose.yml` (copiados do padrão atual de deploy).
- `release/CHANGELOG_RC_UPDATE.md` e esta instrução.

## O que não deve ser sobrescrito
- Não sobrescrever `/srv/rc/deploy/.env.production`.
- Não sobrescrever segredos/variáveis locais fora desta atualização.
- Não substituir volume de dados do banco nem diretórios persistentes.

## Como aplicar no VPS (sem reinstalar)
1. Copiar `release` para VPS (ex.: `/tmp/rc_update_release`).
2. Backup do estado atual da aplicação:
   - `cp -a /srv/rc/deploy/app /srv/rc/deploy/app.bkp_$(date +%Y%m%d_%H%M%S)`
3. Sincronizar apenas aplicação:
   - `rsync -av --delete --exclude='.env' --exclude='.env.production' /tmp/rc_update_release/app/ /srv/rc/deploy/app/`
4. Atualizar arquivos de deploy (opcional, conforme padrão atual):
   - `cp /tmp/rc_update_release/Dockerfile /srv/rc/deploy/Dockerfile`
   - `cp /tmp/rc_update_release/docker-compose.yml /srv/rc/deploy/docker-compose.yml`
5. Rebuild/Restart:
   - Recomendado (modo padrão):
     - `cd /srv/rc/deploy`
     - `docker compose build web`
     - `docker compose up -d --force-recreate web`
   - Se o ambiente estiver com bind-mount de código, validar se basta restart:
     - `docker compose restart web`

## Validação
- Acessar `127.0.0.1:8085` pelo proxy do cPanel.
- Validar fluxo de:
  - Cadastro de lead
  - Edição de lead
  - Pesquisa de telefone (não pertube)
  - Endereço (CEP + auto preenchimento)
  - Agenda de visitas (sem campos de endereço obrigatórios)
- Conferir logs: `docker logs -f rc_web`

## Migração de banco
- Não foi incluída migration SQL nesta release.
- Não executar dump ou reinit do banco.

## Rollback
- Parar serviço e restaurar backup:
  - `docker compose down`
  - `rm -rf /srv/rc/deploy/app`
  - `cp -a /srv/rc/deploy/app.bkp_<YYYYMMDD_HHMMSS> /srv/rc/deploy/app`
  - `docker compose up -d web`
