# CRM Cliente RC - Mapa Geral do Sistema

## Visão geral aparente do sistema
O código indica um CRM comercial em PHP legado, com foco em gestão de leads, agenda comercial, ocorrências/retornos, propostas, contratos, usuários/perfis e operação por polo/conta. A estrutura é majoritariamente server-rendered, com páginas PHP em `view/`, chamadas AJAX para controllers em `controller/` e regras de consulta/gravação concentradas em DAOs dentro de `model/`.

O sistema não está organizado por framework moderno. A navegação depende de `sendPost(...)`, `abrirMenu(...)`, sessão PHP e permissões verificadas por domínio de módulo.

## Ponto de entrada principal
- `index.php`
  - Redireciona para `view/login_form.php`.
- `view/login_form.php`
  - Renderiza o formulário de login.
- `view/login_form.js`
  - Envia `job=autenticarUsuario` para `controller/usuario.controller.php`.
- `controller/usuario.controller.php`
  - Em `autenticarUsuario`, valida usuário/senha, grava `$_SESSION['auth']`, define expiração de 10 horas e retorna `session_id()` como token.

## Fluxo macro após login
1. `index.php` redireciona para `view/login_form.php`.
2. O login chama `controller/usuario.controller.php` com `job=autenticarUsuario`.
3. Em caso de sucesso, `view/login_form.js` consulta `controller/retorno.controller.php?job=listarRerornoPopUp`.
4. Se houver retorno pendente, abre `view/retorno_popup.php`.
5. Em seguida, envia para `view/principal.php`.
6. `view/principal.php` lê `grupos_pk` do token e abre um dashboard conforme o grupo:
   - grupo `2`: `dashboard_consultor_res_form.php`
   - grupo `3`: `dashboard_gestor_res_form.php`
   - grupo `5`: `dashboard_supervisor_res_form.php`
   - grupo `6`: `dashboard_telemarket_res_form.php`
   - grupo `4`: `dashboard_res_form.php`
7. O cabeçalho em `inc/php/header.php` passa a controlar o menu principal por permissão.

## Menu principal e submenus encontrados
Confirmados em `inc/php/header.php` e nos arquivos `view/menu_*.php`.

### Meu Gepros
- Dashboard por grupo.

### Leads
- `view/lead_res_form.php`

### Ag. Visita
- `view/agenda_res_form.php`

### Ag. Retorno
- `view/agenda_retorno_res_form.php`
- O item no header está ativo mesmo com trecho de permissão comentado.

### Relatórios
- `view/menu_relatorios.php`
  - Agendamento
  - Ocorrência
  - Carteira
  - Funil de Vendas

### Administração
- `view/menu_administracao.php`
  - Conta
  - Polos
  - Usuários
  - Equipes
  - Processo
  - Tipos de OC
  - Produtos
  - Operador
  - Mailing
  - Carga Lead
  - Transferência de Leads

### CPainel
- `view/menu_cpainel.php`
  - Módulos do Sistema
  - Grupo de usuários
  - Migração Status

## Módulos encontrados
1. Login, autenticação e navegação base
2. Dashboards e Meu Gepros
3. Leads
4. Agenda de visitas
5. Agenda de retornos, ocorrências e retornos pendentes
6. Processos comerciais, propostas e contratos
7. Administração de conta e polos
8. Usuários, equipes, grupos e permissões
9. Mailing, carga de leads e transferência
10. Cadastros operacionais
11. Relatórios e gráficos
12. Colaboradores e agenda de colaborador
13. CPainel, migração e utilitários administrativos

## Relação entre módulos
- Login/autenticação condiciona todo o restante por sessão e permissão.
- Dashboards consomem leads, agenda, propostas e retornos.
- Leads é o centro funcional do CRM.
- Agenda de visitas e agenda de retorno abrem o painel do lead.
- Ocorrências e retornos se vinculam a leads e, em parte, a etapas de processo.
- Processos, propostas e contratos dependem do lead e atualizam sua classificação comercial.
- Conta/polo/usuário/equipe/permissão delimitam escopo operacional e visibilidade.
- Mailing/carga/transferência alimentam ou redistribuem a carteira de leads.
- Relatórios e gráficos leem agenda, ocorrências, propostas, processos e carteira.

## Áreas obscuras ou inconsistentes
- Há itens de menu apontando para views ausentes no workspace atual:
  - `cargo_res_form.php`
  - `motivo_pausa_res_form.php`
  - `genero_res_form.php`
  - `colaborador_res_form.php`
  - `agenda_condominio_res_form.php`
  - `agenda_colaborador_res_form.php`
  - `teste_calendario_res_form.php`
  - `ocorrencia_cad_form.php`
- Há módulos com controller/model mas sem ponto de acesso claro na navegação atual, como colaborador, agenda de colaborador, plano e partes de contrato/proposta fora do painel do lead.
- O sistema mistura nomes legados e atuais. Exemplo: menu “Ag. Retorno” abre `agenda_retorno_res_form.php`, mas o menu antigo referencia `teste_calendario_res_form.php`.
- Alguns comportamentos dependem fortemente de permissões por domínio, mas o catálogo completo de módulos/permissões só fica claro cruzando `modulos`, `modulos_grupos`, `grupos` e chamadas `permissao(...)`.

## Riscos de entendimento apenas pelo código
- Há muita regra distribuída entre PHP view, JS e DAO SQL.
- Parte do fluxo operacional está em modais incluídos dentro de outras telas, especialmente no painel do lead e nos dashboards.
- O banco contém estruturas que sugerem funcionalidades antigas ou em transição.
- Itens com nome presente no menu nem sempre têm tela correspondente no repositório atual.
- Como o ambiente é legado e session-based, o comportamento real pode depender de dados já existentes no banco, perfis cadastrados e permissões configuradas.

## Evidências principais usadas
- `index.php`
- `view/login_form.php`
- `view/login_form.js`
- `view/principal.php`
- `inc/php/header.php`
- `inc/php/public.php`
- `controller/usuario.controller.php`
- `controller/lead.controller.php`
- `controller/agenda_visita.controller.php`
- `controller/retorno.controller.php`
- `controller/ocorrencia.controller.php`
- `controller/processo.controller.php`
- `controller/proposta.controller.php`
- `controller/contrato.controller.php`
- `controller/conta.controller.php`
- `controller/polo.controller.php`
- `controller/mailing.controller.php`
- `controller/carga_lead.controller.php`
- `controller/transferencia_lead.controller.php`
- `controller/grupo.controller.php`
- `controller/modulo.controller.php`
- `data/rc_wwgepr_crm_antigo.sql`
