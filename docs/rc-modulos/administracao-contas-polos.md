# Administração de conta e polos

## 1. Objetivo aparente
Configurar a conta cliente e seus polos operacionais, incluindo dados cadastrais, responsáveis, operadores habilitados, etapas contratuais e modelos de proposta.

## 2. Pontos de acesso
- Menu: `Administração`
- Submenus
  - `Conta`
  - `Polos`
- Telas
  - `view/conta_res_form.php`
  - `view/conta_cad_form.php`
  - `view/polo_res_form.php`
  - `view/polo_cad_form.php`

## 3. Arquivos principais envolvidos
- Controllers
  - `controller/conta.controller.php`
  - `controller/polo.controller.php`
  - `controller/conta_dados_cobranca.controller.php`
  - `controller/polo_operador.controller.php`
  - `controller/polo_modelo_proposta.controller.php`
- DAOs
  - `model/conta.dao.php`
  - `model/polo.dao.php`
  - `model/conta_dados_cobranca.dao.php`
  - `model/polo_operador.dao.php`
  - `model/polo_modelo_proposta.dao.php`
- Views / JS
  - `view/conta_res_form.php`
  - `view/conta_cad_form.php`
  - `view/polo_res_form.php`
  - `view/polo_cad_form.php`
  - includes de operador/modelo/etapa de polo

## 4. Fluxo identificado no código
1. O usuário acessa a listagem de conta ou polos.
2. Em conta, pode editar dados gerais da conta.
3. Em polos, além dos dados cadastrais, o formulário aceita coleções JSON para:
   - operadores do polo
   - etapas contratuais do polo
   - modelos de proposta do polo
4. Ao salvar polo, o controller grava o cabeçalho e depois salva as estruturas filhas.
5. `inc/php/header.php` consulta a conta logada e redireciona se estiver com `ic_status == 2`.

## 5. Entradas do módulo
- Conta
  - tipo de pessoa
  - nome da conta / razão social
  - CPF/CNPJ, RG, CNAE
  - telefone, celular, email
  - endereço
  - data de ativação / cancelamento
  - status
- Polo
  - dados cadastrais
  - segmento
  - responsável
  - contato
  - dados de cobrança
  - arrays de operadores, etapas e modelos

## 6. Regras e processamentos identificados
- Conta e polo usam escopo por token/conta.
- Polo agrega dados de cobrança junto ao próprio save.
- Polo salva:
  - operadores habilitados
  - esteira contratual
  - modelos de proposta por operador/status/tipo
- Há dependência explícita de `planos`, `tipo_pagamentos`, `bandeira_cartao` e `contas_dados_cobranca`.

## 7. Saídas do módulo
- Cadastro/edição de conta
- Cadastro/edição de polo
- Configuração operacional por polo
- Base para filtros de leads, agenda, usuários, mailing e relatórios

## 8. Tabelas e entidades envolvidas
- `contas`
- `polos`
- `contas_dados_cobranca`
- `polos_operadores`
- `polos_modelos_propostas`
- `etapas_contratos`
- `planos`

## 9. Dependências com outros módulos
- Usuários e permissões
- Leads
- Mailing
- Operadores
- Propostas
- Contratos

## 10. Pontos confirmados no código
- Conta tem validação indireta de status no header.
- Polo concentra várias configurações operacionais.
- O save de polo grava estruturas filhas em lote.

## 11. Pontos duvidosos ou incompletos
- O uso efetivo dos dados de cobrança não apareceu em fluxo financeiro separado.
- Não ficou claro se `conta_dados_cobranca` é usado fora do cadastro de polo/conta.

## 12. O que precisa ser validado manualmente
- Se o bloqueio por conta inativa funciona em todas as páginas.
- Se as configurações de modelo de proposta por polo realmente impactam o envio/impressão da proposta.
- Como as etapas contratuais do polo alimentam a esteira do contrato na interface.

## 13. Nível de confiança da análise
médio
