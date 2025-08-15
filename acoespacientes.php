<?php 
include('conexao.php');

if(!isset($_POST['cadastrar_paciente'])){
    $RGSUSP = $_POST['RGSUSP'];
    $nomeP = $_POST['nomeP'];
    $datanascP = $_POST['datanascP'];
    $idadeP = $_POST['idadeP'];
    $telefoneP = $_POST['telefoneP'];
    $sexoP = $_POST['sexoP'];
    $enderecoP = $_POST['enderecoP'];
    $munResP = $_POST['munResP'];
    $UFP = $_POST['UFP'];

//ta dando erro, não ta enviando os dados
//ARRUMAR ISSO LOGO
    $sql = "INSERT INTO pacientes(RGSUSP, nomeP, datanascP, idadeP, telefoneP, sexoP, enderecoP, munResP, UFP) VALUES ('$RGSUSP','$nomeP','$datanascP','$idadeP','$telefoneP','$sexoP','$enderecoP','$munResP','$UFP')";
    $res = $conn->query($sql);

    if($res==true){
        echo "<script>alert('Cadastro realizado com sucesso!!'); location.href='restrita_recepcao.php'; </script>";
    } else {
        echo "<script>alert('Não foi possível cadastrar!!'); history.back(-1);</script>";
    }
} else{
    echo 'aaaaaaaaa erroooo';
}

?>