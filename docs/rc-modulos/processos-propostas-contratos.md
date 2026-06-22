# Processos / propostas / contratos

## 1. Objetivo aparente
Conduzir a evolução comercial do lead por processo, etapa, proposta e contrato, alterando a classificação do funil.

## 2. Pontos de acesso
- Principalmente a partir de `view/lead_main_form.php`
- Tela de processo: `view/processo_cad_form.php`
- Modais:
  - `view/inc_proposta_cad_form.php`
  - `view/inc_contrato_cad_form.php`
- Relatório ligado:
  - `view/rel_funil_vendas_pesq.php`

## 3. Arquivos principais envolvidos
- Controllers
  - `controller/processo.controller.php`
  - `controller/proposta.controller.php`
  - `controller/proposta_item.controller.php`
  - `controller/contrato.controller.php`
  - `controller/contrato_item.controller.php`
  - `controller/etapa_contrato.controller.php`
- DAOs
  - `model/processo.dao.php`
  - `model/processo_default.dao.php`
  - `model/processo_default_etapa.dao.php`
  - `model/proposta.dao.php`
  - `model/proposta_item.dao.php`
  - `model/contrato.dao.php`
  - `model/contrato_item.dao.php`
- Views / JS
  - `view/processo_cad_form.php`
  - `view/processo_cad_form.js`
  - `view/inc_proposta_cad_form.php`
  - `view/inc_proposta_cad_form.js`
  - `view/inc_contrato_cad_form.php`
  - `view/inc_contrato_cad_form.js`

## 4. Fluxo identificado no código
1. No painel do lead, o usuário inclui ou acessa um processo.
2. `controller/processo.controller.php` pode:
   - criar processo a partir de um `processo_default`
   - registrar cancelamento do processo
3. `view/processo_cad_form.php` apresenta etapas numeradas do processo.
4. Em cada etapa, a aplicação pode abrir proposta ou contrato.
5. Ao salvar proposta:
   - soma itens da proposta
   - grava cabeçalho e itens
   - identifica o processo pelo `processos_etapas_pk`
   - compara classificação atual do processo com a classificação da etapa
   - atualiza a classificação do processo se a etapa for mais avançada
   - pode gerar ocorrência automática ligada ao tipo de ocorrência da etapa
6. Ao salvar contrato:
   - grava cabeçalho
   - grava itens
   - grava esteira de aprovações/etapas de contrato
   - também participa da evolução da classificação do processo
7. Ao excluir processo, o controller remove em cascata contratos, agendas, propostas, ocorrências e retornos das etapas do processo.

## 5. Entradas do módulo
- Processo
  - `pk` de processo default
  - `leads_pk`
  - `polos_pk`
  - motivo de cancelamento
- Proposta
  - versão
  - responsável
  - operadora
  - itens
  - data de envio
  - previsão de fechamento
  - data de validade
  - flags/valores de fechamento e cancelamento
  - observação
- Contrato
  - tipo contrato/aditivo
  - contrato pai
  - operadora
  - itens
  - etapas de contrato
  - número de pedido da operadora
  - observação

## 6. Regras e processamentos identificados
- Proposta recalcula `vl_total` somando itens recebidos.
- Processo usa classificação incremental conforme a etapa.
- Proposta pode gerar ocorrência automática se a etapa default tiver tipo de ocorrência associado.
- Contrato tem suporte explícito a:
  - contrato
  - aditivo
  - contrato pai
- Exclusão de processo é altamente cascata.
- Há vínculos fortes com polo, operador, lead e processo etapa.

## 7. Saídas do módulo
- Processo criado por lead
- Etapas carregadas
- Propostas e itens
- Contratos e esteira de aprovação
- Evolução da classificação do processo
- Ocorrências automáticas derivadas da etapa

## 8. Tabelas e entidades envolvidas
- `processos`
- `processos_etapas`
- `processos_default`
- `processos_default_etapas`
- `propostas`
- `propostas_itens`
- `contratos`
- `contratos_itens`
- `contratos_etapas_contratos`
- `etapas_contratos`
- `ocorrencias`
- `agendas`

## 9. Dependências com outros módulos
- Leads
- Agenda de visitas
- Ocorrências / retornos
- Operadores
- Polos
- Relatórios e dashboards

## 10. Pontos confirmados no código
- Processo pode nascer a partir de processo default.
- Proposta atualiza a classificação comercial do processo.
- Proposta pode gerar ocorrência automática.
- Contrato suporta aditivo e contrato pai.
- Excluir processo remove estruturas filhas importantes.

## 11. Pontos duvidosos ou incompletos
- O conjunto completo de regras de classificação do processo está espalhado entre DAOs e etapas default.
- Não ficou totalmente claro quando o contrato marca o lead como cliente sem depender de rotinas de migração.
- Partes do HTML de proposta/contrato dependem de includes auxiliares não lidos integralmente.

## 12. O que precisa ser validado manualmente
- Como o usuário navega entre etapas no processo.
- Em quais etapas proposta e contrato ficam disponíveis.
- Se o fechamento de proposta altera automaticamente a carteira/relatórios.
- Como a esteira de aprovação de contrato se comporta no uso real.

## 13. Nível de confiança da análise
médio
