# Correcao Backend Status OC no Deploy - 2026-06-23

## Problema

Depois da sincronizacao dos arquivos de `view`, a coluna `Status OC` passou a aparecer no grid do ambiente RC, mas:

- o valor exibido ficava deslocado
- o DataTables apresentava aviso de parametro desconhecido

## Causa raiz

No deploy, os arquivos de interface ja estavam atualizados:

- `deploy/app/view/lead_res_form.php`
- `deploy/app/view/lead_res_form.js`

Mas o backend de deploy ainda nao devolvia o campo `ds_status_oc`:

- `deploy/app/model/lead.dao.php`
- `deploy/app/controller/lead.controller.php`

Ou seja:

- o HTML esperava a coluna `Status OC`
- o JavaScript esperava `t_ds_status_oc`
- o JSON retornado nao continha esse campo

## Correcao aplicada

### Arquivo `deploy/app/model/lead.dao.php`

Foi incluido no `listarLeadsRes`:

- `ANY_VALUE(tio_ult.ds_tipo_ocorrencia) ds_status_oc`
- `LEFT JOIN tipos_ocorrencias tio_ult ON tio_ult.pk = l.ocorrencias_ult_pk`

### Arquivo `deploy/app/controller/lead.controller.php`

Foi incluido no array retornado para a grid:

- `t_ds_status_oc`

## O que aplicar no VPS

Atualizar:

- `deploy/app/model/lead.dao.php`
- `deploy/app/controller/lead.controller.php`

Depois:

- rebuildar novamente o cliente RC

## Resultado esperado

- a coluna `Status OC` passa a exibir o texto correto
- o DataTables deixa de acusar parametro desconhecido
- a listagem volta a alinhar corretamente todas as colunas
