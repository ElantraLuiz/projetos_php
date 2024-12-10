<?php 

require 'db.php'; //conectar com o mysql

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    if (empty($titulo)) {
        echo "O título é obrigatório!";
    } else {
        $query = $conn->prepare("INSERT INTO tarefas (titulo, descricao) VALUES (:titulo, :descricao)");
        $query->bindParam(':titulo', $titulo);
        $query->bindParam(':descricao', $descricao);

        if ($query->execute()) {
            header("Location: index.php");
            exit;
        } else {
            echo "Erro ao adicionar tarefa.";
}}}

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Tarefa</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <h1>Adicionar Nova Tarefa</h1>
    <form method="POST" action="">
        <label for="titulo">Título:</label><br>
        <input type="text" id="titulo" name="titulo" required><br><br>

        <label for="descricao">Descrição:</label><br>
        <textarea id="descricao" name="descricao"></textarea><br><br>

        <button type="submit">Salvar</button>
    </form>
    <a href="index.php">Voltar para a lista de tarefas</a>
</body>
</html>





