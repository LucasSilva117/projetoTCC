<?php
include('conexao.php');

if (isset($_POST['cadastrar_paciente'])) {
    $CPFP = $_POST['CPFP'] ?? null;
    $RGP = $_POST['RGP'] ?? null;
    $CNSP = $_POST['CNSP'] ?? null;
    $nome = $_POST['nomeP'] ?? null;;
    $datanasc = $_POST['datanascP'] ?? null;;
    $idade = $_POST['idadeP'] ?? null;;
    $telefone = $_POST['telefoneP'] ?? null;;
    $sexo = $_POST['sexoP'] ?? null;;
    $endereco = $_POST['enderecoP'] ?? null;;
    $munRes = $_POST['munResP'] ?? null;;
    $UF = $_POST['UFP'] ?? null;;


    $sql = "INSERT INTO pacientes(CPFP, RGP, CNSP, nomeP, datanascP, idadeP, telefoneP, sexoP, enderecoP, munResP, UFP) VALUES ('$CPFP','$RGP','$CNSP','$nome','$datanasc','$idade','$telefone','$sexo','$endereco','$munRes','$UF')";
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
    $sql = "DELETE FROM pacientes WHERE codP = '$paciente_id'";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Paciente excluido com sucesso!!');location.href='lista_pacientes.php';</script>";
    } else {
        echo "<script>alert('Não foi possivel excluir esse paciente!!');location.href='lista_pacientes.php';</script>";
    }
}

if (isset($_POST['editar_paciente']) || (isset($_POST['acao']) && $_POST['acao'] === 'editar_paciente')) {
    $paciente_id = mysqli_real_escape_string($conn, $_POST['codP']);

    $RG = $_POST['CPFP'] ?? null;
    $nome = $_POST['nomeP'] ?? null;;
    $datanasc = $_POST['datanascP'] ?? null;;
    $idade = $_POST['idadeP'] ?? null;;
    $telefone = $_POST['telefoneP'] ?? null;;
    $sexo = $_POST['sexoP'] ?? null;;
    $endereco = $_POST['enderecoP'] ?? null;;
    $munRes = $_POST['munResP'] ?? null;;
    $UF = $_POST['UFP'] ?? null;;



    $sql = "UPDATE pacientes SET CPFP = '$RG', nomeP = '$nome', datanascP = '$datanasc', idadeP = '$idade', telefoneP = '$telefone', sexoP = '$sexo', enderecoP = '$endereco', munResP = '$munRes', UFP = '$UF' WHERE codP = '$paciente_id'";
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
            echo "Erro no banco: " . $erro;
        }
    }
}


// AÇÕES NO ATENDIMENTO (RECEPÇÃO)

if (isset($_POST['adicionar_atendimento'])) {
    session_start();
    $CPFP = $_POST['CPFP'] ?? null;
    $CPFR = $_SESSION['CPFR'] ?? null; // CPF do recepcionista logado

    if (!$CPFP || !$CPFR) {
        echo "<script>alert('Dados insuficientes!'); history.back();</script>";
        exit;
    }

    // Data e hora atuais
    date_default_timezone_set('America/Sao_Paulo');
    $dataHoje = date('Y-m-d');
    $horaAgora = date('H:i');

    // Verifica duplicidade: paciente já adicionado hoje?
    $check = mysqli_query($conn, "SELECT * FROM atendimentos WHERE CPFPf = '$CPFP' AND dataA = '$dataHoje' AND situacao IN ('Esperando', 'Na triagem', 'Esperando consulta','Na consulta')");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Paciente já está na lista de atendimento hoje!'); history.back();</script>";
        exit;
    }

    // Calcular ordem
    $resOrdem = mysqli_query($conn, "SELECT COUNT(*) as total FROM atendimentos WHERE dataA = '$dataHoje'");
    $row = mysqli_fetch_assoc($resOrdem);
    $ordem = $row['total'] + 1;

    // Inserir paciente
    $sqlInsert = "INSERT INTO atendimentos (CPFRf, CPFPf, CPFEf, CPFMf, dataA, horaA, ordem, situacao)
                  VALUES ('$CPFR', '$CPFP', '', '', '$dataHoje', '$horaAgora', '$ordem', 'Esperando')";

    if (mysqli_query($conn, $sqlInsert)) {
        echo "<script>alert('Paciente adicionado com sucesso!'); location.href='restrita_recepcao.php';</script>";
    } else {
        echo "<script>alert('Erro ao adicionar paciente: " . mysqli_error($conn) . "'); history.back();</script>";
    }
}

if (isset($_POST['excluir_atendimento'])) {
    $codAten = mysqli_real_escape_string($conn, $_POST['excluir_atendimento']);

    // verifica a situação antes
    $sql_check = "SELECT situacao FROM atendimentos WHERE codAten = '$codAten'";
    $result_check = mysqli_query($conn, $sql_check);
    $atendimento = mysqli_fetch_assoc($result_check);

    if ($atendimento && $atendimento['situacao'] === 'Na triagem') {
        // bloqueia a exclusão
        echo "<script>alert('Não é possível excluir um atendimento que está em atendimento!');location.href='restrita_recepcao.php';</script>";
        exit;
    }

    //exclusão 
    $codAten = mysqli_real_escape_string($conn, $_POST['excluir_atendimento']);
    $sql = "DELETE FROM atendimentos WHERE codAten = '$codAten'";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Atendimento excluido com sucesso!!');location.href='restrita_recepcao.php';</script>";
    } else {
        echo "<script>alert('Não foi possivel excluir esse atendimento!!');location.href='restrita_recepcao.php';</script>";
    }
}

