<?php
include('conexao.php');

$rg = mysqli_real_escape_string($conn, trim($_GET['rg'] ?? ''));

if($rg === ''){
    echo json_encode([]);
    exit;
}

$sql = "SELECT RGSUSP, nomeP FROM pacientes WHERE RGSUSP LIKE '$rg%'";
$result = mysqli_query($conn, $sql);

$pacientes = [];
while($row = mysqli_fetch_assoc($result)){
    $pacientes[] = $row;
}

header('Content-Type: application/json');
echo json_encode($pacientes);
?>