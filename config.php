<?php
$servername = "localhost";
$username = "root"; // Altere conforme necessário
$password = "1234"; // Altere conforme necessário
$dbname = "exemplo_crud";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
