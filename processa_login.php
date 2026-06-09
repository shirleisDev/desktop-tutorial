<?php
// Inicia a sessão para manter o usuário logado no sistema
session_start();

// Importa o arquivo de conexão que criamos juntos
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados enviados pelo formulário
    $usuario_digitado = $_POST['usuario'] ?? '';
    $senha_digitada = $_POST['senha'] ?? '';

    if (!empty($usuario_digitado) && !empty($senha_digitada)) {
        
        // Busca o usuário usando o padrão MySQLi (da sua conexao.php) de forma segura contra invasões (Prepared Statements)
        $sql = "SELECT * FROM usuarios WHERE email = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("s", $usuario_digitado);
            $stmt->execute();
            
            // Pega o resultado do banco de dados
            $resultado = $stmt->get_result();
            $usuario_banco = $resultado->fetch_assoc();

            // Verifica se o usuário existe e se a senha criptografada bate
            if ($usuario_banco && password_verify($senha_digitada, $usuario_banco['senha'])) {
                $_SESSION['logado'] = true;
                $_SESSION['usuario'] = $usuario_banco['nome']; // Guarda o nome do operador
                
                // Login com sucesso: redireciona para a página principal
                header("Location: index.php");
                exit;
            } else {
                // Se errar a senha ou o e-mail, volta com o aviso de erro 1
                header("Location: index.php?erro=1");
                exit;
            }
        } else {
            die("Erro na preparação do banco de dados: " . $mysqli->error);
        }
    } else {
        // Se deixar campos vazios, volta com o erro 2
        header("Location: index.php?erro=2");
        exit;
    }
}
?>
