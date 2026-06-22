# Usuários / equipes / grupos / permissões

## 1. Objetivo aparente
Administrar usuários, vínculos com polos/equipes e autorização de acesso por módulo.

## 2. Pontos de acesso
- Menu: `Administração`
  - `Usuários`
  - `Equipes`
- Menu: `CPainel`
  - `Módulos do Sistema`
  - `Grupo de usuários`
- Telas
  - `view/usuario_res_form.php`
  - `view/usuario_cad_form.php`
  - `view/equipe_res_form.php`
  - `view/equipe_cad_form.php`
  - `view/grupo_res_form.php`
  - `view/grupo_cad_form.php`
  - `view/modulo_res_form.php`
  - `view/modulo_cad_form.php`

## 3. Arquivos principais envolvidos
- Controllers
  - `controller/usuario.controller.php`
  - `controller/usuario_polo.controller.php`
  - `controller/equipe.controller.php`
  - `controller/grupo.controller.php`
  - `controller/modulo.controller.php`
- DAOs
  - `model/usuario.dao.php`
  - `model/usuario_polo.dao.php`
  - `model/equipe.dao.php`
  - `model/grupo.dao.php`
  - `model/modulo.dao.php`
- Views / JS
  - telas correspondentes acima

## 4. Fluxo identificado no código
1. O usuário lista registros em grids.
2. Na edição de usuário, pode informar grupo, conta e polos vinculados.
3. O save de usuário grava o usuário e depois grava `usuarios_polos`.
4. Grupos podem receber permissões por módulo com flags:
   - inserir
   - atualizar
   - excluir
   - consultar
5. Módulos têm nome e domínio (`ds_dominio`) usado nas verificações `permissao(...)`.
6. Equipes também são consultadas por outros módulos para filtros e atribuições.

## 5. Entradas do módulo
- Usuário
  - nome
  - login
  - senha
  - email
  - celular
  - status
  - grupo
  - conta
  - polos
- Grupo
  - nome
  - polo
  - lista de módulos com `ic_ins`, `ic_upd`, `ic_del`, `ic_cons`
- Módulo
  - nome
  - domínio
  - polo
- Equipe
  - nome e vínculos com usuários

## 6. Regras e processamentos identificados
- Usuário só autentica se estiver ativo e a conta estiver ativa.
- A senha é armazenada em bcrypt quando salva ou ao migrar login legado.
- Os filtros de usuário respeitam permissões específicas, como listar todos, listar grupos ou equipes.
- `permissao(...)` depende de `ds_dominio` do módulo e tipo de ação.
- Vários módulos consomem listas de usuário por grupo, equipe ou retorno.

## 7. Saídas do módulo
- Usuários cadastrados
- Polos vinculados ao usuário
- Equipes
- Grupos e permissões
- Domínios de módulos

## 8. Tabelas e entidades envolvidas
- `usuarios`
- `usuarios_polos`
- `equipes`
- `equipes_usuarios`
- `grupos`
- `modulos`
- `modulos_grupos`
- `polos`

## 9. Dependências com outros módulos
- Login e navegação
- Leads
- Agenda
- Dashboards
- Transferência de leads
- Relatórios

## 10. Pontos confirmados no código
- O sistema usa RBAC simplificado por grupo x módulo x ação.
- Usuário pode pertencer a múltiplos polos.
- Usuário pode ser consultado por grupo e por equipe para compor filtros.

## 11. Pontos duvidosos ou incompletos
- A modelagem completa das equipes não foi lida ponta a ponta.
- Não ficou totalmente claro se há restrição de um usuário para uma única equipe operacional principal.

## 12. O que precisa ser validado manualmente
- Se a UI impede permissões inconsistentes por grupo.
- Se um usuário com múltiplos polos consegue alternar contexto ou recebe apenas um `polos_pk` efetivo na sessão.
- Como a equipe interfere no escopo real das consultas em cada módulo.

## 13. Nível de confiança da análise
alto
