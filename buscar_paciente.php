<?php
include('conexao.php');

$cpf = mysqli_real_escape_string($conn, trim($_GET['cpf'] ?? ''));

if($cpf === ''){
    echo json_encode([]);
    exit;
}

$sql = "SELECT CPFP, nomeP FROM pacientes WHERE CPFP LIKE '$cpf%'";
$result = mysqli_query($conn, $sql);

$pacientes = [];
while($row = mysqli_fetch_assoc($result)){
    $pacientes[] = $row;
}

header('Content-Type: application/json');
echo json_encode($pacientes);
?>