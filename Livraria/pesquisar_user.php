<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <title>Pesquisa de Usuário</title>
</head>
<body>
<h1>Pesquisa  de Usuário</h1>

<div>
<?php // Abertura do PHP


include("conexao.php");




//Iserindo dados

  
$nome = $_POST['nome']; 

$resultado = "SELECT * FROM usuarios WHERE nome LIKE '%$nome%' LIMIT 5";
$busca=mysqli_query($conn,$resultado);

while($linhas = mysqli_fetch_array($busca) ){
   // echo"<table>";
    echo"<h2> ID: </h2>".$linhas['ID']."";       
    echo"<h2>nome:</h2>".$linhas['nome']."";
    echo"<h2> Email: </h2>".$linhas['email'].""; 
    echo"<br>";
    echo"<a href='admin.html'><font color='blue'>Excluir</font></a>  ";
    echo"<a href='admin.html'><font color='blue'>Retornar</font></a>  ";
    echo"<hr>";
    //echo"</table>";        
}

?>

</div>
</body>
</html>
