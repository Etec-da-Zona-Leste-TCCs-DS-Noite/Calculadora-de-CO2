class AuthApp {
    constructor() {
        this.cadastroScreen = document.getElementById('cadastro-screen');
        this.loginScreen = document.getElementById('login-screen');
        this.dashboardScreen = document.getElementById('dashboard-screen');
        this.cadastroForm = document.getElementById('cadastro-form');
        this.loginForm = document.getElementById('login-form');
        this.btnLogout = document.getElementById('btn-logout');
        this.userEmailDisplay = document.getElementById('user-email-display');
        
        // Corrigir caminho absoluto
        this.API = '/Calculadora-de-CO2/src/Controller/LoginController.php';

        this.initListeners(); 
    }

    switchScreen(screenToShow) {
        [this.cadastroScreen, this.loginScreen, this.dashboardScreen].forEach(screen => {
            screen.classList.remove('active-screen');
            screen.classList.add('hidden-screen');
        });
        screenToShow.classList.remove('hidden-screen');
        screenToShow.classList.add('active-screen');
    }

    async handleCadastro(e) { 
        e.preventDefault();
        const email = document.getElementById('cadastro-email').value;
        const password = document.getElementById('cadastro-senha').value;
        
        console.log('Iniciando cadastro...');
        
        try {
            const response = await fetch(this.API, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                credentials: 'include',
                body: JSON.stringify({ email, password, action: 'register' }),
            });

            console.log('Response status:', response.status);
            
            const result = await response.json();
            console.log('Resultado:', result);

            if (result.success) {
                console.log('Cadastro bem-sucedido, redirecionando...');
                alert('Cadastro realizado!');
                
                // Redirecionar
                console.log('URL de redirecionamento:', '/Calculadora-de-CO2/src/View/home.php');
                window.location.href = '/Calculadora-de-CO2/src/View/home.php';
                
            } else {
                console.log('Erro no cadastro:', result.message);
                alert(`Erro: ${result.message}`);
            }

        } catch (error) {
            console.error('Erro na requisição:', error);
            alert(`Erro ao cadastrar: ${error.message}`);
        }
    }

    async handleLogin(e) { 
        e.preventDefault();
        const email = document.getElementById('login-email').value;
        const password = document.getElementById('login-senha').value;

        try {
            // Usa o fetch para enviar dados para o controlador PHP
            const response = await fetch(this.API, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                credentials: 'include', // necessário para sessão funcionar
                body: JSON.stringify({ email, password, action: 'login' }), // Envia a ação para o PHP
            });

            const result = await response.json();

            if (result.success) {
                alert(result.message);
                // Redireciona para a home.php usando window.location
                window.location.href = '/Calculadora-de-CO2/src/View/home.php'; 
            } else {
                throw new Error(result.message);
            }

        } catch (error) {
            console.error('Erro no login:', error);
            alert(`Erro ao fazer login: ${error.message}`);
        }
    }
    
    // O logout agora também usa fetch para limpar a sessão PHP
    async handleLogout() {
        try {
            const response = await fetch(this.API, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },

                credentials: 'include', // necessário para encerrar a sessão no servidor
                body: JSON.stringify({ action: 'logout' }),
            });
            
            const result = await response.json();

            if (result.success) {
                // Redireciona de volta para a página de login/index
                window.location.href = 'index.php'; // Ajuste o caminho conforme necessário
            } else {
                throw new Error(result.message);
            }

        } catch (error) {
            console.error('Erro no logout:', error);
            alert('Erro ao sair.');
        }
    }

    initListeners() {
        this.cadastroForm.addEventListener('submit', this.handleCadastro.bind(this));
        this.loginForm.addEventListener('submit', this.handleLogin.bind(this));
        this.btnLogout.addEventListener('click', this.handleLogout.bind(this));

        document.getElementById('link-ir-login').addEventListener('click', (e) => {
            e.preventDefault();
            this.switchScreen(this.loginScreen);
        });
        document.getElementById('link-ir-cadastro').addEventListener('click', (e) => {
            e.preventDefault();
            this.switchScreen(this.cadastroScreen);
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new AuthApp();
});
