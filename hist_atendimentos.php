<?php
include('protectT.php');
include('conexao.php');

// Recebendo filtros (se existirem)
$data = $_GET['data'] ?? '';
$classificacao = $_GET['classificacao'] ?? '';
$cpf = $_GET['cpf'] ?? '';

// Montando a query base
$sql = "SELECT a.*, 
               p.*, 
               t.* 
        FROM atendimentos a
        JOIN pacientes p ON a.CPFPf = p.CPFP
        LEFT JOIN triagens t ON t.codAtenf = a.codAten
        WHERE 1=1";

// Se o filtro foi preenchido, adiciona condição
if (!empty($_GET['cpf'])) {
    $cpf = mysqli_real_escape_string($conn, $_GET['cpf']);
    $sql .= " AND p.CPFP LIKE '$cpf%'";
}

if (!empty($_GET['data'])) {
    $data = mysqli_real_escape_string($conn, $_GET['data']);
    $sql .= " AND a.dataA = '$data'";
}

if (!empty($_GET['classificacao'])) {
    $classificacao = mysqli_real_escape_string($conn, $_GET['classificacao']);
    $sql .= " AND t.clascRisco = '$classificacao'";
}

$sql .= " AND a.situacao = 'finalizado'";
// Ordenar por mais recente
$sql .= " ORDER BY a.dataA DESC";

$query = mysqli_query($conn, $sql) or die("Erro SQL: " . mysqli_error($conn));
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
            <h1 style="color: white;">Histórico de atendimentos</h1>
            <p><a href="logout.php" onclick="return confirm('Tem certeza que deseja sair da conta?')">Sair da conta</a></p>
        </div>
    </nav>

    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Atendimentos registrados
                            <button onclick="history.back()" class="btn btn-danger float-end">Voltar</button>
                        </h4>
                    </div>
                    <form method="get" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label>Data:</label>
                            <input type="date" name="data" class="form-control" value="<?= htmlspecialchars($data) ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Classificação:</label>
                            <select name="classificacao" class="form-control">
                                <option value="">-- Todas --</option>
                                <option value="vermelho" <?= $classificacao == 'vermelho' ? 'selected' : '' ?>>Vermelho</option>
                                <option value="amarelo" <?= $classificacao == 'amarelo' ? 'selected' : '' ?>>Amarelo</option>
                                <option value="verde" <?= $classificacao == 'verde' ? 'selected' : '' ?>>Verde</option>
                                <option value="azul" <?= $classificacao == 'azul' ? 'selected' : '' ?>>Azul</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>CPF:</label>
                            <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($cpf) ?>">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                            <a href="hist_atendimentos.php" class="btn btn-secondary ms-2">Limpar</a>
                        </div>
                    </form>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Data</th>
                                    <th>Hora R</th>
                                    <th>Hora T</th>
                                    <th>Classificação</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($query) > 0) {

                                    $totalAtendimentos = mysqli_num_rows($query);

                                    echo "<p>Total de registros: $totalAtendimentos</p>";
                                    while ($row = mysqli_fetch_assoc($query)): ?>
                                        <tr>
                                            <td><?= $row['codAten'] ?></td>
                                            <td><?= $row['nomeP'] ?></td>
                                            <td><?= $row['CPFP'] ?></td>
                                            <td><?= date('d/m/Y', strtotime($row['dataA'])) ?></td>
                                            <td><?= $row['horaA'] ?></td>
                                            <td><?= $row['horaT'] ?></td>
                                            <td><?= $row['clascRisco'] ?></td>
                                            <th>
                                                <a href="ver_atendimento.php?id=<?= $row['codAtenT'] ?>" class="btn btn-success btn-sm">Visualizar</a>
                                                <form action="acoespacientes.php" method="post" class="d-inline">
                                                    <button onclick="return confirm('Tem certeza que deseja excluir esse registro?')" type="submit" name="excluir_atendimentoT" value="<?= $row['codAtenT'] ?>" class="btn btn-danger btn-sm">
                                                        Excluir
                                                    </button>
                                                </form>
                                            </th>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php
                                } else {
                                ?>
                                    <p>Nenhum registro encontrado</p>
                                <?php } ?>


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