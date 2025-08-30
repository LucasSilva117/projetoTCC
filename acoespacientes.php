<?php
include('conexao.php');

if (isset($_POST['cadastrar_paciente'])) {
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

    if (mysqli_affected_rows($conn) > 0) {
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

if (isset($_POST['excluir_paciente'])) {
    $paciente_id = mysqli_real_escape_string($conn, $_POST['excluir_paciente']);
    $sql = "DELETE FROM pacientes WHERE id = '$paciente_id'";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Paciente excluido com sucesso!!');location.href='lista_pacientes.php';</script>";
    } else {
        echo "<script>alert('Não foi possivel excluir esse paciente!!');location.href='lista_pacientes.php';</script>";
    }
}

if (isset($_POST['editar_paciente'])) {
    $paciente_id = mysqli_real_escape_string($conn, $_POST['id']);

    $RG = $_POST['RGSUSP'] ?? null;
    $nome = $_POST['nomeP'] ?? null;;
    $datanasc = $_POST['datanascP'] ?? null;;
    $idade = $_POST['idadeP'] ?? null;;
    $telefone = $_POST['telefoneP'] ?? null;;
    $sexo = $_POST['sexoP'] ?? null;;
    $endereco = $_POST['enderecoP'] ?? null;;
    $munRes = $_POST['munResP'] ?? null;;
    $UF = $_POST['UFP'] ?? null;;



    $sql = "UPDATE pacientes SET RGSUSP = '$RG', nomeP = '$nome', datanascP = '$datanasc', idadeP = '$idade', telefoneP = '$telefone', sexoP = '$sexo', enderecoP = '$endereco', munResP = '$munRes', UFP = '$UF' WHERE id = '$paciente_id'";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Edição realizada com sucesso!!'); location.href='lista_pacientes.php'; </script>";
    } else {
        $erro = mysqli_error($conn);

        if ($erro == 1062) {
            // Erro de duplicidade
            echo "<script>alert('Erro: Já existe um paciente com esse RG/SUS!'); history.back();</script>";
        } else {
            // Outro erro qualquer
            echo "Erro no banco: " . mysqli_error($conn);
        }
    }
}


// AÇÕES NO ATENDIMENTO

if (isset($_POST['adicionar_atendimento'])) {
    session_start();
    $RG = $_POST['RGSUSP'] ?? null;
    $cpf = $_SESSION['CPFR'] ?? null; // CPF do recepcionista logado

    if (!$RG || !$cpf) {
        echo "<script>alert('Dados insuficientes!'); history.back();</script>";
        exit;
    }

    // Data e hora atuais
    date_default_timezone_set('America/Sao_Paulo');
    $dataHoje = date('Y-m-d');
    $horaAgora = date('H:i');

    // Verifica duplicidade: paciente já adicionado hoje?
    $check = mysqli_query($conn, "SELECT * FROM atendimentos WHERE RGSUSPf = '$RG' AND dataA = '$dataHoje' AND situacao IN ('esperando', 'em_atendimento')");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Paciente já está na lista de atendimento hoje!'); history.back();</script>";
        exit;
    }

    // Calcular ordem
    $resOrdem = mysqli_query($conn, "SELECT COUNT(*) as total FROM atendimentos WHERE dataA = '$dataHoje'");
    $row = mysqli_fetch_assoc($resOrdem);
    $ordem = $row['total'] + 1;

    // Inserir paciente
    $sqlInsert = "INSERT INTO atendimentos (CPFRf, RGSUSPf, dataA, hora, ordem, situacao)
                  VALUES ('$cpf', '$RG', '$dataHoje', '$horaAgora', '$ordem', 'esperando')";

    if (mysqli_query($conn, $sqlInsert)) {
        echo "<script>alert('Paciente adicionado com sucesso!'); location.href='restrita_recepcao.php';</script>";
    } else {
        echo "<script>alert('Erro ao adicionar paciente: " . mysqli_error($conn) . "'); history.back();</script>";
    }
}

if (isset($_POST['excluir_atendimento'])) {
    $codAten = mysqli_real_escape_string($conn, $_POST['excluir_atendimento']);
    $sql = "DELETE FROM atendimentos WHERE codAten = '$codAten'";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Atendimento excluido com sucesso!!');location.href='restrita_recepcao.php';</script>";
    } else {
        echo "<script>alert('Não foi possivel excluir esse atendimento!!');location.href='restrita_recepcao.php';</script>";
    }
}

if (isset($_POST['atender_paciente'])) {
    session_start();
    $cpf = $_SESSION['CPFE'] ?? null; // CPF do enfermeiro logado
    $codAten = $_POST['codAten'] ?? null; // codAten enviado pelo hidden no formulario

    $sql_update = "UPDATE atendimentos SET situacao = 'finalizado' WHERE codAten = '$codAten'";
    mysqli_query($conn, $sql_update); //atualizando a situacao em atendimentos

    $temDiarreia = $_POST['temDiarreia'] ?? null;
    $tempoSintomas = $_POST['tempoSintomas'] ?? null;
    $temAlergia = $_POST['temAlergia'] ?? null;
    $alergiaAque = $_POST['alergiaAque'] ?? null;
    $tosseMais3sem = $_POST['tosseMais3sem'] ?? null;
    $colheuBK = $_POST['colheuBK'] ?? null;
    $pressaoArterial = $_POST['pressaoArterial'] ?? null;
    $pulso = $_POST['pulso'] ?? null;
    $frequenciaResp = $_POST['frequenciaResp'] ?? null;
    $temperatura = $_POST['temperatura'] ?? null;
    $glicemia = $_POST['glicemia'] ?? null;
    $SPO = $_POST['SPO'] ?? null;
    $clascRisco = $_POST['clascRisco'] ?? null;
    $peso = $_POST['peso'] ?? null;
    $hora = $_POST['hora'] ?? null;
    $observacao = $_POST['observacao'] ?? null;


    $sql = "INSERT INTO triagens(CPFEf, codAtenf, temDiarreia, tempoSintomas, temAlergia, alergiaAque, tosseMais3sem, colheuBK, pressaoArterial, pulso, frequenciaResp, temperatura, glicemia, SPO, clascRisco, peso, hora, observacao) VALUES 
    ('$cpf','$codAten','$temDiarreia','$tempoSintomas','$temAlergia','$alergiaAque','$tosseMais3sem','$colheuBK','$pressaoArterial','$pulso','$frequenciaResp','$temperatura','$glicemia','$SPO','$clascRisco','$peso','$hora','$observacao')";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Atendimento finalizado com sucesso!!'); location.href='restrita_triagem.php'; </script>";
    } else {
        echo "Erro no banco: " . mysqli_error($conn);
    }

    //quando o paciente terminar de ser atendido, mudar o status da tabela atendimento para "finalizado"
}
