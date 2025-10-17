<?php
include('protectA.php');
include('conexao.php');


if (!isset($_GET['cpf']) || !isset($_GET['funcao'])) {
    die("Parâmetros inválidos.");
}

$cpf = mysqli_real_escape_string($conn, $_GET['cpf']);
$funcao = mysqli_real_escape_string($conn, $_GET['funcao']);

switch ($funcao) {
    case 'medico':
        $sufixo = 'M';
        $sql = "SELECT * FROM medicos WHERE CPFM = '$cpf'";
        break;

    case 'enfermeiro':
        $sufixo = 'E';
        $sql = "SELECT * FROM enfermeiros WHERE CPFE = '$cpf'";
        break;

    case 'recepcionista':
        $sufixo = 'R';
        $sql = "SELECT * FROM recepcionistas WHERE CPFR = '$cpf'";
        break;

    default:
        die("Função inválida.");
}

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restrita Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-md">
            <h1 style="color: white;">Visualizar funcionário</h1>
            <p><a href="logout.php">Sair</a></p>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Dados do <?= htmlspecialchars($funcao) ?>
                            <button onclick="history.back()" class="btn btn-danger float-end">Voltar</button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row row-g3">
                            <?php
                            if (isset($_GET['cpf'])) {
                            ?>
                            <div class="col-md-6">
                                <label>CPF</label>
                                <p class="form-control">
                                    <?= htmlspecialchars($cpf) ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label>Nome</label>
                                <p class="form-control">
                                    <?= htmlspecialchars($funcionario['nome' . $sufixo]) ?>
                                </p>
                            </div>
                            <div class="col-md-2">
                                <label>Data de nascimento</label>
                                <p class="form-control">
                                    <?= date('d/m/Y', strtotime($funcionario['datanasc' . $sufixo])) ?>
                                </p>
                            </div>
                            <div class="col-md-2">
                                <label>Idade</label>
                                <p class="form-control">
                                    <?= htmlspecialchars($funcionario['idade' . $sufixo]) ?>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label>Telefone</label>
                                <p class="form-control">
                                    <?= !empty($funcionario['telefone' . $sufixo]) ? htmlspecialchars($funcionario['telefone' . $sufixo]) : '<span class="text-danger">Telefone não cadastrado</span>'; ?>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label>Sexo</label>
                                <p class="form-control">
                                    <?= htmlspecialchars($funcionario['sexo' . $sufixo]) ?>
                                </p>
                            </div>

                            <?php if ($funcao === 'medico'): ?>
                            <div class="col-md-4">
                                <label>CRM</label>
                                <p class="form-control"><?= htmlspecialchars($funcionario['CRM']) ?></p>
                            </div>
                            <div class="col-md-8">
                                <label>Especialidade</label>
                                <p class="form-control"><?= htmlspecialchars($funcionario['especialidade']) ?></p>
                            </div>
                            <?php elseif ($funcao === 'enfermeiro'): ?>
                            <div class="col-md-4">
                                <label>Coren</label>
                                <p class="form-control"><?= htmlspecialchars($funcionario['corenE']) ?></p>
                            </div>
                            <?php endif; ?>
                            <div class="row">
                                <a href="editar_funcionario.php?cpf=<?= $cpf ?>&funcao=<?= $funcao ?>"
                                    class="btn btn-success btn-sm col-md-2">Editar</a>
                            </div>
                            <?php
                            } else {
                                echo "<h5>Funcionário não identificado</h5>";
                            }
                            ?>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</body>

</html>