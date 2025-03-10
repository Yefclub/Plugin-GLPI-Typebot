document.addEventListener('DOMContentLoaded', function() {
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