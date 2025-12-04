<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SEFAPS - portfólio</title>
  <style>
   
    :root{
      --dark:#0b1320;
      --muted:#6b7280;}

    * {box-sizing:border-box;}

     body{
      margin:0 70px;
      padding-top:100px;
      font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
      line-height:1.5;
      font-size:18px; 
    background-color: #d4e0ece7;
  }

header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(6px);
  border-bottom: 1px solid #eee;
  z-index: 1000;
  margin: 0;
  padding: 0;
  
}

/* Contêiner principal da barra */
.nav {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 72px;
  max-width: 100%;
  margin: 0;
  padding: 0 80px;   /* quanto menor, mais pra esquerda */
}


/* Logo + subtítulo */
.brand-container {
  display: flex;
  align-items: center;
  gap: 10px;
}

/* Texto abaixo da logo */
.brand {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  
}

.logo {
  height: 80px;   /* tamanho médio, nitidez boa */
  width: auto;    /* mantém proporção certa */
}
.logos {
  display: flex;
  align-items: center;
  gap: 14px;
}


/* Subtítulo */
.brand-name {
  font-size: 12px;
  color: var(--muted);
  margin-top: 8px;
  
}

/* Lista do menu */
nav ul {
  display: flex;
  gap: 18px;
  list-style: none;
  margin: 0;
  padding: 0;
  align-items: center;
  justify-content: flex-end; /* empurra os links para a direita */
}

/* Links do menu */
nav a {
  color: var(--dark);
  text-decoration: none;
  font-weight: 600;
  font-size: 14px;
  transition: color 0.3s ease;
}
 .cta{padding:8px 14px;
      border-radius:8px;
      background:var(--accent);
      color:#fff;
      text-decoration:none;
      font-weight:700}

   
    p.lead {
      color:#000000;
      padding:10px 0 20px;
      text-align: justify;
      max-width: 800px;
    }
     p.hero-card{
      color:var(--muted);
      max-width:50%;
      padding:10px 0 20px;
      text-align: justify;
    }

    h1 {
      font-size:40px;
      margin:10px 0;
      color: #000000;;
    }
   
    .hero-card {
      background:#f8fbff;
      border-radius:12px;
      padding:22px;
      box-shadow:0 6px 18px rgba(0, 0, 0, 0.06);
      margin-top: 20px;
    }

    section {
      padding:40px 0;
      scroll-margin-top:60px;
    }

   /* politicas */
#psi-section {
    padding: 40px 0;}

#psi-section h2 {
    color: white;
    font-size: 32px;
    margin-bottom: 30px;}

/* Grid das políticas */
.psi-grid {
    display: flex;
    flex-direction: column;
    gap: 20px;}

