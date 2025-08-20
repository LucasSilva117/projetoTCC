<?php
include('protectR.php');
include('conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restrita recepcionista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-md">
            <h1 style="color: white;">Editar paciente</h1>
            <p><a href="logout.php">Sair</a></p>
        </div>
    </nav>
    <div class="container-md">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Editar dados do paciente
                            <a href="javascript:history.back()" class="btn btn-danger float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_GET['id'])) {
                            $paciente_id = mysqli_real_escape_string($conn, $_GET['id']);
                            $sql = "SELECT * FROM pacientes WHERE id='$paciente_id'";
                            $query = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($query) > 0) {
                                //erro aqui, nao ta chegando o sexoP
                                $paciente = mysqli_fetch_array($query);
                                
                                $sexoP = $paciente['sexoP'];


                        ?>
                                <form action="acoespacientes.php" method="post" class="row g-3">
                                    <input type="hidden" name="id" value="<?=$paciente['id'];?>">
                                    <div class="col-md-6">
                                        <label>RG/SUS</label>
                                        <input type="text" name="RGSUSP" value="<?=$paciente['RGSUSP'];?>" class="form-control" placeholder="N° RG ou N° SUS" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Nome</label>
                                        <input type="text" name="nomeP" value="<?=$paciente['nomeP'];?>" class="form-control" placeholder="Nome completo" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Data de nascimento</label>
                                        <input type="date" name="datanascP" value="<?=$paciente['datanascP'];?>" class="form-control" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Idade</label>
                                        <input type="number" name="idadeP" value="<?=$paciente['idadeP'];?>" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Telefone</label>
                                        <input type="text" name="telefoneP" value="<?= !empty($paciente['telefoneP']) ? $paciente['telefoneP'] : ''; ?>" class="form-control" placeholder="<?= !empty($paciente['telefoneP']) ? $paciente['telefoneP'] : 'Telefone não cadastrado'; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Sexo</label>
                                        <select name="sexoP" class="form-select" required>
                                            <option value="">Selecione...</option>
                                            <option value="Masculino" <?= ($sexoP == "masculino") ? "selected" : "" ?>>Masculino</option>
                                            <option value="Feminino" <?= ($sexoP == "Feminino") ? "selected" : "" ?>>Feminino</option>
                                            <option value="Outro" <?= ($sexoP == "Outro") ? "selected" : "" ?>>Outro</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Endereço</label>
                                        <input type="text" name="enderecoP" value="<?=$paciente['enderecoP'];?>" class="form-control" placeholder="Rua, Bairro, complemento, N°" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label>Município de residência</label>
                                        <input type="text" name="munResP" value="<?=$paciente['munResP'];?>" class="form-control" placeholder="Iguape" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>UF</label>
                                        <input type="text" name="UFP" value="<?=$paciente['UFP'];?>" class="form-control" placeholder="SP, RJ, PR..." required>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" name="editar_paciente" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
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