<?php
require 'db.php'; 

// Verifica se o ID da tarefa foi passado na URL
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID da tarefa não fornecido.";
    exit;
}

try {
    // Verifica se a tarefa existe antes de excluirr
    $query = $conn->prepare("SELECT * FROM tarefas WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $tarefa = $query->fetch(PDO::FETCH_ASSOC);

    if (!$tarefa) {
        echo "Tarefa não encontrada.";
        exit;
    }

    // Exclui a tarefa pelo ID
    $delete = $conn->prepare("DELETE FROM tarefas WHERE id = :id");
    $delete->bindParam(':id', $id, PDO::PARAM_INT);
    $delete->execute();

    header("Location: index.php"); // Redireciona após exclusão
    exit;
} catch (PDOException $e) {
    echo "Erro ao excluir tarefa: " . $e->getMessage();
}
?>
