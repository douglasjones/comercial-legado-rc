# Leads

## 1. Objetivo aparente
Cadastrar, pesquisar, classificar e centralizar o histórico operacional e comercial de cada lead.

## 2. Pontos de acesso
- Menu principal: `Leads`
- Pesquisa global no header: botão `Pesquisar`
- Telas
  - `view/lead_res_form.php`
  - `view/lead_cad_form.php`
  - `view/lead_main_form.php`
  - `view/pesquisar_lead_res.php`
- Ações relevantes
  - incluir
  - editar
  - excluir
  - abrir painel principal do lead

## 3. Arquivos principais envolvidos
- Controller principal
  - `controller/lead.controller.php`
- Controllers relacionados
  - `controller/telefone.controller.php`
  - `controller/endereco.controller.php`
  - `controller/contato.controller.php`
  - `controller/lead_operador.controller.php`
  - `controller/lead_responsavel.controller.php`
  - `controller/documento.controller.php`
- DAOs
  - `model/lead.dao.php`
  - DAOs acima
- Views / includes
  - `view/lead_res_form.php`
  - `view/lead_cad_form.php`
  - `view/lead_main_form.php`
  - `view/inc_telefone_*`
  - `view/inc_endereco_*`
  - `view/inc_contato_*`
  - `view/inc_lead_operador_*`
  - `view/inc_responsavel_lead_*`
- Scripts JS
  - `view/lead_res_form.js`
  - `view/lead_cad_form.js`
  - `view/lead_main_form.js`
  - `view/pesquisar_lead_res.js`

## 4. Fluxo identificado no código
1. O usuário pesquisa leads em `lead_res_form.php`.
2. Os filtros incluem polo, tipo de pessoa, lead, razão social, CPF/CNPJ, mailing, perfil, responsável, cidade, status de cliente, status comercial, operador e classificação da operadora.
3. Em `fcIncluir`, abre `lead_cad_form.php`.
4. O cadastro do lead é segmentado em abas:
   - dados cadastrais
   - telefones
   - endereços
   - contatos
   - operadoras atuais
   - responsáveis
5. Ao salvar, `controller/lead.controller.php` grava o lead e também persiste arrays JSON de contatos, responsáveis, endereços, telefones e operadoras.
6. Ao abrir um lead já existente, o sistema pode ir para:
   - tela de edição (`lead_cad_form.php`)
   - painel principal (`lead_main_form.php`)
7. `lead_main_form.php` funciona como hub do lead:
   - mostra dados consolidados
   - gerencia responsáveis
   - gerencia processos
   - gerencia documentos
   - abre módulos de proposta e contrato por etapa/processo

## 5. Entradas do módulo
- Campos de cadastro
  - `polos_pk`
  - `ds_lead`
  - `tipo_pessoa_pk`
  - `ds_razao_social`
  - `ds_cpf_cnpj`
  - `ds_ie`
  - `ds_rg`
  - `ds_cnae`
  - `ds_site`
  - `mailing_pk`
  - `ic_cliente`
  - `ciclo_uso`
  - `ds_log`
  - `ds_obs`
- Subgrids / subformulários
  - telefones
  - endereços
  - contatos
  - operadoras atuais
  - responsáveis
- Uploads
  - documentos do lead

## 6. Regras e processamentos identificados
- `ds_cpf_cnpj` é obrigatório no backend do controller.
- O lead pertence à conta do usuário logado (`contas_pk` vem do token).
- Exclusão de lead remove em cascata:
  - endereços
  - responsáveis
  - contatos
  - telefones
  - retornos ligados a ocorrências do lead
  - ocorrências
  - processos
  - documentos
  - agendas
  - propostas
- O DAO calcula status comercial aparente a partir de:
  - ocorrências com “Sem Interesse”
  - existência de processo
  - classificação do processo
- A listagem de leads respeita permissões como `acessar_todos_lead`.
- O painel do lead expõe botões condicionados por permissão para responsável, processo e documento.

## 7. Saídas do módulo
- Grid de leads filtrados
- Cadastro ou atualização de lead
- Painel consolidado do lead
- Documentos anexados
- Responsáveis vinculados
- Operadoras atuais vinculadas

## 8. Tabelas e entidades envolvidas
- `leads`
- `telefones`
- `enderecos`
- `contatos`
- `leads_operadoras`
- `leads_responsaveis`
- `documentos`
- `mailing`
- `polos`
- `usuarios`

Relacionamento aparente:
- lead pertence a conta e polo
- lead pode ter múltiplos telefones, endereços, contatos e operadoras
- lead pode ter múltiplos responsáveis

## 9. Dependências com outros módulos
- Agenda de visitas
- Agenda de retorno / ocorrências
- Processos / propostas / contratos
- Mailing
- Usuários / grupos
- Operadores

## 10. Pontos confirmados no código
- O painel do lead é o principal hub operacional do CRM.
- Há pesquisa global de lead no header.
- O cadastro salva múltiplas estruturas filhas em JSON.
- O backend impede salvar lead sem CPF/CNPJ.
- A exclusão de lead é ampla e remove diversos vínculos.

## 11. Pontos duvidosos ou incompletos
- A composição exata dos filtros de status comercial depende de consultas extensas do DAO não lidas integralmente.
- Não foi validado no código se há paginação server-side em todas as grids.

## 12. O que precisa ser validado manualmente
- Se todos os filtros da pesquisa retornam combinações coerentes.
- Se a exclusão realmente apaga todos os vínculos sem violar integridade em produção.
- Se o upload/renomeação/remoção de documentos funciona com o diretório configurado.
- Se o campo `ciclo_uso` e o campo `ds_log` são usados operacionalmente ou apenas armazenados.

## 13. Nível de confiança da análise
alto
