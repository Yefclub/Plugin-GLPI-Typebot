document.addEventListener('DOMContentLoaded', function() {
    // Verifica se o botão já existe
    if (document.querySelector('#typebot-navbar-button')) {
        return;
    }

    // Seleciona a barra de navegação
    const navbar = document.querySelector('.navbar-nav');
    if (!navbar) {
        console.error('Barra de navegação não encontrada');
        return;
    }

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
            console.error('Função openTypebotChat não encontrada');
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
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    } catch (e) {
        console.log('Erro ao inicializar tooltip:', e);
    }
}); 