<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Minhas Conexões</title>
  <link rel="stylesheet" href="styleconect.css">
</head>

<body>

  <!-- Header com botão do menu -->
  <div class="header">
    <button id="menu-btn" class="menu-btn">☰</button>
    <div class="menu-title">Conexão</div>
  </div>

  <!-- Sidebar -->
  <aside id="sidebar" class="sidebar" role="navigation" aria-hidden="true">
        <nav>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="conta.php">Minha conta</a></li>
                <li><a href="#3">Minhas Conexões</a></li>
                <li><a href="#4">Sobre</a></li>
            </ul>
        </nav>
    </aside>

  <!-- Overlay -->
  <div id="overlay"></div>

  <div class="page">
    <h1>Minhas Conexões</h1>
    <p class="hint">Exemplo ilustrativo.</p>

    <div class="cards-row">

      <div class="card">
        <div>
          <div class="device-image">
            <img src="calculadora_co2.jpg" alt="Ilustração CO2">
          </div>

          <div class="title">Calculadora de CO₂ — Modelo X100</div>
          <div class="subtitle">
            Insira abaixo o código de emparelhamento do seu equipamento.
          </div>

          <!-- INPUT DO CÓDIGO -->
          <div class="code-input">
            <input type="text" placeholder="Digite o código da calculadora">
          </div>

          <div class="specs">
            <strong>Características:</strong>
            <ul>
              <li>Sensor NDIR de alta precisão</li>
              <li>Wi-Fi / Bluetooth</li>
              <li>Atualização a cada 10s</li>
              <li>Alimentação USB-C</li>
            </ul>
          </div>
        </div>

        <div class="card-footer">
          <button class="btn">Conectar</button>
          <button class="btn ghost">Detalhes</button>
        </div>
      </div>

    </div>
  </div>
   <script src="menu.js"></script>

</body>
</html>

