<?php
include('conexao.php');
//funcao é o cargo da pessoa, enfermeiro, recepcionista
//acao é o que vai ser executado, cadastrar, editar, excluir e logar

$acao='';
$acao = $_GET["acao"];
$funcao = $_POST["funcao"];


if ($acao == "cadastrar") {
    if ($funcao == 'recepcionista') {
        $CPF = $_POST['CPF'] ?? null;
        $nome = $_POST['nome'] ?? null;;
        $datanasc = $_POST['datanasc'] ?? null;;
        $idade = $_POST['idade'] ?? null;;
        $telefone = $_POST['telefone'] ?? null;;
        $sexo = $_POST['sexo'] ?? null;;
        $senha = $_POST['senha'] ?? null;;

        $sql = "INSERT INTO recepcionistas(CPFR, nomeR, datanascR, idadeR, telefoneR, sexoR, senha) VALUES ('$CPF','$nome','$datanasc','$idade','$telefone','$sexo','$senha')";
        mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>alert('Cadastro realizado com sucesso!!'); location.href='restrita_admin.php'; </script>";
        } else {
            $erro = mysqli_errno($conn);

            if ($erro == 1062) {
                // Erro de duplicidade
                echo "<script>alert('Erro: Já existe um funcionário com esse CPF!'); history.back();</script>";
            } else {
                // Outro erro qualquer
                echo "Erro no banco: " . mysqli_error($conn);
            }
        }
    } else if ($funcao == 'enfermeiro') {
        $CPF = $_POST['CPF'] ?? null;
        $nome = $_POST['nome'] ?? null;;
        $datanasc = $_POST['datanasc'] ?? null;;
        $idade = $_POST['idade'] ?? null;;
        $telefone = $_POST['telefone'] ?? null;;
        $sexo = $_POST['sexo'] ?? null;;
        $senha = $_POST['senha'] ?? null;;
        $coren = $_POST['coren'] ?? null;;

        $sql = "INSERT INTO enfermeiros(CPFE, nomeE, datanascE, idadeE, telefoneE, sexoE, senha, corenE) VALUES ('$CPF','$nome','$datanasc','$idade','$telefone','$sexo','$senha', '$coren')";
        mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>alert('Cadastro realizado com sucesso!!'); location.href='restrita_admin.php'; </script>";
        } else {
            $erro = mysqli_errno($conn);

            if ($erro == 1062) {
                // Erro de duplicidade
                echo "<script>alert('Erro: Já existe um funcionário com esse CPF!'); history.back();</script>";
            } else {
                // Outro erro qualquer
                echo "Erro no banco: " . mysqli_error($conn);
            }
        }
    } else if ($funcao == 'medico') {
        $CPF = $_POST['CPF'] ?? null;
        $nome = $_POST['nome'] ?? null;;
        $datanasc = $_POST['datanasc'] ?? null;;
        $idade = $_POST['idade'] ?? null;;
        $telefone = $_POST['telefone'] ?? null;;
        $sexo = $_POST['sexo'] ?? null;;
        $senha = $_POST['senha'] ?? null;;
        $CRM = $_POST['CRM'] ?? null;;
        $espec = $_POST['especialidade'] ?? null;;

        $sql = "INSERT INTO medicos(CPFM, nomeM, datanascM, idadeM, telefoneM, sexoM, senha, CRM, especialidade) VALUES ('$CPF','$nome','$datanasc','$idade','$telefone','$sexo','$senha', '$CRM', '$espec')";
        mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>alert('Cadastro realizado com sucesso!!'); location.href='restrita_admin.php'; </script>";
        } else {
            $erro = mysqli_errno($conn);

            if ($erro == 1062) {
                // Erro de duplicidade
                echo "<script>alert('Erro: Já existe um funcionário com esse CPF!'); history.back();</script>";
            } else {
                // Outro erro qualquer
                echo "Erro no banco: " . mysqli_error($conn);
            }
        }
    } else {
        echo "<script>alert('Não foi possível fazer o cadastro!!');location.href='index.php';</script>";
    }
}