// AÇÕES NO ATENDIMENTO (TRIAGEM)

if (isset($_POST['atender_paciente'])) {
    session_start();
    $cpf = $_SESSION['CPFE'] ?? null; // CPF do enfermeiro logado
    $codAten = $_POST['codAten'] ?? null; // codAten enviado pelo hidden no formulario

    $sql_update = "UPDATE atendimentos SET situacao = 'Esperando consulta', WHERE codAten = '$codAten'";
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
    $horaT = $_POST['horaT'] ?? null;
    $observacao = $_POST['observacao'] ?? null;


    $sql = "INSERT INTO triagens(CPFEf, codAtenf, temDiarreia, tempoSintomas, temAlergia, alergiaAque, tosseMais3sem, colheuBK, pressaoArterial, pulso, frequenciaResp, temperatura, glicemia, SPO, clascRisco, peso, horaT, observacao) VALUES 
    ('$cpf','$codAten','$temDiarreia','$tempoSintomas','$temAlergia','$alergiaAque','$tosseMais3sem','$colheuBK','$pressaoArterial','$pulso','$frequenciaResp','$temperatura','$glicemia','$SPO','$clascRisco','$peso','$horaT','$observacao')";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Atendimento realizado com sucesso!!'); location.href='restrita_triagem.php'; </script>";
    } else {
        echo "Erro no banco: " . mysqli_error($conn);
    }

    //quando o paciente terminar de ser atendido, mudar o status da tabela atendimento para "Esperando consulta"
}

if (isset($_POST['excluir_atendimentoT'])) {
    $codAtenT = mysqli_real_escape_string($conn, $_POST['excluir_atendimentoT']);

    // Buscar o codAten referente à triagem
    $res = mysqli_query($conn, "SELECT codAtenf FROM triagens WHERE codAtenT = '$codAtenT'");
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $codAten = $row['codAtenf'];

        // Excluir da triagem
        mysqli_query($conn, "DELETE FROM triagens WHERE codAtenT = '$codAtenT'");

        // Excluir do atendimento
        mysqli_query($conn, "DELETE FROM atendimentos WHERE codAten = '$codAten'");
    }

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Atendimento excluido com sucesso!!');location.href='hist_atendimentos.php';</script>";
    } else {
        echo "<script>alert('Não foi possivel excluir esse atendimento!!');location.href='hist_atendimentos.php';</script>";
    }
}

if (isset($_POST['voltar_atendimento'])) {
    $codAten = mysqli_real_escape_string($conn, $_POST['codAten']);

    // Atualiza a situação para "esperando"
    $sql = "UPDATE atendimentos SET situacao = 'Esperando' WHERE codAten = '$codAten'";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Atendimento voltou para a fila!'); location.href='restrita_triagem.php';</script>";
    } else {
        echo "<script>alert('Erro ao voltar atendimento!'); location.href='restrita_triagem.php';</script>";
    }
    exit;
}

// AÇÕES NO ATENDIMENTO (CONSULTÓRIO)

if (isset($_POST['consulta_paciente'])) {
    session_start();
    $CPFM = $_SESSION['CPFM'] ?? null; // CPF do médico logado
    $codAten = $_POST['codAten'] ?? null; // codAten enviado pelo hidden no formulario

    $sql_update = "UPDATE atendimentos SET situacao = 'Finalizado', WHERE codAten = '$codAten'";
    mysqli_query($conn, $sql_update); //atualizando a situacao em atendimentos

    // completar com os dados da consulta
    $horaC = $_POST['horaC'] ?? null;
    $exameClinico = $_POST['exameClinico'] ?? null;
    $conduta = $_POST['conduta'] ?? null;
    $sql = "INSERT INTO consultas(CPFMf, codAtenf, horaC, exameClinico, conduta) VALUES 
    ('$CPFM','$codAten','$horaC','$exameClinico','$conduta')";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Atendimento finalizado com sucesso!!'); location.href='restrita_medico.php'; </script>";
    } else {
        echo "Erro no banco: " . mysqli_error($conn);
    }
}

if (isset($_POST['excluir_atendimentoC'])) {
    $codAten = mysqli_real_escape_string($conn, $_POST['excluir_atendimentoC']);

    // verifica a situação antes
    $sql_check = "SELECT situacao FROM atendimentos WHERE codAten = '$codAten'";
    $result_check = mysqli_query($conn, $sql_check);
    $atendimento = mysqli_fetch_assoc($result_check);

    if ($atendimento && $atendimento['situacao'] === 'Na consulta') {
        // bloqueia a exclusão
        echo "<script>alert('Não é possível excluir um atendimento que está em atendimento!');location.href='restrita_medico.php';</script>";
        exit;
    }

    //exclusão 
    $codAten = mysqli_real_escape_string($conn, $_POST['excluir_atendimentoC']);
    $sql = "DELETE FROM atendimentos WHERE codAten = '$codAten'";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Atendimento excluido com sucesso!!');location.href='restrita_medico.php';</script>";
    } else {
        echo "<script>alert('Não foi possivel excluir esse atendimento!!');location.href='restrita_medico.php';</script>";
    }
}

if (isset($_POST['voltar_atendimentoC'])) {
    $codAten = mysqli_real_escape_string($conn, $_POST['codAten']);

    // Atualiza a situação para "esperando consulta"
    $sql = "UPDATE atendimentos SET situacao = 'Esperando consulta' WHERE codAten = '$codAten'";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Atendimento voltou para a fila de espera para consulta!'); location.href='restrita_medico.php';</script>";
    } else {
        echo "<script>alert('Erro ao voltar atendimento!'); location.href='restrita_medico.php';</script>";
    }
    exit;
}