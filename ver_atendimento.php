<?php
include('protectT.php');
include('conexao.php');

// aceitar codCons ou codAten
$atendimento_id = null;
if (!empty($_GET['codCons'])) {
    $atendimento_id = mysqli_real_escape_string($conn, trim($_GET['codCons']));
} elseif (!empty($_GET['codAten'])) {
    $atendimento_id = mysqli_real_escape_string($conn, trim($_GET['codAten']));
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver atendimento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <style>
        .navbar {
            padding-top: 0;
            padding-bottom: 0;
            height: 90px;
            display: flex;
            align-items: center;
        }

        .logo {
            height: 80px;
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container-md d-flex justify-content-between align-items-center">

            <div class="d-flex align-items-center">
                <img src="sefapslogo.png" alt="logo do hospital" class="logo" />
                <h1 style="color: white; margin: 0 0 0 10px;">Visualizar atendimento</h1>
            </div>

            <p style="margin: 0;">
                <a href="logout.php" onclick="return confirm('Tem certeza que deseja sair da conta?')">
                    Sair da conta
                </a>
            </p>

        </div>
    </nav>
    <div class="container-md">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Visualizar atendimento
                            <?php if ($atendimento_id): ?>
                                <button onclick="history.back()" class="btn btn-danger float-end">Voltar</button>
                            <?php endif; ?>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if (!$atendimento_id) {
                            echo "<h5>Atendimento não identificado</h5>";
                        } else {
                            $sql = "SELECT c.*, t.*, a.*, p.* 
                                FROM atendimentos a
                                JOIN pacientes p ON a.CPFPf = p.CPFP
                                LEFT JOIN triagens t ON t.codAtenf = a.codAten 
                                LEFT JOIN consultas c ON c.codAtenf = a.codAten
                                WHERE (c.codCons = '$atendimento_id' OR a.codAten = '$atendimento_id')
                                LIMIT 1";
                            $query = mysqli_query($conn, $sql);
                            if (!$query) {
                                die('Erro SQL: ' . mysqli_error($conn));
                            }
                            if (mysqli_num_rows($query) > 0) {
                                $aten = mysqli_fetch_assoc($query);
                                // garantir índices existentes antes de uso
                                $codAtenT = $aten['codAtenT'] ?? null;
                                $sexoP = $aten['sexoP'] ?? null;
                        ?>
                                <h4>Dados do paciente</h4>
                                <form action="" method="post" class="row g-3">
                                    <div class="col-md-6">
                                        <label>CPF</label>
                                        <p class="form-control"><?= htmlspecialchars($aten['CPFP'] ?? '') ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Nome</label>
                                        <p class="form-control"><?= htmlspecialchars($aten['nomeP'] ?? '') ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>RG</label>
                                        <p class="form-control"><?= !empty($aten['RGP']) ? htmlspecialchars($aten['RGP']) : '<span class="text-danger">RG não cadastrado</span>' ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Cartão Nacional da Saúde</label>
                                        <p class="form-control"><?= !empty($aten['CNSP']) ? htmlspecialchars($aten['CNSP']) : '<span class="text-danger">CNS não cadastrado</span>' ?></p>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Data de nascimento</label>
                                        <p class="form-control"><?= !empty($aten['datanascP']) ? date('d/m/Y', strtotime($aten['datanascP'])) : '' ?></p>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Idade</label>
                                        <p class="form-control"><?= htmlspecialchars($aten['idadeP'] ?? '') ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Telefone</label>
                                        <p class="form-control"><?= !empty($aten['telefoneP']) ? htmlspecialchars($aten['telefoneP']) : '<span class="text-danger">Telefone não cadastrado</span>' ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Sexo</label>
                                        <p class="form-control"><?= htmlspecialchars($aten['sexoP'] ?? '') ?></p>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Endereço</label>
                                        <p class="form-control"><?= htmlspecialchars($aten['enderecoP'] ?? '') ?></p>
                                    </div>
                                    <div class="col-md-8">
                                        <label>Município de residência</label>
                                        <p class="form-control"><?= htmlspecialchars($aten['munResP'] ?? '') ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <label>UF</label>
                                        <p class="form-control"><?= htmlspecialchars($aten['UFP'] ?? '') ?></p>
                                    </div>
                                </form>

                                <!-- Área do atendimento -->
                                <div class="container-sm">
                                    <h4 class="mb-4">Enfermagem</h4>
                                </div>
                                <div>
                                    <form action="acoespacientes.php" method="post" class="row g-3 ">
                                        <input type="hidden" name="codAten" value="<?= htmlspecialchars($atendimento_id) ?>">
                                        <div class="col-md-1">
                                            <label>Diarréia?</label>
                                            <p class="form-control"><?= htmlspecialchars($aten['temDiarreia'] ?? '') ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Data de início dos sintomas</label>
                                            <p class="form-control"><?= !empty($aten['tempoSintomas']) ? date('d/m/Y', strtotime($aten['tempoSintomas'])) : '' ?></p>
                                        </div>
                                        <div class="col-md-1">
                                            <label>Tem alergia?</label>
                                            <p class="form-control"><?= htmlspecialchars($aten['temAlergia'] ?? '') ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Se sim, à que?</label>
                                            <p class="form-control"><?= !empty($aten['alergiaAque']) ? htmlspecialchars($aten['alergiaAque']) : '<span class="text-danger">Não tem alergia</span>' ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Tosse a mais de 3 semanas?</label>
                                            <p class="form-control"><?= htmlspecialchars($aten['tosseMais3sem'] ?? '') ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Colheu BK?</label>
                                            <p class="form-control"><?= htmlspecialchars($aten['colheuBK'] ?? '') ?></p>
                                        </div>
                                        <div class="col-md-1">
                                            <label>PA:</label>
                                            <p class="form-control"><?= htmlspecialchars($aten['pressaoArterial'] ?? '') ?></p>
                                        </div>
                                        <div class="col-md-1">
                                            <label>Pulso:</label>
                                            <p class="form-control"><?= htmlspecialchars($aten['pulso'] ?? '') ?></p>
                                        </div>
                                        <div class="col-md-1">
                                            <label>F/R:</label>
                                            <p class="form-control"><?= htmlspecialchars($aten['frequenciaResp'] ?? '') ?></p>
                                        </div>
                                        <div class="col-md-1">
                                            <label>Tax:</label>
                                            <p class="form-control"><?= htmlspecialchars($aten['temperatura'] ?? '') ?></p>
                                        </div>
                                        <div class="col-md-1">
                                            <label>Glicemia:</label>
                                            <p class="form-control"><?= htmlspecialchars($aten['glicemia'] ?? '') ?></p>
                                        </div>
                                        <div class="col-md-1">
                                            <label>SPO:</label>
                                            <p class="form-control"><?= htmlspecialchars($aten['SPO'] ?? '') ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Classificação de risco:</label> <br>
                                            <p class="form-control"><?= htmlspecialchars($aten['clascRisco'] ?? '') ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Peso:</label>
                                            <p class="form-control"><?= htmlspecialchars($aten['peso'] ?? '') ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Hora do atendimento</label>
                                            <p class="form-control"><?= htmlspecialchars($aten['horaT'] ?? '') ?></p>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Situação / Queixa / Histórico (medicações usuais)</label> <br>
                                            <p class="form-control"><?= nl2br(htmlspecialchars($aten['observacao'] ?? '')) ?></p>
                                        </div>
                                        </form>
                                        <div class="container-sm">
                                            <h4 class="mb-4">Consultório</h4>
                                        </div>

                                        <div class="row g-3 ">
                                            <div class="col-md-6">
                                                <label>Hora do atendimento (Médico)</label>
                                                <p class="form-control"><?= htmlspecialchars($aten['horaC'] ?? '') ?></p>
                                            </div>

                                            <div class="col-md-12">
                                                <label>Exame Clínico</label>
                                                <p class="form-control"><?= nl2br(htmlspecialchars($aten['exameClinico'] ?? '')) ?></p>
                                            </div>

                                            <div class="col-md-12">
                                                <label>Conduta</label>
                                                <p class="form-control"><?= nl2br(htmlspecialchars($aten['conduta'] ?? '')) ?></p>
                                            </div>
                                        </div>
                                    
                                </div>
                        <?php
                            } else {
                                echo "<h5>Atendimento não identificado</h5>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        window.addEventListener("load", function() {
            let agora = new Date();
            let horas = String(agora.getHours()).padStart(2, '0');
            let minutos = String(agora.getMinutes()).padStart(2, '0');
            const horaEl = document.getElementById("hora");
            if (horaEl) horaEl.value = `${horas}:${minutos}`;
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</body>

</html>