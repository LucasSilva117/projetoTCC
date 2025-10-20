<?php
include('conexao.php');
//funcao é o cargo da pessoa, enfermeiro, recepcionista
//acao é o que vai ser executado, cadastrar, editar, excluir e logar

$acao = '';
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
        $senha = isset($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : '';;

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
        $senha = isset($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : '';;
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
        $senha = isset($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : '';;
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
    if ($funcao == 'recepcionista') {
        $cpfexclui = $_POST['cpf'];

        $sql = "DELETE FROM recepcionistas WHERE CPFR = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $cpfexclui);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Funcionário excluído com sucesso!');location.href='lista_funcionarios.php';</script>";
        } else {
            if (mysqli_errno($conn) == 1451) { // erro de restrição FK
                echo "<script>alert('Não é possível excluir: esse funcionário possui atendimentos concluídos.');history.back();</script>";
            } else {
                echo "<script>alert('Erro ao excluir: " . mysqli_error($conn) . "');history.back();</script>";
            }
        }
    } elseif ($funcao == 'enfermeiro') {
        $cpfexclui = $_POST['cpf'];

        $sql = "DELETE FROM enfermeiros WHERE CPFE = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $cpfexclui);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Funcionário excluído com sucesso!');location.href='lista_funcionarios.php';</script>";
        } else {
            if (mysqli_errno($conn) == 1451) { // erro de restrição FK
                echo "<script>alert('Não é possível excluir: esse funcionário possui atendimentos concluídos.');history.back();</script>";
            } else {
                echo "<script>alert('Erro ao excluir: " . mysqli_error($conn) . "');history.back();</script>";
            }
        }
    } elseif ($funcao == 'medico') {
        $cpfexclui = $_POST['cpf'];

        $sql = "DELETE FROM medicos WHERE CPFM = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $cpfexclui);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Funcionário excluído com sucesso!');location.href='lista_funcionarios.php';</script>";
        } else {
            if (mysqli_errno($conn) == 1451) { // erro de restrição FK
                echo "<script>alert('Não é possível excluir: esse funcionário possui atendimentos concluídos.');history.back();</script>";
            } else {
                echo "<script>alert('Erro ao excluir: " . mysqli_error($conn) . "');history.back();</script>";
            }
        }
    } else {
        die('Erro ao preparar query: ' . mysqli_error($conn));
    }
}

if ($acao == "logar") {


    if ($funcao == 'recepcionista') {
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];

        // Busca o funcionário pelo CPF
        $query = mysqli_query($conn, "SELECT * FROM recepcionistas WHERE CPFR='$cpf'");

        if ($query && mysqli_num_rows($query) === 1) {
            $recepcionista = mysqli_fetch_assoc($query);

            // Verifica a senha
            if (password_verify($senha, $recepcionista['senha'])) {

                if (!isset($_SESSION)) {
                    session_start();
                }

                $_SESSION['CPFR'] = $recepcionista['CPFR'];
                $_SESSION['nomeR'] = $recepcionista['nomeR'];

                echo "<script>alert('Recepcionista logado com sucesso!');location.href='restrita_recepcao.php';</script>";
            } else {
                // Senha incorreta
                echo "<script>alert('Senha incorreta!');location.href='index.php';</script>";
            }
        } else {
            // CPF não encontrado
            echo "<script>alert('Usuário não encontrado!');location.href='index.php';</script>";
        }
    } else if ($funcao == 'enfermeiro') {
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];

        // Busca o funcionário pelo CPF
        $query = mysqli_query($conn, "SELECT * FROM enfermeiros WHERE CPFE='$cpf'");

        if ($query && mysqli_num_rows($query) === 1) {
            $enfermeiro = mysqli_fetch_assoc($query);

            // Verifica a senha
            if (password_verify($senha, $enfermeiro['senha'])) {

                if (!isset($_SESSION)) {
                    session_start();
                }

                $_SESSION['CPFE'] = $enfermeiro['CPFE'];
                $_SESSION['nomeE'] = $enfermeiro['nomeE'];

                echo "<script>alert('Enfermeiro logado com sucesso!');location.href='restrita_triagem.php';</script>";
            } else {
                // Senha incorreta
                echo "<script>alert('Senha incorreta!');location.href='index.php';</script>";
            }
        } else {
            // CPF não encontrado
            echo "<script>alert('Usuário não encontrado!');location.href='index.php';</script>";
        }
    } else if ($funcao == 'administrador') {
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];

        // Busca o funcionário pelo CPF
        $query = mysqli_query($conn, "SELECT * FROM administradores WHERE CPFA='$cpf'");

        if ($query && mysqli_num_rows($query) === 1) {
            $administrador = mysqli_fetch_assoc($query);

            // Verifica a senha
            if (password_verify($senha, $administrador['senha'])) {

                if (!isset($_SESSION)) {
                    session_start();
                }

                $_SESSION['CPFA'] = $administrador['CPFA'];
                $_SESSION['nomeA'] = $administrador['nomeA'];

                echo "<script>alert('Administrador logado com sucesso!');location.href='restrita_admin.php';</script>";
            } else {
                // Senha incorreta
                echo "<script>alert('Senha incorreta!');location.href='index.php';</script>";
            }
        } else {
            // CPF não encontrado
            echo "<script>alert('Usuário não encontrado!');location.href='index.php';</script>";
        }
    } else if ($funcao == 'medico') {
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];

        // Busca o funcionário pelo CPF
        $query = mysqli_query($conn, "SELECT * FROM medicos WHERE CPFM='$cpf'");

        if ($query && mysqli_num_rows($query) === 1) {
            $medico = mysqli_fetch_assoc($query);

            // Verifica a senha
            if (password_verify($senha, $medico['senha'])) {

                if (!isset($_SESSION)) {
                    session_start();
                }

                $_SESSION['CPFM'] = $medico['CPFM'];
                $_SESSION['nomeM'] = $medico['nomeM'];

                echo "<script>alert('Médico logado com sucesso!');location.href='restrita_medico.php';</script>";
            } else {
                // Senha incorreta
                echo "<script>alert('Senha incorreta!');location.href='index.php';</script>";
            }
        } else {
            // CPF não encontrado
            echo "<script>alert('Usuário não encontrado!');location.href='index.php';</script>";
        }
    }
}
