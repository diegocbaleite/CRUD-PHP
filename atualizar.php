<?php
include 'config.php';

// Verificar se o ID foi fornecido e é válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido ou ausente");
}

$id = intval($_GET['id']);

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitizar e validar entradas
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    // Validar o email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Formato de email inválido";
    } else {
        $sql = "UPDATE usuarios SET name=?, email=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $name, $email, $id);

        if ($stmt->execute()) {
            echo "Registro atualizado com sucesso";
            header("Location: listar.php"); // Redirecionar após a atualização
            exit();
        } else {
            echo "Erro ao atualizar o registro: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Preparar e executar a consulta para obter o usuário
$sql = "SELECT * FROM usuarios WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar se o resultado da consulta é válido
if ($result === false || $result->num_rows === 0) {
    die("Nenhum registro encontrado");
}

$row = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Usuários</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1 class="update">Atualizar Usuários</h1>
    <form method="post" action="">
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
        </div>
        <input type="submit" value="Atualizar">
    </form>
</body>
</html>
