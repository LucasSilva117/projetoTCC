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


    $sql = "INSERT INTO pacientes(CPFP, RGP, CNSP, nomeP, datanascP, idadeP, telefoneP, sexoP, enderecoP, munResP, UFP) 
    VALUES ('$CPFP','$RGP','$CNSP','$nome','$datanasc','$idade','$telefone','$sexo','$endereco','$munRes','$UF')";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Cadastro realizado com sucesso!!'); location.href='restrita_recepcao.php'; </script>";
    } else {
        $erro = mysqli_errno($conn);

        if ($erro == 1062) {
            // Erro de duplicidade
            echo "<script>alert('Erro: Já existe um paciente com esse CPF, RG ou CNS!'); history.back();</script>";
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



    $sql = "UPDATE pacientes SET CPFP = '$RG', nomeP = '$nome', 
    datanascP = '$datanasc', idadeP = '$idade', telefoneP = '$telefone',
    sexoP = '$sexo', enderecoP = '$endereco', munResP = '$munRes',
    UFP = '$UF' 
    WHERE codP = '$paciente_id'";
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
    $check = mysqli_query($conn, "SELECT * FROM atendimentos 
    WHERE CPFPf = '$CPFP' AND dataA = '$dataHoje' AND situacao 
    IN ('Esperando', 'Na triagem', 'Esperando consulta','Na consulta')");
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
        echo "<script>alert('Não é possível excluir um atendimento que está em atendimento!');history.back();</script>";
        exit;
    }

    //exclusão 
    $codAten = mysqli_real_escape_string($conn, $_POST['excluir_atendimento']);
    $sql = "DELETE FROM atendimentos WHERE codAten = '$codAten'";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Atendimento excluido com sucesso!!'); history.back();</script>";
    } else {
        echo "<script>alert('Não foi possivel excluir esse atendimento!!');history.back();</script>";
    }
}

// AÇÕES NO ATENDIMENTO (TRIAGEM)

if (isset($_POST['atender_paciente'])) {
    session_start();
    $cpf = $_SESSION['CPFE'] ?? null; // CPF do enfermeiro logado
    $codAten = $_POST['codAten'] ?? null; // codAten enviado pelo hidden no formulario

    $sql_update = "UPDATE atendimentos SET situacao = 'Esperando consulta', CPFEf = '$cpf' WHERE codAten = '$codAten'";
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


    $sql = "INSERT INTO triagens(CPFEf, codAtenf, temDiarreia, tempoSintomas,
    temAlergia, alergiaAque, tosseMais3sem, colheuBK, pressaoArterial,
    pulso, frequenciaResp, temperatura, glicemia, SPO, clascRisco,
    peso, horaT, observacao) 
    VALUES 
    ('$cpf','$codAten','$temDiarreia','$tempoSintomas','$temAlergia','$alergiaAque',
    '$tosseMais3sem','$colheuBK','$pressaoArterial','$pulso','$frequenciaResp',
    '$temperatura','$glicemia','$SPO','$clascRisco','$peso','$horaT','$observacao')";
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

    // verifica a situação antes
    $sql_check = "SELECT situacao FROM atendimentos WHERE codAten = '$codAtenT'";
    $result_check = mysqli_query($conn, $sql_check);
    $atendimento = mysqli_fetch_assoc($result_check);

    if ($atendimento && $atendimento['situacao'] === 'Na consulta') {
        // bloqueia a exclusão
        echo "<script>alert('Não é possível excluir um atendimento que está em atendimento!');history.back();</script>";
        exit;
    }
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
        echo "<script>alert('Atendimento excluido com sucesso!!');history.back();</script>";
    } else {
        echo "<script>alert('Não foi possivel excluir esse atendimento!!');history.back();</script>";
    }
}

