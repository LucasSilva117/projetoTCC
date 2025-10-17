<?php
include('protectA.php');
include('conexao.php');
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
            <h1 style="color: white;">Cadastrar Funcionário</h1>
            <p><a href="logout.php">Sair</a></p>
        </div>
    </nav>
    <div class="container-md">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Novo funcionário
                            <button onclick="history.back()" class="btn btn-danger float-end">Voltar</button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="funcionarios.php?funcao=cadastrar" method="post" id="formCadastro" class="row g-3">
                            
                            <h3>Cadastrar Funcionário</h3>
                            <div class="row justify-content-start">
                                <div class="col-md-4">
                                    <label>Função do funcionário:</label>
                                    <select name="tipo" id="tipo" class="form-select" required
                                        onchange="mostrarCampos()">
                                        <option value="">Selecione...</option>
                                        <option value="enfermeiro">Enfermeiro</option>
                                        <option value="medico">Médico</option>
                                        <option value="recepcionista">Recepcionista</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Nome Completo:</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>CPF:</label>
                                <input type="text" name="CPF" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label>Telefone:</label>
                                <input type="text" name="teleofne" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label>Data de Nascimento:</label>
                                <input type="date" name="datanasc" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label>Idade:</label>
                                <input type="number" name="idade" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label>Sexo:</label>
                                <select name="sexo" class="form-select">
                                    <option value="Masculino">Masculino</option>
                                    <option value="Feminino">Feminino</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Senha:</label>
                                <input type="password" name="senha" class="form-control" required>
                            </div>
                            <!-- Campos específicos por tipo -->
                            <div id="camposEspecificos"></div>

                            <div class="mb-3">
                                <button type="submit" name="cadastrar" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>

                        <script>
                            function mostrarCampos() {
                                const tipo = document.getElementById('tipo').value;
                                const camposDiv = document.getElementById('camposEspecificos');

                                camposDiv.innerHTML = ''; // limpa campos anteriores

                                if (tipo === 'enfermeiro') {
                                    camposDiv.innerHTML = `
                                <div class="col-md-4" m-3>
                                    <label>Coren:</label>
                                    <input type="text" name="coren" class="form-control" required>
                                </div>
                                `;
                                } else if (tipo === 'medico') {
                                    camposDiv.innerHTML = `
                                <div class="col-md-4">
                                    <label>CRM:</label>
                                    <input type="text" name="crm" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label>Especialidade:</label>
                                    <input type="text" name="especialidade" class="form-control" required>
                                </div>
                                 `;
                                } else if (tipo === 'recepcionista') {
                                    camposDiv.innerHTML = `
                                `;
                                }
                            }
                        </script>

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