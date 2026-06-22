# CHANGELOG_RC_UPDATE

Data de geração: 2026-03-16

Objetivo: release incremental para VPS, sem reinstalação completa e sem recriação de banco.

## Base de comparação
- Release anterior considerada: `deploy/app` (pacote atual já publicado no VPS).
- Estratégia: copiar apenas arquivos alterados para o patch + manter persistência de banco.

## Arquivos alterados

| Arquivo | Tipo | Impacto | Rebuild | Restart | Mudança de BD | Mudança em .env |
|---|---|---|---:|---:|---:|---:|
| controller/lead.controller.php | Aplicação (PHP) | Ajuste de fluxo/rregra em controllers/views (cadastro/agenda/telefones/lead). | Sim* | Sim | Não | Não |
| controller/telefone.controller.php | Aplicação (PHP) | Ajuste de fluxo/rregra em controllers/views (cadastro/agenda/telefones/lead). | Sim* | Sim | Não | Não |
| inc/js/bestflow/bestflow.js | Aplicação (JS front-end) | Ajuste de comportamento de formulário/validação e máscara. | Sim* | Sim | Não | Não |
| view/inc_agenda_visita_cad_form.js | Aplicação (JS front-end) | Ajuste de comportamento de formulário/validação e máscara. | Sim* | Sim | Não | Não |
| view/inc_agenda_visita_cad_form.php | Aplicação (PHP) | Ajuste de fluxo/rregra em controllers/views (cadastro/agenda/telefones/lead). | Sim* | Sim | Não | Não |
| view/inc_dashboard_agenda_visita_cad_form.js | Aplicação (JS front-end) | Ajuste de comportamento de formulário/validação e máscara. | Sim* | Sim | Não | Não |
| view/inc_dashboard_agenda_visita_cad_form.php | Aplicação (PHP) | Ajuste de fluxo/rregra em controllers/views (cadastro/agenda/telefones/lead). | Sim* | Sim | Não | Não |
| view/inc_endereco_cad_form.js | Aplicação (JS front-end) | Ajuste de comportamento de formulário/validação e máscara. | Sim* | Sim | Não | Não |
| view/inc_telefone_cad_form.js | Aplicação (JS front-end) | Ajuste de comportamento de formulário/validação e máscara. | Sim* | Sim | Não | Não |
| view/inc_telefone_cad_form.php | Aplicação (PHP) | Ajuste de fluxo/rregra em controllers/views (cadastro/agenda/telefones/lead). | Sim* | Sim | Não | Não |
| view/inc_telefone_res_form.php | Aplicação (PHP) | Ajuste de fluxo/rregra em controllers/views (cadastro/agenda/telefones/lead). | Sim* | Sim | Não | Não |
| view/lead_cad_form.js | Aplicação (JS front-end) | Ajuste de comportamento de formulário/validação e máscara. | Sim* | Sim | Não | Não |
| view/lead_cad_form.php | Aplicação (PHP) | Ajuste de fluxo/rregra em controllers/views (cadastro/agenda/telefones/lead). | Sim* | Sim | Não | Não |
| view/lead_main_form.php | Aplicação (PHP) | Ajuste de fluxo/rregra em controllers/views (cadastro/agenda/telefones/lead). | Sim* | Sim | Não | Não |

## Configuração, Banco e Docs
- Nenhum script de banco foi alterado nesta release.
- Nenhum migration novo identificado (sem dump de banco).
- Não há documentação nova além deste changelog/guia.

## Observações de segurança
- Não incluir mudanças de `.env.production`.
- Não sobrescrever variáveis locais do VPS fora do necessário.
- Banco de dados persistido no VPS não deve ser recriado.