if (isset($_POST['voltar_atendimento'])) {
    $codAten = mysqli_real_escape_string($conn, $_POST['codAten']);

    // Atualiza a situação para "esperando"
    $sql = "UPDATE atendimentos SET situacao = 'Esperando', CPFEf = '' WHERE codAten = '$codAten'";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Atendimento voltou para a fila!'); location.href='restrita_triagem.php';</script>";
    } else {
        echo "<script>alert('Erro ao voltar atendimento!'); location.href='restrita_triagem.php';</script>";
    }
    exit;
}

// AÇÕES NO ATENDIMENTO (CONSULTÓRIO)

if (isset($_POST['consulta_paciente']) || (isset($_POST['acao']) && $_POST['acao'] === 'consulta_paciente')) {

    session_start();
    $CPFM = $_SESSION['CPFM'] ?? null; // CPF do médico logado, se usado
    $codAten = mysqli_real_escape_string($conn, $_POST['codAten'] ?? '');
    $codAtenT = mysqli_real_escape_string($conn, $_POST['codAtenT'] ?? '');
    $horaC = mysqli_real_escape_string($conn, $_POST['horaC'] ?? '');
    $exameClinico = mysqli_real_escape_string($conn, $_POST['exameClinico'] ?? '');
    $conduta = mysqli_real_escape_string($conn, $_POST['conduta'] ?? '');
    $imprimir = isset($_POST['imprimir']) && $_POST['imprimir'] == '1';

    // Atualiza atendimento com os dados do consultório e finaliza
    $sql_update = "UPDATE atendimentos SET CPFMf = '$CPFM', situacao = 'Finalizado' WHERE codAten = '$codAten'";
    mysqli_query($conn, $sql_update);
    $sql_update2 = "UPDATE triagens SET CPFMf = '$CPFM' WHERE codAten = '$codAtenT'";
    mysqli_query($conn, $sql_update2);

    $sql = "INSERT INTO consultas(CPFMf, codAtenTf, codAtenf, horaC, exameclinico, conduta) VALUES 
    ($CPFM,'$codAtenT','$codAten','$horaC','$exameClinico','$conduta')";
    mysqli_query($conn, $sql);
    
    if ($imprimir == '0'){
        // Sem impressão, apenas confirma
        echo "<script>alert('Consulta realizada com sucesso!'); location.href='restrita_medico.php';</script>";
        exit;

    }elseif ($imprimir == '1') {

        // Carrega dados completos para o relatório (aten + paciente + triagem)
        $sql = "SELECT a.*, p.*, t.* 
                FROM atendimentos a
                JOIN pacientes p ON a.CPFPf = p.CPFP
                LEFT JOIN triagens t ON t.codAtenf = a.codAten
                WHERE a.codAten = '$codAten' LIMIT 1";
        $res = mysqli_query($conn, $sql);
        $aten = mysqli_fetch_assoc($res);

        // Gerar HTML do relatório usando os dados 
        $html = '<!doctype html><html><head><meta charset="utf-8"><style>
        body{font-family: DejaVu Sans, Arial, sans-serif; font-size:12px}
        h1,h2{margin:0 0 8px}
        .section{margin-bottom:12px}
        .label{font-weight:700}
        table{width:100%; border-collapse:collapse}
        td, th{padding:6px; border:1px solid #ccc; vertical-align:top}
        </style></head><body>';
        $html .= '<h1>Relatório de Atendimento</h1>';
        $html .= '<div class="section"><h2>Dados do Paciente</h2>';
        $html .= '<table><tr><td class="label">CPF</td><td>' . htmlspecialchars($aten['CPFP'] ?? '') . '</td>';
        $html .= '<td class="label">Nome</td><td>' . htmlspecialchars($aten['nomeP'] ?? '') . '</td></tr>';
        $html .= '<tr><td class="label">RG</td><td>' . htmlspecialchars($aten['RGP'] ?? '') . '</td>';
        $html .= '<td class="label">CNS</td><td>' . htmlspecialchars($aten['CNSP'] ?? '') . '</td></tr>';
        $html .= '<tr><td class="label">Data de Nascimento</td><td>' . htmlspecialchars($aten['datanascP'] ?? '') . '</td>';
        $html .= '<td class="label">Idade</td><td>' . htmlspecialchars($aten['idadeP'] ?? '') . '</td></tr>';
        $html .= '<tr><td class="label">Telefone</td><td>' . htmlspecialchars($aten['telefoneP'] ?? '') . '</td>';
        $html .= '<td class="label">Sexo</td><td>' . htmlspecialchars($aten['sexoP'] ?? '') . '</td></tr></table></div>';

        $html .= '<div class="section"><h2>Triagem / Enfermagem</h2><table>';
        $html .= '<tr><td class="label">Data de sintomas</td><td>' . htmlspecialchars($aten['tempoSintomas'] ?? '') . '</td>';
        $html .= '<td class="label">PA</td><td>' . htmlspecialchars($aten['pressaoArterial'] ?? '') . '</td></tr>';
        $html .= '<tr><td class="label">Pulso</td><td>' . htmlspecialchars($aten['pulso'] ?? '') . '</td>';
        $html .= '<td class="label">F/R</td><td>' . htmlspecialchars($aten['frequenciaResp'] ?? '') . '</td></tr>';
        $html .= '<tr><td class="label">Temperatura</td><td>' . htmlspecialchars($aten['temperatura'] ?? '') . '</td>';
        $html .= '<td class="label">Glicemia</td><td>' . htmlspecialchars($aten['glicemia'] ?? '') . '</td></tr>';
        $html .= '<tr><td class="label">SPO</td><td>' . htmlspecialchars($aten['SPO'] ?? '') . '</td>';
        $html .= '<td class="label">Classificação de risco</td><td>' . htmlspecialchars($aten['clascRisco'] ?? '') . '</td></tr>';
        $html .= '<tr><td class="label">Observação</td><td colspan="3">' . nl2br(htmlspecialchars($aten['observacao'] ?? '')) . '</td></tr>';
        $html .= '</table></div>';

        $html .= '<div class="section"><h2>Consultório (Médico)</h2>';
        $html .= '<table><tr><td class="label">Hora atendimento</td><td>' . htmlspecialchars($aten['horaC'] ?? $horaC) . '</td></tr>';
        $html .= '<tr><td class="label">Exame Clínico</td><td>' . nl2br(htmlspecialchars($aten['exameClinico'] ?? $exameClinico)) . '</td></tr>';
        $html .= '<tr><td class="label">Conduta</td><td>' . nl2br(htmlspecialchars($aten['conduta'] ?? $conduta)) . '</td></tr></table></div>';

        $html .= '<div class="section"><small>Gerado em ' . date('d/m/Y H:i') . '</small></div>';
        $html .= '</body></html>';

        // Gerar PDF com dompdf - usar autoload do composer
        $vendorAutoload = __DIR__ . '/vendor/autoload.php';
        if (!file_exists($vendorAutoload)) {
            echo "<script>alert('Erro: vendor/autoload.php não encontrado. Execute composer require dompdf/dompdf:3.1.4 em c:/xampp/htdocs/projetotcc'); history.back();</script>";
            exit;
        }

        // remover qualquer saída anterior que possa corromper o PDF
        while (ob_get_level()) {
            ob_end_clean();
        }
        @ini_set('display_errors', '0');
        error_reporting(0);

        // carregar autoload do composer
        $vendorAutoload = __DIR__ . '/vendor/autoload.php';
        if (!file_exists($vendorAutoload)) {
            file_put_contents(__DIR__ . '/dompdf_debug.txt', "vendor/autoload.php não encontrado\n", FILE_APPEND);
            echo "<script>alert('Erro: vendor/autoload.php não encontrado. Verifique instalação do dompdf.'); history.back();</script>";
            exit;
        }
        require_once $vendorAutoload;

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);

        // salva o HTML gerado para inspeção
        //@file_put_contents(__DIR__ . '/dompdf_debug.html', $html);

        // render e captura o conteúdo do PDF em memória
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdf = $dompdf->output();

        // salva o PDF gerado para abrir localmente (debug)
        //@file_put_contents(__DIR__ . '/dompdf_last.pdf', $pdf);

        // verificar se o PDF contém o header %PDF
        if (strpos($pdf, '%PDF') === false) {
            @file_put_contents(__DIR__ . '/dompdf_debug.txt', date('c') . " - PDF gerado sem header %PDF. Tamanho: " . strlen($pdf) . "\n", FILE_APPEND);
            // também salvar início do conteúdo para inspecionar (texto legível)
            @file_put_contents(__DIR__ . '/dompdf_debug_head.txt', substr($pdf, 0, 2000));
            echo "<script>alert('Erro ao gerar PDF: verifique os arquivos dompdf_debug.html e dompdf_last.pdf na pasta do projeto.'); history.back();</script>";
            exit;
        }

        $filePath = __DIR__ . "/relatorios/relatorio_atendimento_$codAten.pdf";
        file_put_contents($filePath, $pdf);

        // Redireciona para abrir o arquivo em nova aba
        header("Location: relatorios/relatorio_atendimento_$codAten.pdf");
        exit;

        // limpar qualquer saída anterior
        while (ob_get_level()) {
            ob_end_clean();
        }
        header_remove();

        header('Content-Type: application/pdf');
        header('Content-Length: ' . strlen($pdf));
        header('Content-Disposition: inline; filename="relatorio_atendimento_' . $codAten . '.pdf"');
        echo $pdf;
        exit;
    }else {
        echo "<script>alert('Ocorreu algum erro'); location.href='restrita_medico.php';</script>";
    }
}

