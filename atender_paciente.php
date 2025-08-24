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
                                <h4>Enfermagem</h4>
                                <div>
                                    <form action="acoespacientes.php" method="post" class="row g-3">
                                        <div class="col-md-6">
                                            <label>RG/SUS</label>
                                            <input type="text" name="RGSUSP" class="form-control" placeholder="N° RG ou N° SUS" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Nome</label>
                                            <input type="text" name="nomeP" class="form-control" placeholder="Nome completo" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Data de nascimento</label>
                                            <input type="date" name="datanascP" class="form-control" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Idade</label>
                                            <input type="number" name="idadeP" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Telefone</label>
                                            <input type="text" name="telefoneP" class="form-control" placeholder="1399999999">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Sexo</label>
                                            <select name="sexoP" class="form-select" required>
                                                <option value="">Selecione...</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Feminino">Feminino</option>
                                                <option value="Outro">Outro</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Endereço</label>
                                            <input type="text" name="enderecoP" class="form-control" placeholder="Rua, Bairro, complemento, N°" required>
                                        </div>
                                        <div class="col-md-8">
                                            <label>Município de residência</label>
                                            <input type="text" name="munResP" class="form-control" placeholder="Iguape" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>UF</label>
                                            <input type="text" name="UFP" class="form-control" placeholder="SP, RJ, PR..." required>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" name="cadastrar_paciente" class="btn btn-primary">Salvar</button>
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



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>