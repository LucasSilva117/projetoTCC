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
            <h1 style="color: white;">Lista de pacientes</h1>
            <p><a href="logout.php">Sair da conta</a></p>
        </div>
    </nav>

    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Pacientes registrados
                            <a href="restrita_recepcao.php" class="btn btn-danger float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>RG/SUS</th>
                                    <th>Nome</th>
                                    <th>idade</th>
                                    <th>DN</th>
                                    <th>Sexo</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php 
                                $sql = 'SELECT * FROM pacientes ORDER BY id DESC';
                                $pacientes = mysqli_query($conn, $sql);
                                
                                if(mysqli_num_rows($pacientes) > 0){
                                    foreach($pacientes as $paciente) {
                                ?>

                                <tr>
                                    <td><?=$paciente['RGSUSP']?></td>
                                    <td><?=$paciente['nomeP']?></td>
                                    <td><?=$paciente['idadeP']?></td>
                                    <td><?=date('d/m/Y', strtotime($paciente['datanascP']))?></td>
                                    <td><?=$paciente['sexoP']?></td>
                                    <td>
                                        <a href="ver_paciente.php?id=<?=$paciente['id']?>" class="btn btn-success btn-sm">Visualizar e editar</a>                                        
                                        <form action="acoespacientes.php" method="post" class="d-inline">
                                            <button onclick="return confirm('Tem certeza que deseja excluir esse paciente?')" type="submit" name="excluir_paciente" value="<?=$paciente['id']?>" class="btn btn-danger btn-sm">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php 
                                    }
                                } else{
                                    echo '<h5>Nenhum paciente registrado</h5>';
                                }
                                ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>