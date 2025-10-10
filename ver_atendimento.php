<?php
include('protectT.php');
include('conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restrita triagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-md">
            <h1 style="color: white;">Atendimento</h1>
            <p><a href="logout.php">Sair</a></p>
        </div>
    </nav>
    <div class="container-md">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Visualizar atendimento
                            <?php if (isset($_GET['id'])) {
                                $atendimento_id = mysqli_real_escape_string($conn, $_GET['id']);
                            ?>
                                <button onclick="history.back()" class="btn btn-danger float-end">Voltar</button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php
                                $sql = "SELECT t.*, a.*, p.* 
                                FROM atendimentos a
                                JOIN pacientes p ON a.RGSUSPf = p.RGSUSP
                                LEFT JOIN triagens t ON t.codAtenf = a.codAten 
                                WHERE t.codAtenT = '$atendimento_id'";
                                $query = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($query) > 0) {

                                    $aten = mysqli_fetch_array($query);
                                    $codAtenT = $aten['codAtenT'];
                                    $sexoP = $aten['sexoP'];


                        ?>
                        <h4>Dados do paciente</h4>
                        <form action="" method="post" class="row g-3">
                            <div class="col-md-6">
                                <label>RG/SUS</label>
                                <p class="form-control">
                                    <?= $aten['RGSUSP']; ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label>Nome</label>
                                <p class="form-control">
                                    <?= $aten['nomeP']; ?>
                                </p>
                            </div>
                            <div class="col-md-2">
                                <label>Data de nascimento</label>
                                <p class="form-control">
                                    <?= date('d/m/Y', strtotime($aten['datanascP'])) ?>
                                </p>
                            </div>
                            <div class="col-md-2">
                                <label>Idade</label>
                                <p class="form-control">
                                    <?= $aten['idadeP']; ?>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label>Telefone</label>
                                <p class="form-control">
                                    <?= !empty($aten['telefoneP']) ? $aten['telefoneP'] : '<span class="text-danger">Telefone não cadastrado</span>'; ?>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label>Sexo</label>
                                <p class="form-control">
                                    <?= $aten['sexoP']; ?>
                                </p>
                            </div>
                            <div class="col-md-12">
                                <label>Endereço</label>
                                <p class="form-control">
                                    <?= $aten['enderecoP']; ?>
                                </p>
                            </div>
                            <div class="col-md-8">
                                <label>Município de residência</label>
                                <p class="form-control">
                                    <?= $aten['munResP']; ?>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label>UF</label>
                                <p class="form-control">
                                    <?= $aten['UFP']; ?>
                                </p>
                            </div>
                        </form>

                        <!--Àrea do atendimento-->
                        <!--O horario do atendimento é a hora que o paciente entrou-->
                        <div class="container-sm">
                            <h4 class="mb-4">Enfermagem</h4>
                        </div>
                        <div>
                            <form action="acoespacientes.php" method="post"
                                class="row g-3 border border-2 border-secondary">
                                <input type="hidden" name="codAten" value="<?= $atendimento_id ?>">
                                <div class="col-md-1">
                                    <label>Diarréia?</label>
                                    <p class="form-control">
                                        <?=$aten['temDiarreia'];?>
                                    </p>
                                </div>
                                <div class="col-md-2">
                                    <label>Data de início dos sintomas</label>
                                    <p class="form-control">
                                        <?=date('d/m/Y', strtotime($aten['tempoSintomas']))?>
                                    </p>
                                </div>
                                <div class="col-md-1">
                                    <label>Tem alergia?</label>
                                    <p class="form-control">
                                        <?=$aten['temAlergia'];?>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <label>Se sim, à que?</label>
                                    <p class="form-control">
                                        <?= !empty($aten['alergiaAque']) ? $aten['alergiaAque'] : '<span class="text-danger">Não tem alergia</span>'; ?>
                                    </p>
                                </div>
                                <div class="col-md-2">
                                    <label>Tosse a mais de 3 semanas?</label>
                                    <p class="form-control">
                                        <?=$aten['tosseMais3sem'];?>
                                    </p>
                                </div>
                                <div class="col-md-2">
                                    <label>Colheu BK?</label>
                                    <p class="form-control">
                                        <?=$aten['colheuBK'];?>
                                    </p>
                                </div>
                                <div class="col-md-1">
                                    <label>PA:</label>
                                    <p class="form-control">
                                        <?=$aten['pressaoArterial'];?>
                                    </p>
                                </div>
                                <div class="col-md-1">
                                    <label>Pulso:</label>
                                    <p class="form-control">
                                        <?=$aten['pulso'];?>
                                    </p>                                
                                </div>
                                <div class="col-md-1">
                                    <label>F/R:</label>
                                    <p class="form-control">
                                        <?=$aten['frequenciaResp'];?>
                                    </p>
                                </div>
                                <div class="col-md-1">
                                    <label>Tax:</label>
                                    <p class="form-control">
                                        <?=$aten['temperatura'];?>
                                    </p>
                                </div>
                                <div class="col-md-1">
                                    <label>Glicemia:</label>
                                    <p class="form-control">
                                        <?=$aten['glicemia'];?>
                                    </p>
                                </div>
                                <div class="col-md-1">
                                    <label>SPO:</label>
                                    <p class="form-control">
                                        <?=$aten['SPO'];?>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <label>Classificação de risco:</label> <br>
                                    <p class="form-control">
                                        <?=$aten['clascRisco'];?>
                                    </p>
                                </div>
                                <div class="col-md-2">
                                    <label>Peso:</label>
                                    <p class="form-control">
                                        <?=$aten['peso'];?>
                                    </p>
                                </div>
                                <div class="col-md-2">
                                    <label>Hora do atendimento</label>
                                    <p class="form-control">
                                        <?=$aten['horaT']?>
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <label>Situação / Queixa / Histórico (medicações usuais)</label> <br>
                                    <p class="form-control">
                                        <?=$aten['observacao'];?>
                                    </p>
                                </div>






                            </form>
                        </div>
                        <?php
                                }
                            } else {
                                echo "<h5>Paciente não identificado</h5>";
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
        document.getElementById("hora").value = `${horas}:${minutos}`;
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</body>

</html>