/* Cada box */
.psi-card {
    background: white;
    padding: 16px 22px;
    border-radius: 12px;
    border: 1px solid #ddd;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    transition: transform .2s ease, box-shadow .2s ease;}

/* Título dentro do card */
.psi-card h3 {
    margin: 0 0 8px;
    font-size: 18px;
    font-weight: 700;}

/* Texto */
.psi-card p {
    margin: 0;
    color: #444;
    font-size: 15px;}

    /*Fundadores*/
.card {
    background: #ffffff;
    border-radius: 12px;
    padding: 18px 25px;     
    border: 1px solid #e0e0e0;  
    margin: 15px 0; }
.contato-cards {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;}

.card-c{background:white;
      border-radius:10px;
      padding:18px;
    border:1px solid #eee}

    .team-grid {
      display:grid;
      grid-template-columns:repeat(3,1fr);
      gap:16px;}

    .persona {
      display:flex;
      gap:12px;
      align-items:center;
    }

    .avatar {
      width:84px;
      height:84px;
      border-radius:10px;
      background:linear-gradient(135deg,#eee,#ddd);
      display:flex;
      align-items:center;
      justify-content:center;
      color:#777;
      font-weight:700;
      object-fit: cover;
    }
    .hero-flex {
  display: flex;
  align-items: center;
  gap: 30px;
}
.hero-text {
  flex: 1;
}

.hero-img {
  width: 40   0px;
  max-width: 500px;
  border-radius: 9px;
}


  </style>
</head>
<body>
  <header>
  <div class="container nav">
      <div class="logos">
        <img src="sefapslogo.png" alt="logo do hospital" class="logo" />
        <div>
          <div style="font-weight:800;">SEFAPS</div>
          <div style="font-size:12px;color:var(--muted)">Sistema Eletrônico de Fichas de Atendimento</div>
        </div>
      </div>

      <nav>
        <ul id="navlist">
          <li><a href="#hero">Quem Somos</a></li>
          <li><a href="#proposito">Nosso propósito</a></li>
          <li><a href="#sobre">Fundadores</a></li>
          <li><a href="#politica">PSI</a></li>
          <li><a href="#contato">Contato</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <section id="hero">
      <div class="container hero-flex" >
        <div class="hero-text">
      <h1>Quem somos</h1> 
      <p class="lead" style="color: #000000;">
        &nbsp&nbsp Somos estudantes da ETEC Engenheiro Agrônomo Narciso de Medeiros, do curso técnico em Informática, atualmente cursando o terceiro ano(2025). Este site faz parte do nosso Trabalho de Conclusão de Curso (TCC), desenvolvido com o objetivo de aplicar na prática os conhecimentos adquiridos ao longo da formação técnica.
      </p>
    </div>

    <img src="escola.webp" alt="escola" class="hero-img">

  </div>
    </section>

    <section id="proposito">
      <div class="container">
        <h1>Nosso propósito</h1> 
          <p class="lead" style="color:var(--muted);margin-top:8px;color: #000000;">
           &nbsp&nbsp O propósito do nosso trabalho é desenvolver uma solução tecnológica que melhore a eficiência e a organização nos atendimentos de pronto-socorro, por meio de um sistema eletrônico de fichas de atendimento.<br>
           &nbsp&nbsp Com esse projeto, buscamos modernizar processos manuais, reduzir erros e otimizar o tempo de espera dos pacientes, além de facilitar o acesso dos profissionais da saúde. Nosso objetivo é demonstrar como a tecnologia pode ser uma grande aliada na gestão da saúde pública, tornando o atendimento mais rápido e seguro.
          </p>
        </div>
      </div>
    </section>

    <section id="sobre" class="container">
      <h2>Fundadores</h2>
      <div class="team-grid" style="margin-top:18px">
        <div class="card persona">
          <img src="Lívia.jpeg" alt="foto" class="avatar" />
          <div>
            <div style="font-weight:800">Livia Xavier</div>
            <div style="font-size:13px;color:var(--muted)">Técnica em Informática</div>
          </div>
        </div>
        <div class="card persona">
        <img src="Lucas.jpeg" alt="foto" class="avatar" />
          <div>
            <div style="font-weight:800">Lucas Barbosa</div>
            <div style="font-size:13px;color:var(--muted)">Técnico em Informática</div>
          </div>
        </div>
        <div class="card persona">
          <img src="Monalisa.jpeg" alt="foto" class="avatar" />
          <div>
            <div style="font-weight:800">Monalisa Montanari</div>
            <div style="font-size:13px;color:var(--muted)">Técnica em Informática</div>
          </div>
        </div>
      </div>
    </section>

    <section id="politica">
    <div class="container">
        <h2>Política de Segurança da Informação (PSI)</h2>

        <div class="psi-grid">

            <div class="psi-card">
                <h3>Políticas Regulatórias</h3>
                <p>É obrigatório o acesso por meio de login.</p>
            </div>

            <div class="psi-card">
                <h3>Política Consultiva</h3>
                <p>Recomenda-se sair da conta ao final do expediente.</p>
            </div>

            <div class="psi-card">
                <h3>Política Informativa</h3>
                <p>Caso haja alterações nas fichas, os administradores têm acesso aos autores.</p>
            </div>

        </div>
    </div>
</section>


<section id="local">
  <div class="container">
    <!-- local -->
    <h2>Onde estamos</h2>
    <div class="card" style="display:flex; align-items:flex-start; gap:10px;">
      <span style="font-size:20px;">📍</span>
      <div>
        <strong>Iguape, SP</strong>
        <div style="color:var(--muted);font-size:14px;margin-top:8px">
          <a href="https://www.google.com/maps?q=R.+Latif+Corrêa,+92-196,+Iguape,+SP" 
             target="_blank" 
             style="color:var(--dark); text-decoration:none;">
            R. Latif Corrêa, 92-196
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="contato">
  <div class="container">
    <h2>Contato</h2>
    <div class="contato-cards" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
      <!-- E-mail -->
      <div class="card-c" style="min-width:260px; display:flex; align-items:flex-start; gap:10px;">
        <span style="font-size:20px;">📧</span>
        <div>
          <strong>E-mail</strong>
          <div style="color:var(--muted);font-size:14px;margin-top:8px">
            <a href="mailto:tccsefaps@gmail.com" 
               style="color:var(--dark); text-decoration:none;">
              tccsefaps@gmail.com
            </a>
          </div>
        </div>
      </div>
      <!-- Telefone -->
      <div class="card-c" style="min-width:260px; display:flex; align-items:flex-start; gap:10px;">
        <span style="font-size:20px;">📞</span>
        <div>
          <strong>Telefone</strong>
          <div style="color:var(--muted);font-size:14px;margin-top:8px">
            <a href="tel:+5513999999999" 
               style="color:var(--dark); text-decoration:none;">
              (13) 99999-9999
            </a>
          </div>
        </div>
      </div>
      
</body>
</html>