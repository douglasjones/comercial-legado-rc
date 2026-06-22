# CPainel / migração / utilitários administrativos

## 1. Objetivo aparente
Oferecer manutenção administrativa de módulos/permissões e rotinas de migração de legado para status/classificações comerciais.

## 2. Pontos de acesso
- Menu: `CPainel`
- Submenus confirmados
  - `Módulos do Sistema`
  - `Grupo de usuários`
  - `Migração Status`
- Telas
  - `view/menu_cpainel.php`
  - `view/modulo_res_form.php`
  - `view/grupo_res_form.php`
  - `view/migracao_50_75.php`
  - `view/migrar.php`

## 3. Arquivos principais envolvidos
- Controllers
  - `controller/modulo.controller.php`
  - `controller/grupo.controller.php`
  - `controller/migrar_50_75.controller.php`
  - `controller/migrar.controller.php`
- DAOs
  - `model/modulo.dao.php`
  - `model/grupo.dao.php`
  - `model/migrar.dao.php`
- Views / JS
  - `view/modulo_*`
  - `view/grupo_*`
  - `view/migracao_50_75.php`
  - `view/migracao_50_75.js`
  - `view/migrar.php`
  - `view/migrar.js`

## 4. Fluxo identificado no código
1. O usuário de CPainel pode cadastrar módulos e grupos.
2. Em grupo, o sistema grava permissões por módulo.
3. Em migração 50/75, o usuário informa `pk_old` e uma porcentagem/status alvo.
4. O controller busca o lead correspondente pelo `pk_old` e executa ações automáticas:
   - criar processo
   - criar proposta
   - criar contrato
   - atualizar classificação do processo
   - gerar ocorrência de sem interesse
   - limpar processos/ocorrências para “não contactado”

## 5. Entradas do módulo
- Módulo
  - nome
  - domínio
  - polo
- Grupo
  - nome
  - polo
  - permissões por módulo
- Migração
  - `pk_old` separado por vírgula
  - `porcentagem_pk`

## 6. Regras e processamentos identificados
- A tela de migração oferece opções:
  - Sem Interesse
  - Não Contactado
  - Contactado
  - 50%
  - 75%
  - 80%
  - 90%
  - Cliente
- Para 50%, o sistema cria proposta com versão `1.0`.
- Para 75%, 80%, 90% e Cliente, cria contrato e atualiza classificação do processo.
- Para Sem Interesse, gera ocorrência “Migração”.
- Para Não Contactado, remove ocorrências, retornos, processos, contratos, agendas e propostas vinculadas.

## 7. Saídas do módulo
- Catálogo de módulos
- Grupos e permissões
- Ajustes massivos de classificação/status comercial

## 8. Tabelas e entidades envolvidas
- `modulos`
- `modulos_grupos`
- `grupos`
- `leads`
- `processos`
- `processos_etapas`
- `propostas`
- `contratos`
- `ocorrencias`
- `retornos`
- `agendas`

## 9. Dependências com outros módulos
- Usuários / permissões
- Processos
- Propostas
- Contratos
- Ocorrências
- Agenda

## 10. Pontos confirmados no código
- Há rotina administrativa explícita para migrar status/classificação.
- O módulo de grupo controla permissões por ação.
- O módulo cadastra `ds_dominio` usado nas verificações de permissão.

## 11. Pontos duvidosos ou incompletos
- Não foi confirmada a frequência de uso dessas rotinas no ambiente atual.
- `view/migrar.php` e `controller/migrar.controller.php` parecem coexistir com a migração 50/75, mas o escopo exato entre as duas rotinas não foi lido por completo.

## 12. O que precisa ser validado manualmente
- Se as rotinas de migração ainda são usadas em produção.
- Se existem travas de segurança antes de executar migração em massa.
- Se os domínios cadastrados em CPainel correspondem exatamente aos usados em todos os `permissao(...)`.

## 13. Nível de confiança da análise
médio
