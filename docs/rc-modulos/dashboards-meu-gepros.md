# Dashboards / Meu Gepros

## 1. Objetivo aparente
Oferecer visão operacional resumida por perfil, reunindo retornos pendentes, agenda, oportunidades, propostas e gráficos.

## 2. Pontos de acesso
- Menu: `Meu Gepros`
- Rotas / telas
  - `view/dashboard_consultor_res_form.php`
  - `view/dashboard_gestor_res_form.php`
  - `view/dashboard_supervisor_res_form.php`
  - `view/dashboard_telemarket_res_form.php`
  - `view/dashboard_res_form.php`

## 3. Arquivos principais envolvidos
- Views / páginas
  - dashboards acima
  - `view/inc_dashboard_agenda_visita_res_form.php`
  - `view/inc_dashboard_proposta_res_form.php`
  - `view/inc_dashboard_contrato_res_form.php`
- Scripts JS
  - `view/dashboard_consultor_res_form.js`
  - `view/dashboard_gestor_res_form.js`
  - `view/dashboard_supervisor_res_form.js`
  - `view/dashboard_telemarket_res_form.js`
  - `view/dashboard_res_form.js`
- Controllers
  - `controller/retorno.controller.php`
  - `controller/agenda_visita.controller.php`
  - `controller/proposta.controller.php`
  - `controller/grafico_agendamento_controller.php`
  - `controller/grafico_funil_vendas_controller.php`
  - outros `controller/grafico_*.php`

## 4. Fluxo identificado no código
1. `view/principal.php` escolhe o dashboard pelo grupo do usuário.
2. O dashboard carrega nome do usuário logado.
3. Carrega métricas de retorno atrasado e grid de retornos.
4. Carrega agenda de visitas do dia ou do período.
5. Carrega gráficos de agenda e funil/carteira/oportunidades dependendo do perfil.
6. Em alguns dashboards há grids de proposta 50%, 75%, fechada e cancelada.
7. A partir de grids e widgets, o usuário pode abrir:
   - painel do lead
   - modais de nova ocorrência
   - edição de retorno
   - proposta

## 5. Entradas do módulo
- Filtros por data
- Filtro de membro de equipe no dashboard supervisor
- Filtro implícito por usuário, equipe, grupo e polo do token
- Ações em grid para abrir lead, proposta ou ocorrência

## 6. Regras e processamentos identificados
- Cada dashboard é especializado por grupo.
- O dashboard supervisor consulta membro de equipe.
- O dashboard consultor e telemarketing mostram carteira e oportunidades futuras.
- O dashboard gestor e dashboards gerais trabalham com retorno, agenda e gráficos.
- Várias ações do dashboard abrem `lead_main_form.php`.
- O módulo usa bastante agregação via controllers `grafico_*`.

## 7. Saídas do módulo
- Indicadores numéricos
- Gráficos
- Grids de retorno, agenda, proposta e oportunidades
- Atalhos para lead e modais operacionais

## 8. Tabelas e entidades envolvidas
- `retornos`
- `ocorrencias`
- `agendas`
- `agendas_responsavel`
- `propostas`
- `processos`
- `leads`
- `leads_operadoras`
- `usuarios`
- `equipes`

## 9. Dependências com outros módulos
- Leads
- Agenda de visitas
- Retornos / ocorrências
- Processos / propostas
- Relatórios gráficos

## 10. Pontos confirmados no código
- Existem dashboards distintos por grupo.
- O dashboard usa controllers gráficos dedicados.
- O dashboard abre o painel do lead a partir de grids.
- Há seção explícita de retornos pendentes/atrasados.

## 11. Pontos duvidosos ou incompletos
- Nem todas as consultas de cada widget foram lidas em detalhe.
- A diferença funcional exata entre `dashboard_gestor_res_form.php` e `dashboard_res_form.php` precisa de teste.
- Parte dos includes de dashboard reutiliza componentes complexos de agenda/proposta.

## 12. O que precisa ser validado manualmente
- Quais widgets aparecem para cada grupo real em produção.
- Se todos os gráficos carregam dados sem dependências adicionais.
- Se ações de “nova ocorrência”, “novo retorno” e “editar proposta” funcionam em todos os perfis.

## 13. Nível de confiança da análise
médio
