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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

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
                        <h4>Atender paciente
                            <a href="javascript:history.back()" class="btn btn-danger float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_GET['rg'])) {
                            $paciente_id = mysqli_real_escape_string($conn, $_GET['rg']);
                            $sql = "SELECT a.*, p.* FROM atendimentos a JOIN pacientes p ON a.RGSUSPf = p.RGSUSP";
                            $query = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($query) > 0) {

                                $paciente = mysqli_fetch_array($query);

                                $sexoP = $paciente['sexoP'];


                        ?>
                                <h4>Dados do paciente</h4>
                                <form action="" method="post" class="row g-3">
                                    <div class="col-md-6">
                                        <label>RG/SUS</label>
                                        <p class="form-control">
                                            <?= $paciente['RGSUSP']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Nome</label>
                                        <p class="form-control">
                                            <?= $paciente['nomeP']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Data de nascimento</label>
                                        <p class="form-control">
                                            <?= date('d/m/Y', strtotime($paciente['datanascP'])) ?>
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Idade</label>
                                        <p class="form-control">
                                            <?= $paciente['idadeP']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Telefone</label>
                                        <p class="form-control">
                                            <?= !empty($paciente['telefoneP']) ? $paciente['telefoneP'] : '<span class="text-danger">Telefone não cadastrado</span>'; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Sexo</label>
                                        <p class="form-control">
                                            <?= $paciente['sexoP']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Endereço</label>
                                        <p class="form-control">
                                            <?= $paciente['enderecoP']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-8">
                                        <label>Município de residência</label>
                                        <p class="form-control">
                                            <?= $paciente['munResP']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <label>UF</label>
                                        <p class="form-control">
                                            <?= $paciente['UFP']; ?>
                                        </p>
                                    </div>
                                </form>

                                <!--Àrea do atendimento-->
                                <!--O horario do atendimento é a hora que o paciente entrou, logo coloca um input pré-selecionado com o horário atual de quando a página-->
                                <div class="container-sm">
                                    <h4 class="mb-4">Enfermagem</h4>
                                </div>
                                <div>
                                    <form action="acoespacientes.php" method="post" class="row g-3 border border-2 border-secondary">
                                        <div class="col-md-1">
                                            <label>Diarréia?</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="temDiarreia" value="Sim">
                                                <label class="form-check-label">
                                                    Sim
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="temDiarreia" value="Nao">
                                                <label class="form-check-label">
                                                    Não
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Data de início dos sintomas</label>
                                            <input type="date" name="tempoSintomas" class="form-control" placeholder="Nome completo" required>
                                        </div>
                                        <div class="col-md-1">
                                            <label>Tem alergia?</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="temAlergia" value="Sim">
                                                <label class="form-check-label">
                                                    Sim
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="temAlergia" value="Nao">
                                                <label class="form-check-label">
                                                    Não
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Se sim, à que?</label>
                                            <input type="text" name="alergiaAque" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Tosse a mais de 3 semanas?</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="tosseMais3sem" value="Sim">
                                                <label class="form-check-label">
                                                    Sim
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="tosseMais3sem" value="Nao">
                                                <label class="form-check-label">
                                                    Não
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Colheu BK?</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="colheuBK" value="Sim">
                                                <label class="form-check-label">
                                                    Sim
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="colheuBK" value="Nao">
                                                <label class="form-check-label">
                                                    Não
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label>PA:</label>
                                            <input type="text" name="pressaoArterial" class="form-control" placeholder="12x8" required>
                                        </div>
                                        <div class="col-md-1">
                                            <label>Pulso:</label>
                                            <input type="text" name="pulso" class="form-control" placeholder="b/m" required>
                                        </div>
                                        <div class="col-md-1">
                                            <label>F/R:</label>
                                            <input type="text" name="frequenciaResp" class="form-control" placeholder="r/m" required>
                                        </div>
                                        <div class="col-md-1">
                                            <label>Tax:</label>
                                            <input type="text" name="temperatura" class="form-control" placeholder="°C" required>
                                        </div>
                                        <div class="col-md-1">
                                            <label>Glicemia:</label>
                                            <input type="text" name="glicemia" class="form-control" placeholder="mg/dl" required>
                                        </div>
                                        <div class="col-md-1">
                                            <label>SPO:</label>
                                            <input type="text" name="SPO" class="form-control" placeholder="%" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Classificação de risco:</label> <br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" value="">
                                                <label class="form-check-label">Vermelho</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" value="option2">
                                                <label class="form-check-label" for="inlineRadio2">Amarelo</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" value="">
                                                <label class="form-check-label">Verde</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" value="option2">
                                                <label class="form-check-label" for="inlineRadio2">Azul</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Peso:</label>
                                            <input type="text" name="peso" class="form-control" placeholder="100,5Kg" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Hora do atendimento</label>
                                            <input type="time" name="hora" class="form-control" id="hora" required>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Situação / Queixa / Histórico (medicações usuais)</label> <br>
                                            <textarea name="observacao" rows="10" cols="150" class="form-control"></textarea>
                                        </div>


                                        <div class="mb-3">
                                            <button type="submit" name="atender_paciente" class="btn btn-primary">Salvar</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>