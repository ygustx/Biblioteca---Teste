<?php
// Inclui a conexão com o banco de dados
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se todos os campos estão preenchidos
    if (!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
        // Filtra e escapa os dados
        $nome = $conn->real_escape_string(trim($_POST['nome']));
        $email = $conn->real_escape_string(trim($_POST['email']));
        $senha_hashed = password_hash(trim($_POST['senha']), PASSWORD_DEFAULT);

        // Prepara a consulta
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param("sss", $nome, $email, $senha_hashed);

        // Executa a consulta e verifica se foi bem-sucedida
        if ($stmt->execute()) {
            echo "Usuário cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }

        // Fecha a declaração
        $stmt->close();
    } else {
        echo "Todos os campos são obrigatórios!";
    }
} else {
    echo "Método inválido.";
}

// Fecha a conexão com o banco
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" 
    content="3;http://localhost/livraria/Livraria.html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <title>Confirmação de Cadastro</title>
</head>    

<body>
    <h1>Usuário Cadastrado!</h1>
    <br>
    <h2>Você será redirecionado para a tela principal</h2>
</body>
</html>