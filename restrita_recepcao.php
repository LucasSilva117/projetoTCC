<?php 
include('protectR.php');

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
      <h1 style="color: white;">Recepção</h1>
      <p><a href="logout.php">Sair</a></p>
    </div>
  </nav>

<div class="container-lg">
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
              <th>RG/SUS</th>
              <th>Nome</th>
              <th>idade</th>
              <th>DN</th>
              <th>Sexo</th>
              <th>Ação</th>
            </tr>
            </thead>
            

          </table>
        </div>
      </div>
    </div>
  </div>
      <a href="cadpaciente.php">
        <button class="btn btn-primary">
          <p>Cadastrar novo paciente</p>
        </button>
      </a>
      <a href="adpaciente.php">
        <button class="btn btn-success">
          <p>Adicionar Paciente à lista</p>
        </button>
      </a>
      <a href="listapacientes.php">
        <button class="btn btn-info">
          <p>Lista de pacientes cadastrados</p>
        </button>
      </a>
</div>






  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>