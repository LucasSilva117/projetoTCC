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
            <p><a href="logout.php" onclick="return confirm('Tem certeza que deseja sair da conta?')">Sair</a></p>
        </div>
    </nav>
    <div class="container-md">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Editar dados do paciente
                            <button onclick="history.back()" class="btn btn-danger float-end">Voltar</button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_GET['codP'])) {
                            $paciente_id = mysqli_real_escape_string($conn, $_GET['codP']);
                            $sql = "SELECT * FROM pacientes WHERE codP='$paciente_id'";
                            $query = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($query) > 0) {

                                $paciente = mysqli_fetch_array($query);

                                $sexoP = $paciente['sexoP'];


                        ?>
                                <form action="acoespacientes.php" method="post" class="row g-3">
                                    <input type="hidden" name="codP" value="<?= $paciente['codP']; ?>">
                                    <div class="col-md-6">
                                        <label>CPF</label>
                                        <input type="text" name="CPFP" value="<?= $paciente['CPFP']; ?>" class="form-control" placeholder="Coloque o CPF" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Nome</label>
                                        <input type="text" name="nomeP" value="<?= $paciente['nomeP']; ?>" class="form-control" placeholder="Nome completo" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>RG</label>
                                        <input type="text"  name="RGP" value="<?= !empty($paciente['RGP']) ? $paciente['RGP'] : '<span class="text-danger">RG não cadastrado</span>'; ?>" class="form-control" placeholder="Insira o RG (opicional)">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Cartão Nacional da Saúde</label>
                                        <input type="text" name="CNSP" value="<?= !empty($paciente['CNSP']) ? $paciente['CNSP'] : '<span class="text-danger">CNS não cadastrado</span>'; ?>" class="form-control" placeholder="Insira o número do SUS (opicional)">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Data de nascimento</label>
                                        <input type="date" name="datanascP" value="<?= $paciente['datanascP']; ?>" class="form-control" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Idade</label>
                                        <input type="number" name="idadeP" value="<?= $paciente['idadeP']; ?>" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Telefone</label>
                                        <input type="text" name="telefoneP" value="<?= !empty($paciente['telefoneP']) ? $paciente['telefoneP'] : ''; ?>" class="form-control" placeholder="<?= !empty($paciente['telefoneP']) ? $paciente['telefoneP'] : 'Telefone não cadastrado'; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Sexo</label>
                                        <select name="sexoP" class="form-select" required>
                                            <option value="">Selecione...</option>
                                            <option value="Masculino" <?= ($sexoP == "Masculino") ? "selected" : "" ?>>Masculino</option>
                                            <option value="Feminino" <?= ($sexoP == "Feminino") ? "selected" : "" ?>>Feminino</option>
                                            <option value="Outro" <?= ($sexoP == "Outro") ? "selected" : "" ?>>Outro</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Endereço</label>
                                        <input type="text" name="enderecoP" value="<?= $paciente['enderecoP']; ?>" class="form-control" placeholder="Rua, Bairro, complemento, N°" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label>Município de residência</label>
                                        <input type="text" name="munResP" value="<?= $paciente['munResP']; ?>" class="form-control" placeholder="Iguape" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>UF</label>
                                        <input type="text" name="UFP" value="<?= $paciente['UFP']; ?>" class="form-control" placeholder="SP, RJ, PR..." required>
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