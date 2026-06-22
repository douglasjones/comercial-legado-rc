# Login / autenticação / navegação

## 1. Objetivo aparente
Autenticar o usuário, manter sessão ativa, validar permissões por módulo e direcionar para o dashboard compatível com o grupo do usuário.

## 2. Pontos de acesso
- URL inicial: `index.php`
- Tela: `view/login_form.php`
- Ação AJAX: `controller/usuario.controller.php` com `job=autenticarUsuario`
- Pós-login: `view/principal.php`
- Navegação global: `inc/php/header.php`
- Saída: `view/logoff.php`

## 3. Arquivos principais envolvidos
- Controllers
  - `controller/usuario.controller.php`
  - `controller/retorno.controller.php`
- Models / DAOs
  - `model/usuario.dao.php`
- Views / páginas
  - `view/login_form.php`
  - `view/principal.php`
  - `view/logoff.php`
- Scripts JS
  - `view/login_form.js`
  - `inc/js/bestflow/bestflow.js`
- Includes / helpers
  - `inc/php/header.php`
  - `inc/php/public.php`

## 4. Fluxo identificado no código
1. `index.php` redireciona o browser para `view/login_form.php`.
2. O usuário informa login e senha.
3. `view/login_form.js` valida campos vazios no frontend.
4. O JS envia `job=autenticarUsuario` para `controller/usuario.controller.php`.
5. O controller consulta `model/usuario.dao.php::listarLogin`.
6. `listarLogin` busca o usuário ativo, conta ativa e verifica senha:
   - usa `password_verify` se a senha já estiver em hash
   - aceita senha em texto puro legado e, nesse caso, migra para hash bcrypt
7. Em sucesso, o controller grava `$_SESSION['auth']`, define `$_SESSION['auth_exp']` e retorna `session_id()` como token.
8. `view/login_form.js` consulta se existem retornos pendentes.
9. Se existir retorno pendente, abre `view/retorno_popup.php`.
10. O sistema envia para `view/principal.php`.
11. `view/principal.php` escolhe qual dashboard abrir com base em `grupos_pk`.
12. `inc/php/header.php` monta o menu visível com chamadas `permissao(...)`.

## 5. Entradas do módulo
- Formulário de login
  - `ds_login`
  - `ds_senha`
- Troca de senha
  - `ds_login`
  - `ds_nova_senha`
  - `ds_cofirmar_senha`
- Token de sessão

## 6. Regras e processamentos identificados
- Frontend bloqueia envio se login/senha estiverem vazios.
- Senha padrão textual `gepros` leva para `view/nova_senha.php`.
- Sessão expira em 10 horas.
- `inc/php/public.php::verificarLogin` redireciona ao `index.php` se não houver sessão válida.
- Permissões são avaliadas por domínio de módulo e ação (`ins`, `upd`, `del`, `cons`).
- O header faz uma verificação periódica de retornos pendentes e pode abrir popup.
- O header também consulta o status da conta e redireciona para o `index.php` se `ic_status == 2`.

## 7. Saídas do módulo
- Token de sessão
- Dashboard inicial conforme grupo
- Menu filtrado por permissão
- Popup de retorno pendente

## 8. Tabelas e entidades envolvidas
- `usuarios`
- `grupos`
- `equipes_usuarios`
- `usuarios_polos`
- `contas`
- `modulos`
- `modulos_grupos`

Relação aparente:
- usuário pertence a conta e grupo
- usuário pode estar ligado a equipe e polo
- permissões são resolvidas por grupo x módulo

## 9. Dependências com outros módulos
- Dashboards
- Retornos
- Conta
- Pesquisa global de leads
- Todos os módulos protegidos por `verificarLogin` e `permissao`

## 10. Pontos confirmados no código
- O token retornado no login é o `session_id()`.
- O login usa sessão PHP em vez de JWT.
- Há migração gradual de senha em texto puro para bcrypt.
- O dashboard inicial depende de `grupos_pk`.
- O menu principal é controlado por `permissao(...)`.

## 11. Pontos duvidosos ou incompletos
- O uso do parâmetro `token` é parcialmente simbólico, porque `tratarToken` lê `$_SESSION['auth']`.
- Não ficou totalmente claro se há múltiplos fluxos de logoff além de `view/logoff.php`.

## 12. O que precisa ser validado manualmente
- Se todos os grupos mapeados no banco realmente caem no dashboard esperado.
- Se a troca de senha obrigatória após senha padrão ainda está ativa em produção.
- Se a verificação de conta inativa realmente encerra a sessão ou só redireciona.
- Se o popup de retorno pode abrir mais de uma vez na mesma sessão.

## 13. Nível de confiança da análise
alto
