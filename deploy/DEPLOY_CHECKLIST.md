# Checklist de Deploy RC

## Antes de copiar para o VPS

- Confirmar que `deploy/app` contem a versao correta do codigo.
- Confirmar que `deploy/database/01_rc_dump.sql` e o dump desejado para o ambiente temporario.
- Revisar `deploy/.env.production` e trocar `DB_PASS` e `MYSQL_ROOT_PASSWORD`.
- Ajustar `APP_URL` para o dominio ou subdominio real.
- Confirmar `MAIL_ENABLED=false`.
- Confirmar que a validacao inicial sera feita por `http://IP_DO_VPS:8092`.

## Antes de subir no VPS

- Copiar `deploy/` para `/srv/rc`.
- Validar que `docker` e `docker compose` estao disponiveis no VPS.
- Garantir que nenhuma outra stack ja esteja usando o projeto `rc`.
- Garantir espaco em disco suficiente para imagem, dump e volumes.
- Depois da validacao inicial, revisar o proxy reverso do Apache/cPanel/Nginx para apontar para `127.0.0.1:8092`.
- Aplicar o arquivo `nginx/appcr.gpros1.com.br.conf` ou a regra equivalente no proxy existente.

## Depois de subir

- Executar `docker compose ps` em `/srv/rc`.
- Verificar `docker compose logs web --tail=100`.
- Verificar `docker compose logs db --tail=100`.
- Testar `curl -I http://127.0.0.1:8092/` no host.
- Confirmar acesso via URL publicada.
- Testar login basico.
- Testar leitura de dados principais.
- Testar upload pequeno.

## Itens de seguranca temporaria

- Manter `MAIL_ENABLED=false`.
- Enquanto a validacao estiver em andamento, restringir o acesso a `8092` no firewall sempre que possivel.
- Manter bloqueio dos endpoints de migracao.
- Restringir a publicacao por IP ou autenticacao adicional no proxy, se possivel.
- Nao reutilizar as senhas de exemplo.
- Remover ou rotacionar o dump se ele nao precisar ficar no servidor apos a carga inicial.
