# Correcao de Pesquisa Leads no Deploy - 2026-06-23

## Causa raiz

No VPS, o build usa a arvore `deploy/app/view`.

Na implantacao anterior foi publicado apenas o arquivo:

- `deploy/app/view/lead_res_form.js`

Mas o arquivo HTML de deploy permaneceu antigo:

- `deploy/app/view/lead_res_form.php`

Isso deixou a tela com divergencia entre:

- quantidade de colunas do HTML
- mapeamento de colunas do DataTables no JavaScript

## Sintoma observado

Ao clicar em `Pesquisar`, o DataTables quebrava antes de montar a grade.

Erros vistos no navegador:

- `Cannot read properties of undefined (reading 'nTh')`
- `Cannot read properties of null (reading 'parentNode')`

## Correcao aplicada no repositorio

Arquivos ajustados:

- `deploy/app/view/lead_res_form.php`
- `deploy/app/view/lead_res_form.js`

## Ajustes feitos

### Em `deploy/app/view/lead_res_form.php`

- inclusao da coluna `Status OC` no cabecalho do grid
- alinhamento visual do cabecalho com a versao ativa

### Em `deploy/app/view/lead_res_form.js`

- inclusao do mapeamento da coluna `t_ds_status_oc`
- inclusao do fluxo de `sessionStorage` para filtros e retorno da lista
- inclusao da validacao centralizada de acesso ao lead
- protecao contra quebra silenciosa quando `acessar_todos_lead` nao retorna `success`

## O que precisa ser aplicado no VPS

Atualizar os dois arquivos abaixo no projeto publicado:

- `deploy/app/view/lead_res_form.php`
- `deploy/app/view/lead_res_form.js`

Depois, executar novamente o rebuild do cliente RC.

## Resultado esperado

- a pesquisa volta a executar normalmente
- o grid carrega sem erro de DataTables
- a coluna `Status OC` permanece visivel
- o fluxo de `Retornar a Lista` permanece funcionando
