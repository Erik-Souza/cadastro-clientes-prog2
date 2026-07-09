<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once 'conexao.php';

// Pega o ID que será passado pela URL (ex: deletar.php?id=1)
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    try {
        $query = "DELETE FROM clientes WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            http_response_code(200); 
            echo json_encode(["mensagem" => "Cliente excluído com sucesso!"]);
        } else {
            http_response_code(500); 
            echo json_encode(["erro" => "Erro ao excluir o cliente."]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["erro" => "Erro no banco de dados: " . $e->getMessage()]);
    }
} else {
    http_response_code(400); 
    echo json_encode(["erro" => "ID do cliente não fornecido."]);
}
?>