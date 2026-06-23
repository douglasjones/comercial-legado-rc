# Atualizacao Leads - 2026-06-23

## Objetivo

Corrigir a regressao de permissao na abertura do painel do lead, sem remover:

- a coluna `Status OC`
- o fluxo de `Retornar a Lista`

## Arquivo alterado

- `view/lead_res_form.js`

## O que foi ajustado

Foi criada uma regra central para decidir se o usuario pode abrir/editar/excluir o lead:

- permite acesso quando o usuario possui a permissao `acessar_todos_lead`
- permite acesso quando o lead nao possui responsavel definido
- permite acesso quando o usuario logado e responsavel pelo lead
- caso contrario, exibe o alerta de bloqueio

Tambem foi corrigido o problema de fluxo silencioso quando `permissao("acessar_todos_lead", "cons")` nao retornava `success`, o que fazia o clique no painel parar sem abrir a tela e sem mostrar mensagem.

## O que foi preservado

- persistencia dos filtros em `sessionStorage`
- retorno para a listagem com filtros restaurados
- coluna `Status OC` no grid
- coluna `Dt Ult OC` no grid

## Pontos tecnicos

Funcoes adicionadas em `view/lead_res_form.js`:

- `fcTemPermissaoSuccess`
- `fcLeadSemResponsavel`
- `fcPodeAcessarLead`

Essas funcoes passaram a ser usadas nas acoes:

- painel
- editar
- excluir

## Instrucoes para aplicar no VPS

1. Atualizar o arquivo `view/lead_res_form.js` no projeto publicado no VPS.
2. Garantir que a versao publicada mantenha a coluna `Status OC` e o fluxo de `Retornar a Lista`.
3. Se existir pasta de publicacao espelhada como `deploy/app/view/lead_res_form.js`, alinhar manualmente se o processo do VPS usar essa copia.
4. Recarregar a pagina no navegador com cache limpo.

## Prompt sugerido para o ChatGPT aplicar no VPS

Aplicar no VPS a atualizacao do modulo de leads referente ao arquivo `view/lead_res_form.js`.

Objetivo:
- corrigir a permissao de abertura do painel do lead
- manter a coluna `Status OC`
- manter o fluxo de `Retornar a Lista`

Regra esperada:
- se o usuario tiver `acessar_todos_lead`, pode abrir/editar/excluir
- se o lead estiver sem responsavel definido, pode abrir/editar/excluir
- se o usuario for responsavel pelo lead, pode abrir/editar/excluir
- caso contrario, deve exibir o alerta de bloqueio

Importante:
- nao remover o uso de `sessionStorage` dos filtros
- nao remover a coluna `Status OC`
- nao quebrar o retorno para `lead_res_form.php`

Arquivo principal:
- `view/lead_res_form.js`
