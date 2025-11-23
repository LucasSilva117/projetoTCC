<?php
include('protectM.php');
include('conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restrita consultório</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-md">
            <h1 style="color: white;">Atendimento</h1>
            <p><a href="logout.php" onclick="return confirm('Tem certeza que deseja sair da conta?')">Sair da conta</a></p>
        </div>
    </nav>
    <div class="container-md">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Atender paciente (consultório)
                            <?php if (isset($_GET['aten_id'])) {
                                $atendimento_id = mysqli_real_escape_string($conn, $_GET['aten_id']);
                            ?>
                                <form action="acoespacientes.php" method="post" onsubmit="return confirm('Tem certeza que quer voltar? Os dados serão perdidos!');">
                                    <input type="hidden" name="codAten" value="<?= $atendimento_id ?>">
                                    <button type="submit" name="voltar_atendimentoC" class="btn btn-danger float-end">
                                        Voltar
                                    </button>
                                </form>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php
                                // Pegando CPF do médico que clicou em atender
                                if (!isset($_SESSION)) {
                                    session_start();
                                }
                                $cpf_medico = $_SESSION['CPFM'];
                                // Só muda para "em_atendimento" se ainda estiver "Esperando consulta"
                                $sql_check = "SELECT * FROM atendimentos WHERE codAten = '$atendimento_id'";
                                $result_check = mysqli_query($conn, $sql_check);
                                $row = mysqli_fetch_assoc($result_check);

                                if ($row && $row['situacao'] == 'Esperando consulta') {
                                    $sql_update = "UPDATE atendimentos SET situacao = 'Na consulta', CPFMf = '$cpf_medico' WHERE codAten = '$atendimento_id'";
                                    mysqli_query($conn, $sql_update);
                                }


                                $sql = "SELECT t.*, a.*, p.* 
                                FROM atendimentos a
                                JOIN pacientes p ON a.CPFPf = p.CPFP
                                LEFT JOIN triagens t ON t.codAtenf = a.codAten 
                                WHERE a.codAten = '$atendimento_id'";
                                $query = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($query) > 0) {

                                    $aten = mysqli_fetch_array($query);
                                    $codAtenT = $aten['codAtenT'];
                                    $sexoP = $aten['sexoP'];


                        ?>
                            <h4>Dados do paciente</h4>
                            <form action="" method="post" class="row g-3">
                                <div class="col-md-6">
                                    <label>CPF</label>
                                    <p class="form-control">
                                        <?= $aten['CPFP']; ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label>Nome</label>
                                    <p class="form-control">
                                        <?= $aten['nomeP']; ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label>RG</label>
                                    <p class="form-control">
                                        <?= !empty($aten['RGP']) ? $aten['RGP'] : '<span class="text-danger">RG não cadastrado</span>'; ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label>Cartão Nacional da Saúde</label>
                                    <p class="form-control">
                                        <?= !empty($aten['CNSP']) ? $aten['CNSP'] : '<span class="text-danger">CNS não cadastrado</span>'; ?>
                                    </p>
                                </div>
                                <div class="col-md-2">
                                    <label>Data de nascimento</label>
                                    <p class="form-control">
                                        <?= date('d/m/Y', strtotime($aten['datanascP'])) ?>
                                    </p>
                                </div>
                                <div class="col-md-2">
                                    <label>Idade</label>
                                    <p class="form-control">
                                        <?= $aten['idadeP']; ?>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <label>Telefone</label>
                                    <p class="form-control">
                                        <?= !empty($aten['telefoneP']) ? $aten['telefoneP'] : '<span class="text-danger">Telefone não cadastrado</span>'; ?>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <label>Sexo</label>
                                    <p class="form-control">
                                        <?= $aten['sexoP']; ?>
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <label>Endereço</label>
                                    <p class="form-control">
                                        <?= $aten['enderecoP']; ?>
                                    </p>
                                </div>
                                <div class="col-md-8">
                                    <label>Município de residência</label>
                                    <p class="form-control">
                                        <?= $aten['munResP']; ?>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <label>UF</label>
                                    <p class="form-control">
                                        <?= $aten['UFP']; ?>
                                    </p>
                                </div>
                            </form>

                            <!--Àrea do atendimento-->
                            <!--O horario do atendimento é a hora que o paciente entrou-->
                            <div class="container-sm">
                                <h4 class="mb-4">Enfermagem</h4>
                            </div>
                            <div>
                                <form action="acoespacientes.php" method="post"
                                    class="row g-3 border border-2 border-secondary">
                                    <input type="hidden" name="codAten" value="<?= $atendimento_id ?>">
                                    <div class="col-md-1">
                                        <label>Diarréia?</label>
                                        <p class="form-control">
                                            <?= $aten['temDiarreia']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Data de início dos sintomas</label>
                                        <p class="form-control">
                                            <?= date('d/m/Y', strtotime($aten['tempoSintomas'])) ?>
                                        </p>
                                    </div>
                                    <div class="col-md-1">
                                        <label>Tem alergia?</label>
                                        <p class="form-control">
                                            <?= $aten['temAlergia']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Se sim, à que?</label>
                                        <p class="form-control">
                                            <?= !empty($aten['alergiaAque']) ? $aten['alergiaAque'] : '<span class="text-danger">Não tem alergia</span>'; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Tosse a mais de 3 semanas?</label>
                                        <p class="form-control">
                                            <?= $aten['tosseMais3sem']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Colheu BK?</label>
                                        <p class="form-control">
                                            <?= $aten['colheuBK']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-1">
                                        <label>PA:</label>
                                        <p class="form-control">
                                            <?= $aten['pressaoArterial']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-1">
                                        <label>Pulso:</label>
                                        <p class="form-control">
                                            <?= $aten['pulso']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-1">
                                        <label>F/R:</label>
                                        <p class="form-control">
                                            <?= $aten['frequenciaResp']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-1">
                                        <label>Tax:</label>
                                        <p class="form-control">
                                            <?= $aten['temperatura']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-1">
                                        <label>Glicemia:</label>
                                        <p class="form-control">
                                            <?= $aten['glicemia']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-1">
                                        <label>SPO:</label>
                                        <p class="form-control">
                                            <?= $aten['SPO']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Classificação de risco:</label> <br>
                                        <p class="form-control">
                                            <?= $aten['clascRisco']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Peso:</label>
                                        <p class="form-control">
                                            <?= $aten['peso']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Hora do atendimento (triagem)</label>
                                        <p class="form-control">
                                            <?= $aten['horaT'] ?>
                                        </p>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Situação / Queixa / Histórico (medicações usuais)</label> <br>
                                        <p class="form-control">
                                            <?= $aten['observacao']; ?>
                                        </p>
                                    </div>
                                </form>
                                <!-- Área do consultório (médico) -->
                                <div class="container-sm">
                                    <h4 class="mb-4">Consultório</h4>
                                </div>
                                <form action="acoespacientes.php" method="post" id="formConsulta"
                                    class="row g-3 border border-2 border-secondary">
                                    <input type="hidden" name="codAten" value="<?= $atendimento_id ?>">
                                    <input type="hidden" name="codAtenT" value="<?= $codAtenT ?>">
                                    <input type="hidden" name="imprimir" id="imprimir" value="0">
                                    <input type="hidden" name="acao" value="consulta_paciente">

                                    <div class="col-md-6">
                                        <label>Hora do atendimento (Médico)</label>
                                        <input type="time" name="horaC" class="form-control" id="hora" readonly>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Exame Clínico</label>
                                        <textarea name="exameClinico" id="exameClinico" class="form-control" rows="6" cols="150" placeholder="Descreva o exame clínico"></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Conduta</label>
                                        <textarea name="conduta" id="conduta" class="form-control" rows="6" cols="150" placeholder="Descreva a conduta"></textarea>
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" name="consulta_paciente" id="btnFinalizar" class="btn btn-primary">Finalizar atendimento</button>
                                    </div>
                                    <!-- Ao clicar em finalizar atendimento, vai gerar uma notificação perguntando se deseja imprimir o relatório -->
                                </form>
                                <!-- Modal confirmar salvar / salvar e imprimir -->
                                <div class="modal fade" id="confirmSaveModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Finalizar atendimento</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Deseja apenas salvar ou salvar e imprimir o relatório?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="btnSaveOnly" class="btn btn-secondary" data-bs-dismiss="modal">Salvar somente</button>
                                                <button type="button" id="btnSavePrint" class="btn btn-primary" target="_blank">Salvar e imprimir</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const form = document.getElementById('formConsulta');
                                        if (!form) return;

                                        const imprimirInput = document.getElementById('imprimir'); // hidden input
                                        const confirmModalEl = document.getElementById('confirmSaveModal');
                                        const btnSaveOnly = document.getElementById('btnSaveOnly');
                                        const btnSavePrint = document.getElementById('btnSavePrint');

                                        form.addEventListener('submit', function(e) {
                                            e.preventDefault();

                                            // se não houver modal, usa confirm() padrão
                                            if (!confirmModalEl || typeof bootstrap === 'undefined') {
                                                const imprimir = confirm('Deseja salvar e imprimir o relatório? OK = Imprimir, Cancel = Salvar somente');
                                                if (imprimirInput) imprimirInput.value = imprimir ? '1' : '0';
                                                return form.submit();
                                            }

                                            const bsModal = new bootstrap.Modal(confirmModalEl);
                                            bsModal.show();
                                        });

                                        if (btnSaveOnly) {
                                            btnSaveOnly.addEventListener('click', function() {
                                                if (imprimirInput) imprimirInput.value = '0';
                                                const modalEl = document.getElementById('confirmSaveModal');
                                                const bsModal = bootstrap.Modal.getInstance(modalEl);
                                                if (bsModal) bsModal.hide();

                                                setTimeout(async () => {
                                                    // envia via fetch para evitar abrir nova aba e garantir que a aba atual feche/retorne
                                                    try {
                                                        btnSaveOnly.disabled = true;
                                                        if (btnSavePrint) btnSavePrint.disabled = true;

                                                        const fd = new FormData(form);
                                                        fd.set('imprimir', '0');
                                                        // garantir que o envio ocorra na mesma aba
                                                        form.target = '_self';

                                                        await fetch(form.action, {
                                                            method: (form.method || 'POST').toUpperCase(),
                                                            body: fd,
                                                            credentials: 'same-origin'
                                                        });

                                                        // redireciona a aba atual para o painel do médico
                                                        window.location.replace('restrita_medico.php');
                                                    } catch (err) {
                                                        console.error(err);
                                                        alert('Erro ao salvar. Tente novamente.');
                                                        btnSaveOnly.disabled = false;
                                                        if (btnSavePrint) btnSavePrint.disabled = false;
                                                    }
                                                }, 250);
                                            });
                                        }

                                        if (btnSavePrint) {
                                            btnSavePrint.addEventListener('click', function() {
                                                if (imprimirInput) imprimirInput.value = '1';

                                                // salva target original para restaurar depois
                                                const originalTarget = form.target || '';
                                                // marca atributo com o original (útil se houver múltiplos cliques)
                                                form.setAttribute('data-original-target', originalTarget);

                                                form.target = '_blank'; // abre nova aba
                                                const modalEl = document.getElementById('confirmSaveModal');
                                                const bsModal = bootstrap.Modal.getInstance(modalEl);
                                                if (bsModal) bsModal.hide();

                                                // Aguarda o modal fechar e depois envia o form
                                                setTimeout(() => {
                                                    form.submit();

                                                    // restaura target para uso futuro
                                                    form.target = originalTarget;
                                                    form.removeAttribute('data-original-target');

                                                    // redireciona a aba atual de volta ao painel do médico
                                                    // usar replace para não deixar histórico (evita voltar à tela de atendimento)
                                                    window.location.replace('restrita_medico.php');
                                                }, 300); // pequeno delay pro modal sumir e para o submit iniciar
                                            });

                                        };
                                    });
                                </script>
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


        <script>
            window.addEventListener("load", function() {
                let agora = new Date();
                let horas = String(agora.getHours()).padStart(2, '0');
                let minutos = String(agora.getMinutes()).padStart(2, '0');
                document.getElementById("hora").value = `${horas}:${minutos}`;
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
        </script>
</body>

</html>