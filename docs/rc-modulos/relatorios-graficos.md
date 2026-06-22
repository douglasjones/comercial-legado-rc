# Relatórios e gráficos

## 1. Objetivo aparente
Consolidar consultas operacionais e comerciais por filtros e disponibilizar gráficos de apoio a dashboards.

## 2. Pontos de acesso
- Menu: `Relatórios`
- Submenus confirmados
  - Agendamento
  - Ocorrência
  - Carteira
  - Funil de Vendas
- Telas
  - `view/rel_agendamento_pesq.php`
  - `view/rel_agendamento_res.php`
  - `view/rel_ocorrencia_pesq.php`
  - `view/rel_ocorrencia_res.php`
  - `view/rel_carteira_pesq.php`
  - `view/rel_carteira_res.php`
  - `view/rel_funil_vendas_pesq.php`
  - `view/rel_funil_vendas_res.php`

## 3. Arquivos principais envolvidos
- Views / JS dos relatórios acima
- Controllers gráficos
  - `controller/grafico_agendamento_controller.php`
  - `controller/grafico_funil_vendas_controller.php`
  - `controller/grafico_carteira_lead.controller.php`
  - `controller/grafico_oportunidade_futura*.php`
  - `controller/grafico_rel_agendamento_controller.php`
  - `controller/grafico_rel_agendado_por_controller.php`
  - `controller/grafico_produtividade.controller.php`
  - `controller/grafico_retorno_pendente.controller.php`
- DAOs consumidos
  - agenda
  - ocorrência
  - lead
  - processo
  - proposta

## 4. Fluxo identificado no código
1. O usuário acessa a tela de pesquisa do relatório.
2. Preenche filtros.
3. O JS envia para a tela de resultado correspondente com `sendPost`.
4. Os resultados montam grids.
5. Em dashboards e relatórios, gráficos adicionais são carregados por controllers `grafico_*`.

## 5. Entradas do módulo
- Relatório de agendamento
  - polo
  - perfil
  - responsável
  - razão social
  - tipo de agendamento
  - status produtivo/improdutivo/reagendado
  - intervalo de data agendada
  - intervalo de data de visita
  - mailing
- Relatório de funil
  - polo
  - perfil
  - responsável
  - lead
  - data de envio
  - previsão de fechamento
  - data de fechamento
- Há telas equivalentes para ocorrência e carteira.

## 6. Regras e processamentos identificados
- O gráfico de agendamento agrega últimos 3 meses por classificação:
  - sem classificação
  - produtivo
  - improdutivo
  - reagendado
  - cancelado
- O gráfico de funil lê quantidade por classificação de processo.
- Os relatórios reutilizam filtros por polo, grupo, usuário, mailing e lead.

## 7. Saídas do módulo
- Grids de resultados por relatório
- Séries para gráficos
- Indicadores usados também em dashboards

## 8. Tabelas e entidades envolvidas
- `agendas`
- `ocorrencias`
- `retornos`
- `leads`
- `processos`
- `propostas`
- `usuarios`
- `equipes`
- `mailing`
- `polos`

## 9. Dependências com outros módulos
- Dashboards
- Leads
- Agenda
- Processos / propostas
- Ocorrências / retornos

## 10. Pontos confirmados no código
- Existem telas de pesquisa e resultado separadas para os relatórios principais.
- Os gráficos são servidos por controllers dedicados.
- O gráfico de agendamento trabalha com classificação da agenda.

## 11. Pontos duvidosos ou incompletos
- Não foi lida cada consulta SQL dos relatórios em profundidade.
- Não foi confirmado se existe exportação para arquivo em todas as telas.

## 12. O que precisa ser validado manualmente
- Se os relatórios têm paginação/exportação.
- Se os filtros por responsável/equipe respeitam corretamente as permissões do usuário.
- Se os gráficos dos relatórios e dos dashboards usam exatamente a mesma base.

## 13. Nível de confiança da análise
médio
