<?php
include('protectR.php');

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de pacientes</title>
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
        <h1 class="text-white">Cadastrar paciente</h1>
      </div>

      <p style="margin: 0;">
        <a href="logout.php" onclick="return confirm('Tem certeza que deseja sair da conta?')">
          Sair da conta
        </a>
      </p>

    </div>
  </nav>
    <div class="container-md">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Novo paciente
                            <button onclick="history.back()" class="btn btn-danger float-end">Voltar</button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="acoespacientes.php" method="post" class="row g-3">
                            <div class="col-md-6">
                                <label>CPF</label>
                                <input type="text" name="CPFP" class="form-control" placeholder="Insira o CPF" required>
                            </div>
                            <div class="col-md-6">
                                <label>Nome</label>
                                <input type="text" name="nomeP" class="form-control" placeholder="Nome completo" required>
                            </div>
                            <div class="col-md-6">
                                <label>RG</label>
                                <input type="text" name="RGP" class="form-control" placeholder="Insira o RG (opicional)" >
                            </div>
                            <div class="col-md-6">
                                <label>Cartão Nacional da Saúde</label>
                                <input type="text" name="CNSP" class="form-control" placeholder="Insira o número do SUS (opicional)" >
                            </div>
                            <div class="col-md-2">
                                <label>Data de nascimento</label>
                                <input type="date" name="datanascP" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label>Idade</label>
                                <input type="number" name="idadeP" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>Telefone</label>
                                <input type="text" name="telefoneP" class="form-control" placeholder="1399999999">
                            </div>
                            <div class="col-md-4">
                                <label>Sexo</label>
                                <select name="sexoP" class="form-select" required>
                                    <option value="">Selecione...</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Feminino">Feminino</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Endereço</label>
                                <input type="text" name="enderecoP" class="form-control" placeholder="Rua, Bairro, complemento, N°" required>
                            </div>
                            <div class="col-md-8">
                                <label>Município de residência</label>
                                <input type="text" name="munResP" class="form-control" placeholder="Iguape" required>
                            </div>
                            <div class="col-md-4">
                                <label>UF</label>
                                <input type="text" name="UFP" class="form-control" placeholder="SP, RJ, PR..." required>
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