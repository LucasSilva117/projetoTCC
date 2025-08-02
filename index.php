
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
    body {
      background-color: #f0f2f5;
      font-family: Arial, sans-serif;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    #bemvindo {
      margin-bottom: 30px;
      color: #1e4b5d;
      text-align: center;
    }

    .formulario{
        text-align: center;
    }

    .inputs{
        text-align: left;
    }

    form {
        background-color: #fff;
        padding: 15px;
        border: 2px solid #1e4b5d;
        border-radius: 8px;
        max-width: 400px;
        margin: 30px; 
        margin-bottom: 20px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    button{
      width: 50%;
      padding: 10px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 15px;
    }

    button:hover {
      background-color: #0056b3;
    }

    select {
        height: 30px;
        font-size: 15px;
        border-radius: 10px;
    }
  </style>
</head>


<body>
    <!--Objetivo: colocar um header com a logo do sefaps e iguape-->
    <div class="box">
        <h1 id="bemvindo">Bem-vindo! Faça seu login</h1>
        <div class="formulario">
            <form action="funcionarios.php?funcao=logar" method="POST">
                <div class="inputs">
                    <label for="cpf">CPF</label>
                    <input type="text" name="cpf" placeholder="Digite seu login" required id="cpf">

                    <label for="senha">Senha</label>
                    <input type="password" name="senha" placeholder="Digite sua senha" required id="senha">

                    <label for="funcao">Função: </label>
                    <select name="tipo" id="tipo">
                        <option value="">Selecione a sua função</option>
                        <option value="recepcionista">Recepcionista</option>
                        <option value="enfermeiro">Enfermeiro(a)</option>
                    </select>
                    
                </div>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
</body>
</html>