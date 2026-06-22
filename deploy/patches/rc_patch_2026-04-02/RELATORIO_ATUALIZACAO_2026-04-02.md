# Relatorio de Atualizacao - 2026-04-02

## Objetivo

Aplicar em producao duas melhorias no modulo comercial RC:

1. Correcao da pesquisa de Leads por CPF/CNPJ.
2. Inclusao dos filtros abaixo no modulo `Administracao > Transferencia de Leads`, integrando-os tanto na contagem de leads quanto na transferencia efetiva:
   - Operadora
   - Classificacao da Operadora
   - Tempo de Contrato
   - Quantidade de Linhas

## Arquivos de producao alterados

- `deploy/app/model/lead.dao.php`
- `deploy/app/view/transferencia_lead.php`
- `deploy/app/view/transferencia_lead.js`
- `deploy/app/view/transferencia_lead2.js`
- `deploy/app/controller/transferencia_lead.controller.php`
- `deploy/app/model/transferencia_lead.dao.php`

## Resumo tecnico das alteracoes

### 1. Pesquisa de Leads por CPF/CNPJ

Arquivo:

- `deploy/app/model/lead.dao.php`

Alteracoes:

- Corrigido bug no filtro de CPF/CNPJ que usava variavel incorreta.
- A busca agora compara o valor sem mascara, permitindo pesquisar com ou sem pontos, barras e hifen.
- A mesma normalizacao foi aplicada nos trechos auxiliares da DAO para evitar comportamento inconsistente.

### 2. Transferencia de Leads - novos filtros

Arquivos:

- `deploy/app/view/transferencia_lead.php`
- `deploy/app/view/transferencia_lead.js`
- `deploy/app/view/transferencia_lead2.js`
- `deploy/app/controller/transferencia_lead.controller.php`
- `deploy/app/model/transferencia_lead.dao.php`

Alteracoes:

- Inclusao dos campos de filtro na tela inicial:
  - Operadora
  - Classificacao Operadora
  - Tempo Contrato
  - Qtde. Linhas De
  - Qtde. Linhas Ate
- Envio desses filtros da primeira tela para a segunda tela.
- Reenvio desses filtros para o controller que calcula os totais.
- Reuso dos mesmos filtros na rotina que realmente faz a transferencia.
- Quando qualquer filtro de operadora for informado, a consulta passa a usar `leads_operadoras`.
- O filtro de quantidade de linhas agora suporta:
  - somente `De`
  - somente `Ate`
  - intervalo `De` + `Ate`
- A comparacao de quantidade de linhas passou a ser numerica com `CAST(lo.ds_qtde_voz AS UNSIGNED)`.

## Validacoes realizadas localmente

- Validacao de sintaxe PHP:
  - `php -l deploy/app/model/lead.dao.php`
  - `php -l deploy/app/controller/transferencia_lead.controller.php`
  - `php -l deploy/app/model/transferencia_lead.dao.php`
- Todas as validacoes retornaram sem erro de sintaxe.

## Pacote preparado para upload

Arquivo gerado:

- `deploy/rc_patch_2026-04-02.tar.gz`

Conteudo esperado do patch:

- `app/model/lead.dao.php`
- `app/view/transferencia_lead.php`
- `app/view/transferencia_lead.js`
- `app/view/transferencia_lead2.js`
- `app/controller/transferencia_lead.controller.php`
- `app/model/transferencia_lead.dao.php`
- `RELATORIO_ATUALIZACAO_2026-04-02.md`

## Procedimento recomendado no servidor Linux

### Opcao 1 - Atualizacao pontual com backup

1. Acessar o servidor.
2. Ir para a pasta da aplicacao:

```sh
cd /srv/rc/deploy
```

3. Fazer backup dos arquivos atuais:

```sh
mkdir -p /srv/rc/backups/2026-04-02
cp app/model/lead.dao.php /srv/rc/backups/2026-04-02/
cp app/view/transferencia_lead.php /srv/rc/backups/2026-04-02/
cp app/view/transferencia_lead.js /srv/rc/backups/2026-04-02/
cp app/view/transferencia_lead2.js /srv/rc/backups/2026-04-02/
cp app/controller/transferencia_lead.controller.php /srv/rc/backups/2026-04-02/
cp app/model/transferencia_lead.dao.php /srv/rc/backups/2026-04-02/
```

4. Enviar o arquivo `rc_patch_2026-04-02.tar.gz` para o servidor.
5. Extrair por cima da estrutura `deploy/`:

```sh
cd /srv/rc/deploy
tar -xzf /caminho/do/arquivo/rc_patch_2026-04-02.tar.gz
```

6. Reiniciar apenas o container web:

```sh
docker compose --env-file .env.production restart web
```

7. Validar no navegador:
   - Pesquisa de Leads por CPF/CNPJ
   - Administracao > Transferencia de Leads
   - Contagem na segunda etapa da transferencia

### Opcao 2 - Rebuild completo da stack

Usar se o fluxo de deploy do ambiente sempre sobe a stack novamente:

```sh
cd /srv/rc/deploy
docker compose --env-file .env.production up -d --build
```

## Checklist de teste em producao

### Pesquisa de Leads

- Pesquisar um CNPJ com mascara.
- Pesquisar o mesmo CNPJ sem mascara.
- Confirmar que ambos retornam o mesmo lead.

### Transferencia de Leads

- Filtrar somente por Operadora e conferir se o total muda.
- Filtrar somente por Classificacao da Operadora e conferir se o total muda.
- Filtrar somente por Tempo de Contrato e conferir se o total muda.
- Filtrar somente por Quantidade de Linhas e conferir se o total muda.
- Testar combinacao de filtros.
- Avancar para a segunda tela e confirmar que os totais respeitam os filtros.
- Executar transferencia controlada de poucos registros e validar o resultado.

## Prompt pronto para outro ChatGPT conduzir o deploy

```text
Estou atualizando o sistema RC no servidor Linux.

Contexto:
- Aplicacao em /srv/rc/deploy
- Stack Docker Compose
- Arquivo de ambiente: /srv/rc/deploy/.env.production
- Preciso aplicar um patch ja preparado no arquivo rc_patch_2026-04-02.tar.gz

Objetivo da atualizacao:
1. Corrigir a pesquisa de Leads por CPF/CNPJ para buscar com ou sem mascara.
2. Adicionar ao modulo Administracao > Transferencia de Leads os filtros:
   - Operadora
   - Classificacao da Operadora
   - Tempo de Contrato
   - Quantidade de Linhas
3. Garantir que esses filtros sejam aplicados tanto na contagem dos leads quanto na transferencia efetiva.

Arquivos alterados no patch:
- app/model/lead.dao.php
- app/view/transferencia_lead.php
- app/view/transferencia_lead.js
- app/view/transferencia_lead2.js
- app/controller/transferencia_lead.controller.php
- app/model/transferencia_lead.dao.php

Quero que voce me conduza no deploy com seguranca, seguindo esta ordem:
1. Confirmar a pasta atual e listar os arquivos relevantes.
2. Fazer backup dos arquivos que serao substituidos.
3. Extrair o patch no local correto.
4. Reiniciar a aplicacao da forma menos invasiva possivel.
5. Rodar verificacoes basicas pos-deploy.
6. Me passar um checklist funcional para validar no navegador.

Se houver qualquer diferenca de estrutura no servidor, pare e me diga exatamente o que encontrou antes de prosseguir.
```
