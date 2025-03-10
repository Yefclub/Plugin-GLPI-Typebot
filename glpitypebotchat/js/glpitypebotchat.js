document.addEventListener('DOMContentLoaded', function() {
    // Verifica se já existe uma instância do chat
    if (document.querySelector('.typebot-chat-icon')) {
        return;
    }

    // URL do plugin
    let pluginBaseUrl = '';
    const scripts = document.getElementsByTagName('script');
    for (let i = 0; i < scripts.length; i++) {
        const src = scripts[i].src;
        if (src.includes('glpitypebotchat/js/glpitypebotchat.js')) {
            pluginBaseUrl = src.split('js/glpitypebotchat.js')[0];
            break;
        }
    }

    if (!pluginBaseUrl) {
        console.error('Não foi possível determinar a URL base do plugin');
        return;
    }

    // Busca as configurações do chat
    fetch(pluginBaseUrl + 'ajax/getconfig.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na resposta do servidor: ' + response.status);
            }
            return response.json();
        })
        .then(config => {
            if (!config.is_active || !config.typebot_url) {
                console.log('Chat desativado ou URL não configurada');
                return;
            }

            console.log('Configurações do chat carregadas com sucesso');

            // Cria o ícone do chat
            const chatIcon = document.createElement('div');
            chatIcon.className = 'typebot-chat-icon ' + config.icon_position;
            chatIcon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z" fill="white"/>
                </svg>
            `;

            // Cria o modal do chat
            const modal = document.createElement('div');
            modal.className = 'typebot-modal';
            modal.innerHTML = `
                <div class="typebot-modal-content">
                    <div class="typebot-close">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="white">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </div>
                    <iframe src="${config.typebot_url}" frameborder="0"></iframe>
                </div>
            `;

            // Adiciona os elementos ao DOM
            document.body.appendChild(chatIcon);
            document.body.appendChild(modal);

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

            // Expõe função global para abrir o chat
            window.openTypebotChat = function() {
                modal.classList.add('active');
            };

            console.log('Chat Typebot inicializado com sucesso');
        })
        .catch(error => {
            console.error('Erro ao carregar configurações do Typebot:', error);
        });
}); 