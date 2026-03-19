<?php
require_once __DIR__ . '/../Controller/protect.php';
?> 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós</title>
    <link rel="stylesheet" href="firstSTL.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet" />
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar">
    <button id="hamburger" class="hamburger">
        <span></span>
        <span></span>
        <span></span>
    </button>
</nav>

<!-- SIDEBAR -->
<aside id="sidebar" class="sidebar">
    <ul class="nav-links">
        <li><a href="home.php">Home</a></li>
        <li><a href="conta.php">Minha conta</a></li>
        <li><a href="minha_conect.php">Minhas Conexões</a></li>
        <li><a href="#sobre">Sobre</a></li>
        <li><a href="../Controller/logout.php" style="color:#ffb3b3;">Sair</a></li>
    </ul>
</aside>

<div id="overlay" class="overlay"></div>

<!-- CARROSSEL -->
<div class="carousel">
    <div class="slides">
        <div class="slide">
            <img src="foto1.webp">
        </div>
        <div class="slide">
            <img src="foto2.avif">
        </div>
        <div class="slide">
            <img src="foto3.jpg">
        </div>
    </div>

    <div class="arrows">
        <span class="prev">&#10094;</span>
        <span class="next">&#10095;</span>
    </div>
</div>

<!-- CONTEÚDO -->
<div class="box01" id="sobre">

    <h1 style="text-align:center; font-size:3em;">SOBRE NÓS</h1>

    <!-- BLOCO 1 -->
    <div class="section">
        <p>
            A Sky-Guard nasceu com o objetivo de tornar o monitoramento
            sobre gases poluentes mais simples, preciso e acessível para empresas que buscam
            reduzir seu impacto ecológico.
        </p>
        <img src="foto4.avif">
    </div>

    <!-- BLOCO 2 -->
    <div class="section reverse">
        <p>
            Nosso sistema integra hardware como ESP32 e sensor SGP30 com uma plataforma web
            moderna que oferece visualização em tempo real dos índices ambientais.
        </p>
        <img src="foto5.avif">
    </div>

    <!-- TEXTO CENTRAL -->
    <p class="text-center">
        Nossa visão: Acreditamos que a tecnologia é uma das ferramentas mais poderosas
        para promover mudanças positivas e tornar ambientes mais sustentáveis.
    </p>

    <p class="text-center">
        Nossa missão: Democratizar o acesso ao monitoramento ambiental,
        oferecendo uma ferramenta confiável e acessível.
    </p>

    <p class="text-center">
        Nossos valores: transparência, inovação e responsabilidade ambiental
        em todas as decisões.
    </p>

    <!-- IMAGEM CENTRAL -->
    <div style="text-align:center;">
        <img src="foto6.avif" style="width:60%; border-radius:20px;">
    </div>

    <p class="text-center">
        Nosso compromisso é evoluir constantemente, buscando novas tecnologias
        e soluções para tornar o sistema mais eficiente e intuitivo.
    </p>

    <div style="text-align:center;">
        <img src="foto7.jpeg" style="width:60%; border-radius:20px;">
    </div>

</div>

<!-- FOOTER -->
<footer>
    <h2>Fale com a gente!</h2>

    <div class="emails">
        <p>matheus.santos1944@etec.sp.gov.br</p>
        <p>pedro.santos1248@etec.sp.gov.br</p>
        <p>ryan.guedes@etec.sp.gov.br</p>
    </div>
</footer>

<!-- SCRIPT MENU -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const menuBtn  = document.getElementById("hamburger");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    function toggleMenu() {
        sidebar.classList.toggle("open");
        overlay.classList.toggle("show");
    }

    menuBtn.addEventListener("click", toggleMenu);
    overlay.addEventListener("click", toggleMenu);
});
</script>

</body>
</html>
