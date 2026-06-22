# Cadastros operacionais

## 1. Objetivo aparente
Manter cadastros auxiliares usados por leads, agenda, processo, proposta, contrato e colaborador.

## 2. Pontos de acesso
- Menu: `Administração`
  - Processo
  - Tipos de OC
  - Produtos
  - Operador
- Menu: `Cadastros`
  - Cargos
  - Motivos Pausa
  - Equipes
  - Gêneros
  - Produtos/Serviços
  - Processos Default
  - Tipos Ocorrências

Observação:
- No workspace atual, alguns destinos do menu não existem como view:
  - `cargo_res_form.php`
  - `motivo_pausa_res_form.php`
  - `genero_res_form.php`

## 3. Arquivos principais envolvidos
- Controllers confirmados
  - `controller/produto_servico.controller.php`
  - `controller/tipo_ocorrencia.controller.php`
  - `controller/operador.controller.php`
  - `controller/processo_default.controller.php`
  - `controller/processo_default_etapa.controller.php`
  - `controller/plano.controller.php`
  - `controller/cargo.controller.php`
  - `controller/genero.controller.php`
  - `controller/motivo_pausa.controller.php`
- Views confirmadas
  - `view/produto_servico_*`
  - `view/tipo_ocorrencia_*`
  - `view/operador_*`
  - `view/processo_default_*`
  - `view/plano_*`
- Views ausentes para alguns cadastros de menu
  - cargos
  - motivo pausa
  - gêneros

## 4. Fluxo identificado no código
1. O usuário acessa a listagem do cadastro disponível.
2. Faz inclusão/edição/exclusão simples.
3. Os registros passam a ser consumidos por outros módulos:
   - produto/serviço em proposta, contrato e colaborador
   - tipo de ocorrência em agenda/retorno/processo
   - operador em lead, proposta, contrato e polo
   - processo default na abertura de processo comercial

## 5. Entradas do módulo
- Dependem do cadastro específico.
- Confirmadas no código:
  - nome/descrição do produto ou serviço
  - tipo de ocorrência e flags
  - operador e classificações
  - processo default e etapas
  - plano
  - cargo
  - gênero
  - motivo de pausa

## 6. Regras e processamentos identificados
- Muitos controllers seguem padrão CRUD simples.
- `tipos_ocorrencias` é um cadastro estratégico porque aparece em:
  - ocorrências manuais
  - ocorrências automáticas de proposta
  - transferência
  - migração
- `processos_default` e `processos_default_etapas` definem base do funil e de parte das classificações.
- Operador também participa de classificação e vinculação por polo.

## 7. Saídas do módulo
- Catálogos de apoio consumidos por outros módulos
- Combos e grids usados em leads, agenda, processos e contratos

## 8. Tabelas e entidades envolvidas
- `produtos_servicos`
- `tipos_ocorrencias`
- `operadores`
- `processos_default`
- `processos_default_etapas`
- `planos`
- `cargos`
- `generos`
- `motivos_pausas`

## 9. Dependências com outros módulos
- Leads
- Agenda
- Ocorrências
- Processos / propostas / contratos
- Colaboradores
- Polos

## 10. Pontos confirmados no código
- Os controllers CRUD desses cadastros existem.
- Nem todos possuem view correspondente no repositório atual.
- Produtos/serviços, tipos de ocorrência, operador e processo default são efetivamente usados por módulos centrais.

## 11. Pontos duvidosos ou incompletos
- Sem as views faltantes, não dá para confirmar se alguns cadastros ainda estão expostos ao usuário final.
- O uso de planos parece mais ligado à cobrança/configuração de polo do que a operação diária.

## 12. O que precisa ser validado manualmente
- Quais cadastros do menu realmente abrem no ambiente rodando.
- Se os cadastros sem view atual foram removidos, renomeados ou estão fora deste dump.
- Quais campos específicos existem nas telas ausentes.

## 13. Nível de confiança da análise
baixo
