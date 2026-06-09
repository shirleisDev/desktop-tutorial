<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "galactic_games";

// Criando a conexão com o MySQL através do XAMPP
$mysqli = new mysqli($host, $usuario, $senha, $banco);

// Testando se houve erro de conexão
if ($mysqli->connect_error) {
    die("Falha ao conectar ao banco de dados: " . $mysqli->connect_error);
}

// Garante que o PHP traga as informações com acentuação correta
$mysqli->set_charset("utf8mb4");
?>
