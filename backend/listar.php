<?php
// Configurações de cabeçalho para permitir a comunicação (CORS) e definir o retorno em JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET'); 

// Inclui o arquivo de conexão
require_once 'conexao.php';

try {
    // Prepara a query para buscar todos os clientes, ordenando pelos mais recentes
    $query = "SELECT * FROM clientes ORDER BY id DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Pega todos os resultados e guarda em um array
    $clientes = $stmt->fetchAll();

    // Retorna os dados em formato JSON
    http_response_code(200);
    echo json_encode($clientes);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["erro" => "Erro ao buscar clientes: " . $e->getMessage()]);
}
?>