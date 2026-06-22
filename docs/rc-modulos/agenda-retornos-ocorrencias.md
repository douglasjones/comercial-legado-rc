# Agenda de retornos / ocorrências / retornos pendentes

## 1. Objetivo aparente
Registrar ocorrências ligadas ao lead, programar retornos e monitorar pendências e atrasos.

## 2. Pontos de acesso
- Menu principal: `Ag. Retorno`
- Telas
  - `view/agenda_retorno_res_form.php`
  - `view/retorno_popup.php`
  - `view/ocorrencia_res_form.php`
  - `view/inc_ocorrencia_cad_form.php`
- Ações relevantes
  - salvar ocorrência
  - salvar retorno
  - listar retornos em aberto
  - listar atrasados
  - abrir lead a partir do retorno

## 3. Arquivos principais envolvidos
- Controllers
  - `controller/retorno.controller.php`
  - `controller/ocorrencia.controller.php`
  - `controller/agenda_retorno.controller.php`
- DAOs
  - `model/retorno.dao.php`
  - `model/ocorrencia.dao.php`
  - `model/tipo_ocorrencia.dao.php`
- Views / JS
  - `view/agenda_retorno_res_form.php`
  - `view/agenda_retorno_res_form.js`
  - `view/retorno_popup.php`
  - `view/retorno_popup.js`
  - `view/inc_ocorrencia_cad_form.php`
  - `view/inc_ocorrencia_cad_form.js`

## 4. Fluxo identificado no código
1. O header e a tela de login consultam `listarRerornoPopUp`.
2. Se houver quantidade de retorno pendente, o sistema pode abrir um popup.
3. `agenda_retorno_res_form.php` funciona como calendário/lista de retornos com filtros.
4. Ao salvar uma ocorrência em `controller/ocorrencia.controller.php`, o mesmo fluxo também salva ou atualiza um retorno vinculado.
5. O retorno fica ligado a `ocorrencias_pk`.
6. Dashboards consultam:
   - retornos em aberto
   - total de atrasados
7. A partir do grid, o usuário pode abrir o painel do lead.

## 5. Entradas do módulo
- Ocorrência
  - `ds_ocorrencia`
  - `tipos_ocorrencias_pk`
  - `processos_etapas_pk`
  - `dt_fechamento`
  - `motivo_sem_interesse_pk`
  - `ds_motivo_sem_interesse`
  - `leads_pk`
- Retorno
  - `dt_retorno`
  - `hr_retorno`
  - `equipes_pk`
  - `responsavel_pk`
  - `dt_termino_retorno`
  - `ds_retorno`
  - `ocorrencias_pk`

## 6. Regras e processamentos identificados
- Salvar ocorrência pode criar/atualizar retorno no mesmo request.
- Excluir ocorrência remove retornos associados.
- O módulo expõe listagem de retorno em aberto e retorno atrasado.
- Tipos de ocorrência alimentam regras comerciais, inclusive “Sem Interesse” e ocorrências automáticas de proposta/transferência.
- Em `agenda_retorno_res_form.js` há permissões específicas para inserir agenda, reagendar e classificar.

## 7. Saídas do módulo
- Grid de retornos pendentes
- Popup de retorno
- Agenda/lista de retorno por período
- Ocorrências e retornos associados ao lead

## 8. Tabelas e entidades envolvidas
- `ocorrencias`
- `retornos`
- `tipos_ocorrencias`
- `leads`
- `processos_etapas`
- `equipes`
- `usuarios`

## 9. Dependências com outros módulos
- Leads
- Agenda de visitas
- Dashboards
- Processos
- Transferência de lead
- Migração

## 10. Pontos confirmados no código
- O popup de retorno é consultado no login e periodicamente no header.
- Ocorrência e retorno são gravados em fluxo acoplado.
- Existe contagem de retornos atrasados para dashboard.
- A tela de agenda de retorno abre o painel do lead.

## 11. Pontos duvidosos ou incompletos
- Não foi confirmado se `agenda_retorno.controller.php` ainda é a principal fonte de dados da tela ou se parte do comportamento está migrado para outros endpoints.
- A distinção funcional entre “agenda de retorno” e “retorno ligado à ocorrência” precisa de validação no sistema rodando.

## 12. O que precisa ser validado manualmente
- Quando um retorno é encerrado no fluxo da aplicação.
- Se todas as ocorrências exigem retorno ou se isso depende do tipo.
- Como a tela diferencia retorno pendente, respondido e atrasado.
- Quais tipos de ocorrência fecham automaticamente a ocorrência.

## 13. Nível de confiança da análise
médio
