<?php
require_once __DIR__ . '/../Controller/protect.php';
require_once __DIR__ . '/../Controller/Conexao.php';

$mysqli = (new Conexao())->getConnection();

$stmt = $mysqli->prepare("SELECT COALESCE(c.nome, '') AS nome, u.email FROM usuario u LEFT JOIN Conta c ON c.cod_user = u.cod WHERE u.cod = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($nome_atual, $email_atual);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta</title>
    <link rel="stylesheet" href="conta.css">

    <style>
       
    </style>
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
                <li><a href="home.php">Home</a></li>
                <li><a href="conta.php">Minha conta</a></li>
                <li><a href="minha_conect.php">Minhas Conexões</a></li>
                <li><a href="#4">Sobre</a></li>
                <ul class="nav-links">
                <li><a href="../Controller/logout.php" style="color: #ffb3b3;">Sair</a></li>
</ul>

            </ul>
        </nav>
    </aside>

    <div id="overlay" class="overlay" aria-hidden="true"></div>

    <div class="account-panel">
        <div class="account-header">
            <h2>Minha Conta</h2>
            <p>Gerencie suas informações pessoais e configurações</p>
        </div>

        <div class="account-card">
            <div class="profile-section">
                <div class="profile-avatar">👤</div>
                <div class="profile-info">
                    <h3><?php echo htmlspecialchars($nome_atual); ?></h3>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($email_atual); ?></p>
                    <p><strong>ID:</strong> <?php echo htmlspecialchars($_SESSION['id']); ?></p>
                </div>
            </div>
            <hr>

            <form class="form-grid" action="../Model/update_user.php" method="POST">
                <label>Nome
                    <input type="text" name="nome" placeholder="Seu nome"
                        value="<?php echo htmlspecialchars($nome_atual); ?>" required>
                </label>

                <label>Email
                    <input type="email" name="email" placeholder="Seu email"
                        value="<?php echo htmlspecialchars($email_atual); ?>" required>
                </label>

                <label>Senha Atual
                    <input type="password" name="senha_atual" placeholder="Digite sua senha atual" required>
                </label>

                <label>Nova Senha
                    <input type="password" name="nova_senha" placeholder="Nova senha (opcional)">
                </label>

                <button class="btn-save" type="submit">Salvar Alterações</button>
            </form>

            <div class="delete-section">
                <h4>Excluir Conta</h4>
                <p>Esta ação é permanente e não pode ser desfeita.</p>
                <form action="../Model/delete_user.php" method="POST">
                    <button class="btn-delete" type="submit">Deletar Conta</button>
                </form>
            </div>
        </div>
    </div>
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