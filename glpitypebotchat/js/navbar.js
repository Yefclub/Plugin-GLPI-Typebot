// Script isolado para adicionar o botão do Typebot à barra de navegação
(function() {
    // Executa apenas quando o DOM estiver completamente carregado
    document.addEventListener('DOMContentLoaded', function() {
        try {
            // Verifica se a função openTypebotChat existe
            // Se não existir, não adiciona o botão na barra de navegação
            if (typeof window.openTypebotChat !== 'function') {
                console.log('Função openTypebotChat não encontrada, botão de chat não será adicionado');
                return;
            }

            // Função para tentar encontrar a barra de navegação
            function findNavbar() {
                return document.querySelector('.navbar-nav') || 
                       document.querySelector('#navbar-menu .nav') ||
                       document.querySelector('.navigation-menu');
            }

            // Verifica se o botão já existe
            if (document.querySelector('#typebot-navbar-button')) {
                return;
            }

            // Tenta encontrar a barra de navegação
            const navbar = findNavbar();
            if (!navbar) {
                console.log('Barra de navegação ainda não disponível, tentando novamente...');
                // Tenta novamente após um pequeno delay
                setTimeout(function() {
                    const retryNavbar = findNavbar();
                    if (!retryNavbar) {
                        console.log('Barra de navegação não encontrada após retry');
                        return;
                    }
                    initializeButton(retryNavbar);
                }, 1000);
                return;
            }

            initializeButton(navbar);
        } catch (e) {
            console.error('Erro ao adicionar botão Typebot à barra de navegação:', e);
        }
    });

    function initializeButton(navbar) {
        // Cria o botão
        const navItem = document.createElement('li');
        navItem.className = 'nav-item';
        
        const button = document.createElement('a');
        button.className = 'btn btn-sm btn-icon btn-outline-secondary mx-1';
        button.id = 'typebot-navbar-button';
        button.title = 'Abrir Chat';
        button.setAttribute('data-bs-toggle', 'tooltip');
        button.setAttribute('data-bs-placement', 'bottom');
        button.innerHTML = '<i class="fas fa-comments"></i>';
        
        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (typeof window.openTypebotChat === 'function') {
                window.openTypebotChat();
            } else {
                console.log('Função openTypebotChat não encontrada');
            }
        });
        
        navItem.appendChild(button);
        
        // Adiciona o botão à barra de navegação
        const helpItem = document.querySelector('.navbar-nav .nav-link[title="Ajuda"]');
        if (helpItem && helpItem.parentNode) {
            navbar.insertBefore(navItem, helpItem.parentNode);
        } else {
            navbar.appendChild(navItem);
        }
        
        // Inicializa o tooltip
        try {
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        } catch (e) {
            console.log('Tooltip não inicializado:', e);
        }
    }
})(); 