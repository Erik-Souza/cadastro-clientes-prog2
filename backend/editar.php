<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once 'conexao.php';

$dados = json_decode(file_get_contents("php://input"), true);

// Na edição, o ID também é obrigatório para sabermos quem atualizar
if (isset($dados['id']) && isset($dados['nome']) && isset($dados['email'])) {
    
    $id = $dados['id'];
    $nome = $dados['nome'];
    $email = $dados['email'];
    $telefone = isset($dados['telefone']) ? $dados['telefone'] : '';

    try {
        $query = "UPDATE clientes SET nome = :nome, email = :email, telefone = :telefone WHERE id = :id";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);

        if ($stmt->execute()) {
            http_response_code(200); 
            echo json_encode(["mensagem" => "Cliente atualizado com sucesso!"]);
        } else {
            http_response_code(500); 
            echo json_encode(["erro" => "Erro ao atualizar o cliente."]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["erro" => "Erro no banco de dados: " . $e->getMessage()]);
    }
} else {
    http_response_code(400); 
    echo json_encode(["erro" => "Dados incompletos. ID, nome e email são obrigatórios."]);
}
?>