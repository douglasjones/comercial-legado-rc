# Colaboradores / agenda de colaborador

## 1. Objetivo aparente
Manter cadastro de colaboradores e uma agenda técnica/operacional associada a processo, contrato e turnos.

## 2. Pontos de acesso
- Menu legado identificado em `view/menu_operacao.php`
  - `colaborador_res_form.php`
  - `agenda_colaborador_res_form.php`
- Situação no código atual
  - controllers e models existem
  - as views principais acima não foram encontradas no workspace atual

## 3. Arquivos principais envolvidos
- Controllers
  - `controller/colaborador.controller.php`
  - `controller/agenda_colaborador_padrao.controller.php`
  - `controller/agenda_colaborador_pausa.controller.php`
- DAOs
  - `model/colaborador.dao.php`
  - `model/agenda_colaborador_padrao.dao.php`
  - `model/agenda_colaborador_pausa.dao.php`
  - `model/documento.dao.php`
  - `model/produto_servico.dao.php`
- Views localizadas
  - nenhuma tela principal encontrada para colaborador/agenda do colaborador

## 4. Fluxo identificado no código
1. O cadastro de colaborador salva dados pessoais e de contato.
2. O save também recebe lista de produtos/serviços relacionados ao colaborador, com flags de treinamento e certificado.
3. A exclusão de colaborador:
   - remove vínculos de produtos/serviços
   - remove documentos físicos no diretório de upload
   - remove documentos do banco
4. A agenda padrão do colaborador grava:
   - período de vigência
   - colaborador
   - processo etapa
   - contrato item
   - flags por dia da semana
   - turnos por dia

## 5. Entradas do módulo
- Colaborador
  - nome
  - celulares
  - flags WhatsApp
  - email
  - RG / CPF
  - data de nascimento
  - endereço
  - status
  - funcionário ou não
  - gênero
  - lista de produtos/serviços vinculados
- Agenda padrão
  - descrição da agenda
  - datas início/fim
  - colaborador
  - processo etapa
  - contrato item
  - marcação de domingo a sábado
  - turno por dia

## 6. Regras e processamentos identificados
- Dias não marcados na agenda recebem valor `2`.
- O cadastro do colaborador apaga e recria vínculos de produtos/serviços no save.
- Documentos de colaborador usam o mesmo mecanismo de upload do sistema.
- O módulo aparenta ser mais operacional/técnico do que comercial.

## 7. Saídas do módulo
- Cadastro de colaborador
- Agenda padrão do colaborador
- Vínculos de qualificação por produto/serviço
- Documentos do colaborador

## 8. Tabelas e entidades envolvidas
- `colaboradores`
- `agenda_colaborador_padrao`
- `agenda_colaborador_pausa`
- `colaboradores_produtos_servicos`
- `documentos`
- `turnos`
- `dias_semana`
- `contratos_itens`
- `processos_etapas`

## 9. Dependências com outros módulos
- Produtos/serviços
- Documentos
- Contratos
- Processos

## 10. Pontos confirmados no código
- O cadastro e a agenda técnica existem no backend.
- Há vínculo entre colaborador e produtos/serviços.
- A agenda do colaborador considera dias da semana e turnos.

## 11. Pontos duvidosos ou incompletos
- As views principais do módulo não estão no workspace.
- O ponto de entrada real para o usuário final não foi confirmado.
- Não ficou claro se o módulo ainda está ativo ou se foi parcialmente descontinuado.

## 12. O que precisa ser validado manualmente
- Se o módulo aparece no ambiente rodando.
- Se as telas faltantes estão em outro repositório, build ou pasta não versionada.
- Qual o fluxo real entre agenda de colaborador, contrato e processo.

## 13. Nível de confiança da análise
baixo