if (isset($_POST['excluir_atendimentoC'])) {
    $codAtenC = mysqli_real_escape_string($conn, $_POST['excluir_atendimentoC']);

    // verifica a situação antes
    $sql_check = "SELECT situacao FROM atendimentos WHERE codAten = '$codAtenC'";
    $result_check = mysqli_query($conn, $sql_check);
    $atendimento = mysqli_fetch_assoc($result_check);

    if ($atendimento && $atendimento['situacao'] === 'Na consulta') {
        // bloqueia a exclusão
        echo "<script>alert('Não é possível excluir um atendimento que está em atendimento!');history.back();</script>";
        exit;
    }
        // Buscar o codAten referente à triagem
    $res = mysqli_query($conn, "SELECT codAtenTf, codAtenf FROM consultas WHERE codCons = '$codAtenC'");
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $codAten = $row['codAtenf'];
        $codAtenT = $row['codAtenTf'];
        // Excluir da consulta
        mysqli_query($conn, "DELETE FROM consultas WHERE codCons = '$codAtenC'");

        // Excluir da triagem
        mysqli_query($conn, "DELETE FROM triagens WHERE codAtenT = '$codAtenT'");

        // Excluir do atendimento
        mysqli_query($conn, "DELETE FROM atendimentos WHERE codAten = '$codAten'");
    }
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Atendimento excluido com sucesso!!'); history.back();</script>";
    } else {
        echo "<script>alert('Não foi possivel excluir esse atendimento!!');history.back();</script>";
    }
}

if (isset($_POST['voltar_atendimentoC'])) {
    $codAten = mysqli_real_escape_string($conn, $_POST['codAten']);

    // Atualiza a situação para "esperando consulta"
    $sql = "UPDATE atendimentos SET situacao = 'Esperando consulta', CPFMf = '' WHERE codAten = '$codAten'";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Atendimento voltou para a fila de espera para consulta!'); location.href='restrita_medico.php';</script>";
    } else {
        echo "<script>alert('Erro ao voltar atendimento!'); location.href='restrita_medico.php';</script>";
    }
}
