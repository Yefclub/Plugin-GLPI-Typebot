// Script isolado para o chat Typebot
(function() {
    // Verifica se o script já foi executado para evitar duplicação
    if (window.typebotChatInitialized) {
        return;
    }

    // Marca como inicializado
    window.typebotChatInitialized = true;

    // Executa apenas quando o DOM estiver completamente carregado
    document.addEventListener('DOMContentLoaded', function() {
        // Verifica se já existe uma instância do chat
        if (document.querySelector('.typebot-chat-icon')) {
            return;
        }

        try {
            // URL do plugin - obtém de forma mais segura
            let pluginBaseUrl = (function() {
                const scripts = document.getElementsByTagName('script');
                for (let i = 0; i < scripts.length; i++) {
                    const src = scripts[i].src;
                    if (src.includes('glpitypebotchat/js/glpitypebotchat.js')) {
                        return src.split('js/glpitypebotchat.js')[0];
                    }
                }
                // Fallback para URL relativa
                return window.location.origin + '/plugins/glpitypebotchat/';
            })();

            // Busca as configurações do chat de forma isolada
            fetch(pluginBaseUrl + 'ajax/getconfig.php', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na resposta do servidor: ' + response.status);
                    }
                    return response.json();
                })
                .then(config => {
                    // Verifica se o chat está ativo e se a URL do Typebot está configurada
                    if (!config || !config.is_active || !config.typebot_url) {
                        console.log('Chat desativado ou URL não configurada');
                        return;
                    }

                    // Cria um wrapper isolado para os elementos do chat
                    const typebotWrapper = document.createElement('div');
                    typebotWrapper.id = 'typebot-chat-wrapper';
                    typebotWrapper.style.position = 'fixed';
                    typebotWrapper.style.zIndex = '9999';
                    typebotWrapper.style.pointerEvents = 'none';
                    typebotWrapper.style.width = '0';
                    typebotWrapper.style.height = '0';
                    
                    // Cria o ícone do chat com namespace
                    const chatIcon = document.createElement('div');
                    chatIcon.className = 'typebot-chat-icon ' + config.icon_position;
                    chatIcon.style.pointerEvents = 'auto';
                    chatIcon.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z" fill="white"/>
                        </svg>
                    `;

                    // Cria o modal do chat
                    const modal = document.createElement('div');
                    modal.className = 'typebot-modal';
                    modal.style.pointerEvents = 'auto';
                    modal.innerHTML = `
                        <div class="typebot-modal-content">
                            <div class="typebot-close">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="white">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                </svg>
                            </div>
                            <iframe src="${config.typebot_url}" frameborder="0" title="Typebot Chat"></iframe>
                        </div>
                    `;

                    // Adiciona os elementos ao wrapper
                    typebotWrapper.appendChild(chatIcon);
                    typebotWrapper.appendChild(modal);
                    
                    // Adiciona o wrapper ao final do body
                    document.body.appendChild(typebotWrapper);

                    // Adiciona os eventos de clique
                    chatIcon.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        modal.classList.add('active');
                    });

                    modal.querySelector('.typebot-close').addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        modal.classList.remove('active');
                    });

                    modal.addEventListener('click', (e) => {
                        if (e.target === modal) {
                            e.preventDefault();
                            e.stopPropagation();
                            modal.classList.remove('active');
                        }
                    });

                    // Expõe função global para abrir o chat
                    window.openTypebotChat = function() {
                        modal.classList.add('active');
                    };
                })
                .catch(error => {
                    console.error('Erro ao carregar configurações do Typebot:', error);
                    // Não faz nada em caso de erro, apenas registra no console
                });
        } catch (e) {
            console.error('Erro ao inicializar Typebot chat:', e);
        }
    });
})(); 