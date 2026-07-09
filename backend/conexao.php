<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'cadastro_clientes';
$username = 'root'; // Usuário padrão do XAMPP/MySQL
$password = ''; // Senha padrão do XAMPP geralmente é vazia (ou a que você configurou)

try {
    // Cria a conexão com o banco
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Configura o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Configura para que os dados retornem como um array associativo (ideal para JSON)
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Se der erro, retorna um JSON com a mensagem de erro
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        "erro" => "Falha na conexão com o banco de dados",
        "detalhes" => $e->getMessage()
    ]);
    exit;
}
?>