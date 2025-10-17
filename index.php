<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      background-image: url('ps.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
    }

    .header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 60px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
      background-color: #fff;
      border-bottom: 2px solid #000;
      z-index: 1000;
    }

    .logo {
      height: 200px;
      margin-top: 30px;
    }

    /* Ícone do menu (hambúrguer) */
    .menu-toggle {
      display: flex;
      flex-direction: column;
      cursor: pointer;
      z-index: 1100;
    }

    .menu-toggle span {
      height: 3px;
      width: 25px;
      background: #333;
      margin: 4px 0;
      border-radius: 2px;
      transition: 0.3s;
    }

    /* Menu escondido */
    nav {
      display: none;
      position: absolute;
      top: 60px;
      right: 20px;
      background: #fff;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    nav.active {
      display: block;
    }

    nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    nav ul li {
      margin: 10px 0;
    }

    nav ul li a {
      text-decoration: none;
      color: #14365b;
      font-weight: bold;
    }

    /* Caixa central do login */
    .box {
      max-width: 320px;
      margin: 200px auto 0;
      padding: 10px;
      border-radius: 14px;
      background-color: #fff;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .box h2 {
      margin-bottom: 5px;
      font-size: 30px;
      font-weight: bold;
      color: #1a3153;
      display: inline-block;
      border-bottom: 2px solid #000;
      padding-bottom: 2px;
    }

    .box p {
      margin-bottom: 20px;
      color: #363535;
      padding: 5px;
    }

    /* Inputs e labels */
    .inputs {
      display: flex;
      flex-direction: column;
      text-align: left;
      gap: 5px;
      margin-bottom: 10px;
    }

    label {
      font-size: 14px;
      color: #333;
      margin-bottom: 1px;
    }

    input, #funcao {
      padding: 8px;
      border: 1px solid #aaa;
      border-radius: 7px;
    }

    #funcao {
      font-size: 14px;
      color: #333;
    }

    /* Botão */
    button {
      margin-top: 15px;
      width: 100%;
      padding: 10px;
      background: #14365b;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    button:hover {
      background: #24578d;
    }
    .password {
      position: relative;
      width: 280px;
      height: 40px;
      margin: 20px auto;
    }

    .password input {
      width: 100%;
      height: 100%;
      padding: 10px;
      font-size: 16px;
      outline: none;
      border: 2px solid #1a3153;
      border-radius: 12px;
      background: transparent;
      box-shadow: inset 5px 5px 10px #d1d9e6,
                  inset -5px -5px 10px #fff;
    }

    .password img {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      width: 24px;
      height: 24px;
      cursor: pointer;
      opacity: 0.6;
    }

    .password img:hover {
      opacity: 1;
    }
  </style>
</head>
<body>
  <header class="header">
    <img src="SEFAPS.png" alt="logo do hospital" class="logo" />

    <!-- Botão menu -->
    <div class="menu-toggle" id="menu-toggle">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <!-- Menu -->
    <nav id="menu">
      <ul>
      
        <li><a href="login_adm.php">Login Administrador</a></li>
      </ul>
    </nav>
  </header>

  <div class="box">
    <h2 id="bemvindo">Acesse sua conta!</h2>
    <p>Bem vindo, por favor efetue seu login.</p>
    <div class="formulario">
      <form action="funcionarios.php?acao=logar" method="POST">
        <div class="inputs">
          <label for="cpf">CPF</label>
          <input type="text" name="cpf" placeholder="Digite seu login" required id="cpf">

          <label for="senha">Senha</label>
          <input type="password" name="senha" placeholder="Digite sua senha" required id="senha">
           

          <label for="funcao">Função: </label>
          <select name="funcao" id="funcao" class="form-control">
            <option value="">Selecione a sua função</option>
            <option value="recepcionista">Recepcionista</option>
            <option value="enfermeiro">Enfermeiro(a)</option>
            <option value="medico">Médico</option>
            <option value="administrador">Administrador</option>
          </select>
        </div>
        <button type="submit">Entrar</button>
      </form>
    </div>
  </div>

  <script>
    const toggle = document.getElementById("menu-toggle");
    const menu = document.getElementById("menu");



    
  </script>
</body>
</html>

