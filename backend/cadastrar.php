<?php
// Define que o retorno desta página será obrigatoriamente um JSON [cite: 90]
header('Content-Type: application/json');
// Permite que o Front-end (que pode estar em outra porta/servidor) acesse esta API (CORS)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Inclui o arquivo de conexão que criamos no passo anterior
require_once 'conexao.php';

// Recebe os dados enviados pelo Front-end
// Como o Front-end enviará em JSON, usamos essa função para ler os dados
$dados = json_decode(file_get_contents("php://input"), true);

// Verifica se os dados mínimos e obrigatórios (nome e email) foram enviados
if (isset($dados['nome']) && isset($dados['email'])) {
    
    // Guarda os dados em variáveis
    $nome = $dados['nome'];
    $email = $dados['email'];
    // Se o telefone não for enviado, salva como vazio
    $telefone = isset($dados['telefone']) ? $dados['telefone'] : '';

    try {
        // Prepara a query SQL para inserir o registro no banco
        $query = "INSERT INTO clientes (nome, email, telefone) VALUES (:nome, :email, :telefone)";
        $stmt = $pdo->prepare($query);

        // Substitui os parâmetros pelos valores reais (isso evita falhas de segurança como SQL Injection)
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);

        // Executa a query
        if ($stmt->execute()) {
            http_response_code(201); // Código HTTP 201 significa "Criado com sucesso"
            echo json_encode(["mensagem" => "Cliente cadastrado com sucesso!"]);
        } else {
            http_response_code(500); // Código HTTP 500 significa "Erro interno do servidor"
            echo json_encode(["erro" => "Erro ao cadastrar o cliente no banco de dados."]);
        }

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["erro" => "Erro no banco de dados: " . $e->getMessage()]);
    }

} else {
    http_response_code(400); // Código HTTP 400 significa "Requisição Inválida" (faltou dado)
    echo json_encode(["erro" => "Dados incompletos. Os campos 'nome' e 'email' são obrigatórios."]);
}
?>