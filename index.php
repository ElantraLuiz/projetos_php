<?php 
require 'db.php';
$tarefas = []; 
try {
    // Consulta para obter todas as tarefas
    $query = $conn->query("SELECT * FROM tarefas ORDER BY criado_em DESC");
    $tarefas = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar tarefas: " . $e->getMessage();
    $tarefas = []; // Inicializa como array vazio para evitar b.o no foreach
}


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <h1>Gerenciador de Tarefas</h1>
    <a href="create.php">Adicionar Nova Tarefa</a>
    <ul>
        <?php if (!empty($tarefas)): ?>
            <?php foreach ($tarefas as $tarefa): ?>
                <li>
                    <strong><?php echo htmlspecialchars($tarefa['titulo']); ?></strong><br>
                    <p><?php echo htmlspecialchars($tarefa['descricao']); ?></p>
                    <a href="edit.php?id=<?php echo $tarefa['id']; ?>">Editar</a> |
                    <a href="delete.php?id=<?php echo $tarefa['id']; ?>">Excluir</a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Sem tarefas cadastradas no momento.</li>
        <?php endif; ?>
    </ul>
</body>
</html>
