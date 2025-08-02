<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "prototipotcclogin";
$port = 3306;

// Aqui a variável $conn recebe a conexão:
$conn = mysqli_connect($host, $user, $pass, $db, $port);

// Verificação (opcional)
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}
?>
