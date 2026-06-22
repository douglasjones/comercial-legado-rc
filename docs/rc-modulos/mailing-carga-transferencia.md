# Mailing / carga de leads / transferência

## 1. Objetivo aparente
Organizar a origem da carteira, registrar cargas de leads e redistribuir leads entre responsáveis.

## 2. Pontos de acesso
- Menu: `Administração`
  - `Mailing`
  - `Carga Lead`
  - `Transferencia de Leads`
- Telas
  - `view/mailing_res_form.php`
  - `view/mailing_cad_form.php`
  - `view/carga_lead_res_form.php`
  - `view/carga_lead_cad_form.php`
  - `view/transferencia_lead.php`
  - `view/transferencia_lead2.php`

## 3. Arquivos principais envolvidos
- Controllers
  - `controller/mailing.controller.php`
  - `controller/carga_lead.controller.php`
  - `controller/transferencia_lead.controller.php`
- DAOs
  - `model/mailing.dao.php`
  - `model/carga_lead.dao.php`
  - `model/transferencia_lead.dao.php`
  - `model/lead_responsavel.dao.php`
  - `model/ocorrencia.dao.php`
  - `model/tipo_ocorrencia.dao.php`
- JS
  - `view/mailing_res_form.js`
  - `view/mailing_cad_form.js`
  - `view/carga_lead_res_form.js`
  - `view/carga_lead_cad_form.js`
  - `view/transferencia_lead.js`
  - `view/transferencia_lead2.js`

## 4. Fluxo identificado no código
1. Mailing cadastra a origem/lista de carteira por polo e status.
2. Carga Lead registra um arquivo/carga associado a mailing, polo, cliente, grupo e usuário.
3. A listagem de carga possui visualização de “não realizado”.
4. Transferência de lead começa em `transferencia_lead.php`, com filtros de seleção da carteira.
5. O fluxo avança para `transferencia_lead2.php`.
6. O controller de transferência:
   - consulta quantidade de leads por classificação
   - seleciona leads para transferência
   - cria ocorrência automática “Transferência de Lead”
   - altera o vínculo em `leads_responsaveis`

## 5. Entradas do módulo
- Mailing
  - nome
  - status
  - polo
- Carga
  - mailing
  - polo
  - arquivo
  - flag cliente
  - grupo
  - usuário
- Transferência
  - polo
  - razão social
  - tipo pessoa
  - mailing
  - filtros de status comercial
  - perfil
  - responsável atual
  - responsável de destino
  - grupo de destino
  - total a transferir

## 6. Regras e processamentos identificados
- Mailing tem status e escopo por polo/conta.
- Carga de lead registra apenas a carga no controller analisado; a rotina completa de importação de arquivo parece estar no DAO ou em processo externo.
- Transferência cria ocorrência automática com tipo específico de transferência.
- Transferência altera o responsável do lead usando `lead_responsavel`.
- A tela mostra quantidade por classificação antes da transferência.

## 7. Saídas do módulo
- Cadastros de mailing
- Registros de carga
- Grid de carga não realizada
- Quantitativo de leads elegíveis para transferência
- Alteração de responsável do lead
- Ocorrência de transferência

## 8. Tabelas e entidades envolvidas
- `mailing`
- `cargas`
- `cargas_lead`
- `carga_nao_realizada`
- `leads`
- `leads_responsaveis`
- `ocorrencias`
- `tipos_ocorrencias`

## 9. Dependências com outros módulos
- Leads
- Usuários / grupos
- Polos
- Ocorrências

## 10. Pontos confirmados no código
- Transferência gera ocorrência automática.
- O responsável do lead é alterado no backend.
- Existe consulta específica para “não realizado” em carga.

## 11. Pontos duvidosos ou incompletos
- A importação física do arquivo de carga não ficou clara apenas pelo controller.
- Não ficou totalmente claro se a transferência atualiza somente um vínculo de responsável ou múltiplos vínculos por lead.

## 12. O que precisa ser validado manualmente
- Como o arquivo de carga é processado de fato.
- Se a transferência seleciona leads aleatoriamente, por ordem fixa ou por outro critério.
- Se a ocorrência de transferência aparece imediatamente no histórico do lead.

## 13. Nível de confiança da análise
médio
