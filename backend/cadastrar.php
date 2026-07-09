<?php
// Configurações de cabeçalho para permitir a comunicação (CORS)
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
// Adicionamos o OPTIONS aqui nas permissões
header('Access-Control-Allow-Methods: POST, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type');

// Se for a requisição de "teste" (OPTIONS) do navegador, a gente aprova e encerra aqui
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Inclui o arquivo de conexão
require_once 'conexao.php';

// Recebe os dados enviados pelo Front-end
$dados = json_decode(file_get_contents("php://input"), true);

// Verifica se os dados mínimos e obrigatórios foram enviados
if (isset($dados['nome']) && isset($dados['email'])) {
    
    $nome = $dados['nome'];
    $email = $dados['email'];
    $telefone = isset($dados['telefone']) ? $dados['telefone'] : '';

    try {
        $query = "INSERT INTO clientes (nome, email, telefone) VALUES (:nome, :email, :telefone)";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);

        if ($stmt->execute()) {
            http_response_code(201); 
            echo json_encode(["mensagem" => "Cliente cadastrado com sucesso!"]);
        } else {
            http_response_code(500); 
            echo json_encode(["erro" => "Erro ao cadastrar o cliente no banco de dados."]);
        }

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["erro" => "Erro no banco de dados: " . $e->getMessage()]);
    }

} else {
    http_response_code(400); 
    echo json_encode(["erro" => "Dados incompletos. Os campos 'nome' e 'email' são obrigatórios."]);
}
?>