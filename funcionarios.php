<?php
include('conexao.php');
$funcao = "";
$funcao = $_GET["funcao"];
$tipo=$_POST["tipo"];


if ($funcao == "cadastrar") {
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $insere = mysqli_query($conn, "INSERT INTO funcionarios(NOME,cpf,SENHA) VALUES ('$nome','$cpf','$senha')");

    if ($insere) {
        echo "<script>alert('Cadastro realizado com sucesso!!'); location.href='cad_funcionarios.php'; </script>";
    } else {
        echo "<script>alert('Não foi possível inserir os dados!!');history.back(-1);</script>";
    }
}

if ($funcao == "editar") {
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $cpfaltera = $_GET['cpf'];

    $altera = mysqli_query($conn, "UPDATE funcionarios SET nome='$nome', cpf='$cpf' WHERE cpf='$cpfaltera'");

    if ($altera) {
        echo "<script>alert('Alteração realizada com sucesso!!');location.href='listatabela.php';</script>";
    } else {
        echo "<script>alert('Não foi possível alterar os dados!!');history.back(-1);</script>";
    }
}

if ($funcao == "excluir") {
    $cpfexclui = $_GET['cpf'];

    $exclui = mysqli_query($conn, "DELETE FROM funcionarios WHERE cpf='$cpfexclui'");

    if ($exclui) {
        echo "<script>alert('Exclusão realizada com sucesso!!');location.href='listatabela.php';</script>";
    } else {
        echo "<script>alert('Não foi possível excluir os dados!!');history.back(-1);</script>";
    }
}

if ($funcao == "logar") {
    
     
    if($tipo=='recepcionista'){
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];
        $query = mysqli_query($conn, "SELECT * FROM recepcionistas WHERE CPFR='$cpf' AND senha='$senha'");
        $numReg = mysqli_num_rows($query);

        if ($numReg == 1) {
        $recepcionista = $query->fetch_assoc();

        if(!isset($_SESSION)){
            session_start();
        };
        $_SESSION['CPFR']= $recepcionista['CPFR'];
        $_SESSION['nomeR']= $recepcionista['nomeR'];
 
            //header("Location: restrita_recepcao.php");
            echo "<script>alert('recepcionista logado com sucesso!!');location.href='restrita_recepcao.php';</script>";
        } 
        else {
        echo "<script>alert('funcionarios e senha não existem!!');location.href='index.php';</script>";
        }
    }
    else if($tipo=='enfermeiro'){
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];
        $query = mysqli_query($conn, "SELECT * FROM enfermeiros WHERE CPFE='$cpf' AND senha='$senha'");
        $numReg = mysqli_num_rows($query);

        if ($numReg == 1) {
        $enfermeiro = $query->fetch_assoc();

        if(!isset($_SESSION)){
            session_start();
        };
        $_SESSION['CPFE']= $enfermeiro['CPFE'];
        $_SESSION['nomeE']= $enfermeiro['nomeE'];
 
 
            //header("Location: restrita_triagem.php");
            echo "<script>alert('enfermeiro logado com sucesso!!');location.href='restrita_triagem.php';</script>";
        }
        else {
        echo "<script>alert('funcionarios e senha não existem!!');location.href='index.php';</script>";
        }
    }
    else if($tipo=='administrador'){
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];
        $query = mysqli_query($conn, "SELECT * FROM administradores WHERE CPFA='$cpf' AND senha='$senha'");
        $numReg = mysqli_num_rows($query);

        if ($numReg == 1) {
        $administrador = $query->fetch_assoc();

        if(!isset($_SESSION)){
            session_start();
        };
        $_SESSION['CPFA']= $administrador['CPFA'];
        $_SESSION['nomeA']= $administrador['nomeA'];
 
 
            header("Location: restrita_admin.php");
            //echo "<script>alert('Admin logado com sucesso!!');location.href='restrita_admin.php';</script>";
        }
        else {
        echo "<script>alert('funcionarios e senha não existem!!');location.href='index.php';</script>";
        }
    }
    else if($tipo=='medico'){
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];
        $query = mysqli_query($conn, "SELECT * FROM medicos WHERE CPFM='$cpf' AND senha='$senha'");
        $numReg = mysqli_num_rows($query);

        if ($numReg == 1) {
        $medico = $query->fetch_assoc();

        if(!isset($_SESSION)){
            session_start();
        };
        $_SESSION['CPFA']= $medico['CPFM'];
        $_SESSION['nomeA']= $medico['nomeM'];
 
 
            
        echo "<script>alert('Médico logado com sucesso!!');location.href='restrita_medico.php';</script>";
        }
        else {
        echo "<script>alert('funcionario e senha não existem!!');location.href='index.php';</script>";
        }
    }
        
    
}
?>