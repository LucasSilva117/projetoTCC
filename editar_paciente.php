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
            <p><a href="logout.php" onclick="return confirm('Tem certeza que deseja sair da conta?')">Sair da conta</a></p>
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
                                    <input type="hidden" name="acao" value="editar_paciente">
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
                                        <input type="text" name="RGP" value="<?= !empty($paciente['RGP']) ? $paciente['RGP'] : ''; ?>" class="form-control" placeholder="<?= !empty($paciente['RGP']) ? $paciente['RGP'] : 'RG não cadastrado'; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Cartão Nacional da Saúde</label>
                                        <input type="text" name="CNSP" value="<?= !empty($paciente['CNSP']) ? $paciente['CNSP'] : ''; ?>" class="form-control" placeholder="<?= !empty($paciente['CNSP']) ? $paciente['CNSP'] : 'CNS não cadastrado'; ?>">
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
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary col-md-4">Salvar</button>
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
        // Dados originais gerados pelo PHP (ajustados para pacientes)
        const originalData = <?= json_encode([
                                    'CPFP'      => $paciente['CPFP'] ?? '',
                                    'nomeP'     => $paciente['nomeP'] ?? '',
                                    'RGP'       => $paciente['RGP'] ?? '',
                                    'CNSP'      => $paciente['CNSP'] ?? '',
                                    'datanascP' => $paciente['datanascP'] ?? '',
                                    'idadeP'    => $paciente['idadeP'] ?? '',
                                    'telefoneP' => $paciente['telefoneP'] ?? '',
                                    'sexoP'     => $paciente['sexoP'] ?? '',
                                    'enderecoP' => $paciente['enderecoP'] ?? '',
                                    'munResP'   => $paciente['munResP'] ?? '',
                                    'UFP'       => $paciente['UFP'] ?? ''
                                ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

        function labelFor(key) {
            const labels = {
                CPFP: 'CPF',
                nomeP: 'Nome',
                RGP: 'RG',
                CNSP: 'Cartão Nacional da Saúde',
                datanascP: 'Data de Nascimento',
                idadeP: 'Idade',
                telefoneP: 'Telefone',
                sexoP: 'Sexo',
                enderecoP: 'Endereço',
                munResP: 'Município de residência',
                UFP: 'UF'
            };
            return labels[key] || key;
        }

        function showChanges(form) {
            const fields = Object.keys(originalData);
            const current = {};

            fields.forEach(f => {
                const el = form.elements[f];
                let val = '';
                if (el) {
                    if (el.tagName === 'SELECT') val = el.options[el.selectedIndex]?.value ?? '';
                    else val = (el.value ?? '');
                }
                current[f] = String(val).trim();
            });

            const changes = [];
            fields.forEach(key => {
                const orig = String(originalData[key] ?? '').trim();
                const now = String(current[key] ?? '').trim();
                if (orig !== now) {
                    changes.push({
                        key,
                        from: orig === '' ? '(vazio)' : orig,
                        to: now === '' ? '(vazio)' : now
                    });
                }
            });

            const modalBody = document.getElementById('changesModalBody');
            modalBody.innerHTML = '';

            if (changes.length === 0) {
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
            // remover listener anterior para evitar múltiplos submit
            confirmBtn.replaceWith(confirmBtn.cloneNode(true));
            const newConfirm = document.getElementById('confirmChangesBtn');
            newConfirm.addEventListener('click', () => form.submit());

            const modal = new bootstrap.Modal(document.getElementById('changesModal'));
            modal.show();
        }

        // Intercepta o submit do formulário de edição de paciente
        document.addEventListener('DOMContentLoaded', () => {
            // Seleciona o formulário de edição (único formulário que envia para acoespacientes.php neste arquivo)
            const form = document.querySelector('form[action="acoespacientes.php"]');
            if (!form) return;
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                showChanges(form);
            }, {
                once: false
            });
        });
    </script>
</body>

</html>