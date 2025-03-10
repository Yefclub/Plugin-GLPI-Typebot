document.addEventListener('DOMContentLoaded', function() {
    // Verifica se já existe uma instância do chat
    if (document.querySelector('.typebot-chat-icon')) {
        return;
    }

    // Cria o ícone do chat
    const chatIcon = document.createElement('div');
    chatIcon.className = 'typebot-chat-icon';
    chatIcon.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
            <path d="M0 0h24v24H0z" fill="none"/>
        </svg>
    `;

    // Cria o modal do chat
    const modal = document.createElement('div');
    modal.className = 'typebot-modal';
    modal.innerHTML = `
        <div class="typebot-modal-content">
            <div class="typebot-close">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    <path d="M0 0h24v24H0z" fill="none"/>
                </svg>
            </div>
            <iframe src="" frameborder="0"></iframe>
        </div>
    `;

    // Adiciona os elementos ao DOM
    document.body.appendChild(chatIcon);
    document.body.appendChild(modal);

    // Configura a posição do ícone baseado nas configurações
    fetch('../ajax/getconfig.php')
        .then(response => response.json())
        .then(config => {
            if (config.is_active) {
                chatIcon.classList.add(config.icon_position);
                const iframe = modal.querySelector('iframe');
                iframe.src = config.typebot_url;
            } else {
                chatIcon.style.display = 'none';
            }
        });

    // Adiciona os eventos de clique
    chatIcon.addEventListener('click', () => {
        modal.classList.add('active');
    });

    modal.querySelector('.typebot-close').addEventListener('click', (e) => {
        e.stopPropagation();
        modal.classList.remove('active');
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });
}); 