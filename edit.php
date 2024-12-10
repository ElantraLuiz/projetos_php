<?php
require 'db.php'; // Inclui a conexão com o banco de dados.

// Verifica se o ID da tarefa foi passado pela URL.
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID da tarefa não fornecido.";
    exit;
}

// Busca os dados da tarefa pelo ID.
try {
    $query = $conn->prepare("SELECT * FROM tarefas WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $tarefa = $query->fetch(PDO::FETCH_ASSOC);

    if (!$tarefa) {
        echo "Tarefa não encontrada.";
        exit;
    }
} catch (PDOException $e) {
    echo "Erro ao buscar tarefa: " . $e->getMessage();
    exit;
}

// Processa o formulário de edição.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    if (empty($titulo)) {
        echo "O título é obrigatório!";
    } else {
        try {
            $update = $conn->prepare("UPDATE tarefas SET titulo = :titulo, descricao = :descricao WHERE id = :id");
            $update->bindParam(':titulo', $titulo);
            $update->bindParam(':descricao', $descricao);
            $update->bindParam(':id', $id, PDO::PARAM_INT);
            $update->execute();

            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            echo "Erro ao atualizar tarefa: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarefa</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <h1>Editar Tarefa</h1>
    <form method="POST" action="">
        <label for="titulo">Título:</label><br>
        <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($tarefa['titulo']); ?>" required><br><br>

        <label for="descricao">Descrição:</label><br>
        <textarea id="descricao" name="descricao"><?php echo htmlspecialchars($tarefa['descricao']); ?></textarea><br><br>

        <button type="submit">Atualizar</button>
    </form>
    <a href="index.php">Voltar para a lista de tarefas</a>
</body>
</html>
