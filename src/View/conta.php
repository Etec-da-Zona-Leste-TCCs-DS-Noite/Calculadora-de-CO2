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
    <link rel="stylesheet" href="firstSTL.css">

    <style>
        /* ===== Reset básico ===== */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
        }

        /* ===== Body / Layout ===== */
        body {
            font-family: "Poppins", Arial, sans-serif;
            background: #fdf8f0;
            color: #222;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            padding: 40px 20px;
        }

        /* ===== Menu botão ===== */
        .menu-btn {
            position: fixed;
            top: 18px;
            left: 18px;
            font-size: 20px;
            background: #28a745;
            color: #fff;
            border: none;
            padding: 10px 12px;
            border-radius: 10px;
            cursor: pointer;
            z-index: 1200;
            box-shadow: 0 6px 18px rgba(40, 167, 69, 0.18);
        }

        /* ===== Sidebar ===== */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: #ffffff;
            position: fixed;
            top: 0;
            left: -280px;
            transition: left 0.28s ease;
            box-shadow: 2px 8px 30px rgba(0, 0, 0, 0.06);
            z-index: 1100;
            padding-top: 70px;
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar .nav-links {
            list-style: none;
            padding: 10px 18px;
        }

        .sidebar .nav-links li {
            margin-bottom: 10px;
        }

        .sidebar .nav-links a {
            display: block;
            padding: 10px 14px;
            color: #1f2937;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .sidebar .nav-links a:hover,
        .sidebar .nav-links a:focus {
            background: rgba(40, 167, 69, 0.08);
            color: #28a745;
        }

        /* ===== Overlay quando sidebar aberta ===== */
        #overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.25);
            z-index: 1050;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
        }

        #overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* ===== Painel de Conta ===== */
        .account-panel {
            max-width: 760px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .account-header {
            text-align: center;
            margin-bottom: 18px;
        }

        .account-header h2 {
            font-size: 28px;
            color: #199a3d;
            margin-bottom: 8px;
        }

        .account-header p {
            color: #4b5563;
            font-size: 14px;
        }

        /* Card */
        .account-card {
            background: #fff;
            padding: 24px;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
            border: 1px solid rgba(20, 20, 20, 0.02);
        }

        /* Profile top */
        .profile-section {
            display: flex;
            gap: 14px;
            align-items: center;
            margin-bottom: 16px;
        }

        .profile-avatar {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: #28a745;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 26px;
            box-shadow: 0 6px 18px rgba(40, 167, 69, 0.12);
        }

        .profile-info h3 {
            margin-bottom: 6px;
            font-size: 18px;
            color: #111827;
        }

        .profile-info p {
            color: #374151;
            font-size: 14px;
            margin-bottom: 3px;
        }

        /* Divider */
        .account-card hr {
            border: none;
            border-top: 1px solid #eee;
            margin: 16px 0;
        }

        /* Form grid */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-grid label {
            display: flex;
            flex-direction: column;
            font-weight: 600;
            color: #111827;
            font-size: 14px;
        }

        .form-grid input {
            margin-top: 8px;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background: #fff;
            outline: none;
            transition: box-shadow .18s ease, border-color .12s ease;
        }

        .form-grid input:focus {
            border-color: #28a745;
            box-shadow: 0 6px 18px rgba(40, 167, 69, 0.08);
        }

        /* Save button */
        .btn-save {
            grid-column: 1 / -1;
            padding: 12px 18px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 6px;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.08);
        }

        .btn-save:hover {
            background: #1f8f34;
        }

        /* Delete area */
        .delete-section {
            margin-top: 20px;
            text-align: center;
            padding-top: 12px;
            border-top: 1px dashed #eee;
        }

        .delete-section h4 {
            margin-bottom: 8px;
            color: #111827;
        }

        .delete-section p {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .btn-delete {
            background: #dc3545;
            color: #fff;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-delete:hover {
            background: #c21f33;
        }

        /* ===== Responsividade ===== */
        @media (max-width: 880px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .account-panel {
                padding: 0 12px;
            }

            .menu-btn {
                top: 12px;
                left: 12px;
            }
        }

        /* Small screens: sidebar full-screen */
        @media (max-width: 560px) {
            .sidebar {
                width: 100%;
                left: -100%;
            }

            .sidebar.open {
                left: 0;
            }
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 12px 20px;
            background: rgb(5, 82, 5);
            color: #fff;
            position: relative;
        }

        .hamburger {
            display: flex;
            flex-direction: column;
            gap: 5px;
            width: 42px;
            height: 42px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 6px;
            margin-right: 12px;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 40;
        }

        .hamburger span {
            display: block;
            width: 26px;
            height: 3px;
            background: #fff;
            border-radius: 2px;
            transition: transform .25s ease, opacity .25s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: translateY(6px) rotate(45deg);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: translateY(-6px) rotate(-45deg);
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 260px;
            background: rgb(9, 148, 9);
            transform: translateX(-110%);
            transition: transform .35s cubic-bezier(.2, .9, .3, 1);
            z-index: 50;
            padding: 60px 20px 20px 20px;
            box-shadow: 4px 0 16px rgba(0, 0, 0, .5);
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .sidebar .nav-links {
            display: flex;
            flex-direction: column;
            gap: 14px;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .sidebar .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 6px;
            display: block;
            border-radius: 6px;
        }

        .sidebar .nav-links a:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s ease;
            z-index: 45;
        }

        .overlay.visible {
            opacity: 1;
            pointer-events: auto;
        }
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
                <li><a href="#3">Minhas Conexões</a></li>
                <li><a href="#4">Sobre</a></li>
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

        const hamburger = document.getElementById("hamburger");
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");

        hamburger.addEventListener("click", () => {
            const isOpen = hamburger.classList.toggle("active");
            sidebar.classList.toggle("open");
            overlay.classList.toggle("visible");
        });

        overlay.addEventListener("click", () => {
            hamburger.classList.remove("active");
            sidebar.classList.remove("open");
            overlay.classList.remove("visible");
        });


    </script>
</body>

</html>