<?php
include 'db.php';

// Verificar se o ID foi fornecido e é válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid or missing ID");
}

$id = intval($_GET['id']);

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitizar e validar entradas
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        die("Invalid email format");
    }

    $sql = "UPDATE users SET name=?, email=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $name, $email, $id);

    if ($stmt->execute()) {
        echo "Record updated successfully";
        $stmt->close();
        $conn->close();
        header("Location: listar.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Preparar e executar a consulta para obter o usuário
$sql = "SELECT * FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar se o resultado da consulta é válido
if ($result === false || $result->num_rows === 0) {
    die("No records found");
}

$row = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Atualizar usuários</title>
</head>
<body>
    <h1>Atualizar usuários</h1>
    <form method="post" action="">
        Nome: <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required><br>
        Email: <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required><br>
        <input type="submit" value="Atualizar">
    </form>
</body>
</html>
