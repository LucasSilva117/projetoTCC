<?php
include('protectT.php');
include('conexao.php');
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
      <h1 style="color: white;">Triagem</h1>
      <p><a href="logout.php">Sair da conta</a></p>
    </div>
  </nav>

  <div class="container-lg">
    <div class="mx-2 my-1">
      <a href="" class="btn btn-primary">Registros de atendimentos</a>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4>Lista de espera para triagem</h4>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Ordem</th>
                  <th>RG/SUS</th>
                  <th>Nome</th>
                  <th>idade</th>
                  <th>Sexo</th>
                  <th>Hora do Atendimento</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = 'SELECT a.*, p.id, p.nomeP, p.idadeP, p.sexoP FROM atendimentos a JOIN pacientes p ON a.RGSUSPf = p.RGSUSP ORDER BY a.ordem ASC';
                $atendimentos = mysqli_query($conn, $sql);

                if (mysqli_num_rows($atendimentos) > 0) {
                  foreach ($atendimentos as $atendimento) {
                ?>

                    <tr>
                      <td><?= $atendimento['ordem'] ?></td>
                      <td><?= $atendimento['RGSUSPf'] ?></td>
                      <td><?= $atendimento['nomeP'] ?></td>
                      <td><?= $atendimento['idadeP'] ?></td>
                      <td><?= $atendimento['sexoP'] ?></td>
                      <td><?= $atendimento['hora'] ?></td>
                      <td>
                        
                        <form action="acoespacientes.php" method="post" class="d-inline">
                          <button onclick="return confirm('Tem certeza que deseja excluir esse paciente?')" type="submit" name="excluir_atendimento" value="<?= $atendimento['codAten'] ?>" class="btn btn-danger btn-sm">
                            Excluir
                          </button>
                        </form>
                        <a href="atender_paciente.php?rg=<?=$atendimento['RGSUSPf']?>" class="btn btn-success btn-sm ">Atender</a>
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
      </div>
    </div>

  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>