if ($acao == "editar") {

    // Campos comuns
    $cpf      = $_POST['cpf'];
    $nome     = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? null;
    $sexo     = $_POST['sexo'] ?? '';
    $idade    = $_POST['idade'] ?? null;
    $datanasc = $_POST['datanasc'] ?? null;
    $funcao     = $_POST['funcao'] ?? '';

    // usa NULL para valores vazios
    $telefone = $telefone == '' ? null : $telefone;

    if ($funcao == 'medico') {
        $crm = $_POST['crm'] ?? null;
        $especialidade = $_POST['especialidade'] ?? null;

        $sql = "UPDATE medicos 
            SET nomeM = ?, telefoneM = ?, sexoM = ?, idadeM = ?, datanascM = ?, CRM = ?, especialidade = ?
            WHERE CPFM = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssss", $nome, $telefone, $sexo, $idade, $datanasc, $crm, $especialidade, $cpf);
    } elseif ($funcao == 'enfermeiro') {
        $coren = $_POST['coren'] ?? null;

        $sql = "UPDATE enfermeiros 
            SET nomeE = ?, telefoneE = ?, sexoE = ?, idadeE = ?, datanascE = ?, corenE = ?
            WHERE CPFE = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $nome, $telefone, $sexo, $idade, $datanasc, $coren, $cpf);
    } elseif ($funcao == 'recepcionista') {
        $sql = "UPDATE recepcionistas 
            SET nomeR = ?, telefoneR = ?, sexoR = ?, idadeR = ?, datanascR = ?
            WHERE CPFR = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $nome, $telefone, $sexo, $idade, $datanasc, $cpf);
    } 

    // Executa e verifica
    if (!$stmt) {
        die('Erro ao preparar query: ' . mysqli_error($conn));
    }
    $ok = mysqli_stmt_execute($stmt);
    if ($ok) {
        mysqli_stmt_close($stmt);
        // Redireciona (ou exibe mensagem)
        echo "<script>alert('Dados modificados com sucesso!!');location.href='lista_funcionarios.php';</script>";
        exit;
    } else {
        $err = mysqli_error($conn);
        mysqli_stmt_close($stmt);
        die("Erro ao atualizar: $err");
    }
}

if ($acao == "excluir") {
    die("Aqui voce morre");
}

if ($acao == "logar") {


    if ($funcao == 'recepcionista') {
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];
        $query = mysqli_query($conn, "SELECT * FROM recepcionistas WHERE CPFR='$cpf' AND senha='$senha'");
        $numReg = mysqli_num_rows($query);

        if ($numReg == 1) {
            $recepcionista = $query->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
            };
            $_SESSION['CPFR'] = $recepcionista['CPFR'];
            $_SESSION['nomeR'] = $recepcionista['nomeR'];

            //header("Location: restrita_recepcao.php");
            echo "<script>alert('recepcionista logado com sucesso!!');location.href='restrita_recepcao.php';</script>";
        } else {
            echo "<script>alert('funcionarios e senha não existem!!');location.href='index.php';</script>";
        }
    } else if ($funcao == 'enfermeiro') {
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];
        $query = mysqli_query($conn, "SELECT * FROM enfermeiros WHERE CPFE='$cpf' AND senha='$senha'");
        $numReg = mysqli_num_rows($query);

        if ($numReg == 1) {
            $enfermeiro = $query->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
            };
            $_SESSION['CPFE'] = $enfermeiro['CPFE'];
            $_SESSION['nomeE'] = $enfermeiro['nomeE'];


            //header("Location: restrita_triagem.php");
            echo "<script>alert('enfermeiro logado com sucesso!!');location.href='restrita_triagem.php';</script>";
        } else {
            echo "<script>alert('funcionarios e senha não existem!!');location.href='index.php';</script>";
        }
    } else if ($funcao == 'administrador') {
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];
        $query = mysqli_query($conn, "SELECT * FROM administradores WHERE CPFA='$cpf' AND senha='$senha'");
        $numReg = mysqli_num_rows($query);

        if ($numReg == 1) {
            $administrador = $query->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
            };
            $_SESSION['CPFA'] = $administrador['CPFA'];
            $_SESSION['nomeA'] = $administrador['nomeA'];


            header("Location: restrita_admin.php");
            //echo "<script>alert('Admin logado com sucesso!!');location.href='restrita_admin.php';</script>";
        } else {
            echo "<script>alert('funcionarios e senha não existem!!');location.href='index.php';</script>";
        }
    } else if ($funcao == 'medico') {
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];
        $query = mysqli_query($conn, "SELECT * FROM medicos WHERE CPFM='$cpf' AND senha='$senha'");
        $numReg = mysqli_num_rows($query);

        if ($numReg == 1) {
            $medico = $query->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
            };
            $_SESSION['CPFA'] = $medico['CPFM'];
            $_SESSION['nomeA'] = $medico['nomeM'];



            echo "<script>alert('Médico logado com sucesso!!');location.href='restrita_medico.php';</script>";
        } else {
            echo "<script>alert('funcionario e senha não existem!!');location.href='index.php';</script>";
        }
    }
}
