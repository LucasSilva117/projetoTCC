<?php
include('protectA.php');
include('conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restrita admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <style>
    .navbar {
      padding-top: 0;
      padding-bottom: 0;
      height: 90px;
      display: flex;
      align-items: center;
    }

    .logo {
      height: 80px;
      margin-right: 10px;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-dark bg-dark">
    <div class="container-md d-flex justify-content-between align-items-center">

      <div class="d-flex align-items-center">
        <img src="sefapslogo.png" alt="logo do hospital" class="logo" />
        <h1 style="color: white; margin: 0 0 0 10px;">Administração</h1>
      </div>

      <p style="margin: 0;">
        <a href="logout.php" onclick="return confirm('Tem certeza que deseja sair da conta?')">
          Sair da conta
        </a>
      </p>

    </div>
  </nav>

  <div class="container-lg">
    <div class="mx-2 my-1">
      <a href="lista_funcionarios.php" class="btn btn-dark">Gerenciamento de funcionários</a>
      <a href="hist_atendimentos.php" class="btn btn-primary">Histórico de atendimentos</a>
      <a href="lista_pacientes.php" class="btn btn-info">Lista de pacientes cadastrados</a>
    </div>
    <!-- ABAS -->
    <ul class="nav nav-tabs mb-3" id="listasTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="triagem-tab" data-bs-toggle="tab" data-bs-target="#tabTriagem" type="button" role="tab">
          Lista da Triagem
        </button>
      </li>

      <li class="nav-item" role="presentation">
        <button class="nav-link" id="consultorio-tab" data-bs-toggle="tab" data-bs-target="#tabConsultorio" type="button" role="tab">
          Lista do Consultório
        </button>
      </li>
    </ul>

    <div class="tab-content" id="listasTabContent">

      <!-- ========================== -->
      <!-- 📌 ABA 1 – LISTA DE TRIAGEM -->
      <!-- ========================== -->
      <div class="tab-pane fade show active" id="tabTriagem" role="tabpanel">

        <div class="card">
          <div class="card-header">
            <h4>Lista de espera para triagem</h4>
          </div>
          <div class="card-body">

            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Ordem</th>
                  <th>CPF</th>
                  <th>Nome</th>
                  <th>Idade</th>
                  <th>Sexo</th>
                  <th>Hora do Atendimento</th>
                  <th>Ação</th>
                  <th>Situação</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $sql = "SELECT a.*, p.nomeP, p.idadeP, p.sexoP, e.nomeE 
                        FROM atendimentos a 
                        JOIN pacientes p ON a.CPFPf = p.CPFP 
                        LEFT JOIN enfermeiros e ON a.CPFEf = e.CPFE 
                        WHERE a.situacao IN ('esperando','em_atendimento')
                        ORDER BY a.ordem ASC";

                $atendimentos = mysqli_query($conn, $sql);

                if (!$atendimentos) {
                  die('Erro na consulta: ' . mysqli_error($conn));
                }

                if (mysqli_num_rows($atendimentos) > 0):
                  foreach ($atendimentos as $atendimento):
                ?>

                    <tr>
                      <td><?= $atendimento['ordem'] ?></td>
                      <td><?= $atendimento['CPFPf'] ?></td>
                      <td><?= $atendimento['nomeP'] ?></td>
                      <td><?= $atendimento['idadeP'] ?></td>
                      <td><?= $atendimento['sexoP'] ?></td>
                      <td><?= $atendimento['horaA'] ?></td>

                      <td>
                        <form action="acoespacientes.php" method="post" class="d-inline">
                          <button onclick="return confirm('Tem certeza que deseja excluir esse atendimento?')" type="submit" name="excluir_atendimentoT" value="<?= $atendimento['codAten'] ?>" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                        <a href="atender_paciente.php?aten_id=<?= $atendimento['codAten'] ?>" class="btn btn-success btn-sm">Atender</a>
                      </td>

                      <td>
                        <?php if ($atendimento['situacao'] === 'esperando'): ?>
                          <span class="badge bg-secondary">Em espera</span>
                        <?php elseif ($atendimento['situacao'] === 'em_atendimento'):
                          $primeiroNome = explode(' ', trim($atendimento['nomeE']))[0];
                        ?>
                          <span class="badge bg-danger">Em triagem (<?= htmlspecialchars($primeiroNome) ?>)</span>
                        <?php endif; ?>
                      </td>
                    </tr>

                <?php
                  endforeach;
                else:
                  echo '<h5>Nenhum paciente na lista</h5>';
                endif;
                ?>

              </tbody>
            </table>

          </div>
        </div>
      </div>

      <!-- ===================================== -->
      <!-- 📌 ABA 2 – LISTA DE ESPERA CONSULTÓRIO -->
      <!-- ===================================== -->
      <div class="tab-pane fade" id="tabConsultorio" role="tabpanel">

        <div class="card">
          <div class="card-header">
            <h4>Lista de espera para consulta</h4>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Ordem</th>
                  <th>CPF</th>
                  <th>Nome</th>
                  <th>idade</th>
                  <th>Sexo</th>
                  <th>Hora dos atendimentos(R / T)</th>
                  <th>Classificação de risco</th>
                  <th>Ação</th>
                  <th>Situação</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $sql = "SELECT a.*, p.*, e.*, t.* FROM
                atendimentos a 
                LEFT JOIN pacientes p ON a.CPFPf = p.CPFP
                LEFT JOIN triagens t ON a.codAten = t.codAtenf
                LEFT JOIN enfermeiros e ON a.CPFEf = e.CPFE
                LEFT JOIN medicos m ON a.CPFMf = m.CPFM
                WHERE a.situacao IN ('Esperando consulta', 'Na consulta', 'Finalizado')
                ORDER BY FIELD(t.clascRisco, 'vermelho', 'amarelo', 'verde', 'azul'),
                a.horaA ASC;";
                $atendimentos = mysqli_query($conn, $sql);

                if (!$atendimentos) {
                  die("Erro na consulta: " . mysqli_error($conn));
                }

                if (mysqli_num_rows($atendimentos) > 0) {
                  foreach ($atendimentos as $atendimento) {
                ?>
                    <tr>
                      <td><?= $atendimento['ordem'] ?></td>
                      <td><?= $atendimento['CPFPf'] ?></td>
                      <td><?= $atendimento['nomeP'] ?></td>
                      <td><?= $atendimento['idadeP'] ?></td>
                      <td><?= $atendimento['sexoP'] ?></td>
                      <td><?= $atendimento['horaA'] ?> / <?= $atendimento['horaT'] ?></td>
                      <td><strong><?= $atendimento['clascRisco'] ?></strong></td>
                      <td>
                        <form action="acoespacientes.php" method="post" class="d-inline">
                          <button onclick="return confirm('Tem certeza que deseja excluir esse atendimento?')" type="submit" name="excluir_atendimentoC" value="<?= $atendimento['codAten'] ?>" class="btn btn-danger btn-sm">
                            Excluir
                          </button>
                        </form>
                      </td>
                      <td>
                        <?php if ($atendimento['situacao'] === 'Esperando consulta'): ?>
                          <span class="badge bg-secondary"><i class="bi bi-hourglass-split"></i> Em espera</span>
                        <?php elseif ($atendimento['situacao'] === 'Na consulta'):
                          $primeiroNome = explode(' ', trim($atendimento['nomeM']))[0];
                        ?>
                          <span class="badge bg-danger"><i class="bi bi-exclamation-triangle-fill"></i> Em atendimento(<?= htmlspecialchars($primeiroNome) ?>)</span>
                        <?php endif; ?>
                      </td>
                    </tr>
                <?php
                  }
                } else {
                  echo '<h5>Nenhum paciente na lista</h5>';
                }
                ?>
              </tbody>

            </table>
          </div>
        </div>

      </div> <!-- fim aba consultório -->

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>