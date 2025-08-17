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
            <h1 style="color: white;">Visualizar paciente</h1>
            <p><a href="logout.php">Sair</a></p>
        </div>
    </nav>
    <div class="container-md">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Dados do paciente
                            <a href="lista_pacientes.php" class="btn btn-danger float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row row-g3">
                        <?php 
                        if(isset($_GET['id'])){
                            $paciente_id = mysqli_real_escape_string($conn, $_GET['id']);
                            $sql = "SELECT * FROM pacientes WHERE id='$paciente_id'";
                            $query = mysqli_query($conn, $sql);

                            if(mysqli_num_rows($query) > 0){
                                $paciente = mysqli_fetch_array($query);

                        ?>
                        <div class="col-md-6">
                            <label>RG/SUS</label>
                            <p class="form-control">
                                <?=$paciente['RGSUSP'];?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label>Nome</label>
                            <p class="form-control">
                                <?=$paciente['nomeP'];?>
                            </p>
                        </div>
                        <div class="col-md-2">
                            <label>Data de nascimento</label>
                            <p class="form-control">
                                <?=date('d/m/Y', strtotime($paciente['datanascP']))?>
                            </p>
                        </div>
                        <div class="col-md-2">
                            <label>Idade</label>
                            <p class="form-control">
                                <?=$paciente['idadeP'];?>
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
                                <?=$paciente['sexoP'];?>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <label>Endereço</label>
                            <p class="form-control">
                                <?=$paciente['enderecoP'];?>
                            </p>
                        </div>
                        <div class="col-md-8">
                            <label>Município de residência</label>
                            <p class="form-control">
                                <?=$paciente['munResP'];?>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <label>UF</label>
                            <p class="form-control">
                                <?=$paciente['UFP'];?>
                            </p>
                        </div>
                        <?php 
                            }
                        } else{
                            echo "<h5>Paciente não identificado</h5>";
                        }
                        ?>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>