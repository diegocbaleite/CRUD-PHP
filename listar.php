<?php
include 'config.php';

// Executa a consulta SQL para buscar todos os usuários
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Usuários</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Listar Usuários</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Data de Cadastro</th>
                <th>Ações</th>
            </tr>
            <?php
            // Verifica se a consulta retornou resultados
            if ($result && $result->num_rows > 0) {
                // Itera sobre os resultados e exibe os dados na tabela
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['criado_em']}</td>
                        <td>
                            <a href='atualizar.php?id={$row['id']}'>Editar</a> |
                            <a href='deletar.php?id={$row['id']}' onclick=\"return confirm('Tem certeza que deseja apagar este registro?');\">Apagar</a>
                        </td>
                    </tr>";
                }
            } else {
                // Exibe uma mensagem se não houver registros
                echo "<tr><td colspan='5'>Nenhum registro encontrado</td></tr>";
            }
            // Fecha a conexão com o banco de dados
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
