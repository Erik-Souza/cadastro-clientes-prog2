# Sistema de Cadastro de Clientes

Este projeto é um Sistema Web Completo desenvolvido como Atividade Avaliativa para a disciplina de Programação II – 2026/01. O tema escolhido foi "Cadastro de clientes".

## ⚙️ Como Executar a Aplicação

### 1. Dependências Necessárias
* **Servidor Web / PHP:** XAMPP (ou qualquer outro ambiente que rode PHP 8+ localmente).
* **Banco de Dados:** MySQL (pode ser o serviço embutido no XAMPP ou autônomo).
* **Navegador Web:** Google Chrome, Microsoft Edge, Firefox, etc.

### 2. Configuração do Banco de Dados
1. Inicie o serviço do **MySQL** (por exemplo, clicando em "Start" no painel do XAMPP).
2. Acesse seu gerenciador de banco de dados preferido (como o MySQL Workbench).
3. Na pasta `database` deste repositório, localize o arquivo `script.sql`.
4. Copie e execute o código SQL deste arquivo no gerenciador para criar o banco de dados `cadastro_clientes` e a tabela `clientes`.

### 3. Como Executar o Back-end
O back-end foi desenvolvido em PHP puro utilizando a extensão PDO para comunicação com o banco de dados.
1. Abra o terminal do seu editor de código (como o VS Code) na pasta raiz do projeto.
2. Navegue até a pasta do back-end digitando: `cd backend`
3. Inicie o servidor embutido do PHP com o comando abaixo (ajuste o caminho de acordo com a instalação do seu XAMPP):
   ```bash
   C:\xampp\php\php.exe -S localhost:8000
   ```

### 4. Como Executar o Front-end
O front-end foi construído utilizando HTML5, CSS3 e JavaScript (Vanilla).
1. Mantenha o terminal do back-end rodando em segundo plano.
2. Pelo explorador de arquivos do seu sistema operacional, navegue até a pasta `frontend`.
3. Dê um duplo clique no arquivo `index.html` para abri-lo diretamente no seu navegador. 

### 5. URLs do Sistema
* **Front-end:** Acessado localmente via protocolo de arquivo (ex: `file:///C:/.../frontend/index.html`).
* **Back-end (API Base URL):** `http://localhost:8000`

---

## ✨ Principais Funcionalidades Implementadas

O sistema integra as camadas de front-end, back-end e banco de dados, implementando um CRUD completo:
* **Cadastro (Create):** Inserção de novos registros de clientes informando Nome, E-mail e Telefone.
* **Listagem Geral (Read All):** Exibição de todos os clientes cadastrados em uma tabela de interface amigável.
* **Atualização (Update):** Recuperação dos dados de um cliente específico no formulário para a edição de suas informações.
* **Exclusão (Delete):** Remoção de registros do banco de dados, protegida por um alerta de confirmação do usuário.

---

## 🔌 Endpoints Disponíveis

A API REST foi desenvolvida para receber e retornar informações obrigatoriamente no formato JSON.

### 1. Listar Clientes
* **Rota:** `/listar.php`
* **Método HTTP:** `GET`
* **Finalidade:** Recuperar a lista completa de clientes cadastrados, retornando os dados ordenados dos mais recentes para os mais antigos.
* **Exemplo de Requisição:** *(Não requer envio de corpo JSON).*

### 2. Cadastrar Cliente
* **Rota:** `/cadastrar.php`
* **Método HTTP:** `POST`
* **Finalidade:** Receber os dados do front-end e persistir um novo registro de cliente no banco de dados.
* **Exemplo de Requisição (JSON):**
  ```json
  {
    "nome": "Erik Souza Lopes",
    "email": "eriksouzalopes@gmail.com",
    "telefone": "35999665841"
  }
  ```

### 3. Atualizar Cliente
* **Rota:** `/editar.php`
* **Método HTTP:** `PUT`
* **Finalidade:** Atualizar as informações de um cliente já existente utilizando o seu ID como referência.
* **Exemplo de Requisição (JSON):**
  ```json
  {
    "id": 1,
    "nome": "Erik Souza Lopes",
    "email": "erik.novo@gmail.com",
    "telefone": "35000000000"
  }
  ```

### 4. Excluir Cliente
* **Rota:** `/deletar.php?id={id}`
* **Método HTTP:** `DELETE`
* **Finalidade:** Apagar definitivamente um registro de cliente do banco de dados a partir do ID enviado como parâmetro na própria URL.
* **Exemplo de Requisição:** `DELETE http://localhost:8000/deletar.php?id=1`