<?php
include('protectA.php');
include('conexao.php');

// Verifica se recebeu CPF e função
if (!isset($_GET['cpf']) || !isset($_GET['funcao'])) {
    die("Parâmetros inválidos.");
}

$cpf = mysqli_real_escape_string($conn, $_GET['cpf']);
$funcao = mysqli_real_escape_string($conn, $_GET['funcao']);

// Define qual tabela buscar
switch ($funcao) {
    case 'medico':
        $tabela = 'medicos';
        $sufixo = 'M';
        $campo_cpf = 'CPFM';
        break;
    case 'enfermeiro':
        $tabela = 'enfermeiros';
        $sufixo = 'E';
        $campo_cpf = 'CPFE';
        break;
    case 'recepcionista':
        $tabela = 'recepcionistas';
        $sufixo = 'R';
        $campo_cpf = 'CPFR';
        break;
    default:
        die("Função inválida.");
}


// Consulta para preencher os campos
$sql = "SELECT * FROM $tabela WHERE $campo_cpf = '$cpf'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 0) {
    die("Funcionário não encontrado.");
}
$funcionario = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar <?= htmlspecialchars($funcao) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-md">
            <h1 class="text-white">Editar <?= htmlspecialchars($funcao) ?></h1>
            <p><a href="logout.php" onclick="return confirm('Tem certeza que deseja sair da conta?')">Sair</a></p>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Editar dados do <?= htmlspecialchars($funcao) ?>
                    <button onclick="history.back()" class="btn btn-danger float-end">Voltar</button>
                </h4>
            </div>
            <div class="card-body">
                <form method="post" action="funcionarios.php?acao=editar">
                    <input type="hidden" name="cpf" value="<?= htmlspecialchars($cpf) ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>CPF</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($cpf) ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control"
                                value="<?= htmlspecialchars($funcionario['nome' . $sufixo]) ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label>Data de Nascimento</label>
                            <input type="date" name="datanasc" class="form-control"
                                value="<?= htmlspecialchars($funcionario['datanasc' . $sufixo] ?? '') ?>">
                        </div>

                        <div class="col-md-4">
                            <label>Idade</label>
                            <input type="number" name="idade" class="form-control"
                                value="<?= htmlspecialchars($funcionario['idade' . $sufixo]) ?>">
                        </div>

                        <div class="col-md-2">
                            <label>Telefone</label>
                            <input type="text" name="telefone" class="form-control"
                                value=<?= htmlspecialchars($funcionario['telefone' . $sufixo]) ?>>
                        </div>

                        <div class="col-md-2">
                            <label>Sexo</label>
                            <select name="sexo" class="form-control">
                                <option value="Masculino"
                                    <?= $funcionario['sexo' . $sufixo] === 'Masculino' ? 'selected' : '' ?>>Masculino
                                </option>
                                <option value="Feminino"
                                    <?= $funcionario['sexo' . $sufixo] === 'Feminino' ? 'selected' : '' ?>>Feminino
                                </option>
                                <option value="Outro"
                                    <?= $funcionario['sexo' . $sufixo] === 'Outro' ? 'selected' : '' ?>>Outro</option>
                            </select>
                        </div>

                        <?php if ($funcao === 'medico'): ?>
                        <input type="hidden" name="funcao" value="medico">
                        <div class="col-md-4">
                            <label>CRM</label>
                            <input type="text" name="crm" class="form-control"
                                value="<?= htmlspecialchars($funcionario['CRM']) ?>">
                        </div>
                        <div class="col-md-8">
                            <label>Especialidade</label>
                            <input type="text" name="especialidade" class="form-control"
                                value="<?= htmlspecialchars($funcionario['especialidade']) ?>">
                        </div>
                        <?php elseif ($funcao === 'enfermeiro'): ?>
                        <input type="hidden" name="funcao" value="enfermeiro">
                        <div class="col-md-4">
                            <label>Coren</label>
                            <input type="text" name="coren" class="form-control"
                                value="<?= htmlspecialchars($funcionario['corenE']) ?>">
                        </div>
                        <?php elseif ($funcao === 'recepcionista'): ?>
                        <input type="hidden" name="funcao" value="recepcionista">

                        <?php endif; ?>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary col-md-4">Salvar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>