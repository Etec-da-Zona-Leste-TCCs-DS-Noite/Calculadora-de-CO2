<?php
// Usar caminho absoluto relativo a este arquivo
require_once __DIR__ . '/../Controller/protect.php';
// NÃO chame session_start() aqui pois já foi chamado em protect.php
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Calculadora de CO2</title>
    <link rel="stylesheet" href="firstSTL.css">
</head>

<body>
    <nav class="navbar">
        <button id="hamburger" class="hamburger" aria-label="Abrir menu" aria-expanded="false" aria-controls="sidebar">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="logo"></div>
    </nav>

  
    <aside id="sidebar" class="sidebar" role="navigation" aria-hidden="true">
        <nav>
            <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#">Minha conta</a></li>
            <li><a href="#">Minhas Conexões</a></li>
            <li><a href="#">Sobre</a></li>
            <li><a href="#">Contatos</a></li>
            </ul>
        </nav>
    </aside>


    <div id="overlay" class="overlay" aria-hidden="true"></div>
    <div class="box01"></div>
    <div class="carousel">

        <div class="slides">
          <div class="slide s1">
            <img src="foto1.jpg" alt="">
          </div>
    
          <div class="slide">
            <img src="foto2.jpg" alt="">
          </div>
    
          <div class="slide">
            <img src="foto3.jpg" alt="">
          </div>
        </div>

        <div class="arrows">
            <span class="prev">&#10094;</span>
            <span class="next">&#10095;</span>
        </div>

        <div class="navigation">
          <span data-slide="0"></span>
          <span data-slide="1"></span>
          <span data-slide="2"></span>
        </div>

    </div>

    <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['email']); ?>!</h1>
    <p>Você está logado com sucesso!</p>
    <a href="/Calculadora-de-CO2/Tela de Login/index.php?logout=1">Sair</a>

    <script src="carrossel.js"></script>
    <script src="menu.js"></script>
</body>
</html>

