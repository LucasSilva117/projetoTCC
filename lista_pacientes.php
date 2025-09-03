<?php
include('protectR.php');
include('conexao.php');

// Recebendo filtros (se existirem)
$rg = $_GET['rg'] ?? '';
$nome = $_GET['nome'] ?? '';
$sexo = $_GET['sexo'] ?? '';

// Montando a query base
$sql = "SELECT *
        FROM pacientes
        WHERE 1=1";

// Se o filtro foi preenchido, adiciona condição
if (!empty($_GET['rg'])) {
    $rg = mysqli_real_escape_string($conn, $_GET['rg']);
    $sql .= " AND RGSUSP LIKE '$rg%'";
}

if (!empty($_GET['nome'])) {
    $nome = mysqli_real_escape_string($conn, $_GET['nome']);
    $sql .= " AND nomeP LIKE '$nome%'";
}

if (!empty($_GET['sexo'])) {
    $idade = mysqli_real_escape_string($conn, $_GET['sexo']);
    $sql .= " AND sexoP = '$sexo'";
}

// Ordenar por mais recente
$sql .= " ORDER BY id DESC";

$query = mysqli_query($conn, $sql) or die("Erro SQL: " . mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restrita recepção</title>
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
                    <form method="get" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label>RG:</label>
                            <input type="text" name="rg" class="form-control" value="<?= htmlspecialchars($rg) ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($nome) ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Sexo:</label>
                            <select name="sexo" class="form-control">
                                <option value="">-- Todos --</option>
                                <option value="Masculino" <?= $sexo == 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                                <option value="Feminino" <?= $sexo == 'Feminino' ? 'selected' : '' ?>>Feminino</option>
                                <option value="Outro" <?= $sexo == 'Outro' ? 'selected' : '' ?>>Outro</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                            <a href="lista_pacientes.php" class="btn btn-secondary ms-2">Limpar</a>
                        </div>
                    </form>
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
                                if (mysqli_num_rows($query) > 0) {

                                    $totalAtendimentos = mysqli_num_rows($query);

                                    echo "<p>Total de registros: $totalAtendimentos</p>";
                                    while ($row = mysqli_fetch_assoc($query)): ?>

                                <tr>
                                    <td><?=$row['RGSUSP']?></td>
                                    <td><?=$row['nomeP']?></td>
                                    <td><?=$row['idadeP']?></td>
                                    <td><?=date('d/m/Y', strtotime($row['datanascP']))?></td>
                                    <td><?=$row['sexoP']?></td>
                                    <td>
                                        <a href="ver_paciente.php?id=<?=$row['id']?>" class="btn btn-success btn-sm">Visualizar e editar</a>                                        
                                        <form action="acoespacientes.php" method="post" class="d-inline">
                                            <button onclick="return confirm('Tem certeza que deseja excluir esse paciente?')" type="submit" name="excluir_paciente" value="<?=$row['id']?>" class="btn btn-danger btn-sm">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php 
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