<?php
include('protectA.php');
include('conexao.php');

// Recebendo filtros (se existirem)
$cpf = $_GET['cpf'] ?? '';
$nome = $_GET['nome'] ?? '';
$sexo = $_GET['sexo'] ?? '';
$funcao = $_GET['funcao'] ?? '';

// Montando a query base unificada com UNION ALL
$sql = "
    SELECT nomeE AS nome, CPFE AS cpf, sexoE AS sexo, 'Enfermeiro' AS funcao, idadeE AS idade, datanascE AS datanasc FROM enfermeiros
    UNION ALL
    SELECT nomeM AS nome, CPFM AS cpf, sexoM AS sexo, 'Médico' AS funcao, idadeM AS idade, datanascM AS datanasc FROM medicos
    UNION ALL
    SELECT nomeR AS nome, CPFR AS cpf, sexoR AS sexo, 'Recepcionista' AS funcao, idadeR AS idade, datanascR AS datanasc FROM recepcionistas
";

// Agora criamos o filtro geral
$sql = "SELECT * FROM ($sql) AS todos WHERE 1=1";

// Aplicando filtros se existirem
if (!empty($cpf)) {
    $cpf = mysqli_real_escape_string($conn, $cpf);
    $sql .= " AND cpf LIKE '$cpf%'";
}

if (!empty($nome)) {
    $nome = mysqli_real_escape_string($conn, $nome);
    $sql .= " AND nome LIKE '$nome%'";
}

if (!empty($sexo)) {
    $sexo = mysqli_real_escape_string($conn, $sexo);
    $sql .= " AND sexo = '$sexo'";
}

if (!empty($funcao)) {
    $funcao = mysqli_real_escape_string($conn, $funcao);
    $sql .= " AND funcao = '$funcao'";
}

// Ordenar por nome (ou qualquer outro campo)
$sql .= " ORDER BY nome ASC";

$query = mysqli_query($conn, $sql) or die("Erro SQL: " . mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restrita Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-md">
            <h1 style="color: white;">Gerenciamento de funcionários</h1>
            <p><a href="logout.php">Sair da conta</a></p>
        </div>
    </nav>

    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Funcionários registrados
                            <button onclick="history.back()" class="btn btn-danger float-end">Voltar</button>
                        </h4>
                    </div>
                    <form method="get" class="row g-3 mb-4">
                        <div class="col-md-2">
                            <label>CPF:</label>
                            <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($cpf) ?>">
                        </div>
                        <div class="col-md-3">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($nome) ?>">
                        </div>
                        <div class="col-md-2">
                            <label>Sexo:</label>
                            <select name="sexo" class="form-control">
                                <option value="">-- Todos --</option>
                                <option value="Masculino" <?= $sexo == 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                                <option value="Feminino" <?= $sexo == 'Feminino' ? 'selected' : '' ?>>Feminino</option>
                                <option value="Outro" <?= $sexo == 'Outro' ? 'selected' : '' ?>>Outro</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Função:</label>
                            <select name="funcao" class="form-control">
                                <option value="">-- Todos --</option>
                                <option value="Enfermeiro" <?= $funcao == 'Enfermeiro' ? 'selected' : '' ?>>Enfermeiro</option>
                                <option value="Médico" <?= $funcao == 'Médico' ? 'selected' : '' ?>>Médico</option>
                                <option value="Recepcionista" <?= $funcao == 'Recepcionista' ? 'selected' : '' ?>>Recepcionista</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                            <a href="lista_funcionarios.php" class="btn btn-secondary ms-2">Limpar</a>
                        </div>
                        <div class="col-md-4">
                            <a href="cad_funcionario.php" class="btn btn-success">Cadastrar novo funcionário</a>
                        </div>
                    </form>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>CPF</th>
                                    <th>Nome</th>
                                    <th>idade</th>
                                    <th>Sexo</th>
                                    <th>Função</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php 
                                if (mysqli_num_rows($query) > 0) {

                                    $totalFuncionarios = mysqli_num_rows($query);

                                    echo "<p>Total de registros: $totalFuncionarios</p>";
                                    while ($row = mysqli_fetch_assoc($query)): ?>

                                <tr>
                                    <td><?=$row['cpf']?></td>
                                    <td><?=$row['nome']?></td>
                                    <td><?=$row['idade']?></td>
                                    <td><?=$row['sexo']?></td>
                                    <td><?=$row['funcao']?></td>
                                    <td>
                                        <a href="ver_funcionario.php?cpf=<?=$row['cpf']?>&funcao=<?=$row['funcao']?>" class="btn btn-success btn-sm">Visualizar e editar</a>                                        
                                        <form action="funcionarios.php" method="post" class="d-inline">
                                            <button onclick="return confirm('Tem certeza que deseja excluir esse funcionário?')" type="submit" name="excluir_paciente" value="<?=$row['cpf']?>" class="btn btn-danger btn-sm">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php 
                                } else{
                                    echo '<h5>Nenhum funcionário registrado</h5>';
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