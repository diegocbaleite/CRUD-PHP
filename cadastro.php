<?php
include 'config.php';

$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";

    if ($conn->query($sql) === TRUE) {
        $success = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar usuários</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script type="text/javascript">
        function showSuccessMessageAndRedirect() {
            alert("Novo usuário cadastrado com sucesso!");
            window.location.href = 'index.php';
        }
    </script>
</head>
<body>
    <div class="form-container">
        <form method="post" action="">
            <h2>Cadastrar Usuários</h2>
            Nome: <input type="text" name="name" required><br>
            Email: <input type="email" name="email" required><br>
            <input type="submit" value="Cadastrar">
        </form>
    </div>
    
    <?php if ($success): ?>
        <script type="text/javascript">
            showSuccessMessageAndRedirect();
        </script>
    <?php endif; ?>
</body>
</html>
