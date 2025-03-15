// Script isolado para adicionar o botão do Typebot à barra de navegação
(function() {
    // Verifica se o script já foi executado para evitar duplicação
    if (window.typebotNavbarInitialized) {
        return;
    }

    // Marca como inicializado
    window.typebotNavbarInitialized = true;

    // Executa apenas quando o DOM estiver completamente carregado
    document.addEventListener('DOMContentLoaded', function() {
        try {
            // Verifica se a função openTypebotChat existe
            // Se não existir, não adiciona o botão na barra de navegação
            if (typeof window.openTypebotChat !== 'function') {
                console.log('Função openTypebotChat não encontrada, botão de chat não será adicionado');
                return;
            }

            // Função para encontrar a barra de navegação de forma segura
            function findNavbar() {
                // Busca apenas os seletores específicos para minimizar o impacto
                const elements = [
                    document.querySelector('#navbar-menu .navbar-nav'),
                    document.querySelector('.navbar-nav'),
                    document.querySelector('#c_menu .primary-nav')
                ];
                
                // Retorna o primeiro elemento encontrado
                return elements.find(el => el !== null);
            }

            // Verifica se o botão já existe para evitar duplicação
            if (document.querySelector('#typebot-navbar-button')) {
                console.log('Botão do Typebot já existe no DOM');
                return;
            }

            // Tenta encontrar a barra de navegação
            const navbar = findNavbar();
            if (!navbar) {
                console.log('Barra de navegação não encontrada');
                return; // Não faz mais tentativas para evitar impactos
            }

            // Adiciona o botão apenas uma vez
            addButton(navbar);
        } catch (e) {
            console.error('Erro ao adicionar botão Typebot à barra de navegação:', e);
        }
    });

    function addButton(navbar) {
        // Verifica o tema do GLPI para aplicar os estilos apropriados
        const isDarkTheme = document.body.classList.contains('dark-mode');
        const buttonClass = isDarkTheme ? 
            'btn btn-sm btn-outline-secondary mx-1' : 
            'btn btn-sm btn-outline-secondary mx-1';

        // Cria o botão como um link
        const button = document.createElement('a');
        button.href = '#';
        button.className = buttonClass;
        button.id = 'typebot-navbar-button';
        button.title = 'Abrir Chat';
        button.setAttribute('data-bs-toggle', 'tooltip');
        button.setAttribute('data-bs-placement', 'bottom');
        button.innerHTML = '<i class="fas fa-comments"></i>';
        
        // Adiciona o evento de clique de forma segura
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (typeof window.openTypebotChat === 'function') {
                window.openTypebotChat();
            }
        });
        
        // Adiciona o botão ao navbar como último item
        navbar.appendChild(button);
        
        console.log('Botão do Typebot adicionado com sucesso');
    }
})(); 