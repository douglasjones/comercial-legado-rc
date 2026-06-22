# Agenda de visitas

## 1. Objetivo aparente
Controlar o calendário comercial de visitas, reuniões e fechamentos, com filtros por polo, equipe, responsável, classificação e agendado por.

## 2. Pontos de acesso
- Menu principal: `Ag. Visita`
- Tela principal: `view/agenda_res_form.php`
- Includes / telas auxiliares
  - `view/inc_agenda_visita_cad_form.php`
  - `view/cal_inc_agenda_visita_cad_form.php`
  - `view/inc_dashboard_agenda_visita_cad_form.php`

## 3. Arquivos principais envolvidos
- Controller
  - `controller/agenda_visita.controller.php`
- DAO
  - `model/agenda_visita.dao.php`
- Dependências
  - `model/processo.dao.php`
  - `model/processo_default_etapa.dao.php`
  - `model/ocorrencia.dao.php`
  - `model/tipo_ocorrencia.dao.php`
  - `model/contato.dao.php`
  - `model/usuario.dao.php`
  - `model/lead_responsavel.dao.php`
  - `model/polo.dao.php`
  - `model/enviar_email.dao.php`
  - `controller/layout_agenda.controller.php`
- JS
  - `view/agenda_res_form.js`
  - `view/inc_agenda_visita_cad_form.js`
  - `view/cal_inc_agenda_visita_cad_form.js`

## 4. Fluxo identificado no código
1. O usuário abre `agenda_res_form.php`.
2. O frontend carrega mês/ano e monta a grade/calendário.
3. O usuário pode filtrar por:
   - polo
   - perfil
   - tipo de agendamento
   - responsável
   - classificação
   - agendado por
   - equipe
   - atendente
4. Ao criar/editar um agendamento, o sistema grava dados da visita e uma lista de responsáveis.
5. Na gravação, o controller remove vínculos antigos em `agendas_responsavel` e recria os atuais.
6. Se um responsável do agendamento ainda não estiver vinculado ao lead, o sistema cria vínculo em `leads_responsaveis`.
7. A tela também carrega ocorrência, lead, telefone, endereço, contato e responsáveis do lead a partir do contexto da agenda.
8. Há ações para abrir o painel do lead.

## 5. Entradas do módulo
- Dados da agenda
  - `dt_agenda_visita`
  - `hr_agenda_visita`
  - endereço completo
  - observações
  - `classificacao_agenda_pk`
  - motivo/obs de cancelamento
  - motivo/obs de reagendamento
  - `processos_etapas_pk`
  - `tipos_agendas_pk`
  - `ic_status`
  - `tipo_evento_pk`
  - `ds_titulo_agenda`
  - `aviso_pk`
  - `atendente_pk`
- Contato da agenda
  - contato, celular, telefone, email, cargo
- Relações
  - `polos_pk`
  - `leads_pk`
  - lista JSON `responsavel_pk`

## 6. Regras e processamentos identificados
- Há permissões distintas para:
  - inserir agenda
  - reagendar
  - classificar agenda
- Tipos de agendamento expostos no frontend:
  - `1` Prospecção
  - `2` Reunião
  - `3` Fechamento
- Classificação exposta no frontend:
  - `1` Produtivo
  - `2` Improdutivo
  - `3` Reagendado
  - `4` Cancelado
- O controller preenche `dt_reagendamento` com a própria data/hora da agenda em alguns cenários de save.
- Há integração com email (`enviar_email.dao.php`), mas o fluxo completo de disparo não foi confirmado integralmente.
- A agenda conversa com ocorrências e com a classificação de processo/lead.

## 7. Saídas do módulo
- Grade/calendário mensal
- Grid de ocorrências relacionadas
- Abertura do painel do lead
- Indicadores usados em dashboard e relatórios

## 8. Tabelas e entidades envolvidas
- `agendas`
- `agendas_responsavel`
- `leads`
- `processos_etapas`
- `usuarios`
- `leads_responsaveis`
- `ocorrencias`
- `contatos`

## 9. Dependências com outros módulos
- Leads
- Processos
- Ocorrências / retornos
- Dashboards
- Relatórios

## 10. Pontos confirmados no código
- A agenda possui múltiplos responsáveis por registro.
- O filtro visual inclui equipe e atendente.
- O agendamento pode abrir o painel do lead.
- O módulo injeta vínculo de responsável no lead se necessário.

## 11. Pontos duvidosos ou incompletos
- O significado exato de `tipo_evento_pk`, `aviso_pk` e parte do layout do calendário não ficou totalmente claro.
- O disparo de email não foi confirmado ponta a ponta.
- Parte da lógica de classificação automática parece estar espalhada entre agenda, ocorrência e processo.

## 12. O que precisa ser validado manualmente
- Regras reais de reagendamento e cancelamento na interface.
- Se o filtro “agendado por” usa usuário de cadastro, atendente ou ambos em telas específicas.
- Se a classificação da agenda altera automaticamente indicadores do dashboard.

## 13. Nível de confiança da análise
médio
