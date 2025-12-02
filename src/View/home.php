<?php
// Usar caminho absoluto relativo a este arquivo
require_once __DIR__ . '/../Controller/protect.php';
// NÃO chame session_start() aqui pois já foi chamado em protect.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="firstSTL.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet" />
    <script></script>
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
                <li><a href="home.php" style="font-family:'Anton', sans-serif; font-weight: lighter;">Home</a></li>
                <li><a href="conta.php" style="font-family:'Anton', sans-serif; font-weight: lighter;">Minha conta</a></li>
                <li><a href="minha_conect.php" style="font-family:'Anton', sans-serif; font-weight: lighter;">Minhas Conexões</a></li>
                <li><a href="#4" style="font-family:'Anton', sans-serif; font-weight: lighter;">Sobre</a></li>
                <li><a href="../Controller/logout.php" style="color: #ffb3b3;font-family:'Anton', sans-serif; font-weight: lighter;">Sair</a></li>

            </ul>
        </nav>
    </aside>

    <div id="overlay" class="overlay" aria-hidden="true"></div>

    <div class="carousel">

        <div class="slides">
          <div class="slide s1">
            <img src="foto1.webp" style="width: 1500px; height: 350px;">
          </div>
    
          <div class="slide">
            <img src="foto2.avif" alt="">
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

    <div class="box01">
      <p id="4" style="font-family:'Anton', sans-serif; font-size: 5em">SOBRE NÓS</p>

      <p style="font-family:'Anton', sans-serif; margin: 35px; text-align: left; font-size: 1.5em;">A Calculadora de CO₂ nasceu com o objetivo de tornar o monitoramento <br>
        ambiental mais simples, preciso e acessível para empresas que buscam <br>
        reduzir seu impacto ecológico. Em um cenário onde a sustentabilidade deixou <br>
         de ser apenas uma opção e se tornou uma necessidade, desenvolvemos uma 
         solução <br> capaz de transformar dados ambientais em informações claras, úteis e estratégicas.
     </p>

         <img src="foto4.avif" alt="" style="margin-left: 1000px;margin-top: -270px; border-radius: 40px;">

         <p style="font-family:'Anton', sans-serif; margin: 35px; text-align: right; font-size: 1.5em;">Nosso sistema integra hardware dedicado como o ESP32 e o sensor SGP30 com uma plataforma web <br>
            moderna que oferece visualização em tempo real dos índices de CO₂ e outros compostos presentes  <br>
            no ambiente. Acreditamos que decisões inteligentes começam com dados confiáveis. Por isso, cada <br>
             parte do nosso projeto foi pensada para garantir precisão, estabilidade e facilidade de uso.
        </p>

        <img src="foto5.avif" style="border-radius: 40px; width: 560px; margin-left: 70px; margin-top: -300px;">

        <p style="font-family:'Anton', sans-serif; margin: 35px; text-align: center; font-size: 1.5em;">Nossa visão: Acreditamos que a tecnologia é uma das ferramentas mais poderosas para promover mudanças 
        positivas. Ao trazer informações ambientais em tempo real, ajudamos organizações a entender melhor seus processos internos e tomar decisões que diminuem o impacto ambiental sem comprometer a produtividade.
        Sonhamos com ambientes industriais mais limpos, eficientes e inteligentes. Para isso, criamos uma solução que se adapta às necessidades de diferentes setores, auxiliando desde pequenas empresas até grandes
        indústrias no caminho para uma gestão mais sustentável.
        </p>

        <p style="font-family:'Anton', sans-serif; margin: 35px; text-align: center; font-size: 1.5em;">Nossa missão: Nossa missão é democratizar o acesso ao monitoramento ambiental, oferecendo uma ferramenta confiável,
         acessível e de fácil implantação. Queremos que qualquer empresa possa acompanhar suas emissões, identificar oportunidades de melhoria e contribuir ativamente para um futuro mais sustentável.
        Buscamos constantemente aprimorar nossa plataforma, ampliando recursos, aprimorando a precisão das medições e expandindo a compatibilidade com diferentes sensores e dispositivos.
        </p>

        <p style="font-family:'Anton', sans-serif; margin: 35px; text-align: center; font-size: 1.5em;">Nossos Valores: Nossos valores representam a base que sustenta cada etapa do desenvolvimento da Calculadora de CO₂. Acreditamos que a transparência, a ética e a responsabilidade ambiental devem estar presentes em todas as decisões. 
        Valorizamos a inovação constante, buscando sempre soluções tecnológicas que tragam precisão, eficiência e confiabilidade para nossos usuários. Comprometemo-nos a entregar produtos que realmente façam diferença no
        cotidiano das empresas, promovendo melhoria contínua e contribuindo para ambientes mais saudáveis. Trabalhamos com foco na simplicidade sem abrir mão da qualidade, garantindo que nossos sistemas sejam acessíveis, 
        intuitivos e eficazes. Além disso, priorizamos a colaboração, pois entendemos que os melhores resultados surgem quando tecnologia, sustentabilidade e pessoas caminham juntas em direção ao mesmo propósito.</p>
    
        <img src="foto6.avif" style="border-radius: 40px; margin-left: 32%;">

        <p style="font-family:'Anton', sans-serif; margin: 35px; text-align: center; font-size: 1.5em;">
        Nosso compromisso com a Inovação e responsabilidade ambiental caminham juntas 
        em nosso projeto. Trabalhamos para unir engenharia, tecnologia da informação 
        <br>e práticas sustentáveis para entregar um produto que realmente faça diferença 
        no dia a dia. Estamos em constante evolução. Pesquisamos novas tecnologias, 
        <br>testamos novos sensores e buscamos sempre formas de tornar o sistema mais 
        completo, eficiente e intuitivo. Nosso compromisso é continuar desenvolvendo 
        <br>soluções que facilitem o monitoramento e incentivem práticas ambientalmente 
        corretas.
        </p>

        <img src="foto7.jpeg" style="border-radius: 40px; width: 600px; margin-left: 33%;">

    </div>

    

    <footer>
      <p style="font-family:'Anton', sans-serif; font-size: 3em; text-align: center; margin-top: -15px;">Fale com a gente !</p>
      <img src="icons8-nova-mensagem-64.png" style="margin-top: -23px; margin-left: 44%;">
      <p style="font-family:'Anton', sans-serif; font-size: 1.95em; margin-top: 10px; margin-left: 44%;"> emails:</p>
      <div class="emails" style="bottom: -40px; margin-left: 25px; justify-content: center; font-size: 1.3em;">
      <p>matheus.santos1944@etec.sp.gov.br</p>
      <p>pedro.santos1248@etec.sp.gov.br</p>
      <p>ryan.guedes@etec.sp.gov.br</p>
    </div>
    </footer>

    <script src="carrossel.js"></script>

    <script>
      // IDs EXISTENTES NO HTML
      const menuBtn  = document.getElementById("hamburger");
      const sidebar = document.getElementById("sidebar");
      const overlay = document.getElementById("overlay");

      // Proteção contra erro
      if (!menuBtn) console.error("ERRO: #menu-btn não encontrado.");
      if (!sidebar) console.error("ERRO: #sidebar não encontrado.");
      if (!overlay) console.error("ERRO: #overlay não encontrado.");

      function toggleMenu() {
          sidebar.classList.toggle("open");
          overlay.classList.toggle("show");

          const isOpen = sidebar.classList.contains("open");
          menuBtn.setAttribute("aria-expanded", isOpen);
          sidebar.setAttribute("aria-hidden", !isOpen);
      }

      // EVENTOS
      menuBtn.addEventListener("click", toggleMenu);
      overlay.addEventListener("click", toggleMenu);

      // ESC fecha
      document.addEventListener("keydown", (e) => {
          if (e.key === "Escape" && sidebar.classList.contains("open")) {
              toggleMenu();
          }
      }); // <-- FECHAMENTO CORRETO DO EVENTO

    </script>
</body>
</html>
