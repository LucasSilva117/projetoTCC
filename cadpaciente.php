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
      <h1 style="color: white;">Cadastrar paciente</h1>
      <p><a href="logout.php">Sair</a></p>
    </div>
  </nav>
  <div class="container-md">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Novo paciente
                        <a href="restrita_recepcao.php" class="btn btn-danger float-end">Voltar</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="acoespacientes.php" method="$_POST" class="row g-3">
                        <div class="col-md-6">
                            <label>RG/SUS</label>
                            <input type="text" name="RGSUSP" class="form-control" placeholder="N° RG ou N° SUS">
                        </div>
                        <div class="col-md-6">
                            <label>Nome</label>
                            <input type="text" name="nomeP" class="form-control" placeholder="Nome completo">
                        </div>
                        <div class="col-md-2">
                            <label>Data de nascimento</label>
                            <input type="date" name="datanascP" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label>Idade</label>
                            <input type="number" name="idadeP" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Telefone</label>
                            <input type="text" name="telefoneP" class="form-control" placeholder="13999999999">
                        </div>
                        <div class="col-md-4">
                            <label for="funcao">Sexo</label>
                                <select name="sexoP" class="form-select">
                                    <option value="">Selecione...</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="Feminino">Feminino</option>
                                    <option value="Outro">Outro</option>
                                </select>
                        </div>
                        <div class="col-md-12">
                            <label>Endereço</label>
                            <input type="text" name="enderecoP" class="form-control" placeholder="Rua, Bairro, complemento, N°">
                        </div>
                        <div class="col-md-8">
                            <label>Município de residência</label>
                            <input type="text" name="munResP" class="form-control" placeholder="Iguape">
                        </div>
                        <div class="col-md-4">
                            <label>UF</label>
                            <input type="text" name="sexoP" class="form-control" placeholder="SP, RJ, PR...">
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="cadastrar_paciente" class="btn btn-primary">Salvar</button>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>