<?php
session_start();
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os campos foram preenchidos
    if (!empty($_POST['email']) && !empty($_POST['senha'])) {
        $email = trim($_POST['email']);
        $senha = trim($_POST['senha']);

        // Consulta preparada para evitar SQL Injection
        $sql = "SELECT id, nome, email, senha FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Obtém os dados do usuário
                $usuario = $result->fetch_assoc();

                // Verifica se a senha está correta
                if (password_verify($senha, $usuario['senha'])) {
                    // Armazena os dados do usuário na sessão
                    $_SESSION['id'] = $usuario['id'];
                    $_SESSION['nome'] = $usuario['nome'];
                    $_SESSION['email'] = $usuario['email'];

                    // Redireciona para a página principal
                    echo "Login bem-sucedido para: " . $usuario['nome'];
                    exit();

                } else {
                    // Senha incorreta
                    echo "<script>alert('Senha incorreta.');</script>";
                    echo "<script>window.history.back();</script>";
                }
            } else {
                // Usuário não encontrado
                echo "<script>alert('Usuário não encontrado.');</script>";
                echo "<script>window.history.back();</script>";
            }

            $stmt->close();
        } else {
            echo "Erro na consulta ao banco de dados: " . $conn->error;
        }
    } else {
        echo "<script>alert('Preencha todos os campos!');</script>";
        echo "<script>window.history.back();</script>";
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>




