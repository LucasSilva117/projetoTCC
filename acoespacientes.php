<?php 
include('conexao.php');

if(isset($_POST['cadastrar_paciente'])){
    $RG = $_POST['RGSUSP'] ?? null;
    $nome = $_POST['nomeP'] ?? null;;
    $datanasc = $_POST['datanascP'] ?? null;;
    $idade = $_POST['idadeP'] ?? null;;
    $telefone = $_POST['telefoneP'] ?? null;;
    $sexo = $_POST['sexoP'] ?? null;;
    $endereco = $_POST['enderecoP'] ?? null;;
    $munRes = $_POST['munResP'] ?? null;;
    $UF = $_POST['UFP'] ?? null;;


    $sql = "INSERT INTO pacientes(RGSUSP, nomeP, datanascP, idadeP, telefoneP, sexoP, enderecoP, munResP, UFP) VALUES ('$RG','$nome','$datanasc','$idade','$telefone','$sexo','$endereco','$munRes','$UF')";
    mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn) > 0){
        echo "<script>alert('Cadastro realizado com sucesso!!'); location.href='restrita_recepcao.php'; </script>";
    } else {
        $erro = mysqli_errno($conn);

        if ($erro == 1062) {
            // Erro de duplicidade
            echo "<script>alert('Erro: Já existe um paciente com esse RG/SUS!'); history.back();</script>";
        } else {
            // Outro erro qualquer
            echo "Erro no banco: " . mysqli_error($conn);
        }
    }
} 

if(isset($_POST['excluir_paciente'])){
    $paciente_id = mysqli_real_escape_string($conn, $_POST['excluir_paciente']);
    $sql = "DELETE FROM pacientes WHERE id = '$paciente_id'";
    mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn) > 0){
        echo "<script>alert('Paciente excluido com sucesso!!');location.href='lista_pacientes.php';</script>";
    } else {
        echo "<script>alert('Não foi possivel excluir esse paciente!!');location.href='lista_pacientes.php';</script>";
    }
}   

if(isset($_POST['editar_paciente'])){
    $paciente_id =mysqli_real_escape_string($conn, $_POST['id']);

    $RG = $_POST['RGSUSP'] ?? null;
    $nome = $_POST['nomeP'] ?? null;;
    $datanasc = $_POST['datanascP'] ?? null;;
    $idade = $_POST['idadeP'] ?? null;;
    $telefone = $_POST['telefoneP'] ?? null;;
    $sexo = $_POST['sexoP'] ?? null;;
    $endereco = $_POST['enderecoP'] ?? null;;
    $munRes = $_POST['munResP'] ?? null;;
    $UF = $_POST['UFP'] ?? null;;



    $sql = "UPDATE pacientes SET RGSUSP = '$RG', nomeP = '$nome', datanascP = '$datanasc', idadeP = '$idade', telefoneP = '$telefone', sexoP = '$sexo' enderecoP = '$endereco', munResP = '$munRes', UFP = '$UF'";
    mysqli_query($conn, $sql);

    if(mysqli_affected_rows($conn) > 0){
        echo "<script>alert('Edição realizada com sucesso!!'); location.href='lista_pacientes.php'; </script>";
    } else {
        $erro = mysqli_errno($conn);

        if ($erro == 1062) {
            // Erro de duplicidade
            echo "<script>alert('Erro: Já existe um paciente com esse RG/SUS!'); history.back();</script>";
        } else {
            // Outro erro qualquer
            echo "Erro no banco: " . mysqli_error($conn);
        }
    }
} 
?>