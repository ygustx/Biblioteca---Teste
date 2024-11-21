<?php
include("conexao.php");

// Diagnóstico: Verifica se $_POST está sendo recebido corretamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "Dados recebidos via POST:<br>";
    var_dump($_POST);

    // Captura o ID do POST, garantindo a limpeza de dados
    $id = isset($_POST['id']) ? trim($_POST['id']) : null;

    if ($id !== null && $id !== '') {
        // Dados do banco de dados
        $servidor = "localhost";
        $usuario = "root";
        $senha = "";
        $dbname = "projeto";

        // Criar a conexão
        $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

        // Verifica a conexão com o banco de dados
        if (!$conn) {
            die("Falha na conexão: " . mysqli_connect_error());
        }

        // Exibe o banco conectado
        $db_check = mysqli_query($conn, "SELECT DATABASE()");
        $db_name = mysqli_fetch_row($db_check);
        echo "Banco de dados conectado: " . $db_name[0] . "<br>";

        // Depuração: Exibe o ID recebido
        echo "ID recebido: " . htmlspecialchars($id) . "<br>";

        // Executa a consulta
        $stmt = mysqli_prepare($conn, "DELETE FROM usuarios WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            // Verifica se o registro foi excluído
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "<h1>Usuário excluído com sucesso!</h1>";
            } else {
                echo "<h1>Nenhum usuário encontrado com o ID fornecido.</h1>";
            }
        } else {
            echo "Erro ao executar a consulta: " . mysqli_error($conn);
        }

        // Fecha a conexão e o statement
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo "<h1>ID não fornecido ou inválido.</h1>";
    }
} else {
    echo "<h1>Nenhum dado enviado via POST.</h1>";
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <title>Alteração de Usuário</title>
</head>
<body>
    <h1>Usuário Excluído!</h1>
    <br>
    <h2>Você será redirecionado para a tela do admin</h2>
</body>
</html>