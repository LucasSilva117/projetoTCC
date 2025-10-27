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
                <form id="editarForm" method="post" action="funcionarios.php?acao=editar">
                    <input type="hidden" name="cpf" value="<?= htmlspecialchars($cpf) ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>CPF</label>
                            <input id="cpf" type="text" class="form-control" value="<?= htmlspecialchars($cpf) ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <label>Nome</label>
                            <input id="nome" type="text" name="nome" class="form-control"
                                value="<?= htmlspecialchars($funcionario['nome' . $sufixo]) ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label>Data de Nascimento</label>
                            <input id="datanasc" type="date" name="datanasc" class="form-control"
                                value="<?= htmlspecialchars($funcionario['datanasc' . $sufixo] ?? '') ?>">
                        </div>

                        <div class="col-md-4">
                            <label>Idade</label>
                            <input id="idade" type="number" name="idade" class="form-control"
                                value="<?= htmlspecialchars($funcionario['idade' . $sufixo]) ?>">
                        </div>

                        <div class="col-md-2">
                            <label>Telefone</label>
                            <input id="telefone" type="text" name="telefone" class="form-control"
                                value="<?= htmlspecialchars($funcionario['telefone' . $sufixo]) ?>">
                        </div>

                        <div class="col-md-2">
                            <label>Sexo</label>
                            <select id="sexo" name="sexo" class="form-control">
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
                            <input id="crm" type="text" name="crm" class="form-control"
                                value="<?= htmlspecialchars($funcionario['CRM']) ?>">
                        </div>
                        <div class="col-md-8">
                            <label>Especialidade</label>
                            <input id="especialidade" type="text" name="especialidade" class="form-control"
                                value="<?= htmlspecialchars($funcionario['especialidade']) ?>">
                        </div>
                        <?php elseif ($funcao === 'enfermeiro'): ?>
                        <input type="hidden" name="funcao" value="enfermeiro">
                        <div class="col-md-4">
                            <label>Coren</label>
                            <input id="coren" type="text" name="coren" class="form-control"
                                value="<?= htmlspecialchars($funcionario['corenE']) ?>">
                        </div>
                        <?php elseif ($funcao === 'recepcionista'): ?>
                        <input type="hidden" name="funcao" value="recepcionista">
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-primary col-md-4" onclick="showChanges()">Salvar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar mudanças -->
    <div class="modal fade" id="changesModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirme as alterações</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body" id="changesModalBody">
            <!-- Conteúdo preenchido via JS -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button id="confirmChangesBtn" type="button" class="btn btn-primary">Confirmar e salvar</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // Dados originais gerados pelo PHP
    const originalData = <?= json_encode([
        'nome' => $funcionario['nome' . $sufixo] ?? '',
        'datanasc' => $funcionario['datanasc' . $sufixo] ?? '',
        'idade' => $funcionario['idade' . $sufixo] ?? '',
        'telefone' => $funcionario['telefone' . $sufixo] ?? '',
        'sexo' => $funcionario['sexo' . $sufixo] ?? '',
        'crm' => $funcionario['CRM'] ?? '',
        'especialidade' => $funcionario['especialidade'] ?? '',
        'coren' => $funcionario['corenE'] ?? ''
    ], JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP) ?>;

    function labelFor(key){
      const labels = {nome:'Nome', datanasc:'Data de Nascimento', idade:'Idade', telefone:'Telefone', sexo:'Sexo', crm:'CRM', especialidade:'Especialidade', coren:'Coren'};
      return labels[key] || key;
    }

    function showChanges(){
      const form = document.getElementById('editarForm');
      const current = {
        nome: document.getElementById('nome')?.value || '',
        datanasc: document.getElementById('datanasc')?.value || '',
        idade: document.getElementById('idade')?.value || '',
        telefone: document.getElementById('telefone')?.value || '',
        sexo: document.getElementById('sexo')?.value || '',
        crm: document.getElementById('crm')?.value || '',
        especialidade: document.getElementById('especialidade')?.value || '',
        coren: document.getElementById('coren')?.value || ''
      };

      const changes = [];
      for (const key in originalData){
        if ((originalData[key] || '') !== (current[key] || '')){
          changes.push({key, from: originalData[key] || '(vazio)', to: current[key] || '(vazio)'});
        }
      }

      const modalBody = document.getElementById('changesModalBody');
      modalBody.innerHTML = '';

      if (changes.length === 0){
        if (confirm('Nenhuma alteração detectada. Deseja salvar mesmo assim?')) form.submit();
        return;
      }

      const ul = document.createElement('ul');
      ul.className = 'list-group';
      changes.forEach(ch => {
        const li = document.createElement('li');
        li.className = 'list-group-item';
        li.textContent = `${labelFor(ch.key)}: ${ch.from} → ${ch.to}`;
        ul.appendChild(li);
      });
      modalBody.appendChild(ul);

      const confirmBtn = document.getElementById('confirmChangesBtn');
      confirmBtn.onclick = function(){ form.submit(); };

      const modal = new bootstrap.Modal(document.getElementById('changesModal'));
      modal.show();
    }
    </script>
</body>

</html>